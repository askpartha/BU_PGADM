<div class="container-fluid">
	<div class="row">
		<div class="col-lg-12">
			<div class="page-title">
				<div class="col-lg-4 col-sm-4">
					<h2>Welcome, <?php echo $this->session->userdata['student']['student_name'];?></h2>
				</div>
				<div class="col-lg-6 col-sm-6">
					<h2>Application Number: <?php echo $this->session->userdata('appl_code');?></h2>
				</div>
				<div class="col-lg-2 col-sm-2" style="text-align: right;">
					<?php
						$picture = $this->session->userdata['student']['student_pic'];
						if($picture == ''){
							$picture = 'no-profile-pic_90.png'; 	
						}else{
							$picture = 't_'.$picture; 
						}
					?>
					<img class="profile-pic" src="<?php echo $this->config->base_url();?>upload/students/profile_pic/<?php echo $picture;?>" alt="Profile Photo">
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
			<h3>Dashboard</h3>
			<div class="row btm-mrg-md">
				<div class="col-lg-3"></div>
				<div class="col-lg-4">
					<h4>Applied Subject: <u><?php echo $this->session->userdata('appl_subj');?></u></h4>
				</div>
				<div class="col-lg-5"><h4>Status: 
					<?php
						echo _getApplicationStatus($this->session->userdata('appl_status'));
					?></h4>
				</div>	
			</div>
			
			<div class="row btm-mrg-md">
				<div class="col-lg-7">
					<?php
						if($this->session->userdata('appl_status') == 1) {
					?>
						<h4>Your next steps:</h4>
						<ol>
							<!--
							<li><a href="<?php echo $this->config->base_url();?>students/uploadphoto">Upload your photo</a> if not uploaded</li>
							-->
							<li>Upload your photo, if not uploaded</li>
							<li>Confirm your bank payment <a href="<?php echo $this->config->base_url();?>students/confirmbankpayment/<?php echo $this->session->userdata('appl_num');?>">from here</a></li>
							<!--<li>If you want to submit payment through challan then download the challan from above link and go to your nearest State Bank of India branch and pay the fees</li>-->
							<li>Wait until your payment is confirmed. Expected waiting time of payment confirmation is 3 days from date of payment confirmation. If waiting period is beyond 3 days then contact over mail with documents of payments.</li>
						</ol>
					<?php	
						}elseif($this->session->userdata('appl_status') == 2) {
					?>
						<h4>Your next steps:</h4>
						<ol>
							<li>Wait until your payment of application is processed</li>
							<!--
							<li><a href="<?php echo $this->config->base_url();?>students/uploadphoto">Upload your photo</a> if not uploaded</li>
							-->
							<li>Upload your photo, if not uploaded</li>
							<li>Once your application processed download Admit Card from the respective link from left side menu</li>
						</ol>
					<?php		
						}elseif($this->session->userdata('appl_status') >= 3) {
							if($this->session->userdata['student']['student_pic'] == '') {
								echo "<h3 class='red-text btm-mrg-lg'>You didn't upload your photo.<br/>
								Unless you upload the photo, you can't download the Admit Card and Rank Card.</h3>";
					?>
						<h4>Your next steps:</h4>
						<ol>
							<!--
							<li><a href="<?php echo $this->config->base_url();?>students/uploadphoto">Upload your photo</a></li>
							-->
							<li>Upload your photo, if not uploaded</li>
							<li>Download your Admit Card</li>
							<li>You will notify by the  University of Burdwan if you are in rank list</li>
						</ol>
					<?php
							} else {
					?>
						<h4>Your next steps:</h4>
						<ol>
							<li>Download your Admit Card <a href="<?php echo $this->config->base_url();?>admissions/downloadadmitcard/<?php echo $this->session->userdata('appl_num');?>">from here</a></li>
							<?php
							if($this->session->userdata('appl_status') >= 3 && ($this->session->userdata['rankcard_60'] || $this->session->userdata['rankcard_40'])) {
							?>
							<li>Download your Rank Card  <a href="<?php echo $this->config->base_url();?>admissions/downloadrankcard/<?php echo $this->session->userdata('appl_num');?>">here</a></li>
							<?php 
							}
							?>
							<li>You will notify by the  University of Burdwan if you are in merit list</li>
						</ol>
					<?php
							}		
						}		
					?>	
				</div>
				
				<!--Rank details -->
				<div class="col-lg-5">
				<?php
						if($this->session->userdata('appl_status') >= 3 && ($this->session->userdata['rankcard_60'] || $this->session->userdata['rankcard_40'])) {
				?>
						<h4>Your Rank Details:</h4>
						<div class="row btm-mrg-sm">
							<div class="col-lg-5"><label>Student Category: </label></div>
							
							<div class="col-lg-7"><?php echo _getUniversityCtgr($this->session->userdata['student']['rank']['CTGR']) ?></div>
						</div>
				
				<?php
						if($this->session->userdata['rankcard_60']) {
				?>
						<div class="row btm-mrg-sm" style="margin-left: -25px;">
						<ul>
						<?php 
								if($this->session->userdata['student']['rank']['60PCT']['GEN'] != '' && $this->session->userdata['student']['rank']['60PCT']['GEN'] > 0){
									echo '<div class="row btm-mrg-sm"><b><small> ' . $this->session->userdata['student']['rank']['60PCT']['GEN_TYPE'] . ' :</small> </b> <span class="label label-success">'. $this->session->userdata['student']['rank']['60PCT']['GEN'] . '</span></div>';	
								}
								if($this->session->userdata['student']['rank']['60PCT']['OBCA'] != '' && $this->session->userdata['student']['rank']['60PCT']['OBCA'] > 0){
									echo '<div class="row btm-mrg-sm"><b><small> ' . $this->session->userdata['student']['rank']['60PCT']['OBCA_TYPE'] . ' :</small> </b> <span class="label label-success">'. $this->session->userdata['student']['rank']['60PCT']['OBCA'] . '</span></div>';	
								}
								if($this->session->userdata['student']['rank']['60PCT']['OBCB'] != '' && $this->session->userdata['student']['rank']['60PCT']['OBCB'] > 0){
									echo '<div class="row btm-mrg-sm"><b><small> ' . $this->session->userdata['student']['rank']['60PCT']['OBCB_TYPE'] . ' :</small> </b> <span class="label label-success">'. $this->session->userdata['student']['rank']['60PCT']['OBCB'] . '</span></div>';	
								}
								if($this->session->userdata['student']['rank']['60PCT']['SC'] != '' && $this->session->userdata['student']['rank']['60PCT']['SC'] > 0){
									echo '<div class="row btm-mrg-sm"><b><small> ' . $this->session->userdata['student']['rank']['60PCT']['SC_TYPE'] . ' :</small> </b> <span class="label label-success">'. $this->session->userdata['student']['rank']['60PCT']['SC'] . '</span></div>';	
								}
								if($this->session->userdata['student']['rank']['60PCT']['ST'] != '' && $this->session->userdata['student']['rank']['60PCT']['ST'] > 0){
									echo '<div class="row btm-mrg-sm"><b><small> ' . $this->session->userdata['student']['rank']['60PCT']['ST_TYPE'] . ' :</small> </b> <span class="label label-success">'. $this->session->userdata['student']['rank']['60PCT']['ST'] . '</span></div>';	
								}
								if($this->session->userdata['student']['rank']['60PCT']['PWD'] != '' && $this->session->userdata['student']['rank']['60PCT']['PWD'] > 0){
									echo '<div class="row btm-mrg-sm"><b><small> ' . $this->session->userdata['student']['rank']['60PCT']['PWD_TYPE'] . ' :</small> </b> <span class="label label-success">'. $this->session->userdata['student']['rank']['60PCT']['PWD'] . '</span></div>';
								}
								if($this->session->userdata['student']['rank']['60PCT']['SPORTS'] != '' && $this->session->userdata['student']['rank']['60PCT']['SPORTS'] > 0){
									echo '<div class="row btm-mrg-sm"><b><small> ' . $this->session->userdata['student']['rank']['60PCT']['SPORTS_TYPE'] . ' :</small> </b> <span class="label label-success">'. $this->session->userdata['student']['rank']['60PCT']['SPORTS'] . '</span></div>';
								}
								if($this->session->userdata['student']['rank']['60PCT']['HONS'] != '' && $this->session->userdata['student']['rank']['60PCT']['HONS'] > 0){
									echo '<div class="row btm-mrg-sm"><b><small> ' . $this->session->userdata['student']['rank']['60PCT']['HONS_TYPE'] . ' :</small> </b> <span class="label label-success">'. $this->session->userdata['student']['rank']['60PCT']['HONS'] . '</span></div>';
								}
						?>	
					</ul>	
					</div>
				<?php
				}
				
				if($this->session->userdata['rankcard_40']) {
				?>	
					<div class="row btm-mrg-sm" style="margin-left: -25px;">
						<ul>
						<?php 
								if($this->session->userdata['student']['rank']['40PCT']['GEN'] != '' && $this->session->userdata['student']['rank']['40PCT']['GEN'] > 0){
									echo '<div class="row btm-mrg-sm"><b><small> ' . $this->session->userdata['student']['rank']['40PCT']['GEN_TYPE'] . ' :</small> </b> <span class="label label-success">'. $this->session->userdata['student']['rank']['40PCT']['GEN'] . '</span></div>';	
								}
								if($this->session->userdata['student']['rank']['40PCT']['OBCA'] != '' && $this->session->userdata['student']['rank']['40PCT']['OBCA'] > 0){
									echo '<div class="row btm-mrg-sm"><b><small> ' . $this->session->userdata['student']['rank']['40PCT']['OBCA_TYPE'] . ' :</small> </b> <span class="label label-success">'. $this->session->userdata['student']['rank']['40PCT']['OBCA'] . '</span></div>';	
								}
								if($this->session->userdata['student']['rank']['40PCT']['OBCB'] != '' && $this->session->userdata['student']['rank']['40PCT']['OBCB'] > 0){
									echo '<div class="row btm-mrg-sm"><b><small> ' . $this->session->userdata['student']['rank']['40PCT']['OBCB_TYPE'] . ' :</small> </b> <span class="label label-success">'. $this->session->userdata['student']['rank']['40PCT']['OBCB'] . '</span></div>';	
								}
								if($this->session->userdata['student']['rank']['40PCT']['SC'] != '' && $this->session->userdata['student']['rank']['40PCT']['SC'] > 0){
									echo '<div class="row btm-mrg-sm"><b><small> ' . $this->session->userdata['student']['rank']['40PCT']['SC_TYPE'] . ' :</small> </b> <span class="label label-success">'. $this->session->userdata['student']['rank']['40PCT']['SC'] . '</span></div>';	
								}
								if($this->session->userdata['student']['rank']['40PCT']['ST'] != '' && $this->session->userdata['student']['rank']['40PCT']['ST'] > 0){
									echo '<div class="row btm-mrg-sm"><b><small> ' . $this->session->userdata['student']['rank']['40PCT']['ST_TYPE'] . ' :</small> </b> <span class="label label-success">'. $this->session->userdata['student']['rank']['40PCT']['ST'] . '</span></div>';	
								}
								if($this->session->userdata['student']['rank']['40PCT']['PWD'] != '' && $this->session->userdata['student']['rank']['40PCT']['PWD'] > 0){
									echo '<div class="row btm-mrg-sm"><b><small> ' . $this->session->userdata['student']['rank']['40PCT']['PWD_TYPE'] . ' :</small> </b> <span class="label label-success">'. $this->session->userdata['student']['rank']['40PCT']['PWD'] . '</span></div>';
								}
								if($this->session->userdata['student']['rank']['40PCT']['SPORTS'] != '' && $this->session->userdata['student']['rank']['40PCT']['SPORTS'] > 0){
									echo '<div class="row btm-mrg-sm"><b><small> ' . $this->session->userdata['student']['rank']['40PCT']['SPORTS_TYPE'] . ' :</small> </b> <span class="label label-success">'. $this->session->userdata['student']['rank']['40PCT']['SPORTS'] . '</span></div>';
								}
								if($this->session->userdata['student']['rank']['40PCT']['HONS'] != '' && $this->session->userdata['student']['rank']['40PCT']['HONS'] > 0){
									echo '<div class="row btm-mrg-sm"><b><small> ' . $this->session->userdata['student']['rank']['40PCT']['HONS_TYPE'] . ' :</small> </b> <span class="label label-success">'. $this->session->userdata['student']['rank']['40PCT']['HONS'] . '</span></div>';
								}
						?>	
					</ul>	
					</div>	
			<?php 
				} 
			}
			?>
				</div>
				
			</div>
				
		</div>	
	</div>	<!-- /row -->		
	
</div>
<?php
	$this->load->view('web_footer');
?>