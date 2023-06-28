<?php

namespace App\Models\Contracts;

interface CrudInterface
{
    # create (insert)
    public function create(array $data) : int;

    # read (select)  single | multiple
    public function find($id) : object;

    public function get(array $columns,array $where) : array;

    # update records 
    public function update(array $columns,array $where) : int;

    # Delete 
    public function delete(array $where) : int;
}