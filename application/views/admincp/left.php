
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
                <a class="navbar-brand" href="<?php echo ROOT_URL;?>" target="_blank">Home</a>

            </div>
            <!-- Top Menu Items -->
            <ul class="nav navbar-left top-nav">
               <li class="dropdown">
                <a href="#" class="dropdown-toggle" data-toggle="dropdown"><span class="glyphicon glyphicon-th"></span>&nbsp;&nbsp;Add new <span class="caret"></span></a>
                <ul class="dropdown-menu" role="menu">
                  <li><a href="<?php echo ADMINCP_URL;?>categories">Category</a></li>
                 <li><a href="<?php echo ADMINCP_URL;?>pages/addnew">Page</a></li>
                 <li><a href="<?php echo ADMINCP_URL;?>post/addnew">Post</a></li>

                </ul>
              </li>
              <li class="dropdown">
                <a href="#" class="dropdown-toggle" data-toggle="dropdown"><span class="glyphicon glyphicon-th"></span>&nbsp;&nbsp;Ecommerce <span class="caret"></span></a>
                <ul class="dropdown-menu" role="menu">
                  <li><a href="<?php echo ADMINCP_URL;?>products/addnew">Add new product</a></li>
                 <li><a href="<?php echo ADMINCP_URL;?>manufacturers/addnew">Add new manufacturer</a></li>
                 <li><a href="<?php echo ADMINCP_URL;?>downloads/addnew">Add new download</a></li>
                 <li><a href="<?php echo ADMINCP_URL;?>vouchers/addnew">Add new gift vouchers</a></li>
                 <li><a href="<?php echo ADMINCP_URL;?>coupons/addnew">Add new coupons</a></li>

                </ul>
              </li>
              
            </ul>


            <!-- Top Menu Items -->
            <ul class="nav navbar-right top-nav">
                
    
                <li class="dropdown">
                    <a href="#" class="dropdown-toggle" data-toggle="dropdown"><i class="fa fa-user"></i> <?php echo Cookie::get('firstname').' '.Cookie::get('lastname');?> <b class="caret"></b></a>
                    <ul class="dropdown-menu">
                        <li>
                            <a href="<?php echo ADMINCP_URL;?>logout"><i class="fa fa-fw fa-power-off"></i> Log Out</a>
                        </li>
                    </ul>
                </li>
            </ul>

            <!-- Sidebar Menu Items - These collapse to the responsive navigation menu on small screens -->
            <div class="collapse navbar-collapse navbar-ex1-collapse">
                <ul class="nav navbar-nav side-nav">
                    <li>
                        <a href="<?php echo ADMINCP_URL;?>"><span class="glyphicon glyphicon-globe"></span> Dashboard</a></a>
                    </li>
                    <li>
                        <a href="javascript:;" data-toggle="collapse" data-target="#ecommerce"><span class="glyphicon glyphicon-shopping-cart"></span> Ecommerce <i class="fa fa-fw fa-caret-down"></i></a>
                        <ul id="ecommerce" class="collapse">
                          <li><a href="<?php echo ADMINCP_URL;?>ecommerce">Statistics</a></li>
                          <!-- <li><a href="<?php echo ADMINCP_URL;?>affiliates">Affiliates</a></li> -->
                          <li><a href="<?php echo ADMINCP_URL;?>coupons">Coupons</a></li>
                          <li><a href="<?php echo ADMINCP_URL;?>currency">Currency</a></li>
                          <li><a href="<?php echo ADMINCP_URL;?>downloads">Downloads</a></li>
                          <li><a href="<?php echo ADMINCP_URL;?>vouchers">Gift Vouchers</a></li>
                         <li><a href="<?php echo ADMINCP_URL;?>manufacturers">Manufacturers</a></li>
                           <li><a href="<?php echo ADMINCP_URL;?>products">Product</a></li>
                           <li><a href="<?php echo ADMINCP_URL;?>paymentmethods">Payment Methods</a></li>
                            <li><a href="<?php echo ADMINCP_URL;?>reviews">Reviews</a></li>
                         <!-- <li><a href="<?php echo ADMINCP_URL;?>requestpayment">Request Payments</a> </li>        -->
                         <li><a href="<?php echo ADMINCP_URL;?>orders">Orders</a></li>
                         <li><a href="<?php echo ADMINCP_URL;?>taxrate">Tax Rate</a></li>
                         

                        </ul>
                    </li>                    
                    <li>
                        <a href="<?php echo ADMINCP_URL;?>categories"><span class="glyphicon glyphicon-list-alt"></span> Categories</a>
                    </li>

                    <li>
                        <a href="javascript:;" data-toggle="collapse" data-target="#post"><span class="glyphicon glyphicon-file"></span> Post <i class="fa fa-fw fa-caret-down"></i></a>
                        <ul id="post" class="collapse">
                        <li><a href="<?php echo ADMINCP_URL;?>post">List post</a></li>
                         <li><a href="<?php echo ADMINCP_URL;?>post/status/pending">Pending</a></li>

                      <li><a href="<?php echo ADMINCP_URL;?>post/addnew">Add new</a></li>
                          <li><a href="<?php echo ADMINCP_URL;?>comments">Comments</a></li>

                        </ul>
                    </li>
                    <li>
                        <a href="javascript:;" data-toggle="collapse" data-target="#page"><span class="glyphicon glyphicon-th-large"></span> Page <i class="fa fa-fw fa-caret-down"></i></a>
                        <ul id="page" class="collapse">
                         <li><a href="<?php echo ADMINCP_URL;?>pages">List page</a></li>
                         <li><a href="<?php echo ADMINCP_URL;?>pages/addnew">Add new</a></li>

                        </ul>
                    </li>

                    <li>
                        <a href="javascript:;" data-toggle="collapse" data-target="#users"><span class="glyphicon glyphicon-user"></span> Users <i class="fa fa-fw fa-caret-down"></i></a>
                        <ul id="users" class="collapse">
                         <li><a href="<?php echo ADMINCP_URL;?>users">List users</a></li>

                        </ul>
                    </li>
                    <li>
                        <a href="javascript:;" data-toggle="collapse" data-target="#usergroup"><span class="glyphicon glyphicon-user"></span> User Groups <i class="fa fa-fw fa-caret-down"></i></a>
                        <ul id="usergroup" class="collapse">
                         <li><a href="<?php echo ADMINCP_URL;?>usergroups">List groups</a></li>
                         <li><a href="<?php echo ADMINCP_URL;?>usergroups/addnew">Add new</a></li>

                        </ul>
                    </li>


                    <li>
                        <a href="<?php echo ADMINCP_URL;?>contacts"><span class="glyphicon glyphicon-comment"></span> Contacts</a>
                    </li>
                    <li>
                        <a href="javascript:;" data-toggle="collapse" data-target="#appearance"><span class="glyphicon glyphicon-th"></span> Appearance <i class="fa fa-fw fa-caret-down"></i></a>
                        <ul id="appearance" class="collapse">
                          <li><a href="<?php echo ADMINCP_URL;?>theme">Theme</a></li>
                          <!-- <li><a href="<?php echo ADMINCP_URL;?>widgets">Widgets</a></li> -->
                              <li><a href="<?php echo ADMINCP_URL;?>theme/filemanager">File Manager</a>
                          <li><a href="<?php echo ADMINCP_URL;?>templatestore">Themes Store</a></li>      
                          <li><a href="<?php echo ADMINCP_URL;?>theme/import">Import</a></li>  
                        </ul>
                    </li>
                     <li>
                        <a href="javascript:;" data-toggle="collapse" data-target="#plugins"><span class="glyphicon glyphicon-wrench"></span> Plugins <i class="fa fa-fw fa-caret-down"></i></a>
                        <ul id="plugins" class="collapse">
                            <li><a href="<?php echo ADMINCP_URL;?>plugins">List Plugins</a></li>
                              <li><a href="<?php echo ADMINCP_URL;?>pluginstore">Plugins Store</a></li>
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

                    <?php Render::cpanel_menu('admincp_menu');?>

                </ul>
            </div>
            <!-- /.navbar-collapse -->
        </nav>

        <div id="page-wrapper">    
          <div class="container-fluid">            

                <!-- Page Heading -->
                <div class="row">
                    <div class="col-lg-12">          