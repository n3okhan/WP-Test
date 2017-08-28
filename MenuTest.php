<?php
   require_once(ABSPATH . 'wp-admin/includes/taxonomy.php');
/*
Plugin Name: Update categories now Test
Description: Update categories now Test
Author: Codex authors
Author URI: http://farrukhmazhar.com
*/
// resource address https://www.youtube.com/watch?v=UciopWMTdUM
$url="http://localhost:3000/categories";

// send request to resource
$client = curl_init($url);
curl_setopt($client,CURLOPT_RETURNTRANSFER,1);
// get response from resource
$response=curl_exec($client);
// decode
$result=json_decode($response, true);

//action

    foreach($result as $key => $value){
        //echo $value["id"] . ", " . $value["name"] . ", " . $value["parent_id"] . "<br>";
        //Define the category https://codex.wordpress.org/Function_Reference/wp_insert_category
        if (!empty($value["parent_id"])) {
                echo $value["name"];
                $test_cat = array('cat_name' => $value["name"], 'category_description' => 'test', 'category_nicename' => $value["name"], 'category_parent' => 'State');
                $my_cat_id = wp_insert_category($test_cat);
            } 
            else { 
            echo "null";
                $test_cat = array('cat_name' => $value["name"], 'category_description' => 'test', 'category_nicename' => $value["name"], 'category_parent' => '');
                $my_cat_id = wp_insert_category($test_cat);
            }
        
    }

// Hook for adding admin menus https://codex.wordpress.org/Administration_Menus#Sub-Level_Menus
add_action('admin_menu', 'mt_add_pages');

// action function for above hook
function mt_add_pages() {
    // Add a new submenu under Settings:
    add_options_page(__('Available categories','menu-test'), __('Available categories','menu-test'), 'manage_options', 'testsettings', 'mt_settings_page');
}

// mt_settings_page() displays the page content for the Test Settings submenu
function mt_settings_page() {
    echo "<h2>" . __( 'List of categories', 'menu-test' ) . "</h2>";
    global $result;
    foreach($result as $key => $value){
        echo "ID=" . $value["id"] . ", State=" . $value["name"] . ", Parent ID=" . $value["parent_id"] . "<br>";

    }
}


// https://trepmal.com/2011/03/07/add-field-to-general-settings-page/#comment-282873
$new_general_setting = new new_general_setting();

class new_general_setting {
    function new_general_setting( ) {
        add_filter( 'admin_init' , array( &$this , 'register_fields' ) );
    }
    function register_fields() {
        register_setting( 'general', 'update_categories', 'esc_attr' );
        add_settings_field('fav_color', '<label for="update_categories">'.__('Update Categories' , 'update_categories' ).'</label>' , array(&$this, 'fields_html') , 'general' );
    }
    function fields_html() {
        $value = get_option( 'update_categories', 'Update categories now' );
        echo '<input type="button" id="update_categories" name="update_categories" value="' . $value . '" />';
    }
}

?>
