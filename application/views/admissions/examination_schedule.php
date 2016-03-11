<div class="page-title">
	<h2>Examination Scheduling</h2>
	<ul class="breadcrumb">
		<li>You are here:</li>
		<li class="active">Admission</li>
		<li class="">Examination Scheduling</li>
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
				<table class="wrl-table btm-mrgn-sm">
					<thead>
						<tr>
							<th style="width:5%;">Sl</th>
							<th style="width:10%;">Subject</th>
							<th style="width:30%;">Examination Date & Time</th>
							<th style="width:15%;">Hall Name</th>
							<th style="width:13%;">No of Seat</th>
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
					echo form_open('admissions/createexamschedules', $form);
				?>
				<div class="">	
					<div class="row">
						<div class="form-group col-sm-11">
							<label>Examinations*</label>
							<?php
								$exam_data = 'id="exam_id" class="col-xs-12 col-sm-12"';				
								echo form_dropdown('exam_id', $examination_options, null, $exam_data)
							?>
						</div>
					</div>	
					<div class="row">
						<div class="form-group col-sm-11">
							<label>Subject * </label>
							<?php
								$exam_subject_data = 'id="exam_subject" class="col-xs-12 col-sm-12"';				
								echo form_dropdown('exam_subject', $pgsubject_options, null, $exam_subject_data)
							?>
						</div>
					</div>
					<div class="row">	
						<div class="form-group col-sm-6">
							<label>Building</label>
							<?php
								$building_data = 'id="building_id" class="col-xs-11 col-sm-11"';				
								echo form_dropdown('building_id', $buildings_options, null, $building_data)
							?>
						</div>
						
						<div class="form-group col-sm-6">
							<label>Halls *</label>
							<?php
								$hall_id_data = 'id="hall_id" class="col-xs-11 col-sm-11"';				
								echo form_dropdown('hall_id', $halls_options, null, $hall_id_data)
							?>
						</div>
					</div>
					<div class="row">	
						<div class="form-group col-sm-6">
							<label>Number of Seat</label>
							<?php
								$seat_cnt_data = array(
					              					'name'        	=> 'seat_cnt',
													'id'          	=> 'seat_cnt',
													'value'       	=> '',
													'maxlength'     => '3',
													'placeholder'	=> '',
													'class'			=>	'col-xs-11 col-sm-11 input-number'
					            				);
	
								echo form_input($seat_cnt_data);
							?>
						</div>
					</div>	
					<div class="row">	
						<div class="form-group col-sm-12">
							<label>Remaining Seat in Hall: <span id="remain_seat_hall">0</span> </label> 
						<br/>
							<label>Unallocated Seat in Subject:  <span id="unallocated_seat_subject">0</span> </label>
						</div>
					</div>
					</div>

					<div class="row">
						<div class="form-group col-sm-6">
							<input type="checkbox" name="exam_is_active" id="exam_is_active" class=""/>&nbsp;Active
						</div>
					</div>
					<div class="row">	
						<div class="form-group col-sm-12">
							<button class="btn btn-info search-btn" type="button">Search</button> &nbsp;
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
var unallocated_seat_subject = 0;
var remain_seat_hall = 0;

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
				s += "<td>" + arr[i].subj_name + "</td>";
				s += "<td>" + arr[i].exam_date_time + "</td>";
				s += "<td>" + arr[i].hall_number + "</td>";
				s += "<td>" + arr[i].seat_cnt + "</td>";
				s += "<td style='text-align:center;'>" + is_active + "</td>";
				s += "<td class='text-center'>"
				//s += "<a href='javascript:void(0);' id='edit_" + i + "' class='btn btn-primary btn-xs edit-record'>Edit</a>&nbsp;&nbsp;";
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
	$('#exam_id').val(examinations_data[index].exam_id);
	$('#exam_subject').val(examinations_data[index].exam_subject);
	$('#building_id').val(examinations_data[index].building_id);
	populatehalls(index);
	//$('#hall_id').val(examinations_data[index].hall_id);
	$('#seat_cnt').val(examinations_data[index].seat_cnt);
	$('#seat_cnt').prop('disabled', true);
	
	if(examinations_data[index].exam_is_active == "1") {
		$('#exam_is_active').prop('checked', true);
	} else {
		$('#exam_is_active').prop('checked', false);
	}
	$('#record_id').val(examinations_data[index].exam_subj_id);
	$('#form_action').val('edit');
	
	populatehallinfo();
	populatesubjectinfo();
});

var halls_data = "";

$("#building_id").on('change',function() {
	populatehalls();
});

$("#hall_id").on('change',function() {
 	populatehallinfo();
});

