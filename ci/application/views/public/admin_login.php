<?php include('public_header.php'); ?>
<div class="container">
<!-- <form> -->
	<?php echo form_open('Login/admin_login') ;?>
  <fieldset>
    <legend>Login Form</legend>
    
    <div class="form-group">
      <label for="exampleInputPassword1">Username</label>
      <input type="text" class="form-control" id="exampleInputPassword1" placeholder="Username">
    </div>
    <div class="form-group">
      <label for="exampleInputPassword1">Password</label>
      <input type="password" class="form-control" id="exampleInputPassword1" placeholder="Password">
    </div>
    
    <button type="submit" class="btn btn-primary">Submit</button>
  </fieldset>
</form>
</div>
<?php include('public_footer.php'); ?>

