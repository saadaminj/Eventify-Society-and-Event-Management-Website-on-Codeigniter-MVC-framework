<div id="fh5co-contact">
		<div class="container">
			<div class="row">
				<div class="col-md-6 animate-box">
					<h1> Register Yourself</h1>
					<form action="" method="post">
						<div class="row form-group">
							<div class="col-md-6">
								<!-- <label for="fname">First Name</label> -->
								<input type="text" name="fname" id="fname" class="form-control" placeholder="Your firstname" value="<?php echo set_value('fname')?>">
								<p><?php echo form_error('fname'); ?></p>
							</div>
							<div class="col-md-6">
								<!-- <label for="lname">Last Name</label> -->
								<input type="text" id="lname" name="lname" class="form-control" placeholder="Your lastname" value="<?php echo set_value('lname')?>">
								<p><?php echo form_error('lname'); ?></p>
							</div>
						</div>

						<div class="row form-group">
							<div class="col-md-12">
								<!-- <label for="subject">Subject</label> -->
								<input type="tel" id="phone_number" name="phone_number" class="form-control" placeholder="Your Phone Number (+923xxxxxxxxx)" pattern="+[9][2][3][0-9]{9}" value="<?php echo set_value('phone_number')?>">
								<p><?php echo form_error('phone_number'); ?></p>
							</div>
						</div>

						<div class="row form-group">
							<div class="col-md-12">
								<!-- <label for="email">Email</label> -->
								<input type="text" id="email" name="email" class="form-control" placeholder="Your email address" value="<?php echo set_value('email')?>">
								<p><?php echo form_error('email'); ?></p>
							</div>
						</div>
                        <div class="form-group">
							<input type="submit" name="register"  value="Register" class="btn btn-primary">
						</div>

					</form>		
				</div>a
			</div>
			
		</div>
	</div>
	