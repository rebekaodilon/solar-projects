<?php

namespace App\Base;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Query\Builder;

class BaseRepository
{
    protected const MAX_PER_PAGE = 50;
    protected const PER_PAGE = 20;

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
     * @param array $attributes
     *
     * @return Model
     */
    public function create($attributes): Model
    {
        return $this->model->create($attributes);
    }

    /**
     * @param array $attributes
     *
     * @return Model
     */
    public function updateOrCreate($key, $value, array $attributes): Model
    {
        return $this->model->updateOrCreate(
            [$key => $value],
            $attributes
        );
    }

    /**
     * @param array $attributes
     *
     * @return
     */
    public function update($id, array $attributes)
    {
        return $this->model->where('id', $id)->update($attributes);
    }

    /**
     * @param $id
     * @return Model
     */
    public function find($id): ?Model
    {
        return $this->model->find($id);
    }

    /**
     * @param $field
     * @param $value
     * @return Model
     */
    public function findByField($field, $value)
    {
        return $this->model->where($field, $value)->first();
    }

    /**
     * @param $field
     * @param $value
     * @return Model
     */
    public function findAllByField($field, $value)
    {
        return $this->model->where($field, $value)->get();
    }
    /**
     * @param array $where
     * @return Model
     */
    public function findBy($where)
    {
        return $this->model->where($where)->first();
    }

    public function findAll()
    {
        return $this->model->all();
    }

    public function paginate($builder)
    {
        $paginate = request(['nopaginate', 'per_page']);

        if (request()->has('nopaginate'))
            return $builder->get();

        if (!isset($paginate['per_page']))
            $paginate['per_page'] = self::PER_PAGE;
        else if (isset($paginate['per_page']) && $paginate['per_page'] > self::MAX_PER_PAGE)
            $paginate['per_page'] == self::MAX_PER_PAGE;

        return $builder->paginate($paginate['per_page']);
    }

    /**
     * @override method
     * @param Builder $builder
     * @return Builder
     */
    public function makeFilter($builder)
    {
        if (request()->has('code'))
            $builder->where('code', request()->input('code'));

        return $builder;
    }

    /**
     * @return int
     */
    public function getNextCode()
    {
        $currentCode = $this->model->orderBy('created_at', 'ASC')->pluck('code')->last();
        return $currentCode + 1;
    }

    /**
     * @param array $where
     * @param array $with
     *
     * @return Model
     */
    public function findByWith($where, $with)
    {
        return $this->model
            ->where($where)
            ->with($with)
            ->first();
    }

    public function destroyAll($key, $id)
    {
        return $this->model->where($key, $id)->delete();
    }

    public function destroy($id)
    {
        return $this->model->where('id', $id)->delete();
    }
}
