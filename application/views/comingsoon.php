<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">
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
    
    <div class="main_content">
			
		<div class="container-fluid">
	        <div class="row">
	        	<div class="col-lg-12 col-sm-12 top-mrg-lg btm-mrg-lg" style="text-align:center;margin-top:100px;height:400px;">
					<h1>Launching Today, 4th September 2014</h1>
					<h4>Please check after some time.</h4>
				</div>
			</div>
		</div>	
		
	</div>


		
    </body>

    <script src="<?php echo $this->config->base_url();?>assets/js/jquery-1.9.1.min.js"></script>
	<script src="<?php echo $this->config->base_url();?>assets/bootstrap/js/bootstrap.min.js"></script>
	<script src="<?php echo $this->config->base_url();?>assets/js/jquery.alerts.js"></script>
	<script type="text/javascript">
		$(document).ready(function(){
			if (document.all && !document.addEventListener) {
			    jAlert('You are using the old version of browser.', 'Oops');
			    setTimeout(function() {
				      location.href = '<?php echo $this->config->base_url();?>welcome/browser';
				}, 5000);
			    
			}
					
		});
</script>
</html>