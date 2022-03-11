<?php

namespace App\Http\Controllers;

use App\Models\Tournament;
use Illuminate\Http\Request;
use App\UseCases\TournamentUseCase;

class TournamentController extends Controller
{
    public function get(int $id) 
    {
        $result = TournamentUseCase::getTournament($id);
        if ($result) {
            return response($result, 200);
        } else {
            return response(["Tournament not found"], 404);
        }
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate(["name" => "required"]);
        $result = TournamentUseCase::createTournament($request->name);
        if ($result) {
            return response(["id" => $result], 201);
        } else {
            return response(["Name already exists"], 400);
        }
    }
}
