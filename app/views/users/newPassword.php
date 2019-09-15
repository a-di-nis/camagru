<?php require APPROOT . '/views/inc/header.php'; ?>

<div class="row">
	<div class="col-md-6 mx-auto">
		<div class="card card-body bg-light mt-5">
			<h2>Reset password</h2>
			<p>Please fill the form</p>

			
			<form action="/users/newPassword/<?php echo $data['token_two']; ?>" method="post">	
				<div class="form-group">
					<label for="password">New Password: <sup>*</sup></label>
					<input type="password" name="password" class="form-control form-control-lg <?php echo (!empty($data['password_err'])) ? 'is-invalid' : ''; ?>" value="">
					<span class="invalid-feedback"><?php echo $data['password_err'];?></span>
				</div>
				<div class="row">
					<div class="col">
						<input type="submit" value="Change Password" class="btn btn-success btn-block">
					</div>
				</div>
			</form>
		</div>
	</div>
</div>

<?php require APPROOT . '/views/inc/footer.php'; ?>