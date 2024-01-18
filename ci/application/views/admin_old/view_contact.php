<section class="content">
    <div class="container-fluid">
        <!-- Exportable Table -->
        <div class="row clearfix">
            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                <div class="card">
                    <div class="header">
                        <h2>
                            Contacted Users
                        </h2>
                        <?php 
                        $succMsg = $this->session->flashdata('msg');
                        if(isset($succMsg) && $succMsg != null){ ?>
                            <div class="alert alert-success alert-dismissable fade in">
                                <a class="close" data-dismiss="alert" aria-label="close">&times;</a>
                                <strong>Yahoo!</strong> <?php echo $succMsg; ?>
                            </div>
                        <?php } ?>
                        

                    </div>
                    <div class="body">
                        <table class="table table-bordered table-striped table-hover dataTable js-exportable" id="myTable">
                            <thead>
                            <tr>
                                <th>First Name</th>
                                <th>Last Name</th>
                                <th>Email</th>
                                <th>Message</th>
                                <th>Created Date</th>
                            </tr>
                            </thead>
                            <tbody>
                            <?php if(isset($final_data) && $final_data != null){ ?>
                                <?php foreach($final_data As $final_data){ ?>
                                   <tr>
                                        <td><?php echo $final_data['first_name'];?></td>
                                        <td><?php echo $final_data['last_name'];?></td>
                                        <td><?php echo $final_data['email'];?></td>
                                        <td><?php echo $final_data['message'];?></td>
                                        <td><?php echo $final_data['created_at'];?></td>
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
