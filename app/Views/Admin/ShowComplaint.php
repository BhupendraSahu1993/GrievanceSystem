<!-- page content -->
<div class="right_col" role="main">
    <div class="">
        <div class="page-title">
            <div class="title_left">
                <h3>Complaint <small>Show current complaint list</small></h3>
            </div>

            <div class="title_right">
                <div class="col-md-5 col-sm-5 col-xs-12 form-group pull-right top_search">
                    <div class="input-group">
                        <input type="text" class="form-control" placeholder="Search for...">
                        <span class="input-group-btn">
                            <button class="btn btn-secondary" type="button">Go!</button>
                        </span>
                    </div>
                </div>
            </div>
        </div>
        <?php $count=1; ?>
        <div class="clearfix"></div>
        <div class="row">
            <div class="col-md-12 col-sm-12 ">
                <div class="x_panel">
                    <div class="x_title">
                        <h2>Default Example <small>Users</small></h2>
                        <div class="clearfix"></div>
                    </div>
                    <div class="x_content">
                        <div class="row">
                            <div class="col-sm-12">
                                <div class="card-box table-responsive">
                                    <table id="datatable" class="table table-striped table-bordered" style="width:100%">
                                        <thead>
                                            <tr>
                                                <th>S.No.</th>
                                                <th>Ticket Id</th>
                                                <th>Issue Type</th>
                                                <th>Sub-Issue Type</th>
                                                <th>Application Name</th>
                                                <th>Reason</th>
                                                <th>Action</th>
                                            </tr>
                                        </thead>

                                        <tbody>
                                            <?php foreach($showComplaint as $item): ?>
                                               <!--?php var_dump($item["ApplicationName"]); exit; ?-->
                                            <tr>
                                                <td><?php echo $count; ?></td>
                                                <td class="TI"><?= $item['Ticket_Id'] ?></td>
                                                <td><?= $item['Issue'] ?></td>
                                                <td><?= $item['SubIssue'] ?></td>
                                                <td><?= $item['ApplicationName'] ?></td>                                                                                               
                                                <td><?= $item['Reason'] ?></td>                                                
                                                <td><input type="button" value="Take Decision" class="btn btn-primary btn-sm ShowModal" data-toggle="modal"
                                                    data-target=".bs-example-modal-md">
                                                </td> 
                                            </tr>
                                            <?php $count++; ?>
                                            <?php endforeach; ?>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- /page content -->

<!-- Small modal -->
<div class="modal fade bs-example-modal-md" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-md">
        <div class="modal-content">
            
            <!-- start form for validation -->
            <form id="acceptForm" action="<?php echo base_url('admin/updatecompstatus');?>" method="post" data-parsley-validate>
            <div class="modal-header">
                <h4 class="modal-title" id="myModalLabel2">Refer To</h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span
                        aria-hidden="true">×</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-md-12 col-md-12">
                        <div class="x_panel">
                            <div class="x_title">
                                <h2><small>Complaint refer to department by Admin</small></h2>
                                <div class="clearfix"></div>
                            </div>
                            <div class="x_content">                                    
                                <input type="hidden" name="TicketId" id="TicketId">
                                
                                <table class="table table-bordered imdvdoTable">
                                <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>Image Name</th>
                                        <th>Mime Type</th>
                                        <th>View Image</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <!-- By Jquery -->
                                </tbody>
                                </table>

                                <label for="Take_Action">Take Action *:</label>
                                <select id="Take_Action" name="Take_Action" class="form-control" required>
                                    <option value="0">Choose Action..</option>
                                    <option value="1">Accept</option>
                                    <option value="2">Reject</option>
                                </select>

                                <br class="Accept">
                                <label for="Issue_Situ" class="Accept">Issue Situation * :</label>
								<select id="Issue_Situ" name="Issue_Situ" class="form-control Accept" required>
									<option value="0">Choose Issue Situation..</option>
									<option value="1">Critical</option>
									<option value="2">Major</option>
									<option value="3">Minor</option>
                                </select>

                                <br class="Accept">
                                <label for="Dept_Id" class="Accept">Department *:</label>
                                <select id="Dept_Id" name="Dept_Id" class="form-control Accept" required>
                                    <option value="0">Choose Department..</option>
                                    <?php foreach($Department as $item): ?>
                                    <option value="<?= $item['Dept_Id'] ?>"><?= $item['Dept_Name'] ?></option>
                                    <?php endforeach; ?>
                                </select>

                                <br class="Reject">
                                <label for="rejectReason" class="Reject">Explain Problem *:</label>
                                <textarea name="rejectReason" id="rejectReason" cols="30" rows="5" class="form-control Reject" placeholder="Write reject reason here....."></textarea>
                                
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                <button type="submit" class="btn btn-primary">Refer Complaint</button>
            </div>
            </form>
            <!-- end form for validations -->

        </div>
    </div>
</div>
<!-- /modals -->

<script>
    $(document).ready(function () {
        $('.Accept').hide();
        $('.Reject').hide();
        $('.imdvdoTable').hide();
    });

    $('#Take_Action').change(function(){
        var Val = $('#Take_Action').val();
        if(Val == 1)
        {
            $('.Reject').hide();
            $('.Accept').show();
        }
        else if(Val == 2)
        {
            $('.Reject').show();
            $('.Accept').hide();
        }
        else
        {
            $('.Accept').hide();
            $('.Reject').hide();
        }
    });

    $('.ShowModal').click(function()
    {

        var $row = $(this).closest("tr"); // Finds the closest row <tr>
        $tds = $row.find("td"); // Finds all children <td> elements
        console.log($tds[1]);
        var $uf = $("#acceptForm");
        $uf.find('[id=TicketId]').val($tds[1].textContent);
        $uf.find('[id=ticket_Id]').val($tds[1].textContent);
        $uf.find('[id=issue_type]').val($tds[2].textContent);
        $uf.find('[id=sub_issue]').val($tds[3].textContent);
        $uf.find('[id=app_name]').val($tds[4].textContent);
        $uf.find('[id=reason]').val($tds[5].textContent);

        $.ajax({
            type: "GET",
            url: "showimagevideo",
            datatype: "json",
            data: {
                ticketId: $("#TicketId").val()
            },
            success: function(data)
            {
                var result = JSON.parse(data);
                var len = result.comFile.length;
                if(len > 0)
                {
                    $('.imdvdoTable').show();
                    var tbodyData = '';
                    $('.imdvdoTable tbody').empty();
                    var sno = 0;
                    for(var i=0; i <= result.comFile.length - 1; i++)
                    {
                        var filename = result.comFile[i].FileName;
                        console.log(filename);
                        var mime = filename.split('.');
                        var type = '';
                        var folder = '';
                        if(mime[1] == 'jpg' || mime[1] == 'jpeg' || mime[1] == 'gif' || mime[1] == 'bmp' || mime[1] == 'png')
                        {
                            type = "image/"+mime[1];
                            folder = "images";
                        }
                        else if(mime[1] == 'mp4' || mime[1] == 'mkv' || mime[1] == 'avi')
                        {
                            type = "video/"+mime[1];
                            folder = "videos";
                        }
                        sno++;
                        tbodyData += "<tr><td>"+ sno +"</td><td>"+ result.comFile[i].FileName +"</td><td>"+ type +"</td><td><a href='/uploads/"+ folder + "/" + result.comFile[i].FileName + "' target='_blank' class='font-weight-bold'>Click To View</a> </td><tr>";
                    }
                    $('.imdvdoTable tbody').append(tbodyData);
                }
                else
                {
                    $('.imdvdoTable').hide();
                }                
            }
        });
    });
</script>