<?php
//Start printaura_additional_user_meta_fields 

// Define the neccessary meta fields:
    function define_printaura_additional_user_fields() {
      $printaura_additional_user_meta_fields = array();
      $printaura_additional_user_meta_fields['access_heat_press_tag'] = 'Access Heatpress';
      $printaura_additional_user_meta_fields['access_pack_in'] = 'Access Packin';
      $printaura_additional_user_meta_fields['access_attach_hang_tag'] = 'Attach Hangtag';
      $printaura_additional_user_meta_fields['access_custom_packaging'] = 'Custom Packing';
      return $printaura_additional_user_meta_fields;
    }

//Create columns and data in the users.php menu:
   
    function printaura_additional_user_fields_columns($defaults) {
      $meta_number = 0;
      $printaura_additional_user_meta_fields = define_printaura_additional_user_fields();
      foreach ($printaura_additional_user_meta_fields as $meta_field_name => $meta_disp_name) {
        $meta_number++;
        $defaults[('printaura-additional-user-fields-usercolumn-' . $meta_number . '')] = __($meta_disp_name, 'user-column');
      }
      return $defaults;
    }
    
    function printaura_additional_user_fields_custom_columns($value, $column_name, $id) {
      $meta_number = 0;
      $printaura_additional_user_meta_fields = define_printaura_additional_user_fields();
      foreach ($printaura_additional_user_meta_fields as $meta_field_name => $meta_disp_name) {
        $meta_number++;
        if( $column_name == ('printaura-additional-user-fields-usercolumn-' . $meta_number . '') ) {
          return get_the_author_meta($meta_field_name, $id );
        }
      }
    }
    
// Populate custom information on the users profile.php and/or edit-user.php pages.  
    
    function printaura_additional_user_fields($user) {
      print('<h3>Enable Branding Options</h3>');
    
      print('<table class="form-table">');
    
      $meta_number = 0;
      $printaura_additional_user_meta_fields = define_printaura_additional_user_fields();
      foreach ($printaura_additional_user_meta_fields as $meta_field_name => $meta_disp_name) {
        $meta_number++;
        print('<tr>');
        print('<th><label for="' . $meta_field_name . '">' . $meta_disp_name . '</label></th>');
        print('<td>');
        print('<input type="checkbox" name="' . $meta_field_name . '" id="' . $meta_field_name . '" value="' . esc_attr( get_the_author_meta($meta_field_name, $user->ID ) ) . '" class="regular-text" /><br />');
        print('<span class="description"></span>');
        print('</td>');
        print('</tr>');
      }
      print('</table>');
    }

// Save changes to user_meta table
    
    function save_printaura_additional_user_fields($user_id) {
    
      if (!current_user_can('edit_user', $user_id))
        return false;
    
      $meta_number = 0;
      $printaura_additional_user_meta_fields = define_printaura_additional_user_fields();
      foreach ($printaura_additional_user_meta_fields as $meta_field_name => $meta_disp_name) {
        $meta_number++;
        update_usermeta( $user_id, $meta_field_name, $_POST[$meta_field_name] );
      }
    }

// Add handles for custom user meta fields.
    
    add_action('edit_user_profile', 'printaura_additional_user_fields');
    add_action('edit_user_profile_update', 'save_printaura_additional_user_fields');
// show in users profile:
   //add_action('show_user_profile', 'printaura_additional_user_fields');
// updates available to user:
   // add_action('personal_options_update', 'save_printaura_additional_user_fields');
// display columns in users menu:
   // add_action('manage_users_custom_column', 'printaura_additional_user_fields_custom_columns', 15, 3);
// filter user menu columns:  
   // add_filter('manage_users_columns', 'printaura_additional_user_fields_columns', 15, 1);    

//End printaura_additional_user_meta_fields
?>
