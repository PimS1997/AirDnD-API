<?php
/**
 * Created by PhpStorm.
 * User: Pim Schwippert
 * Date: 11/17/2017
 * Time: 6:24 PM
 */

namespace App\Http\Controllers\v1;


use App\Services\GameService;
use Illuminate\Http\Request;

class GameController extends Controller
{
    public function __construct(GameService $gameService)
    {
        $this->gameService = $gameService;
    }

    public function createGame(Request $request)
    {
        $this->validate($request,[
            'title' => 'required|min:3',
            'description' => 'required|min:8',
            'ruleset' => 'required',
        ], [
            'min' => 'The :attribute must at least be :min characters long.',
        ]);

        $game = $this->gameService->createGame(
            $request->get('title'),
            $request->get('description'),
            $request->get('ruleset')
        );

        if(!$game)
        {
            return response()->json(['status' => 'FAIL', 'message' => "Something went wrong or game already exists in DB"], 201);
        }

        return response()->json(['status' => 'OK', 'message' => "Game {$game->title} has successfully been created"], 201);


    }
}