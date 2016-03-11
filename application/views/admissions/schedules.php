<div class="page-title">
	<h2>Schedules</h2>
	<ul class="breadcrumb">
		<li>You are here:</li>
		<li class="active">Master Data</li>
		<li class="">Schedules</li>
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
							<th style="width:15%;">Schedule Name</th>
							<th style="width:15%;">Schedule Date</th>
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
					<h3 class="addedit-label">Create Schedule</h3>
				</div>
				<div class="content">	
					<?php
						$form = array(
										'class'	=>	'form-horizontal lft-pad-nm',
										'role'	=>	'form',
										'id' => 'addeditform'
									);	
						echo form_open('admissions/createschedule', $form);
					?>
						<div class="form-group">
							<label>Schedule Name</label>
							<?php
								$schedule = 'id="schedule_name" class="col-xs-10 col-sm-10"';				
	
								echo form_dropdown('schedule_name', $schedule_options, null, $schedule)
							?>
						</div>
						
						<div class="form-group">
							<label>Schedule Date</label>
							<?php
								$schedule_date = array(
					              					'name'        	=> 'schedule_date',
													'id'          	=> 'schedule_date',
													'maxlength'    	=> '5',
													'value'       	=> '',
													'placeholder'	=> '',
													'class'			=>	'col-xs-6 col-sm-6 future-datepicker'
					            				);
	
								echo form_input($schedule_date);
							?>
						</div>
						
						<div class="form-group">
							<label>Schedule Time</label>
							<?php
								$schedule_time_data = 'id="schedule_time" class="col-xs-7 col-sm-7"';				
								echo form_dropdown('schedule_time', $time_options, null, $schedule_time_data)
							?>
						</div>
						
						
						<div class="form-group">
							<input type="checkbox" name="schedule_is_active" id="schedule_is_active" class=""/>&nbsp;Active
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
var schedules = '<?php echo json_encode($schedules);?>';
var schedules_data = jQuery.parseJSON(schedules);

var schedule_options = '<?php echo json_encode($schedule_options);?>';
var schedule_options_data = jQuery.parseJSON(schedule_options);

console.log(schedule_options_data);

$(document).ready(function() {
	printAllSchedules(schedules_data);
});	

function printAllSchedules(arr) {
	//console.log(arr);
	var s = "";
	if(arr.length > 0) {
			for(var i=0; i<arr.length; i++) {
				var is_active = (arr[i].schedule_is_active == "1") ? "<i class='fa fa-check green-text'></i>" : "<i class='fa fa-times red-text'></i>";
				s += "<tr>";
				s += "<td>" + (i+1) + "</td>";
				s += "<td>" + schedule_options_data[arr[i].schedule_name] + "</td>";	
				s += "<td>" + arr[i].schedule_date + "</td>";
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
	$('.addedit-label').html('Edit Schedule');
	$('#schedule_name').val(schedules_data[index].schedule_name);
	$('#schedule_date').val(schedules_data[index].schedule_date);
	$('#schedule_time').val(schedules_data[index].schedule_time);
	
	if(schedules_data[index].schedule_is_active == "1") {
		$('#schedule_is_active').prop('checked', true);
	} else {
		$('#schedule_is_active').prop('checked', false);
	}
	$('#record_id').val(schedules_data[index].schedule_id);
	$('#form_action').val('edit');
});

$(document).on('click','.delete-record',function() {
	var arr = $(this).attr('id').split("_");
	var index = arr[1];
	var schedule_id = schedules_data[index].schedule_id;
	var params = "id="+schedule_id;			
	var loadUrl = "<?php echo $this->config->base_url();?>admissions/delschedule/"+new Date().getTime();
	
	jConfirm('Are you sure want to delete?', 'Please Confirm', function(e) {
		if (e) {	
			$.ajax({
			    type: "POST",
			    url: loadUrl,
			    data: params,
			    dataType: 'html',
			    success: function(res){
			    	console.log('PARTHA'+res+'GHOSH');
			    	if(res == 'DELETED') {
						$.ajax({
								url: "<?php echo $this->config->base_url();?>admissions/loadschedules",
								type: "post",
								dataType: "json",
								success: function(response){
													//show message
													printAllSchedules(response);
													schedules_data = response;
													
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
	$('.addedit-label').html('Create Schedule');
	$('#form_action').val('add');
	$('#schedule_name').val('EMPTY');
	$('#schedule_date').val('');
	$('#schedule_time').val('EMPTY');
	$('#schedule_is_active').prop('checked', false);
	$('#record_id').val(0);
});

//validates form
$(document).on('click','.addedit-btn',function() {
	$('.error-msg').remove();
	$('input').removeClass('form-error');
	$('select').removeClass('form-error');
	
	var schedule_name = $('#schedule_name').val();
	var schedule_date = $('#schedule_date').val();
	var schedule_time = $('#schedule_time').val();
	
	var error = false;
	var msg = "<h4><strong>Ohh!</strong> Change a few things up and try submitting again.</h4>";
	
	if(schedule_name == 'EMPTY') {
		error = true;
		$('#schedule_name').addClass('form-error');
	}
	if(schedule_date == '') {
		error = true;
		$('#schedule_date').addClass('form-error');
	}
	if(schedule_time == '') {
		error = true;
		$('#schedule_time').addClass('form-error');
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