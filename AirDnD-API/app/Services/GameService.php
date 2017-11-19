<?php
/**
 * Created by PhpStorm.
 * User: Pim Schwippert
 * Date: 11/17/2017
 * Time: 7:28 PM
 */

namespace App\Services;

use App\Repositories\GameRepository;

class GameService extends AbstractService
{
    public function __construct(GameRepository $repo)
    {
        parent::__construct($repo);
    }

    public function createGame($title, $description, $ruleset)
    {
        $game = $this->getRepo()->createGame($title, $description, $ruleset);
        return $game;
    }



}