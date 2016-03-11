<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">
    <link rel="shortcut icon" href="favicon.ico" />

    <title><?php echo $this->config->item("app_title") . " - " . $page_title;?></title>

    <!-- Bootstrap framework -->
    <link href="<?php echo $this->config->base_url();?>assets/bootstrap/css/bootstrap.min.css" rel="stylesheet">

    <!-- main styles -->
    <link rel="stylesheet" href="<?php echo $this->config->base_url();?>assets/css/style.css" />
    <link rel="stylesheet" href="<?php echo $this->config->base_url();?>assets/css/jquery.alerts.css" />

	<!-- jquery ui style -->
    <link rel="stylesheet" href="<?php echo $this->config->base_url();?>assets/css/jquery-ui-1.10.3.custom.min.css" />

	<!-- google web fonts -->
    <link href='http://fonts.googleapis.com/css?family=Open+Sans' rel='stylesheet' type='text/css'> <!-- Headings -->
    <link href='http://fonts.googleapis.com/css?family=Droid+Sans' rel='stylesheet' type='text/css' /> <!-- Text -->
    
    <!-- Font Awesome -->   
    <link href="//netdna.bootstrapcdn.com/font-awesome/4.1.0/css/font-awesome.min.css" rel="stylesheet">
    
    <!-- HTML5 shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!--[if lt IE 9]>
      <script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
      <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->
    
</head>

