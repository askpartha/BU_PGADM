<div class="page-title">
	
</div>	
<div class="container-fluid">
	<div class="row" style="height: 480px;margin: 10px; ">
		<?php
			$form = array(
							'class'	=>	'form-horizontal lft-pad-nm',
							'role'	=>	'form',
							'id' => 'addeditform'
						);	
			echo form_open('admissions/submitpgsteptwo', $form);
		?>
		<div class="container-fluid">
			
			<!-- start 1st row -->
			<div class="row">
				<?php
					if($this->session->flashdata('success')) {
						echo "<div class='alert alert-success action-message'>" . $this->session->flashdata('success') . "</div>";
					} else if($this->session->flashdata('failure')) {
						echo "<div class='alert alert-danger action-message'>" . $this->session->flashdata('failure') . "</div>";
					}
				?>
				<div class="col-lg-12 col-sm-12">
					<div class="row">
						<div class="col-lg-3 col-sm-3">
							<div class="form-group">
								<label>Name : <span id="appl_name"><?php echo $appl_name?></span></label>
							</div>
						</div>
					    <div class="col-lg-3 col-sm-3">
					    	<div class="form-group">
								<label>Applied Subject : <?php echo $appl_subj?></label>
							</div>
						</div>
						
				     </div>
				    
				     <div class="row">
					    <div class="col-lg-3 col-sm-3">
					    	<div class="form-group">
								<label>Date of Birth<small>(DD-MM-YYYY)</small></label>
								<?php
									$pg_appl_dob = array(
						              					'name'        	=> 'pg_appl_dob',
														'id'          	=> 'pg_appl_dob',
														'value'       	=> '',
														'tabindex'		=> '1',
														'class'			=>	'col-xs-8 col-sm-8 datepicker'
						            				);
		
									echo form_input($pg_appl_dob);
								?>
							</div>
						</div>
						<div class="col-lg-3 col-sm-3">
							<div class="form-group">
								<label>PWD</label>
								<select id="pg_appl_pwd" name="pg_appl_pwd" class="col-xs-10 col-sm-10"  tabindex="2">
									<option = "0">No</option>
									<option = "1">Yes</option>
								</select>
							</div>
						</div>
						<div class="col-lg-3 col-sm-3">
							<div class="form-group">
								<label>Sports</label>
								<select id="pg_appl_sports" name="pg_appl_sports" class="col-xs-10 col-sm-10" tabindex="3" >
									<option = "0">No</option>
									<option = "1">Yes</option>
								</select>
							</div>
						</div>
						<div class="col-lg-3 col-sm-3">
					    	<div class="form-group">
								<label>First Preference of Center</label>
								<?php
									$center_option_data = 'id="center_option" tabindex="4" class="col-xs-10"';				
									echo form_dropdown('center_option', $center_options, null, $center_option_data);
								?>
							</div>
						</div>
				     </div>
				     
				     <div class="row">
						<div class="col-lg-8 col-sm-6">
							<div class="form-group">
								<label>Gurdian Name</label>
								<?php
									$pg_appl_gurd_name = array(
						              					'name'        	=> 'pg_appl_gurd_name',
														'id'          	=> 'pg_appl_gurd_name',
														'value'       	=> '',
														'maxlength'		=> '50',
														'tabindex'		=> '5',
														'class'			=>	'col-xs-11 col-sm-11 upper'
						            				);
		
									echo form_input($pg_appl_gurd_name);
								?>
							</div>
						</div>
				     </div>
				</div>
				<div class="col-lg-3 col-sm-3">
					
				</div>
			</div>
			<!-- end 1st row -->
		</div>
		
		<!-- start 2nd row -->
		<div class="container-fluid">
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
												'tabindex'		=> '6',
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
												'tabindex'		=> '7',
												'class'			=>	'col-xs-11 col-sm-11 upper'
				            				);

							echo form_input($pg_appl_comm_address2);
						?>
					</div>
				</div>
			</div>
		</div>	<!-- end 2nd row -->	
			
		<!-- start 3rd row -->
		<div class="container-fluid">
			<div class="row">
				<div class="col-lg-3 col-sm-3">
					<div class="form-group">
						<label>City / Town / Village</label>
						<?php
							$pg_appl_comm_city = array(
				              					'name'        	=> 'pg_appl_comm_city',
												'id'          	=> 'pg_appl_comm_city',
												'value'       	=> '',
												'tabindex'		=> '8',
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
												'tabindex'		=> '9',
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
							$pg_appl_comm_state = 'id="pg_appl_comm_state" class="col-xs-10 indian state" tabindex="10"';				
							echo form_dropdown('pg_appl_comm_state', $state_options, null, $pg_appl_comm_state);
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
		</div>	<!-- end 3rd row -->		
		
		<!-- start 4th row -->
		<div class="container-fluid">
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
				<div class="col-lg-3 col-sm-3">
					<div class="form-group">
						<label>Email Address</label>
						<?php
							$appl_email = array(
				              					'name'        	=> 'pg_appl_email',
												'id'          	=> 'pg_appl_email',
												'value'       	=> '',
												'tabindex'		=> '13',
												'class'			=>	'col-xs-10 col-sm-10'
				            				);

							echo form_input($appl_email);
						?>
					</div>
				</div>
				<div class="col-lg-6 col-sm-6">
					<?php
					if($appl_ctgry == 'BU'){
					?>
					<div class="form-group">
						<label>Burdwan University Registration Number</label>
						<?php
							$pg_appl_bu_reg_no = array(
				              					'name'        	=> 'pg_appl_bu_reg_no',
												'id'          	=> 'pg_appl_bu_reg_no',
												'value'       	=> '',
												'tabindex'		=> '14',
												'maxlength'		=> '30',
												'class'			=>	'col-xs-11 col-sm-11'
				            				);

							echo form_input($pg_appl_bu_reg_no);
						?>
						<div class='col-sm-6' style='padding:0 0;'><small>(registration number with year)</small></div>
					</div>
					<?php
					}
					?>
				</div>
			</div>
		</div>	
		<!-- end 4th row -->	
			
		<!-- start 6th row -->
		<div class="container-fluid" style="margin: 10px;">
			<div class="row">
				<div class="form-group">
				<table>
					<thead>
						<tr>
							<th style="width:11%;">Exam Passed</th>
							<th style="width:20%;">Board / University</th>
							<th style="width:7%;">Year of Passing</th>
							<th style="width:26%;">Subject(s) Studied <span class='criteria_exam_name'></span></th>
							<!--
							<th style="width:8%;">Total Marks</th>
							<th style="width:8%;">Obtained Marks</th>-->							
							<th style="width:8%;">% of Marks</th>
							<th style="width:4%;"></th>
						</tr>
					</thead>
					<tbody>
						<tr class='tr_exam'><!-- start 6/1th row -->
							<td>
								<label>10th Standard or Equivalent</label>
							</td>
							<td>
								<?php
									$board_data = 'id="pg_appl_mp_org" tabindex="15" class="col-xs-11"';				
									echo form_dropdown('pg_appl_mp_org', $board_options, 'EMPTY', $board_data);
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
								<label>12th Standard or Equivalent</label>
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
					</tbody>
				</table>
				</div>	
			</div>
		</div>	<!-- end 6th row -->	
		
		<!-- start 7th row -->
		<div class="container-fluid">
			<div class="row">
				<div class="col-lg-3 col-sm-3">
					<div class="form-group">
						<label>Password</label>
						<?php
							$appl_passwd = array(
				              					'name'        	=> 'pg_appl_password',
												'id'          	=> 'pg_appl_password',
												'type'       	=> 'password',
												'tabindex'		=> '23',
												'maxlength'		=> '20',
												'class'			=>	'col-xs-10 col-sm-10 password'
				            				);

							echo form_input($appl_passwd);
						?>
						<div class='col-sm-8' style='padding:0 0;'><small>(Between 6 and 20 characters)</small></div>
					</div>
				</div>
				<div class="col-lg-3 col-sm-3">
					<div class="form-group">
						<label>Confirm Password</label>
						<?php
							$appl_passwd2 = array(
				              					'name'        	=> 'pg_appl_password_cnfrm',
												'id'          	=> 'pg_appl_password_cnfrm',
												'type'       	=> 'password',
												'tabindex'		=> '24',
												'maxlength'		=> '20',
												'class'			=>	'col-xs-10 col-sm-10 password'
				            				);

							echo form_input($appl_passwd2);
						?>
						<div class='col-sm-8' style='padding:0 0;'><small>(Between 6 and 20 characters)</small></div>
					</div>
				</div>
			</div>
		</div>	<!-- end 7thth row -->		
					
		<!-- start 8th row -->
		<div class="container-fluid">
			<div class="row">
				<div class="col-lg-12 col-sm-12" style="padding-left: 0;">
					<h4>Declaration</h4>
					<div>
						<input type="checkbox" id="declaration" checked="true" tabindex="25"/>
						I declare that the particulars above are true to the best of my knowledge and belief. I give undertaking that my admission
						will stand cancelled if it is discovered that I do not have the minimum qualification or the information supplied by me is false. 
						I agree to abide by the rules and regulations of the course. I further declare that I shall submit to the disciplinary jurisdiction
						of the authorities of the University, who may be vested with the authority to exercise discipline under the Act, Statuses, Ordinances,
						Regulations and Rules of the University.
					</div>
				</div>
			</div>
		</div>	<!-- end 8th row -->
			
		<!-- start 9th row -->
		<div class="container-fluid">
			<div class="row">
				<div class="col-lg-12 col-sm-12 top-mrg-md" style="padding-left: 0;">
					<button type="button" class="btn btn-success save-btn" tabindex="26">Submit Application</button>&nbsp;
					<button type="button" class="btn btn-default cancel-btn" tabindex="27">Cancel</button>
					<input type="hidden" name="form_action" id="form_action" value="add">
					<br/>
					<small>This application must be submitted electronically, using the Submit Application button above. Printed copies of this online application form will not be accepted. </small>
				</div>
			</div>
		</div>	<!-- end 9th row -->			
		
		<?php	
			echo form_close();
		?>
		
	</div>
</div>

<?php
	$this->load->view('footer');
?>		

<script type="text/javascript">

	$('.input-number').keypress(function (key){
		if(key.charCode==0) return true;
		if(key.charCode<48 || key.charCode>57 )return false;
	});
	$('.input-number').keydown(function (key){
		if(key.charCode==0) return true;
		if(key.charCode<48 || key.charCode>57 )return false;
	});

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
			jConfirm(confirm_message_template(), $('#appl_name').html()+' PLEASE CONFIRM', function(e) {
				if (e) {
					$('.save-btn').attr('disabled', true);
					$('#addeditform').submit();	
				}
			})
		}
	});	

	//this template message shown into the confirm message at the time of form submission.
	function confirm_message_template(){
		var message = 'Are you sure want to submit the form with the below information. ';
			message += '\n Once application submited can\'t be revoked. ';
			message += '\n All the communication will be done on your primary mobile number. ';
		    message += '<table cellpadding="5px;">';
			message += '<tr><td><b>Mobile Number</b></td><td>' + $('#pg_appl_mobile').val() + '</td></tr>';
			message += '</table>';
		 return message;
	}

	//below functions are used for validations : Start
	function validate_form(){
		$('.error-msg').remove();
		$('input').removeClass('form-error');
		$('select').removeClass('form-error');
		$('input:checkbox').removeClass('form-error');
		
		if(check_declaration()){
			var message = '';
			//message += basic_info_validation();
			message += address_validation();
			message += mislenious_validation();
			message += secondary_validation();
			message += higher_secondary_validation();
			message += password_validation();
			
			if(message == ''){
				return true;
			}else{
				//$('#addeditform').before("<div class='error-msg'></div>");
				$('.error-msg').html(message);
				jAlert('<b><u>Your form contains some error. Please check.</u></b><div class="error-msg">'+message+"</div>");
				return false;
			}
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
		if($("#pg_appl_gurd_name").val() == ''){
			msg += "<span><i class='fa fa-arrow-right'></i>Gurdian name is mandatory.</span>"; 
			$('#pg_appl_gurd_name').addClass('form-error');
		}
		
		if($("#pg_appl_dob").val() == ''){
			msg += "<span><i class='fa fa-arrow-right'></i>Date of Birth can't be blank.</span>"; 
			$('#pg_appl_dob').addClass('form-error');
		}
		
		if($("#center_option").val() == '' || $("#center_option").val() == 'EMPTY'  || $("#center_option").val() == 'undefined' ){
			msg += "<span><i class='fa fa-arrow-right'></i>Date of Birth can't be blank.</span>"; 
			$('#center_option').addClass('form-error');
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
		/*
		if($("#appl_last_univ_reg").val() == '' ){
			msg += "<span><i class='fa fa-arrow-right'></i>last attended university registration number can't be blank.</span>"; 
			$('#appl_last_univ_reg').addClass('form-error');
		}*/
		return msg;
	}
	
	function check_declaration(){
		var flag = true;
		if(!$("#declaration").is(':checked')){
			flag = false;
			$('#declaration').addClass('form-error');
			jAlert('Before proceeding you need to accept the declaration. <br/> Plese tick into check box in declaration section');
		}
		return flag;
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
	
	function password_validation(){
		var msg = '';
		var flag = true;
		if($("#pg_appl_password").val() == ''){
			msg += "<span><i class='fa fa-arrow-right'></i>Profile Password can't be left blank.</span>"; 
			$('#pg_appl_password').addClass('form-error');
			flag = false;
		}
		if($("#pg_appl_password_cnfrm").val() == ''){
			msg += "<span><i class='fa fa-arrow-right'></i>Confirm Password Can't be blank</span>"; 
			$('#pg_appl_password_cnfrm').addClass('form-error');
			flag = false;
		}
		if(flag == true && $("#pg_appl_password_cnfrm").val() != $("#pg_appl_password").val() ){
			msg += "<span><i class='fa fa-arrow-right'></i>Password should be mathced with confirm password.</span>"; 
			$('#pg_appl_password_cnfrm').addClass('form-error');
			$('#pg_appl_password').addClass('form-error');
		}
		if(flag == true && $("#pg_appl_password").val().length < 6 ){
			msg += "<span><i class='fa fa-arrow-right'></i>Password should be minimum of 6 alpha neumeric character.</span>"; 
			$('#pg_appl_password').addClass('form-error');
		}
		return msg;
	}
	
	function onload_form(){
		fill_form_with_updated_value();
	}
	
	function fill_form_with_updated_value(){
		$("#pg_appl_dob").val("<?php echo $_pg_appl_dob; ?>");
		$("#center_option").val("<?php echo $_center_option; ?>");
		$("#pg_appl_pwd").val ("<?php echo $_pg_appl_pwd; ?>");
		$("#pg_appl_sports").val ("<?php echo $_pg_appl_sports; ?>");
		$("#pg_appl_gurd_name").val ("<?php echo $_pg_appl_gurd_name; ?>");
		$("#pg_appl_bu_reg_no").val ("<?php echo $_pg_appl_bu_reg_no; ?>");
		$("#pg_appl_comm_address1").val("<?php echo $_pg_appl_comm_address1; ?>");		
		$("#pg_appl_comm_address2").val ("<?php echo $_pg_appl_comm_address2; ?>");
		$("#pg_appl_comm_city").val ("<?php echo $_pg_appl_comm_city; ?>");
		$("#pg_appl_comm_district").val("<?php echo $_pg_appl_comm_district; ?>");		
		$("#pg_appl_comm_state").val ("<?php echo $_pg_appl_comm_state; ?>");
		$("#pg_appl_comm_pin").val ("<?php echo $_pg_appl_comm_pin; ?>");
		$("#pg_appl_mobile").val("<?php echo $_pg_appl_mobile; ?>");
		$("#pg_appl_email").val("<?php echo $_pg_appl_email; ?>");
		$("#pg_appl_mp_subj").val("<?php echo $_pg_appl_mp_subj; ?>");
		$("#pg_appl_hs_subj").val("<?php echo $_pg_appl_hs_subj; ?>");
		$("#pg_appl_mp_pct").val("<?php echo $_pg_appl_mp_pct; ?>");
		$("#pg_appl_hs_pct").val("<?php echo $_pg_appl_hs_pct; ?>");
		$("#pg_appl_mp_pyear").val("<?php echo $_pg_appl_mp_pyear; ?>");
		$("#pg_appl_hs_pyear").val("<?php echo $_pg_appl_hs_pyear; ?>");
		$("#pg_appl_mp_org").val("<?php echo $_pg_appl_mp_org; ?>");
		$("#pg_appl_hs_org").val("<?php echo $_pg_appl_hs_org; ?>");
	}
	
	onload_form();
</script>

