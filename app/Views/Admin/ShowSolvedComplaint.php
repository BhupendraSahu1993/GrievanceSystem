<!-- page content -->
<div class="right_col" role="main">
    <div class="">
        <div class="page-title">
            <div class="title_left">
                <h3>Complaint <small>Show solved complaint list</small></h3>
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
                                                <th>Action</th>
                                            </tr>
                                        </thead>
                                        <?php $count=1;?>
                                        <tbody>
                                            <?php foreach($SolvedComplaint as $item): ?>
                                            <tr>
                                                <td><?php echo $count; ?></td>
                                                <td class="TI"><?= $item['Ticket_Id'] ?></td>
                                                <td><?= $item['Department'] ?></td>
                                                <td><?= $item['Applications'] ?></td>
                                                <td><?= $item['Reason'] ?></td>
                                                <td><input type="button" value="Send to User"
                                                        class="btn btn-primary btn-sm takeDecision">
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

<script>
    $(document).ready(function () {
        
    });

    $('.takeDecision').click(function(){
        var $row = $(this).closest("tr"); // Finds the closest row <tr>
        $tds = $row.find("td"); // Finds all children <td> elements
        var ticket_Id = $tds[1].textContent;
        console.log($tds[1], ticket_Id);

        $.ajax({
            type: "GET",
            url: "/admin/solcompsendtousr",
            datatype: "json",
            data: {
                ticketId: ticket_Id
            },
            success: function(data)
            {
                var result = JSON.parse(data);   
                console.log(result);
                if(result.status == 200)
                {
                    alert(result.Message);
                    location.reload();
                }
                else
                {
                    alert('No data found.......');
                }
            }            
        });
    });
    
</script>