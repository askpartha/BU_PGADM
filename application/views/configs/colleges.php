<div class="page-title">
	<h2>Study Centers</h2>
	<ul class="breadcrumb">
		<li>You are here:</li>
		<li class="active">Master Data</li>
		<li class="">Course Study Centers</li>
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
							<th style="width:7%;">Category</th>
							<th style="width:8%;">Code</th>
							<th style="width:22%;">Name</th>
							<th style="width:38%;">Address</th>
							<th style="width:4%;">Active</th>
							<th style="width:15%;">Action</th>
						</tr>
					</thead>
					<tbody id="tbl-content"></tbody>
				</table>
				<div class="paginator pull-right btm-mrgn-sm"></div>
			</div>	<!-- /box -->
		</div>
		
		<div class="col-sm-4">
			<div class="btm-mrg-sm"><a href="<?php echo $this->config->base_url();?>configs/collegepgsubject" class="btn btn-primary">Subject- Center Availability</a></div>
			<div class="box">
				<div class="title">
					<h3 class="addedit-label">Create Study Center</h3>
				</div>
				<div class="content">	
					<?php
						$form = array(
										'class'	=>	'form-horizontal lft-pad-nm',
										'role'	=>	'form',
										'id' => 'addeditform'
									);	
						echo form_open('configs/createcollege', $form);
					?>
						
						<div class="form-group">
							<label>Center Category</label>
							<?php
								$col_ctgry = 'id="col_ctgry" class="col-xs-10 col-sm-10"';				
	
								echo form_dropdown('col_ctgry', $college_category_options, null, $col_ctgry)
							?>
						</div>
						
						<div class="form-group">
							<label>Center Code</label>
							<?php
								$col_code = array(
					              					'name'        	=> 'col_code',
													'id'          	=> 'col_code',
													'value'       	=> '',
													'placeholder'	=> '',
													'class'			=>	'col-xs-10 col-sm-10'
					            				);
	
								echo form_input($col_code);
							?>
						</div>
						<div class="form-group">
							<label>Center Name</label>
								<?php
									$col_name = array(
								              					'name'        	=> 'col_name',
																'id'          	=> 'col_name',
																'value'       	=> '',
																'class'			=>	'col-xs-10 col-sm-10'
								            				);
	
									echo form_input($col_name);
								?>
						</div>
						
						<div class="form-group">
							<label>Center Address</label>
								<?php
									$col_address = array(
								              					'name'        	=> 'col_address',
																'id'          	=> 'col_address',
																'value'       	=> '',
																'class'			=>	'col-xs-10 col-sm-10'
								            				);
	
									echo form_input($col_address);
								?>
						</div>
						
						<div class="form-group">
							<label>City</label>
								<?php
									$col_city = array(
								              					'name'        	=> 'col_city',
																'id'          	=> 'col_city',
																'value'       	=> '',
																'class'			=>	'col-xs-10 col-sm-10'
								            				);
	
									echo form_input($col_city);
								?>
						</div>
						
						<!--
						<div class="form-group">
							<label>State</label>
								<?php
									$col_state = array(
								              					'name'        	=> 'col_state',
																'id'          	=> 'col_state',
																'value'       	=> '',
																'class'			=>	'col-xs-10 col-sm-10'
								            				);
	
									echo form_input($col_state);
								?>
						</div>
						-->
						
						<div class="form-group">
							<label>Phone Number(s)</label>
								<?php
									$col_phone = array(
								              					'name'        	=> 'col_phone',
																'id'          	=> 'col_phone',
																'value'       	=> '',
																'class'			=>	'col-xs-10 col-sm-10'
								            				);
	
									echo form_input($col_phone);
								?>
						</div>
						
						<div class="form-group">
							<label>Email Address</label>
								<?php
									$col_email = array(
								              					'name'        	=> 'col_email',
																'id'          	=> 'col_email',
																'value'       	=> '',
																'class'			=>	'col-xs-10 col-sm-10'
								            				);
	
									echo form_input($col_email);
								?>
						</div>
						
						<div class="form-group">
							<input type="checkbox" name="col_is_active" id="col_is_active" class=""/>&nbsp;Active
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
var colleges = '<?php echo json_encode($colleges);?>';
var colleges_data = jQuery.parseJSON(colleges);

