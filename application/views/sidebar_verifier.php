
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
				<li><?php echo anchor('users/changepass', 'Change Password', 'title="Change Password"');?></li>
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
				<li><?php echo anchor('admissions/searchapplication/SEARCH', 'Search Applications', 'title="SEARCH APPLICATION"');?></li>
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
			</ul>
		</div><!-- /panel-body -->
	</div><!-- /panel-collapse -->
</div><!-- /panel panel-default -->															