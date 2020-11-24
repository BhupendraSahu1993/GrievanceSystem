<!-- page content -->
<div class="right_col" role="main">
	<div class="">
		<div class="page-title">
			<div class="title_left">
				<h3>Complaint</h3>
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

		<?php if (session('msg')) : ?>
		<div class="alert alert-info alert-dismissible">
			<?= session('msg') ?>
			<button type="button" class="close" data-dismiss="alert"><span>×</span></button>
		</div>
		<?php endif ?>
		<div class="x_panel">
			<div class="x_title">
				<h2>Complaint Form <small>submit your complaint here</small></h2>
				<div class="clearfix"></div>
			</div>
			<div class="x_content">

				<!-- start form for validation UserController/submit_complaint-->
				<form id="demo-form" action="<?php echo base_url('user/submit_complaint');?>" method="post"
					enctype="multipart/form-data" data-parsley-validate>
					<div class="row">
						<div class="col-md-4">
							<div class="form-group">
								<label for="Issue_Type">Type of Issue * :</label>
								<select id="Issue_Type" name="Issue_Type" class="form-control" required>
									<option value="">-- Select Issue Type --</option>
									<?php foreach($Issue_Type as $item): ?>
									<option value="<?= $item['IssueId'] ?>"><?= $item['IssueName'] ?></option>
									<?php endforeach; ?>
								</select>
							</div>
						</div>

						<div class="col-md-4 TI">
							<div class="form-group">
								<label for="Sub_Issue_Type">Sub-Issue Type * :</label>
								<select id="Sub_Issue_Type" name="Sub_Issue_Type" class="form-control" required>
									<option value="">-- Select Sub-Issue Type --</option>
									<!-- Through Jquery -->
								</select>
							</div>
						</div>

						<div class="col-md-4 APP">
							<div class="form-group">
								<label for="App_Id">Application * :</label>
								<select id="App_Id" name="App_Id" class="form-control">
									<option value="">-- Select Aplication --</option>
									<?php foreach($Application as $item): ?>
									<option value="<?= $item['App_Id'] ?>"><?= $item['App_Name'] ?></option>
									<?php endforeach; ?>
								</select>
							</div>
						</div>

						<div class="col-md-4">
							<label for="ImgVdoUpd">You want to upload Image or Video * :</label>
							<select id="ImgVdoUpd" name="ImgVdoUpd" class="form-control" required>
								<option value="">-- Select Option --</option>
								<option value="1">Yes</option>
								<option value="2">No</option>
							</select>
						</div>

						<div class="col-md-4 uplImgSel">
							<label for="ImgVdoSelect">Type of File * :</label>
							<select id="ImgVdoSelect" name="ImgVdoSelect" class="form-control">
								<option value="">-- Select Option --</option>
								<option value="1">Image</option>
								<option value="2">Video</option>
							</select>
						</div>

						<div class="col-md-4 uplImg">
							<div class="form-group">
								<label for="upl_Img">Select Image * : [<span style="color:red;">Select one or more files to upload</span>]</label>
								<input type="file" id="upl_Img" Name="upl_Img[]" class="form-control" multiple>
								<span id="spnmsg" class="spnmsg" style="color:red;"></span>
							</div>
						</div>

						<div class="col-md-4 uplVdo">
							<div class="form-group">
								<label for="upl_Vdo">Select Video * :</label>
								<input type="file" id="upl_Vdo" Name="upl_Vdo" class="form-control">
								<span class="spnmsg" style="color:red;"></span>
							</div>
						</div>

					</div>

					<div class="row">
						<div class="col-md-12">
							<div class="form-group">
								<label for="message">Complaint Reason * :</label>
								<textarea id="Reason" name="Reason" class="form-control" name="message"
									data-parsley-trigger="keyup" data-parsley-minlength="20"
									data-parsley-maxlength="100"
									data-parsley-minlength-message="Write the complaint reason"
									data-parsley-validation-threshold="10" required></textarea>
							</div>
						</div>
					</div>

					<div class="ln_solid"></div>
					<div class="item form-group">
						<button class="btn btn-primary" type="reset">Reset</button>
						<button type="submit" class="btn btn-success" id="submitForm">Submit</button>
					</div>

				</form>
				<!-- end form for validations -->

			</div>
		</div>
	</div>
