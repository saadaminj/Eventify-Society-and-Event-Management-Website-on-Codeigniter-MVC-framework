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
                <?php echo $final_data[0]['title']; ?>
            </h2>
        </div>
        <!-- Advanced Validation -->
        <div class="row clearfix">
            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                <div class="card">
                    <div class="header">
                        <h2>Edit CMS</h2>
                    </div>
                    <div class="body">

                        <?php if(isset($errors)){ ?>
                            <?php foreach( $errors->all() As $error){ ?>
                                <div class="alert alert-danger alert-dismissable fade in">
                                    <a href="javascript:;" class="close" data-dismiss="alert" aria-label="close">&times;</a>
                                    <strong>oops!</strong> <?php echo $errorMsg;?>
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
                        <form id="form_advanced_validation" method="POST" action="<?php echo SITE_ADMIN_URL.'cms/edit/'.$final_data[0]['id'];?>" enctype="multipart/form-data">
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="form-group form-float">
                                        <label class="form-label">Title</label>
                                        <div class="form-line">
                                            <input type="text" class="form-control" value="<?php echo $final_data[0]['title'];?>" disabled>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="form-group form-float">
                                        <label class="form-label">Description</label>
                                        <div class="form-line">
                                            <textarea id="ckeditor" class="form-control" name="text" required><?php echo $final_data[0]['text'];?></textarea>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            
                            <input type='hidden' name='doAct' value='update'/>
                            <input type='hidden' name='id' value='<?php echo $final_data[0]['id'];?>'/>
                            <center><button class="btn mt-5 pt-5 btn-lg btn-primary waves-effect" id="submitBtn" type="submit">Update</button>
                                <a class="btn mt-5 pt-5 btn-lg waves-effect btn-danger" href='<?php echo SITE_ADMIN_URL.'cms/index'?>' style='margin-right: 10px;'>Cancel</a></center>
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
<script src="https://cdn.jsdelivr.net/bootstrap.tagsinput/0.4.2/bootstrap-tagsinput.min.js"></script>
<script>
    $(function() {
        $('#inputTags').tagsinput();
    });
</script>