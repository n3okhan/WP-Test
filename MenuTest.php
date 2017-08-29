<?php
/*
Plugin Name: Update categories Test
Description: Update categories Test
Author: Farrukh Khan
Author URI: http://farrukhmazhar.com
*/

require_once(ABSPATH . 'wp-admin/includes/taxonomy.php');

// resource address https://www.youtube.com/watch?v=UciopWMTdUM

function get_categories_API(){
    // API source URL
    $url="http://localhost:3000/categories";
    
    // Requesting to API
    $client = curl_init($url);
    curl_setopt($client,CURLOPT_RETURNTRANSFER,1);
    
    // Collecting response from API
    $response=curl_exec($client);
    
    // Decoding API JSON
    $result=json_decode($response, true);

    //Looping json to get the data

        foreach($result as $key => $value){
            //echo $value["id"] . ", " . $value["name"] . ", " . $value["parent_id"] . "<br>";
            //Define the category https://codex.wordpress.org/Function_Reference/wp_insert_category
            if (!empty($value["parent_id"])) {
                    // Setting parent and child relation
                    //echo $value["name"];
                    $parent_id = get_category_by_slug($value["parent_id"]); 
                    //echo $parent_id->term_id;
                    $test_cat = array('cat_name' => $value["name"], 'category_description' => 'test', 'category_nicename' => $value["id"], 'category_parent' => $parent_id->term_id);
                    $my_cat_id = wp_insert_category($test_cat);
                } 
                else { 
                    // Adding parent categories
                    //echo "null";
                    //wp_create_category($value["name"]);
                    $test_cat = array('cat_name' => $value["name"], 'category_description' => 'test', 'category_nicename' => $value["id"], 'category_parent' => '');
                    $my_cat_id = wp_insert_category($test_cat);
                }
            
        }

    // // Hook for adding admin menus https://codex.wordpress.org/Administration_Menus#Sub-Level_Menus
    // add_action('admin_menu', 'mt_add_pages');

    // // action function for above hook
    // function mt_add_pages() {
    //     // Add a new submenu under Settings:
    //     add_options_page(__('Available categories','menu-test'), __('Available categories','menu-test'), 'manage_options', 'testsettings', 'mt_settings_page');
    // }

    // // mt_settings_page() displays the page content for the Test Settings submenu
    // function mt_settings_page() {
    //     echo "<h2>" . __( 'List of categories', 'menu-test' ) . "</h2>";
    //     global $result;
    //     foreach($result as $key => $value){
    //         echo "ID=" . $value["id"] . ", State=" . $value["name"] . ", Parent ID=" . $value["parent_id"] . "<br>";

    //     }
    // }

}



// https://trepmal.com/2011/03/07/add-field-to-general-settings-page/#comment-282873
// $new_general_setting = new new_general_setting();

// class new_general_setting {
//     function new_general_setting( ) {
//         add_filter( 'admin_init' , array( &$this , 'register_fields' ) );
//     }
//     function register_fields() {
//         register_setting( 'general', 'update_categories', 'esc_attr' );
//         add_settings_field('fav_color', '<label for="update_categories">'.__('Update Categories' , 'update_categories' ).'</label>' , array(&$this, 'fields_html') , 'general' );
//     }
//     function fields_html() {
//         $value = get_option( 'update_categories', 'Update categories now' );
//         $adminPage=admin_url( 'admin-post.php' );
//         echo $adminPage;
//         echo '<form action="options-general.php?page=test-button-slug" method="post">';
        
//           // this is a WordPress security feature - see: https://codex.wordpress.org/WordPress_Nonces
//           wp_nonce_field('test_button_clicked');
//           echo '<input type="hidden" value="true" name="test_button" />';
//           submit_button('Update categories now');
//           echo '</form>';
//           alert("Hello World");
          
//     }
// }

//https://stackoverflow.com/questions/8597846/wordpress-plugin-call-function-on-button-click-in-admin-panel
add_action('admin_menu', 'test_button_menu');

function test_button_menu(){
  add_menu_page('Update categories', 'Update Categories', 'manage_options', 'test-button-slug', 'test_button_admin_page');

}

function test_button_admin_page() {

  // This function creates the output for the admin page.
  // It also checks the value of the $_POST variable to see whether
  // there has been a form submission. 

  // The check_admin_referer is a WordPress function that does some security
  // checking and is recommended good practice.

  // General check for user permissions.
  if (!current_user_can('manage_options'))  {
    wp_die( __('You do not have sufficient pilchards to access this page.')    );
  }

  // Start building the page

  echo '<div class="wrap">';

  echo '<h2>Update categories now</h2>';

  // Check whether the button has been pressed AND also check the nonce
  if (isset($_POST['test_button']) && check_admin_referer('test_button_clicked')) {
    // the button has been pressed AND we've passed the security check
    test_button_action();
  }

  echo '<form action="options-general.php?page=test-button-slug" method="post">';

  // this is a WordPress security feature - see: https://codex.wordpress.org/WordPress_Nonces
  wp_nonce_field('test_button_clicked');
  echo '<input type="hidden" value="true" name="test_button" />';
  submit_button('Update categories now');
  echo '</form>';

  echo '</div>';

}


function test_button_action()
{
    //alert("Hello World");
    get_categories_API();
    echo 'Categories Updated';
} 

function alert($msg) {
    echo "<script type='text/javascript'>alert('$msg');</script>";
}

?>
