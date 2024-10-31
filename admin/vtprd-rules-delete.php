<?php                         
class VTPRD_Rule_delete {
	
	public function __construct(){
     
    }
    
  public  function vtprd_delete_rule () {
    global $post, $vtprd_info, $vtprd_rules_set, $vtprd_rule;
    $post_id = $post->ID;  
    
     
       
    $vtprd_temp_rules_set = array();

    //v2.1.0 begin - PHP 8.0 was kicking this out as a non-array
    //$vtprd_rules_set   = get_option( 'vtprd_rules_set' ) ;
    $vtprd_rules_set = vtprd_get_rules_set();
    //v2.1.0 end 

  //error_log( print_r(  ' ' , true ) );
  //error_log( print_r(  'function vtprd_delete_rule, delete postID=  ' .$post_id, true ) );
  //error_log( print_r(  '$vtprd_rules_set BEFORE delete= ' , true ) ); 
  //error_log( var_export($vtprd_rules_set, true ) ); 
     
    $sizeof_rules_set = is_array($vtprd_rules_set) ? sizeof($vtprd_rules_set) : 0; //v2.1.0     
    for($i=0; $i < $sizeof_rules_set; $i++) {       //v2.1.0 
       //load up temp_rule_set with every rule *except* the one to be deleted
       if ($vtprd_rules_set[$i]->post_id != $post_id) {
          $vtprd_temp_rules_set[] = $vtprd_rules_set[$i];
       }
    }


    //v1.1.0.5 begin
    //If no more rules posts, delete the rules_set
    global $wpdb;
    $contentSearch = 'vtprd-rule'; //v2.0.3 - $wpdb->prepare REQUIRES a variable in the sql.
    $varsql = $wpdb->prepare( "SELECT posts.`id`
		FROM `".$wpdb->posts."` AS posts			
		WHERE posts.`post_type`= %s ;",
               $contentSearch        
            );       
                               
  	$rule_id_list = $wpdb->get_col($varsql);
    
    $sizeof_rule_id_list = is_array($rule_id_list) ? sizeof($rule_id_list) : 0; //v2.1.0 
    if ($sizeof_rule_id_list == 0) {
      delete_option( 'vtprd_rules_set' );
      return;
    }
    //v1.1.0.5 end

    $vtprd_rules_set = $vtprd_temp_rules_set;
    
  //error_log( print_r(  '$vtprd_rules_set AFTER delete= ' , true ) ); 
  //error_log( var_export($vtprd_rules_set, true ) );    
   
    $sizeof_rules_set = is_array($vtprd_rules_set) ? sizeof($vtprd_rules_set) : 0; //v2.1.0
    if ($sizeof_rules_set == 0) {
      delete_option( 'vtprd_rules_set' );
  //error_log( print_r(  '$vtprd_rules_set DELETED ' , true ) );
    } else {
      //v2.1.0 begin - PHP 8.0 was kicking this out as a non-array
      //update_option( 'vtprd_rules_set', $vtprd_rules_set );
      vtprd_set_rules_set($vtprd_rules_set);
      //v2.1.0 end     
    }
 }  
 
