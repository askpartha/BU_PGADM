<div class="page-title">
	<h2>Subjects</h2>
	<ul class="breadcrumb">
		<li>You are here:</li>
		<li class="active">Master Data</li>
		<li class="">Subjects</li>
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
							<th style="width:25%;">Subj. Code</th>
							<th style="width:38%;">Subject Name</th>
							<th style="width:7%;">Active</th>
							<th style="width:18%;">Action</th>
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
					<h3 class="addedit-label">Create Subject</h3>
				</div>
				<div class="content">	
					<?php
						$form = array(
										'class'	=>	'form-horizontal lft-pad-nm',
										'role'	=>	'form',
										'id' => 'addeditform'
									);	
						echo form_open('configs/createsubject', $form);
					?>
						
						<div class="form-group">
							<label>Subject Code</label>
							<?php
								$subj_code = array(
					              					'name'        	=> 'subj_code',
													'id'          	=> 'subj_code',
													'maxlength'    	=> '5',
													'value'       	=> '',
													'placeholder'	=> '',
													'class'			=>	'col-xs-10 col-sm-10'
					            				);
	
								echo form_input($subj_code);
							?>
						</div>
						
						<div class="form-group">
							<label>Subject Name</label>
							<?php
								$subj_name = array(
					              					'name'        	=> 'subj_name',
													'id'          	=> 'subj_name',
													'maxlength'    	=> '50',
													'value'       	=> '',
													'placeholder'	=> '',
													'class'			=>	'col-xs-10 col-sm-10'
					            				);
	
								echo form_input($subj_name);
							?>
						</div>
						
						<div class="form-group">
							<input type="checkbox" name="subj_is_active" id="subj_is_active" class=""/>&nbsp;Active
						</div>
						
						<div class="form-group">
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
var subjects = '<?php echo json_encode($subjects);?>';
var subjects_data = jQuery.parseJSON(subjects);

$(document).ready(function() {
	printAllSubjects(subjects_data);
});	

function printAllSubjects(arr) {
	console.log(arr);
	var s = "";
	if(arr.length > 0) {
			for(var i=0; i<arr.length; i++) {
				var is_active = (arr[i].subj_is_active == "1") ? "<i class='fa fa-check green-text'></i>" : "<i class='fa fa-times red-text'></i>";
				s += "<tr>";
				s += "<td>" + (i+1) + "</td>";
				s += "<td>" + arr[i].subj_code + "</td>";
				s += "<td>" + arr[i].subj_name + "</td>";
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
	$('.addedit-label').html('Edit Subject');
	$('#subj_code').val(subjects_data[index].subj_code);
	$('#subj_name').val(subjects_data[index].subj_name);
	if(subjects_data[index].subj_is_active == "1") {
		$('#subj_is_active').prop('checked', true);
	} else {
		$('#subj_is_active').prop('checked', false);
	}
	$('#record_id').val(subjects_data[index].subj_id);
	$('#form_action').val('edit');
});

$(document).on('click','.delete-record',function() {
	var arr = $(this).attr('id').split("_");
	var index = arr[1];
	var subj_id = subjects_data[index].subj_id;
	var params = "id="+subj_id;			
	var loadUrl = "<?php echo $this->config->base_url();?>configs/delsubject/"+new Date().getTime();
	
	jConfirm('Are you sure want to delete?', 'Please Confirm', function(e) {
		if (e) {	
			$.ajax({
			    type: "POST",
			    url: loadUrl,
			    data: params,
			    success: function(res){
			    	if(res == 'DELETED') {
						$.ajax({
								url: "<?php echo $this->config->base_url();?>configs/loadsubjects",
								type: "post",
								dataType: "json",
								success: function(response){
													//show message
													printAllSubjects(response);
													subjects_data = response;
													
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
	$('.addedit-label').html('Create Subject');
	$('#form_action').val('add');
	$('#subj_code').val('');
	$('#subj_name').val('');
	$('#subj_is_active').prop('checked', false);
	$('#record_id').val(0);
});

//validates form
$(document).on('click','.addedit-btn',function() {
	$('.error-msg').remove();
	$('input').removeClass('form-error');
	
	var subj_code = $('#subj_code').val();
	var subj_name = $('#subj_name').val();
	
	var error = false;
	var msg = "<h4><strong>Ohh!</strong> Change a few things up and try submitting again.</h4>";
	
	if(subj_code == '') {
		error = true;
		$('#subj_code').addClass('form-error');
	}
	if(subj_name == '') {
		error = true;
		$('#subj_name').addClass('form-error');
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