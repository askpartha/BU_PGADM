<div class="page-title">
	<h2>Post Graduate Subjects</h2>
	<ul class="breadcrumb">
		<li>You are here:</li>
		<li class="active">Master Data</li>
		<li class="">Post Graduate Subjects</li>
	</ul>
</div>	<!-- /heading -->

<div class="container-fluid">
	<div class="row">
		<div class="col-sm-8 data-content">
			<?php
				if($this->session->flashdata('success')) {
					echo "<div class='alert alert-success action-message'>" . $this->session->flashdata('success') . "</div>";
				} else if($this->session->flashdata('failure')) {
					echo "<div class='alert alert-danger action-message'>" . $this->session->flashdata('failure') . "</div>";
				}
			?>	
			<div class="box">
				<table class="wrl-table btm-mrgn-xs">
					<thead>
						<tr>
							<th style="width:5%;">Sl</th>
							<th style="width:15%;">Course</th>
							<th style="width:15%;">Subj. Code</th>
							<th style="width:28%;">Subject Name</th>
							<th style="width:12%;">Can Apply</th>
							<th style="width:7%;">Active</th>
							<th style="width:18%;">Action</th>
						</tr>
					</thead>
					<tbody id="tbl-content"></tbody>
				</table>
				<div class="paginator pull-right btm-mrgn-sm"></div>
			</div>	<!-- /box -->
		</div>
		
		<div class="col-sm-4">
			<div class="btm-mrg-sm"><a href="<?php echo $this->config->base_url();?>configs/pgugsubjects" class="btn btn-primary">Under Graduate Subject Association</a></div>
			<div class="box">
				<div class="title">
					<h3 class="addedit-label">Create Subject</h3>
				</div>
				<div class="content">	
					<?php
						$form = array(
										'class'	=>	'form-horizontal lft-pad-nm',
										'role'	=>	'form',
										'id' => 'addeditform'
									);	
						echo form_open('configs/createpgsubject', $form);
					?>
						<div class="form-group">
							<label>Course</label>
							<?php
								$course = 'id="subj_cors_code" class="col-xs-10 col-sm-10"';				
	
								echo form_dropdown('subj_cors_code', $course_options, null, $course)
							?>
						</div>
						
						<div class="form-group">
							<label>Subject</label>
							<?php
								$subj_code_data = 'id="subj_code" class="col-xs-10 col-sm-10"';				
	
								echo form_dropdown('subj_code', $subject_options, null, $subj_code_data)
							?>
						</div>
						
						<div class="form-group">
							<input type="checkbox" name="subj_can_apply" id="subj_can_apply" class=""/>&nbsp;Can Apply&nbsp;&nbsp;&nbsp;
							<input type="checkbox" name="subj_is_active" id="subj_is_active" class=""/>&nbsp;Active
						</div>
						
						<div class="form-group">
							<button class="btn btn-primary addedit-btn" type="button">Save</button>
							<button type="button" class="btn btn-default cancel-btn">Cancel</button>
						</div>	
						
						<input type="hidden" name="record_id" id="record_id">
						<input type="hidden" name="form_action" id="form_action" value="add">
					<?php	
						echo form_close();
					?>	
				</div>
			</div>	
		</div>
		
		
	</div>
</div>

<?php
	$this->load->view('footer');
?>		

<script type="text/javascript">
var pg_subjects = '<?php echo json_encode($pg_subjects);?>';
var pg_subjects_data = jQuery.parseJSON(pg_subjects);

$(document).ready(function() {
	printAllSubjects(pg_subjects_data);
});	

