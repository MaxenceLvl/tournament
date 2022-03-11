<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Particpant;
use App\UseCases\TournamentUseCase;
use App\UseCases\ParticipantUseCase;

class ParticipantController extends Controller
{
    /**
     * Retrieve the participant with his id.
     *
     * @param  int id
     * @return \Illuminate\Http\Response
     */
    public function get(int $id)
    {
        $result = ParticipantUseCase::getParticipant($id);
        if ($result) {
            return response($result, 200);
        } else {
            return response(["Participant not found"], 404);
        }
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(int $tournamentId, Request $request)
    {
        $request->validate([
            "name"          => "required",
            "elo"           => "required",
        ]);
        if (TournamentUseCase::getTournament($tournamentId) == null) {
            return response("Tournament doesn't exists", 404);
        }
        $result = ParticipantUseCase::createParticipant($request->name, $request->elo, $tournamentId);
        if ($result) {
            return response(["id" => $result], 201);
        } else {
            return response(["Name already exists"], 400);
        }
    }

    /**
     * Retrieve all participants asssociated with to the tournament id.
     *
     * @param  int tournamentId
     * @return \Illuminate\Http\Response
     */
    public function getByTournament(int $tournamentId) 
    {
        $result = ParticipantUseCase::getParticipantsByTournament($tournamentId);
        if ($result == null) {
            return response("Tournament doesn't exists", 404);
        }
        return response($result);
    }

    /**
     * Delete particiant of the given tournament id.
     *
     * @param  int tournamentId
     * @param  int participantId
     * @return \Illuminate\Http\Response
     */
    public function deleteParticipantOfTournament(int $tournamentId, int $participantId) 
    {
        $result = ParticipantUseCase::deleteParticipant($tournamentId, $participantId);
        if ($result == null) {
            return response("Tournament doesn't exists", 404);
        } else if (!$result) {
            return response("Error while deleting", 500);
        } else {
            return response("Participant deleted", 204);
        }
    }
}
