<div class="page-title">
	<h2>Organizations</h2>
	<ul class="breadcrumb">
		<li>You are here:</li>
		<li class="active">Master Data</li>
		<li class="">Organizations</li>
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
							<th style="width:20%;">Category</th>
							<th style="width:36%;">Name</th>
							<th style="width:17%;">State</th>
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
			<div class="box">
				<div class="title">
					<h3 class="addedit-label">Create Organization</h3>
				</div>
				<div class="content">	
					<?php
						$form = array(
										'class'	=>	'form-horizontal lft-pad-nm',
										'role'	=>	'form',
										'id' => 'addeditform'
									);	
						echo form_open('configs/createorganization', $form);
					?>
						
						<div class="form-group">
							<label>Organization Category</label>
							<?php
								$organization_ctgry = 'id="organization_ctgry" class="col-xs-10 col-sm-10 selectOrganization"';				
	
								echo form_dropdown('organization_ctgry', $organization_category_options, null, $organization_ctgry)
							?>
						</div>
						
						<div class="form-group">
							<label>Organization Name</label>
								<?php
									$organization_name = array(
								              					'name'        	=> 'organization_name',
																'id'          	=> 'organization_name',
																'value'       	=> '',
																'class'			=>	'col-xs-10 col-sm-10'
								            				);
	
									echo form_input($organization_name);
								?>
						</div>
						
						<div class="form-group">
							<label>Organization State</label>
								<?php
									$organization_state = 'id="organization_state" class="col-xs-10 col-sm-10 selectOrganization"';				
		
									echo form_dropdown('organization_state', $state_options, null, $organization_state)
								?>
						</div>
						
						<!--
						<div class="form-group">
													<label>City</label>
														<?php
															$organization_city = array(
																						  'name'        	=> 'organization_city',
																						'id'          	=> 'organization_city',
																						'value'       	=> '',
																						'class'			=>	'col-xs-10 col-sm-10'
																					);
							
															echo form_input($organization_city);
														?>
												</div>
												<div class="form-group">
													<label>Phone Number(s)</label>
														<?php
															$organization_phone = array(
																						  'name'        	=> 'organization_phone',
																						'id'          	=> 'organization_phone',
																						'value'       	=> '',
																						'class'			=>	'col-xs-10 col-sm-10'
																					);
							
															echo form_input($organization_phone);
														?>
												</div>
												<div class="form-group">
													<label>Email Address</label>
														<?php
															$organization_email = array(
																						  'name'        	=> 'organization_email',
																						'id'          	=> 'organization_email',
																						'value'       	=> '',
																						'class'			=>	'col-xs-10 col-sm-10'
																					);
							
															echo form_input($organization_email);
														?>
												</div>-->
						
						
						<div class="form-group">
							<input type="checkbox" name="organization_is_active" id="organization_is_active" class=""/>&nbsp;Active
						</div>
						
						<div class="form-group">
							<button class="btn btn-primary search-btn" type="button">Search</button>
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
var organizations = '<?php echo json_encode($organizations);?>';
var organizations_data = jQuery.parseJSON(organizations);

$(document).ready(function() {
	printAllStudyOrganizations(organizations_data);
});	

/*
$(document).on('change','#organization_state, #organization_ctgry',function() {
	var organization_state = $('#organization_state').val()!='EMPTY'?$('#organization_state').val():'';
	var organization_ctgry = $('#organization_ctgry').val()!='EMPTY'?$('#organization_ctgry').val():'';
	
	var params1 = "organization_state="+organization_state
	var params2 = "organization_ctgry="+organization_ctgry;	
	var params = params1+"&"+params2;
	
	var flag = true;
	if($('#organization_state').val() == 'EMPTY' && $('#organization_ctgry').val() == 'EMPTY'){
		flag = false;
	}
	var loadUrl = "<?php echo $this->config->base_url();?>configs/loadorganizations/"+new Date().getTime();
	
	if(flag) {
		$.ajax({
				    type: "POST",
				    url: loadUrl,
				    data: params,
				    success: function(res){
				    	printAllStudyOrganizations(res);
				    }
				});
	}			
});	*/


