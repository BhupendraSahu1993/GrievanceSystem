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
                                                <!-- <th>Solution</th> -->
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
                                                <td><?= $item['Applications'] ?></td>
                                                <td><?= $item['Reason'] ?></td>
                                                <td><?= $item['Solution'] ?></td>
                                                <!-- <td><!-?= $item['Solution'] ?></td> -->
                                                <td><input type="button" value="Take"
                                                        class="btn btn-primary btn-sm takeDecision" data-toggle="modal"
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
            <form id="takeDecisionOnSolvedComplaint" action="<?php echo base_url('department/takedecionsolcomp');?>" method="post" data-parsley-validate>
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
                                    <label for="Decision">Team Member *:</label>
                                    <select id="Decision" name="Decision" class="form-control" required>
                                       <option value="0">Choose Your Decision..</option>
                                       <option value="1">Solution Approved</option>
                                       <option value="2">Solution Not Approved</option>
                                    </select>
                                    <br class="CompDesc" />
                                    <label for="notAppReason" class="CompDesc">Description *:</label>
                                    <textarea name="notAppReason" id="notAppReason" cols="30" rows="5" class="form-control CompDesc" placeholder="Why not approved....."></textarea>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                <button type="submit" class="btn btn-primary">Take Decision</button>
            </div>
            </form>
            <!-- end form for validations -->

        </div>
    </div>
</div>
<!-- /modals -->

<script>
    $(document).ready(function () {
        $('.CompDesc').hide();
    });

    $('#Decision').click(function () {
        if($('#Decision').val() == 2)
        {
            $('.CompDesc').show();
        }
        else{
            $('.CompDesc').hide();
        }
    });

    $('.takeDecision').click(function(){
        var $row = $(this).closest("tr"); // Finds the closest row <tr>
        $tds = $row.find("td"); // Finds all children <td> elements
        console.log($tds[1]);
        var $uf = $("#takeDecisionOnSolvedComplaint");
        $uf.find('[id=TicketId]').val($tds[1].textContent);
    });
    
</script>