<body> 
    <!-- Static navbar -->
	<div class="navbar navbar-default navbar-fixed-top" role="navigation">
      <div class="container-fluid">
        <div class="navbar-header">
          <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse">
            <span class="sr-only">Toggle navigation</span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
          </button>
          <a class="navbar-brand" href="<?php echo $this->config->base_url();?>">
          	<img src="<?php echo $this -> config -> base_url(); ?>assets/img/bu_logo60.png" alt="The University of Burdwan">&nbsp;
          	<span class='app-name'><?php echo $this->config->item("app_title");?>, The Universtiy of Burdwan</a></span>
        </div>
        
      </div>
    </div>	<!-- /wrl-navbar -->
			
	<div class="container-fluid">
        <div class="row">
        	<div class="col-lg-4 col-sm-4">&nbsp;</div>
        	<div class="col-lg-4 col-sm-4 login-container">
	        	<?php
					if($this->session->flashdata('failure')) {
						echo "<div class='alert alert-danger'>" . $this->session->flashdata('failure') . "</div>";
					}
				?>
	            <div class="box">
	                <?php echo form_open('students/studentlogin', array('id' => 'login_form'));?>
	                	<div class="title">
							<h2>Candidate : Sign In</h2>
						</div>	<!-- /title -->
	                    <div class="content">
	                    	<div class="form-group">
	                    		<label>Application Number</label>
	                    		<?php
									$appl_num = array(
							              					'name'        	=> 'appl_num',
							              					'id'        	=> 'appl_num',
															'value'       	=> '',
															'class'			=>	'col-xs-8'
							            				);
				
									echo form_input($appl_num);
								?>
	                    	</div>
	                    	<div class="form-group">	
		                    	<label>Password</label>
		                    	<?php
									$appl_passwd = array(
							              					'name'        	=> 'appl_passwd',
							              					'id'        	=> 'appl_passwd',
															'type'       	=> 'password',
															'class'			=>	'col-xs-8'
							            				);
				
									echo form_input($appl_passwd);
								?>
		                    </div>
		                    <div class="btm-mrg-sm">	
		                    	<span class="forgot-link"><a href="javascript:void(0);" class="forgot">Forgot your password?</a></span>
								<input class="btn btn-primary pull-right submitbtn btm" type="button" value="Sign In" id="login" />
								<span>&nbsp;</span>
							</div>	
							
						</div>
	                </form>
	                
	                <!-- Forgot Password Form -->
					<?php echo form_open('users/forgot', array('id' => 'fotgot_form', 'style' => 'display:none;'));?>
						<span id="password_msg" class="password">
							
						</span>
						<div class="title">
							<h2>Forgot Password</h2>
						</div>	
						<div id="wait" style="display:none;">
							Password generating ........
						</div>
	                    <div class="content">
	                    	<div class="form-group">
								<label>Application Number</label>
	                    		<input type="text" class="col-sm-12 col-lg-8" name="pg_appl_code" id="pg_appl_code">
	                    	</div>
	                    	<div class="form-group">
								<label>Mobile Number</label>
	                    		<input type="text" class="col-sm-12 col-lg-8 input-number" name="pg_apl_mobile" id="pg_apl_mobile" maxlength="10">
	                    	</div>
	                    	<div class="btm-mrg-sm">
	                    		<span class="back-link"><a href="javascript:void(0);" class="back">Back to login</a></span>
	                    		<input type="button" class="generate-btn btn btn-primary pull-right btn-forgot" value="Send Password">
	                    	</div>	
	                    </div>
	                </form>	
	            </div>
	            <!--
												  <br/>
								<small>Your password is the combination of date of birth and mobile number.<br/>If your date of birth is 12th October 1998 and mobile number is 9876543210,<br/>
									then your password will be <strong>12oct983210</strong>
								</small>-->
				
		                    	
        	</div>	<!-- /login-container-->
        	<div class="col-lg-4 col-sm-4">&nbsp;</div>
        </div>
	        
	</div>			
			
    </body>

	<?php
		$this->load->view('footer');
	?>


	<script type="text/javascript">
	    $(function() {
			$( ".datepicker" ).datepicker({ 
					dateFormat: "dd-mm-yy",
				    showOn: "both",
				    buttonImage: "<?php echo $this->config->base_url();?>assets/img/cal_icon.png",
				    buttonImageOnly: true,
				    changeMonth: true,
					changeYear: true						
			 });
		
		});	
	
		$(document).ready(function(){
	    	$('.forgot').click(function() {
	    		$('#login_form').hide();
	    		$('.forgot-link').hide();
	    		$('#wait').hide();
	    		$('#fotgot_form').show();
	    		$('.back-link').show();
	    		$('.alert').hide();
	    		$('#pg_appl_code').val('');
	    		$('#pg_apl_mobile').val('')
	    		$('.password_msg').html('');
	    		$('.generate-btn').attr('disabled', false);
	    	});
	    	
	    	$('.back').click(function() {
	    		$('#fotgot_form').hide();
	    		$('.back-link').hide();
	    		$('#login_form').show();
	    		$('.forgot-link').show();
	    		$('.alert').hide();
	    	});
	    	
			$('.submitbtn').click(function() {
				$('.alert-error').remove();
				$('input').removeClass('form-error');
				
				var username = $('#appl_num').val();
				var userpass = $('#appl_passwd').val();
				
				var error = false;
				var msg = "<h4><strong>Ohh! there are some problems.</strong></h4>";
				
				if(username == '') {
					error = true;
					msg += "<span><i class='icon-hand-right'></i> Application Number/Enrolment Number can't be blank</span>";
					$('#appl_num').addClass('form-error');
				}
				
				if(userpass == '') {
					error = true;
					msg += "<span><i class='icon-hand-right'></i> Password can't be blank</span>";
					$('#appl_passwd').addClass('form-error');
				}
				
				
				if(error) {
					$('.box').before("<div class='alert alert-error error-msg'></div>");
					$('.error-msg').html(msg);
				} else {
					$('#login_form').submit();
				}
			});	
			
	$('.btn-forgot').click(function() {
				$('.alert-error').remove();
				$('input').removeClass('form-error');
				$('#password_msg').html('');
				
				var pg_appl_code = $('#pg_appl_code').val();
				var pg_apl_mobile = $('#pg_apl_mobile').val();
				
				var error = false;
				var msg = "<h4><strong>Ohh!</strong>Please enter your registered mobile number and application code to get the password.</h4>";
				
				if(pg_appl_code == '') {
					error = true;
					msg += "<span><i class='icon-hand-right'></i> Application code can't be blank</span>";
					$('#pg_appl_code').addClass('form-error');
				}
				if(pg_apl_mobile == '') {
					error = true;
					msg += "<span><i class='icon-hand-right'></i> Mobile number can't be blank</span>";
					$('#pg_apl_mobile').addClass('form-error');
				}
				
				if(error) {
					//$('.login-container').before("<div class='alert alert-error error-msg' style='width:400px;margin-left:auto;margin-right:auto;margin-bottom:20px;'></div>");
					$('.box').before("<div class='alert alert-error error-msg'></div>");
					$('.error-msg').html(msg);
				} else {
					//$('#fotgot_form').submit();
					$('#wait').show();
					var params = "pg_appl_code="+pg_appl_code+"&pg_apl_mobile="+pg_apl_mobile;
					$('.generate-btn').attr('disabled', true);
					$.ajax({
							url: "<?php echo $this->config->base_url();?>students/forgotpass/"+new Date().getTime(),
							type: "post",
							data: params,
							dataType: "html",
							success: function(response){
								//show message
								//$('.passwd').show();
								$('#password_msg').html(response);
								$('#wait').hide();
								$('.generate-btn').attr('disabled', false);
							 }
						});
					
				}
			});				    	
	    });
	</script>            	

</html>