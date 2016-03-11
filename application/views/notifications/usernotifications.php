<div class="page-title">
	<h2>User Notifications</h2>
	<ul class="breadcrumb">
		<li>You are here:</li>
		<li class="active">Notification </li>
		<li class="">User Notifications</li>
	</ul>
</div>	<!-- /heading -->
<div class="container-fluid">
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
						'id' => 'searchform'
					);	
		echo form_open('notifications/sendusernotifications', $form);
	?>
	<div class="row">
		<div class="col-sm-5">
			<div class="form-group">
				<label>Mobile Number</label>
				<?php
					$notification_number_data = array(
			              					'name'        	=> 'notification_number',
											'id'          	=> 'notification_number',
											'tabindex'      => '1',
											'rows'      => '4',
											'class'			=>	'col-xs-10 col-sm-10'
			            				);

					echo form_textarea($notification_number_data);
				?>
			</div>
			<small>(comma separated & maximum 25 numbers are allowed)</small>
		</div>
	
		<div class="col-sm-5">
			<div class="form-group">
				<label>Message</label>
				<?php
					$notification_message_data = array(
			              					'name'        	=> 'notification_message',
											'id'          	=> 'notification_message',
											'tabindex'      => '2',
											'rows'      => '4',
											'maxlength' => 150,
											'class'			=>	'col-xs-11 col-sm-11'
			            				);

					echo form_textarea($notification_message_data);
				?>
			</div>
			<label id="characterLeft" style="margin-top: -20px; margin-left: -15px;"></label>
		</div>
		<div class="col-sm-2">	
			<div class="form-group">
				<label>&nbsp;</label><label>&nbsp;</label>
				<button type="button" class="btn btn-success notification-btn">Send Notifications</button>
			</div>
		</div>
	</div>
		
		<?php	
			echo form_close();
		?>
	
	
<?php
	$this->load->view('footer');
?>
<script type="text/javascript">
	$('.input-number-comma').keypress(function (key){
		if(key.charCode==0) return true;
		if(key.charCode==44) return true;
		if(key.charCode<48 || key.charCode>57)return false;
	});
	$('.input-number-comma').keydown(function (key){
		if(key.charCode==0) return true;
		if(key.charCode==44) return true;
		if(key.charCode<48 || key.charCode>57)return false;
	});

	$('#characterLeft').text('150 characters left');
	$('#notification_message').keyup(function () {
	    var max = 150;
	    var len = $(this).val().length;
	    if (len >= max) {
	        $('#characterLeft').text(' you have reached the limit');
	    } else {
	        var ch = max - len;
	        $('#characterLeft').text(ch + ' characters left');
	    }
	});

	$('#notification_number').blur(function (key){
		var str = $('#notification_number').val();
		str = str.replace(/,\s*$/, "").replace(/\s+/g, '');
		$('#notification_number').val(str);
	});
	

	$(document).on('click','.notification-btn',function() {
		if(formValidation()){
			jConfirm(confirmMessageTemplate(), 'PLEASE CONFIRM', function(e) {
				if (e) {
					$('#searchform').submit();	
				}
			})
		}
	});	



  function confirmMessageTemplate(){
	var message = 'Would you like to send the notification to the entered numbers. ';
	return message;	
  }



  function formValidation(){
		$('.error-msg').remove();
		$('textarea').removeClass('form-error');
		
		var message = '';
		if($("#notification_message").val().trim()==""){
			message += "Message should not be blank";
			$('#notification_message').addClass('form-error');
		}
		
		if($("#notification_number").val().trim()==""){
			message += "Number should not be blank";
			$('#notification_number').addClass('form-error');
		}else{
			var phnos = $("#notification_number").val().trim();
			var array_nos = phnos.split(",");
			for(var i=0; i<array_nos.length; i++){
				if(array_nos[i].length != 10){
					message += "<br/><b>"+array_nos[i]+ "</b> should be 10 digit only";
				}
			}
		}
		
		if(message == ''){
			return true;
		}else{
			$('#addeditform').before("<div class='error-msg'></div>");
			//$('.error-msg').html(message);
			jAlert('<b>Please check.</b><br/>'+message);
			return false;
		}
		return true;
	}


</script>	