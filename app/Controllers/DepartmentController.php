<?php namespace App\Controllers;

use CodeIgniter\HTTP\IncomingRequest;
use App\Models\show_complaint_model;
use App\Models\complaint_model;
use App\Models\add_designation_model;
use App\Models\admin_model;
use CodeIgniter\Controller;
use CodeIgniter\I18n\Time;

class DepartmentController extends BaseController
{
    public function ShowComplaintToDept()
    {
        $Dept_Id = $_SESSION['dept_id'];
        $page = 'ShowComplaintToDept';
        $model = new show_complaint_model();
        $data['teamMember'] = $model->Team_Member($Dept_Id);
        $data['showComplaint'] = $model->Show_Complaint_Dept();
        $this->render_view($page, $data);
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
        $Dept_Id = $_SESSION['dept_id'];
        $User_Id = $_SESSION['user_id'];
        $page = 'ShowSolvedComplaint';
        $model = new show_complaint_model();
        $data['teamMember'] = $model->Team_Member($Dept_Id);
        $data['showComplaint'] = $model->Show_Solved_Complaint($User_Id);
        $this->render_view($page, $data);
    }

    public function ReferToTeamMember()
    {
        $model = new show_complaint_model();
        $TicketId = $this->request->getPost('TicketId');
        $ProblemExp = $this->request->getPost('Explain');
        $Updation = new Time('now');
        $StatusVal = 3;
        $Ip_Address = $this->request->getIPAddress();
        $User_Id = $_SESSION['user_id'];
        $Refer_to = $this->request->getPost('Team_Member_Id');

        $refer_status = $model->Refer_To_Team_Member($ProblemExp,$TicketId,$Updation,$StatusVal,$Ip_Address,$User_Id,$Refer_to);
        if($refer_status == true)
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

    public function ShowComplaintToTeamMember()
    {
        $User_Id = $_SESSION['user_id'];
        $page = 'ShowComplaintToTeamMember';
        $model = new show_complaint_model();
        $data['teamLeader'] = 1;
        $data['showComplaint'] = $model->Show_Complaint_To_Team_Member($User_Id);
        $this->render_view($page, $data);
    }

    public function GetTeamLeader()
    {
        $ticketId = $_GET['ticketId'];
        // print_r($ticketId); exit;
        $model = new show_complaint_model();
        $data = $model->Team_Leader($ticketId);
        
        $response = array(
            'status'   => 200,
            'Refer_from' => $data[0]['Refer_from'],
            'U_Name' => $data[0]['U_Name']
        );
        echo(json_encode($response));
    }

    public function ComplaintSolved()
    {
        $model = new show_complaint_model();
        $TicketId = $this->request->getPost('TicketId');
        $ProblemSol = $this->request->getPost('ProbSol');
        $Updation = new Time('now');
        $StatusVal = 4;
        $Ip_Address = $this->request->getIPAddress();
        $User_Id = $_SESSION['user_id'];
        $Refer_to = $this->request->getPost('Team_Leader_Id');

        $refer_status = $model->Solved_the_Complaint($ProblemSol,$TicketId,$Updation,$StatusVal,$Ip_Address,$User_Id,$Refer_to);
        if($refer_status == true)
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

    public function TakeDecisionOnSolvedComplaint()
    {
        $model = new show_complaint_model();
        $TicketId = $this->request->getPost('TicketId');
        $Decision = $this->request->getPost('Decision');
        $User_Id = $_SESSION['user_id'];
        $Updation = new Time('now');
        $Ip_Address = $this->request->getIPAddress();
        
        if($Decision == 1)
        {
            $Refer_to = 2;
            $StatusVal = 6;
            $NAReason="";
        }
        elseif($Decision == 2)
        {
            $R_To_DisApp = $model->Not_Approved_By_Teamleader($TicketId);
            $Refer_to = $R_To_DisApp[0]['Refer_From'];
            $StatusVal = 3;
            $NAReason = $this->request->getPost('notAppReason');
        }
        else {
            # code...
        }

        $Update_Status = $model->Approve_Or_DisApproved_By_TeamLeader($TicketId,$User_Id,$Updation,$Ip_Address,$Refer_to,$StatusVal,$NAReason);
        if($Update_Status == true)
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

    function render_view($page, $data)
	{
		echo view('templates/header');
		echo view('department/'.$page, $data);
		echo view('templates/footer');
	}
}