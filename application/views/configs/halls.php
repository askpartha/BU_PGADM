<div class="page-title">
	<h2>Halls</h2>
	<ul class="breadcrumb">
		<li>You are here:</li>
		<li class="active">Master Data</li>
		<li class="">Halls</li>
	</ul>
</div>	<!-- /heading -->

<div class="container-fluid">
	<div class="row">
		<div class="col-sm-9 data-content">
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
							<th style="width:20%;">Building Name</th>
							<th style="width:10%;">Hall No</th>
							<th style="width:10%;">Column</th>
							<th style="width:10%;">Row</th>
							<th style="width:10%;">Seat/ Unit</th>
							<th style="width:10%;">Capacity</th>
							<th style="width:7%;">Active</th>
							<th style="width:13%;">Action</th>
						</tr>
					</thead>
					<tbody id="tbl-content"></tbody>
				</table>
				<div class="paginator pull-right btm-mrgn-sm"></div>
			</div>	<!-- /box -->
		</div>
		
		<div class="col-sm-3">
			<div class="box">
				<div class="title">
					<h3 class="addedit-label">Create Hall</h3>
				</div>
				<div class="content">	
					<?php
						$form = array(
										'class'	=>	'form-horizontal lft-pad-nm',
										'role'	=>	'form',
										'id' => 'addeditform'
									);	
						echo form_open('configs/createhall', $form);
					?>
						
						<div class="form-group">
							<label>Building</label>
							<?php
								$building = 'id="building_id" class="col-xs-10 col-sm-10"';				
	
								echo form_dropdown('building_id', $building_options, null, $building)
							?>
						</div>
						
						<div class="form-group">
							<label>Hall Number</label>
							<?php
								$hall_number = array(
					              					'name'        	=> 'hall_number',
													'id'          	=> 'hall_number',
													'value'       	=> '',
													'placeholder'	=> '',
													'maxlength'		=> '100',
													'class'			=>	'col-xs-10 col-sm-10'
					            				);
	
								echo form_input($hall_number);
							?>
						</div>
						
						<div class="form-group">
							<label>Total Number of Rows</label>
							<?php
								$hall_row_num = array(
					              					'name'        	=> 'hall_row_num',
													'id'          	=> 'hall_row_num',
													'value'       	=> '',
													'placeholder'	=> '',
													'maxlength'		=> '2',
													'class'			=>	'col-xs-10 col-sm-10 input-number'
					            				);
	
								echo form_input($hall_row_num);
							?>
						</div>
						<div class="form-group">
							<label>Total Number of Columns</label>
							<?php
								$hall_column_num = array(
					              					'name'        	=> 'hall_column_num',
													'id'          	=> 'hall_column_num',
													'value'       	=> '',
													'placeholder'	=> '',
													'maxlength'		=> '2',
													'class'			=>	'col-xs-10 col-sm-10 input-number'
					            				);
	
								echo form_input($hall_column_num);
							?>
						</div>
						
						<div class="form-group">
							<label>Perunit Seat</label>
							<?php
								$hall_per_unit_seat = array(
					              					'name'        	=> 'hall_per_unit_seat',
													'id'          	=> 'hall_per_unit_seat',
													'value'       	=> '',
													'placeholder'	=> '',
													'maxlength'		=> '2',
													'class'			=>	'col-xs-10 col-sm-10 input-number'
					            				);
	
								echo form_input($hall_per_unit_seat);
							?>
						</div>
						
						<div class="form-group">
							<label>Total Seat Capacity</label>
							<?php
								$hall_capacity = array(
					              					'name'        	=> 'hall_capacity',
													'id'          	=> 'hall_capacity',
													'value'       	=> '',
													'placeholder'	=> '',
													'maxlength'		=> '3',
													'class'			=>	'col-xs-10 col-sm-10 input-number'
					            				);
	
								echo form_input($hall_capacity);
							?>
						</div>
						
						<div class="form-group">
							<input type="checkbox" name="hall_is_active" id="hall_is_active" class=""/>&nbsp;Active
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
var halls = '<?php echo json_encode($halls);?>';
var halls_data = jQuery.parseJSON(halls);

