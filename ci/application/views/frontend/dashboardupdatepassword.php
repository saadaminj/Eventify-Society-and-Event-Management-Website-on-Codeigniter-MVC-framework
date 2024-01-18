n<div id="fh5co-contact" style="text-align: center;" >
		<div class="container">
			<div class="row">
				
				<div class="col-md-12 animate-box">
					<div class="price-box">
					<h1 >UPDATE PASSWORD</h1>

					<?php if(isset($_SESSION['success']))
                   		{ ?>
                   	  <div class="alert alert-success">
                   	  	<?php echo $_SESSION['success'];?></div>

                   	     <?php
                   		}  ?>
                   	
                   	<br><br><br>
                   	<form action="<?php echo base_url().'updatepassword' ;?>" method="post">
						<br>
						<div class="row form-group">
							<div class="col-md-12">
								<!-- <label for="email">Email</label> -->
								<input type="password" id="oldpassword" name="oldpassword"  class="form-control" placeholder="Enter your old password">
								<p><?php echo form_error('oldpassword'); ?></p>
							</div>
						</div>
						<div class="row form-group">
							<div class="col-md-12">
								<!-- <label for="email">Email</label> -->
								<input type="password" id="newpassword" name="newpassword" class="form-control" placeholder="Enter your new password">
								<p><?php echo form_error('newpassword'); ?></p>
							</div>
						</div>
						<div class="row form-group">
							<div class="col-md-12">
								<!-- <label for="email">Email</label> -->
								<input type="password" id="renternewpassword" name="reenternewpassword" class="form-control" placeholder="Re-enter your new password">
								<p><?php echo form_error('reenternewpassword'); ?></p>
							</div>
						</div>

						
						<div class="form-group">
						<input type="submit" name='dashboard' value="submit" class="btn btn-primary" >
						</div>

					</form>	
				</div>
			</div>
			</div>
			
		</div>
	</div>
	