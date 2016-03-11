<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="The Universtiy of Burdwan is a leading university in  West Bengal, India." />
    <meta name="keywords" content="Universtiy of Burdwan,Burdwan,Online,Admission,Result,Online Admission,Online Result,Post Graduate Admission,Post Graduate Result,Students">
    <meta name="author" content="Partha Sarathi Ghosh, parthaghosh.wb@gmail.com">
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
    
    <!-- Font Awesome -->   
    <link href="//maxcdn.bootstrapcdn.com/font-awesome/4.2.0/css/font-awesome.min.css" rel="stylesheet">
    
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
        
        <div class="navbar-collapse collapse">
          <ul class="nav navbar-nav navbar-right">
          	<li><?php echo anchor('/', '<i class="fa fa-home"></i> Home');?></li>
          	<?php
	        	if(isset($this->session->userdata['student'])) {
	        ?>
            <li><?php echo anchor('students/dashboard', '<i class="fa fa-dashboard"></i> Dashboard');?></li>
            <li><?php echo anchor('users/logout', '<i class="fa fa-reply"></i> Logout');?></li>	
            <?php
				}
	        ?>
          </ul>
        </div><!--/.navbar-collapse -->
        
      </div>
    </div>	<!-- /wrl-navbar -->
    
    <div class="wrapper">