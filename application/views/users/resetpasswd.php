<div class="page-title">
	<h2>User Password Reset</h2>
	<ul class="breadcrumb">
		<li>You are here:</li>
		<li class="active">Admissions</li>
		<li class="">Password Reset</li>
	</ul>
</div>	<!-- /heading -->

<div class="container-fluid">
	<div class="row">
	<?php
		$form = array(
						'class'	=>	'form-horizontal lft-pad-nm',
						'role'	=>	'form',
						'id' => 'searchform'
					);	
		echo form_open('users/resetpasswd', $form);
	?>
		<div class="col-sm-3">
			<div class="form-group">
				<label>User Name</label>
				<?php
					$user_name = array(
			              					'name'        	=> 'user_name',
											'id'          	=> 'user_name',
											'tabindex'      => '1',
											'maxlength'		=> '10',
											'class'			=>	'col-xs-11 col-sm-11'
			            				);

					echo form_input($user_name);
				?>
		    </div>
		 </div>
		 <div class="col-sm-3">
		    <div class="form-group">
				<label>First Name</label>
				<?php
					$user_firstname = array(
			              					'name'        	=> 'user_firstname',
											'id'          	=> 'user_firstname',
											'tabindex'      => '1',
											'maxlength'		=> '10',
											'class'			=>	'col-xs-11 col-sm-11'
			            				);

					echo form_input($user_firstname);
				?>
		    </div>
		 </div>
		 <div class="col-sm-4">
		    <div class="form-group">				
				<label>Mobile Number</label>
				<?php
					$user_name = array(
			              					'name'        	=> 'user_phone',
											'id'          	=> 'user_phone',
											'tabindex'      => '1',
											'maxlength'		=> '10',
											'class'			=>	'col-xs-8 col-sm-8 input-number'
			            				);

					echo form_input($user_name);
				?>
				&nbsp;
				<button type="button" class="btn btn-success search-btn">Search</button>
			</div>
		</div>
		<div class="col-sm-6 passwd" style="display:none;">
			<div class="form-group alert alert-success"><span class='new_passwd'></span></div>			
		</div>	
		<?php	
			echo form_close();
		?>
	</div>
	
	<div class="row">
		<div class="col-sm-12">
			<h4>Please verify the below details at least, before resetting the password.</h4>
			<div class="box">
				<table class="wrl-table btm-mrgn-xs">
					<thead>
						<tr>
							<th style="width:15%;">First Name.</th>
							<th style="width:15%;">Last Name</th>
							<th style="width:15%;">User Name</th>
							<th style="width:15%;">Role</th>
							<th style="width:15%;">Department</th>
							<th style="width:10%;">Mobile No.</th>
							<th style="width:15%;"></th>
						</tr>
					</thead>
					<tbody id="tbl-content">
					<?php
						if(count($info) > 0) {
							for($i=0; $i<count($info); $i++){
					?>
						<tr>
							<td><?php echo $info[$i]['user_firstname'];?></td>
							<td><?php echo $info[$i]['user_lastname'];?></td>
							<td><?php echo $info[$i]['user_name'];?></td>
							<td><?php echo $info[$i]['role'];?></td>
							<td><?php echo $info[$i]['user_dept'];?></td>
							<td><?php echo $info[$i]['user_phone'];?></td>
							<td style="text-align: center;"><button type="button" data-val="<?php echo $info[$i]['user_id'];?>" class="btn btn-info generate-btn">Reset Password</button></td>
						</tr>
					<?php	
							}		
						} else {
							echo "<tr><td colspan='7'>No data available</td></tr>";
						}
					?>
					</tbody>
				</table>
			</div>	<!-- /box -->
		</div>
	</div>
	
<?php
	$this->load->view('footer');
?>
<script type="text/javascript">
$(document).on('click','.search-btn',function() {
	$('#searchform').submit();
});	


$(document).on('click','.generate-btn',function() {
	var val = $(this).attr('data-val')
	var params = "user_id="+val;
	$.ajax({
			url: "<?php echo $this->config->base_url();?>users/generatepasswd/"+new Date().getTime(),
			type: "post",
			data: params,
			dataType: "html",
			success: function(response){
				//show message
				$('.passwd').show();
				$('.new_passwd').html(response);
				$('.generate-btn').attr('disabled', true);
			 }
		});
});	
</script>	