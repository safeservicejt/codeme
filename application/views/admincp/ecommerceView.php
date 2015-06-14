                
<!-- Panel -->
<div class="panel panel-default">
  <div class="panel-body">


    <!-- Row -->
    <div class="row">
        <div class="col-lg-12">
            <h4><strong>Today:</strong></h4>           
        </div>
    </div>
    <!-- End Row -->

    <!-- Row -->
    <div class="row">
        <div class="col-lg-2">
            <!-- <p><h4>Get Started</h4></p>     -->
        <h4>Orders: <?php echo $orders['today'];?></h4> 
        </div>
        <div class="col-lg-3">
        <h4>Orders Completed: <?php echo $orders['today_completed'];?></h4>                
        </div>

        <div class="col-lg-2">
        <h4>Coupons: <?php echo $coupons['today'];?></h4>          
      </div>

            <div class="col-lg-2">
            <h4>Vouchers: <?php echo $vouchers['today'];?></h4>               
        </div>

            <div class="col-lg-2">
            <h4>Reviews: <?php echo $reviews['today'];?></h4>               
        </div>

  
    </div>
    <!-- End Row -->

    <!-- Row -->
    <div class="row">
                <div class="col-lg-12">
            <hr>           
        </div>
        <div class="col-lg-12">
            <h4><strong>Summary:</strong></h4>           
        </div>        
        <div class="col-lg-3">
            <!-- <p><h4>Get Started</h4></p>     -->
        <h4>Orders</h4> 
        <ul class="ulDashboard">
        <li><a href=""><span class="glyphicon glyphicon-th-large"></span> Today orders: <span id="todayPost"><?php echo $orders['today'];?></span></a></li>
        <li><a href=""><span class="glyphicon glyphicon-th-large"></span> Total orders: <span id="totalPost"><?php echo $orders['total'];?></span></a></li>
        <li><a href=""><span class="glyphicon glyphicon-th-large"></span> Completed orders: <span id="publishPost"><?php echo $orders['completed'];?></span></a></li>
        <li><a href=""><span class="glyphicon glyphicon-th-large"></span> Pending orders: <span id="pendingPost"><?php echo $orders['pending'];?></span></a></li>
        <li><a href=""><span class="glyphicon glyphicon-th-large"></span> Holding orders: <span id="pendingPost"><?php echo $orders['holding'];?></span></a></li>
        <li><a href=""><span class="glyphicon glyphicon-th-large"></span> Cancelled orders: <span id="pendingPost"><?php echo $orders['cancelled'];?></span></a></li>

        </ul> 
        </div>
        <div class="col-lg-3">
        <h4>Products</h4> 
        <ul class="ulDashboard">
        <li><a href=""><span class="glyphicon glyphicon-th-large"></span> Today products: <span id="todayComment"><?php echo $products['today'];?></span></a></li>
       <li><a href=""><span class="glyphicon glyphicon-th-large"></span> Total products: <span id="totalComment"><?php echo $products['total'];?></span></a></li>
        <li><a href=""><span class="glyphicon glyphicon-th-large"></span> Published products: <span id="approvedComment"><?php echo $products['published'];?></span></a></li>
       <li><a href=""><span class="glyphicon glyphicon-th-large"></span> Pending products: <span id="pendingComment"><?php echo $products['pending'];?></span></a></li>

        </ul>  

      </div>
              <div class="col-lg-3">
        <h4>Coupons</h4> 
        <ul class="ulDashboard">
        <li><a href=""><span class="glyphicon glyphicon-th-large"></span> Today coupons: <span id="todayContact"><?php echo $coupons['today'];?></span></a></li>
        <li><a href=""><span class="glyphicon glyphicon-th-large"></span> Total coupons: <span id="totalContact"><?php echo $coupons['total'];?></span></a></li>

        </ul> 
            <h4>Vouchers</h4> 
            <ul class="ulDashboard">
        <li><a href=""><span class="glyphicon glyphicon-th-large"></span> Today vouchers: <span id="todayUsers"><?php echo $vouchers['today'];?></span></a></li>
       <li><a href=""><span class="glyphicon glyphicon-th-large"></span> Total vouchers: <span id="totalUsers"><?php echo $vouchers['total'];?></span></a></li>
       

            </ul>                       
      </div>
            <div class="col-lg-3">
            <h4>Reviews</h4> 
            <ul class="ulDashboard">
        <li><a href=""><span class="glyphicon glyphicon-th-large"></span> Today reviews: <span id="todayUsers"><?php echo $reviews['today'];?></span></a></li>
       <li><a href=""><span class="glyphicon glyphicon-th-large"></span> Total reviews: <span id="totalUsers"><?php echo $reviews['total'];?></span></a></li>
       <li><a href=""><span class="glyphicon glyphicon-th-large"></span> Approved reviews: <span id="totalUsers"><?php echo $reviews['approved'];?></span></a></li>
       <li><a href=""><span class="glyphicon glyphicon-th-large"></span> Pending reviews: <span id="totalUsers"><?php echo $reviews['pending'];?></span></a></li>
       

            </ul>                   
        </div>

  
    </div>
    <!-- End Row -->




  </div>
</div>
 <!-- End panel -->