$(document).ready(function() {
	printAllHall(halls_data);
});	

function printAllHall(arr) {
	var s = "";
	if(arr.length > 0) {
			for(var i=0; i<arr.length; i++) {
				var is_active = (arr[i].hall_is_active == "1") ? "<i class='fa fa-check green-text'></i>" : "<i class='fa fa-times red-text'></i>";
				s += "<tr>";
				s += "<td>" + (i+1) + "</td>";
				s += "<td>" + arr[i].building_name + "</td>";
				s += "<td>" + arr[i].hall_number + "</td>";
				s += "<td>" + arr[i].hall_row_num + "</td>";
				s += "<td>" + arr[i].hall_column_num + "</td>";
				s += "<td>" + arr[i].hall_per_unit_seat + "</td>";
				s += "<td>" + arr[i].hall_capacity + "</td>";
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
	$('.addedit-label').html('Edit Hall');
	$('#hall_number').val(halls_data[index].hall_number);
	$('#building_id').val(halls_data[index].building_id);
	$('#hall_row_num').val(halls_data[index].hall_row_num);
	$('#hall_column_num').val(halls_data[index].hall_column_num);
	$('#hall_per_unit_seat').val(halls_data[index].hall_per_unit_seat);
	$('#hall_capacity').val(halls_data[index].hall_capacity);
	
	if(halls_data[index].hall_is_active == "1") {
		$('#hall_is_active').prop('checked', true);
	} else {
		$('#hall_is_active').prop('checked', false);
	}
	$('#record_id').val(halls_data[index].hall_id);
	$('#form_action').val('edit');
});

$(document).on('click','.delete-record',function() {
	var arr = $(this).attr('id').split("_");
	var index = arr[1];
	var hall_id = halls_data[index].hall_id;
	var params = "id="+hall_id;			
	var loadUrl = "<?php echo $this->config->base_url();?>configs/delhall/"+new Date().getTime();
	
	jConfirm('Are you sure want to delete?', 'Please Confirm', function(e) {
		if (e) {	
			$.ajax({
			    type: "POST",
			    url: loadUrl,
			    data: params,
			    success: function(res){
			    	if(res == 'DELETED') {
						$.ajax({
								url: "<?php echo $this->config->base_url();?>configs/loadhalls",
								type: "post",
								dataType: "json",
								success: function(response){
													//show message
													printAllHall(response);
													halls_data = response;
													
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
	$('.addedit-label').html('Create Hall');
	$('#form_action').val('add');
	$('#hall_number').val('');
	$('#building_id').val('EMPTY');
	$('#hall_row_num').val('');
	$('#hall_column_num').val('');
	$('#hall_per_unit_seat').val('');
	$('#hall_capacity').val('');
	$('#hall_is_active').prop('checked', false);
	$('#record_id').val(0);
});

//validates form
$(document).on('click','.addedit-btn',function() {
	$('.error-msg').remove();
	$('input').removeClass('form-error');
	
	var hall_number = $('#hall_number').val();
	var building_id = $('#building_id').val();
	var hall_row_num = $('#hall_row_num').val();
	var hall_column_num = $('#hall_column_num').val();
	var hall_per_unit_seat = $('#hall_per_unit_seat').val();
	var hall_capacity = $('#hall_capacity').val();
	
	var error = false;
	var msg = "<h4><strong>Ohh!</strong> Change a few things up and try submitting again.</h4>";
	
	if(hall_number == '') {
		error = true;
		$('#hall_number').addClass('form-error');
	}
	if(building_id == 'EMPTY') {
		error = true;
		$('#building_id').addClass('form-error');
	}
	if(hall_row_num == '') {
		error = true;
		$('#hall_row_num').addClass('form-error');
	}
	if(hall_column_num == '') {
		error = true;
		$('#hall_column_num').addClass('form-error');
	}
	if(hall_per_unit_seat == '') {
		error = true;
		$('#hall_per_unit_seat').addClass('form-error');
	}
	if(hall_capacity == '') {
		error = true;
		$('#hall_capacity').addClass('form-error');
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