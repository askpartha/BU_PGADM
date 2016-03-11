<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <!--[if IE]><meta http-equiv='X-UA-Compatible' content='IE=edge,chrome=1'><![endif]-->
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content=" The Universtiy of Burdwan is a leading university with distance mode education in and around the West Bengal, India." />
    <meta name="keywords" content="Universtiy of Burdwan,Burdwan,Online,Admission,Result,Online Admission,Online Result,Post Graduate Admission,Post Graduate Result,Students">
    <meta name="author" content="Partha Sarathi Ghosh">
    <link rel="shortcut icon" href="<?php echo $this->config->base_url();?>assets/img/favicon.ico" type="image/x-icon">
	<link rel="icon" href="<?php echo $this->config->base_url();?>assets/img/favicon.ico" type="image/x-icon">

    <title><?php echo $this->config->item("app_title") . " - " . $page_title;?></title>

    <!-- Bootstrap framework -->
    <link href="<?php echo $this->config->base_url();?>assets/bootstrap/css/bootstrap.min.css" rel="stylesheet">

    <!-- main styles -->
    <link rel="stylesheet" href="<?php echo $this->config->base_url();?>assets/css/style.css" />
    <link rel="stylesheet" href="<?php echo $this->config->base_url();?>assets/css/home.css" />
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
        <div class="navbar-header" style="width: 100%">
          <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse">
            <span class="sr-only">Toggle navigation</span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
          </button>
          <a class="navbar-brand" href="<?php echo $this->config->base_url();?>">
          	<img src="<?php echo $this->config->base_url();?>assets/img/bu_logo120.png" alt="The University of Burdwan">&nbsp;
          	<span class='app-name'><?php echo $this->config->item("app_title");?></span>
          	</a>          	
        </div>
        
      </div>
    </div>	<!-- /wrl-navbar -->
			
	<div class="container-fluid">
        <div class="row">
        	<div class="col-lg-6 col-sm-6 left_content">
        		<!-- left_content-->
        	</div>
        	
        	<div class="col-lg-6 col-sm-6 right_content">
        		<h3 class="top-mrg-md">From Vice Chancellor's Desk</h3>
				<p>
				I am happy to launch the programme of on-line admission to Post-Graduate Courses to the University of Burdwan 
				for the session 2015-17. By clicking the mouse of your computer, students would now be able to meet all queries 
				with regard to post graduate studies. This would enable them to submit the application, monitor their 
				position on the merit list and make the payment of fees.</p>

				<p>Our intention is to make the system absolutely transparent and a zero tolerant exercise with regard to 
					discrimination and suppression of fact.</p>

				<p>I welcome you, our prospective students, their guardians and all other stakeholders of the university 
					to make the best use of the system. I would also seek your cooperation to bear with us in the event of 
					encountering a technical snag or two, sometimes beyond our control.</p>

				<p>Let's log on to the new era of technology.</p>
				
				<p>
					<b>Prof. Smritikumar Sarkar</b>	
				</p>
				<p>
					<b>25-July-2015, Burdwan</b>	
				</p>
				
				<div class="row">
					&nbsp;&nbsp;
					<a href="<?php echo $this->config->base_url();?>admissions/instructions" class="btn btn-success">General Instruction</a>
					&nbsp;&nbsp;
					<!--
					<a href="<?php echo $this->config->base_url();?>admissions/pgadmstepone" class="btn btn-success">Application form</a>
					&nbsp;&nbsp;
					-->
					<a href="<?php echo $this->config->base_url();?>students/studentlogin" class="btn btn-success">Login to Student Profile</a>
					&nbsp;&nbsp;
					<a href="<?php echo $this->config->base_url();?>students/results" class="btn btn-success"><span id="blink">Result</span></a>
		        </div>
		        <div class="row">
		        	<br/>
		        	&nbsp;&nbsp;
		        	<font style="color: RED; background-color:YELLOW; font-weight: bold">
		        		WRITTEN TEST RESULT AND RANK LIST OF PHILOSOPHY ARE AVAILABLE. PLEASE CHECK RESULT TAB. <br/>
		        		&nbsp;&nbsp; ADMISSION DATE of PHILOSOPHY (40% CATEGORY) - 10-SEPT-2015 & 11-SEPT-2015.		        		
		        	</font>
		        </div>
        	</div>
        	<div class="col-lg-2 col-sm-2 ">
        		<!-- left_content-->
        	</div>
        </div>
        
        
	</div>			
	
	<div class="footer top-mrg-sm">
		<div class="container-fluid">
	    	<p>Best viewed in IE 9+, Firefox, Chrome</p>
	    	<p>Copyright @2015, Burdwan University</p>
	  	</div>
	</div>	
		
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
			
		  	setTimeout("blinkFont()",500)
		});
		
		function blinkFont(){
		  document.getElementById("blink").style.color="yellow"
		  setTimeout("setblinkFont()",1000)
		}
		
		function setblinkFont(){
		  document.getElementById("blink").style.color=""
		  setTimeout("blinkFont()",1000)
		}
		
	</script>
</body>
</html>