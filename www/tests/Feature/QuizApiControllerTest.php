<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\User;
use Illuminate\Foundation\Testing\DatabaseMigrations;

class QuizApiControllerTest extends TestCase
{

    private string $SEARCH_URL = '/api/quiz/search?term=Alakada';
    private string $SCORE_QUIZ_URL = '/api/quiz/score';

    use DatabaseMigrations {
        runDatabaseMigrations as baseRunDatabaseMigrations;
    }

    /**
     * Define hooks to migrate the database before and after each test.
     *
     * @return void
     */
    public function runDatabaseMigrations()
    {
        $this->baseRunDatabaseMigrations();
        $this->artisan('db:seed');
    }

    public function testLogin_withoutBearerToken_Assert401()
    {
        $response = $this->json('GET', $this->SEARCH_URL, array());

        $response->assertStatus(401);
        $response->assertJson(['message' => 'Unauthenticated.']);
    }

    public function testScoreQuiz_withValidInput_Assert200()
    {
        $user = factory(User::class)->create();
        $this->actingAs($user, 'api');

        $jsonData = '{
                        "submissions": [
                            {
                                "movieId": "tt0120903",
                                "rating": 7
                            },
                            {
                                "movieId": "tt0290334",
                                "rating": 7
                            }

                        ],
                        "term_id": 1
                    }';
        $payload = json_decode($jsonData, TRUE);

        $this->json('POST', $this->SCORE_QUIZ_URL, $payload, ['Accept' => 'application/json'])
            ->assertStatus(200)
            ->assertJson([
                "score"=> 2,
                "total"=> 2,
                "percentage"=> 100,
                "percentageScore"=> "100% of correct guesses ",
                "messageScore"=> "2 out of 2 guessed correctly "
            ]);

    }

    /**
     * Not suitable for prod because test may fail if another movie with name is added.gi
     *
     */
    public function testQuizSearch_withValidInput_Assert200()
    {
        $user = factory(User::class)->create();
        $this->actingAs($user, 'api');

        $searchResults = [
            0 => [
                "Title"=> "Fate of Alakada",
                "Year"=> "2020",
                "imdbID"=> "tt11829884",
                "Type"=> "movie",
                "Poster"=> "https://m.media-amazon.com/images/M/MV5BODEwNzY3YWYtMjA1Zi00MzgwLWI0M2UtYTkxMmMyZWU2ZDU3XkEyXkFqcGdeQXVyMTAxNDc4OTgy._V1_SX300.jpg"
            ],
            1 => [
                "Title"=> "Alakada Reloaded",
                "Year"=> "2017",
                "imdbID"=> "tt13275228",
                "Type"=> "movie",
                "Poster"=> "N/A"
            ]
        ];

        $this->json('GET', $this->SEARCH_URL, ['Accept' => 'application/json'])
            ->assertStatus(200)
            ->assertJson([
                "results" => $searchResults,
                "username" => $user->name
            ]);
    }

}
