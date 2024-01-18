<section class="content">
    <div class="container-fluid">
        <!-- Exportable Table -->
        <div class="row clearfix">
            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                <div class="card">
                    <div class="header">
                        <h2>
                            Users Management
                        </h2>
                        <ul class="header-dropdown m-r--5">
                            <li class="dropdown">
                                <a href="javascript:void(0);" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">
                                    <i class="material-icons">add</i>
                                </a>
                                <ul class="dropdown-menu pull-right">
                                    <li><a href="<?php echo SITE_ADMIN_URL.'admin_users_admin/add';?>">Add</a></li>
                                </ul>
                            </li>
                        </ul>
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
                                <th>User Name</th>
                                <th>Email</th>
                                <th>First Name</th>
                                <th>Last Name</th>
                                <th>Status</th>
                                <th>Created Date</th>
                                <th>Last Subscription Date</th>
                                <th>Expire Date</th>
                                <th>Actions</th>
                            </tr>
                            </thead>
                            <tbody>
                            <?php if(isset($final_data) && $final_data != null){ ?>
                                <?php foreach($final_data As $final_data){ ?>
                                   <?php if($final_data['is_deleted'] != 1){ ?>
                                    <tr id="row-{{$breedListing->id}}" <?php echo ($final_data['is_premium'] == 0)?"style='background-color:#ffcccc;'": '' ?>>
                                        <td><?php echo $final_data['id'];?></td>
                                        <td><?php echo $final_data['username'];?></td>
                                        <td><?php echo $final_data['email'];?></td>
                                        <td><?php echo $final_data['first_name'];?></td>
                                        <td><?php echo $final_data['last_name'];?></td>
                                        <td><a href="javascript:;" class="btn btn-<?php echo ($final_data['status'] == 1) ? 'success' : 'danger'; ?>"><?php echo ($final_data['status'] == 1) ? 'Active' : 'Inactive'; ?></a>    
                                        <td><?php echo $final_data['created_at'];?></td>
                                        <td><?php echo $final_data['last_subscription_date'];?></td>
                                        <td><?php echo $final_data['last_exp_date'];?></td>
                                        <td>
                                            <a  class="btn btn-primary" href='<?php echo SITE_ADMIN_URL.'admin_users_admin/edit'.'/'.$final_data['id'];?>' style='margin-right: 10px;'>Edit</a>
                                            <a class="btn btn-danger" href='<?php echo SITE_ADMIN_URL.'admin_users_admin/delete/'.'/'.$final_data['id'];?>'>Delete</a>
                                            <a  class="btn btn-success" href='<?php echo SITE_ADMIN_URL.'admin_users_admin/edit_premium'.'/'.$final_data['id'];?>' style='margin-right: 10px;'>Edit Premium</a>
                                        </td> 
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
