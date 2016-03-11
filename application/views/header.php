<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="Directorate of Distance Education, The Universtiy of Burdwan is a leading university with distance mode education in and around the West Bengal, India." />
    <meta name="keywords" content="Directorate of Distance Education,Distance Education,Universtiy of Burdwan,Burdwan,Online,Admission,Result,Online Admission,Online Result,Post Graduate Admission,Post Graduate Result,Students">
    <meta name="author" content="Sutanati Technologies">
    <link rel="shortcut icon" href="<?php echo $this->config->base_url();?>assets/img/favicon.ico" type="image/x-icon">
	<link rel="icon" href="<?php echo $this->config->base_url();?>assets/img/favicon.ico" type="image/x-icon">

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
    
    <!-- Font Awesome  --> 
    <link href="//netdna.bootstrapcdn.com/font-awesome/4.2.0/css/font-awesome.min.css" rel="stylesheet">
    
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
        
        <?php
        	if(isset($this->session->userdata['user'])) {
        ?>
        <div class="navbar-collapse collapse">
          <ul class="nav navbar-nav navbar-right">
            <li><?php echo anchor('users/dashboard', '<i class="fa fa-dashboard"></i> Dashboard');?></li>	
            <li class="dropdown" style="margin-right:0;">
				<a href="#" class="dropdown-toggle" data-toggle="dropdown"><?php echo $this->session->userdata['user']['user_name'];?> <span class="caret"></span></a>
				<ul class="dropdown-menu" role="menu">
					<li class="menu">
						<ul>
							<li><?php echo anchor('users/changepass', '<i class="fa fa-key"></i> Change Password');?></li>
							<li><?php echo anchor('users/logout', '<i class="fa fa-reply"></i> Logout');?></li>
						</ul>
					</li>	<!-- /menu -->
				</ul>	<!-- /dropdown-menu -->		
			</li>	<!-- /dropdown -->
          </ul>
        </div><!--/.navbar-collapse -->
        <?php
			}
        ?>
      </div>
    </div>	<!-- /wrl-navbar -->
    
    <div class="main_content">
		<div class="left-side">
			<?php
				$this->load->view('sidebar');
			?>
		</div>	<!-- /left-side -->
		
		<div class="right-side">
    	
    
