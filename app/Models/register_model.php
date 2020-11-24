<?php namespace App\Models;

use CodeIgniter\Model;

$db = db_connect();

class register_model extends model
{
    protected $table = "users";

    public function Register_User($user_id,$name,$mobile,$gender_id,$dept_Id,$role_Id,$desig_Id,$dist_Id,$city_Id,$address,$register_by)
    {
        if($dist_Id == '' && $city_Id == '' && $address == '')
        {
            $parameter_Register = array('User_Id'=>$user_id,'U_Name'=>$name,'Mobile'=>$mobile,'Gender_Id'=>$gender_id,'Dept_Id'=>$dept_Id,'Role_Id'=>$role_Id,'Desig_Id'=>$desig_Id,'Register_By'=>$register_by);
        }
        else
        {
            $parameter_Register = array('User_Id'=>$user_id,'U_Name'=>$name,'Mobile'=>$mobile,'Gender_Id'=>$gender_id,'Dept_Id'=>$dept_Id,'Role_Id'=>$role_Id,'Desig_Id'=>$desig_Id,'Dist_Id'=>$dist_Id,'City_Id'=>$city_Id,'Address'=>$address,'Register_By'=>$register_by);
        }
        $parameter_Login = array('Username'=>$mobile,'User_Id'=>$user_id,'Role'=>$role_Id);

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

    public function Show_Users_For_Approval()
    {
        $sql = "SELECT usr.User_Id AS UserId,usr.U_Name AS UName,usr.Mobile AS Mobile,
        (Case 
            WHEN usr.Gender_Id=1 THEN 'Male'
            WHEN usr.Gender_Id=2 THEN 'Female'
            ELSE 'Other'
        END) AS Gender,md.Dept_Name AS Department,mr.Role_Name AS Role,mdsg.Desig_Name AS Designation,usr.Address AS Address
        FROM users usr
        INNER JOIN master_department md ON md.Dept_Id=usr.Dept_Id
        INNER JOIN master_role mr ON mr.Role_Id=usr.Role_Id
        INNER JOIN master_designation mdsg ON mdsg.Desig_Id=usr.Desig_Id
        WHERE usr.Mobile IN(SELECT Username FROM login WHERE Approval=0)";
        $query = $this->db->query($sql);        
        return $query->getResultArray();
    }

    public function Decision_On_User($UserId,$Decision,$Reason)
    {
        $pwd='';
        $this->db->transBegin();

        $data = [
            'Reason' => $Reason
        ];
        $builder = $this->db->table('users');
        $builder->where('User_Id', $UserId);
        $builder->update($data);

        if($Decision == 1)
        {
            $pwd='123456';
        }
        elseif($Decision == 2)
        {
            $pwd='';
        }

        $data = [
            'Approval' => $Decision,
            'U_Password' => $pwd
        ];        
        $builder = $this->db->table('login');
        $builder->where('User_Id', $UserId);
        $builder->update($data);

        if($this->db->transStatus === FALSE){
            $this->db->transRollback();
            return false;
        }
        else{
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

    public function Get_Department()
    {
        $builder = $this->db->table('master_department')->select('Dept_Id,Dept_Name');
        $query = $builder->get();
        return $query->getResultArray();
    }

    public function Get_Designation()
    {
        $builder = $this->db->table('master_designation')->select('Desig_Id,Desig_Name');
        $query = $builder->get();
        return $query->getResultArray();
    }
}