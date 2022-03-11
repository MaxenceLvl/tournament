<?php

use App\Http\Controllers\ParticipantController;
use App\Http\Controllers\TournamentController;
use App\Models\Tournament;
use App\Models\Tournaments;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

// Tournament
Route::get('/tournaments', [TournamentController::class, 'index']);
Route::post('/tournaments', [TournamentController::class, 'store']);
Route::get('/tournaments/{id}', [TournamentController::class, 'get']);

// Participant
Route::post('/tournaments/{tournamentId}/participants', [ParticipantController::class, 'store']);
Route::get('/tournament/{tournamentId}/participants', [ParticipantController::class, 'getByTournament']);
Route::delete('/tournaments/{tournamentId}/participants/{participantId}', [ParticipantController::class, 'deleteParticipantOfTournament']);
