
<br/>

<ul class='student-dashboard-links' >
	
	<?php 
		/**
		echo '<li>' . anchor('students/uploadphoto', '<i class="fa fa-upload"></i> Upload your photo') . '</li>';
		**/
		echo '<li><i class="fa fa-upload"></i> Upload your photo</li>';
		
		if($this->session->userdata('appl_status') <= 1) {
			echo '<li>' . anchor('admissions/pgadmedit', '<i class="fa fa-edit"></i> Modify your application') . '</li>';
		} else {
			echo '<li><i class="fa fa-upload"></i> Modify your application</li>';
		}
	?>

	<?php  echo '<li>' . anchor('admissions/downloadpgform/' . $this->session->userdata('appl_num'), '<i class="fa fa-download"></i> Download Application Form') . '</li>'; ?>
	
	
	<li>
		<?php
			if($this->session->userdata('appl_status') == 1) {
				echo anchor('students/confirmbankpayment/' . $this->session->userdata('appl_num'), '<i class="fa fa-money"></i> Confirm Bank Payment');
			} else {
				echo '<i class="fa fa-money"></i> Confirm Bank Payment';
			}
		?>
	</li>
	
	<!--
	<li>
		<?php
			if($this->session->userdata('appl_status') == 1) {
				echo anchor('admissions/downloadchallan/' . $this->session->userdata('appl_num'), '<i class="fa fa-download"></i> Download Challan');
			} else {
				echo '<i class="fa fa-download"></i> Download Challan';
			}
		?>
	</li>
	-->
	
	<!--Admitcard -->
	<?php 
		if($this->session->userdata('appl_status') >= 2 && $this->session->userdata('admitcard')=='1') {
			if($this->session->userdata['student']['student_pic'] != '') {
				echo '<li>' . anchor('admissions/downloadadmitcard/' . $this->session->userdata('appl_num'), '<i class="fa fa-download"></i> Download Admit Card') . '</li>';
			}else {
				echo '<li><i class="fa fa-download"></i> Download Admit Card</li>';
			}
		} else {
			echo '<li><i class="fa fa-download"></i> Download Admit Card</li>';
		}
	?>
	
	<!--Rankcard -->
	<?php 
		if($this->session->userdata('appl_status') >= 3 && ($this->session->userdata('rankcard_60')=='1' || $this->session->userdata('rankcard_40')=='1')) {
			if($this->session->userdata['student']['student_pic'] != '') {
				echo '<li>' . anchor('admissions/downloadrankcard/' . $this->session->userdata('appl_num'), '<i class="fa fa-download"></i> Download Rank Card') . '</li>';
			}else {
				echo '<li><i class="fa fa-download"></i> Download Rank Card</li>';
			}
		} else {
			echo '<li><i class="fa fa-download"></i> Download Rank Card</li>';
		}
	?>
	
	
	<li><?php echo anchor('students/changepass/', '<i class="fa fa-key"></i> Change Password');?></li>
</ul>