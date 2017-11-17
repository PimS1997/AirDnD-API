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