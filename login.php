<?php include('header.php') ?>

<!---->
<!---->
<!--	<div class="header">-->
<!--		<h2>Login</h2>-->
<!--	</div>-->
<!---->
<!--	<form method="post" action="login.php">-->
<!---->
<!--		--><?php //include('errors.php'); ?>
<!---->
<!--		<div class="input-group">-->
<!--			<label>Username</label>-->
<!--			<input type="text" name="username" >-->
<!--		</div>-->
<!--		<div class="input-group">-->
<!--			<label>Password</label>-->
<!--			<input type="password" name="password">-->
<!--		</div>-->
<!--		<div class="input-group">-->
<!--			<button type="submit" class="btn" name="login_user">Login</button>-->
<!--		</div>-->
<!--		<p>-->
<!--			Not yet a member? <a href="register.php">Sign up</a>-->
<!--		</p>-->
<!--	</form>-->

<div id="login">
    <h3 class="text-center text-grey pt-5">Login</h3>
    <div class="container">
        <div id="login-row" class="row justify-content-center align-items-center">
            <div id="login-column" class="col-md-6">
                <div id="login-box" class="col-md-12">
                    <form id="login-form" class="form" method="post" action="login.php">
                        <?php include('errors.php'); ?>
                        <h3 class="text-center text-info">Welcome to GWTutor System</h3>
                        <div class="form-group">
                            <label for="username" class="text-info">Email:</label><br>
                            <input type="text" name="username" id="username" class="form-control" required>
                        </div>
                        <div class="form-group">
                            <label for="password" class="text-info">Password:</label><br>
                            <input type="password" name="password" id="password" class="form-control" required>
                        </div>
                        <div class="form-group">
                            <input type="submit" name="login_user" class="btn btn-info btn-md" value="Login">
                        </div>
                        <div id="register-link" class="text-right">
                            <a href="register.php" class="text-info">Sign up as a member</a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>


</body>
</html>
