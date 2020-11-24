<?php namespace App\Models;

use CodeIgniter\Model;

$db = db_connect();

class add_designation_model extends model
{
    public function Designation($dept_Id,$desig_name)
    {
        $parameter = array('Dept_Id'=>$dept_Id,'Desig_Name'=>$desig_name);
        $builder = $this->db->table('master_designation')->insert($parameter);
        if(isset($builder))
        {
            return true;
        }
        else {
            return false;
        }
    }
}