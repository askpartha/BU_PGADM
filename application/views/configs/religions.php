<div class="page-title">
	<h2>Religions</h2>
	<ul class="breadcrumb">
		<li>You are here:</li>
		<li class="active">Master Data</li>
		<li class="">Religions</li>
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
							<th style="width:60%;">Religion</th>
							<th style="width:10%;">Wight</th>
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
					<h3 class="addedit-label">Create Religion</h3>
				</div>
				<div class="content">	
					<?php
						$form = array(
										'class'	=>	'form-horizontal lft-pad-nm',
										'role'	=>	'form',
										'id' => 'addeditform'
									);	
						echo form_open('configs/createreligion', $form);
					?>
						<div class="form-group">
							<label>Religion</label>
							<?php
								$relg_val = array(
					              					'name'        	=> 'relg_val',
													'id'          	=> 'relg_val',
													'value'       	=> '',
													'placeholder'	=> '',
													'class'			=>	'col-xs-10 col-sm-10'
					            				);
	
								echo form_input($relg_val);
							?>
						</div>
						
						<div class="form-group">
							<label>Weight</label>
							<?php
								$relg_weight = array(
					              					'name'        	=> 'relg_weight',
													'id'          	=> 'relg_weight',
													'value'       	=> '',
													'placeholder'	=> '',
													'maxlength'		=> '3',
													'class'			=>	'col-xs-10 col-sm-10 input-number'
					            				);
	
								echo form_input($relg_weight);
							?>
						</div>
						
						<div class="form-group">
							<input type="checkbox" name="relg_is_active" id="relg_is_active" class=""/>&nbsp;Active
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
var religions = '<?php echo json_encode($religions);?>';
var religions_data = jQuery.parseJSON(religions);

$(document).ready(function() {
	printAllReligion(religions_data);
});	

function printAllReligion(arr) {
	var s = "";
	if(arr.length > 0) {
			for(var i=0; i<arr.length; i++) {
				var is_active = (arr[i].relg_is_active == "1") ? "<i class='fa fa-check green-text'></i>" : "<i class='fa fa-times red-text'></i>";
				s += "<tr>";
				s += "<td>" + (i+1) + "</td>";
				s += "<td>" + arr[i].relg_val + "</td>";
				s += "<td>" + arr[i].relg_weight + "</td>";
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
	$('.addedit-label').html('Edit Religion');
	$('#relg_val').val(religions_data[index].relg_val);
	$('#relg_weight').val(religions_data[index].relg_weight);
	if(religions_data[index].relg_is_active == "1") {
		$('#relg_is_active').prop('checked', true);
	} else {
		$('#relg_is_active').prop('checked', false);
	}
	$('#record_id').val(religions_data[index].relg_id);
	$('#form_action').val('edit');
});

$(document).on('click','.delete-record',function() {
	var arr = $(this).attr('id').split("_");
	var index = arr[1];
	var relg_id = religions_data[index].relg_id;
	var params = "id="+relg_id;			
	var loadUrl = "<?php echo $this->config->base_url();?>configs/delreligion/"+new Date().getTime();
	
	jConfirm('Are you sure want to delete?', 'Please Confirm', function(e) {
		if (e) {	
			$.ajax({
			    type: "POST",
			    url: loadUrl,
			    data: params,
			    success: function(res){
			    	if(res == 'DELETED') {
						$.ajax({
								url: "<?php echo $this->config->base_url();?>configs/loadreligions",
								type: "post",
								dataType: "json",
								success: function(response){
													//show message
													printAllReligion(response);
													religions_data = response;
													
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
	$('.addedit-label').html('Create Religion');
	$('#form_action').val('add');
	$('#relg_val').val('');
	$('#relg_weight').val('');
	$('#relg_is_active').prop('checked', false);
	$('#record_id').val(0);
});

//validates form
$(document).on('click','.addedit-btn',function() {
	$('.error-msg').remove();
	$('input').removeClass('form-error');
	
	var relg_val = $('#relg_val').val();
	var relg_weight = $('#relg_weight').val();
	
	var error = false;
	var msg = "<h4><strong>Ohh!</strong> Change a few things up and try submitting again.</h4>";
	
	if(relg_val == '') {
		error = true;
		$('#relg_val').addClass('form-error');
	}
	if(relg_weight == '') {
		error = true;
		$('#relg_weight').addClass('form-error');
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