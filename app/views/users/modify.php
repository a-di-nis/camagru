<?php require APPROOT . '/views/inc/header.php'; ?>

<div class="row">
	<div class="col-md-8 col-lg-6 mx-auto">
		<div class="card card-body bg-light mt-5">
			<h2>Modify Personal Info</h2>


			<?php flash_message() ?>
			<form action="/users/modify" method="post">
				<div class="form-group">
					<label for="old_password">Old Password: <sup>*</sup></label>
					<input type="password" name="old_password" class="form-control form-control-lg <?php echo (!empty($data['old_password_err'])) ? 'is-invalid' : ''; ?>" value="">
					<span class="invalid-feedback"><?php echo $data['old_password_err'];?></span>
				</div>

				<div class="form-group">
					<label for="username">New Username: <sup>*</sup></label>
					<input type="text" name="username" class="form-control form-control-lg <?php echo (!empty($data['new_username_err'])) ? 'is-invalid' : ''; ?>" value="">
					<span class="invalid-feedback"><?php echo $data['new_username_err'];?></span>
				</div>

				<div class="form-group">
					<label for="email">New Email: <sup>*</sup></label>
					<input type="email" name="email" class="form-control form-control-lg <?php echo (!empty($data['new_email_err'])) ? 'is-invalid' : ''; ?>" value="">
					<span class="invalid-feedback"><?php echo $data['new_email_err'];?></span>
				</div>

				<div class="form-group">
					<label for="password">New Password: <sup>*</sup></label>
					<input type="password" name="password" class="form-control form-control-lg <?php echo (!empty($data['new_password_err'])) ? 'is-invalid' : ''; ?>" value="">
					<span class="invalid-feedback"><?php echo $data['new_password_err'];?></span>
				</div>

				<div class="form-group">
					<input class="form-check-input" type="checkbox" value="" name="notifications" id="notifications" <?php if ($data['notifications']) { echo "checked"; } ?>>
					<label class="form-check-label" for="notifications">
						Do you want to be notified by email?
					</label>
				</div>

				<div class="form-group">
					<input type="submit" value="Modify" class="form-control btn-success w-100">
				</div>
			</form>


		</div>
	</div>
</div>


<?php require APPROOT . '/views/inc/footer.php'; ?>