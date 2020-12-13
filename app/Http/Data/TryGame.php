<?php

namespace App\Http\Data;

class TryGame
{
    public $guessed;
    public $bulls;
    public $cows;
    public $input;

    public function __construct(string $input, $bulls = 0, $cows = 0)
    {
        $this->input = $input;
        $this->bulls = $bulls;
        $this->cows = $cows;
        $this->guessed = false;
    }
}
