<?php


namespace App\Repositories\Eloquent;

use App\Helpers\Constants;
use Illuminate\Container\Container as App;
use App\Repositories\IRepositories\IBaseRepository;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

abstract class BaseRepository implements IBaseRepository
{

    /**
     * @var App
     */
    private $app;

    /**
     * @var
     */
    protected $model;

    /**
     * BaseRepository constructor.
     * @param App $app
     * @throws \Illuminate\Contracts\Container\BindingResolutionException
     */
    public function __construct(App $app)
    {
        $this->app = $app;
        $this->makeModel();
    }

    /**
     * @param array $columns
     * @param array $conditions
     * @return mixed
     * @throws \Exception
     */
    public function all($with = [], $conditions = [], $columns = array('*'))
    {
        $order_by = request(Constants::ORDER_BY) ?? "id";
        $order_by_direction = request(Constants::ORDER_By_DIRECTION) ?? "asc";
        $filter_operator = request(Constants::FILTER_OPERATOR) ?? "=";
        $filters = request(Constants::FILTERS) ?? [];
        $per_page = request(Constants::PER_PAGE) ?? 15;
        $paginate = request(Constants::PAGINATE) ?? false;
        $query = $this->model;
        $all_conditions = array_merge($conditions, $filters);
        $query = $query->filter($all_conditions, $filter_operator);
        if (isset($order_by) && !empty($with))
            $query = $query->with($with)->orderBy($order_by, $order_by_direction);
        if ($paginate && !empty($with))
            return $query->with($with)->paginate($per_page, $columns);
        if (isset($order_by))
            $query = $query->orderBy($order_by, $order_by_direction);
        if ($paginate)
            return $query->paginate($per_page, $columns);
        if (!empty($with))
            return $query->with($with)->get($columns);
        else
            return $query->get($columns);
    }

    /**
     * @param array $data
     * @return mixed
     */
    public function create($data)
    {
        //        $userData = array();
        //        foreach ($this->model->getFillable() as $var) {
        //            if (isset($data[Mapper::snakeToCamel($var)])){
        //                $this->model->{$var} = $data[Mapper::snakeToCamel($var)];
        //                $userData[$var] = $data[Mapper::snakeToCamel($var)];
        //            }
        //        }

        return $this->model->create($data);
    }

    /**
     * @param array $data
     * @param $id
     * @param string $attribute
     * @return mixed
     */
    public function update(array $data, $id, $attribute = "id")
    {
        //        $snake_data = array();
        //        foreach ($this->model->getFillable() as $var) {
        //            if (isset($data[Mapper::snakeToCamel($var)]))
        //                $snake_data[$var] = $data[Mapper::snakeToCamel($var)];
        //        }
        return $this->model->where($attribute, '=', $id)->update($data);
    }

    /**
     * @param $key
     * @param $value
     * @param $data
     * @return mixed
     */
    public function updateOrCreate($key, $value, $data)
    {
        $object = $this->findBy($key, $value);

        if (!$object)
            return $this->create($data);
        else
            return $this->update($data, $value, $key);
    }

    /**
     * @param $id
     * @return mixed
     */
    public function delete($id)
    {
        return $this->model->destroy($id);
    }

    /**
     * @param $id
     * @param array $columns
     * @return mixed
     */
    public function find($id, $columns = array('*'))
    {
        return $this->model->find($id, $columns);
    }

    /**
     * @param $attribute
     * @param $value
     * @param array $columns
     * @return mixed
     */
    public function findBy($attribute, $value, $columns = array('*'))
    {
        //        $attribute = Mapper::camelToSnake($attribute);
        return $this->model->where($attribute, '=', $value)->first($columns);
    }

    /**
     * @param mixed $model
     * @param mixed $array
     * @param mixed $relation
     *
     * @return void
     * @auth yasser kanj
     */
    public function syncWith($model, $array = [], $relation)
    {
        $model->{$relation}()->sync($array);
    }

    /**
     * Specify Model class name
     *
     * @return mixed
     */
    abstract function model();

    /**
     * @return Model
     * @throws \Illuminate\Contracts\Container\BindingResolutionException
     */
    public function makeModel(): Model
    {
        $model = $this->app->make($this->model());
        return $this->model = $model;
    }

