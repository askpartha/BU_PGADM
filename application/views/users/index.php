<div class="page-title">
	<h2>Users</h2>
	<ul class="breadcrumb">
		<li>You are here:</li>
		<li class="active">Master Data</li>
		<li class="">Users</li>
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
							<th style="width:17%;">First Name</th>
							<th style="width:17%;">Last name</th>
							<th style="width:15%;">Username</th>
							<th style="width:10%;">Role</th>
							<th style="width:10%;">Dept</th>
							<th style="width:5%;">Status</th>
							<th style="width:13%;">Action</th>
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
					<h3 class="addedit-label">Create User</h3>
				</div>
				<div class="content">	
					<?php
						$form = array(
										'class'	=>	'form-horizontal lft-pad-nm',
										'role'	=>	'form',
										'id' => 'addeditform'
									);	
						echo form_open('users/createuser', $form);
					?>
						
						<div class="form-group">
							<label>User Role</label>
							<?php
								$user_role = 'id="role" class="col-xs-10 col-sm-10 selectUser"';				
								echo form_dropdown('role', $user_role_options, null, $user_role)
							?>
						</div>
						
						<div class="form-group">
							<label>User Department</label>
								<?php
									$user_dept = 'id="user_dept" class="col-xs-10 col-sm-10 selectUser"';				
									echo form_dropdown('user_dept', $dept_options, null, $user_dept)
								?>
						</div>
						
						<div class="form-group">
							<label>User Name</label>
								<?php
									$user_name = array(
								              					'name'        	=> 'user_name',
																'id'          	=> 'user_name',
																'value'       	=> '',
																'class'			=>	'col-xs-10 col-sm-10'
								            				);
	
									echo form_input($user_name);
								?>
						</div>
						
						<div class="form-group">
							<label>First Name</label>
								<?php
									$user_firstname = array(
								              					'name'        	=> 'user_firstname',
																'id'          	=> 'user_firstname',
																'value'       	=> '',
																'class'			=>	'col-xs-10 col-sm-10'
								            				);
	
									echo form_input($user_firstname);
								?>
						</div>
						
						<div class="form-group">
							<label>Last Name</label>
								<?php
									$user_lastname = array(
								              					'name'        	=> 'user_lastname',
																'id'          	=> 'user_lastname',
																'value'       	=> '',
																'class'			=>	'col-xs-10 col-sm-10'
								            				);
	
									echo form_input($user_lastname);
								?>
						</div>
						
						<div class="form-group">
							<label>Mobile Number</label>
								<?php
									$user_phone = array(
								              					'name'        	=> 'user_phone',
																'id'          	=> 'user_phone',
																'value'       	=> '',
																'maxlength'       	=> '10',
																'class'			=>	'col-xs-10 col-sm-10 input-number mobile-number'
								            				);
	
									echo form_input($user_phone);
								?>
						</div>
						
						<div class="form-group">
							<input type="checkbox" name="user_is_active" id="user_is_active" class=""/>&nbsp;Active
						</div>
						
						<div class="form-group">
							<button class="btn btn-info search-btn" type="button">Search</button>
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
var users = '<?php echo json_encode($users);?>';
var users_data = jQuery.parseJSON(users);

$(document).ready(function() {
	printAllUsers(users_data);
});	

$(document).on('change','#role',function() {
	var user_dept 		= $('#user_dept').val();
	var role 			= $('#role').val();
	if(role == 'Admin' || role == 'Verifier' || role == 'Center'){
		$('#user_dept').val('EMPTY');
	}	
});

$(document).on('change','#user_dept',function() {
	var user_dept 		= $('#user_dept').val();
	var role 			= $('#role').val();
	if((role == 'Admin' || role == 'Verifier' || role == 'Center') && (user_dept != 'EMPTY' || user_dept != '') ){
		$('#role').val('EMPTY');
	}	
});