function populatehallinfo(){
	var exam_id = $("#exam_id").val();
	var hall_id = $("#hall_id").val();
	if(hall_id == 'EMPTY' || hall_id == "" || hall_id == 'undefined'){
		hall_id = "-1";
	}
	if(exam_id != ''){
		var params = "hall_id="+hall_id+"&exam_id="+exam_id;
		$.ajax({
			url: "<?php echo $this->config->base_url();?>admissions/gethallinfo",
			type: "post",
			data: params,
			dataType: "html",
			success: function(response){
				remain_seat_hall = response;
				$("#remain_seat_hall").html('');
				$("#remain_seat_hall").html(remain_seat_hall);
			 }
		});
	}else{
		jAlert('Select Exam date before selecting hall.');
		$("#hall_id").val('EMPTY');
	}
}

$("#exam_subject").on('change',function() {
    populatesubjectinfo();
});

$("#exam_date").on('change',function() {
    $("#hall_id").val('EMPTY');
});

function populatesubjectinfo(){
	var params = "exam_subject="+$("#exam_subject").val();
		$.ajax({
			url: "<?php echo $this->config->base_url();?>admissions/getsubjectinfo",
			type: "post",
			data: params,
			dataType: "html",
			success: function(response){
				unallocated_seat_subject = response;
				$("#unallocated_seat_subject").html('');
				$("#unallocated_seat_subject").html(unallocated_seat_subject);
			 }
		});
}

function populatehalls($flag = -1){
	var params = "building_id="+$("#building_id").val();
		$.ajax({
			url: "<?php echo $this->config->base_url();?>admissions/gethalls",
			type: "post",
			data: params,
			dataType: "json",
			success: function(response){
				halls_data = response;
				console.log(response);
				$("#hall_id").html('');
				var subjs = "<option value='EMPTY'></option>";
				for(var i=0; i<halls_data.length; i++){
					subjs += '<option value="'+halls_data[i]['hall_id']+'">'+halls_data[i]['hall_number']+'</option>';
				}
				$("#hall_id").html(subjs);
				if($flag >=0 ){
					$('#hall_id').val(examinations_data[$flag].hall_id);
				}
			 }
		});
}

$(document).on('click','.delete-record',function() {
	var arr = $(this).attr('id').split("_");
	var index = arr[1];
	var exam_subj_id  = examinations_data[index].exam_subj_id ;
	var params = "id="+exam_subj_id;			
	var loadUrl = "<?php echo $this->config->base_url();?>admissions/delexamschedules/"+new Date().getTime();
	
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
							url: "<?php echo $this->config->base_url();?>admissions/loadexamschedules",
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
	var exam_id = $("#exam_id").val();
	if(exam_id == "EMPTY" || exam_id == '' || exam_id=='undefined' ){
		exam_id = null;
	}
	
	var exam_subject = $("#exam_subject").val();
	if(exam_subject == "EMPTY" || exam_subject == '' || exam_subject=='undefined' ){
		exam_subject = null;
	}
	
	var hall_id = $("#hall_id").val();
	if(hall_id == "EMPTY" || hall_id == '' || hall_id=='undefined' ){
		hall_id = null;
	}
	var params = "exam_id="+exam_id+"&exam_subject="+exam_subject+"&hall_id="+hall_id;			
	$.ajax({
		url: "<?php echo $this->config->base_url();?>admissions/loadsearchexamschedules",
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
	
	$('#seat_cnt').prop('disabled', false);
	
	var exam_subject = $('#exam_subject').val();
	var hall_id = $('#hall_id').val();
	var building_id = $('#building_id').val();
	var exam_id = $('#exam_id').val();
	var seat_cnt = $('#seat_cnt').val();
	var error = false;
	var msg = "<h4><strong>Ohh!</strong> Change a few things up and try submitting again.</h4>";
	if(exam_id == 'EMPTY' || exam_id == '' || exam_id == 'undefined' || exam_id == null) {
		error = true;
		$('#exam_id').addClass('form-error');
	}
	if(exam_subject == 'EMPTY' || exam_subject == '' || exam_subject == 'undefined' || exam_subject == null) {
		error = true;
		$('#exam_subject').addClass('form-error');
	}
	if(hall_id == 'EMPTY' || hall_id == '' || hall_id == 'undefined' || hall_id == null) {
		error = true;
		$('#hall_id').addClass('form-error');
	}
	if(building_id == 'EMPTY' || building_id == '' || building_id == 'undefined' || building_id == null) {
		error = true;
		$('#building_id').addClass('form-error');
	}
	if(seat_cnt == '') {
		error = true;
		$('#seat_cnt').addClass('form-error');
	}else if(parseInt(seat_cnt) > parseInt(remain_seat_hall) || parseInt(seat_cnt) > parseInt(unallocated_seat_subject)){
		error = true;
		$('#seat_cnt').addClass('form-error');
	}
	
	if(error) {
		if($("#form_action").val()== 'edit'){
			$('#seat_cnt').prop('disabled', true);			
		}
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
	$("#exam_subject").val('EMPTY');
	$("#hall_id").val('EMPTY');
	$("#building_id").val('EMPTY');
	$("#exam_id").val('EMPTY');
	$("#seat_cnt").val('');
	$('#exam_is_active').prop('checked', false);
	$('#record_id').val(0);
	$('#seat_cnt').prop('disabled', false);
}
onload();
populatehalls();
</script>