<?php
	session_start();

	// variable declaration
	$username = "";
	$email    = "";
	$errors = array();
	$_SESSION['success'] = "";

	// connect to database
	$db = mysqli_connect('localhost', 'root', '', 'etutor');

	// REGISTER USER
	if (isset($_POST['reg_user'])) {
		// receive all input values from the form
		$username = mysqli_real_escape_string($db, $_POST['username']);
		$email = mysqli_real_escape_string($db, $_POST['email']);
		$password_1 = mysqli_real_escape_string($db, $_POST['password_1']);
		$password_2 = mysqli_real_escape_string($db, $_POST['password_2']);

		// form validation: ensure that the form is correctly filled
		if (empty($username)) { array_push($errors, "Username is required"); }
		if (empty($email)) { array_push($errors, "Email is required"); }
		if (empty($password_1)) { array_push($errors, "Password is required"); }

		if ($password_1 != $password_2) {
			array_push($errors, "The two passwords do not match");
		}

		// register user if there are no errors in the form
		if (count($errors) == 0) {
			$password = md5($password_1);//encrypt the password before saving in the database
			$query = "INSERT INTO users (username, email, password)
					  VALUES('$username', '$email', '$password')";
			mysqli_query($db, $query);

			$_SESSION['username'] = $username;
			$_SESSION['success'] = "You are now Registed, please leave a message for GW Staff for assigning your role";
			header('location: contactStaff.php');
		}

	}

	// ...

	// LOGIN USER
	if (isset($_POST['login_user'])) {
		$username = mysqli_real_escape_string($db, $_POST['username']);
		$password = mysqli_real_escape_string($db, $_POST['password']);

		if (empty($username)) {
			array_push($errors, "Username is required");
		}
		if (empty($password)) {
			array_push($errors, "Password is required");
		}

		if (count($errors) == 0) {
			//$password = md5($password);
			$query = "SELECT * FROM users WHERE username='$username' AND password='$password'";

			$results = mysqli_query($db, $query);
			$row = mysqli_fetch_assoc($results);

            if ($results == true) {
                $_SESSION['username'] = $username;
                $_SESSION['user_role'] = $row['user_role'];
                $_SESSION['success'] = "You are now logged in";

                if ($_SESSION['user_role'] == 'student') {
                    header('location: student.php');
                }elseif ($_SESSION['user_role'] == 'tutor') {
                    header('location: tutor.php');
                }elseif ($_SESSION['user_role'] == 'staff'){
					header('location: staffDashboard.php');
                }else{
					header('location: contactStaff.php');
                }
			}else {
				array_push($errors, "Wrong username/password combination");
			}
		}
	}

?>
