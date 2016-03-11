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
			<div class="row">
				<div class="col-lg-11 col-sm-11">
					<h3>Online Payment</h3>
					<ul>
						<li>Make the online payment by clicking the link given below.</li>
						<li>Candidate can make the online payment any of Netbanking facility/ Debit Card/ Credit Card.</li>
						<li>Those who are not having any online transaction facility they can filled up challan form from the given link and make the payment off line to any other SBI branch.</li>
						<li>Make sure that you have written correct Application code and name in the online payment form. Candidature will be cancelled if candidate put any wrong input of application code </li>
						<li>If after 3 days payment confirmation not done then please contact with the concern authorities for payment confirmation.</li>
						<li>Follow the steps the <a href="<?php echo $this->config->base_url(); ?>upload/offline/HOW_TO_MAKE_ONLINE_PAYMENT.pdf" target="_blank">INSTRUCTION SHEET</a> here carefully before make the online payment.</li>
					</ul>
				</div
			</div>
			<div class="row">
				<div class="col-lg-6 col-sm-6">
					<a href="<?php echo getOnlinePaymentURL();?>" target="_blank"><label class="alert alert-success">ONLINE PAYMENT</label></a>
				</div>
			</div>
		</div>
	</div>	<!-- /row -->
	
</div>
<?php
	$this->load->view('web_footer');
?>	
<script type="text/javascript">

</script>		