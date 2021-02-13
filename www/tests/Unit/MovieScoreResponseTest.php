<?php

namespace Tests\Unit;

use App\Http\Classes\MovieScoreResponse;
use PHPUnit\Framework\TestCase;

/**
 * Class MovieScoreResponseTest
 * @package Tests\Unit
 *
 * Tests Percentage computation task
 * Tests if response object contains keys
 */
class MovieScoreResponseTest extends TestCase
{

    public function testPercentage_AssertIntegerResult() {
        $movieScoreResponse = new MovieScoreResponse(2, 5);

        $this->assertNotNull($movieScoreResponse->getPercentage());
        $this->assertEquals(40, $movieScoreResponse->getPercentage());
    }

    public function testPercentage_AssertFloatEqual() {
        $movieScoreResponse = new MovieScoreResponse(1, 3);

        $this->assertNotNull($movieScoreResponse->getPercentage());
        $this->assertEquals(33.33, $movieScoreResponse->getPercentage());
    }

    public function testPercentage_AssertKeyExists() {
        $movieScoreResponse = new MovieScoreResponse(1, 3);
        $result = $movieScoreResponse->toArray();

        $this->assertNotTrue(in_array('score', $result));
        $this->assertNotTrue(in_array('total', $result));
        $this->assertNotTrue(in_array('percentage', $result));
        $this->assertNotTrue(in_array('percentageScore', $result));
        $this->assertNotTrue(in_array('messageScore', $result));
    }
}
