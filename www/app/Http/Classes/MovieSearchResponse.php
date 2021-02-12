<?php

namespace App\Http\Classes;

use App\Term;

/**
 * Class MovieSearchResponse
 * @package App\Http\Classes
 */
class MovieSearchResponse {

    private array $movies;
    private Term $term;

    /**
     * MovieSearchResponse constructor.
     * @param array $movies
     * @param Term $term
     */
    public function __construct(array $movies, Term $term) {
        $this->movies = $movies;
        $this->term = $term;
    }

    /**
     * @return array
     */
    public function toArray(): array {
        return [
            'results' => $this->movies,
            'username' => auth()->user()->name,
            'term_id' => $this->term->id
        ];
    }
}
