<div id="fh5co-contact">
		<div class="container">
			<div class="row">
				<div class="col-md-6 animate-box">
					<h1> Register Yourself</h1>
					<form action="<?php echo base_url().'register_group/'.$users[1]; ?>" method="post">
						<div class="row form-group">
                            <div class="col-md-12">
								<!-- <label for="fname">First Name</label> -->
								<input type="text" name="gname" id="gname" class="form-control" placeholder="Group Name" value="<?php echo set_value('gname')?>">
								<p><?php echo form_error('gname'); ?></p>
							</div>
						</div>

                        <div class="row form-group">
							<div class="col-md-12" style="width:1000px">
								<!-- <label for="subject">Subject</label> -->
								<input type="text" id="par_id" name="par_id" class="form-control" placeholder="Group Member IDs (kxxxxxx,kxxxxxx,kxxxxxx...) <?php echo 'maximum no. of member is :' ; echo $users[0]; ?>" value="<?php echo set_value('par_id')?>">
								<p><?php echo form_error('par_id'); ?></p>
							</div>
						</div>

                        <div class="form-group">
							<input type="submit" name="register22" id="register22"  value="Register" class="btn btn-primary">
						</div>

					</form>		
				</div>
			</div>
			
		</div>
	</div>
	