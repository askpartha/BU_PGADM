<div class="page-title">
	<h2>Allocate Roll Numbers</h2>
	<ul class="breadcrumb">
		<li>You are here:</li>
		<li class="active">Operation</li>
		<li class="">Allocate Roll Numbers</li>
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
		
		<div class="col-sm-3">
				<div class="content">	
					<?php
						$form = array(
										'class'	=>	'form-horizontal lft-pad-nm',
										'role'	=>	'form',
										'id' => 'allocateform'
									);	
						echo form_open('operations/allocateRollNumber', $form);
					?>
						<div class="form-group">
							<button class="btn btn-primary allocate-btn" type="button">Allocate Roll Numbers</button>
						</div>
					<?php	
						echo form_close();
					?>	
				</div>
		
				<div class="content">	
					<?php
						$form = array(
										'class'	=>	'form-horizontal lft-pad-nm',
										'role'	=>	'form',
										'id' => 'revokeform'
									);	
						echo form_open('operations/revokeRollNumber', $form);
					?>
						<div class="form-group">
							<button class="btn btn-primary revoke-btn" type="button">Revoke Roll Numbers</button>
						</div>
					<?php	
						echo form_close();
					?>	
				</div>
		</div>
		
		<div class="col-sm-9">
			<div class="box">
				<div class="title">
					<h3 class="addedit-label">Subject wise Roll Numbers</h3>
				</div>
				<div class="content">	
					
				</div>
			</div>	
		</div>
		
		
	</div>
</div>

<?php
	$this->load->view('footer');
?>		

<script type="text/javascript">
	$(document).on('click','.allocate-btn',function() {
		$('#allocateform').submit();
	});
	
	$(document).on('click','.revoke-btn',function() {
		$('#revokeform').submit();
	});
</script>