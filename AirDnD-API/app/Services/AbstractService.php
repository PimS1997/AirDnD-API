<?php
/**
 * Created by PhpStorm.
 * User: Pim Schwippert
 * Date: 11/17/2017
 * Time: 8:37 PM
 */

namespace App\Services;

use App\Repositories\AbstractRepository;
use Illuminate\Database\Eloquent\Model;
abstract class AbstractService
{
    /**
     * @var $repo
     */
    private $repo;
    /**
     * AbstractService constructor.
     * @param AbstractRepository $repo
     */
    public function __construct(AbstractRepository $repo)
    {
        $this->repo = $repo;
    }
    /**
     * @return mixed
     */
    public function index()
    {
        return $this->repo->index();
    }
    /**
     * @param $fractal
     * @param $transformer
     * @param $modelname
     * @param $apiversion
     * @param $count
     * @return mixed
     */
    public function indexWithPaginate($fractal, $transformer, $modelname, $apiversion, $count)
    {
        return $this->repo->indexWithPaginate($fractal, $transformer, $modelname, $apiversion, $count);
    }
    /**
     * @param $pk
     * @return Model
     */
    public function get($pk)
    {
        return $this->repo->get($pk);
    }
    /**
     * @param $data
     * @return Model
     */
    public function store($data)
    {
        return $this->repo->store($data);
    }
    /**
     * @param $request
     * @param $pk
     * @return \Exception|\Illuminate\Database\Eloquent\ModelNotFoundException
     */
    public function update($request, $pk)
    {
        return $this->repo->update($request, $pk);
    }
    /**
     * @param $pk
     * @return \Illuminate\Http\JsonResponse|\Illuminate\Http\Response|\Laravel\Lumen\Http\ResponseFactory
     */
    public function destroy($pk)
    {
        return $this->repo->destroy($pk);
    }

    public function getRepo()
    {
        return $this->repo;
    }
}