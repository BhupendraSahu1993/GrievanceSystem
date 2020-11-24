<?php namespace App\Controllers;

use CodeIgniter\HTTP\IncomingRequest;
use App\Models\show_complaint_model;
use App\Models\complaint_model;
use App\Models\register_model;
use App\Models\add_designation_model;
use App\Models\admin_model;
use CodeIgniter\Controller;
use CodeIgniter\I18n\Time;

class AdminController extends BaseController
{
    public function index()
    {
        return view('Admin/Dashboard');
    }

    public function ShowUsersForApproval()
    {
        // if(empty($_SESSION['uname']) || empty($_SESSION['user_id'] ))
        // {
        //     return redirect()->route('/');
        // }
        // $dept_id = $_SESSION['dept_id'];
        $page = 'UserForApproval';
        $model = new register_model();
        $data['Users'] = $model->Show_Users_For_Approval();
        $this->render_view($page, $data);
    }

    public function DecisionOnUser()
    {
        $model = new register_model();
        $UserId = $this->request->getPost('User_Id');
        $Decision = $this->request->getPost('Take_Action');
        $Reason = $this->request->getPost('refuseReason');
        $decisionOnUsers = $model->Decision_On_User($UserId,$Decision,$Reason);
        if($decisionOnUsers == true)
		{
			print_r('Approved Successfully');
			return redirect()->back();
		}
		else
		{
			print_r('You refused the user registration !');
			return redirec()->back();
		}
    }

    public function ShowComplaint()
    {
        if(empty($_SESSION['uname']) || empty($_SESSION['user_id'] ))
        {
            return redirect()->route('/');
        }
        $dept_id = $_SESSION['dept_id'];
        $page = 'showcomplaint';
        $model = new show_complaint_model();
        $com_data['Department'] = $model->Department();
        $com_data['showComplaint'] = $model->Show_Complaint($dept_id);
        $this->render_view($page, $com_data);
    }

    public function ShowImageVideo()
    {
        $model = new show_complaint_model();
        $ticketId = $_GET['ticketId'];
        $comFile = $model->Show_Image_Video($ticketId);
        $response = array(
            'Status'   => 200,
            'Message' => "Data Saved Successfully",
            'comFile' => $comFile
        );
        echo(json_encode($response));
    }

    public function ShowSolvedComplaint()
    {
        $page = 'ShowSolvedComplaint';
        $model = new show_complaint_model();
        $data['SolvedComplaint'] = $model->Show_Solved_Complaint_To_Admin();
        $this->render_view($page, $data);
    }

    public function User()
    {
        $model = new show_complaint_model();
        $page = 'RegisterUser';
        $data['title'] = ucfirst($page); // Capitalize the first letter   
        $status['Department'] = $model->Department();  
        $status['Designation'] = $model->Designation();    
        $status['Role'] = $model->Role(); 
        $this->render_view($page, $status);
    }

    public function RegisterUser()
    {
        $model = new admin_model();

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
        $dept_Id=$this->request->getPost('Dept_Id');
        $role_Id=$this->request->getPost('Role_Id');
        $desig_Id=$this->request->getPost('Desig_Id');
        $gender_id='';
        $dist_Id='';
		$city_Id='';
		$address='';
        $password='12345';
        $register_by=$_SESSION['user_id'];

        $admin_reg_user = $model->Admin_Register_User($user_id,$name,$mobile,$gender_id,$dept_Id,$role_Id,$desig_Id,$dist_Id,$city_Id,$address,$password,$register_by);

		if($admin_reg_user == true)
		{
			print_r('Register Successfully');
			return redirect()->route('admin/user');
		}
		else
		{
			print_r('Register Unsuccessfully');
			return redirec()->back();
		}
    }

    public function AddDesignation()
    {
        $model = new complaint_model();
        $page = 'AddDesignation';
        $status['Department'] = $model->Department();
        $this->render_view($page, $status);
    }

    public function InsertDesignation()
    {
        $model = new add_designation_model();

        $dept_Id = $this->request->getPost('Dept_Id');
        $desig_name = $this->request->getPost('Desig_Name');
        $add_desig = $model->Designation($dept_Id,$desig_name);
        if($add_desig == true)
		{
			print_r('Register Successfully');
			return redirect()->route('admin/designation');
		}
		else
		{
			print_r('Register Unsuccessfully');
			return redirec()->back();
		}
    }

    public function UpdateComplaintStatus()
    {
        $model = new show_complaint_model();
        $TicketId = $this->request->getPost('TicketId');
        $DeptId = $this->request->getPost('Dept_Id');
        $Action = $this->request->getPost('Take_Action');
        $Updation = new Time('now');
        $Ip_Address = $this->request->getIPAddress();
        $Issue_Situation = $this->request->getPost('Issue_Situ');
        $User_Id = $_SESSION['user_id'];

        if($Action == 1){
            $StatusVal = 2;
            $Refer_To = $this->request->getPost('Dept_Id');
            $Reject="";
        }
        elseif($Action == 2){
            $StatusVal = 5;
            $Refer_To = "User";
            $Reject = $this->request->getPost('rejectReason');
        }

        $upt_status = $model->Complaint_Accepted($TicketId,$DeptId,$Updation,$StatusVal,$Ip_Address,$Issue_Situation,$User_Id,$Refer_To,$Reject);
        
        if($upt_status == true)
        {
            // print_r('Hello'); exit;
            $msg='successful';
            return redirect()->back();
        }
        else
        {
            // print_r('hi'); exit;
            $msg="un-successful";
            return redirect()->back();
        }
    }

    public function SolveComplaintSendToUser()
    {
        $model = new show_complaint_model();
        $TicketId = $_GET['ticketId'];
        $Updation=new Time('now');
        $StatusVal=7;
        $Ip_Address=$this->request->getIPAddress();
        $User_Id=$_SESSION['user_id'];

        $Get_UserId = $model->Get_UserID_of_Complaint($TicketId);

        $Refer_to= $Get_UserId[0]['User_Id'];

        $Upt_Comp_Status = $model->Complaint_Solved($TicketId,$Updation,$StatusVal,$Ip_Address,$User_Id,$Refer_to);
        $response = array(
            'status'   => 200,
            'Message' => "Data Saved Successfully",
        );
        echo(json_encode($response));
    }

    function render_view($page, $data)
	{
		echo view('templates/header');
		echo view('admin/'.$page, $data);
		echo view('templates/footer');
    }
}