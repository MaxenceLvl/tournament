<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class ParticipantTest extends TestCase
{
    protected $tournamentId;

    public function setUp(): void
    {
        parent::setUp();
        $response =  $this->postJson( '/api/tournaments', [
            "name" => "First tournament"
        ]);
        $this->tournamentId = $response->json()["id"];

        $response2 = $this->postJson("/api/tournaments/$this->tournamentId/participants", [
            "name" => "Djoko",
            "elo"  => 2500
        ]);

    }

    public function testCreateParticipantShouldBeOk() 
    {
        $this->postJson("/api/tournaments/$this->tournamentId/participants", [
            'name' => 'Nadal', 
            'elo'  => 2500])
            ->assertStatus(201);
    }

    public function testCreateParticipantShouldNotSameName() 
    {
        $this->postJson("/api/tournaments/$this->tournamentId/participants", [
            "name" => "Djoko",
            "elo"  => 2500])
            ->assertStatus(400);
    }

    public function testCreateParticipantWithoutName() {
        $this->postJson("/api/tournaments/$this->tournamentId/participants", [
            'name' => '', 
            'elo'  => 2500])
            ->assertStatus(422);
    }

    public function testCreateParticipantWithoutElo() {
        $this->postJson("/api/tournaments/$this->tournamentId/participants", [
            'name' => 'Djoko', 
            'elo'  => null])
            ->assertStatus(422);
    }

    public function testRetrieveAllParticipant() {
        $this->getJson("/api/tournaments/$this->tournamentId/participants")
        ->assertStatus(200)
        ->assertExactJson(([
            "id" => 1,
            "name" => "Djoko",
            "elo" => 2500,
            "tournamentId" => 1
        ]));
    }
}
