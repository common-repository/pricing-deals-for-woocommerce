<?php
/*                         
   Rule CPT rows are stored.  At rule store/update
   time, a master rule option array is (re)created, to allow speedier access to rule information at
   product/cart processing time.
 */
   
class VTPRD_Rules_UI{ 
	
	public function __construct(){       
    global $post, $vtprd_info;
    
    //ACTION TO ALLOW THEME TO OFFER ALL PRODUCTS AT A DISCOUNT.....
    
        
    add_action( 'add_meta_boxes_vtprd-rule', array(&$this, 'vtprd_remove_meta_boxes') );   
    add_action( 'add_meta_boxes_vtprd-rule', array(&$this, 'vtprd_add_metaboxes') );
    add_action( 'add_meta_boxes_vtprd-rule', array($this, 'vtprd_remove_all_in_one_seo_aiosp') ); 
    
    //v2.0.0.8 begin
    // ** BOTH executions NEEDED **
    // Gutenberg caused multiple themes to add conflicting JS, need BOTH executions to catch various themes...
    //  this double execution works in tandem with "add_filter( 'vtprd_remove_all_extra_js_from_rule_page', function() { return TRUE; } );"
    //v2.0.3 begin - changed the 2 '999' to '888' so that the new inline will run last
    //add_action( "admin_enqueue_scripts",     array(&$this, 'vtprd_enqueue_admin_scripts'),999  );//v2.0.0.3a 999 so the dequeue is LAST
    //add_action( "admin_print_scripts",       array(&$this, 'vtprd_enqueue_admin_scripts'),999  );//v2.0.0.3a 999 so the dequeue is LAST
    
    //v2.0.3 - changed to 888 so that the enzueue of the datepicker full js would fall first
    add_action( "admin_enqueue_scripts",     array(&$this, 'vtprd_enqueue_admin_scripts'),888  );//v2.0.3
    add_action( "admin_print_scripts",       array(&$this, 'vtprd_enqueue_admin_scripts'),888  );//v2.0.3
    
    //add_action( "admin_print_styles",        array(&$this, 'vtprd_print_admin_styles'),888  );
    
    add_action( "admin_enqueue_scripts",     array(&$this, 'vtprd_enqueue_admin_inline_scripts'),999  );  //v2.0.3
    //add_action( "admin_print_styles",        array(&$this, 'vtprd_print_admin_inline_styles'),999  );
       
    //v2.0.0.8 end
     //v2.0.3 end
    
    //AJAX actions
         
    // v1.1.8.1 begin - clone rule button
    add_action( 'wp_ajax_vtprd_ajax_clone_rule',                      array(&$this, 'vtprd_ajax_clone_rule') ); 
    add_action( 'wp_ajax_nopriv_vtprd_ajax_clone_rule',               array(&$this, 'vtprd_ajax_clone_rule') );
    // v1.1.8.1 end
              
    //Adds Wholesale flag on the Product Page
    add_action( 'post_submitbox_misc_actions', array( $this, 'vtprd_product_data_visibility' ) ); //v1.1.0.7 

    
    //*******************************************
    //v2.0.0 begin NEW ajax actions for SELECT2 
    //*******************************************
    //Product Search
    add_action( 'wp_ajax_vtprd_product_search_ajax',         array(&$this, 'vtprd_ajax_do_product_selector') ); 
    add_action( 'wp_ajax_nopriv_vtprd_product_search_ajax',  array(&$this, 'vtprd_ajax_do_product_selector') ); 
    //Category Search - no longer ajax, just select2...
    //add_action( 'wp_ajax_vtprd_category_search_ajax',        array(&$this, 'vtprd_ajax_do_category_selector') ); 
    //add_action( 'wp_ajax_nopriv_vtprd_category_search_ajax', array(&$this, 'vtprd_ajax_do_category_selector') );   
    //Customer Search
    add_action( 'wp_ajax_vtprd_customer_search_ajax',        array(&$this, 'vtprd_ajax_do_customer_selector') ); 
    add_action( 'wp_ajax_nopriv_vtprd_customer_search_ajax', array(&$this, 'vtprd_ajax_do_customer_selector') );
 
    //v2.0.0 end
    
	}
  
  public function vtprd_enqueue_admin_scripts() {
    //v2.0.0.1 begin
    global $vtprd_info;  //V2.0.0.1 removed $post_type from global statement
 
    $allowed_html = vtprd_get_allowed_html(); //v2.0.3 
      
    $post_type = get_post_type();
    if( $post_type == 'vtprd-rule' ){         //v1.0.8.2   can't just test $post_type here, not always accurate!
    //v2.0.0.1 end      
    
          //v2.0.0.9 begin - turns off gutenberg for post type
          // Enable Gutenberg for WP < 5.0 beta
          add_filter('gutenberg_can_edit_post_type', '__return_false', 10);
      
          // Enable Gutenberg for WordPress >= 5.0
          add_filter('use_block_editor_for_post_type', '__return_false', 10);
          //v2.0.0.9 end


          //*****************
          //v2.0.0.8 begin
          //*****************
          global $vtprd_setup_options; 
          if (!isset( $vtprd_setup_options['register_under_tools_menu'] ))  { //register_under... is the 1st option
            $vtprd_setup_options = get_option( 'vtprd_setup_options' );
          }
          
          //TEST for AVADA theme - if avada, set switch
          if (($vtprd_setup_options['remove_all_extra_js_from_rule_page'] == 'no') ||
              ($vtprd_setup_options['remove_all_extra_js_from_rule_page'] <= ' ') ) {
            //get current theme name
            $theme_name = wp_get_theme()->get( 'Name' );
            /*
              https://codex.wordpress.org/Function_Reference/wp_get_theme
              Template 
              (Optional — used in a child theme) The folder name of the parent theme            
            */
            $parent_theme_template_name = wp_get_theme()->get( 'Template' ); 
            $theme_name = strtolower($theme_name);
            $parent_theme_template_name = strtolower($parent_theme_template_name);    
            
            if ( (strpos($theme_name, 'avada' ) !== FALSE) ||  //v2.0.0.9  switched needle and haystack
                 (strpos($parent_theme_template_name, 'avada' ) !== FALSE) ) {     //v2.0.0.9  switched needle and haystack              
               //if theme name found, set switch to 'yes'!
               $vtprd_setup_options['remove_all_extra_js_from_rule_page'] = 'yes';
               update_option( 'vtprd_setup_options',$vtprd_setup_options); 
            }
           
             
          }
          
          
          
        // from https://wordpress.stackexchange.com/questions/61635/how-to-remove-all-javascript-in-a-theme-wordpress
        /*
          If you are editing a rule and having trouble with the lower Rule screen display:
          	//add the 'add_filter...' statement to your theme/child-theme functions.php file 
          	add_filter( 'vtprd_remove_all_extra_js_from_rule_page', function() { return TRUE; } ); 
        */
        if ( (apply_filters('vtprd_remove_all_extra_js_from_rule_page',FALSE )) ||
             ($vtprd_setup_options['remove_all_extra_js_from_rule_page'] == 'yes') ) { //if the theme has a terminal wp-admin conflict...
        
            //error_log( print_r(  'vtprd_remove_all_extra_JS_from_rule_page EXECUTED ' , true ) );

            //this is a single CSS statement, which overrides the publish box 'floating' attribute
           // wp_register_style ('vtprd-admin-override', esc_url(VTPRD_URL).'/admin/css/vtprd-admin-style-override.css' );  
           // wp_enqueue_style  ('vtprd-admin-override');
                        
            global $wp_scripts;
            /*
            $leave_alone = array(
                // Put the scripts you don't want to remove in here.
            );
            */
            /*
        
            foreach ( $wp_scripts->queue as $handle )
            {
                // Here we skip/leave-alone those, that we added above ?
                //if ( in_array( $handle, $leave_alone ) )
                //    continue;
        
                $wp_scripts->remove( $handle );
            } 
            */ 
            //from https://stackoverflow.com/questions/22561094/how-do-i-remove-all-scripts-from-wordpress-using-wp-dequeue-script-or-wp-deregis
            $scripts = $wp_scripts->registered;
            foreach ( $scripts as $script ){
                wp_dequeue_script($script->handle);
            } 
            
                    
            /* duplicating!!
            //**********************************
            //error messages get deleted above, so redo them
            global $vtprd_rule;
            $sizeTest = sizeof($vtprd_rule->rule_error_message);
            if ( sizeof($vtprd_rule->rule_error_message ) > 0 ) {    //these error messages are from the last upd action attempt, coming from vtprd-rules-update.php
               $this->vtprd_error_messages();
            }
            */
        
                                     
        } else {
          $this->vtprd_remove_excess_scripts(); //v2.0.0.5a
        }
        /*
        remove excess CSS
          https://gelwp.com/articles/removing-all-enqueued-and-default-css-scripts-in-wordpress/

            1. dump all wordpress handles current for my test installation
            2. delete all except that list (include 'vtprd-admin-override')
            3. use filter to add to that list as needed
        */  
        if ( (apply_filters('vtprd_remove_all_extra_css_from_rule_page',FALSE )) ||
             ($vtprd_setup_options['remove_all_extra_css_from_rule_page'] == 'yes') ) { //if the theme has a terminal wp-admin conflict...      
              /*
            	// get all styles data
            	global $wp_styles;    
              // loop over all of the registered scripts
              	foreach ($wp_styles->registered as $handle => $data)
              	{
                //error_log( print_r(  ' ' , true ) );
                error_log( print_r(  'active $handle= "' .$handle. '"' , true ) );
                //error_log( print_r(  'styles Date for this handle = ', true ) );
                //error_log( var_export($data, true ) ); 
              	} 
                */  
        
            //error_log( print_r(  'vtprd_remove_all_extra_CSS_from_rule_page EXECUTED ' , true ) );
                                       
            // get all styles data
          	global $wp_styles;
          
          	// create an array of stylesheet "handles" to allow to remain
          	// e.g. these styles will keep the admin bar styled
          	$styles_to_keep = array(
                "colors",
                "common",
                "forms",
                "admin-menu",
                "dashboard",
                "list-tables",
                "edit",
                "revisions",
                "media",
                "themes",
                "about",
                "nav-menus",
                "widgets",
                "site-icon",
                "l10n",
                "code-editor",
                "wp-admin",
                "login",
                "install",
                "wp-color-picker",
                "customize-controls",
                "customize-widgets",
                "customize-nav-menus",
                "ie",
                "buttons",
                "dashicons",
                "admin-bar",
                "wp-auth-check",
                "editor-buttons",
                "media-views",
                "wp-pointer",
                "customize-preview",
                "wp-embed-template-ie",
                "imgareaselect",
                "wp-jquery-ui-dialog",
                "mediaelement",
                "wp-mediaelement",
                "thickbox",
                "wp-codemirror",
                "deprecated-media",
                "farbtastic",
                "jcrop",
                "colors-fresh",
                "open-sans",
                "wp-editor-font",
                "wp-block-library-theme",
                "wp-edit-blocks",
                "wp-block-library",
                "wp-components",
                "wp-edit-post",
                "wp-editor",
                "wp-format-library",
                "wp-list-reusable-blocks",
                "wp-nux",
                "wordfence-font-awesome-style",
                "wordfence-global-style",
                "vtprd-pro-admin-style",
                "wordfenceAJAXcss",
                "wf-adminbar",
                "storefront-plugin-install",
                "woocommerce_admin_menu_styles",
                "woocommerce_admin_styles",
                "jquery-ui-style",
                "woocommerce_admin_dashboard_styles",
                "woocommerce_admin_print_reports_styles",
                "vtprd-qtip-style",
                "vtprd-admin-style",
                "vtprd-jquery-datepicker-style",
                "vtprd-admin-style2",
                "selectWoo-style"                   
            );
          
          	// loop over all of the registered scripts
          	foreach ($wp_styles->registered as $handle => $data) {
          		// if we want to keep it, skip it
          		if ( in_array($handle, $styles_to_keep) ) {               
                continue;
              } else {
            		// otherwise remove it
            		wp_deregister_style($handle);
            		wp_dequeue_style($handle);
              }
          	}            
        }
        //v2.0.0.8 end

        //v1.1.8.1 end  
      
        //Datepicker resources, some part of WP
        wp_register_style ('vtprd-jquery-datepicker-style', esc_url(VTPRD_URL.'/admin/css/smoothness/jquery-ui-1.10.2.custom.css') );  
        wp_enqueue_style  ('vtprd-jquery-datepicker-style');
        wp_enqueue_script ('jquery-ui-core', array('jquery'), false, true );
        wp_enqueue_script ('jquery-ui-datepicker', array('jquery'), false, true );

        if(defined('VTPRD_PRO_DIRNAME')) {
            wp_register_style ('vtprd-admin-style2', esc_url(VTPRD_PRO_URL.'/admin/css/vtprd-admin-style2.css') );  
            wp_enqueue_style  ('vtprd-admin-style2');
        }
             
        //v2.0.0 begin

        wp_register_script('selectWoo', esc_url(VTPRD_URL.'/admin/js/selectWoo.full.min.js') );  
        wp_enqueue_script ('selectWoo', array('jquery'), false, true);        
        wp_register_style ('selectWoo-style', esc_url(VTPRD_URL.'/admin/css/selectWoo-style.css') );  
        wp_enqueue_style  ('selectWoo-style');   

        wp_register_script('vtprd-enhanced-select', esc_url(VTPRD_URL.'/admin/js/vtprd-enhanced-select.min.js') );  //v2.0.0.1 changed to .min
        wp_enqueue_script ('vtprd-enhanced-select', array('jquery'), false, true); 

        //create ajax resource for EACH SEARCH BOX
        //wp_localize_script('vtprd-enhanced-select', 'vtprdProductSelect', array( 'ajaxurl' => admin_url( 'admin-ajax.php' )  ));                                 
        //v2.0.0 end
        
                
        //*********************
        //v2.0.0.8 begin - moved these statements to bottom, to accomodate new 'extra js' wipeout actions
        //*********************
        
        //QTip Resources
        wp_register_style ('vtprd-qtip-style', esc_url(VTPRD_URL.'/admin/css/vtprd.qtip.min.css') );  
        wp_enqueue_style  ('vtprd-qtip-style'); 
       
       //qtip resources named jquery-qtip, to agree with same name used in wordpress-seo from yoast!
        wp_register_script('jquery-qtip', esc_url(VTPRD_URL.'/admin/js/vtprd.qtip.min.js') );  
        wp_enqueue_script ('jquery-qtip', array('jquery'), false, true);


        wp_register_style ('vtprd-admin-style', esc_url(VTPRD_URL.'/admin/css/vtprd-admin-style-' .wp_kses(VTPRD_ADMIN_CSS_FILE_VERSION ,$allowed_html). '.css') );  //v1.1.0.7
        wp_enqueue_style  ('vtprd-admin-style');
        
        wp_register_script('vtprd-admin-script', esc_url(VTPRD_URL.'/admin/js/vtprd-admin-script-' .wp_kses(VTPRD_ADMIN_JS_FILE_VERSION ,$allowed_html). '.js') );  //v1.1
        //create ajax resource
               
        wp_enqueue_script ('vtprd-admin-script', array('jquery', 'vtprd-qtip-js'), false, true);
        
        //v1.1.8.1 begin
        //create ajax resource
        wp_localize_script('vtprd-admin-script', 'cloneRuleAjax', array( 'ajaxurl' => admin_url( 'admin-ajax.php' )  ));

        //v2.0.0.8 end
        //*************
        

        //--------------------------------------------------------------------------  
                       
      } //end 'vtprd-rule' section


      //v2.0.0.1 BEGIN
      //keep this for css for vtprd-wholesale 
      if( $post_type == $vtprd_info['parent_plugin_cpt']){
        wp_register_style('vtprd-admin-product-metabox-style', esc_url(VTPRD_URL.'/admin/css/vtprd-admin-product-metabox-style.css') );  
        wp_enqueue_style( 'vtprd-admin-product-metabox-style');    
      }
      //v2.0.0.1 end
      
     return;
  }                               

  //*******************************
  //v2.0.3 new function
  //*******************************
  public function vtprd_enqueue_admin_inline_scripts() {
    //v2.0.0.1 begin
    global $vtprd_info, $vtprd_rule;  //V2.0.0.1 removed $post_type from global statement   //v2.0.3 added $vtprd_rule
 
    $allowed_html = vtprd_get_allowed_html(); //v2.0.3 
      
    $post_type = get_post_type();
    if( $post_type == 'vtprd-rule' ){         //v1.0.8.2   can't just test $post_type here, not always accurate!
       
        //*************
        //v2.0.3 begin
        //*************
        // all new either created or moved here, 
        //to be placed correctly to use "wp_add_inline" functions
        //*************
        
        wp_register_script('vtprd-admin-ui-script', esc_url(VTPRD_URL.'/admin/js/vtprd-admin-ui-script-' .wp_kses(VTPRD_UI_JS_FILE_VERSION ,$allowed_html). '.js') );  //v1.1   
        wp_enqueue_script ('vtprd-admin-ui-script', array('jquery'), false, true);
        wp_register_style ('vtprd-admin-ui-style', esc_url(VTPRD_URL.'/admin/css/vtprd-admin-ui-style-' .wp_kses(VTPRD_UI_CSS_FILE_VERSION ,$allowed_html). '.css') );  //v1.1.0.7
        wp_enqueue_style  ('vtprd-admin-ui-style');

        //--------------------------------------------------------------------------
        // v2.0.3 - changed to an inline script
        //spinner fix no longer necessary!!!!!!! 
        /*
        $vtprd_inline_script  = 'jQuery(document).ready(function($) {';
        $vtprd_inline_script .= "$('.spinner').append('<img src='";
        $vtprd_inline_script .= esc_url(VTPRD_URL);
        $vtprd_inline_script .= "/admin/images/indicator.gif' />');      });  ";
        */
                        
        //wp_add_inline_script('vtprd-admin-ui-script',$vtprd_inline_script );  //v2.0.3  
                               
        $this->vtprd_get_or_create_rule();
             

         //error_log( print_r(  '$vtprd_rule after rule get = ' , true ) ); 
         //error_log( var_export($vtprd_rule, true ) ); 
                 
         //v2.0.3 end
        $sizeof_msgs = is_array($vtprd_rule->rule_error_message) ? sizeof($vtprd_rule->rule_error_message) : 0; //v2.1.0  
         //error_log( print_r(  'sizeof rule_error_message = ' .$sizeTest, true ) ); 
        
        $vtprd_inline_style = FALSE;
        
        if ( $sizeof_msgs > 0 ) {    //these error messages are from the last upd action attempt, coming from vtprd-rules-update.php
              //error_log( print_r(  'go to vtprd_error_messages',  true ) );
             $this->vtprd_error_messages();
        }  else { //v2.0.0 begin ***********
          if(!defined('VTPRD_PRO_DIRNAME')) {
            //grey out the selection labels in buy group and get group not available in FREE
             //v2.0.3 begin
             //recoded to use: 
             // wp_add_inline_style
            $vtprd_inline_style .= '  
            .buy-prod-category-incl-label, .buy-prod-category-excl-label, 
            .buy-plugin-category-incl-label, .buy-plugin-category-excl-label,
            .buy-product-incl-label, .buy-product-excl-label,
            .buy-role-incl-label, .buy-role-excl-label,
            .buy-email-incl-label, .buy-email-excl-label,
            .action-prod-category-incl-label, .action-prod-category-excl-label, 
            .action-plugin-category-incl-label, .action-plugin-category-excl-label,
            .action-product-incl-label, .action-product-excl-label
              {color:#888;} 
            
            #buy-and-or-selector-prod-cat,
            #buy-and-or-selector-plugin-cat,
            #buy-and-or-selector-product,
            #action-and-or-selector-prod-cat,
            #action-and-or-selector-plugin-cat,
            #action-and-or-selector-product {         
              color: #BB8500 !important;
              border: 1px solid #BB8500;
            }                
             ' ; 
            //v2.0.3 end 
             //most of the yellow stuff is in JS, except the above        
          }     
        } //v2.0.0 end
        
        //v2.0.0 begin
        //THESE blocks are also in JS, but are causing a BLINK due to slow load.  
        //SO also here.
        if ( $vtprd_rule->cart_or_catalog_select  ==  'catalog') {
            //v2.0.3 begin
            $vtprd_inline_style .= '  
                #bulk-checkout-msg-comment, 
                #deal-action-line,
                #apply-to-cheapest-select-area,
                #buy_amt_box_0,
                #buy_repeat_box_0,
                #pricing-type-Bulk, 
                #pricing-type-Bogo,
                #pricing-type-Group,
                #pricing-type-Cheapest,
                .cumulativeCouponPricing_area,
                #deal-action-horiz-line
                  {display:none;}  
                          
                ' ; 
            //v2.0.3 end                    
        }
        if (in_array( $vtprd_rule->pricing_type_select, array('choose', 'all', 'simple', 'bulk') )) {
            //v2.0.3 begin
            $vtprd_inline_style .= '   
                #deal-action-line, 
                #deal-action-horiz-line
                  {display:none;} 
                         
                ' ; 
            
            //v2.0.3 end                    
        }      
        //v2.0.0 end  
        
        if ($vtprd_inline_style) {
           wp_add_inline_style('vtprd-admin-ui-style',$vtprd_inline_style );  //v2.0.3
        }
        
        //*************      
        //v2.0.3 end
        //*************
        //--------------------------------------------------------------------------  
                       
      } //end 'vtprd-rule' section

     return;
  }                               

 
  //**************************
  //v2.0.0.5a New Function
  //**************************
  public function vtprd_remove_excess_scripts() {
    //v2.0.0.8 begin
    /*
    $post_type = get_post_type();
      //error_log( print_r(  'Function begin - vtprd_remove_excess_scripts, post_type= ' .$post_type, true ) );
    if( $post_type == 'vtprd-rule' ){         //v1.0.8.2   can't just test $post_type here, not always accurate!
    //v2.0.0.1 end
    */
    //v2.0.0.8 end

        //v2.0.0.2 begin
        /*
           	If you are editing a rule and having trouble with the Date Picker:
          	//add the 'add_filter...' statement to your theme/child-theme functions.php file 
          	add_filter( 'vtprd_trouble_with_date_picker', function() { return TRUE; } ); 
         */      
        if (apply_filters('vtprd_trouble_with_date_picker',FALSE )) { //v2.0.0.3a  'false' was in parenthesis!!
            //error_log( print_r(  'Function begin - MINI DEQUEUE LOADED', true ) ); 
            $dq_list = array (
            //Woocommmerce verison of selectwoo is REMOVED, I supply my own copy.
            'selectWoo'
           );
        } else {
          //*********************************
          //REMOVE UNNECCESSARY JS from PAGE!!
          //*********************************
            $dq_list = array (
            //Woocommmerce verison of selectwoo is REMOVED, I supply my own copy.
            'selectWoo',  
            
            //Perfect WooCommerce Brands 
            'pwb-functions-admin',     
            
            //Woocommerce Memberships
            'wc-memberships-admin', 
            
            //Product Brands For WooCommerce  
            'jquery-ui-accordion',  
           // 'wp-color-picker',   //v2.0.0.8 removed, causing problems with some themes.
            'wpsf-plugins', 
            'wpsf-fields',  
            'wpsf-framework', 
            
            //YITH WooCommerce Brands Add-On
            'yith-enhanced-select', 
            
            //Ultimate WooCommerce Brands
            'mgwb-script-admin',
            
            //Members plugin 
            'members-edit-post',  
                 
            'moxiejs', //file upload
            'plupload', //file upload
            
            //Wordpress media
            'media-editor',              
            'media-views',
            'media-audiovideo',       
            'thickbox',      
            'media-upload',
            'imgAreaSelect',
            'image-edit',
            'editor',
            'wp-embed',
            'TinyMCE',
            'quicktags',
            'wplink',
            'wp-emoji-release',
            'concatemoji',
            'print_emoji_detection_script',
             
            //v2.0.0.5 begin Wordpress 5.0 additions
            // list from https://make.wordpress.org/core/2018/12/06/javascript-packages-and-interoperability-in-5-0-and-beyond/
            'wp-a11y',
            'wp-annotations',
            'wp-api-fetch',
            'wp-autop',
            'wp-blob',
            'wp-block-library',
            'wp-block-serialization-default-parser',
            'wp-blocks',
            'wp-components',
            'wp-compose',
            'wp-core-data',
            'wp-data',
            'wp-date',
            'wp-deprecated',
            'wp-dom-ready',
            'wp-dom',
            'wp-edit-post',
            'wp-editor',
            'wp-element',
            'wp-escape-html',
            'wp-format-library',
            'wp-hooks',
            'wp-html-entities',
            'wp-i18n',
            'wp-is-shallow-equal',
            'wp-keycodes',
            'wp-list-reusable-blocks',
            'wp-notices',
            'wp-nux',
            'wp-plugins',
            'wp-polyfill-element-closest',
            'wp-polyfill-fetch',
            'wp-polyfill-formdata',
            'wp-polyfill-node-contains',
            'wp-polyfill',
            'wp-redux-routine',
            'wp-rich-text',
            'wp-shortcode',
            'wp-token-list',
            'wp-url',
            'wp-viewport',
            'wp-wordcount'           
            //v2.0.0.5 end          
          );
          //error_log( print_r(  'Function begin - DEQUEUE LOADED', true ) ); 
        }
        //v2.0.0.2 end
        
        
        foreach ( $dq_list as $dq_this) { 
          wp_dequeue_script($dq_this);
          wp_deregister_script($dq_this);
        } 
     // } v2.0.0.8
      return;  
  }
  
  public function vtprd_remove_meta_boxes() {
     if(!current_user_can('administrator')) {  
      	remove_meta_box( 'revisionsdiv', 'post', 'normal' ); // Revisions meta box
        remove_meta_box( 'commentsdiv', 'vtprd-rule', 'normal' ); // Comments meta box
      	remove_meta_box( 'authordiv', 'vtprd-rule', 'normal' ); // Author meta box
      	remove_meta_box( 'slugdiv', 'vtprd-rule', 'normal' );	// Slug meta box        	
      	remove_meta_box( 'postexcerpt', 'vtprd-rule', 'normal' ); // Excerpt meta box
      	remove_meta_box( 'formatdiv', 'vtprd-rule', 'normal' ); // Post format meta box
      	remove_meta_box( 'trackbacksdiv', 'vtprd-rule', 'normal' ); // Trackbacks meta box
      	remove_meta_box( 'postcustom', 'vtprd-rule', 'normal' ); // Custom fields meta box
      	remove_meta_box( 'commentstatusdiv', 'vtprd-rule', 'normal' ); // Comment status meta box
      	remove_meta_box( 'postimagediv', 'vtprd-rule', 'side' ); // Featured image meta box
      	remove_meta_box( 'pageparentdiv', 'vtprd-rule', 'side' ); // Page attributes meta box
        remove_meta_box( 'categorydiv', 'vtprd-rule', 'side' ); // Category meta box
        remove_meta_box( 'tagsdiv-post_tag', 'vtprd-rule', 'side' ); // Post tags meta box
        remove_meta_box( 'tagsdiv-vtprd_rule_category', 'vtprd-rule', 'side' ); // vtprd_rule_category tags  
        remove_meta_box( 'relateddiv', 'vtprd-rule', 'side');                  
      } 
 
  }
         
  //v1.1.0.7  New Function - 
  //    add wholesale Product tickbox in PUBLISH metabox for Parent Product
  public  function vtprd_product_data_visibility() {
      global $post, $vtprd_info, $vtprd_rule, $vtprd_rules_set;        

      //error_log( print_r(  'FUNCTION vtprd_product_data_visibility begin' , true ) ); 

      //only do this for PRODUCT
      if( get_post_type() != $vtprd_info['parent_plugin_cpt'] ){  
        return;
      } 
      
      $allowed_html = vtprd_get_allowed_html(); //v2.0.3
      
      $current_visibility = get_post_meta( $post->ID, 'vtprd_wholesale_visibility', true );
      
      ?> 
      &nbsp; &nbsp; 
      <span id="vtprd-wholesale">
      <label class="selectit vtprd-wholesale-visibility-label">
        <input id="vtprd-wholesale-visibility" class="vtprd-wholesale-visibility-class" name="vtprd-wholesale-visibility" value="yes" 
        <?php 
        if ($current_visibility == 'yes'){  //v2.0.3
          $message = ' checked="checked" ';
          echo wp_kses($message ,$allowed_html ); //v2.0.3            
        } ?>  
        type="checkbox">
        <strong>&nbsp; <?php esc_attr_e('Wholesale Product', 'vtprd') ?></strong>
      </label>
      </span>
      <?php 
      
      return;
  }
          
  public  function vtprd_add_metaboxes() {
      global $post, $vtprd_info, $vtprd_rule, $vtprd_rules_set;        

      $this->vtprd_get_or_create_rule(); //v2.0.3 rule creation moved below

      add_meta_box('vtprd-deal-selection',  __('Pricing Deals', 'vtprd') , array(&$this, 'vtprd_deal'), 'vtprd-rule', 'normal', 'high');

  }                   
   
  //---------------------
  //v2.0.3 new function
  // body moved from  function vtprd_add_metaboxes
  //---------------------                                                  
  public function vtprd_get_or_create_rule() {  
      global $post, $vtprd_info, $vtprd_rule, $vtprd_rules_set;
      
      //error_log( print_r(  'function vtprd_get_or_create_rule', true ) );
      
      //v2.0.3  BEGIN
      if (isset($_SESSION['rule_already_retrieved-or-created']) ) {
         $rule_already_created =  sanitize_text_field($_SESSION['rule_already_retrieved-or-created']);
         if ($rule_already_created) {
            return;
         }
      }
         
      $_SESSION['rule_already_retrieved-or-created'] = TRUE;
      
      //NB - THIS SWITCH NEEDS TO BE REMOVED AFTER THE LAST HOOK EXECUTES IN DISPLAYING THE UI!!!!!!!!!!!
      // this is done in vt-pricing-deals.php, just after the new class statement.
      //v2.0.3  END
        
            
      $found_rule = false;                            
      if ($post->ID > ' ' ) {
        $post_id =  $post->ID;
        //v2.1.0 begin - PHP 8.0 was kicking this out as a non-array
        //$vtprd_rules_set   = get_option( 'vtprd_rules_set' ) ;
        $vtprd_rules_set = vtprd_get_rules_set();
        //v2.1.0 end 

         //$sizeof_rules_set = sizeof($vtprd_rules_set);  //v2.1.0
        $sizeof_rules_set = is_array($vtprd_rules_set) ? sizeof($vtprd_rules_set) : 0; //v2.1.0
        for($i=0; $i < $sizeof_rules_set; $i++) {  
           if ($vtprd_rules_set[$i]->post_id == $post_id) {
              $vtprd_rule = $vtprd_rules_set[$i];  //load vtprd-rule               
              $found_rule = true;
              $found_rule_index = $i; 
              $i = $sizeof_rules_set;  
              
              
              //error_log( print_r(  'rule found in ruleset, ID = '.$post_id, true ) );        
              //error_log( var_export($vtprd_rule, true ) );
       
              //***************
              //v2.0.0.9 begin
              //***************
              /*
              There is a bug cascade brought on by Gutenburg and the resulting programming in other plugins.
              If the JS for these other plugins bleed into the rule screen display and cause a JS conflict, 
              then $vtprd_rule->rule_deal_info may have **no** iterations following update.
              So in that case, two things have to happen.
              1. at this point, the damage has been done to $vtprd_rule->rule_deal_info, so put in the default array
              2. send an error message explaining the JS conflict, and send the user to the Settings screen to turn on the switches, 
              and then try the udpate again.             
              */ 
              $sizeof_info = is_array($vtprd_rule->rule_deal_info) ? sizeof($vtprd_rule->rule_deal_info) : 0; //v2.1.0
              //if (sizeof($vtprd_rule->rule_deal_info) == 0) { 
              if ($sizeof_info == 0) {        
                $vtprd_rule->rule_deal_info[] = vtprd_build_rule_deal_info(); 
                //'insert_error_before_selector' => '#vtprd-deal-selection',  //blue-area-title-line
                /* v2.0.3 msg removed
                $vtprd_rule->rule_error_message[] = array( 
                    'insert_error_before_selector' => '#vtprd-deal-selection',  //blue-area-title-line
                    'error_msg'  => __('******* <br> Due to another module mishandling Javascript resources, a Javascript conflict has caused a fatal error on this rule. <br><br> please go to wp-admin/pricing deals rules/pricing deals settings page. <br><br> On the horizontal JUMP TO menu, click on "System Options". <br> at "Remove Extra JS from Rule Page", select "Yes"	<br> at "Remove Extra CSS from Rule Page", select "Yes" <br> and click on "Save Changes." <br><br> Any rules which are not displaying correctly will need to deleted and recreated. <br><br>Test in a fresh browser session.  <br>******* ', 'vtprd') );  
                */
              }               
              //v2.0.0.9 end                           
           }
        }
      } 

      if (!$found_rule) {
        $this->vtprd_build_new_rule();        
      }   
    return;
  }   
                                                    
  public function vtprd_error_messages() {     
      global $post, $vtprd_rule;
      
      //-----------------------------------------
      //v2.0.3 function recoded to use: 
      // wp_add_inline_script
      // wp_add_inline_style
      //-----------------------------------------
      $allowed_html = vtprd_get_allowed_html(); //v2.0.3
      
      //error_log( print_r(  'vtprd_error_messages BEGIN' , true ) );


      $error_msg_count = sizeof($vtprd_rule->rule_error_message);
      
            /* inline datepicker function:
            jQuery(function(jQuery){jQuery.datepicker.setDefaults({"closeText":"Close","currentText":"Today","monthNames":["January","February","March","April","May","June","July","August","September","October","November","December"],"monthNamesShort":["Jan","Feb","Mar","Apr","May","Jun","Jul","Aug","Sep","Oct","Nov","Dec"],"nextText":"Next","prevText":"Previous","dayNames":["Sunday","Monday","Tuesday","Wednesday","Thursday","Friday","Saturday"],"dayNamesShort":["Sun","Mon","Tue","Wed","Thu","Fri","Sat"],"dayNamesMin":["S","M","T","W","T","F","S"],"dateFormat":"MM d, yy","firstDay":1,"isRTL":false});});

            */
      
           /*  VERSIONS TESTED:
           ***************************
            
           1.  NO  <script> </script> DING DING DING
           *2.  NO  <script> </script>  AND change to jQuery(document) syntax
           *3.  added in (from woocommerce) inline dummies
           *4.  //NO  <script> </script>, no JQUERY statement - '$( document ).ready(function() {';
           *5.  boil the statement down to just   (function()
           
           ***************************
           */
           
      //$vtprd_inline_script  = '(function() {';       //NO  <script> </script>, no JQUERY statement, no document statement...           
      //$vtprd_inline_script  = '$( document ).ready(function() {';       //NO  <script> </script>, no JQUERY statement
      //$vtprd_inline_script  = '<script> jQuery(document).ready(function($) {'; 
      $vtprd_inline_script  = 'jQuery(document).ready(function($) {';       //NO  <script> </script>  
      
      
      //FIX - the surrounding single quotes must be doubles.  Separate out the double in a sep statement:  $vtprd_inline_script .= '"';
      
      $vtprd_inline_script .= '$("'; //double quotes surrounding the <div> </div>         
      $vtprd_inline_script .= "<div class='vtprd-error' id='vtprd-error-announcement'>" . __("Please Repair Errors below", "vtprd"); 
      $vtprd_inline_script .= '</div>")';  //double quotes surrounding the <div> </div>
      $vtprd_inline_script .= ".insertBefore('#vtprd-deal-selection');";  
     //error_log( print_r(  'javascript output' , true ) );   
      //loop through all of the error messages 
      //          $vtmax_info['line_cnt'] is used when table formattted msgs come through.  Otherwise produces an inactive css id. 
     for($i=0; $i < $error_msg_count; $i++) { 
       $vtprd_inline_script .= '$("'; //double quotes surrounding the <div> </div> 
       $vtprd_inline_script .= "<div class='vtprd-error'>";
       $vtprd_inline_script .= wp_kses($vtprd_rule->rule_error_message[$i]['error_msg'] ,$allowed_html);
       $vtprd_inline_script .= '</div>")';  //double quotes surrounding the <div> </div>
       $vtprd_inline_script .= ".insertBefore('";
       $vtprd_inline_script .= wp_kses($vtprd_rule->rule_error_message[$i]['insert_error_before_selector'] ,$allowed_html);
       $vtprd_inline_script .= "');";
     //error_log( print_r(  'message loaded into script= ' .$vtprd_rule->rule_error_message[$i]['error_msg'] , true ) );   
     }  //end 'for' loop       
      
     $vtprd_inline_script .= "}); ";   //NO  <script> </script>
     //$vtprd_inline_script .= "}); </script>";
     
     //***************************
     //esc_js makes the JS unusable!!
     //***************************
     //$vtprd_inline_script  = esc_js($vtprd_inline_script);
     
     //error_log( print_r(  '$vtprd_inline_script before add_inline' , true ) );
     //error_log( print_r(  '$vtprd_inline_script= ' .$vtprd_inline_script , true ) ); 
     
     //test with Empty Handle, following woocommerce example:
	/* - NO CHANGE with this	
        		$error_handle = 'vtprd-admin-ui-inline001';
                wp_register_script( $error_handle, '' );
				wp_enqueue_script( $error_handle ); 
                wp_add_inline_script($error_handle, $vtprd_inline_script );  //v2.0.3  
     */

     wp_add_inline_script('vtprd-admin-ui-script',$vtprd_inline_script );  //v2.0.3 
   
     
     //v1.1.8.0 begin - reformulated

      
           /*  VERSIONS TESTED:
           ***************************
            
           1.  NO    DING DING DING
           
           ***************************
           */
     
     //Change the label color to red for fields in error
     if ( (sizeof($vtprd_rule->rule_error_red_fields) > 0 ) || 
          (sizeof($vtprd_rule->rule_error_box_fields) > 0 ) )  {  //v1.1.8.0 added error_box test
      

       $vtprd_inline_style = "";

       
       if (sizeof($vtprd_rule->rule_error_red_fields) > 0 ) {  //v1.1.8.0 added if
         for($i=0; $i < sizeof($vtprd_rule->rule_error_red_fields); $i++) { 
            if ($i > 0) { // if 2nd to n field name, put comma before the name...
              $vtprd_inline_style .= ', ';
            }
            $vtprd_inline_style .= $vtprd_rule->rule_error_red_fields[$i] ;
         }
         //echo '{color:red !important; display:block;}' ;         // display:block added for hidden date err msg fields
         $vtprd_inline_style .= '{color:red !important;} '; //v2.0.3
       }
       
       if (sizeof($vtprd_rule->rule_error_box_fields) > 0 ) {  //v1.1.8.0 added if
         for($i=0; $i < sizeof($vtprd_rule->rule_error_box_fields); $i++) { 
            if ($vtprd_rule->rule_error_box_fields[$i] > ' ')
              if ($i > 0) { // if 2nd to n field name, put comma before the name...
                $vtprd_inline_style .= ', ';
              }

              $vtprd_inline_style .= $vtprd_rule->rule_error_box_fields[$i]; //v2.0.3
            }
         }

         $vtprd_inline_style .= '{border-color:red !important; display:block;}'; //v2.0.3
         
         $vtprd_inline_style = wp_kses($vtprd_inline_style,$allowed_html ); //v2.0.3
        
       //v1.1.8.0 end
           
         wp_add_inline_style('vtprd-admin-ui-style',$vtprd_inline_style );  //v2.0.3 
 
     }

      
      if( $post->post_status == 'publish') { //if post status not = pending, make it so  
          $post_id = $post->ID;
          global $wpdb;
            
            //v2.0.3 begin
            //$wpdb->update( $wpdb->posts, array( 'post_status' => 'pending' ), array( 'ID' => $post_id ) );    //match the post status to pending, as errors exist.
            
            $wpdb->query( 
                $wpdb->prepare( 
                    "UPDATE `".$wpdb->posts."`  SET `post_status` = 'pending'  WHERE `ID` = %s" , 
                    $post_id
                ) 
            );
            //v2.0.3 end          
      } 

  }     

/* **************************************************************
    Deal Selection Metabox
                                                                                     
    Includes: 
    - Rule type info
    - Rule deal info
    - applies-to max info
    - rule catalog/cart display msgs
    - cumulative logic rule switches
************************************************************** */                                                   
  public function vtprd_deal() {     
      global $vtprd_rule_template_framework, $vtprd_deal_structure_framework, $vtprd_deal_screen_framework, $vtprd_rule_display_framework, $vtprd_rule, $vtprd_info, $vtprd_setup_options;
      $selected = 'selected="selected"';
      $checked = 'checked="checked"';
      $disabled = 'disabled="disabled"' ; 
      $vtprdNonce = wp_create_nonce("vtprd-rule-nonce"); //nonce verified in vt-pricing-deals.php
      $allowed_html = vtprd_get_allowed_html(); //v2.0.3


   //error_log( print_r(  'RULE BEGIN OF RULE DISPLAY = ', true ) );
   //error_log( var_export($vtprd_rule, true ) ); 
      //V2.0.3 MOVED error msg handling to enque
    
      $currency_symbol = vtprd_get_currency_symbol();
      
      //v1.1.0.8 begin ==>>  init messages with default value, if blank (cleared out in rules_update )
      if ($vtprd_rule->discount_product_short_msg <= ' ') {
        $vtprd_rule->discount_product_short_msg = $vtprd_info['default_short_msg']; 
      }
      if ($vtprd_rule->discount_product_full_msg <= ' ') {
        $vtprd_rule->discount_product_full_msg = $vtprd_info['default_full_msg']; 
      }
      if ($vtprd_rule->only_for_this_coupon_name <= ' ') {
        $vtprd_rule->only_for_this_coupon_name = $vtprd_info['default_coupon_msg']; 
      }
      //v1.1.0.8 end
      
      //v2.0.0 begin
      /*
      //v1.1.7.1a begin
      if ($vtprd_rule->buy_group_varName_array <= ' ') {
        $vtprd_rule->buy_group_varName_array = $vtprd_info['default_by_varname_msg']; 
      }
      if ($vtprd_rule->action_group_varName_array <= ' ') {
        $vtprd_rule->action_group_varName_array = $vtprd_info['default_by_varname_msg']; 
      }
      //v1.1.7.1a end      
      */
      /*v2.0.0  NO longer necessary, this is now taken care of via the PLACEHOLDER
      if ($vtprd_rule->buy_group_population_info['buy_group_var_name_incl_array']  <= ' ') {
          $vtprd_rule->buy_group_population_info['buy_group_var_name_incl_array'] = $vtprd_info['default_by_varname_msg'];             
      }
      if ($vtprd_rule->buy_group_population_info['buy_group_var_name_excl_array']  <= ' ') {
          $vtprd_rule->buy_group_population_info['buy_group_var_name_excl_array'] = $vtprd_info['default_by_varname_msg'];             
      }      
      if ($vtprd_rule->action_group_population_info['action_group_var_name_incl_array']  <= ' ') {
          $vtprd_rule->action_group_population_info['action_group_var_name_incl_array'] = $vtprd_info['default_by_varname_msg'];             
      }
      if ($vtprd_rule->action_group_population_info['action_group_var_name_excl_array']  <= ' ') {
          $vtprd_rule->action_group_population_info['action_group_var_name_excl_array'] = $vtprd_info['default_by_varname_msg'];             
      }  
      */  
      //v2.0.0 end
         
      //**********************************************************************
      //IE CSS OVERRIDES, done here to ensure they're last in line...
      //**********************************************************************
      //v2.0.3 begin
      
      // 1. remove IE support

      // end override
       
      //This Div only shows if there is a JS error in the customer implementation of the plugin, as the JS hides this div, if the JS is active
      //vtprd_show_help_if_js_is_broken(); 

       /*
       <div class="hide-by-jquery">
        <span class="">< ?php esc_attr_e('If you can see this, there is a JavaScript Error on the Page. Hover over this &rarr;', 'vtprd'); ? > </span>
            < ?php vtprd_show_help_tooltip($context = 'onlyShowsIfJSerror', $location = 'title'); ? >
       </div>
       */
       //BANNER AND BUTTON AREA
       
       $homeURL1 = VTPRD_URL.'/admin/images/upgrade-bkgrnd-banner.jpg';
       $homeURL2 = VTPRD_URL.'/admin/images/sale-circle.png';
       ?>
                         

     
    <img id="pricing-deals-img-preload" alt="" src="<?php echo esc_url($homeURL1);?>" />
 		<div id="upgrade-title-area">
      <a  href=" <?php echo esc_url(VTPRD_PURCHASE_PRO_VERSION_BY_PARENT); ?> "  title="Purchase Pro">
      <img id="pricing-deals-img" alt="help" height="40px" width="40px" src="<?php echo esc_url($homeURL2);?>" />
      </a>      
      <h2>
        <?php esc_attr_e('Pricing Deals', 'vtprd'); ?>
        <?php if(defined('VTPRD_PRO_DIRNAME')) {  
                esc_attr_e(' Pro', 'vtprd');
              }
        ?>    
        
        </h2>  
      
      <?php if(!defined('VTPRD_PRO_DIRNAME')) {  ?> 
          <span class="group-power-msg">
            <strong><em><?php esc_attr_e('Create rules for Any Group you can think of, and More!', 'vtprd'); ?></em></strong>
            <?php /* 
              - Product Category
              - Pricing Deal Custom Category
              - Logged-in Status
              - Product
              - Variations!
                */ ?> 
          </span> 
          <span class="buy-button-area">
            <a href="<?php echo esc_url(VTPRD_PURCHASE_PRO_VERSION_BY_PARENT);?>" class="help tooltip tooltipWide buy-button">
                <span class="buy-button-label"><?php esc_attr_e('Get Pricing Deals Pro', 'vtprd'); ?></span>
                <b> <?php vtprd_show_help_tooltip_text('upgradeToPro'); ?> </b>
            </a>
          </span> 
      <?php }  ?>
          
    </div>  
    
      <?php //RULE EXECUTION TYPE 
      $currency_symbol = get_woocommerce_currency_symbol(); //v2.0.3
      ?> 
      <div class="display-virtual_box  top-box">                           
        
        <?php //************************ ?>
        <?php //HIDDEN FIELDS BEGIN ?>
        <?php //************************ ?>
        <?php //RULE EXECUTION blue-dropdownS - only one actually displays at a time, depending on ?>
        <input type="hidden" id="vtprd_nonce" name="vtprd_nonce" value="<?php echo wp_kses($vtprdNonce,$allowed_html); ?>" />
        <?php //Hidden switch to communicate with the JS that the data is 1st time screenful ?>
        <input type="hidden" id="firstTimeBackFromServer" name="firstTimeBackFromServer" value="yes" />        
        <input type="hidden" id="upperSelectsFirstTime" name="upperSelectsFirstTime" value="yes" />
        <input type="hidden" id="upperSelectsDoneSw" name="upperSelectsDoneSw" value="" />
        <input type="hidden" id="catalogCheckoutMsg" name="catalogCheckoutMsg" value="<?php esc_attr_e('Message unused for Catalog Discount', 'vtprd');?>" />
        <input type="hidden" id="vtprd-moreInfo" name="vtprd-docTitle" value="<?php esc_attr_e('More Info', 'vtprd');?>" /> <?php //v1.0.5 added 2nd button ?>
        <input type="hidden" id="vtprd-docTitle" name="vtprd-docTitle" value="<?php esc_attr_e('- Help! -', 'vtprd');?>" /> 
        <input type="hidden" id="currencySymbol" name="currencySymbol" value="<?php echo wp_kses($currency_symbol,$allowed_html);?>" /> <?php //v1.1.8.0 ?>        
        <?php
        //v2.0.0.8 begin
        $decimal_separator  = get_option( 'woocommerce_price_decimal_sep' );
        if ($decimal_separator == ',') {
          $stepValue = '0,01';
          $placeholderValue = '0,00';
          $typeValue = 'text'; //allows comma to be input, but deactivates JS auto number checking
        } else {
          $stepValue = '0.01';
          $placeholderValue = '0.00';
          $typeValue = 'number';                                                                     
        }                           
        ?>
        <input type="hidden" id="stepValue" name="stepValue" value="<?php echo wp_kses($stepValue,$allowed_html);?>" />
        <input type="hidden" id="placeholderValue" name="placeholderValue" value="<?php echo wp_kses($placeholderValue,$allowed_html); ?>" />
        <input type="hidden" id="typeValue" name="typeValue" value="<?php echo wp_kses($typeValue,$allowed_html); ?>" />
        <?php //v2.0.0.8 end ?>
                
        <?php //v1.1.8.1 begin  
        global $post; 
        // ajax-ruleID value is sent down with the button click
        ?> 
        <input type="hidden" id="vtprd-cloneRule" name="vtprd-cloneRule" value="<?php esc_attr_e('Clone This Rule', 'vtprd');?>" />
        <input type="hidden" id="vtprd-url" name="vtprd-url" value="<?php echo esc_url(VTPRD_URL); ?>" />
        <input type="hidden" id="ajaxRuleID" name="ajaxRuleID" value="<?php echo wp_kses($post->ID,$allowed_html); ?>" /> 
        <?php //v1.1.8.1 end  ?>
        <input type="hidden" id="vtprd-copyForSupport" name="vtprd-copyForSupport" value="<?php esc_attr_e('Copy to Support', 'vtprd');?>" />
        
        <?php //v2.0.0.2 begin added to handle non-standard installations in copy for support ?>
        <input type="hidden" id="vtprd-admin-url" name="vtprd-admin-url" value="<?php echo esc_url(VTPRD_ADMIN_URL);?>" />
        <?php //v2.0.0.2 end ?>

        <?php 
           /*
            Assign a numeric value to the switch
              showing HOW MANY selects have data
                on 1st return from server...
           */           
           $data_sw = '0';
           
           //test the Various group filter selects and set a value...
           switch( true) {
              case ( ($vtprd_rule->get_group_filter_select > ' ') &&
                     ($vtprd_rule->get_group_filter_select != 'choose') ):
                  $data_sw = '5';
                break;
              case ( ($vtprd_rule->buy_group_filter_select > ' ') &&
                     ($vtprd_rule->buy_group_filter_select != 'choose') ):
                  $data_sw = '4';
                break;  
              case ( ($vtprd_rule->minimum_purchase_select > ' ') &&
                     ($vtprd_rule->minimum_purchase_select != 'choose') ):              
                  $data_sw = '3';
                break;   
              case ( ($vtprd_rule->pricing_type_select > ' ') &&
                     ($vtprd_rule->pricing_type_select != 'choose') ):
                  $data_sw = '2';
                break;   
              case ( ($vtprd_rule->cart_or_catalog_select > ' ') &&
                     ($vtprd_rule->cart_or_catalog_select != 'choose') ):              
                  $data_sw = '1';
                break;                    
             } 
             
             /*  upperSelectsHaveDataFirstTime has values from 0 => 5
             value = 0  no previous data saved 
             value = 1  last run got to:  cart_or_catalog_select
             value = 2  last run got to:  pricing_type_select
             value = 3  last run got to:  minimum_purchase_select
             value = 4  last run got to:  buy_group_filter_select
             value = 5  last run got to:  get_group_filter_select
             */
        ?>
        <input type="hidden" id="upperSelectsHaveDataFirstTime" name="upperSelectsHaveDataFirstTime" value="<?php echo wp_kses($data_sw,$allowed_html); ?>" />
        
        <input type="hidden" id="templateChanged" name="templateChanged" value="no" /> 
        
        <?php //Statuses used for switching of the upper dropdowns ?>
        <input type="hidden" id="select_status_sw"  name="select_status_sw"  value="no" />
        <input type="hidden" id="chg_detected_sw"  name="chg_detected_sw"    value="no" />   <?php //v1.0.7.6 ?>
        
        <?php //pass these two messages up to JS, translated here if necessary ?>
        <input type="hidden" id="fullMsg" name="fullMsg" value="<?php echo wp_kses($vtprd_info['default_full_msg'],$allowed_html);?>" />    
        <input type="hidden" id="shortMsg" name="shortMsg" value="<?php echo wp_kses($vtprd_info['default_short_msg'],$allowed_html);?>" />
        <input type="hidden" id="couponMsg" name="couponMsg" value="<?php echo wp_kses($vtprd_info['default_coupon_msg'],$allowed_html);?>" />   <?php //v1.1.0.8  ?>
  
        <input id="pluginVersion" type="hidden" value="<?php if(defined('VTPRD_PRO_DIRNAME')) { echo wp_kses("proVersion",$allowed_html); } else { echo wp_kses("freeVersion",$allowed_html); } ?>" name="pluginVersion" />  
        <input id="rule_template_framework" type="hidden" value="<?php echo wp_kses($vtprd_rule->rule_template,$allowed_html);?>" name="rule_template_framework" />
              
           
        <?php //************************ ?>
        <?php //HIDDEN FIELDS END ?>
        <?php //************************ 
        
        $homeURL = VTPRD_URL.'/admin/images/tab-icons.png';
        $hoverhelpURL = VTPRD_URL.'/admin/images/help.png';
        ?>

        <div class="template-area clear-left">  
          
          <div class="clear-left" id="blue-area-title-line"> 
              <img id="blue-area-title-icon" src="<?php echo esc_url($homeURL);?>" width="1" height="1" />
              <span class="section-headings column-width2" id="blue-area-title">  <?php esc_attr_e('Blueprint', 'vtprd');?></span>             
          </div> <?php //blue-area-title-line ?>
          
          <div class="clear-left" id="first-blue-line">                          
                                                                             
              <div class="left-column"  style="margin-top: 14px;" >                              
                 <?php //mwn20140414 added id ?>
                 <label id="cart-or-catalog-select-label" class="hasWizardHelpRight"  for="<?php echo wp_kses($vtprd_rule_display_framework['cart_or_catalog_select']['label']['for'],$allowed_html);?>"><?php echo wp_kses($vtprd_rule_display_framework['cart_or_catalog_select']['label']['title'],$allowed_html);?></label>  
                 <?php vtprd_show_object_hover_help ('cart_or_catalog_select', 'wizard'); ?> 
              </div>
              <div class="blue-dropdown  cart-or-catalog" id="cart-or-catalog-select-area"> 
                  <label class="cart-or-catalog-label">&nbsp;<?php esc_attr_e('Purchase Discount &nbsp;&nbsp;&nbsp;/&nbsp;&nbsp; Store Display Discount', 'vtprd');?></label> 
                  <?php //vtprd_show_object_hover_help ('cart-or-catalog-select', 'wizard'); ?>
                  <div class="switch-field-blueprint" id="" class="clear-left" >                    
                        
                        <input id="cart-or-catalog-Cart" class="cart-or-catalog" name="cart-or-catalog-select" value="cart" type="radio"  
                        <?php if ( 'cart' == $vtprd_rule->cart_or_catalog_select) { echo wp_kses($checked ,$allowed_html); } ?> >
                        <label for="cart-or-catalog-Cart" id="cart-or-catalog-Cart-label">&nbsp;&nbsp;CART Deal&nbsp;&nbsp;</label> 
                     
                        <input id="cart-or-catalog-Catalog" class="cart-or-catalog" name="cart-or-catalog-select" value="catalog" type="radio"  
                        <?php if ( 'catalog' == $vtprd_rule->cart_or_catalog_select) { echo wp_kses($checked ,$allowed_html); } ?> >
                        <label for="cart-or-catalog-Catalog" id="cart-or-catalog-Catalog-label"> CATALOG Discount</label> 
                                          
                  </div>  
                  <?php //v2.0.0.1 img old style below style="margin-top:24px;margin-left:15px;"  
                  ?> 
                <img class="hasHoverHelp2" width="18px" style="float:left;margin-left:15px;" alt=""  src="<?php echo esc_url($hoverhelpURL);?>" />
                <?php vtprd_show_object_hover_help ('cart_or_catalog_select', 'small'); ?> 
              </div>               

          </div> <?php //end first blue-line ?> 
          
          <div class="horiz-line-div">&nbsp;</div> 

          <div class="blue-line  clear-left" id="pricing_type_select_box">                                  
               <span class="left-column" style="padding-top: 5px;">                              
                 <?php //mwn20140414 added id ?>
                 <label id="pricing-type-select-label" class="hasWizardHelpRight"   for="<?php echo wp_kses($vtprd_rule_display_framework['pricing_type_select']['label']['for'] ,$allowed_html);?>"><?php echo wp_kses($vtprd_rule_display_framework['pricing_type_select']['label']['title'] ,$allowed_html);?></label>
                 <?php vtprd_show_object_hover_help ('pricing_type_select', 'wizard'); ?> 
               </span>
               <span class="blue-dropdown  right-column" id="pricing-type-select-area">   
                 <select id="<?php echo wp_kses($vtprd_rule_display_framework['pricing_type_select']['select']['id'] ,$allowed_html);?>" class="<?php echo wp_kses($vtprd_rule_display_framework['pricing_type_select']['select']['class'] ,$allowed_html); ?>  " name="<?php echo wp_kses($vtprd_rule_display_framework['pricing_type_select']['select']['name'] ,$allowed_html);?>" tabindex="<?php echo wp_kses($vtprd_rule_display_framework['pricing_type_select']['select']['tabindex'] ,$allowed_html);?>" >          
                   <?php
                   for($i=0; $i < sizeof($vtprd_rule_display_framework['pricing_type_select']['option']); $i++) { 
                   ?>                             
                      <option id="<?php echo wp_kses($vtprd_rule_display_framework['pricing_type_select']['option'][$i]['id'] ,$allowed_html);?>"  class="<?php echo wp_kses($vtprd_rule_display_framework['pricing_type_select']['option'][$i]['class'] ,$allowed_html);?>"  value="<?php echo wp_kses($vtprd_rule_display_framework['pricing_type_select']['option'][$i]['value'] ,$allowed_html);?>"   <?php if ($vtprd_rule_display_framework['pricing_type_select']['option'][$i]['value'] == $vtprd_rule->pricing_type_select )  { echo wp_kses($selected ,$allowed_html);} ?> >  <?php echo wp_kses($vtprd_rule_display_framework['pricing_type_select']['option'][$i]['title'] ,$allowed_html);?> </option>
                   <?php } ?> 
                 </select>  
                  <img  class="hasHoverHelp2" width="18px" style="margin-top:5px;margin-left:13px;" alt=""  src="<?php echo esc_url($hoverhelpURL);?>" />  
                  <?php vtprd_show_object_hover_help ('pricing_type_select', 'small'); ?>                                                        
               </span> 
          </div> <?php //end blue-line ?>
          
          <div class="horiz-line-div" id="deal-action-horiz-line">&nbsp;</div> 

          <div class="blue-line  clear-left" id="deal-action-line" style="margin-top: -10px;">  
               <div class="left-column" style="margin-top: 14px;" >                                            
                 <?php //mwn20140414 added id ?>
                 <label id="minimum-purchase-select-label" class="hasWizardHelpRight" for="<?php echo wp_kses($vtprd_rule_display_framework['minimum_purchase_select']['label']['for'] ,$allowed_html);?>"><?php echo wp_kses($vtprd_rule_display_framework['minimum_purchase_select']['label']['title'] ,$allowed_html);?></label>
                 <?php vtprd_show_object_hover_help ('minimum_purchase_select', 'wizard'); ?> 
               </div>
               <div class="blue-dropdown  blue-dropdown-minimum  right-column" id="minimum-purchase-select-area">  
                  <label class="minimum-purchase-label"><?php esc_attr_e('&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; "Buy 3 discount the *next* item" &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; / &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; "Buy 3 discount 1 of them" ', 'vtprd');?></label> 
                  <?php //vtprd_show_object_hover_help ('minimum-purchase-select', 'wizard'); ?>
                  <div class="switch-field-blueprint" id="" class="clear-left">                    
                                                                         
                        <input id="minimum-purchase-Next" class="minimum-purchase" name="minimum-purchase-select" value="next" type="radio" 
                        <?php if ( 'next' == $vtprd_rule->minimum_purchase_select) { echo wp_kses($checked ,$allowed_html); } ?> >
                        
                        <label for="minimum-purchase-Next" id="minimum-purchase-Next-label"> Discount Next item added to cart</label> 
                                                   
                        <input id="minimum-purchase-None" class="minimum-purchase" name="minimum-purchase-select" value="none" type="radio"
                        <?php if ( 'none' == $vtprd_rule->minimum_purchase_select) { echo wp_kses($checked ,$allowed_html); } ?> >
                        
                        <label for="minimum-purchase-None" id=""> Discount item in cart already</label> 
                                                              
                  </div>
                <img  class="hasHoverHelp2" width="18px" style="margin-top:22px;margin-left:15px;" alt=""  src="<?php echo esc_url($hoverhelpURL);?>" />                
                <?php vtprd_show_object_hover_help ('minimum_purchase_select', 'small'); ?>                                          
              </div>         
          </div> <?php //end blue-line ?>  
          
          <div class="horiz-line-div">&nbsp;</div> 
                                        
          <div class="blue-line  blue-line-less-top  clear-left">
              <span class="left-column">                                                      
                <label class="scheduling-label hasWizardHelpRight" id="scheduling-label-item"><?php esc_attr_e('Deal Schedule', 'vtprd');?></label>   
                <?php vtprd_show_object_hover_help ('scheduling', 'wizard'); ?>
              </span>
              <span class="blue-dropdown  scheduling-group  right-column" id="scheduling-area">   
                <span class="date-line" id='date-line-0'>                               
                <?php //   <label class="scheduling-label">Scheduling</label> ?>                                              
                    <span class="date-line-area">  
                      <?php  $this->vtprd_rule_scheduling(); ?> 
                    </span> 
                    <span class="on-off-switch">                              
                    <?php //     <label for="rule-state-select">On/Off Switch</label>  ?> 
                       <select id="<?php echo wp_kses($vtprd_rule_display_framework['rule_on_off_sw_select']['select']['id'] ,$allowed_html);?>" class="<?php echo wp_kses($vtprd_rule_display_framework['rule_on_off_sw_select']['select']['class'] ,$allowed_html);?>" name="<?php echo wp_kses($vtprd_rule_display_framework['rule_on_off_sw_select']['select']['name'] ,$allowed_html);?>" tabindex="<?php echo wp_kses($vtprd_rule_display_framework['rule_on_off_sw_select']['select']['tabindex'] ,$allowed_html); ?>" >          
                         <?php
                         for($i=0; $i < sizeof($vtprd_rule_display_framework['rule_on_off_sw_select']['option']); $i++) { 
                         ?>                             
                            <option id="<?php echo wp_kses($vtprd_rule_display_framework['rule_on_off_sw_select']['option'][$i]['id'] ,$allowed_html); ?>"  class="<?php echo wp_kses($vtprd_rule_display_framework['rule_on_off_sw_select']['option'][$i]['class'] ,$allowed_html); ?>"  value="<?php echo wp_kses($vtprd_rule_display_framework['rule_on_off_sw_select']['option'][$i]['value'] ,$allowed_html); ?>"   <?php if ($vtprd_rule_display_framework['rule_on_off_sw_select']['option'][$i]['value'] == $vtprd_rule->rule_on_off_sw_select )  { echo wp_kses($selected ,$allowed_html);} ?> >  <?php echo wp_kses($vtprd_rule_display_framework['rule_on_off_sw_select']['option'][$i]['title'] ,$allowed_html);?> </option>
                         <?php } ?> 
                       </select>                        
                    </span>                                
                </span> 
                    <img  class="hasHoverHelp2" width="18px" alt="" style="margin-top:30px;margin-left:9px;"  src="<?php echo esc_url($hoverhelpURL);?>" /> 
                    <?php vtprd_show_object_hover_help ('scheduling', 'small'); ?>                                                    
              </span>      
          </div> <?php //end blue-line ?>
          
          <div class="horiz-line-div">&nbsp;</div> 

          <div class="blue-line  clear-left" id="schedule-box" style="margin-top: -10px;">
              <div class="left-column">                                                      
                &nbsp;
              </div>
              <div class="right-column">       
                  <div class="blue-dropdown  rule-type" id="rule-type-select-area" style="margin-top: -2px;"> 
                      <label id="show-me-label" class="rule-type-label">&nbsp;<?php esc_attr_e('Show Me', 'vtprd');?></label> 
                      <div class="switch-field-blueprint-small"  class="clear-left"> 
                                         
                          <input id="basicSelected" class="basic-advancedClass" name="rule-type-select" value="basic" type="radio"
                          <?php if ( 'basic' == $vtprd_rule->rule_type_select) { echo wp_kses($checked ,$allowed_html);} ?>   >
                          <label for="basicSelected"> Basic Rule</label> 
                                                     
                          <input id="advancedSelected" class="basic-advancedClass" name="rule-type-select" value="advanced" type="radio"
                          <?php if ( 'advanced' == $vtprd_rule->rule_type_select) { echo wp_kses($checked ,$allowed_html); } ?>   >
                          <label for="advancedSelected"> Advanced Rule</label>                    
                      
                      </div> 
                        <?php //v2.0.0.1 img old style below style="margin-top:24px;margin-left:15px;"  ?>
                      <img class="hasHoverHelp2" width="18px" style="float:left;margin-left:15px;" alt=""  src="<?php echo esc_url($hoverhelpURL);?>" />
                      <?php vtprd_show_object_hover_help ('rule-type-select', 'small'); ?> 
                  </div>

                   <?php //v1.1.6.7 begin 
                      //v2.0.0
                      //--------------------------------------------------------------------                
                      //Discount Equal or Lesser Value Item first
                      //- Discount the item(s) in the GET Group of equal or lesser value to the most expensive item in the BUY Group    
                      //--------------------------------------------------------------------  
                   ?> 
                   <div class="blue-dropdown cheapest-type" id="apply-to-cheapest-select-area"> 
                      <div style="float:left;">
                        <label class="wizard-type-label" id="apply-to-cheapest-label">&nbsp;<?php esc_attr_e('Apply Discount to &nbsp;&nbsp; - which - &nbsp;&nbsp; Cart Item First', 'vtprd');?></label> 
                        <select id="<?php echo wp_kses($vtprd_rule_display_framework['apply_deal_to_cheapest_select']['select']['id'] ,$allowed_html);?>" class="<?php echo wp_kses($vtprd_rule_display_framework['apply_deal_to_cheapest_select']['select']['class'] ,$allowed_html);?>" name="<?php echo wp_kses($vtprd_rule_display_framework['apply_deal_to_cheapest_select']['select']['name'] ,$allowed_html);?>" tabindex="<?php echo wp_kses($vtprd_rule_display_framework['apply_deal_to_cheapest_select']['select']['tabindex'] ,$allowed_html);?>" >          
                           <?php
                           for($i=0; $i < sizeof($vtprd_rule_display_framework['apply_deal_to_cheapest_select']['option']); $i++) { 
                           ?>                             
                              <option id="<?php echo wp_kses($vtprd_rule_display_framework['apply_deal_to_cheapest_select']['option'][$i]['id'] ,$allowed_html);?>"  class="<?php echo wp_kses($vtprd_rule_display_framework['apply_deal_to_cheapest_select']['option'][$i]['class'] ,$allowed_html);?>"  value="<?php echo wp_kses($vtprd_rule_display_framework['apply_deal_to_cheapest_select']['option'][$i]['value'] ,$allowed_html);?>"   <?php if ($vtprd_rule_display_framework['apply_deal_to_cheapest_select']['option'][$i]['value'] == $vtprd_rule->apply_deal_to_cheapest_select )  { echo wp_kses($selected ,$allowed_html);} ?> >  <?php echo wp_kses($vtprd_rule_display_framework['apply_deal_to_cheapest_select']['option'][$i]['title'] ,$allowed_html);?> </option>
                           <?php } ?> 
                        </select> 
                      </div>
                      <img class="hasHoverHelp2" width="18px" style="margin-top:24px;margin-left:13px;" alt=""  src="<?php echo esc_url($hoverhelpURL);?>" />
                      <?php vtprd_show_object_hover_help ('apply_deal_to_cheapest', 'small'); ?> 
                   </div>                   
                   <?php //v1.1.6.7 end ?>                    
                                               
                     
              </div>
          </div> <?php //end blue-line ?>
    
          <?php //v1.0.9.0 begin  
           $memory = wc_let_to_num( WP_MEMORY_LIMIT );
      
      		 //v1.1.1 begin - REMOVED MEMORY LIMIT TEST
           //if ( $memory < 67108864 ) {     //test for 64mb             
           if ( $memory < 1 ) {     //test for 64mb 
           //v1.1.1 end   
          ?>
          <div class="blue-line  clear-left"> 
              <span class="left-column">                                                      
                &nbsp;
              </span>
              <span class="right-column">     			     
                 <?php
                 $message = 'We recommend a WP Memory Limit: of 512mb';
                 echo wp_kses($message ,$allowed_html); //v2.0.3
                 ?> 
              </span>                 
          </div> <?php //end blue-line ?>
          <?php } //v1.0.9.0 end ?>
          
          
      </div> <?php //end template-area ?>                       

     </div> <?php //end top-box ?>                
     
  <div class="display-virtual_box hideMe" id="lower-screen-wrapper" >

  
      <?php //****************  
            //DEAL INFO GROUP  
            //**************** ?> 
 
     <div class="display-virtual_box  clear-left" id="rule_deal_info_group">  
                       
      <?php // for($k=0; $k < sizeof($vtprd_rule->rule_deal_info[$k]); $k++) {  ?> 
      <?php  for($k=0; $k < sizeof($vtprd_rule->rule_deal_info); $k++) {  ?> 
        <?php  $message = '_' .$k;  ?>        
      <div class="display-virtual_box rule_deal_info" id="rule_deal_info_line<?php echo wp_kses($message ,$allowed_html);?>">   
        <div class="display-virtual_box" id="buy_info<?php echo wp_kses($message ,$allowed_html); ?>">  
         
           <input id="hiddenDealInfoLine<?php echo wp_kses($message ,$allowed_html); ?>" type="hidden" value="lineActive" name="dealInfoLine<?php echo wp_kses($message ,$allowed_html); ?>" />

           <?php 
              //*****************************************************
              //set the switch used on the screen for JS data check 
              //*****************************************************  ?>
           <?php //end switch ************************************** ?> 

         <div class="screen-box buy_group_title_box">
            <span class="buy_group_title-area">
              <img class="buy_amt_title_icon" src="<?php echo esc_url(VTPRD_URL.'/admin/images/tab-icons.png');?>" width="1" height="1" />              
              
              <?php //EITHER / OR TITLE BASED ON DISCOUNT PRICING TYPE ?>
              <span class="section-headings first-level-title showBuyAsDiscount" id="buy_group_title_asDiscount">
                <?php esc_attr_e('Discount Group ', 'vtprd');?>
              </span>
              <span class="section-headings first-level-title showBuyAsBuy" id="buy_group_title_asBuy">
                <?php esc_attr_e('Qualify Group', 'vtprd');?>
                <span class="label-no-cap" style="color:#888;font-style:italic;font-family: Arial,Helvetica,sans-serif;">&nbsp;&nbsp;&nbsp;( Buy Group )</span>                
              </span>          
            </span>

         </div><!-- //buy_group_title_box --> 
 

      <div class="screen-box buy_group_box" id="buy_group_box<?php echo wp_kses($message ,$allowed_html); ?>" >
            
          <div class="group-product-filter-box clear-left" id="buy-group-product-filter-box">            
            <span class="left-column">
                <span class="title  hasWizardHelpRight" id="buy_group_title">
                  <a id="buy_group_title_anchor" class="title-anchors second-level-title" href="<?php echo esc_js('javascript:void(0);');?>"><span class="showBuyAsBuy"><?php esc_attr_e('Select Group By', 'vtprd');?></span><span class="showBuyAsDiscount"><?php esc_attr_e('Select Group By', 'vtprd');?></span> </a>                    
                  <span class="required-asterisk">* </span>                    
                </span>
                <?php vtprd_show_object_hover_help ('inPop', 'wizard'); ?> 
                 
            </span>
            
            <span class="dropdown  buy_group  right-column" id="buy_group_dropdown">              
               <select id="<?php echo wp_kses($vtprd_rule_display_framework['inPop']['select']['id'] ,$allowed_html);?>" class="<?php echo wp_kses($vtprd_rule_display_framework['inPop']['select']['class'] ,$allowed_html);?> " name="<?php echo wp_kses($vtprd_rule_display_framework['inPop']['select']['name'] ,$allowed_html);?>" tabindex="<?php //echo $vtprd_rule_display_framework['inPop']['select']['tabindex']; ?>" >          
                 <?php
                 for($i=0; $i < sizeof($vtprd_rule_display_framework['inPop']['option']); $i++) { 
                      
                      //pick up the free/pro version of the title => in this case, title and title3
                      $title = $vtprd_rule_display_framework['inPop']['option'][$i]['title'];
                      if ( ( defined('VTPRD_PRO_DIRNAME') ) &&
                           ( isset($vtprd_rule_display_framework['inPop']['option'][$i]['title3']) ) &&    //v2.0.3
                           ( $vtprd_rule_display_framework['inPop']['option'][$i]['title3'] > ' ' ) ) {
                        $title = $vtprd_rule_display_framework['inPop']['option'][$i]['title3'];                        
                      }               
                 ?>                             
                    <option id="<?php echo wp_kses($vtprd_rule_display_framework['inPop']['option'][$i]['id'] ,$allowed_html); ?>"  class="<?php echo wp_kses($vtprd_rule_display_framework['inPop']['option'][$i]['class'] ,$allowed_html); ?>"  value="<?php echo wp_kses($vtprd_rule_display_framework['inPop']['option'][$i]['value'] ,$allowed_html); ?>"   <?php if ($vtprd_rule_display_framework['inPop']['option'][$i]['value'] == $vtprd_rule->inPop )  { echo wp_kses($selected ,$allowed_html); } ?> >  <?php echo wp_kses($title ,$allowed_html); ?> </option>
                 <?php } ?> 
               </select> 
            
               <span class="shortIntro  shortIntro2" >
                  <img  class="hasHoverHelp2" width="18px" alt=""  src="<?php echo esc_url($hoverhelpURL);?>" /> 
                 <?php vtprd_show_object_hover_help ('inPop', 'small');?>
               </span>                

              <div class="show-and-or-switches" id="buy-show-and-or-switches">                          
                <label class="show-and-or-switches-label"><?php esc_attr_e('Show And/Or"s', 'vtprd');?></label>
                <div class="switch-field">               
                  <span class="hasWizardHelpRight">
                    <input id="buy-group-show-and-or-switches-YesSelect" class="buy-group-show-and-or-switches" name="buy_group_show_and_or_switches" value="yes" type="radio" <?php if ( $vtprd_rule->buy_group_population_info['buy_group_show_and_or_switches'] == 'yes') { echo wp_kses($checked ,$allowed_html); } ?> >
                    <label for="buy-group-show-and-or-switches-YesSelect">Yes</label>
                  </span> 
                  <?php vtprd_show_object_hover_help ('buy_group_show_and_or_switches_YesSelect', 'wizard'); ?> 
                  <span class="hasWizardHelpRight">                                                       
                    <input id="buy-group-show-and-or-switches-NoSelect"  class="buy-group-show-and-or-switches" name="buy_group_show_and_or_switches" value="no"  type="radio" <?php if ( $vtprd_rule->buy_group_population_info['buy_group_show_and_or_switches'] == 'no' ) { echo wp_kses($checked ,$allowed_html); } ?> > 
                    <label for="buy-group-show-and-or-switches-NoSelect" id="buy-group-show-and-or-switches-NoSelect-label">No</label>
                  </span>
                  <?php vtprd_show_object_hover_help ('buy_group_show_and_or_switches_NoSelect', 'wizard'); ?> 
                </div> 
              </div>
                           
               <span class="buy_group_line_remainder_class" id="buy_group_line_remainder">   
                  <?php $this->vtprd_buy_group_cntl(); ?> 
               </span>                
               
               <?php  /* v1.1 "Product must be in the Filter Group" messaging removed!  */ ?>                          
            </span>  
          </div> <!-- //buy-group-product-filter-box -->                                                                       

       
         
         <?php  
         //*****************************
         //v1.1.8.0 begin
         //*****************************
         $message = '_' .$k; //v2.0.3
         ?>
         
        <div id="bulk-box">   <?php //Bulk Buying ?>
            <div class="display-virtual_box pricing_table_info" id="pricing_table_info<?php echo wp_kses($message ,$allowed_html);?>"> 
             <div class="screen-box pricing_table_group_title_box">
                <span class="title  hasWizardHelpRight" id="pricing_table_title">
                  <a id="pricing_table_title_anchor" class="title-anchors second-level-title" href="<?php echo esc_js('javascript:void(0);');?>"><span class="showBuyAsBuy"><?php esc_attr_e('Bulk Pricing Table', 'vtprd');?></span><span class="showBuyAsDiscount"><?php esc_attr_e('Bulk Pricing Table', 'vtprd');?></span> </a>                    
                  <span class="required-asterisk">* </span>                    
                </span>
                <?php vtprd_show_object_hover_help ('pricingTable', 'wizard'); ?> 
             </div><!-- //pricing_table_group_title_box -->


            <?php 
              $bulk_deal_method_units = false;   
              $bulk_deal_method_currency = false;
              $bulk_deal_CountBy_each = false;
              $bulk_deal_CountBy_all = false;
              $bulk_deal_method_units_hideme = false;
              $bulk_deal_method_currency_hideme = 'hideMe';
              switch( $vtprd_rule->bulk_deal_method ) {
                case 'units':
                    $bulk_deal_method_units = $selected;
                  break;
                case 'currency':
                    $bulk_deal_method_currency = $selected;
                    $bulk_deal_method_units_hideme = 'hideMe';
                    $bulk_deal_method_currency_hideme = false;                 
                  break; 
                default:  
                    $bulk_deal_method_units = $selected;
                  break;                                                                    
              }
              switch( $vtprd_rule->bulk_deal_qty_count_by ) {
                case 'each':
                    $bulk_deal_CountBy_each = $selected;
                  break;
                case 'all':
                    $bulk_deal_CountBy_all = $selected;
                  break;
                default:  
                    $bulk_deal_CountBy_all = $selected;
                  break;                                                                          
              }              
            ?> 
             
             <div class="screen-box pricing_table_body_box">
               
                <div class="screen-box pricing_table_method_count_box  clear-left"> 
                  <span class="clear-left" id="pricing_table_method_box"> 
                       <span class="pricing_table_method_type">
                          <label class="pricing_table-method_label" ><?php esc_attr_e('Count by Units or Currency', 'vtprd');?></label>
                          <select id="bulkMethodIn" class="clear-left" name="bulkMethodIn" tabindex="">                                                                
                              <option id="bulkMethodUnits" class="bulkMethodInOptions" <?php echo wp_kses($bulk_deal_method_units ,$allowed_html);?> value="units" ><?php esc_attr_e('Units &nbsp;&nbsp;- &nbsp; count by product units  ', 'vtprd');?></option>
                              <option id="bulkMethodCurrency" class="bulkMethodInOptions"  <?php echo wp_kses($bulk_deal_method_currency ,$allowed_html);?> value="currency" >
                                      <?php 
                                          esc_attr_e('Currency &nbsp;&nbsp;- &nbsp; count by ', 'vtprd');
                                          echo wp_kses($currency_symbol ,$allowed_html);
                                          esc_attr_e(' value  ', 'vtprd');
                                      ?>
                              </option>                                                                                  
                          </select>
                       </span>
                  </span> 
   
                   <span class="" id="pricing_table_CountBy_box"> 
                       <span class="pricing_table_CountBy_type">
                          <label class="pricing_table_CountBy-label" ><?php esc_attr_e('Begin / End Ranges Apply To', 'vtprd');?></label>
                          <select id="bulkCountByIn" class="clear-left" name="bulkCountByIn" tabindex="">                                                                                            
                              <option id="bulkCountByAll" class="bulkCountByInOptions"  <?php echo wp_kses($bulk_deal_CountBy_all ,$allowed_html);?> value="all" ><?php esc_attr_e('All &nbsp;&nbsp;- &nbsp; count together as a group ', 'vtprd'); //  &nbsp;&nbsp; ex: "Buy 5 shirts get a discount" '?></option> 
                              <option id="bulkCountByEach" class="bulkCountByInOptions" <?php echo wp_kses($bulk_deal_CountBy_each ,$allowed_html);?> value="each" ><?php esc_attr_e('Each &nbsp;&nbsp;-&nbsp; count each individual cart line item total ', 'vtprd');  //  &nbsp;&nbsp;  ex: "Buy 5 units of any one shirt..." ?></option>                                                                                 
                          </select>
                       </span>
                  </span>    
                </div>
                
                <div class="screen-box pricing_table_rows_box  clear-left">
                    <div class="pricing_table_line  pricing_table_line_top  clear-left" id="pricing-table-headings-line">              
                        <span class="pricing-table-headings pricing_table_column1 pricing-table-heading1"> 
                          <span><?php esc_attr_e('Begin', 'vtprd');?></span>
                          <span class="bulk-heading-dollars <?php echo wp_kses($bulk_deal_method_currency_hideme ,$allowed_html);?>"><?php echo wp_kses($currency_symbol ,$allowed_html);?> <?php esc_attr_e('Value', 'vtprd');?> </span>
                          <span class="bulk-heading-units <?php echo wp_kses($bulk_deal_method_units_hideme ,$allowed_html);?> "><?php esc_attr_e('Unit Quantity', 'vtprd');?></span>
                        </span>            
                        <span class="pricing-table-headings pricing_table_column2 pricing-table-heading2">
                          <span><?php esc_attr_e('End', 'vtprd');?></span>
                          <span class="bulk-heading-dollars <?php echo wp_kses($bulk_deal_method_currency_hideme ,$allowed_html);?> "><?php echo wp_kses($currency_symbol ,$allowed_html);?> <?php esc_attr_e('Value', 'vtprd');?> </span>
                          <span class="bulk-heading-units <?php echo wp_kses($bulk_deal_method_units_hideme ,$allowed_html);?> "><?php esc_attr_e('Unit Quantity', 'vtprd');?></span>                    
                        </span>               
                        <span class="pricing-table-headings pricing_table_column3 pricing-table-heading3"><?php esc_attr_e('Discount Type', 'vtprd');  //php esc_attr_e('Adjustment Type', 'vtprd');?></span>           
                        <span class="pricing-table-headings pricing_table_column4 pricing-table-heading4"><?php esc_attr_e('Discount Value', 'vtprd');  //php esc_attr_e('Adjustment Value', 'vtprd');?></span>                                
                    </div> 
                    
    
                     <div class="InputsWrapper" id="InputsWrapper">
    
    
                        <?php 
                        
                        /*
                        When generating new line, show:: Min: 5 (sample)  Max: 10 (sample)
    
                            ==>> start with 2 sample lines:
                            (1) Min: 5 (sample),  Max: 10 (sample)
                            (2) Min: (min = 0),  Max: (max = unlimited)
                        */
                         
                        $bulk_deal_array_count = sizeof($vtprd_rule->bulk_deal_array);
                        $RowCount = 0;
                        if ($bulk_deal_array_count > 0) {  //send existing rows
                            ?>
                            <input type="hidden" id="rowCountFirstTime" name="rowCountFirstTime" value="<?php echo wp_kses($bulk_deal_array_count ,$allowed_html); ?>" />                        
                            <?php
                            $decimal_separator  = get_option( 'woocommerce_price_decimal_sep' );
                            
                            //v2.0.0.8 begin
                            if ($decimal_separator == ',') {
                              $stepValue = '0,01';
                              $placeholderValue = '0,00';
                              $typeValue = 'text'; //allows comma to be input, but deactivates JS auto number checking
                            } else {
                              $stepValue = '0.01';
                              $placeholderValue = '0.00';
                              $typeValue = 'number';
                            }                         
                            //v2.0.0.8 end
                            
                            $currency_symbol = get_woocommerce_currency_symbol();
                            for($b=0; $b < $bulk_deal_array_count; $b++) {
                              
                              //change decimal separator for display purposes, as needed - it's always carried internally as '.'
                              if ($decimal_separator == ',') {
                                $vtprd_rule->bulk_deal_array[$b]['min_value'] = str_replace('.', $decimal_separator, $vtprd_rule->bulk_deal_array[$b]['min_value']);
                                $vtprd_rule->bulk_deal_array[$b]['max_value'] = str_replace('.', $decimal_separator, $vtprd_rule->bulk_deal_array[$b]['max_value']);
                                $vtprd_rule->bulk_deal_array[$b]['discount_value'] = str_replace('.', $decimal_separator, $vtprd_rule->bulk_deal_array[$b]['discount_value']);            
                              }                              
                              
                              $RowCount++;
                              $min_value = $vtprd_rule->bulk_deal_array[$b]['min_value'];
                              $max_value = $vtprd_rule->bulk_deal_array[$b]['max_value'];
                              if ($max_value == 999999999999) {
                                $max_value = false;
                              }
                              $discount_type_percent = false;
                              $discount_type_currency = false;
                              $discount_type_fixedPrice = false;
                              switch( $vtprd_rule->bulk_deal_array[$b]['discount_type'] ) {
                                case 'percent':
                                  $discount_type_percent = $selected;
                                  break;
                                case 'currency':
                                  $discount_type_currency = $selected;
                                  break;                            
                                case 'fixedPrice':
                                  $discount_type_fixedPrice = $selected;
                                  break;                            
                              } 
                              $discount_value = $vtprd_rule->bulk_deal_array[$b]['discount_value'];
                                                        
                              $newHtml  =  '<div class="pricing_tier_row" id="pricing_tier_row_'. $RowCount.'">';
                              
                              $newHtml .=  '<span class="hideMe"><input  type="hidden" name="rowCount[]" id="rowCount_'.$RowCount.'" value="'.$RowCount.'"/></span>';
                              
                              $newHtml .=  '<span class="pricing_table_column1" id="minVal_'.$RowCount.'" ><input  type="text"   placeholder="From" name="minVal[]" id="minVal_row_'. $RowCount.'" value="'.$min_value.'"/></span>';
                              $newHtml .=  '<span class="pricing_table_column2" id="maxVal_'.$RowCount.'" ><input  type="text"   placeholder="To - No limit"  name="maxVal[]" id="maxVal_row_'. $RowCount.'" value="'.$max_value.'"/></span>';
                              
                              $newHtml .=  '<span class="pricing_table_column3" id="discountType_'.$RowCount.'" >';
                              $newHtml .=  '<select id="discount_amt_type_row_'.$RowCount.'"  class="pricing_table_discount_amt_type" name="discountType[]" tabindex="">';          
                              $newHtml .=  '<option id="pricing_table_discount_amt_type_percent_'.$RowCount.'" class="pricing_table_discount_amt_type_percent" value="percent" '.$discount_type_percent.' > % Off </option>';
                              $newHtml .=  '<option id="pricing_table_discount_amt_type_currency_'.$RowCount.'" class="pricing_table_discount_amt_type_currency" value="currency" '.$discount_type_currency.' > '.$currency_symbol.' Off </option>';                                                      
                              $newHtml .=  '<option id="pricing_table_discount_amt_type_fixedPrice_'.$RowCount.'" class="pricing_table_discount_amt_type_fixedPrice" value="fixedPrice" '.$discount_type_fixedPrice.' >  Fixed Unit Price '.$currency_symbol.'  </option>'; 
                              $newHtml .=  '</select>';                    
                              $newHtml .=  '</span>';
           
                              $newHtml .=  '<span class="pricing_table_column4" id="discountVal_'.$RowCount.'" ><input  type="'.$typeValue.'"  step="'.$stepValue.'" placeholder="'.$placeholderValue.'"  name="discountVal[]" id="discountVal_row_'. $RowCount.'" value="'.$discount_value.'"/></span>';
                              $newHtml .=  '<a href="#" class="removeclass">X</a>';
                              $newHtml .=  '</div>'; 
                              echo wp_kses($newHtml ,$allowed_html); //v2.0.3
                            }
                        } else {  //send a default row
                              $RowCount = 1;
                              ?>
                              <input type="hidden" id="rowCountFirstTime" name="rowCountFirstTime" value="<?php echo wp_kses($RowCount ,$allowed_html); //v2.0.3 ?>" />                        
                              <?php
                              $newHtml  =  '<div class="pricing_tier_row" id="pricing_tier_row_'. $RowCount.'">';
                              
                              $newHtml .=  '<span class="hideMe"><input  type="hidden" name="rowCount[]" id="rowCount_'.$RowCount.'" value="'.$RowCount.'"/></span>';
                              
                              $newHtml .=  '<span class="pricing_table_column1" id="minVal_'.$RowCount.'" ><input  type="text"  placeholder="From" name="minVal[]" id="minVal_row_'. $RowCount.'" value=""/></span>';
                              $newHtml .=  '<span class="pricing_table_column2" id="maxVal_'.$RowCount.'" ><input  type="text"  placeholder="To - No limit" name="maxVal[]" id="maxVal_row_'. $RowCount.'" value=""/></span>';
                              
                              $newHtml .=  '<span class="pricing_table_column3" id="discountType_'.$RowCount.'" >';
                              $newHtml .=  '<select id="discount_amt_type_row_'.$RowCount.'"  class="pricing_table_discount_amt_type" name="discountType[]" tabindex="">';          
                              $newHtml .=  '<option id="pricing_table_discount_amt_type_percent_'.$RowCount.'" class="pricing_table_discount_amt_type_percent" value="percent" '.$selected.' > % Off </option>';
                              $newHtml .=  '<option id="pricing_table_discount_amt_type_currency_'.$RowCount.'" class="pricing_table_discount_amt_type_currency" value="currency" > '.$currency_symbol.' Off </option>';                                                      
                              $newHtml .=  '<option id="pricing_table_discount_amt_type_fixedPrice_'.$RowCount.'" class="pricing_table_discount_amt_type_fixedPrice" value="fixedPrice" >  Fixed Unit Price '.$currency_symbol.' </option>'; 
                              $newHtml .=  '</select>';                    
                              $newHtml .=  '</span>';
           
                              $newHtml .=  '<span class="pricing_table_column4" id="discountVal_'.$RowCount.'" ><input  type="'.$typeValue.'"  step="'.$stepValue.'" placeholder="'.$placeholderValue.'" name="discountVal[]" id="discountVal_row_'. $RowCount.'" value=""/></span>';
                              $newHtml .=  '<a href="#" class="removeclass">X</a>';
                              $newHtml .=  '</div>'; 
                              echo wp_kses($newHtml ,$allowed_html); //v2.0.3                    
                        }                
                      ?> 
                      
                     </div>
                    
                    <span class="pricing_table_add_row clear-left"><a href="#" id="AddMoreFileBox" class="btn btn-info"><span class="plus-sign">+</span>&nbsp;<?php esc_attr_e('Add Row', 'vtprd');?></a></span>  
                           
                </div><!-- //pricing_table_rows_box -->                   
             </div><!-- //pricing_table_body_box -->
             
             <?php $message = '_' .$k; //v2.0.3 ?>
             
             <div class="bulk_box_currency_warning_class<?php echo wp_kses($message ,$allowed_html); ?>" id="bulk_box_currency_warning<?php echo wp_kses($message ,$allowed_html); ?>" >
               <span class="warning-line warning-line0"><strong><?php esc_attr_e('COUNT BY CURRENCY &nbsp; - &nbsp; Examples and Recommendations', 'vtprd') ?></strong></span> 
               <a href="#" class="hideWarning">X</a>
               <p>
                  <span class="warning-line warning-line1"><strong><?php esc_attr_e('When "Count by Currency" selected, please be sure to use the decimal place correctly.', 'vtprd') ?></strong></span>
                  <span class="warning-line warning-line2">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<?php esc_attr_e('Begin: 10.00 &nbsp;&nbsp; End: 19.99', 'vtprd') ?></span>
                  <span class="warning-line warning-line3">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<?php esc_attr_e('Begin: 20.00 &nbsp;&nbsp; End: 29.99', 'vtprd') ?></span>
                  <span class="warning-line warning-line4">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<?php esc_attr_e('Begin: 30.00 &nbsp;&nbsp; End: No Limit', 'vtprd') ?></span>
               </p>

               <p>
                  <span class="warning-line warning-line1"><strong><?php esc_attr_e('EXAMPLE: the following discount rows, with a MAX discount of $400:', 'vtprd') ?></strong></span>
                  <span class="warning-line warning-line2">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<?php esc_attr_e('Begin: 100.00 &nbsp;&nbsp; End: 200.00 &nbsp;&nbsp; Discount: 10%', 'vtprd') ?></span>
                  <span class="warning-line warning-line3">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<?php esc_attr_e('Begin: 200.01 &nbsp;&nbsp; End: 300.00 &nbsp;&nbsp; Discount: 15%', 'vtprd') ?></span>
                  <span class="warning-line warning-line4">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<?php esc_attr_e('Begin: 300.01 &nbsp;&nbsp; End: 400.00 &nbsp;&nbsp; Discount: 20%', 'vtprd') ?></span>
               </p>
               
               <p>                  
                  <span class="warning-line warning-line5">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<strong><?php esc_attr_e('Test 1: the following is in the cart', 'vtprd') ?></strong></span>
                  <span class="warning-line warning-line6">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<?php esc_attr_e('Product: A &nbsp;&nbsp; Price: $50.00 &nbsp;&nbsp; Quantity: 7 &nbsp;&nbsp; Total: $350.00', 'vtprd') ?></span>
                  <span class="warning-line warning-line7">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<?php esc_attr_e('Product: B &nbsp;&nbsp; Price: $50.00 &nbsp;&nbsp; Quantity: 2 &nbsp;&nbsp; Total: $100.00', 'vtprd') ?></span>
               </p> 
                              
               <p> 
                  <span class="warning-line warning-line8">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<?php esc_attr_e(' - All 7 units of Product A will be discounted by 20% - Total $350', 'vtprd') ?></span>
                  <span class="warning-line warning-line9">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<?php esc_attr_e(' - 1 full unit of Product B will be discounted by 20% - Total $50', 'vtprd') ?></span>
                  <span class="warning-line warning-line10">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<?php esc_attr_e(' - <strong>Discounting is straightforward</strong>', 'vtprd') ?></span>
               </p> 
               

               <p>                  
                  <span class="warning-line warning-line5">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<strong><?php esc_attr_e('Test 2: the following is in the cart', 'vtprd') ?></strong></span>
                  <span class="warning-line warning-line6">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<?php esc_attr_e('Product: A &nbsp;&nbsp; Price: $50.00 &nbsp;&nbsp; Quantity: 7 &nbsp;&nbsp; Total: $350.00', 'vtprd') ?></span>
                  <span class="warning-line warning-line7">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<?php esc_attr_e('Product: B &nbsp;&nbsp; Price: $15.00 &nbsp;&nbsp; Quantity: 5 &nbsp;&nbsp; Total: $75.00', 'vtprd') ?></span>
                </p> 
                              
               <p>                 
                  <span class="warning-line warning-line8">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<?php esc_attr_e(' - All 7 units of Product A will be discounted by 20% - Total $350', 'vtprd') ?></span>
                  <span class="warning-line warning-line9">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<?php esc_attr_e(' - 3 units of Product B will be discounted by 20% - Total $45', 'vtprd') ?></span>
                  <span class="warning-line warning-line10">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<?php esc_attr_e(' - <strong>1 unit of Product B will be <em>Partially</em> discounted by 20%</strong>', 'vtprd') ?></span>
                  <span class="warning-line warning-line11">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<?php esc_attr_e(' - <strong>$350 + $45 = $395. Only $5 of Product B unit 4 price will be discounted</strong>', 'vtprd') ?></span>                 
               </p>                         
             </div><!-- //bulk_box_warning -->

          </div><!-- //pricing_table_info -->
           
         </div>   <?php //end bulk-box ?>  

         
         <!-- //v1.1.8.0 end -->
        
                     
         <div class="screen-box buy_amt_box buy_amt_box_class<?php echo wp_kses($message ,$allowed_html); ?>" id="buy_amt_box<?php echo wp_kses($message ,$allowed_html); ?>" >
            
            <span class="left-column">
                <span class="title hasWizardHelpRight" id="buy_amt_title<?php echo wp_kses($message ,$allowed_html); ?> ">
                  <a id="buy_amt_title_anchor<?php echo wp_kses($message ,$allowed_html); ?>" class="title-anchors second-level-title" href="<?php echo esc_js('javascript:void(0);');?>"><span class="showBuyAsBuy"><?php esc_attr_e('Group Amount', 'vtprd');?></span><span class="showBuyAsDiscount"><?php esc_attr_e('Group Amount', 'vtprd');?></span>
                  </a>
                  <span class="required-asterisk">*</span>                      
                </span> 
                <?php vtprd_show_object_hover_help ('buy_amt_type', 'wizard'); ?>                                             
            </span>                
 
            <span class="dropdown  buy_amt  right-column" id="buy_amt_dropdown<?php echo wp_kses($message ,$allowed_html); ?>">              
               <select id="<?php echo wp_kses($vtprd_deal_screen_framework['buy_amt_type']['select']['id'] ,$allowed_html); echo wp_kses($message ,$allowed_html); ?>" class="<?php echo wp_kses($vtprd_deal_screen_framework['buy_amt_type']['select']['class'] ,$allowed_html); ?>  " name="<?php echo wp_kses($vtprd_deal_screen_framework['buy_amt_type']['select']['name'] ,$allowed_html); echo wp_kses($message ,$allowed_html); ?>" tabindex="<?php echo wp_kses($vtprd_deal_screen_framework['buy_amt_type']['select']['tabindex'] ,$allowed_html); ?>" >          
                 <?php
                 for($i=0; $i < sizeof($vtprd_deal_screen_framework['buy_amt_type']['option']); $i++) { 
                          $this->vtprd_change_title_currency_symbol('buy_amt_type', $i, $currency_symbol);
                 ?>                             
                    <option id="<?php echo wp_kses($vtprd_deal_screen_framework['buy_amt_type']['option'][$i]['id'] ,$allowed_html);echo wp_kses($message ,$allowed_html); ?>"  class="<?php echo wp_kses($vtprd_deal_screen_framework['buy_amt_type']['option'][$i]['class'] ,$allowed_html);?>"  value="<?php echo wp_kses($vtprd_deal_screen_framework['buy_amt_type']['option'][$i]['value'] ,$allowed_html);?>"   <?php if ($vtprd_deal_screen_framework['buy_amt_type']['option'][$i]['value'] == $vtprd_rule->rule_deal_info[$k]['buy_amt_type'] )  { echo wp_kses($selected ,$allowed_html);} ?> >  <?php echo wp_kses($vtprd_deal_screen_framework['buy_amt_type']['option'][$i]['title'] ,$allowed_html);?> </option>
                 <?php } ?>                   
                </select>  
                
                            
                 <span class="buy_amt_line_remainder  buy_amt_line_remainder_class<?php echo wp_kses($message ,$allowed_html); ?>" id="buy_amt_line_remainder<?php echo wp_kses($message ,$allowed_html);?>">   
                     <span class="amt-field buy_amt_count" id="buy_amt_count_area<?php echo wp_kses($message ,$allowed_html);?>">
                       <input id="<?php echo wp_kses($vtprd_deal_screen_framework['buy_amt_count']['id'] ,$allowed_html); echo wp_kses($message ,$allowed_html);?>" class="<?php echo wp_kses($vtprd_deal_screen_framework['buy_amt_count']['class'] ,$allowed_html);?>" type="<?php echo wp_kses($vtprd_deal_screen_framework['buy_amt_count']['type'] ,$allowed_html);?>" name="<?php echo wp_kses($vtprd_deal_screen_framework['buy_amt_count']['name'] ,$allowed_html); echo wp_kses($message ,$allowed_html);?>" value="<?php echo wp_kses($vtprd_rule->rule_deal_info[$k]['buy_amt_count'] ,$allowed_html); ?>" />
                     </span>

                 </span> 
           
               <span class="shortIntro  shortIntro2" >
                  <img  class="hasHoverHelp2" width="18px" alt=""  src="<?php echo esc_url($hoverhelpURL);?>" /> 
                 <?php vtprd_show_object_hover_help ('buy_amt_type', 'small');?>
               </span>                               
                                            
            </span>
            
         </div><!-- //buy_amt_box -->


                  
         <div class="screen-box  buy_amt_box_appliesto_class<?php echo wp_kses($message ,$allowed_html); ?>  buy_amt_line_remainder  clear-left" id="buy_amt_box_appliesto<?php echo wp_kses($message ,$allowed_html); ?>" > 
            <span class="show-in-adanced-mode-only">
                <span class="left-column  left-column-less-padding-top3">  
                    <span class="title  hasWizardHelpRight" id="buy_amt_type_title<?php echo wp_kses($message ,$allowed_html); ?>" >            
                      <a id="buy_amt_appliesto_anchor<?php echo wp_kses($message ,$allowed_html); ?>" class="title-anchors second-level-title" href="<?php echo esc_js('javascript:void(0);');?>"><?php esc_attr_e('Group Amount', 'vtprd'); ?> <br> <?php  esc_attr_e('Applies to', 'vtprd');?></a>
                    </span> 
                    <?php vtprd_show_object_hover_help ('buy_amt_applies_to', 'wizard'); ?>           
                </span> 
                

                <span class="dropdown  right-column">                           
                     <select id="<?php echo wp_kses($vtprd_deal_screen_framework['buy_amt_applies_to']['select']['id'] ,$allowed_html); echo wp_kses($message ,$allowed_html); ?>" class="<?php echo wp_kses($vtprd_deal_screen_framework['buy_amt_applies_to']['select']['class'] ,$allowed_html);?>" name="<?php echo wp_kses($vtprd_deal_screen_framework['buy_amt_applies_to']['select']['name'] ,$allowed_html); echo wp_kses($message ,$allowed_html); ?>" tabindex="<?php echo wp_kses($vtprd_deal_screen_framework['buy_amt_applies_to']['select']['tabindex'] ,$allowed_html);?>" >          
                       <?php
                       for($i=0; $i < sizeof($vtprd_deal_screen_framework['buy_amt_applies_to']['option']); $i++) { 
                       ?>                             
                          <option id="<?php echo wp_kses($vtprd_deal_screen_framework['buy_amt_applies_to']['option'][$i]['id'] ,$allowed_html); echo wp_kses($message ,$allowed_html); ?>"  class="<?php echo wp_kses($vtprd_deal_screen_framework['buy_amt_applies_to']['option'][$i]['class'] ,$allowed_html);?>"  value="<?php echo wp_kses($vtprd_deal_screen_framework['buy_amt_applies_to']['option'][$i]['value'] ,$allowed_html);?>"   <?php if ($vtprd_deal_screen_framework['buy_amt_applies_to']['option'][$i]['value'] == $vtprd_rule->rule_deal_info[$k]['buy_amt_applies_to'] )  { echo wp_kses($selected ,$allowed_html);} ?> >  <?php echo wp_kses($vtprd_deal_screen_framework['buy_amt_applies_to']['option'][$i]['title'] ,$allowed_html);?> </option>
                       <?php } ?> 
                     </select>
                    
                               
                   <span class="shortIntro" >
                      <img  class="hasHoverHelp2" width="18px" alt=""  src="<?php echo esc_url($hoverhelpURL);?>" /> 
                     <?php vtprd_show_object_hover_help ('buy_amt_applies_to', 'small');?>
                   </span>                               
                                  
                </span>
                                         
           </span>
        </div><!-- //buy_amt_box_appliesto -->


                    
         <div class="screen-box buy_amt_mod_box  buy_amt_mod_box_class<?php echo wp_kses($message ,$allowed_html); ?>" id="buy_amt_mod_box<?php echo wp_kses($message ,$allowed_html); ?>" > 
            <span class="left-column">
                <span class="title  third-level-title  hasWizardHelpRight" id="buy_amt_mod_title<?php echo wp_kses($message ,$allowed_html); ?>" >
                  <a id="buy_amt_mod_title_anchor<?php echo wp_kses($message ,$allowed_html); ?>" class="title-anchors third-level-title" href="<?php echo esc_js('javascript:void(0);');?>"><span class="showBuyAsBuy"><?php esc_attr_e('Min / Max', 'vtprd');?></span><span class="showBuyAsDiscount"><?php esc_attr_e('Min / Max', 'vtprd');?></span></a> 
                </span>
                <?php vtprd_show_object_hover_help ('buy_amt_mod', 'wizard');?>
            </span>
            <span class="dropdown  buy_amt_mod  right-column" id="buy_amt_mod_dropdown<?php echo wp_kses($message ,$allowed_html); ?>">              
               <select id="<?php echo wp_kses($vtprd_deal_screen_framework['buy_amt_mod']['select']['id'] ,$allowed_html); echo wp_kses($message ,$allowed_html); ?>" class="<?php echo wp_kses($vtprd_deal_screen_framework['buy_amt_mod']['select']['class'] ,$allowed_html);?>" name="<?php echo wp_kses($vtprd_deal_screen_framework['buy_amt_mod']['select']['name'] ,$allowed_html); echo wp_kses($message ,$allowed_html); ?>" tabindex="<?php echo wp_kses($vtprd_deal_screen_framework['buy_amt_mod']['select']['tabindex'] ,$allowed_html);?>" >          
                 <?php
                 for($i=0; $i < sizeof($vtprd_deal_screen_framework['buy_amt_mod']['option']); $i++) {
                          $this->vtprd_change_title_currency_symbol('buy_amt_mod', $i, $currency_symbol);                  
                 ?>                             
                    <option id="<?php echo wp_kses($vtprd_deal_screen_framework['buy_amt_mod']['option'][$i]['id'] ,$allowed_html); echo wp_kses($message ,$allowed_html); ?>"  class="<?php echo wp_kses($vtprd_deal_screen_framework['buy_amt_mod']['option'][$i]['class'] ,$allowed_html);?>"  value="<?php echo wp_kses($vtprd_deal_screen_framework['buy_amt_mod']['option'][$i]['value'] ,$allowed_html);?>"   <?php if ($vtprd_deal_screen_framework['buy_amt_mod']['option'][$i]['value'] == $vtprd_rule->rule_deal_info[$k]['buy_amt_mod'] )  { echo wp_kses($selected ,$allowed_html); }?> >  <?php echo wp_kses($vtprd_deal_screen_framework['buy_amt_mod']['option'][$i]['title'] ,$allowed_html);?> </option>
                 <?php } ?> 
               </select>
               
               
               <span class="amt-field  buy_amt_mod_count_area  buy_amt_mod_count_area_class<?php echo wp_kses($message ,$allowed_html); ?>" id="buy_amt_mod_count_area<?php echo wp_kses($message ,$allowed_html); ?>">
                 <input id="<?php echo wp_kses($vtprd_deal_screen_framework['buy_amt_mod_count']['id'] ,$allowed_html); echo wp_kses($message ,$allowed_html); ?>" class="<?php echo wp_kses($vtprd_deal_screen_framework['buy_amt_mod_count']['class'] ,$allowed_html);?>" type="<?php echo wp_kses($vtprd_deal_screen_framework['buy_amt_mod_count']['type'] ,$allowed_html);?>" name="<?php echo wp_kses($vtprd_deal_screen_framework['buy_amt_mod_count']['name'] ,$allowed_html); echo wp_kses($message ,$allowed_html); ?>" value="<?php echo wp_kses($vtprd_rule->rule_deal_info[$k]['buy_amt_mod_count'] ,$allowed_html);?>" />
               </span>   
            
               <span class="shortIntro  shortIntro2" >
                  <img  class="hasHoverHelp2" width="18px" alt=""  src="<?php echo esc_url($hoverhelpURL);?>" /> 
                 <?php vtprd_show_object_hover_help ('buy_amt_mod', 'small');?>
               </span>                               
             
            </span>
                          
         </div><!-- //buy_amt_mod_box -->


                    
          <div class="screen-box buy_repeat_box  buy_repeat_box_class<?php echo wp_kses($message ,$allowed_html);?>" id="buy_repeat_box<?php echo wp_kses($message ,$allowed_html); ?>" >     <?php //Rule repeat shifted to end of action area, although processed first ?> 
            <span class="left-column">
                <span class="title  third-level-title  hasWizardHelpRight" id="buy_repeat_title<?php echo wp_kses($message ,$allowed_html);?> ">
                   <a id="buy_repeat_title_anchor<?php echo wp_kses($message ,$allowed_html); ?>" class="title-anchors third-level-title" href="<?php echo esc_js('javascript:void(0);');?>"><span class="showBuyAsBuy"><?php esc_attr_e('Rule Usage Count', 'vtprd');?></span><span class="showBuyAsDiscount"><?php esc_attr_e('Rule Usage Count', 'vtprd');?></span></a>
                   <span class="required-asterisk">* </span>
                </span>
                <?php vtprd_show_object_hover_help ('buy_repeat_condition', 'wizard');?>
            </span>
            
            <span class="dropdown buy_repeat right-column" id="buy_repeat_dropdown<?php echo wp_kses($message ,$allowed_html); ?>">              
               <select id="<?php echo wp_kses($vtprd_deal_screen_framework['buy_repeat_condition']['select']['id'] ,$allowed_html); echo wp_kses($message ,$allowed_html); ?>" class="<?php echo wp_kses($vtprd_deal_screen_framework['buy_repeat_condition']['select']['class'] ,$allowed_html); ?>" name="<?php echo wp_kses($vtprd_deal_screen_framework['buy_repeat_condition']['select']['name'] ,$allowed_html); echo wp_kses($message ,$allowed_html); ?>" tabindex="<?php echo wp_kses($vtprd_deal_screen_framework['buy_repeat_condition']['select']['tabindex'] ,$allowed_html); ?>" >          
                 <?php
                 for($i=0; $i < sizeof($vtprd_deal_screen_framework['buy_repeat_condition']['option']); $i++) { 
                 ?>                             
                    <option id="<?php echo wp_kses($vtprd_deal_screen_framework['buy_repeat_condition']['option'][$i]['id'] ,$allowed_html); echo wp_kses($message ,$allowed_html); ?>"  class="<?php echo wp_kses($vtprd_deal_screen_framework['buy_repeat_condition']['option'][$i]['class'] ,$allowed_html); ?>"  value="<?php echo wp_kses($vtprd_deal_screen_framework['buy_repeat_condition']['option'][$i]['value'] ,$allowed_html); ?>"   <?php if ($vtprd_deal_screen_framework['buy_repeat_condition']['option'][$i]['value'] == $vtprd_rule->rule_deal_info[$k]['buy_repeat_condition'] )  { echo wp_kses($selected ,$allowed_html);} ?> >  <?php echo wp_kses($vtprd_deal_screen_framework['buy_repeat_condition']['option'][$i]['title'] ,$allowed_html);?> </option>
                 <?php } ?> 
               </select>
               
                             
               <span class="amt-field  buy_repeat_count_area  buy_repeat_count_area_class<?php echo wp_kses($message ,$allowed_html); ?>" id="buy_repeat_count_area<?php echo wp_kses($message ,$allowed_html); ?>">              
                 <input id="<?php echo wp_kses($vtprd_deal_screen_framework['buy_repeat_count']['id'] ,$allowed_html); echo wp_kses($message ,$allowed_html); ?>" class="<?php echo wp_kses($vtprd_deal_screen_framework['buy_repeat_count']['class'] ,$allowed_html);?>" type="<?php echo wp_kses($vtprd_deal_screen_framework['buy_repeat_count']['type'] ,$allowed_html);?>" name="<?php echo wp_kses($vtprd_deal_screen_framework['buy_repeat_count']['name'] ,$allowed_html); echo wp_kses($message ,$allowed_html);?>" value="<?php echo wp_kses($vtprd_rule->rule_deal_info[$k]['buy_repeat_count'] ,$allowed_html); ?>" />                
               </span>
                        
               <span class="shortIntro  shortIntro2" >
                  <img  class="hasHoverHelp2" width="18px" alt=""  src="<?php echo esc_url($hoverhelpURL);?>" /> 
                  <?php vtprd_show_object_hover_help ('buy_repeat_condition', 'small');?>
               </span>                               
                       
            </span>
                     
         </div><!-- //buy_repeat_box --> 
          
        </div><!-- //buy_info -->
           
        <?php //ACtion INFO  ?>        
        
        <div class="display-virtual_box action_info" id="action_info<?php echo wp_kses($message ,$allowed_html); ?>"> 
         <div class="screen-box get_group_title_box">
            <span class="get_group_title-area">
              <img class="get_amt_title_icon" src="<?php echo esc_url(VTPRD_URL.'/admin/images/tab-icons.png');?>" width="1" height="1" />              
              <span class="section-headings first-level-title showGetAsDiscount" id="get_group_title_active">
                <?php esc_attr_e('Discount Group ', 'vtprd');?>
                <span class="label-no-cap"  style="color:#888;font-style:italic;font-family: Arial,Helvetica,sans-serif;">&nbsp;&nbsp;&nbsp;<?php esc_attr_e('( Get Group )', 'vtprd');?></span>
              
            </span>
         </div><!-- //get_group_title_box --> 



        <div class="screen-box action_group_box" id="action_group_box<?php echo wp_kses($message ,$allowed_html); ?>" >           
            <span class="left-column">
                <span class="title  hasWizardHelpRight" id="action_group_title">
                  <a id="action_group_title_anchor" class="title-anchors second-level-title" href="<?php echo esc_js('javascript:void(0);');?>"><span class="showGetAsGet"><?php esc_attr_e('Select Group By', 'vtprd');?></span><span class="showGetAsDiscount"><?php esc_attr_e('Select Group By', 'vtprd');?></span></a>
                  <span class="required-asterisk">*</span>
                </span> 
                <?php vtprd_show_object_hover_help ('actionPop', 'wizard'); ?>      
            </span>
             
            <span class="dropdown action_group right-column" id="action_group_dropdown_0">              
               <select id="<?php echo wp_kses($vtprd_rule_display_framework['actionPop']['select']['id'] ,$allowed_html);?>" class="<?php echo wp_kses($vtprd_rule_display_framework['actionPop']['select']['class'] ,$allowed_html); ?>" name="<?php echo wp_kses($vtprd_rule_display_framework['actionPop']['select']['name'] ,$allowed_html);?>" tabindex="<?php //echo $vtprd_rule_display_framework['actionPop']['select']['tabindex']; ?>" >          
                 <?php
                 for($i=0; $i < sizeof($vtprd_rule_display_framework['actionPop']['option']); $i++) { 
                       
                      //pick up the free/pro version of the title => in this case, title and title3
                      $title = $vtprd_rule_display_framework['actionPop']['option'][$i]['title'];
                      if ( ( defined('VTPRD_PRO_DIRNAME') ) &&
                           ( isset($vtprd_rule_display_framework['actionPop']['option'][$i]['title3']) ) &&    //v2.0.3
                           ( $vtprd_rule_display_framework['actionPop']['option'][$i]['title3'] > ' ' ) ) {
                        $title = $vtprd_rule_display_framework['actionPop']['option'][$i]['title3'];                        
                      }                 
                 ?>                             
                    <option id="<?php echo wp_kses($vtprd_rule_display_framework['actionPop']['option'][$i]['id'] ,$allowed_html); ?>"  class="<?php echo wp_kses($vtprd_rule_display_framework['actionPop']['option'][$i]['class'] ,$allowed_html); ?>"  value="<?php echo wp_kses($vtprd_rule_display_framework['actionPop']['option'][$i]['value'] ,$allowed_html); ?>"   <?php if ($vtprd_rule_display_framework['actionPop']['option'][$i]['value'] == $vtprd_rule->actionPop )  { echo wp_kses($selected ,$allowed_html); } ?> >  <?php echo wp_kses($title ,$allowed_html); ?> </option>
                 <?php } ?> 
               </select> 
                          
               <span class="shortIntro  shortIntro2" >
                  <img  class="hasHoverHelp2" width="18px" alt=""  src="<?php echo esc_url($hoverhelpURL);?>" /> 
                 <?php vtprd_show_object_hover_help ('actionPop', 'small');?>
               </span>  

              <div class="show-and-or-switches" id="action-show-and-or-switches">                          
                <label class="show-and-or-switches-label"><?php esc_attr_e('Show "And/Or"s', 'vtprd');?></label>
                <div class="switch-field">               
                  <span class="hasWizardHelpRight">
                    <input id="action-group-show-and-or-switches-YesSelect" class="action-group-show-and-or-switches" name="action_group_show_and_or_switches" value="yes" type="radio" <?php if ( $vtprd_rule->action_group_population_info['action_group_show_and_or_switches'] == 'yes') { echo wp_kses($checked ,$allowed_html);} ?> >
                    <label for="action-group-show-and-or-switches-YesSelect"  class="show-and-or-switches-yes show-and-or-switches-action">Yes</label>
                  </span> 
                  <?php vtprd_show_object_hover_help ('action_group_show_and_or_switches_YesSelect', 'wizard'); ?> 
                  <span class="hasWizardHelpRight">                                                       
                    <input id="action-group-show-and-or-switches-NoSelect"  class="action-group-show-and-or-switches" name="action_group_show_and_or_switches" value="no"  type="radio" <?php if ( $vtprd_rule->action_group_population_info['action_group_show_and_or_switches'] == 'no' ) { echo wp_kses($checked ,$allowed_html); } ?> > 
                    <label for="action-group-show-and-or-switches-NoSelect"  class="show-and-or-switches-no show-and-or-switches-action" id="action-group-show-and-or-switches-NoSelect-label">No</label> 
                  </span>
                  <?php vtprd_show_object_hover_help ('action_group_show_and_or_switches_NoSelect', 'wizard'); ?> 
                </div> 
              </div>
                                         
               <span class="action_group_line_remainder_class" id="action_group_line_remainder">   
                <?php $this->vtprd_action_group_cntl(); ?> 
               </span>
               
               <?php  /* v1.1 "Product must be in the Filter Group" messaging removed!  */ ?>                               
                    
            </span>

         </div><!-- //action_group_box -->

                   
         <div class="screen-box action_amt_box  action_amt_box_class<?php echo wp_kses($message ,$allowed_html); ?>" id="action_amt_box<?php echo wp_kses($message ,$allowed_html); ?>" > 
            <span class="left-column">  
                <span class="title  hasWizardHelpRight" id="action_amt_type_title<?php echo wp_kses($message ,$allowed_html); ?>" >            
                  <a id="action_amt_title_anchor<?php echo wp_kses($message ,$allowed_html); ?>" class="title-anchors second-level-title" href="<?php echo esc_js('javascript:void(0);');?>"><span class="showGetAsGet"><?php esc_attr_e('Group Amount', 'vtprd');?></span><span class="showGetAsDiscount"><?php esc_attr_e('Group Amount', 'vtprd');?></span></a>
                  <span class="required-asterisk">*</span>
                </span>
                <?php vtprd_show_object_hover_help ('action_amt_type', 'wizard'); ?>                                
            </span> 
            <span class="dropdown action_amt right-column" id="action_amt_dropdown<?php echo wp_kses($message ,$allowed_html); ?>">              
               <select id="<?php echo wp_kses($vtprd_deal_screen_framework['action_amt_type']['select']['id'] ,$allowed_html); echo wp_kses($message ,$allowed_html); ?>" class="<?php echo wp_kses($vtprd_deal_screen_framework['action_amt_type']['select']['class'] ,$allowed_html); ?>" name="<?php echo wp_kses($vtprd_deal_screen_framework['action_amt_type']['select']['name'] ,$allowed_html); echo wp_kses($message ,$allowed_html); ?>" tabindex="<?php echo wp_kses($vtprd_deal_screen_framework['action_amt_type']['select']['tabindex'] ,$allowed_html); ?>" >          
                 <?php
                 for($i=0; $i < sizeof($vtprd_deal_screen_framework['action_amt_type']['option']); $i++) {
                          $this->vtprd_change_title_currency_symbol('action_amt_type', $i, $currency_symbol);                  
                 ?>                            
                    <option id="<?php echo wp_kses($vtprd_deal_screen_framework['action_amt_type']['option'][$i]['id'] ,$allowed_html); echo wp_kses($message ,$allowed_html); ?>"  class="<?php echo wp_kses($vtprd_deal_screen_framework['action_amt_type']['option'][$i]['class'] ,$allowed_html); ?>"  value="<?php echo wp_kses($vtprd_deal_screen_framework['action_amt_type']['option'][$i]['value'] ,$allowed_html); ?>"   <?php if ($vtprd_deal_screen_framework['action_amt_type']['option'][$i]['value'] == $vtprd_rule->rule_deal_info[$k]['action_amt_type'] )  { echo wp_kses($selected ,$allowed_html); } ?> >  <?php echo wp_kses($vtprd_deal_screen_framework['action_amt_type']['option'][$i]['title'] ,$allowed_html); ?> </option>
                 <?php } ?> 
               </select>              
               
              
               <span class="action_amt_line_remainder  action_amt_line_remainder_class<?php echo wp_kses($message ,$allowed_html); ?>" id="action_amt_line_remainder<?php echo wp_kses($message ,$allowed_html); ?>">
                   <span class="amt-field action_amt_count" id="action_amt_count_pair<?php echo wp_kses($message ,$allowed_html); ?>">
                     <input id="<?php echo wp_kses($vtprd_deal_screen_framework['action_amt_count']['id'] ,$allowed_html); echo wp_kses($message ,$allowed_html); ?>" class="<?php echo wp_kses($vtprd_deal_screen_framework['action_amt_count']['class'] ,$allowed_html);?>" type="<?php echo wp_kses($vtprd_deal_screen_framework['action_amt_count']['type'] ,$allowed_html); ?>" name="<?php echo wp_kses($vtprd_deal_screen_framework['action_amt_count']['name'] ,$allowed_html); echo wp_kses($message ,$allowed_html); ?>" value="<?php echo wp_kses($vtprd_rule->rule_deal_info[$k]['action_amt_count'] ,$allowed_html); ?>" />
                   </span>                                                    
               </span>  
           
               <span class="shortIntro  shortIntro2" >
                  <img  class="hasHoverHelp2" width="18px" alt=""  src="<?php echo esc_url($hoverhelpURL);?>" /> 
                 <?php vtprd_show_object_hover_help ('action_amt_type', 'small');?>
               </span>                               
                                          
            </span>

        </div><!-- //action_amt_box -->

                  
         <div class="screen-box action_amt_box_appliesto_class<?php echo wp_kses($message ,$allowed_html); ?>  action_amt_line_remainder clear-left  " id="action_amt_box_appliesto<?php echo wp_kses($message ,$allowed_html); ?>" > 
            <span class="show-in-adanced-mode-only" id="action_amt_box_appliesto_span<?php echo wp_kses($message ,$allowed_html); ?>">
                <span class="left-column  left-column-less-padding-top3">  
                    <span class="title  hasWizardHelpRight" id="action_amt_type_title<?php echo wp_kses($message ,$allowed_html);?>" >            
                      <a id="action_amt_title_anchor<?php echo wp_kses($message ,$allowed_html); ?>" class="title-anchors second-level-title" href="<?php echo esc_js('javascript:void(0);');?>"><span class="showGetAsGet"><?php esc_attr_e('Group Amount', 'vtprd'); ?> <br> <?php esc_attr_e('Applies to', 'vtprd');?></span><span class="showGetAsDiscount"><?php esc_attr_e('Group Amount', 'vtprd'); echo wp_kses('<br>' ,$allowed_html); esc_attr_e('Applies to', 'vtprd');?></span></a>
                    </span>
                    <?php vtprd_show_object_hover_help ('action_amt_applies_to', 'wizard'); ?>            
                </span> 

                <span class="dropdown    right-column">                           
                     <select id="<?php echo wp_kses($vtprd_deal_screen_framework['action_amt_applies_to']['select']['id'] ,$allowed_html); echo wp_kses($message ,$allowed_html); ?>" class="<?php echo wp_kses($vtprd_deal_screen_framework['action_amt_applies_to']['select']['class'] ,$allowed_html); ?>" name="<?php echo wp_kses($vtprd_deal_screen_framework['action_amt_applies_to']['select']['name'] ,$allowed_html); echo wp_kses($message ,$allowed_html); ?>" tabindex="<?php //echo $vtprd_deal_screen_framework['action_amt_applies_to']['select']['tabindex']; ?>" >          
                       <?php
                       for($i=0; $i < sizeof($vtprd_deal_screen_framework['action_amt_applies_to']['option']); $i++) { 
                       ?>                             
                          <option id="<?php echo wp_kses($vtprd_deal_screen_framework['action_amt_applies_to']['option'][$i]['id'] ,$allowed_html); echo wp_kses($message ,$allowed_html);  ?>"  class="<?php echo wp_kses($vtprd_deal_screen_framework['action_amt_applies_to']['option'][$i]['class'] ,$allowed_html); ?>"  value="<?php echo wp_kses($vtprd_deal_screen_framework['action_amt_applies_to']['option'][$i]['value'] ,$allowed_html); ?>"   <?php if ($vtprd_deal_screen_framework['action_amt_applies_to']['option'][$i]['value'] == $vtprd_rule->rule_deal_info[$k]['action_amt_applies_to'] )  { echo wp_kses($selected ,$allowed_html); } ?> >  <?php echo wp_kses($vtprd_deal_screen_framework['action_amt_applies_to']['option'][$i]['title'] ,$allowed_html); ?> </option>
                       <?php } ?> 
                     </select>
                     
                               
                   <span class="shortIntro" >                      
                      <img  class="hasHoverHelp2" width="18px" alt=""  src="<?php echo esc_url($hoverhelpURL);?>" /> 
                     <?php vtprd_show_object_hover_help ('action_amt_applies_to', 'small');?>
                   </span>                               
    
                </span>

            </span>
        </div><!-- //action_amt_box_appliesto -->


 
                    
        <div class="screen-box action_amt_mod_box  action_amt_mod_box_class<?php echo wp_kses($message ,$allowed_html); ?>" id="action_amt_mod_box<?php echo wp_kses($message ,$allowed_html); ?>" >
            <span class="left-column">
                <span class="title  third-level-title  hasWizardHelpRight" id="action_amt_mod_title<?php echo wp_kses($message ,$allowed_html); ?>" >
                   <a id="action_amt_mod_title_anchor<?php echo wp_kses($message ,$allowed_html); ?>" class="title-anchors third-level-title" href="<?php echo esc_js('javascript:void(0);');?>"><span class="showGetAsGet"><?php esc_attr_e('Min / Max', 'vtprd');?></span><span class="showGetAsDiscount"><?php esc_attr_e('Min / Max', 'vtprd');?></span></a>
                </span>
                <?php vtprd_show_object_hover_help ('action_amt_mod', 'wizard');?>
            </span>
            
            <span class="dropdown  right-column" id="action_amt_mod_dropdown<?php echo wp_kses($message ,$allowed_html); ?>">
               <select id="<?php echo wp_kses($vtprd_deal_screen_framework['action_amt_mod']['select']['id'] ,$allowed_html); echo wp_kses($message ,$allowed_html); ?>" class="<?php echo wp_kses($vtprd_deal_screen_framework['action_amt_mod']['select']['class'] ,$allowed_html); ?>" name="<?php echo wp_kses($vtprd_deal_screen_framework['action_amt_mod']['select']['name'] ,$allowed_html); echo wp_kses($message ,$allowed_html); ?>" tabindex="<?php //echo $vtprd_deal_screen_framework['action_amt_mod']['select']['tabindex']; ?>" >          
                 <?php
                 for($i=0; $i < sizeof($vtprd_deal_screen_framework['action_amt_mod']['option']); $i++) { 
                          $this->vtprd_change_title_currency_symbol('action_amt_mod', $i, $currency_symbol);                  
                 ?>                             
                    <option id="<?php echo wp_kses($vtprd_deal_screen_framework['action_amt_mod']['option'][$i]['id'] ,$allowed_html); echo wp_kses($message ,$allowed_html); ?>"  class="<?php echo wp_kses($vtprd_deal_screen_framework['action_amt_mod']['option'][$i]['class'] ,$allowed_html); ?>"  value="<?php echo wp_kses($vtprd_deal_screen_framework['action_amt_mod']['option'][$i]['value'] ,$allowed_html); ?>"   <?php if ($vtprd_deal_screen_framework['action_amt_mod']['option'][$i]['value'] == $vtprd_rule->rule_deal_info[$k]['action_amt_mod'] )  { echo wp_kses($selected ,$allowed_html); } ?> >  <?php echo wp_kses($vtprd_deal_screen_framework['action_amt_mod']['option'][$i]['title'] ,$allowed_html); ?> </option>
                 <?php } ?> 
               </select>
               
                            
               <span class="amt-field  action_amt_mod_count_area  action_amt_mod_count_area_class<?php echo wp_kses($message ,$allowed_html); ?>" id="action_amt_mod_count_area<?php echo wp_kses($message ,$allowed_html); ?>">
                 <input id="<?php echo wp_kses($vtprd_deal_screen_framework['action_amt_mod_count']['id'] ,$allowed_html); echo wp_kses($message ,$allowed_html); ?>" class="<?php echo wp_kses($vtprd_deal_screen_framework['action_amt_mod_count']['class'] ,$allowed_html); ?>" type="<?php echo wp_kses($vtprd_deal_screen_framework['action_amt_mod_count']['type'] ,$allowed_html); ?>" name="<?php echo wp_kses($vtprd_deal_screen_framework['action_amt_mod_count']['name'] ,$allowed_html); echo wp_kses($message ,$allowed_html); ?>" value="<?php echo wp_kses($vtprd_rule->rule_deal_info[$k]['action_amt_mod_count'] ,$allowed_html); ?>" />
               </span>  
            
               <span class="shortIntro  shortIntro2" >
                  <img  class="hasHoverHelp2" width="18px" alt=""  src="<?php echo esc_url($hoverhelpURL);?>" /> 
                  <?php vtprd_show_object_hover_help ('action_amt_mod', 'small');?>
               </span>                                  
            </span>
         </div><!-- //action_amt_mod_box -->  


         
         <div class="screen-box action_repeat_condition_box  action_repeat_condition_box_class<?php echo wp_kses($message ,$allowed_html); ?>" id="action_repeat_condition_box<?php echo wp_kses($message ,$allowed_html); ?>" >      <?php //Action repeat shifted to end of action area, although processed first ?> 
            <span class="left-column">
                <span class="title  third-level-title  hasWizardHelpRight" id="action_repeat_condition_title<?php echo wp_kses($message ,$allowed_html); ?>" >
                   <a id="action_repeat_condition_title_anchor<?php echo wp_kses($message ,$allowed_html); ?>" class="title-anchors third-level-title" href="<?php echo esc_js('javascript:void(0);');?>"><span class="showGetAsGet"><?php esc_attr_e('Group Repeat', 'vtprd');?></span><span class="showGetAsDiscount"><?php esc_attr_e('Group Repeat', 'vtprd');?></span></a>
                </span>
                <?php vtprd_show_object_hover_help ('action_repeat_condition', 'wizard');?>
            </span>
            <span class="dropdown action_repeat_condition right-column"  id="action_repeat_condition_dropdown<?php echo wp_kses($message ,$allowed_html); ?>">              
               
               <select id="<?php echo $vtprd_deal_screen_framework['action_repeat_condition']['select']['id']; echo wp_kses($vtprd_deal_screen_framework['action_repeat_condition']['select']['id'] ,$allowed_html); echo wp_kses($message ,$allowed_html); ?>" class="<?php echo wp_kses($vtprd_deal_screen_framework['action_repeat_condition']['select']['class'] ,$allowed_html); ?>" name="<?php echo wp_kses($vtprd_deal_screen_framework['action_repeat_condition']['select']['name'] ,$allowed_html); echo wp_kses($message ,$allowed_html); ?>" tabindex="<?php //echo $vtprd_deal_screen_framework['action_repeat_condition']['select']['tabindex']; ?>" >          
                 <?php
                 for($i=0; $i < sizeof($vtprd_deal_screen_framework['action_repeat_condition']['option']); $i++) { 
                 ?>                             
                    <option id="<?php echo wp_kses($vtprd_deal_screen_framework['action_repeat_condition']['option'][$i]['id'] ,$allowed_html); echo wp_kses($message ,$allowed_html); ?>"  class="<?php echo wp_kses($vtprd_deal_screen_framework['action_repeat_condition']['option'][$i]['class'] ,$allowed_html); ?>"  value="<?php echo wp_kses($vtprd_deal_screen_framework['action_repeat_condition']['option'][$i]['value'] ,$allowed_html); ?>"   <?php if ($vtprd_deal_screen_framework['action_repeat_condition']['option'][$i]['value'] == $vtprd_rule->rule_deal_info[$k]['action_repeat_condition'] )  { echo wp_kses($selected ,$allowed_html); } ?> > <?php echo wp_kses($vtprd_deal_screen_framework['action_repeat_condition']['option'][$i]['title'] ,$allowed_html); ?> </option>
                 <?php } ?> 
               </select> 
               
                            
               <span class="amt-field action_repeat_count_area  action_repeat_count_area_class<?php echo wp_kses($message ,$allowed_html); ?>" id="action_repeat_count_area<?php echo wp_kses($message ,$allowed_html); ?>">
                 <input id="<?php echo wp_kses($vtprd_deal_screen_framework['action_repeat_count']['id'] ,$allowed_html); echo wp_kses($message ,$allowed_html); ?>" class="<?php echo wp_kses($vtprd_deal_screen_framework['action_repeat_count']['class'] ,$allowed_html); ?>" type="<?php echo wp_kses($vtprd_deal_screen_framework['action_repeat_count']['type'] ,$allowed_html); ?>" name="<?php echo wp_kses($vtprd_deal_screen_framework['action_repeat_count']['name'] ,$allowed_html); echo wp_kses($message ,$allowed_html); ?>" value="<?php echo wp_kses($vtprd_rule->rule_deal_info[$k]['action_repeat_count'] ,$allowed_html); ?>" />                 
               </span>
                        
               <span class="shortIntro  shortIntro2" >
                  <img  class="hasHoverHelp2" width="18px" alt=""  src="<?php echo esc_url($hoverhelpURL);?>" /> 
                  <?php vtprd_show_object_hover_help ('action_repeat_condition', 'small');?>
               </span>                                                   
           </span>
         </div><!-- //action_repeat_condition_box -->  
         
      </div><!-- //action_info -->  
        
      <div class="display-virtual_box" id="discount_info">
                 
          <div class="screen-box discount_amt_box  discount_amt_box_class<?php echo wp_kses($message ,$allowed_html); ?>" id="discount_amt_box<?php echo wp_kses($message ,$allowed_html); ?>" >  
            <span class="title" id="discount_amt_title<?php echo wp_kses($message ,$allowed_html); ?>" >
              <img class="discount_amt_title_icon" src="<?php echo esc_url(VTPRD_URL.'/admin/images/tab-icons.png');?>" width="1" height="1" />                            
              <a id="discount_amt_title_anchor<?php echo wp_kses($message ,$allowed_html); ?>" class="section-headings first-level-title" href="<?php echo esc_js('javascript:void(0);');?>"><?php esc_attr_e('Discount ', 'vtprd'); echo wp_kses($currency_symbol ,$allowed_html); ?></a>
            </span>
            
            <div  class="screen-box discount_amt_row clear-both" id="discount_amt_row<?php echo wp_kses($message ,$allowed_html); ?>">
              <span class="clear-left left-column">
                  <span class="title  discount_action_type  hasWizardHelpRight" id="discount_action_type_title<?php echo wp_kses($message ,$allowed_html); ?>" >            
                    <a id="discount_action_title_anchor<?php echo wp_kses($message ,$allowed_html); ?>" class="title-anchors second-level-title" href="<?php echo esc_js('javascript:void(0);');?>"><?php esc_attr_e('Discount Type', 'vtprd'); //v2.0.0 changed from Discount Amount?></a>
                    <span class="required-asterisk">*</span>
                  </span>
                  <?php vtprd_show_object_hover_help ('discount_amt_type', 'wizard');?>
              </span>
  
              <span class="dropdown discount_amt_type right-column" id="discount_amt_type_dropdown<?php echo wp_kses($message ,$allowed_html); ?>">              
                
                 <select id="<?php echo wp_kses($vtprd_deal_screen_framework['discount_amt_type']['select']['id'] ,$allowed_html); echo wp_kses($message ,$allowed_html); ?>" class="<?php echo wp_kses($vtprd_deal_screen_framework['discount_amt_type']['select']['class'] ,$allowed_html); ?>" name="<?php echo wp_kses($vtprd_deal_screen_framework['discount_amt_type']['select']['name'] ,$allowed_html); echo wp_kses($message ,$allowed_html); ?>" tabindex="<?php //echo $vtprd_deal_screen_framework['discount_amt_type']['select']['tabindex']; ?>" style="width: 61.5%;">          
                   <?php
                   for($i=0; $i < sizeof($vtprd_deal_screen_framework['discount_amt_type']['option']); $i++) { 
                            $this->vtprd_change_title_currency_symbol('discount_amt_type', $i, $currency_symbol);                 
                    ?>                                                
                      <option id="<?php echo wp_kses($vtprd_deal_screen_framework['discount_amt_type']['option'][$i]['id'] ,$allowed_html); echo wp_kses($message ,$allowed_html); ?>"  class="<?php echo wp_kses($vtprd_deal_screen_framework['discount_amt_type']['option'][$i]['class'] ,$allowed_html); ?>"  value="<?php echo wp_kses($vtprd_deal_screen_framework['discount_amt_type']['option'][$i]['value'] ,$allowed_html); ?>"   <?php if ($vtprd_deal_screen_framework['discount_amt_type']['option'][$i]['value'] == $vtprd_rule->rule_deal_info[$k]['discount_amt_type'] )  { echo wp_kses($selected ,$allowed_html); } ?> >  <?php echo wp_kses($vtprd_deal_screen_framework['discount_amt_type']['option'][$i]['title'] ,$allowed_html); ?> </option>
                   <?php } ?> 
                 </select>
                 
                  
                 <span class="discount_amt_count_area  discount_amt_count_area_class<?php echo wp_kses($message ,$allowed_html); ?>  amt-field" id="discount_amt_count_area<?php echo wp_kses($message ,$allowed_html); ?>">    
                   <span class="discount_amt_count_label" id="discount_amt_count_label<?php echo wp_kses($message ,$allowed_html); ?>"> 
                      <span class="forThePriceOf-amt-literal-inserted  discount_amt_count_literal  discount_amt_count_literal<?php echo wp_kses($message ,$allowed_html);?> " id="discount_amt_count_literal_forThePriceOf_buyAmt<?php echo wp_kses($message ,$allowed_html); ?>"><?php $this->vtprd_load_forThePriceOf_literal($k); ?> </span>
                      <span class="discount_amt_count_literal  discount_amt_count_literal_forThePriceOf  discount_amt_count_literal<?php echo wp_kses($message ,$allowed_html);?> " id="discount_amt_count_literal_forThePriceOf<?php echo wp_kses($message ,$allowed_html); ?>"><?php esc_attr_e('units ', 'vtprd'); ?> &nbsp; <?php  esc_attr_e(' For the Price of ', 'vtprd');?> </span>
                      <span class="discount_amt_count_literal  discount_amt_count_literal_forThePriceOf_Currency  discount_amt_count_literal<?php echo wp_kses($message ,$allowed_html);?> " id="discount_amt_count_literal_forThePriceOf_Currency<?php echo wp_kses($message ,$allowed_html); ?>"><?php echo wp_kses($currency_symbol,$allowed_html); ?></span>
                   </span>                 
                   <input id="<?php echo wp_kses($vtprd_deal_screen_framework['discount_amt_count']['id'] ,$allowed_html); echo wp_kses($message ,$allowed_html); ?>" class="<?php echo wp_kses($vtprd_deal_screen_framework['discount_amt_count']['class'] ,$allowed_html); ?>" type="<?php echo wp_kses($vtprd_deal_screen_framework['discount_amt_count']['type'] ,$allowed_html); ?>" name="<?php echo wp_kses($vtprd_deal_screen_framework['discount_amt_count']['name'] ,$allowed_html); echo wp_kses($message ,$allowed_html); ?>" value="<?php echo wp_kses($vtprd_rule->rule_deal_info[$k]['discount_amt_count'] ,$allowed_html); ?>" />                 
                   <span class="discount_amt_count_literal_units_area  discount_amt_count_literal<?php echo wp_kses($message ,$allowed_html);?>  discount_amt_count_literal_units_area_class<?php echo wp_kses($message ,$allowed_html); ?>" id="discount_amt_count_literal_units_area<?php echo wp_kses($message ,$allowed_html); ?>">
                     <span class="discount_amt_count_literal" id="discount_amt_count_literal_units<?php echo wp_kses($message ,$allowed_html); ?>"><?php esc_attr_e(' units', 'vtprd');?> </span>
                     <?php vtprd_show_help_tooltip($context = 'discount_amt_count_forThePriceOf'); ?>
                   </span>                
                 </span>
                  <label id="<?php echo wp_kses($vtprd_deal_screen_framework['discount_auto_add_free_product']['label']['id'] ,$allowed_html); echo wp_kses($message ,$allowed_html); ?>"   class="<?php echo wp_kses($vtprd_deal_screen_framework['discount_auto_add_free_product']['label']['class'] ,$allowed_html);?>"> 
                      
                      <input id="<?php echo wp_kses($vtprd_deal_screen_framework['discount_auto_add_free_product']['checkbox']['id'] ,$allowed_html); echo wp_kses($message ,$allowed_html); ?>" 
                            class="<?php echo wp_kses($vtprd_deal_screen_framework['discount_auto_add_free_product']['checkbox']['class'] ,$allowed_html); ?>  hasWizardHelpBelow"
                            type="checkbox" 
                            value="<?php echo wp_kses($vtprd_deal_screen_framework['discount_auto_add_free_product']['checkbox']['value'] ,$allowed_html); ?>" 
                             <?php if ($vtprd_deal_screen_framework['discount_auto_add_free_product']['checkbox']['value'] == $vtprd_rule->rule_deal_info[$k]['discount_auto_add_free_product'] )  { echo wp_kses($checked ,$allowed_html); } ?>
                            name="<?php echo wp_kses($vtprd_deal_screen_framework['discount_auto_add_free_product']['checkbox']['name'] ,$allowed_html); echo wp_kses($message ,$allowed_html); ?>" />
                      <?php vtprd_show_object_hover_help ('discount_free', 'wizard'); ?> 
                            
                      <?php echo wp_kses($vtprd_deal_screen_framework['discount_auto_add_free_product']['label']['title'] ,$allowed_html); ?>  
                      <?php vtprd_show_help_tooltip($context = 'discount_auto_add_free_product', $location = 'title'); ?> 
                  </label>
                          
                 <span class="shortIntro  shortIntro2" >
                    <img  class="hasHoverHelp2" width="18px" alt=""  src="<?php echo esc_url($hoverhelpURL);?>" /> 
                    <?php vtprd_show_object_hover_help ('discount_amt_type', 'small');?>
                 </span>                                     
              </span>
            </div> <!-- //discount_amt_row -->
          </div> <!-- //discount_amt_box -->
                  
          <div class="screen-box discount_applies_to_box  discount_applies_to_box_class<?php echo wp_kses($message ,$allowed_html); ?>" id="discount_applies_to_box<?php echo wp_kses($message ,$allowed_html); ?>" >
            <span class="left-column">
                <span class="title  hasWizardHelpRight" id="discount_applies_to_title<?php echo wp_kses($message ,$allowed_html); ?>" >
                  <a id="discount_applies_to_title_anchor<?php echo wp_kses($message ,$allowed_html); ?>" class="title-anchors second-level-title" href="<?php echo esc_js('javascript:void(0);');?>"><?php esc_attr_e('Discount Applies To', 'vtprd');?></a>
                </span>
                <?php vtprd_show_object_hover_help ('discount_applies_to', 'wizard');?>
            </span>
            
            <span class="dropdown discount_applies_to right-column"  id="discount_applies_to_dropdown<?php echo wp_kses($message ,$allowed_html); ?>">              
               
               <select id="<?php echo wp_kses($vtprd_deal_screen_framework['discount_applies_to']['select']['id'] ,$allowed_html); echo wp_kses($message ,$allowed_html); ?>" class="<?php echo wp_kses($vtprd_deal_screen_framework['discount_applies_to']['select']['class'] ,$allowed_html); ?>" name="<?php echo wp_kses($vtprd_deal_screen_framework['discount_applies_to']['select']['name'] ,$allowed_html); echo wp_kses($message ,$allowed_html); ?>" tabindex="<?php //echo $vtprd_deal_screen_framework['discount_applies_to']['select']['tabindex']; ?>" >          
                 <?php
                 for($i=0; $i < sizeof($vtprd_deal_screen_framework['discount_applies_to']['option']); $i++) { 
                 ?>                             
                    <option id="<?php echo wp_kses($vtprd_deal_screen_framework['discount_applies_to']['option'][$i]['id'] ,$allowed_html); echo wp_kses($message ,$allowed_html); ?>"  class="<?php echo wp_kses($vtprd_deal_screen_framework['discount_applies_to']['option'][$i]['class'] ,$allowed_html); ?>"  value="<?php echo wp_kses($vtprd_deal_screen_framework['discount_applies_to']['option'][$i]['value'] ,$allowed_html); ?>"   <?php if ($vtprd_deal_screen_framework['discount_applies_to']['option'][$i]['value'] == $vtprd_rule->rule_deal_info[$k]['discount_applies_to'] )  { echo wp_kses($selected ,$allowed_html); } ?> >  <?php echo wp_kses($vtprd_deal_screen_framework['discount_applies_to']['option'][$i]['title'] ,$allowed_html); ?> </option>
                 <?php } ?> 
               </select>
               
                               
                   <span class="shortIntro" >
                      <img  class="hasHoverHelp2" width="18px" alt=""  src="<?php echo esc_url($hoverhelpURL);?>" /> 
                     <?php vtprd_show_object_hover_help ('discount_applies_to', 'small');?>
                   </span>                                                                               
              </span>
              
             
               <div class="discount_applies_to_box_warning_class<?php echo wp_kses($message ,$allowed_html); ?> hideMe" id="bulk_box_currency_warning_<?php echo wp_kses($message ,$allowed_html); ?>" >
                 <p>
                    <span class="warning-line warning-line0"><?php esc_attr_e('Discount Applies to Setup', 'vtprd') ?></span>
                    <span class="warning-line warning-line2">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<?php esc_attr_e('When "All Products" selected, Unit Price discount can result in a "partial unit discount", which would be correct but confusing to the customer.', 'vtprd') ?></span>
                    <span class="warning-line warning-line1"><?php esc_attr_e('On Pricing Deals Settings page, at "Unit Price Discount or Coupon Discount", suggest selecting <strong>"Coupon Discount"</strong>', 'vtprd') ?></span> 
                 </p>             
               </div><!-- //discount_applies_to_box_warning -->              
              
              
          </div><!-- //discount_applies_to_box -->


          <?php //v1.1.0.8 New  BOX - only by coupon ;?>  
          <div class="screen-box only_for_this_coupon_box only_for_this_coupon_box_class<?php echo wp_kses($message ,$allowed_html); ?>" id="only_for_this_coupon_box<?php echo wp_kses($message ,$allowed_html); ?>" >     <?php //Rule repeat shifted to end of action area, although processed first ?> 
            <span class="left-column">
                <span class="title  third-level-title  hasWizardHelpRight" id="only_for_this_coupon_title">
                   <a id="only_for_this_coupon_anchor" class="title-anchors third-level-title" href="<?php echo esc_js('javascript:void(0);');?>"><?php esc_attr_e('Discount Coupon Code', 'vtprd');  //_e('Apply Discount only with', 'vtprd'); //echo '<br>'; esc_attr_e('This Coupon Code', 'vtprd');  // esc_attr_e('Discount Only with Coupon Code (optional)', 'vtprd'); ?> </a>
                </span>
                <?php vtprd_show_object_hover_help ('only_for_this_coupon_name', 'wizard');?>
            </span>
            
            <span class="dropdown buy_repeat right-column only_for_this_coupon_name-column" id="only_for_this_coupon_name_dropdown">              
                     <span class="column-width50">
                         <textarea rows="1" cols="50" id="<?php echo wp_kses($vtprd_rule_display_framework['only_for_this_coupon_name']['id'] ,$allowed_html); ?>" class="<?php echo wp_kses($vtprd_rule_display_framework['only_for_this_coupon_name']['class'] ,$allowed_html); ?>  right-column" type="<?php echo wp_kses($vtprd_rule_display_framework['only_for_this_coupon_name']['type'] ,$allowed_html); ?>" name="<?php echo wp_kses($vtprd_rule_display_framework['only_for_this_coupon_name']['name'] ,$allowed_html); ?>" ><?php echo wp_kses($vtprd_rule->only_for_this_coupon_name ,$allowed_html); ?></textarea>
                         
                     </span>              
                     <span class="shortIntro" >            
                        <img  class="hasHoverHelp2" width="18px" alt=""  src="<?php echo esc_url($hoverhelpURL);?>" /> 
                        <?php vtprd_show_object_hover_help ('only_for_this_coupon_name', 'small');?>
                     </span>                               
                               
                       
            </span>
                     
         </div><!-- //only_for_this_coupon_box-->  
                            
                  
        </div> <!-- //discount_info -->
  
        
        </div> <!-- //end DEAL INFO line in "for" loop --><?php //end DEAL INFO line in "for" loop ?>   
      <?php } //end $k'for' LOOP ?>
      </div> <!-- //rule_deal_info_group --> <?php //end rule_deal_info_group ?>  
      
      <div id="messages-outer-box">           
         <div class="screen-box  messages-box_class" id="messages-box">
           <span class="title" id="discount_msgs_title" >
              <img class="theme_msgs_title_icon" src="<?php echo esc_url(VTPRD_URL.'/admin/images/tab-icons.png');?>" width="1" height="1" />                                          
              <a id="discount_msgs_title_anchor" class="section-headings first-level-title" href="<?php echo esc_js('javascript:void(0);');?>"><?php esc_attr_e('Discount Messages:', 'vtprd');?></a>            
           </span>
           <span class="dropdown messages-box-area clear-left"  id="discount_msgs_dropdown">
             <span class="discount_product_short_msg_area  clear-left">

                 <span class="left-column">
                     <span class="title  hasHoverHelp  hasWizardHelpRight">                
                         <span class="title-anchors" id="discount_product_short_msg_label"><?php esc_attr_e('Checkout Message', 'vtprd'); ?></span> 
                         <span class="required-asterisk">*</span>
                     </span>
                     <?php vtprd_show_object_hover_help ('discount_product_short_msg', 'wizard');?>
                 </span>

                 <span class="right-column">
                     <span class="column-width50">
                         <textarea rows="1" cols="50" id="<?php echo wp_kses($vtprd_rule_display_framework['discount_product_short_msg']['id'] ,$allowed_html); ?>" class="<?php echo wp_kses($vtprd_rule_display_framework['discount_product_short_msg']['class'] ,$allowed_html); ?>  right-column" type="<?php echo wp_kses($vtprd_rule_display_framework['discount_product_short_msg']['type'] ,$allowed_html); ?>" name="<?php echo wp_kses($vtprd_rule_display_framework['discount_product_short_msg']['name'] ,$allowed_html); ?>" ><?php echo esc_textarea($vtprd_rule->discount_product_short_msg); ?></textarea>
                         
                     </span>              
                     <span class="shortIntro" style="margin-top:3px;">                        
                        <img  class="hasHoverHelp2" width="18px" alt=""  src="<?php echo esc_url($hoverhelpURL);?>" /> 
                        <?php vtprd_show_object_hover_help ('discount_product_short_msg', 'small');?>
                     </span>                               

                  </span>                      
             </span>
             
                               
             <?php //<span class="bulk-checkout-msg  clear-both" id="bulk-checkout-msg-comment1"> ('Ex: " Your bulk purchase was discounted by <strong>{show_discount_val}</strong> "', 'vtprd') </span>   ?>    
             <span class="bulk-checkout-msg  clear-both" id="bulk-checkout-msg-comment1"> <?php esc_attr_e('<strong>{show_discount_val}</strong> &nbsp; - wildcard shows discount percent or discount amount applied from Pricing Table', 'vtprd');?> </span>             
             <span class="bulk-checkout-msg  clear-both" id="bulk-checkout-msg-comment3"> <?php esc_attr_e('<strong>{show_discount_val_more}</strong> &nbsp; -  wildcard shows discount val and more in msg ', 'vtprd');?> </span>
             
                    
             <span class="discount_product_full_msg_area clear-both">

                 <span class="left-column">
                     <span class="title  hasWizardHelpRight">                
                         <span class="title-anchors" id="discount_product_full_msg_label"> <?php esc_attr_e('Advertising Message', 'vtprd');?> </span> 
                     </span>
                     <?php vtprd_show_object_hover_help ('discount_product_full_msg', 'wizard');?>
                 </span>
                                    
                 <span class="right-column">                
                     <span class="column-width50">
                         <textarea rows="2" cols="35" id="<?php echo wp_kses($vtprd_rule_display_framework['discount_product_full_msg']['id'] ,$allowed_html); ?>" class="<?php echo wp_kses($vtprd_rule_display_framework['discount_product_full_msg']['class'] ,$allowed_html); ?>  right-column" type="<?php echo wp_kses($vtprd_rule_display_framework['discount_product_full_msg']['type'] ,$allowed_html); ?>" name="<?php echo wp_kses($vtprd_rule_display_framework['discount_product_full_msg']['name'] ,$allowed_html); ?>" ><?php echo esc_textarea($vtprd_rule->discount_product_full_msg); ?></textarea>                                                                                              
                         
                     </span>                               
                     <span class="shortIntro"  style="margin-top:3px;">
                        <img  class="hasHoverHelp2" width="18px" alt=""  src="<?php echo esc_url($hoverhelpURL);?>" /> 
                       <?php vtprd_show_object_hover_help ('discount_product_full_msg', 'small');?>
                     </span> 
                                            
                  </span> 
            
             </span>

           </span>
         </div>    
      </div>
       
    <div id="advanced-data-area"> 

      <div class="screen-box" id="maximums_box">   
          <span class="title" id="cumulativePricing_title" >
            <img class="maximums_icon" src="<?php echo esc_url(VTPRD_URL.'/admin/images/tab-icons.png');?>" width="1" height="1" />                                                        
            <a id="cumulativePricing_title_anchor" class="section-headings first-level-title" href="<?php echo esc_js('javascript:void(0);');?>">
                <?php esc_attr_e('Discount Limits:', 'vtprd');?>
                <?php if (!defined('VTPRD_PRO_DIRNAME'))  {  ?>
                    <span id="max-limits-subtitle"><?php esc_attr_e('(pro only)', 'vtprd');?></span>
                <?php }  ?>
            </a>
          </span>
 
           
        
          <div class="screen-box  screen-box2 discount_lifetime_max_amt_type_box  clear-left" id="discount_lifetime_max_amt_type_box_0">  
             <?php
                 /* ***********************
                 special handling for  discount_lifetime_max_amt_type, discount_lifetime_max_amt_type.  Even though they appear iteratively in deal info,
                 they are only active on the '0' occurrence line.  further, they are displayed only AFTER all of the deal lines are displayed
                 onscreen... This is actually a kluge, done to utilize the complete editing already available in the deal info loop for a  dropdown and an associated amt field.
                 *********************** */
             
               //Both _label fields have trailing '_0', as edits are actually handled in the discount info loop ?>          
            <span class="left-column  left-column-less-padding-top2">
                <span class="title  hasWizardHelpRight" id="discount_lifetime_max_title_0" >
                  <a id="discount_lifetime_max_title_anchor" class="title-anchors second-level-title" href="<?php echo esc_js('javascript:void(0);');?>"><?php esc_attr_e('Customer', 'vtprd'); ?> <br> <?php esc_attr_e('Rule Limit', 'vtprd');?></a>
                </span>
                <?php vtprd_show_object_hover_help ('discount_lifetime_max_amt_type', 'wizard'); ?> 
            </span>
            
            <span class="dropdown  right-column" id="discount_lifetime_max_dropdown">
               
               <select id="<?php echo wp_kses($vtprd_deal_screen_framework['discount_lifetime_max_amt_type']['select']['id'] ,$allowed_html); echo wp_kses('_0' ,$allowed_html);?>" class="<?php echo wp_kses($vtprd_deal_screen_framework['discount_lifetime_max_amt_type']['select']['class'] ,$allowed_html); ?>" name="<?php echo wp_kses($vtprd_deal_screen_framework['discount_lifetime_max_amt_type']['select']['name'] ,$allowed_html); echo wp_kses('_0' ,$allowed_html);?>" tabindex="<?php echo wp_kses($vtprd_deal_screen_framework['discount_lifetime_max_amt_type']['select']['tabindex'] ,$allowed_html); echo wp_kses('_0' ,$allowed_html); ?>" >          
                 <?php
                 for($i=0; $i < sizeof($vtprd_deal_screen_framework['discount_lifetime_max_amt_type']['option']); $i++) { 
                          $this->vtprd_change_title_currency_symbol('discount_lifetime_max_amt_type', $i, $currency_symbol);

                      //pick up the free/pro version of the title => in this case, title and title3
                      $title = $vtprd_deal_screen_framework['discount_lifetime_max_amt_type']['option'][$i]['title'];
                      if ( ( defined('VTPRD_PRO_DIRNAME') ) &&
                           ( isset($vtprd_deal_screen_framework['discount_lifetime_max_amt_type']['option'][$i]['title3']) ) &&    //v2.0.3
                           ( $vtprd_deal_screen_framework['discount_lifetime_max_amt_type']['option'][$i]['title3'] > ' ' ) ) {
                        $title = $vtprd_deal_screen_framework['discount_lifetime_max_amt_type']['option'][$i]['title3'];                        
                      }         
                                                            
                 ?>                             
                    <option id="<?php echo wp_kses($vtprd_deal_screen_framework['discount_lifetime_max_amt_type']['option'][$i]['id'] ,$allowed_html); echo wp_kses('_0' ,$allowed_html);?>"  class="<?php echo wp_kses($vtprd_deal_screen_framework['discount_lifetime_max_amt_type']['option'][$i]['class'] ,$allowed_html); ?>"  value="<?php echo wp_kses($vtprd_deal_screen_framework['discount_lifetime_max_amt_type']['option'][$i]['value'] ,$allowed_html); ?>"   <?php if ($vtprd_deal_screen_framework['discount_lifetime_max_amt_type']['option'][$i]['value']  == $vtprd_rule->rule_deal_info[0]['discount_lifetime_max_amt_type']  )  { echo wp_kses($selected ,$allowed_html); } // use '0' deal_info_line...?> >  <?php echo wp_kses($title ,$allowed_html); ?> </option>
                 <?php } ?> 
               </select>
               
                           
               <span class="amt-field" id="discount_lifetime_max_amt_count_area">
 
                 <input id="<?php echo wp_kses($vtprd_deal_screen_framework['discount_lifetime_max_amt_count']['id'] ,$allowed_html); echo wp_kses('_0' ,$allowed_html); ?>" class="<?php echo wp_kses($vtprd_deal_screen_framework['discount_lifetime_max_amt_count']['class'] ,$allowed_html); ?>  limit-count" type="<?php echo wp_kses($vtprd_deal_screen_framework['discount_lifetime_max_amt_count']['type'] ,$allowed_html); ?>" name="<?php echo wp_kses($vtprd_deal_screen_framework['discount_lifetime_max_amt_count']['name'] ,$allowed_html); echo wp_kses('_0' ,$allowed_html);?>" value="<?php echo wp_kses($vtprd_rule->rule_deal_info[0]['discount_lifetime_max_amt_count'] ,$allowed_html); // use '0' deal_info_line...?>" />
               </span>
            
                        
               <span class="shortIntro  shortIntro2" >
                  <img  class="hasHoverHelp2" width="18px" alt=""  src="<?php echo esc_url($hoverhelpURL);?>" /> 
                  <?php vtprd_show_object_hover_help ('discount_lifetime_max_amt_type', 'small');?>
               </span>                               

            </span>
            <span class="text-field  clear-left" id="discount_lifetime_max_amt_msg">
               <span class="data-line-indent">&nbsp;</span>
               <span class="text-field-label" id="discount_lifetime_max_amt_msg_label"> <?php esc_attr_e('Short Message When Max Applied (opt) ', 'vtprd');?> </span>
                <?php vtprd_show_help_tooltip($context = 'discount_lifetime_max_amt_msg'); ?>
               <textarea rows="1" cols="100" id="<?php echo wp_kses($vtprd_rule_display_framework['discount_lifetime_max_amt_msg']['id'] ,$allowed_html); ?>" class="<?php echo wp_kses($vtprd_rule_display_framework['discount_lifetime_max_amt_msg']['class'] ,$allowed_html); ?>" type="<?php echo wp_kses($vtprd_rule_display_framework['discount_lifetime_max_amt_msg']['type'] ,$allowed_html); ?>" name="<?php echo wp_kses($vtprd_rule_display_framework['discount_lifetime_max_amt_msg']['name'] ,$allowed_html); ?>" ><?php echo esc_textarea($vtprd_rule->discount_lifetime_max_amt_msg); ?></textarea>
            </span>
            
            <?php //v2.0.2.0 begin ?>
            <span class='custLimit_addl_info  clear-left hideMe'>               
              <span class='custLimit_addl_info-line1  clear-left'>
                <em><?php esc_attr_e('Customer Rule Limit settings', 'vtprd'); ?> </em> <?php esc_attr_e(' - go to the ==>> ', 'vtprd'); ?>
                <a id="custLimit_addl_inf_anchor" class=" " target="_blank" href="<?php echo esc_url(VTPRD_ADMIN_URL.'edit.php?post_type=vtprd-rule&page=vtprd_setup_options_page#vtprd-lifetime-options-anchor');?>"><?php esc_attr_e('Pricing Deals Settings page', 'vtprd');?> </a> 
              </span>                        
            </span>
            <?php //v2.0.2.0 end ?>            
                       
          </div> 
                   
                    
          
 
           
        <div class="screen-box  screen-box2  dropdown discount_rule_max_amt_type discount_rule_max_amt_type_box clear-left" id="discount_rule_max_amt_type_box_0">  
             <?php
                 /* ***********************
                 special handling for  discount_rule_max_amt_type, discount_rule_max_amt_type.  Even though they appear iteratively in deal info,
                 they are only active on the '0' occurrence line.  further, they are displayed only AFTER all of the deal lines are displayed
                 onscreen... This is actually a kluge, done to utilize the complete editing already available in the deal info loop for a  dropdown and an associated amt field.
                 *********************** */
             
               //Both _label fields have trailing '_0', as edits are actually handled in the discount info loop ?>          
            <span class="left-column">
                <span class="title  hasWizardHelpRight" id="discount_rule_max_title_0" >
                  <a id="discount_rule_max_title_anchor" class="title-anchors second-level-title" href="<?php echo esc_js('javascript:void(0);');?>"><?php esc_attr_e('Cart Limit', 'vtprd');?></a>
                </span>
                <?php vtprd_show_object_hover_help ('discount_rule_max_amt_type', 'wizard'); ?>                
            </span>   
                    
            <span class="dropdown right-column" id="discount_rule_max_dropdown">
                
                <select id="<?php echo wp_kses($vtprd_deal_screen_framework['discount_rule_max_amt_type']['select']['id'] ,$allowed_html); echo wp_kses('_0' ,$allowed_html);?>" class="<?php echo wp_kses($vtprd_deal_screen_framework['discount_rule_max_amt_type']['select']['class'] ,$allowed_html); ?>" name="<?php echo wp_kses($vtprd_deal_screen_framework['discount_rule_max_amt_type']['select']['name'] ,$allowed_html); echo wp_kses('_0' ,$allowed_html);?>" tabindex="" >          
                 <?php
                 for($i=0; $i < sizeof($vtprd_deal_screen_framework['discount_rule_max_amt_type']['option']); $i++) {
                          $this->vtprd_change_title_currency_symbol('discount_rule_max_amt_type', $i, $currency_symbol); 
                 ?>                             
                    <option id="<?php echo wp_kses($vtprd_deal_screen_framework['discount_rule_max_amt_type']['option'][$i]['id'] ,$allowed_html); echo wp_kses('_0' ,$allowed_html);?>"  class="<?php echo wp_kses($vtprd_deal_screen_framework['discount_rule_max_amt_type']['option'][$i]['class'] ,$allowed_html); ?>"  value="<?php echo wp_kses($vtprd_deal_screen_framework['discount_rule_max_amt_type']['option'][$i]['value'] ,$allowed_html); ?>"   <?php if ($vtprd_deal_screen_framework['discount_rule_max_amt_type']['option'][$i]['value']  == $vtprd_rule->rule_deal_info[0]['discount_rule_max_amt_type']  )  { echo wp_kses($selected ,$allowed_html); }  ?> >  <?php echo wp_kses($vtprd_deal_screen_framework['discount_rule_max_amt_type']['option'][$i]['title'] ,$allowed_html); ?>  </option>
                 <?php } ?> 
                </select> 
                
                
                <span class="amt-field  " id="discount_rule_max_amt_count_area">
                 <input id="<?php echo wp_kses($vtprd_deal_screen_framework['discount_rule_max_amt_count']['id'] ,$allowed_html); echo wp_kses('_0' ,$allowed_html); ?>" class="<?php echo wp_kses($vtprd_deal_screen_framework['discount_rule_max_amt_count']['class'] ,$allowed_html); ?>  limit-count" type="<?php echo wp_kses($vtprd_deal_screen_framework['discount_rule_max_amt_count']['type'] ,$allowed_html); ?>" name="<?php echo wp_kses($vtprd_deal_screen_framework['discount_rule_max_amt_count']['name'] ,$allowed_html); echo wp_kses('_0' ,$allowed_html);?>" value="<?php echo wp_kses($vtprd_rule->rule_deal_info[0]['discount_rule_max_amt_count'] ,$allowed_html); // use '0' deal_info_line...?>" />
                </span>
                        
               <span class="shortIntro  shortIntro2" >
                  <img  class="hasHoverHelp2" width="18px" alt=""  src="<?php echo esc_url($hoverhelpURL);?>" /> 
                  <?php vtprd_show_object_hover_help ('discount_rule_max_amt_type', 'small');?>
               </span>                                  
            </span>

           <?php //while the 2 max_amt fields above are kluged onto the deal_screen_framework, the msg field is on the rule proper ?>
           <span class="text-field  clear-left" id="discount_rule_max_amt_msg">
             <span class="data-line-indent">&nbsp;</span>
             <span class="left-column">
                 <span class="text-field-label" id="discount_rule_max_amt_msg_label"> <?php esc_attr_e('Short Message When Max Applied (opt) ', 'vtprd');?> </span>
                  <?php vtprd_show_help_tooltip($context = 'discount_rule_max_amt_msg'); ?>
             </span>
             <textarea rows="1" cols="100" id="<?php echo wp_kses($vtprd_rule_display_framework['discount_rule_max_amt_msg']['id'] ,$allowed_html); ?>" class="<?php echo wp_kses($vtprd_rule_display_framework['discount_rule_max_amt_msg']['class'] ,$allowed_html); ?> right-column" type="<?php echo wp_kses($vtprd_rule_display_framework['discount_rule_max_amt_msg']['type'] ,$allowed_html); ?>" name="<?php echo wp_kses($vtprd_rule_display_framework['discount_rule_max_amt_msg']['name'] ,$allowed_html); ?>" ><?php echo esc_textarea($vtprd_rule->discount_rule_max_amt_msg); ?></textarea>
           </span>           
        </div>     
  
            <div class="screen-box  screen-box2  dropdown discount_rule_cum_max_amt_type discount_rule_cum_max_amt_type_box clear-left" id="discount_rule_cum_max_amt_type_box_0">  
                 <?php
                     /* ***********************
                     special handling for  discount_rule_cum_max_amt_type, discount_rule_cum_max_amt_type.  Even though they appear iteratively in deal info,
                     they are only active on the '0' occurrence line.  further, they are displayed only AFTER all of the deal lines are displayed
                     onscreen... This is actually a kluge, done to utilize the complete editing already available in the deal info loop for a  dropdown and an associated amt field.
                     *********************** */
                 
                   //Both _label fields have trailing '_0', as edits are actually handled in the discount info loop ?>          
                <span class="left-column">
                    <span class="title  hasWizardHelpRight" >
                      <span class="title-anchors" id="discount_rule_cum_max_title_0" ><?php esc_attr_e('Product Limit', 'vtprd');?></span>
                    </span> 
                    <?php vtprd_show_object_hover_help ('discount_rule_cum_max_amt_type', 'wizard'); ?>      
                </span>
                
                <span class="dropdown right-column" id="discount_rule_cum_max_dropdown">                                                         
                   
                   <select id="<?php echo wp_kses($vtprd_deal_screen_framework['discount_rule_cum_max_amt_type']['select']['id'] ,$allowed_html); echo wp_kses('_0' ,$allowed_html);?>" class="<?php echo wp_kses($vtprd_deal_screen_framework['discount_rule_cum_max_amt_type']['select']['class'] ,$allowed_html); ?>" name="<?php echo wp_kses($vtprd_deal_screen_framework['discount_rule_cum_max_amt_type']['select']['name'] ,$allowed_html); echo wp_kses('_0' ,$allowed_html);?>" tabindex="" >          
                     <?php
                     for($i=0; $i < sizeof($vtprd_deal_screen_framework['discount_rule_cum_max_amt_type']['option']); $i++) { 
                              $this->vtprd_change_title_currency_symbol('discount_rule_cum_max_amt_type', $i, $currency_symbol);             
                     ?>                             
                        <option id="<?php echo wp_kses($vtprd_deal_screen_framework['discount_rule_cum_max_amt_type']['option'][$i]['id'] ,$allowed_html); echo wp_kses('_0' ,$allowed_html);?>"  class="<?php echo wp_kses($vtprd_deal_screen_framework['discount_rule_cum_max_amt_type']['option'][$i]['class'] ,$allowed_html); ?>"  value="<?php echo wp_kses($vtprd_deal_screen_framework['discount_rule_cum_max_amt_type']['option'][$i]['value'] ,$allowed_html); ?>"   <?php if ($vtprd_deal_screen_framework['discount_rule_cum_max_amt_type']['option'][$i]['value']  == $vtprd_rule->rule_deal_info[0]['discount_rule_cum_max_amt_type']  )  { echo wp_kses($selected ,$allowed_html); } // use '0' deal_info_line...?> >  <?php echo wp_kses($vtprd_deal_screen_framework['discount_rule_cum_max_amt_type']['option'][$i]['title'] ,$allowed_html); ?> </option>
                     <?php } ?> 
                   </select>
                   
                    
                   <span class="amt-field" id="discount_rule_cum_max_amt_count_area">
              
                     <input id="<?php echo wp_kses($vtprd_deal_screen_framework['discount_rule_cum_max_amt_count']['id'] ,$allowed_html); echo wp_kses('_0' ,$allowed_html); ?>" class="<?php echo wp_kses($vtprd_deal_screen_framework['discount_rule_cum_max_amt_count']['class'] ,$allowed_html); ?>  limit-count" type="<?php echo wp_kses($vtprd_deal_screen_framework['discount_rule_cum_max_amt_count']['type'] ,$allowed_html); ?>" name="<?php echo wp_kses($vtprd_deal_screen_framework['discount_rule_cum_max_amt_count']['name'] ,$allowed_html); echo wp_kses('_0' ,$allowed_html);?>" value="<?php echo wp_kses($vtprd_rule->rule_deal_info[0]['discount_rule_cum_max_amt_count'] ,$allowed_html); // use '0' deal_info_line...?>" />
                   </span>
                        
                   <span class="shortIntro  shortIntro2" >
                      <img  class="hasHoverHelp2" width="18px" alt=""  src="<?php echo esc_url($hoverhelpURL);?>" /> 
                      <?php vtprd_show_object_hover_help ('discount_rule_max_amt_type', 'small');?>
                   </span>                                
                </span>
               <span class="text-field  clear-left" id="discount_rule_cum_max_amt_msg">
                 <span class="data-line-indent">&nbsp;</span>
                 <span class="text-field-label" id="discount_rule_cum_max_amt_msg_label"> <?php esc_attr_e('Short Message When Max Applied (opt) ', 'vtprd');?> </span>
                  <?php vtprd_show_help_tooltip($context = 'discount_rule_cum_max_amt_msg'); ?>
                 <textarea rows="1" cols="100" id="<?php echo wp_kses($vtprd_rule_display_framework['discount_rule_cum_max_amt_msg']['id'] ,$allowed_html); ?>" class="<?php echo wp_kses($vtprd_rule_display_framework['discount_rule_cum_max_amt_msg']['class'] ,$allowed_html); ?>" type="<?php echo wp_kses($vtprd_rule_display_framework['discount_rule_cum_max_amt_msg']['type'] ,$allowed_html); ?>" name="<?php echo wp_kses($vtprd_rule_display_framework['discount_rule_cum_max_amt_msg']['name'] ,$allowed_html); ?>" ><?php echo wp_kses($vtprd_rule->discount_rule_cum_max_amt_msg ,$allowed_html); ?></textarea>
               </span>
            </div>                
          
      </div> <?php //end maximums_box box ?>                      

      <div class="screen-box" id="cumulativePricing_box">     
          <span class="title" id="cumulativePricing_title" >
            <img class="working_together_icon" src="<?php echo esc_url(VTPRD_URL.'/admin/images/tab-icons.png');?>" width="1" height="1" />                                                        
            <a id="cumulativePricing_title_anchor" class="section-headings first-level-title" href="<?php echo esc_js('javascript:void(0);');?>"><?php esc_attr_e('Discount Works Together With:', 'vtprd');?></a>
          </span>
          
          <div class="clear-left" id="cumulativePricing_dropdown">       
            <div class="screen-box dropdown cumulativeRulePricing_area clear-left" id="cumulativeRulePricing_areaID"> 
               
               <span class="left-column  left-column-less-padding-top">
                  <span class="title  hasWizardHelpRight" >
                    <span class="cumulativeRulePricing_lit" id="cumulativeRulePricing_label"><?php esc_attr_e('Other', 'vtprd'); ?> &nbsp;<br> <?php  esc_attr_e('Rule Discounts', 'vtprd');?></span>
                  </span> 
                  <?php vtprd_show_object_hover_help ('cumulativeRulePricing', 'wizard'); ?>    
               </span>
               
               <span class="right-column">
                   <span class="column-width50"> 
                     <select id="<?php echo wp_kses($vtprd_rule_display_framework['cumulativeRulePricing']['select']['id'] ,$allowed_html);?>" class="<?php echo wp_kses($vtprd_rule_display_framework['cumulativeRulePricing']['select']['class'] ,$allowed_html); ?>" name="<?php echo wp_kses($vtprd_rule_display_framework['cumulativeRulePricing']['select']['name'] ,$allowed_html);?>" tabindex="" >          
                       <?php
                       for($i=0; $i < sizeof($vtprd_rule_display_framework['cumulativeRulePricing']['option']); $i++) { 
                       ?>                             
                          <option id="<?php echo wp_kses($vtprd_rule_display_framework['cumulativeRulePricing']['option'][$i]['id'] ,$allowed_html); ?>"  class="<?php echo wp_kses($vtprd_rule_display_framework['cumulativeRulePricing']['option'][$i]['class'] ,$allowed_html); ?>"  value="<?php echo wp_kses($vtprd_rule_display_framework['cumulativeRulePricing']['option'][$i]['value'] ,$allowed_html); ?>"   <?php if ($vtprd_rule_display_framework['cumulativeRulePricing']['option'][$i]['value'] == $vtprd_rule->cumulativeRulePricing )  { echo wp_kses($selected ,$allowed_html); } ?> >  <?php echo wp_kses($vtprd_rule_display_framework['cumulativeRulePricing']['option'][$i]['title'] ,$allowed_html); ?> </option>
                       <?php } ?> 
                     </select>
                     
                     
                     <span class="" id="priority_num">   <?php //only display if multiple rule discounts  ?>
                       <span class="text-field" id="ruleApplicationPriority_num">
                         <span class="text-field-label" id="ruleApplicationPriority_num_label"> <?php esc_attr_e('Priority', 'vtprd');//_e('Rule Priority Sort Number:', 'vtprd');?> </span>
                         <input id="<?php echo wp_kses($vtprd_rule_display_framework['ruleApplicationPriority_num']['id'] ,$allowed_html); ?>" class="<?php echo wp_kses($vtprd_rule_display_framework['ruleApplicationPriority_num']['class'] ,$allowed_html); ?>" type="<?php echo wp_kses($vtprd_rule_display_framework['ruleApplicationPriority_num']['type'] ,$allowed_html); ?>" name="<?php echo wp_kses($vtprd_rule_display_framework['ruleApplicationPriority_num']['name'] ,$allowed_html); ?>" value="<?php echo wp_kses($vtprd_rule->ruleApplicationPriority_num ,$allowed_html); ?>" />
                       </span>
                     </span>
                   </span>           
                   <span class="shortIntro  shortIntro2" >
                      <img  class="hasHoverHelp2" width="18px" alt=""  src="<?php echo esc_url($hoverhelpURL);?>" /> 
                      <?php vtprd_show_object_hover_help ('cumulativeRulePricing', 'small');?>
                   </span>                                   
               </span> 
                            
            </div>
    
            <div class="screen-box dropdown cumulativeCouponPricing_area clear-left" id="cumulativeCouponPricing_0">              
               <span class="left-column  left-column-less-padding-top">
                  <span class="title  hasWizardHelpRight" >
                    <span class="cumulativeRulePricing_lit" id="cumulativeCouponPricing_label"><?php esc_attr_e('Other', 'vtprd'); ?> <br> <?php esc_attr_e('Coupon Discounts', 'vtprd');?> </span>
                    </span> 
                  <?php vtprd_show_object_hover_help ('cumulativeCouponPricing', 'wizard'); ?>  
               </span>              
               <span class="right-column">
                   <span class="column-width50"> 
                     <select id="<?php echo wp_kses($vtprd_rule_display_framework['cumulativeCouponPricing']['select']['id'] ,$allowed_html);?>" class="<?php echo wp_kses($vtprd_rule_display_framework['cumulativeCouponPricing']['select']['class'] ,$allowed_html); ?>" name="<?php echo wp_kses($vtprd_rule_display_framework['cumulativeCouponPricing']['select']['name'] ,$allowed_html);?>" tabindex="" >          
                       <?php
                       for($i=0; $i < sizeof($vtprd_rule_display_framework['cumulativeCouponPricing']['option']); $i++) { 
                       ?>                             
                          <option id="<?php echo wp_kses($vtprd_rule_display_framework['cumulativeCouponPricing']['option'][$i]['id'] ,$allowed_html); ?>"  class="<?php echo wp_kses($vtprd_rule_display_framework['cumulativeCouponPricing']['option'][$i]['class'] ,$allowed_html); ?>"  value="<?php echo wp_kses($vtprd_rule_display_framework['cumulativeCouponPricing']['option'][$i]['value'] ,$allowed_html); ?>"   <?php if ($vtprd_rule_display_framework['cumulativeCouponPricing']['option'][$i]['value'] == $vtprd_rule->cumulativeCouponPricing )  { echo wp_kses($selected ,$allowed_html); } ?> >  <?php echo wp_kses($vtprd_rule_display_framework['cumulativeCouponPricing']['option'][$i]['title'] ,$allowed_html); ?> </option>
                       <?php } ?> 
                     </select>
                     
                   </span>           
                   <span class="shortIntro  shortIntro2" >
                      <img  class="hasHoverHelp2" width="18px" alt=""  src="<?php echo esc_url($hoverhelpURL);?>" /> 
                     <?php vtprd_show_object_hover_help ('cumulativeCouponPricing', 'small');?>
                   </span>                               

               </span> 
            </div>
                 
            <div class="screen-box dropdown cumulativeSalePricing_area clear-left" id="cumulativeSalePricing_areaID">              
               <span class="left-column  left-column-less-padding-top">
                   <span class="title  hasWizardHelpRight" >
                     <span class="cumulativeRulePricing_lit" id="cumulativeSalePricing_label"><?php esc_attr_e('Product', 'vtprd'); ?> &nbsp;<br> <?php esc_attr_e('Sale Pricing', 'vtprd');?></span>
                   </span> 
                   <?php vtprd_show_object_hover_help ('cumulativeSalePricing', 'wizard'); ?>                
               </span>
               <span class="right-column">
                   
                   <select id="<?php echo wp_kses($vtprd_rule_display_framework['cumulativeSalePricing']['select']['id'] ,$allowed_html);?>" class="<?php echo wp_kses($vtprd_rule_display_framework['cumulativeSalePricing']['select']['class'] ,$allowed_html); ?>" name="<?php echo wp_kses($vtprd_rule_display_framework['cumulativeSalePricing']['select']['name'] ,$allowed_html);?>" tabindex="" >          
                     <?php
                     for($i=0; $i < sizeof($vtprd_rule_display_framework['cumulativeSalePricing']['option']); $i++) { 
                     ?>                             
                        <option id="<?php echo wp_kses($vtprd_rule_display_framework['cumulativeSalePricing']['option'][$i]['id'] ,$allowed_html); ?>"  class="<?php echo wp_kses($vtprd_rule_display_framework['cumulativeSalePricing']['option'][$i]['class'] ,$allowed_html); ?>"  value="<?php echo wp_kses($vtprd_rule_display_framework['cumulativeSalePricing']['option'][$i]['value'] ,$allowed_html); ?>"   <?php if ($vtprd_rule_display_framework['cumulativeSalePricing']['option'][$i]['value'] == $vtprd_rule->cumulativeSalePricing )  { echo wp_kses($selected ,$allowed_html); } ?> >  <?php echo wp_kses($vtprd_rule_display_framework['cumulativeSalePricing']['option'][$i]['title'] ,$allowed_html); ?> </option>
                     <?php } ?> 
                   </select> 
                   
                        
                   <span class="shortIntro  shortIntro2" >
                      <img  class="hasHoverHelp2" width="18px" alt=""  src="<?php echo esc_url($hoverhelpURL);?>" /> 
                      <?php vtprd_show_object_hover_help ('cumulativeSalePricing', 'small'); ?>
                   </span>                                                 
               </span>
               <?php //if (VTPRD_PARENT_PLUGIN_NAME == 'WP E-Commerce') { vtprd_show_help_tooltip($context = 'cumulativeSalePricingLimitation');  } //v2.0.3 REMOVED ?> 
            </div>
          </div>  <?php //end cumulativeRulePricing_dropdown ?>  
       </div> <?php //end cumulativePricing box ?>  

      </div> <?php //end advanced-data-area ?>
            
      </div> <?php //lower-screen-wrapper ?>
      
      <?php 
          
    //lots of selects change their values between standard and 'discounted' titles.
    //This is where we supply the HIDEME alternative titles
    $this->vtprd_print_alternative_title_selects();  
    

         
  }  //end vtprd_deal

      
  
    public    function vtprd_buy_group_cntl() {   
       global $post, $vtprd_info, $vtprd_rule, $vtprd_rule_display_framework, $vtprd_rules_set;
       $selected = 'selected="selected"';
       $checked = 'checked="checked"'; 
       $allowed_html = vtprd_get_allowed_html(); //v2.0.3 
 
       //*****************************
       //v2.0.0 begin
       //*****************************
       
       if(defined('VTPRD_PRO_DIRNAME')) { 
          $prodcat_msg    =  __( 'Search Product Cat &hellip;', 'vtprd' ); 
          $plugincat_msg  =  __( 'Search Pricing Deal Cat&hellip;', 'vtprd' );
          $product_msg    =  __( 'Search Product &hellip;', 'vtprd' );
          $role_msg       =  __( 'Search Role &hellip;', 'vtprd' );
          $email_msg      =  __( 'Search Email or Name &hellip;', 'vtprd' );
          $selector_msg   = null;      
       } else {
          $pro_only_msg   =  __( '* Pro - only * Search &hellip;', 'vtprd' );
          $prodcat_msg    =  $pro_only_msg; 
          $plugincat_msg  =  $pro_only_msg; 
          $product_msg    =  $pro_only_msg; 
          $role_msg       =  $pro_only_msg; 
          $email_msg      =  $pro_only_msg;
          $selector_msg   = '<h4 class="clear-left free-warning">- Yellow selectors not available in Free version -  </h4>'; 
       } ?> 

      <div class="buy-group-select-product-area  clear-left"> <?php  /* box around the product selections  */ ?>
      
        <?php  /* Select by Category / Product / Variation Products / Variation Name across Products / Brands  */ ?>
        <h4 class="select-sub-heading clear-left">Select Products: &nbsp; by Category / Product / Variation Name across Products / Brands</h4>
        <?php echo wp_kses($selector_msg ,$allowed_html); //FREE Version blue message, yellow selectors not available; ?>        
        
         <?php //PROD CATEGORIES ?> 
        <div class="incl-excl-group top-horiz-line bottom-horiz-line buy-group-prod-cat-incl-excl-group clear-left">

          <div class="and-or-selector buy-and-or-selector" id="buy-and-or-selector-prod-cat">                                        
            <div class="switch-field">   
              <span class="hasWizardHelpRight">
                <input id="buy_group_prod_cat_and_or-AndSelect" class="and-or-selector-AndSelect" name="buy_group_prod_cat_and_or" value="and" type="radio" <?php if ( $vtprd_rule->buy_group_population_info['buy_group_prod_cat_and_or'] == 'and') { echo wp_kses($checked ,$allowed_html); } ?> >
                <label id="buy_group_prod_cat_and_or-AndSelect-label" for="buy_group_prod_cat_and_or-AndSelect" class="and-or-selector-yes">And</label>
              </span> 
              <?php vtprd_show_object_hover_help ('buy_group_prod_cat_AndSelect', 'wizard'); ?> 
              <span class="hasWizardHelpRight">                                                       
                <input id="buy_group_prod_cat_and_or-OrSelect"  class="" name="buy_group_prod_cat_and_or" value="or"  type="radio" <?php if ( $vtprd_rule->buy_group_population_info['buy_group_prod_cat_and_or'] == 'or' ) { echo wp_kses($checked ,$allowed_html); } ?> > 
                <label id="buy_group_prod_cat_and_or-OrSelect-label" for="buy_group_prod_cat_and_or-OrSelect"  class="and-or-selector-no">Or</label> 
              </span>
              <?php vtprd_show_object_hover_help ('buy_group_prod_cat_OrSelect', 'wizard'); ?> 
              <span class="hasWizardHelpRight">                                                       
                <input id="buy_group_prod_cat_each-EachSelect"  class="" name="buy_group_prod_cat_and_or" value="each"  type="radio" <?php if ( $vtprd_rule->buy_group_population_info['buy_group_prod_cat_and_or'] == 'each' ) { echo wp_kses($checked ,$allowed_html); } ?> > 
                <label for="buy_group_prod_cat_each-EachSelect" id="buy_group_prod_cat_each-EachSelect-label"  class="and-or-selector-each">Each</label> 
              </span>
              <?php vtprd_show_object_hover_help ('buy_group_prod_cat_EachSelect', 'wizard'); ?>               
            </div> 
          </div>
                                
          <div class="form-group2 clear-both  buy_group_prod_cat_incl">        
      				<div class="form-field"><label class="buy-prod-category-incl-label right-col-label"><?php esc_attr_e( 'Category', 'vtprd' ); ?></label>
    				    <select class="vtprd-category-search vtprd-noajax-search left-col-data" multiple="multiple" style="width: 500px;" name="buy_group_prod_cat_incl_array[]" data-catid="prod_cat" data-placeholder="<?php echo wp_kses($prodcat_msg ,$allowed_html); ?>" data-action="vtprd_category_search_ajax">
      					<?php
                            $taxonomy = $vtprd_info['parent_plugin_taxonomy'];
                            $checked_list = $vtprd_rule->buy_group_population_info['buy_group_prod_cat_incl_array'];
      						$this->vtprd_build_cat_selects($taxonomy, $checked_list); 
      					?>
                </select>
                 <span class="shortIntro-b-and-w shortIntro-select2 question-mark-area" >
                    <img  class="hasHoverHelp2 help-b-and-w" width="15px" alt=""  src="<?php echo esc_url(VTPRD_URL.'/admin/images/help-b-and-w.png');?>" /> 
                   <?php vtprd_show_object_hover_help ('buy_group_prod_cat_incl', 'small');?>
                 </span>              
              </div>
          </div>
         
          <div class="form-group2 pad-the-top clear-left  buy_group_prod_cat_excl">     
      				<div class="form-field"><label class="buy-prod-category-excl-label  right-col-label"><?php esc_attr_e( 'Exclude Category', 'vtprd' ); ?></label>
    				    <select class="vtprd-category-search vtprd-noajax-search  left-col-data" multiple="multiple" style="width: 500px;" name="buy_group_prod_cat_excl_array[]" data-catid="prod_cat" data-placeholder="<?php echo wp_kses($prodcat_msg ,$allowed_html); ?>" data-action="vtprd_category_search_ajax">
      					<?php
                            $taxonomy = $vtprd_info['parent_plugin_taxonomy'];
                            $checked_list = $vtprd_rule->buy_group_population_info['buy_group_prod_cat_excl_array'];
      						$this->vtprd_build_cat_selects($taxonomy, $checked_list); 
      					?>
                </select>
                 <span class="shortIntro-b-and-w shortIntro-select2 question-mark-area" >
                    <img  class="hasHoverHelp2 help-b-and-w" width="15px" alt=""  src="<?php echo esc_url(VTPRD_URL.'/admin/images/help-b-and-w.png');?>" /> 
                   <?php vtprd_show_object_hover_help ('buy_group_prod_cat_excl', 'small');?>
                 </span>              
              </div>
          </div>
          
        </div>        

         
         <?php //PRICING DEAL CATEGORIES ?> 
        <div class="incl-excl-group bottom-horiz-line  buy-group-plugin-cat-incl-excl-group clear-left">


          <div class="and-or-selector  buy-and-or-selector" id="buy-and-or-selector-plugin-cat">                                        
            <div class="switch-field"> 
              <span class="hasWizardHelpRight">
                <input id="buy_group_plugin_cat_and_or-AndSelect" class="and-or-selector-AndSelect" name="buy_group_plugin_cat_and_or" value="and" type="radio" <?php if ( $vtprd_rule->buy_group_population_info['buy_group_plugin_cat_and_or'] == 'and') { echo wp_kses($checked ,$allowed_html); } ?> >
                <label id="buy_group_plugin_cat_and_or-AndSelect-label" for="buy_group_plugin_cat_and_or-AndSelect" class="and-or-selector-yes">And</label>
              </span> 
              <?php vtprd_show_object_hover_help ('buy_group_plugin_cat_AndSelect', 'wizard'); ?> 
              <span class="hasWizardHelpRight">                                                       
                <input id="buy_group_plugin_cat_and_or-OrSelect"  class="" name="buy_group_plugin_cat_and_or" value="or"  type="radio" <?php if ( $vtprd_rule->buy_group_population_info['buy_group_plugin_cat_and_or'] == 'or' ) { echo wp_kses($checked ,$allowed_html); } ?> > 
                <label id="buy_group_plugin_cat_and_or-OrSelect-label" for="buy_group_plugin_cat_and_or-OrSelect"  class="and-or-selector-no">Or</label> 
              </span>
              <?php vtprd_show_object_hover_help ('buy_group_plugin_cat_OrSelect', 'wizard'); ?>
              <span class="hasWizardHelpRight">                                                       
                <input id="buy_group_plugin_cat_each-EachSelect"  class="" name="buy_group_plugin_cat_and_or" value="each"  type="radio" <?php if ( $vtprd_rule->buy_group_population_info['buy_group_plugin_cat_and_or'] == 'each' ) { echo wp_kses($checked ,$allowed_html); } ?> > 
                <label id="buy_group_plugin_cat_each-EachSelect-label"  for="buy_group_plugin_cat_each-EachSelect" class="and-or-selector-each">Each</label> 
              </span>
              <?php vtprd_show_object_hover_help ('buy_group_plugin_cat_EachSelect', 'wizard'); ?>                   
            </div>              
          </div>
         
          <div class="form-group2  clear-both  buy_group_plugin_cat_incl">       
      				<div class="form-field"><label class="buy-plugin-category-incl-label  right-col-label"><?php esc_attr_e( 'Pricing Deal', 'vtprd' ); ?> <br>  <?php esc_attr_e( 'Category', 'vtprd' ); ?></label>
    				    <select class="vtprd-category-search vtprd-noajax-search  left-col-data" multiple="multiple" style="width: 500px;" name="buy_group_plugin_cat_incl_array[]" data-catid="rule_cat" data-placeholder="<?php echo wp_kses($plugincat_msg ,$allowed_html);?>" data-action="vtprd_category_search_ajax">
      					<?php
                            $taxonomy = $vtprd_info['rulecat_taxonomy'];
                            $checked_list = $vtprd_rule->buy_group_population_info['buy_group_plugin_cat_incl_array'];
      						$this->vtprd_build_cat_selects($taxonomy, $checked_list); 
      					?>
                </select>
                 <span class="shortIntro-b-and-w shortIntro-select2 question-mark-area" >
                    <img  class="hasHoverHelp2 help-b-and-w" width="15px" alt=""  src="<?php echo esc_url(VTPRD_URL.'/admin/images/help-b-and-w.png');?>" /> 
                   <?php vtprd_show_object_hover_help ('buy_group_plugin_cat_incl', 'small');?>
                 </span>              
              </div>
          </div>
          
          <div class="form-group2 pad-the-top clear-left  buy_group_plugin_cat_excl">        
      				<div class="form-field"><label class="buy-plugin-category-excl-label right-col-label"><?php esc_attr_e( 'Exclude', 'vtprd' ); ?> <br> <?php esc_attr_e( 'Pricing Deal', 'vtprd' ); ?> <br> <?php esc_attr_e( 'Category', 'vtprd' ); ?></label>
    				    <select class="vtprd-category-search vtprd-noajax-search left-col-data" multiple="multiple" style="width: 500px;" name="buy_group_plugin_cat_excl_array[]" data-catid="rule_cat" data-placeholder="<?php echo wp_kses($plugincat_msg ,$allowed_html); ?>" data-action="vtprd_category_search_ajax">
      					<?php
                            $taxonomy = $vtprd_info['rulecat_taxonomy'];
                            $checked_list = $vtprd_rule->buy_group_population_info['buy_group_plugin_cat_excl_array'];
      						$this->vtprd_build_cat_selects($taxonomy, $checked_list); 
      					?>
                </select>
                 <span class="shortIntro-b-and-w shortIntro-select2 question-mark-area" >
                    <img  class="hasHoverHelp2 help-b-and-w" width="15px" alt=""  src="<?php echo esc_url(VTPRD_URL.'/admin/images/help-b-and-w.png');?>" /> 
                   <?php vtprd_show_object_hover_help ('buy_group_plugin_cat_excl', 'small');?>
                 </span>              
              </div>
          </div> 
                 
        </div>
                 
         <?php //PRODUCTS ?>               
         <div class="incl-excl-group bottom-horiz-line buy-group-product-incl-excl-group clear-left"> 


          <div class="and-or-selector  buy-and-or-selector" id="buy-and-or-selector-product">                                        
            <div class="switch-field">                
              <span class="hasWizardHelpRight">
                <input id="buy_group_product_and_or-AndSelect" class="and-or-selector-AndSelect" name="buy_group_product_and_or" value="and" type="radio" <?php if ( $vtprd_rule->buy_group_population_info['buy_group_product_and_or'] == 'and') { echo wp_kses($checked ,$allowed_html); } ?> >
                <label id="buy_group_product_and_or-AndSelect-label" for="buy_group_product_and_or-AndSelect" class="and-or-selector-yes">And</label>
              </span> 
              <?php vtprd_show_object_hover_help ('buy_group_product_AndSelect', 'wizard'); ?> 
              <span class="hasWizardHelpRight">                                                       
                <input id="buy_group_product_and_or-OrSelect"  class="" name="buy_group_product_and_or" value="or"  type="radio" <?php if ( $vtprd_rule->buy_group_population_info['buy_group_product_and_or'] == 'or' ) { echo wp_kses($checked ,$allowed_html); } ?> > 
                <label id="buy_group_product_and_or-OrSelect-label" for="buy_group_product_and_or-OrSelect" id="buy_group_product_and_or-OrSelect-label" class="and-or-selector-no">Or</label> 
              </span>
              <?php vtprd_show_object_hover_help ('buy_group_product_OrSelect', 'wizard'); ?> 
              <span class="hasWizardHelpRight">                                                       
                <input id="buy_group_product_each-EachSelect"  class="" name="buy_group_product_and_or" value="each"  type="radio" <?php if ( $vtprd_rule->buy_group_population_info['buy_group_product_and_or'] == 'each' ) { echo wp_kses($checked ,$allowed_html); } ?> > 
                <label for="buy_group_product_each-EachSelect" id="buy_group_product_each-EachSelect-label" class="and-or-selector-each">Each</label> 
              </span>
              <?php vtprd_show_object_hover_help ('buy_group_product_EachSelect', 'wizard'); ?>                
            </div> 
          </div>
              
         
           <div class="form-group2 clear-both  buy_group_product_incl">
              <div class="form-field"><label class="buy-product-incl-label  right-col-label" style="padding-top:8px;"><?php esc_attr_e( 'Product', 'vtprd' ); ?></label>                                          
      				    <select class="vtprd-product-search left-col-data buy-product-incl-select" multiple="multiple" style="width: 500px;" name="buy_group_product_incl_array[]" data-placeholder="<?php echo wp_kses($product_msg ,$allowed_html);?>" data-action="vtprd_product_search_ajax">
        					<?php
                    $product_ids = $vtprd_rule->buy_group_population_info['buy_group_product_incl_array'];
        
        						//v2.0.0.9a begin
                    foreach ( $product_ids as $product_id ) {
        				if ($product_id > ' ') {
                            $product = wc_get_product( $product_id );
                            if ( is_object( $product ) ) {
                              $product_name = $product->get_formatted_name(); 
                              if (vtprd_test_for_variations($product_id)) {
                                $product_name .= '&nbsp; [all variations] ';
                              }
            				  $output = '<option value="' . esc_attr( $product_id ) . '"' . selected( true, true, false ) . '>' . wp_kses_post( $product_name ) . '</option>'; //v2.0.3
                              echo wp_kses($output ,$allowed_html); //v2.0.3  
            			   }
                        }
        			 }
                    //v2.0.0.9a end
        					?>
                  </select>                                                   
                 <span class="shortIntro-b-and-w shortIntro-select2 question-mark-area" >
                    <img  class="hasHoverHelp2 help-b-and-w" width="15px" alt=""  src="<?php echo esc_url(VTPRD_URL.'/admin/images/help-b-and-w.png');?>" /> 
                   <?php vtprd_show_object_hover_help ('buy_group_product_incl', 'small');?>
                 </span>                                                                 
              </div>                                                    
          </div>
          
           <div class="form-group2 pad-the-top clear-left  buy_group_product_excl">
              <div class="form-field"><label class="buy-product-excl-label  right-col-label" style="padding-top:8px;"><?php esc_attr_e( 'Exclude Product', 'vtprd' ); ?></label>                           
      				    <select class="vtprd-product-search left-col-data" multiple="multiple" style="width: 500px;" name="buy_group_product_excl_array[]" data-placeholder="<?php echo wp_kses($product_msg ,$allowed_html); ?>" data-action="vtprd_product_search_ajax">
        					<?php
                    $product_ids = $vtprd_rule->buy_group_population_info['buy_group_product_excl_array'];

        						//v2.0.0.9a begin
                    foreach ( $product_ids as $product_id ) {
        				if ($product_id > ' ') {
                          $product = wc_get_product( $product_id );
                          if ( is_object( $product ) ) {
                             $product_name = $product->get_formatted_name(); 
                             if (vtprd_test_for_variations($product_id)) {
                               $product_name .= '&nbsp; [all variations] ';
                             }
                            
                             $output = '<option value="' . esc_attr( $product_id ) . '"' . selected( true, true, false ) . '>' . wp_kses_post( $product_name ) . '</option>'; //v2.0.3
                             echo wp_kses($output ,$allowed_html); //v2.0.3
          			      }
                       }
        			}
                    //v2.0.0.9a end                   
                    
        					?>
                  </select>                                                   
                 <span class="shortIntro-b-and-w shortIntro-select2" >
                    <img  class="hasHoverHelp2 help-b-and-w" width="15px" alt=""  src="<?php echo esc_url(VTPRD_URL.'/admin/images/help-b-and-w.png');?>" /> 
                   <?php vtprd_show_object_hover_help ('buy_group_product_excl', 'small');?>
                 </span>
              </div>                                                                                                         
          </div>
          
        </div>


         <?php //VARNAME ?> 
         <div class="incl-excl-group bottom-horiz-line buy-group-var-name-incl-excl-group clear-left">


          <div class="and-or-selector  buy-and-or-selector" id="buy-and-or-selector-var-name">                                        
            <div class="switch-field">
              <span class="hasWizardHelpRight">
                <input id="buy_group_var_name_and_or-AndSelect" class="and-or-selector-AndSelect" name="buy_group_var_name_and_or" value="and" type="radio" <?php if ( $vtprd_rule->buy_group_population_info['buy_group_var_name_and_or'] == 'and') { echo wp_kses($checked ,$allowed_html); } ?> >
                <label id="buy_group_var_name_and_or-AndSelect-label" for="buy_group_var_name_and_or-AndSelect" class="and-or-selector-yes">And</label>
              </span> 
              <?php vtprd_show_object_hover_help ('buy_group_var_name_AndSelect', 'wizard'); ?> 
              <span class="hasWizardHelpRight">                                                       
                <input id="buy_group_var_name_and_or-OrSelect"  class="" name="buy_group_var_name_and_or" value="or"  type="radio" <?php if ( $vtprd_rule->buy_group_population_info['buy_group_var_name_and_or'] == 'or' ) { echo wp_kses($checked ,$allowed_html); } ?> > 
                <label for="buy_group_var_name_and_or-OrSelect"  class="and-or-selector-no">Or</label> 
              </span>
              <?php vtprd_show_object_hover_help ('buy_group_var_name_OrSelect', 'wizard'); ?> 
            </div>          
          </div>
           
           <div class="form-group2 clear-both">        
      				<div class="form-field"><label class="buy_group_var_name_incl-label right-col-label" style="margin-top: 30px;"><?php esc_attr_e( 'Variation Name', 'vtprd' );?> <br> <?php esc_attr_e( 'Across Products', 'vtprd' );?></label>

               <?php
                   // large|red+extra large|blue (*full* variation name[s], separated by: | AND combined by: + )
                   $varName_array = $vtprd_rule->buy_group_population_info['buy_group_var_name_incl_array'];
                   $varName_string = $this->vtprd_stringify_var_name_array($varName_array);
              ?>
              <span class='varName-example'><?php esc_attr_e('Example:', 'vtprd') ?>&nbsp;&nbsp;<?php echo wp_kses($vtprd_info['default_by_varname_example'] ,$allowed_html); ?> </span>
                         
               <span class="varName-area">
                   <textarea rows="1" cols="50" id="buy_group_var_name_incl_array" class="buy_group_var_name_incl_array_class" name="buy_group_var_name_incl_array" placeholder="<?php esc_attr_e( 'Enter attribute names ', 'vtprd' ); ?> &hellip;"><?php echo wp_kses($varName_string ,$allowed_html); ?></textarea>                 
               </span>              
               <span class="shortIntro-b-and-w shortIntro-select2 question-mark-area">
                  <img  class="hasHoverHelp2 help-b-and-w" width="15px" alt=""  style="margin-left: -1.5% !important;" src="<?php echo esc_url(VTPRD_URL.'/admin/images/help-b-and-w.png');?>" /> 
                  <?php vtprd_show_object_hover_help ('buy_group_var_name_incl', 'small');?>
               </span>                               
           </div>     
         </div>    


           <div class="form-group2 clear-left"  style="padding-top:15px;">        
      				
              <div class="form-field"><label class="buy_group_var_name_excl-label right-col-label"><?php esc_attr_e( 'Exclude', 'vtprd' ); ?> <br> <?php esc_attr_e( 'Variation Name', 'vtprd' ); ?> <br><?php esc_attr_e( 'Across Products', 'vtprd' ); ?></label>

               <?php
                   // large|red+extra large|blue (*full* variation name[s], separated by: | AND combined by: + )
                   $varName_array = $vtprd_rule->buy_group_population_info['buy_group_var_name_excl_array'];
                   $varName_string = $this->vtprd_stringify_var_name_array($varName_array);
              ?>
                         
               <span class="varName-area">
                   <textarea rows="1" cols="50" id="buy_group_var_name_excl_array" class="buy_group_var_name_excl_array_class"  name="buy_group_var_name_excl_array" placeholder="<?php esc_attr_e( 'Enter attribute names ', 'vtprd' ); ?> &hellip;"><?php echo wp_kses($varName_string ,$allowed_html); ?></textarea>                 
               </span>              
               <span class="shortIntro-b-and-w shortIntro-select2 question-mark-area" style="margin-left: -1% !important;">
                  <img  class="hasHoverHelp2 help-b-and-w" width="15px" alt=""  style="margin-left: -1.5% !important;"  src="<?php echo esc_url(VTPRD_URL.'/admin/images/help-b-and-w.png');?>" /> 
                  <?php vtprd_show_object_hover_help ('buy_group_var_name_excl', 'small');?>
               </span>

           <?php //v2.0.0.1 REMOVED ERRANT '}' in style above ?> 
            
                <?php //v1.1.8.0 begin ?>
                <span class='varName_addl_info  clear-left'> 

                  <span class='varName_addl_info-line1  clear-left'><span style='color:#666;font-size: 13px;margin-left: -4%;font-weight: normal;' <?php wp_kses($vtprd_info['default_by_varname_msg'] ,$allowed_html);?> </span> </span>
                  
                  
                  <span class='varName_addl_info-line2  clear-left'>( <em><?php  esc_attr_e( 'Changes To', 'vtprd' ); ?>&nbsp;&nbsp; <?php  esc_attr_e( 'lowercase', 'vtprd' ); ?> &nbsp; , &nbsp; <?php  esc_attr_e( 'removes leading and trailing spaces', 'vtprd'); ?> </em>)</span>                  
                  <span class='varName_addl_info-line3  clear-left'>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<em><?php esc_attr_e('If an Attribute Name has a space in the name between words, ', 'vtprd'); ?></em></span>
                  <span class='varName_addl_info-line4  clear-left'>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<em><?php esc_attr_e(' and the name is not found in testing, ', 'vtprd'); ?></em></span>                  
                  <span class='varName_addl_info-line5  clear-left'>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<em><?php esc_attr_e(' try replacing the space in the name with a dash "-" ', 'vtprd'); ?></em></span>          
                </span>
                <?php //v1.1.8.0 end ?>
            
                <?php //v2.0 begin ?>
                <span class='varName_catalog_info  clear-left'>
                  <span class='varName_addl_info-line1  clear-left' style="margin-top: 8px;"><?php esc_attr_e('Catalog Attributes Note', 'vtprd'); ?></span>
                  <img  class="hasHoverHelp2 help-b-and-w" width="15px" alt=""  style="margin-top: 3px; float: left;"  src="<?php echo esc_url(VTPRD_URL.'/admin/images/help-b-and-w.png');?>" /> 
                  <?php vtprd_show_object_hover_help ('buy_group_varName_catalog_info', 'small');?>                
                </span>  
                <?php //v2.0 end ?>                
             </div>     
           </div>   
                         
         </div>  <?php //end buy_group_varName_exclude_area ?>   


         
         <?php //BRANDS         
          /* ********************************
          Pricing Deals Pro has built-in support for the following list of BRANDS Plugins .
          There's also the 'vtprd_add_brands_taxonomy' filter, which allows you to use ANY
          nominated custom taxonomy at the BRANDS selector 

          	If using a BRANDS plugin not in the supported list, add support by doing the following:
          	//add the 'add_filter...' statement to your theme/child-theme functions.php file 
          	//change [brands plugin taxonomy] to the taxonomy of your brands plugin   
          	add_filter( 'vtprd_add_brands_taxonomy', function() { return  'brands plugin taxonomy'; } ); 
          
          Here's what we're prepared for: 
            
            Product Brands For WooCommerce
            https://wordpress.org/plugins/product-brands-for-woocommerce/
            taxonomy = 'product_brands'
            <a href="https://wordpress.org/plugins/product-brands-for-woocommerce/">Product Brands For WooCommerce</a>
            
            Perfect WooCommerce Brands
            https://wordpress.org/plugins/perfect-woocommerce-brands/
            taxonomy = 'pwb-brand'
            <a href="https://wordpress.org/plugins/perfect-woocommerce-brands/">Perfect WooCommerce Brands</a>
            
            Brands for WooCommerce
            https://wordpress.org/plugins/brands-for-woocommerce/
            taxonomy = 'berocket_brand'
            <a href="https://wordpress.org/plugins/brands-for-woocommerce/">Brands for WooCommerce</a>

            YITH WooCommerce Brands Add-On
            https://wordpress.org/plugins/yith-woocommerce-brands-add-on/
            taxonomy = 'yith_product_brand';
            <a href="https://wordpress.org/plugins/yith-woocommerce-brands-add-on/">YITH WooCommerce Brands Add-On</a>
            
            Ultimate WooCommerce Brands
            https://wordpress.org/plugins/ultimate-woocommerce-brands/
            taxonomy = "product_brand"
            <a href="https://wordpress.org/plugins/ultimate-woocommerce-brands/">Ultimate WooCommerce Brands</a>
            
            Woocommerce Brand
            https://wordpress.org/plugins/wc-brand/
            taxonomy = 'product_brand' 
            <a href="https://wordpress.org/plugins/wc-brand/">Woocommerce Brand</a> 
            
          */ 
          $tax_array = $vtprd_info['brands_taxonomy_array']; 

          //add_filter( 'vtprd_add_brands_taxonomy', function() { return  'YOUR brands plugin taxonomy'; } );               
          $filter_tax = apply_filters('vtprd_add_brands_taxonomy',FALSE );
          if ($filter_tax) {
            $tax_array[] = $filter_tax;
          } 
          $taxonomy = FALSE;
          foreach ( $tax_array as $tax ) {
            if (taxonomy_exists($tax)) { 
              $taxonomy = $tax;
              break;
            } else {
            }
          }                             
         ?> 
         <div class="incl-excl-group bottom-horiz-line buy-group-brands-incl-excl-group clear-left"> 

         <?php        
          if ($taxonomy) {   //only show and/or if there's something to SEARCH!!        
         ?>
          <div class="and-or-selector  buy-and-or-selector" id="buy-and-or-selector-brands">                                        
            <div class="switch-field"> 
              <span class="hasWizardHelpRight">
                <input id="buy_group_brands_and_or-AndSelect" class="and-or-selector-AndSelect" name="buy_group_brands_and_or" value="and" type="radio" <?php if ( $vtprd_rule->buy_group_population_info['buy_group_brands_and_or'] == 'and') { echo wp_kses($checked ,$allowed_html); } ?> >
                <label id="buy_group_brands_and_or-AndSelect-label" for="buy_group_brands_and_or-AndSelect" class="and-or-selector-yes">And</label>
              </span> 
              <?php vtprd_show_object_hover_help ('buy_group_brands_AndSelect', 'wizard'); ?> 
              <span class="hasWizardHelpRight">                                                       
                <input id="buy_group_brands_and_or-OrSelect"  class="" name="buy_group_brands_and_or" value="or"  type="radio" <?php if ( $vtprd_rule->buy_group_population_info['buy_group_brands_and_or'] == 'or' ) { echo wp_kses($checked ,$allowed_html); } ?> > 
                <label for="buy_group_brands_and_or-OrSelect"  class="and-or-selector-no">Or</label> 
              </span>
              <?php vtprd_show_object_hover_help ('buy_group_brands_OrSelect', 'wizard'); ?> 
            </div>          
          </div>
         <?php        
          }           
         ?>              
                  
          <div class="form-group2 clear-both">      
      				<div class="form-field"><label class="buy-brands-incl-label right-col-label"><?php esc_attr_e( 'Brand', 'vtprd' ); if (!$taxonomy) { ?> <br><br> <?php esc_attr_e( 'Exclude Brand', 'vtprd' ); } ?></label>
                 <?php        
                  if ($taxonomy) {           
                 ?> 
        				    <select class="vtprd-brand-search vtprd-noajax-search left-col-data" multiple="multiple" style="width: 500px;" name="buy_group_brands_incl_array[]" data-placeholder="<?php esc_attr_e( 'Search Brand ', 'vtprd' ); ?> &hellip;" data-action="vtprd_brand_search_ajax">
          					<?php
                                $checked_list = $vtprd_rule->buy_group_population_info['buy_group_brands_incl_array'];
          						$this->vtprd_build_cat_selects($taxonomy,$checked_list); //ALSO USED FOR BRANDS!!
          					?>
                    </select>
                  <?php } else {
                      ?> 
                      <span class="plugin-required hasWizardHelpRight">( <span class="brand-lit"> <?php esc_attr_e( 'Brands', 'vtprd' );?> </span> <?php esc_attr_e( ' - free Brands plugin needed', 'vtprd' );?> &nbsp;&nbsp;<em> <?php esc_attr_e( '[ hover for plugin list ]', 'vtprd' );?> </em> )</span>
                      <?php 
                      vtprd_show_object_hover_help ('buy_group_brands_incl', 'wizard'); 
                  } ?> 
                 <span class="shortIntro-b-and-w shortIntro-select2 question-mark-area" >
                    <img  class="hasHoverHelp2 help-b-and-w hasWizardHelpRight" width="15px" alt=""  src="<?php echo esc_url(VTPRD_URL.'/admin/images/help-b-and-w.png');?>" /> 
                   <?php vtprd_show_object_hover_help ('buy_group_brands_incl', 'wizard'); ?>
                 </span>                 
              </div>   
          </div>

         <?php        
          if ($taxonomy) {           
         ?>           
          <div class="form-group2   pad-the-top clear-left">      
      				<div class="form-field"><label class="buy-brands-excl-label right-col-label"><?php esc_attr_e( 'Exclude Brand', 'vtprd' ); ?></label>
                 <?php        
                  if ($taxonomy) {          
                 ?>				    
                    <select class="vtprd-brand-search vtprd-noajax-search left-col-data" multiple="multiple" style="width: 500px;" name="buy_group_brands_excl_array[]" data-placeholder="<?php esc_attr_e( 'Search Brand ', 'vtprd' ); ?> &hellip;" data-action="vtprd_brand_search_ajax">
          					<?php
                                $checked_list = $vtprd_rule->buy_group_population_info['buy_group_brands_excl_array'];
          						$this->vtprd_build_cat_selects($taxonomy,$checked_list); 
          					?>
                    </select>
                  <?php } else {
                      ?>
                      <span class="plugin-required hasWizardHelpRight"> <?php  esc_attr_e( '( Brands - free Brands plugin needed )', 'vtprd' ); ?> </span>
                      <?php 
                      vtprd_show_object_hover_help ('buy_group_brands_incl', 'wizard'); 
                  } ?> 
                 <span class="shortIntro-b-and-w shortIntro-select2 question-mark-area" >
                    <img  class="hasHoverHelp2 help-b-and-w hasWizardHelpRight" width="15px" alt=""  src="<?php echo esc_url(VTPRD_URL.'/admin/images/help-b-and-w.png');?>" /> 
                   <?php vtprd_show_object_hover_help ('buy_group_brands_excl', 'wizard');?>
                 </span> 
              </div>               
          </div>
         <?php        
          }           
         ?>           
          
        </div>    


         
         <?php //SUBSCRIPTIONS        
          /* ********************************

            Look for:
            register_post_type
            register_taxonomy
            
            
            YITH WooCommerce Subscription
            https://wordpress.org/plugins/yith-woocommerce-subscription/
            yith zip
            register_post_type( 'ywsbs_subscription', $args );
            
            
            HF WooCommerce Subscriptions
            https://wordpress.org/plugins/xa-woocommerce-subscriptions/
            za zip
            wc_register_order_type('hf_shop_subscription', apply_filters('woocommerce_register_post_type_hf_subscription', array(
            public function get_order_count( $status ) {
            		global $wpdb;
            		//return absint( $wpdb->get_var( $wpdb->prepare( "SELECT COUNT( * ) FROM {$wpdb->posts} WHERE post_type = 'hf_shop_subscription' AND post_status = %s", $status ) ) );
            	}
            
            
            Woocommerce subscriptions
            https://github.com/wp-premium/woocommerce-subscriptions
            woocommerce-subscriptions-master
            register_post_type 'shop_subscription'
            
            function wcs_do_subscriptions_exist() {
            	global $wpdb;
            	$sql = //$wpdb->prepare( "SELECT ID FROM {$wpdb->posts} WHERE post_type = %s LIMIT 1;", 'shop_subscription' );

          */           
          ?>
      </div>  <?php //end buy-group-select-product-area box around the product selections  ?> 

                                          
      <div class="buy-group-select-customer-area  clear-left"> <?php  /* box around the customer selections  */ ?>
        <h4 class="select-sub-heading clear-left" id="buy-group-by-customer-title">Select Customers: &nbsp; by Role (Wholesale) / Email / Customer Name / Group / Membership</h4>     
          
        <div id="" class="buy-group-and-or clear-left" >                                                                
          <span class="hasWizardHelpRight">
            <input id="buy-group-and-or-AndSelect" class="and-orClass" name="buy_group_customer_and_or" value="and" type="radio" <?php if ( $vtprd_rule->buy_group_population_info['buy_group_customer_and_or'] == 'and') { echo wp_kses($checked ,$allowed_html); } ?> >
            <span id="andSelect-label"><span id="and-select-field">AND</span> <span class="and-or-message-field" id="and-message-field">&nbsp;&nbsp;<span style="text-decoration:underline;">One</span> Customer entry from lists below is <span style="text-decoration:underline;">required</span></span>  </span>
          </span> 
          <?php vtprd_show_object_hover_help ('buy-group-and-or-AndSelect', 'wizard'); ?> 
          <br><br>
          <span class="hasWizardHelpRight">                                                       
            <input id="buy-group-and-or-OrSelect"  class="and-orClass" name="buy_group_customer_and_or" value="or"  type="radio" <?php if ( $vtprd_rule->buy_group_population_info['buy_group_customer_and_or'] == 'or' ) { echo wp_kses($checked ,$allowed_html); } ?> > 
            <span id="orSelect-label" ><span id="or-select-field">OR</span> <span class="and-or-message-field">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<span style="text-decoration:underline;">Any</span> Customer entry can "activate" the deal</span>  </span> 
          </span>
          <?php vtprd_show_object_hover_help ('buy-group-and-or-OrSelect', 'wizard'); ?>                                                      
        </div>
        
        <?php echo wp_kses($selector_msg ,$allowed_html);  //FREE Version blue message, yellow selectors not available; ?>
           
         <?php //Roles ?> 
        <div class="incl-excl-group top-horiz-line bottom-horiz-line buy-group-role-incl-excl-group clear-left">
          <div class="form-group2 clear-left  buy_group_role_incl">       
      				<div class="form-field"><label class="buy-role-incl-label right-col-label"><?php esc_attr_e( 'Role', 'vtprd' ); ?></label>
    				    <select class="vtprd-role-search vtprd-noajax-search left-col-data" multiple="multiple" style="width: 500px;" name="buy_group_role_incl_array[]" data-placeholder="<?php echo wp_kses($role_msg ,$allowed_html); ?>" data-action="vtprd_role_search_ajax">
      					<?php
                            $checked_list = $vtprd_rule->buy_group_population_info['buy_group_role_incl_array'];
      						$this->vtprd_build_role_selects($checked_list); 
      					?>
                </select>
                 <span class="shortIntro-b-and-w shortIntro-select2 question-mark-area" >
                   <img  class="hasHoverHelp2 help-b-and-w hasWizardHelpRight" width="15px" alt=""  src="<?php echo esc_url(VTPRD_URL.'/admin/images/help-b-and-w.png');?>" /> 
                   <?php vtprd_show_object_hover_help ('buy_group_role_incl', 'wizard');?>                 
                 </span>               
              </div>
          </div>
          
          <div class="form-group2   pad-the-top  clear-left  buy_group_role_excl">        
      				<div class="form-field"><label class="buy-role-excl-label right-col-label"><?php esc_attr_e( 'Exclude Role', 'vtprd' ); ?></label>
    				    <select class="vtprd-role-search vtprd-noajax-search left-col-data" multiple="multiple" style="width: 500px;" name="buy_group_role_excl_array[]" data-placeholder="<?php echo wp_kses($role_msg ,$allowed_html); ?>" data-action="vtprd_role_search_ajax">
      					<?php
                            $checked_list = $vtprd_rule->buy_group_population_info['buy_group_role_excl_array'];
      						$this->vtprd_build_role_selects($checked_list); 
      					?>
                </select>
                 <span class="shortIntro-b-and-w shortIntro-select2 question-mark-area" >
                   <img  class="hasHoverHelp2 help-b-and-w hasWizardHelpRight" width="15px" alt=""  src="<?php echo esc_url(VTPRD_URL.'/admin/images/help-b-and-w.png');?>" /> 
                   <?php vtprd_show_object_hover_help ('buy_group_role_excl', 'wizard');?> 
                 </span> 
              </div>
          </div> 
        </div>      

                        
         
         <?php //Customers ?> 
        <div class="incl-excl-group bottom-horiz-line buy-group-email-incl-excl-group clear-left">
          <div class="form-group2  clear-left  buy_group_email_incl">        
      				<div class="form-field"><label class="buy-email-incl-label right-col-label"><?php esc_attr_e( 'Email or', 'vtprd' ); ?> <br> <?php esc_attr_e( 'Customer Name', 'vtprd' ); ?></label>
    				    <select class="vtprd-customer-search left-col-data" multiple="multiple" style="width: 500px;" name="buy_group_email_incl_array[]" data-placeholder="<?php echo wp_kses($email_msg ,$allowed_html); ?>" data-action="vtprd_customer_search_ajax">
      					<?php
                            $checked_list = $vtprd_rule->buy_group_population_info['buy_group_email_incl_array'];
      						$this->vtprd_build_customer_selects($checked_list); 
      					?>
                </select>
                 <span class="shortIntro-b-and-w shortIntro-select2 question-mark-area" >
                   <img  class="hasHoverHelp2 help-b-and-w hasWizardHelpRight" width="15px" alt=""  src="<?php echo esc_url(VTPRD_URL.'/admin/images/help-b-and-w.png');?>" /> 
                   <?php vtprd_show_object_hover_help ('buy_group_email_incl', 'wizard');?> 
                 </span>               
              </div>
          </div>
          
          <div class="form-group2 clear-left  buy_group_email_excl">         
      				<div class="form-field"><label class="buy-email-excl-label right-col-label"><?php esc_attr_e( 'Exclude', 'vtprd' ); ?> <br> <?php esc_attr_e( 'Email or', 'vtprd' ); ?> <br> <?php esc_attr_e( 'Customer Name', 'vtprd' ); ?></label>
    				    <select class="vtprd-customer-search left-col-data" multiple="multiple" style="width: 500px;" name="buy_group_email_excl_array[]" data-placeholder="<?php echo wp_kses($email_msg ,$allowed_html); ?>" data-action="vtprd_customer_search_ajax">
      					<?php
                            $checked_list = $vtprd_rule->buy_group_population_info['buy_group_email_excl_array'];
      						$this->vtprd_build_customer_selects($checked_list); 
      					?>
                </select>
                 <span class="shortIntro-b-and-w shortIntro-select2 question-mark-area" >
                   <img  class="hasHoverHelp2 help-b-and-w hasWizardHelpRight" width="15px" alt=""  src="<?php echo esc_url(VTPRD_URL.'/admin/images/help-b-and-w.png');?>" /> 
                   <?php vtprd_show_object_hover_help ('buy_group_email_excl', 'wizard');?> 
                 </span>               
              </div>
          </div>
        </div>


         
         <?php //GROUPS   based on the free version of Woocommerce Groups: https://wordpress.org/plugins/groups/  ?>    
 
        <div class="incl-excl-group bottom-horiz-line buy-group-groups-incl-excl-group clear-left">
          <div class="form-group2  clear-left">       
      				<div class="form-field"><label class="buy-groups-incl-label right-col-label"><?php esc_attr_e( 'Group', 'vtprd' ); if ( !function_exists('_groups_get_tablename') ) {  ?> <br><br> <?php esc_attr_e( 'Exclude Group', 'vtprd' ); } ?></label>
                 <?php        
                  if ( function_exists('_groups_get_tablename') ) {            
                 ?> 
        				    <select class="vtprd-group-search vtprd-noajax-search left-col-data" multiple="multiple" style="width: 500px;" name="buy_group_groups_incl_array[]" data-placeholder="<?php esc_attr_e( 'Search Group ', 'vtprd' ); ?> &hellip;" data-action="vtprd_group_search_ajax">
          					<?php
                                $checked_list = $vtprd_rule->buy_group_population_info['buy_group_groups_incl_array'];
          						$this->vtprd_build_group_selects($checked_list); 
          					?>
                    </select>
                  <?php } else {
                      ?>
                      <span class="plugin-required hasWizardHelpRight">( <a id="" class="" href="<?php echo esc_url( 'https://wordpress.org/plugins/groups/');?>"> <?php esc_attr_e( 'Groups', 'vtprd' );?> </a> <?php  esc_attr_e( ' - free Groups plugin needed )', 'vtprd' ); ?> </span>
                      <?php 
                      vtprd_show_object_hover_help ('buy_group_groups_needed', 'wizard');
                  } ?> 
                  <span class="shortIntro-b-and-w shortIntro-select2 question-mark-area" >
                    <img  class="hasHoverHelp2 help-b-and-w hasWizardHelpRight" width="15px" alt=""  src="<?php echo esc_url(VTPRD_URL.'/admin/images/help-b-and-w.png');?>" /> 
                    <?php vtprd_show_object_hover_help ('buy_group_groups_incl', 'wizard');?> 
                  </span>                 
              </div>   
          </div>
          
         <?php        
          if ( function_exists('_groups_get_tablename') ) {            
         ?>          
          <div class="form-group2   pad-the-top  clear-left">        
      				<div class="form-field"><label class="buy-groups-excl-label right-col-label"><?php esc_attr_e( 'Exclude Group', 'vtprd' ); ?></label>
                 <?php        
                  if ( function_exists('_groups_get_tablename') ) {          
                 ?>				    
                    <select class="vtprd-group-search vtprd-noajax-search left-col-data" multiple="multiple" style="width: 500px;" name="buy_group_groups_excl_array[]" data-placeholder="<?php esc_attr_e( 'Search Group ', 'vtprd' ); ?> &hellip;" data-action="vtprd_group_search_ajax">
          					<?php
                                $checked_list = $vtprd_rule->buy_group_population_info['buy_group_groups_excl_array'];
          						$this->vtprd_build_group_selects($checked_list); 
          					?>
                    </select>
                  <?php } else {
                      ?>
                      <span class="plugin-required">( <a id="" class="" href="<?php echo esc_url( 'https://wordpress.org/plugins/groups/');?>"><?php esc_attr_e( 'Groups', 'vtprd' );?> </a> <?php  esc_attr_e( ' - free Groups plugin needed )', 'vtprd' ); ?> </span>
                      <?php 
                  } ?>
                 <span class="shortIntro-b-and-w shortIntro-select2 question-mark-area" >
                   <img  class="hasHoverHelp2 help-b-and-w hasWizardHelpRight" width="15px" alt=""  src="<?php echo esc_url(VTPRD_URL.'/admin/images/help-b-and-w.png');?>" /> 
                   <?php vtprd_show_object_hover_help ('buy_group_groups_excl', 'wizard');?> 
                 </span>                 
              </div>               
          </div>
         <?php        
          }            
         ?>           
          
        </div> 

         
         <?php //MEMBERSHIPS  all the functions needed: https://docs.woocommerce.com/document/woocommerce-memberships-function-reference/  ?>    
 
         
         <?php //memberships   based on the PAY Woocommerce members: https://woocommerce.com/products/woocommerce-memberships/  ?>    
 
        <div class="incl-excl-group bottom-horiz-line buy-group-memberships-incl-excl-group clear-left">
          <div class="form-group2  clear-left">        
      				<div class="form-field"><label class="buy-members-incl-label right-col-label"><?php esc_attr_e( 'Membership', 'vtprd' ); if ( !function_exists('wc_memberships') ) { ?> <br><br> <?php esc_attr_e( 'Exclude Membership', 'vtprd' ); } ?></label>
                 <?php        
                  if ( function_exists('wc_memberships') ) {            
                 ?> 
        				    <select class="vtprd-group-search vtprd-noajax-search left-col-data" multiple="multiple" style="width: 500px;" name="buy_group_memberships_incl_array[]" data-placeholder="<?php esc_attr_e( 'Search Membership ', 'vtprd' ); ?> &hellip;" data-action="vtprd_membership_search_ajax">
          					<?php
                                $checked_list = $vtprd_rule->buy_group_population_info['buy_group_memberships_incl_array'];
          						$this->vtprd_build_memberships_selects($checked_list); 
          					?>
                    </select>
                  <?php } else {
                      ?>
                      <span class="plugin-required hasWizardHelpRight">( <a id="" class="" href="<?php echo esc_url( 'https://woocommerce.com/products/woocommerce-memberships/');?>"> <?php esc_attr_e( 'Memberships', 'vtprd' );?> </a> <?php  esc_attr_e( ' plugin needed )', 'vtprd' ); ?></span>
                      <?php
                      vtprd_show_object_hover_help ('buy_group_memberships_needed', 'wizard');
                  } ?> 
                 <span class="shortIntro-b-and-w shortIntro-select2 question-mark-area" >
                   <img  class="hasHoverHelp2 help-b-and-w hasWizardHelpRight" width="15px" alt=""  src="<?php echo esc_url(VTPRD_URL.'/admin/images/help-b-and-w.png');?>" /> 
                   <?php vtprd_show_object_hover_help ('buy_group_memberships_incl', 'wizard');?> 
                 </span>                 
              </div>   
          </div>

         <?php        
          if ( function_exists('wc_memberships') ) {            
         ?>           
          <div class="form-group2   pad-the-top  clear-left">        
      				<div class="form-field"><label class="buy-members-excl-label right-col-label"><?php esc_attr_e( 'Exclude Membership', 'vtprd' ); ?></label>
                 <?php        
                  if ( function_exists('wc_memberships') ) {          
                 ?>				    
                    <select class="vtprd-group-search vtprd-noajax-search left-col-data" multiple="multiple" style="width: 500px;" name="buy_group_memberships_excl_array[]" data-placeholder="<?php esc_attr_e( 'Search Membership ', 'vtprd' ); ?> &hellip;" data-action="vtprd_membership_search_ajax">
          					<?php
                                $checked_list = $vtprd_rule->buy_group_population_info['buy_group_memberships_excl_array'];
          						$this->vtprd_build_memberships_selects($checked_list); 
          					?>
                    </select>
                  <?php } else {                  
                     ?>
                      <span class="plugin-required">( <a id="" class="" href="<?php echo esc_url( 'https://woocommerce.com/products/woocommerce-memberships/');?>"> <?php esc_attr_e( 'Memberships', 'vtprd' );?> </a> <?php  esc_attr_e( ' plugin needed )', 'vtprd' ); ?></span>
                      <?php                  
                  } ?>  
                 <span class="shortIntro-b-and-w shortIntro-select2 question-mark-area" >
                   <img  class="hasHoverHelp2 help-b-and-w hasWizardHelpRight" width="15px" alt=""  src="<?php echo esc_url(VTPRD_URL.'/admin/images/help-b-and-w.png');?>" /> 
                   <?php vtprd_show_object_hover_help ('buy_group_memberships_excl', 'wizard');?>
                 </span> 
              </div>               
          </div>
         <?php        
          }           
         ?>            
          
        </div>
        
         
      </div>  <?php //end buy-group-select-customer-area box around the customer selections  ?> 

     </div><!-- //buy_group_box -->
       
     <?php 
    //***************   
    //v2.0.0 end 
    //***************   
 
}
      

                                                                            
    public    function vtprd_action_group_cntl() { 
       global $post, $vtprd_info, $vtprd_rule, $vtprd_rule_display_framework, $vtprd_rules_set;
       $selected = 'selected="selected"';
       $checked = 'checked="checked"';                                                  
       $allowed_html = vtprd_get_allowed_html(); //v2.0.3
         //*****************************
         //v2.0.0 begin
         //*****************************
       if(defined('VTPRD_PRO_DIRNAME')) { 
          $prodcat_msg    =  __( 'Search Product Cat &hellip;', 'vtprd' ); 
          $plugincat_msg  =  __( 'Search Pricing Deal Cat&hellip;', 'vtprd' );
          $product_msg    =  __( 'Search Product &hellip;', 'vtprd' );
          $role_msg       =  __( 'Search Role &hellip;', 'vtprd' );
          $email_msg      =  __( 'Search Email or Name &hellip;', 'vtprd' );
          $selector_msg   = null;                
       } else {
          $pro_only_msg   =  __( '* Pro - only * Search &hellip;', 'vtprd' );
          $prodcat_msg    =  $pro_only_msg; 
          $plugincat_msg  =  $pro_only_msg; 
          $product_msg    =  $pro_only_msg; 
          $role_msg       =  $pro_only_msg; 
          $email_msg      =  $pro_only_msg; 
          $selector_msg   = '<h4 class="clear-left free-warning">Free version - yellow selectors not available </h4>';                   
       } ?>
      
      
      <div class="action-group-select-product-area  clear-left"> <?php  /* box around the product selections  */ ?>
      
        <h4 class="select-sub-heading action-group-select-sub-heading clear-left">Select Products: &nbsp; by Category / Product / Variation Name across Products / Brands</h4>
                
        <?php echo wp_kses($selector_msg ,$allowed_html); //FREE Version blue message, yellow selectors not available; ?> 
        
         <?php //PROD CATEGORIES ?> 
        <div class="incl-excl-group top-horiz-line bottom-horiz-line action-group-prod-cat-incl-excl-group clear-left">

          <div class="and-or-selector action-and-or-selector" id="action-and-or-selector-prod-cat">                                        
            <div class="switch-field"> 
              <span class="hasWizardHelpRight">
                <input id="action_group_prod_cat_and_or-AndSelect" class="and-or-selector-AndSelect" name="action_group_prod_cat_and_or" value="and" type="radio" <?php if ( $vtprd_rule->action_group_population_info['action_group_prod_cat_and_or'] == 'and') { echo wp_kses($checked ,$allowed_html); } ?> >
                <label id="action_group_prod_cat_and_or-AndSelect-label" for="action_group_prod_cat_and_or-AndSelect" class="and-or-selector-yes">And</label>
              </span> 
              <?php vtprd_show_object_hover_help ('action_group_prod_cat_AndSelect', 'wizard'); ?> 
              <span class="hasWizardHelpRight">                                                       
                <input id="action_group_prod_cat_and_or-OrSelect"  class="" name="action_group_prod_cat_and_or" value="or"  type="radio" <?php if ( $vtprd_rule->action_group_population_info['action_group_prod_cat_and_or'] == 'or' ) { echo wp_kses($checked ,$allowed_html); } ?> > 
                <label id="action_group_prod_cat_and_or-OrSelect-label"  for="action_group_prod_cat_and_or-OrSelect"  class="and-or-selector-no">Or</label> 
              </span>
              <?php vtprd_show_object_hover_help ('action_group_prod_cat_OrSelect', 'wizard'); ?> 
            </div>               
          </div>
                            
          <div class="form-group2 clear-both  action_group_prod_cat_incl">        
      				<div class="form-field"><label class="action-prod-category-incl-label right-col-label"><?php esc_attr_e( 'Category', 'vtprd' ); ?></label>
    				    <select class="vtprd-category-search vtprd-noajax-search left-col-data" multiple="multiple" style="width: 500px;" name="action_group_prod_cat_incl_array[]" data-catid="prod_cat" data-placeholder="<?php echo wp_kses($prodcat_msg ,$allowed_html); ?>" data-action="vtprd_category_search_ajax">
      					<?php
                            $taxonomy = $vtprd_info['parent_plugin_taxonomy'];
                            $checked_list = $vtprd_rule->action_group_population_info['action_group_prod_cat_incl_array'];
      						$this->vtprd_build_cat_selects($taxonomy, $checked_list); 
      					?>
                </select>
                 <span class="shortIntro-b-and-w shortIntro-select2 question-mark-area" >
                    <img  class="hasHoverHelp2 help-b-and-w" width="15px" alt=""  src="<?php echo esc_url(VTPRD_URL.'/admin/images/help-b-and-w.png');?>" /> 
                   <?php vtprd_show_object_hover_help ('buy_group_prod_cat_incl', 'small');?>
                 </span>              
              </div>
          </div>
         
          <div class="form-group2 pad-the-top clear-left    action_group_prod_cat_excl">     
      				<div class="form-field"><label class="action-prod-category-excl-label  right-col-label"><?php esc_attr_e( 'Exclude Category', 'vtprd' ); ?></label>
    				    <select class="vtprd-category-search vtprd-noajax-search  left-col-data" multiple="multiple" style="width: 500px;" name="action_group_prod_cat_excl_array[]" data-catid="prod_cat" data-placeholder="<?php echo wp_kses($prodcat_msg ,$allowed_html); ?>" data-action="vtprd_category_search_ajax">
      					<?php
                            $taxonomy = $vtprd_info['parent_plugin_taxonomy'];
                            $checked_list = $vtprd_rule->action_group_population_info['action_group_prod_cat_excl_array'];
      						$this->vtprd_build_cat_selects($taxonomy, $checked_list); 
      					?>
                </select>
                 <span class="shortIntro-b-and-w shortIntro-select2 question-mark-area" >
                    <img  class="hasHoverHelp2 help-b-and-w" width="15px" alt=""  src="<?php echo esc_url(VTPRD_URL.'/admin/images/help-b-and-w.png');?>" /> 
                   <?php vtprd_show_object_hover_help ('buy_group_prod_cat_excl', 'small');?>
                 </span>              
              </div>
          </div>
          
        </div>        

         
         <?php //PRICING DEAL CATEGORIES ?> 
        <div class="incl-excl-group bottom-horiz-line action-group-plugin-cat-incl-excl-group clear-left">

          <div class="and-or-selector action-and-or-selector" id="action-and-or-selector-plugin-cat">                                        
            <div class="switch-field">  
              <span class="hasWizardHelpRight">
                <input id="action_group_plugin_cat_and_or-AndSelect" class="and-or-selector-AndSelect" name="action_group_plugin_cat_and_or" value="and" type="radio" <?php if ( $vtprd_rule->action_group_population_info['action_group_plugin_cat_and_or'] == 'and') { echo wp_kses($checked ,$allowed_html); } ?> >
                <label id="action_group_plugin_cat_and_or-AndSelect-label" for="action_group_plugin_cat_and_or-AndSelect" class="and-or-selector-yes">And</label>
              </span> 
              <?php vtprd_show_object_hover_help ('action_group_plugin_cat_AndSelect', 'wizard'); ?> 
              <span class="hasWizardHelpRight">                                                       
                <input id="action_group_plugin_cat_and_or-OrSelect"  class="" name="action_group_plugin_cat_and_or" value="or"  type="radio" <?php if ( $vtprd_rule->action_group_population_info['action_group_plugin_cat_and_or'] == 'or' ) { echo wp_kses($checked ,$allowed_html); } ?> > 
                <label id="action_group_plugin_cat_and_or-OrSelect-label" for="action_group_plugin_cat_and_or-OrSelect"  class="and-or-selector-no">Or</label> 
              </span>
              <?php vtprd_show_object_hover_help ('action_group_plugin_cat_OrSelect', 'wizard'); ?> 
            </div>
          </div>
                   
          <div class="form-group2  clear-both   action_group_plugin_cat_incl">       
      				<div class="form-field"><label class="action-plugin-category-incl-label  right-col-label"><?php esc_attr_e( 'Pricing Deal', 'vtprd' ); ?> <br> <?php esc_attr_e( 'Category', 'vtprd' ); ?></label>
    				    <select class="vtprd-category-search vtprd-noajax-search  left-col-data" multiple="multiple" style="width: 500px;" name="action_group_plugin_cat_incl_array[]" data-catid="rule_cat" data-placeholder="<?php echo wp_kses($plugincat_msg ,$allowed_html); ?>" data-action="vtprd_category_search_ajax">
      					<?php
                            $taxonomy = $vtprd_info['rulecat_taxonomy'];
                            $checked_list = $vtprd_rule->action_group_population_info['action_group_plugin_cat_incl_array'];
      						$this->vtprd_build_cat_selects($taxonomy, $checked_list); 
      					?>
                </select>
                 <span class="shortIntro-b-and-w shortIntro-select2 question-mark-area" >
                    <img  class="hasHoverHelp2 help-b-and-w" width="15px" alt=""  src="<?php echo esc_url(VTPRD_URL.'/admin/images/help-b-and-w.png');?>" /> 
                   <?php vtprd_show_object_hover_help ('buy_group_plugin_cat_incl', 'small');?>
                 </span>              
              </div>
          </div>
          
          <div class="form-group2 pad-the-top clear-left  action_group_plugin_cat_excl">        
      				<div class="form-field"><label class="action-plugin-category-excl-label right-col-label"><?php esc_attr_e( 'Exclude', 'vtprd' ); ?> <br> <?php esc_attr_e( 'Pricing Deal', 'vtprd' ); ?> <br> <?php esc_attr_e( 'Category', 'vtprd' ); ?></label>
    				    <select class="vtprd-category-search vtprd-noajax-search left-col-data" multiple="multiple" style="width: 500px;" name="action_group_plugin_cat_excl_array[]" data-catid="rule_cat" data-placeholder="<?php echo wp_kses($plugincat_msg ,$allowed_html); ?>" data-action="vtprd_category_search_ajax">
      					<?php
                            $taxonomy = $vtprd_info['rulecat_taxonomy'];
                            $checked_list = $vtprd_rule->action_group_population_info['action_group_plugin_cat_excl_array'];
      						$this->vtprd_build_cat_selects($taxonomy, $checked_list); 
      					?>
                </select>
                 <span class="shortIntro-b-and-w shortIntro-select2 question-mark-area" >
                    <img  class="hasHoverHelp2 help-b-and-w" width="15px" alt=""  src="<?php echo esc_url(VTPRD_URL.'/admin/images/help-b-and-w.png');?>" /> 
                   <?php vtprd_show_object_hover_help ('buy_group_plugin_cat_excl', 'small');?>
                 </span>              
              </div>
          </div> 
                 
        </div>
                 
         <?php //PRODUCTS ?>               
         <div class="incl-excl-group bottom-horiz-line action-group-product-incl-excl-group clear-left"> 

          <div class="and-or-selector action-and-or-selector" id="action-and-or-selector-product">                                        
            <div class="switch-field"> 
              <span class="hasWizardHelpRight">
                <input id="action_group_product_and_or-AndSelect" class="and-or-selector-AndSelect" name="action_group_product_and_or" value="and" type="radio" <?php if ( $vtprd_rule->action_group_population_info['action_group_product_and_or'] == 'and') { echo wp_kses($checked ,$allowed_html); } ?> >
                <label id="action_group_product_and_or-AndSelect-label" for="action_group_product_and_or-AndSelect" class="and-or-selector-yes">And</label>
              </span> 
              <?php vtprd_show_object_hover_help ('action_group_product_AndSelect', 'wizard'); ?> 
              <span class="hasWizardHelpRight">                                                       
                <input id="action_group_product_and_or-OrSelect"  class="" name="action_group_product_and_or" value="or"  type="radio" <?php if ( $vtprd_rule->action_group_population_info['action_group_product_and_or'] == 'or' ) { echo wp_kses($checked ,$allowed_html); } ?> > 
                <label id="action_group_product_and_or-OrSelect-label"  for="action_group_product_and_or-OrSelect" class="and-or-selector-no">Or</label> 
              </span>
              <?php vtprd_show_object_hover_help ('action_group_product_OrSelect', 'wizard'); ?> 
            </div>
          </div>
                     
                              
           <div class="form-group2 clear-both  action_group_product_incl">
              <div class="form-field"><label class="action-product-incl-label  right-col-label"><?php esc_attr_e( 'Product', 'vtprd' ); ?></label>                                          
      				    <select class="vtprd-product-search left-col-data action-product-incl-select" multiple="multiple" style="width: 500px;" name="action_group_product_incl_array[]" data-placeholder="<?php echo wp_kses($product_msg ,$allowed_html); ?>" data-action="vtprd_product_search_ajax">
        					<?php
                    $product_ids = $vtprd_rule->action_group_population_info['action_group_product_incl_array'];        

        						//v2.0.0.9a begin
                    foreach ( $product_ids as $product_id ) {
        				if ($product_id > ' ') {
                          $product = wc_get_product( $product_id );
                          if ( is_object( $product ) ) {
                            $product_name = $product->get_formatted_name(); 
                            if (vtprd_test_for_variations($product_id)) {
                              $product_name .= '&nbsp; [all variations] ';
                            }
                            
                            $output = '<option value="' . esc_attr( $product_id ) . '"' . selected( true, true, false ) . '>' . wp_kses_post( $product_name ) . '</option>'; //v2.0.3
                            echo wp_kses($output ,$allowed_html); //v2.0.3			
                          }
                        }
        			}
                    //v2.0.0.9a end
                    
        					?>
                  </select>                                                   
                 <span class="shortIntro-b-and-w shortIntro-select2 question-mark-area" >
                    <img  class="hasHoverHelp2 help-b-and-w" width="15px" alt=""  src="<?php echo esc_url(VTPRD_URL.'/admin/images/help-b-and-w.png');?>" /> 
                   <?php vtprd_show_object_hover_help ('buy_group_product_incl', 'small');?>
                 </span>                                                                 
              </div>                                                    
          </div>
          
           <div class="form-group2 pad-the-top clear-left  action_group_product_excl">
              <div class="form-field"><label class="action-product-excl-label  right-col-label"><?php esc_attr_e( 'Exclude Product', 'vtprd' ); ?></label>                           
      				    <select class="vtprd-product-search left-col-data" multiple="multiple" style="width: 500px;" name="action_group_product_excl_array[]" data-placeholder="<?php echo wp_kses($product_msg ,$allowed_html); ?>" data-action="vtprd_product_search_ajax">
        					<?php
                    $product_ids = $vtprd_rule->action_group_population_info['action_group_product_excl_array'];

        						//v2.0.0.9a begin
                    foreach ( $product_ids as $product_id ) {
        				if ($product_id > ' ') {
                          $product = wc_get_product( $product_id );
                          if ( is_object( $product ) ) {
                              $product_name = $product->get_formatted_name(); 
                              if (vtprd_test_for_variations($product_id)) {
                                $product_name .= '&nbsp; [all variations] ';
                              }
  
                              $output = '<option value="' . esc_attr( $product_id ) . '"' . selected( true, true, false ) . '>' . wp_kses_post( $product_name ) . '</option>'; //v2.0.3
                              echo wp_kses($output ,$allowed_html); //v2.0.3          							
                          }
                        }
        			}
                    //v2.0.0.9a end                    
                    
        					?>
                  </select>                                                   
                 <span class="shortIntro-b-and-w shortIntro-select2" >
                    <img  class="hasHoverHelp2 help-b-and-w" width="15px" alt=""  src="<?php echo esc_url(VTPRD_URL.'/admin/images/help-b-and-w.png');?>" /> 
                   <?php vtprd_show_object_hover_help ('buy_group_product_excl', 'small');?>
                 </span>
              </div>                                                                                                         
          </div>
          
        </div>


         <?php //VARNAME ?> 
         <div class="incl-excl-group bottom-horiz-line action-group-var-name-incl-excl-group clear-left">

          <div class="and-or-selector action-and-or-selector" id="action-and-or-selector-var-name">                                        
            <div class="switch-field">
              <span class="hasWizardHelpRight">
                <input id="action_group_var_name_and_or-AndSelect" class="and-or-selector-AndSelect" name="action_group_var_name_and_or" value="and" type="radio" <?php if ( $vtprd_rule->action_group_population_info['action_group_var_name_and_or'] == 'and') { echo wp_kses($checked ,$allowed_html); } ?> >
                <label id="action_group_var_name_and_or-AndSelect-label" for="action_group_var_name_and_or-AndSelect" class="and-or-selector-yes">And</label>
              </span> 
              <?php vtprd_show_object_hover_help ('action_group_var_name_AndSelect', 'wizard'); ?> 
              <span class="hasWizardHelpRight">                                                       
                <input id="action_group_var_name_and_or-OrSelect"  class="" name="action_group_var_name_and_or" value="or"  type="radio" <?php if ( $vtprd_rule->action_group_population_info['action_group_var_name_and_or'] == 'or' ) { echo wp_kses($checked ,$allowed_html); } ?> > 
                <label for="action_group_var_name_and_or-OrSelect" class="and-or-selector-no">Or</label> 
              </span>
              <?php vtprd_show_object_hover_help ('action_group_var_name_OrSelect', 'wizard'); ?> 
            </div>
          </div>
                            
           <div class="form-group2 clear-both">        
      				<div class="form-field"><label class="action_group_var_name_incl-label right-col-label" style="margin-top: 30px;"><?php esc_attr_e( 'Variation Name', 'vtprd' ); ?> <br> <?php esc_attr_e( 'Across Products', 'vtprd' ); ?></label>

               <?php
                   // large|red+extra large|blue (*full* variation name[s], separated by: | AND combined by: + )
                   $varName_array = $vtprd_rule->action_group_population_info['action_group_var_name_incl_array'];
                   $varName_string = $this->vtprd_stringify_var_name_array($varName_array);
              ?>
              <span class='varName-example'>Example:&nbsp;&nbsp;<?php echo wp_kses($vtprd_info['default_by_varname_example'] ,$allowed_html); ?> </span>
                         
               <span class="varName-area">
                   <textarea rows="1" cols="50" id="action_group_var_name_incl_array" class="action_group_var_name_incl_array_class" name="action_group_var_name_incl_array" placeholder="<?php esc_attr_e( 'Enter attribute names ', 'vtprd' ); ?> &hellip;"><?php echo wp_kses($varName_string ,$allowed_html); ?></textarea>                 
               </span>              
               <span class="shortIntro-b-and-w shortIntro-select2 question-mark-area">
                  <img  class="hasHoverHelp2 help-b-and-w" width="15px" alt=""  style="margin-left: -1.5% !important;" src="<?php echo esc_url(VTPRD_URL.'/admin/images/help-b-and-w.png');?>" /> 
                  <?php vtprd_show_object_hover_help ('buy_group_var_name_incl', 'small');?>
               </span>                               
           </div>     
         </div>    


           <div class="form-group2 clear-left"  style="padding-top:15px;">        
      				
              <div class="form-field"><label class="action_group_var_name_excl-label right-col-label"><?php esc_attr_e( 'Exclude', 'vtprd' ); ?> <br> <?php esc_attr_e( 'Variation Name', 'vtprd' ); ?> <br> <?php esc_attr_e( 'Across Products', 'vtprd' ); ?></label>

               <?php
                   // large|red+extra large|blue (*full* variation name[s], separated by: | AND combined by: + )
                   $varName_array = $vtprd_rule->action_group_population_info['action_group_var_name_excl_array'];
                   $varName_string = $this->vtprd_stringify_var_name_array($varName_array);
              ?>
                         
               <span class="varName-area">
                   <textarea rows="1" cols="50" id="action_group_var_name_excl_array" class="action_group_var_name_excl_array_class" name="action_group_var_name_excl_array" placeholder="<?php esc_attr_e( 'Enter attribute names ', 'vtprd' ); ?> &hellip;"><?php echo wp_kses($varName_string ,$allowed_html); ?></textarea>                 
               </span>              
               <span class="shortIntro-b-and-w shortIntro-select2 question-mark-area" style="margin-left: -1% !important;">
                  <img  class="hasHoverHelp2 help-b-and-w" width="15px" alt=""  style="margin-left: -1.5% !important;"  src="<?php echo esc_url(VTPRD_URL.'/admin/images/help-b-and-w.png');?>" /> 
                  <?php vtprd_show_object_hover_help ('buy_group_var_name_excl', 'small');?>
               </span>                               

            
                <?php //v1.1.8.0 begin ?>
                <span class='varName_addl_info  clear-left'> 
                  <span class='varName_addl_info-line1  clear-left'><span style="color:#666;font-size: 13px;margin-left: -4%;font-weight: normal;"> <?php $vtprd_info['default_by_varname_msg']; ?> </span></span>
                  <span class='varName_addl_info-line2  clear-left'><?php esc_attr_e('( <em>Changes To &nbsp; lowercase &nbsp; , &nbsp; removes leading and trailing spaces </em>)', 'vtprd'); ?></span>                  
                  <span class='varName_addl_info-line3  clear-left'>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<?php esc_attr_e('<em>If an Attribute Name has a space in the name between words, </em>', 'vtprd'); ?></span>
                  <span class='varName_addl_info-line4  clear-left'>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<?php esc_attr_e(' <em>and the name is not found in testing, </em>', 'vtprd'); ?></span>                  
                  <span class='varName_addl_info-line5  clear-left'>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<?php esc_attr_e(' <em>try replacing the space in the name with a dash "-" </em>', 'vtprd'); ?></span>          
                </span>
                <?php //v1.1.8.0 end ?>
                
             </div>     
           </div>   
                         
         </div>  <?php //end action_group_varName_exclude_area ?>   


         
         <?php //BRANDS         
          /* ********************************
          Pricing Deals Pro has built-in support for the following list of BRANDS Plugins .
          There's also the 'vtprd_add_brands_taxonomy' filter, which allows you to use ANY
          nominated custom taxonomy at the BRANDS selector 

          	If using a BRANDS plugin not in the supported list, add support by doing the following:
          	//add the 'add_filter...' statement to your theme/child-theme functions.php file 
          	//change [brands plugin taxonomy] to the taxonomy of your brands plugin   
          	add_filter( 'vtprd_add_brands_taxonomy', function() { return  'brands plugin taxonomy'; } ); 
          
          Here's what we're prepared for: 
            
            Product Brands For WooCommerce
            https://wordpress.org/plugins/product-brands-for-woocommerce/
            taxonomy = 'product_brands'
            <a href="https://wordpress.org/plugins/product-brands-for-woocommerce/">Product Brands For WooCommerce</a>
            
            Perfect WooCommerce Brands
            https://wordpress.org/plugins/perfect-woocommerce-brands/
            taxonomy = 'pwb-brand'
            <a href="https://wordpress.org/plugins/perfect-woocommerce-brands/">Perfect WooCommerce Brands</a>
            
            Brands for WooCommerce
            https://wordpress.org/plugins/brands-for-woocommerce/
            taxonomy = 'berocket_brand'
            <a href="https://wordpress.org/plugins/brands-for-woocommerce/">Brands for WooCommerce</a>

            YITH WooCommerce Brands Add-On
            https://wordpress.org/plugins/yith-woocommerce-brands-add-on/
            taxonomy = 'yith_product_brand';
            <a href="https://wordpress.org/plugins/yith-woocommerce-brands-add-on/">YITH WooCommerce Brands Add-On</a>
            
            Ultimate WooCommerce Brands
            https://wordpress.org/plugins/ultimate-woocommerce-brands/
            taxonomy = "product_brand"
            <a href="https://wordpress.org/plugins/ultimate-woocommerce-brands/">Ultimate WooCommerce Brands</a>
            
            Woocommerce Brand
            https://wordpress.org/plugins/wc-brand/
            taxonomy = 'product_brand' 
            <a href="https://wordpress.org/plugins/wc-brand/">Woocommerce Brand</a> 
            
          */ 
          $tax_array = $vtprd_info['brands_taxonomy_array']; 
          //add_filter( 'vtprd_add_brands_taxonomy', function() { return  'brands plugin taxonomy'; } );               
          $filter_tax = apply_filters('vtprd_add_brands_taxonomy',FALSE );
          if ($filter_tax) {
            $tax_array[] = $filter_tax;
          } 
          $taxonomy = FALSE;
          foreach ( $tax_array as $tax ) {
            if (taxonomy_exists($tax)) { 
              $taxonomy = $tax;
              break;
            }
          }                             
         ?> 
         <div class="incl-excl-group bottom-horiz-line action-group-brands-incl-excl-group clear-left"> 
         
         <?php        
          if ($taxonomy) {           
         ?> 
          <div class="and-or-selector action-and-or-selector" id="action-and-or-selector-brands">                                        
            <div class="switch-field"> 
              <span class="hasWizardHelpRight">
                <input id="action_group_brands_and_or-AndSelect" class="and-or-selector-AndSelect" name="action_group_brands_and_or" value="and" type="radio" <?php if ( $vtprd_rule->action_group_population_info['action_group_brands_and_or'] == 'and') { echo wp_kses($checked ,$allowed_html); } ?> >
                <label id="action_group_brands_and_or-AndSelect-label" for="action_group_brands_and_or-AndSelect" class="and-or-selector-yes">And</label>
              </span> 
              <?php vtprd_show_object_hover_help ('action_group_brands_AndSelect', 'wizard'); ?> 
              <span class="hasWizardHelpRight">                                                       
                <input id="action_group_brands_and_or-OrSelect"  class="" name="action_group_brands_and_or" value="or"  type="radio" <?php if ( $vtprd_rule->action_group_population_info['action_group_brands_and_or'] == 'or' ) { echo wp_kses($checked ,$allowed_html); } ?> > 
                <label for="action_group_brands_and_or-OrSelect"  class="and-or-selector-no">Or</label> 
              </span>
              <?php vtprd_show_object_hover_help ('action_group_brands_OrSelect', 'wizard'); ?> 
            </div> 
          </div>
         <?php        
          }          
         ?>  
                  
          <div class="form-group2 clear-both">      
      				<div class="form-field"><label class="action-brands-incl-label right-col-label"><?php esc_attr_e( 'Brand', 'vtprd' ); if (!$taxonomy) { ?> <br><br> <?php esc_attr_e( 'Exclude Brand', 'vtprd' ); } ?></label>
                 <?php        
                  if ($taxonomy) {           
                 ?> 
        				    <select class="vtprd-brand-search vtprd-noajax-search left-col-data" multiple="multiple" style="width: 500px;" name="action_group_brands_incl_array[]" data-placeholder="<?php esc_attr_e( 'Search Brand ', 'vtprd' ); ?>&hellip;" data-action="vtprd_brand_search_ajax">
          					<?php
                                $checked_list = $vtprd_rule->action_group_population_info['action_group_brands_incl_array'];
          						$this->vtprd_build_cat_selects($taxonomy,$checked_list); 
          					?>
                    </select>
                  <?php } else {
                      ?>
                      <span class="plugin-required hasWizardHelpRight">( <span class="brand-lit"><?php esc_attr_e('Brands', 'vtprd' ); ?></span><?php esc_attr_e(' - free Brands plugin needed', 'vtprd' ); ?> &nbsp;&nbsp;<em><?php esc_attr_e('[ hover for plugin list ]', 'vtprd' ); ?></em> )</span>
                      <?php                   
                      vtprd_show_object_hover_help ('buy_group_brands_incl', 'wizard'); 
                  } ?> 
                 <span class="shortIntro-b-and-w shortIntro-select2 question-mark-area" >
                    <img  class="hasHoverHelp2 help-b-and-w hasWizardHelpRight" width="15px" alt=""  src="<?php echo esc_url(VTPRD_URL.'/admin/images/help-b-and-w.png');?>" /> 
                   <?php vtprd_show_object_hover_help ('buy_group_brands_incl', 'wizard'); ?>
                 </span>                 
              </div>   
          </div>

         <?php        
          if ($taxonomy) {           
         ?>           
          <div class="form-group2   pad-the-top clear-left">      
      				<div class="form-field"><label class="action-brands-excl-label right-col-label"><?php esc_attr_e( 'Exclude Brand', 'vtprd' ); ?></label>
                 <?php        
                  if ($taxonomy) {          
                 ?>				    
                    <select class="vtprd-brand-search vtprd-noajax-search left-col-data" multiple="multiple" style="width: 500px;" name="action_group_brands_excl_array[]" data-placeholder="<?php esc_attr_e( 'Search Brand ', 'vtprd' ); ?> &hellip;" data-action="vtprd_brand_search_ajax">
          					<?php
                                $checked_list = $vtprd_rule->action_group_population_info['action_group_brands_excl_array'];
          						$this->vtprd_build_cat_selects($taxonomy,$checked_list); 
          					?>
                    </select>
                  <?php } else {                 
                      ?>
                      <span class="plugin-required hasWizardHelpRight"><?php esc_attr_e('( Brands - free Brands plugin needed )', 'vtprd' ); ?></span>
                      <?php                    
                      vtprd_show_object_hover_help ('buy_group_brands_incl', 'wizard'); 
                  } ?> 
                 <span class="shortIntro-b-and-w shortIntro-select2 question-mark-area" >
                    <img  class="hasHoverHelp2 help-b-and-w hasWizardHelpRight" width="15px" alt=""  src="<?php echo esc_url(VTPRD_URL.'/admin/images/help-b-and-w.png');?>" /> 
                   <?php vtprd_show_object_hover_help ('buy_group_brands_excl', 'wizard');?>
                 </span> 
              </div>               
          </div>
         <?php        
          }           
         ?>                     
        </div>  

      </div> <?php  /* END action-group-select-product-area  */ ?>
          
    <?php 
    //*************
    //v2.0.0 end   
    //*************
 
    }  
      
  
    public    function vtprd_pop_in_specifics( ) {                     
       global $post, $vtprd_info, $vtprd_rule; $vtprd_rules_set;
       $checked = 'checked="checked"'; 
       $allowed_html = vtprd_get_allowed_html(); //v2.0.3 
  ?>
        
       <div class="column1" id="specDescrip">
          <h4><?php esc_attr_e('How is the Rule applied to the search results?', 'vtprd');?></h4>
          <p><?php esc_attr_e("Once we've figured out the population we're working on (cart only or specified groups),
          how do we apply the rule?  Do we look at each product individually and apply the rule to
          each product we find?  Or do we look at the population as a group, and apply the rule to the
          group as a tabulated whole?  Or do we apply the rule to any we find, and limit the application 
          of the rule to a certain number of products?", 'vtprd');?>           
          </p>
       </div>
       <div class="column2" id="specChoiceIn">
          <h3><?php esc_attr_e('Select Rule Application Method', 'vtprd');?></h3>
          <div id="specRadio">
            <span id="Choice-input-span">
                <?php
               for($i=0; $i < sizeof($vtprd_rule->specChoice_in); $i++) { 
               ?>                 

                  <input id="<?php echo wp_kses($vtprd_rule->specChoice_in[$i]['id'] ,$allowed_html); ?>" class="<?php echo wp_kses($vtprd_rule->specChoice_in[$i]['class'] ,$allowed_html); ?>" type="<?php echo wp_kses($vtprd_rule->specChoice_in[$i]['type'] ,$allowed_html); ?>" name="<?php echo wp_kses($vtprd_rule->specChoice_in[$i]['name'] ,$allowed_html); ?>" value="<?php echo wp_kses($vtprd_rule->specChoice_in[$i]['value'] ,$allowed_html); ?>" <?php if ( $vtprd_rule->specChoice_in[$i]['user_input'] > ' ' ) { echo wp_kses($checked ,$allowed_html); } ?> /><?php echo wp_kses($vtprd_rule->specChoice_in[$i]['label'] ,$allowed_html); ?><br />

               <?php
                }
               ?>  
            </span>
            <span class="" id="anyChoiceIn-span">
                <span><?php esc_attr_e('*Any* applies to a *required*', 'vtprd');?></span><br />
                 <?php esc_attr_e('Maximum of:', 'vtprd');?>                      
                 <input id="<?php echo wp_kses($vtprd_rule->anyChoiceIn_max['id'] ,$allowed_html); ?>" class="<?php echo wp_kses($vtprd_rule->anyChoiceIn_max['class'] ,$allowed_html); ?>" type="<?php echo wp_kses($vtprd_rule->anyChoiceIn_max['type'] ,$allowed_html); ?>" name="<?php echo wp_kses($vtprd_rule->anyChoiceIn_max['name'] ,$allowed_html); ?>" value="<?php echo wp_kses($vtprd_rule->anyChoiceIn_max['value'] ,$allowed_html); ?>" />
                 <?php esc_attr_e('Products', 'vtprd');?>
            </span>           
          </div>                
       </div>                                                
       <div class="column3 specExplanation" id="allChoiceIn-chosen">
          <h4><?php esc_attr_e('Treat the Selected Group as a Single Entity', 'vtprd');?><span> - <?php esc_attr_e('explained', 'vtprd');?></span></h4>
          <p><?php esc_attr_e("Using *All* as your method, you choose to look at all the products from your cart search results.  That means we add
          all the quantities and/or price across all relevant products in the cart, to test against the rule's requirements.", 'vtprd');?>           
          </p>
       </div>
       <div class="column3 specExplanation" id="eachChoiceIn-chosen">
          <h4><?php esc_attr_e('Each in the Selected Group', 'vtprd');?><span> - <?php esc_attr_e('explained', 'vtprd');?></span></h4>
          <p><?php esc_attr_e("Using *Each* as your method, we apply the rule to each product from your cart search results.
          So if any of these products fail to meet the rule's requirements, the cart as a whole receives an error message.", 'vtprd');?>           
          </p>
       </div>
       <div class="column3 specExplanation" id="anyChoiceIn-chosen">
          <h4><?php esc_attr_e('Apply the rule to any Individual Product in the Cart', 'vtprd');?><span> - <?php esc_attr_e('explained', 'vtprd');?></span></h4>
          <p><?php esc_attr_e("Using *Any*, we can apply the rule to any product in the cart from your cart search results, similar to *Each*.  However, there is a
          maximum number of products to which the rule is applied. The product group is checked to see if any of the group fail to reach the maximum amount
          threshhold.  If so, the error will be applied to products in the cart based on cart order, up to the maximum limit supplied.", 'vtprd');?>
          <br /> <br /> 
          <?php esc_attr_e('For example, the rule might be something like:', 'vtprd');?>
          <br /> <br /> &nbsp;&nbsp;
          <?php esc_attr_e('"You may buy a maximum of $10 for each of any of 2 products from this group."', 'vtprd');?>              
          </p>               
       </div> 
      
    <?php
  }  
                                                                           
    public    function vtprd_rule_id() {          
        global $post, $vtprd_rule;           
       
        $allowed_html = vtprd_get_allowed_html(); //v2.0.3
       
        if ($vtprd_rule->ruleInWords > ' ') { ?>
            <span class="ruleInWords" >              
               <span class="clear-left">  <?php echo wp_kses($vtprd_rule->ruleInWords ,$allowed_html); ?></span><!-- /clear-left -->                              
            </span><!-- /ruleInWords -->              
        <?php } //end ruleInWords 
  } 
  
    public    function vtprd_rule_resources() {          
        ?> <a id="vtprd-rr-doc"  href=" <?php echo esc_url(VTPRD_DOCUMENTATION_PATH); ?> '"  title="Access Plugin Documentation">  <?php  esc_attr_e('Plugin', 'vtprd'); ?> <br>  <?php esc_attr_e('Documentation', 'vtprd'); ?> </a>;
        <?php 
        //Back to the Top box, fixed at lower right corner!!!!!!!!!!
        ?> <a href="#" id="back-to-top-tab" class="show-tab"> <?php  esc_attr_e('Back to Top', 'vtprd') ?> <strong>&uarr;</strong></a>
        <?php 
  }   

      
    public    function vtprd_rule_scheduling() {             //periodicByDateRange
        global $vtprd_rule;
        $allowed_html = vtprd_get_allowed_html(); //v2.0.3
        //**********************************************************************************
        //script goes here, rather than in enqueued resources, due to timing issues 
        //**********************************************************************************
       
       //-----------------------------------------
       //v2.0.3 datepicker JS moved to fixed file 'vtprd-admin-ui-script'      
      
     //load up default if no date range
     if ( sizeof($vtprd_rule->periodicByDateRange) == 0 ) {     
        $vtprd_rule->periodicByDateRange[0]['rangeBeginDate'] = date('Y-m-d');
        $vtprd_rule->periodicByDateRange[0]['rangeEndDate']   = (date('Y')+1) . date('-m-d') ;
     } 

     ?> 
        <span class="basic-begin-date-area blue-dropdown"> 
            <label class="begin-date first-in-line-label">&nbsp;<?php esc_attr_e('Begin Date', 'vtprd');?></label> 
            <input type='text' id='date-begin-0' class='pickdate  clear-left' size='7' value="<?php echo wp_kses($vtprd_rule->periodicByDateRange[0]['rangeBeginDate'] ,$allowed_html);?>" name='date-begin-0' readonly="readonly" />				
        </span>        
        <span class="basic-end-date-area blue-dropdown">          
          <label class="end-date first-in-line-label">&nbsp;<?php esc_attr_e('End Date', 'vtprd');?></label>                      
          <input type='text' id='date-end-0'   class='pickdate   clear-left' size='7' value="<?php echo wp_kses($vtprd_rule->periodicByDateRange[0]['rangeEndDate'] ,$allowed_html); ?>"   name='date-end-0' readonly="readonly"  />          
        </span>        
        
    <?php      
       global $vtprd_setup_options;

  }   

  public  function vtprd_change_title_currency_symbol( $variable_name, $i, $currency_symbol ) {
     global $vtprd_deal_screen_framework;
      //replace $$ with setup currency!!                        
      $vtprd_deal_screen_framework[$variable_name]['option'][$i]['title'] = 
                str_replace('$$', $currency_symbol, $vtprd_deal_screen_framework[$variable_name]['option'][$i]['title'] );
      
      //v2.0.3 begin
      if ( (isset($vtprd_deal_screen_framework[$variable_name]['option'][$i]['title2'])) &&
           ($vtprd_deal_screen_framework[$variable_name]['option'][$i]['title2'] > ' ') ) {
        $vtprd_deal_screen_framework[$variable_name]['option'][$i]['title2'] = 
                  str_replace('$$', $currency_symbol, $vtprd_deal_screen_framework[$variable_name]['option'][$i]['title2'] );           
      }
     
      if ( (isset($vtprd_deal_screen_framework[$variable_name]['option'][$i]['title3'])) &&
           ($vtprd_deal_screen_framework[$variable_name]['option'][$i]['title3'] > ' ') ) {
        $vtprd_deal_screen_framework[$variable_name]['option'][$i]['title3'] = 
                  str_replace('$$', $currency_symbol, $vtprd_deal_screen_framework[$variable_name]['option'][$i]['title3'] );           
      } 
     
      if ( (isset($vtprd_deal_screen_framework[$variable_name]['option'][$i]['title4'])) &&
           ($vtprd_deal_screen_framework[$variable_name]['option'][$i]['title4'] > ' ') ) {
        $vtprd_deal_screen_framework[$variable_name]['option'][$i]['title4'] = 
                  str_replace('$$', $currency_symbol, $vtprd_deal_screen_framework[$variable_name]['option'][$i]['title4'] );           
      }            
      //v2.0.3 end 
    return;           
  }    
  

  public  function vtprd_load_forThePriceOf_literal($k) {
      global $vtprd_rule;
      $allowed_html = vtprd_get_allowed_html(); //v2.0.3
      if (($vtprd_rule->rule_deal_info[$k]['discount_amt_type'] =='forThePriceOf_Units') ||
         ($vtprd_rule->rule_deal_info[$k]['discount_amt_type'] =='forThePriceOf_Currency')) {
        switch ($vtprd_rule->rule_template) {
          case 'C-forThePriceOf-inCart':    //buy-x-action-forThePriceOf-same-group-discount              
              echo wp_kses(' Buy ' ,$allowed_html);
              echo wp_kses($vtprd_rule->rule_deal_info[$k]['buy_amt_count'] ,$allowed_html);
            break;
          case 'C-forThePriceOf-Next':  //buy-x-action-forThePriceOf-other-group-discount
              echo wp_kses(' Get ' ,$allowed_html);
              echo wp_kses($vtprd_rule->rule_deal_info[$k]['action_amt_count'] ,$allowed_html);
            break;
        }
      }
    }


    //remove conflict with all-in-one seo pack!!  
    //  from http://wordpress.stackexchange.com/questions/55088/disable-all-in-one-seo-pack-for-some-custom-post-types
   public  function vtprd_remove_all_in_one_seo_aiosp() {
        $cpts = array( 'vtprd-rule' );
        foreach( $cpts as $cpt ) {
            remove_meta_box( 'aiosp', $cpt, 'advanced' );
        }
    }


    
  /*
    *  taxonomy (r) - registered name of taxonomy
    *  tax_class (r) - name options => 'prodcat-in' 'prodcat-out' 'rulecat-in' 'rulecat-out'
    *             refers to product taxonomy on the candidate or action categories,
    *                       rulecat taxonomy on the candidate or action categories
    *                         :: as there are only these 4, they are unique   
    *  checked_list (o) - selection list from previous iteration of rule selection                              
    *                          
   */

  //*******************
  //v2.0.0 recoded and renamed for select2
  //*******************
  public function vtprd_build_cat_selects ($taxonomy, $checked_list) { //v2.0.0.9 removed " = NULL "
        //error_log( print_r(  'function vtprd_build_cat_selects begin in rules-ui, $taxonomy= ' .$taxonomy, true ) );
        //error_log( print_r(  '$checked_list = ', true ) );
        //error_log( var_export($checked_list, true ) );
        
        //v2.0.3 begin 
        $allowed_html = vtprd_get_allowed_html(); //v2.0.3
        $sizeof_checked_list = is_array($checked_list) ? sizeof($checked_list) : 0; //v2.1.0
        //v2.0.3 end
        
        global $wpdb, $vtprd_info;         

        //v2.0.3 begin
        //$sql = "SELECT terms.`term_id`, terms.`name`  FROM `" . $wpdb->prefix . "terms` as terms, `" . $wpdb->prefix . "term_taxonomy` as term_taxonomy  WHERE   terms.`term_id` = term_taxonomy.`term_id` AND term_taxonomy.`taxonomy` = '" . $taxonomy . "' ORDER BY terms.`name` ASC";  
        $sql = $wpdb->prepare( "SELECT terms.`term_id`, terms.`name`  FROM `" . $wpdb->prefix . "terms` as terms, `" . $wpdb->prefix . "term_taxonomy` as term_taxonomy  WHERE   terms.`term_id` = term_taxonomy.`term_id` AND term_taxonomy.`taxonomy` = %s   ORDER BY terms.`name` ASC",
              $taxonomy);  
        //v2.0.3 end
        
        $categories = $wpdb->get_results($sql,ARRAY_A) ;

        //error_log( print_r(  '$categories found on db = ', true ) );
        //error_log( var_export($categories, true ) );
                
        $sizeof_cats = is_array($categories) ? sizeof($categories) : 0; //v2.1.0
        if ($sizeof_cats == 0) {
      		$message = '<option value="0"' . ' selected="selected">No Entries Established</option>';
            echo wp_kses($message ,$allowed_html);
          return;            
        } 
        
       //error_log( print_r(  '$categories', true ) );
       //error_log( var_export($categories, true ) ); 
               
        foreach ($categories as $category) {
            $term_id = $category['term_id']; 
                //error_log( print_r(  '$term_id IN FOREACH = ' .$term_id, true ) );
            //v2.0.3 begin  recoded to correctly handle ($sizeof_checked_list == 0) in php8+
            switch( TRUE ) { 
                case ($sizeof_checked_list == 0):
                		    //error_log( print_r(  '$term_id *NOT* FOUND = ' .$term_id, true ) );
                        $message = '<option value="' . esc_attr( $term_id ) . '"' . '>' . esc_html( $category['name'] ) . '</option>'; 
                          //error_log( print_r(  '$message = ' .$message, true ) );
                          //$output = wp_kses($message ,$allowed_html);
                          //error_log( print_r(  '$message after wp_kses = ' .$output, true ) );                
                		echo wp_kses($message ,$allowed_html);             
                          //error_log( print_r(  'option created cat = ' .$category['name'], true ) );                        
                    break;
            
                case  (in_array( $term_id, $checked_list )) :
                  		    //error_log( print_r(  '$term_id FOUND = ' .$term_id, true ) );
                        $message = '<option value="' . esc_attr( $term_id ) . '"' 	. ' selected="selected">' 	. esc_html( $category['name'] ) . '</option>';
                            //error_log( print_r(  '$message = ' .$message, true ) );
                            //$output = wp_kses($message ,$allowed_html);
                            //error_log( print_r(  '$message after wp_kses = ' .$output, true ) );
                        echo wp_kses($message ,$allowed_html);
                     break;
                
                default :
                  		    //error_log( print_r(  '$term_id *NOT* FOUND = ' .$term_id, true ) );
                        $message = '<option value="' . esc_attr( $term_id ) . '"' . '>' . esc_html( $category['name'] ) . '</option>'; 
                            //error_log( print_r(  '$message = ' .$message, true ) );
                            //$output = wp_kses($message ,$allowed_html);
                            //error_log( print_r(  '$message after wp_kses = ' .$output, true ) );                
                  		echo wp_kses($message ,$allowed_html);             
                            //error_log( print_r(  'option created cat = ' .$category['name'], true ) );           
                    break;
                
            }
            //v2.0.3 end       
         }    
         return;
   
    }


  //*******************
  //v2.0.0 new function
  //*******************
  public function vtprd_build_role_selects ($checked_list) {  //v2.0.0.9 removed " = NULL "
        //error_log( print_r(  ' ', true ) );
        //error_log( print_r(  'function vtprd_build_role_selects begin', true ) );

        //error_log( print_r(  '$checked_list = ', true ) );
        //error_log( var_export($checked_list, true ) );
        
        //v2.0.3 begin 
        $allowed_html = vtprd_get_allowed_html(); //v2.0.3
        $sizeof_checked_list = is_array($checked_list) ? sizeof($checked_list) : 0; //v2.1.0
        //v2.0.3 end
                        
        global $wpdb, $vtprd_info;         

        $roles = get_editable_roles();
        
        $roles['notLoggedIn'] = array( 'name' => 'Not logged in (just visiting)' );

        //error_log( print_r(  '$roles found on db = ', true ) );
        //error_log( var_export($roles, true ) );

        foreach ($roles as $role => $info) {
            $name_translated = translate_user_role( $info['name'] );
                      //error_log( print_r(  '$role = ' .$role, true ) );
                      //error_log( print_r(  '$name_translated = ' .$name_translated, true ) );
            
            //v2.0.3 begin  recoded to correctly handle ($sizeof_checked_list == 0) in php8+            
            switch( TRUE ) { 
                case ($sizeof_checked_list == 0):
                  		$message =  '<option value="' . $role . '"' . '>' . $name_translated . '</option>'; 
                            
                            //error_log( print_r(  'ROLE **NOT** FOUND ' , true ) );
                            //error_log( print_r(  '$message = ' .$message, true ) );
                            //$output = wp_kses($message ,$allowed_html);
                            //error_log( print_r(  '$message after wp_kses = ' .$output, true ) );                
                        
                        echo wp_kses($message ,$allowed_html); 
                    break;
            
                case  (in_array( $role, $checked_list )) :
                  		$message =  '<option value="' . $role . '"' . ' selected="selected">' . $name_translated . '</option>';
        
                            //error_log( print_r(  'ROLE FOUND ' , true ) );
                            //error_log( print_r(  '$message = ' .$message, true ) );
                            //$output = wp_kses($message ,$allowed_html);
                            //error_log( print_r(  '$message after wp_kses = ' .$output, true ) );                
                        
                        echo wp_kses($message ,$allowed_html);
                    break;
                
                default :
                		$message =  '<option value="' . $role . '"' . '>' . $name_translated . '</option>'; 
                          
                          //error_log( print_r(  'ROLE **NOT** FOUND ' , true ) );
                          //error_log( print_r(  '$message = ' .$message, true ) );
                          //$output = wp_kses($message ,$allowed_html);
                          //error_log( print_r(  '$message after wp_kses = ' .$output, true ) );                
                      
                      echo wp_kses($message ,$allowed_html); 
                    break;                
            }
            //v2.0.3 end           
     
         }
   
         return;
    }


  //*******************
  //v2.0.0 new function
  //*******************
  public function vtprd_build_customer_selects ($checked_list = NULL ) {
//redo to go directly after key, rather than do array check!!
        //error_log( print_r(  'function vtprd_build_customer_selects begin ', true ) ); 
 
         
        //v2.0.3 begin - occasional fatal error caught here
        $allowed_html = vtprd_get_allowed_html(); //v2.0.3
        $sizeof_checked_list = is_array($checked_list) ? sizeof($checked_list) : 0; //v2.1.0
        if ($sizeof_checked_list == 0) {   //this is OK here, as $checked_list is the driving array
          return;            
        }
        //v2.0.3 end
 
        global $wpdb, $vtprd_info;         

        
        foreach ($checked_list as $user_id) {                                     
            //$sql = "SELECT *  FROM `" . $wpdb->prefix . "users`   WHERE   `ID` = '" . $user_id . "' "; 
            $sql = $wpdb->prepare( "SELECT *  FROM `" . $wpdb->prefix . "users`   WHERE   `ID` = %s ",
                $user_id
            ); 
                                        
		    $user = $wpdb->get_results($sql,ARRAY_A) ; 
            if ($user) { 
              //result is a single iteration array, with an occurrence!! 
              $email_and_name = $user[0]['user_email'] .' ('. $user[0]['display_name'] .')';

              $message = '<option value="' . esc_attr( $user_id ) . '"' 	. ' selected="selected">' 	. esc_html( $email_and_name ) . '</option>'; 
              echo wp_kses($message ,$allowed_html); //v2.0.3  
             
            }          
         }    
         return;
    }

/*
Groups By itthinx
https://wordpress.org/plugins/groups/


$user_id = isset( $user->ID ) ? $user->ID : isset( $args[1] ) ? $args[1] : 0;

		global $wpdb;

		$group_table = _groups_get_tablename( 'group' );
		$user_group_table = _groups_get_tablename( 'user_group' );
		// We can end up here while a blog is being deleted, in that case, 
		// the tables have already been deleted.
		//if ( ( $wpdb->get_var( "SHOW TABLES LIKE '" . $group_table . "'" ) == $group_table ) &&
		//	( $wpdb->get_var( "SHOW TABLES LIKE '" . $user_group_table . "'" ) == $user_group_table )
		) {

			$rows = $wpdb->get_results( $wpdb->prepare(
				"SELECT * FROM $user_group_table
				LEFT JOIN $group_table ON $user_group_table.group_id = $group_table.group_id
				WHERE $user_group_table.user_id = %d
				",
				Groups_Utility::id( $user_id )
			) );
			if ( $rows ) {
				foreach( $rows as $row ) {
					// don't optimize that, favour standard deletion
					self::delete( $row->user_id, $row->group_id );
				}
*/
  //*******************
  //v2.0.0 new function
  //*******************
  public function vtprd_build_group_selects($checked_list = NULL ) {
        //error_log( print_r(  'function vtprd_build_group_selects begin', true ) );
        
        //v2.0.3 begin 
        $allowed_html = vtprd_get_allowed_html(); //v2.0.3
        $sizeof_checked_list = is_array($checked_list) ? sizeof($checked_list) : 0; //v2.1.0

        //v2.0.3 end
                
        global $wpdb, $vtprd_info;         
        
              //$sql = "SELECT *  FROM `" . $wpdb->prefix . "groups_group`  ORDER BY `name` ASC";     //v2.0.3
              $contentSearch = 'ASC'; //v2.0.3 - $wpdb->prepare REQUIRES a variable in the sql.
              $sql = $wpdb->prepare( "SELECT *  FROM `" . $wpdb->prefix . "groups_group`  ORDER BY `name` %1s", $contentSearch);     //v2.0.3  %1s prevents prepare from adding single quotes
              $groups = $wpdb->get_results($sql,ARRAY_A) ;
        
       //error_log( print_r(  '$groups', true ) );
      //error_log( var_export($groups, true ) ); 

        $sizeof_groups = is_array($groups) ? sizeof($groups) : 0; //v2.1.0
        //if (sizeof($groups) == 0) {
        if ($sizeof_groups == 0) {
      		$message = '<option value="0"' . ' selected="selected">No Groups Established</option>';
            echo wp_kses($message ,$allowed_html); //v2.0.3
          return;            
        }
               
        foreach ($groups as $group) {
            $group_id = $group['group_id']; 
            
            //v2.0.3 begin  recoded to correctly handle ($sizeof_checked_list == 0) in php8+            
            switch( TRUE ) { 
                case ($sizeof_checked_list == 0):
                  		$message = '<option value="' . esc_attr( $group_id ) . '"' 	. '>' 	. esc_html( $group['name'] ) . '</option>'; 
                        echo wp_kses($message ,$allowed_html); //v2.0.3
                            //error_log( print_r(  'option created cat = ' .$group['name'], true ) );  
                    break;
            
                case  (in_array( $group_id, $checked_list )) :
                  		$message = '<option value="' . esc_attr( $group_id ) . '"' . ' selected="selected">' . esc_html( $group['name'] ) . '</option>';
                        echo wp_kses($message ,$allowed_html); //v2.0.3
                    break;
                
                default :
                  		$message = '<option value="' . esc_attr( $group_id ) . '"' 	. '>' 	. esc_html( $group['name'] ) . '</option>'; 
                        echo wp_kses($message ,$allowed_html); //v2.0.3
                            //error_log( print_r(  'option created cat = ' .$group['name'], true ) );  
                    break;                
            }
            //v2.0.3 end      
         }    
         return;                  
    }

  //*******************
  //v2.0.0 new function
  //*******************
  public function vtprd_build_memberships_selects($checked_list = NULL ) {
        //error_log( print_r(  'function vtprd_build_memberships_selects begin', true ) );
        
        //v2.0.3 begin 
        $allowed_html = vtprd_get_allowed_html(); //v2.0.3        
        $sizeof_checked_list = is_array($checked_list) ? sizeof($checked_list) : 0; //v2.1.0
        //v2.0.3 end
                
        global $wpdb, $vtprd_info;         
        
        //this comes back as POSTS with post_type of 'wc_membership_plan'
        $all_membership_plans = wc_memberships_get_membership_plans();
        
       //error_log( print_r(  '$all_membership_plans', true ) );
       //error_log( var_export($all_membership_plans, true ) ); 
        $sizeof_plans = is_array($all_membership_plans) ? sizeof($all_membership_plans) : 0; //v2.1.0
        //if (sizeof($all_membership_plans) == 0) {
        if ($sizeof_plans == 0) {
      		$message = '<option value="0"' . ' selected="selected">No Memberships Established</option>';
            echo wp_kses($message ,$allowed_html); //v2.0.3
          return;            
        }       
        
        
        foreach ($all_membership_plans as $membership_plan) {        
            $membership_plan_id = $membership_plan->id; 
            
            //v2.0.3 begin  recoded to correctly handle ($sizeof_checked_list == 0) in php8+            
            switch( TRUE ) { 
                case ($sizeof_checked_list == 0):
                  		$message = '<option value="' . esc_attr( $membership_plan_id ) . '"' . '>' . esc_html( $membership_plan->name ) . '</option>';
                        echo wp_kses($message ,$allowed_html); //v2.0.3 
                    break;
            
                case  (in_array( $membership_plan_id, $checked_list )) :
                   		$message = '<option value="' . esc_attr( $membership_plan_id ) . '"' . ' selected="selected">' . esc_html( $membership_plan->name ) . '</option>';
                        echo wp_kses($message ,$allowed_html); //v2.0.3
                    break;
                
                default :
                  		$message = '<option value="' . esc_attr( $membership_plan_id ) . '"' . '>' . esc_html( $membership_plan->name ) . '</option>';
                        echo wp_kses($message ,$allowed_html); //v2.0.3 
                    break;                
            }
            //v2.0.3 end     
         }    
         return;                  
    }

  
 
  //BUILD A DEFAULT RULE       
  public  function vtprd_build_new_rule() {
      global $post, $vtprd_info, $vtprd_rule, $vtprd_rules_set, $vtprd_deal_structure_framework, $vtprd_edit_arrays_framework; //v2.0.0 added $vtprd_edit_arrays_framework
                    
        //initialize rule
        $vtprd_rule = new VTPRD_Rule;
 
         //fill in standard default values not already supplied
         
        //load the 1st iteration of deal info by default    => internal defaults set in vtprd_deal_structure_framework


        //***************
        //v2.0.0.9 begin
        //***************
        $vtprd_rule->rule_deal_info[] = vtprd_build_rule_deal_info();
        
        /*
        $vtprd_rule->rule_deal_info[] = $vtprd_deal_structure_framework;  

        $vtprd_rule->rule_deal_info[0]['buy_repeat_condition'] = 'none'; 
        $vtprd_rule->rule_deal_info[0]['buy_amt_type'] = 'none';
        $vtprd_rule->rule_deal_info[0]['buy_amt_mod'] = 'none';
        $vtprd_rule->rule_deal_info[0]['buy_amt_applies_to'] = 'all';
        $vtprd_rule->rule_deal_info[0]['action_repeat_condition'] = 'none'; 
        $vtprd_rule->rule_deal_info[0]['action_amt_type'] = 'none';  
        $vtprd_rule->rule_deal_info[0]['action_amt_mod'] = 'none';
        $vtprd_rule->rule_deal_info[0]['action_amt_applies_to'] = 'all';
        $vtprd_rule->rule_deal_info[0]['discount_amt_type'] = '0';
        $vtprd_rule->rule_deal_info[0]['discount_applies_to'] = 'each';
        $vtprd_rule->rule_deal_info[0]['discount_rule_max_amt_type'] = 'none';
        $vtprd_rule->rule_deal_info[0]['discount_lifetime_max_amt_type'] = 'none';
        $vtprd_rule->rule_deal_info[0]['discount_rule_cum_max_amt_type'] = 'none'; 
        */
        //v2.0.0.9 end
        $vtprd_rule->cumulativeRulePricing = 'yes';   
        $vtprd_rule->cumulativeSalePricing = 'addToSalePrice';   //v1.0.4 
        $vtprd_rule->cumulativeCouponPricing = 'yes';
               //discount occurs 5 times
        $vtprd_rule->ruleApplicationPriority_num = '10';         
        $vtprd_rule->rule_type_selected_framework_key =  'Title01'; //default 1st title for BOTH dropdowns
        
        $vtprd_rule->inPop = 'wholeStore';  //apply to all products
        //$vtprd_rule->role_and_or_in = 'or'; //v2.0.0
        $vtprd_rule->actionPop = 'sameAsInPop' ; 
        //$vtprd_rule->role_and_or_out = 'or'; //v2.0.0
        
        //new upper selects 

        $vtprd_rule->cart_or_catalog_select =  'cart'; //v2.0.0 New Defaults
        $vtprd_rule->pricing_type_select = 'choose';
        $vtprd_rule->minimum_purchase_select =  'next'; //v2.0.0 New Defaults
        $vtprd_rule->buy_group_filter_select = 'choose';
        $vtprd_rule->get_group_filter_select = 'choose';
        $vtprd_rule->rule_on_off_sw_select = 'onForever'; //v1.0.7.5 changed from 'on' 
        $vtprd_rule->wizard_on_off_sw_select = 'on';
        $vtprd_rule->rule_type_select = 'advanced'; //v2.0.0 was 'basic'    
              
        $vtprd_rule->buy_group_population_info = $vtprd_edit_arrays_framework['buy_group_framework']; //v2.0.0 
        $vtprd_rule->action_group_population_info = $vtprd_edit_arrays_framework['action_group_framework']; //v2.0.0 
                 
    return;
  }        
     //lots of selects change their values between standard and 'discounted' titles.
    //This is where we supply the HIDEME alternative titles
  public  function vtprd_print_alternative_title_selects() {
      global $vtprd_rule_display_framework, $vtprd_deal_screen_framework;
      
      $allowed_html = vtprd_get_allowed_html(); //v2.0.3
      
      ?>          
             
           <?php 
           /* +-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-
             Hidden Selects containing various versions of the Select Option texts.
             
                #1  = the default version of the titles
                #2  = the altenate (Discount) version of the titles
              
              Both are supplied, so the JS can toggle between these two sets,
              as needed by the Upper select choices
              +-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-
           */ ?>  
             <?php //Upper  pricint_type_select?>  
              <select id="<?php echo wp_kses($vtprd_rule_display_framework['pricing_type_select']['select']['id'] ,$allowed_html); echo wp_kses('1' ,$allowed_html);?>" class="<?php echo wp_kses($vtprd_rule_display_framework['pricing_type_select']['select']['class'] ,$allowed_html); echo wp_kses('1' ,$allowed_html); echo wp_kses(' hideMe' ,$allowed_html);?> " name="<?php echo wp_kses($vtprd_rule_display_framework['pricing_type_select']['select']['name'] ,$allowed_html); echo wp_kses('1' ,$allowed_html);?>" tabindex="" >          
                 <?php
                 for($i=0; $i < sizeof($vtprd_rule_display_framework['pricing_type_select']['option']); $i++) { 
                                             
                      //pick up the free/pro version of the title => in this case, title and title3
                      $title = $vtprd_rule_display_framework['pricing_type_select']['option'][$i]['title'];
                 ?>                             
                    <option id="<?php echo wp_kses($vtprd_rule_display_framework['pricing_type_select']['option'][$i]['id'] ,$allowed_html); echo wp_kses('1' ,$allowed_html); ?>"  class="<?php echo wp_kses($vtprd_rule_display_framework['pricing_type_select']['option'][$i]['class'] ,$allowed_html); echo wp_kses('1' ,$allowed_html); ?>"  value="<?php echo wp_kses($vtprd_rule_display_framework['pricing_type_select']['option'][$i]['value'] ,$allowed_html); ?>"    ><?php echo wp_kses($title ,$allowed_html); ?></option>
                 <?php } ?> 
               </select>                                        
              <select id="<?php echo wp_kses($vtprd_rule_display_framework['pricing_type_select']['select']['id'] ,$allowed_html); echo wp_kses('-catalog' ,$allowed_html);?>" class="<?php echo wp_kses($vtprd_rule_display_framework['pricing_type_select']['select']['class'] ,$allowed_html); echo wp_kses('-catalog' ,$allowed_html); echo wp_kses(' hideMe' ,$allowed_html);?>" name="<?php echo wp_kses($vtprd_rule_display_framework['pricing_type_select']['select']['name'] ,$allowed_html); echo wp_kses('-catalog' ,$allowed_html);?>" tabindex="" >          
                 <?php
                 for($i=0; $i < sizeof($vtprd_rule_display_framework['pricing_type_select']['option']); $i++) { 
                                             
                      //pick up the free/pro version of the title 
                      //v2.0.0 removed   $title = $vtprd_rule_display_framework['pricing_type_select']['option'][$i]['title-catalog'];
                
                 ?>                             
                    <option id="<?php echo wp_kses($vtprd_rule_display_framework['pricing_type_select']['option'][$i]['id'] ,$allowed_html); echo wp_kses('-catalog' ,$allowed_html); ?>"  class="<?php echo wp_kses($vtprd_rule_display_framework['pricing_type_select']['option'][$i]['class'] ,$allowed_html); echo wp_kses('-catalog' ,$allowed_html); ?>"  value="<?php echo wp_kses($vtprd_rule_display_framework['pricing_type_select']['option'][$i]['value'] ,$allowed_html); ?>"    ><?php echo wp_kses($title ,$allowed_html); ?></option>
                 <?php } ?> 
               </select>   
                          
             
             <?php //Upper  minimum_purchase_select?>  
              <select id="<?php echo wp_kses($vtprd_rule_display_framework['minimum_purchase_select']['select']['id'] ,$allowed_html); echo wp_kses('1' ,$allowed_html);?>" class="<?php echo wp_kses($vtprd_rule_display_framework['minimum_purchase_select']['select']['class'] ,$allowed_html); echo wp_kses('1' ,$allowed_html); echo wp_kses(' hideMe' ,$allowed_html);?> " name="<?php echo wp_kses($vtprd_rule_display_framework['minimum_purchase_select']['select']['name'] ,$allowed_html); echo wp_kses('1' ,$allowed_html);?>" tabindex="" >          
                 <?php
                 for($i=0; $i < sizeof($vtprd_rule_display_framework['minimum_purchase_select']['option']); $i++) { 
                                             
                      //pick up the free/pro version of the title => in this case, title and title3
                      //v2.0.0 removed   $title = $vtprd_rule_display_framework['minimum_purchase_select']['option'][$i]['title'];
                 ?>                             
                    <option id="<?php echo wp_kses($vtprd_rule_display_framework['minimum_purchase_select']['option'][$i]['id'] ,$allowed_html); echo wp_kses('1' ,$allowed_html); ?>"  class="<?php echo wp_kses($vtprd_rule_display_framework['minimum_purchase_select']['option'][$i]['class'] ,$allowed_html); echo wp_kses('1' ,$allowed_html); ?>"  value="<?php echo wp_kses($vtprd_rule_display_framework['minimum_purchase_select']['option'][$i]['value'] ,$allowed_html); ?>"    ><?php echo wp_kses($title ,$allowed_html); ?></option>
                 <?php } ?> 
               </select>                                        
              <select id="<?php echo wp_kses($vtprd_rule_display_framework['minimum_purchase_select']['select']['id'] ,$allowed_html); echo wp_kses('-catalog' ,$allowed_html);?>" class="<?php echo wp_kses($vtprd_rule_display_framework['minimum_purchase_select']['select']['class'] ,$allowed_html); echo wp_kses('-catalog' ,$allowed_html); echo wp_kses(' hideMe' ,$allowed_html);?> " name="<?php echo wp_kses($vtprd_rule_display_framework['minimum_purchase_select']['select']['name'] ,$allowed_html); echo wp_kses('-catalog' ,$allowed_html);?>" tabindex="" >          
                 <?php
                 for($i=0; $i < sizeof($vtprd_rule_display_framework['minimum_purchase_select']['option']); $i++) { 
                                             
                      //pick up the free/pro version of the title 
                      //v2.0.0 removed   $title = $vtprd_rule_display_framework['minimum_purchase_select']['option'][$i]['title-catalog'];
                
                 ?>                             
                    <option id="<?php echo wp_kses($vtprd_rule_display_framework['minimum_purchase_select']['option'][$i]['id'] ,$allowed_html); echo wp_kses('-catalog' ,$allowed_html); ?>"  class="<?php echo wp_kses($vtprd_rule_display_framework['minimum_purchase_select']['option'][$i]['class'] ,$allowed_html); echo wp_kses('-catalog' ,$allowed_html); ?>"  value="<?php echo wp_kses($vtprd_rule_display_framework['minimum_purchase_select']['option'][$i]['value'] ,$allowed_html); ?>"    ><?php echo wp_kses($title ,$allowed_html); ?></option>
                 <?php } ?> 
               </select>   
             
             <?php //Upper  buy_group_filter_select?>  
              <select id="<?php echo wp_kses($vtprd_rule_display_framework['buy_group_filter_select']['select']['id'] ,$allowed_html); echo wp_kses('1' ,$allowed_html);?>" class="<?php echo wp_kses($vtprd_rule_display_framework['buy_group_filter_select']['select']['class'] ,$allowed_html); echo wp_kses('1' ,$allowed_html); echo wp_kses(' hideMe' ,$allowed_html);?> " name="<?php echo wp_kses($vtprd_rule_display_framework['buy_group_filter_select']['select']['name'] ,$allowed_html); echo wp_kses('1' ,$allowed_html);?>" tabindex="" >          
                 <?php
                 for($i=0; $i < sizeof($vtprd_rule_display_framework['buy_group_filter_select']['option']); $i++) { 
                                             
                      //pick up the free/pro version of the title => in this case, title and title3
                      $title = $vtprd_rule_display_framework['buy_group_filter_select']['option'][$i]['title'];
                      if ( ( defined('VTPRD_PRO_DIRNAME') ) &&
                           ( isset($vtprd_rule_display_framework['buy_group_filter_select']['option'][$i]['title3']) ) &&    //v2.0.3
                           ( $vtprd_rule_display_framework['buy_group_filter_select']['option'][$i]['title3'] > ' ' ) ) {
                        $title = $vtprd_rule_display_framework['buy_group_filter_select']['option'][$i]['title3'];                        
                      }
                 ?>                             
                    <option id="<?php echo wp_kses($vtprd_rule_display_framework['buy_group_filter_select']['option'][$i]['id'] ,$allowed_html); echo wp_kses('1' ,$allowed_html); ?>"  class="<?php echo wp_kses($vtprd_rule_display_framework['buy_group_filter_select']['option'][$i]['class'] ,$allowed_html); echo wp_kses('1' ,$allowed_html); ?>"  value="<?php echo wp_kses($vtprd_rule_display_framework['buy_group_filter_select']['option'][$i]['value'] ,$allowed_html); ?>"    ><?php echo wp_kses($title ,$allowed_html); ?></option>
                 <?php } ?> 
               </select>                                        
              <select id="<?php echo wp_kses($vtprd_rule_display_framework['buy_group_filter_select']['select']['id'] ,$allowed_html); echo wp_kses('2' ,$allowed_html);?>" class="<?php echo wp_kses($vtprd_rule_display_framework['buy_group_filter_select']['select']['class'] ,$allowed_html); echo wp_kses('2' ,$allowed_html); echo wp_kses(' hideMe' ,$allowed_html);?>" name="<?php echo wp_kses($vtprd_rule_display_framework['buy_group_filter_select']['select']['name'] ,$allowed_html); echo wp_kses('2' ,$allowed_html);?>" tabindex="" >          
                 <?php
                 for($i=0; $i < sizeof($vtprd_rule_display_framework['buy_group_filter_select']['option']); $i++) { 
                                             
                      //pick up the free/pro version of the title 
                      $title = $vtprd_rule_display_framework['buy_group_filter_select']['option'][$i]['title2'];
                      if ( ( defined('VTPRD_PRO_DIRNAME') ) &&
                           ( isset($vtprd_rule_display_framework['buy_group_filter_select']['option'][$i]['title4']) ) &&    //v2.0.3
                           ( $vtprd_rule_display_framework['buy_group_filter_select']['option'][$i]['title4'] > ' ' ) ) {
                        $title = $vtprd_rule_display_framework['buy_group_filter_select']['option'][$i]['title4'];                        
                      }                                     
                 ?>                             
                    <option id="<?php echo wp_kses($vtprd_rule_display_framework['buy_group_filter_select']['option'][$i]['id'] ,$allowed_html); echo wp_kses('2' ,$allowed_html); ?>"  class="<?php echo wp_kses($vtprd_rule_display_framework['buy_group_filter_select']['option'][$i]['class'] ,$allowed_html); echo wp_kses('2' ,$allowed_html); ?>"  value="<?php echo wp_kses($vtprd_rule_display_framework['buy_group_filter_select']['option'][$i]['value'] ,$allowed_html); ?>"    ><?php echo wp_kses($title ,$allowed_html); ?></option>
                 <?php } ?> 
               </select>
              <select id="<?php echo wp_kses($vtprd_rule_display_framework['buy_group_filter_select']['select']['id'] ,$allowed_html); echo wp_kses('-catalog' ,$allowed_html);?>" class="<?php echo wp_kses($vtprd_rule_display_framework['buy_group_filter_select']['select']['class'] ,$allowed_html); echo wp_kses('-catalog' ,$allowed_html); echo wp_kses(' hideMe' ,$allowed_html);?>" name="<?php echo wp_kses($vtprd_rule_display_framework['buy_group_filter_select']['select']['name'] ,$allowed_html); echo wp_kses('-catalog' ,$allowed_html);?>" tabindex="" >          
                 <?php
                 for($i=0; $i < sizeof($vtprd_rule_display_framework['buy_group_filter_select']['option']); $i++) { 
                                             
                      //pick up the free/pro version of the title 
                      //v2.0.0 removed   $title = $vtprd_rule_display_framework['buy_group_filter_select']['option'][$i]['title-catalog'];
                
                 ?>                             
                    <option id="<?php echo wp_kses($vtprd_rule_display_framework['buy_group_filter_select']['option'][$i]['id'] ,$allowed_html); echo wp_kses('-catalog' ,$allowed_html); ?>"  class="<?php echo wp_kses($vtprd_rule_display_framework['buy_group_filter_select']['option'][$i]['class'] ,$allowed_html); echo wp_kses('-catalog' ,$allowed_html); ?>"  value="<?php echo wp_kses($vtprd_rule_display_framework['buy_group_filter_select']['option'][$i]['value'] ,$allowed_html);?>"    ><?php echo wp_kses($title ,$allowed_html); ?></option>
                 <?php } ?> 
               </select>                  
      
             <?php //buy_amt_type ?>  
              <select id="<?php echo wp_kses($vtprd_deal_screen_framework['buy_amt_type']['select']['id'] ,$allowed_html); echo wp_kses('1' ,$allowed_html);?>" class="<?php echo wp_kses($vtprd_deal_screen_framework['buy_amt_type']['select']['class'] ,$allowed_html); echo wp_kses('1' ,$allowed_html); echo wp_kses(' hideMe' ,$allowed_html);?>" name="<?php echo wp_kses($vtprd_deal_screen_framework['buy_amt_type']['select']['name'] ,$allowed_html); echo wp_kses('1' ,$allowed_html);?>" tabindex="" >          
                 <?php
                 for($i=0; $i < sizeof($vtprd_deal_screen_framework['buy_amt_type']['option']); $i++) { 
                 ?>                             
                    <option id="<?php echo wp_kses($vtprd_deal_screen_framework['buy_amt_type']['option'][$i]['id'] ,$allowed_html); echo wp_kses('1' ,$allowed_html); ?>"  class="<?php echo wp_kses($vtprd_deal_screen_framework['buy_amt_type']['option'][$i]['class'] ,$allowed_html); echo wp_kses('1' ,$allowed_html); ?>"  value="<?php echo wp_kses($vtprd_deal_screen_framework['buy_amt_type']['option'][$i]['value'] ,$allowed_html); ?>"    ><?php echo wp_kses($vtprd_deal_screen_framework['buy_amt_type']['option'][$i]['title'] ,$allowed_html);?></option>
                 <?php } ?> 
               </select>                                        
              <select id="<?php echo wp_kses($vtprd_deal_screen_framework['buy_amt_type']['select']['id'] ,$allowed_html); echo wp_kses('2' ,$allowed_html);?>" class="<?php echo wp_kses($vtprd_deal_screen_framework['buy_amt_type']['select']['class'] ,$allowed_html); echo wp_kses('2' ,$allowed_html); echo wp_kses(' hideMe' ,$allowed_html);?>" name="<?php echo wp_kses($vtprd_deal_screen_framework['buy_amt_type']['select']['name'] ,$allowed_html); echo wp_kses('2' ,$allowed_html);?>" tabindex="" >          
                 <?php
                 for($i=0; $i < sizeof($vtprd_deal_screen_framework['buy_amt_type']['option']); $i++) { 
                 ?>                             
                    <option id="<?php echo wp_kses($vtprd_deal_screen_framework['buy_amt_type']['option'][$i]['id'] ,$allowed_html); echo wp_kses('2' ,$allowed_html); ?>"  class="<?php echo wp_kses($vtprd_deal_screen_framework['buy_amt_type']['option'][$i]['class'] ,$allowed_html); echo wp_kses('2' ,$allowed_html); ?>"  value="<?php echo wp_kses($vtprd_deal_screen_framework['buy_amt_type']['option'][$i]['value'] ,$allowed_html); ?>"    ></option>
                 <?php } ?> 
               </select>
              <select id="<?php echo wp_kses($vtprd_deal_screen_framework['buy_amt_type']['select']['id'] ,$allowed_html); echo wp_kses('-catalog' ,$allowed_html);?>" class="<?php echo wp_kses($vtprd_deal_screen_framework['buy_amt_type']['select']['class'] ,$allowed_html); echo wp_kses('-catalog' ,$allowed_html); echo wp_kses(' hideMe' ,$allowed_html);?>" name="<?php echo wp_kses($vtprd_deal_screen_framework['buy_amt_type']['select']['name'] ,$allowed_html); echo wp_kses('-catalog' ,$allowed_html);?>" tabindex="" >          
                 <?php
                 for($i=0; $i < sizeof($vtprd_deal_screen_framework['buy_amt_type']['option']); $i++) { 
                                             
                      //pick up the free/pro version of the title 
                      //v2.0.0 removed   $title = $vtprd_deal_screen_framework['buy_amt_type']['option'][$i]['title-catalog'];
                
                 ?>                             
                    <option id="<?php echo wp_kses($vtprd_deal_screen_framework['buy_amt_type']['option'][$i]['id'] ,$allowed_html); echo wp_kses('-catalog' ,$allowed_html); ?>"  class="<?php echo wp_kses($vtprd_deal_screen_framework['buy_amt_type']['option'][$i]['class'] ,$allowed_html); echo wp_kses('-catalog' ,$allowed_html); ?>"  value="<?php echo wp_kses($vtprd_deal_screen_framework['buy_amt_type']['option'][$i]['value'] ,$allowed_html); ?>"    ><?php echo wp_kses($title ,$allowed_html); ?></option>
                 <?php } ?> 
               </select>                   
               
             <?php //buy_amt_applies_to ?>  
              <select id="<?php echo wp_kses($vtprd_deal_screen_framework['buy_amt_applies_to']['select']['id'] ,$allowed_html); echo wp_kses('1' ,$allowed_html);?>" class="<?php echo wp_kses($vtprd_deal_screen_framework['buy_amt_applies_to']['select']['class'] ,$allowed_html); echo wp_kses('1' ,$allowed_html); echo wp_kses(' hideMe' ,$allowed_html);?>" name="<?php echo wp_kses($vtprd_deal_screen_framework['buy_amt_applies_to']['select']['name'] ,$allowed_html); echo wp_kses('1' ,$allowed_html);?>" tabindex="" >          
                 <?php
                 for($i=0; $i < sizeof($vtprd_deal_screen_framework['buy_amt_applies_to']['option']); $i++) { 
                 ?>                             
                    <option id="<?php echo wp_kses($vtprd_deal_screen_framework['buy_amt_applies_to']['option'][$i]['id'] ,$allowed_html); echo wp_kses('1' ,$allowed_html); ?>"  class="<?php echo wp_kses($vtprd_deal_screen_framework['buy_amt_applies_to']['option'][$i]['class'] ,$allowed_html); echo wp_kses('1' ,$allowed_html); ?>"  value="<?php echo wp_kses($vtprd_deal_screen_framework['buy_amt_applies_to']['option'][$i]['value'] ,$allowed_html); ?>"    ><?php echo wp_kses($vtprd_deal_screen_framework['buy_amt_applies_to']['option'][$i]['title'] ,$allowed_html); ?></option>
                 <?php } ?> 
               </select>                                        
              <select id="<?php echo wp_kses($vtprd_deal_screen_framework['buy_amt_applies_to']['select']['id'] ,$allowed_html); echo wp_kses('2' ,$allowed_html);?>" class="<?php echo wp_kses($vtprd_deal_screen_framework['buy_amt_applies_to']['select']['class'] ,$allowed_html); echo wp_kses('2' ,$allowed_html); echo wp_kses(' hideMe' ,$allowed_html);?>" name="<?php echo wp_kses($vtprd_deal_screen_framework['buy_amt_applies_to']['select']['name'] ,$allowed_html); echo wp_kses('2' ,$allowed_html);?>" tabindex="" >          
                 <?php
                 for($i=0; $i < sizeof($vtprd_deal_screen_framework['buy_amt_applies_to']['option']); $i++) { 
                 ?>                             
                    <option id="<?php echo wp_kses($vtprd_deal_screen_framework['buy_amt_applies_to']['option'][$i]['id'] ,$allowed_html); echo wp_kses('2' ,$allowed_html); ?>"  class="<?php echo wp_kses($vtprd_deal_screen_framework['buy_amt_applies_to']['option'][$i]['class'] ,$allowed_html); echo wp_kses('2' ,$allowed_html); ?>"  value="<?php echo wp_kses($vtprd_deal_screen_framework['buy_amt_applies_to']['option'][$i]['value'] ,$allowed_html); ?>"    ></option>
                 <?php } ?> 
               </select>  
               
             <?php //buy_amt_mod ?>  
              <select id="<?php echo wp_kses($vtprd_deal_screen_framework['buy_amt_mod']['select']['id'] ,$allowed_html); echo wp_kses('1' ,$allowed_html);?>" class="<?php echo wp_kses($vtprd_deal_screen_framework['buy_amt_mod']['select']['class'] ,$allowed_html); echo wp_kses('1' ,$allowed_html); echo wp_kses(' hideMe' ,$allowed_html);?>" name="<?php echo wp_kses($vtprd_deal_screen_framework['buy_amt_mod']['select']['name'] ,$allowed_html); echo wp_kses('1' ,$allowed_html);?>" tabindex="" >          
                 <?php
                 for($i=0; $i < sizeof($vtprd_deal_screen_framework['buy_amt_mod']['option']); $i++) { 
                 ?>                             
                    <option id="<?php echo wp_kses($vtprd_deal_screen_framework['buy_amt_mod']['option'][$i]['id'] ,$allowed_html); echo wp_kses('1' ,$allowed_html); ?>"  class="<?php echo wp_kses($vtprd_deal_screen_framework['buy_amt_mod']['option'][$i]['class'] ,$allowed_html); echo wp_kses('1' ,$allowed_html); ?>"  value="<?php echo wp_kses($vtprd_deal_screen_framework['buy_amt_mod']['option'][$i]['value'] ,$allowed_html); ?>"    ><?php echo wp_kses($vtprd_deal_screen_framework['buy_amt_mod']['option'][$i]['title'] ,$allowed_html); ?></option>
                 <?php } ?> 
               </select>                                        
              <select id="<?php echo wp_kses($vtprd_deal_screen_framework['buy_amt_mod']['select']['id'] ,$allowed_html); echo wp_kses('2' ,$allowed_html);?>" class="<?php echo wp_kses($vtprd_deal_screen_framework['buy_amt_mod']['select']['class'] ,$allowed_html); echo wp_kses('2' ,$allowed_html); echo wp_kses(' hideMe' ,$allowed_html);?>" name="<?php echo wp_kses($vtprd_deal_screen_framework['buy_amt_mod']['select']['name'] ,$allowed_html); echo wp_kses('2' ,$allowed_html);?>" tabindex="" >          
                 <?php
                 for($i=0; $i < sizeof($vtprd_deal_screen_framework['buy_amt_mod']['option']); $i++) { 
                 ?>                             
                    <option id="<?php echo wp_kses($vtprd_deal_screen_framework['buy_amt_mod']['option'][$i]['id'] ,$allowed_html); echo wp_kses('2' ,$allowed_html); ?>"  class="<?php echo wp_kses($vtprd_deal_screen_framework['buy_amt_mod']['option'][$i]['class'] ,$allowed_html); echo wp_kses('2' ,$allowed_html); ?>"  value="<?php echo wp_kses($vtprd_deal_screen_framework['buy_amt_mod']['option'][$i]['value'] ,$allowed_html); ?>"    ></option>
                 <?php } ?> 
               </select>  
             
            <?php //buy_repeat_condition ?>  
              <select id="<?php echo wp_kses($vtprd_deal_screen_framework['buy_repeat_condition']['select']['id'] ,$allowed_html); echo wp_kses('1' ,$allowed_html);?>" class="<?php echo wp_kses($vtprd_deal_screen_framework['buy_repeat_condition']['select']['class'] ,$allowed_html); echo wp_kses('1' ,$allowed_html); echo wp_kses(' hideMe' ,$allowed_html);?>" name="<?php echo wp_kses($vtprd_deal_screen_framework['buy_repeat_condition']['select']['name'] ,$allowed_html); echo wp_kses('1' ,$allowed_html);?>" tabindex="" >          
                 <?php
                 for($i=0; $i < sizeof($vtprd_deal_screen_framework['buy_repeat_condition']['option']); $i++) { 
                 ?>                             
                    <option id="<?php echo wp_kses($vtprd_deal_screen_framework['buy_repeat_condition']['option'][$i]['id'] ,$allowed_html); echo wp_kses('1' ,$allowed_html); ?>"  class="<?php echo wp_kses($vtprd_deal_screen_framework['buy_repeat_condition']['option'][$i]['class'] ,$allowed_html); echo wp_kses('1' ,$allowed_html); ?>"  value="<?php echo wp_kses($vtprd_deal_screen_framework['buy_repeat_condition']['option'][$i]['value'] ,$allowed_html); ?>"    ><?php echo wp_kses($vtprd_deal_screen_framework['buy_repeat_condition']['option'][$i]['title'] ,$allowed_html); ?></option>
                 <?php } ?> 
               </select>                                        
              <select id="<?php echo wp_kses($vtprd_deal_screen_framework['buy_repeat_condition']['select']['id'] ,$allowed_html); echo wp_kses('2' ,$allowed_html);?>" class="<?php echo wp_kses($vtprd_deal_screen_framework['buy_repeat_condition']['select']['class'] ,$allowed_html); echo wp_kses('2' ,$allowed_html); echo wp_kses(' hideMe' ,$allowed_html);?>" name="<?php echo wp_kses($vtprd_deal_screen_framework['buy_repeat_condition']['select']['name'] ,$allowed_html); echo wp_kses('2' ,$allowed_html);?>" tabindex="" >          
                 <?php
                 for($i=0; $i < sizeof($vtprd_deal_screen_framework['buy_repeat_condition']['option']); $i++) { 
                 ?>                             
                    <option id="<?php echo wp_kses($vtprd_deal_screen_framework['buy_repeat_condition']['option'][$i]['id'] ,$allowed_html); echo wp_kses('2' ,$allowed_html); ?>"  class="<?php echo wp_kses($vtprd_deal_screen_framework['buy_repeat_condition']['option'][$i]['class'] ,$allowed_html); echo wp_kses('2' ,$allowed_html); ?>"  value="<?php echo wp_kses($vtprd_deal_screen_framework['buy_repeat_condition']['option'][$i]['value'] ,$allowed_html); ?>"    ></option>
                 <?php } ?> 
               </select>  
              <select id="<?php echo wp_kses($vtprd_deal_screen_framework['buy_repeat_condition']['select']['id'] ,$allowed_html); echo wp_kses('-catalog' ,$allowed_html);?>" class="<?php echo wp_kses($vtprd_deal_screen_framework['buy_repeat_condition']['select']['class'] ,$allowed_html); echo wp_kses('-catalog' ,$allowed_html); echo wp_kses(' hideMe' ,$allowed_html);?>" name="<?php echo wp_kses($vtprd_deal_screen_framework['buy_repeat_condition']['select']['name'] ,$allowed_html); echo wp_kses('-catalog' ,$allowed_html);?>" tabindex="" >          
                 <?php
                 for($i=0; $i < sizeof($vtprd_deal_screen_framework['buy_repeat_condition']['option']); $i++) { 
                                             
                      //pick up the free/pro version of the title 
                      //v2.0.0 removed   $title = $vtprd_deal_screen_framework['buy_repeat_condition']['option'][$i]['title-catalog'];
                
                 ?>                             
                    <option id="<?php echo wp_kses($vtprd_deal_screen_framework['buy_repeat_condition']['option'][$i]['id'] ,$allowed_html); echo wp_kses('-catalog' ,$allowed_html); ?>"  class="<?php echo wp_kses($vtprd_deal_screen_framework['buy_repeat_condition']['option'][$i]['class'] ,$allowed_html); echo wp_kses('-catalog' ,$allowed_html); ?>"  value="<?php echo wp_kses($vtprd_deal_screen_framework['buy_repeat_condition']['option'][$i]['value'] ,$allowed_html); ?>"    ><?php echo wp_kses($title ,$allowed_html); ?></option>
                 <?php } ?> 
               </select>
      
             <?php //action_amt_type ?>  
              <select id="<?php echo wp_kses($vtprd_deal_screen_framework['action_amt_type']['select']['id'] ,$allowed_html); echo wp_kses('1' ,$allowed_html);?>" class="<?php echo wp_kses($vtprd_deal_screen_framework['action_amt_type']['select']['class'] ,$allowed_html); echo wp_kses('1' ,$allowed_html); echo wp_kses(' hideMe' ,$allowed_html);?>" name="<?php echo wp_kses($vtprd_deal_screen_framework['action_amt_type']['select']['name'] ,$allowed_html); echo wp_kses('1' ,$allowed_html);?>" tabindex="" >          
                 <?php
                 for($i=0; $i < sizeof($vtprd_deal_screen_framework['action_amt_type']['option']); $i++) { 
                 ?>                             
                    <option id="<?php echo wp_kses($vtprd_deal_screen_framework['action_amt_type']['option'][$i]['id'] ,$allowed_html); echo wp_kses('1' ,$allowed_html); ?>"  class="<?php echo wp_kses($vtprd_deal_screen_framework['action_amt_type']['option'][$i]['class'] ,$allowed_html); echo wp_kses('1' ,$allowed_html); ?>"  value="<?php echo wp_kses($vtprd_deal_screen_framework['action_amt_type']['option'][$i]['value'] ,$allowed_html); ?>"    ><?php echo wp_kses($vtprd_deal_screen_framework['action_amt_type']['option'][$i]['title'] ,$allowed_html); ?></option>
                 <?php } ?> 
               </select>                                        
              <select id="<?php echo wp_kses($vtprd_deal_screen_framework['action_amt_type']['select']['id'] ,$allowed_html); echo wp_kses('2' ,$allowed_html);?>" class="<?php echo wp_kses($vtprd_deal_screen_framework['action_amt_type']['select']['class'] ,$allowed_html); echo wp_kses('2' ,$allowed_html); echo wp_kses(' hideMe' ,$allowed_html);?>" name="<?php echo wp_kses($vtprd_deal_screen_framework['action_amt_type']['select']['name'] ,$allowed_html); echo wp_kses('2' ,$allowed_html);?>" tabindex="" >          
                 <?php
                 for($i=0; $i < sizeof($vtprd_deal_screen_framework['action_amt_type']['option']); $i++) { 
                 ?>                             
                    <option id="<?php echo wp_kses($vtprd_deal_screen_framework['action_amt_type']['option'][$i]['id'] ,$allowed_html); echo wp_kses('2' ,$allowed_html); ?>"  class="<?php echo wp_kses($vtprd_deal_screen_framework['action_amt_type']['option'][$i]['class'] ,$allowed_html); echo wp_kses('2' ,$allowed_html); ?>"  value="<?php echo wp_kses($vtprd_deal_screen_framework['action_amt_type']['option'][$i]['value'] ,$allowed_html); ?>"    ></option>
                 <?php } ?> 
               </select> 
               
            <?php //inPop ?>  
              <select id="<?php echo wp_kses($vtprd_rule_display_framework['inPop']['select']['id'] ,$allowed_html); echo wp_kses('1' ,$allowed_html);?>" class="<?php echo wp_kses($vtprd_rule_display_framework['inPop']['select']['class'] ,$allowed_html); echo wp_kses('1' ,$allowed_html); echo wp_kses(' hideMe' ,$allowed_html);?>" name="<?php echo wp_kses($vtprd_rule_display_framework['inPop']['select']['name'] ,$allowed_html); echo wp_kses('1' ,$allowed_html);?>" tabindex="" >          
                 <?php
                 for($i=0; $i < sizeof($vtprd_rule_display_framework['inPop']['option']); $i++) { 
                                             
                      //pick up the free/pro version of the title 
                      $title = $vtprd_rule_display_framework['inPop']['option'][$i]['title'];
                      if ( ( defined('VTPRD_PRO_DIRNAME') ) &&
                           ( isset($vtprd_rule_display_framework['inPop']['option'][$i]['title3'] ) ) &&    //v2.0.3
                           ( $vtprd_rule_display_framework['inPop']['option'][$i]['title3'] > ' ' ) ) {
                        $title = $vtprd_rule_display_framework['inPop']['option'][$i]['title3'];                        
                      }                  
                 ?>                             
                    <option id="<?php echo wp_kses($vtprd_rule_display_framework['inPop']['option'][$i]['id'] ,$allowed_html); echo wp_kses('1' ,$allowed_html); ?>"  class="<?php echo wp_kses($vtprd_rule_display_framework['inPop']['option'][$i]['class'] ,$allowed_html); echo wp_kses('1' ,$allowed_html); ?>"  value="<?php echo wp_kses($vtprd_rule_display_framework['inPop']['option'][$i]['value'] ,$allowed_html); ?>"    ><?php echo wp_kses($title ,$allowed_html); ?></option>
                 <?php } ?> 
               </select>                                        
              <select id="<?php echo wp_kses($vtprd_rule_display_framework['inPop']['select']['id'] ,$allowed_html); echo wp_kses('2' ,$allowed_html);?>" class="<?php echo wp_kses($vtprd_rule_display_framework['inPop']['select']['class'] ,$allowed_html); echo wp_kses('2' ,$allowed_html); echo wp_kses(' hideMe' ,$allowed_html);?>" name="<?php echo wp_kses($vtprd_rule_display_framework['inPop']['select']['name'] ,$allowed_html); echo wp_kses('2' ,$allowed_html);?>" tabindex="" >          
                 <?php
                 for($i=0; $i < sizeof($vtprd_rule_display_framework['inPop']['option']); $i++) { 
                                             
                      //pick up the free/pro version of the title 
                      $title = $vtprd_rule_display_framework['inPop']['option'][$i]['title2'];
                      if ( ( defined('VTPRD_PRO_DIRNAME') ) &&
                           ( isset($vtprd_rule_display_framework['inPop']['option'][$i]['title4'] ) ) &&    //v2.0.3
                           ( $vtprd_rule_display_framework['inPop']['option'][$i]['title4'] > ' ' ) ) {
                        $title = $vtprd_rule_display_framework['inPop']['option'][$i]['title4'];                        
                      }                   
                 ?>                             
                    <option id="<?php echo wp_kses($vtprd_rule_display_framework['inPop']['option'][$i]['id'] ,$allowed_html); echo wp_kses('2' ,$allowed_html); ?>"  class="<?php echo wp_kses($vtprd_rule_display_framework['inPop']['option'][$i]['class'] ,$allowed_html); echo wp_kses('2' ,$allowed_html); ?>"  value="<?php echo wp_kses($vtprd_rule_display_framework['inPop']['option'][$i]['value'] ,$allowed_html); ?>"    ><?php echo wp_kses($title ,$allowed_html); ?></option>
                 <?php } ?> 
               </select>  
                 
             <?php //specChoice_in ?>  
              <select id="<?php echo wp_kses($vtprd_rule_display_framework['specChoice_in']['select']['id'] ,$allowed_html); echo wp_kses('1' ,$allowed_html);?>" class="<?php echo wp_kses($vtprd_rule_display_framework['specChoice_in']['select']['class'] ,$allowed_html); echo wp_kses('1' ,$allowed_html); echo wp_kses(' hideMe' ,$allowed_html);?>" name="<?php echo wp_kses($vtprd_rule_display_framework['specChoice_in']['select']['name'] ,$allowed_html); echo wp_kses('1' ,$allowed_html);?>" tabindex="" >          
                 <?php
                 for($i=0; $i < sizeof($vtprd_rule_display_framework['specChoice_in']['option']); $i++) { 
                 ?>                             
                    <option id="<?php echo wp_kses($vtprd_rule_display_framework['specChoice_in']['option'][$i]['id'] ,$allowed_html); echo wp_kses('1' ,$allowed_html); ?>"  class="<?php echo wp_kses($vtprd_rule_display_framework['specChoice_in']['option'][$i]['class'] ,$allowed_html); echo wp_kses('1' ,$allowed_html); ?>"  value="<?php echo wp_kses($vtprd_rule_display_framework['specChoice_in']['option'][$i]['value'] ,$allowed_html); ?>"    ><?php echo wp_kses($vtprd_rule_display_framework['specChoice_in']['option'][$i]['title'] ,$allowed_html); ?></option>
                 <?php } ?> 
               </select>                                        
              <select id="<?php echo wp_kses($vtprd_rule_display_framework['specChoice_in']['select']['id'] ,$allowed_html); echo wp_kses('2' ,$allowed_html);?>" class="<?php echo wp_kses($vtprd_rule_display_framework['specChoice_in']['select']['class'] ,$allowed_html); echo wp_kses('2' ,$allowed_html); echo wp_kses(' hideMe' ,$allowed_html);?>" name="<?php echo wp_kses($vtprd_rule_display_framework['specChoice_in']['select']['name'] ,$allowed_html); echo wp_kses('2' ,$allowed_html);?>" tabindex="" >          
                 <?php                                               
                 for($i=0; $i < sizeof($vtprd_rule_display_framework['specChoice_in']['option']); $i++) { 
                 ?>                             
                    <option id="<?php echo wp_kses($vtprd_rule_display_framework['specChoice_in']['option'][$i]['id'] ,$allowed_html); echo wp_kses('2' ,$allowed_html); ?>"  class="<?php echo wp_kses($vtprd_rule_display_framework['specChoice_in']['option'][$i]['class'] ,$allowed_html); echo wp_kses('2' ,$allowed_html); ?>"  value="<?php echo wp_kses($vtprd_rule_display_framework['specChoice_in']['option'][$i]['value'] ,$allowed_html); ?>"    ><?php echo wp_kses($vtprd_rule_display_framework['specChoice_in']['option'][$i]['title2'] ,$allowed_html); ?></option>
                 <?php } ?> 
               </select>  
                          
   <?php         
  } 



    //******************************
    //v1.1.8.1  New Function
    //******************************
    public  function vtprd_ajax_clone_rule() {
      //global $post, $vtprd_rule, $vtprd_rules_set, $vtprd_setup_options; 
      global $post;
      $allowed_html = vtprd_get_allowed_html(); //v2.0.3
      
      //error_log( print_r(  'Function begin - vtprd_ajax_clone_rule', true ) ); 
      
      $clone_from_ruleID  = sanitize_text_field( $_POST['ajaxRuleID'] );
      if (!$clone_from_ruleID) {    
         $message = '<div id="ajaxCloneRuleMsg">' . __('Pricing Deal Rule *Clone Action* Failed. The clone-from rule ID not supplied.', 'vtprd') .  '</div>';
         echo wp_kses($message ,$allowed_html); //v2.0.3
         exit; 
      }
            
      $post = get_post($clone_from_ruleID);

      //'clone XX of rule ID YYYY'  
      if ( ($post) &&
           ($post->post_title > ' ' ) &&
           ($post->post_status == 'publish') ) {
        $carry_on = true;
      } else {     
         $message = '<div id="ajaxCloneRuleMsg">' . __('Pricing Deal Rule *Clone Action* Failed. The clone-from rule must be Published, in order to use the Clone button.', 'vtprd') .  '</div>';
         echo wp_kses($message ,$allowed_html); //v2.0.3
         exit; 
      }

      //get ruleset
      //v2.1.0 begin - PHP 8.0 was kicking this out as a non-array
      //$vtprd_rules_set   = get_option( 'vtprd_rules_set' ) ;
      $vtprd_rules_set = vtprd_get_rules_set();
      $sizeof_rules_set = is_array($vtprd_rules_set) ? sizeof($vtprd_rules_set) : 0; //v2.1.0  
      if ($sizeof_rules_set == 0) {
         $message = '<div id="ajaxCloneRuleMsg">' . __('Pricing Deal Rule *Clone Action* Failed. The clone-from rule no longer exists.', 'vtprd') .  '</div>';
         echo wp_kses($message ,$allowed_html); //v2.0.3        
         exit; 
      } 
      //v2.1.0 end 
      
      //NEED to STASH the current ruleset in the OPTION table
      //since when we store the new cloned rule, the ruleset gets clobbered by the normal Pricing Deals update catcher...
      //v2.1.0 begin - PHP 8.0 was kicking this out as a non-array
      $vtprd_rules_set_array   = serialize($vtprd_rules_set);  
      if (get_option( 'vtprd_clone_rules_set' )) {
        update_option( 'vtprd_clone_rules_set',$vtprd_rules_set_array );
      } else {
        add_option( 'vtprd_clone_rules_set',$vtprd_rules_set_array );
      }
      //v2.1.0 end

      //Find rule
      $rule_found = false;
       //$sizeof_rules_set = sizeof($vtprd_rules_set);  //v2.1.0
      //$sizeof_rules_set = is_array($vtprd_rules_set) ? sizeof($vtprd_rules_set) : 0; //v2.1.0  - MOVED ABOVE
      for($i=0; $i < $sizeof_rules_set; $i++) {       
         if ($vtprd_rules_set[$i]->post_id == $post->ID) {
            $hold_vtprd_rule = $vtprd_rules_set[$i];
            $rule_found = true;
            break;
         }
      }
      
      //clone-from rule NOT FOUND! 
      if (!$rule_found) {;
         $message = '<div id="ajaxCloneRuleMsg">' . __('Pricing Deal Rule *Clone Action* Failed. The clone-from rule no longer exists.', 'vtprd') .  '</div>';
         echo wp_kses($message ,$allowed_html); //v2.0.3        
         exit;     
      }
      
      //set an option to be read during the Pricing Deals update catcher
      //removed at end of this function (can't use session var, for some reason...)
      add_option('vtprd_clone_in_process_skip_upd_rule', 'yes');  

      //cloned rules are pending only   
      //add 'clone XX of rule ID YYYY'  to title 
      $cloneNum = maybe_unserialize(get_post_meta($post->ID, '_cloneNum'));     //maybe_unserialize is a WP function  
      
      if ($cloneNum) {
        if (is_array($cloneNum)) {
          $cloneNum = $cloneNum[0]; //unfortunately, the number is often stored as an array!!!!!!
        }
        $cloneNum++;
        update_post_meta($post->ID, '_cloneNum', $cloneNum );         
      } else {
        $cloneNum = 1;
        add_post_meta($post->ID, '_cloneNum', $cloneNum, true );      
      }
      
      $dateTime = date("Y-m-d H:i:s");
      $my_post = array(
           'post_title' => $post->post_title . ' - Clone ' .$cloneNum. ' of Rule ID ' .$post->ID ,
           'post_date' => $dateTime,    //v2.0.3  - sanitize_text_field($_SESSION['cal_startdate']),   changed to date function
           'post_date_gmt' => $dateTime,    //v2.0.3 
           'post_content' => 'cloned rule.',
           'post_status' => 'pending',
           'post_type' => 'vtprd-rule' 
        );

      $new_post_id = wp_insert_post(wp_slash($my_post));

      $vtprd_rule      = $hold_vtprd_rule;
      $vtprd_rule->post_id = $new_post_id;
      $vtprd_rule->rule_status = 'pending';
      $vtprd_rule->rule_updated_with_free_version_number =  VTPRD_VERSION; //v2.0.0
       
      //get previously saved option copy - from the  STASH of the current ruleset in the OPTION table
      //since when we store the new cloned rule, the ruleset gets clobbered by the normal Pricing Deals update catcher...
      
        //v2.1.0 begin - PHP 8.0 was kicking this out as a non-array
        //$vtprd_rules_set = get_option('vtprd_clone_rules_set'); 
        $vtprd_rules_set_array   = get_option( 'vtprd_clone_rules_set' );  
        If ($vtprd_rules_set_array) {
        	$vtprd_rules_set   = unserialize($vtprd_rules_set_array);
        }
        //v2.1.0 end

      $vtprd_rules_set[] = $vtprd_rule;
            
      //v2.1.0 begin - PHP 8.0 was kicking this out as a non-array
      //update_option( 'vtprd_rules_set', $vtprd_rules_set );
      vtprd_set_rules_set($vtprd_rules_set);
      //v2.1.0 end  
           
      //clean up 
      delete_option('vtprd_clone_in_process_skip_upd_rule'); 
      delete_option('vtprd_clone_rules_set');
      
       $message = '<div id="ajaxCloneRuleMsg">' . __('Pricing Deal Rule Clone Completed.', 'vtprd') .  '</div>';
       echo wp_kses($message ,$allowed_html); //v2.0.3 
              
      $post = get_post($clone_from_ruleID);
      
      //error_log( print_r(  '$vtprd_rules_set AT BOTTOM', true ) );
      //error_log( var_export($vtprd_rules_set, true ) );  
 
  	exit;
  }

    //********************************
    //* v2.0.0  NEW Function
    //********************************
    public function vtprd_stringify_var_name_array($varName_array) {
       global $vtprd_info; 
       
       if ($varName_array <= ' ') {                    
          return;
       }
 
 
       
       // large|red+extra large|blue (*full* variation name[s], separated by: | AND combined by: + )
       $varName_string = null;
       $varName_count = 0;
       foreach ($varName_array as $varName) {
        
        if ($varName_count > 0) {
          $varName_string .= '|';
        }
        $varName_combo_count = 0;
        foreach ($varName as $varName_combo) {
          if ($varName_combo_count > 0) {
            $varName_string .= '+';
          }
          $varName_string .= $varName_combo;
          $varName_combo_count++;
        }

        $varName_count++;
      }
      
      if ($varName_count == 0) {
        return;
      }
      
      return $varName_string;
  }

    //********************************
    //* v2.0.0  NEW Function
    //********************************
    public function vtprd_ajax_do_product_selector() {
      global $wpdb, $post, $vtprd_rule;
      //error_log( print_r(  'Function vtprd_ajax_do_product_selector BEGIN', true ) ); 

      $data = array();
      
      //******************
      //v2.0.3 begin - if structure to do the sanitize correctly
      if (isset( $_GET['term'] )) {
         $action = vtprd_sanitize_text_or_array_field( $_GET['term'] );
         if (!$action) {  //if nothing left after sanitize
            wp_die();
         }
      } else {
         //$action = false;
         wp_die(); //no need to go further, if term is not supplied
      }     
      //$search = wc_clean( empty( $term ) ? stripslashes( $_GET['term'] ) : $term );
      $search = wc_clean( empty( $term ) ? stripslashes( $action ) : $term ); 
      //v2.0.3 end
      //******************
          
      //error_log( print_r(  'SEARCH term 002 = ' .$search, true ) );   
               
      //v2.0.3 begin -  user input needs to be properly escaped
      //$search = '%'.$search.'%';     
      $search = esc_sql('%'.$wpdb->esc_like($search).'%');
      //v2.0.3 end
           
      $post_status_publish = 'publish';
      
      //v2.0.0.5 begin
      // only works with PRO
      //similar code ALSO in vtprd-parent-definitions.php , so that the new post_type is also added to Pricing Deal Category
      /*
         	If added PRODUCT type from additional Plugins needed
          Find all the Product types needed in your additional plugins, by searching for: "register_post_type".
          In the "return" statement below, string them together as the example suggests
           - return ('product-type1'); for 1
           - return ('product-type1','product-type2' etc ); for more than 1
           
        	//add the 'add_filter...' statement to your theme/child-theme functions.php file 
        	add_filter( 'vtprd_use_additional_product_type', function() { return (array('product-type1','product-type2')); } ); 
          
          THIS FILTER will add your added PRODUCT type to BOTH the PRODUCT selector AND the Pricing Deal Category selector
          - so if you want a group of products to be included in a rule, you can either list them in the PRODUCT selector,
          or make sure they participate in a Pricing Deal Category, which is then selected in your desired rule.
       */  
      $product_type_array = array('product', 'product_variation');    
      if (apply_filters('vtprd_use_additional_product_type',FALSE )) { 
        $additional_product_types = apply_filters('vtprd_use_additional_product_type',FALSE );
        /*
        foreach ($additional_product_types as $key => $additional_product_type) {
           $product_type_array[] = $additional_product_type;
        }
        */
        $product_type_array = array_merge($product_type_array,$additional_product_types);
      }     
    //v2.0.0.6 begin doesn't work with array!!!!  must be a comma separated list with quotes around each item
    //$sql = "SELECT `ID`, `post_title`, `post_type`  FROM `" . $wpdb->prefix . "posts`  WHERE `post_title` LIKE '" . $search . "' AND `post_status` =  '" . $post_status_publish . "'    AND `post_type` IN ( 'product', 'product_variation' )  ORDER BY `post_title` ASC";                         	      
    //$sql = "SELECT `ID`, `post_title`, `post_type`  FROM `" . $wpdb->prefix . "posts`  WHERE `post_title` LIKE '" . $search . "' AND `post_status` =  '" . $post_status_publish . "'    AND `post_type` IN  '" . $product_type_array . "'   ORDER BY `post_title` ASC";
    //v2.0.0.6 end
      //v2.0.0.5 end
        
      //v2.0.3 begin
      //$sql = "SELECT `ID`, `post_title`, `post_type`  FROM `" . $wpdb->prefix . "posts`  WHERE `post_title` LIKE '" . $search . "' AND `post_status` =  '" . $post_status_publish . "'    AND `post_type` IN ( 'product', 'product_variation' )  ORDER BY `post_title` ASC";                         	      
      $sql = $wpdb->prepare( "SELECT `ID`, `post_title`, `post_type`  FROM `" . $wpdb->prefix . "posts`  WHERE `post_title` 
            LIKE %s AND `post_status` = %s  AND `post_type` IN ( 'product', 'product_variation' )  ORDER BY `post_title` ASC",                         	      
            $search,
            $post_status_publish
            );  
      //v2.0.3 end      
               
      $products_array = $wpdb->get_results($sql,ARRAY_A) ; 
      
      $sizeof_products = is_array($products_array) ? sizeof($products_array) : 0; //v2.1.0             
      //if(sizeof($products_array) > 0){
      if ($sizeof_products > 0){
        foreach ($products_array as $key => $product_row) {
           $product = wc_get_product($product_row['ID']);
           $product_name = wp_kses_post( $product->get_formatted_name() );
           //v2.0.3 begin
           //T$product->get_formatted_name() now introduces '<span class="description"></span>' after the name during ajax, which does not display well with ajax.
           //remove **only** in ajax.
           $product_name = str_replace('<span class="description"></span>', '', $product_name ?? '' );   //v2.0.3 added  ?? '' 
           //v2.0.3 end
           if (vtprd_test_for_variations($product_row['ID'])) {
            $product_name .= '&nbsp; [all variations] ';
           }            
	       $prodID = $product_row['ID'];
           $data[$prodID] = $product_name;			 	
        } 
      } else {
           $data[1] = 'No Products Found';              
      }      
       //error_log( print_r(  '$data after PRODUCT search, before escape', true ) );
       //error_log( var_export($data, true ) );  
      
      $data =  vtprd_escape_text_or_array_field($data); //v2.0.3 
       
       //error_log( print_r(  '$data after PRODUCT search, after escape', true ) );
       //error_log( var_export($data, true ) );        
      
      wp_send_json( $data );
      
      die();
  }


    //********************************
    //* v2.0.0  NEW Function
    //********************************
    public function vtprd_ajax_do_customer_selector() {
      global $wpdb, $post, $vtprd_rule, $vtprd_info;
      //copied from woocommerce class-wc-ajax.php
      //error_log( print_r(  'Function vtprd_ajax_do_customer_selector BEGIN', true ) );

      //******************
      //v2.0.3 begin - if structure to do the sanitize correctly
      if (isset( $_GET['term'] )) {
         $action = vtprd_sanitize_text_or_array_field( $_GET['term'] );
         if (!$action) {  //if nothing left after sanitize
            wp_die();
         }
      } else {
         //$action = false;
         wp_die(); //no need to go further, if term is not supplied
      }     
      $search = wc_clean( empty( $term ) ? stripslashes( $action ) : $term ); 
  
	  //if ( ! $search = wc_clean( stripslashes( $_GET['term'] ) ) ) {
		//wp_die();
	  //}
                
      //v2.0.3 end
      //******************

        
      
      //error_log( print_r(  'Search term= ' .$search, true ) );
            
  		$found_customers = array();
            
      //v2.0.3 begin -  user input needs to be properly escaped
      //$search = '%'.$search.'%';  //add these for 'LIKE'
      $search = esc_sql('%'.$wpdb->esc_like($search).'%');
      //v2.0.3 end
        
            
     
      //manual access, as 'get_terms' changed over history, AND has a problem with the custom taxonomy
      
      //v2.0.3 begin
      //$sql = "SELECT *  FROM `" . $wpdb->prefix . "users` as users  WHERE  users.`user_email`  LIKE '" . $search . "'  OR users.`display_name`  LIKE '" . $search . "' ORDER BY users.`user_email` ASC";                         
      $sql = $wpdb->prepare( "SELECT *  FROM `" . $wpdb->prefix . "users` as users  WHERE  users.`user_email`  
             LIKE %s  OR users.`display_name`  LIKE %s ORDER BY users.`user_email` ASC",
             $search,
             $search                         
            );  
      //v2.0.3 end

 
      $terms = $wpdb->get_results($sql,ARRAY_A) ;
      
       //error_log( print_r(  '$terms after customer search', true ) );
       //error_log( var_export($terms, true ) );       
      
      $sizeof_terms = is_array($terms) ? sizeof($terms) : 0; //v2.1.0
      //if (sizeof($terms) > 0){
      if ($sizeof_terms > 0){
		foreach ( $terms as $term ) {
			$email_and_name = $term['user_email'] .' ('. $term['display_name'] .')';
            $found_customers[ $term['ID'] ] = $email_and_name;
		}
  	  } else {
        $found_customers[1] = 'No Customers Found';              
      }  
          
       //error_log( print_r(  '$found_customers', true ) );
       //error_log( var_export($found_customers, true ) );  
      
      $found_customers =  vtprd_escape_text_or_array_field($found_customers); //v2.0.3       
      wp_send_json( $found_customers);
      
      die();
  } 
      
      
} //end class
