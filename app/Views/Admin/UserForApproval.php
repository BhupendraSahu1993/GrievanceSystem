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
                                                <th hidden>User Id</th>
                                                <th>Name</th>
                                                <th>Mobile</th>
                                                <th>Gender</th>
                                                <th>Department</th>
                                                <th>Role</th>
                                                <th>Designation</th>
                                                <th>Address</th>
                                                <th>Action</th>
                                            </tr>
                                        </thead>

                                        <tbody>
                                            <?php foreach($Users as $item): ?>
                                            <tr>
                                                <td><?php echo $count; ?></td>
                                                <td hidden><?= $item['UserId'] ?></td>
                                                <td><?= $item['UName'] ?></td>
                                                <td><?= $item['Mobile'] ?></td>
                                                <td><?= $item['Gender'] ?></td>
                                                <td><?= $item['Department'] ?></td>
                                                <td><?= $item['Role'] ?></td>
                                                <td><?= $item['Designation'] ?></td>
                                                <td><?= $item['Address'] ?></td>
                                                <td><input type="button" value="Take Decision"
                                                        class="btn btn-primary btn-sm TakeDecision" data-toggle="modal"
                                                        data-target=".bs-example-modal-md">
                                                    <!-- OR&nbsp;&nbsp; <input type="button" id="Reject" value="Reject"
                                                        class="btn btn-danger btn-sm">-->
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
            <form id="decisionForm" action="<?php echo base_url('admin/decisiononuser');?>" method="post" data-parsley-validate>
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
                                    
                                    <input type="hidden" name="User_Id" id="User_Id">

                                    <label for="Take_Action">Take Decision *:</label>
                                    <select id="Take_Action" name="Take_Action" class="form-control" required>
                                        <option value="0">Choose Your Decision..</option>
                                        <option value="1">Approve</option>
                                        <option value="2">Refuse</option>
                                    </select>
                                    <br class="refReson">
                                    <label for="refuseReason" class="refReson">Reason *:</label>
                                    <textarea name="refuseReason" id="refuseReason" cols="30" rows="5" class="form-control refReson" placeholder="Write refuse reason here....."></textarea>
                                
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                <button type="submit" class="btn btn-primary">Submit</button>
            </div>
            </form>
            <!-- end form for validations -->

        </div>
    </div>
</div>
<!-- /modals -->

<script>
    $(document).ready(function () {
        $('.refReson').hide();
    });

    $('.TakeDecision').click(function () {
        var $row = $(this).closest("tr"); // Finds the closest row <tr>
        $tds = $row.find("td"); // Finds all children <td> elements
        console.log($tds[1]);
        var $uf = $("#decisionForm");
        $uf.find('[id=User_Id]').val($tds[1].textContent);
    });

    $('#Take_Action').change(function(){
        var Val = $('#Take_Action').val();
        if(Val == 1)
        {
            $('.refReson').hide();
            $('.Dept').show();
        }
        else if(Val == 2)
        {
            $('.refReson').show();
            $('.Dept').hide();
        }
        else
        {
            $('.Dept').hide();
            $('.rejReson').hide();
        }
    });

</script>