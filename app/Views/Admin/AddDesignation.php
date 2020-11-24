<!-- page content -->
<div class="right_col" role="main">
    <div class="">
        <div class="page-title">
            <div class="title_left">
                <h3>Designation Form</h3>
            </div>

            <div class="title_right">
                <div class="col-md-5 col-sm-5  form-group pull-right top_search">
                    <div class="input-group">
                        <input type="text" class="form-control" placeholder="Search for...">
                        <span class="input-group-btn">
                            <button class="btn btn-default" type="button">Go!</button>
                        </span>
                    </div>
                </div>
            </div>
        </div>
        <div class="clearfix"></div>
        <div class="row">
            <div class="col-md-12 col-md-12">
                <div class="x_panel">
                    <div class="x_title">
                        <h2>Add Designation Form <small>Add designation by Admin</small></h2>
                        <div class="clearfix"></div>
                    </div>
                    <div class="x_content">

                        <!-- start form for validation -->
                        <form id="demo-form" action="<?php echo base_url('admin/insertdesignation');?>" method="post" data-parsley-validate>
                            <div class="row">
                            <div class="col-md-6">
                                    <label for="Dept_Id">Department *:</label>
                                    <select id="Dept_Id" name="Dept_Id" class="form-control" required>
                                        <option value="0">Choose Department..</option>
                                        <?php foreach($Department as $item): ?>
                                        <option value="<?= $item['Dept_Id'] ?>"><?= $item['Dept_Name'] ?></option>
                                        <?php endforeach; ?>
                                    </select>
                                </div>

                                <div class="col-md-6">
                                    <label for="Desig_Name">Designation * :</label>
                                    <input type="text" id="Desig_Name" class="form-control" name="Desig_Name" required />
                                </div>                                
                            </div>
                            <br />
                            <input type="submit" class="btn btn-primary" value="Register">
                        </form>
                        <!-- end form for validations -->
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>