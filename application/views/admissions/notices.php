<div class="page-title">
	<h2>Notices</h2>
	<ul class="breadcrumb">
		<li>You are here:</li>
		<li class="active">Admissions</li>
		<li class="">Notice</li>
	</ul>
</div>	<!-- /heading -->

<div class="container-fluid">
	<div class="row">
		<div class="col-sm-8 data-content">
			<?php
				if($this->session->flashdata('success')) {
					echo "<div class='alert alert-success action-message'>" . $this->session->flashdata('success') . "</div>";
				} else if($this->session->flashdata('failure')) {
					echo "<div class='alert alert-danger action-message'>" . $this->session->flashdata('failure') . "</div>";
				}
			?>	
			<div class="box">
				<table class="wrl-table btm-mrgn-xs">
					<thead>
						<tr>
							<th style="width:5%;">Sl</th>
							<th style="width:13%;">Category</th>
							<th style="width:5%;">Wt.</th>
							<th style="width:25%;">Title</th>
							<th style="width:25%;">Description</th>
							<th style="width:13%;">File</th>
							<th style="width:7%;">Active</th>
							<th style="width:9%;">Action</th>
						</tr>
					</thead>
					<tbody id="tbl-content"></tbody>
				</table>
				<div class="paginator pull-right btm-mrgn-sm"></div>
			</div>	<!-- /box -->
		</div>
		
		<div class="col-sm-4">
			<div class="box">
				<div class="title">
					<h3 class="addedit-label">Create Notice</h3>
				</div>
				<div class="content">	
					<?php
						$form = array(
										'class'	=>	'form-horizontal lft-pad-nm',
										'role'	=>	'form',
										'id' => 'addeditform',
										'enctype'=>'multipart//form-data'
									);	
						echo form_open_multipart('admissions/createnotice', $form);
					?>
						<div class="form-group">
							<label>Notice Category*</label>
							<?php
								$notice_ctgry = 'id="notice_ctgry" class="col-xs-6 col-sm-6"';				
	
								echo form_dropdown('notice_ctgry', $notice_ctgry_options, null, $notice_ctgry)
							?>
							
						</div>
						
						<div class="form-group">
							<label>Notice Title</label>
							<?php
								$notice_title = array(
					              					'name'        	=> 'notice_title',
													'id'          	=> 'notice_title',
													'value'       	=> '',
													'placeholder'	=> '',
													'class'			=>	'col-xs-11 col-sm-11'
					            				);
	
								echo form_input($notice_title);
							?>
						</div>
						
						<div class="form-group">
							<label>Notice Description</label>
							<?php
								$notice_desc = array(
					              					'name'        	=> 'notice_desc',
													'id'          	=> 'notice_desc',
													'value'       	=> '',
													'placeholder'	=> '',
													'cols'			=> 	'80',
													'rows'			=> 	'10',
													'maxlength'		=>	'4000',
													'class'			=>	'col-xs-11 col-sm-11'
					            				);
	
								echo form_textarea($notice_desc);
							?>
						</div>
						<div class="form-group">
							<label>Weight</label>
							<?php
								$notice_weight = array(
					              					'name'        	=> 'notice_weight',
													'id'          	=> 'notice_weight',
													'value'       	=> '',
													'placeholder'	=> '',
													'maxlength'		=>	'2',
													'class'			=>	'col-xs-6 col-sm-6 input-number'
					            				);
	
								echo form_input($notice_weight);
							?>
						</div>
						
						<div class="form-group">
							<label>Select File To Upload</label>
							<input type="file" name="userfile" id="userfile" multiple="multiple"  />
						</div>
			
						<div class="form-group">
							<input type="checkbox" name="notice_is_active" id="notice_is_active" class=""/>&nbsp;Active
						</div>
						<div class="form-group">
							<button class="btn btn-info search-record" type="button">Search</button>
							<button class="btn btn-primary addedit-btn" type="button">Save</button>
							<button type="button" class="btn btn-default cancel-btn">Cancel</button>
						</div>	
						
						<input type="hidden" name="record_id" id="record_id">
						<input type="hidden" name="form_action" id="form_action" value="add">
					<?php	
						echo form_close();
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
$('input').bind('keypress',function(event) {
	if(event.charCode == 39 || event.charCode == 34 || event.charCode == 96 || event.charCode == 126 || event.charCode==42 || event.charCode==37){
		jAlert('This special character not allowd.');
		return false;
	}
});
$('textarea').bind('keypress',function(event) {
	if(event.charCode == 39 || event.charCode == 34 || event.charCode == 96 || event.charCode == 126 || event.charCode==42 || event.charCode==37){
		jAlert('This special character not allowd.');
		return false;
	}
});


var notices = '<?php echo json_encode($notices);?>';
var notices_data = jQuery.parseJSON(notices);

$(document).ready(function() {
	printAllNotice(notices_data);
});	

