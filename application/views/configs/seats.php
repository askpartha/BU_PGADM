<div class="page-title">
	<h2>Seat Matrix</h2>
	<ul class="breadcrumb">
		<li>You are here:</li>
		<li class="active">Master Data</li>
		<li class="">Seat Matrix</li>
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
							<th style="width:15%;">Subject Name.</th>
							<th style="width:10%;">Rank Ctgr.</th>
							<th style="width:9%;">Resv.</th>
							<th style="width:9%;">Extra Resv.</th>
							<th style="width:7%;">Count.</th>
							<th style="width:30%;">Merit Dscr.</th>
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
					<h3 class="addedit-label">Create Seat</h3>
				</div>
				<div class="content">	
					<?php
						$form = array(
										'class'	=>	'form-horizontal lft-pad-nm',
										'role'	=>	'form',
										'id' => 'addeditform'
									);	
						echo form_open('configs/createseat', $form);
					?>
						<div class="form-group">
							<label>Subject*</label>
							<?php
								$subject = 'id="seat_subj" class="col-xs-10 col-sm-10"';				
								echo form_dropdown('seat_subj', $subject_options, null, $subject)
							?>
						</div>
						<div class="form-group">
							<label>Category*</label>
							<?php
								$category = 'id="seat_rank_ctgr" class="col-xs-10 col-sm-10"';				
								echo form_dropdown('seat_rank_ctgr', $seat_category_options, null, $category)
							?>
						</div>
						<div class="form-group">
							<label>Reservation</label>
							<?php
								$reservation = 'id="seat_resv" class="col-xs-10 col-sm-10"';				
								echo form_dropdown('seat_resv', $reservation_options, null, $reservation)
							?>
						</div>
						
						<div class="form-group">
							<label>Extra Reservation</label>
							<?php
								$extra_reservation = 'id="seat_resv_extra" class="col-xs-10 col-sm-10"';				
								echo form_dropdown('seat_resv_extra', $extra_reservation_options, null, $extra_reservation)
							?>
						</div>
						
						<div class="form-group">
							<label>Number of Seat</label>
							<?php
								$seat_cnt = array(
					              					'name'        	=> 'seat_cnt',
													'id'          	=> 'seat_cnt',
													'maxlength'    	=> '3',
													'value'       	=> '',
													'placeholder'	=> '',
													'class'			=>	'col-xs-10 col-sm-10 input-number'
					            				);
								echo form_input($seat_cnt);
							?>
						</div>
						<div class="form-group">
							<label>Merit List Description(<small>will appear in the meritlist</small>)</label>
							<?php
								$seat_desc_data = array(
					              					'name'        	=> 'seat_desc',
													'id'          	=> 'seat_desc',
													'maxlength'    	=> '200',
													'value'       	=> '',
													'placeholder'	=> '',
													'class'			=>	'col-xs-10 col-sm-10'
					            				);
								echo form_input($seat_desc_data);
							?>
						</div>
						
						<div class="form-group">
							<button class="btn btn-info search-btn" type="button">Search</button> &nbsp;
							<button class="btn btn-primary addedit-btn" type="button">Save</button> &nbsp;
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
var seats = '<?php echo json_encode($seats);?>';
var seats_data = jQuery.parseJSON(seats);

$(document).ready(function() {
	printAllSeats(seats_data);
});	

function printAllSeats(arr) {
	console.log(arr);
	var s = "";
	if(arr.length > 0) {
			for(var i=0; i<arr.length; i++) {
				var seat_resv_extra = arr[i].seat_resv_extra;
				if(arr[i].seat_resv_extra=='EMPTY'){
					seat_resv_extra = "---";
				}
				s += "<tr>";
				s += "<td>" + (i+1) + "</td>";
				s += "<td>" + arr[i].subj_name + "</td>";
				s += "<td>" + arr[i].seat_rank_ctgr_name + "</td>";
				s += "<td>" + arr[i].resv_name + "</td>";
				s += "<td>" + seat_resv_extra + "</td>";
				s += "<td>" + arr[i].seat_cnt + "</td>";
				s += "<td>" + arr[i].seat_desc.substr(0, 50)+"..." + "</td>";
				s += "<td class='text-center'>"
				s += "<a href='javascript:void(0);' id='edit_" + i + "' class='btn btn-primary btn-xs edit-record'>Edit</a>&nbsp;&nbsp;";
				s += "<a href='javascript:void(0);' id='del_"  + arr[i].seat_id + "' class='btn btn-danger btn-xs delete-record'>Delete</a>";
				s += "</td>";
				s += "</tr>"
			}
		}else {
	
		s += '<tr><td colspan="100%"><h3 class="top-mrgn-sm btm-mrgn-sm">No data available</h3></td></tr>';
	}
	$('#tbl-content').html(s);
}

