<?php include 

	'templates/header.html';
	require 'script.php';

	# Initialise session to persist data between different pages 
	session_start();

	# Set the global user directory variable
	if (!isset($_SESSION['users'])) {
		$_SESSION['users'] = load_users();
	}

	# Clear the user name and email variables
	# Empty variables allows text fields to populated with empty strings after submit and clear
	if(isset($_POST['clear_new_user'])){
		$user_name = "";
		$user_email = "";
	}

	# Store the form values and add data as new user to user directory
	$errors = []; # Initalise empty array of errors
	if(isset($_POST['submit_new_user'])){
		$user_name = $_POST['name'];
		$user_email = $_POST['email'];

		# Boolean flag for valid input: default is true
		$valid = true;

		# Validation: name
		# Evaluate if user name contains at least two words separated by space
		if (!preg_match('/^[^ ]+ [^ ]+/', $user_name)) {
			$errors[] = 'Enter your name and surname separated by a space.';
			$valid = false;
		} 
		# Validation: e-mail
		# Use filter_var() to evaluate e-mail address
		if (!filter_var($user_email, FILTER_VALIDATE_EMAIL)) {
			$errors[] = 'Enter a valid e-mail address.';
			$valid = false;
		}
		
		# Store new user into user directory
		if ($valid){
			$new_user = array(
				'name' => $user_name,
				'email' => $user_email
			);
			create_user($new_user);

			$success = "Created new user! Visit View directory to see updated list of users.";
			$user_name = $user_email = ""; # clear vars and the form's fields
		}
	}

?>

<body>
	
	<!-- Page title and nav bar -->
	<h1>User Directory</h1>
	<nav>
		<ul>
			<li><a href="index.php">View directory</a></li>
			<li><a href="form.php">Add new user</a></li>
		</ul>
	</nav>

	<!-- New user input form (container ensures form does not span entire width of page) -->
	<div class="container">
		<!-- Class "card" places form in boxed border -->
		<div class="card">
			<!-- POST method: securely send the data in request body (GET is less secure since data is in URL as query string) -->
			<form action="" method="POST">
				<h3>Add a new user</h3>
				
				<div class="form-group">
					<label>Name and surname</label>
					<input type="text" name="name" value="<?php echo @$user_name; ?>">
				</div>
				
				<div class="form-group">
					<label>E-mail address</label>
					<input type="email" name="email" value="<?php echo @$user_email; ?>">
				</div>

				<!-- Submit and clear buttons -->
				<input type="submit" name="submit_new_user" value="Submit" class="btn btn-primary">
				<input type="submit" name="clear_new_user" value="Clear" class="btn btn-secondary">

				<!-- User feedback upon form submission: displays either success or error (determined by defined variable) -->
				<p class="error"><?php 
					foreach($errors as $error){
    					echo $error . "<br>";
					} ?>
				</p>
				<p class="success"><?php echo @$success ?></p>
			</form>
		</div>
	</div>
	
</body>
</html>