  /* Change rule status to 'pending'
        if status is 'pending', the rule will not be executed during cart processing 
  */ 
  public  function vtprd_trash_rule () {
    global $post, $vtprd_info, $vtprd_rules_set, $vtprd_rule;
    $post_id = $post->ID;    
    //v2.1.0 begin - PHP 8.0 was kicking this out as a non-array
    //$vtprd_rules_set   = get_option( 'vtprd_rules_set' ) ;
    $vtprd_rules_set = vtprd_get_rules_set();
    //v2.1.0 end 
    
    $sizeof_rules_set = is_array($vtprd_rules_set) ? sizeof($vtprd_rules_set) : 0; //v2.1.0 
    for($i=0; $i < $sizeof_rules_set; $i++) {  //v2.1.0
       if ($vtprd_rules_set[$i]->post_id == $post_id) {
          if ( $vtprd_rules_set[$i]->rule_status =  'publish' ) {    //only update if necessary, may already be pending
            $vtprd_rules_set[$i]->rule_status =  'pending';
		        //v2.1.0 begin - PHP 8.0 was kicking this out as a non-array
		        //update_option( 'vtprd_rules_set', $vtprd_rules_set );
		        vtprd_set_rules_set($vtprd_rules_set);
		        //v2.1.0 end 
          }
          $i =  $sizeof_rules_set; //set to done   //v2.1.0 
       }
    }
 
    $sizeof_rules_set = is_array($vtprd_rules_set) ? sizeof($vtprd_rules_set) : 0; //v2.1.0
    if ($sizeof_rules_set == 0) {
    //if (count($vtprd_rules_set) == 0) {
      delete_option( 'vtprd_rules_set' );
    } else {
      //v2.1.0 begin - PHP 8.0 was kicking this out as a non-array
      //update_option( 'vtprd_rules_set', $vtprd_rules_set );
      vtprd_set_rules_set($vtprd_rules_set);
      //v2.1.0 end 
    }    


    //v2.0.0 begin M solution
    //**************
    //keep a running track of ruleset_has_a_display_rule   ==> used in apply-rules processing
    //*************    
    // added in test for rule_status == 'publish'
    $ruleset_has_a_display_rule = 'no';
    $ruleset_contains_auto_add_free_product = 'no';
    $ruleset_contains_auto_add_free_coupon_initiated_deal = 'no';
     //$sizeof_rules_set = sizeof($vtprd_rules_set);  //v2.1.0
    $sizeof_rules_set = is_array($vtprd_rules_set) ? sizeof($vtprd_rules_set) : 0; //v2.1.0
    for($i=0; $i < $sizeof_rules_set; $i++) { 
       if ( ($vtprd_rules_set[$i]->rule_status == 'publish') &&
            ($vtprd_rules_set[$i]->rule_on_off_sw_select != 'off') ) {
         if ($vtprd_rules_set[$i]->rule_execution_type == 'display') {
            $ruleset_has_a_display_rule = 'yes'; 
         } 
         if ($vtprd_rules_set[$i]->rule_contains_auto_add_free_product  == 'yes') { 
            $ruleset_contains_auto_add_free_product = 'yes';         
         }
         if ( ($vtprd_rules_set[$i]->rule_contains_auto_add_free_product  == 'yes') &&
              ($vtprd_rules_set[$i]->only_for_this_coupon_name > ' ') ) { 
            $ruleset_contains_auto_add_free_coupon_initiated_deal = 'yes';         
         } 
      }
    }
    update_option( 'vtprd_ruleset_has_a_display_rule',$ruleset_has_a_display_rule );    
    update_option( 'vtprd_ruleset_contains_auto_add_free_product',$ruleset_contains_auto_add_free_product );
    update_option( 'vtprd_ruleset_contains_auto_add_free_coupon_initiated_deal',$ruleset_contains_auto_add_free_coupon_initiated_deal );
    //v2.0.0 end M solution
    
 }  

