<?php
                                     
class VTPRD_Checkbox_classes{
	
	public function __construct(){
		     //look at usernoise admin/settings.php for constructor stuff
	}
     
    /*
    * For the checkbox tax_type, get all the selected values and return in checked_list
    */
    public function vtprd_produce_tax_checked_list ($post_ID, $taxonomy) { 
        $allowed_html = vtprd_get_allowed_html(); //v2.0.3 
        $post_ID =  wp_kses($post_ID ,$allowed_html); //v2.0.3 
        $taxonomy =  wp_kses($taxonomy ,$allowed_html); //v2.0.3 

        $checked_list = wp_get_object_terms($post_ID, $taxonomy, array('fields'=>'ids'));
        return $checked_list;
    }


    /*
    * For the checkbox tax_type, get all the selected values and return in checked_list
    * ONLY works following updates    
    */
    public function vtprd_process_tax_checklist ($post_ID, $taxonomy) { 
        $allowed_html = vtprd_get_allowed_html(); //v2.0.3 
        $post_ID =  wp_kses($post_ID ,$allowed_html); //v2.0.3 
        $taxonomy =  wp_kses($taxonomy ,$allowed_html); //v2.0.3 
        
        $checked_list = wp_get_object_terms($post_ID, $taxonomy, array('fields'=>'ids'));
        return $checked_list;
    }
        
    
            
    public function vtprd_is_product_in_tax_list ($prod_id, $tax_name, $checked_list) { 
        $allowed_html = vtprd_get_allowed_html(); //v2.0.3 
        $prod_id =  wp_kses($prod_id ,$allowed_html); //v2.0.3 
        $tax_name =  wp_kses($tax_name ,$allowed_html); //v2.0.3  
               
        $tax_ids = wp_get_object_terms( $prod_id, $tax_name ); //get all terms within tax this id belongs to 
        $sizeof_tax_ids  = is_array($tax_ids) ? sizeof($tax_ids) : 0; //v2.1.0
        //for($i=0; $i < sizeof($tax_ids); $i++){
        for($i=0; $i < $sizeof_tax_ids; $i++){
            if (strpos($checked_list, $tax_ids[$i])) {   //if cat_id is in previously checked_list
                $selected = true;
                $i = sizeof($tax_ids);
            } 
        }
        if ($selected) {
          return true;
        } else {
          return false;
        }
    }

 
   /*
    *  checked_list (o) - selection list from previous iteration of rule selection                               
    *                           
   */
    public function vtprd_fill_roles_checklist ($tax_class, $checked_list = NULL) { 
        $roles = get_editable_roles();
        $roles['notLoggedIn'] = array( 'name' => 'Not logged in (just visiting)' );
           
        foreach ($roles as $role => $info) {
            $name_translated = translate_user_role( $info['name'] );
            $output  = '<li id='.$role.'>' ;
            $output  .= '<label class="selectit">' ;
            $output  .= '<input id="'.$role.'_'.$tax_class.' " ';
            $output  .= 'type="checkbox" name="tax-input-' .  $tax_class . '[]" ';
            $output  .= 'value="'.$role.'" ';
            if ($checked_list) {
                if (in_array($role, $checked_list)) {   //if cat_id is in previously checked_list       
                   $output  .= 'checked="checked"';
                }               
            }
            $output  .= '>'; //end input statement
            $output  .= '&nbsp;' . $name_translated;
            $output  .= '</label>';
            
            $output  .= '</li>';
            //echo $output ; //v2.0.3
            $allowed_html = vtprd_get_allowed_html(); //v2.0.3
            echo wp_kses($output ,$allowed_html ); //v2.0.3           
         }
        return;   
    } 
    
    /*
    * For the checkbox rolelist, get all the selected values and return in checked_list
    */
    public function vtprd_process_roles_checklist () { 
        if (empty($_REQUEST['rolelist'])) {
            return false;
         }
        
        $checked_list;
        $checkbox = vtprd_sanitize_text_or_array_field($_REQUEST['rolelist']);   //gets all of the selected 'rolelist[]' boxes
        for($i=0; $i < sizeof($checkBox); $i++){
            $checked_list .= $checkBox[$i].'>';   //returns 'value' from checkbox input statement
        } 
        return $checked_list;
    }

   /*
    * For the checkbox list, get all the selected values and return in checked_list
    */
    public function vtprd_checked_list_from_checkboxes ($checkbox) { 
        $checked_list;
        for($i=0; $i < sizeof($checkBox); $i++){
            $checked_list .= $checkBox[$i].'>';   //returns 'value' from checkbox input statement
        } 
        return $checked_list;
    }
            
    public function vtprd_is_user_in_role_list ($checked_list) { 
        if ( !is_user_logged_in() ) {
            return false;
        }
        if (strpos($checked_list, vtprd_get_current_user_role() )) {   //if role is in previously checked_list
          return true;
        } else { 
          return false;
        }

    }

    public function vtprd_get_current_user_role() {
      	global $current_user;     
      	$user_roles = $current_user->roles;
      	$user_role = array_shift($user_roles);     
      	return $user_role;
      }
 
} //end class
