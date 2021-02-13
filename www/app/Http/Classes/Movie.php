<?php

namespace App\Http\Classes;

/**
 * Class Movie
 * @package App\Http\Classes
 */
class Movie {

    private float $imdbRating;
    private float $userRating;

    public function __construct(float $imdbRating, float $userRating) {
        $this->imdbRating = $imdbRating;
        $this->userRating = $userRating;
    }

    public function score(): int {
        $lowerRange = $this->imdbRating - 1.0;
        $upperRange = $this->imdbRating + 1.0;

        if( $this->userRating >= $lowerRange && $this->userRating <= $upperRange){
            return 1;
        }else {
            return 0;
        }
    }
}
