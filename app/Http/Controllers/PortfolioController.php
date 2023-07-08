<?php

namespace App\Http\Controllers;

use App\Http\Resources\PortfolioResource;
use App\Models\Portfolio;
use App\Models\PortfolioType;
use App\ResponseHelper\ErrorResponse;
use App\ResponseHelper\SuccessfulResponse;
use \Symfony\Component\HttpFoundation\Response;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;

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
            return ErrorResponse::respondErrorMsg(['description' => 'Es existiert bereits ein Portfolio mit dieser Bezeichnung.']);
        }

        return SuccessfulResponse::respondSuccess(status: 201);
    }

    // Gibt alle Portfolios des aktuellen Users zurück
    public function getAll(): AnonymousResourceCollection
    {
        $portfolios = Portfolio::with(['portfolioType'])->whereBelongsTo(Auth::user());
        $portfolios = $portfolios->get();

        return PortfolioResource::collection($portfolios);
    }

    // Gibt alle Portfoliotypen zurück
    public function getAlltypes(): Response
    {
        return response(PortfolioType::all());
    }
}