  /*  Change rule status to 'publish' 
        if status is 'pending', the rule will not be executed during cart processing  
  */
  public  function vtprd_untrash_rule () {
    global $post, $vtprd_info, $vtprd_rules_set, $vtprd_rule;
    $post_id = $post->ID;     
      //v2.1.0 begin - PHP 8.0 was kicking this out as a non-array
      //$vtprd_rules_set   = get_option( 'vtprd_rules_set' ) ;
      $vtprd_rules_set = vtprd_get_rules_set();
      //v2.1.0 end 
     //$sizeof_rules_set = sizeof($vtprd_rules_set);  //v2.1.0
    $sizeof_rules_set = is_array($vtprd_rules_set) ? sizeof($vtprd_rules_set) : 0; //v2.1.0
    for($i=0; $i < $sizeof_rules_set; $i++) { //v2.0.0
       if ($vtprd_rules_set[$i]->post_id == $post_id) {
          if  ( sizeof($vtprd_rules_set[$i]->rule_error_message) > 0 ) {   //if there are error message, the status remains at pending
            //$vtprd_rules_set[$i]->rule_status =  'pending';   status already pending
            global $wpdb;
            
            //v2.0.3 begin
            //$wpdb->update( $wpdb->posts, array( 'post_status' => 'pending' ), array( 'ID' => $post_id ) );    //match the post status to pending, as errors exist.
            
            $wpdb->query( 
                $wpdb->prepare( 
                    "UPDATE `".$wpdb->posts."`  SET `post_status` = 'pending'  WHERE `ID` = %s ;" , 
                    $post_id
                ) 
            );
            //v2.0.3 end

            
          }  else {
            $vtprd_rules_set[$i]->rule_status =  'publish';
	        //v2.1.0 begin - PHP 8.0 was kicking this out as a non-array
	        //update_option( 'vtprd_rules_set', $vtprd_rules_set );
	        vtprd_set_rules_set($vtprd_rules_set);
	        //v2.1.0 end   
          }
          continue;   //set to done
       }
    }

    //v2.0.0 begin M solution
    //**************
    //keep a running track of ruleset_has_a_display_rule   ==> used in apply-rules processing
    //*************    
    // added in test for rule_status == 'publish'
    $ruleset_has_a_display_rule = 'no';
    $ruleset_contains_auto_add_free_product = 'no';
    $ruleset_contains_auto_add_free_coupon_initiated_deal = 'no';
     //$sizeof_rules_set = sizeof($vtprd_rules_set);  //v2.1.0
    $sizeof_rules_set = is_array($vtprd_rules_set) ? sizeof($vtprd_rules_set) : 0; //v2.1.0
    for($i=0; $i < $sizeof_rules_set; $i++) { 
       if ( ($vtprd_rules_set[$i]->rule_status == 'publish') &&
            ($vtprd_rules_set[$i]->rule_on_off_sw_select != 'off') ) {
         if ($vtprd_rules_set[$i]->rule_execution_type == 'display') {
            $ruleset_has_a_display_rule = 'yes'; 
         } 
         if ($vtprd_rules_set[$i]->rule_contains_auto_add_free_product  == 'yes') { 
            $ruleset_contains_auto_add_free_product = 'yes';         
         }
         if ( ($vtprd_rules_set[$i]->rule_contains_auto_add_free_product  == 'yes') &&
              ($vtprd_rules_set[$i]->only_for_this_coupon_name > ' ') ) { 
            $ruleset_contains_auto_add_free_coupon_initiated_deal = 'yes';         
         } 
      }
    }
    update_option( 'vtprd_ruleset_has_a_display_rule',$ruleset_has_a_display_rule );    
    update_option( 'vtprd_ruleset_contains_auto_add_free_product',$ruleset_contains_auto_add_free_product );
    update_option( 'vtprd_ruleset_contains_auto_add_free_coupon_initiated_deal',$ruleset_contains_auto_add_free_coupon_initiated_deal );
    //v2.0.0 end M solution   
    
 }  
 
     
  public  function vtprd_nuke_all_rules() {
    global $post, $vtprd_info;
    
   //DELETE all posts from CPT
   $myPosts = get_posts( array( 'post_type' => 'vtprd-rule', 'number' => 500, 'post_status' => array ('draft', 'publish', 'pending', 'future', 'private', 'trash' ) ) );
   //$mycustomposts = get_pages( array( 'post_type' => 'vtprd-rule', 'number' => 500) );
   foreach( $myPosts as $mypost ) {
     // Delete's each post.
     wp_delete_post( $mypost->ID, true);
    // Set to False if you want to send them to Trash.
   }
    
   //DELETE matching option array
   delete_option( 'vtprd_rules_set' );
  
   update_option( 'vtprd_ruleset_has_a_display_rule','no' );    //v2.0.0 K solution
   update_option( 'vtprd_ruleset_contains_auto_add_free_product','no'); //v2.0.0 end M solution
   update_option( 'ruleset_contains_auto_add_free_coupon_initiated_deal','no');
    
 }  
  