$(document).ready(function() {
	printAllStudyCenters(colleges_data);
});	

function printAllStudyCenters(arr) {
	var s = "";
	if(arr.length > 0) {
			for(var i=0; i<arr.length; i++) {
				var is_active = (arr[i].col_is_active == "1") ? "<i class='fa fa-check green-text'></i>" : "<i class='fa fa-times red-text'></i>";
				var colCategory = '';
				if(arr[i].col_ctgry=='B'){	colCategory = 'Boys'; }
				else if(arr[i].col_ctgry=='G'){	colCategory = 'Girls'; }
				else if(arr[i].col_ctgry=='BG'){	colCategory = 'Both'; }
				
				s += "<tr>";
				s += "<td>" + (i+1) + "</td>";
				s += "<td>" + colCategory + "</td>";
				s += "<td>" + arr[i].col_code + "</td>";
				s += "<td>" + arr[i].col_name + "</td>";
				s += "<td>" + arr[i].col_address + ", " + arr[i].col_city;
				s += ((arr[i].col_phone == null) ? '' : "<br>" + arr[i].col_phone);
				s += ((arr[i].col_email == null) ? '' : "<br>" + arr[i].col_email);
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
	$('.addedit-label').html('Edit Study Center');
	$('#col_ctgry').val(colleges_data[index].col_ctgry);
	$('#col_code').val(colleges_data[index].col_code);
	$('#col_name').val(colleges_data[index].col_name);
	$('#col_address').val(colleges_data[index].col_address);
	$('#col_city').val(colleges_data[index].col_city);
	$('#col_state').val(colleges_data[index].col_state);
	$('#col_phone').val(colleges_data[index].col_phone);
	$('#col_email').val(colleges_data[index].col_email);
	if(colleges_data[index].col_is_active == "1") {
		$('#col_is_active').prop('checked', true);
	} else {
		$('#col_is_active').prop('checked', false);
	}
	$('#record_id').val(colleges_data[index].col_id);
	$('#form_action').val('edit');
});

$(document).on('click','.delete-record',function() {
	var arr = $(this).attr('id').split("_");
	var index = arr[1];
	var col_id = colleges_data[index].col_id;
	var params = "id="+col_id;			
	var loadUrl = "<?php echo $this->config->base_url();?>configs/delcollege/"+new Date().getTime();
	
	jConfirm('Are you sure want to delete?', 'Please Confirm', function(e) {
		if (e) {	
			$.ajax({
			    type: "POST",
			    url: loadUrl,
			    data: params,
			    success: function(res){
			    	if(res == 'DELETED') {
						$.ajax({
								url: "<?php echo $this->config->base_url();?>configs/loadcolleges",
								type: "post",
								dataType: "json",
								success: function(response){
													//show message
													printAllStudyCenters(response);
													colleges_data = response;
													
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
	$('.addedit-label').html('Create Study Center');
	$('#form_action').val('add');
	$('#col_ctgry').val('EMPTY');
	$('#col_code').val('');
	$('#col_name').val('');
	$('#col_address').val('');
	$('#col_city').val('');
	$('#col_state').val('');
	$('#col_phone').val('');
	$('#col_email').val('');
	$('#col_is_active').prop('checked', false);
	$('#record_id').val(0);
});

//validates form
$(document).on('click','.addedit-btn',function() {
	$('.error-msg').remove();
	$('input').removeClass('form-error');
	
	var col_ctgry= $('#col_ctgry').val();
	var col_code = $('#col_code').val();
	var col_name = $('#col_name').val();
	
	var error = false;
	var msg = "<h4><strong>Ohh!</strong> Change a few things up and try submitting again.</h4>";
	
	if(col_ctgry == 'EMPTY') {
		error = true;
		$('#col_ctgry').addClass('form-error');
	}
	
	if(col_code == '') {
		error = true;
		$('#col_code').addClass('form-error');
	}	
	
	if(col_name == '') {
		error = true;
		$('#col_name').addClass('form-error');
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