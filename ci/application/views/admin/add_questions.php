<style>
    .file {
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
               Question Management
            </h2>
        </div>
        <!-- Advanced Validation -->
        <div class="row clearfix">
            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                <div class="card">
                    <div class="header">
                        <h2>Add Question</h2>
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
                        <form id="form_advanced_validation" method="POST" action="<?php echo SITE_URL.'admin/questions/add/';?>" enctype="multipart/form-data">
                            <div class="col-md-4">
                                <div class="form-group form-float">
                                    <div class="form-line ">
                                        <input type="text" class="form-control" name="question" required/>
                                        <label class="form-label">Question</label>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group form-float">
                                    <div class="form-line">
                                        <input type="text" class="form-control" name="option1" required/>
                                        <label class="form-label">Option 1</label>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group form-float">
                                    <div class="form-line">
                                        <input type="text" class="form-control" name="option2" required/>
                                        <label class="form-label">Option 2</label>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group form-float">
                                    <div class="form-line">
                                        <input type="text" class="form-control" name="option3" required/>
                                        <label class="form-label">Option 3</label>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group form-float">
                                    <div class="form-line">
                                        <input type="text" class="form-control" name="option4" required/>
                                        <label class="form-label">Option 4</label>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <label class="form-label" style="font-weight: normal;color: #aaa;position: absolute;top: -20px;cursor: text;-moz-transition: 0.2s;-o-transition: 0.2s;-webkit-transition: 0.2s;transition: 0.2s;">Please select question type</label>
                                <select class="form-control show-tick" style="margin-top: 27px margin-bottom: 27px;" name="is_free" required>
                                    <option value="1">Free</option>
                                    <option value="0">Paid</option>
                                </select>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group form-float">
                                    <div class="form-line">
                                        <input type="text" class="form-control" name="explain" required/>
                                        <label class="form-label">Explaination</label>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label" style="font-weight: normal;color: #aaa;position: absolute;top: -20px;cursor: text;-moz-transition: 0.2s;-o-transition: 0.2s;-webkit-transition: 0.2s;transition: 0.2s;">Please select right option</label>
                                <select class="form-control show-tick" style="margin-top: 27px margin-bottom: 27px;" name="is_right" required>
                                    <option value="1">Option 1</option>
                                    <option value="2">Option 2</option>
                                    <option value="3">Option 3</option>
                                    <option value="4">Option 4</option>
                                </select>
                            </div>
                            <input type='hidden' name='doAct' value='add'/>
                            
                            <center><button class="btn mt-5 pt-5 btn-lg btn-primary waves-effect" id="submitBtn" type="submit">Add</button>
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