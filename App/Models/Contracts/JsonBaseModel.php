<?php

namespace App\Models\Contracts;

class JsonBaseModel extends BaseModel
{
    private $db_folder;
    private $table_path;

    public function __construct()
    {
        $this->db_folder = BASEPATH . "Storage/Jsondb/";
        $this->table_path = $this->db_folder . $this->table . '.json';
    }

    private function read_table() : array
    {
        return json_decode(file_get_contents($this->table_path));
    }

    private function write_table(array $data)
    {
        $table_data_json = json_encode($data);
        file_put_contents($this->table_path,$table_data_json);
    }
        # create (insert)
        public function create(array $data) : int
        {
            $table_data = $this->read_table();
            $table_data[] = $data;
            $this->write_table($table_data);

            return 1;
        }

        # read (select)  single | multiple
        public function find($id) : object
        {
            $table_data = $this->read_table();
            foreach ($table_data as $row) {
                if($row->{$this->primaryKey} === $id){
                    return $row;
                }
            }
            return null;
        }
    
        public function get(array $columns,array $where) : array
        {
            return [];
        }
    
        # update records 
        public function update(array $columns,array $where) : int
        {
            return 1;
        }
    
        # Delete 
        public function delete(array $where) : int
        {
            return 1;
        }
}