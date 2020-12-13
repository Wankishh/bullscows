<?php

namespace App\Http\Services;

use App\Http\Data\TryGame;

class GameService
{
    public function game(string $input, string $key): TryGame
    {
        $response = new TryGame($input);
        $len = strlen($input);
        for ($i = 0; $i < $len; $i++) {
            $currentKey = $input[$i];
            $existsInSession = strpos($key, $currentKey, $i);
            if ($existsInSession !== false) {
                $samePos = $existsInSession === $i;
                if ($samePos) {
                    $response->bulls++;
                } else {
                    $response->cows++;
                }
            }
        }

        $response->guessed = $response->bulls === strlen($key);
        return $response;
    }
}
