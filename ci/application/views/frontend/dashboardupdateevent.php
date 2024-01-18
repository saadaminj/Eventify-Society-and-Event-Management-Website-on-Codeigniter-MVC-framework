<div id="fh5co-contact">
		<div class="container">
			<div class="row">
				<div class="col-md-2 animate-box">
				</div>
				<div class="col-md-8 animate-box">
					<div class="price-box">
					<h1>FILL THE FORM TO UPDATE EVENT</h1>
                   <?php if(isset($_SESSION['success']))
                   		{ ?>
                   	  <div class="alert alert-success">
                   	  	<?php echo $_SESSION['success'];?></div>

                   	     <?php
                   		}  ?>
                   	
                   				<?php //print_r($pagedata);?>
                   				<?php //echo($pagedata[0]['id']);?>
							<form action="<?php echo base_url().'dashboardupdateevent/'.$pagedata[0]['id'];?>" method="post">
						<div class="row form-group">
							<div class="col-md-12">
								<!-- <label for="fname">First Name</label> -->
								<input type="text" id="title" class="form-control" 
								value="<?php echo ($pagedata[0]['title']); ?>" name="title" placeholder="<?php echo ($pagedata[0]['title']); ?>">
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
								value="<?php echo ($pagedata[0]['event_date']); ?>" placeholder="<?php echo ($pagedata[0]['event_date']); ?>">
								<p><?php echo form_error('date'); ?></p>
							</div>
							<div class="col-md-6">
								<!-- <label for="fname">First Name</label> -->
								<input type="number" id="totalseats" class="form-control"
								value="<?php echo ($pagedata[0]['total_seats']); ?>" name="totalseats" placeholder="<?php echo ($pagedata[0]['total_seats']); ?>">
								<p><?php echo form_error('totalseats'); ?></p>
							</div>
							
						</div>
						<div class="row form-group">
							<div class="col-md-12">
								<!-- <label for="email">Email</label> -->
								<textarea name="description" value="<?php echo ($pagedata[0]['description']); ?>" id="description" cols="30" rows="10" class="form-control" placeholder="<?php echo ($pagedata[0]['description']); ?>" spellcheck="false"></textarea>

								<p><?php echo form_error('description'); ?></p>
							</div>
						</div>
						
						
						<div class="form-group">
						
						
						<input type="submit" name="UpdateEvent" value="Update Event" class="btn btn-primary">
						
							
						</div>

					</form>		
				</div>
			</div>
			</div>
			
		</div>
	</div>
	