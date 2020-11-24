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
                                                <th>Department</th>
                                                <th>Application</th>
                                                <th>Reason</th>
                                                <th>Explanation</th>
                                                <th>Action</th>
                                            </tr>
                                        </thead>
                                        <?php $count=1;?>
                                        <tbody>
                                            <?php foreach($showComplaint as $item): ?>
                                            <tr>
                                                <td><?php echo $count; ?></td>
                                                <td class="TI"><?= $item['Ticket_Id'] ?></td>
                                                <td><?= $item['Department'] ?></td>
                                                <td><?= $item['Application'] ?></td>
                                                <td><?= $item['Reason'] ?></td>
                                                <td><?= $item['Explanation'] ?></td>
                                                <td><input type="button" value="Complaint Solved"
                                                        class="btn btn-primary btn-sm complaintSolved" data-toggle="modal"
                                                        data-target=".bs-example-modal-md">
                                                    </td>
                                            </tr>
                                            <?php $count++; endforeach; ?>
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
            <form id="solvedComplaint" action="<?php echo base_url('department/complaintsolved');?>" method="post" data-parsley-validate>
            <div class="modal-header">
                <h4 class="modal-title" id="myModalLabel2">Complaint Solved</h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span
                        aria-hidden="true">×</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-md-12 col-md-12">
                        <div class="x_panel">
                            <div class="x_title">
                                <h2><small>Write what you do to solve the problem</small></h2>
                                <div class="clearfix"></div>
                            </div>
                            <div class="x_content">

                                    <input type="hidden" name="TicketId" id="TicketId">
                                    <div style=" height: 150px;  overflow-y: scroll;">
                                        <table class="table table-bordered imdvdoTable" >
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
                                    </div>
                                    
                                    <label for="Team_Leader_Id">Team Member *:</label>
                                    <select id="Team_Leader_Id" name="Team_Leader_Id" class="form-control" required>
                                       <!-- By Jquery -->
                                    </select>
                                    <br />
                                    <label for="ProbSol">Description *:</label>
                                    <textarea name="ProbSol" id="ProbSol" cols="30" rows="5" class="form-control" placeholder="Write explanation here....."></textarea>
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
    
    });

    $('.complaintSolved').click(function () {
        var $row = $(this).closest("tr"); // Finds the closest row <tr>
        $tds = $row.find("td"); // Finds all children <td> elements
        console.log($tds[1]);
        var $uf = $("#solvedComplaint");
        $uf.find('[id=TicketId]').val($tds[1].textContent);

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

        $.ajax({
            type: "GET",
            url: "/department/getteamleader",
            datatype: "json",
            data: {
                ticketId: $("#TicketId").val()
            },
            success: function(data)
            {
                var result = JSON.parse(data);   
                console.log(result);
                if(result.status == 200)
                {
                    var options = '';
                    $("#Team_Leader_Id").empty();
                    options += '<option value="0">Choose Team Member..</option>';
                    // for (var i = 0; i < data.teamLeader.length; i++) {
                        options += '<option value="' + result.Refer_from + '">' + result.U_Name + '</option>';
                    // }
                    $("#Team_Leader_Id").append(options);
                }
                else
                {
                    alert('No data found.......');
                }
                
            }            
        });
    });

    
</script>