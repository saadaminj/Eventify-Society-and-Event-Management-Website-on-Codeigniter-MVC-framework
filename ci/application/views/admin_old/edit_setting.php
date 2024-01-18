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
               Test Settings
            </h2>
        </div>
        <!-- Advanced Validation -->
        <div class="row clearfix">
            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                <div class="card">
                    <div class="header">
                        <h2>Edit Test Settings</h2>
                    </div>
                    <div class="body">

                        <?php if(isset($errors)){ 
                            ?>
                            <?php foreach($errors As $error){ ?>
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
                        <form id="form_advanced_validation" method="POST" action="<?php echo SITE_URL.'admin/admin_users_admin/test_setting/'.$final_data[0]['id'];?>" enctype="multipart/form-data">
                            <div class="row">
                                <div class="col-md-3">
                                    <div class="form-group form-float">
                                        <div class="form-line">
                                            <input type="number" class="form-control" name="no_of_free_questions" value="<?php echo $final_data[0]['no_of_free_questions'];?>" required/>
                                            <label class="form-label">Number Of Free Question</label>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="form-group form-float">
                                        <div class="form-line">
                                            <input type="number" class="form-control" name="no_of_paid_questions" value="<?php echo $final_data[0]['no_of_paid_questions'];?>" required/>
                                            <label class="form-label">Number Of Paid Question</label>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="form-group form-float">
                                        <div class="form-line">
                                            <input type="number" class="form-control" name="duration_free" value="<?php echo $final_data[0]['duration_free'];?>" required/>
                                            <label class="form-label">Test Duration For Free(In min)</label>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="form-group form-float">
                                        <div class="form-line">
                                            <input type="number" class="form-control" name="duration_paid" value="<?php echo $final_data[0]['duration_paid'];?>" required/>
                                            <label class="form-label">Test Duration For Paid(In min)</label>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-4">
                                    <div class="form-group form-float">
                                        <div class="form-line">
                                            <input type="number" class="form-control" name="point_free" value="<?php echo $final_data[0]['point_free'];?>" required/>
                                            <label class="form-label">Points Per Question For Free Question</label>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group form-float">
                                        <div class="form-line">
                                            <input type="number" class="form-control" name="point_paid" value="<?php echo $final_data[0]['point_paid'];?>" required/>
                                            <label class="form-label">Points Per Question For Paid Question</label>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group form-float">
                                        <div class="form-line">
                                            <input type="number" class="form-control" name="passing_percentage" value="<?php echo $final_data[0]['passing_percentage'];?>" required/>
                                            <label class="form-label">Pass Score(In %)</label>
                                        </div>
                                    </div>
                                </div>
                            </div>                    
                            <input type='hidden' name='doAct' value='update'/>
                             <center><button class="btn mt-5 pt-5 btn-lg btn-primary waves-effect" id="submitBtn" type="submit">Update</button>
                                <a class="btn mt-5 pt-5 btn-lg waves-effect btn-danger" href='./' style='margin-right: 10px;'>Cancel</a></center>
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