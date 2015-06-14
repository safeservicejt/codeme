
        <!-- Navigation -->
        <nav class="navbar navbar-inverse navbar-fixed-top" role="navigation">
            <!-- Brand and toggle get grouped for better mobile display -->
            <div class="navbar-header">
                <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-ex1-collapse">
                    <span class="sr-only">Toggle navigation</span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                </button>
                <a class="navbar-brand" href="index.html" target="_blank">Home</a>
            </div>



            <!-- Top Menu Items -->
            <ul class="nav navbar-right top-nav">
                <li class="dropdown">
                    <a href="#" class="dropdown-toggle" data-toggle="dropdown"><i class="fa fa-envelope"></i> <b class="caret"></b></a>
                    <ul class="dropdown-menu message-dropdown">
                        <li class="message-preview">
                            <a href="#">
                                <div class="media">
                                    <span class="pull-left">
                                        <img class="media-object" src="http://placehold.it/50x50" alt="">
                                    </span>
                                    <div class="media-body">
                                        <h5 class="media-heading"><strong>John Smith</strong>
                                        </h5>
                                        <p class="small text-muted"><i class="fa fa-clock-o"></i> Yesterday at 4:32 PM</p>
                                        <p>Lorem ipsum dolor sit amet, consectetur...</p>
                                    </div>
                                </div>
                            </a>
                        </li>
                        <li class="message-preview">
                            <a href="#">
                                <div class="media">
                                    <span class="pull-left">
                                        <img class="media-object" src="http://placehold.it/50x50" alt="">
                                    </span>
                                    <div class="media-body">
                                        <h5 class="media-heading"><strong>John Smith</strong>
                                        </h5>
                                        <p class="small text-muted"><i class="fa fa-clock-o"></i> Yesterday at 4:32 PM</p>
                                        <p>Lorem ipsum dolor sit amet, consectetur...</p>
                                    </div>
                                </div>
                            </a>
                        </li>
                        <li class="message-preview">
                            <a href="#">
                                <div class="media">
                                    <span class="pull-left">
                                        <img class="media-object" src="http://placehold.it/50x50" alt="">
                                    </span>
                                    <div class="media-body">
                                        <h5 class="media-heading"><strong>John Smith</strong>
                                        </h5>
                                        <p class="small text-muted"><i class="fa fa-clock-o"></i> Yesterday at 4:32 PM</p>
                                        <p>Lorem ipsum dolor sit amet, consectetur...</p>
                                    </div>
                                </div>
                            </a>
                        </li>
                        <li class="message-footer">
                            <a href="#">Read All New Messages</a>
                        </li>
                    </ul>
                </li>
                <li class="dropdown">
                    <a href="#" class="dropdown-toggle" data-toggle="dropdown"><i class="fa fa-bell"></i> <b class="caret"></b></a>
                    <ul class="dropdown-menu alert-dropdown">
                        <li>
                            <a href="#">Alert Name <span class="label label-default">Alert Badge</span></a>
                        </li>
                        <li>
                            <a href="#">Alert Name <span class="label label-primary">Alert Badge</span></a>
                        </li>
                        <li>
                            <a href="#">Alert Name <span class="label label-success">Alert Badge</span></a>
                        </li>
                        <li>
                            <a href="#">Alert Name <span class="label label-info">Alert Badge</span></a>
                        </li>
                        <li>
                            <a href="#">Alert Name <span class="label label-warning">Alert Badge</span></a>
                        </li>
                        <li>
                            <a href="#">Alert Name <span class="label label-danger">Alert Badge</span></a>
                        </li>
                        <li class="divider"></li>
                        <li>
                            <a href="#">View All</a>
                        </li>
                    </ul>
                </li>
                <li class="dropdown">
                    <a href="#" class="dropdown-toggle" data-toggle="dropdown"><i class="fa fa-user"></i> John Smith <b class="caret"></b></a>
                    <ul class="dropdown-menu">
                        <li>
                            <a href="#"><i class="fa fa-fw fa-user"></i> Profile</a>
                        </li>
                        <li>
                            <a href="#"><i class="fa fa-fw fa-envelope"></i> Inbox</a>
                        </li>
                        <li>
                            <a href="#"><i class="fa fa-fw fa-gear"></i> Settings</a>
                        </li>
                        <li class="divider"></li>
                        <li>
                            <a href="#"><i class="fa fa-fw fa-power-off"></i> Log Out</a>
                        </li>
                    </ul>
                </li>
            </ul>

            <!-- Sidebar Menu Items - These collapse to the responsive navigation menu on small screens -->
            <div class="collapse navbar-collapse navbar-ex1-collapse">
                <ul class="nav navbar-nav side-nav">
                    <li>
                        <a href="index.html"><span class="glyphicon glyphicon-globe"></span> Dashboard</a></a>
                    </li>
                    <li>
                        <a href="javascript:;" data-toggle="collapse" data-target="#ecommerce"><span class="glyphicon glyphicon-shopping-cart"></span> Ecommerce <i class="fa fa-fw fa-caret-down"></i></a>
                        <ul id="ecommerce" class="collapse">
                          <li><a href="products">Statistics</a></li>
                           <li><a href="products">Product</a></li>

                         <li><a href="manufacturers">Manufacturers</a></li>
                          <li><a href="downloads">Downloads</a></li>
                            <li><a href="reviews">Reviews</a></li>
                         <li><a href="paymentmethods">Payment Methods</a></li>
                         <li><a href="requestpayment">Request Payments</a> </li>       
                         <li><a href="orders">Orders</a></li>
                         <li><a href="affiliates">Affiliates</a></li>
                         <li><a href="giftvouchers">Gift Vouchers</a></li>
                         <li><a href="coupons">Coupons</a></li>
                         <li><a href="taxrate">Tax Rate</a></li>
                         <li><a href="currency">Currency</a></li>

                        </ul>
                    </li>                    
                    <li>
                        <a href="charts.html"><span class="glyphicon glyphicon-list-alt"></span> Categories</a>
                    </li>

                    <li>
                        <a href="javascript:;" data-toggle="collapse" data-target="#post"><span class="glyphicon glyphicon-file"></span> Post <i class="fa fa-fw fa-caret-down"></i></a>
                        <ul id="post" class="collapse">
                      <li><a href="<?php echo ADMINCP_URL;?>news/addnew">Add new</a></li>
                          <li><a href="<?php echo ADMINCP_URL;?>comments">Comments</a></li>

                        </ul>
                    </li>
                    <li>
                        <a href="javascript:;" data-toggle="collapse" data-target="#page"><span class="glyphicon glyphicon-th-large"></span> Page <i class="fa fa-fw fa-caret-down"></i></a>
                        <ul id="page" class="collapse">
                         <li><a href="<?php echo ADMINCP_URL;?>pages/addnew">Add new</a></li>

                        </ul>
                    </li>

                    <li>
                        <a href="javascript:;" data-toggle="collapse" data-target="#users"><span class="glyphicon glyphicon-user"></span> Users <i class="fa fa-fw fa-caret-down"></i></a>
                        <ul id="users" class="collapse">
                         <li><a href="<?php echo ADMINCP_URL;?>pages/addnew">Add new</a></li>

                        </ul>
                    </li>
                    <li>
                        <a href="javascript:;" data-toggle="collapse" data-target="#usergroup"><span class="glyphicon glyphicon-user"></span> User Groups <i class="fa fa-fw fa-caret-down"></i></a>
                        <ul id="usergroup" class="collapse">
                         <li><a href="<?php echo ADMINCP_URL;?>pages/addnew">Add new</a></li>

                        </ul>
                    </li>


                    <li>
                        <a href="forms.html"><span class="glyphicon glyphicon-comment"></span> Contacts</a>
                    </li>
                    <li>
                        <a href="javascript:;" data-toggle="collapse" data-target="#appearance"><span class="glyphicon glyphicon-th"></span> Appearance <i class="fa fa-fw fa-caret-down"></i></a>
                        <ul id="appearance" class="collapse">
                          <li><a href="<?php echo ADMINCP_URL;?>theme">Theme</a></li>
                              <li><a href="<?php echo ADMINCP_URL;?>filemanager">File Manager</a>
                          <li><a href="<?php echo ADMINCP_URL;?>templatestore">Themes Store</a></li>      
                          <li><a href="<?php echo ADMINCP_URL;?>theme/import">Import</a></li>  
                        </ul>
                    </li>
                     <li>
                        <a href="javascript:;" data-toggle="collapse" data-target="#plugins"><span class="glyphicon glyphicon-wrench"></span> Plugins <i class="fa fa-fw fa-caret-down"></i></a>
                        <ul id="plugins" class="collapse">
                              <li><a href="<?php echo ADMINCP_URL;?>pluginstore">Plugins Store</a></li>
                                  <li><a href="<?php echo ADMINCP_URL;?>plugins/layouts">Layouts</a></li>
                                  <li><a href="<?php echo ADMINCP_URL;?>plugins/import">Import</a></li>
                        </ul>
                    </li>

                       <li>
                        <a href="javascript:;" data-toggle="collapse" data-target="#setting"><span class="glyphicon glyphicon-cog"></span> Setting <i class="fa fa-fw fa-caret-down"></i></a>
                        <ul id="setting" class="collapse">
                              <li><a href="<?php echo ADMINCP_URL;?>setting">General</a></li>

                              <li><a href="<?php echo ADMINCP_URL;?>setting/ecommerce">Ecommerce</a></li>
                              <li><a href="<?php echo ADMINCP_URL;?>setting/mailsystem">Mail System</a></li>
                        </ul>
                    </li>

                </ul>
            </div>
            <!-- /.navbar-collapse -->
        </nav>

        <div id="page-wrapper">    
          <div class="container-fluid">            

                <!-- Page Heading -->
                <div class="row">
                    <div class="col-lg-12">          