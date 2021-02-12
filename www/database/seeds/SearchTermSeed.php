<?php

use Illuminate\Database\Seeder;
use App\Term;

class SearchTermSeed extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('terms')->insert([
            'term' => 'X-men'
        ]);
    }
}
