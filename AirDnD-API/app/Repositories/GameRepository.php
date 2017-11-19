<?php
/**
 * Created by PhpStorm.
 * User: Pim Schwippert
 * Date: 11/17/2017
 * Time: 7:29 PM
 */

namespace App\Repositories;

class GameRepository extends AbstractRepository
{


    public function createGame($title, $description, $ruleset)
    {
        $game = $this->getModel();
        $game->fill([
            'title' => $title,
            'description' => $description,
            'ruleset' => $ruleset
            ]);
        $game->save();
        return $game;
    }

    /**
     * Specify Model class name
     *
     * @return mixed
     */
    public function model()
    {
        return 'App\Models\GameModel';
    }
}