function printAllSubjects(arr) {
	console.log(arr);
	var s = "";
	if(arr.length > 0) {
			for(var i=0; i<arr.length; i++) {
				var can_apply = (arr[i].subj_can_apply == "1") ? "<i class='fa fa-check green-text'></i>" : "<i class='fa fa-times red-text'></i>";
				var is_active = (arr[i].subj_is_active == "1") ? "<i class='fa fa-check green-text'></i>" : "<i class='fa fa-times red-text'></i>";
				s += "<tr>";
				s += "<td>" + (i+1) + "</td>";
				s += "<td>" + arr[i].cors_name + "</td>";
				s += "<td>" + arr[i].subj_code + "</td>";
				s += "<td>" + arr[i].subj_name + "</td>";
				s += "<td style='text-align:center;'>" + can_apply + "</td>";
				s += "<td style='text-align:center;'>" + is_active + "</td>";
				s += "<td class='text-center'>"
				s += "<a href='javascript:void(0);' id='edit_" + i + "' class='btn btn-primary btn-xs edit-record'>Edit</a>&nbsp;&nbsp;";
				s += "<a href='javascript:void(0);' id='del_" + i + "' class='btn btn-danger btn-xs delete-record'>Delete</a>";
				s += "</td>";
				s += "</tr>"
			}
		}else {
	
		s += '<tr><td colspan="100%"><h3 class="top-mrgn-sm btm-mrgn-sm">No data available</h3></td></tr>';
	}
	$('#tbl-content').html(s);
}

//edit record
$(document).on('click','.edit-record',function() {
	var arr = $(this).attr('id').split("_");
	var index = arr[1];
	$('.addedit-label').html('Edit Subject');
	$('#subj_cors_code').val(pg_subjects_data[index].subj_cors_code);
	//$('#subj_code').val(pg_subjects_data[index].subj_code);
	$('#subj_code').val(pg_subjects_data[index].subj_code);
	if(pg_subjects_data[index].subj_can_apply == "1") {
		$('#subj_can_apply').prop('checked', true);
	} else {
		$('#subj_can_apply').prop('checked', false);
	}
	if(pg_subjects_data[index].subj_is_active == "1") {
		$('#subj_is_active').prop('checked', true);
	} else {
		$('#subj_is_active').prop('checked', false);
	}
	$('#record_id').val(pg_subjects_data[index].subj_id);
	$('#form_action').val('edit');
});

$(document).on('click','.delete-record',function() {
	var arr = $(this).attr('id').split("_");
	var index = arr[1];
	var subj_id = pg_subjects_data[index].subj_id;
	var params = "id="+subj_id;			
	var loadUrl = "<?php echo $this->config->base_url();?>configs/delpgsubject/"+new Date().getTime();
	
	jConfirm('Are you sure want to delete?', 'Please Confirm', function(e) {
		if (e) {	
			$.ajax({
			    type: "POST",
			    url: loadUrl,
			    data: params,
			    success: function(res){
			    	if(res == 'DELETED') {
						$.ajax({
								url: "<?php echo $this->config->base_url();?>configs/loadpgsubjects",
								type: "post",
								dataType: "json",
								success: function(response){
													//show message
													printAllSubjects(response);
													subjects_data = response;
													
													$('.action-message').remove();
													$('<div>').attr({
													    class: 'alert alert-success action-message'
													}).html('Record deleted succesfully').prependTo('.data-content');
					
												 }
							});
						
						
						
			    	}
			    }
			});    		
		}
	});	
	
});	

//cancel action
$(document).on('click','.cancel-btn',function() {
	$('.addedit-label').html('Create Subject');
	$('#form_action').val('add');
	$('#subj_cors_code').val('');
	//$('#subj_code').val('');
	$('#subj_code').val('');
	$('#subj_can_apply').prop('checked', false);
	$('#subj_is_active').prop('checked', false);
	$('#record_id').val(0);
});

//validates form
$(document).on('click','.addedit-btn',function() {
	$('.error-msg').remove();
	$('input').removeClass('form-error');
	$('select').removeClass('form-error');
	
	var subj_cors_code = $('#subj_cors_code').val();
	//var subj_code = $('#subj_code').val();
	var subj_code = $('#subj_code').val();
	
	var error = false;
	var msg = "<h4><strong>Ohh!</strong> Change a few things up and try submitting again.</h4>";
	
	if(subj_cors_code == 'EMPTY') {
		error = true;
		$('#subj_cors_code').addClass('form-error');
	}
	if(subj_code == 'EMPTY') {
		error = true;
		$('#subj_code').addClass('form-error');
	}
	
	if(error) {
		$('#addeditform').before("<div class='error-msg'></div>");
		$('.error-msg').html(msg);
		return false;
	} else {
		$('#addeditform').submit();
	}
});	
</script>