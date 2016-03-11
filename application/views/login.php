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
          	<span class='app-name'><?php echo $this->config->item("app_title");?></a></span>
        </div>
        
      </div>
    </div>	<!-- /wrl-navbar -->
			
	<div class="container-fluid">
        <div class="row">
        	<div class="col-lg-4 col-sm-4"></div>
        	<div class="col-lg-4 col-sm-4 login-container">
	        	<?php
					if($this->session->flashdata('failure')) {
						echo "<div class='alert alert-danger'>" . $this->session->flashdata('failure') . "</div>";
					}
				?>
	            <div class="box">
	                <?php echo form_open('users/login', array('id' => 'login_form'));?>
	                	<div class="title">
							<h2>Sign In</h2>
						</div>	<!-- /title -->
	                    <div class="content">
	                    	<div class="form-group">
	                    		<label>Username</label>
	                    		<input type="text" class="col-sm-12 col-lg-12" name="username" id="username">
	                    	</div>
	                    	<div class="form-group">	
		                    	<label>Password</label>
		                    	<input type="password" class="col-sm-12 col-lg-12" name="userpass" id="userpass">
		                    </div>
		                    <div class="btm-mrg-sm">	
		                    	<!--span class="forgot-link"><a href="javascript:void(0);" class="forgot">Forgot your password?</a></span-->
								<input class="btn btn-primary pull-right submitbtn" type="button" value="Sign In" id="login" />
								<span>&nbsp;</span>
							</div>	
							
						</div>
	                </form>
	                
	                <!-- Forgot Password Form -->
					<?php echo form_open('users/forgot', array('id' => 'fotgot_form', 'style' => 'display:none;'));?>
						<div class="title">
							<h2>Forgot Password</h2>
						</div>	<!-- /title -->
	                    <div class="content">
	                    	<div class="form-group">
								<label>Email Address</label>
	                    		<input type="text" class="col-sm-12 col-lg-12" name="email" id="email">
	                    	</div>
	                    	<div class="btm-mrg-sm">
	                    		<span class="back-link"><a href="javascript:void(0);" class="back">Back to login</a></span>
	                    		<input type="button" class="btn btn-primary pull-right btn-forgot" value="Send">
	                    	</div>	
	                    </div>
	                </form>
	            </div>
        	</div>	<!-- /login-container-->
        	<div class="col-lg-4 col-sm-4"></div>
        </div>
	        
	</div>			
			
    </body>

    <script src="<?php echo $this->config->base_url();?>assets/js/jquery-1.9.1.min.js"></script>
	<script src="<?php echo $this->config->base_url();?>assets/bootstrap/js/bootstrap.min.js"></script>
	<script type="text/javascript">
		$(document).ready(function(){
	    	$('.forgot').click(function() {
	    		$('#login_form').hide();
	    		$('.forgot-link').hide();
	    		$('#fotgot_form').show();
	    		$('.back-link').show();
	    		$('.alert').hide();
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
				
				var username = $('#username').val();
				var userpass = $('#userpass').val();
				
				var error = false;
				var msg = "<h4><strong>Ohh! there are some problems.</strong></h4>";
				
				if(username == '') {
					error = true;
					msg += "<span><i class='icon-hand-right'></i> Username can't be blank</span>";
					$('#username').addClass('form-error');
				}
				
				if(userpass == '') {
					error = true;
					msg += "<span><i class='icon-hand-right'></i> Password can't be blank</span>";
					$('#userpass').addClass('form-error');
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
				
				var email = $('#email').val();
				
				var error = false;
				var msg = "";//<h4><strong>Ohh!</strong> Please enter your email address to get the password.</h4>";
				
				if(email == '') {
					error = true;
					msg += "<span><i class='icon-hand-right'></i> Email address can't be blank</span>";
					$('#username').addClass('form-error');
				}
				
				
				if(error) {
					$('.box').before("<div class='alert alert-error error-msg'></div>");
					$('.error-msg').html(msg);
				} else {
					$('#fotgot_form').submit();
				}
			});				    	
	    });
	</script>            	

</html>