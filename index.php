<?php 

	include 'templates/header.html';
	require 'script.php';

	# Initialise session to persist data between different pages 
	session_start();

	# Set the global user directory variable
	if ((!isset($_SESSION['users'])) || (isset($_POST['reset_users']))) {
		$_SESSION['users'] = load_users();
	}

	# Initialise filtered array of users with original array of users
	$users_filtered = $_SESSION['users'];

	# Repopulate filtered user array when a search term is submitted
	if(($_SERVER['REQUEST_METHOD'] == 'POST') && !empty($_POST['search_term'])) {
		$users_filtered = array();
		foreach($_SESSION['users'] as $user) {
			# Find partial match (case-insensitive)
			if(stripos($user['name'], $_POST['search_term']) !== false) {
				# Add matched user to array
				$users_filtered[] = $user;
			}
		}
	}

?>
<body>
	
	<!-- Page title and nav bar -->
	<h1>User Directory</h1>
	<p style='text-align:center'>This page presents a mock list of users from the <a href="https:#jsonplaceholder.typicode.com/users">{JSON} Placeholder</a> website.</p>
	<br>
	<nav>
		<ul>
			<li><a href="index.php">View directory</a></li>
			<li><a href="form.php">Add new user</a></li>
		</ul>
	</nav>
	<br>	

	<!-- Create search bar -->
	<div class="container">
		<h3>Search</h3>
		<form action="" method="POST" class="form-inline">
			<div class="form-group">
				<input type="text" name="search_term" placeholder="Search by name" class="form-control">
			</div>
			<button type="submit" name="submit_search" class="btn btn-primary">Search</button>
			<button type="submit" name="reset_users" class="btn btn-secondary">Reset directory</button>
		</form>
		<br>
	</div>

	<!-- Create and populate user directory table -->
	<div class="container">
		<table class="table">
			<!-- Table headers -->
			<thread>
				<th>Full name</th>
				<th>E-mail</th>
			</thread>
			<!-- The html table is populated by elements of $user_filtered array -->
			<tr>
				<!-- Populate individual table cells with users' details -->
				<?php if (count($users_filtered) != 0){
					foreach($users_filtered as $user){ ?>
						<tr>
							<!-- Table cell: Full name -->
							<td> <?php echo $user['name'] ?> </td>
							<!-- Table cell: E-mail -->
							<td>
								<a target="_blank" href="mailto:<?php echo $user['email'] ?>">  
									<?php echo $user['email'] ?>
								</a> 
							</td>
						</tr>
					<?php
					}
				} 
				?>			
			</tr>
		</table>
	</div>
</body>
</html>