    /**
     * Display the specified resource.
     *
     * @param model id , case of navigation , optional search key and value
     * @return object
     * @auth A.Soliman
     */
    function navigate($id, $case, $key = null, $value = null)
    {
        switch ($case) {
            case ('previous'):
                if ($id == 0) {
                    $model = $this->model->orderby('id', 'desc')->firstOrFail();
                } else {
                    $model = $this->model->where('id', '<', $id)->when(isset($value), function ($query) use ($key, $value) {
                        return $query->where($key, $value);
                    })->orderby('id', 'desc')->firstOrFail();
                    break;
                }
                $model = $this->model->where('id', '<', $id)->when(isset($value), function ($query) use ($key, $value) {
                    return $query->where($key, $value);
                })->orderby('id', 'desc')->firstOrFail();
                break;

            case ('next'):
                $model = $this->model->where('id', '>', $id)->when(isset($value), function ($query) use ($key, $value) {
                    return $query->where($key, $value);
                })->orderby('id', 'asc')->firstOrFail();
                break;
            case ('first'):
                $model = $this->model->when(isset($value), function ($query) use ($key, $value) {
                    return $query->where($key, $value);
                })->firstOrFail();
                break;
            case ('last'):
                $model = $this->model->when(isset($value), function ($query) use ($key, $value) {
                    return $query->where($key, $value);
                })->orderBy('id', 'desc')->first();
                break;
        }
        return $model;
    }


    /**
     * @param $id
     * @return mixed
     */
    public function deleteWithRelation($id, $relation)
    {
        if ($this->model->{$relation}() == 0) {
            return $this->model->destroy($id);
        }
    }

    public function codeGenerator($key = null, $value = null)
    {
        $code = $this->model->when(isset($value), function ($query) use ($key, $value) {
            return $query->where($key, $value);
        })->orderBy('id', 'desc')->pluck('code')->first();
        $nextCode = getAutoGeneratedNextCode($code);
        $newCode = $this->model->when(isset($value), function ($query) use ($key, $value) {
            return $query->where($key, $value);
        })->where('code', $nextCode)->pluck('code')->first();
        while ($newCode != null) {
            $nextCode = getAutoGeneratedNextCode($newCode);
            $newCode = $this->model->when(isset($value), function ($query) use ($key, $value) {
                return $query->where($key, $value);
            })->where('code', $nextCode)->pluck('code')->first();
        }
        return $nextCode;
    }

    public function names()
    {
        return  $this->model->select(['id', 'name', 'is_active'])->orderByRaw("FIELD(is_active,1) DESC")->get();
    }

    public function latestId()
    {
        return  $this->model->latest('created_at')->pluck('id')->firstOrFail();
    }

    public function deleteRecords($tableName, $ids, $relationsToNeglect = [])
    {
        $databaseName = DB::connection()->getDatabaseName();
        $destroyDenied = [];
        foreach ($ids as $id) {
            if (checkColumnUsed($databaseName, $tableName, 'id', $id, $relationsToNeglect)) {
                $destroyDenied[] = [$id];
            } else {

                $this->delete($id);
            }
        }
        return count($destroyDenied);
    }

    public function childValue($key = null, $value = null, $property = 'code')
    {
        $parentCode = $this->model->when(isset($value), function ($query) use ($key, $value) {
            return $query->where($key, $value);
        })->value($property);
        return (string)$parentCode . "001";
    }

    public function orderNumperNext($key = null, $value = null)
    {
        $code = $this->model->when(isset($value), function ($query) use ($key, $value) {
            return $query->where($key, $value);
        })->orderBy('id', 'desc')->pluck('order_number')->first();
        $nextCode = getAutoGeneratedNextCode($code);
        $newCode = $this->model->when(isset($value), function ($query) use ($key, $value) {
            return $query->where($key, $value);
        })->where('order_number', $nextCode)->pluck('order_number')->first();
        while ($newCode != null) {
            $nextCode = getAutoGeneratedNextCode($newCode);
            $newCode = $this->model->when(isset($value), function ($query) use ($key, $value) {
                return $query->where($key, $value);
            })->where('order_number', $nextCode)->pluck('order_number')->first();
        }
        return $nextCode;
    }
}
