<?php

namespace App\Http\Controllers;

use App\Models\PortfolioType;
use \Symfony\Component\HttpFoundation\Response;

class PortfolioController extends Controller
{
    // Gibt alle Portfoliotypen zurück
    public function getAlltypes(): Response
    {
        return response(PortfolioType::all());
    }
}
