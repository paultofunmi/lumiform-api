<?php

namespace Tests\Unit;

use App\Http\Classes\Movie;
use PHPUnit\Framework\TestCase;

class MovieTest extends TestCase
{

    public function testScoreQuiz_AssertEqualZero() {
        $movie = new Movie(9, 7);
        $this->assertEquals(0, $movie->score());
    }

    public function testScoreQuiz_AssertEqualOne() {
        $movie = new Movie(9, 8);
        $this->assertEquals(1, $movie->score());
    }

}