function printAllUsers(arr) {
	var s = "";
	if(arr.length > 0) {
			for(var i=0; i<arr.length; i++) {
				var user_dept_name = arr[i].user_dept_name;
				if(user_dept_name == null || user_dept_name == 'EMPTY'){
					user_dept_name = "";
				}
				var is_active = (arr[i].user_is_active == "1") ? "<i class='fa fa-check green-text'></i>" : "<i class='fa fa-times red-text'></i>";
				s += "<tr>";
				s += "<td>" + (i+1) + "</td>";
				s += "<td>" + arr[i].user_firstname + "</td>";
				s += "<td>" + arr[i].user_lastname + "</td>";
				s += "<td>" + arr[i].user_name + "</td>";
				s += "<td>" + arr[i].role + "</td>";
				s += "<td>" + user_dept_name + "</td>";
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
	$('.addedit-label').html('Edit User');
	$('#role').val(users_data[index].role);
	$('#user_name').val(users_data[index].user_name);
	$('#user_firstname').val(users_data[index].user_firstname);
	$('#user_lastname').val(users_data[index].user_lastname);
	$('#user_phone').val(users_data[index].user_phone);
	$('#user_dept').val(users_data[index].user_dept);
	
	if(users_data[index].user_is_active == "1") {
		$('#user_is_active').prop('checked', true);
	} else {
		$('#user_is_active').prop('checked', false);
	}
	$('#record_id').val(users_data[index].user_id);
	$('#form_action').val('edit');
});

$(document).on('click','.delete-record',function() {
	var arr = $(this).attr('id').split("_");
	var index = arr[1];
	var user_id = users_data[index].user_id;
	var params = "id="+user_id;			
	var loadUrl = "<?php echo $this->config->base_url();?>users/deluser/"+new Date().getTime();
	
	jConfirm('Are you sure want to delete?', 'Please Confirm', function(e) {
		if (e) {	
			$.ajax({
			    type: "POST",
			    url: loadUrl,
			    data: params,
			    success: function(res){
			    	if(res == 'DELETED') {
			    		loadUsers();
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


function loadUsers(){
	$('.error-msg').remove();
	$('input').removeClass('form-error');
	$('select').removeClass('form-error');
	
	var user_dept 		= $('#user_dept').val()!='EMPTY'?$('#user_dept').val():'';
	var role 			= $('#role').val()!='EMPTY'?$('#role').val():'';
	var user_name  		= $('#user_name').val();
	var user_firstname  = $('#user_firstname').val();
	var user_lastname  	= $('#user_lastname').val();
	var user_phone  	= $('#user_phone').val();
	
	var $flag = true;
	if(user_dept == '' && role == '' && user_name == '' && user_firstname == '' && user_lastname == '' && user_phone == ''){
		$flag = false;
	}
	
	if($flag){
		var params1 = "user_dept="+user_dept
		var params2 = "role="+role;
		var params3 = "user_name="+user_name;
		var params4 = "user_firstname="+user_firstname
		var params5 = "user_lastname="+user_lastname;
		var params6 = "user_phone="+user_phone;
			
		var params_total = params1+"&"+params2+"&"+params3+"&"+params4+"&"+params5+"&"+params6;
		$.ajax({
			url: "<?php echo $this->config->base_url();?>users/loadusers",
			data: params_total,
			type: "post",
			dataType: "json",
			success: function(response){
				//show message
				printAllUsers(response);
				users_data = response;
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
	$('.addedit-label').html('Create User');
	$('#form_action').val('add');
	$('#role').val('EMPTY');
	$('#user_name').val('');
	$('#user_firstname').val('');
	$('#user_lastname').val('');
	$('#user_phone').val('');
	$('#user_dept').val('EMPTY');
	$('#user_is_active').prop('checked', false);
	$('#record_id').val(0);
});

$(document).on('click','.search-btn',function() {
	loadUsers();
});

//validates form
$(document).on('click','.addedit-btn',function() {
	$('.error-msg').remove();
	$('input').removeClass('form-error');
	$('select').removeClass('form-error');
	
	var role= $('#role').val();
	var user_dept = $('#user_dept').val();
	var user_name = $('#user_name').val();
	var user_firstname = $('#user_firstname').val();
	var user_lastname = $('#user_lastname').val();
	var user_phone = $('#user_phone').val();
	
	
	var error = false;
	var msg = "<h4><strong>Ohh!</strong> Change a few things up and try submitting again.</h4>";
	
	if(role == 'EMPTY') {
		error = true;
		$('#role').addClass('form-error');
	}
	
	if(role == 'Staff'){
		if(user_dept == 'EMPTY') {
			error = true;
			$('#user_dept').addClass('form-error');
		}
	}
	
	if(user_name == '') {
		error = true;
		$('#user_name').addClass('form-error');
	}
	
	if(user_firstname == '') {
		error = true;
		$('#user_firstname').addClass('form-error');
	}
	
	if(user_lastname == '') {
		error = true;
		$('#user_lastname').addClass('form-error');
	}
	
	if(user_phone == '') {
		error = true;
		$('#user_phone').addClass('form-error');
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