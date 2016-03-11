<div class="container-fluid">
	<div class="row">
		<div class="col-lg-12">
			<div class="page-title">
				<div class="col-lg-8 col-sm-8">
					<h2>Welcome, <?php echo $this->session->userdata['student']['student_name'];?></h2>
				</div>
				<div class="col-lg-4 col-sm-4">
					<h3>Application Number: <?php echo $this->session->userdata('appl_code');?></h3>
				</div>
			</div>	<!-- /heading -->
		</div>
	</div>	<!-- /row -->
	
	<div class="row">
		<div class="col-lg-3 col-sm-3">
			<?php
				$this->load->view('students/sidebar');
			?>
		</div>
		
		<div class="col-lg-9 col-sm-9">
			<h3>Change Password</h3>
			<div class="row btm-mrg-md">
				<div class="col-lg-12 col-sm-12">
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
						echo form_open('students/changepass', $form);
					?>
					<div class="form-group">
						<label>New Password</label>
						<?php
							$appl_passwd = array(
					              					'name'        	=> 'pg_appl_password',
													'id'          	=> 'pg_appl_password',
													'tabindex'      => '1',
													'type'			=>	'password',
													'maxlength'		=> '20',
													'class'			=>	'col-xs-3 col-sm-3'
					            				);
		
							echo form_input($appl_passwd);
						?>
					</div>
					
					<div class="form-group">
						<label>Confirm Password</label>
						<?php
							$appl_passwd = array(
					              					'name'        	=> 'pg_appl_password_cnfrm',
													'id'          	=> 'pg_appl_password_cnfrm',
													'tabindex'      => '2',
													'type'			=>	'password',
													'maxlength'		=> '20',
													'class'			=>	'col-xs-3 col-sm-3'
					            				);
		
							echo form_input($appl_passwd);
						?>
					</div>
			
					<div class="form-group">
						<label>&nbsp;</label>	
						<button type="button" class="btn btn-info change-btn">Change Password</button>
					</div>
					
					<?php	
						echo form_close();
					?>
				</div>
			</div>
		</div>
	</div>	<!-- /row -->		
	
</div>
<?php
	$this->load->view('web_footer');
?>	
<script type="text/javascript">
$(document).on('click','.change-btn',function() {
	$('.error-msg').remove();
	$('input').removeClass('form-error');
	
	var appl_passwd_confirm = $('#appl_passwd_confirm').val();
	var appl_passwd 		= $('#appl_passwd').val();
	
	var error = false;
	var msg = "<h4><strong>Ohh!</strong> Change a few things up and try submitting again.</h4>";
	
	var status = password_validation();
	if(status != ''){
		msg += status;
		error = true;
	}
	if(error) {
		$('#passwdform').before("<div class='error-msg'></div>");
		$('.error-msg').html(msg);
		return false;
	} else {
		$('#passwdform').submit();
	}
});


	function password_validation(){
		var msg = '';
		var flag = true;
		if($("#pg_appl_password").val() == ''){
			msg += "<span><i class='fa fa-arrow-right'></i>Profile Password can't be left blank.</span>"; 
			$('#pg_appl_password').addClass('form-error');
			flag = false;
		}
		if($("#pg_appl_password_cnfrm").val() == ''){
			msg += "<span><i class='fa fa-arrow-right'></i>Confirm Password Can't be blank</span>"; 
			$('#pg_appl_password_cnfrm').addClass('form-error');
			flag = false;
		}
		if(flag == true && $("#pg_appl_password_cnfrm").val() != $("#pg_appl_password").val() ){
			msg += "<span><i class='fa fa-arrow-right'></i>Password should be mathced with confirm password.</span>"; 
			$('#pg_appl_password_cnfrm').addClass('form-error');
			$('#pg_appl_password').addClass('form-error');
		}
		if(flag == true && $("#pg_appl_password").val().length < 6 ){
			msg += "<span><i class='fa fa-arrow-right'></i>Password should be minimum of 6 alpha neumeric character.</span>"; 
			$('#pg_appl_password').addClass('form-error');
		}
		return msg;
	}
</script>		