<?php


namespace App\Repositories\IRepositories;


use Illuminate\Database\Eloquent\Model;

interface IBaseRepository
{
    /**
     * @return Model
     */
    public function makeModel();

    /**
     * @param  mixed $conditions
     * @param  mixed $columns
     * @return void
     */
    public function all($with = [], $conditions = [], $columns = array('*'));

    /**
     * @param $model
     * @return mixed
     */
    public function create($model);

    /**
     * @param $key
     * @param $value
     * @param $data
     * @return mixed
     */
    public function updateOrCreate($key, $value, $data);
    /**
     * @param array $data
     * @param $id
     * @param string $attribute
     * @return mixed
     */
    public function update(array $data, $id, $attribute = "id");
    public function delete($id);

    /**
     * @param $id
     * @param array $columns
     * @return mixed
     */
    public function find($id, $columns = array('*'));

    /**
     * @param $attribute
     * @param $value
     * @param array $columns
     * @return mixed
     */
    public function findBy($attribute, $value, $columns = array('*'));

    /**
     * @param mixed $model
     * @param mixed $array
     * @param mixed $relation
     *
     * @return void
     * @auth yasser kanj
     */
    public function syncWith($model, $array = [], $relation);

    function model();

    function navigate($id, $case, $key = null, $value = null);

    public function orderNumperNext($key = null, $value = null);

    public function deleteWithRelation($id, $relation);

    public function codeGenerator();

    public function names();

    public function latestId();

    public function deleteRecords($tableName, $ids, $relationsToNeglect = []);

    public function childValue($key = null, $value = null, $property = null);

}
