<?php


namespace App\Services;

use App\Exceptions\APIException;
use App\Http\Classes\Movie;
use App\Http\Classes\MovieScoreResponse;
use App\Term;
use App\Result;
use Illuminate\Database\QueryException;
use Illuminate\Support\Facades\DB;


/**
 * Class QuizService
 * @package App\Services
 */
class QuizService
{
    private ExternalGatewayService  $externalGatewayService;
    private string $baseUrl;
    private string $apikey;


    public function __construct() {
        $this->externalGatewayService = new ExternalGatewayService();
        $this->baseUrl = env("OMDB_BASEURL");
        $this->apikey = env('OMDB_APIKEY');
    }

    public function searchMovies(string $term): array {
        $url = $this->__buildSearchMoviesUrl($term);

        $response = $this->externalGatewayService->makeGETRequest($url);
        $responseBody = json_decode($response->getBody());
        if($responseBody->Response === 'True'){
            $selectedMovies = array_slice($responseBody->Search, 0, 5);
            $moviesWithPlotInfo = array();
            foreach($selectedMovies as $movie){
                $fetchedMovie = $this->__fetchMovie($movie->imdbID);
                $movie->plot = $fetchedMovie->Plot;
                array_push($moviesWithPlotInfo, $movie);
            }
            return $moviesWithPlotInfo;
        }else {
            return array();
        }
    }

    public function scoreQuiz(array $submissions): MovieScoreResponse{
        $score = 0;
        $total = count($submissions);

        foreach($submissions as $submission){
            $apiMovieResponse = $this->__fetchMovie($submission->movieId);

            $movie = new Movie( (float) $apiMovieResponse->imdbRating, (float)$submission->rating);
            $score += $movie->score();
        }

        return new MovieScoreResponse($score, $total);
    }

    public function saveSearchTerm(string $searchTerm): Term{
        $term  = new Term;
        $term->term = $searchTerm;
        $term->save();

        return $term;
    }

    public function saveResult(int $score, int $term_id): void{

        $result = new Result;
        $result->score = $score;
        $result->term()->associate($term_id);
        $result->user()->associate(auth()->user());

        try {
            $result->save();
        }catch(QueryException $exception) {
            // Silence exception because user has played quiz before.
            // throw new APIException("Error saving your record");
        }
    }

    public function fetchResults() {

        return DB::table('results')
               ->join('users', 'users.id', '=', 'results.user_id')
               ->join('terms', 'terms.id', '=', 'results.term_id')
               ->select('users.name', 'terms.term', 'results.score', 'results.created_at')
               ->groupBy('results.user_id', 'results.term_id')
               ->orderBy('results.score', 'DESC')
               ->get();
    }

    private function __fetchMovie(string $movieId){

        $url = $this->__buildFetchMovieUrl($movieId);

        $response = $this->externalGatewayService->makeGETRequest($url);
        return json_decode($response->getBody());
    }

    private function __buildSearchMoviesUrl(string $term): string {
        $this->__validateEnv();
        return $this->baseUrl . "?apikey=" . $this->apikey . "&s=" . $term;
    }

    private function __buildFetchMovieUrl(string $movieId): string {
        $this->__validateEnv();
        return $this->baseUrl . "?apikey=" . $this->apikey . "&i=" . $movieId;
    }

    private function __validateEnv(): void {
        if($this->apikey !== '' && $this->baseUrl !== ''){}
        else {
            throw new APIException("Invalid Input: base url and omdb api key must be set in env file");
        }
    }
}
