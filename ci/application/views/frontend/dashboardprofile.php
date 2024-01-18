<div id="fh5co-contact" style="text-align: center;" >
		<div class="container">
			<div class="row">
				
				<div class="col-md-12 animate-box">
					<div class="price-box">
					<h1 >WELCOME TO YOUR PROFILE</h1>

					
                   	<br><br><br>
					<h3><img  style="width: 200px; height: 200px; border-radius:50%" src="<?php echo base_url().'./assets/uploads/3.jpg';?>" alt="image"></h3>   			
					<br>
					<h3>Firstname :<?php echo $pagedata[0]['firstname'] ; ?></h3>
					<h3>Lastname :<?php echo $pagedata[0]['lastname']?></h3>
					<h3>Email :<?php echo $pagedata[0]['email'] ?></h3>
					<?php 
					$a=$pagedata[0]['role'];
					
					if($a==3)
					{
					$role = 'Faculty';
					}
					else if($a==1)
					{
						$role = 'Student';
					}	
					else if ($a==2)
					{
						$role = 'Society President';
					}
					else
					{
						$role = 'Undefined role';
					}
					?>
					<h3>Role : <?php echo $role; ?></h3>

					</ul>
				</div>
			</div>
			</div>
			
		</div>
	</div>
	