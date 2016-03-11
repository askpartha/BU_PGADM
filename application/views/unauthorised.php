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
				if(isset($this->session->userdata['user'])) {
					$this->load->view('sidebar');
				}	
			?>
		</div>	<!-- /left-side -->
		
		<div class="right-side">
			
			<h1 class="heading top-mrg-lg" style="color: #B94A48;">Sorry, you don't have permission to access the page</h1>
			<div>Click <a href="<?php echo $this->config->base_url();?>users/login">here</a>, to go back.</div>
						
		</div> <!-- /right-side -->
	</div> <!-- /main_content -->	

<div style="height:60px;">&nbsp;</div>

<div class="footer top-mrg-md">
	<div class="container-fluid">
    	<p>Best viewed in IE 9+, Firefox, Chrome</p>
    	<p>Website will down for schedule maintenance every night between 12AM and 12:30 AM IST</p>
  	</div>
</div>

<script src="<?php echo $this->config->base_url();?>assets/js/jquery-1.9.1.min.js"></script>
<script src="<?php echo $this->config->base_url();?>assets/js/jquery-ui-1.10.3.custom.min.js"></script>
<script src="<?php echo $this->config->base_url();?>assets/bootstrap/js/bootstrap.min.js"></script>
<script src="<?php echo $this->config->base_url();?>assets/js/tipsy.js"></script>
<script src="<?php echo $this->config->base_url();?>assets/js/jquery.alerts.js"></script>

<script type="text/javascript">
	jQuery(document).ready(function(){  
	 
	 	if (document.all && !document.addEventListener) {
		    jAlert('You are using the old version of browser.', 'Oops');
		    setTimeout(function() {
			      location.href = '<?php echo $this->config->base_url();?>welcome/browser';
			}, 5000);
		}
		
		//toggle sidebar based on the window size
		if($(window).width() > 979){
			$('body').removeClass('sidebar_hidden');
			$('.sidebar_switch').removeClass('off_switch').addClass('on_switch');
		} else {
			$('body').addClass('sidebar_hidden');
			$('.sidebar_switch').removeClass('on_switch').addClass('off_switch');
		}			 
	 
	 	//* sidebar visibility switch
        $('.sidebar_switch').click(function(){
            $('.sidebar_switch').removeClass('on_switch off_switch');
            if( $('body').hasClass('sidebar_hidden') ) {
                $('body').removeClass('sidebar_hidden');
                $('.sidebar_switch').addClass('on_switch').show();
                $('.sidebar_switch').attr( 'title', "Hide Sidebar" );
            } else {
                $('body').addClass('sidebar_hidden');
                $('.sidebar_switch').addClass('off_switch');
                $('.sidebar_switch').attr( 'title', "Show Sidebar" );
            };
			$(window).resize();
        });
        
        fixHeight();
        
		$('.tooltip-label').tipsy({gravity: 's', fade: true});

    });  

	function fixHeight() {
		//Get window height and the wrapper height
        var height = $(window).height() - $("body > .wrl-navbar").height() - ($("body > .footer").outerHeight() || 0);
        $(".main_content").css("min-height", height + "px");
        var content = $(".main_content").height();
        //If the wrapper height is greater than the window
        if (content > height)
            //then set sidebar height to the wrapper
            $(".left-side, html, body").css("min-height", content + "px");
        else {
            //Otherwise, set the sidebar to the height of the window
            $(".left-side, html, body").css("min-height", height + "px");
        }
	}
    
    $(function() {
			$( ".datepicker" ).datepicker({ 
					dateFormat: "dd-mm-yy",
				    showOn: "both",
				    buttonImage: "<?php echo $this->config->base_url();?>assets/img/cal_icon.png",
				    buttonImageOnly: true,
				    changeMonth: true,
					changeYear: true,
					yearRange:'<?php echo date('Y', strtotime('-50 years'));?>:<?php echo date('Y');?>',
					maxDate: '<?php echo date('d-m-Y');?>'								
			 });
		
		$('a.tipsy').tipsy({trigger: 'hover', gravity: 's', opacity: 0.9});
	});	 
	
		
	$(document).on('click','.search-btn',function() {
		$('#search-form').submit();		
	});	

</script>
		
    </body>
</html><!-- rendered in {elapsed_time} seconds -->					