<section class="content">
    <div class="container-fluid">
        <!-- Exportable Table -->
        <div class="row clearfix">
            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                <div class="card">
                    <div class="header">
                        <h2>
                            Event Management
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
                                <th>Id #</th>
                                <th>Society</th>
                                <th>title</th>
                                <th>description</th>
                                <th>event_date</th>
                                <th>Remaining Seats</th>
                                <th>Created Date</th>
                                <th>Actions</th>
                                
                                
                            </tr>
                            </thead>
                            <tbody>
                            <?php if(isset($final_data) && $final_data != null){ ?>
                                <?php foreach($final_data As $final_data){ ?>
                                   <?php { ?>
                                    <tr>
                                        <td><?php echo $final_data['id'];?></td>
                                        <td><?php echo $final_data['Society'];?></td>
                                        <td><?php echo $final_data['title'];?></td>
                                        <td><?php echo $final_data['description'];?></td>
                                        <td><?php echo $final_data['event_date'];?></td>
                                        <td><?php echo $final_data['total_seats'];?></td>
                                        <td><?php echo $final_data['created_at'];?></td>
                                        
                                        <td><a href="<?php echo SITE_ADMIN_URL;?>Admin_users_admin/acitve_inactive_event/<?php echo $final_data['id']; ?>/<?php echo ($final_data['status'] == 1) ? 0 : 1; ?>" class="btn btn-<?php echo ($final_data['status'] == 1)?'success':'danger';?>"><?php echo ($final_data['status'] == 1)?'Active':'Inactive';?></a> </td>   
                                        
                           
                                    </tr>
                                    <?php } ?>
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