  //v2.0.2.0 re-worked   
  public  function vtprd_nuke_all_rule_cats() {
    global $vtprd_info;
    
     //DELETE all rule category entries
     $terms = get_terms($vtprd_info['rulecat_taxonomy'], 'hide_empty=0&parent=0' );
     /*
     $count = count($terms);
     if ( $count > 0 ){  
         foreach ( $terms as $term ) {
            wp_delete_term( $term->term_id, $vtprd_info['rulecat_taxonomy'] );
         }
     }
     */
     if ( (is_array($terms)) &&
          (sizeof($terms) > 0) ) {
         foreach ( $terms as $term ) {
            wp_delete_term( $term->term_id, 'vtprd_rule_category' );
         }
     } 
   return;
    
 }  
      
  public  function vtprd_repair_all_rules() {
    global $wpdb, $post, $vtprd_info, $vtprd_rules_set, $vtprd_rule;    
    $vtprd_temp_rules_set = array();
      //v2.1.0 begin - PHP 8.0 was kicking this out as a non-array
      //$vtprd_rules_set   = get_option( 'vtprd_rules_set' ) ;
      $vtprd_rules_set = vtprd_get_rules_set();
      //v2.1.0 end 
    
    $sizeof_rules_set = is_array($vtprd_rules_set) ? sizeof($vtprd_rules_set) : 0; //v2.1.0
    for($i=0; $i < $sizeof_rules_set; $i++) { 
       //$test_post = get_post($vtprd_rules_set[$i]->post_id );
       //load up temp_rule_set with every rule *except* the one to be deleted
       if ( get_post($vtprd_rules_set[$i]->post_id ) ) {
          $vtprd_temp_rules_set[] = $vtprd_rules_set[$i];
       }
    }
    $vtprd_rules_set = $vtprd_temp_rules_set;
       
    if (count($vtprd_rules_set) == 0) {
      delete_option( 'vtprd_rules_set' );
    } else {
      //v2.1.0 begin - PHP 8.0 was kicking this out as a non-array
      //update_option( 'vtprd_rules_set', $vtprd_rules_set );
      vtprd_set_rules_set($vtprd_rules_set);
      //v2.1.0 end 
    }
    


    //v2.0.0 begin M solution
    //**************
    //keep a running track of ruleset_has_a_display_rule   ==> used in apply-rules processing
    //*************    
    // added in test for rule_status == 'publish'
    $ruleset_has_a_display_rule = 'no';
    $ruleset_contains_auto_add_free_product = 'no';
    $ruleset_contains_auto_add_free_coupon_initiated_deal = 'no';
     //$sizeof_rules_set = sizeof($vtprd_rules_set);  //v2.1.0
    $sizeof_rules_set = is_array($vtprd_rules_set) ? sizeof($vtprd_rules_set) : 0; //v2.1.0
    for($i=0; $i < $sizeof_rules_set; $i++) { 
       if ( ($vtprd_rules_set[$i]->rule_status == 'publish') &&
            ($vtprd_rules_set[$i]->rule_on_off_sw_select != 'off') ) {
         if ($vtprd_rules_set[$i]->rule_execution_type == 'display') {
            $ruleset_has_a_display_rule = 'yes'; 
         } 
         if ($vtprd_rules_set[$i]->rule_contains_auto_add_free_product  == 'yes') { 
            $ruleset_contains_auto_add_free_product = 'yes';         
         }
         if ( ($vtprd_rules_set[$i]->rule_contains_auto_add_free_product  == 'yes') &&
              ($vtprd_rules_set[$i]->only_for_this_coupon_name > ' ') ) { 
            $ruleset_contains_auto_add_free_coupon_initiated_deal = 'yes';         
         } 
      }
    }
    update_option( 'vtprd_ruleset_has_a_display_rule',$ruleset_has_a_display_rule );    
    update_option( 'vtprd_ruleset_contains_auto_add_free_product',$ruleset_contains_auto_add_free_product );
    update_option( 'vtprd_ruleset_contains_auto_add_free_coupon_initiated_deal',$ruleset_contains_auto_add_free_coupon_initiated_deal );
    //v2.0.0 end M solution
    
 }
     
