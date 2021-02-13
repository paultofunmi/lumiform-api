<?php

namespace Tests\Unit;

use App\Http\Classes\Movie;
use PHPUnit\Framework\TestCase;

/**
 * Class MovieTest
 * @package Tests\Unit
 *
 * Test Movie Scoring Feature
 * Accepts ImdbRating and User Rating. It returns 1 if user rating is betwen +- of imdbRating else it returns 0
 */
class MovieTest extends TestCase
{

    public function testScoreQuiz_AssertEqualZero() {
        $movie = new Movie(9, 7);
        $this->assertEquals(0, $movie->score());
    }

    public function testScoreQuiz_withLowerEdgeCase_AssertEqualOne() {
        $movie = new Movie(9.5, 8.5);
        $this->assertEquals(1, $movie->score());
    }

    public function testScoreQuiz_withLowerEdgeCase_AssertEqualZero() {
        $movie = new Movie(9.5, 8.4);
        $this->assertEquals(0, $movie->score());
    }

    public function testScoreQuiz_AssertEqualOne() {
        $movie = new Movie(9, 8);
        $this->assertEquals(1, $movie->score());
    }

    public function testScoreQuiz_withUpperEdgeCase_AssertEqualOne() {
        $movie = new Movie(9.5, 10.5);
        $this->assertEquals(1, $movie->score());
    }

    public function testScoreQuiz_withUpperEdgeCase_AssertEqualZero() {
        $movie = new Movie(9.5, 10.6);
        $this->assertEquals(0, $movie->score());
    }

}
