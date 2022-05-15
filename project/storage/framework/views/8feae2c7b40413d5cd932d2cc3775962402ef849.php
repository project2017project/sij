        <div class="col-lg-4">
          <div class="user-profile-info-area">
            <ul class="links">
                <?php 

                  if(isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on') 
                  {
                    $link = "https"; 
                  }
                  else
                  {
                    $link = "http"; 
                      
                    // Here append the common URL characters. 
                    $link .= "://"; 
                      
                    // Append the host(domain name, ip) to the URL. 
                    $link .= $_SERVER['HTTP_HOST']; 
                      
                    // Append the requested resource location to the URL 
                    $link .= $_SERVER['REQUEST_URI']; 
                  }      

                ?>
              <li class="<?php echo e($link == route('user-dashboard') ? 'active':''); ?>">
                <a href="<?php echo e(route('user-dashboard')); ?>">
                  <?php echo e($langg->lang200); ?>

                </a>
              </li>
              
              <?php if(Auth::user()->IsVendor()): ?>
                <li>
                  <a href="<?php echo e(route('vendor-dashboard')); ?>">
                    <?php echo e($langg->lang230); ?>

                  </a>
                </li>
              <?php endif; ?>

              <li class="<?php echo e($link == route('user-orders') ? 'active':''); ?>">
                <a href="<?php echo e(route('user-orders')); ?>">
                 My Orders
                </a>
              </li>
			   <li class="<?php echo e($link == route('user-refunds') ? 'active':''); ?>">
                <a href="<?php echo e(route('user-refunds')); ?>">
                 Refund
                </a>
              </li>
			  <li class="<?php echo e($link == route('user-exchange') ? 'active':''); ?>">
                <a href="<?php echo e(route('user-exchange')); ?>">
                 Exchange
                </a>
              </li>

            


             <!-- <li class="<?php echo e($link == route('user-order-track') ? 'active':''); ?>">
                  <a href="<?php echo e(route('user-order-track')); ?>"><?php echo e($langg->lang772); ?></a>
              </li>-->
              
              
               <li class="<?php echo e($link == route('user-order-track') ? 'active':''); ?>">
                  <a href="javascript:;" data-toggle="modal" data-target="#track-order-modal"><?php echo e($langg->lang772); ?></a>
              </li>



           

<!--
              <li class="<?php echo e($link == route('user-message-index') ? 'active':''); ?>">
                  <a href="<?php echo e(route('user-message-index')); ?>"><?php echo e($langg->lang204); ?></a>
              </li>

              <li class="<?php echo e($link == route('user-dmessage-index') ? 'active':''); ?>">
                  <a href="<?php echo e(route('user-dmessage-index')); ?>"><?php echo e($langg->lang250); ?></a>
              </li>-->

              <li class="<?php echo e($link == route('user-profile') ? 'active':''); ?>">
                <a href="<?php echo e(route('user-profile')); ?>">
                  <?php echo e($langg->lang205); ?>

                </a>
              </li>

              <li class="<?php echo e($link == route('user-reset') ? 'active':''); ?>">
                <a href="<?php echo e(route('user-reset')); ?>">
                 <?php echo e($langg->lang206); ?>

                </a>
              </li>

              <li>
                <a href="<?php echo e(route('user-logout')); ?>">
                  <?php echo e($langg->lang207); ?>

                </a>
              </li>

            </ul>
          </div>
        
        </div>