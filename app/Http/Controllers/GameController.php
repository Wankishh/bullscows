<?php

namespace App\Http\Controllers;

use App\Http\Requests\GameRequest;
use App\Http\Resources\GamePlayResource;
use App\Http\Services\GameCodeService;
use App\Http\Services\GameService;

class GameController extends Controller
{
    private $gameCodeService;
    private $gameService;

    public function __construct()
    {
        $this->gameCodeService = new GameCodeService();
        $this->gameService = new GameService();
    }

    public function newGame()
    {
        session()->forget(['tries', 'key']);
        $this->createNewGame();
        $responseData = new GamePlayResource(0, $this->getCodedSession(), []);
        return $this->response($responseData);
    }

    public function playGame(GameRequest $request)
    {
        $input = (string)$request->get('input');
        $tries = session()->get('tries', []);
        if(!session()->has('key')) {
            $this->createNewGame();
        }
        $newTry = $this->gameService->game($input, session()->get('key'));
        if ($newTry->guessed) {
            // Game over, number is guessed
            $key = session()->get('key');
            session()->forget(['key', 'tries']);

            return $this->response(new GamePlayResource(1, $key, []));
        }
        array_unshift($tries, $newTry);
        session(['tries' => $tries]);

        return $this->response(new GamePlayResource(0, $this->getCodedSession(), $tries));
    }

    public function activeSessionGame()
    {
        if(!session()->has('key')) {
            $this->createNewGame();
        }

        return $this->response(new GamePlayResource(0, $this->getCodedSession(), session('tries', [])));
    }

    private function createNewGame()
    {
        session(['key' => $this->generateNewSessionKey()]);
    }

    private function generateNewSessionKey(): string
    {
        return $this->gameCodeService->generateCustomKey(config('app.max_allowed_numbers'));
    }

    private function getCodedSession(): string
    {
        return $this->gameCodeService->getCodedKey(session()->get('key'));
    }
}
