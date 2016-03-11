<div class="page-title">
	<h2>Change Password</h2>
	<ul class="breadcrumb">
		<li>You are here:</li>
		<li class="active">Change Password</li>
	</ul>
</div>	<!-- /heading -->

<div class="container-fluid">
	<div class="row">
		<?php
			if($this->session->flashdata('success')) {
				echo "<div class='alert alert-success action-message'>" . $this->session->flashdata('success') . "</div>";
			} else if($this->session->flashdata('failure')) {
				echo "<div class='alert alert-danger action-message'>" . $this->session->flashdata('failure') . "</div>";
			}
		?>
		<?php
			$form = array(
							'class'	=>	'form-horizontal lft-pad-nm',
							'role'	=>	'form',
							'id' => 'passwdform'
						);	
			echo form_open('users/changepass', $form);
		?>
		<div class="row">
			<div class="col-sm-4">
				<div class="form-group">
					<label>New Password</label>
					<input type="password" class="col-sm-8 col-lg-8" name="user_password" id="user_password" value="" maxlength="15">
				</div>
			</div>
		</div>
		<div class="row">
			<div class="col-sm-4">
				<div class="form-group">
					<label>Confirm Password</label>
					<input type="password" class="col-sm-8 col-lg-8" name="user_password_confirm" id="user_password_confirm" value="">
				</div>
			</div>
		</div>
		<div class="row">
			<div class="col-sm-4">
				<div class="form-group">
					<button type="button" class="btn btn-success change-btn">Change</button>
				</div>
			</div>
		</div>
		
		<?php	
			echo form_close();
		?>	
	</div>
</div>

<?php
	$this->load->view('footer');
?>	
<script type="text/javascript">
$(document).on('click','.change-btn',function() {
	$('.error-msg').remove();
	$('input').removeClass('form-error');
	
	var msg = "<h4><strong>Ohh!</strong> Change a few things up and try submitting again.</h4>";
	var user_password =  $('#user_password').val();;
	var user_password_confirm =  $('#user_password_confirm').val();;
	
	var error = false;	
	if(user_password == '') {
		error = true;
		$('#user_password').addClass('form-error');
	}
	if(user_password_confirm == '') {
		error = true;
		$('#user_password_confirm').addClass('form-error');
	}
	if(user_password.length < 6 ){
		msg += '<h5>Password should be minimum length of 6 digit.</h5>';
		error = true;
		$('#user_password').addClass('form-error');
	}else{
		if(user_password != user_password_confirm){
			msg += '<h5>Password should be matched with confirm password.</h5>';
			error = true;
			$('#user_password_confirm').addClass('form-error');
		}
	}
	
	if(error) {
		$('#passwdform').before("<div class='error-msg'></div>");
		$('.error-msg').html(msg);
		return false;
	} else {
		$('#passwdform').submit();	
	}
	
});	
</script>	