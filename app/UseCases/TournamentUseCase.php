<?php

namespace App\UseCases;

use App\Models\Tournament;

class TournamentUseCase 
{
    public static function createTournament(string $name): int|false
    {
        if (TournamentUseCase::getTournamentByName($name) == null) {
            return Tournament::insertGetId(["name" => $name]);
        } else {
            return false;
        }
    }

    public static function getTournament(int $id): ?Tournament
    {
        return Tournament::find($id);
    }

    public static function getTournamentByName(string $name): ?Tournament 
    {
        return Tournament::firstWhere(["name" => $name]);
    }
}