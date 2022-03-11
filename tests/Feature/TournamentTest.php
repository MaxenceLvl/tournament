<?php

namespace Tests\Feature;

use App\Models\Tournament;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class TournamentTest extends TestCase
{

    protected $tournamentId;

    public function setUp(): void
    {
        parent::setUp();
        $response =  $this->postJson('/api/tournaments', [
            "name" => "First tournament"
        ]);
        $this->tournamentId = $response->json()["id"];
    }

    public function testCreateTournamentShouldBeOk()
    {
        $this->postJson('/api/tournaments', ['name' => 'Tournament'])
            ->assertStatus(201);
    }

    public function testCreateTournamentWithoutName()
    {
        $this->postJson('/api/tournaments', ["name" => ""])
            ->assertStatus(422);
    }

    public function testTournamentShouldHaveUniqueName()
    {
        $this->postJson('/api/tournaments', ['name' => 'Tournament']);
        $this->postJson('/api/tournaments', ['name' => 'Tournament'])
            ->assertStatus(400);
    }

    public function testTournamentCreationShouldEnableToRetrieveTournamentsAfter()
    {
        $this->postJson("/api/tournaments/$this->tournamentId/participants", [
                "name"  => "Novak Djokovic",
                "elo"   => 2500
        ])->assertStatus(201);


        $this->getJson("/api/tournaments/$this->tournamentId")
            ->assertStatus(200)
            ->assertExactJson(([
                "id" => $this->tournamentId,
                "name" => "First tournament"
            ]));


            //         // $response = json_decode(json_decode($this->client->getResponse()->getContent()));
            //   $participantId = $response->id;

            //         // $this->assertResponseIsSuccessful();
            //   $this->assertEquals("Tournament", $response->name);

            //         // $this->assertArrayHasKey(0, $response->participants);
            // $this->assertJsonEquals([
            //     "id"    => $response->id,
            //     "name"  => "Tournament",
            //     "participants"   => [
            //         json_encode([
            //             "id"    => $participantId,
            //             "name"  => "Novak Djokovic",
            //             "elo"   => 2500
            //         ])
            //     ]
            // ]);
        ;
    }
}
