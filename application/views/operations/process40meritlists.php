<div class="page-title">
	<h2>Process/Revoke Rank List - 40% Category</h2>
	<ul class="breadcrumb">
		<li>You are here:</li>
		<li class="active">Operation</li>
		<li class="">Process Rank Lists - 40% Category</li>
	</ul>
</div>	<!-- /heading -->

<div class="container-fluid">
	<div class="row">
		<div class="col-sm-12">
			<?php
				if($this->session->flashdata('success')) {
					echo "<div class='alert alert-success action-message'>" . $this->session->flashdata('success') . "</div>";
				} else if($this->session->flashdata('failure')) {
					echo "<div class='alert alert-danger action-message'>" . $this->session->flashdata('failure') . "</div>";
				}
			?>	
		</div>
	</div>
	<div class="row">
		<div class="col-sm-6">
			<div class="box">
				<div class="title">
					<h3 class="addedit-label">Generated Ranks Lists</h3>
				</div>
				<div class="content">	
					<?php
						$form = array(
										'class'	=>	'form-horizontal lft-pad-nm',
										'role'	=>	'form',
										'id' => 'revokeform'
									);	
						echo form_open('operations/revoke40merits', $form);
					?>
						<div class="form-group">
							<label>Subjects</label>
							<?php
								$revoke_subj_code = 'id="revoke_subj_code" class="col-xs-10 col-sm-10"';				
								echo form_dropdown('revoke_subj_code', $generated_subjects, null, $revoke_subj_code)
							?>
						</div>
						
						<div class="form-group">
							<button class="btn btn-primary revoke-btn" type="button">Revoke</button>
						</div>
					<?php	
						echo form_close();
					?>	
				</div>
			</div>	
		</div>
		
		<div class="col-sm-6">
			<div class="box">
				<div class="title">
					<h3 class="addedit-label">Non generated Ranks Lists</h3>
				</div>
				<div class="content">	
					<?php
						$form = array(
										'class'	=>	'form-horizontal lft-pad-nm',
										'role'	=>	'form',
										'id' => 'processform'
									);	
						echo form_open('operations/process40merits', $form);
					?>
						<div class="form-group">
							<label>Subjects</label>
							<?php
								$process_subj_code = 'id="process_subj_code" class="col-xs-10 col-sm-10"';				
								echo form_dropdown('process_subj_code', $non_generated_subjects, null, $process_subj_code)
							?>
						</div>
						<div class="form-group">
							<button class="btn btn-primary process-btn" type="button">Process</button>
						</div>	
					<?php	
						echo form_close();
					?>	
				</div>
			</div>	
		</div>
		
		
	</div>
</div>

<?php
	$this->load->view('footer');
?>		

<script type="text/javascript">
	$(document).on('click','.process-btn',function() {
		var subj_code = $("#process_subj_code").val();
		if(subj_code != 'EMPTY' && subj_code != '' && subj_code != 'undefined'){
			$('#processform').submit();
		}else{
			jAlert('Please select atleast one subject from dropdown');
		}
	});
	
	$(document).on('click','.revoke-btn',function() {
		var subj_code = $("#revoke_subj_code").val();
		if(subj_code != 'EMPTY' && subj_code != '' && subj_code != 'undefined'){
			$('#revokeform').submit();
		}else{
			jAlert('Please select atleast one subject from dropdown');
		}
	});
	
	$("#process_subj_code").val('EMPTY');
	$("#revoke_subj_code").val('EMPTY');
		
</script>