<div id="fh5co-blog">
		<div class="container">
			<div class="row animate-box">
				<div class="col-md-8 col-md-offset-2 text-center fh5co-heading">
					<h2>Recent Post</h2>
					</div>
				</div>


			<div class="row">
				<?php foreach ($pagedata as $key ) { ?>
				<div class="col-lg-4 col-md-4">
					<div class="fh5co-blog animate-box">
					<?php if($key['picture']!=NULL) :  ?>
						<a href=""><img class="img-responsive" style="width: 800px; height: 270px; overflow: hidden" src="<?php echo base_url().'./assets/uploads/'.$key['picture'];?>" alt=""></a>
		
					<?php else : ?>
				    	<a href=""><img class="img-responsive" src="<?php echo base_url().'./assets/frontend/images/project-8.jpg';?>" alt=""></a>
				    <?php endif; ?>
						<div class="blog-text">
						<h3><a href=""#><?php echo ($key['Society']); ?>	HAS CREATED A NEW POST</a></h3>
						<span class="posted_on"><?php echo($key['created_at']);?></span>
						<span class="comment"><a href=""><?php echo $key['total_seats']; ?><i class="icon-speech-bubble"></i></a></span>
						<p><?php echo ($key['description']); ?></p>
							<div class="col text-center">
							<a href="<?php echo base_url().'registerevent/'.$key['id'];?>"class="btn btn-primary">Register</a>
							
							</div>
						</div> 
					</div>
				</div>
			<?php	} ?>	
			</div>	
							
		
		
<!--				
				 <div class="col text-center">
				 	<a href="<?php echo base_url().'dashboardaddevent';?>" class="btn btn-primary" >Click to add Event</a>
						
				 </div>
-->				 	

			</div>
		</div>
	</div>
