<!-- page content -->
<div class="right_col" role="main">
    <div class="">
        <div class="page-title">
            <div class="title_left">
                <h3>Complaint <small>Show your complaint Status</small></h3>
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
                                <?php $count=1;?>
                                <div class="card-box table-responsive">
                                    <table id="datatable" class="table table-striped table-bordered" style="width:100%">
                                        <thead>
                                            <tr>
                                                <th>S.No.</th>
                                                <th>Ticket Id</th>
                                                <th>Department</th>
                                                <th>Reason</th>
                                                <td hidden>Case Status</td>
                                                <th>Status</th>
                                            </tr>
                                        </thead>

                                        <tbody>
                                            <?php foreach($ShowComplaint as $item): ?>
                                            <tr>
                                                <td><?php echo $count; ?></td>
                                                <td class="TI"><?= $item['Ticket_Id'] ?></td>
                                                <td><?= $item['Department'] ?></td>
                                                <td><?= $item['Reason'] ?></td>
                                                <td hidden><?= $item['Complaint_Status'] ?></td>

                                                <?php if($item['Complaint_Status'] == 7){?>
                                                <td class="text-success text-uppercase"><b><?= $item['CaseStatus']?></b></td>

                                                <?php }elseif($item['Complaint_Status'] == 3 || $item['Complaint_Status'] == 4 || $item['Complaint_Status'] == 6){?>
                                                <td class="text-warning text-uppercase"><b><?= $item['CaseStatus']?></b></td>

                                                <?php }elseif($item['Complaint_Status'] == 2){?>
                                                <td class="text-primary text-uppercase"><b><?= $item['CaseStatus']?></b></td>

                                                <?php }elseif($item['Complaint_Status'] == 1){?>
                                                <td class="text-muted text-uppercase"><b><?= $item['CaseStatus']?></b></td>

                                                <?php }elseif($item['Complaint_Status'] == 5){?>
                                                <td class="text-danger text-uppercase"><b><?= $item['CaseStatus']?></b></td>

                                                <?php } ?>
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

<script>
    $(document).ready(function(){

    });
</script>