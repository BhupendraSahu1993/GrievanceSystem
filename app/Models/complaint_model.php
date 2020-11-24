<?php namespace App\Models;

use CodeIgniter\Model;

$db = db_connect();

class complaint_model extends Model
{
    protected $table = "complaint";

    public function Register_Complaint($TicketId,$IssueType,$SubIssueType,$file,$AppId,$Reason,$Complaint_Status,$Insertion,$Ip_Address,$User_Id,$Refer_To)
    {
        $parameter_complaint = array('Ticket_Id'=>$TicketId,'Issue_Type'=>$IssueType,'Sub_Issue_type'=>$SubIssueType,'App_Id'=>$AppId,'Reason'=>$Reason,'Complaint_Status'=>$Complaint_Status,'Insertion'=>$Insertion,'Ip_Address'=>$Ip_Address,'User_Id'=>$User_Id);
        $parameter_compl_trans = array('User_Id'=>$User_Id,'Ticket_Id'=>$TicketId,'Date_Time_Stamp'=>$Insertion,'Ip_Address'=>$Ip_Address,'Refer_To'=>$Refer_To,'Refer_From'=>$User_Id);

        $this->db->transBegin();
        $query_complaint = $this->db->table('complaint')->insert($parameter_complaint);
        for($i = 1; $i < sizeof($file['name']); $i++)
        {
            $parameter_file_upload = array('Ticket_Id'=>$TicketId,'FileName'=>$file['name'][$i],'User_Id'=>$User_Id);
            $query_file_upload = $this->db->table('complaint_img_vdo')->insert($parameter_file_upload);
        }      
        $query_compl_trans = $this->db->table('complaint_transaction')->insert($parameter_compl_trans);
        
        if($this->db->transStatus === FALSE){
            $this->db->transRollback();
            return false;
        }
        else{
            $this->db->transCommit();
            return true;
        }
    }

    public function Get_Max_Ticket_Id()
    {
        $builder = $this->db->table('complaint')->selectMax('Ticket_Id');
        $query = $builder->get();
        return $query->getResult();
    }

    public function Department()
    {
        $builder = $this->db->table('master_department')->select('Dept_Id, Dept_Name');
        $query = $builder->get();
        //echo "<pre>" ; print_r($query->getResultArray()); exit;
        return $query->getResultArray();
    }

    public function Application()
    {
        $builder = $this->db->table('master_application')->select('App_Id,App_Name');
        $query = $builder->get();
        return $query->getResultArray();
    }

    public function IssueType()
    {
        $builder = $this->db->table('master_issue_type')->select('IssueId,IssueName');
        $query = $builder->get();
        return $query->getResultArray();
    }

    public function SubIssueType($IssueType)
    {
        $builder = $this->db->table('master_sub_issues_type')->select('SubIssueId,SubIssueName');
        $builder->where('IssueId', $IssueType);
        $query = $builder->get();
        return $query->getResultArray();
    }

    public function Show_Submitted_Complaint_To_User()
    {
        $query = $this->db->query("SELECT Sno,Ticket_Id,md.Dept_Name AS Department,Reason,Complaint_Status,
        CASE 
            WHEN Complaint_Status=1 THEN 'Pending' 
            WHEN Complaint_Status=2 THEN 'Accepted'
            WHEN Complaint_Status IN(3,4,6) THEN 'In Progress'
            WHEN Complaint_Status=7 THEN 'Completed'
            WHEN Complaint_Status=5 THEN 'Rejected'
         ELSE 'No Result' END AS CaseStatus 
        FROM complaint cmp
        INNER JOIN master_department md ON cmp.Dept_Id=md.Dept_Id
        WHERE User_Id IN(SELECT User_Id FROM complaint_transaction)");
        return $query->getResultArray();
    }
}