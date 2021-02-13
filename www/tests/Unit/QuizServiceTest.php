<?php

namespace Tests\Feature;

use App\Services\QuizService;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use Mockery;

class QuizServiceTest extends TestCase
{
    public function testBasicTest()
    {
        $this->assertTrue(true);
    }

//    public function searchMovies_whenAPIKEYIsNull_Assert400()
//    {
//        $mockQuizService = Mockery::mock(QuizService::class);
//
//        $mockedJSONResponse = '{
//                                "message": "Invalid Input: base url and omdb api key must be set in env file",
//                                "timestamp": "2021-02-05 08:07:48"
//                            }';
//        $mockedResponse = json_encode($mockedJSONResponse, TRUE);
//        $mockQuizService->shouldReceive('searchterm')->once()->andReturn();
//    }
}
