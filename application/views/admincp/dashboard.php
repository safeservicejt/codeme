                
<!-- Panel -->
<div class="panel panel-default">
  <div class="panel-body">


    <!-- Row -->
    <div class="row">
        <div class="col-lg-12">
            <h4>Welcome to Noblesse CMS</h4>        
        </div>
    </div>
    <!-- End Row -->

    <!-- Row -->
    <div class="row">
        <div class="col-lg-4">
            <!-- <p><h4>Get Started</h4></p>     -->
            <img src="<?php echo ROOT_URL;?>bootstrap/images/logo3128.png" />
        </div>
        <div class="col-lg-4">
            <h4>Next Steps</h4> 
            <ul class="ulDashboard">
            <li><a href="<?php echo ROOT_URL;?>admincp/news/addnew"><span class="glyphicon glyphicon-plus-sign"></span> Write a post</a></li>
            <li><a href="<?php echo ROOT_URL;?>admincp/pages/addnew"><span class="glyphicon glyphicon-th-large"></span> Create a page</a></li>
            <li><a href="<?php echo ROOT_URL;?>admincp/categories"><span class="glyphicon glyphicon-th-list"></span> Manage categories</a></li>

            </ul>                   
        </div>
        <div class="col-lg-4">
            <h4>More Actions</h4>
            <ul class="ulDashboard">
            <li><a href="<?php echo ROOT_URL;?>admincp/setting"><span class="glyphicon glyphicon-cog"></span> Change your system status</a></li>
            <li><a href="<?php echo ROOT_URL;?>admincp/setting"><span class="glyphicon glyphicon-list-alt"></span> Config your site information</a></li>
            <li><a href="<?php echo ROOT_URL;?>admincp/plugins"><span class="glyphicon glyphicon-wrench"></span> Manage plugins</a></li>

            </ul>                   
        </div>

    </div>
    <!-- End Row -->




  </div>
</div>
 <!-- End panel -->
<!-- Panel -->
<div class="panel panel-default">
  <div class="panel-body">


    <!-- Row -->
    <div class="row">
        <div class="col-lg-12">
            <h4>News feed:</h4>           
        </div>
    </div>
    <!-- End Row -->

    <!-- Row -->
    <div class="row">
<div id="fb-root"></div>
<script>(function(d, s, id) {
  var js, fjs = d.getElementsByTagName(s)[0];
  if (d.getElementById(id)) return;
  js = d.createElement(s); js.id = id;
  js.src = "//connect.facebook.net/en_US/sdk.js#xfbml=1&appId=882186538492766&version=v2.0";
  fjs.parentNode.insertBefore(js, fjs);
}(document, 'script', 'facebook-jssdk'));</script>    
        <div class="col-lg-6">
<div class="fb-post" data-href="https://www.facebook.com/permalink.php?story_fbid=858563977529771&id=858562830863219" data-width="500"></div>              
 
        </div>
        <div class="col-lg-6">


<div class="fb-post" data-href="https://www.facebook.com/permalink.php?story_fbid=1600068756891459&id=1600068363558165" data-width="500"></div>              
      </div>

  
    </div>
    <!-- End Row -->




  </div>
</div>
 <!-- End panel -->

<!-- Panel -->
<div class="panel panel-default">
  <div class="panel-body">


    <!-- Row -->
    <div class="row">
        <div class="col-lg-12">
            <h4>Statitics:</h4>           
        </div>
    </div>
    <!-- End Row -->

    <!-- Row -->
    <div class="row">
        <div class="col-lg-3">
            <!-- <p><h4>Get Started</h4></p>     -->
        <h4>Post</h4> 
        <ul class="ulDashboard">
        <li><a href=""><span class="glyphicon glyphicon-th-large"></span> Today post: <span id="todayPost"><?php echo $post['today'];?></span></a></li>
        <li><a href=""><span class="glyphicon glyphicon-th-large"></span> Total post: <span id="totalPost"><?php echo $post['total'];?></span></a></li>
        <li><a href=""><span class="glyphicon glyphicon-th-large"></span> Pubished posts: <span id="publishPost"><?php echo $post['published'];?></span></a></li>
        <li><a href=""><span class="glyphicon glyphicon-th-large"></span> Pending posts: <span id="pendingPost"><?php echo $post['pending'];?></span></a></li>
  
        </ul> 
        </div>
        <div class="col-lg-3">
        <h4>Comments</h4> 
        <ul class="ulDashboard">
        <li><a href=""><span class="glyphicon glyphicon-th-large"></span> Today comments: <span id="todayComment"><?php echo $comments['today'];?></span></a></li>
       <li><a href=""><span class="glyphicon glyphicon-th-large"></span> Total comments: <span id="totalComment"><?php echo $comments['total'];?></span></a></li>
        <li><a href=""><span class="glyphicon glyphicon-th-large"></span> Approved comments: <span id="approvedComment"><?php echo $comments['approved'];?></span></a></li>
       <li><a href=""><span class="glyphicon glyphicon-th-large"></span> Pending comments: <span id="pendingComment"><?php echo $comments['pending'];?></span></a></li>

        </ul>               
      </div>
              <div class="col-lg-3">
        <h4>Contacts</h4> 
        <ul class="ulDashboard">
        <li><a href=""><span class="glyphicon glyphicon-th-large"></span> Today contacts: <span id="todayContact"><?php echo $contactus['today'];?></span></a></li>
        <li><a href=""><span class="glyphicon glyphicon-th-large"></span> Total contacts: <span id="totalContact"><?php echo $contactus['total'];?></span></a></li>

        </ul>               
      </div>
            <div class="col-lg-3">
            <h4>Users</h4> 
            <ul class="ulDashboard">
        <li><a href=""><span class="glyphicon glyphicon-th-large"></span> Today users: <span id="todayUsers"><?php echo $users['today'];?></span></a></li>
       <li><a href=""><span class="glyphicon glyphicon-th-large"></span> Total users: <span id="totalUsers"><?php echo $users['total'];?></span></a></li>
       

            </ul>                   
        </div>

  
    </div>
    <!-- End Row -->




  </div>
</div>
 <!-- End panel -->
