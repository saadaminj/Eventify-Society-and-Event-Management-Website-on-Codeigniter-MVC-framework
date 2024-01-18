<div id="fh5co-contact">
		<div class="container">
			<div class="row">
				<div class="col-md-5 col-md-push-1 animate-box">
					
					<div class="fh5co-contact-info">
						<h3>Contact Information</h3>
						<ul>
							<li class="address"><iframe style="width:300px;height:300px;" src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d231670.52891243875!2d67.00050625277642!3d24.8689034091605!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x3eb3316c5276e35b%3A0x823a6a0100195ffd!2sFAST%20University%20Karachi%20Campus!5e0!3m2!1sen!2s!4v1574981050342!5m2!1sen!2s" width="600" height="450" frameborder="0" style="border:0;" allowfullscreen=""></iframe></br></li>
							<li class="phone"><a href="tel://1234567920">XXX</a></li>
							<li class="email"><a href="mailto:eventify@gmail.com">eventify@gmail.com</a></li>
							
						</ul>
					</div>

				</div>
				<div class="col-md-6 animate-box">
					<h3>Get In Touch</h3>
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
								<!-- <label for="email">Email</label> -->
								<input type="text" id="email" name="email" class="form-control" placeholder="Your email address" value="<?php echo set_value('email')?>">
								<p><?php echo form_error('email'); ?></p>
							</div>
						</div>

						<div class="row form-group">
							<div class="col-md-12">
								<!-- <label for="subject">Subject</label> -->
								<input type="text" id="subject" name="subject" spellcheck="true" class="form-control" placeholder="Your subject of this message" value="<?php echo set_value('subject')?>">
								<p><?php echo form_error('subject'); ?></p>
							</div>
						</div>

						<div class="row form-group">
							<div class="col-md-12">
								<!-- <label for="message">Message</label> -->
								<textarea name="message" id="message" cols="30" spellcheck="true" rows="10" class="form-control" placeholder="Say something about us" value="<?php echo set_value('message')?>"></textarea>
								<p><?php echo form_error('message'); ?></p>
							</div>
						</div>
						<div class="form-group">
							<input type="submit" name="send"  value="Send Message" class="btn btn-primary">
						</div>

					</form>		
				</div>
			</div>
			
		</div>
	</div>
	