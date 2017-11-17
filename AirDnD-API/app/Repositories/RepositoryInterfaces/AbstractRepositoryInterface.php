<?php
/**
 * Created by PhpStorm.
 * User: Pim Schwippert
 * Date: 11/17/2017
 * Time: 8:35 PM
 */

namespace App\Repositories\RepositoryInterfaces;

interface AbstractRepositoryInterface
{
    /**
     * Get all entries from the database.
     *
     * @return \Illuminate\Database\Eloquent\Collection
     */
    public function index();
    /**
     * Get a resource from the database by given pk.
     *
     * @param  integer                              $pk
     * @return \Illuminate\Database\Eloquent\Model
     */
    public function get($pk);

    /**
     * Store a resource using the given data.
     *
     * @param $data
     * @return \Illuminate\Database\Eloquent\Model
     * @internal param array|\Illuminate\Http\Request $request
     */
    public function store($data);
    /**
     * Bulk store multiple rows of a certain type.
     *
     * @param  array    $items
     * @return boolean
     */
    public function bulkStore(array $items);
    /**
     * Update the resource with the given pk.
     *
     * @param  array|\Illuminate\Http\Request               $request
     * @param  integer|\Illuminate\Database\Eloquent\Model  $pk
     * @return \Illuminate\Database\Eloquent\Model
     */
    public function update($data, $pk);
    /**
     * Remove a resource with the given pk.
     *
     * @param  integer|\Illuminate\Database\Eloquent\Model  $pk
     * @return boolean
     */
    public function destroy($pk);
}