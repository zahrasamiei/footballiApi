<?php


namespace App\Repositories\Eloquent;


use App\Repositories\EloquentRepositoryInterface;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;

class BaseRepository implements EloquentRepositoryInterface
{

    /**
     * @var Model
     */
    protected $model;

    /**
     * BaseRepository constructor.
     *
     * @param Model $model
     */

    public function __construct(Model $model)
    {
        $this->model = $model;
    }

    /**
     * @return Collection|Model[]
     */

    public function all():Collection
    {
        return $this->model->all();
    }

    /**
     * @param array $attributes
     * @return Model
     */

    public function create(array $attributes): Model
    {
        return $this->model->create($attributes);
    }

    /**
     * @param array $attributes
     * @param string $field
     * @param $value
     * @return Model
     */

    public function update(array $attributes, $value, string $field = "id")
    {
        return $this->findByColumn($field,$value)->update($attributes);
    }

    /**
     * @param int $id
     * @return int
     */

    public function delete(int $id): int
    {
        return $this->model->destroy($id);
    }

    /**
     * @param $id
     * @return Model
     */

    public function find($id): ?Model
    {
        return  $this->model->find($id);
    }

    /**
     * @param $table
     * @param $values
     * @return Model
     */

    public function findByRelation($table, $values): ?Model
    {
        return  $this->model->where($values["field1"], "LIKE","%".$values["value1"]."%")->whereHas($table, function (Builder $query) use($values){
            $query->where($values["field2"], "LIKE","%".$values["value2"]."%");
        });
    }

    /**
     * @param $column
     * @param $value
     * @return Model
     */

    public function findByColumn($column, $value)
    {
        return $this->model->where($column, $value);
    }

    /**
     * @param $column
     * @param $value
     * @return Model
     */

    public function findLikeByColumn($column, $value)
    {
        return $this->model->where($column, 'LIKE',"%$value%");
    }

    /**
     * @param array $attributes
     * @return Model
     */

    public function createMany($attributes)
    {
        return $this->model->insert($attributes);
    }

    /**
     * @param string $relation
     * @param array $data
     * @param int $id
     * @return Model
     */

    public function addRelationData(string $relation, array $data, int $id)
    {
        return $this->find($id)?$this->find($id)->$relation()->create($data):false;
    }
}
