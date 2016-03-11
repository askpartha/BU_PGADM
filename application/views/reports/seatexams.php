<div class="page-title">
	<h2>Examination Seating Arrangement</h2>
	<ul class="breadcrumb">
		<li>You are here:</li>
		<li class="active">Report</li>
		<li class="">Examination Seating Arrangement</li>
	</ul>
</div>	<!-- /heading -->

<div class="container-fluid">
	
	<div class="row">
		<div class="col-sm-12">
			<div class="box">
				<?php
					$form = array(
									'class'	=>	'form-horizontal lft-pad-nm',
									'role'	=>	'form',
									'id' => 'addeditform'
								);	
					echo form_open('reports/downloadseatarrangements', $form);
				?>
					<input type="hidden" id="exam_subject_hidden" name="exam_subject_hidden" value=""/>
					<input type="hidden" id="hall_id_hidden" name="hall_id_hidden" value=""/>
					<input type="hidden" id="exam_id_hidden" name="exam_id_hidden" value=""/>
					
					<div class="row">
						<div class="form-group col-sm-3">
							<label>Exam Schedule *</label>
							<?php
								$exam_id_data = 'id="exam_id" class="col-xs-11 col-sm-11"';				
								echo form_dropdown('exam_id', $exams_options, null, $exam_id_data)
							?>
						</div>
						<div class="form-group col-sm-3">
							<label>Subject * </label>
							<?php
								$exam_subject_data = 'id="exam_subject" class="col-xs-11 col-sm-11"';				
								echo form_dropdown('exam_subject', $pgsubject_options, null, $exam_subject_data)
							?>
						</div>
						<div class="form-group col-sm-3">
							<label>Halls *</label>
							<?php
								$hall_id_data = 'id="hall_id" class="col-xs-11 col-sm-11"';				
								echo form_dropdown('hall_id', $halls_options, null, $hall_id_data)
							?>
						</div>
						<input id="downloadtype" name="downloadtype" type="hidden"/>
						<div class="form-group col-sm-4">
							<label>&nbsp;</label>
							<button class="btn btn-info search-btn" type="button">Search</button> &nbsp;
							<button class="btn btn-success download-pdf-btn" type="button">PDF</button> &nbsp;
							<button class="btn btn-success download-excel-btn" type="button">CSV</button> &nbsp;
						</div>
					</div>
				<?php	
					echo form_close();
				?>
			</div>	
		</div>		
	</div>
	
	<div class="row">
		<div class="col-sm-12">
			<div class="box">
				<table class="wrl-table btm-mrgn-xs">
					<caption><lable id="hall_number"></lable></caption>
					<thead>
						<tr>
							<th style="width:5%;">Sl No</th>
							<th style="width:4%;">Photo.</th>
							<th style="width:15%;">Student Name.</th>
							<th style="width:9%;">Appl. No.</th>
							<th style="width:11%;">Subject.</th>
							<th style="width:15%;">Building Name.</th>
							<th style="width:10%;">Hall No.</th>
							<th style="width:9%;">Roll No.</th>
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
	
</div>

<?php
	$this->load->view('footer');
?>		

<script type="text/javascript">
$("#exam_id").on('change',function() {
	populatesubjects();
	populatehalls();
});

function populatehalls(flag){
	var params = "exam_id="+$("#exam_id").val();
		$.ajax({
			url: "<?php echo $this->config->base_url();?>admissions/gethallsforexam",
			type: "post",
			data: params,
			dataType: "json",
			success: function(response){
				halls_data = response;
				console.log(response);
				$("#hall_id").html('');
				var subjs = "<option value='EMPTY'></option>";
				for(var i=0; i<halls_data.length; i++){
					subjs += '<option value="'+halls_data[i]['hall_id']+'">'+halls_data[i]['building_name']+'  <==>  '+halls_data[i]['hall_number']+'</option>';
				}
				$("#hall_id").html(subjs);
				if(flag >=0 ){
					$('#hall_id').val(examinations_data[$flag].hall_id);
				}
			 }
		});
}

