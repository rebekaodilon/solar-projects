<?php

namespace App\Repositories;

use App\Base\BaseRepository;
use App\Models\Customer;

class CustomerRepository extends BaseRepository
{

    public function __construct()
    {
        parent::__construct(new Customer());
    }

    public function list()
    {
        return parent::findAll();
    }

    public function create($attributes): Customer
    {
        return parent::create($attributes);
    }

    public function show($id)
    {
        return parent::find($id);
    }

    public function update($id, $attributes)
    {
        return parent::update($id, $attributes);
    }

    public function delete($id)
    {
        return parent::destroy($id);
    }
}
