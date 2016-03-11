<div class="page-title">
	<h2>Examination Scheduling</h2>
	<ul class="breadcrumb">
		<li>You are here:</li>
		<li class="active">Configs</li>
		<li class="">Examination Scheduling</li>
	</ul>
</div>	<!-- /heading -->

<div class="container-fluid">
	
	<div class="row">
		
		<div class="col-sm-7 data-content">
			<?php
				if($this->session->flashdata('success')) {
					echo "<div class='alert alert-success action-message'>" . $this->session->flashdata('success') . "</div>";
				} else if($this->session->flashdata('failure')) {
					echo "<div class='alert alert-danger action-message'>" . $this->session->flashdata('failure') . "</div>";
				}
			?>	
			<div class="box">
				<table class="wrl-table btm-mrgn-sm">
					<thead>
						<tr>
							<th style="width:5%;">Sl</th>
							<th style="width:10%;">Date</th>
							<th style="width:10%;">Start Time</th>
							<th style="width:10%;">End Time</th>
							<th style="width:7%;">Active</th>
							<th style="width:18%;">Action</th>
						</tr>
					</thead>
					<tbody id="tbl-content"></tbody>
				</table>
				<div class="paginator pull-right btm-mrgn-sm"></div>
			</div>	<!-- /box -->
		</div>
	
		<div class="col-sm-5">
			<div class="box">
				<div class="title">
					<h3 class="addedit-label">Exam Scheduling</h3>
				</div>
				
				<?php
					$form = array(
									'class'	=>	'form-horizontal lft-pad-nm',
									'role'	=>	'form',
									'id' => 'addeditform'
								);	
					echo form_open('configs/createexamination', $form);
				?>
					<div class="row">
						<div class="form-group col-sm-6">
							<label>Date of Exam</label>
							<?php
								$exam_date_data = array(
					              					'name'        	=> 'exam_date',
													'id'          	=> 'exam_date',
													'value'       	=> '',
													'placeholder'	=> '',
													'class'			=>	'col-xs-8 col-sm-8 future-datepicker'
					            				);
	
								echo form_input($exam_date_data);
							?>
						</div>
					</div>
					<div class="row">	
						<div class="form-group col-sm-6">
							<label>Start Time</label>
							<?php
								$exam_start_time_data = array(
					              					'name'        	=> 'exam_start_time',
													'id'          	=> 'exam_start_time',
													'value'       	=> '',
													'maxlength'     => '10',
													'placeholder'	=> '',
													'class'			=>	'col-xs-11 col-sm-11'
					            				);
	
								echo form_input($exam_start_time_data);
							?>
						</div>
						<div class="form-group col-sm-6">
							<label>End Time</label>
							<?php
								$exam_end_time_data = array(
					              					'name'        	=> 'exam_end_time',
													'id'          	=> 'exam_end_time',
													'value'       	=> '',
													'maxlength'     => '10',
													'placeholder'	=> '',
													'class'			=>	'col-xs-11 col-sm-11'
					            				);
	
								echo form_input($exam_end_time_data);
							?>
						</div>
					</div>

					<div class="row">
						<div class="form-group col-sm-6">
							<input type="checkbox" name="exam_is_active" id="exam_is_active" class=""/>&nbsp;Active
						</div>
					</div>
					<div class="row">	
						<div class="form-group col-sm-12">
							<!--<button class="btn btn-info search-btn" type="button">Search</button> &nbsp;-->
							<button class="btn btn-primary addedit-btn" type="button">Save</button> &nbsp;
							<button type="button" class="btn btn-default cancel-btn">Cancel</button> &nbsp;
						</div>	
						
						<input type="hidden" name="record_id" id="record_id">
						<input type="hidden" name="form_action" id="form_action" value="add">
						
				</div>
				<?php	
					echo form_close();
				?>
			</div>	
		</div>
	</div>
	
</div>

<?php
	$this->load->view('footer');
?>		

<script type="text/javascript">
var examinations = '<?php echo json_encode($examinations);?>';
var examinations_data = jQuery.parseJSON(examinations);

