
<div class="panel panel-default">
    <div class="panel-heading">
      <h4 class="panel-title">
        <a data-toggle="collapse" data-parent="#accordion" href="#collapseOne">
        	<i class="fa fa-users"></i> User Management
        </a>
      </h4>
    </div>
    <div id="collapseOne" class="panel-collapse collapse">
	    <div class="panel-body">
			<ul class="nav nav-list">
				<li><?php echo anchor('users/musers', 'Users', 'title="Users"');?></li>
				<li><?php echo anchor('users/changepass', 'Change Password', 'title="Change Password"');?></li>
				<li><?php echo anchor('users/resetpasswd', 'Reset: User Password', 'title="Reset User Password"');?></li>
				<li><?php echo anchor('students/resetpasswd', 'Reset: Student Password', 'title="Reset Student Password"');?></li>
			</ul>
		</div><!-- /panel-body -->
	</div><!-- /panel-collapse -->
</div><!-- /panel panel-default -->

<div class="panel panel-default">
	<div class="panel-heading">
  		<h4 class="panel-title">
	        <a data-toggle="collapse" data-parent="#accordion" href="#collapseTwo">
	        	<i class="fa fa-graduation-cap"></i> Admissions
	        </a>
  		</h4>
	</div>
	<div id="collapseTwo" class="panel-collapse collapse">
    	<div class="panel-body">
			<ul class="nav nav-list">
				<li><?php echo anchor('admissions/schedules', 'Date Schedules', 'title="Schedules"');?></li>
				<li><?php echo anchor('admissions/notices', 'Notices', 'title="Notices"');?></li>
				<li><?php echo anchor('admissions/searchapplication/SEARCH', 'Search Applications', 'title="SEARCH APPLICATION"');?></li>
				<li><?php echo anchor('admissions/searchapplication/CANCEL', 'Cancel Applications', 'title="CANCEL APPLICATION"');?></li>
				<li><?php echo anchor('admissions/searchapplication/CONVERT', 'Convert Applications', 'title="CONVERT APPLICATION"');?></li>
				<li><?php echo anchor('admissions/searchapplication/PAYMENT', 'Update Payments', 'title="UPDATE PAYMENTS"');?></li>
				<li><?php echo anchor('admissions/searchapplication/DUPLICATE', 'Duplicate Records', 'title="DUPLICATE RECORDS"');?></li>
				<li><?php echo anchor('admissions/examinations', 'Exam Schedule', 'title="EXAM-SCHEDULING"');?></li>
			</ul>
		</div><!-- /panel-body -->
	</div><!-- /panel-collapse -->
</div><!-- /panel panel-default -->

<div class="panel panel-default">
	<div class="panel-heading">
  		<h4 class="panel-title">
	        <a data-toggle="collapse" data-parent="#accordion" href="#collapseFour">
	        	<i class="fa fa-envelope"></i> Notifications
	        </a>
  		</h4>
	</div>
	<div id="collapseFour" class="panel-collapse collapse">
    	<div class="panel-body">
			<ul class="nav nav-list">
				<li><?php echo anchor('notifications/usernotifications', 'User Notifications', 'title="User Notifications"');?></li>
				<li><?php echo anchor('notifications/groupnotifications', 'Group Notifications', 'title="Group Notifications"');?></li>
				<li><?php echo anchor('notifications/admissionnotifications', 'Admission Notifications', 'title="Admission Notifications"');?></li>
			</ul>
		</div><!-- /panel-body -->
	</div><!-- /panel-collapse -->
</div><!-- /panel panel-default -->	


<div class="panel panel-default">
	<div class="panel-heading">
  		<h4 class="panel-title">
	        <a data-toggle="collapse" data-parent="#accordion" href="#collapseSix">
	        	<i class="fa fa-bar-chart-o"></i> Reports
	        </a>
  		</h4>
	</div>
	<div id="collapseSix" class="panel-collapse collapse">
    	<div class="panel-body">
			<ul class="nav nav-list">
				<li><?php echo anchor('reports/payments', 'Payment Confirmations', 'title="PAYMENT CONFIRMATION"');?></li>
				<li><?php echo anchor('reports/seatexams', 'Seat Arrangements', 'title="SEATING ARRANGEMENTS"');?></li>
				<li><?php echo anchor('reports/meritlists', 'Rank List', 'title="RANK LIST"');?></li>
			</ul>
		</div><!-- /panel-body -->
	</div><!-- /panel-collapse -->
</div><!-- /panel panel-default -->															