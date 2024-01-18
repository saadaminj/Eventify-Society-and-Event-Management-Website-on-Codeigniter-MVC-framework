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
                                <th>Section</th>
                                <th>Batch</th>
                                <th>Role</th>
                                <th>Change Role</th>
                                
                            </tr>
                            </thead>
                            <tbody>
                            <?php if(isset($final_data) && $final_data != null){ ?>
                                <?php foreach($final_data As $final_data){ ?>
                                   <?php { ?>
                                    <tr>
                                        <td><?php echo $final_data['id'];?></td>
                                        <td><?php echo $final_data['username'];?></td>
                                        <td><?php echo $final_data['email'];?></td>
                                        <td><?php echo $final_data['firstname'];?></td>
                                        <td><?php echo $final_data['lastname'];?></td>
                                        <td><a href="<?php echo SITE_ADMIN_URL;?>Admin_users_admin/acitve_inactive/<?php echo $final_data['id']; ?>/<?php echo ($final_data['status'] == 1) ? 0 : 1; ?>" class="btn btn-<?php echo ($final_data['status'] == 1)?'success':'danger';?>"><?php echo ($final_data['status'] == 1)?'Active':'Inactive';?></a> </td>   
                                        <td><?php echo $final_data['createdat'];?></td>
                                        <td><?php echo $final_data['Section'];?></td>
                                        <td><?php echo $final_data['Batch'];?></td>
                                        
                                        <td><?php 
                                        if($final_data['role']==1)
                                            echo "Student";
                                        elseif ($final_data['role']==2) {
                                            echo "Society President";
                                        }
                                        elseif ($final_data['role']==3) {
                                            echo "Faculty";
                                        }
                                        else
                                        {
                                            echo "Undefined Role";
                                        }
                                                ?></td>
                                        
                                        <td style='text-align: center;'>
                                                <form action="<?php echo SITE_ADMIN_URL.'admin_users_admin/edit'.'/'.$final_data['id'];?>" method="post">
                                                <?php 
                                                
                                                if ($final_data['role']==1) {
                                                    echo '
                                                <select name="Role" class="form-control">
                                                <option value="Faculty">Faculty</option>
                                                <option value="President">President</option>
                                                <option value="Student">Student</option>
                                                </select>';
                                                }
                                                else if ($final_data['role']==2) {
                                                    echo '
                                                <select name="Role" class="form-control">
                                                <option value="President">President</option>
                                                <option value="Faculty">Faculty</option>
                                                <option value="Student">Student</option>
                                                </select>';
                                                }
                                                else
                                                {
                                                   echo '
                                                <select name="Role" class="form-control">
                                                <option value="Faculty">Faculty</option>
                                                <option value="President">President</option>
                                                <option value="Student">Student</option>
                                                </select>';
                                                }
                                                ?>
                                                <input type="submit" name="changerole" value="Change Role" class="btn btn-primary">
                                             <!-- <a  style="display: inline;" class="btn btn-primary" href='<?php //echo SITE_ADMIN_URL.'admin_users_admin/edit'.'/'.$final_data['id'];?>' style='margin-right: 10px;'>Change Status</a>
                                             -->
                                         </form>
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
