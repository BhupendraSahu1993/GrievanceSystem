<?php namespace App\Controllers;

use CodeIgniter\HTTP\IncomingRequest;

use App\Models\complaint_model;
use CodeIgniter\Controller;
use CodeIgniter\I18n\Time;


$request = service('request');

class UserController extends BaseController
{
    public function index()
    {
        $this->render_view($page, $data);
    }

    public function complaint()
    {
        if(!isset($_SESSION['uname']) && !isset($_SESSION['user_id']))
        {
            return redirect()->route('/');
        }
        elseif($_SESSION['role'] != '6')
        {
            return redirect()->back();
        }
        $model = new complaint_model();
        $page = 'Complaint';
        $data['title'] = ucfirst($page); // Capitalize the first letter 
        $status['Issue_Type'] = $model->IssueType();
        $status['Application'] = $model->Application();     
        $this->render_view($page, $status);
    }

    public function submit_complaint()
    {
        $model = new complaint_model();

        helper(['form', 'url']);

        $val = "CT";
        $year = date('Y');
        $month = date('m');
        $day = date('d');    
        $status = $model->Get_Max_Ticket_Id();

        if($status[0]->Ticket_Id == NULL)
        {
            $TicketId = $val.$year.$month.$day.'00001';
        }
        else
        {
            $ticketNo = substr($status[0]->Ticket_Id,10,14);
            $num = (int)$ticketNo + 1; 
            $num = str_pad($num,5,"0",STR_PAD_LEFT);      
            $TicketId = $val.$year.$month.$day.$num;
        }

        $IssueType = $this->request->getPost('Issue_Type');
        $SubIssueType = $this->request->getPost('Sub_Issue_Type');

        if($SubIssueType == 2)
        {
            $AppId = $this->request->getPost('App_Id');
        }
        else
        {
            $AppId = '';
        }

        if($this->request->getPost('ImgVdoUpd') == 1) // If Upload File
        {
            $file['name'][] = "";
            $newName = time();

            if($this->request->getPost('ImgVdoSelect') == 1) // For Image
            {
                if($comp_File = $this->request->getFiles())
                {
                    foreach($comp_File['upl_Img'] as $img)
                    {
                        $type = $img->getMimeType();
                        $ext = $img->getClientExtension();
                        $size = $img->getSize();

                        if(($ext == 'jpg' || $ext == 'jpeg' || $ext == 'gif' || $ext == 'png' || $ext == 'bmp') && $size <= 1048576)
                        {
                            if ($img->isValid() && ! $img->hasMoved())
                            {
                                $img->move('./uploads/images', $newName.".".$ext);
                                $file['name'][] = $newName.".".$ext;
                            }
                            else
                            {
                                var_dump('Image not uploaded'); exit;
                            }
                        }   
                        else
                        {
                            var_dump('Failed!! Please upload jpg, jpeg, png, gif, bmp file only.'); exit;
                        }                     
                    }
                }  
                else
                {
                    var_dump("Select image to upload"); exit;
                }             
            }
            elseif($this->request->getPost('ImgVdoSelect') == 2) // For Video
            {
                $comp_File = $this->request->getFile('upl_Vdo');
                $type = $comp_File->getMimeType();
                $ext = $comp_File->getClientExtension();
                $size = $comp_File->getSize();

                $validated = $this->validate([
                    'upl_Vdo' => [
                        'uploaded[upl_Vdo]',
                        'mime_in[upl_Vdo,video/mp4,video/mkv,video/avi]',
                        'max_size[upl_Vdo,3121000]',
                    ],
                ]);

                if($validated)
                {
                    $comp_File->move('./uploads/videos', $newName.".".$ext);        
                    $file['name'][] = $newName.".".$ext;
                }
            }
            else
            {
                var_dump("Please select file to upload !"); exit;
            }
        }
        else
        {
            $file['name'][] = "";
        }     

        $Reason=$this->request->getPost('Reason');
        $Complaint_Status=1;
        $Insertion=new Time('now');
        $Ip_Address=$this->request->getIPAddress();
        $User_Id=$_SESSION['user_id'];
        $Refer_To=2;

        $comp_reg = $model->Register_Complaint($TicketId,$IssueType,$SubIssueType,$file,$AppId,$Reason,$Complaint_Status,$Insertion,$Ip_Address,$User_Id,$Refer_To);

        if($comp_reg == true)
        {
            $msg = "Complaint Submitted Successfully. Your Complaint Id is ".$TicketId;
            return redirect()->back()->with('msg', $msg);
        }
        else
        {
            $msg = "Compliant not Submitted Unsuccessful";
            return redirect()->back()->with('msg', $msg);
        }
    }

    public function SubmitedComplaint()
    {
        $page = "ShowComplaintStatus";
        $model = new complaint_model();
        $data['ShowComplaint'] = $model->Show_Submitted_Complaint_To_User();
        $this->render_view($page, $data);
    }

    public function SubIssueType()
    {
        $model = new complaint_model();
        $IssueType = $_GET['typeofIssue'];
        $GetIssueType = $model->SubIssueType($IssueType);
        $response = array(
            'Status'   => 200,
            'Message' => "Data Saved Successfully",
            'SubIssueType' => $GetIssueType
        );
        echo(json_encode($response));
    }

    function render_view($page, $data = null)
	{
		echo view('templates/header');
		echo view('User/'.$page, $data);
		echo view('templates/footer');
	}
}