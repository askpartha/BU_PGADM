<div class="page-title">
	<h2>Dashboard</h2>
	<ul class="breadcrumb">
		<li>You are here:</li>
		<li class="active">Dashboard</li>
	</ul>
</div>	<!-- /heading -->

<div class="container-fluid">
	<div class="col-sm-6">
		<div class="box">
			<div class="title">
				<h3 class="addedit-label">Applications Statistics</h3>
			</div>
			<div class="row">
				<?php
					$form = array(
									'class'	=>	'form-horizontal lft-pad-nm',
									'role'	=>	'form',
									'id' => 'searchform'
								);	
					echo form_open('users/dashboard', $form);
				?>
				<div class="col-sm-8">
					<div class="form-group">
						<label>Subject</label>
						<?php
							$subject_data = 'id="pg_subj_code" class="col-xs-11"';				
							echo form_dropdown('pg_subj_code', $subject_options, null, $subject_data);
						?>
					</div>
				</div>
				
				<div class="col-sm-4">
					<div class="form-group">
						<label>&nbsp;</label>
						<button type="button" class="btn btn-success search-btn">Get Data</button>
					</div>
				</div>
				<?php	
					echo form_close();
				?>	
			</div>
			<div class="row">
				<div class="col-sm-11">
					<div class="row">
						<div class="col-sm-12">
							<h5><span class='dashboard_label_small'>Form Submitted: </span><span class='total_application label label-success'></span></h5>
						</div>
					</div>
					<div class="row">
						<div class="col-sm-6">
							<h5><span class='dashboard_label_small'>BU Candidate: </span><span class='total_bu_application label label-primary'></span></h5>
						</div>
						<div class="col-sm-6">
							<h5><span class='dashboard_label_small'>OU Candidate: </span><span class='total_ou_application label label-info'></span></h5>
						</div>
					</div>
					<div class="row">
						<div class="col-sm-12">
							<h5><span class='dashboard_label_small'>Payment Confirmed: </span><span class='total_payment label label-success'></span></h5>
						</div>
					</div>
					<div class="row">
						<div class="col-sm-6">
							<h5><span class='dashboard_label_small'>BU Candidate: </span><span class='total_bu_payment label label-primary'></span></h5>
						</div>
						<div class="col-sm-6">
							<h5><span class='dashboard_label_small'>OU Candidate: </span><span class='total_ou_payment label label-info'></span></h5>
						</div>
					</div>
					<div class="row">
						<div class="col-sm-6">
							<h5><span class='dashboard_label_small'>Application Confirmed: </span><span class='total_confirm label label-success'></span></h5>
						</div>
						<div class="col-sm-6">
							<h5><span class='dashboard_label_small'>Application Rejected: </span><span class='total_appl_rejected label label-danger'></span></h5>
						</div>
					</div>
					<!--
					<h5><span class='dashboard_label'>Admitted Candidates: </span><span class='total_appl_admitted label label-success'></span></h5>
					-->
				</div>
			</div>
		</div>
	</div>
	<div class="col-sm-6">
		<?php
			if($this->session->userdata['user']['user_role'] == "Admin" || $this->session->userdata['user']['user_role'] == "Center"){
		?>
		<div class="box">
			<div class="title">
				<h3 class="addedit-label">User Statistics</h3>
			</div>
			<div class="row">	
				<div class="col-sm-6">
					<h5><span class='dashboard_label_small'>Total User: </span>		<span class='total_user label label-info'> <?php echo $usrs[0]->total_user; ?> </span></h5>
				</div>
				<div class="col-sm-6">
					<h5><span class='dashboard_label_small'>Active User: </span>		<span class='total_user_active label label-success'> <?php echo $usrs[0]->total_user_active; ?> </span></h5>
				</div>
			</div>
			<div class="row">	
				<div class="col-sm-6">
					<h5><span class='dashboard_label_small'>Total Admin: </span>		<span class='total_admin label label-info'> <?php echo $usrs[0]->total_admin; ?> </span></h5>
				</div>
				<div class="col-sm-6">
					<h5><span class='dashboard_label_small'>Total Active Admin:</span><span class='total_admin_active label label-success'> <?php echo $usrs[0]->total_admin_active; ?> </span></h5>
				</div>
			</div>
			
			<div class="row">	
				<div class="col-sm-6">
					<h5><span class='dashboard_label_small'>Total Center: </span>		<span class='total_center label label-info'> <?php echo $usrs[0]->total_center; ?> </span></h5>
				</div>
				<div class="col-sm-6">
					<h5><span class='dashboard_label_small'>Total Active Center:</span><span class='total_center_active label label-success'> <?php echo $usrs[0]->total_center_active; ?> </span></h5>
				</div>
			</div>
			
			<div class="row">	
				<div class="col-sm-6">
					<h5><span class='dashboard_label_small'>Total Verifier: </span>	<span class='total_verifier label label-info'> <?php echo $usrs[0]->total_verifier; ?> </span></h5>
				</div>
				<div class="col-sm-6">
					<h5><span class='dashboard_label_small'>Total Active Verifier:</span><span class='total_verifier_active label label-success'> <?php echo $usrs[0]->total_verifier_active; ?> </span></h5>
				</div>
			</div>
			
			<div class="row">	
				<div class="col-sm-6">
					<h5><span class='dashboard_label_small'>Total Staff: </span>		<span class='total_staff label label-info'> <?php echo $usrs[0]->total_staff; ?> </span></h5>
				</div>
				<div class="col-sm-6">
					<h5><span class='dashboard_label_small'>Total Active Staff:</span><span class='total_staff_active label label-success'> <?php echo $usrs[0]->total_staff_active; ?> </span></h5>
				</div>
			</div>
		</div>
		
		
		<div class="row">	
			<div class="col-sm-6">
				<div class="box">
					<div class="title">
						<h3 class="addedit-label">Payment Statistics</h3>
					</div>
					<div class="row">	
						<div class="col-sm-12">
							<?php
								for($pmt=0; $pmt<count($payments); $pmt++){
							?>
							<div class="row">	
								<div class="col-sm-12">
								<h5>
									<span class='dashboard_label_small'><?php echo getDateFormat($payments[$pmt]->pg_appl_verified_on)?></span>		
									<span class='total_user label label-info'> <?php echo $payments[$pmt]->COUNT ?> </span>
								</h5>
								</div>
							</div>
							<?php		
								}
							?>
							
						</div>
					</div>
				</div>
			</div>
			<div class="col-sm-6">
			</div>
		</div>
		<?php } ?>
	</div>
	
	
</div>

<?php
	$this->load->view('footer');
?>	
<script type="text/javascript">
var stats = jQuery.parseJSON('<?php echo json_encode($stats);?>');
$(document).ready(function() {
	printDashboardStat(stats);
});	

//print dashboard stat
function printDashboardStat(data) {
	$('.total_application').html(data.stats[0].total_application);
	$('.total_bu_application').html(data.stats[0].total_bu_application);
	$('.total_ou_application').html(data.stats[0].total_ou_application);
	$('.total_payment').html(data.stats[0].total_payment);
	$('.total_bu_payment').html(data.stats[0].total_bu_payment);
	$('.total_ou_payment').html(data.stats[0].total_ou_payment);
	$('.total_confirm').html(data.stats[0].total_confirm);
	$('.total_appl_admitted').html(data.stats[0].total_appl_admitted);
	$('.total_appl_rejected').html(data.stats[0].total_appl_rejected);
}	

$(document).on('click','.search-btn',function() {
	$('#searchform').submit();
});	
</script>	