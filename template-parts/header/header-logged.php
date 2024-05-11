<?php
$current_user = wp_get_current_user();
# use get_user_meta to all data

$last_notification = get_user_meta($current_user->ID,"_dci_last_notification", true);

// $link_notification = get_permalink($last_notification);

// if($last_notification){
    ?>
    <!-- <div class="header-notification-alert has-notifications">
        <a href="<?#php echo $link_notification; ?>" aria-label="Notifiche">
            <svg class="svg-bell-solid"><use xmlns:xlink="http://www.w3.org/1999/xlink" xlink:href="#svg-bell-solid"></use></svg>
        </a>
    </div>
    /header-notification-alert -->

<?php
// }

?>

<div class="it-user-wrapper nav-item dropdown">
    <a aria-expanded="false" class="btn btn-primary btn-icon btn-full" data-toggle="dropdown" href="#">
        <span class="rounded-icon">
            <img src="<?php echo dci_get_user_avatar($current_user); ?>" class="border rounded-circle icon-white" alt="<?php echo dci_get_display_name($current_user->ID); ?>" style="max-width:20px;" height="" width="20"/>
        </span>
        <span class="d-none d-lg-block">
            <?php echo dci_get_display_name($current_user->ID); ?>
        </span>
        <svg class="icon icon-white d-none d-lg-block">
        <use
            xlink:href="#it-expand"></use>
        </svg>
    </a>

    </div>
</div>