  public  function vtprd_nuke_lifetime_purchase_history() {
    global $wpdb;      
    //v1.0.8.0 begin
    //$wpdb->query("DROP TABLE IF EXISTS `".VTPRD_LIFETIME_LIMITS_PURCHASER."` ");  
    //$wpdb->query("DROP TABLE IF EXISTS `".VTPRD_LIFETIME_LIMITS_PURCHASER_RULE."` " );
    //$wpdb->query("DROP TABLE IF EXISTS `".VTPRD_LIFETIME_LIMITS_PURCHASER_LOGID_RULE."` " );

    //only empty if tables exist
    $table_name =  VTPRD_LIFETIME_LIMITS_PURCHASER;
    
    //v2.0.3 begin
    //$is_this_table = $wpdb->get_var( "SHOW TABLES LIKE '$table_name'" );
    $is_this_table = $wpdb->get_var(
    		$wpdb->prepare(
                  "SHOW TABLES LIKE %s ",
                  $table_name               
    		)
    	); 
    //v2.0.3  %1s prevents prepare from adding single quotes
       
    if ( $is_this_table  == VTPRD_LIFETIME_LIMITS_PURCHASER) {
      $content = 'TRUNCATE'; //v2.0.3 - $wpdb->prepare REQUIRES a variable in the sql.
      $wpdb->query($wpdb->prepare( " %1s `".VTPRD_LIFETIME_LIMITS_PURCHASER."` ", $content));      //v2.0.3   
      $wpdb->query($wpdb->prepare( " %1s `".VTPRD_LIFETIME_LIMITS_PURCHASER_RULE."` ", $content ));      //v2.0.3 
      $wpdb->query($wpdb->prepare( " %1s `".VTPRD_LIFETIME_LIMITS_PURCHASER_LOGID_RULE."` ", $content ));      //v2.0.3 
    } //v2.0.3  %1s prevents prepare from adding single quotes   
    //v1.0.8.0 end
  }
       
  public  function vtprd_nuke_audit_trail_logs() {
    global $wpdb;    
    //v1.0.8.0 begin
    
    //only empty if tables exist
    $table_name =  VTPRD_PURCHASE_LOG;
    
    //v2.0.3 begin
    //$is_this_table = $wpdb->get_var( "SHOW TABLES LIKE '$table_name'" );
    $is_this_table = $wpdb->get_var(
    		$wpdb->prepare(
                  "SHOW TABLES LIKE %s ",
                  $table_name               
    		)
    	); 
    //v2.0.3  %1s prevents prepare from adding single quotes
    
    if ( $is_this_table  == VTPRD_PURCHASE_LOG) {
        $content = 'TRUNCATE'; //v2.0.3 - $wpdb->prepare REQUIRES a variable in the sql.
        $wpdb->query($wpdb->prepare( "%1s `".VTPRD_PURCHASE_LOG."` ", $content));       //v2.0.3 
        $wpdb->query($wpdb->prepare( "%1s `".VTPRD_PURCHASE_LOG_PRODUCT."` ", $content));      //v2.0.3 
        $wpdb->query($wpdb->prepare( "%1s `".VTPRD_PURCHASE_LOG_PRODUCT_RULE."` ", $content));      //v2.0.3 
    }
    //v2.0.3  %1s prevents prepare from adding single quotes     
    //v1.0.8.0 end
  }
} //end class
