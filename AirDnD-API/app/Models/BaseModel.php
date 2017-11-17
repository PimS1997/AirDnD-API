<?php
/**
 * Created by PhpStorm.
 * User: Pim Schwippert
 * Date: 11/17/2017
 * Time: 11:46 PM
 */


namespace App\Models;
use App\HasManyMultipleKeys;
use Illuminate\Database\Eloquent\Model;

class BaseModel extends Model
{
    /**
     * Custom relations
     *
     * @var array
     */
    protected $customRelation = [];
    /**
     * The primary key for the models.
     *
     * @var string
     */
    protected $primaryKey = 'pk';
    /**
     * Map data base attributes to model attributes
     *
     * @param $data
     * @return array
     */
    public function dataToModel($data)
    {
        $keys = array();
        $tableNameLength = strlen($this->getTable()) + 1;
        foreach ($data as $key => $value) {
            if (strpos($key, $this->getTable()) === 0) {
                $str = substr($key, $tableNameLength);
                $str = strtok($str, '[');
                $keys[$str] = $value;
                if ($this->getAttribute($str) === null) {
                    if ($value != null) {
                        $this->fill($keys);
                    }
                    unset($data[$key]);
                } else {
                    break;
                }
            }
        }
        return $data;
    }
    /**
     * Checks if model has attributes
     *
     * @return bool
     */
    public function isEmpty()
    {
        foreach ($this->fillable as $attr) {
            if ($this->$attr != null) {
                return false;
            }
        }
        return true;
    }
    /**
     * @param $customRelation
     * @param $model
     */
    public function setCustomRelation($customRelation, $model)
    {
        $this->customRelation[$customRelation] = $model;
    }
    /**
     * @param $customRelation
     * @return mixed
     */
    public function getCustomRelation($customRelation)
    {
        return $this->customRelation[$customRelation];
    }
    /**
     * Define a one-to-many relationship with multipe local keys.
     *
     * @param  string $related
     * @param null $foreignKey
     * @param null $localKeys
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function hasManyMultipleKeys($related, $foreignKey = null, $localKeys = null)
    {
        $foreignKey = $foreignKey ?: $this->getForeignKey();
        $instance = new $related;
        return new HasManyMultipleKeys($instance->newQuery(), $this, $instance->getTable() . '.' . $foreignKey, $localKeys);
    }
}