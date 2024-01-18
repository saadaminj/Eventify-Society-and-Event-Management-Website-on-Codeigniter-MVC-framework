<div id="fh5co-contact" style="text-align: center;" >
		<div class="container">
			<div class="row">
				
				<div class="col-md-12 animate-box">
					<div class="price-box">
					<h1 >WELCOME TO YOUR DASHBOARD</h1>


                   	<br><br><br>
                   	<ul>			
					<a href="<?php echo base_url().'dashboardprofile'?>"><li><h3>Your Profile</h3></li></a>
					<br><br>
					<a href="<?php echo base_url().'updatepassword'?>"><li><h3>Update password</h3></li></a>
					<br><br>
					<a href="<?php echo base_url().'dashboardevent'?>"><li><h3>Events</h3></li></a>
					<?php if($pagedata[0]==1) :  ?>
					<br><br>
					<a href="<?php echo base_url().'dashboardregisteredevent'?>"><li><h3>Your Registered Events</h3></li></a>
					<?php endif; ?>
					</ul>
				</div>
			</div>
			</div>
			
		</div>
	</div>
	