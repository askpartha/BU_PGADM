<a class="sidebar_switch on_switch" href="javascript:void(0)" oldtitle="Hide Sidebar">Sidebar switch</a>

<div class="sidebar">
	<div class="sidebar_inner">
		<div class="mainnav">
			<div class="panel-group" id="accordion">
				<?php
					if($this->session->userdata['user']['user_role'] == 'Admin') {
						$this->load->view('sidebar_admin');
					}elseif($this->session->userdata['user']['user_role'] == "Verifier") {
						$this->load->view('sidebar_verifier');
					}elseif($this->session->userdata['user']['user_role'] == "Staff") {
						$this->load->view('sidebar_staff');
					} 
					  
					 /*
					elseif($this->session->userdata['user']['user_role'] == "Center") {
											$this->load->view('sidebar_center');
										} elseif($this->session->userdata['user']['user_role'] == "CoE") {
											$this->load->view('sidebar_coe');
										}*/
					
				?>
			</div>	<!-- /#accordion -->
		</div>	<!-- /mainnav -->	
	</div>	<!-- /sidebar_inner -->
</div><!-- /sidebar -->	