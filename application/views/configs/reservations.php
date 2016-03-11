<div class="page-title">
	<h2>Reservations</h2>
	<ul class="breadcrumb">
		<li>You are here:</li>
		<li class="active">Master Data</li>
		<li class="">Reservations</li>
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
							<th style="width:30%;">Name</th>
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
					<h3 class="addedit-label">Create Reservation</h3>
				</div>
				<div class="content">	
					<?php
						$form = array(
										'class'	=>	'form-horizontal lft-pad-nm',
										'role'	=>	'form',
										'id' => 'addeditform'
									);	
						echo form_open('configs/createreservation', $form);
					?>
						<div class="form-group">
							<label>Rreservation</label>
							<?php
								$resv_name = array(
					              					'name'        	=> 'resv_name',
													'id'          	=> 'resv_name',
													'maxlength'     => '50',
													'value'       	=> '',
													'placeholder'	=> '',
													'class'			=>	'col-xs-10 col-sm-10'
					            				);
	
								echo form_input($resv_name);
							?>
						</div>
						
						<div class="form-group">
							<label>Rreservation Code</label>
							<?php
								$resv_code = array(
					              					'name'        	=> 'resv_code',
													'id'          	=> 'resv_code',
													'maxlength'     => '10',
													'value'       	=> '',
													'placeholder'	=> '',
													'class'			=>	'col-xs-10 col-sm-10'
					            				);
	
								echo form_input($resv_code);
							?>
						</div>
						<div class="form-group">
							<label>Weight</label>
							<?php
								$resv_weight = array(
					              					'name'        	=> 'resv_weight',
													'id'          	=> 'resv_weight',
													'maxlength'     => '2',
													'value'       	=> '',
													'placeholder'	=> '',
													'class'			=>	'col-xs-10 col-sm-10 input-number'
					            				);
	
								echo form_input($resv_weight);
							?>
						</div>
						<div class="form-group">
							<input type="checkbox" name="resv_is_active" id="resv_is_active" class=""/>&nbsp;Active
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
var reservations = '<?php echo json_encode($reservations);?>';
var reservations_data = jQuery.parseJSON(reservations);

$(document).ready(function() {
	printAllRreservations(reservations_data);
});	

function printAllRreservations(arr) {
	var s = "";
	if(arr.length > 0) {
			for(var i=0; i<arr.length; i++) {
				var is_active = (arr[i].resv_is_active == "1") ? "<i class='fa fa-check green-text'></i>" : "<i class='fa fa-times red-text'></i>";
				s += "<tr>";
				s += "<td>" + (i+1) + "</td>";
				s += "<td>" + arr[i].resv_code + "</td>";
				s += "<td>" + arr[i].resv_name + "</td>";
				s += "<td>" + arr[i].resv_weight + "</td>";
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
	$('.addedit-label').html('Edit Rreservation');
	$('#resv_code').val(reservations_data[index].resv_code);
	$('#resv_name').val(reservations_data[index].resv_name);
	$('#resv_weight').val(reservations_data[index].resv_weight);
	
	if(reservations_data[index].resv_is_active == "1") {
		$('#resv_is_active').prop('checked', true);
	} else {
		$('#resv_is_active').prop('checked', false);
	}
	$('#record_id').val(reservations_data[index].resv_id);
	$('#form_action').val('edit');
});

$(document).on('click','.delete-record',function() {
	var arr = $(this).attr('id').split("_");
	var index = arr[1];
	var resv_id = reservations_data[index].resv_id;
	var params = "id="+resv_id;			
	var loadUrl = "<?php echo $this->config->base_url();?>configs/delreservation/"+new Date().getTime();
	
	jConfirm('Are you sure want to delete?', 'Please Confirm', function(e) {
		if (e) {	
			$.ajax({
			    type: "POST",
			    url: loadUrl,
			    data: params,
			    success: function(res){
			    	if(res == 'DELETED') {
						$.ajax({
								url: "<?php echo $this->config->base_url();?>configs/loadreservations",
								type: "post",
								dataType: "json",
								success: function(response){
													//show message
													printAllRreservations(response);
													reservations_data = response;
													
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
	$('.addedit-label').html('Create Rreservation');
	$('#form_action').val('add');
	$('#resv_code').val('');
	$('#resv_name').val('');
	$('#resv_weight').val('');
	$('#resv_is_active').prop('checked', false);
	$('#record_id').val(0);
});

//validates form
$(document).on('click','.addedit-btn',function() {
	$('.error-msg').remove();
	$('input').removeClass('form-error');
	
	var resv_code = $('#resv_code').val();
	var resv_name = $('#resv_name').val();
	var resv_weight = $('#resv_weight').val();
	
	var error = false;
	var msg = "<h4><strong>Ohh!</strong> Change a few things up and try submitting again.</h4>";
	
	if(resv_code == '') {
		error = true;
		$('#resv_code').addClass('form-error');
	}
	
	if(resv_name == '') {
		error = true;
		$('#resv_name').addClass('form-error');
	}
	
	if(resv_weight == '') {
		error = true;
		$('#resv_weight').addClass('form-error');
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