function printAllNotice(arr) {
	var s = "";
	if(arr.length > 0) {
			for(var i=0; i<arr.length; i++) {
				var is_active = (arr[i].notice_is_active == "1") ? "<i class='fa fa-check green-text'></i>" : "<i class='fa fa-times red-text'></i>";
				var notice_file = '<a href="<?php echo $this->config->base_url(); ?>upload/notices/'+arr[i].notice_file+'" target="_blank">'+arr[i].notice_file+'</a>';
				s += "<tr>";
				s += "<td>" + (i+1) + "</td>";
				s += "<td>" + arr[i].notice_ctgry + "</td>";
				s += "<td>" + arr[i].notice_weight + "</td>";
				s += "<td>" + arr[i].notice_title + "</td>";
				s += "<td>" + arr[i].notice_desc.substring(0, 20)+"..."; + "</td>";
				s += "<td>" + notice_file + "</td>";
				s += "<td style='text-align:center;'>" + is_active + "</td>";
				s += "<td class='text-center'>"
				s += "<a href='javascript:void(0);' id='edit_" + i + "' class='btn btn-primary btn-xs edit-record'>Edit</a>&nbsp;&nbsp;";
				s += "<a href='javascript:void(0);' id='del_" + i + "' class='btn btn-danger btn-xs delete-record'>Delete</a>";
				s += "</td>";
				s += "</tr>"
			}
		}else {
	
		s += '<tr><td colspan="100%"><h3 class="top-mrgn-sm btm-mrgn-sm">No data available</h3></td></tr>';
	}
	$('#tbl-content').html(s);
}

//edit record
$(document).on('click','.edit-record',function() {
	var arr = $(this).attr('id').split("_");
	var index = arr[1];
	$('.addedit-label').html('Edit Notice');
	$('#notice_ctgry').val(notices_data[index].notice_ctgry);
	$('#notice_title').val(notices_data[index].notice_title);
	$('#notice_weight').val(notices_data[index].notice_weight);
	
	var description = notices_data[index].notice_desc;
		description = description.replace("&quote;", '"');
		description = description.replace("&apos;", "'");
	
	$('#notice_desc').val(description);
	
	if(notices_data[index].notice_is_active == "1") {
		$('#notice_is_active').prop('checked', true);
	} else {
		$('#notice_is_active').prop('checked', false);
	}
	$('#record_id').val(notices_data[index].notice_id);
	$('#form_action').val('edit');
});

$(document).on('click','.search-record',function() {
	var notice_ctgry = $('#notice_ctgry').val();
	var params = "notice_ctgr="+notice_ctgry;
	$.ajax({
				url: "<?php echo $this->config->base_url();?>admissions/loadnotices",
				type: "post",
				data: params,
				dataType: "json",
				success: function(response){
									//show message
									printAllNotice(response);
									notices_data = response;
								 }
			});
	
});	

$(document).on('click','.delete-record',function() {
	var arr = $(this).attr('id').split("_");
	var index = arr[1];
	var notice_id = notices_data[index].notice_id;
	var params = "id="+notice_id;			
	var loadUrl = "<?php echo $this->config->base_url();?>admissions/delnotice/"+new Date().getTime();
	jConfirm('Are you sure want to delete?', 'Please Confirm', function(e) {
		if (e) {	
			$.ajax({
			    type: "POST",
			    url: loadUrl,
			    data: params,
			    success: function(res){
			    	if(res == 'DELETED') {
						$.ajax({
								url: "<?php echo $this->config->base_url();?>admissions/loadnotices",
								type: "post",
								dataType: "json",
								success: function(response){
													//show message
													printAllNotice(response);
													notices_data = response;
													
													$('.action-message').remove();
													$('<div>').attr({
													    class: 'alert alert-success action-message'
													}).html('Record deleted succesfully').prependTo('.data-content');
					
												 }
							});
						
						
						
			    	}
			    }
			});    		
		}
	});	
	
});	

//cancel action
$(document).on('click','.cancel-btn',function() {
	$('.addedit-label').html('Create Notice');
	$('#form_action').val('add');
	$('#notice_ctgry').val('EMPTY');
	$('#notice_title').val('');
	$('#notice_weight').val('');
	$('#notice_desc').val('');
	$('#notice_is_active').prop('checked', false);
	$('#record_id').val(0);
});

//validates form
$(document).on('click','.addedit-btn',function() {
	$('.error-msg').remove();
	$('input').removeClass('form-error');
	$('textarea').removeClass('form-error');
	
	var notice_ctgry = $('#notice_ctgry').val();
	var notice_title = $('#notice_title').val();
	var notice_desc  = $('#notice_desc').val();
	var notice_weight  = $('#notice_weight').val();
	
	var error = false;
	var msg = "<h4><strong>Ohh!</strong> Change a few things up and try submitting again.</h4>";
	
	if(notice_ctgry == 'EMPTY') {
		error = true;
		$('#notice_ctgry').addClass('form-error');
	}
	/*
	if(notice_title == '') {
			error = true;
			$('#notice_title').addClass('form-error');
		}*/
	
	if(notice_desc == '') {
		error = true;
		$('#notice_desc').addClass('form-error');
	}
	if(notice_weight == '') {
		error = true;
		$('#notice_weight').addClass('form-error');
	}
	
	if(error) {
		$('#addeditform').before("<div class='error-msg'></div>");
		$('.error-msg').html(msg);
		return false;
	} else {
		$('#addeditform').submit();
	}
});	
</script>