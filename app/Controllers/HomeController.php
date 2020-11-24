<?php namespace App\Controllers;

use CodeIgniter\HTTP\IncomingRequest;

use App\Models\login_model;
use App\Models\register_model;
use CodeIgniter\Controller;
use CodeIgniter\I18n\Time;

$request = service('request');

class HomeController extends BaseController
{
	
	public function index()
	{ 
		$model = new register_model();
		$data['Department'] = $model->Get_Department();
		$data['Designation'] = $model->Get_Designation();
		echo view('Home/Login',$data);
	}

	public function Login()
	{
		$model = new login_model();

		$uname = $this->request->getPost('uname');
		$pass=$this->request->getPost('pass');

		$log_user = $model->Login_User($uname,$pass);

		
		if(isset($log_user) && !empty($log_user))
		{
			if($log_user[0]['Approval'] == 1)
			{
				$_SESSION['uname'] = $log_user[0]['Username'];
				$_SESSION['role'] = $log_user[0]['Role'];
				$_SESSION['user_id'] = $log_user[0]['User_Id'];
				$_SESSION['dept_id'] = $log_user[0]['Dept_Id'];
				$_SESSION['u_name'] = $log_user[0]['U_Name'];
				$_SESSION['desig_id'] = $log_user[0]['Desig_Id'];
				
				if($_SESSION['role'] == '6')
				{
					return redirect()->route('user/complaint');
				}
				elseif($_SESSION['role'] == '1' || $_SESSION['role'] == '2')
				{
					return redirect()->route('admin/showcomplaint');
				}
				elseif ($_SESSION['role'] == '3') 
				{
					return redirect()->route('department/showcomplaint');
				}
				elseif ($_SESSION['role'] == '4') 
				{
					return redirect()->route('department/showcomplainttoteammember');
				}
				else 
				{
					print_r('Wrong username and password');
				}
			}
			else
			{
				$msg = "Your login is not approved yet..";
				return redirect()->back()->with('msg', $msg);
			}
		}
		else
		{
			$msg = "Username and Password is Incorrect !";
			return redirect()->back()->with('msg', $msg);
		}
	}

	public function Logout()
	{
		unset(
			$_SESSION['uname'],
			$_SESSION['role'],
			$_SESSION['user_id']
		);
		// print_r($_SESSION['uname']); exit;
		return redirect()->route('/');
	}

	public function Register()
	{
		$model = new register_model();

		$val = "GSUI";
		$status = $model->Get_Max_User_Id();
        if($status[0]->User_Id == NULL){
            $user_id = $val.'00001';
        }
        else{
            $num = substr($status[0]->User_Id,4,9);
            $num = (int)$num + 1; 
            $num = str_pad($num,5,"0",STR_PAD_LEFT);      
            $user_id = $val.$num;
		}

		$name = $this->request->getPost('Name');
		$mobile=$this->request->getPost('Mobile');
		$gender_id=$this->request->getPost('Gender_id');
		$dept_Id=$this->request->getPost('Dept_Id');
		$role_Id='6';
		$desig_Id=$this->request->getPost('Desg_Id');
		$dist_Id=$this->request->getPost('Dist_Id');
		$city_Id=$this->request->getPost('Dist_Id');
		$address=$this->request->getPost('Address');
		// $password=$this->request->getPost('Password');
		// $con_Pass=$this->request->getPost('Confirm_Password');
		$register_by="self";

		$reg_user = $model->Register_User($user_id,$name,$mobile,$gender_id,$dept_Id,$role_Id,$desig_Id,$dist_Id,$city_Id,$address,$register_by);
		// print_r($reg_user); exit;
		if($reg_user == true)
		{
			print_r('Register Successfully');
			return redirect()->route('user/complaint');
		}
		else
		{
			print_r('Register Unsuccessfully');
			return redirec()->back();
		}
	}
}