function populatesubjects(flag){
	var params = "exam_id="+$("#exam_id").val();
		$.ajax({
			url: "<?php echo $this->config->base_url();?>admissions/getsubjectsforexam",
			type: "post",
			data: params,
			dataType: "json",
			success: function(response){
				subejcts_data = response;
				console.log(response);
				$("#exam_subject").html('');
				var subjs = "<option value='EMPTY'></option>";
				for(var i=0; i<subejcts_data.length; i++){
					subjs += '<option value="'+subejcts_data[i]['subj_code']+'">'+subejcts_data[i]['subj_name']+'</option>';
				}
				$("#exam_subject").html(subjs);
				if(flag >=0 ){
					$('#exam_subject').val(examinations_data[$flag].subj_code);
				}
			 }
		});
}


$(document).on('click','.search-btn',function() {
	$flag = true;
	var exam_subject_hidden = $('#exam_subject_hidden').val().trim();
	var hall_id_hidden = $('#hall_id_hidden').val().trim();
	var exam_id_hidden = $('#exam_id_hidden').val().trim();
	
	$("#hall_number").html('');
	if($flag){
		var page = 1;
		
		$("#exam_subject_hidden").val($("#exam_subject").val());
		$("#hall_id_hidden").val($("#hall_id").val());
		$("#exam_id_hidden").val($("#exam_id").val());
		
		var params = "exam_id="+$("#exam_id_hidden").val()+"&exam_subject="+$("#exam_subject_hidden").val()+"&hall_id="+$('#hall_id_hidden').val().trim()+"&page="+page;

		$.ajax({
				url: "<?php echo $this->config->base_url();?>reports/loadseatarrangements/"+new Date().getTime(),
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

$(document).on('click','.download-pdf-btn',function() {
	var flag = true;
	var flag1 = true;
	var flag2 = true;
	
	if($('#exam_subject').val() == null || $('#exam_subject').val() == 'EMPTY' || $('#exam_subject').val() == ""){
		flag1 = false;
	}
	if($('#hall_id').val() == null || $('#hall_id').val() == 'EMPTY' || $('#hall_id').val() == ""){
		flag2 = false;
	}
	if(flag1 == false && flag2==false){
		flag = false;
	}
	
	if(flag){
		$('#downloadtype').val('pdf');
		$('#addeditform').submit();
	}else{
		jAlert('Please serach by atleast one search criteria.');
	}
});	

$(document).on('click','.download-excel-btn',function() {
	var flag = true;
	var flag1 = true;
	var flag2 = true;
	
	if($('#exam_subject').val() == null || $('#exam_subject').val() == 'EMPTY' || $('#exam_subject').val() == ""){
		flag1 = false;
	}
	if($('#hall_id').val() == null || $('#hall_id').val() == 'EMPTY' || $('#hall_id').val() == ""){
		flag2 = false;
	}
	if(flag1 == false && flag2==false){
		flag = false;
	}
	
	if(flag){
		$('#downloadtype').val('excel');
		$('#addeditform').submit();
	}else{
		jAlert('Please serach by either subject or hall.');
	}
});	


$(document).on('click','.page',function() {
	var page = $(this).attr('data-val');
		
		var params = "exam_subject="+$("#exam_subject_hidden").val()+"&exam_id="+$("#exam_id_hidden").val()+"&hall_id="+$("#hall_id_hidden").val()+"&page="+page;

		$.ajax({
			url: "<?php echo $this->config->base_url();?>reports/loadseatarrangements/"+new Date().getTime(),
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
	//console.log(arr);
	if(arr.length > 0) {
			for(var i=0; i<arr.length; i++) {
				s += "<tr>";
				s += "<td style='text-align:center'>" + (offset+ i + 1) + "</td>";
				s += "<td><img src='" + arr[i].pg_appl_profile_pic + "' width='40px' height='35px'/></td>";
				s += "<td>" + arr[i].pg_appl_name + "</td>";
				s += "<td>" + arr[i].pg_appl_code + "</td>";
				s += "<td>" + arr[i].pg_appl_subj_name + "</td>";
				s += "<td>" + (arr[i].building_name) + "</td>";
				s += "<td>" + (arr[i].hall_number) + "</td>";
				s += "<td>" + (arr[i].roll_no) + "</td>";
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

function onload(){
	$("#exam_subject").val('EMPTY');
	$("#hall_id").val('EMPTY');
	$("#exam_id").val('EMPTY');
}
onload();
	
</script>