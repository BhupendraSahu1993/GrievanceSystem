<?php namespace App\Models;

use CodeIgniter\Model;

$db = db_connect();

class show_complaint_model extends model
{
    public function Department()
    {
        $builder = $this->db->table('master_department')->select('Dept_Id, Dept_Name');
        $query = $builder->get();
        return $query->getResultArray();
    }

    public function Designation()
    {
        $builder = $this->db->table('master_designation')->select('Desig_Id,Desig_Name');
        $query = $builder->get();
        return $query->getResultArray();
    }
    
    public function Role()
    {
        $builder = $this->db->table('master_role')->select('Role_Id,Role_Name');
        $query = $builder->get();
        return $query->getResultArray();
    }

    public function Show_Complaint($dept_id)
    {
        $sql = "SELECT Ticket_Id,mit.IssueName AS Issue,msit.SubIssueName AS SubIssue,msit.IssueId,ma.App_Name AS ApplicationName,Reason
        FROM complaint cmp
        INNER JOIN master_issue_type mit ON cmp.Issue_Type=mit.IssueId
        INNER JOIN master_sub_issues_type msit ON cmp.Sub_Issue_type=msit.SubIssueId
        LEFT JOIN master_application ma ON cmp.App_Id=ma.App_Id
        WHERE Complaint_Status=1";
        $query = $this->db->query($sql);        
        return $query->getResultArray();
    }

    public function Show_Image_Video($ticketId)
    {
        $builder = $this->db->table('complaint_img_vdo')->select('Sno,Ticket_Id,FileName,User_Id');
        $builder->where('Ticket_Id', $ticketId);
        $query = $builder->get();
        return $query->getResultArray();
    }

    public function Complaint_Accepted($TicketId,$DeptId,$Updation,$StatusVal,$Ip_Address,$Issue_Situation,$User_Id,$Refer_To,$Reject)
    {
        $parameter_compl_trans = array('User_Id'=>$User_Id,'Ticket_Id'=>$TicketId,'Date_Time_Stamp'=>$Updation,'Ip_Address'=>$Ip_Address,'Refer_To'=>$Refer_To,'Refer_From'=>$User_Id,'comments'=>$Reject);

        $this->db->transBegin();

        $data = [
            'Dept_Id' => $DeptId,
            'Complaint_Status' => $StatusVal,
            'Updation'  => $Updation,
            'Issue_Situation' => $Issue_Situation
        ];
        $builder = $this->db->table('complaint');
        $builder->where('Ticket_Id', $TicketId);
        $builder->update($data);

        $parameter_compl_trans = $this->db->table('complaint_transaction')->insert($parameter_compl_trans);
        
        if($this->db->transStatus === FALSE){
            $this->db->transRollback();
            return false;
        }
        else{
            $this->db->transCommit();
            return true;
        }
    }

    public function Show_Complaint_Dept()
    {
        $sql = "SELECT SNo,Ticket_Id,md.Dept_Name AS Department,Reason,Complaint_Status,Insertion,Updation,ma.App_name AS Application,
                CASE 
                    WHEN cmp.Issue_Situation=1 THEN 'Critical'
                    WHEN cmp.Issue_Situation=2 THEN 'Major'
                    WHEN cmp.Issue_Situation=3 THEN 'Minor'
                    ELSE 0
                END AS IssueSituation,
                Ip_Address,User_Id
                FROM complaint cmp
                INNER JOIN master_department md ON md.Dept_Id = cmp.Dept_Id
                LEFT JOIN master_application ma ON ma.App_Id = cmp.App_Id
                WHERE Complaint_Status=2";
        $query = $this->db->query($sql);        
        return $query->getResultArray();
    }

    public function Team_Member($Dept_Id)
    {
        $builder = $this->db->table('users usr')->select('User_Id,U_Name,md.Desig_Name AS Designation');
        $builder->join('master_designation md', 'usr.Desig_Id=md.Desig_Id', 'inner');
        $builder->where('usr.Dept_Id', $Dept_Id);
        $builder->where('usr.Role_Id', 4);
        $query = $builder->get();
        return $query->getResultArray();
    }

    public function Refer_To_Team_Member($ProblemExp,$TicketId,$Updation,$StatusVal,$Ip_Address,$User_Id,$Refer_to)
    {
        $parameter_compl_trans = array('User_Id'=>$User_Id,'Ticket_Id'=>$TicketId,'Date_Time_Stamp'=>$Updation,'Ip_Address'=>$Ip_Address,'Refer_To'=>$Refer_to,'Refer_From'=>$User_Id,
        'comments' => $ProblemExp);

        $this->db->transBegin();

        $data = [
            'Complaint_Status' => $StatusVal,
            'Updation'  => $Updation
        ];
        $builder = $this->db->table('complaint');
        $builder->where('Ticket_Id', $TicketId);
        $builder->update($data);

        $parameter_compl_trans = $this->db->table('complaint_transaction')->insert($parameter_compl_trans);
        
        if($this->db->transStatus === FALSE){
            $this->db->transRollback();
            return false;
        }
        else{
            $this->db->transCommit();
            return true;
        }
    }

    public function Show_Complaint_To_Team_Member($User_Id)
    {
        $sql = "SELECT cmp.Ticket_Id,md.Dept_Name AS Department,ma.App_Name AS Application,Reason,ct.Comments AS Explanation FROM complaint cmp 
        INNER JOIN master_department md ON md.Dept_Id=cmp.Dept_Id
        LEFT JOIN master_application ma ON ma.App_Id=cmp.App_Id
        INNER JOIN complaint_transaction ct ON ct.Ticket_Id=cmp.Ticket_Id WHERE ct.Refer_To = ? AND Complaint_Status=?";
        $query = $this->db->query($sql, [$User_Id, 3]);
        // print_r($query); exit;
        return $query->getResultArray();
    }
    
