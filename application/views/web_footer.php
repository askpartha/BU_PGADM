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

	$('.input-number').keypress(function (key){
		if(key.charCode==0) return true;
		if(key.charCode<48 || key.charCode>57 )return false;
	});
	$('.input-number').keydown(function (key){
		if(key.charCode==0) return true;
		if(key.charCode<48 || key.charCode>57 )return false;
	});

	//make all the input text box value as upper case
	$('.input-number').keypress(function (key){
		if(key.charCode==0) return true;
		if(key.charCode<48 || key.charCode>57 )return false;
	});
	$('.input-number').keydown(function (key){
		if(key.charCode==0) return true;
		if(key.charCode<48 || key.charCode>57 )return false;
	});
	$('.input-number-decimal').keyup(function (){
		var $this = $(this);
    	$this.val($this.val().replace(/[^\d.]/g, ''));
	});
	
	$('input').bind('keypress',function(event) {
		if(event.charCode == 39 || event.charCode == 34 || event.charCode == 96 || event.charCode == 126 || event.charCode==42 || event.charCode==37){
			jAlert('This special character not allowd.');
			return false;
		}
	});
	
</script>
		
    </body>
</html><!-- rendered in {elapsed_time} seconds -->