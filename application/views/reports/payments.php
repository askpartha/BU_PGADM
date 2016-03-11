<div class="page-title">
	<h2>Payment Information</h2>
	<ul class="breadcrumb">
		<li>You are here:</li>
		<li class="active">Reports</li>
		<li class="">Payments</li>
	</ul>
</div>	<!-- /heading -->

<div class="container-fluid">
	<div class="row">
	<?php
		$form = array(
						'class'	=>	'form-horizontal lft-pad-nm',
						'role'	=>	'form',
						'id' => 'searchform'
					);	
		echo form_open('reports/searchappl', $form);
	?>
		<div class="col-sm-3">
			<div class="form-group">
				<label>Payment Date</label>
				<?php
					$pmt_date_data = array(
			              					'name'        	=> 'pmt_date',
											'id'          	=> 'pmt_date',
											'tabindex'      => '1',
											'class'			=>	'col-xs-8 col-sm-8 datepicker'
			            				);

					echo form_input($pmt_date_data);
				?>
				<input type="hidden" id="pmt_date_hidden" name="pmt_date_hidden" value=""/>
			</div>
		</div>
		<div class="col-sm-3">	
			<div class="form-group">
				<label>&nbsp;</label>
				<button type="button" class="btn btn-success search-btn">Search</button>
			</div>
		</div>
		<?php	
			echo form_close();
		?>
	</div>
	
	<div class="row">
		<div class="col-sm-12">
			<div class="box">
				<a href="#" onclick="javascript:printMe()">Print</a>
				<table class="wrl-table btm-mrgn-xs">
					<thead>
						<tr>
							<th style="width:5%;">Sl No</th>
							<th style="width:11%;">Application No.</th>
							<th style="width:9%;">Category.</th>
							<th style="width:18%;">Student Name.</th>
							<th style="width:14%;">Application Status.</th>
							<th style="width:12%;">Payment No.</th>
							<th style="width:12%;">Verification On.</th>
							<th style="width:12%;">Verification By.</th>
						</tr>
					</thead>
					<tbody id="tbl-content">
						
					</tbody>
				</table>
			</div>	<!-- /box -->
			<div class="paginator pull-right btm-mrgn-sm"></div>
			<div class="record-count"></div>
		</div>
	</div>
	
<?php
	$this->load->view('footer');
?>
<script type="text/javascript">
function printMe(){
	var tblContent = $(".wrl-table").html();
    window.print(tblContent);	
}

$(document).on('click','.search-btn',function() {
	$flag = true;
	if($('#pmt_date').val().trim()==''){
		$flag = false;
	}
	if($flag){
		$("#pmt_date_hidden").val($("#pmt_date").val()); 
		var page = 1;
		var params = "date="+$("#pmt_date").val()+"&page="+page;
		$.ajax({
				url: "<?php echo $this->config->base_url();?>reports/loadpayments/"+new Date().getTime(),
				type: "post",
				data: params,
				dataType: "json",
				success: function(response){
					//show message
					printPaymentVerificationDetails(response);
				 }
			});	
	}else{
		jAlert('Please serach by atleast one search criteria.');
	}
});	

$(document).on('click','.page',function() {
	var page = $(this).attr('data-val');
	var params = "date="+$("#pmt_date_hidden").val()+"&page="+page;
	$.ajax({
			url: "<?php echo $this->config->base_url();?>reports/loadpayments/"+new Date().getTime(),
			type: "post",
			data: params,
			dataType: "json",
			success: function(response){
				//show message
				printPaymentVerificationDetails(response);
			 }
		});	
});	


//print pagination links
function printPagination(arr) {
	var s = "";	
	if( (arr.paginate.current_page <= 5)) {
		if(arr.paginate.current_page > 1) {
			s += '<a href="javascript:void(0);" data-val="' + (parseInt(arr.paginate.current_page)-1) + '" class="page">Prev</a>';
		}
		for(var i=1; i<= ((arr.paginate.total_pages > 5) ? 5 : arr.paginate.total_pages); i++) {
			if(arr.paginate.current_page == i) {
				s += '<a href="javascript:void(0);" data-val="' + i + '" class="page active">' + i + '</a>';
			} else {
				s += '<a href="javascript:void(0);" data-val="' + i + '" class="page">' + i + '</a>';
			}	
		}
		if(arr.paginate.current_page < arr.paginate.total_pages) {
			s += '<a href="javascript:void(0);" data-val="' + (parseInt(arr.paginate.current_page)+1) + '" class="page">Next</a>';
		}
	}else if( (arr.paginate.current_page > 5) && (arr.paginate.current_page < arr.paginate.total_pages) ) {
		
		s += '<a href="javascript:void(0);" data-val="' + (parseInt(arr.paginate.current_page)-1) + '" class="page">Prev</a>';
		for(var i=arr.paginate.current_page; i<=parseInt(arr.paginate.current_page) + 4; i++) {
			if(arr.paginate.current_page == i) {
				s += '<a href="javascript:void(0);" data-val="' + i + '" class="page active">' + i + '</a>';
			} else {
				if(i <= arr.paginate.total_pages) {
					s += '<a href="javascript:void(0);" data-val="' + i + '" class="page">' + i + '</a>';
				}	
			}	
		}
		if(arr.paginate.current_page < arr.paginate.total_pages) {
			s += '<a href="javascript:void(0);" data-val="' + (parseInt(arr.paginate.current_page)+1) + '" class="page">Next</a>';
		}	
	}else if( arr.paginate.current_page == arr.paginate.total_pages ) {
		
		s += '<a href="javascript:void(0);" data-val="' + (parseInt(arr.paginate.current_page)-1) + '" class="page">Prev</a>';
		for(var i=arr.paginate.current_page; i<=parseInt(arr.paginate.current_page); i++) {
			if(arr.paginate.current_page == i) {
				s += '<a href="javascript:void(0);" data-val="' + i + '" class="page active">' + i + '</a>';
			} 
		}
			
	}	
	
	$('.paginator').fadeIn(1000);
	if(arr.paginate.total_pages > 1) {
		$('.paginator').html(s);
	}
	
	$('.record-count').html('<strong>Total records:</strong> ' + arr.paginate.total_records);
}

function printPaymentVerificationDetails(data) {
	var arr = data['payments'];
	var page = data['paginate']['current_page'];
	var offset = data['paginate']['offset'];
	
	var s = "";
	console.log(arr);
	if(arr.length > 0) {
			for(var i=0; i<arr.length; i++) {
				s += "<tr>";
				s += "<td style='text-align:center'>" + (offset+ i + 1) + "</td>";
				s += "<td>" + arr[i].appl_code + "</td>";
				s += "<td>" + arr[i].appl_ctgr + "</td>";
				s += "<td>" + arr[i].appl_name + "</td>";
				s += "<td>" + arr[i].appl_status + "</td>";
				s += "<td>" + (arr[i].appl_pmt_code) + "</td>";
				s += "<td>" + (arr[i].appl_verified_on) + "</td>";
				s += "<td>" + (arr[i].appl_verified_by) + "</td>";
				s += "</tr>"
			}
			printPagination(data);
		}else {
		s += '<tr><td colspan="100%"><h3 class="top-mrgn-sm btm-mrgn-sm">No data available</h3></td></tr>';
	}
	$('#tbl-content').html(s);
}


$(document).on('click','.download-btn',function() {
	var params = "appl_code="+$(this).attr('data-val');
	window.open("<?php echo $this->config->base_url();?>admissions/downloadapplform/"+$(this).attr('data-val'));
	
});	
</script>	