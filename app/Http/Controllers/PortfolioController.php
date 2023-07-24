<?php

namespace App\Http\Controllers;

use App\Models\Portfolio;
use App\Models\PortfolioEntry;
use App\Models\PortfolioEntryValue;
use App\Models\PortfolioType;
use App\ResponseHelper\ErrorResponse;
use App\ResponseHelper\SuccessfulResponse;
use \Symfony\Component\HttpFoundation\Response;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;


class PortfolioController extends Controller
{
    // Speichert neues Portfolio für aktuellen Nutzer
    public function add(Request $request): Response
    {
        $request->validate([
            'description' => [
                'required'
            ], 'typeCode' => [
                'required'
            ]
        ]);

        $description = $request->input('description');
        $type_code = $request->input('typeCode');

        // Type-Id abrufen. Wenn nicht existiert, Fehler zurückgeben
        $typeId = PortfolioType::firstWhere('code', $type_code)->id;

        if (!$typeId) {
            return ErrorResponse::respondErrorMsg(['typeCode' => 'Der Portfoliotype ' . $type_code . ' existiert nicht!']);
        }

        // Portfolio anlegen
        $portfolio = Portfolio::firstOrCreate(['description' => $description, 'type_id' =>  $typeId, 'user_id' => Auth::user()->id]);

        if (!$portfolio->wasRecentlyCreated) {
            return ErrorResponse::respondErrorMsg(['description' => 'Es existiert bereits ein Portfolio mit dieser Bezeichnung zu diesem Typen.']);
        }

        return SuccessfulResponse::respondSuccess(status: 201);
    }

    // Gibt alle Portfolios des aktuellen Users zurück
    public function getAll(): Response
    {
        $portfolios = Portfolio::with(['portfolioType'])->whereBelongsTo(Auth::user());
        $portfolios = $portfolios->get();

        return response($portfolios);
    }

    // Gibt alle Portfoliotypen zurück
    public function getAlltypes(): Response
    {
        return response(PortfolioType::all());
    }

    // Gibt Portfolio des aktuellen Nutzers anhand von ID zurück
    public function getOneById(string $id): Response
    {
        $portfolio = Portfolio::whereBelongsTo(Auth::user())
            ->with(['portfolioType'])
            ->find($id);

        if (!$portfolio) {
            return ErrorResponse::respondErrorMsg('Das gesuchte Portfolio konnte nicht gefunden werden.');
        }

        return SuccessfulResponse::respondSuccess($portfolio);
    }

    // Speichert neuen Portfolioeintrag für aktuellen Nutzer
    public function addEntry(Request $request): Response
    {
        $request->validate([
            'description' => [
                'required', 'string'
            ], 'value' => [
                'required', 'numeric'
            ], 'datetime' => [
                'required', 'date'
            ],
            'portfolioId' => [
                'required', 'numeric'
            ]

        ]);

        $description = $request->input('description');
        $portfolioId = $request->input('portfolioId');
        $timestamp = $request->input('datetime');
        $value = $request->input('value');

        // Portfolio-Id des Users existiert?
        $portfolioExists = Portfolio::find($portfolioId)->whereBelongsTo(Auth::user())->exists();

        if (!$portfolioExists) {
            return ErrorResponse::respondErrorMsg('Das angegebene Portfolio kann dem User nicht zugeordnet werden.');
        }

        // Portfolioeintrag anlegen wenn noch nicht existiert
        $portfolioEntry = PortfolioEntry::firstOrCreate(['description' => $description, 'portfolio_id' => $portfolioId]);

        if (!$portfolioEntry->wasRecentlyCreated) {
            return ErrorResponse::respondErrorMsg(['description' => 'Es existiert bereits ein Eintrag mit dieser Bezeichnung.']);
        }

        // Anfangsvalue anlegen
        PortfolioEntryValue::create(['portfolio_entries_id' => $portfolioEntry->id, 'time' => $timestamp, 'value' => $value]);

        return SuccessfulResponse::respondSuccess(status: 201);
    }
}
