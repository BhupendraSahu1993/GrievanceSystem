<!-- page content -->
<div class="right_col" role="main">
    <div class="">
        <div class="page-title">
            <div class="title_left">
                <h3>Registration Form</h3>
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
                        <h2>User Registration Form <small>User registration by Admin</small></h2>
                        <div class="clearfix"></div>
                    </div>
                    <div class="x_content">

                        <!-- start form for validation -->
                        <form id="demo-form" action="<?php echo base_url('admin/registeruser');?>" method="post" data-parsley-validate>
                            <div class="row">
                                <div class="col-md-4">
                                    <label for="Name">Full Name * :</label>
                                    <input type="text" id="Name" class="form-control" name="Name" required />
                                </div>

                                <div class="col-md-4">
                                    <label for="Mobile">Mobile Number * :</label>
                                    <input type="text" id="Mobile" class="form-control" name="Mobile" required />
                                </div>

                                <div class="col-md-4">
                                    <label for="Dept_Id">Department *:</label>
                                    <select id="Dept_Id" name="Dept_Id" class="form-control" required>
                                        <option value="0">Choose Department..</option>
                                        <?php foreach($Department as $item): ?>
                                        <option value="<?= $item['Dept_Id'] ?>"><?= $item['Dept_Name'] ?></option>
                                        <?php endforeach; ?>
                                    </select>
                                </div>
                            </div>
                            <br/>
                            <div class="row">
                                <div class="col-md-4">
                                    <label for="Desig_Id">Designation *:</label>
                                        <select id="Desig_Id" name="Desig_Id" class="form-control" required>
                                            <option value="0">Choose Designation..</option>
                                            <?php foreach($Designation as $item): ?>
                                            <option value="<?= $item['Desig_Id'] ?>"><?= $item['Desig_Name'] ?></option>
                                            <?php endforeach; ?>
                                        </select>
                                </div>

                                <div class="col-md-4">
                                    <label for="Role_Id">Role *:</label>
                                        <select id="Role_Id" name="Role_Id" class="form-control" required>
                                            <option value="0">Choose Role..</option>
                                            <?php foreach($Role as $item): ?>
                                            <option value="<?= $item['Role_Id'] ?>"><?= $item['Role_Name'] ?></option>
                                            <?php endforeach; ?>
                                        </select>
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