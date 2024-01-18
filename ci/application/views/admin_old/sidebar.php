<section>
    <!-- Left Sidebar -->
    <aside id="leftsidebar" class="sidebar">
        <!-- User Info -->
        <div class="user-info">
            <div class="image">
                <img src="<?php echo SITE_URL.'/assets/admin/';?>images/user.png" width="48" height="48" alt="User" />
            </div>
            <div class="info-container">
                <div class="name" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">Welcome</div>
        
                <div class="btn-group user-helper-dropdown">
                    <i class="material-icons" data-toggle="dropdown" aria-haspopup="true" aria-expanded="true">keyboard_arrow_down</i>
                    <ul class="dropdown-menu pull-right">
                        <li><a href="<?php echo SITE_ADMIN_URL.'users_admin/index';?>"><i class="material-icons">person</i>Profile</a></li>
                        <li><a href="<?php echo SITE_ADMIN_URL.'admin_users_admin/logout';?>" class=" waves-effect waves-block"><i class="material-icons">input</i>Sign Out</a></li>
                    </ul>
                </div>
            </div>
        </div>
        <!-- #User Info -->
        <!-- Menu -->
    <div class="menu">
        <ul class="list">
            <li class="header">MAIN NAVIGATION</li>
            <li class="active">
                <a href="<?php echo SITE_ADMIN_URL . 'index_admin/index';?>">
                    <i class="material-icons">home</i>
                    <span>Dashboard</span>
                </a>
            </li>

            <li>
                <a href="<?php echo SITE_ADMIN_URL.'admin_users_admin/admin_users';?>">
                    <i class="material-icons">person</i>
                    <span>Users Management</span>
                </a>
            </li>
            <li>
                <a href="<?php echo SITE_ADMIN_URL.'admin_users_admin/test_setting';?>">
                    <i class="material-icons icon-image-preview">settings_applications</i>
                    <span>Test Setting</span>
                </a>
            </li>
            <li>
                <a href="<?php echo SITE_ADMIN_URL.'questions/index';?>">
                    <i class="material-icons icon-image-preview">assignment_turned_in</i>
                    <span>Questions Management</span>
                </a>
            </li>
            <li>
                <a href="<?php echo SITE_ADMIN_URL.'cms/index';?>">
                    <i class="material-icons icon-image-preview">chrome_reader_mode</i>
                    <span>CMS Management</span>
                    <i class="fas fa-book"></i>
                </a>
            </li>
            <!--<li>-->
            <!--    <a href="<?php echo SITE_ADMIN_URL.'admin_users_admin/subscribe';?>">-->
            <!--        <i class="material-icons icon-image-preview">settings_applications</i>-->
            <!--        <span>Subscribers</span>-->
            <!--    </a>-->
            <!--</li>-->
            <li>
                <a href="<?php echo SITE_ADMIN_URL.'admin_users_admin/contact';?>">
                    <i class="material-icons icon-image-preview">settings_applications</i>
                    <span>Contacted User</span>
                </a>
            </li>
            
            <li>
                <a href="<?php echo SITE_ADMIN_URL.'admin_users_admin/payment_setting';?>">
                    <i class="material-icons icon-image-preview">settings_applications</i>
                    <span>Payment Settings</span>
                </a>
            </li>
                   
        <!-- --------- Home Management -------  --> 
            
        <!-- --------- About CWS -------  -->
            
        
                        </ul> 
                    </li>
                </ul>
            </li>  
        <!-- --------- Payments -------  -->
            
        <!-- --------- Site User -------  --> 
           <!--<li>-->
           <!--             <a href="<?php echo SITE_ADMIN_URL.'Site_user/admin_users';?>">-->
           <!--                 <i class="material-icons">account_box</i>-->
           <!--                 <span>Site Users</span>-->
           <!--             </a>-->
           <!--         </li>-->
        <!-- --------- Contact Us -------  --> 
            <!--<li>-->
            <!--                            <a href="javascript:void(0);" class="menu-toggle">-->
            <!--                                <span>Social Media</span>-->
            <!--                            </a>-->
            <!--                            <ul class="ml-menu">-->
            <!--                                <li>-->
            <!--                                    <a href="<?php echo SITE_ADMIN_URL.'social_media/';?>">View</a>-->
            <!--                                </li>-->
            <!--                            </ul>                    -->
                          
            <!--            </li>-->
                        
                        <!-- --------- Privacy policy -------  --> 
                        <!--<li>-->
                                    
                        <!--                <a href="javascript:void(0);" class="menu-toggle">-->
                        <!--                    <span>Privacy Policy</span>-->
                        <!--                </a>-->
                        <!--                <ul class="ml-menu">-->
                        <!--                    <li>-->
                        <!--                        <a href="<?php echo SITE_ADMIN_URL.'privacy_policy/index';?>">View</a>-->
                        <!--                    </li>-->
                        <!--                </ul>                    -->
                               
                        <!--</li>       -->
                    </ul>
                </li>
        </ul>
    </div>
        <!-- #Menu -->
        <!-- Footer -->
        <div class="legal">
            <div class="copyright">
                <p class="white-text">Copyright 2019 <a href="#">CBSDT.</a></p>
            </div>
            <div class="version">
                <b>Version: </b> 1.0.1
            </div>
        </div>
        <!-- #Footer -->
    </aside>
    <!-- #END# Left Sidebar -->
    <!-- Right Sidebar -->
    <aside id="rightsidebar" class="right-sidebar">
        <ul class="nav nav-tabs tab-nav-right" role="tablist">
            <li role="presentation" class="active"><a href="#skins" data-toggle="tab">SKINS</a></li>
            <li role="presentation"><a href="#settings" data-toggle="tab">SETTINGS</a></li>
        </ul>
        <div class="tab-content">
            <div role="tabpanel" class="tab-pane fade in active in active" id="skins">
                <ul class="demo-choose-skin" style="height:100% !important;">
                    <li data-theme="red" class="active">
                        <div class="red"></div>
                        <span>Red</span>
                    </li>
                    <li data-theme="pink">
                        <div class="pink"></div>
                        <span>Pink</span>
                    </li>
                    <li data-theme="purple">
                        <div class="purple"></div>
                        <span>Purple</span>
                    </li>
                    <li data-theme="deep-purple">
                        <div class="deep-purple"></div>
                        <span>Deep Purple</span>
                    </li>
                    <li data-theme="indigo">
                        <div class="indigo"></div>
                        <span>Indigo</span>
                    </li>
                    <li data-theme="blue">
                        <div class="blue"></div>
                        <span>Blue</span>
                    </li>
                    <li data-theme="light-blue">
                        <div class="light-blue"></div>
                        <span>Light Blue</span>
                    </li>
                    <li data-theme="cyan">
                        <div class="cyan"></div>
                        <span>Cyan</span>
                    </li>
                    <li data-theme="teal">
                        <div class="teal"></div>
                        <span>Teal</span>
                    </li>
                    <li data-theme="green">
                        <div class="green"></div>
                        <span>Green</span>
                    </li>
                    <li data-theme="light-green">
                        <div class="light-green"></div>
                        <span>Light Green</span>
                    </li>
                    <li data-theme="lime">
                        <div class="lime"></div>
                        <span>Lime</span>
                    </li>
                    <li data-theme="yellow">
                        <div class="yellow"></div>
                        <span>Yellow</span>
                    </li>
                    <li data-theme="amber">
                        <div class="amber"></div>
                        <span>Amber</span>
                    </li>
                    <li data-theme="orange">
                        <div class="orange"></div>
                        <span>Orange</span>
                    </li>
                    <li data-theme="deep-orange">
                        <div class="deep-orange"></div>
                        <span>Deep Orange</span>
                    </li>
                    <li data-theme="brown">
                        <div class="brown"></div>
                        <span>Brown</span>
                    </li>
                    <li data-theme="grey">
                        <div class="grey"></div>
                        <span>Grey</span>
                    </li>
                    <li data-theme="blue-grey">
                        <div class="blue-grey"></div>
                        <span>Blue Grey</span>
                    </li>
                    <li data-theme="black">
                        <div class="black"></div>
                        <span>Black</span>
                    </li>
                </ul>
            </div>
            <div role="tabpanel" class="tab-pane fade" id="settings">
                <div class="demo-settings">
                    <p>GENERAL SETTINGS</p>
                    <ul class="setting-list">
                        <li>
                            <span>Report Panel Usage</span>
                            <div class="switch">
                                <label><input type="checkbox" checked><span class="lever"></span></label>
                            </div>
                        </li>
                        <li>
                            <span>Email Redirect</span>
                            <div class="switch">
                                <label><input type="checkbox"><span class="lever"></span></label>
                            </div>
                        </li>
                    </ul>
                    <p>SYSTEM SETTINGS</p>
                    <ul class="setting-list">
                        <li>
                            <span>Notifications</span>
                            <div class="switch">
                                <label><input type="checkbox" checked><span class="lever"></span></label>
                            </div>
                        </li>
                        <li>
                            <span>Auto Updates</span>
                            <div class="switch">
                                <label><input type="checkbox" checked><span class="lever"></span></label>
                            </div>
                        </li>
                    </ul>
                    <p>ACCOUNT SETTINGS</p>
                    <ul class="setting-list">
                        <li>
                            <span>Offline</span>
                            <div class="switch">
                                <label><input type="checkbox"><span class="lever"></span></label>
                            </div>
                        </li>
                        <li>
                            <span>Location Permission</span>
                            <div class="switch">
                                <label><input type="checkbox" checked><span class="lever"></span></label>
                            </div>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </aside>
    <!-- #END# Right Sidebar -->
</section>