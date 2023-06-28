<?php

namespace App\Models\Contracts;

use App\Models\Contracts\CrudInterface;


abstract class BaseModel implements CrudInterface
{
    protected $connection;
    protected $table;
    protected $primaryKey = 'id';
    protected $pageSize = 10;
    protected $attributes =[];

    protected function __construct()
    {
        # if mysql => set connection
    }

    protected function getAttribute($key){
        if(!$key || array_key_exists($key,$this->attributes)){
            return null;
        }
         return $this->attributes[$key];
    }

    public function __get($name)
    {
        return $this->getAttribute($name);
    }

    public function __set($name, $value)
    {
        if(!array_key_exists($name,$this->attributes)){
            return null;
        }

        $this->attributes[$name] = $value;
    }
}