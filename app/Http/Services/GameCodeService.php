<?php

namespace App\Http\Services;

use App\Rules\GameCodeCustomRule;

class GameCodeService
{
    private $gameCodeRule;
    public function __construct()
    {
        $this->gameCodeRule = new GameCodeCustomRule();
    }

    public function generateCustomKey($allowedChars)
    {
        $valid = false;
        $key = "";
        while (!$valid) {
            $num = "";
            for ($i = 0; $i < $allowedChars; $i++) {
                $num .= random_int(0, 9);
            }

            if($this->gameCodeRule->passes('none', $num)) {
                $valid = true;
                $key = $num;
            }
        }

        return $key;
    }

    public function getCodedKey(string $key)
    {
        $resp = "";
        $len = strlen($key);
        for ($i = 0; $i < $len; $i++) {
            $resp .= "? ";
        }

        return $resp;
    }
}
