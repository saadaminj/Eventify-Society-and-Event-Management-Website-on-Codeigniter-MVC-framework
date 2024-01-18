<div id="fh5co-contact">
		<div class="container">
			<div class="row">
				<div class="col-md-6 animate-box">
					<h1> Register Yourself</h1>
					<form action="" method="post">
                        <div class="row form-group">
                            <button class="btn" onclick="return false";>Register As :</button>
                            <div class="col-md-12">
                                <input type="radio" name="register_as" value="Individual"> Individual<br>
                                <input type="radio" name="register_as" value="Group"> Group<br>
                                <p><?php echo form_error('register_as'); ?></p>
                            </div>
						</div>
                        <div class="form-group">
							<input type="submit" name="proceed"  value="Proceed" class="btn btn-primary">
						</div>

					</form>		
				</div>
			</div>
			
		</div>
	</div>
	