$(document).ready(function() {
	printAllSubjects(examinations_data);
});	

function printAllSubjects(arr) {
	console.log(arr);
	var s = "";
	if(arr.length > 0) {
			for(var i=0; i<arr.length; i++) {
				var is_active = (arr[i].exam_is_active == "1") ? "<i class='fa fa-check green-text'></i>" : "<i class='fa fa-times red-text'></i>";
				s += "<tr>";
				s += "<td>" + (i+1) + "</td>";
				s += "<td>" + arr[i].exam_date + "</td>";
				s += "<td>" + arr[i].exam_start_time + "</td>";
				s += "<td>" + arr[i].exam_end_time + "</td>";
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
	$('#exam_date').val(examinations_data[index].exam_date);
	$('#exam_start_time').val(examinations_data[index].exam_start_time);
	$('#exam_end_time').val(examinations_data[index].exam_end_time);
	
	if(examinations_data[index].exam_is_active == "1") {
		$('#exam_is_active').prop('checked', true);
	} else {
		$('#exam_is_active').prop('checked', false);
	}
	$('#record_id').val(examinations_data[index].exam_id);
	$('#form_action').val('edit');
});

var halls_data = "";


$(document).on('click','.delete-record',function() {
	var arr = $(this).attr('id').split("_");
	var index = arr[1];
	var exam_id = examinations_data[index].exam_id;
	var params = "id="+exam_id;			
	var loadUrl = "<?php echo $this->config->base_url();?>configs/delexamination/"+new Date().getTime();
	
	jConfirm('Are you sure want to delete?', 'Please Confirm', function(e) {
		if (e) {	
			$.ajax({
			    type: "POST",
			    url: loadUrl,
			    data: params,
			    dataType: "html",
			    success: function(res){
			    	if(res.trim() == 'DELETED') {
						$.ajax({
							url: "<?php echo $this->config->base_url();?>configs/loadexaminations",
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


//search record
$(document).on('click','.search-btn',function() {
	var exam_subject = $("#exam_subject").val();
	if(exam_subject == "EMPTY" || exam_subject == '' || exam_subject=='undefined' ){
		exam_subject = null;
	}
	var hall_id = $("#hall_id").val();
	if(hall_id == "EMPTY" || hall_id == '' || hall_id=='undefined' ){
		hall_id = null;
	}

	var params = "exam_subject="+exam_subject+"&hall_id="+hall_id;			
	
	$.ajax({
		url: "<?php echo $this->config->base_url();?>configs/loadsearchexaminations",
		type: "post",
		data: params,
		dataType: "json",
		success: function(response){
				//show message
				printAllSubjects(response);
				subjects_data = response;
			 }
		});
	
});	

//cancel action
$(document).on('click','.cancel-btn',function() {
	onload();	
});

//validates form
$(document).on('click','.addedit-btn',function() {
	$('.error-msg').remove();
	$('input').removeClass('form-error');
	$('select').removeClass('form-error');
	
	var exam_date = $('#exam_date').val();
	var exam_start_time = $('#exam_start_time').val();
	var exam_end_time = $('#exam_end_time').val();
	var error = false;
	var msg = "<h4><strong>Ohh!</strong> Change a few things up and try submitting again.</h4>";
	
	if(exam_date == '') {
		error = true;
		$('#exam_date').addClass('form-error');
	}
	if(exam_start_time == '') {
		error = true;
		$('#exam_start_time').addClass('form-error');
	}
	if(exam_end_time == '') {
		error = true;
		$('#exam_end_time').addClass('form-error');
	}
	
	
	if(error) {
		$('#addeditform').before("<div class='error-msg'></div>");
		$('.error-msg').html(msg);
		return false;
	} else {
		$('#addeditform').submit();
	}
});	

function onload(){
	$('.addedit-label').html('Create Subject');
	$('#form_action').val('add');
	$("#exam_date").val('');
	$("#exam_start_time").val('');
	$("#exam_end_time").val('');
	$('#exam_is_active').prop('checked', false);
	$('#record_id').val(0);
}
</script>