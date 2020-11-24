<?php namespace App\Models;

use CodeIgniter\Model;

$db = db_connect();

class login_model extends Model
{
    protected $table = "login";

    public function Login_User($uname,$pass)
    {
        $builder = $this->db->table('login lg');
        $builder->select('lg.Sno AS Sno,Username,U_PASSWORD,Role,lg.User_Id AS User_Id,usr.Dept_Id AS Dept_Id,usr.U_Name AS U_Name,usr.Desig_Id AS Desig_Id,lg.Approval');
        $builder->join('users usr', 'usr.User_Id=lg.User_Id', 'inner');
        $builder->where('Username', $uname);
        $builder->where('U_Password', $pass);
        $query = $builder->get();
        return $query->getResultArray();
    }
}