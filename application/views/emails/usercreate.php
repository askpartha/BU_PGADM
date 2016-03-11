<h3>Hi! <?php echo $user['user']['user_fullname'];?></h3>
<p>Your account is created. Please get the details below.</p>

<h4>Username: <?php echo $user['user']['user_username'];?></h4>
<h4>Password: <?php echo $user['user']['user_password'];?></h4>
<h4>Role: <?php echo getUserRole($user['user']['user_role']);?></h4>

<p>Please login with the supplied credential and change your password for better security.</p>

Thanks,<br/>
Hoteler Team