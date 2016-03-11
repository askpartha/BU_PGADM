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
			<h3>Upload Photo</h3>
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
						echo _getApplicationStatus($this->session->userdata('appl_status'));
					?></h4>
				</div>	
			</div>
			
			<div class="row btm-mrg-md">
				<div class="col-lg-12">
					<?php	
						$attributes = array('class' => '', 'id' => 'uploadform');
						echo form_open_multipart('students/uploadphoto', $attributes);
						//$profile_pic = ($this->session->userdata['student']['student_pic'] == '') ? "no-profile-pic_90.png" : "t_" . $this->session->userdata['student']['student_pic'];
						if( ($this->session->userdata['student']['student_pic'] != '') || ($this->session->userdata['student']['student_pic'] != NULL) ) {
							$profile_pic = "t_" . $this->session->userdata['student']['student_pic'];
						}elseif($this->session->userdata('tmp_student_pic') != '') {
							$profile_pic = "t_" . $this->session->userdata('tmp_student_pic');
						} else {
							$profile_pic = "no-profile-pic_90.png";
						}
					?>
	
						<div class="row btm-mrg-md">
							<div class="col-sm-4">		
								<img class="profile-pic" src="<?php echo $this->config->base_url();?>upload/students/profile_pic/<?php echo $profile_pic;?>" alt="Profile Photo">
							</div>
							<div class="col-sm-6">					
								<input type="file" name="upload" id="fileupload"><br/>
								<input type="hidden" name="pg_appl_code" value="<?php echo $this->session->userdata('appl_code');?>"/>
								<button type='button' class='btn btn-success save-btn'>Upload</button>
							</div>
						
					<?php
						echo form_close();
					?>	
				</div>
			</div>
				
		</div>	
	</div>	<!-- /row -->		
	
</div>
<?php
	$this->load->view('web_footer');
?>
<script type="text/javascript">
//check valid image type and size
var _URL = window.URL || window.webkitURL;
$(document).on('change','#fileupload',function() {	
	 var image, file;
    if ((file = this.files[0])) {
        image = new Image();
        image.onload = function() {
	    	if( (this.width < 90) || (this.height < 90) ) {
	    		jAlert("The minimum width and height of image should be 90px", 'Nope');
	    		$('.save-btn').attr('disabled', true);
	    	} else {
	    		$('.save-btn').attr('disabled', false);
	    	}
        };
        image.src = _URL.createObjectURL(file);
    }
    
	var filename = $('#fileupload').val();
	var ext = filename.substr((~-filename.lastIndexOf(".") >>> 0) + 2);
	var valid_extensions = /(jpg|jpeg|gif|png)$/i; 
	if(ext.length > 0) {
		if(!valid_extensions.test(ext)) {
			jAlert("This is not a valid image type.", 'Nope');
			$('.save-btn').attr('disabled', true);
		} else {
			$('.save-btn').attr('disabled', false);
		}
	}
});
$(document).on('click','.save-btn',function() {
	$('#uploadform').submit();
});
</script>