$(document).on('click','.search-btn',function() {
	var seat_subj = $('#seat_subj').val();
	var seat_rank_ctgr = $('#seat_rank_ctgr').val();
	var flag = true;
	
	if(seat_subj == 'EMPTY') {
		flag = false;
		$('#seat_subj').addClass('form-error');
	}
	if(seat_rank_ctgr == 'EMPTY') {
		flag = false;
		$('#seat_rank_ctgr').addClass('form-error');
	}
	
	if(flag){
		var params = "seat_subj="+seat_subj+"&seat_rank_ctgr="+seat_rank_ctgr;
		$.ajax({
					url: "<?php echo $this->config->base_url();?>configs/loadseats",
					type: "post",
					data: params,
					dataType: "json",
					success: function(response){
										//show message
										printAllSeats(response);
										seats_data = response;
									 }
				});
	}
	
});	

//edit record
$(document).on('click','.edit-record',function() {
	var arr = $(this).attr('id').split("_");
	var index = arr[1];
	$('.addedit-label').html('Edit Subject');

	$('#seat_subj').val(seats_data[index].seat_subj);
	$('#seat_resv').val(seats_data[index].seat_resv);
	$('#seat_resv_extra').val(seats_data[index].seat_resv_extra);
	$('#seat_rank_ctgr').val(seats_data[index].seat_rank_ctgr);
	$('#seat_cnt').val(seats_data[index].seat_cnt);
	$('#seat_desc').val(seats_data[index].seat_desc);
	$('#record_id').val(seats_data[index].seat_id);

	$('#form_action').val('edit');
});

$(document).on('click','.delete-record',function() {
	var arr = $(this).attr('id').split("_");
	
	var seat_id = arr[1];
	
	//alert(seat_id);
	
	var params = "id="+seat_id;			
	var loadUrl = "<?php echo $this->config->base_url();?>configs/delseat/"+new Date().getTime();
	
	jConfirm('Are you sure want to delete?', 'Please Confirm', function(e) {
		if (e) {	
			$.ajax({
			    type: "POST",
			    url: loadUrl,
			    data: params,
			    success: function(res){
			    	if(res == 'DELETED') {
						$.ajax({
								url: "<?php echo $this->config->base_url();?>configs/loadseats",
								type: "post",
								dataType: "json",
								success: function(response){
													//show message
													printAllSeats(response);
													seats_data = response;
													
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
	$('#seat_subj').val('EMPTY');
	$('#seat_resv').val('EMPTY');
	$('#seat_resv_extra').val('EMPTY');
	$('#seat_rank_ctgr').val('EMPTY');
	$('#seat_cnt').val('');
	$('#seat_desc').val('');
	$('#record_id').val(0);
});

//validates form
$(document).on('click','.addedit-btn',function() {
	$('.error-msg').remove();
	$('input').removeClass('form-error');
	$('select').removeClass('form-error');
	
	var seat_subj 	= $('#seat_subj').val();
	var seat_resv 	= $('#seat_resv').val();
	var seat_rank_ctgr 	= $('#seat_rank_ctgr').val();
	var seat_cnt 		= $('#seat_cnt').val();
	var seat_desc  	= $('#seat_desc').val();
	
	var error = false;
	var msg = "<h4><strong>Ohh!</strong> Change a few things up and try submitting again.</h4>";
	
	if(seat_desc.trim() == '') {
		error = true;
		$('#seat_desc').addClass('form-error');
	}
	if(seat_subj == 'EMPTY') {
		error = true;
		$('#seat_subj').addClass('form-error');
	}
	if(seat_resv == 'EMPTY') {
		error = true;
		$('#seat_resv').addClass('form-error');
	}
	if(seat_rank_ctgr == 'EMPTY') {
		error = true;
		$('#seat_rank_ctgr').addClass('form-error');
	}
	if(seat_cnt == '') {
		error = true;
		$('#seat_cnt').addClass('form-error');
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