


<section class="content">
    <div class="container-fluid">
        <div class="block-header">
            <b><h1>DASHBOARD</h1></b>
        </div>

        <!-- Widgets -->
        <div class="row clearfix">
            <a href="<?php echo SITE_ADMIN_URL.'admin_users_admin';?>">
                <div class="col-lg-3 col-md-3 col-sm-6 col-xs-12">
                    <div class="info-box bg-pink hover-expand-effect">
                        <div class="icon">
                            <i class="material-icons">person_add</i>
                        </div>
                        <div class="content">
                            <div class="text">CUSTOMERS (Free)</div>
                            <div class="number count-to" data-from="0" data-to="125" data-speed="15" data-fresh-interval="20">
                                <?php echo $customers; ?>
                            </div>
                        </div>
                    </div>
                </div>
            </a>
            <a href="<?php echo SITE_ADMIN_URL.'admin_users_admin';?>">
                <div class="col-lg-3 col-md-3 col-sm-6 col-xs-12">
                    <div class="info-box bg-cyan hover-expand-effect">
                        <div class="icon">
                            <i class="material-icons">group</i>
                        </div>
                        <div class="content">
                            <div class="text">CUSTOMERS (Paid)</div>
                            <div class="number count-to" data-from="0" data-to="257" data-speed="1000" data-fresh-interval="20">
                                <?php echo $awaitingPayments; ?>
                            </div>
                        </div>
                    </div>
                </div>
            </a>
            <a href="<?php echo SITE_ADMIN_URL.'questions';?>">
                <div class="col-lg-3 col-md-3 col-sm-6 col-xs-12">
                    <div class="info-box bg-light-green hover-expand-effect">
                        <div class="icon">
                            <i class="material-icons">description</i>
                        </div>
                        <div class="content">
                            <div class="text">Questions</div>
                            <div class="number count-to" data-from="0" data-to="243" data-speed="1000" data-fresh-interval="20">
                                <?php echo $ordersCount; ?>
                            </div>
                        </div>
                    </div>
                </div>
            </a>
            <!--<a href="<?php echo SITE_ADMIN_URL.'subscribed_email/index';?>">-->
            <!--    <div class="col-lg-3 col-md-3 col-sm-6 col-xs-12">-->
            <!--        <div class="info-box bg-orange hover-expand-effect">-->
            <!--            <div class="icon">-->
            <!--                <i class="material-icons">playlist_add_check</i>-->
            <!--            </div>-->
            <!--            <div class="content">-->
            <!--                <div class="text">SUBSCRIBED EMAILS</div>-->
            <!--                <div class="number count-to" data-from="0" data-to="1225" data-speed="1000" data-fresh-interval="20">-->
            <!--                    <?php echo $subscribedCount; ?>-->
            <!--                </div>-->
            <!--            </div>-->
            <!--        </div>-->
            <!--    </div>-->
            <!--</a>-->
        </div>
        <!-- #END# Widgets -->

    </div>
</section>

<!-- Jquery Core Js -->
<script src="<?php echo SITE_URL.'/assets/admin/';?>plugins/jquery/jquery.min.js"></script>

<script src="<?php echo SITE_URL.'/assets/admin/';?>plugins/morrisjs/morris.js"></script>
<!-- Flot Charts Plugin Js -->
<script src="<?php echo SITE_URL.'/assets/admin/';?>plugins/flot-charts/jquery.flot.js"></script>
<script src="<?php echo SITE_URL.'/assets/admin/';?>plugins/flot-charts/jquery.flot.resize.js"></script>
<script src="<?php echo SITE_URL.'/assets/admin/';?>plugins/flot-charts/jquery.flot.pie.js"></script>
<script src="<?php echo SITE_URL.'/assets/admin/';?>plugins/flot-charts/jquery.flot.categories.js"></script>
<script src="<?php echo SITE_URL.'/assets/admin/';?>plugins/flot-charts/jquery.flot.time.js"></script>
