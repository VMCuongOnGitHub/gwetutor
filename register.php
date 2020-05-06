<?php include('header.php') ?>

<!--	<div class="header">-->
<!--		<h2>Register</h2>-->
<!--	</div>-->
<!---->
<!--	<form method="post" action="register.php">-->
<!---->
<!--		--><?php //include('errors.php'); ?>
<!---->
<!--		<div class="input-group">-->
<!--			<label>Username</label>-->
<!--			<input type="text" name="username" value="--><?php //echo $username; ?><!--">-->
<!--		</div>-->
<!--		<div class="input-group">-->
<!--			<label>Email</label>-->
<!--			<input type="email" name="email" value="--><?php //echo $email; ?><!--">-->
<!--		</div>-->
<!--		<div class="input-group">-->
<!--			<label>Password</label>-->
<!--			<input type="password" name="password_1">-->
<!--		</div>-->
<!--		<div class="input-group">-->
<!--			<label>Confirm password</label>-->
<!--			<input type="password" name="password_2">-->
<!--		</div>-->
<!--		<div class="input-group">-->
<!--			<button type="submit" class="btn" name="reg_user">Register</button>-->
<!--		</div>-->
<!--		<p>-->
<!--			Already a member? <a href="login.php">Sign in</a>-->
<!--		</p>-->
<!--	</form>-->

<div id="login">
    <h3 class="text-center text-grey pt-5">Register</h3>
    <div class="container">
        <div id="login-row" class="row justify-content-center align-items-center">
            <div id="login-column" class="col-md-6">
                <div id="login-box" class="col-md-12">
                    <form id="login-form" class="form" method="post" action="register.php">
                        <?php include('errors.php'); ?>
                        <h3 class="text-center text-info">Welcome to GWTutor System</h3>
                        <div class="form-group">
                            <label for="username" class="text-info">Username:</label><br>
                            <input type="text" name="username" value="<?php echo $username; ?>" class="form-control" required>
                        </div>
                        <div class="form-group">
                            <label for="email" class="text-info">Email:</label><br>
                            <input type="email" name="email" value="<?php echo $email; ?>" class="form-control" required>
                        </div>
                        <div class="form-group">
                            <label for="password_1" class="text-info">Password:</label><br>
                            <input type="password" name="password_1" class="form-control" required>
                        </div>
                        <div class="form-group">
                            <label for="password_2" class="text-info">Re-enter Password:</label><br>
                            <input type="password" name="password_2" class="form-control" required>
                        </div>
                        <div class="form-group">
                            <input type="submit" name="reg_user" class="btn btn-info btn-md" value="Register">
                        </div>
                        <div id="register-link" class="text-right">
                            <a href="login.php" class="text-info">Sign in</a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<?php include('footer.php') ?>
