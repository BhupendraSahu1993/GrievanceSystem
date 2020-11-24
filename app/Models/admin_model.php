<?php namespace App\Models;

use CodeIgniter\Model;

$db = db_connect();

class admin_model extends model
{
    protected $table = "users";

    public function Admin_Register_User($user_id,$name,$mobile,$gender_id,$dept_Id,$role_Id,$desig_Id,$dist_Id,$city_Id,$address,$password)
    {
        $parameter_Register = array('User_Id'=>$user_id,'Name'=>$name,'Mobile'=>$mobile,'Gender_Id'=>$gender_id,'Dept_Id'=>$dept_Id,'Role_Id'=>$role_Id,'Desig_Id'=>$desig_Id);
        $parameter_Login = array('Username'=>$mobile,'Password'=>$password,'User_Id'=>$user_id,'Role'=>$role_Id,'Dept_Id'=>$dept_Id);
        
        $this->db->transBegin();
        $query_Reg = $this->db->table('users')->insert($parameter_Register);
        $query_Log = $this->db->table('login')->insert($parameter_Login);
        
        if($this->db->transStatus() === FALSE)
        {
            $this->db->transRollback();
            return false;
        }
        else
        {
            $this->db->transCommit();
            return true;
        }
    }

    public function Get_Max_User_Id()
    {
        $builder = $this->db->table('users')->selectMax('User_Id');
        $query = $builder->get();
        return $query->getResult();
    }
}