<div class="page-title">
	<h2>Student Password Reset</h2>
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
		echo form_open('students/resetpasswd', $form);
	?>
		<div class="col-sm-3">
			<div class="form-group">
				<label>Application Form Number</label>
				<?php
					$appl_num = array(
			              					'name'        	=> 'pg_appl_code',
											'id'          	=> 'pg_appl_code',
											'tabindex'      => '1',
											'class'			=>	'col-xs-11 col-sm-11'
			            				);

					echo form_input($appl_num);
				?>
			</div>
		</div>
		<div class="col-sm-5">	
			<div class="form-group">
				<label>Mobile Number</label>
				<?php
					$pg_appl_mobile = array(
			              					'name'        	=> 'pg_appl_mobile',
											'id'          	=> 'pg_appl_mobile',
											'tabindex'      => '2',
											'maxlength'		=> '10',
											'class'			=>	'col-xs-6 col-sm-6 input-number'
			            				);

					echo form_input($pg_appl_mobile);
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
							<th style="width:10%;">Photo</th>
							<th style="width:15%;">Student Name</th>
							<th style="width:10%;">Appl Code.</th>
							<th style="width:15%;">Gurdian's Name</th>
							<th style="width:10%;">Subject</th>
							<th style="width:10%;">Mobile No.</th>
							<th style="width:15%;">Email Id.</th>
							<th style="width:15%;"></th>
						</tr>
					</thead>
					<tbody id="tbl-content">
					<?php
						if(count($info) > 0) {
					?>
						<tr>
							<td><img src="<?php echo $info['pg_appl_profile_pic'];?>"/></td>
							<td><?php echo $info['pg_appl_name'];?></td>
							<td><?php echo $info['pg_appl_code'];?></td>
							<td><?php echo $info['pg_appl_gurd_name'];?></td>
							<td><?php echo $info['subj_name'];?></td>
							<td><?php echo $info['pg_appl_mobile'];?></td>
							<td><?php echo $info['pg_appl_email'];?></td>
							<td style="text-align: center;"><button type="button" class="btn btn-info generate-btn" data-val="<?php echo $info['pg_appl_sl_num'];?>">Reset Password</button></td>
						</tr>
					<?php			
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
	var params = "pg_appl_sl_num="+val;
	$.ajax({
			url: "<?php echo $this->config->base_url();?>students/generatepasswd/"+new Date().getTime(),
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