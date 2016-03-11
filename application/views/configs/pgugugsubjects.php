<div class="page-title">
	<h2>PG-UG/UG - Subjects Assocoation</h2>
	<ul class="breadcrumb">
		<li>You are here:</li>
		<li class="active">Master Data</li>
		<li class="">PG-UG/UG - Subjects Assocoation</li>
	</ul>
</div>	<!-- /heading -->

<div class="container-fluid">
	<div class="row">
		<?php
			$form = array(
							'class'	=>	'form-horizontal lft-pad-nm',
							'role'	=>	'form',
							'id' => 'addeditform'
						);	
			echo form_open('configs/pgugugsubjectassoc', $form);
		?>
		<div class="col-sm-12">
			<?php
				if($this->session->flashdata('success')) {
					echo "<div class='alert alert-success action-message'>" . $this->session->flashdata('success') . "</div>";
				} else if($this->session->flashdata('failure')) {
					echo "<div class='alert alert-danger action-message'>" . $this->session->flashdata('failure') . "</div>";
				}
			?>
			
			<div class="form-group">
				<div class="col-sm-3" style="padding-left:0;">
					<label>PG Subjects: </label>
					<?php
						$pgsubjects = 'id="pg_subj_code" class="col-xs-11"';				
						echo form_dropdown('pg_subj_code', $pgsubject_options, null, $pgsubjects);
					?>
					<br/><br/><br/>
					<label>UG Major Subject: </label>
					<?php
						$ug_subj_code_major_data = 'id="ug_subj_code_major" class="col-xs-11"';				
						echo form_dropdown('ug_subj_code_major', $ug_subj_code_major_options, null, $ug_subj_code_major_data);
					?>
				</div>
				
				<div class="col-sm-3" style="padding-left:0;">
					<label>UG Subjects: </label>
					<?php
						$ugsubjects = 'id="left_subj_code" multiple="multiple" size="12" class="col-xs-12"';				
						echo form_dropdown('ug_subj_code', $ugsubject_options, null, $ugsubjects);
					?>
				</div>
				<div class="col-sm-1" style="text-align: center">
					<label>&nbsp;&nbsp;</label>
					<button type="button" class="btn btn-primary" onclick="moveLeftToRightListBoxItem('left_subj_code', 'right_subj_code', false)">&gt;</button><br/><br/>
					<button type="button" class="btn btn-primary" onclick="moveLeftToRightListBoxItem('left_subj_code', 'right_subj_code', true)">&gt;&gt;</button><br/><br/>
					<button type="button" class="btn btn-primary" onclick="moveRightToLeftListBoxItem('left_subj_code', 'right_subj_code', false)">&lt;</button><br/><br/>
					<button type="button" class="btn btn-primary" onclick="moveRightToLeftListBoxItem('left_subj_code', 'right_subj_code', true)">&lt;&lt;</button>
					
				</div>
				
				<div class="col-sm-3">
					<label>UG Associative Minor Subjects: </label>
					<?php
						$new_subject_options = array();
						$subjects = 'id="right_subj_code" multiple="multiple" size="12" class="col-xs-12"';				
						echo form_dropdown('ug_subj_code_minor[]', $new_subject_options, null, $subjects);
					?>
				</div>
			</div>
			<DIV class="row" style="text-align: center; margin-top: 20px;">
				<div class="form-group">
					<button type="button" class="btn btn-success save-btn">Associate</button>
					<input type="hidden" name="record_id" id="record_id">
					<input type="hidden" name="form_action" id="form_action" value="add">
				</div>
			</DIV>
			
			
		</div>
		<?php	
			echo form_close();
		?>	
	</div>
	
	<div class="row">
		<div class="col-sm-12">
			&nbsp;
		</div>	
	</div>
</div>
<?php
	$this->load->view('footer');
?>		

<script type="text/javascript">
$(document).ready(function() {
	//$("#left_subj_code option[value='EMPTY']").remove();
});	

$(document).on('change','#pg_subj_code',function() {
	$('#left_subj_code option').remove();
	$('#right_subj_code option').remove();
	$('#ug_subj_code_major option').remove();
	
	var params = "pg_subj_code="+$('#pg_subj_code').val();			
	var loadUrl = "<?php echo $this->config->base_url();?>configs/loadpgugsubjects/"+new Date().getTime();
	
	if($('#ug_subj_code_major').val() != 'EMPTY') {
		$.ajax({
				    type: "POST",
				    url: loadUrl,
				    data: params,
				    success: function(res){
				    	console.log(res);
				    	var json = jQuery.parseJSON(res);
				    	$('#ug_subj_code_major').append($('<option>').text('').attr('value', 'EMPTY'));
				    	$.each(json.available, function(i, item) {
				            $('#ug_subj_code_major').append($('<option>').text(item.subj_name).attr('value', item.subj_code));
				        });
				    }
				});
	}			
});	

$(document).on('change','#ug_subj_code_major',function() {
	$('#left_subj_code option').remove();
	$('#right_subj_code option').remove();
	var params = "ug_subj_code_major="+$('#ug_subj_code_major').val()+"&pg_subj_code="+$('#pg_subj_code').val();				
	var loadUrl = "<?php echo $this->config->base_url();?>configs/loadpgugugsubjects/"+new Date().getTime();
	
		
	if($('#ug_subj_code_major').val() != 'EMPTY') {
		$.ajax({
				    type: "POST",
				    url: loadUrl,
				    data: params,
				    success: function(res){
				    	console.log(res);
				    	var json = jQuery.parseJSON(res);
				    	$.each(json.notavailable, function(i, item) {
				            $('#left_subj_code').append($('<option>').text(item.subj_name).attr('value', item.subj_code));
				        });
				        
				        $.each(json.available, function(i, item) {
				            $('#right_subj_code').append($('<option>').text(item.subj_name).attr('value', item.subj_code));
				        });
				    }
				});
	}			
});	

function moveLeftToRightListBoxItem(leftListBoxID, rightListBoxID, isMoveAll) {
    if (isMoveAll == true) {
        $('#' + leftListBoxID + ' option').remove().appendTo('#' + rightListBoxID).removeAttr('selected');
    }
    else {
        $('#' + leftListBoxID + ' option:selected').remove().appendTo('#' + rightListBoxID).removeAttr('selected');
    }
}

function moveRightToLeftListBoxItem(leftListBoxID, rightListBoxID, isMoveAll) {
    if (isMoveAll == true) {
        $('#' + rightListBoxID + ' option').remove().appendTo('#' + leftListBoxID).removeAttr('selected');
    }
    else {
        $('#' + rightListBoxID + ' option:selected').remove().appendTo('#' + leftListBoxID).removeAttr('selected');
    }
}

$(document).on('click','.save-btn',function() {
	var n = $('#right_subj_code option').length;
	//for(var i=0; i<n; i++) {
		$('#right_subj_code option').prop('selected', true);
	//}
	$('#addeditform').submit();
});	
</script>			
