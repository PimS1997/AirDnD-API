<?php
/**
 * Created by PhpStorm.
 * User: Pim Schwippert
 * Date: 11/17/2017
 * Time: 8:34 PM
 */

namespace App\Repositories;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Container\Container as App;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use App\Repositories\RepositoryInterfaces\AbstractRepositoryInterface;

abstract class AbstractRepository implements AbstractRepositoryInterface
{
    /**
     * @var $app
     * @var $model
     */
    private $model;
    private $queries;
    public function __construct()
    {
        $this->makeModel();
    }
    /**
     * Specify Model class name
     *
     * @return mixed
     */
    abstract public function model();

    public function index()
    {
        return $this->model->get();
    }
    public function indexWithPaginate($fractal, $transformer, $modelname, $apiversion, $count)
    {
        $paginator = $this->model->paginate($count);
        $models = $paginator->getCollection();
        $resource = $fractal->collection($models, $transformer, $modelname, $apiversion, $paginator);
        return $resource;
    }
    /**
     * @param $pk
     * @return Model
     */
    public function get($pk)
    {
        return $this->model->findOrFail($pk);
    }
    /**
     * @param $data
     * @return Model
     */
    public function store($data)
    {
        $model = $this->model->getModel()->create($data);
        return $model;
    }
    /**
     * Store the given data, or return the first entry available.
     *
     * @param array $searchItems
     * @param array $data
     * @return mixed
     */
    public function firstOrStore(array $searchItems, array $data)
    {
        return $this->getModel()->firstOrCreate($searchItems, $data);
    }
    /**
     * Bulk store multiple rows of a certain type
     *
     * @param  array $items
     * @param  boolean $ignore
     * @return boolean
     */
    public function bulkStore(array $items, $ignore = false)
    {
        if ($ignore) {
            return $this->bulkStoreIgnore($items);
        }
        return $this->getModel()->insert($items);
    }
    /**
     * Bulk store multiple rows of a certain type, but now ignore all errors when inserting.
     *
     * @param array $items
     */
    private function bulkStoreIgnore(array $items)
    {
        $table = $this->getModel()->getTable();
        $attributes = implode('`, `', array_keys($items[0]));
        $values = '';
        foreach ($items as $item) {
            $values .= '(';
            for ($i = 0; $i < count($item); $i++) {
                if ($i == 0) {
                    $values .= '?';
                } else {
                    $values .= ', ?';
                }
            }
            $values .= '),';
        }
        $values = rtrim($values, ',');
        return DB::insert(
            DB::raw("INSERT IGNORE INTO `{$table}` (`{$attributes}`) VALUES {$values}"),
            collect($items)->flatten()->toArray()
        );
    }
    /**
     * Update the resource via the given model
     *
     * @param  array|\Illuminate\Http\Request              $data
     * @param  integer|\Illuminate\Database\Eloquent\Model $model
     * @return boolean|\Illuminate\Database\Eloquent\Model
     */
    public function update($data, $model)
    {
        try {
            if (!$model instanceof Model) {
                $model = $this->getModel()->findOrFail($model);
            }
            if ($data instanceof Request) {
                $data = $data->request->all();
            }
            $model->fill($data);
            $model->save();
            return $model;
        } catch (ModelNotFoundException $exception) {
            return false;
        }
    }
    /**
     * @param $pk
     * @return mixed
     */
    public function destroy($pk)
    {
        try {
            $newmodel = $this->getModel()->findOrFail($pk);
            $newmodel->delete();
            return ($this->model() . ' is succesfully deleted');
        } catch (ModelNotFoundException $exception) {
            return false;
        }
    }
    /**
     * Returns Model by custom field.
     *
     * @param  $customField
     * @param  $value
     * @param  string      $operator
     * @return Model
     */
    public function getOneByCustomField($customField, $value, $operator = '=')
    {
        return $this->getModel()->where($customField, $operator, $value)->first();
    }
    /**
     * Returns Models by custom field.
     *
     * @param  $customField
     * @param  $value
     * @param  string      $operator
     * @return Collection
     */
    public function getAllByCustomField($customField, $value, $operator = '=')
    {
        return $this->getModel()->where($customField, $operator, $value)->get();
    }
    public function getCollection($array, $column = 'pk')
    {
        return $this->getModel()->whereIn($column, $array)->get();
    }
    /**
     * Create a builder for a select statement.
     *
     * @param array $select
     * @return mixed
     */
    private function selectBuilder(array $select)
    {
        return $this->getModel()->select($select);
    }
    /**
     * Get multiple rows with only the given attributes.
     *
     * @param array $select
     * @return \Illuminate\Support\Collection
     */
    public function select(array $select)
    {
        return $this->selectBuilder($select)->get();
    }
    /**
     * Get one row with the given identifier with only the given attributes.
     *
     * @param mixed $identifier
     * @param array $select
     * @return \Illuminate\Support\Collection
     */
    public function selectItem($identifier, array $select)
    {
        return $this->selectBuilder($select)->where($this->getModel()->getKeyName(), '=', $identifier)->first();
    }
    /**
     * Make a new model from the app container
     *
     * @return \Illuminate\Database\Eloquent\Builder
     * @throws ModelNotFoundException
     */
    public function makeModel()
    {
        $model = app('app')->make($this->model());
        if (!$model instanceof Model) {
            throw new ModelNotFoundException("Could not find model {$model}");
        }
        return $this->model = $model->newQuery();
    }
    /**
     * Get the model from \Illuminate\Database\Eloquent\Builder
     *
     * @return \Illuminate\Database\Eloquent\Model
     */
    public function getModel()
    {
        return $this->model->getModel();
    }
    public function enableQueryLog()
    {
        app('db')->connection()->enableQueryLog();
    }
    public function getQueries()
    {
        return $this->queries = app('db')->getQueryLog();
    }
}