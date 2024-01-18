<div id="fh5co-contact">
		<div class="container">
			<div class="row">
				<div class="col-md-2 animate-box">
				</div>
				<div class="col-md-8 animate-box">
					<div class="price-box">
					<h1>Kindly Fill Your Credentials</h1>
							<form action="<?php echo base_url().'logineventify'?>" method='post'>
						<br>
						<div class="row form-group">
							<div class="col-md-12">
								<!-- <label for="email">Email</label> -->
								

							<?php print_r($error);?>

								<input type="email" id="email" name="email"  class="form-control" placeholder="Your nu-email address">
							</div>
						</div>
						<div class="row form-group">
							<div class="col-md-12">
								<!-- <label for="email">Email</label> -->
								<input type="password" id="password" name="password" class="form-control" placeholder="Your password">
							</div>
						</div>
						

						
						<div class="form-group">
						
						
						<input type="submit" name='login1' value="submit" class="btn btn-primary" >
						
							
						</div>

					</form>		
				</div>
			</div>
			</div>
			
		</div>
	</div>
	