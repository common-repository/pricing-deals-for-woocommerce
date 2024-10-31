<?php
/**
 * Pricing Deals Uninstall
 *
 * @version 2.0.2.0
 * 
 * ++file launches automatically on uninstall, no rqeuire_once on the file is needed++
 * 
 * v2.0.3 recoded to include $wpdb->prepare everywhere
 */
 
 //*******************************************************************
 //v2.0.3 added $wpdb->prepare to all $wpdb->query statements
 //*******************************************************************


    if ( ! defined( 'WP_UNINSTALL_PLUGIN' ) ) {
	   //error_log( print_r(  'vtprd UNINSTALL - exit001', true ) );
	   return;
	}
 	

	//moved above wp_clear statements, v2.0.3
    if ((get_option('vtprd_deleteALL_on_UnInstall')) != 'yes') {
	   //error_log( print_r(  'vtprd UNINSTALL - exit002', true ) );
	   return;
	}

    //error_log( print_r(  'vtprd UNINSTALL is running', true ) );

	global $wpdb, $wp_version;

    //done on deactivation by default, but just in case
	wp_clear_scheduled_hook( 'vtprd_once_daily_scheduled_events' ); //v2.0.2.0
    wp_clear_scheduled_hook( 'vtprd_twice_daily_scheduled_events' );
    wp_clear_scheduled_hook( 'vtprd_thrice_daily_scheduled_events' ); //v2.0.0.2, just in case



	// Delete options.
    $contentSearch = 'vtprd\_%'; //v2.0.3 - $wpdb->prepare REQUIRES a variable in the sql. Also, "Literal percentage signs (%) in the query string must be written as %%. "
	$wpdb->query($wpdb->prepare(  "DELETE FROM $wpdb->options WHERE option_name LIKE %s;" ,
          $contentSearch
        )); //v2.0.3       
        
	
	// Delete posts + data.
	$contentSearch = 'vtprd-rule'; //v2.0.3 - $wpdb->prepare REQUIRES a variable in the sql.
    $wpdb->query( $wpdb->prepare(  "DELETE FROM {$wpdb->posts} WHERE post_type = %s;" ,
          $contentSearch
        )); //v2.0.3
    
    $isNull = 'IS NULL'; //v2.0.3 - $wpdb->prepare REQUIRES a variable in the sql.    
	$wpdb->query( $wpdb->prepare(  "DELETE meta FROM {$wpdb->postmeta} meta LEFT JOIN {$wpdb->posts} posts ON posts.ID = meta.post_id WHERE posts.ID %1s;" ,  
          $isNull
        )); //v2.0.3  %1s prevents prepare from adding single quotes

	// Delete usermeta.
    $contentSearch = 'vtprd\_%'; //v2.0.3 - $wpdb->prepare REQUIRES a variable in the sql. Also, "Literal percentage signs (%) in the query string must be written as %%. "
	$wpdb->query( $wpdb->prepare(  "DELETE FROM $wpdb->usermeta WHERE meta_key LIKE %s;" ,
          $contentSearch
        )); //v2.0.3
	
    
    
    //drop all tables
    $tableName = 'vtprd_purchase_log';
	$wpdb->query( $wpdb->prepare( "DROP TABLE IF EXISTS {$wpdb->prefix}%1s;" ,
          $tableName
        )); //v2.0.3  %1s prevents prepare from adding single quotes
    
    $tableName = 'vtprd_purchase_log_product';
    $wpdb->query( $wpdb->prepare( "DROP TABLE IF EXISTS {$wpdb->prefix}%1s;" ,
          $tableName
        )); //v2.0.3  %1s prevents prepare from adding single quotes
    
    $tableName = 'vtprd_purchase_log_product_rule';
    $wpdb->query( $wpdb->prepare( "DROP TABLE IF EXISTS {$wpdb->prefix}%1s;" ,
          $tableName
        )); //v2.0.3  %1s prevents prepare from adding single quotes
    
    $tableName = 'vtprd_transient_cart_data';
    $wpdb->query( $wpdb->prepare( "DROP TABLE IF EXISTS {$wpdb->prefix}%1s;" ,
          $tableName
        )); //v2.0.3  %1s prevents prepare from adding single quotes
    
    $tableName = 'vtprd_lifetime_limits_purchaser';
    $wpdb->query( $wpdb->prepare( "DROP TABLE IF EXISTS {$wpdb->prefix}%1s;" ,
          $tableName
        )); //v2.0.3  %1s prevents prepare from adding single quotes
    
    $tableName = 'vtprd_lifetime_limits_purchaser_logid_rule';
    $wpdb->query( $wpdb->prepare( "DROP TABLE IF EXISTS {$wpdb->prefix}%1s;" ,
          $tableName
        )); //v2.0.3  %1s prevents prepare from adding single quotes
    
    $tableName = 'vtprd_lifetime_limits_purchaser_rule';
    $wpdb->query( $wpdb->prepare( "DROP TABLE IF EXISTS {$wpdb->prefix}%1s;" ,
          $tableName
        )); //v2.0.3  %1s prevents prepare from adding single quotes

    //delete all custom Taxonomy entries
   //DELETE all rule category entries
   $terms = get_terms('vtprd_rule_category', 'hide_empty=0&parent=0' );
   if ( (is_array($terms)) &&
        (sizeof($terms) > 0) ) {
       foreach ( $terms as $term ) {
          wp_delete_term( $term->term_id, 'vtprd_rule_category' );
       }
   } 


    //delete custom Taxonomy - does it's own prepare, from all accounts 
	$wpdb->delete(  
		$wpdb->term_taxonomy,
		array(
			'taxonomy' => 'vtprd_rule_category',
		) 
	);		


	// Delete orphan relationships.
	$wpdb->query( $wpdb->prepare(  "DELETE tr FROM {$wpdb->term_relationships} tr LEFT JOIN {$wpdb->posts} posts ON posts.ID = tr.object_id WHERE posts.ID %1s;" ,
          $isNull
        )); //v2.0.3  %1s prevents prepare from adding single quotes

	// Delete orphan terms.
	$wpdb->query( $wpdb->prepare(  "DELETE t FROM {$wpdb->terms} t LEFT JOIN {$wpdb->term_taxonomy} tt ON t.term_id = tt.term_id WHERE tt.term_id %1s;" ,
          $isNull
        )); //v2.0.3  %1s prevents prepare from adding single quotes

	// Delete orphan term meta.
	if ( ! empty( $wpdb->termmeta ) ) {
		$wpdb->query( $wpdb->prepare(  "DELETE tm FROM {$wpdb->termmeta} tm LEFT JOIN {$wpdb->term_taxonomy} tt ON tm.term_id = tt.term_id WHERE tt.term_id %1s;" ,
          $isNull
        )); //v2.0.3  %1s prevents prepare from adding single quotes
	}


	// Clear any cached data that has been removed.
	wp_cache_flush();
    return;