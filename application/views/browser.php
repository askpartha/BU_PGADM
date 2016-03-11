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

    <!-- main styles -->
    <link rel="stylesheet" href="<?php echo $this->config->base_url();?>assets/css/style.css" />

	<!-- google web fonts -->
    <link href='http://fonts.googleapis.com/css?family=Open+Sans' rel='stylesheet' type='text/css'> <!-- Headings -->
    <link href='http://fonts.googleapis.com/css?family=Droid+Sans' rel='stylesheet' type='text/css' /> <!-- Text -->
    
	<script src="<?php echo $this->config->base_url();?>assets/js/jquery-1.9.1.min.js"></script>
    
</head>

<body> 
    <!-- Static navbar -->
	<div class="navbar navbar-default navbar-fixed-top" role="navigation">
      <div class="container-fluid">
        <div class="navbar-header">
          <a class="navbar-brand" href="<?php echo $this->config->base_url();?>">
          	<img src="<?php echo $this -> config -> base_url(); ?>assets/img/bu_logo60.png" alt="The University of Burdwan">&nbsp;
          	<span class='app-name'><?php echo $this->config->item("app_title");?>, The Universtiy of Burdwan</a></span>
        </div>
      </div>  	
	</div>
	
	<div class="container-fluid">
		<div class="row">
			<div class="col-lg-12 col-sm-12">
				<h3>Download the latest browser</h3>
			</div>
		</div>
	</div>		
	
				
	<div class="container-fluid">
	    <div class="row">
	    	<div class="col-lg-12 col-sm-12">
	    		<h4><img src="<?php echo $this->config->base_url();?>assets/img/firefox.png" alt="Firefox" style="height:48px;"/> <a href="https://www.mozilla.org/en-US/products/download.html?product=firefox-stub&os=win&lang=en-US">from here</a></h4>
	    		<h4><img src="<?php echo $this->config->base_url();?>assets/img/chrome.png" alt="Chrome" style="height:48px;"/> <a href="https://www.google.com/chrome/browser/">from here</a></h4>
	    		<h4><img src="<?php echo $this->config->base_url();?>assets/img/ie.png" alt="Chrome" style="height:48px;"/> <a href="http://windows.microsoft.com/en-in/internet-explorer/download-ie">from here</a></h4>
	    	</div>
		</div>
	</div>			
	
</div> <!-- /main_content -->	

<div style="height:60px;">&nbsp;</div>

<div class="footer top-mrg-md">
	<div class="container-fluid">
		<p>Best viewed in IE 9+, Firefox, Chrome</p>
		<p>Website will down for schedule maintenance every night between 12AM and 12:30 AM IST</p>
	</div>
</div>

</body>
</html>