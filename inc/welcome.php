<?php

require get_template_directory() . '/inc/lib/parsedown.php';

/**
 * Welcome page
 */
remove_action('welcome_panel', 'wp_welcome_panel');
add_action( 'welcome_panel', 'dci_welcome_panel' );
function dci_welcome_panel(){
    ?>
    <div class="welcome-panel-content" style="padding-bottom:30px;">
        <img src="<?php echo get_template_directory_uri() . '/assets/img/designers-italia-wordpress-dashboard.png'?>"  style="width: 10%; margin: 0 auto;" />
        <img src="<?php echo get_template_directory_uri() . '/assets/img/logo-point.png'?>"  style="margin: 0 auto; width:10%;" />
        <h2 style="color: #fff; font-size: 24px; text-align:center"><?php _e( 'Tema basato su Design Comuni Italia: il tema di Developers Italia per i Comuni Italiani', "design_comuni_italia" ); ?></h2>
        <a href="https://p-service.it" style="text-align:center;"><button type="button" class="button button-primary" style="text-align:center;margin:0auto;">Sito Web</button></a>
        <a href="https://www.servizipa.com/guide/pointservice/" style="text-align:center;"><button type="button" class="button button-primary" style="text-align:center;margin:0auto;">Link alle Guide</button></a>
    </div>
    <?php
}

function dci_welcome_init() {
    global $wpdb;
    $wpdb->update($wpdb->usermeta,array('meta_value'=>1),array('meta_key'=>'show_welcome_panel'));
}
add_action('after_switch_theme','dci_welcome_init');

/**
 * Gestione widget dashboard admin
 *
 */
// Add a new widget to the dashboard using a custom function
add_action( 'wp_dashboard_setup', 'dci_add_dashboard_widgets' );
// Register the new dashboard widget with the 'wp_dashboard_setup' action
function dci_add_dashboard_widgets() {
    wp_add_dashboard_widget(
        'dci_dashboard_widget', // Widget slug
        'Tema Point Service S.r.l', // Widget title
        'dci_new_dashboard_widget_function' // Function name to display the widget
    );
}
// Initialize the function to output the contents of your new dashboard widget
function dci_new_dashboard_widget_function() {
    echo "Basato su Design Comuni Italia: il tema di Developers Italia per i Comuni Italiani ";
}

/**
 * Mostra solo i metabox del progetto
 */
function dci_remove_all_dashboard_meta_boxes()
{
    global $wp_meta_boxes;

    $keep_boxes = array();
    foreach ($wp_meta_boxes['dashboard']['normal']['core'] as $wp_meta_box) {
        if (substr($wp_meta_box["id"], 0, 4) == "dci_") {
            $keep_boxes[] = $wp_meta_box;
        }
    }
    $wp_meta_boxes['dashboard']['normal']['core'] = $keep_boxes;

    $keep_boxes = array();
    foreach ($wp_meta_boxes['dashboard']['side']['core'] as $wp_meta_box) {
        if (substr($wp_meta_box["id"], 0, 4) == "dci_") {
            $keep_boxes[] = $wp_meta_box;
        }
    }
    $wp_meta_boxes['dashboard']['side']['core'] = $keep_boxes;
}
add_action('wp_dashboard_setup', 'dci_remove_all_dashboard_meta_boxes', 100 );

/**
 * Forzo a 2 colonne la dashboard admin
 * @param $columns
 * @return mixed
 */
function dci_screen_layout_columns($columns) {
    $columns['dashboard'] = 2;
    return $columns;
}
add_filter('screen_layout_columns', 'dci_screen_layout_columns');

function dci_screen_layout_dashboard() {
    return 2;
}
add_filter('get_user_option_screen_layout_dashboard', 'dci_screen_layout_dashboard');

add_action ('admin_menu', function () {
  //  add_management_page('Manuale Tema Comuni', 'Manuale Tema Comuni', 'read', 'manuale-comuni', 'dci_readme_render_manual', '');
});

function dci_readme_render_manual(){
echo '<div class="wrap manuale">';

    $response = wp_remote_get( 'https://raw.githubusercontent.com/italia/design-comuni-wordpress-theme/master/README.md?test=1' );

    if ( is_array( $response ) && ! is_wp_error( $response ) ) {

        $body    = $response['body']; // use the content
        $Parsedown = new Parsedown();
        echo $Parsedown->text($body);

    }

echo "</div>";
}
add_action('admin_bar_menu', 'dci_add_toolbar_manual', 100);
function dci_add_toolbar_manual($admin_bar)
{
    $admin_bar->add_menu(array(
        'id' => 'manuale',
        'title' => 'Manuale',
        'href' => 'https://www.servizipa.com/guide/pointservice',
        'meta' => array(
            'title' => __('Manuale'),
            'target' => '_blank'
        ),
    ));
}