function printAllStudyOrganizations(arr) {
	var s = "";
	if(arr.length > 0) {
			for(var i=0; i<arr.length; i++) {
				var is_active = (arr[i].organization_is_active == "1") ? "<i class='fa fa-check green-text'></i>" : "<i class='fa fa-times red-text'></i>";
				var organizationCategory = '';
				if(arr[i].organization_ctgry=='1'){	organizationCategory = 'Secondary Board'; }
				else if(arr[i].organization_ctgry=='2'){	organizationCategory = 'Higher Secondary Board'; }
				else if(arr[i].organization_ctgry=='3'){	organizationCategory = 'University'; }
				
				s += "<tr>";
				s += "<td>" + (i+1) + "</td>";
				s += "<td>" + organizationCategory + "</td>";
				s += "<td>" + arr[i].organization_name + "</td>";
				s += "<td>" + arr[i].organization_state;
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
	$('.addedit-label').html('Edit Organization');
	$('#organization_ctgry').val(organizations_data[index].organization_ctgry);
	$('#organization_name').val(organizations_data[index].organization_name);
	$('#organization_state').val(organizations_data[index].organization_state);
	if(organizations_data[index].organization_is_active == "1") {
		$('#organization_is_active').prop('checked', true);
	} else {
		$('#organization_is_active').prop('checked', false);
	}
	$('#record_id').val(organizations_data[index].organization_id);
	$('#form_action').val('edit');
});

$(document).on('click','.delete-record',function() {
	var arr = $(this).attr('id').split("_");
	var index = arr[1];
	var organization_id = organizations_data[index].organization_id;
	var params = "id="+organization_id;			
	var loadUrl = "<?php echo $this->config->base_url();?>configs/delcollege/"+new Date().getTime();
	
	
	
	jConfirm('Are you sure want to delete?', 'Please Confirm', function(e) {
		if (e) {	
			$.ajax({
			    type: "POST",
			    url: loadUrl,
			    data: params,
			    success: function(res){
			    	if(res == 'DELETED') {
			    		loadOrganizations();
						$('.action-message').remove();
						$('<div>').attr({
						    class: 'alert alert-success action-message'
						}).html('Record deleted succesfully').prependTo('.data-content');
			    	}
			    }
			});    		
		}
	});	
	
});	


	function loadOrganizations(){
		$('.error-msg').remove();
		$('input').removeClass('form-error');
		$('select').removeClass('form-error');
		
		var organization_state = $('#organization_state').val()!='EMPTY'?$('#organization_state').val():'';
		var organization_ctgry = $('#organization_ctgry').val()!='EMPTY'?$('#organization_ctgry').val():'';
		var organization_name  = $('#organization_name').val();
		
		var $flag = true;
		if(organization_state == '' && organization_ctgry == '' && organization_name == ''){
			$flag = false;
		}
		
		if($flag){
			var params1 = "organization_state="+organization_state
			var params2 = "organization_ctgry="+organization_ctgry;
			var params3 = "organization_name="+organization_name;
				
			var params_total = params1+"&"+params2+"&"+params3;
			$.ajax({
				url: "<?php echo $this->config->base_url();?>configs/loadorganizations",
				data: params_total,
				type: "post",
				dataType: "json",
				success: function(response){
						//show message
						printAllStudyOrganizations(response);
						organizations_data = response;
					 }
			});
		}else{
			$('#addeditform').before("<div class='error-msg'></div>");
			$('.error-msg').html('Please select atleast one criteria');
		}
		
	}
	
	$('input').bind('keypress',function(event) {
		if(event.charCode == 39 || event.charCode == 34 || event.charCode == 96 || event.charCode == 126 || event.charCode==42 || event.charCode==37){
			jAlert('This special character not allowd.');
			return false;
		}
	});
	
	
	
//cancel action
$(document).on('click','.cancel-btn',function() {
	$('.addedit-label').html('Create Organization');
	$('#form_action').val('add');
	$('#organization_ctgry').val('EMPTY');
	$('#organization_name').val('');
	$('#organization_state').val('');
	$('#organization_is_active').prop('checked', false);
	$('#record_id').val(0);
});

$(document).on('click','.search-btn',function() {
	loadOrganizations();
});

//validates form
$(document).on('click','.addedit-btn',function() {
	$('.error-msg').remove();
	$('input').removeClass('form-error');
	$('select').removeClass('form-error');
	
	var organization_ctgry= $('#organization_ctgry').val();
	var organizatio_name = $('#organization_name').val();
	var organization_state = $('#organization_state').val();
	
	var error = false;
	var msg = "<h4><strong>Ohh!</strong> Change a few things up and try submitting again.</h4>";
	
	if(organization_ctgry == 'EMPTY') {
		error = true;
		$('#organization_ctgry').addClass('form-error');
	}
	
	if(organization_name == '') {
		error = true;
		$('#organization_name').addClass('form-error');
	}
	
	if(organization_state == 'EMPTY') {
		error = true;
		$('#organization_state').addClass('form-error');
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