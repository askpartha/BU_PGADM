<div class="container-fluid">
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
			<h3>Confirm Bank Payment</h3>
			<div class="row">
				<div class="col-lg-12">
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
						echo getApplicationStatus($this->session->userdata('appl_status'));
					?></h4>
				</div>	
			</div>
			
			<?php
				if($challan != NULL) {
					$form = array(
									'class'	=>	'form-horizontal lft-pad-nm',
									'role'	=>	'form',
									'id' => 'addeditform'
								);	
					echo form_open('admissions/confirmbankpayment', $form);
			?>
			
			<div class="row">
				<div class="col-sm-2"><label>Challan Number</label></div>
				
				<div class="col-sm-4"><?php echo $challan['pg_appl_code'];?></div>
				
				<div class="col-sm-2"><label>Challan Date</label></div>
				
				<div class="col-sm-4">
					<?php 
						if($this->session->userdata('appl_status') < 3) {
							$challan_date = array(
				              					'name'        	=> 'appl_inst_date',
												'id'          	=> 'appl_inst_date',
												'value'       	=> $challan['appl_inst_date'],
												'tabindex'		=> '',
												'class'			=>	'col-xs-6 col-sm-6 datepicker upper'
				            				);

							echo form_input($challan_date);
						} else {
							echo $challan['appl_inst_date'];
						}	
					?>
				</div>
			</div>
			<br/>
			<div class="row">
				<div class="col-sm-2"><label>Branch Name</label></div>
				
				<div class="col-sm-4">
					<?php 
						if($this->session->userdata('appl_status') < 3) {

							$branch_name = array(
				              					'name'        	=> 'appl_inst_branch',
												'id'          	=> 'appl_inst_branch',
												'value'       	=> $challan['appl_inst_branch'],
												'maxlength'       	=> '50',
												'placeholder'	=>	'Branch name',
												'class'			=>	'col-xs-10 col-sm-10 upper'
				            				);
	
							echo form_input($branch_name);
						} else {
							echo $challan['appl_inst_branch'];
						}	
					?>
				</div>
			
				<div class="col-sm-2"><label>Branch Code</label></div>
				
				<div class="col-sm-4">
					<?php 
						if($this->session->userdata('appl_status') < 3) {

							$branch_code = array(
				              					'name'        	=> 'appl_inst_branch_code',
												'id'          	=> 'appl_inst_branch_code',
												'value'       	=> $challan['appl_inst_branch_code'],
												'maxlength'       	=> '30',
												'placeholder'	=>	'Branch code',
												'class'			=>	'col-xs-10 col-sm-10 upper'
				            				);
	
							echo form_input($branch_code);
						} else {
							echo $challan['appl_inst_branch_code'];
						}					
					?>
				</div>
			</div>
			<br/>
			<div class="row">
				<div class="col-sm-2"><label>Journal Number</label></div>
				
				<div class="col-sm-4">
					<?php 
						if($this->session->userdata('appl_status') < 3) {

							$journal_num = array(
				              					'name'        	=> 'appl_inst_num',
												'id'          	=> 'appl_inst_num',
												'value'       	=> $challan['appl_inst_num'],
												'maxlength'       	=> '30',
												'placeholder'	=>	'Journal Number',
												'class'			=>	'col-xs-10 col-sm-10 upper'
				            				);
	
							echo form_input($journal_num);
						} else {
							echo $challan['appl_inst_num'];
						}
					?>
				</div>
				
				<div class="col-sm-2">
				</div>
				
				<div class="col-sm-4">
				</div>
			</div>
			
			<br/>
			<?php
					if($this->session->userdata('appl_status') < 3 && $validation) {
			?>
			<div class="row">
				<div class="col-sm-4">
				</div>
				<div class="col-sm-4">
					<input type="hidden" name="pg_appl_code" value="<?php echo $challan['pg_appl_code'];?>"/>
						<button type='button' class='btn btn-success save-btn'>Confirm</button>
				</div>
			</div>	
			<?php
					}	
					echo form_close();
				} else {
					echo "<h4 class='alert alert-danger'>You requested for an invalid Application Numer.</h4>";
				}
			?>	
				
		</div>	
	</div>	<!-- /row -->		
	
</div>
<?php
	$this->load->view('web_footer');
?>
<script type="text/javascript">
//make all the input text box value as upper case
$(document).on('keyup','.upper',function() {
	this.value = this.value.toLocaleUpperCase();
	this.value = this.value.replace(/'/g, "");
	this.value = this.value.replace(/"/g, "");
});
$(document).on('keydown','.upper',function() {
	this.value = this.value.toLocaleUpperCase();
	this.value = this.value.replace(/'/g, "");
	this.value = this.value.replace(/"/g, "");
});

$(document).on('click','.save-btn',function() {
	$('.error-msg').remove();
	$('input, select').removeClass('form-error');
	
	var appl_inst_date = $('#appl_inst_date').val();
	var appl_inst_num = $('#appl_inst_num').val();
	var appl_inst_branch = $('#appl_inst_branch').val();
	
	var error = false;
	var msg = "<h4 class='lft-pad-nm'><strong>Ohh!</strong> Change a few things up and try submitting again.</h4>";
	
	if(appl_inst_date == '') {
		error = true;
		$('#appl_inst_date').addClass('form-error');
	}
	
	if(appl_inst_num == '') {
		error = true;
		$('#appl_inst_num').addClass('form-error');
	}
	
	if(appl_inst_branch == '') {
		error = true;
		$('#appl_inst_branch').addClass('form-error');
	}
	
	if(error) {
		$('#addeditform').before("<div class='error-msg'></div>");
		$('.error-msg').html(msg);
		return false;
	} else {
		jConfirm('Please verify Bank details and Journal Number before you submit. Once submitted can\'t be modified.', 'Please Confirm', function(e) {
			if (e) {
				$('#addeditform').submit();
			}
		});	
	}
	
});	

function update_form(){
	
}
</script>