<?php


namespace App\Http\Classes;


class MovieScoreResponse
{
    private int $score;
    private int $total;
    private float $percentage;

    public function __construct(int $score, int $total) {
        $this->score = $score;
        $this->total = $total;
        $this->computePercentage();
    }

    private function computePercentage(): void{
        $divisionResult = (float) $this->score / $this->total;
        $this->percentage = round($divisionResult * 100,2);
    }

    public function createMessageScore(): string{
        return $this->score . " out of " . $this->total . " guessed correctly ";
    }

    public function createPercentageScore(): string{
        return $this->percentage . "% of correct guesses ";
    }

    /**
     * @return float
     */
    public function getPercentage(): float
    {
        return $this->percentage;
    }

    public function toArray(): array {
        return [
            'score' => $this->score,
            'total' => $this->total,
            'percentage' => $this->percentage,
            'percentageScore' => $this->createPercentageScore(),
            'messageScore' => $this->createMessageScore()
        ];
    }
}
