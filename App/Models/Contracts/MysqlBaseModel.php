<?php

namespace App\Models\Contracts;

use PDO;
use Medoo\Medoo;

class MysqlBaseModel extends BaseModel
{
    public function __construct()
    {
        try {
            // $this->connection = new PDO("mysql:host={$_ENV['DB_HOST']};port=8889;dbname={$_ENV['DB_NAME']}", $_ENV['DB_USER'], $_ENV['DB_PASS']);
            // $this->connection->exec("set name utf8;");
            $this->connection = new Medoo([
                // [required]
                'type' => 'mysql',
                'host' => $_ENV['DB_HOST'],
                'database' => $_ENV['DB_NAME'],
                'username' => $_ENV['DB_USER'],
                'password' => $_ENV['DB_PASS'],
             
                // [optional]
                'charset' => 'utf8mb4',
                'collation' => 'utf8mb4_general_ci',
                'port' => 8889,
            ]);
        
        } catch (\Throwable $th) {
            echo "connection failed: " . $th->getMessage();
        }


    }

	public function create(array $data): int {

       $this->connection->insert($this->table, $data);
        return $this->connection->id();
	}
	

	public function find($id): object {

       $result = $this->connection->get($this->table, "*", [$this->primaryKey => $id]);

       if(is_null($result))
       {
        return (object)null;
       }

       foreach ($result as $col => $val) {
            $this->attributes[$col] = $val;
       }

       return $this;
	}

    public function getAll():array
    {
        return $this->connection->select($this->table, "*");
    }
	

	public function get(array $columns, array $where): array {

        return $this->connection->select($this->table, $columns , $where);
	}

	public function update(array $data, array $where): int {

        $result = $this->connection->update($this->table, $data, $where);
        return $result->rowCount();
	}
	

	public function delete(array $where): int {

        $result = $this->connection->delete($this->table, $where);
        return $result->rowCount();
	}

    public function remove(): int 
    {
        $record_id = $this->{$this->primaryKey};
        return $this->delete([$this->primaryKey => $record_id]);
    }

    public function save(): int 
    {
        $record_id = $this->{$this->primaryKey};
        return $this->update($this->attributes,[$this->primaryKey => $record_id]);
    }
}