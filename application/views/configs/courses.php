<div class="page-title">
	<h2>Courses</h2>
	<ul class="breadcrumb">
		<li>You are here:</li>
		<li class="active">Master Data</li>
		<li class="">Courses</li>
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
							<th style="width:20%;">Code</th>
							<th style="width:40%;">Courses</th>
							<th style="width:10%;">Weight</th>
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
					<h3 class="addedit-label">Create Course</h3>
				</div>
				<div class="content">	
					<?php
						$form = array(
										'class'	=>	'form-horizontal lft-pad-nm',
										'role'	=>	'form',
										'id' => 'addeditform'
									);	
						echo form_open('configs/createcourse', $form);
					?>
						<div class="form-group">
							<label>Course</label>
							<?php
								$cors_name = array(
					              					'name'        	=> 'cors_name',
													'id'          	=> 'cors_name',
													'value'       	=> '',
													'placeholder'	=> '',
													'class'			=>	'col-xs-10 col-sm-10'
					            				);
	
								echo form_input($cors_name);
							?>
						</div>
						
						<div class="form-group">
							<label>Course Code</label>
							<?php
								$cors_code = array(
					              					'name'        	=> 'cors_code',
													'id'          	=> 'cors_code',
													'value'       	=> '',
													'placeholder'	=> '',
													'class'			=>	'col-xs-10 col-sm-10'
					            				);
	
								echo form_input($cors_code);
							?>
						</div>
						<div class="form-group">
							<label>Weight</label>
							<?php
								$cors_weight = array(
					              					'name'        	=> 'cors_weight',
													'id'          	=> 'cors_weight',
													'value'       	=> '',
													'placeholder'	=> '',
													'maxlength'		=> '2',
													'class'			=>	'col-xs-10 col-sm-10 input-number'
					            				);
	
								echo form_input($cors_weight);
							?>
						</div>
						
						
						<div class="form-group">
							<input type="checkbox" name="cors_is_active" id="cors_is_active" class=""/>&nbsp;Active
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
var courses = '<?php echo json_encode($courses);?>';
var courses_data = jQuery.parseJSON(courses);

$(document).ready(function() {
	printAllCourses(courses_data);
});	

function printAllCourses(arr) {
	var s = "";
	if(arr.length > 0) {
			for(var i=0; i<arr.length; i++) {
				var is_active = (arr[i].cors_is_active == "1") ? "<i class='fa fa-check green-text'></i>" : "<i class='fa fa-times red-text'></i>";
				s += "<tr>";
				s += "<td>" + (i+1) + "</td>";
				s += "<td>" + arr[i].cors_code + "</td>";
				s += "<td>" + arr[i].cors_name + "</td>";
				s += "<td>" + arr[i].cors_weight + "</td>";
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
	$('.addedit-label').html('Edit Course');
	$('#cors_code').val(courses_data[index].cors_code);
	$('#cors_name').val(courses_data[index].cors_name);
	$('#cors_weight').val(courses_data[index].cors_weight);
	
	if(courses_data[index].cors_is_active == "1") {
		$('#cors_is_active').prop('checked', true);
	} else {
		$('#cors_is_active').prop('checked', false);
	}
	$('#record_id').val(courses_data[index].cors_id);
	$('#form_action').val('edit');
});

$(document).on('click','.delete-record',function() {
	var arr = $(this).attr('id').split("_");
	var index = arr[1];
	var cors_id = courses_data[index].cors_id;
	var params = "id="+cors_id;			
	var loadUrl = "<?php echo $this->config->base_url();?>configs/delcourse/"+new Date().getTime();
	
	jConfirm('Are you sure want to delete?', 'Please Confirm', function(e) {
		if (e) {	
			$.ajax({
			    type: "POST",
			    url: loadUrl,
			    data: params,
			    success: function(res){
			    	if(res == 'DELETED') {
						$.ajax({
								url: "<?php echo $this->config->base_url();?>configs/loadcourses",
								type: "post",
								dataType: "json",
								success: function(response){
													//show message
													printAllCourses(response);
													courses_data = response;
													
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
	$('.addedit-label').html('Create Course');
	$('#form_action').val('add');
	$('#cors_code').val('');
	$('#cors_name').val('');
	$('#cors_weight').val('');
	$('#cors_is_active').prop('checked', false);
	$('#record_id').val(0);
});

//validates form
$(document).on('click','.addedit-btn',function() {
	$('.error-msg').remove();
	$('input').removeClass('form-error');
	
	var cors_code = $('#cors_code').val();
	var cors_name = $('#cors_name').val();
	var cors_weight = $('#cors_weight').val();
	
	var error = false;
	var msg = "<h4><strong>Ohh!</strong> Change a few things up and try submitting again.</h4>";
	
	if(cors_code == '') {
		error = true;
		$('#cors_code').addClass('form-error');
	}
	if(cors_name == '') {
		error = true;
		$('#cors_name').addClass('form-error');
	}
	if(cors_weight == '') {
		error = true;
		$('#cors_weight').addClass('form-error');
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