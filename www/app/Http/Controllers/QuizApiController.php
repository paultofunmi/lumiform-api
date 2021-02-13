<?php

namespace App\Http\Controllers;

use App\Exceptions\APIException;
use App\Http\Classes\MovieSearchResponse;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use App\Services\QuizService;

/**
 * Class QuizApiController
 * @package App\Http\Controllers
 *
 */


class QuizApiController extends Controller
{
    private QuizService $quizService;

    public function __construct() {
        $this->quizService = new QuizService();
    }

    public function searchMoviesByTerm(Request $request): JsonResponse{
        if ( $request->has('term') ) {
            $searchResults = $this->quizService->searchMovies(request()->input('term'));

            $term = $this->quizService->saveSearchTerm(request()->input('term'));
            $searchMoviesResponse = new MovieSearchResponse($searchResults, $term);

            return response()->json($searchMoviesResponse->toArray());
        }else {
            throw new APIException("Invalid Input: search term must be set");
        }
    }

    public function scoreQuiz(Request $request): JsonResponse
    {
        $payload = json_decode($request->getContent());

        $movieScoreResponse = $this->quizService->scoreQuiz($payload->submissions);
        $this->quizService->saveResult($movieScoreResponse->getPercentage(), $payload->term_id);

        return response()->json($movieScoreResponse->toArray());
    }

    public function quizResults() {
        $quizRequests = $this->quizService->fetchResults();

        return response()->json($quizRequests->toArray());
    }
}
