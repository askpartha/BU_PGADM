<div class="page-title">
	<h2>Group Notifications</h2>
	<ul class="breadcrumb">
		<li>You are here:</li>
		<li class="active">Notification </li>
		<li class="">Group Notifications</li>
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
		echo form_open('notifications/sendgroupnotifications', $form);
	?>
	<div class="row">
		<div class="col-sm-5">
			<div class="form-group">
				<label>Subject</label>
				<?php
					$subject_data = 'id="pg_subj_code" class="col-xs-10"';				
					echo form_dropdown('pg_subj_code', $subject_options, null, $subject_data);
				?>
			</div>
			<div class="form-group">
				<label>Application Status</label>
				<?php
					$status_data = 'id="pg_appl_status" class="col-xs-10"';				
					echo form_dropdown('pg_appl_status', $status_options, null, $status_data);
				?>
			</div>
			<div class="form-group">
				<label>Extra Reservation</label>
				<?php
					$resv_data = 'id="extra_resv" class="col-xs-10"';				
					echo form_dropdown('extra_resv', $extra_resv_options, null, $resv_data);
				?>
			</div>
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
		$('select').removeClass('form-error');
		
		var message = '';
		if($("#notification_message").val().trim()==""){
			message += "<br/>Message should not be blank";
			$('#notification_message').addClass('form-error');
		}
		if($("#pg_subj_code").val().trim()=="EMPTY"){
			message += "<br/>Please select atleast one subject";
			$('#pg_subj_code').addClass('form-error');
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