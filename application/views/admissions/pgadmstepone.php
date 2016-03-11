<div class="page-title">
	
</div>	
<div class="container-fluid">
	<div class="row" style="height: 480px;">
		<div class="col-sm-8 data-content" style="height: 100%; overflow-y: auto;">
			<h2 style="text-align: center">Application Instruction</h2>
			<h3 style="text-align: center">Online Application For Admission To M.A/M.Sc./M.Com.<?php echo getCurrentSession();?></h3>
			<hr/>
			<div class="row">
				<div class="col-sm-12">
					<!--<h4><?php echo $application_notices[$i]['notice_title'] ;?></h4>-->
					<ol >
					<?php
					for($i=0; $i<count($application_notices); $i++){
					?>
					<li><?php echo $application_notices[$i]['notice_desc'] ;?></li>
					<?php	
					}
					?>
					</ol>
				</div>
			</div>
		</div>
		<div class="col-sm-4">
			<?php
				if($this->session->flashdata('success')) {
					echo "<div class='alert alert-success action-message'>" . $this->session->flashdata('success') . "</div>";
				} else if($this->session->flashdata('failure')) {
					echo "<div class='alert alert-danger action-message'>" . $this->session->flashdata('failure') . "</div>";
				}
			?>	
			<!-- Form Data Entered Here-->
			<?php
				$form = array(
								'class'	=>	'form-horizontal lft-pad-nm',
								'role'	=>	'form',
								'id' => 'addeditform'
							);	
				echo form_open('admissions/submitpgstepone', $form);
			?>
			
			<div class="row">
				<div class="col-lg-6 col-sm-6">
					<div class="form-group">
						<label>Student From</label>
						<?php
							$university_ctgr_data = 'id="pg_appl_ctgr" tabindex="2" class="col-xs-11"';				
							echo form_dropdown('pg_appl_ctgr', $university_ctgry_options, null, $university_ctgr_data);
						?>
					</div>
				</div>	
			
				<div class="col-lg-6 col-sm-6">
					<div class="form-group">
						<label>Subject Applied For</label>
						<?php
							$pg_subj_data = 'id="pg_appl_subj" tabindex="3" class="col-xs-11"';				
							echo form_dropdown('pg_appl_subj', $subject_options, null, $pg_subj_data);
						?>
					</div>
				</div>
			</div>
			
			<div class="row">
				<div class="col-lg-12 col-sm-12">
					<div class="form-group">
						<label>Applicant's Full Name</label>
						<?php
							$pg_appl_name = array(
													'name'	=> 'pg_appl_name', 	
													'id'	=> 'pg_appl_name',
													'value' =>  '',	
													'maxlength'=>'50',	
													'tabindex'=>"4",						
													'class'	=>	'col-xs-11 col-sm-11'
					            				);
							echo form_input($pg_appl_name);
						?>
					</div>
				</div>	
			</div>
			<div class="row">
				<div class="col-lg-6 col-sm-6">
					<div class="form-group">
						<label>Gender</label>
						<?php
							$gender_data = 'id="pg_appl_gender" tabindex="5" class="col-xs-11"';				
							echo form_dropdown('pg_appl_gender', $gender_options, null, $gender_data);
						?>
					</div>
				</div>
				<div class="col-lg-6 col-sm-6">
			    	<div class="form-group">
						<label>Reservation</label>
						<?php
							$pg_appl_reservation = 'id="pg_appl_reservation" class="col-xs-10" tabindex="1"';				
							echo form_dropdown('pg_appl_reservation', $reservation_options, null, $pg_appl_reservation);
						?>
					</div>
				</div>	
			</div>
			<div class="row">
				<div class="col-lg-6 col-sm-6">
					<div class="form-group">
						<label>Graduation Subject Major/Honors</label>
						<select id="pg_appl_grad_major_subj" name="pg_appl_grad_major_subj" tabindex="7", class="col-xs-11"></select>
					</div>
				</div>
				
				<div class="col-lg-6 col-sm-6">
					<div class="form-group">
						<label>Graduation Subject Minor/Pass</label>
						<select id="pg_appl_grad_minor_subj" name="pg_appl_grad_minor_subj" tabindex="8", class="col-xs-11"></select>
					</div>
				</div>
				
			</div>
			<div class="row">
				<div class="col-lg-12 col-sm-12">
					<div class="form-group">
						<label>Graduation University <small style="font-weight: normal">(use down arrow to select the university from list)</small></label>
						<?php
							$university_data = 'id="pg_appl_grad_org" tabindex="9" class="col-xs-11"';				
							echo form_dropdown('pg_appl_grad_org', $university_options, 'EMPTY', $university_data);
						?>
					</div>
				</div>
			</div>
			<div class="row">
				<div class="col-lg-6 col-sm-6">
					<div class="form-group">
						<label>Graduation Passing Year</label>
						<?php
							$pg_appl_grad_pyear = array(
													'name'	=> 'pg_appl_grad_pyear', 	
													'id'	=> 'pg_appl_grad_pyear',
													'value' => '',	
													'maxlength'=>'4',	
													'tabindex'=>"10",						
													'class'	=>	'col-xs-11 col-sm-11 input-number'
					            				);
							echo form_input($pg_appl_grad_pyear);
						?>
					</div>
				</div>
				<div class="col-lg-6 col-sm-6">
					<div class="form-group">
						<label>Graduation Percentage</label>
						<?php
							$pg_appl_grad_pct = array(
													'name'	=> 'pg_appl_grad_pct', 	
													'id'	=> 'pg_appl_grad_pct',
													'value' => '',	
													'maxlength'=>'6',	
													'tabindex'=>"11",						
													'class'	=>	'col-xs-11 col-sm-11 input-number-decimal pc_marks'
					            				);
							echo form_input($pg_appl_grad_pct);
						?>
					</div>
				</div>
			</div>
			
			<div class="container-fluid">
				<div class="row">
					<div class="col-lg-12 col-sm-12 top-mrg-md" style="padding-left: 0;">
						<button type="button" class="btn btn-default cancel-btn">Cancel</button>
						<button type="button" class="btn btn-success save-btn">Proceed..</button>&nbsp;
						<input type="hidden" name="form_action" id="form_action" value="add">
					</div>
				</div>
			</div>
			
			<?php	
				echo form_close();
			?>	
		</div>
	</div>
