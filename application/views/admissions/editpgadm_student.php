<div class="container-fluid">
	<?php
		$form = array(
						'class'	=>	'form-horizontal lft-pad-nm',
						'role'	=>	'form',
						'id' => 'addeditform'
					);	
		echo form_open('admissions/pgadmupdate', $form);
	?>
	<div class="row">
		<div class="col-lg-12">
			<div class="page-title">
				<div class="col-lg-8 col-sm-8">
					<h2>Welcome, <?php echo $this->session->userdata['student']['student_name'];?></h2>
				</div>
				<div class="col-lg-4 col-sm-4">
					<h3>Application Number: <?php echo $this->session->userdata('appl_code');?></h3>
				</div>
			</div>	<!-- /heading -->
		</div>
	</div>	<!-- /row -->
	
	<div class="row">
		<div class="col-lg-3 col-sm-3">
			<?php
				$this->load->view('students/sidebar');
			?>
		</div>
		
		<div class="col-lg-9 col-sm-9">
			<div class="row btm-mrg-sm">
				<div class="col-lg-3">
					<h3>Update Profile</h3>
				</div>
				<div class="col-lg-8">
					<?php
						if($this->session->userdata('appl_status') > 1) {
					?>
					<h5 style="color: red">Payment has confirmed so not been possible to update.</h5>					
					<?php
						}
					?>
					<?php
						if($this->session->flashdata('success')) {
							echo "<div class='alert alert-success action-message'>" . $this->session->flashdata('success') . "</div>";
						} else if($this->session->flashdata('failure')) {
							echo "<div class='alert alert-danger action-message'>" . $this->session->flashdata('failure') . "</div>";
						}
					?>
				</div>
			</div>
			
			<div class="row btm-mrg-md">
				<div class="col-lg-2"></div>
				<div class="col-lg-5">
					<h4>Applied Subject: <u><?php echo $this->session->userdata('appl_subj');?></u></h4>
				</div>
				<div class="col-lg-5"><h4>Status: 
					<?php
						echo _getApplicationStatus($this->session->userdata('appl_status'));
					?></h4>
				</div>	
			</div>
			<input type="hidden" value="<?php echo $result['pg_appl_sl_num']?>" id="pg_appl_sl_num" name="pg_appl_sl_num" />
			<input type="hidden" value="<?php echo $result['pg_appl_subj']?>"   id="pg_appl_subj"   name="pg_appl_subj" />
			<input type="hidden" value="<?php echo $result['pg_appl_gender']?>"   id="pg_appl_gender"   name="pg_appl_gender" />
			<input type="hidden" value="<?php echo $result['pg_appl_code']?>"   id="pg_appl_code"   name="pg_appl_code" />
			<input type="hidden" value="<?php echo $result['pg_appl_name']?>"   id="pg_appl_name"   name="pg_appl_name" />
			
			
			<div class="row btm-mrg-sm">
				<div class="col-lg-3">
					<div class="form-group">
						<label>Student From</label>
						<?php
							$university_ctgr_data = 'id="pg_appl_ctgr" tabindex="1" class="col-xs-10"';				
							echo form_dropdown('pg_appl_ctgr', $university_ctgry_options, null, $university_ctgr_data);
						?>
					</div>
				</div>
				<div class="col-lg-3">
					<div class="form-group">
						<label>Gurdian Name</label>
						<?php
							$pg_appl_gurd_name_date = array(
				              					'name'        	=> 'pg_appl_gurd_name',
												'id'          	=> 'pg_appl_gurd_name',
												'value'       	=> '',
												'tabindex'		=> '3',
												'class'			=>	'col-xs-10 col-sm-10'
				            				);

							echo form_input($pg_appl_gurd_name_date);
						?>
					</div>
				</div>
				<div class="col-lg-3">
					<div class="form-group">
						<label>First Preference of Center</label>
						<?php
							$center_option_data = 'id="pg_apl_center_option" tabindex="15" class="col-xs-10"';				
							echo form_dropdown('pg_apl_center_option', $center_options, null, $center_option_data);
						?>
					</div>
				</div>
			</div>
			
			<!-- Row 2-->	
			<div class="row btm-mrg-sm">
				<div class="col-lg-3">
					<div class="form-group">
						<label>Date of Birth<small>(DD-MM-YYYY)</small></label>
						<?php
							$pg_appl_dob = array(
				              					'name'        	=> 'pg_appl_dob',
												'id'          	=> 'pg_appl_dob',
												'value'       	=> '',
												'tabindex'		=> '3',
												'class'			=>	'col-xs-8 col-sm-8 datepicker'
				            				);

							echo form_input($pg_appl_dob);
						?>
					</div>
				</div>
				 <div class="col-lg-3 col-sm-3">
			    	<div class="form-group">
						<label>Reservation</label>
						<?php
							$pg_appl_reservation = 'id="pg_appl_reservation" class="col-xs-10" tabindex="5"';				
							echo form_dropdown('pg_appl_reservation', $reservation_options, null, $pg_appl_reservation);
						?>
					</div>
				</div>
				<div class="col-lg-3 col-sm-3">
					<div class="form-group">
						<label>PWD</label>
						<select id="pg_appl_pwd" name="pg_appl_pwd" class="col-xs-10 col-sm-10"  tabindex="6">
							<option = "0">No</option>
							<option = "1">Yes</option>
						</select>
					</div>
				</div>
				<div class="col-lg-3 col-sm-3">
					<div class="form-group">
						<label>Sports</label>
						<select id="pg_appl_sports" name="pg_appl_sports" class="col-xs-10 col-sm-10" tabindex="7" >
							<option = "0">No</option>
							<option = "1">Yes</option>
						</select>
					</div>
				</div>
				<div class="col-lg-3">
					
				</div>
			</div>
			
			
		<!-- start 2nd row -->
			<div class="row">
				<div class="col-lg-6 col-sm-6">
					<div class="form-group">
						<label>Address</label>
						<?php
							$appl_address = array(
				              					'name'        	=> 'pg_appl_comm_address1',
												'id'          	=> 'pg_appl_comm_address1',
												'value'       	=> '',
												'maxlength'		=> '50',
												'tabindex'		=> '7',
												'class'			=>	'col-xs-11 col-sm-11 upper'
				            				);

							echo form_input($appl_address);
						?>
					</div>
				</div>
				<div class="col-lg-6 col-sm-6">
					<div class="form-group">
						<label>Address (more)</label>
						<?php
							$pg_appl_comm_address2 = array(
				              					'name'        	=> 'pg_appl_comm_address2',
												'id'          	=> 'pg_appl_comm_address2',
												'value'       	=> '',
												'maxlength'		=> '50',
												'tabindex'		=> '8',
												'class'			=>	'col-xs-11 col-sm-11 upper'
				            				);

							echo form_input($pg_appl_comm_address2);
						?>
					</div>
				</div>
			</div>
			<!-- end 2nd row -->	
			
		<!-- start 3rd row -->
			<div class="row">
				<div class="col-lg-3 col-sm-3">
					<div class="form-group">
						<label>City / Town / Village</label>
						<?php
							$pg_appl_comm_city = array(
				              					'name'        	=> 'pg_appl_comm_city',
												'id'          	=> 'pg_appl_comm_city',
												'value'       	=> '',
												'tabindex'		=> '9',
												'class'			=>	'col-xs-10 col-sm-10 upper'
				            				);

							echo form_input($pg_appl_comm_city);
						?>
					</div>
				</div>
				<div class="col-lg-3 col-sm-3">
					<div class="form-group">
						<label>District</label>
						<?php
							$pg_appl_comm_district = array(
				              					'name'        	=> 'pg_appl_comm_district',
												'id'          	=> 'pg_appl_comm_district',
												'value'       	=> '',
												'tabindex'		=> '10',
												'class'			=>	'col-xs-10 col-sm-10 upper'
				            				);

							echo form_input($pg_appl_comm_district);
						?>
					</div>
				</div>
				<div class="col-lg-3 col-sm-3">
					<div class="form-group">
						<label>State / Union Territory</label>
						<?php
							$pg_appl_comm_state_data = 'id="pg_appl_comm_state" class="col-xs-10 indian state" tabindex=""';				
							echo form_dropdown('pg_appl_comm_state', $state_options, 'EMPTY', $pg_appl_comm_state_data);
						?>
					</div>
				</div>
				<div class="col-lg-3 col-sm-3">
					<div class="form-group">
						<label>PIN Code</label>
						<?php
							$pg_appl_comm_pin = array(
				              					'name'        	=> 'pg_appl_comm_pin',
												'id'          	=> 'pg_appl_comm_pin',
												'value'       	=> '',
												'tabindex'		=> '11',
												'maxlength'		=> '6',
												'class'			=>	'col-xs-10 col-sm-10 input-number'
				            				);

							echo form_input($pg_appl_comm_pin);
						?>
					</div>
				</div>
			</div>
		<!-- end 3rd row -->		
		
		<!-- start 4th row -->
			<div class="row">
				<div class="col-lg-3 col-sm-3">
					<div class="form-group">
						<label>Mobile Number</label>
						<?php
							$appl_mobile = array(
				              					'name'        	=> 'pg_appl_mobile',
												'id'          	=> 'pg_appl_mobile',
												'value'       	=> '',
												'tabindex'		=> '12',
												'maxlength'		=> '10',
												'class'			=>	'col-xs-10 col-sm-10 input-number mobile-number'
				            				);

							echo form_input($appl_mobile);
						?>
						<div class='col-sm-6' style='padding:0 0;'><small>(10 digits number)</small></div>
					</div>
				</div>
				<div class="col-lg-6 col-sm-6">
					<div class="form-group">
						<label>Email Address</label>
						<?php
							$appl_email = array(
				              					'name'        	=> 'pg_appl_email',
												'id'          	=> 'pg_appl_email',
												'value'       	=> '',
												'tabindex'		=> '14',
												'class'			=>	'col-xs-11 col-sm-11'
				            				);

							echo form_input($appl_email);
						?>
					</div>
				</div>
			</div>
		<!-- end 4th row -->
		<br/>	
		<div class="row">
			<div class="form-group">
			<table>
				<thead>
					<tr>
						<th style="width:10%;">Exam Passed</th>
						<th style="width:20%;">Board / University</th>
						<th style="width:8%;">Year of Passing</th>
						<th style="width:30%;">Subject(s) Studied <span class='criteria_exam_name'></span></th>
						<th style="width:6%;">% of Marks</th>
						<th style="width:4%;"></th>
					</tr>
				</thead>
				<tbody>
					<tr class='tr_exam'><!-- start 6/1th row -->
						<td>
							10th Standard
						</td>
						<td>
							<?php
								$board_data = 'id="pg_appl_mp_org" tabindex="15" class="col-xs-11"';				
								echo form_dropdown('pg_appl_mp_org', $board_options, null, $board_data);
							?>
						</td>
						<td>
							<?php
								$yr_passing = array(
						              					'name'        	=> 'pg_appl_mp_pyear',
						              					'id'        	=> 'pg_appl_mp_pyear',
														'value'       	=> '',
														'tabindex'		=> '16',
														'maxlength'		=> '4',
														'class'			=>	'col-xs-11 input-number'
						            				);
								echo form_input($yr_passing);
							?>
						</td>
						<td>
							<?php
								$subjects = array(
						              					'name'        	=> 'pg_appl_mp_subj',
						              					'id'        	=> 'pg_appl_mp_subj',
														'value'       	=> '',
														'tabindex'		=> '17',
														'maxlength'		=> '100',
														'class'			=>	'col-xs-11 upper'
						            				);
								echo form_input($subjects);
							?>
						</td>
						<td>
							<?php
								$pc_marks = array(
						              					'name'        	=> 'pg_appl_mp_pct',
						              					'id'        	=> 'pg_appl_mp_pct',
														'value'       	=> '',	
														'tabindex'		=> '18',
														'class'			=>	'col-xs-11 pc_marks input-number-decimal'
						            				);

								echo form_input($pc_marks);
							?>
						</td>
					</tr>
					<tr class='tr_exam'><td>&nbsp;</td></tr>
					<tr class='tr_exam'><!-- start 6/2nd row -->
						<td>
							12th Standard
						</td>
						<td>
							<?php
								$council_data = 'id="pg_appl_hs_org" tabindex="19" class="col-xs-11"';				
								echo form_dropdown('pg_appl_hs_org', $council_options, 'EMPTY', $council_data);
							?>
						</td>
						<td>
							<?php
								$yr_passing_hs = array(
						              					'name'        	=> 'pg_appl_hs_pyear',
						              					'id'        	=> 'pg_appl_hs_pyear',
														'value'       	=> '',
														'tabindex'		=> '20',
														'maxlength'		=> '4',
														'class'			=>	'col-xs-11 input-number'
						            				);
								echo form_input($yr_passing_hs);
							?>
						</td>
						<td>
							<?php
								$subjects_hs = array(
						              					'name'        	=> 'pg_appl_hs_subj',
						              					'id'        	=> 'pg_appl_hs_subj',
														'value'       	=> '',
														'tabindex'		=> '21',
														'maxlength'		=> '100',
														'class'			=>	'col-xs-11 upper'
						            				);
								echo form_input($subjects_hs);
							?>
						</td>
						<td>
							<?php
								$pc_marks_hs = array(
						              					'name'        	=> 'pg_appl_hs_pct',
						              					'id'        	=> 'pg_appl_hs_pct',
						              					'tabindex'		=> '22',
														'value'       	=> '',	
														'class'			=>	'col-xs-11 pc_marks input-number-decimal'
						            				);

								echo form_input($pc_marks_hs);
							?>
						</td>
					</tr>
					<tr class='tr_exam'><td>&nbsp;</td></tr>
					<tr class='tr_exam'><!-- start 6/2nd row -->
						<td>
							Graduation
						</td>
						<td>
							<?php
								$university_data = 'id="pg_appl_grad_org" tabindex="23" class="col-xs-11"';				
								echo form_dropdown('pg_appl_grad_org', $university_options, 'EMPTY', $university_data);
							?>
						</td>
						<td>
							<?php
								$yr_passing_grad = array(
						              					'name'        	=> 'pg_appl_grad_pyear',
						              					'id'        	=> 'pg_appl_grad_pyear',
														'value'       	=> '',
														'tabindex'		=> '24',
														'maxlength'		=> '4',
														'class'			=>	'col-xs-11 input-number'
						            				);
								echo form_input($yr_passing_grad);
							?>
						</td>
						<td>
							<?php
								$pg_appl_grad_major_subj_data = 'id="pg_appl_grad_major_subj" tabindex="25" class="col-xs-6"';				
								echo form_dropdown('pg_appl_grad_major_subj', $ug_subject_major_options, 'EMPTY', $pg_appl_grad_major_subj_data);
							?>
							<?php
								$pg_appl_grad_minor_subj_data = 'id="pg_appl_grad_minor_subj" tabindex="26" class="col-xs-6"';				
								echo form_dropdown('pg_appl_grad_minor_subj', $ug_subject_minor_options, '', $pg_appl_grad_minor_subj_data);
							?>
						</td>
						<td>
							<?php
								$pc_marks_grad = array(
						              					'name'        	=> 'pg_appl_grad_pct',
						              					'id'        	=> 'pg_appl_grad_pct',
						              					'tabindex'		=> '22',
														'value'       	=> '',	
														'class'			=>	'col-xs-11 pc_marks input-number-decimal'
						            				);

								echo form_input($pc_marks_grad);
							?>
						</td>
					</tr>
				</tbody>
			</table>
			</div>	
		</div>
	
		<div class="row">
			<div class="col-lg-7 col-sm-7 top-mrg-md" style="padding-left: 0;">
			</div>
			<div class="col-lg-6 col-sm-6 top-mrg-md" style="padding-left: 0;">
				<button type="button" class="btn btn-success save-btn">Modify</button>&nbsp;
				<input type="hidden" name="form_action" id="form_action" value="edit">
			</div>
		</div>
		
		</div>	
	</div>	<!-- /row -->		