    public function Solved_the_Complaint($ProblemSol,$TicketId,$Updation,$StatusVal,$Ip_Address,$User_Id,$Refer_to)
    {
        $parameter_compl_trans = array('User_Id'=>$User_Id,'Ticket_Id'=>$TicketId,'Date_Time_Stamp'=>$Updation,'Ip_Address'=>$Ip_Address,'Refer_To'=>$Refer_to,'Refer_From'=>$User_Id,
        'Comments' => $ProblemSol);

        $this->db->transBegin();

        $data = [
            'Complaint_Status' => $StatusVal,
            'Updation'  => $Updation
        ];
        $builder = $this->db->table('complaint');
        $builder->where('Ticket_Id', $TicketId);
        $builder->update($data);

        $parameter_compl_trans = $this->db->table('complaint_transaction')->insert($parameter_compl_trans);
        
        if($this->db->transStatus === FALSE){
            $this->db->transRollback();
            return false;
        }
        else{
            $this->db->transCommit();
            return true;
        }
    }

    public function Team_Leader($Ticket_Id)
    {
        $sql = "SELECT Refer_from,usr.U_Name FROM complaint_transaction ct
        INNER JOIN users usr ON ct.User_Id=usr.User_Id
        WHERE Ticket_Id=? AND Com_Tr_Id=(SELECT MAX(Com_Tr_Id) FROM complaint_transaction)";
        $query = $this->db->query($sql, [$Ticket_Id]);
        return $query->getResultArray();
    }

    public function Show_Solved_Complaint($User_Id)
    {
        $sql = "SELECT SNo,cmp.Ticket_Id,md.Dept_Name AS Department,ma.App_name Applications,Reason,ct.Comments AS Solution FROM complaint cmp
        INNER JOIN master_department md ON md.Dept_Id=cmp.Dept_Id
        LEFT JOIN master_application ma ON ma.App_Id=cmp.App_Id
        INNER JOIN complaint_transaction ct ON ct.Ticket_Id=cmp.Ticket_Id
        WHERE complaint_Status=4 AND ct.Refer_To=? 
        ORDER BY  ct.Date_Time_Stamp DESC";
        $query = $this->db->query($sql, [$User_Id]);        
        return $query->getResultArray();
    }

    public function Not_Approved_By_Teamleader($TicketId)
    {
        $builder = $this->db->table('complaint_transaction')->select('MAX(Com_Tr_Id) AS Com_Tr_Id,User_Id,Ticket_Id,Date_Time_Stamp,Ip_Address,Refer_To,Refer_From,Comments');
        $builder->where('Ticket_Id', $TicketId);
        $query = $builder->get();
        return $query->getResultArray();
    }

    public function Approve_Or_DisApproved_By_TeamLeader($TicketId,$User_Id,$Updation,$Ip_Address,$Refer_to,$StatusVal,$NAReason)
    {
        $parameter_compl_trans = array('User_Id'=>$User_Id,'Ticket_Id'=>$TicketId,'Date_Time_Stamp'=>$Updation,'Ip_Address'=>$Ip_Address,'Refer_To'=>$Refer_to,'Refer_From'=>$User_Id,
        'Comments' => $NAReason);

        $this->db->transBegin();

        $data = [
            'Complaint_Status' => $StatusVal,
            'Updation'  => $Updation
        ];
        $builder = $this->db->table('complaint');
        $builder->where('Ticket_Id', $TicketId);
        $builder->update($data);

        $parameter_compl_trans = $this->db->table('complaint_transaction')->insert($parameter_compl_trans);
        
        if($this->db->transStatus === FALSE)
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

    public function Show_Solved_Complaint_To_Admin()
    {
        $sql = "SELECT SNo,cmp.Ticket_Id,md.Dept_Name AS Department,ma.App_name Applications,Reason FROM complaint cmp
        INNER JOIN master_department md ON md.Dept_Id=cmp.Dept_Id
        LEFT JOIN master_application ma ON ma.App_Id=cmp.App_Id
        INNER JOIN complaint_transaction ct ON ct.Ticket_Id=cmp.Ticket_Id
        WHERE complaint_Status=6 AND ct.Refer_To=2
        ORDER BY  ct.Date_Time_Stamp DESC";
        $query = $this->db->query($sql);        
        return $query->getResultArray();
    }

    public function Get_UserID_of_Complaint($ticketId)
    {
        $builder = $this->db->table('complaint')->select('User_Id');
        $builder->where('Ticket_Id', $ticketId);
        $query = $builder->get();
        return $query->getResultArray();
    }

    public function Complaint_Solved($TicketId,$Updation,$StatusVal,$Ip_Address,$User_Id,$Refer_to)
    {
        $parameter_compl_trans = array('User_Id'=>$User_Id,'Ticket_Id'=>$TicketId,'Date_Time_Stamp'=>$Updation,'Ip_Address'=>$Ip_Address,'Refer_To'=>$Refer_to,'Refer_From'=>$User_Id);

        $this->db->transBegin();

        $data = [
            'Complaint_Status' => $StatusVal,
            'Updation'  => $Updation
        ];
        $builder = $this->db->table('complaint');
        $builder->where('Ticket_Id', $TicketId);
        $builder->update($data);

        $parameter_compl_trans = $this->db->table('complaint_transaction')->insert($parameter_compl_trans);
        
        if($this->db->transStatus === FALSE){
            $this->db->transRollback();
            return false;
        }
        else{
            $this->db->transCommit();
            return true;
        }
    }

}