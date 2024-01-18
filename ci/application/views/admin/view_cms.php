<section class="content">
    <div class="container-fluid">
        <!-- Exportable Table -->
        <div class="row clearfix">
            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                <div class="card">
                    <div class="header">
                        <h2>
                            Cms Management
                        </h2>
                        <?php 
                        $succMsg = $this->session->flashdata('succMsg');
                        if(isset($succMsg) && $succMsg != null){ ?>
                            <div class="alert alert-success alert-dismissable fade in">
                                <a class="close" data-dismiss="alert" aria-label="close">&times;</a>
                                <strong>Yahoo!</strong> <?php echo $succMsg; ?>
                            </div>
                        <?php } ?>
                        <?php 
                        $errorMsg = $this->session->flashdata('errorMsg');
                        if(isset($errorMsg) && $errorMsg != null){ ?>
                            <div class="alert alert-danger alert-dismissable fade in">
                                <a class="close" data-dismiss="alert" aria-label="close">&times;</a>
                                <strong>Ooopss!</strong> <?php echo $errorMsg; ?>
                            </div>
                        <?php } ?>
                        

                    </div>
                    <div class="body">
                        <table class="table table-bordered table-striped table-hover dataTable js-exportable" id="myTable">
                            <thead>
                            <tr>
                                <th>Id #</th>
                                <th>Title</th>
                                <th>Updated Date</th>
                                <th>Actions</th>
                            </tr>
                            </thead>
                            <tbody>
                            <?php if(isset($final_data) && $final_data != null){ ?>
                                <?php foreach($final_data As $final_data){ ?>
                                    <tr id="row">
                                        <td><?php echo $final_data['id'];?></td>
                                        <td><?php echo $final_data['title'];?></td>
                                        <td><?php echo $final_data['updated_at'];?></td>
                                        <td>
                                            <a  class="btn btn-primary" href='<?php echo SITE_ADMIN_URL.'cms/edit'.'/'.$final_data['id'];?>' style='margin-right: 10px;'>Edit</a>
                                            <a class="btn btn-danger" href='<?php echo SITE_ADMIN_URL.'cms/detail'.'/'.$final_data['id'];?>'>Detail</a>
                                        </td> 
                                    </tr>
                                <?php } ?>
                            <?php } ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
        <!-- #END# Exportable Table -->
    </div>
</section>

<!-- Jquery Core Js -->
<script src="<?php echo SITE_URL.'/assets/admin/';?>plugins/jquery/jquery.min.js"></script>
