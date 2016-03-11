<div class="page-title">
	<h2>Payment Process Files</h2>
	<ul class="breadcrumb">
		<li>You are here:</li>
		<li class="active">Operations</li>
		<li class="">Payment Process File</li>
	</ul>
</div>	<!-- /heading -->

<div class="container-fluid">
	<div class="row">
		<div class="col-sm-12 data-content">
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
							<th style="width:9%;">File Date</th>
							<th style="width:15%;">File Name</th>
							<th style="width:9%;">Prcs Date</th>
							<th style="width:13%;">File Status</th>
							<th style="width:10%;">Ttl Rcrd</th>
							<th style="width:10%;">NonPrcs Rcrd</th>
							<th style="width:15%;">Non Prcs File</th>
							<th style="width:10%;">Action</th>
						</tr>
					</thead>
					<tbody id="tbl-content"></tbody>
				</table>
				<div class="paginator pull-right btm-mrgn-sm"></div>
			</div>	<!-- /box -->
		</div>
	
	</div>
</div>

<?php
	$this->load->view('footer');
?>		

<script type="text/javascript">
var payment_files = '<?php echo json_encode($payment_files);?>';
var payment_files_data = jQuery.parseJSON(payment_files);

$(document).ready(function() {
	printAllPaymentFile(payment_files_data);
});	

function printAllPaymentFile(arr) {
	var s = "";
	if(arr.length > 0) {
			for(var i=0; i<arr.length; i++) {
				var payment_files = '<a href="<?php echo $this->config->base_url(); ?>upload/payments/'+arr[i].file_name+'" target="_blank">'+arr[i].file_name+'</a>';
				var non_payment_files = "<a href='javascript:void(0);' id='edit_" + i + "' class='btn btn-info btn-xs generate-record'>Non Verified Record</a>&nbsp;&nbsp;";
				
				var processed_on = "";
				if(arr[i].file_status > 0){
					processed_on = arr[i].processed_on
				}
				if(arr[i].total_record  > 0 &&  arr[i].unprocess_record  != 0){
				}
				else{
					non_payment_files="";
				}
				
				s += "<tr>";
				s += "<td>" + (i+1) + "</td>";
				s += "<td>" + arr[i].file_date + "</td>";
				s += "<td>" + payment_files + "</td>";
				s += "<td>" + processed_on  + "</td>";
				s += "<td>" +  arr[i].file_status_name + "</td>";
				s += "<td>" +  arr[i].total_record + "</td>";
				s += "<td>" +  arr[i].unprocess_record + "</td>";
				s += "<td class='text-center'>"+ non_payment_files + "</td>";
				s += "<td class='text-center'>"
				if(arr[i].file_status == 0 || arr[i].file_status == 1){
					s += "<a href='javascript:void(0);' id='del_" + i + "' class='btn btn-success btn-xs process-record'>Run Process</a>";
				}				
				s += "</td>";
				s += "</tr>"
			}
		}else {
	
		s += '<tr><td colspan="100%"><h3 class="top-mrgn-sm btm-mrgn-sm">No data available</h3></td></tr>';
	}
	$('#tbl-content').html(s);
}


$(document).on('click','.generate-record',function() {
	var arr = $(this).attr('id').split("_");
	var index = arr[1];
	var file_id = payment_files_data[index].file_id;
	var params = "id="+file_id;			
	var loadUrl = "<?php echo $this->config->base_url();?>operations/downloadnonverifiedrecord/"+file_id+"/"+new Date().getTime();
	window.open(loadUrl);	
});	

$(document).on('click','.process-record',function() {
	var arr = $(this).attr('id').split("_");
	var index = arr[1];
	var file_id = payment_files_data[index].file_id;
	var params = "id="+file_id;			
	var loadUrl = "<?php echo $this->config->base_url();?>operations/verifysystempayments/"+new Date().getTime();
	jConfirm('Are you sure want to process the file?', 'Please Confirm', function(e) {
		if (e) {	
			$.ajax({
			    type: "POST",
			    url: loadUrl,
			    data: params,
			    success: function(res){
			    	if(res == 'SUCCESS') {
						$.ajax({
								url: "<?php echo $this->config->base_url();?>operations/loadpayments",
								type: "post",
								dataType: "json",
								success: function(response){
													//show message
													console.log(response);
													printAllPaymentFile(response);
													payment_files_data = response;
													
													$('.action-message').remove();
													$('<div>').attr({
													    class: 'alert alert-success action-message'
													}).html('Payment file processed succesfully').prependTo('.data-content');
					
												 }
							});
						
						
						
			    	}
			    }
			});    		
		}
	});	
	
});	


</script>