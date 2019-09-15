<?php require APPROOT . '/views/inc/header.php'; ?>

<div class="row">
	<div class="col-md-8 col-lg-6 mx-auto">
		<div class="card card-body bg-light mt-5">

			<?php flash_message() ?>

			<h2>Login</h2>
			<p>Please fill the form</p>
			
			<form action="/users/login" method="post">	
				<div class="form-group">
					<label for="email">Email: <sup>*</sup></label>
					<input type="text" name="email" class="form-control form-control-lg <?php echo (!empty($data['email_err'])) ? 'is-invalid' : ''; ?>" value="<?php echo $data['email']; ?>">
					<span class="invalid-feedback"><?php echo $data['email_err'];?></span>
				</div>

				<div class="form-group">
					<label for="password">Password: <sup>*</sup></label>
					<input type="password" name="password" class="form-control form-control-lg <?php echo (!empty($data['password_err'])) ? 'is-invalid' : ''; ?>" value="<?php echo $data['password']; ?>">
					<span class="invalid-feedback"><?php echo $data['password_err'];?></span>
				</div>

				<div class="row">
					<div class="col-md-6 offset-md-3 text-center">
						<input type="submit" value="Login" class="form-control btn-success btn-block">
					</div>
				</div>
				<div class="row mt-2">
					<div class="col-md-6 text-center">
						<a href="/users/register" class="form-control btn-light btn-block">No account? Register</a>
					</div>
					<div class="col-md-6 text-center">
						<a href="/users/passwordLink" class="form-control btn-light btn-block">Forgotten Password?</a>
					</div>
				</div>
	
			</form>
		</div>
	</div>
</div>

<?php require APPROOT . '/views/inc/footer.php'; ?>