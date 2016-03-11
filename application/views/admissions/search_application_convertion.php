<style>
a.result-page {
    display: inline-block;
    padding: 0px 9px;
    margin: 6px;
    border-radius: 3px;
    border: solid 1px #c0c0c0;
    background: #e9e9e9;
    box-shadow: inset 0px 1px 0px rgba(255,255,255, .8), 0px 1px 3px rgba(0,0,0, .1);
    font-size: 1em;
    font-weight: bold;
    text-decoration: none;
    color: #717171;
    text-shadow: 0px 1px 0px rgba(255,255,255, 1);
}

a.result-page:hover, a.result-page.gradient:hover {
    background: #fefefe;
    background: -webkit-gradient(linear, 0% 0%, 0% 100%, from(#FEFEFE), to(#f0f0f0));
    background: -moz-linear-gradient(0% 0% 270deg,#FEFEFE, #f0f0f0);
}

a.result-page.active {
    border: none;
    background: #616161;
    box-shadow: inset 0px 0px 8px rgba(0,0,0, .5), 0px 1px 0px rgba(255,255,255, .8);
    color: #f0f0f0;
    text-shadow: 0px 0px 3px rgba(0,0,0, .5);
}
</style>

<div class="page-title">
	<h2>Student Application : CONVERSION</h2>
	<ul class="breadcrumb">
		<li>You are here:</li>
		<li class="active">Admissions</li>
		<li class="">Search Application : Convertion</li>
	</ul>
</div>	<!-- /heading -->

<div class="container-fluid">
	<?php
		$form = array(
						'class'	=>	'form-horizontal lft-pad-nm',
						'role'	=>	'form',
						'id' => 'searchform'
					);	
		echo form_open('admissions/searchapplication/CONVERT', $form);
	?>
		<input type="hidden" name="form_action" id="form_action" value="search">
		<input type="hidden" name="page" id="page" value="0">
		
	<div class="row">
		<div class="col-sm-2">
			<div class="form-group">
				<label>Application Code</label>
				<?php
					$pg_appl_code_data = array(
			              					'name'        	=> 'pg_appl_code',
											'id'          	=> 'pg_appl_code',
											'tabindex'      => '1',
											'class'			=>	'col-xs-11 col-sm-11'
			            				);
					echo form_input($pg_appl_code_data);
				?>
			</div>
		</div>
		<div class="col-sm-2">
			<div class="form-group">
				<label>Application Name</label>
				<?php
					$pg_appl_name_data = array(
			              					'name'        	=> 'pg_appl_name',
											'id'          	=> 'pg_appl_name',
											'tabindex'      => '2',
											'class'			=>	'col-xs-11 col-sm-11'
			            				);
					echo form_input($pg_appl_name_data);
				?>
			</div>
		</div>
		<div class="col-sm-2">
			<div class="form-group">
				<label>Mobile Number</label>
				<?php
					$pg_appl_mobile_data = array(
			              					'name'        	=> 'pg_appl_mobile',
											'id'          	=> 'pg_appl_mobile',
											'tabindex'      => '3',
											'maxlength'		=> '10',
											'class'			=>'col-xs-11 col-sm-11 input-number'
			            				);
					echo form_input($pg_appl_mobile_data);
				?>
			</div>
		</div>
		<div class="col-sm-2">
			<div class="form-group">
				<label>Subject</label>
				<?php
					$pg_subj_data = 'id="pg_appl_subj" tabindex="4" class="col-xs-11"';				
					echo form_dropdown('pg_appl_subj', $subject_options, null, $pg_subj_data);
				?>
			</div>
		</div>
		<div class="col-sm-2">
			<div class="form-group">
				<label>Application Status</label>
				<?php
					$pg_appl_status_data = 'id="pg_appl_status" tabindex="4" class="col-xs-11"';				
					echo form_dropdown('pg_appl_status', $application_status_options, null, $pg_appl_status_data);
				?>
			</div>
		</div>
		<div class="col-sm-2">
			<div class="form-group">
				<label>Extr Resv.</label>
				<?php
					$extra_resv_data = 'id="pg_appl_resv_extra" tabindex="4" class="col-xs-6"';				
					echo form_dropdown('pg_appl_resv_extra', $reservation_extra_options, null, $extra_resv_data);
				?>
				&nbsp;
				<input type="hidden" id="pg_appl_spcl_status" name="pg_appl_spcl_status" value = "-1"/>
				<button type="button" class="btn btn-success search-btn">Search</button>
				<input type="hidden" value="1" name="pageno" id="pageno"/>
			</div>
		</div>
		</div>
		<?php	
			echo form_close();
		?>
	
	
	<div class="row">
		<div class="col-sm-12">
			<div class="box">
				<table class="wrl-table btm-mrgn-xs">
					<thead>
						<tr>
							<th style="width:4%;"></th>
							<th style="width:13%;">Appl. Code</th>
							<th style="width:9%;">Reservation</th>
							<th style="width:9%;">Extr. Resv</th>
							<th style="width:17%;">Applicant's Name</th>
							<th style="width:10%;">Mobile No.</th>
							<th style="width:10%;">Subject</th>
							<th style="width:12%;">Appl. Status</th>
							<!--<th style="width:10%;">Comments</th>-->
							<th style="width:10%;"></th>
						</tr>
					</thead>
					<tbody id="tbl-content">
						<?php
						if(isset($info['RESULT']) && count($info['RESULT']) > 0) {
								for($i=0; $i<count($info['RESULT']); $i++)
								{
								$extra_resv = "";
								if($info['RESULT'][$i]['pg_appl_pwd'] == 'Y'){
									$extra_resv = 'PWD';
								}elseif($info['RESULT'][$i]['pg_appl_sports'] == 'Y'){
									$extra_resv = 'SPORTS';
								}
						?>
							<tr>
								<td><img height="35px" width="40px" src="<?php echo $info['RESULT'][$i]['pg_appl_profile_pic'];?>"/></td>
								<?php  echo '<td>' . anchor('admissions/downloadpgform/' . $info['RESULT'][$i]['pg_appl_code'], '<i class="fa fa-download"></i> '.$info['RESULT'][$i]['pg_appl_code']) . '</td>'; ?>
								<td><?php echo $info['RESULT'][$i]['pg_appl_reservation_name'];?></td>
								<td id="resv_<?php echo $info['RESULT'][$i]['pg_appl_sl_num']; ?>"><?php echo $extra_resv; ?></td>
								<td><?php echo $info['RESULT'][$i]['pg_appl_name'];?></td>
								<td><?php echo $info['RESULT'][$i]['pg_appl_mobile'];?></td>
								<td><?php echo $info['RESULT'][$i]['pg_appl_subj_name'];?></td>
								<td><?php echo _getApplicationStatus($info['RESULT'][$i]['pg_appl_status'])?></td>
								<td>
									<?php
										if($extra_resv != ""){
									?>
									<button type="button" class="btn btn-info submit-btn" data-val="<?php echo $info['RESULT'][$i]['pg_appl_sl_num']; ?>" id="btn_<?php echo $info['RESULT'][$i]['pg_appl_sl_num']; ?>">
										Convert
									</button>
									<?php
										} 
									?>
									
								</td>
							</tr>
						<?php
								}			
							} else {
								echo "<tr><td colspan='9'>No data available</td></tr>";
							}
						?>
					</tbody>
				</table>
				<div class="paginator pull-right">
					<?php  
						if(isset($info['TOTALPAGES'])){
							for($j=1; $j<=$info['TOTALPAGES']; $j++) {
								//echo anchor('#', $j, array('class' => 'result-page', 'data-val' => $j));
								if($j == $info['PAGENO']){
									echo "<a href='#' class='result-page active' data-val='".$j ."'>" . $j . "</a>";	
								}else{
									echo "<a href='#' class='result-page' data-val='".$j ."'>" . $j . "</a>";
								}
								
								echo "&nbsp;";
							}
						} 
					?>
				</div>
			</div>	<!-- /box -->
		</div>
	</div>
	
<?php
	$this->load->view('footer');
?>
<script type="text/javascript">
$(document).on('click','.search-btn',function() {
	serach(1);
});	

$(document).on('click','.result-page',function() {
	var pageno = $(this).attr("data-val")
	serach(pageno);
});	

function serach(pageno){
	$("#pageno").val(pageno);

	var pg_appl_code = $("#pg_appl_code").val();
	var pg_appl_name = $("#pg_appl_name").val();
	var pg_appl_mobile = $("#pg_appl_mobile").val();
	var pg_appl_subj = $("#pg_appl_subj").val();
	var pg_appl_status = $("#pg_appl_status").val();
	var pg_appl_resv_extra = $("#pg_appl_resv_extra").val();
	if(pg_appl_code.trim() == '' && pg_appl_name.trim() == '' && pg_appl_mobile.trim() == '' && 
	   pg_appl_subj.trim() == 'EMPTY' && pg_appl_status.trim() == 'EMPTY' && pg_appl_resv_extra.trim() == 'EMPTY' ){
		jAlert('Please select atleast one search criteria.');
	}else{
		$('#searchform').submit();		
	}
}


$(document).on('click','.submit-btn',function() {
	
	var pg_appl_sl_no = $(this).attr('data-val');
	var pg_appl_status_remarks  = $("#pg_appl_status_remarks_"+pg_appl_sl_no).val();
	var labels = $('#resv_'+pg_appl_sl_no).html();
	
	jConfirm('<center>Would you like to convert application reservation <br/> from <br/> <b>'+labels+' to GENERAL </b></center>', 'PLEASE CONFIRM', function(e) {
		if (e) {
			
			var params = "pg_appl_sl_no="+pg_appl_sl_no+"&status=N";		
			
			if(labels == 'SPORTS'){
				params += "&resv=pg_appl_sports";
			}else if(labels == 'PWD'){
				params += "&resv=pg_appl_pwd";
			}
			
			$.ajax({
					url: "<?php echo $this->config->base_url();?>admissions/updatestudentreservation/"+new Date().getTime(),
					type: "post",
					data: params,
					dataType: "html",
					success: function(response){
						//console.log(response);
						if (response.indexOf("TRUE") !=-1) {
							//hide triggered button.
							$('#btn_'+pg_appl_sl_no).hide();
							$('#resv_'+pg_appl_sl_no).html('');
						}
					 }
				});	
		}
	})
});	

function reset_form(){
	$("#pg_appl_code").val('');
	$("#pg_appl_name").val('');
	$("#pg_appl_mobile").val('');
	$("#pg_appl_subj").val('');
	$("#pg_appl_status").val('>0');
	$("#pg_appl_resv_extra").val('EMPTY');
}

reset_form();

<?php
	if(isset($info['CRITERIA'])){
?>
		$("#pg_appl_code").val('<?php echo $info['CRITERIA']['pg_appl_code'];?>');
		$("#pg_appl_name").val('<?php echo $info['CRITERIA']['pg_appl_name'];?>');
		$("#pg_appl_mobile").val('<?php echo $info['CRITERIA']['pg_appl_mobile'];?>');
		$("#pg_appl_subj").val('<?php echo $info['CRITERIA']['pg_appl_subj'];?>');
		$("#pg_appl_status").val('<?php echo $info['CRITERIA']['pg_appl_status'];?>');
		$("#pg_appl_resv_extra").val('<?php echo $info['CRITERIA']['pg_appl_resv_extra'];?>');
<?php	
	}
?>
//------------------------ BASED UPON OPERATION ----------------------
$(document).on('click','.download-btln',function() {
	var params = "pg_appl_code=";
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
//------------------------ BASED UPON OPERATION ----------------------	
</script>	