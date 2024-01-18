<div id="fh5co-contact">
		<div class="container">
			<div class="row">
				<div class="col-md-2 animate-box">
				</div>
				<div class="col-md-8 animate-box">
					<div class="price-box">
					<h1>FILL THE FORM TO CREATE NEW EVENT</h1>
                   <?php if(isset($_SESSION['success']))
                   		{ ?>
                   	  <div class="alert alert-success">
                   	  	<?php echo $_SESSION['success'];?></div>

                   	     <?php
                   		}  ?>
                   	
                   				
							<!-- <form action="<//?php echo base_url().'dashboardaddevent'?>" method="post"> -->
							<?php echo form_open_multipart('');?>
						<div class="row form-group">
							<div class="col-md-12">
								<!-- <label for="fname">First Name</label> -->
								<input type="text" id="title" class="form-control" 
								name="title" placeholder="Title of the event">
								<p><?php echo form_error('title'); ?></p>
							</div>
						</div>

							<div class="row form-group">
							<div class="col-md-12">
								<!-- <label for="email">Email</label> -->
							<select name="society" class="form-control" >
						    <option value="ACM">ACM</option>
						    <option value="DECS">DECS</option>
						    <option value="TNC">TNC</option>
						    <option value="WEBMASTERS">WEBMASTERS</option>
						    <option value="CBS">CBS</option>
						    <option value="TLC">TLC</option>
						    <option value="FMS">FMS</option>
						    <option value="SPORTICS">SPORTICS</option>
  							</select>
								<p><?php echo form_error('society'); ?></p>
							</div>
							</div>
						
						<div class="row form-group">
							<div class="col-md-6">
								<!-- <label for="fname">First Name</label> -->
								<input type="date" id="date" class="form-control" name="date" 
								placeholder="Date of the event">
								<p><?php echo form_error('date'); ?></p>
							</div>
							<div class="col-md-6">
								<!-- <label for="fname">First Name</label> -->
								<input type="number" id="totalseats" class="form-control"
								name="totalseats" placeholder="Total seats">
								<p><?php echo form_error('totalseats'); ?></p>
							</div>
							<div class="col-md-6">
								<!-- <label for="fname">First Name</label> -->
								<input type="file" size="100000" id="userfile" name="userfile" class="form-control"  placeholder="browse">
								<p><?php echo form_error('userfile'); ?></p>
							</div>
							<div class="col-md-6">
								<!-- <label for="fname">First Name</label> -->
								<input type="number" id="no_par" class="form-control"
								name="no_par" placeholder="Number of Participants per group">
								<p><?php echo form_error('no_par'); ?></p>
							</div>
							
						</div>
						<div class="row form-group">
							<div class="col-md-12">
								<!-- <label for="email">Email</label> -->
								<textarea name="description" spellcheck="true" id="description" cols="30" rows="10" class="form-control" placeholder="Description of the event" spellcheck="false"></textarea>

								<p><?php echo form_error('description'); ?></p>
							</div>
						</div>
						
						
						<div class="form-group">
						
						
						<input type="submit" name="AddEvent" value="Add Event" class="btn btn-primary">
						
							
						</div>

					</form>		
				</div>
			</div>
			</div>
			
		</div>
	</div>
	