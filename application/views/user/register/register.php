<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>
<div class="container">
	<div class="row">
		<?php if (validation_errors()) : ?>
			<div class="col-md-12">
				<div class="alert alert-danger" role="alert">
					<?= validation_errors() ?>
				</div>
			</div>
		<?php endif; ?>
		<?php if (isset($error)) : ?>
			<div class="col-md-12">
				<div class="alert alert-danger" role="alert">
					<?= $error ?>
				</div>
			</div>
		<?php endif; ?>

		<?php $user = "";
		 if (isset($username)) : $user=  $username; endif; ?>

		
		<div class="col-md-12">
			<div class="page-header">
				<h1>Register</h1>
			</div>
			<?php  echo form_open(base_url()."register"); ?>
				<div class="form-group">
					<label for="first_name">First Name</label>
					<input type="text" class="form-control" id="first_name" name="first_name" placeholder="Enter a First Name">
					<p class="help-block">Enter Your First Name</p>
				</div>
				<div class="form-group">
					<label for="last_name">Last Name</label>
					<input type="text" class="form-control" id="last_name" name="last_name" placeholder="Enter a last Name">
					<p class="help-block">Enter Your Last Name</p>
				</div>
				<div class="form-group">
					<label for="email">Email</label>
					<input type="email" readonly class="form-control" id="email" name="email" placeholder="Enter your email" value="<?= $user ?>">
					<p class="help-block">A valid email address</p>
				</div>
				<div class="form-group">
					<label for="password">Password</label>
					<input type="password" class="form-control" id="password" name="password" placeholder="Enter a password">
					<p class="help-block">At least 6 characters</p>
				</div>
				<div class="form-group">
					<label for="password_confirm">Confirm password</label>
					<input type="password" class="form-control" id="password_confirm" name="password_confirm" placeholder="Confirm your password">
					<p class="help-block">Must match your password</p>
				</div>
				<div class="form-group">
					<input type="submit" class="btn btn-default" value="Register">
				</div>
			</form>
		</div>
	</div><!-- .row -->
</div><!-- .container -->