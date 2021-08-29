<?php
namespace App\Repositories;

use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;

/**
 * Interface EloquentRepositoryInterface
 * @package App\Repositories
 */
interface EloquentRepositoryInterface
{
    /**
     * @return Collection|Model[]
     */

    public function all():Collection;

    /**
     * @param array $attributes
     * @return Model
     */

    public function create(array $attributes): Model;

    /**
     * @param array $attributes
     * @param string $field
     * @param $value
     * @return Model
     */

    public function update(array $attributes, $value, string $field = "id");

    /**
     * @param int $id
     * @return int
     */

    public function delete(int $id): int;

    /**
     * @param $id
     * @return Model
     */

    public function find($id): ?Model;

    /**
     * @param $table
     * @param $values
     * @return Model
     */

    public function findByRelation($table, $values): ?Model;

    /**
     * @param $column
     * @param $value
     * @return Model
     */

    public function findByColumn($column, $value);

    /**
     * @param $column
     * @param $value
     * @return Model
     */

    public function findLikeByColumn($column, $value);

    /**
     * @param array $attributes
     * @return Model
     */

    public function createMany($attributes);

    /**
     * @param string $relation
     * @param array $data
     * @param int $id
     * @return Model
     */

    public function addRelationData(string $relation, array $data, int $id);

}