</div>

<?php
	$this->load->view('footer');
?>		

<script type="text/javascript">


	//onchange university category graduation university will change to Burdwan University 
	//automatically and vice versa will also be applied
	$("#pg_appl_ctgr").on('change',function() {
		if($("#pg_appl_ctgr").val() == 'BU'){
			$("#pg_appl_grad_org").val('525');
		}else{
			$("#pg_appl_grad_org").val('EMPTY');
		}
	});	
	
	$("#pg_appl_grad_org").on('change',function() {
		if($("#pg_appl_grad_org").val() == '525'){
			$("#pg_appl_ctgr").val('BU');
		}else{
			$("#pg_appl_ctgr").val('OU');
		}
	});		
	
	//onchange on applied subject other ug subject lists are populated	
	$("#pg_appl_subj").on('change',function() {
		setGraduationMajorSubject('');
	});	
	
	$("#pg_appl_grad_major_subj").on('change',function() {
		setGraduationMinorSubject('');
	});	
	
	function setGraduationMajorSubject(subjcode){
		var pg_appl_subj = '';
		if(subjcode == ''){
			pg_appl_subj = $("#pg_appl_subj").val();
		}else{
			pg_appl_subj = subjcode;
		}
		
		var params = "pg_appl_subj="+pg_appl_subj;
		$.ajax({
			url: "<?php echo $this->config->base_url();?>admissions/getUGMajorSubjects",
			type: "post",
			data: params,
			dataType: "json",
			success: function(response){
				//console.log(response);
				SetOptionUGSubject(response, 'pg_appl_grad_major_subj');
			 }
		});
	}
	
	function setGraduationMinorSubject(subjcode){
		var pg_appl_grad_major_subj = '';
		if(subjcode == ''){
			pg_appl_grad_major_subj = $("#pg_appl_grad_major_subj").val();
		}else{
			pg_appl_grad_major_subj = subjcode;
		}
		
		var params = "pg_appl_grad_major_subj="+pg_appl_grad_major_subj;
		$.ajax({
			url: "<?php echo $this->config->base_url();?>admissions/getUGMinorSubjects",
			type: "post",
			data: params,
			dataType: "json",
			success: function(response){
				//console.log(response);
				SetOptionUGSubject(response, 'pg_appl_grad_minor_subj');
			 }
		});
	}
	
	function SetOptionUGSubject(data, ids){
		var hons_subjects = data;
		
		$("#"+ids).html('');
		var subjs = "<option value='EMPTY'></option>";
		for(var i=0; i<data.length; i++){
			subjs += '<option value="'+data[i]['ug_subj_code']+'">'+data[i]['ug_subj_name']+'</option>';
		}
		$("#"+ids).html(subjs);
	}
	
	
	//onclick on Proceed button form information will be stored into session and control will navigate to next page.
	$(document).on('click','.save-btn',function() {
		if(formValidationStepOne()){
			jConfirm(confirmMessageTemplate(), $('#pg_appl_name').val()+' PLEASE CONFIRM', function(e) {
				if (e) {
					$('#addeditform').submit();	
				}
			})
		}
	});	
	
	
	
	$(document).on('click','.cancel-btn',function() {
		reset_form_one();;
	});	
	
	
	//this template message shown into the confirm message at the time of form submission.
	function confirmMessageTemplate(){
		var message = 'Are you sure want to submit the form with the below information. ';
			message += '\n Once application submited can\'t be revoked. ';
			message += '\n Don\'t use back button or press F5. ';
		    message += '<table cellpadding="5px;">';
			message += '<tr><td><b>Applied courses:</b></td><td>' + $('#pg_appl_subj').val() + '</td></tr>';
			message += '<tr><td><b>Graduation %</b></td><td>'     + $('#pg_appl_grad_pct').val() + '</td></tr>';
			message += '</table>';
		    
		 return message;
	}
	
	function formValidationStepOne(){
		$('.error-msg').remove();
		$('input').removeClass('form-error');
		$('select').removeClass('form-error');
		$('input:checkbox').removeClass('form-error');
		
		var message = '';
		message += formValidationGeneralStepOne();
		message += formValidationGraduationStepOne();
		
		if(message == ''){
			return true;
		}else{
			$('#addeditform').before("<div class='error-msg'></div>");
			//$('.error-msg').html(message);
			jAlert(' <b>Your form contains some error. Please check.</b>'+message+'');
			return false;
		}
	}
	
	//step one form validation for general
	function formValidationGeneralStepOne(){
		var msg = '';
		if($("#pg_appl_subj").val() == '' || $("#pg_appl_subj").val() ==  'EMPTY'){
			msg += "<li><i class='fa fa-arrow-right'></i>Please Select Subject Applied for Post Graduate Admission.</li>"; 
			$('#pg_appl_subj').addClass('form-error');
		}
		if($("#pg_appl_name").val() == '' ){
			msg += "<li><i class='fa fa-arrow-right'></i>Name Can't Be Blank.</li>"; 
			$('#pg_appl_name').addClass('form-error');
		}
		if($("#pg_appl_reservation").val() == '' ){
			msg += "<li><i class='fa fa-arrow-right'></i>Date Of Birth Can't Be Blank..</li>"; 
			$('#pg_appl_reservation').addClass('form-error');
		}
		if($("#pg_appl_gender").val() == '' || $("#pg_appl_gender").val() ==  'EMPTY'){
			msg += "<li><i class='fa fa-arrow-right'></i>Please Select Gender.</li>"; 
			$('#pg_appl_gender').addClass('form-error');
		}
		return msg;
	}
	
	//step one form validation for graduation
	function formValidationGraduationStepOne(){
		var msg = '';
		if($("#pg_appl_grad_org").val() == '' || $("#pg_appl_grad_org").val() ==  'EMPTY'){
			msg += "<li><i class='fa fa-arrow-right'></i>Please select university at the time of graduation.</li>"; 
			$('#pg_appl_grad_org').addClass('form-error');
		}
		if($("#pg_appl_grad_pyear").val() == '' ){
			msg += "<li><i class='fa fa-arrow-right'></i>Graduation passing year can't be blank.</li>"; 
			$('#pg_appl_grad_pyear').addClass('form-error');
		}
		if($("#pg_appl_grad_pct").val() == '' ){
			msg += "<li><i class='fa fa-arrow-right'></i>Percentage of graduation can't be blank.</li>"; 
			$('#pg_appl_grad_pct').addClass('form-error');
		}
		if($("#pg_appl_grad_major_subj").val() == '' 			|| $("#pg_appl_grad_major_subj").val() == 'EMPTY' 	|| 
			 $("#pg_appl_grad_major_subj").val() == 'null' 		|| $("#pg_appl_grad_major_subj").val() == null 		||
			 $("#pg_appl_grad_major_subj").val() == undefined 	|| $("#pg_appl_grad_major_subj").val() == 'undefined'){
			msg += "<li><i class='fa fa-arrow-right'></i>Honours subject of graduation can't be blank.</li>"; 
			$('#pg_appl_grad_major_subj').addClass('form-error');
		}
		return msg;
	}
	

	function onload_form(){
		reset_form_one();
		fill_form_with_updated_value();
	}
	
	
	
	function fill_form_with_updated_value(){
		$("#pg_appl_ctgr").val("<?php echo $_pg_appl_ctgr; ?>");
		$("#pg_appl_reservation").val ("<?php echo $_pg_appl_reservation; ?>");
		$("#pg_appl_name").val ("<?php echo $_pg_appl_name; ?>");
		$("#pg_appl_gender").val ("<?php echo $_pg_appl_gender; ?>");
		$("#pg_appl_subj").val ("<?php echo $_pg_appl_subj; ?>");
		$("#pg_appl_grad_org").val("<?php echo $_pg_appl_grad_org; ?>");
		
		setGraduationMajorSubject("<?php echo $_pg_appl_subj; ?>");
		
		$("#pg_appl_grad_major_subj").val("<?php echo $_pg_appl_grad_major_subj; ?>");

		setGraduationMinorSubject("<?php echo $_pg_appl_grad_major_subj; ?>");

		$("#pg_appl_grad_pct").val("<?php echo $_pg_appl_grad_pct; ?>");
		$("#pg_appl_grad_pyear").val("<?php echo $_pg_appl_grad_pyear; ?>");
		
	}
	
	function reset_form_one(){
		$("#pg_appl_ctgr").val('EMPTY');
		$("#pg_appl_reservation").val('EMPTY');
		$("#pg_appl_name").val('');
		$("#pg_appl_gender").val('EMPTY');
		$("#pg_appl_subj").val('EMPTY');
		$("#pg_appl_grad_org").val('EMPTY');
		$("#pg_appl_grad_major_subj").html('');
		$("#pg_appl_grad_pct").val('');
		$("#pg_appl_grad_pyear").val('');
	}
	
	
	
	onload_form();
</script>

