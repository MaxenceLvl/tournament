<?php

namespace App\UseCases;

use App\Models\Participant;
use App\Models\Tournament;

class ParticipantUseCase
{
    public static function createParticipant(string $name, int $elo, int $tournamentId): int|false
    {
        if (ParticipantUseCase::getParticipantByName($name) == null) {
            return Participant::insertGetId([
                "name"          => $name,
                "elo"           => $elo,
                "tournamentId"  => $tournamentId
            ]);
        } else {
            return false;
        }
    }

    public static function getParticipant(int $id): ?Participant
    {
        return Participant::find($id);
    }

    public static function getParticipantByName(string $name): ?Participant
    {
        return Participant::firstWhere(["name" => $name]);
    }

    public static function getParticipantsByTournament(int $tournamentId)
    {
        if (TournamentUseCase::getTournament($tournamentId) == null) {
            return null;
        }
        return Participant::where(["tournamentId" => $tournamentId]);
    }

    public static function deleteParticipant(int $tournamentId, int $participantId): bool
    {
        if (TournamentUseCase::getTournament($tournamentId) == null) {
            return null;
        }
        $participant = Participant::getParticipant($participantId);
        return $participant->delete();
    }
}