</div>

<?php	
	echo form_close();
?>

<?php
	$this->load->view('web_footer');
?>

<script>
	
	//make all the input text box value as upper case
	$(document).on('keyup','input',function() {
		this.value = this.value.toLocaleUpperCase();
	});
	$(document).on('keydown','input',function() {
		this.value = this.value.toLocaleUpperCase();
	});
	$('input').bind('keypress',function(event) {
		if(event.charCode == 39 || event.charCode == 34 || event.charCode == 96 || event.charCode == 126 || event.charCode==42 || event.charCode==37){
			jAlert('This special character not allowd.');
			return false;
		}
	});


	//onclick on submit button form information will be stored into database.
	$(document).on('click','.save-btn',function() {
		if(validate_form()){
			jConfirm("", 'PLEASE CONFIRM', function(e) {
				if (e) {
					$('#addeditform').submit();	
				}
			})
		}
	});	

	//below functions are used for validations : Start
	function validate_form(){
		$('.error-msg').remove();
		$('input').removeClass('form-error');
		$('select').removeClass('form-error');
		$('input:checkbox').removeClass('form-error');
		
			var message = '';
			message += address_validation();
			message += mislenious_validation();
			message += secondary_validation();
			message += higher_secondary_validation();
			message += graduation_validation();
			
			if(message == ''){
				return true;
			}else{
				//$('#addeditform').before("<div class='error-msg'></div>");
				$('.error-msg').html(message);
				jAlert('<b><u>Your form contains some error. Please check.</u></b><div class="error-msg">'+message+"</div>");
				return false;
			}
	}
	
	function address_validation(){
		var msg = '';
		if($("#pg_appl_comm_address1").val() == '' || $("#pg_appl_comm_address1").val() ==  'EMPTY'){
			msg += "<span><i class='fa fa-arrow-right'></i>Address line1 can't be blank.</span>"; 
			$('#pg_appl_comm_address1').addClass('form-error');
		}
		if($("#pg_appl_comm_city").val() == '' || $("#pg_appl_comm_city").val() ==  'EMPTY'){
			msg += "<span><i class='fa fa-arrow-right'></i>Address city/town/village can't be blank.</span>"; 
			$('#pg_appl_comm_city').addClass('form-error');
		}
		if($("#pg_appl_comm_district").val() == '' || $("#pg_appl_comm_district").val() ==  'EMPTY'){
			msg += "<span><i class='fa fa-arrow-right'></i>Address district can't be blank.</span>"; 
			$('#pg_appl_comm_district').addClass('form-error');
		}
		if($("#pg_appl_comm_state").val() == '' || $("#pg_appl_comm_state").val() ==  'EMPTY'){
			msg += "<span><i class='fa fa-arrow-right'></i>Address state can't be blank.</span>"; 
			$('#pg_appl_comm_state').addClass('form-error');
		}
		if($("#pg_appl_comm_pin").val() == '' || $("#pg_appl_comm_pin").val() ==  'EMPTY'){
			msg += "<span><i class='fa fa-arrow-right'></i>Address pin number can't be blank.</span>"; 
			$('#pg_appl_comm_pin').addClass('form-error');
		}
		return msg;
	}

	function mislenious_validation(){
		var msg = '';
		
		if($("#pg_appl_dob").val() == 'EMPTY'){
			msg += "<span><i class='fa fa-arrow-right'></i>Dateof birth can't be blank.</span>"; 
			$('#pg_appl_dob').addClass('form-error');
		}
		
		if($("#pg_appl_gurd_name").val() == ''){
			msg += "<span><i class='fa fa-arrow-right'></i>Gurdian name is mandatory.</span>"; 
			$('#pg_appl_gurd_name').addClass('form-error');
		}
		
		if($("#pg_apl_center_option").val() == 'EMPTY'){
			msg += "<span><i class='fa fa-arrow-right'></i>Please select first options of center.</span>"; 
			$('#pg_appl_gurd_name').addClass('form-error');
		}
		
		if($("#pg_appl_mobile").val() == ''){
			msg += "<span><i class='fa fa-arrow-right'></i>Mobile number is mandatory.</span>"; 
			$('#pg_appl_mobile').addClass('form-error');
		}
		
		if($("#pg_appl_email").val() != ''){
		    var email = $("#pg_appl_email").val();
		    var reg = /^[_a-zA-Z0-9-]+(\.[_a-zA-Z0-9-]+)*@[_a-zA-Z0-9-]+()*(\.[_a-zA-Z0-9-]+)*(\.[a-zA-Z]{2,4})$/
			if(reg.test(email)){
			}else{
				msg += "<span><i class='fa fa-arrow-right'></i>Email id is not in correct format.</span>"; 
				$('#pg_appl_email').addClass('form-error');
			}
		}
		return msg;
	}
	
	function secondary_validation(){
		var msg = '';
		if($("#pg_appl_mp_org").val() == '' || $("#pg_appl_mp_org").val() ==  'EMPTY'){
			msg += "<span><i class='fa fa-arrow-right'></i>Please select board for secondary examination.</span>"; 
			$('#pg_appl_mp_org').addClass('form-error');
		}		
		if($("#pg_appl_mp_subj").val() == '' ){
			msg += "<span><i class='fa fa-arrow-right'></i>Subject of secondary standard can't be blank.</span>"; 
			$('#pg_appl_mp_subj').addClass('form-error');
		}		
		if($("#pg_appl_mp_pct").val() == ''){
			msg += "<span><i class='fa fa-arrow-right'></i>Percentage of secondary can't be blank.</span>"; 
			$('#pg_appl_mp_pct').addClass('form-error');
		}
		return msg;	
	}
	
	function higher_secondary_validation(){
		var msg = '';
		if($("#pg_appl_hs_org").val() == '' || $("#pg_appl_hs_org").val() ==  'EMPTY'){
			msg += "<span><i class='fa fa-arrow-right'></i>Please select board for higher secondary examination.</span>"; 
			$('#pg_appl_hs_org').addClass('form-error');
		}		
		if($("#pg_appl_hs_subj").val() == '' ){
			msg += "<span><i class='fa fa-arrow-right'></i>Subject of higher secondary standard can't be blank.</span>"; 
			$('#pg_appl_hs_subj').addClass('form-error');
		}		
		if($("#pg_appl_hs_pct").val() == ''){
			msg += "<span><i class='fa fa-arrow-right'></i>Percentage of higher secondary can't be blank.</span>"; 
			$('#pg_appl_hs_pct').addClass('form-error');
		}
		return msg;
	}
	
	function graduation_validation(){
		var msg = '';
		if($("#pg_appl_grad_org").val() == '' || $("#pg_appl_grad_org").val() ==  'EMPTY'){
			msg += "<span><i class='fa fa-arrow-right'></i>Please select graduation university.</span>"; 
			$('#pg_appl_grad_org').addClass('form-error');
		}		
		if($("#pg_appl_grad_major_subj").val() == '' || $("#pg_appl_grad_major_subj").val() == 'EMPTY'  || $("#pg_appl_grad_major_subj").val() == 'undefined' || $("#pg_appl_grad_major_subj").val() == 'null' ){
			msg += "<span><i class='fa fa-arrow-right'></i>Subject of graduation standard can't be blank.</span>"; 
			$('#pg_appl_grad_major_subj').addClass('form-error');
		}		
		if($("#pg_appl_grad_pct").val() == ''){
			msg += "<span><i class='fa fa-arrow-right'></i>Percentage of graduation can't be blank.</span>"; 
			$('#pg_appl_grad_pct').addClass('form-error');
		}
		return msg;
	}
	
	
	
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
	
	
	$("#pg_appl_grad_major_subj").on('change',function() {
		setGraduationMinorSubject('');
	});
	
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
	
	
	function onload_form(){
		fill_form_with_updated_value();
	}
	
	function fill_form_with_updated_value(){
		
		$("#pg_appl_ctgr").val("<?php echo $result['pg_appl_ctgr']; ?>");
		$("#pg_appl_gurd_name").val("<?php echo $result['pg_appl_gurd_name']; ?>");
		$("#pg_apl_center_option").val("<?php echo $result['pg_apl_center_option']; ?>");
		
		$("#pg_appl_dob").val("<?php echo getDateFormat($result['pg_appl_dob'], 'd-m-Y'); ?>");
		$("#pg_appl_reservation").val("<?php echo $result['pg_appl_reservation']; ?>");
		$("#pg_appl_pwd").val("<?php echo $result['pg_appl_pwd']; ?>");
		$("#pg_appl_sports").val("<?php echo $result['pg_appl_sports']; ?>");
		
		$("#pg_appl_mp_org").val("<?php echo $result['pg_appl_mp_org']; ?>");
		$("#pg_appl_mp_pyear").val("<?php echo $result['pg_appl_mp_pyear']; ?>");
		$("#pg_appl_mp_subj").val("<?php echo $result['pg_appl_mp_subj']; ?>");
		$("#pg_appl_mp_pct").val("<?php echo $result['pg_appl_mp_pct']; ?>");
		
		$("#pg_appl_hs_org").val("<?php echo $result['pg_appl_hs_org']; ?>");
		$("#pg_appl_hs_pyear").val("<?php echo $result['pg_appl_hs_pyear']; ?>");
		$("#pg_appl_hs_subj").val("<?php echo $result['pg_appl_hs_subj']; ?>");
		$("#pg_appl_hs_pct").val("<?php echo $result['pg_appl_hs_pct']; ?>");
		
		$("#pg_appl_grad_org").val("<?php echo $result['pg_appl_grad_org']; ?>");
		$("#pg_appl_grad_pyear").val("<?php echo $result['pg_appl_grad_pyear']; ?>");
		$("#pg_appl_grad_major_subj").val("<?php echo $result['pg_appl_grad_major_subj']; ?>");
		$("#pg_appl_grad_minor_subj").val("<?php echo $result['pg_appl_grad_minor_subj']; ?>");
		$("#pg_appl_grad_pct").val("<?php echo $result['pg_appl_grad_pct']; ?>");
		
		$("#pg_appl_comm_address1").val("<?php echo $result['pg_appl_comm_address1']; ?>");
		$("#pg_appl_comm_address2").val("<?php echo $result['pg_appl_comm_address2']; ?>");
		$("#pg_appl_comm_city").val("<?php echo $result['pg_appl_comm_city']; ?>");
		$("#pg_appl_comm_district").val("<?php echo $result['pg_appl_comm_district']; ?>");
		$("#pg_appl_comm_state").val("<?php echo $result['pg_appl_comm_state']; ?>");
		$("#pg_appl_comm_pin").val("<?php echo $result['pg_appl_comm_pin']; ?>");
		$("#pg_appl_mobile").val("<?php echo $result['pg_appl_mobile']; ?>");
		$("#pg_appl_email").val("<?php echo $result['pg_appl_email']; ?>");
	}
	
	onload_form();

</script>
	
