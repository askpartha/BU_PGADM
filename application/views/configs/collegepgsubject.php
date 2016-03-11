<div class="page-title">
	<h2>Centers - Subjects Assocoation</h2>
	<ul class="breadcrumb">
		<li>You are here:</li>
		<li class="active">Master Data</li>
		<li class="">Centers</li>
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
			echo form_open('configs/collegepgsubjectassoc', $form);
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
				<label>Study Center: </label>
				<?php
					$study_center = 'id="col_code" class="col-xs-6"';				
					echo form_dropdown('col_code', $college_options, null, $study_center);
				?>
			</div>	
			
			<div class="form-group">
				<label>Subjects: </label>
				<div class="col-sm-5" style="padding-left:0;">
					<?php
						$subjects = 'id="left_subj_code" multiple="multiple" size="10" class="col-xs-12"';				
						echo form_dropdown('subj_code', $subject_options, null, $subjects);
					?>
				</div>
				<div class="col-sm-2" style="text-align: center">
					<button type="button" class="btn btn-primary" onclick="moveLeftToRightListBoxItem('left_subj_code', 'right_subj_code', false)">&gt;</button><br/><br/>
					<button type="button" class="btn btn-primary" onclick="moveLeftToRightListBoxItem('left_subj_code', 'right_subj_code', true)">&gt;&gt;</button><br/><br/>
					<button type="button" class="btn btn-primary" onclick="moveRightToLeftListBoxItem('left_subj_code', 'right_subj_code', false)">&lt;</button><br/><br/>
					<button type="button" class="btn btn-primary" onclick="moveRightToLeftListBoxItem('left_subj_code', 'right_subj_code', true)">&lt;&lt;</button>
					
				</div>
				<div class="col-sm-5">
					<?php
						$new_subject_options = array();
						$subjects = 'id="right_subj_code" multiple="multiple" size="10" class="col-xs-12"';				
						echo form_dropdown('subj_code[]', $new_subject_options, null, $subjects);
					?>
				</div>
			</div>
			<div class="form-group">
				<button type="button" class="btn btn-success save-btn">Associate</button>
				<input type="hidden" name="record_id" id="record_id">
				<input type="hidden" name="form_action" id="form_action" value="add">
			</div>
			
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

$(document).on('change','#col_code',function() {
	$('#left_subj_code option').remove();
	$('#right_subj_code option').remove();
	var params = "col_code="+$('#col_code').val();			
	var loadUrl = "<?php echo $this->config->base_url();?>configs/loadcollegepgsubjects/"+new Date().getTime();
	
		
	if($('#col_code').val() != 'EMPTY') {
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
