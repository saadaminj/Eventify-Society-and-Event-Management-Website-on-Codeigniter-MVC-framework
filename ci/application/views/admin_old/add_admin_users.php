<style>.file {
        visibility: hidden;
        position: absolute;
    }
    /*
     * Styles for demo only
     */
    $purple: #5c4084;
    body {
        background-color: $purple;
        margin: 50px;
    }
    .container {
        background-color: #fff;
        padding: 40px 80px;
        border-radius: 8px;
    }
    h1 {
        color: #fff;
        font-size: 4rem;
        font-weight: 900;
        margin: 0 0 5px 0;
        background: -webkit-linear-gradient(#fff, #999);
        -webkit-background-clip: text;
        -webkit-text-fill-color: transparent;
        text-align: center;
    }
    h4 {
        color: lighten(#5c3d86,30%);
        font-size: 24px;
        font-weight: 400;
        text-align: center;
        margin: 0 0 35px 0;
    }
    .btn.btn-primary {
        background-color: $purple;
        border-color: $purple;
        outline: none;
    &:hover {
         background-color: darken($purple, 10%);
         border-color: darken($purple, 10%);
     }
    &:active, &:focus {   quotes: 
                   background-color: lighten($purple, 5%);
                   border-color: lighten($purple, 5%);
               }
    }
</style>
<?php
$succMsg = $this->session->flashdata('msg');
$errorMsg = $this->session->flashdata('errorMsg');
?>
<section class="content">
    <div class="container-fluid">
        <div class="block-header">
            <h2>
               User Management
            </h2>
        </div>
        <!-- Advanced Validation -->
        <div class="row clearfix">
            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                <div class="card">
                    <div class="header">
                        <h2>Add User</h2>
                    </div>
                    <div class="body">

                        <?php if(isset($errors)){ 
                            ?>
                            <?php foreach( $errors As $error){ ?>
                                <div class="alert alert-danger alert-dismissable fade in">
                                    <a href="javascript:;" class="close" data-dismiss="alert" aria-label="close">&times;</a>
                                    <strong>oops!</strong> <?php echo $error;?>
                                </div>
                            <?php } ?>
                        <?php } ?>
                        <?php if(isset($errorMsg) && $errorMsg != null){ ?>
                            <div class="alert alert-danger alert-dismissable fade in">
                                <a href="javascript:;" class="close" data-dismiss="alert" aria-label="close">&times;</a>
                                <strong>oops!</strong> <?php echo $errorMsg;?>
                            </div>
                        <?php } ?>
                        <?php if(isset($succMsg) && $succMsg != null){ ?>
                            <div class="alert alert-success alert-dismissable fade in">
                                <a href="javascript:;" class="close" data-dismiss="alert" aria-label="close">&times;</a>
                                <strong>Yahoo!</strong> <?php echo $succMsg;?>
                            </div>
                        <?php }?>
                        <form id="form_advanced_validation" method="POST" action="<?php echo SITE_URL.'admin/admin_users_admin/add/';?>" enctype="multipart/form-data">
                            <div class="col-md-4">
                                <div class="form-group form-float">
                                    <div class="form-line ">
                                        <input type="text" class="form-control" name="username" required/>
                                        <label class="form-label">Username</label>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group form-float">
                                    <div class="form-line">
                                        <input type="email" class="form-control" name="email" required/>
                                        <label class="form-label">Email</label>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group form-float">
                                    <div class="form-line">
                                       <input type="password" class="form-control" name="password" required/>
                                        <label class="form-label">Password</label>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group form-float">
                                    <div class="form-line ">
                                        <input type="text" class="form-control" name="first_name" required/>
                                        <label class="form-label">First Name</label>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group form-float">
                                    <div class="form-line">
                                        <input type="text" class="form-control" name="last_name" required/>
                                        <label class="form-label">Last Name</label>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <label class="form-label" style="font-weight: normal;color: #aaa;position: absolute;top: -20px;cursor: text;-moz-transition: 0.2s;-o-transition: 0.2s;-webkit-transition: 0.2s;transition: 0.2s;">Please select status</label>
                                <select class="form-control show-tick" style="margin-top: 27px margin-bottom: 27px;" name="status" required>
                                    <option value="1">Active</option>
                                    <option value="0">In active</option>
                                </select>
                            </div>
                            <input type='hidden' name='doAct' value='add'/>
                            
                            <center><button class="btn mt-5 pt-5 btn-lg btn-primary waves-effect" id="submitBtn" type="submit">Add</button>
                                <a class="btn mt-5 pt-5 btn-lg waves-effect btn-danger" href='./admin_users' style='margin-right: 10px;'>Cancel</a></center>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        <!-- #END# Advanced Validation -->

    </div>
</section>

<!-- Jquery Core Js -->
<script src="<?php echo SITE_URL.'/assets/admin/';?>plugins/jquery/jquery.min.js"></script>
<script type="text/javascript">
   
   $("#select_all").change(function(){  //"select all" change 
    $(".checkbox").prop('checked', $(this).prop("checked")); //change all ".checkbox" checked status
});

//".checkbox" change 
$('.checkbox').change(function(){ 
    //uncheck "select all", if one of the listed checkbox item is unchecked
    if(false == $(this).prop("checked")){ //if this item is unchecked
        $("#select_all").prop('checked', false); //change "select all" checked status to false
    }
    //check "select all" if all checkbox items are checked
    if ($('.checkbox:checked').length == $('.checkbox').length ){
        $("#select_all").prop('checked', true);
    }
});

</script>