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
	
</div>	
<div class="container-fluid">
	<div class="row">
		<div class="col-sm-12 data-content">
			<h3 style="text-align: center">Provisional Results &amp; Instructions</h3>
			<h4 style="text-align: center">Provisional Rank List of Online Application For <?php echo admissionName();?>(<?php echo getCurrentSession();?>)</h4>
			<hr/>
			<div class="row">
				<div class="col-sm-6">
					<!--<h4><?php echo $application_notices[$i]['notice_title'] ;?></h4>-->
					<ol >
					<?php
					for($i=0; $i<count($result_notices); $i++){
					?>
					<li>
						<div style="margin-bottom: 10px;">
							<h5><b>
								<?php echo $result_notices[$i]['notice_title'] ;?>
							</b></h5>
							<p style="text-align: justify">
								<?php echo $result_notices[$i]['notice_desc'] ;?>
							</p>
							<?php
							if($result_notices[$i]['notice_file'] != ''){
							?>
							<a href="<?php echo $this->config->base_url(); ?>upload/notices/<?php echo $result_notices[$i]['notice_file'] ;?>" target="_blank">
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
				
				
				<?php
					$record_per_page = getRecordsPerPage('records_per_page_medium');
				?>
				
				<div class="col-sm-3" style="border: 1px; border-right-style: solid;">
					<?php 
					//if($result60_publication_flag){
					if(FALSE){
					?>
					<?php
						$form = array(
										'class'	=>	'form-horizontal lft-pad-nm',
										'role'	=>	'form',
										'id' => 'searchform60'
									);	
						echo form_open('students/results', $form);
					?>
					<div class="row">
						<div class="col-sm-12">
							<div class="form-group">
								<label>Subjects</label>
								<?php
									$pg_subject_data = 'id="pg_subject" class="col-xs-10 col-sm-10 "';				
									echo form_dropdown('pg_subject', $subject_options, isset($_REQUEST['$pg_subject_data'])?$_REQUEST['$pg_subject_data']:'EMPTY', $pg_subject_data);
								?>
								<input type="hidden" name="seat_ctgry", id="seat_ctgry" value="60PCT"/>
							</div>
						</div>
					</div>
					<div class="row">
						<div class="col-sm-12">	
							<div class="form-group">
								<label>&nbsp;</label>
								<button type="button" class="btn btn-success download60-btn">Get Rank List (60%)</button>
							</div>
						</div>
					</div>
					<?php	
						echo form_close();
					?>
					<div id="result60-content" style="display: block">
					<?php 
						for($i=0; $i<count($result60); $i++){
					?>
						<div class="row" style="border-style: solid; border-width:1px; margin-bottom: 5px;">
							<div class="col-sm-12">
								<h5 ><a><?php echo $result60[$i]['description'];?></a><small>(No of Seats : <?php echo $result60[$i]['no_of_seats'];?>)</small></h5>
								
								<?php
									if($result60[$i]['total_record'] > 0) {
								?>
								
								<h3 class="page-click top-mrg-md btm-mrg-md" style="display:none;">Selected page: <span class="selected_page"></span> of <?php echo $result60[$i]['total_record'];?></h3>
								<div class="paginator">
									<?php  
										for($j=1; $j<=$result60[$i]['total_pages']; $j++) {
											echo anchor('reports/downloadmeritspublic/' . $result60[$i]['reservation']. "/". $result60[$i]['sl_no']. "/". $result60[$i]['seat_ctgry'] ."/". $j, $j, array('class' => 'result-page', 'data-val' => $j));
											echo "&nbsp;";
										}
									?>
									
								</div>
								
								<?php
									} else {
										echo "<h5 class='alert alert-danger'>No records found</h5>";
									}
								?>
								
							</div>
						</div>
					<?php
						}
					?>
				</div>
				<?php	
					}else{
						echo "<h4 align='center'> Provisional rank list of merits will be published on " . $apl_result60_date . ". <br/> Login Students Profile to view the result</h4>";
					}
				?>
				</div>
				
				<div class="col-sm-3" style="border: 1px; border-right-style: solid;">
					<?php 
					//if($result40_publication_flag){
					if(FALSE){
					?>
					<?php
						$form = array(
										'class'	=>	'form-horizontal lft-pad-nm',
										'role'	=>	'form',
										'id' => 'searchform40'
									);	
						echo form_open('students/results', $form);
					?>
					<div class="row">
						<div class="col-sm-12">
							<div class="form-group">
								<label>Subjects</label>
								<?php
									$pg_subject_40_data = 'id="pg_subject_40" class="col-xs-10 col-sm-10 "';				
									echo form_dropdown('pg_subject_40', $subject_options, isset($_REQUEST['$pg_subject_data'])?$_REQUEST['$pg_subject_data']:'EMPTY', $pg_subject_40_data);
								?>
								<input type="hidden" name="seat_ctgry", id="seat_ctgry" value="40PCT"/>
							</div>
						</div>
					</div>
					<div class="row">
						<div class="col-sm-12">	
							<div class="form-group">
								<label>&nbsp;</label>
								<button type="button" class="btn btn-success download40-btn">Get Rank List (40%)</button>
							</div>
						</div>
					</div>
					<?php	
						echo form_close();
					?>
					<div id="result40-content" style="display: block">
					<?php 
						for($i=0; $i<count($result40); $i++){
					?>
						<div class="row" style="border-style: solid; border-width:1px; margin-bottom: 5px;">
							<div class="col-sm-12">
								<h5 ><a><?php echo $result40[$i]['description'];?></a><small>(No of Seats : <?php echo $result40[$i]['no_of_seats'];?>)</small></h5>
								
								<?php
									if($result40[$i]['total_record'] > 0) {
								?>
								
								<h3 class="page-click top-mrg-md btm-mrg-md" style="display:none;">Selected page: <span class="selected_page"></span> of <?php echo $result40[$i]['total_record'];?></h3>
								<div class="paginator">
									<?php  
										for($j=1; $j<=$result40[$i]['total_pages']; $j++) {
											echo anchor('reports/downloadmeritspublic/' . $result40[$i]['reservation']. "/". $result40[$i]['sl_no']. "/". $result40[$i]['seat_ctgry'] ."/". $j, $j, array('class' => 'result-page', 'data-val' => $j));
											echo "&nbsp;";
										}
									?>
									
								</div>
								
								<?php
									} else {
										echo "<h5 class='alert alert-danger'>No records found</h5>";
									}
								?>
								
							</div>
						</div>
					<?php
						}
					?>
				</div>
				<?php	
					}else{
						echo "<h4 align='center'> Provisional rank list of written test will be published on " . $apl_result40_date . ". <br/> Login Students Profile to view the result</h4>";
					}
				?>
				</div>
				
			</div>
		</div>
	</div>
</div>

<?php
	$this->load->view('footer');
?>		

<script type="text/javascript">
$(document).on('click','.download60-btn',function() {
	var pg_subject  = $("#pg_subject").val();
	if(pg_subject != "" && pg_subject != "EMPTY" ){
		$('#searchform60').submit();	
	}else{
		$('#result60-content').hide();
		jAlert('Please select Subject to retrieve the rank list');
	}
});	
$(document).on('click','.download40-btn',function() {
	var pg_subject  = $("#pg_subject_40").val();
	if(pg_subject != "" && pg_subject != "EMPTY" ){
		$('#searchform40').submit();	
	}else{
		$('#result40-content').hide();
		jAlert('Please select Subject to retrieve the rank list');
	}
});	

$("#pg_subject").val('EMPTY');

$(document).on('click','.result-page',function() {
	$(this).addClass("active");
});	

</script>	