</div>
<!-- /page content -->

<script>
	$(document).ready(function () {
		$('.APP').hide();
		$('.uplImg').hide();
		$('.uplVdo').hide();
		$('.uplImgSel').hide();
	});

	$('#ImgVdoUpd').change(function(){
		if($(this).val() == 1)
		{
			$('#ImgVdoSelect').attr('required', true);
		}
	});

	$('#ImgVdoSelect').change(function(){
		// alert($(this).val());
		if($(this).val() == 1)
		{
			$('#upl_Img').attr('required', true);
		}
		else if($(this).val() == 2)
		{
			$('#upl_Vdo').attr('required', true);
		}
		else
		{

		}
	});

	$('#ImgVdoUpd').click(function () {
		if ($(this).val() == 1) {
			$('.uplImgSel').show();
		} else if ($(this).val() == 2) {
			$('.uplImgSel').hide();
			$('.uplImg').hide();
			$('.uplVdo').hide();
		} else {
			$('.uplImgSel').hide();
			$('.uplImg').hide();
			$('.uplVdo').hide();
		}
	});

	$('#ImgVdoSelect').click(function () {
		if ($(this).val() == 1) {
			$('.uplImg').show();
			$('.uplVdo').hide();
		} else if ($(this).val() == 2) {
			$('.uplVdo').show();
			$('.uplImg').hide();
		} else {
			$('.uplImg').hide();
			$('.uplVdo').hide();
		}
	});

	$('#Sub_Issue_Type').click(function () {
		var TechIss = $(this).val();
		if (TechIss == 2) {
			$('.APP').show();
		} else {
			$('.APP').hide();
		}
	});

	$('#Issue_Type').change(function () {
		$.ajax({
			type: "GET",
			url: "/user/subissuetype",
			datatype: "JSON",
			data: {
				typeofIssue: $(this).val()
			},
			success: function (data) {
				var result = JSON.parse(data);
				var options = '';
				$("#Sub_Issue_Type").empty();
				options += '<option value="">-- Select Sub-Issue Type --</option>';
				for (var i = 0; i < result.SubIssueType.length; i++) {
					options += '<option value="' + result.SubIssueType[i].SubIssueId + '">' + result
						.SubIssueType[i].SubIssueName + '</option>';
				}
				$("#Sub_Issue_Type").append(options);
			}
		});
	});

	$("form").submit(function () {
		if ($('#ImgVdoSelect').val() == 1) 
		{
			//Validation of Client Side For Image Upload
			var img = $('#upl_Img').val();

			if (img != '') 
			{
				// Get uploaded file extension
				var extension = $('#upl_Img').val().split('.').pop().toLowerCase();

				// Create array with the files extensions that we wish to upload
				var validFileExtensions = ['jpeg', 'jpg', 'png', 'gif', 'bmp'];

				//Check file extension in the array.if -1 that means the file extension is not in the list.
				if ($.inArray(extension, validFileExtensions) == -1) {
					$('.spnmsg').text("Failed!! Please upload jpg, jpeg, png, gif, bmp file only.").show();

					// Clear fileuload control selected file
					$('#upl_Img').replaceWith($('#upl_Img').val('').clone(true));

					//Disable Submit Button
					$('#btnSubmit').prop('disabled', true);
				} else {
					// Check and restrict the file size to 32 KB.32768
					if ($('#upl_Img').get(0).files[0].size > (1048576)) {
						$('.spnmsg').text("Failed!! Max allowed file size is 32 kb").show();

						// Clear fileuload control selected file
						$('#upl_Img').replaceWith($('#upl_Img').val('').clone(true));

						//Disable Submit Button
						$('#btnSubmit').prop('disabled', true);
					} else {
						//Clear and Hide message span
						$('.spnmsg').text('').hide();

						//Enable Submit Button
						$('#btnSubmit').prop('disabled', false);
					}
				}
			}
			else
			{
				// $('.spnmsg').text('Select image to upload.').show();
			}
		}
		else if($('#ImgVdoSelect').val() == 2)
		{
			//Validation of Client Side For Image Upload
			var vdo = $('#upl_Vdo').val();

			if(vdo != '')
			{

			}
			else
			{
				$('.spnmsg').text('Select video to upload.').show();
			}
		}
	});
</script>