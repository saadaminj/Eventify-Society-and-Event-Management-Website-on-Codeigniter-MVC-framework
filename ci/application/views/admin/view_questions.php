<section class="content">
    <div class="container-fluid">
        <!-- Exportable Table -->
        <div class="row clearfix">
            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                <div class="card">
                    <div class="header">
                        <h2>
                            Questions Management
                        </h2>
                        <ul class="header-dropdown m-r--5">
                            <li class="dropdown">
                                <a href="javascript:void(0);" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">
                                    <i class="material-icons">add</i>
                                </a>
                                <ul class="dropdown-menu pull-right">
                                    <li><a href="<?php echo SITE_ADMIN_URL.'questions/add';?>">Add</a></li>
                                </ul>
                            </li>
                        </ul>
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
                                <th>Question Type</th>
                                <th>Question</th>
                                <th>Option 1</th>
                                <th>Option 2</th>
                                <th>Option 3</th>
                                <th>Option 4</th>
                                 <th>Explaination</th>
                                <th>Created Date</th>
                                <th>Actions</th>
                            </tr>
                            </thead>
                            <tbody>
                            <?php if(isset($final_data) && $final_data != null){ ?>
                                <?php foreach($final_data As $final_data){ ?>
                                    <tr id="row">
                                        <td><?php echo $final_data['id'];?></td>
                                        <td><?php echo ($final_data['is_free'] == 1)? 'Free':'Paid';?></td>
                                        <td><?php echo $final_data['text'];?></td>
                                        <td <?php echo ($final_data['is_right'] == 1)?"style='background-color:#0b9444; color:#fff'": '' ?>><?php echo $final_data['option1'];?></td>
                                        <td <?php echo ($final_data['is_right'] == 2)?"style='background-color:#0b9444; color:#fff'": '' ?>><?php echo $final_data['option2'];?></td>
                                        <td <?php echo ($final_data['is_right'] == 3)?"style='background-color:#0b9444; color:#fff'": '' ?>><?php echo $final_data['option3'];?></td>
                                        <td <?php echo ($final_data['is_right'] == 4)?"style='background-color:#0b9444; color:#fff'": '' ?>><?php echo $final_data['option4'];?></td>
                                        <td><?php echo $final_data['explain'];?></td>
                                        <td><?php echo $final_data['created_at'];?></td>
                                        <td>
                                            <a  class="btn btn-primary" href='<?php echo SITE_ADMIN_URL.'questions/edit'.'/'.$final_data['id'];?>' style='margin-right: 10px;'>Edit</a>
                                            <a class="btn btn-danger" href='<?php echo SITE_ADMIN_URL.'questions/delete'.'/'.$final_data['id'];?>'>Delete</a>
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
