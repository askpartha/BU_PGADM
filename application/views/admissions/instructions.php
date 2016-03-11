<div class="page-title"></div>	
<div class="container-fluid" style="margin-bottom: -55px;">
	<div class="row" style="height: 500px; 	overflow: scroll;">
		<div class="col-sm-12 data-content" style="height: 100%">
			<h3 style="text-align: center">General Instructions</h3>
			<h4 style="text-align: center">Online Application For <?php echo admissionName();?>(<?php echo getCurrentSession();?>) in The University of Burdwan.</h4>
			<hr/>
			
			
			<!-- Modal -->
			<div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
			  <div class="modal-dialog" role="document">
			    <div class="modal-content">
			      <div class="modal-header">
			        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
			        	<span aria-hidden="true">&times;</span>
			        </button>
			        <h4 class="modal-title" id="myModalLabel" style="text-align: center">Online Application Procedure</h4>
			      </div>
			      <div class="modal-body">
			        <img src="<?php echo $this->config->base_url(); ?>upload/notices/instruction_steps.png" width="870px;"/>
			      </div>
			     <!--
				  <div class="modal-footer">
									 <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
								   </div>-->
				 
			    </div>
			  </div>
			</div>
			
			
			<div class="row">
				<div class="col-sm-12">
					<!--<h4><?php echo $application_notices[$i]['notice_title'] ;?></h4>-->
					<ol >
					<li>
						<h4><a href="#" data-toggle="modal" data-target="#myModal">Click Here</a> for instruction steps </h4>
					</li>
					<?php
					for($i=0; $i<count($general_notices); $i++){
					?>
					<li>
						<div style="margin-bottom: 10px;">
							<h5><b>
								<?php echo $general_notices[$i]['notice_title'] ;?>
							</b></h5>
							<p>
								<?php echo $general_notices[$i]['notice_desc'] ;?>
							</p>
							<?php
							if($general_notices[$i]['notice_file'] != ''){
							?>
							<a href="<?php echo $this->config->base_url(); ?>upload/notices/<?php echo $general_notices[$i]['notice_file'] ;?>" target="_blank">
								Download for details.
							</a>
							<?php	
							}
							?>
							
						</div>
						
					</li>
					<?php	
					}
					?>
					</ol>
				</div>
			</div>
		</div>
	</div>
</div>

<?php
	$this->load->view('footer');
?>		

<style>
	
	.modal-dialog {
	    margin: 30px auto;
	    width: 900px !important;
	}
</style>
