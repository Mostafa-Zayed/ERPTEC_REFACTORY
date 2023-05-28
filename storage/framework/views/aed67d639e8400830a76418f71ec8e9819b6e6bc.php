<?php
    $all_notifications = auth()->user()->notifications;
    $unread_notifications = $all_notifications->where('read_at', null);
    $total_unread = count($unread_notifications);
  
    $business = request()->session()->get('user.business_id');
    $user_id = request()->session()->get('user.id');
    
    $package = \Modules\Superadmin\Entities\Subscription::active_subscription($business);
    //$new_orderss = App\NotificationOrder::where('user_id','=',$user_id)->where('business_id','=',$business)->orderby('id','desc')->get()->take(10);
    //$count = App\NotificationOrder::where('read_at',null)->where('user_id','=',$user_id)->where('business_id','=',$business)->orderby('id','desc')->get();
    
    //$affilates = App\User::where('affilate_agent',1)->where('business_id','=',$business)->orderby('id','desc')->get()->take(8);
    
?>

<!-- Notifications: style can be found in dropdown.less -->
<li class="dropdown notifications-menu">
    <a href="#" class="btn btn-default dropdown-toggle load_notifications icon-container d-flex align-items-center justify-content-center" data-toggle="dropdown" id="show_unread_notifications" data-loaded="false">
        <i class="fas fa-bell"></i>
        <span class="badge notifications_count"><?php if(!empty($total_unread)): ?><?php echo e($total_unread, false); ?><?php endif; ?></span>
    </a>
  <ul class="dropdown-menu">
    <!-- <li class="header">You have 10 unread notifications</li> -->
    <li>
      <!-- inner menu: contains the actual data -->

      <ul class="menu" id="notifications_list">
      </ul>
    </li>
    
    <?php if(count($all_notifications) > 10): ?>
      <li class="footer load_more_li">
        <a href="#" class="load_more_notifications"><?php echo app('translator')->getFromJson('lang_v1.load_more'); ?></a>
      </li>
    <?php endif; ?>
  </ul>
</li>

<input type="hidden" id="notification_page" value="1"><?php /**PATH /home/u521976387/domains/erptec.net/public_html/erp/resources/views/layouts/partials/header-notifications.blade.php ENDPATH**/ ?>