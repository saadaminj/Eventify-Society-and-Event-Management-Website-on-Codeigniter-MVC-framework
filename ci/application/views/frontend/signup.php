<div id="fh5co-contact">
		<div class="container">
			<div class="row">
				<div class="col-md-2 animate-box">
				</div>
				<div class="col-md-8 animate-box">
					<div class="price-box">
					<h1>Fill the form to get registered</h1>
                   <?php if(isset($_SESSION['success']))
                   		{ ?>
                   	  <div class="alert alert-success">
                   	  	<?php echo $_SESSION['success'];?></div>

                   	     <?php
                   		}  ?>
                   	
                   				
							<form action="" method="post">
						<div class="row form-group">
							<div class="col-md-6">
								<!-- <label for="fname">First Name</label> -->
								<input type="text" id="fname" class="form-control" 
								name="fname" placeholder="Your firstname">
								<p><?php echo form_error('fname'); ?></p>
							</div>

							<div class="col-md-6">
								<!-- <label for="lname">Last Name</label> -->
								<input type="text" id="lname" class="form-control"
								name="lname" placeholder="Your lastname">
								<p><?php echo form_error('lname'); ?></p>
							</div>
						</div>
						<div class="row form-group">
							<div class="col-md-6">
								<!-- <label for="fname">First Name</label> -->
								<input type="text" id="BATCH" class="form-control" name="BATCH" 
								placeholder="Your Batch(EX:-17K)">
								<p><?php echo form_error('BATCH'); ?></p>
							</div>
							<div class="col-md-6">
								<!-- <label for="fname">First Name</label> -->
								<input type="text" id="SECTION" class="form-control"
								name="SECTION" placeholder="Your Section(EX:-G)">
								<p><?php echo form_error('SECTION'); ?></p>
							</div>
							
						</div>
						<div class="row form-group">
							<div class="col-md-12">
								<!-- <label for="email">Email</label> -->
								<input type="text" id="email" class="form-control"
								name="email" placeholder="Your nu-email address">
								<p><?php echo form_error('email'); ?></p>
							</div>
						</div>
						<div class="row form-group">
							<div class="col-md-12">
								<!-- <label for="email">Email</label> -->
								<input type="text" id="username" class="form-control"
								name="username" placeholder="Enter your username">
								<p><?php echo form_error('username'); ?></p>
							</div>
						</div>
						
						<div class="row form-group">
							<div class="col-md-12">
								<!-- <label for="email">Email</label> -->
							<select name="role" class="form-control">
						    <option value="1">student</option>
						    <option value="2">president</option>
						    <option value="3">faculty</option>
						    
  							</select>
								<p><?php echo form_error('role'); ?></p>
							</div>
						</div>

						<div class="row form-group">
							<div class="col-md-12">
								<!-- <label for="email">Email</label> -->
								<input type="password" id="password" class="form-control"
								name="password" placeholder="Enter your password">
								<p><?php echo form_error('password'); ?></p>
							</div>
						</div>
						
						<div class="row form-group">
							<div class="col-md-12">
								<!-- <label for="email">Email</label> -->
								<input type="password" id="confirm_password" class="form-control" 
								name="confirm_password" placeholder="Re-Enter your passsword">
								<p><?php echo form_error('confirm_password'); ?></p>
							</div>
						</div>
						

						
						<div class="form-group">
						
						
						<input type="submit" name="signup" value="Signup" class="btn btn-primary">
						<a href="<?php echo base_url().'logineventify';?>" class="btn btn-primary">Login</a>
						
							
						</div>

					</form>		
				</div>
			</div>
			</div>
			
		</div>
	</div>
	