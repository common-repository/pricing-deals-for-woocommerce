<?php
 /*                                
v2.0.0 new entries:

Products that the deal will be applied to, or that need to be in the cart in order for the discount to be applied.

List of allowed emails to check against the customer billing email when an order is placed. Separate email addresses with commas.

Products that the coupon will not be applied to, or that cannot be in the cart in order for the "Fixed cart discount" to be applied.

'AND' message:
"AND" ONE of entries in the Role, Email, Groups or Membership Lists MUST be satisfied, in order for the discount to be applied.

"AND" Rule example - "Buy 3 of Category X and logged as Wholesale, get a discount"

"OR" = Entries in the Role, Email, Groups or Membership Lists that the deal can be applied to.

          "AND" ONE of entries in the Role, Email, Groups or Membership Lists MUST be satisfied, in order for the discount to be applied.
          <br>
          "AND" Rule example - "Buy 3 of Category X and logged as Wholesale, get a discount" 
        <div class="andSelected  clear-left">
          "AND" ONE of entries in the Role, Email, Groups or Membership Lists MUST be satisfied, in order for the discount to be applied.
          <br>
          "AND" Rule example - "Buy 3 of Category X and logged as Wholesale, get a discount" 
        </div>
        <div class="orSelected  clear-left">"OR" = Entries in the Role, Email, Groups or Membership Lists that the deal can be applied to.</div>
        
        that the deal will may be applied to
        
buy_group_prod_cat_incl
buy_group_prod_cat_excl
buy_group_plugin_cat_incl
buy_group_plugin_cat_excl
buy_group_product_incl
buy_group_product_excl
buy_group_var_name_incl
buy_group_var_name_excl
buy_group_brands_incl
buy_group_brands_excl

** in the INCLUDE doc, have the 'include' and 'required' message both here
** and use JS to test the and/or radio buttons to show/hide the correct message!

buy_group_role_incl
buy_group_role_excl
buy_group_email_incl
buy_group_email_excl
buy_group_groups_incl
buy_group_groups_excl
buy_group_memberships_incl
buy_group_memberships_excl


action_group_prod_cat_incl
action_group_prod_cat_excl
action_group_plugin_cat_incl
action_group_plugin_cat_excl
action_group_product_incl
action_group_product_excl
action_group_var_name_incl
action_group_var_name_excl
action_group_brands_incl
action_group_brands_excl
 */
            
  //************************************************  
  // Help panel for Pricing Deal Screen
  //************************************************ 
  function vtprd_show_help_selection_panel_0() {  
    global $vtprd_setup_options, $vtprd_rule_template_framework, $vtprd_deal_screen_framework;
    $onclick_data1 = "javascript:void window.open('" .esc_url(VTPRD_ADMIN_URL.'edit.php?post_type=vtprd-rule&page=vtprd_show_help_page')."','1375122357919','width=1200,height=500,toolbar=0,menubar=0,location=1,status=1,scrollbars=1,resizable=1,left=0,top=0');return false;";   //v2.0.3
    $onclick_data2 = "javascript:void(0);" . '><img class="close-button" alt="help"  width="16" height="16" src="' .esc_url(VTPRD_URL.'/admin/images/close-icon.png') .'"'; //v2.0.3
  ?>           
    <div class="selection-panel selection-panel-0" id="selection-panel-0" >                                
      <span class="selection-panel-label label"><strong><?php esc_attr_e('Tell me about Pricing Deals', 'vtprd');?></strong></span>  
      <a id="open-help-in-new-window"  href="<?php echo esc_url(VTPRD_ADMIN_URL.'edit.php?post_type=vtprd-rule&page=vtprd_show_help_page');?>" onclick=<?php esc_js($onclick_data1)?> > Open "Help" in a Separate Window</a> 
      <a class="selection-panel-close selection-panel-close-0" href=<?php esc_js($onclick_data2)?> /></a>                      
  		<span class="selection-panel-text" >
        <span class="selection-panel-text-info">
        
        <?php
          vtprd_show_help_panel_0_text();
        ?>
       
        </span>
      </span> 
      <a class="selection-panel-close  clear-left selection-panel-close-0" href="<?php echo esc_js("javascript:void(0);");?>" ><img class="close-button" alt="help"  width="16" height="16" src="<?php echo esc_url(VTPRD_URL.'/admin/images/close-icon.png');?>" /></a>
    </div>       
<?php 
   return;  
  }   
  //************************************************
  // General Introduction and outline, in clickable FAQ format
  //************************************************  
  function vtprd_show_help_panel_0_text() {               
       $allowed_html = vtprd_get_allowed_html(); //v2.0.3
      ?>      
      <span class="textarea vtprd-intro-info">         
          <h4 id="vtprd-test-warning"><?php esc_attr_e('**Always Test the Heck out of a Rule** before Releasing it into the Wild!', 'vtprd');?>
              <a id="pricing-deal-examples-more2" class="more-anchor" href="<?php echo esc_js("javascript:void(0);");?>"><?php esc_attr_e(' Pricing Deal Examples ', 'vtprd'); ?><img class="plus-button" alt="help" height="14px" width="14px" src="<?php echo esc_url(VTPRD_URL.'/admin/images/plus-toggle2.png');?>" /></a>            
              <a id="pricing-deal-examples-less2" class="more-anchor less-anchor" href="<?php echo esc_js('javascript:void(0);');?>"><?php esc_attr_e('   Less Examples ...', 'vtprd'); ?><img class="minus-button" alt="help" height="14px" width="14px" src="<?php echo esc_url(VTPRD_URL.'/admin/images/minus-toggle2.png');?>" /></a>              
          </h4> 
             <?php vtprd_show_help_selection_panel_5(); ?>
          <h4 id="vtprd-discount-out-of-the-box"><?php esc_attr_e('Plugin Works Out of the Box!', 'vtprd');?> 
             <a id="vtprd-info1-help6" class="info-doc-anchor" href="<?php echo esc_js('javascript:void(0);');?>" ><?php esc_attr_e('More Info', 'vtprd');?></a>
             &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
             <a id="vtprd-info1-help-all" class="info-help-anchor" href="<?php echo esc_js('javascript:void(0);');?>" ><span><?php esc_attr_e('Show All', 'vtprd'); ?></span></a>              
             <a id="discount-shortcodes-more2" class="more-anchor" href="<?php echo esc_js('javascript:void(0);');?>"><?php esc_attr_e('Add Pricing Deal Messages to your Theme using Shortcodes! ', 'vtprd'); ?>&nbsp;<img class="plus-button" alt="help" height="10px" width="10px" src="<?php echo esc_url(VTPRD_URL.'/admin/images/plus-toggle2.png');?>" /></a>            
             <a id="discount-shortcodes-less2" class="more-anchor less-anchor" href="<?php echo esc_js('javascript:void(0);');?>"><?php esc_attr_e('  Less Shortcodes Help ... ', 'vtprd'); ?>&nbsp;<img class="minus-button" alt="help" height="12px" width="12px" src="<?php echo esc_url(VTPRD_URL.'/admin/images/minus-toggle2.png');?>" /></a>          
          </h4>
              <?php vtprd_show_help_selection_panel_4(); ?>
          <ul id="vtprd-info1-help6-text" class="vtprd-info1-help-text">
            <li><?php esc_attr_e('- Just Create a Rule, of either Realtime or Cart type', 'vtprd');?> </li>
            <li><?php esc_attr_e('- Realtime pricing discounts will be applied to the product automatically when the product is displayed, in response to a Realtime rule', 'vtprd');?> </li>
            <li><?php esc_attr_e('- Cart Rule discounts will be automatically shown in detail at checkout, and all Cart discounts applied ', 'vtprd'); echo wp_kses('&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;' ,$allowed_html ); esc_attr_e('(lots of checkout settings ', 'vtprd');?>  
              <?php  echo wp_kses('<a href="' ,$allowed_html ) . admin_url( 'edit.php?post_type=vtprd-rule&page=vtprd_setup_options_page#vtprd-checkout-reporting-anchor' ) .  wp_kses('">' ,$allowed_html ). esc_attr_e( 'options', 'vtprd' ) . wp_kses('</a>)' ,$allowed_html );
              ?>
            </li>
          </ul>

                
          <h4 id="vtprd-discount-type"><?php esc_attr_e('When are Discounts Applied?', 'vtprd'); echo wp_kses('&nbsp;=>&nbsp;' ,$allowed_html ); esc_attr_e(' Realtime or in the Cart', 'vtprd');?>
            <a id="vtprd-info1-help0" class="info-doc-anchor" href="<?php echo esc_js('javascript:void(0);');?>" ><?php esc_attr_e('More Info', 'vtprd');?></a>
            <a id="discount-amt-info-more2" class="more-anchor" href="<?php echo esc_js('javascript:void(0);');?>"><?php esc_attr_e('Checkout How-to', 'vtprd'); echo wp_kses('&nbsp;-&nbsp;' ,$allowed_html ); esc_attr_e('Discounts Work out of the Box ', 'vtprd'); ?>&nbsp;<img class="plus-button" alt="help" height="10px" width="10px" src="<?php echo esc_url(VTPRD_URL.'/admin/images/plus-toggle2.png');?>" /></a>            
            <a id="discount-amt-info-less2" class="more-anchor less-anchor" href="<?php echo esc_js('javascript:void(0);');?>"><?php esc_attr_e('  Less Checkout Discount Display Help ... ', 'vtprd'); ?>&nbsp;<img class="minus-button" alt="help" height="12px" width="12px" src="<?php echo esc_url(VTPRD_URL.'/admin/images/minus-toggle2.png');?>" /></a>                        
          </h4>
          <?php vtprd_show_help_selection_panel_1(); ?>
          <ul id="vtprd-info1-help0-text" class="vtprd-info1-help-text">
            <li><?php esc_attr_e('Realtime Type - acts when the catalog displays, and the product price is automatically reduced => often used for Membership or Wholesaler discounts / Discount prices for logged in users', 'vtprd');?> </li>
            <li><?php esc_attr_e('Add-to-Cart Type - acts when the product is added to cart', 'vtprd');?> </li>
          </ul>

          <h4 id="vtprd-discount-rules"><?php esc_attr_e('Discount Rule Info', 'vtprd');?>
            <a id="vtprd-info1-help1" class="info-doc-anchor" href="<?php echo esc_js('javascript:void(0);');?>" ><?php esc_attr_e('More Info', 'vtprd');?></a>
            <a id="discount-msgs-install-more2" class="more-anchor" href="<?php echo esc_js('javascript:void(0);');?>"><?php esc_attr_e('Cart Widget How-to', 'vtprd'); echo wp_kses('&nbsp;-&nbsp;' ,$allowed_html ); esc_attr_e('Add All Pricing Deal Discounts ', 'vtprd'); ?>&nbsp;<img class="plus-button" alt="help" height="10px" width="10px" src="<?php echo esc_url(VTPRD_URL.'/admin/images/plus-toggle2.png');?>" /></a>            
            <a id="discount-msgs-install-less2" class="more-anchor less-anchor" href="<?php echo esc_js('javascript:void(0);');?>"><?php esc_attr_e('  Less Cart Widget Install Help ... ', 'vtprd'); ?>&nbsp;<img class="minus-button" alt="help" height="12px" width="12px" src="<?php echo esc_url(VTPRD_URL.'/admin/images/minus-toggle2.png');?>" /></a>                                    
          </h4>
          <?php vtprd_show_help_selection_panel_3(); ?>           
          <ul id="vtprd-info1-help1-text" class="vtprd-info1-help-text">
            <li><?php esc_attr_e('Rule Types [Realtime and Cart]', 'vtprd');?> </li>
            <li><?php esc_attr_e('Rule Templates - Refine the capability used by each Rule by Deal Type chosen', 'vtprd');?> 
              <ul>
                <li><?php esc_attr_e('Basic Rule Structure - "Buy 1 Get 1"', 'vtprd');?> </li>
                <li><?php esc_attr_e('Define the basics', 'vtprd');?>
                  <ul>
                    <li><?php esc_attr_e('"Buy" group and "Get" Group', 'vtprd');?> 
                      <ul>
                        <li><?php esc_attr_e('By Product Category ,  Pricing Deal Custom Taxonomy Category, Wholesaler / Membership / Discount Levels for logged in users, Product ID, Variation', 'vtprd');?></li> 
                      </ul>
                    </li>
                    <li><?php esc_attr_e('Discount type and amount', 'vtprd');?> </li>
                    <li><?php esc_attr_e('Enter a Theme Deal description message and Checkout (short) Deal Message', 'vtprd');?> </li>
                    <li><?php esc_attr_e('Enter begin/end dates', 'vtprd');?> </li>
                  </ul>
                </li>
                <li><?php esc_attr_e('Rule exclusion - Available at the product level, on the product page', 'vtprd');?></li>
              </ul>
            </li>
          </ul>

          <h4 id="vtprd-discount-rules"><?php esc_attr_e('Display Theme Messages and Info', 'vtprd');?>
            <a id="vtprd-info1-help2" class="info-doc-anchor" href="<?php echo esc_js('javascript:void(0);');?>" ><?php esc_attr_e('More Info', 'vtprd');?></a>
            <a id="discount-msgs-info-more2" class="more-anchor" href="<?php echo esc_js('javascript:void(0);');?>"><?php esc_attr_e('Add "You Save" and "Old Price" Realtime Rule Info to your Theme ', 'vtprd'); ?>&nbsp;<img class="plus-button" alt="help" height="10px" width="10px" src="<?php echo esc_url(VTPRD_URL.'/admin/images/plus-toggle2.png');?>" /></a>            
            <a id="discount-msgs-info-less2" class="more-anchor less-anchor" href="<?php echo esc_js('javascript:void(0);');?>"><?php esc_attr_e('  Less Realtime Messages Use Help ... ', 'vtprd'); ?>&nbsp;<img class="minus-button" alt="help" height="12px" width="12px" src="<?php echo esc_url(VTPRD_URL.'/admin/images/minus-toggle2.png');?>" /></a>
          </h4>
          <?php vtprd_show_help_selection_panel_2(); ?> 
          <ul id="vtprd-info1-help2-text" class="vtprd-info1-help-text">
            <li><?php esc_attr_e('Discount Deal Rule Messages displayed in Theme', 'vtprd');?>
               <ul>
                <li><?php esc_attr_e('Via Shortcode', 'vtprd');?> 
                  <ul>
                    <li><?php esc_attr_e('3 different kinds of shortcode, with parameters for whole store, deals by category, product etc', 'vtprd');?></li>
                  </ul>
                </li>
              </ul>
            </li>
            <li><?php esc_attr_e('Product-specific info, such as "You Save" or "Old Price" (available ', 'vtprd'); echo wp_kses('<em>' ,$allowed_html ); esc_attr_e('only', 'vtprd'); echo wp_kses('</em>' ,$allowed_html ); esc_attr_e(' for Realtime Rules)', 'vtprd');?> 
              <ul>
                <li><em><?php esc_attr_e('Look in ', 'vtprd'); 
                        echo wp_kses('vt-pricing-deals-for- -integration ' ,$allowed_html );   
                        esc_attr_e('folders for how-to info', 'vtprd');?></em> 
                  <ul>
                    <li><?php esc_attr_e('"Sample Cart Widget" folder', 'vtprd');?></li>
                    <li><?php esc_attr_e('Theme product-level info', 'vtprd');?>  
                    <?php if (VTPRD_PARENT_PLUGIN_NAME == 'WP E-Commerce') { ?>
                      <ul>
                        <li><?php esc_attr_e('Two folders - before release 3.8.9, and after', 'vtprd');?> 
                          <ul>
                            <li><?php esc_attr_e('"Sample wpsc-theme before 3.8.9" folder', 'vtprd');?></li>
                            <li><?php esc_attr_e('"Sample wpsc-theme 3.8.9+" folder', 'vtprd');?></li>  
                          </ul>
                        </li>
                        <li><?php esc_attr_e('Each folder contains samples on how to integrate Pricing Deal messages into your Theme for grid-view, list-view, single-product, and products-page.', 'vtprd');?></li> 
                      </ul>
                    <?php } ?>
                    </li>
                  </ul>
                </li>
              </ul>
            </li>
          </ul>

          <h4 id="vtprd-discount-rules"><?php esc_attr_e('Products Discount display', 'vtprd');?>
            <a id="vtprd-info1-help3" class="info-doc-anchor" href="<?php echo esc_js('javascript:void(0);');?>" ><?php esc_attr_e('More Info', 'vtprd');?></a>
          </h4>       
          <ul id="vtprd-info1-help3-text" class="vtprd-info1-help-text">
            <li><?php esc_attr_e('Display types', 'vtprd');?>
               <ul>
                <li><?php esc_attr_e('Realtime Display discount directly in the product Catalog', 'vtprd');?> 
                  <ul>
                    <li><?php esc_attr_e('CATALOG Display Discount ', 'vtprd');?>
                      <ul>
                        <li><?php esc_attr_e('Price is automatically reduced when shown to the customer ', 'vtprd');?></li>
                      </ul>
                    </li>
                  </ul>
                </li>
                <li><?php esc_attr_e('Products discounted in the cart, based on add-to-cart rules', 'vtprd');?> 
                  <ul>
                    <li><?php esc_attr_e('Display discounts in the Cart', 'vtprd');?> 
                      <ul>
                        <li><?php esc_attr_e('In the Cart Widget', 'vtprd');?>  
                          <ul>
                            <li><?php esc_attr_e('With the addition of three lines to your Theme cart widget, rule discounts will be shown in mini-cart', 'vtprd');?></li>                        
                          </ul>
                        </li>
                        <li><?php esc_attr_e('At Checkout', 'vtprd');?>  
                          <ul>
                            <li><?php esc_attr_e('Discounts can be shown at various levels and places in the checkout', 'vtprd');?>                        
                              <ul>
                                <li><?php esc_attr_e('By product and rule short description', 'vtprd');?></li>
                                <li><?php esc_attr_e('By product discount total', 'vtprd');?></li>
                                <li><?php esc_attr_e('By discount total for Cart only', 'vtprd');?></li>                        
                              </ul>
                            </li>                      
                          </ul>
                        </li>                    
                      </ul>
                    </li>
                  </ul>
                </li>                
              </ul>
            </li>
            <li><?php esc_attr_e('Many display options are available in the product settings, for both the Cart Widget and Checkout.', 'vtprd');?></li>
          </ul>

          <h4 id="vtprd-discount-rules"><?php esc_attr_e('Discounts Working Together', 'vtprd');?>
            <a id="vtprd-info1-help4" class="info-doc-anchor" href="<?php echo esc_js('javascript:void(0);');?>" ><?php esc_attr_e('More Info', 'vtprd');?></a>
          </h4>
          <ul id="vtprd-info1-help4-text" class="vtprd-info1-help-text">
            <li><?php esc_attr_e('Each Discount Deal has settings for interaction with', 'vtprd');?> 
              <ul>
                <li><?php esc_attr_e('Other Discount Deals', 'vtprd');?> </li>
                <li><?php esc_attr_e('Sale Pricing', 'vtprd');?></li>
                <li><?php esc_attr_e('Coupon Use', 'vtprd');?></li>
              </ul>
            </li>
            <li><?php esc_attr_e('A variety of maximum settings are available by Rule', 'vtprd');?> 
              <ul>
                <li><?php esc_attr_e('Rule maximum for cart', 'vtprd');?> </li>
                <li><?php esc_attr_e('Lifetime rule usage for Customer', 'vtprd');?> </li>
                <li><?php esc_attr_e('Rule discount limit for all discounts applied to cart', 'vtprd');?> </li>
              </ul>
            </li>
            <li><?php esc_attr_e('A maximum discount percentage can be set in the options to apply to the Whole Store', 'vtprd');?> 
              <ul>
                <li><?php esc_attr_e('Sets a floor percentage for all discounts By product', 'vtprd');?> </li>
              </ul>
            </li>                       
          </ul>
 
          <h4 id="vtprd-discount-rules"><?php esc_attr_e('Audit Trail', 'vtprd');?>
            <a id="vtprd-info1-help5" class="info-doc-anchor" href="<?php echo esc_js('javascript:void(0);');?>" ><?php esc_attr_e('More Info', 'vtprd');?></a>
          </h4>
          <ul id="vtprd-info1-help5-text" class="vtprd-info1-help-text">
            <li><?php esc_attr_e('Discount Log Tables saved', 'vtprd');?> 
              <ul>
                <li><?php esc_attr_e('By Cart and Customer', 'vtprd');?> </li>
                <li><?php esc_attr_e('Showing Cart discount totals', 'vtprd');?></li>
                <li><?php esc_attr_e('Showing Each discount by product and rule', 'vtprd');?></li>
              </ul>
            </li>                      
          </ul>
                                
      </span> <?php //end  .textarea span ?> 
     <?php   
  }

            
  //************************************************
  // Help panel for Discount Amt Info
  //************************************************ 
  function vtprd_show_help_selection_panel_1() {  
    global $vtprd_setup_options, $vtprd_rule_template_framework, $vtprd_deal_screen_framework;
  ?>           
    <div class="selection-panel selection-panel-1" id="selection-panel-1" >                                
      <span class="selection-panel-label label"><strong><?php esc_attr_e('How Does the Discount display at Checkout?', 'vtprd');?></strong></span>                         
      <a class="selection-panel-close selection-panel-close-1" href="<?php echo esc_js('javascript:void(0);');?>" ><img class="close-button" alt="help"  width="16" height="16" src="<?php echo esc_url(VTPRD_URL.'/admin/images/close-icon.png');?>" /></a>                     
  		<span class="selection-panel-text" >
        <span class="selection-panel-text-info">
        
        <?php
          vtprd_show_help_panel_1_text();
        ?>
       
        </span>
      </span> 
      <a class="selection-panel-close selection-panel-close-1" href="<?php echo esc_js('javascript:void(0);');?>" ><img class="close-button" alt="help"  width="16" height="16" src="<?php echo esc_url(VTPRD_URL.'/admin/images/close-icon.png');?>" /></a>
    </div>       
<?php 
   return;  
  }   
  //************************************************ 
  //Discount Display INFO for both Checkout and Cart Widget
  //************************************************ 
  function vtprd_show_help_panel_1_text() {               
      $allowed_html = vtprd_get_allowed_html(); //v2.0.3
      ?>
          <span class="infoSection">
            <span class="textarea">
              
              <h4 class="discount-help-title"><?php esc_attr_e('Pricing Deals Discounts show Automatically at Checkout', 'vtprd');?></h4>
             
              <ol class="directions-list">
                <li><?php esc_attr_e('Realtime Discounts display automatically when the product price is first displayed to the customer.', 'vtprd');?> </li>
                <li><?php esc_attr_e('Add to Cart discounts are displayed to the customer at Checkout and in the Cart Widget', 'vtprd');?></li>
              </ol>               
             </span>
              
              <span class="textarea">
              <strong><?php esc_attr_e('There are ', 'vtprd'); echo wp_kses('<em>',$allowed_html ); esc_attr_e('no code changes required', 'vtprd'); echo wp_kses('</em>',$allowed_html ); esc_attr_e(' to display discounts at checkout.', 'vtprd');?></strong>
              </span>
      
              <span class="textarea"><br><?php esc_attr_e('The Discount Totals for the cart are loaded in to the Cart"s coupon
                  amount field for processing.', 'vtprd');?></span>
   
            
              
            <ol class="directions-list">
              <li><?php esc_attr_e('Discount totals are combined into a single discount bucket, along with any coupon discounts..', 'vtprd');?> </li>
              <li><?php esc_attr_e('If there are no coupons presented, the Pricing Deal plugin will create its own Discount Totals line for the cart.', 'vtprd');?> </li>
              <li><?php esc_attr_e('If an active coupon amount is present, and the Pricing Deal discount applies in addition to the Coupon discount,
                            the total will be displayed by default as part of the Coupon Discount total.', 'vtprd');?></li>
            </ol>
            <span class="textarea"> 
              <?php esc_attr_e('Discounts at checkout are controlled by the group of settings in the ', 'vtprd');?>
              <?php  echo wp_kses('<a href="' ,$allowed_html ) . admin_url( 'edit.php?post_type=vtprd-rule&page=vtprd_setup_options_page#vtprd-checkout-reporting-anchor' ) .  wp_kses('">' ,$allowed_html ). esc_attr_e( 'Settings Page - Checkout Discount Options', 'vtprd' ) . wp_kses('</a>)' ,$allowed_html ); ?>            
            </span> 
                                   
          </span>
      
    <?php 
  }

            
  //************************************************
  // Help panel for Discount Msgs Info
  //************************************************ 
  function vtprd_show_help_selection_panel_2() {  
    global $vtprd_setup_options, $vtprd_rule_template_framework, $vtprd_deal_screen_framework;
  ?>           
    <div class="selection-panel selection-panel-2" id="selection-panel-2" >                                
      <span class="selection-panel-label label"><strong><?php esc_attr_e('How to Use Discount Messages in your Theme?', 'vtprd');?></strong></span>                         
      <a class="selection-panel-close selection-panel-close-2" href="<?php echo esc_js('javascript:void(0);');?>" ><img class="close-button" alt="help"  width="16" height="16" src="<?php echo esc_url(VTPRD_URL.'/admin/images/close-icon.png');?>" /></a>                      
  		<span class="selection-panel-text" >
        <span class="selection-panel-text-info">
        
        <?php
          vtprd_show_help_panel_2_text();
        ?>
       
        </span>
      </span> 
      <a class="selection-panel-close selection-panel-close-2" href="<?php echo esc_js('javascript:void(0);');?>" ><img class="close-button" alt="help"  width="16" height="16" src="<?php echo esc_url(VTPRD_URL.'/admin/images/close-icon.png');?>" /></a>
    </div>       
<?php 
   return;  
  }   
  //************************************************
  // Help panel for Discount Msgs Info
  //************************************************  
  function vtprd_show_help_panel_2_text() {               
      $allowed_html = vtprd_get_allowed_html(); //v2.0.3
   ?> 
      <span class="infoSection">
        <span class="textarea"> 
          
          <h4 class="discount-help-title"><?php esc_attr_e('Installing "You Save" and "Old Price" messages in your Theme (available ', 'vtprd'); echo wp_kses('<em>',$allowed_html ); esc_attr_e('only', 'vtprd'); echo wp_kses('</em>',$allowed_html ); esc_attr_e(' for Realtime Rules)', 'vtprd');?></h4>
        </span>  
        
        <span class="textarea"><?php esc_attr_e('Your theme contains the following four files, which all require changes, in order to display Pricing Deal "Yousave" and "Old Price" messages.  
                Please note that the  "You Save" and "Old Price" functionality for ', 'vtprd'); echo wp_kses('<em>',$allowed_html ); esc_attr_e('regular', 'vtprd'); echo wp_kses('</em>',$allowed_html ); esc_attr_e(' sale pricing will remain in effect.', 'vtprd');?>
        </span>
        
        <ol class="directions-list">
          <li><?php echo esc_url('"wpsc-grid_view.php"');?> </li>
          <li><?php echo esc_url('"wpsc-list_view.php"');?> </li>
          <li><?php echo esc_url('"wpsc-products_page"');?> </li>
          <li><?php echo esc_url('"wpsc-single_product.php"');?> </li>
        </ol>
        <span class="textarea"> 
          <?php esc_attr_e('Find the sample version of these same files.  Look in ', 'vtprd');?>
          <em>
          <?php  echo wp_kses('vt-pricing-deals-for- -integration' ,$allowed_html ); //v2.0.3 ?> 
          </em>  
          <?php  esc_attr_e(' folders for step-by-step instructions.', 'vtprd');?>  
          <br><em>
          <?php  esc_attr_e('Apply the changes you find in the appropriate sample folder, to your matching theme files.', 'vtprd');?>
          </em> 
        </span>
        
        <ol class="directions-list">
          <li><?php esc_attr_e('"Sample wpsc-theme before 3.8.9" folder', 'vtprd');?>
              <br>&nbsp;&nbsp;&nbsp;
              <span class="subLine"><?php esc_attr_e('Within Each of the files, "You Save" and "Old Price" generation are controlled by individual code areas: ', 'vtprd');?></span>
                <ul class="directions-list">
                  <li><?php esc_attr_e('If Pricing Deal "You Save" message should be turned off, simply do not make the "You Save" code changes listed.', 'vtprd');?></li>
                  <li><?php esc_attr_e('If Pricing Deal "Old Price" message should be turned off, simply do not make the "Old Price" code changes listed.', 'vtprd');?></li>  
                </ul> 
          </li>
          <li><?php esc_attr_e('"Sample wpsc-theme 3.8.9+" folder', 'vtprd');?>
              <br>&nbsp;&nbsp;&nbsp;
              <span class="subLine"><?php esc_attr_e('Within Each of the files, there are options noted for "You Save" and "Old Price" generation: ', 'vtprd');?></span>
                <ul class="directions-list">
                  <li><?php esc_attr_e('vtprd_the_product_price_display(); => Shows both the Old Price and You Save  messages', 'vtprd');?></li>
                  <li><?php esc_attr_e('vtprd_the_product_price_display( array( "output_old_price" => false ) ); => Turns off the Old Price message', 'vtprd');?></li>
                  <li><?php esc_attr_e('vtprd_the_product_price_display( array( "output_you_save" => false ) );  => Turns off the You Save message', 'vtprd');?></li>
                  <li><?php esc_attr_e('vtprd_the_product_price_display( array( "output_old_price" => false, "output_you_save" => false ) ); => Turns off both messages', 'vtprd');?></li>  
                </ul>   
          </li>
        </ol>
        
        <span class="textarea">  
           <?php  esc_attr_e('Choose the folder which matches your WP E-Commerce release, and find the file name within the folder matching each file in your theme.', 'vtprd');?> 
        </span>
        
        <ol class="directions-list">
          <li><?php esc_attr_e('Apply the changes from the each sample file to your ', 'vtprd'); echo wp_kses('<em>',$allowed_html ); esc_attr_e('active theme', 'vtprd'); echo wp_kses('</em>',$allowed_html ); esc_attr_e(' version of the file.', 'vtprd');?> </li>
          <li><?php esc_attr_e('If your Active Theme has child-theme capability, place the changed file into the child-theme folder, and you are done.', 'vtprd'); 
                    echo wp_kses('<br><em>',$allowed_html ); esc_attr_e('And', 'vtprd'); echo wp_kses('</em>',$allowed_html ); esc_attr_e(' you will never have to update this file again, unless your custom theme changes this file on update.', 'vtprd');?> </li>
          <li><?php esc_attr_e('If your Active Theme does not have child-theme capability, replace "wpsc-cart_widget.php" where you found it in your theme area.  ', 'vtprd');?></li>
          <li><?php esc_attr_e('In this case, <em>Each</em> time your theme updates, you will want to check the "wpsc-cart_widget.php", and re-apply the changes as necessary.', 'vtprd');?> </li>
        </ol>             
      </span>

      <span class="infoSection">
        <span class="textarea"> 
          
          <h4 class="discount-help-title"><?php esc_attr_e('Discounts in Cart Widget and Checkout', 'vtprd');?></h4>
        </span>  
        
        <span class="textarea marginBottom"> 
          <?php esc_attr_e('- Short Discount Rule Messages are displayed when messaging is selected, and that rule has generated a discount in the Cart', 'vtprd');?>
        </span> 
                        
        <span class="textarea marginBottom"> 
          <?php esc_attr_e('- Cart Widget and Checkout each have their own Settings Options - ', 'vtprd');?>
          <?php  echo wp_kses('<a href="' ,$allowed_html ) . admin_url( 'edit.php?post_type=vtprd-rule&page=vtprd_setup_options_page' ) .  wp_kses('">' ,$allowed_html ). esc_attr_e( 'Settings Page', 'vtprd' ) . wp_kses('</a>)' ,$allowed_html ); ?>
        </span> 
     
        <span class="textarea marginBottom"> 
          <?php esc_attr_e('- Each option controls how or whether Discount data is presented.', 'vtprd');?>
        </span> 
        
        <span class="textarea"> 
          <?php esc_attr_e('- Please experiment with these options settings, to arrive at the Discount display best for your online store.', 'vtprd');?>
        </span> 
      </span>
      
      
      <span class="infoSection">
        <span class="textarea"> 
          
          <h4 class="discount-help-title"><?php esc_attr_e('Discounts and Messages at Product Display Time (in the Catalog)', 'vtprd');?></h4>
        </span>  
        
        <span class="textarea marginBottom"> 
          <?php esc_attr_e('- When a Realtime Type Rule is in force for a product, at catalog display, the product price is automatically reduced.', 'vtprd');?>
        </span> 
                        
        <span class="textarea marginBottom"> 
          <?php esc_attr_e('- if the "echo do_action" code to be found in the sample file is employed, the Realtime Type Rule(s) Message in force for this product will be produced (for example, "Membership Discount of 10%" .', 'vtprd');?>
        </span> 
     
        <span class="textarea marginBottom"> 
          <?php esc_attr_e('- In addition to, or in place of the "echo do_action" code, you can also use the sample "echo do_shortcode" to produce a variety of Rule messages (see above).', 'vtprd');?>
        </span> 
 
      </span>

  <?php    
  }

 
            
  //************************************************
  // How to Install Discount Messages in your Theme
  //************************************************ 
  function vtprd_show_help_selection_panel_3() {  
    global $vtprd_setup_options, $vtprd_rule_template_framework, $vtprd_deal_screen_framework;
  ?>           
    <div class="selection-panel selection-panel-3" id="selection-panel-3" >                                
      <span class="selection-panel-label label"><strong><?php esc_attr_e('How to Show Pricing Deals in Cart Widget?', 'vtprd');?></strong></span>                         
      <a class="selection-panel-close selection-panel-close-3" href="<?php echo esc_js('javascript:void(0);');?>" ><img class="close-button" alt="help"  width="16" height="16" src="<?php echo esc_url(VTPRD_URL.'/admin/images/close-icon.png');?>" /></a>                    
  		<span class="selection-panel-text" >
        <span class="selection-panel-text-info">
        
        <?php
          vtprd_show_help_panel_3_text();
        ?>
       
        </span>
      </span> 
      <a class="selection-panel-close selection-panel-close-3" href="<?php echo esc_js('javascript:void(0);');?>" ><img class="close-button" alt="help"  width="16" height="16" src="<?php echo esc_url(VTPRD_URL.'/admin/images/close-icon.png');?>" /></a>
    </div>       
<?php 
   return;  
  }   
  //************************************************
  // How to Install Discount Messages in your Theme
  //v2.0.3 REmoved
  //************************************************  
  function vtprd_show_help_panel_3_text() {               
     switch( VTPRD_PARENT_PLUGIN_NAME ) {
      case 'WP E-Commerce':  
     
      break;  //end wpec              

      
    } //end Swtich 
  }


            
  //************************************************
  // Help panel for Shortcodes
  //************************************************ 
  function vtprd_show_help_selection_panel_4() {  
    global $vtprd_setup_options, $vtprd_rule_template_framework, $vtprd_deal_screen_framework;
  ?>           
    <div class="selection-panel selection-panel-4" id="selection-panel-4" >                                
      <span class="selection-panel-label label"><strong><?php esc_attr_e('Marketing! - Add Pricing Deal Message Shortcodes!', 'vtprd');?></strong></span>                         
      <a class="selection-panel-close selection-panel-close-4" href="<?php echo esc_js('javascript:void(0);');?>" ><img class="close-button" alt="help"  width="16" height="16" src="<?php echo esc_url(VTPRD_URL.'/admin/images/close-icon.png');?>" /></a>                     
  		<span class="selection-panel-text" >
        <span class="selection-panel-text-info">
        
        <?php
          vtprd_show_help_panel_4_text();
        ?>
       
        </span>
      </span> 
      <a class="selection-panel-close selection-panel-close-4" href="<?php echo esc_js('javascript:void(0);');?>" ><img class="close-button" alt="help"  width="16" height="16" src="<?php echo esc_url(VTPRD_URL.'/admin/images/close-icon.png');?>" /></a>
    </div>       
<?php 
   return;  
  }   
  //************************************************
  // Help panel for Shortcodes
  //************************************************  
  function vtprd_show_help_panel_4_text() {               
   $allowed_html = vtprd_get_allowed_html(); //v2.0.3
   ?> 
      <span class="infoSection">
        <span class="textarea"> 
          
          <h4 class="discount-help-title"><?php esc_attr_e('Add Your Deal Messages to your Theme', 'vtprd'); echo wp_kses('&nbsp;-&nbsp;' ,$allowed_html ); esc_attr_e('Use Shortcodes!', 'vtprd');?></h4>
        </span>  
         
        <span class="textarea"> 
          <?php esc_attr_e('- Your deal messages can be introduced anywhere on your Website!', 'vtprd'); echo wp_kses('&nbsp;-&nbsp;' ,$allowed_html ); esc_attr_e('"24-Hour Store-Wide Sale, 10% off of Everything!"', 'vtprd');?>
        </span>
         <ol class="directions-list">
          <li><?php esc_attr_e('Standard Shortcode', 'vtprd'); echo wp_kses('&nbsp;=>&nbsp;' ,$allowed_html );  esc_attr_e('example: [pricing_deal_store_msgs]', 'vtprd');?> </li>
          <li><?php esc_attr_e('Anywhere in your Theme', 'vtprd'); echo wp_kses('&nbsp;=>&nbsp;' ,$allowed_html );  esc_attr_e('example: < ?php echo do_shortcode(\'[pricing_deal_store_msgs  rule_id_list="10,15,30"]\' ? > &nbsp;&nbsp;&nbsp;&nbsp; (remove space between "<>" and "?")', 'vtprd');?> </li>
          <li><?php esc_attr_e('At the Product Level, show all RealTime messages:', 'vtprd');?>
            <ul class="directions-list">
              <li><?php esc_attr_e('At Product display time, *any* Pricing Deal message which relates to the product can be displayed', 'vtprd');?> 
                  <br>&nbsp;&nbsp;&nbsp;
                  <?php esc_attr_e('"Buy 2 of this product, get one of those products free"', 'vtprd');?>
                  <br>&nbsp;&nbsp;&nbsp;
                  <?php esc_attr_e('"Buy 2 of those products, get this product free"', 'vtprd');?> 
              </li>
              <li><?php esc_attr_e('Look in ', 'vtprd'); 
                        echo wp_kses('vt-pricing-deals-for- -integration ' ,$allowed_html );   
                        esc_attr_e('folders for how-to info, using the do_shortchode or do_action syntax listed.', 'vtprd');?>   
              </li>
            </ul>         
          </li>
        </ol>
    
      </span>

       <span class="infoSection">
        <span class="textarea"> 
          
          <h4 class="discount-help-title"><?php esc_attr_e('Theme Shortcodes Usage', 'vtprd');?></h4>
        </span>  
         
        <span class="textarea"> 
          <?php esc_attr_e('These Shortcodes can be used on their own, or with a variety of parameters', 'vtprd');?>
        </span>
         <ol class="directions-list">
          <li><?php esc_attr_e('Standard - [pricing_deal_store_msgs]', 'vtprd');?><a id="vtprd-shortcode-details1-help" class="vtprd-shortcode-details1-help info-doc-anchor" href="<?php echo esc_js('javascript:void(0);');?>" ><?php esc_attr_e('Details', 'vtprd');?></a> 
            <span id="vtprd-shortcode-details1" class="vtprd-info1-help-text shortcode-details vtprd-shortcode-details1">
               <br /><br />
               <?php esc_attr_e('THIS IS EXAMPLE SYNTAX ONLY.  Please refer to the SAMPLE FILE for the actual syntax.', 'vtprd');?>                
               <br /><br />
               //====================================<br />
               //SHORTCODE: pricing_deal_store_msgs<br />
               //====================================<br />
               <br />
               //shortcode documentation here - wholestore<br />
               //WHOLESTORE MESSAGES SHORTCODE 'vtprd_pricing_deal_store_msgs'<br />
               /* ================================================================================= <br />
               => rule_id_list is OPTIONAL - Show msgs only for these rules => if not supplied, all msgs will be produced<br />
               <br />
               A list can be a single code [ example: rule_id_list => '123' }, or a group of codes [ example: rule_id_list => '123,456,789' } with no spaces in the list<br />
               A switch can be sent to just display the whole store messages<br />
               <br />
               As a shortcode:<br />
               [pricing_deal_whole_store_msgs rule_id_list=&quot;10,15,30&quot;]<br />
               <br />
               As a template code with a passed variable containing the list:<br />
               $rule_id_list=&quot;10,15,30&quot;; //or it is a generated list <br />
               echo do_shortcode('[pricing_deal_store_msgs rule_id_list=' .$rule_id_list. ']');<br />
               OR<br />
               echo do_shortcode('[pricing_deal_store_msgs rule_id_list=&quot;10,15,30&quot;]');<br />
               echo do_shortcode('[pricing_deal_store_msgs wholestore_msgs_only=&quot;yes&quot; rule_id_list=&quot;10,15,30&quot; ]'); <br />
              <br />
               ====================================<br />
               PARAMETER DEFAULTS and VALID VALUES<br />
               ==================================== <br />
               msg_type => 'cart', //'cart' (default) / 'catalog' / 'all' ==> &quot;cart&quot; msgs = cart rules type, &quot;catalog&quot; msgs = realtime catalog rules type <br />
               // AND (implicit)<br />
               wholestore_msgs_only => 'no', //'yes' / 'no' (default) <br />
               // AND [implicit]<br />
               // ( <br />
               // OR [implicit]<br />
               role_name_list => '', //'Administrator,Customer,Not logged in (just visiting),Member' <br />
               // OR [implicit]<br />
               rule_id_list => '', //'123,456,789' <br />
               // OR [implicit]<br />
               product_id_list => '' //'123,456,789' (ONLY WORKS in the LOOP, or if the Post is available )<br />
               // ) 
               <br /><br />
               // in vtprd-parent-theme-functions.php 
               <br /><br />             
            </span>          
          </li>
          
          <li><?php esc_attr_e('By Category - [pricing_deal_category_msgs]', 'vtprd');?><a id="vtprd-shortcode-details2-help" class="vtprd-shortcode-details2-help info-doc-anchor" href="<?php echo esc_js('javascript:void(0);');?>" ><?php esc_attr_e('Details', 'vtprd');?></a> 
            <span id="vtprd-shortcode-details2" class="vtprd-info1-help-text shortcode-details vtprd-shortcode-details2">
               <br /><br />
               <?php esc_attr_e('THIS IS EXAMPLE SYNTAX ONLY.  Please refer to the SAMPLE FILE for the actual syntax.', 'vtprd');?> 
               <br /> <br />
                  //====================================<br />
                   //SHORTCODE: pricing_deal_category_msgs<br />
                   //==================================== <br />
                   <br />
                   //shortcode documentation here - category<br />
                   //STORE CATEGORY MESSAGES SHORTCODE vtprd_pricing_deal_category_msgs<br />
                   /* ================================================================================= <br />
                   => either prodcat_id_list or rulecat_id_list or rule_id_list is REQUIRED<br />
                   => if both lists supplied, the shortcode will find rule msgs in EITHER prodcat_id_list OR rulecat_id_list OR rule_id_list.<br />
                   <br />
                   A list can be a single code [ example: rule_id_list => '123' }, or a group of codes [ example: rule_id_list => '123,456,789' } with no spaces in the list <br />
                   <br />
                   REQUIRED => Data MUST be sent in ONE of the list parameters, or nothing is returned.<br />
                   <br />
                   As a shortcode:<br />
                   [pricing_deal_category_msgs prodcat_id_list=&quot;10,15,30&quot; rulecat_id_list=&quot;12,17,32&quot;]<br />
                   <br />
                   As a template code with a passed variable containing the list:<br />
                   to show only the current category messages, for example:<br />
                   GET CURRENT CATEGORY <br />
                   <br />
                   if (is_category()) {<br />
                   $prodcat_id_list = get_query_var('cat');<br />
                   echo do_shortcode('[pricing_deal_category_msgs prodcat_id_list=' .$prodcat_id_list. ']');<br />
                   }<br />
                   OR <br />
                   USING A HARDCODED CAT LIST <br />
                   echo do_shortcode('[pricing_deal_category_msgs prodcat_id_list=&quot;10,15,30&quot; ]');<br />
                  <br />
                   ====================================<br />
                   PARAMETER DEFAULTS and VALID VALUES<br />
                   ====================================<br />
                   msg_type => 'cart', //'cart' (default) / 'catalog' / 'all' ==> &quot;cart&quot; msgs = cart rules type, &quot;catalog&quot; msgs = realtime catalog rules type <br />
                   // AND [implicit] <br />
                   // ( <br />
                   prodcat_id_list => '', //'123,456,789' only active if in this list<br />
                   // OR [implicit]<br />
                   rulecat_id_list => '' //'123,456,789' only active if in this list<br />
                   // )
               <br /><br />
               // in vtprd-parent-theme-functions.php 
               <br /><br />            
            </span>          
          </li>
          
          <li><?php esc_attr_e('Advanced - [pricing_deal_advanced_msgs]', 'vtprd');?><a id="vtprd-shortcode-details3-help" class="vtprd-shortcode-details3-help info-doc-anchor" href="<?php echo esc_js('javascript:void(0);');?>" ><?php esc_attr_e('Details', 'vtprd');?></a> 
            <span id="vtprd-shortcode-details3" class="vtprd-info1-help-text shortcode-details vtprd-shortcode-details3">
               <br /><br />
               <?php esc_attr_e('THIS IS EXAMPLE SYNTAX ONLY.  Please refer to the SAMPLE FILE for the actual syntax.', 'vtprd');?>                
               <br /><br />
                  //====================================<br />
                   //SHORTCODE: pricing_deal_advanced_msgs<br />
                   //==================================== <br />
                   <br />
                   //shortcode documentation here - advanced<br />
                   //ADVANCED MESSAGES SHORTCODE vtprd_pricing_deal_advanced_msgs<br />
                   /* ================================================================================= <br />

                   <br />
                   A list can be a single code [ example: rule_id_list => '123' }, or a group of codes [ example: rule_id_list => '123,456,789' } with no spaces in the list <br />
                   <br />
                   NB - please be careful to follow the comma use exactly as described!!! <br />
                   <br />
                   As a shortcode:<br />
                   [pricing_deal_advanced_msgs <br />
                   grp1_msg_type => 'cart'<br />
                   grp1_and_or_wholestore_msgs_only => 'and'<br />
                   grp1_wholestore_msgs_only => 'no'<br />
                   and_or_grp1_to_grp2 => 'and'<br />
                   grp2_rule_id_list => ''<br />
                   grp2_and_or_role_name_list => 'and'<br />
                   grp2_role_name_list => ''<br />
                   and_or_grp2_to_grp3 => 'and'<br />
                   grp3_prodcat_id_list => ''<br />
                   grp3_and_or_rulecat_id_list => 'or'<br />
                   grp3_rulecat_id_list => '' <br />
                   ]<br />
                   <br />
                   As a template code with passed variablea<br />
                   echo do_shortcode('[pricing_deal_advanced_msgs <br />
                   grp1_msg_type => 'cart'<br />
                   grp1_and_or_wholestore_msgs_only => 'and'<br />
                   grp1_wholestore_msgs_only => 'no'<br />
                   and_or_grp1_to_grp2 => 'and'<br />
                   grp2_rule_id_list => ''<br />
                   grp2_and_or_role_name_list => 'and'<br />
                   grp2_role_name_list => ''<br />
                   and_or_grp2_to_grp3 => 'and'<br />
                   grp3_prodcat_id_list => ''<br />
                   grp3_and_or_rulecat_id_list => 'or'<br />
                   grp3_rulecat_id_list => '' <br />
                   ]');<br />
                   <br />
                   ====================================<br />
                   PARAMETER DEFAULTS and VALID VALUES<br />
                   ====================================<br />
                   // ( grp 1<br />
                   grp1_msg_type => 'cart', //'cart' (default) / 'catalog' / 'all' ==> &quot;cart&quot; msgs = cart rules type, &quot;catalog&quot; msgs = realtime catalog rules type <br />
                   grp1_and_or_wholestore_msgs_only => 'and', //'and'(default) / 'or' <br />
                   grp1_wholestore_msgs_only => 'no', //'yes' / 'no' (default) only active if rule active for whole store<br />
                   // )<br />
                   and_or_grp1_to_grp2 => 'and', //'and'(default) / 'or' <br />
                   // ( grp 2<br />
                   grp2_rule_id_list => '', //'123,456,789' only active if in this list<br />
                   grp2_and_or_role_name_list => 'and', //'and'(default) / 'or' <br />
                   grp2_role_name_list => '', //'Administrator,Customer,Not logged in (just visiting),Member' Only active if in this list <br />
                   // )<br />
                   and_or_grp2_to_grp3 => 'and', //'and'(default) / 'or' <br />
                   // ( grp 3<br />
                   grp3_prodcat_id_list => '', //'123,456,789' only active if in this list<br />
                   grp3_and_or_rulecat_id_list => 'or', //'and' / 'or'(default) <br />
                   grp3_rulecat_id_list => '' //'123,456,789' only active if in this list<br />
                   // )
               <br /><br />
               // in vtprd-parent-theme-functions.php 
               <br /><br />                
            </span>          
          </li>            
                    
        </ol>
         
      </span>

  <?php    
  }

            
  //************************************************
  // Help panel for Deals Examples
  //************************************************ 
  function vtprd_show_help_selection_panel_5() {  
    global $vtprd_setup_options, $vtprd_rule_template_framework, $vtprd_deal_screen_framework;    
  ?>           
    <div class="selection-panel selection-panel-5" id="selection-panel-5" >                                
      <span class="selection-panel-label label"><strong><?php esc_attr_e('Pricing Deal Examples FAQ', 'vtprd');?></strong></span>                         
      <a id="open-faq-in-new-window"  href="<?php echo esc_url(VTPRD_ADMIN_URL.'edit.php?post_type=vtprd-rule&page=vtprd_show_faq_page');?>" onclick="javascript:void window.open('<?php esc_url(VTPRD_ADMIN_URL.'edit.php?post_type=vtprd-rule&page=vtprd_show_faq_page');?>','1375122357919','width=700,height=500,toolbar=0,menubar=0,location=1,status=1,scrollbars=1,resizable=1,left=0,top=0');return false;">Open "Examples FAQ" in a Separate Window</a>                       		      
      <a class="selection-panel-close selection-panel-close-5" href="<?php echo esc_js('javascript:void(0);');?>" ><img class="close-button" alt="help"  width="16" height="16" src="<?php echo esc_url(VTPRD_URL.'/admin/images/close-icon.png');?>" /></a>                      
  		<span class="selection-panel-text" >
        <span class="selection-panel-text-info">
        
        <?php
          vtprd_show_help_panel_5_text();
        ?>
       
        </span>
      </span>
      <a class="selection-panel-close selection-panel-close-5" href="<?php echo esc_js('javascript:void(0);');?>" ><img class="close-button" alt="help"  width="16" height="16" src="<?php echo esc_url(VTPRD_URL.'/admin/images/close-icon.png');?>" /></a>
    </div>       
<?php 
   return;  
  }   
  //************************************************
  // Help panel for Discount Msgs Info
  //************************************************  
  function vtprd_show_help_panel_5_text() {               
   $allowed_html = vtprd_get_allowed_html(); //v2.0.3
   ?> 
      <span class="textarea vtprd-intro-info">         
          
          <h4 id="">
            <?php $FAQ_title = __('Pricing Deals Overview ', 'vtprd'); ?>
            <a id="vtprd-panel-5-help1-more" class="panel-5-anchor" href="<?php echo esc_js('javascript:void(0);');?>"><?php echo wp_kses($FAQ_title ,$allowed_html ). wp_kses('&nbsp;&nbsp;' ,$allowed_html ); ?><img class="plus-button" alt="help" height="12px" width="12px" src="<?php echo esc_url(VTPRD_URL.'/admin/images/plus-toggle2.png');?>" /></a> 
            <a id="vtprd-panel-5-help1-less" class="panel-5-anchor hideMe" href="<?php echo esc_js('javascript:void(0);');?>"><?php echo wp_kses($FAQ_title ,$allowed_html ). wp_kses('&nbsp;&nbsp;' ,$allowed_html ) .  esc_attr_e(' ... Less ', 'vtprd') . wp_kses('&nbsp;&nbsp;' ,$allowed_html ) ; ?><img class="plus-button" alt="help" height="14px" width="14px" src="<?php echo esc_url(VTPRD_URL.'/admin/images/minus-toggle2.png');?>" /></a>                        
          </h4>
          <span id="vtprd-panel-5-help1-text" class="vtprd-panel-5-help-text-all">           
            <p class="faq-intro">
              <strong><?php esc_attr_e("Whenever you set up a pricing deal **Test the Heck Out of It** to make sure it does what you want precisely.", 'vtprd');?></strong>
            </p>
            <p class="faq-intro">
              <strong><?php esc_attr_e("There are basically 3 kinds of Pricing Deals ", 'vtprd');?></strong>
            </p>            
            <ul id="" class="">
              <li><strong><em>
                  <?php esc_attr_e('CATALOG Display Discount - Realtime', 'vtprd');?>
                  </em></strong>
                  <?php esc_attr_e(' Catalog Item Sale Pricing, by Whole Store [and by additional the Grouping Options listed below, available in the Pro Version]', 'vtprd');?> 
                <ul id="" class="">
                  <li><?php esc_attr_e('Price Reduction always shows as the product is displayed', 'vtprd');?> </li>
                  <li><?php esc_attr_e('"Buy" Group can be specified as the whole store, etc (see below)', 'vtprd');?> </li>
                  <li><?php esc_attr_e('"Get" group always the same as the "Buy" group', 'vtprd');?> </li>
                  <li><?php esc_attr_e('GROUP Options - Free Version => Whole Store; Pro Version => Wholesale or Membership (Display different prices for logged in users), Product Category and Pricing Deal custom Category, Product or Variation', 'vtprd');?> </li>
                </ul>              
              </li>
              <li><strong><em>
                  <?php esc_attr_e('Cart Purchase Pricing - BOGO', 'vtprd');?>
                  </em></strong>
                  <?php esc_attr_e(' (Buy One, Get One (Free, at a discount, etc)', 'vtprd');?> 
                <ul id="" class="">
                  <li><?php esc_attr_e('BUY - What group you have to purchase from to activate the Deal (Buy Group)', 'vtprd');?> </li>
                  <li><?php esc_attr_e('ONE - How many you have to purchase to activate the Deal (Buy Amount)', 'vtprd');?> </li>
                  <li><?php esc_attr_e('GET - What group the Deal acts on (Get Group)', 'vtprd');?> </li>
                  <li><?php esc_attr_e('ONE - How many the Deal acts on (Get Amount)', 'vtprd');?> </li>
                  <li><?php esc_attr_e('FREE - The Discount (Discount Amount)', 'vtprd');?> </li>
                </ul>              
              </li>
              <li><strong><em>
                  <?php esc_attr_e('Cart Purchase Pricing - GROUP PRICING', 'vtprd');?>
                  </em></strong>
                  <?php esc_attr_e(' (Buy 5, get them for the a fixed price [or for the price of 4,...])', 'vtprd');?> 
                 <ul id="" class="">
                  <li><?php esc_attr_e('Give any group a different price!', 'vtprd');?> </li>
                </ul>              
              </li>
            </ul>                       
          </span>
         

          <h4 id="">
            <?php $FAQ_title = __('Pricing Deal Theme Marketing ', 'vtprd'); ?>
            <a id="vtprd-panel-5-help2-more" class="panel-5-anchor" href="<?php echo esc_js('javascript:void(0);');?>"><?php echo wp_kses($FAQ_title ,$allowed_html ). wp_kses('&nbsp;&nbsp;' ,$allowed_html ); ?><img class="plus-button" alt="help" height="12px" width="12px" src="<?php echo esc_url(VTPRD_URL.'/admin/images/plus-toggle2.png');?>" /></a> 
            <a id="vtprd-panel-5-help2-less" class="panel-5-anchor hideMe" href="<?php echo esc_js('javascript:void(0);');?>"><?php echo wp_kses($FAQ_title ,$allowed_html ). wp_kses('&nbsp;&nbsp;' ,$allowed_html ) .   esc_attr_e(' ... Less ', 'vtprd') . wp_kses('&nbsp;&nbsp;' ,$allowed_html )  ; ?><img class="plus-button" alt="help" height="14px" width="14px" src="<?php echo esc_url(VTPRD_URL.'/admin/images/minus-toggle2.png');?>" /></a>                        
          </h4>
          <span id="vtprd-panel-5-help2-text" class="vtprd-panel-5-help-text-all">            
            <p class="faq-intro">
              <strong><?php esc_attr_e('Theme Marketing - add your Deal messages anywhere on your Website via Shortcode!', 'vtprd');?></strong>
              <br>&nbsp;&nbsp;
              <strong><?php esc_attr_e(' for example => "24-Hour Store-Wide Sale, 10% off of Everything!"', 'vtprd');?></strong>
            </p>
            <ul id="" class="">
              <li><?php esc_attr_e('On the Pricing Deal Rule and Settings screen, look in the upper right corner', 'vtprd');?></li>
              <li><em><?php esc_attr_e('Click on "Help! Tell me about Pricing Deals"', 'vtprd');?></em></li>
              <li><em><?php esc_attr_e('Click on "Add Pricing Deal Messages to your Theme using Shortcodes!"', 'vtprd');?></em></li>
            </ul>            
          </span>
          

          <h4 id="">
            <?php $FAQ_title = __('Group Selection Power! ', 'vtprd'); ?>
            <a id="vtprd-panel-5-help3-more" class="panel-5-anchor" href="<?php echo esc_js('javascript:void(0);');?>"><?php echo wp_kses($FAQ_title ,$allowed_html ). wp_kses('&nbsp;&nbsp;' ,$allowed_html ); ?><img class="plus-button" alt="help" height="12px" width="12px" src="<?php echo esc_url(VTPRD_URL.'/admin/images/plus-toggle2.png');?>" /></a> 
            <a id="vtprd-panel-5-help3-less" class="panel-5-anchor hideMe" href="<?php echo esc_js('javascript:void(0);');?>"><?php echo wp_kses($FAQ_title ,$allowed_html ). wp_kses('&nbsp;&nbsp;' ,$allowed_html ) .   esc_attr_e(' ... Less ', 'vtprd') . wp_kses('&nbsp;&nbsp;' ,$allowed_html )  ; ?><img class="plus-button" alt="help" height="14px" width="14px" src="<?php echo esc_url(VTPRD_URL.'/admin/images/minus-toggle2.png');?>" /></a>                        
          </h4>
          <span id="vtprd-panel-5-help3-text" class="vtprd-panel-5-help-text-all">            
            <p class="faq-intro">
              <?php esc_attr_e('Group Selection for discrete groups is a ', 'vtprd');?>
              <em><?php esc_attr_e('Pro Option', 'vtprd');?></em>
            </p>
            <ul id="" class="">
              <li><?php esc_attr_e('Selection by Product Category', 'vtprd');?> </li>
              <li><?php esc_attr_e('Selection by Pricing Deal custom Category', 'vtprd');?> </li>
              <li><?php esc_attr_e('Selection by Wholesaler, Membership or Role (Display different prices for logged in users)', 'vtprd');?> </li>
              <li><?php esc_attr_e('Selection by Product or Variation', 'vtprd');?> </li>
            </ul>
            
            <p class="faq-intro">
              <strong><?php esc_attr_e('Group pricing is made much more powerful ', 'vtprd');?></strong>
              <em><?php esc_attr_e('using Pricing Deals Custom Categories.  ', 'vtprd');?></em>
            </p>
            <p class="faq-intro">
              <?php esc_attr_e('Creating a Pricing Deals Custom Category in place of a store Product Category allows you to:', 'vtprd');?>
            </p>            
            <ul id="" class="">
              <li><?php esc_attr_e('Group together any products you elect', 'vtprd');?><em><?php esc_attr_e(' outside of the product categories', 'vtprd');?></em> </li>
              <li><?php esc_attr_e('Pricing Deals Custom Categories does not affect Product Category store organization and presentation', 'vtprd');?><em><?php esc_attr_e(' in any way', 'vtprd');?></em> </li>
              <li><?php esc_attr_e('You can cherry pick products across the Store, to assemble your desired grouping', 'vtprd');?> </li>
            </ul>            
          </span>


          <h4 id="">
            <?php $FAQ_title = __('Example - REALTIME Pricing Deals', 'vtprd'); ?>
            <a id="vtprd-panel-5-help4-more" class="panel-5-anchor vtprd-panel-5-example" href="<?php echo esc_js('javascript:void(0);');?>"><?php echo wp_kses($FAQ_title ,$allowed_html ). wp_kses('&nbsp;&nbsp;' ,$allowed_html ); ?><img class="plus-button" alt="help" height="12px" width="12px" src="<?php echo esc_url(VTPRD_URL.'/admin/images/plus-toggle2.png');?>" /></a> 
            <a id="vtprd-panel-5-help4-less" class="panel-5-anchor hideMe" href="<?php echo esc_js('javascript:void(0);');?>"><?php echo wp_kses($FAQ_title ,$allowed_html ). wp_kses('&nbsp;&nbsp;' ,$allowed_html ) .   esc_attr_e(' ... Less ', 'vtprd') . wp_kses('&nbsp;&nbsp;' ,$allowed_html )  ;  ?><img class="plus-button" alt="help" height="14px" width="14px" src="<?php echo esc_url(VTPRD_URL.'/admin/images/minus-toggle2.png');?>" /></a>                        
          </h4>
          <span id="vtprd-panel-5-help4-text" class="vtprd-panel-5-help-text-all">            
            <ul id="" class="">              
              <li><?php esc_attr_e('Catalog Item Sale Pricing => in Template Type -Under "Immediate Price Reduction", Choose:', 'vtprd');?> 
                  <ul id="" class="">
                    <li><?php esc_attr_e('Store-wide Sale', 'vtprd');?>
                        <ul id="" class="">
                          <li><?php esc_attr_e('Buy Amount - fixed at "Any" [Each in Buy Group]', 'vtprd');?></li>
                          <li><?php esc_attr_e('Buy Group -	fixed at Whole Store', 'vtprd');?></li>
                          <li><?php esc_attr_e('Get Amount - fixed at "Any" [Each in Get Group]', 'vtprd');?></li>
                          <li><?php esc_attr_e('Get Group -	fixed at "Same as Buy Group"', 'vtprd');?></li>
                          <li><?php esc_attr_e('Discount Amount -	* Choose type and enter amount *', 'vtprd');?></li>
                          <li><?php esc_attr_e('Discount Applies To -	fixed at "Each product in the Get Group"', 'vtprd');?></li>                          
                        </ul>                                        
                    </li>
                     <li><?php esc_attr_e('Simple Discount by wholesaler, membership category etc - a Pro Option', 'vtprd');?>
                        <ul id="" class="">
                          <li><?php esc_attr_e('Buy Amount - fixed at "Any" [Each in Buy Group]', 'vtprd');?></li>
                          <li><?php esc_attr_e('Buy Group -	* Choose any Group Configuration *', 'vtprd');?></li>
                          <li><?php esc_attr_e('Get Amount - fixed at "Any" [Each in Get Group]', 'vtprd');?></li>
                          <li><?php esc_attr_e('Get Group -	fixed at "Same as Buy Group"', 'vtprd');?></li>
                          <li><?php esc_attr_e('Discount Amount -	* Choose type and enter amount *', 'vtprd');?></li>
                          <li><?php esc_attr_e('Discount Applies To -	fixed at "Each product in the Get Group"', 'vtprd');?></li>                          
                        </ul>                                        
                    </li> 
                  </ul>
              </li>
            </ul>            
          </span>


          <h4 id="">
            <?php $FAQ_title = __('Example - BOGO Deals, Cart Purchase Pricing ', 'vtprd'); ?>
            <a id="vtprd-panel-5-help5-more" class="panel-5-anchor vtprd-panel-5-example" href="<?php echo esc_js('javascript:void(0);');?>"><?php echo wp_kses($FAQ_title ,$allowed_html ). wp_kses('&nbsp;&nbsp;' ,$allowed_html ); ?> <img class="plus-button" alt="help" height="12px" width="12px" src="<?php echo esc_url(VTPRD_URL.'/admin/images/plus-toggle2.png');?>" /></a> 
            <a id="vtprd-panel-5-help5-less" class="panel-5-anchor hideMe" href="<?php echo esc_js('javascript:void(0);');?>"><?php echo wp_kses($FAQ_title ,$allowed_html ). wp_kses('&nbsp;&nbsp;' ,$allowed_html ) .   esc_attr_e(' ... Less ', 'vtprd') . wp_kses('&nbsp;&nbsp;' ,$allowed_html )  ; ?><img class="plus-button" alt="help" height="14px" width="14px" src="<?php echo esc_url(VTPRD_URL.'/admin/images/minus-toggle2.png');?>" /></a>                        
          </h4>
          <span id="vtprd-panel-5-help5-text" class="vtprd-panel-5-help-text-all">            
            <ul id="" class="">
              <li><?php esc_attr_e('"Buy a Laptop, Get a Mouse Free" (for Pro Version)', 'vtprd');?> 
                  <ul id="" class="">
                    <li><?php esc_attr_e('Template Type - 	"Buy 6/$600, Get a discount on Next 4/$400 added to Cart"', 'vtprd');?></li>
                    <li><?php esc_attr_e('Buy Amount - 		Buy One (or ...)', 'vtprd');?></li>
                    <li><?php esc_attr_e('Buy Group -		Select "Use Category", Select Product Category = "laptop"', 'vtprd');?></li>
                    <li><?php esc_attr_e('Get Amount -		Get Next One', 'vtprd');?></li>
                    <li><?php esc_attr_e('Get Group -		Select "Use Category", Select Product Category = "mouse"', 'vtprd');?></li>
                    <li><?php esc_attr_e('Discount Amount -	Free', 'vtprd');?></li>
                    <li><?php esc_attr_e('Discount Applies To	- "Each product in the Get Group"', 'vtprd');?></li>                    
                  </ul>
              </li>
              <li><?php esc_attr_e('"Buy a Mouse, Get a 2nd Mouse Free" (for Pro Version)', 'vtprd');?> 
                  <ul id="" class="">
                    <li><?php esc_attr_e('Template Type - " Buy 6/$600, Get a discount on Next 4/$400 added to Cart"', 'vtprd');?></li>
                    <li><?php esc_attr_e('Buy Amount - 		Buy One (or ...)', 'vtprd');?></li>
                    <li><?php esc_attr_e('Buy Group -		Select "Use Category", Select Product Category = "mouse"', 'vtprd');?></li>
                    <li><?php esc_attr_e('Get Amount -		Get Next One', 'vtprd');?></li>
                    <li><?php esc_attr_e('Get Group -		Get Group Same as Buy Group ', 'vtprd');?></li>
                    <li><?php esc_attr_e('Discount Amount -	Free', 'vtprd');?></li>
                    <li><?php esc_attr_e('Discount Applies To	- "Each product in the Get Group"', 'vtprd');?></li>                    
                  </ul>
              </li>
              <li><?php esc_attr_e('With Buy (Rule) Repeats - "Buy a Mouse, Get a 2nd Mouse Free, up to 2 Mice Free" (for Pro Version)', 'vtprd');?> 
                  <ul id="" class="">
                    <li><?php esc_attr_e('Same as above, +', 'vtprd');?></li>
                    <li><?php esc_attr_e('Get Group (Rule) Repeat: - Number of Times Rule is Applied = 2', 'vtprd');?></li>                                      
                  </ul>
              </li> 
              <li><?php esc_attr_e('With "Forever" limits - "Buy a Mouse, Get a 2nd Mouse Free, Limit ONE per customer" (for Pro Version)', 'vtprd');?> 
                  <ul id="" class="">
                    <li><?php esc_attr_e('Same as above, +', 'vtprd');?></li>
                    <li><?php esc_attr_e('Maximum Discounts per Customer - for the Lifetime of the Rule: Maximum Number of times = 1', 'vtprd');?></li>                                      
                  </ul>
              </li>                                           
            </ul>            
          </span>           


          <h4 id="">
            <?php $FAQ_title = __('Example - GROUP Pricing Deals, Cart Purchase Pricing ', 'vtprd'); ?>
            <a id="vtprd-panel-5-help6-more" class="panel-5-anchor vtprd-panel-5-example" href="<?php echo esc_js('javascript:void(0);');?>"><?php echo wp_kses($FAQ_title ,$allowed_html ). wp_kses('&nbsp;&nbsp;' ,$allowed_html ); ?><img class="plus-button" alt="help" height="12px" width="12px" src="<?php echo esc_url(VTPRD_URL.'/admin/images/plus-toggle2.png');?>" /></a> 
            <a id="vtprd-panel-5-help6-less" class="panel-5-anchor hideMe" href="<?php echo esc_js('javascript:void(0);');?>"><?php echo wp_kses($FAQ_title ,$allowed_html ). wp_kses('&nbsp;&nbsp;' ,$allowed_html ) .   esc_attr_e(' ... Less ', 'vtprd') . wp_kses('&nbsp;&nbsp;' ,$allowed_html )  ; ?><img class="plus-button" alt="help" height="14px" width="14px" src="<?php echo esc_url(VTPRD_URL.'/admin/images/minus-toggle2.png');?>" /></a>                        
          </h4>
          <span id="vtprd-panel-5-help6-text" class="vtprd-panel-5-help-text-all">            
            <ul id="" class="">
              <li><?php esc_attr_e('"Get 10 vegetables for $10" (for Pro Version)', 'vtprd');?> 
                  <ul id="" class="">
                    <li><?php esc_attr_e('Template Type - 	"  Buy 5/$500, Get them for the price of 4/$400 - *GROUP PRICING*"', 'vtprd');?></li>
                    <li><?php esc_attr_e('Buy Amount - 		Buy Unit Quantity - 10 Units', 'vtprd');?></li> 
                    <li><?php esc_attr_e('Buy Amt Applies to- 	All (so it works with either 10 of the same Veg, or 10 different Veg)', 'vtprd');?></li> 
                    <li><?php esc_attr_e('Buy Group -		Select "Use Category", Select Product Category = "vegetables"', 'vtprd');?></li> 
                    <li><?php esc_attr_e('Get Amount -		 "Any" [Each in Get Group]', 'vtprd');?></li> 
                    <li><?php esc_attr_e('Get Group -		 "Same as Buy Group"', 'vtprd');?></li> 
                    <li><?php esc_attr_e('Discount Amount -	"For the Price of - Currency Discount"', 'vtprd');?></li> 
                    <li><?php esc_attr_e('For the price of: $	10', 'vtprd');?></li> 
                    <li><?php esc_attr_e('Discount Applies To	 fixed at "All products in the Get Group"', 'vtprd');?></li>                     
                  </ul>
              </li> 
              <li><?php esc_attr_e('"Buy $500 of Accessories, Get that them for $400" (for Pro Version)', 'vtprd');?> 
                  <ul id="" class="">
                    <li><?php esc_attr_e('Template Type - 	"  Buy 5/$500, Get them for the price of 4/$400 - *GROUP PRICING*"', 'vtprd');?></li>
                    <li><?php esc_attr_e('Buy Amount - 		Buy $ Value - 500', 'vtprd');?></li>
                    <li><?php esc_attr_e('Buy Amt Applies to- 	All (so it works with either 10 of the same, or 10 different)', 'vtprd');?></li>
                    <li><?php esc_attr_e('Buy Group -		Select "Use Category", Select Pricing Deals Category = " Accessories"', 'vtprd');?></li>
                    <li><?php esc_attr_e('Get Amount -		 "Any" [Each in Get Group]', 'vtprd');?></li>
                    <li><?php esc_attr_e('Get Group -		 "Same as Buy Group"', 'vtprd');?></li>
                    <li><?php esc_attr_e('Discount Amount -	"For the Price of - Currency Discount"   ', 'vtprd');?></li>
                    <li><?php esc_attr_e('For the price of: $	400', 'vtprd');?></li>
                    <li><?php esc_attr_e('Discount Applies To	 "All products in the Get Group"', 'vtprd');?></li>                  
                  </ul>
              </li>
              <li><?php esc_attr_e('"Buy $200, Get next 10 vegetables for the price of 8 vegetables" (for Pro Version)', 'vtprd');?> 
                  <ul id="" class="">
                    <li><?php esc_attr_e('Template Type - 	"  Buy 6/$600, Get Next 3 for the price of 2/$200 - *GROUP PRICING*', 'vtprd');?></li> 
                    <li><?php esc_attr_e('Buy Amount - 		Buy $ Value - 200', 'vtprd');?></li> 
                    <li><?php esc_attr_e('Buy Group -		Select "Whole Store"', 'vtprd');?></li> 
                    <li><?php esc_attr_e('Get Amount -		Get Unit Quantity - 10 Units', 'vtprd');?></li> 
                    <li><?php esc_attr_e('Get Group -		 Select "Use Category", Select Product Category = "vegetables"', 'vtprd');?></li> 
                    <li><?php esc_attr_e('Discount Amount -	"For the Price of - Units Discount', 'vtprd');?></li> 
                    <li><?php esc_attr_e('For the price of: 	8', 'vtprd');?></li> 
                    <li><?php esc_attr_e('Discount Applies To	 fixed at "All products in the Get Group"', 'vtprd');?></li>                  
                  </ul>
              </li>                                                                                     
            </ul>            
          </span>                      
          

          <h4 id="">
            <?php $FAQ_title = __('Group Selection - Using Pricing Deals Custom Categories ', 'vtprd'); ?>
            <a id="vtprd-panel-5-help7-more" class="panel-5-anchor" href="<?php echo esc_js('javascript:void(0);');?>"><?php echo wp_kses($FAQ_title ,$allowed_html ). wp_kses('&nbsp;&nbsp;' ,$allowed_html );?><img class="plus-button" alt="help" height="12px" width="12px" src="<?php echo esc_url(VTPRD_URL.'/admin/images/plus-toggle2.png');?>" /></a> 
            <a id="vtprd-panel-5-help7-less" class="panel-5-anchor hideMe" href="<?php echo esc_js('javascript:void(0);');?>"><?php echo wp_kses($FAQ_title ,$allowed_html ). wp_kses('&nbsp;&nbsp;' ,$allowed_html ) .   esc_attr_e(' ... Less ', 'vtprd') . wp_kses('&nbsp;&nbsp;' ,$allowed_html )  ;  ?><img class="plus-button" alt="help" height="14px" width="14px" src="<?php echo esc_url(VTPRD_URL.'/admin/images/minus-toggle2.png');?>" /></a>                        
          </h4>
          <span id="vtprd-panel-5-help7-text" class="vtprd-panel-5-help-text-all">            
            <p class="faq-intro">
              <?php esc_attr_e('Pricing Deals Custom Categories give you an independant way to organize your rule groups.
              Pricing Deals Categories are a custom taxonomy, which acts exactly like Product Categories.  So the Add Category function, the category participation box
              on the product page, are all the same.  The Add Pricing Deals Category page menu item hangs off of the Product menu.  The Pricing Deals Category participation box
              on the product page appears just below  the Product Category box.', 'vtprd');?>
            </p>
            <p class="faq-intro">
              <strong><?php esc_attr_e('Group pricing is made much more powerful ', 'vtprd');?></strong>
              <em><?php esc_attr_e('using Pricing Deals Custom Categories.  ', 'vtprd');?></em>
            </p>
            <p class="faq-intro">
              <?php esc_attr_e('Creating and Using a Pricing Deals Custom Category in place of a store Product Category allows you to:', 'vtprd');?>
            </p>            
            <ul id="" class="">
              <li><?php esc_attr_e('Group together any products you elect', 'vtprd');?><em><?php esc_attr_e(' outside of the product categories', 'vtprd');?></em> </li>
              <li><?php esc_attr_e('Pricing Deals Custom Categories does not affect Product Category store organization and presentation', 'vtprd');?><em><?php esc_attr_e(' in any way', 'vtprd');?></em> </li>
              <li><?php esc_attr_e('You can cherry pick products across the Store, to assemble your desired grouping', 'vtprd');?> </li>
            </ul>            
          </span>

                    

          <h4 id="">
            <?php $FAQ_title = __('Group Selection - Selection by Wholesaler, Membership or Role (Display different prices for logged in users) ', 'vtprd'); ?>
            <a id="vtprd-panel-5-help8-more" class="panel-5-anchor" href="<?php echo esc_js('javascript:void(0);');?>"><?php echo wp_kses($FAQ_title ,$allowed_html ). wp_kses('&nbsp;&nbsp;' ,$allowed_html );  ?><img class="plus-button" alt="help" height="12px" width="12px" src="<?php echo esc_url(VTPRD_URL.'/admin/images/plus-toggle2.png');?>" /></a> 
            <a id="vtprd-panel-5-help8-less" class="panel-5-anchor hideMe" href="<?php echo esc_js('javascript:void(0);');?>"><?php echo wp_kses($FAQ_title ,$allowed_html ). wp_kses('&nbsp;&nbsp;' ,$allowed_html ) .   esc_attr_e(' ... Less ', 'vtprd') . wp_kses('&nbsp;&nbsp;' ,$allowed_html )  ;  ?><img class="plus-button" alt="help" height="14px" width="14px" src="<?php echo esc_url(VTPRD_URL.'/admin/images/minus-toggle2.png');?>" /></a>                        
          </h4>
          <span id="vtprd-panel-5-help8-text" class="vtprd-panel-5-help-text-all">            
            <p class="faq-intro">
              <?php               esc_attr_e("Display different prices/pricing tiers for logged in users => Role/Membership is used within Wordpress to control access and capabilities, when a role is given to a user.  
                 Wordpress assigns certain roles by default such as Subscriber for new users or Administrator for the site's owner. Roles can also be used to associate a user 
                 with a pricing level.  Use a role management plugin like , ", 'vtprd'); 
                 $url = esc_url("http://wordpress.org/extend/plugins/user-role-editor/");
                 ?>
                 <a href="<?php echo esc_url($url);?>">
                 <?php esc_attr_e('User Role Editor', 'vtprd');?></a> 
               <?php 
               esc_attr_e("to establish custom roles, which you can give 
                 to a user or class of users.  Then you can associate that role with a Pricing Deals Rule.  
                 So when the user logs into your site, their Role interacts with the appropriate Rule.", 'vtprd');
                ?>
            </p>
            <p class="faq-intro">
              <?php esc_attr_e('Membership / Wholesaler / Customer/ Display different prices for logged in users', 'vtprd'); wp_kses('&nbsp;&nbsp;' ,$allowed_html ); esc_attr_e('Role How-To', 'vtprd');?>
            </p>            
            <ol class="directions-list">
              <li><?php esc_attr_e('Download a Role Management Plugin (like ', 'vtprd');?> <a href="<?php echo esc_url($url);?>"><?php esc_attr_e('User Role Editor', 'vtprd');?></a>) </li>
              <li><?php esc_attr_e('Set up unique Membership/Wholesale Roles using Role Management Plugin', 'vtprd');?></li>
              <li><?php esc_attr_e('Ensure shop website theme allows user to Log In to store', 'vtprd');?></li>                    
              <li><?php esc_attr_e('Assign signed-up users to appropriate Membership/Wholesale Role (', 'vtprd');?><a href="<?php echo esc_url(VTPRD_ADMIN_URL.'users.php');?>"><?php esc_attr_e('Users Screen', 'vtprd');?></a>)</li>
              <li><?php esc_attr_e('Set up Pricing Deal rule(s) which specify the appropriate Membership/Wholesale role(s) for the Buy or Get Pool', 'vtprd');?></li>
            </ol>           
          </span>
                                 
      </span><?php //end  .textarea span ?>
       
  <?php    
  }

           
  //************************************************
  // Help panel for Discount Amt Info
  //************************************************ 
  function vtprd_show_help_selection_panel_6() {  
    global $vtprd_setup_options, $vtprd_rule_template_framework, $vtprd_deal_screen_framework;
  ?>           
    <div class="selection-panel selection-panel-6" id="selection-panel-6" >                                
      <span class="selection-panel-label label"><strong><?php esc_attr_e('PLEASE READ', 'vtprd'); //Automatically Add Free Product to Cart - PLEASE READ?></strong></span>                         
      <a class="selection-panel-close selection-panel-close-6" href="<?php echo esc_js('javascript:void(0);');?>" ><img class="close-button" alt="help"  width="16" height="16" src="<?php echo esc_url(VTPRD_URL.'/admin/images/close-icon.png');?>" /></a>                     
  		<span class="selection-panel-text" >
        <span class="selection-panel-text-info">
        
        <?php
          vtprd_show_help_panel_6_text();
        ?>
       
        </span>
      </span> 
      <a class="selection-panel-close selection-panel-close-6" href="<?php echo esc_js('javascript:void(0);');?>" ><img class="close-button" alt="help"  width="16" height="16" src="<?php echo esc_url(VTPRD_URL.'/admin/images/close-icon.png');?>" /></a>
    </div>       
<?php 
   return;  
  }   
  //************************************************ 
  //Auto Add Info
  //************************************************ 
  function vtprd_show_help_panel_6_text() {               
      $allowed_html = vtprd_get_allowed_html(); //v2.0.3
      ?>
          <span class="infoSection">
            <span class="textarea">
              
              <h4 class="discount-help-title"><?php esc_attr_e('Auto Adds work differently with Coupons.', 'vtprd');?></h4>
              <ul class="directions-list">
                <li><?php esc_attr_e('- For Auto Adds, "Apply this Rule Discount in Addition to Coupon Discount" must be "Yes" .', 'vtprd');
                          ?><br> &nbsp;&nbsp;<em><?php 
                          esc_attr_e(' The FREE Auto Add takes place and any Coupon presented is skipped for the Free Product only... ', 'vtprd');
                          ?></em><?php
                     ?> 
                </li>
              </ul> 
              
              <h4 class="discount-help-title"><?php esc_attr_e('Automatically Add Free Product to Cart WORKS BEST with the following configurations:', 'vtprd');?></h4>
             
              <ul class="directions-list">
                <li><?php esc_attr_e('- Buy and Get(Discount) Groups are COMPLETELY Different', 'vtprd'); 
                          ?>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<?php
                          esc_attr_e('("Buy a Laptop, Get a FREE Mouse")', 'vtprd');
                     ?>
                </li> 
                <li><?php  ?>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<?php  esc_attr_e(' (or) ');?></li>
                <li><?php esc_attr_e('- Buy and Get Groups are EXACTLY the same product', 'vtprd');
                          ?> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<?php 
                          esc_attr_e('("Buy WidgetX, get the next WidgetX FREE")', 'vtprd');
                          ?> <br> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<?php
                          esc_attr_e('(Both BUY and GET Groups must select the SAME individual product, as a single variation or single product)', 'vtprd');                    
                     ?> 
                </li>
                <li> &nbsp; </li>
                <li><?php esc_attr_e('- Please NOTE that there is a settings switch which controls BOGO Auto Add behavior:', 'vtprd');              
                     ?> 
                </li>
                <li> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp; 
                     <?php
                       esc_attr_e('"BOGO Behavior for Auto Add of Same Product"', 'vtprd');              
                     ?> 
                </li>                

              </ul>               
             </span>
                                   
          </span>
      
    <?php 
  }
           
  //************************************************
  // Help panel for Template Dropdown
  //************************************************ 
  function vtprd_show_help_selection_panel_A($k) {  
    global $vtprd_setup_options, $vtprd_rule_template_framework;
    $allowed_html = vtprd_get_allowed_html(); //v2.0.3
    $counter = 0;   
    for($i=0; $i < sizeof($vtprd_rule_template_framework['option']); $i++) {   //run through the whole array!!
      //skip if "please enter"     
      if ( $vtprd_rule_template_framework['option'][$i]['value'] == '')  {
         continue; //skip this iteration
      }

     switch( true ) {
        case $counter == 0:
            $subtitle = '';
          break;
        case (($counter > 0) && ($counter <= 4)):
            $subtitle = 'Discount Type - Realtime Product Display Discount';
          break;
        default:
            $subtitle = 'Discount Type - Add to Cart Discount';
            if (($counter >= 8) && 
                ($counter <= 10)) {
              $subtitle .= ', Applied within Product(s) Already in Cart';   
            } else {
              $subtitle .= ', Applied to Next Product(s) Added to Cart';
            }             
          break;  
     }   
  /*      
      if ($counter <= 4) {
        $subtitle = 'Discount Type - Realtime Product Display Discount';
      } else {
        $subtitle = 'Discount Type - Add to Cart Discount';
        if (($counter >= 8) && 
            ($counter <= 10)) {
          $subtitle .= ', Applied within Product(s) Already in Cart';   
        } else {
          $subtitle .= ', Applied to Next Product(s) Added to Cart';
        }    
      }  */
      ?>                                   
       
        <div class="selection-panel selection-panel-A  selection-panel-A-<?php echo wp_kses($counter ,$allowed_html ); ?>" 
              id="selection-panel-A-<?php echo wp_kses($counter ,$allowed_html ) . '-' . wp_kses($k ,$allowed_html );?>" >                                
          <span class="selection-panel-label label"><strong><?php esc_attr_e('Template Chosen:', 'vtprd');?></strong></span>                         
          <a class="selection-panel-close selection-panel-close-A" href="<?php echo esc_js('javascript:void(0);');?>" ><img class="close-button" alt="help"  width="16" height="16" src="<?php echo esc_url(VTPRD_URL.'/admin/images/close-icon.png');?>" /> </a>
          <span class="selection-panel-template"><?php echo wp_kses($vtprd_rule_template_framework['option'][$i]['title'] ,$allowed_html ); ?></span>
          <span class="selection-panel-subtitle"><?php echo wp_kses($subtitle ,$allowed_html ); ?></span>                       
      		<span class="selection-panel-text" >
            <span class="selection-panel-text-title"><?php esc_attr_e('Description', 'vtprd');?></span>
            <span class="selection-panel-text-info">
            
            <?php
              vtprd_show_help_panel_A_text($vtprd_rule_template_framework['option'][$i]['value']);
            ?>
           
            </span>
          </span>
          <a class="selection-panel-close  clear-left  selection-panel-close-A" href="<?php echo esc_js('javascript:void(0);');?>" ><img class="close-button" alt="help"  width="16" height="16" src="<?php echo esc_url(VTPRD_URL.'/admin/images/close-icon.png');?>" /> </a>          
        </div>
       
       <?php 
       $counter++; 
    } //end of for loop 
   return;  
  }    
          
  //************************************************
  // Help panel for Template Dropdown
  //************************************************ 
  function vtprd_show_help_panel_A_text($key_value) { 
    $allowed_html = vtprd_get_allowed_html(); //v2.0.3     
    switch($key_value) {
      //display templates
      case '0':  //  Please choose
          ?>  
            <span class="textarea"> <?php                          
              esc_attr_e('The Pricing Deal Plugin is driven by Template choice.  Templates fall under two main categories:', 'vtprd'); 
          ?> 
            </span>
            <ol class="directions-list">
              <li><?php esc_attr_e('Realtime product price reduction, which immediately shows the price reduction to the ', 'vtprd'); echo wp_kses('<em>',$allowed_html ); esc_attr_e('logged-in Customer', 'vtprd'); echo wp_kses('</em>',$allowed_html ); esc_attr_e('.  This gives you the ability to
                    offer pricing tiers based via Membership or for the Wholesaler.', 'vtprd');?> </li>
              <li><?php esc_attr_e('Discounts which are applied after the product has been Added to Cart.', 'vtprd');?></li>
            </ol>
            
            <span class="textarea"> <?php                          
              esc_attr_e('The Template Choices Break down as follows:', 'vtprd'); 
          ?> 
            </span>
            
            <ol class="directions-list"><span class="ol-title"><?php esc_attr_e('Simple Realtime Discounts, Limited to a percent or $$ value discount', 'vtprd');?></span> <br>
              <li><?php esc_attr_e('Store-Wide Sale with a Percentage or $$ Value Off all Products in the Cart', 'vtprd');?> </li>
              <li><?php esc_attr_e('Membership / Wholesaler Discount /Display different prices for logged in users for all Products in the Buy Pool Group', 'vtprd');?></li>
              <li><?php esc_attr_e('Simple Discount by any Buy Pool Group Criteria [Product / Category / Pricing Deal Category / Membership / Wholesale]', 'vtprd');?></li>
            </ol>
            
            <ol class="directions-list"><span class="ol-title"><?php esc_attr_e('Simple Add to Cart Discounts, Limited to simple discounts and Buy Pool options', 'vtprd');?></span> <br>
              <li><?php esc_attr_e('Store-Wide Sale with a Percentage or $$ Value Off all Products in the Cart', 'vtprd');?> </li>
              <li><?php esc_attr_e('Membership / Wholesaler Discount /Display different prices for logged in users for all Products in the Buy Pool Group', 'vtprd');?></li>
              <li><?php esc_attr_e('Simple Discount by any Buy Pool Group Criteria [Product / Category / Pricing Deal Category / Membership / Wholesale]', 'vtprd');?></li>
            </ol>
            
            <ol class="directions-list"><span class="ol-title"><?php esc_attr_e('Add to Cart Discounts, Where the discount is applied to ', 'vtprd'); echo wp_kses('<em>',$allowed_html ); esc_attr_e('items already in the Cart', 'vtprd'); echo wp_kses('</em>',$allowed_html ); ?></span> <br>
              <li><?php esc_attr_e('Buy 5/$500, get a discount for Some/All 5', 'vtprd');?> </li>
              <li><?php esc_attr_e('Buy 5, get them for the price of 4', 'vtprd');?></li>
              <li><?php esc_attr_e('Buy 5/$500, get the cheapest/most expensive at a discount', 'vtprd');?></li>
            </ol>
            
            <ol class="directions-list"><span class="ol-title"><?php esc_attr_e('Add to Cart Discounts, Where the discount is applied to the ', 'vtprd'); echo wp_kses('<em>',$allowed_html ); esc_attr_e('NEXT Items added to the Cart', 'vtprd'); echo wp_kses('</em>',$allowed_html );?></span> <br>
              <li><?php esc_attr_e('Buy 5/$500, get a discount on Next 4/$400', 'vtprd');?> </li>
              <li><?php esc_attr_e('Buy 5/$500, get next 3 for the price of 2 [Group Pricing]', 'vtprd');?></li>
              <li><?php esc_attr_e('Buy 5/$500, get a discount on the cheapest/most expensive in next 5/$500 purchased', 'vtprd');?></li>
              <li><?php esc_attr_e('Buy 5/$500, get the Next Nth at a discount', 'vtprd');?></li>
            </ol>
                        
                             
            <span class="textarea"> <?php                          
              esc_attr_e('Sale Information and Messages can be added to your Website Theme, using the "echo do_action" syntax discussed in the documentation and the readme.', 'vtprd');    
              ?><br><?php
              esc_attr_e('The plugin offers the following additonal theme-available info:', 'vtprd'); 
          ?> 
            </span>
            <ol class="directions-list">
              <li><?php esc_attr_e('Discount Full Message for participating products (where the product is either in the "Buy" or "Get" groups)');?> </li>
              <li><?php esc_attr_e('"Yousave At Checkout" Amount, if the rule applies to the Cart.', 'vtprd');?></li>
              <li><?php esc_attr_e('Discount Short Message at checkout.', 'vtprd');?></li>
              <li><?php esc_attr_e('Full breakdown of the discount applied to each product for each rule, or a simple discount totals amount.', 'vtprd');?></li>
            </ol>
          <?php      
       break;
     case 'D-storeWideSale':  //  Store-Wide Sale
              esc_attr_e('Realtime price discount applied across the whole store.', 'vtprd');
              ?><br><?php
              esc_attr_e('The price reduction created by this Rule takes place as the product is displayed on the website.  Original price, yousave amount and the Long Rule Description are available to the
              theme using the "echo do_action" syntax discussed in the documentation and the readme,
              so that you can display this info to the customer, informing them of the discount available to them.', 'vtprd');    
       break;       
      case 'D-simpleDiscount':  // Simple Discount by any Buy Pool Group Criteria          
          ?>  <span class="textarea"> <?php                          
              esc_attr_e('This selection allows you to create a rule for any Buy pool criteria:', 'vtprd'); 
          ?>   
            </span
            <ol class="directions-list">
              <li><?php esc_attr_e('By Category or Pricing Deal Category / and/or / Membership/Wholesale Role (Display different prices for logged in users)', 'vtprd');?></li>
              <li><?php esc_attr_e('By Product or Product Variations', 'vtprd');?></li>
            </ol>
            <span class="textarea">                       
           <?php
           esc_attr_e('The price reduction created by this Rule takes place as the product is displayed on the website.  Original price, yousave amount and the Long Rule Description are available to the
            theme using the "echo do_action" syntax discussed in the documentation and the readme,
              so that you can display this info to the customer, informing them of the discount available to them.', 'vtprd');
          ?> </span> <?php
        break; 
      case 'D00-N5':  // UpCharge by any Buy Pool Group Criteria          
          ?>  <span class="textarea"> <?php                          
              esc_attr_e('UpCharge (price increase) applied across the whole store (Great for Variations UpCharge):', 'vtprd'); 
          ?>   
            </span>
            <ol class="directions-list">
              <li><?php esc_attr_e('By Category or Pricing Deal Category / and/or / Membership/Wholesale Role (Display different prices for logged in users)', 'vtprd');?></li>
              <li><?php esc_attr_e('By Product or Product Variations', 'vtprd');?></li>
            </ol>
            <span class="textarea">                       
           <?php
           esc_attr_e('The Price UpCharge created by this Rule takes place as the product is displayed on the website.', 'vtprd');
          ?> </span> <?php
        break;         
      case 'C-storeWideSale':  // Store-Wide Sale
              esc_attr_e('Realtime price discount applied across the whole store.', 'vtprd'); 
               ?><br><?php
               esc_attr_e('The price reduction created by this Rule takes place at Add to Cart time.  Long Rule Description, whose display indicates that the product participates in a Pricing Deal, is available to the
              theme (at all times) using the "echo do_action" syntax discussed in the documentation and the readme,
              so that you can display this info to the customer, informing them of the discount available to them.', 'vtprd');    
       break; 
      case 'C-simpleDiscount':  //  Simple Discount by any Buy Pool Group Criteria          
          ?>  <span class="textarea"> <?php                          
              esc_attr_e('This selection allows you to create a rule for any Buy pool criteria:', 'vtprd'); 
          ?>   
            </span>
            <ol class="directions-list">
              <li><?php esc_attr_e('By Category or Pricing Deal Category / and/or / Membership/Wholesale Role (Display different prices for logged in users)', 'vtprd');?></li>
              <li><?php esc_attr_e('By Product or Product Variations', 'vtprd');?></li>
            </ol>
            <span class="textarea">                      
           <?php
            esc_attr_e('The price reduction created by this Rule takes place at Add to Cart time.  Long Rule Description, whose display indicates that the product participates in a Pricing Deal, is available to the
              theme (at all times) using the "echo do_action" syntax discussed in the documentation and the readme,
              so that you can display this info to the customer, informing them of the discount available to them.', 'vtprd');
          ?> </span> <?php
        break; 
      case 'C-discount-inCart':  //   Buy 5/$500, get a discount for Some/All 5         
          ?>  <span class="textarea"> <?php                          
              esc_attr_e('This selection allows you to define a Buy Group activation amount and then define how many of that group get the discount, and how it is applied.', 'vtprd'); 
          ?>   
            </span>
            <ol class="directions-list">
              <li><?php esc_attr_e('Activation amount example: 5 units or $500', 'vtprd');?></li>
              <li><?php esc_attr_e('Result example: "Buy $500 of computer items, get 10% off (all of them)" = $50 off of total bill', 'vtprd');?></li>
              <li><?php esc_attr_e('Result example: "Buy $500 of computer items, get 10% off (one of them)" = up to $50 off of total bill, depending on item purchase price - applied to 1st product in group', 'vtprd');?></li>
            </ol>
            <span class="textarea">                      
           <?php
            esc_attr_e('The price reduction created by this Rule takes place at Add to Cart time.  Long Rule Description, whose display indicates that the product participates in a Pricing Deal, is available to the
               theme (at all times) using the "echo do_action" syntax discussed in the documentation and the readme,
              so that you can display this info to the customer, informing them of the discount available to them.', 'vtprd');
          ?> </span> <?php
        break;
      case 'C-forThePriceOf-inCart':  // Buy 5, get them for the price of 4 - Cart 
          ?>  <span class="textarea"> <?php                          
              esc_attr_e('5 for the price of 4 is a group purchase option, but with a difference. Here, the deal price is computed based on a percentage of the cost of the group total', 'vtprd');
              ?><br><?php
              esc_attr_e('For example, if 5 items of equal cost are purchased, each costing $100.  The Deal price would be 80% of the total, or $400.', 'vtprd'); 
          ?>   
              </span>
           <?php             
        break;
      case 'C-cheapest-inCart':  //  Buy 5/$500, get a discount for Some/All 5 -Cart         
          ?>  <span class="textarea"> <?php                          
              esc_attr_e('This is the most basic kind of group purchase. Here, the deal price pre-figured discount within the group purchased.', 'vtprd');
              ?><br><?php
              esc_attr_e('Example 1: buy 5 units, get $20 off of 2 items.', 'vtprd');
              ?><br><?php
              esc_attr_e('Example 2: buy 5 specific items, get them for a fixed group price - True Group Pricing.', 'vtprd'); 
          ?>   
              </span>
           <?php         
        break;                
      case 'C-discount-Next':  // occurrence 8, matches "C-discount-Next"   Buy 5/$500, get a discount on Next 4/$400 - Cart        
          ?>  <span class="textarea"> <?php                          
              esc_attr_e('Dummy Text', 'vtprd'); 
          ?>   
              </span>
           <?php              
        break;
      case 'C-forThePriceOf-Next':  // occurrence 8, matches "C-forThePriceOf-Next"   Buy 5/$500, get next 3 for the price of 2 - Cart        
          ?>  <span class="textarea"> <?php                          
              esc_attr_e('Dummy Text', 'vtprd'); 
          ?>   
              </span>
           <?php  
        break;
      case 'C-cheapest-Next':  // occurrence 8, matches "C-cheapest-Next"   Buy 5/$500, get a discount on the cheapest/most expensive when next 5/$500 purchased - Cart        
          ?>  <span class="textarea"> <?php                          
              esc_attr_e('Dummy Text', 'vtprd'); 
          ?>   
              </span>
           <?php          
        break;
      case 'C-nth-Next':  // occurrence 8, matches "C-nth-Next"   Buy 5/$500, get the following Nth at a discount - Cart         
          ?>  <span class="textarea"> <?php                          
              esc_attr_e('Dummy Text', 'vtprd'); 
          ?>   
              </span>
           <?php          
        break;        
    }
  
  } 
 
           
  //************************************************
  // Help panel for Buy amount condition type Dropdown
  //************************************************ 
  function vtprd_show_help_selection_panel_B($k) {  
    global $vtprd_setup_options, $vtprd_rule_template_framework, $vtprd_deal_screen_framework;
    $allowed_html = vtprd_get_allowed_html(); //v2.0.3
    for($i=0; $i < sizeof($vtprd_deal_screen_framework['buy_amt_type']['option']); $i++)  {   //run through the whole array!!
      ?>           
        <div class="selection-panel selection-panel-B  selection-panel-B-<?php echo wp_kses($i ,$allowed_html ); ?>" id="selection-panel-B-<?php echo wp_kses($i ,$allowed_html ) . '-' . wp_kses($k ,$allowed_html );?>" >                                
          <span class="selection-panel-label label"><strong><?php esc_attr_e('Buy Type Chosen:', 'vtprd');?></strong></span>                         
          <a class="selection-panel-close selection-panel-close-B" href="<?php echo esc_js('javascript:void(0);');?>" ><img class="close-button" alt="help"  width="16" height="16" src="<?php echo esc_url(VTPRD_URL.'/admin/images/close-icon.png');?>" /></a>
          <span class="selection-panel-template"><?php echo wp_kses($vtprd_deal_screen_framework['buy_amt_type']['option'][$i]['title'] ,$allowed_html ); ?></span>                      
      		<span class="selection-panel-text" >
            <span class="selection-panel-text-title"><?php esc_attr_e('Description', 'vtprd');?></span>
            <span class="selection-panel-text-info">
            
            <?php
              vtprd_show_help_panel_B_text($i);
            ?>
           
            </span>
          </span> 
        </div>       
       <?php 
    } //end of for loop 
   return;  
  }   
 
  function vtprd_show_help_panel_B_text($i) {          
    switch($i) {
      //display templates
      case '0':  // No Buy Condition (rule applies to entire Buy pool)
              esc_attr_e('Rule applies against all individual product units in the Buy pool.', 'vtprd');    
        break;
      case '1':  // Buy One
              esc_attr_e('Rule applies to each single product unit in the Buy Pool. ', 'vtprd');    
        break;
      case '2':  // Buy Unit Quantity 
              esc_attr_e('Rule applies to a quantity of individual products, or a quantity across the all the products, in the Buy Pool.', 'vtprd');    
        break;
      case '3':  // Buy $$ Value
              esc_attr_e('Rule applies to a $$ value of individual products, or a quantity across the all the products, in the Buy Pool.', 'vtprd');    
        break;
      case '4':  // Buy Each Nth Unit 
              esc_attr_e('Rule applies to every Nth unit count of individual products, or a quantity across the all the products, in the Buy Pool.', 'vtprd');
              ?><br><?php
              esc_attr_e('Please note that the "Each Nth" option does not by definition repeat multiple times, but as in all other rule types, 
                  the repetition is controlled by the  Rule Usage Count Amt.', 'vtprd');    
        break;           
    }
  }
       
           
  //************************************************
  // Help panel for Buy amount condition applies to Dropdown
  //************************************************ 
  function vtprd_show_help_selection_panel_C($k) {  
    global $vtprd_setup_options, $vtprd_rule_template_framework, $vtprd_deal_screen_framework;
    $allowed_html = vtprd_get_allowed_html(); //v2.0.3
    for($i=0; $i < sizeof($vtprd_deal_screen_framework['buy_amt_applies_to']['option']); $i++)  {   //run through the whole array!!
      ?>           
        <div class="selection-panel selection-panel-C  selection-panel-C-<?php echo wp_kses($i ,$allowed_html ); ?>" id="selection-panel-C-<?echo wp_kses($i ,$allowed_html ) . '-' . wp_kses($k ,$allowed_html );?>" >                                
          <span class="selection-panel-label label"><strong><?php esc_attr_e('Buy Amount "Applies To" Chosen:', 'vtprd');?></strong></span>                         
          <a class="selection-panel-close selection-panel-close-C" href="<?php echo esc_js('javascript:void(0);');?>" ><img class="close-button" alt="help"  width="16" height="16" src="<?php echo esc_url(VTPRD_URL.'/admin/images/close-icon.png');?>" /></a>
          <span class="selection-panel-template"><?php echo wp_kses($vtprd_deal_screen_framework['buy_amt_applies_to']['option'][$i]['title'] ,$allowed_html );?></span>                      
      		<span class="selection-panel-text" >
            <span class="selection-panel-text-title"><?php esc_attr_e('Description', 'vtprd');?></span>
            <span class="selection-panel-text-info">
            
            <?php
              vtprd_show_help_panel_C_text($i);
            ?>
           
            </span>
          </span> 
        </div>       
       <?php 
    } //end of for loop 
   return;  
  }    
 
  function vtprd_show_help_panel_C_text($i) {          
    switch($i) {
      //display templates
      /*  NO LONGER EXISTS!!!!!!   FIX!!!!!!!!
      case '0':  // All Buy pool products in the cart as a group
              esc_attr_e('The rule Buy Amount applies to all Buy products in the cart as a group total', 'vtprd');    
        break;  */
      case '1':  // Each Buy pool product quantity total in the cart
              esc_attr_e('The rule Buy Amount applies to all Buy products in the cart as individual product quantity totals', 'vtprd');     
        break;        
    }
  }

           
  //************************************************
  // Help panel for Get amount condition type Dropdown
  //************************************************ 
  function vtprd_show_help_selection_panel_D($k) {  
    global $vtprd_setup_options, $vtprd_rule_template_framework, $vtprd_deal_screen_framework;
    $allowed_html = vtprd_get_allowed_html(); //v2.0.3
    
    for($i=0; $i < sizeof($vtprd_deal_screen_framework['action_amt_type']['option']); $i++)  {   //run through the whole array!!
      ?>           
        <div class="selection-panel selection-panel-D  selection-panel-D-<?php echo wp_kses($i ,$allowed_html ); ?>" id="selection-panel-D-<?php echo wp_kses($i ,$allowed_html ) . '-' . wp_kses($k ,$allowed_html );?>" >                                
          <span class="selection-panel-label label"><strong><?php esc_attr_e('Get Amount Type Chosen:', 'vtprd');?></strong></span>                         
          <a class="selection-panel-close selection-panel-close-D" href="<?php echo esc_js('javascript:void(0);');?>" ><img class="close-button" alt="help"  width="16" height="16" src="<?php echo esc_url(VTPRD_URL.'/admin/images/close-icon.png');?>" /></a>
          <span class="selection-panel-template"><?php echo wp_kses($vtprd_deal_screen_framework['buy_amt_applies_to']['option'][$i]['title'] ,$allowed_html ); ?></span>                      
      		<span class="selection-panel-text" >
            <span class="selection-panel-text-title"><?php esc_attr_e('Description', 'vtprd');?></span>
            <span class="selection-panel-text-info">
            
            <?php
              vtprd_show_help_panel_D_text($i);
            ?>
           
            </span>
          </span> 
        </div>       
       <?php 
    } //end of for loop 
   return;  
  }   
 
  function vtprd_show_help_panel_D_text($i) {          
    switch($i) {
      //display templates
      case '0':  // No Get Condition (rule applies to entire Get pool)
              esc_attr_e('Rule applies against all individual product units in the Get pool.
              ', 'vtprd');    
        break;
      case '1':  // Get this one
              esc_attr_e('Rule applies to the single product unit in the Buy Pool which is current.
              For example, every 5th purchase gets 10% off.  ("action pool same as buy pool" is required). ', 'vtprd');    
        break;
      case '2':  // Get next one
              esc_attr_e('Rule applies to next single product unit in the Get Pool. ', 'vtprd');    
        break;
      case '3':  // Get next Unit Quantity 
              esc_attr_e('Rule applies to a quantity of individual products, or a quantity across the all the products, in the Get Pool.', 'vtprd');    
        break;
      case '4':  // Get next $$ Value
              esc_attr_e('Rule applies to a $$ value of individual products, or a quantity across the all the products, in the Get Pool.', 'vtprd');    
        break;
      case '5':  // Get Each Nth Unit 
              esc_attr_e('Rule applies to every Nth unit count of individual products, or a quantity across the all the products, in the Get Pool.', 'vtprd');
              ?><br><?php
              esc_attr_e('Please note that the "Each Nth" option does not by definition repeat multiple times, but as in all other rule types, 
              the repetition is controlled by the  Get Pool Repeat Amt.', 'vtprd');    
        break;           
    }
  }
           
  
  //************************************************
  // Help panel for action amount condition applies to Dropdown
  //************************************************ 
  function vtprd_show_help_selection_panel_E($k) {  
    global $vtprd_setup_options, $vtprd_rule_template_framework, $vtprd_deal_screen_framework;
    $allowed_html = vtprd_get_allowed_html(); //v2.0.3
    
    for($i=0; $i < sizeof($vtprd_deal_screen_framework['action_amt_applies_to']['option']); $i++)  {   //run through the whole array!!
      ?>           
        <div class="selection-panel selection-panel-E  selection-panel-E-<?php echo wp_kses($i ,$allowed_html ); ?>" id="selection-panel-E-<?php echo wp_kses($i ,$allowed_html ) . '-' . wp_kses($k ,$allowed_html );?>" >                                
          <span class="selection-panel-label label"><strong><?php esc_attr_e('Get Amount "Applies To" Chosen:', 'vtprd');?></strong></span>                         
          <a class="selection-panel-close selection-panel-close-E" href="<?php echo esc_js('javascript:void(0);');?>" ><img class="close-button" alt="help"  width="16" height="16" src="<?php echo esc_url(VTPRD_URL.'/admin/images/close-icon.png');?>" /></a>
          <span class="selection-panel-template"><?php echo wp_kses($vtprd_deal_screen_framework['action_amt_applies_to']['option'][$i]['title'] ,$allowed_html ); ?></span>                      
      		<span class="selection-panel-text" >
            <span class="selection-panel-text-title"><?php esc_attr_e('Description', 'vtprd');?></span>
            <span class="selection-panel-text-info">
            
            <?php
              vtprd_show_help_panel_E_text($i);
            ?>
           
            </span>
          </span> 
        </div>       
       <?php 
    } //end of for loop 
   return;  
  }    
 
  function vtprd_show_help_panel_E_text($i) {          
    switch($i) {
      //display templates
      case '0':  // All action pool products in the cart as a group
              esc_attr_e('The rule action Amount applies to all Get products in the cart as a group total.', 'vtprd');    
        break;
      case '1':  // Each action pool product quantity total in the cart
              esc_attr_e('The rule action Amount applies to all Get products in the cart as individual product quantity totals.', 'vtprd');     
        break;        
    }
  }

  
  //************************************************
  // Help panel for Discount Amount
  //************************************************ 
  function vtprd_show_help_selection_panel_F($k) {  
    global $vtprd_setup_options, $vtprd_rule_template_framework, $vtprd_deal_screen_framework;
    $allowed_html = vtprd_get_allowed_html(); //v2.0.3
    
    for($i=0; $i < sizeof($vtprd_deal_screen_framework['discount_amt_type']['option']); $i++)  {   //run through the whole array!!
      ?>           
        <div class="selection-panel selection-panel-F  selection-panel-F-<?php echo wp_kses($i ,$allowed_html ); ?>" id="selection-panel-F-<?php echo wp_kses($i ,$allowed_html ) . '-' . wp_kses($k ,$allowed_html );?>" >                                
          <span class="selection-panel-label label"><strong><?php esc_attr_e('Discount Amount Type Chosen:', 'vtprd');?></strong></span>                         
          <a class="selection-panel-close selection-panel-close-F" href="<?php echo esc_js('javascript:void(0);');?>" ><img class="close-button" alt="help"  width="16" height="16" src="<?php echo esc_url(VTPRD_URL.'/admin/images/close-icon.png');?>" /></a>
          <span class="selection-panel-template"><?php echo wp_kses($vtprd_deal_screen_framework['discount_amt_type']['option'][$i]['title'] ,$allowed_html ); ?></span>                      
      		<span class="selection-panel-text" >
            <span class="selection-panel-text-title"><?php esc_attr_e('Description', 'vtprd');?></span>
            <span class="selection-panel-text-info">
            
            <?php
              vtprd_show_help_panel_F_text($i);
            ?>
           
            </span>
          </span> 
        </div>       
       <?php 
    } //end of for loop 
   return;  
  }    
 
  function vtprd_show_help_panel_F_text($i) {          
    switch($i) {
      //display templates
      case '0':  // Please enter...
              esc_attr_e('Please choose a discount type.', 'vtprd');    
        break;
      case '1':  // Percentage Off Discount
              esc_attr_e('Offer a Percentage Off Discount', 'vtprd');
              ?><br><?php
              esc_attr_e('Long Rule Description is available to the theme using the "echo do_action" syntax discussed in the documentation and the readme,
              so that you can display the Pricing Deal Message to the customer, informing them of the discount available to them.', 'vtprd');    
        break;
      case '2':  // Currency Amount Discount
              esc_attr_e('Offer a fixed Currency Amount Discounted.', 'vtprd');
              ?><br><?php
              esc_attr_e('Long Rule Description is available to the theme using the "echo do_action" syntax discussed in the documentation and the readme,
              so that you can display the Pricing Deal Message to the customer, informing them of the discount available to them.', 'vtprd');     
        break;
      case '3':  // Set a Discounted Fixed Price
              esc_attr_e('Set a Discounted Fixed Price.', 'vtprd');
              ?><br><?php
              esc_attr_e('Long Rule Description is available to the theme using the "echo do_action" syntax discussed in the documentation and the readme,
              so that you can display the Pricing Deal Message to the customer, informing them of the discount available to them.', 'vtprd');     
        break;        
      case '4':  // Free
              esc_attr_e('Offer a product for Free in this Discount.', 'vtprd');
              ?><br><?php
              esc_attr_e('Long Rule Description is available to the theme using the "echo do_action" syntax discussed in the documentation and the readme,
              so that you can display the Pricing Deal Message to the customer, informing them of the discount available to them.', 'vtprd');     
        break;        
      case '5':  // For the Price of (Units) Discount ["Buy 5 for the price of 4"]
              esc_attr_e('Group Pricing, "Buy 5 for the price of 4".', 'vtprd');
              ?><br><?php
              esc_attr_e('Long Rule Description is available to the theme using the "echo do_action" syntax discussed in the documentation and the readme,
              so that you can display the Pricing Deal Message to the customer, informing them of the discount available to them.', 'vtprd');     
        break;                   
    }
  }
 
  
  //************************************************
  // Help panel for Discount Applies To
  //************************************************ 
  function vtprd_show_help_selection_panel_G($k) {  
    global $vtprd_setup_options, $vtprd_rule_template_framework, $vtprd_deal_screen_framework;
    $allowed_html = vtprd_get_allowed_html(); //v2.0.3
    
    for($i=0; $i < sizeof($vtprd_deal_screen_framework['discount_amt_type']['option']); $i++)  {   //run through the whole array!!
      ?>           
        <div class="selection-panel selection-panel-G  selection-panel-G-<?php echo wp_kses($i ,$allowed_html ); ?>" id="selection-panel-G-<?php echo wp_kses($i ,$allowed_html ) . '-' . wp_kses($k ,$allowed_html );?>" >                                
          <span class="selection-panel-label label"><strong><?php esc_attr_e('Discount "Applies To" Chosen:', 'vtprd');?></strong></span>                         
          <a class="selection-panel-close selection-panel-close-G" href="<?php echo esc_js('javascript:void(0);');?>" ><img class="close-button" alt="help"  width="16" height="16" src="<?php echo esc_url(VTPRD_URL.'/admin/images/close-icon.png');?>" /></a>
          <span class="selection-panel-template"><?php echo wp_kses($vtprd_deal_screen_framework['discount_applies_to']['option'][$i]['title'] ,$allowed_html ); ?></span>                      
      		<span class="selection-panel-text" >
            <span class="selection-panel-text-title"><?php esc_attr_e('Description', 'vtprd');?></span>
            <span class="selection-panel-text-info">
            
            <?php
              vtprd_show_help_panel_G_text($i);
            ?>
           
            </span>
          </span> 
        </div>       
       <?php 
    } //end of for loop 
   return;  
  }    
 
  function vtprd_show_help_panel_G_text($i) {          
    switch($i) {
      case '0':  //   Each Product in the Get Pool 
              esc_attr_e('Please enter a "Discount applies to" value', 'vtprd');    
        break;
      case '1':  //   Each Product in the Get Pool 
              esc_attr_e('Apply Discount to Each individual Product in the Get Pool', 'vtprd');    
        break;
      case '2':  //   All Products in the Get Pool 
              esc_attr_e('Apply Discount to All Products in the Get Pool as a Group', 'vtprd');    
        break;
      case '3':  //   Cheapest Product in the Get Pool 
              esc_attr_e('Apply Discount to the Cheapest Product in the Get Pool', 'vtprd');   
        break;        
      case '4':  //   Most Expensive Product in the Get Pool 
              esc_attr_e('Apply Discount to the Most Expensive Product in the Get Pool', 'vtprd');     
        break;                          
    }
  }

  
  //************************************************
  // Help panel for Discount Maximum for Rule across the Cart
  //************************************************ 
  function vtprd_show_help_selection_panel_H($k) {  
    global $vtprd_setup_options, $vtprd_rule_template_framework, $vtprd_deal_screen_framework;
    $allowed_html = vtprd_get_allowed_html(); //v2.0.3
    
    for($i=0; $i < sizeof($vtprd_deal_screen_framework['discount_rule_max_amt_type']['option']); $i++)  {   //run through the whole array!!
      ?>           
        <div class="selection-panel selection-panel-H  selection-panel-H-<?php echo wp_kses($i ,$allowed_html ); ?>" id="selection-panel-H-<?php echo wp_kses($i ,$allowed_html ) . '-' . wp_kses($k ,$allowed_html );?>" >                                
          <span class="selection-panel-label label"><strong><?php esc_attr_e('Discount Rule Maximum Type Chosen:', 'vtprd');?></strong></span>                         
          <a class="selection-panel-close selection-panel-close-H" href="<?php echo esc_js('javascript:void(0);');?>" ><img class="close-button" alt="help"  width="16" height="16" src="<?php echo esc_url(VTPRD_URL.'/admin/images/close-icon.png');?>" /></a>
          <span class="selection-panel-template"><?php echo wp_kses($vtprd_deal_screen_framework['discount_rule_max_amt_type']['option'][$i]['title'] ,$allowed_html ); ?></span>                      
      		<span class="selection-panel-text" >
            <span class="selection-panel-text-title"><?php esc_attr_e('Description', 'vtprd');?></span>
            <span class="selection-panel-text-info">
            
            <?php
              vtprd_show_help_panel_H_text($i);
            ?>
           
            </span>
          </span> 
        </div>       
       <?php 
    } //end of for loop 
   return;  
  }    
 
  function vtprd_show_help_panel_H_text($i) {          
    switch($i) {
      //display templates
      case '0':  //     No Discount Rule Max  
              esc_attr_e('No Cart-level Discount Rule Maximum', 'vtprd');    
        break;
      case '1':  //     Maximum Percentage Discount Value for the rule across the cart - Rule Max  
              esc_attr_e('Cart-level Percentage Rule Maximum purchase', 'vtprd');    
        break;        
      case '2':  //     Maximum Number of times the Discount may be employed for the rule across the cart - Rule Max   
              esc_attr_e('Cart-level maximum Product occurrences allowed for rule.  Limits how many times the rule discount can be applied across the cart.', 'vtprd');    
        break;
      case '3':  //     Maximum $$ Value Discount the rule may create across the cart  - Rule Max 
              esc_attr_e('Cart-level $$ maximum allowed for rule.  Limits the dollar value total discount for the rule which can be applied across the cart.', 'vtprd');   
        break;                                 
    }
  }

  
  //************************************************
  // Help panel for Lifetime Discount Maximum for Rule
  //************************************************ 
  function vtprd_show_help_selection_panel_I($k) {  
    global $vtprd_setup_options, $vtprd_rule_template_framework, $vtprd_deal_screen_framework;
    $allowed_html = vtprd_get_allowed_html(); //v2.0.3

    for($i=0; $i < sizeof($vtprd_deal_screen_framework['discount_lifetime_max_amt_type']['option']); $i++)  {   //run through the whole array!!
      ?>           
        <div class="selection-panel selection-panel-I  selection-panel-I-<?php echo wp_kses($i ,$allowed_html ); ?>" id="selection-panel-I-<?php echo wp_kses($i ,$allowed_html ) . '-' . wp_kses($k ,$allowed_html );?>" >                                
          <span class="selection-panel-label label"><strong><?php esc_attr_e('Discount Rule Maximum Amount Type Chosen:', 'vtprd');?></strong></span>                         
          <a class="selection-panel-close selection-panel-close-I" href="<?php echo esc_js('javascript:void(0);');?>" ><img class="close-button" alt="help"  width="16" height="16" src="<?php echo esc_url(VTPRD_URL.'/admin/images/close-icon.png');?>" /></a>
          <span class="selection-panel-template"><?php echo wp_kses($vtprd_deal_screen_framework['discount_lifetime_max_amt_type']['option'][$i]['title'] ,$allowed_html ); ?></span>                      
      		<span class="selection-panel-text" >
            <span class="selection-panel-text-title"><?php esc_attr_e('Description', 'vtprd');?></span>
            <span class="selection-panel-text-info">
            
            <?php
              vtprd_show_help_panel_I_text($i);
            ?>
           
            </span>
          </span> 
        </div>       
       <?php 
    } //end of for loop 
   return;  
  }    
 
  function vtprd_show_help_panel_I_text($i) {          
    switch($i) {
      //display templates
      case '0':  //     No Discount Rule Max  
              esc_attr_e('No Lifetime Discount Rule Maximum', 'vtprd');    
        break;
      case '1':  //     Maximum Percentage Discount Value for the rule across the cart - Rule Max  
              esc_attr_e('Lifetime Percentage Rule Maximum purchase.  
                  If the Lifetime limit for a rule has been reached, the shortcode deal message for this rule will not display in the theme, 
                  as the customer will no longer have access to that deal.', 'vtprd');    
        break;        
      case '2':  //     Maximum Number of times the Discount may be employed for the rule across the cart - Rule Max   
              esc_attr_e('Lifetime maximum Product occurrences allowed for rule.  Limits how many times the rule discount can be applied across the lifetime of the rule.  
                  If the Lifetime limit for a rule has been reached, the shortcode deal message for this rule will not display in the theme, 
                  as the customer will no longer have access to that deal.', 'vtprd');    
        break;
      case '3':  //     Maximum $$ Value Discount the rule may create across the cart  - Rule Max 
              esc_attr_e('Lifetime $$ maximum allowed for rule.  Limits the dollar value total discount for the rule which can be applied across the lifetime of the rule.  
                  If the Lifetime limit for a rule has been reached, the shortcode deal message for this rule will not display in the theme, 
                  as the customer will no longer have access to that deal.', 'vtprd');   
        break;                                 
    }
  }

  
  
  //************************************************
  // Help panel for Get Pop
  //************************************************ 
  function vtprd_show_help_selection_panel_J($k) {  
    global $vtprd_setup_options, $vtprd_rule_template_framework, $vtprd_deal_screen_framework, $vtprd_rule_display_framework;
    $allowed_html = vtprd_get_allowed_html(); //v2.0.3
    
    for($i=0; $i < sizeof($vtprd_rule_display_framework['actionPop']['option']); $i++)  {   //run through the whole array!!
      ?>           
        <div class="selection-panel selection-panel-J  selection-panel-J-<?php echo wp_kses($i ,$allowed_html ); ?>" id="selection-panel-J-<?php echo wp_kses($i ,$allowed_html ) . '-' . wp_kses($k ,$allowed_html );?>" >                                
          <span class="selection-panel-label label"><strong><?php esc_attr_e('Get Group Chosen:', 'vtprd');?></strong></span>                         
          <a class="selection-panel-close selection-panel-close-J" href="<?php echo esc_js('javascript:void(0);');?>" ><img class="close-button" alt="help"  width="16" height="16" src="<?php echo esc_url(VTPRD_URL.'/admin/images/close-icon.png');?>" /></a>                     
          <span class="selection-panel-template"><?php echo wp_kses($vtprd_rule_display_framework['actionPop']['option'][$i]['title'] ,$allowed_html ); ?></span>
          <span class="selection-panel-text" >
            <span class="selection-panel-text-title"><?php esc_attr_e('Description', 'vtprd');?></span>
            <span class="selection-panel-text-info">
            
            <?php
              vtprd_show_help_panel_J_text($i);
            ?>
           
            </span>
          </span> 
          <a class="selection-panel-close  clear-left  selection-panel-close-J" id="selection-panel-close-bottom" href="<?php echo esc_js('javascript:void(0);');?>" ><img class="close-button" alt="help"  width="16" height="16" src="<?php echo esc_url(VTPRD_URL.'/admin/images/close-icon.png');?>" /></a>           						
        </div>       
       <?php 
    } //end of for loop 
   return;  
  }    
 
  function vtprd_show_help_panel_J_text($i) {          
    switch($i) {
      //display templates
      case '0':  //     No Discount Rule Max  
              esc_attr_e('Please be careful when choosing the Get Group Selection. ', 'vtprd');
              ?><br><?php
              esc_attr_e('If you choose "Get Pool Group same as Buy Pool Group" or
                 "Apply to all products in store", the Buy and Get groups will be processed as a single group together, alternating
                 between Buy criteria and Get criteria.  For example, in this case you have "buy 5 get 1 free", the 6th item purchased will be free.', 'vtprd');
                 
               ?><br><?php
              esc_attr_e('If the Get Group is separately specified, it will be counted separately, regardless whether the two groups actuall share members.
                 For example, you have "buy 5 get 1 free", but the Get group separately specifies the same categories as the Buy Group.
                 In this case the Get Group will **Recount** the original 5, and offer the 1st free...', 'vtprd'); 
                 
               ?><br><strong><?php
               esc_attr_e('So please be sure that if there is overlap between the Buy group and the specified Get Group, you have considered
                 the overlap issue.', 'vtprd');
               ?></strong><?php    
        break;
                                
    }
  }

    
  //************************************************
  // Help panels for Roles Info
  //************************************************ 
  function vtprd_show_help_selection_panel_K() {  
    global $vtprd_setup_options, $vtprd_rule_template_framework, $vtprd_deal_screen_framework, $vtprd_rule_display_framework;
        //there's only one of these panels...
        $allowed_html = vtprd_get_allowed_html(); //v2.0.3
        $k = 0;
      ?>           
        <div class="selection-panel selection-panel-K  selection-panel-K-0" id="selection-panel-K-0" >                                
          <span class="selection-panel-label label"><strong><?php esc_attr_e('Selection Groups Help Info:', 'vtprd');?></strong></span>                         
          <a class="selection-panel-close selection-panel-close-K" href="<?php echo esc_js('javascript:void(0);');?>" ><img class="close-button" alt="help"  width="16" height="16" src="<?php echo esc_url(VTPRD_URL.'/admin/images/close-icon.png');?>" /></a>                     
          <span class="selection-panel-text" >
            <span class="selection-panel-text-info">
            
              <?php esc_attr_e("
                 Use an existing category to identify the group of products to which you wish to apply the rule.  
                 Or if you'd rather, use a Pricing Deals Category to identify products - this avoids disturbing the store categories. Just add a Pricing Deals Category, go to the product screen,
                 and add the product to the correct Pricing Deals category.  (On your product add/update screen, the Mininimum purchase 
                 category metabox is just below the default product category box.)  You can also apply the rule using Wholesaler / Membership / Roles (Displays different prices for logged in users)  
                 as a solo selection, or you can use any combination of all three.", 'vtprd');
              ?><br><?php
              esc_attr_e("Display different prices/pricing tiers for logged in users => Role/Membership is used within Wordpress to control access and capabilities, when a role is given to a user.  
                 Wordpress assigns certain roles by default such as Subscriber for new users or Administrator for the site's owner. Roles can also be used to associate a user 
                 with a pricing level.  Use a role management plugin like , ", 'vtprd'); 
                 $url = esc_url("http://wordpress.org/extend/plugins/user-role-editor/");
                 ?>
                 <a href="<?php echo esc_url($url);?>">
                 <?php esc_attr_e('User Role Editor', 'vtprd');?></a> 
               <?php 
               esc_attr_e("to establish custom roles, which you can give 
                 to a user or class of users.  Then you can associate that role with a Pricing Deals Rule.  
                 So when the user logs into your site, their Role interacts with the appropriate Rule.", 'vtprd');
              ?><br><?php
              esc_attr_e("Please take note of the relationship choice 'and/or' when using roles.  The default is 'or', while choosing 'and' requires that 
                 both a role and a category be selected, before a rule can be published.", 'vtprd');?>
                <br>
                <h3><?php esc_attr_e('Membership / Wholesale / Customer', 'vtprd'); echo wp_kses('&nbsp;&nbsp;' ,$allowed_html ) ;  esc_attr_e('Role How-To', 'vtprd');?></h3>
                <ol class="directions-list">
                  <li><?php esc_attr_e('Download a Role Management Plugin (like ', 'vtprd');?> <a href="<?php echo esc_url($url);?>"><?php esc_attr_e('User Role Editor', 'vtprd');?></a>) </li>
                  <li><?php esc_attr_e('Set up unique Membership/Wholesale Roles using Role Management Plugin', 'vtprd');?></li>
                  <li><?php esc_attr_e('Ensure shop website theme allows user to Log In to store', 'vtprd');?></li>                    
                  <li><?php esc_attr_e('Assign signed-up users to appropriate Membership/Wholesale Role (', 'vtprd');?><a href="<?php echo esc_url(VTPRD_ADMIN_URL.'users.php');?>"><?php esc_attr_e('Users Screen', 'vtprd');?></a>)</li>
                  <li><?php esc_attr_e('Set up Pricing Deal rule(s) which specify the appropriate Membership/Wholesale role(s) for the Buy or Get Pool', 'vtprd');?></li>
                </ol>          
            </span>
          </span> 
          <a class="selection-panel-close  clear-left  selection-panel-close-K" id="selection-panel-close-bottom" href="<?php echo esc_js('javascript:void(0);');?>" ><img class="close-button" alt="help"  width="16" height="16" src="<?php echo esc_url(VTPRD_URL.'/admin/images/close-icon.png');?>" /></a>           						
        </div>       
       <?php 
   return;  
  }    
  //dup of K
  function vtprd_show_help_selection_panel_L() {  
    global $vtprd_setup_options, $vtprd_rule_template_framework, $vtprd_deal_screen_framework, $vtprd_rule_display_framework;
        //there's only one of these panels...
        $allowed_html = vtprd_get_allowed_html(); //v2.0.3
        $k = 0;
        $url = esc_url("http://wordpress.org/extend/plugins/user-role-editor/");
      ?>           
        <div class="selection-panel selection-panel-L  selection-panel-L-0" id="selection-panel-L-0" >                                
          <span class="selection-panel-label label"><strong><?php esc_attr_e('Selection Groups Help Info:', 'vtprd');?></strong></span>                         
          <a class="selection-panel-close selection-panel-close-L" href="<?php echo esc_js('javascript:void(0);');?>" ><img class="close-button" alt="help"  width="16" height="16" src="<?php echo esc_url(VTPRD_URL.'/admin/images/close-icon.png');?>" /></a>                     
          <span class="selection-panel-text" >
            <span class="selection-panel-text-info">
            
              <?php esc_attr_e("Display different prices/pricing tiers for logged in users => Role/Membership is used within Wordpress to control access and capabilities, when a role is given to a user.  
                 Wordpress assigns certain roles by default such as Subscriber for new users or Administrator for the site's owner. Roles can also be used to associate a user 
                 with a pricing level.  Use a role management plugin like ".esc_url($url)." to establish custom roles, which you can give 
                 to a user or class of users.  Then you can associate that role with a Pricing Deals Rule.  
                 So when the user logs into your site, their Role interacts with the appropriate Rule.", 'vtprd');
              ?><br><?php
              esc_attr_e("Use an existing category to identify the group of products to which you wish to apply the rule.  
                 If you'd rather, use a Pricing Deals Category to identify products - this avoids disturbing the store categories. Just add a Pricing Deals Category, go to the product screen,
                 and add the product to the correct Pricing Deals category.  (On your product add/update screen, the Mininimum purchase 
                 category metabox is just below the default product category box.)  You can also apply the rule using Wholesaler / Membership / Roles (Displays different prices for logged in users)  
                 as a solo selection, or you can use any combination of all three.", 'vtprd');
              ?><br><?php
              esc_attr_e("Please take note of the relationship choice 'and/or' when using roles.  The default is 'or', while choosing 'and' requires that 
                 both a role and a category be selected, before a rule can be published.", 'vtprd');?>
                <br>
                <h3><?php esc_attr_e('Membership / Wholesale / Customer', 'vtprd'); echo wp_kses('&nbsp;&nbsp;' ,$allowed_html ) ;  esc_attr_e('Role How-To', 'vtprd');?></h3>
                <ol class="directions-list">
                  <li><?php esc_attr_e('Download a Role Management Plugin (like ', 'vtprd');?> <a href="<?php echo esc_url($url);?>"><?php esc_attr_e('User Role Editor', 'vtprd');?></a>) </li>
                  <li><?php esc_attr_e('Set up unique Membership/Wholesale Roles using Role Management Plugin', 'vtprd');?></li>
                  <li><?php esc_attr_e('Ensure shop website theme allows user to Log In to store', 'vtprd');?></li>                    
                  <li><?php esc_attr_e('Assign signed-up users to appropriate Membership/Wholesale Role (', 'vtprd');?><a href="<?php echo esc_url(VTPRD_ADMIN_URL,'users.php');?>"><?php esc_attr_e('Users Screen', 'vtprd');?></a>)</li>
                  <li><?php esc_attr_e('Set up Pricing Deal rule(s) which specify the appropriate Membership/Wholesale role(s) for the Buy or Get Pool', 'vtprd');?></li>
                </ol>          
            </span>
          </span> 
          <a class="selection-panel-close  clear-left  selection-panel-close-L" id="selection-panel-close-bottom" href="<?php echo esc_js('javascript:void(0);');?>" ><img class="close-button" alt="help"  width="16" height="16" src="<?php echo esc_url(VTPRD_URL.'/admin/images/close-icon.png');?>" /></a>           						
        </div>       
       <?php 
   return;  
  }    
  
  
  //*************************************************
  //  TOOLTIP AREA
  //*************************************************
   
  function vtprd_show_help_tooltip($context, $location = null) {
     // hasTooltip set up to show the next div (hidden) as tooltip...
   ?>             
     <img class="helpImg  twelveByTwelve  hasTooltip" alt="help"  src="<?php echo esc_url(VTPRD_URL.'/admin/images/help.png');?>" /> 
     <div class="hideMe"> 
     <?php 
      /* //add in class for location as needed
      switch($location) {
        case 'title': 
            echo ' tooltipTitleSpacing';
          break;
      } */
     ?>  
          <b> <?php vtprd_show_help_tooltip_text($context); ?> </b> 
          
     </div>                  
   <?php              
  } 
    
  function vtprd_show_help_tooltip_text($context) {          
    switch($context) {
      //display templates            
      case 'basic-rule-scheduling':  
           esc_attr_e('Rule scheduling is required.', 'vtprd');
            ?><br><?php
            esc_attr_e('The rule may Begin any time, the End Date may be the same as Begin Date or later.', 'vtprd');
            ?><br><?php
            esc_attr_e('In order for the rule to be active, the date must fall between the Begin and End Dates (inclusive of the stated boundary dates).', 'vtprd');               
        break;
      case 'deal-type-title':  
           esc_attr_e('The Pricing Deal Template helps you to define what kind of Pricing Deal rule you wish to employ.  By choosing a template, further overall rule attributes
               are refined to reflect what is valid for that template type.', 'vtprd');
              ?><br><?php
              esc_attr_e('For most templates, the Buy (Buy one) Pool and the Get (Get one) Pool can have various contents.', 'vtprd');
              ?><br><?php
              esc_attr_e('For example, "Buy a 2 Laptops, get 10% off" - that would be a Buy Pool Selection of the Laptops category, 
               and an Get group selection of "Get Pool Group same as Buy Pool Group" .', 'vtprd');
               
        break;
      case 'buy-amt-title':  
           esc_attr_e('The Buy Amount sets the gateway cart purchase Amount into this discount rule.  Options include whether the rule gnerally applies to the entire but pool, or if there is a 
                count or $$ activation amount.', 'vtprd');
              ?><br><?php             
             esc_attr_e('In order for a discount to apply, the Buy Amount criteria must first be satisfied', 'vtprd');              
        break; 
      case 'buy_amt_mod_title':
           esc_attr_e('When the Buy Pool Amt Type threshhold is set to a Quantity Count, Set a Minimum or Maximum $$ value the rule must also reach.', 'vtprd');        
        break;                      
      case 'buy_repeat_condition_title':    
           esc_attr_e('How many times the Whole Rule is repeated, for the cart.', 'vtprd');
              ?><br><?php
              esc_attr_e('For example, "Buy 5, get 10% off" with unlimited Rule repeats is the rule.  If the purchaser gets 10 items which participate in the Buy pool, then the 
             10% off will apply again vs the second group of 5.', 'vtprd');
              ?><br><?php
              esc_attr_e('To control how many times the Whole Rule can Ever be executed for a Customer, use the "Per Customer Limit".', 'vtprd');
        break;
      case 'buy-amt-applies-to':     
            esc_attr_e('Buy 5 ... "OF A SINGLE ITEM / FROM A GROUP "...', 'vtprd');
              ?><br><?php
           esc_attr_e('Applies to EACH = the count or $$ value applies ONLY to a quantity/$$ value of a single product.', 'vtprd');
              ?><br><?php
           esc_attr_e('Applies to ALL = the count or $$ value applies ', 'vtprd');
              ?><br><?php
           esc_attr_e(' EITHER to a a quantity/$$ value of a single product, ', 'vtprd');
              ?><br><?php
           esc_attr_e(' OR the a quantity/$$ value of a GROUP of products 
              (within the specified "Buy" group).', 'vtprd');
        break;        
      case 'action_amt_title':  
           esc_attr_e('.', 'vtprd');
              ?><br><?php
              esc_attr_e('The threshhold (Get Pool Amount Condition) can apply to all products in the cart, or individual products quantites in the cart.', 'vtprd');               
        break;
      case 'action_amt_mod_title':
           esc_attr_e('When the Get Pool Amt Type threshhold is set to a Quantity Count, Set a Minimum or Maximum $$ value the rule must also reach.', 'vtprd');        
        break;                      
      case 'action_repeat_condition_title':  
           esc_attr_e('How many times the Get Pool condition is counted (once the Buy Pool conditions are reached).  
            This essentially counts the number of times the JUST the action pool is repeated and eventually discounted.', 'vtprd');
              ?><br><?php
              esc_attr_e('For example, "Buy 5, get 10% off next one" with unlimited Get repeats is the rule, Get pool same as Buy pool set.  
             If the purchaser gets 10 items which participate in the Buy pool, then the 1st 5 will count towards the Buy count. 
             The 10% off will apply against products 6 - 10.', 'vtprd');
        break;                            
      case 'get-amt-applies-to':     
            esc_attr_e('Get 5 ... "OF A SINGLE ITEM / FROM A GROUP "...', 'vtprd');
              ?><br><?php
           esc_attr_e('Applies to EACH = the count or $$ value applies ONLY to a quantity/$$ value of a single product.', 'vtprd');
              ?><br><?php
           esc_attr_e('Applies to ALL = the count or $$ value applies ', 'vtprd');
              ?><br><?php
           esc_attr_e(' EITHER to a a quantity/$$ value of a single product, ', 'vtprd');
              ?><br><?php
           esc_attr_e(' OR the a quantity/$$ value of a GROUP of products 
              (within the specified "Get" group).', 'vtprd');
        break;                                                
      case 'discount_amt_title': 
           esc_attr_e('The Discount offered is the heart of the Pricing Deal rule system.  
              Discount types include % off, $$ off, sell at a fixed price, free, or "for the price of" discount.', 'vtprd');
              ?><br><?php
              esc_attr_e('The discount can apply to each Get product individually, or all products in the Get Pool.  The discount can also be applied against the
             most expensive/lease expensive product in the Get group.  Discounts granted by this rule can be limited by Maximum limits below.', 'vtprd');
        break;  
      case 'discount_applies_to': 
           esc_attr_e('The discount can be applied against the each individual product/all products as a group, or against.
             most expensive/lease expensive product in the Get group.  Discounts granted by this rule can be limited by Maximum limits below.', 'vtprd');
        break;
      case 'discount_auto_add_free_product': 
           esc_attr_e('Always automatically insert the Free Product into the cart.', 'vtprd');
           ?><br><?php
           esc_attr_e('Automatically Remove the Free Product from the cart, if "free" conditions no longer apply...', 'vtprd');
           ?><br><?php
           esc_attr_e('The Free product will never be one of the items purchased by the client.', 'vtprd');             
           ?><br><?php
           esc_attr_e('The free product is only ever inserted automatically*.  (This is a reversal of normal behavior...)', 'vtprd');             
        break;        
      case 'discount_rule_max_amt_type':
           esc_attr_e('Maximum Discount Limits for Cart Purchases as granted through this rule.', 'vtprd');
              ?><br><?php
              esc_attr_e('Lifetime Maximum Discount limits by IP can be applied immediately at add-to-cart time.', 'vtprd');
              ?><br><?php
              esc_attr_e('All other name, email and address limits are applied at checkout time.', 'vtprd');
        break;
      case 'discount_rule_max_amt_msg': 
           esc_attr_e('This msg is optionally available on demand in your theme using the "echo do_action" syntax discussed in the documentation and the readme.', 'vtprd');
        break;
      case 'discount_lifetime_max_amt_msg': 
           esc_attr_e('This msg is optionally available on demand in your theme using the "echo do_action" syntax discussed in the documentation and the readme.', 'vtprd');
        break;        
      case 'discount_rule_cum_max_amt_msg': 
           esc_attr_e('This msg is optionally available on demand in your theme using the "echo do_action" syntax discussed in the documentation and the readme.', 'vtprd');
        break;        
      case 'discount_lifetime_max_amt_type':
           esc_attr_e('Maximum Discount Limits for Lifetime Purchases as granted through this rule.  
                  If the Lifetime limit for a rule is reached, the shortcode deal message for this rule will not display in the theme, 
                  as the customer will no longer have access to that deal.', 'vtprd');
        break;
      case 'discount_full_msg':
           esc_attr_e('Theme-displayable Product message, using the "echo do_action" syntax discussed in the documentation and the readme.', 'vtprd');
        break;
      case 'discount_short_msg':
           esc_attr_e('The short message is used in the Cart, at the product detail level.  
              The short message is combined with the product name as the label for the product discount.', 'vtprd');
              ?><br><?php
              esc_attr_e('For example, if the short msg = "Buy 1 Get 1 at 10% off", the line showing the product discount could be:', 'vtprd');
              ?><br><?php
              esc_attr_e('"Buy 1 Get 1 at 10% off - discount for Dell Vostro Laptop:  cr $150.00"', 'vtprd');
        break;
      case 'cumulativeSalePricingLimitation':     //
           esc_attr_e('PLEASE NOTE - Due to a WPEC system limitation,', 'vtprd');
              ?><br><?php
              esc_attr_e('if a product VARIATION is on sale, and there is an applicable Realtime product price discount,', 'vtprd');
              ?><br><?php
              esc_attr_e('the Rule discount WILL ALWAYS BE APPLIED, in ADDITION to the Sale Price,', 'vtprd');
              ?><br><?php
              esc_attr_e('REGARDLESS of any switch settings.', 'vtprd');          
        break;
      case 'cumulative_pricing_switches':     //cumulativeSalePricingLimitation
           esc_attr_e('The switches control the interaction of this rule with other rules, sale pricing and coupons.', 'vtprd');
           if (VTPRD_PARENT_PLUGIN_NAME == 'WP E-Commerce') {
              ?><br><?php
              esc_attr_e('PLEASE NOTE - Due to a system limitation, if a product VARIATION is on sale, and there is an applicable Realtime
              product price discount, the Rule discount WILL ALWAYS BE APPLIED, in addition to the Sale Price discount, regardless of any switch settings.', 'vtprd');
           }           
        break;        
      case 'discount_rule_cum_max_amt_type':
           esc_attr_e('Maximum $$ value This Rule can create across the Cart', 'vtprd');
        break;
      case 'ruleApplicationPriority_num':
           esc_attr_e('This number helps determine which rule gets priority, when multiple rule discounts may be applied.  The LOWER the number, the higher the priority.  The default value is "10".', 'vtprd');
        break;
      case 'cumulativeRulePricing':
           esc_attr_e('If "Apply this Rule Discount in Addition to Other Rule Discounts" = "yes", 
              if this rule is applicable in addition to previous Rules applied, the additional
              discount will be applied UP TO the applicable Maximum settings.', 'vtprd');
              ?><br><?php
              esc_attr_e('Please NOTE: This switch ONLY acts on other CART rules, there is no interaction with CATALOG/Display pricing rules', 'vtprd');              
        break;
      case 'cumulativeSalePricing':
           esc_attr_e('"No Discount if Product Sale Priced" = All discounts are ignored if Product is Sale priced', 'vtprd');
              ?><br><?php
              esc_attr_e('"Apply Discount in addition to Product Sale Price" = Apply all discounts to the Product Sale Price, if there', 'vtprd');
              ?><br><?php
              esc_attr_e('"Use Discounted List Price, if Less than Sale Price" = Apply all discounts to the List Price.  Compare to Sale Price, and use
              discounted List Price, if less than Sale Price.', 'vtprd');
        break;       
      case 'cumulativeCouponPricing':
           esc_attr_e('If "Apply this Rule Discount in Addition to Coupon Discount" = "yes", 
              if the customer applies a coupon to the cart, this Rule will also apply
              its discount In Addition To the coupon discount.', 'vtprd');
        break;  
      case 'pop-prod-id':
           esc_attr_e('Only apply rule to a single product found in the cart, whose ID is supplied in the "Product ID" box.  The product ID can be found in the URL
            of the product during a product edit session', 'vtprd');
              ?><br><?php
              $url = esc_url("http://www.xxxx.com/wp-admin/post.php?post=872&action=edit");
              esc_attr_e('For example, in the product edit session url:<br>'.esc_url($url), 'vtprd');
             ?><br><?php
              esc_attr_e('The product id is in the "post=872" portion of the address, and hence the number is 872.
            ', 'vtprd');
        break;     
      case 'buy-group-title':
           esc_attr_e('The Buy group is the gateway into this discount rule. ', 'vtprd');
              ?><br><?php
            esc_attr_e('In order for a discount to apply, the Buy Group criteria must first be satisfied', 'vtprd');
              ?><br><?php
            esc_attr_e('The Buy group can be defined as the whole store catalog, or part of it  
            by product category, pricing deal category, wholesaler or membership, product or product variation.', 'vtprd');
        break; 
      case 'action-group-title':
           esc_attr_e('The Get group defines what product or group of products the discount action may be applied to.', 'vtprd');
              ?><br><?php
            esc_attr_e('In order for a product to receive this discount, the product must participate in the Get Group.', 'vtprd');
              ?><br><?php
            esc_attr_e('The Get group can be defined as the same as buy group, the whole store catalog, or  
            by product category, pricing deal category, wholesaler or membership, product or product variation.', 'vtprd');
        break;
      case 'discount_amt_count_forThePriceOf':
           esc_attr_e('For the price of Units works with either the Buy Amount or the Get Amount, based on which template was chosen.', 'vtprd');
              ?><br><?php
              esc_attr_e('The Buy/Get Amount is the first
            half of the "Buy 5, get for the price of 4".  The second half is the discount "For the Price of Units" amount.  The Buy/Get Amount must be greater than 
            the "For the Price of Units" amount.', 'vtprd');
        break; 
      case 'includeOrExclude':
           esc_attr_e('Control how individual product interacts with all Pricing Deal Rules as a group.', 'vtprd');
           if(!defined('VTPRD_PRO_DIRNAME')) { 
             ?><br><?php
              esc_attr_e('Please Note: This functionality is only available with the Pro plugin.', 'vtprd');
           }
           ?><br><?php
           esc_attr_e('Each option available in the dropdown (combined with the check list of rules, for two of the options) affects whether this product will participate with any/all rules.', 'vtprd');
        break; 
      case 'showPro-checkbox':
           ?>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<?php
           esc_attr_e('Unprotect All the Pro Options.', 'vtprd');
           ?><br><?php
           esc_attr_e("You'll be able to investigate the addtional Buy and Get Group Selection Options:", 'vtprd');
               ?>  
                <ol>
                  <li><?php esc_attr_e('  Use Category, Membership / Wholesaler / Role Selection Groups ', 'vtprd'); ?> </li>
                  <li><?php esc_attr_e('  Single Product with Variations  .', 'vtprd'); ?> </li>
                  <li><?php esc_attr_e('  Single Product Only  ', 'vtprd'); ?> </li>  
                </ol>
                <?php          
           esc_attr_e("You'll also be able to investigate the addtional Advanced Settings Discount Limits.", 'vtprd');
        break; 
      case 'upgradeToPro':
           ?><strong><?php 
           esc_attr_e('Group Power  -  Apply rules to any group you can think of, and More!', 'vtprd'); 
           ?></strong><?php
           ?><br><?php
           ?><strong><?php   esc_attr_e("Create Rules which Filter By:", 'vtprd'); ?></strong><?php
               ?>  
                <ol>
                  <li><?php esc_attr_e('  Membership / Wholesaler / Role Selection Groups (logged-in Status)', 'vtprd'); ?> </li>
                  <li><?php esc_attr_e('  Product Category', 'vtprd'); ?> </li>
                  <li><?php esc_attr_e('  Pricing Deal Custom Category', 'vtprd'); ?> </li>
                  <li><?php esc_attr_e('  Variations', 'vtprd'); ?> </li>
                  <li><?php esc_attr_e('  Single Product', 'vtprd'); ?> </li>  
                </ol>
                <?php        
           ?><strong><?php esc_attr_e("Product-level Deal Exclusion", 'vtprd');  ?></strong><?php
           ?><br><?php
           ?><strong><?php esc_attr_e('Maximum Deal Limits, including "One Per Customer" limit', 'vtprd');  ?></strong><?php
        break;                
      case 'onlyShowsIfJSerror':
           ?>  
              <h3 class="hide-by-jquery"><?php esc_attr_e('JavaScript Error on Page!', 'vtprd'); ?> </h3>
              <p class="hide-by-jquery"><strong><?php esc_attr_e('The best way to debug the problem, is to:', 'vtprd'); ?> </strong> 
                <ol>
                  <li><?php esc_attr_e('Deactivate all plugins ', 'vtprd'); ?><strong><?php esc_attr_e('except', 'vtprd'); ?></strong><?php esc_attr_e(' Pricing Deals and your E-Commerce plugin (WPEC, WOO or JIGOSHOP)', 'vtprd'); ?> </li>
                  <li><?php esc_attr_e('Set your theme to the 2012 theme.', 'vtprd'); ?> </li>
                  <li><?php esc_attr_e('Take a snapshot of this paragraph (using the snipping tool...).', 'vtprd'); ?> </li>  
                  <li><?php esc_attr_e('Retest this page.', 'vtprd'); ?> </li>  
                  <li><?php esc_attr_e('Once this plugin page shows successfully, add in your theme/plugins one at a time, retesting after each add.', 'vtprd'); ?> </li>
                </ol>
                <?php esc_attr_e('This will help you to isolate the issue which is causing the conflict.', 'vtprd'); ?> </p>
              <p class="hide-by-jquery"><?php esc_attr_e('The Pricing Deals plugin uses WordPress best-practice for adding and using JS and JQuery resources.  Thanks for using the Pricing Deals plugin.', 'vtprd'); ?> </p> 
           <?php
        break;                                                                                
    }
  }  // End TOOLTIP AREA           
  
  
  
  //*************************************************
  //  Object Hover Help AREA
  //    Outputs both small help and big (wizard) help 
  //    qTip can access the next object by type - 
  //      <span> is the small help
  //      <div> is the big help
  //    choice is controlled by onscreen checkbox 'show wizard'
  //    ONE of the hover help always shows... => add screen is 
  //      automatically thrown into wizard mode...
  //*************************************************
   
  function vtprd_show_object_hover_help ($context, $type, $asterisk=null) {
      $allowed_html = vtprd_get_allowed_html(); //v2.0.3
      //v1.1.6.7 begin
      if ($context == 'apply_deal_to_cheapest') {
        ?>                           
         <div class="hoverHelp hideMe"> 
            <?php vtprd_show_object_hover_small_text($context); ?>                    
         </div>
                 
        <?php  
        return;    
      }
       //v1.1.6.7 end
   
      if ($type == 'small') {

   ?>                           
         <div class="hoverHelp hideMe" id="small<?php echo '-'.$context; ?>" > 
            <?php vtprd_show_object_hover_small_text($context); ?> 
            <?php if ($context == 'dontEverShowThis') { //$context != 'hover-help' ?>
                <div class="wizard-links clear-left">  
                  <a id="more-info1<?php echo wp_kses('-' .$context ,$allowed_html ); ?>"  target="_blank" class="wizard-more-info" href="<?php vtprd_get_more_info_url($context); ?>">
                      <h4>More Info</h4>
                  </a>
                </div>  
            <?php } ?>                     
         </div>
                 
   <?php 
      } else { ?>       
         <div class="wizardHelp wizardToolTip hideMe" id="wizard<?php echo wp_kses('-' .$context ,$allowed_html ); ?>" > 
         
           <?php vtprd_show_object_hover_wizard_text($context); ?>
              
           <?php //v2.0.0 REMOVED 'more info' and 'turn off hover wizard' ?>      
         </div>                     
   <?php
    }  
  } 
  
     
  function vtprd_get_more_info_url($context) {          
    switch($context) {                      
      case 'cart_or_catalog_select':
          echo esc_url("http://www.varktech.com/documentation/pricing-deals/introrule/#blueprint.catalogorcart");              
        break;                
      case 'pricing_type_select':
          echo esc_url("http://www.varktech.com/documentation/pricing-deals/introrule/#blueprint.dealtype"); 
        break;
      case 'minimum_purchase_select':
          echo esc_url("http://www.varktech.com/documentation/pricing-deals/introrule/#blueprint.dealaction");              
        break;        
      case 'scheduling':
          echo esc_url("http://www.varktech.com/documentation/pricing-deals/introrule/#blueprint.scheduling");              
        break;                 
      case 'buy_amt_type':
          echo esc_url("http://www.varktech.com/documentation/pricing-deals/introrule/#buygroup.buyamount");              
        break;
      case 'buy_amt_applies_to':
          echo esc_url("http://www.varktech.com/documentation/pricing-deals/introrule/#buygroup.buyamountapplies");              
        break;     
      case 'inPop':
          echo esc_url("http://www.varktech.com/documentation/pricing-deals/introrule/#buygroup.buyfilter");              
        break;         
       case 'buy_amt_mod':
          echo esc_url("http://www.varktech.com/documentation/pricing-deals/introrule/#buygroup.minmax");              
        break;        
      case 'buy_repeat_condition':
          echo esc_url("http://www.varktech.com/documentation/pricing-deals/introrule/#buygroup.repeat");              
        break;   
      //v1.1.8.0 begin
      case 'pricingTable':
          echo esc_url("http://www.varktech.com/documentation/pricing-deals/introrule/#buygroup.pricingTable");              
        break; 
      //v1.1.8.0 end            
      case 'action_amt_type':
          echo esc_url("http://www.varktech.com/documentation/pricing-deals/introrule/#getgroup.getamount");              
        break;
      case 'action_amt_applies_to':
          echo esc_url("http://www.varktech.com/documentation/pricing-deals/introrule/#getgroup.getamountapplies");              
        break;        
      case 'actionPop':
          echo esc_url("http://www.varktech.com/documentation/pricing-deals/introrule/#getgroup.getfilter");              
        break;        
     case 'action_amt_mod':
          echo esc_url("http://www.varktech.com/documentation/pricing-deals/introrule/#getgroup.minmax");             
        break;        
       case 'action_repeat_condition':
          echo esc_url("http://www.varktech.com/documentation/pricing-deals/introrule/#getgroup.repeat");             
        break;        
      case 'discount_amt_type':
          echo esc_url("http://www.varktech.com/documentation/pricing-deals/introrule/#discount.discountamount");              
        break;
      case 'discount_free':
          echo esc_url("http://www.varktech.com/documentation/pricing-deals/introrule/#discount.discountfree");              
        break;                
      case 'discount_applies_to':
          echo esc_url("http://www.varktech.com/documentation/pricing-deals/introrule/#discount.discountappliesto");             
        break;        
      case 'discount_product_short_msg':
          echo esc_url("http://www.varktech.com/documentation/pricing-deals/introrule/#messages.checkout");              
        break;        
      case 'discount_product_full_msg':
          echo esc_url("http://www.varktech.com/documentation/pricing-deals/introrule/#messages.marketing");              
        break;        
      case 'discount_lifetime_max_amt_type':
          echo esc_url("http://www.varktech.com/documentation/pricing-deals/introrule/#limits.percustomer");              
        break;         
      case 'discount_rule_max_amt_type':
          echo esc_url("http://www.varktech.com/documentation/pricing-deals/introrule/#limits.percart");              
        break;        
      case 'discount_rule_cum_max_amt_type':
          echo esc_url("http://www.varktech.com/documentation/pricing-deals/introrule/#limits.perproduct");            
        break; 
      case 'only_for_this_coupon_name':  //v1.1.0.8
          echo esc_url("http://www.varktech.com/documentation/pricing-deals/introrule/#only.coupon");            
        break;      
      case 'cumulativeRulePricing':
          echo esc_url("http://www.varktech.com/documentation/pricing-deals/introrule/#workingwith.otherrules");            
        break;        
      case 'cumulativeCouponPricing':
          echo esc_url("http://www.varktech.com/documentation/pricing-deals/introrule/#workingwith.coupons");              
        break;        
      case 'cumulativeSalePricing':
          echo esc_url("http://www.varktech.com/documentation/pricing-deals/introrule/#workingwith.saleprice");              
        break;        
      case '':            
        break;
     
    } //end switch                  
  } 
   
    
  function vtprd_show_object_hover_small_text($context) {          
    switch($context) {           
      //************
      //v2.0.0 begin
      //************    
      case 'buy_group_prod_cat_incl':
          ?>                           
          <div class="section">
            <a name="buygroup.buy_group_prod_cat_incl" data-type="group"></a><h2>Product Category Inclusion</h2>
            <p class="larger-strong">
               <strong>Product Categories that the Deal will be applied to, or that need to be in the cart in order for the discount to be applied</strong>                                             
            </p>                        
           </div>
          <?php             
        break;                   
      case 'buy_group_prod_cat_excl':
          ?>                           
          <div class="section">
            <a name="buygroup.buy_group_prod_cat_incl" data-type="group"></a><h2>Product Category Exclusion</h2>
            <p class="larger-strong">
               <strong>Product Categories that the Deal will not be applied to, or that cannot be in the cart in order for the discount to be applied</strong>                                             
            </p>                        
           </div>
          <?php             
        break;
      case 'buy_group_plugin_cat_incl':
          ?>                           
          <div class="section">
            <a name="buygroup.buy_group_plugin_cat_incl" data-type="group"></a><h2>Pricing Deals Category Inclusion</h2>
            <p class="larger-strong">
               <strong>Pricing Deals Categories that the Deal will be applied to, or that need to be in the cart in order for the discount to be applied</strong>                                             
            </p>                        
           </div>
          <?php             
        break;        
      case 'buy_group_plugin_cat_excl':
          ?>                           
          <div class="section">
            <a name="buygroup.buy_group_plugin_cat_incl" data-type="group"></a><h2>Pricing Deals Category Exclusion</h2>
            <p class="larger-strong">
               <strong>Pricing Deals Categories that the Deal will not be applied to, or that cannot be in the cart in order for the discount to be applied</strong>                                             
            </p>                        
           </div>
          <?php             
        break;
      case 'buy_group_product_incl':
          ?>                           
          <div class="section">
            <a name="buygroup.buy_group_product_incl" data-type="group"></a><h2>Product Inclusion</h2>
            <p class="larger-strong">
               <strong>Products that the Deal will be applied to, or that need to be in the cart in order for the discount to be applied</strong>                                             
            </p>                        
           </div>
          <?php             
        break;        
      case 'buy_group_product_excl':
          ?>                           
          <div class="section">
            <a name="buygroup.buy_group_product_incl" data-type="group"></a><h2>Product Exclusion</h2>
            <p class="larger-strong">
               <strong>Products that the Deal will not be applied to, or that cannot be in the cart in order for the discount to be applied</strong>                                             
            </p>                        
           </div>
          <?php             
        break;
      case 'buy_group_var_name_incl':
          ?>                           
          <div class="section">
            <a name="buygroup.buy_group_var_name_incl" data-type="group"></a><h2>Variation Name (across products) Inclusion</h2>
            <p class="larger-strong">
               <strong>Variation Names (across products) that the Deal will be applied to, or that need to be in the cart in order for the discount to be applied</strong>                                             
            </p>                        
           </div>
          <?php             
        break;        
      case 'buy_group_var_name_excl':
          ?>                           
          <div class="section">
            <a name="buygroup.buy_group_var_name_incl" data-type="group"></a><h2>Variation Name (across products) Exclusion</h2>
            <p class="larger-strong">
               <strong>Variation Names (across products) that the Deal will not be applied to, or that cannot be in the cart in order for the discount to be applied</strong>                                             
            </p>                        
           </div>
          <?php             
        break;  
      case 'buy_group_varName_catalog_info':
          ?>                           
          <div class="section">
            <a name="buygroup.buy_group_var_name_incl" data-type="group"></a><h2>Variation Name (across products) NOTE</h2>
            <p class="larger-strong">
               <strong>Only <em>"priceable"</em> attributes can be used in a <em>CATALOG</em> rule.</strong>
               <br><br>&nbsp;&nbsp;&nbsp;In the Product Edit screen
               <br>&nbsp;&nbsp;&nbsp;If you can't <em>separately price</em> an attribute,
               <br>&nbsp;&nbsp;&nbsp;you <em>can't</em> use that attribute
               <br>&nbsp;&nbsp;&nbsp;in a Variation Name selection
               <br>&nbsp;&nbsp;&nbsp;for a <em>Catalog</em> rule.
               <br><br>&nbsp;&nbsp;&nbsp;ANY attribute
               <br>&nbsp;&nbsp;&nbsp;is fine in a <em>CART</em> rule, though!!!                                           
            </p>                        
           </div>
          <?php             
        break;
      case 'buy_group_brands_incl':
           $url1 = esc_url("https://wordpress.org/plugins/product-brands-for-woocommerce/");
           $url2 = esc_url("https://wordpress.org/plugins/perfect-woocommerce-brands/");
           $url3 = esc_url("https://wordpress.org/plugins/brands-for-woocommerce/");
           $url4 = esc_url("https://wordpress.org/plugins/yith-woocommerce-brands-add-on/");
           $url5 = esc_url("https://wordpress.org/plugins/ultimate-woocommerce-brands/");
           $url6 = esc_url("https://wordpress.org/plugins/wc-brand/");

          ?>                          
          <div class="section">
            <a name="buygroup.brands" data-type="group"></a><h2>Brand Inclusion</h2>
            <p class="larger-strong">
               <strong>Brands that the Deal will be applied to, or that need to be in the cart in order for the discount to be applied</strong>                                             
            </p>
            <p class="larger-strong">
                <span class='varName_addl_info  clear-left'> 
                   ( These FREE Brands plugins are supported by Pricing Deals natively )
                   <br>&nbsp;&nbsp;&nbsp; <a href="<?php echo esc_url($url1);?>">Product Brands For WooCommerce</a>  
                   <br>&nbsp;&nbsp;&nbsp; <a href="<?php echo esc_url($url2);?>">Perfect WooCommerce Brands</a> 
                   <br>&nbsp;&nbsp;&nbsp; <a href="<?php echo esc_url($url3);?>">Brands for WooCommerce</a> 
                   <br>&nbsp;&nbsp;&nbsp; <a href="<?php echo esc_url($url4);?>">YITH WooCommerce Brands Add-On</a> 
                   <br>&nbsp;&nbsp;&nbsp; <a href="<?php echo esc_url($url5);?>">Ultimate WooCommerce Brands</a> 
                   <br>&nbsp;&nbsp;&nbsp; <a href="<?php echo esc_url($url6);?>">Woocommerce Brands</a>     
                </span>                                             
            </p>
            <p class="larger-strong  clear-left">
               <br>
               <strong>If you'd like to have another plugin supported, drop Varktech a line </strong>                                            
            </p>            
            <br>
           </div>
          <?php             
        break;
      case 'buy_group_brands_excl':
           $url1 = esc_url("https://wordpress.org/plugins/product-brands-for-woocommerce/");
           $url2 = esc_url("https://wordpress.org/plugins/perfect-woocommerce-brands/");
           $url3 = esc_url("https://wordpress.org/plugins/brands-for-woocommerce/");
           $url4 = esc_url("https://wordpress.org/plugins/yith-woocommerce-brands-add-on/");
           $url5 = esc_url("https://wordpress.org/plugins/ultimate-woocommerce-brands/");
           $url6 = esc_url("https://wordpress.org/plugins/wc-brand/");

          ?>                          
          <div class="section">
            <a name="buygroup.brands" data-type="group"></a><h2>Brand Exclusion</h2>
            <p class="larger-strong">
               <strong>Brands that the Deal will not be applied to, or that cannot be in the cart in order for the discount to be applied</strong>                                             
            </p>
            <p class="larger-strong">
                <span class='varName_addl_info  clear-left'> 
                  <?php esc_attr_e('( <em>These are the Brands plugins that Pricing Deals supports natively </em>)', 'vtprd'); ?>
                   <br>&nbsp;&nbsp;&nbsp; <a href="<?php echo esc_url($url1);?>">Product Brands For WooCommerce</a>  
                   <br>&nbsp;&nbsp;&nbsp; <a href="<?php echo esc_url($url2);?>">Perfect WooCommerce Brands</a> 
                   <br>&nbsp;&nbsp;&nbsp; <a href="<?php echo esc_url($url3);?>">Brands for WooCommerce</a> 
                   <br>&nbsp;&nbsp;&nbsp; <a href="<?php echo esc_url($url4);?>">YITH WooCommerce Brands Add-On</a> 
                   <br>&nbsp;&nbsp;&nbsp; <a href="<?php echo esc_url($url5);?>">Ultimate WooCommerce Brands</a> 
                   <br>&nbsp;&nbsp;&nbsp; <a href="<?php echo esc_url($url6);?>">Woocommerce Brands</a>      
                </span>                                             
            </p>            
            <p class="larger-strong  clear-left">
               <br>
               <strong>If you'd like to have another plugin supported, drop Varktech a line </strong>                                            
            </p>            
            <br>
           </div>
          <?php             
        break;        
      case 'buy-group-and-or-AndSelect':
          ?>                          
          <div class="section">
            <a name="buygroup.AndSelect" data-type="group"></a><h2>Customer Inclusion Attribute Required</h2>
            <p class="larger-strong">
               <strong>"AND" = ONE of entries in the Role, Email, Groups or Membership Lists MUST be satisfied, in order for the discount to be applied.</strong>                                             
            </p>
            <p>
              "AND" Rule example - "Buy 3 of Category X and logged as Wholesale, get a discount" 
            </p>  
            <p>
              <em>(exclusions don't care about "and" or "or" - they apply regardless)</em> 
            </p>
            
            <p> And/Or <strong>Processing Sequence</strong>: 
              <br>1. Exclusions 
              <br>2. Inclusions with 'AND' 
                <br>&nbsp;&nbsp;&nbsp; - <em> All </em> 'AND' inclusions
                <br>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<em>must</em> be satisfied
              <br>3. Inclusions with 'OR' 
                <br>&nbsp;&nbsp;&nbsp; - <em> Any </em> 'OR' inclusion 
                <br>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;can "activate" the deal
            </p>                                 
           </div>
          <?php             
        break;
       case 'buy-group-and-or-OrSelect':
          ?>                           
          <div class="section">
            <a name="buygroup.AndSelect" data-type="group"></a><h2>Customer Attribute Selected for this Rule</h2>
            <p class="larger-strong">
              <strong>"OR" = <br>ANY of the listed items below will satisfy the Buy group participation criteria</strong>                                                             
            </p>
            <p class="larger-strong">
               <strong>Any entry in the Role, Email, Groups or Membership Lists can "activate" the deal.</strong>                                                            
            </p>
            
            <p> And/Or <strong>Processing Sequence</strong>: 
              <br>1. Exclusions 
              <br>2. Inclusions with 'AND' 
                <br>&nbsp;&nbsp;&nbsp; - <em> All </em> 'AND' inclusions
                <br>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<em>must</em> be satisfied
              <br>3. Inclusions with 'OR' 
                <br>&nbsp;&nbsp;&nbsp; - <em> Any </em> 'OR' inclusion 
                <br>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;can "activate" the deal
            </p>                                
           </div>
          <?php             
        break;
      case 'buy_group_role_incl':
          ?>                           
          <div class="section">
            <a name="buygroup.buy_group_role_incl" data-type="group"></a><h2>Role Inclusion</h2>
            <p class="larger-strong">
               <strong>Roles that the Deal will be applied to, or that need to be in the cart in order for the discount to be applied</strong>                                             
            </p>                        
           </div>
          <?php             
        break;                   
      case 'buy_group_role_excl':
          ?>                           
          <div class="section">
            <a name="buygroup.buy_group_role_incl" data-type="group"></a><h2>Role Exclusion</h2>
            <p class="larger-strong">
               <strong>Roles that the Deal will not be applied to, or that cannot be in the cart in order for the discount to be applied</strong>                                             
            </p>                        
           </div>
          <?php             
        break;        
      case 'buy_group_email_incl':
          ?>                           
          <div class="section">
            <a name="buygroup.buy_group_email_incl" data-type="group"></a><h2>Email Inclusion</h2>
            <p class="larger-strong">
               <strong>Emails or Customer Names that the Deal will be applied to, or that need to be in the cart in order for the discount to be applied</strong>                                             
            </p>                        
           </div>
          <?php             
        break;                   
      case 'buy_group_email_excl':
          ?>                           
          <div class="section">
            <a name="buygroup.buy_group_email_incl" data-type="group"></a><h2>Email Exclusion</h2>
            <p class="larger-strong">
               <strong>Emails or Customer Names that the Deal will not be applied to, or that cannot be in the cart in order for the discount to be applied</strong>                                             
            </p>                        
           </div>
          <?php             
        break;
      case 'buy_group_groups_incl':
          ?>                           
          <div class="section">
            <a name="buygroup.buy_group_groups_incl" data-type="group"></a><h2>Groups Inclusion</h2>
            <p class="larger-strong">
               <strong>Groups that the Deal will be applied to, or that need to be in the cart in order for the discount to be applied</strong>                                             
            </p>                        
           </div>
          <?php             
        break;        
      case 'buy_group_groups_excl':
          ?>                           
          <div class="section">
            <a name="buygroup.buy_group_groups_incl" data-type="group"></a><h2>Groups Exclusion</h2>
            <p class="larger-strong">
               <strong>Groups that the Deal will not be applied to, or that cannot be in the cart in order for the discount to be applied</strong>                                             
            </p>                        
           </div>
          <?php             
        break;
      case 'buy_group_memberships_incl':
          ?>                           
          <div class="section">
            <a name="buymembership.buy_membership_memberships_incl" data-type="membership"></a><h2>Memberships Inclusion</h2>
            <p class="larger-strong">
               <strong>Memberships that the Deal will be applied to, or that need to be in the cart in order for the discount to be applied</strong>                                             
            </p>                        
           </div>
          <?php             
        break;  
      case 'buy_group_memberships_excl':
          ?>                           
          <div class="section">
            <a name="buymembership.buy_membership_memberships_incl" data-type="membership"></a><h2>Memberships Exclusion</h2>
            <p class="larger-strong">
               <strong>Memberships that the Deal will not be applied to, or that cannot be in the cart in order for the discount to be applied</strong>                                             
            </p>                        
           </div>
          <?php             
        break;              
       case 'buy_group_groups_needed':
          $url = esc_url("https://wordpress.org/plugins/groups/");
          ?>                           
          <div class="section">
            <br>
            <a name="buygroups.buy_group_groups_needed" data-type="groups"></a><h2>To search by Groups, &nbsp;  Free &nbsp; <a id="" class="" href="<?php echo esc_url($url);?>">Groups</a> &nbsp; plugin needed </h2>
            <p><?php echo esc_url($url);?></p>
            <br>                        
           </div>
          <?php             
        break; 
       case 'buy_group_memberships_needed':
          $url = esc_url("https://woocommerce.com/products/woocommerce-memberships/");
          ?>                           
          <div class="section">  
            <br>
            <a name="buygroups.buy_group_groups_needed" data-type="groups"></a><h2>To search by Membership, &nbsp; <a id="" class="" href="<?php echo esc_url($url);?>">WooCommerce Memberships</a> &nbsp; plugin needed </h2>
            <p><?php echo esc_url($url);?></p>
            <br>  
           </div>
          <?php             
        break; 
      case 'buy_group_show_and_or_switches_YesSelect':
          ?>                          
          <div class="section">
            <h2>Show &nbsp;&nbsp; AND | OR | EACH  <br>in the "Select Products" box below</h2>
            <p> DEFAULTS to "OR" </p>
            <p> And/Or <strong>Processing Sequence</strong>: 
              <br>1. Exclusions 
              <br>2. Inclusions with 'AND' 
                <br>&nbsp;&nbsp;&nbsp; - <em> All </em> 'AND' inclusions
                <br>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<em>must</em> be satisfied
              <br>3. Inclusions with 'OR' 
                <br>&nbsp;&nbsp;&nbsp; - <em> Any </em> 'OR' inclusion 
                <br>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;can "activate" the deal
            </p>                               
           </div>
          <?php             
        break;      
      case 'action_group_show_and_or_switches_YesSelect':
          ?>                          
          <div class="section">            
            <h2>Show &nbsp;&nbsp; AND | OR  <br>in the "Select Products" box below</h2>
            <p> DEFAULTS to "OR" </p>
            <p> And/Or <strong>Processing Sequence</strong>: 
              <br>1. Exclusions 
              <br>2. Inclusions with 'AND' 
                <br>&nbsp;&nbsp;&nbsp; - <em> All </em> 'AND' inclusions
                <br>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<em>must</em> be satisfied
              <br>3. Inclusions with 'OR' 
                <br>&nbsp;&nbsp;&nbsp; - <em> Any </em> 'OR' inclusion 
                <br>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;can "activate" the deal
            </p>                               
           </div>
          <?php             
        break;   
      case 'buy_group_show_and_or_switches_NoSelect':
          ?>                          
          <div class="section">
            <h2>Show &nbsp;&nbsp; AND | OR | EACH  <br>in the "Select Products" box below</h2>
            <p> DEFAULTS to "OR" </p>
            <p> And/Or <strong>Processing Sequence</strong>: 
              <br>1. Exclusions 
              <br>2. Inclusions with 'AND' 
                <br>&nbsp;&nbsp;&nbsp; - <em> All </em> 'AND' inclusions
                <br>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<em>must</em> be satisfied
              <br>3. Inclusions with 'OR' 
                <br>&nbsp;&nbsp;&nbsp; - <em> Any </em> 'OR' inclusion 
                <br>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;can "activate" the deal
            </p>                               
           </div>
          <?php             
        break;      
      case 'action_group_show_and_or_switches_NoSelect':
          ?>                          
          <div class="section">            
            <h2>Show &nbsp;&nbsp; AND | OR  <br>in the "Select Products" box below</h2>
            <p> DEFAULTS to "OR" </p>
            <p> And/Or <strong>Processing Sequence</strong>: 
              <br>1. Exclusions 
              <br>2. Inclusions with 'AND' 
                <br>&nbsp;&nbsp;&nbsp; - <em> All </em> 'AND' inclusions
                <br>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<em>must</em> be satisfied
              <br>3. Inclusions with 'OR' 
                <br>&nbsp;&nbsp;&nbsp; - <em> Any </em> 'OR' inclusion 
                <br>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;can "activate" the deal
            </p>                               
           </div>
          <?php             
        break;
         
      case 'buy_group_prod_cat_AndSelect':
      case 'action_group_prod_cat_AndSelect':
          ?>                          
          <div class="section">
            <?php  vtprd_show_and_or_each_message('and','Category'); ?>                                
          </div>
          <?php             
        break;
      case 'buy_group_prod_cat_OrSelect':
      case 'action_group_prod_cat_OrSelect':
          ?>                          
          <div class="section">
            <?php  vtprd_show_and_or_each_message('or','Category'); ?>                              
           </div>
          <?php             
        break;
      case 'buy_group_prod_cat_EachSelect':
          ?>                          
          <div class="section">
           <?php  vtprd_show_and_or_each_message('each','Category'); ?> 
          </div>
          <?php             
        break;
               
      case 'buy_group_plugin_cat_AndSelect':
      case 'action_group_plugin_cat_AndSelect':
          ?>                          
          <div class="section">
            <?php  vtprd_show_and_or_each_message('and','Category'); ?>                                
           </div>
          <?php             
        break;
      case 'buy_group_plugin_cat_OrSelect':
      case 'action_group_plugin_cat_OrSelect':
          ?>                          
          <div class="section">
            <?php  vtprd_show_and_or_each_message('or','Category'); ?>                                
           </div>
          <?php             
        break;
      case 'buy_group_plugin_cat_EachSelect':
          ?>                          
          <div class="section">
            <?php  vtprd_show_and_or_each_message('each','Category'); ?> 
          </div>
          <?php             
        break; 
                	
      case 'buy_group_product_AndSelect':
      case 'action_group_product_AndSelect':
          ?>                          
          <div class="section">
            <?php  vtprd_show_and_or_each_message('and','Product'); ?>                                
           </div>
          <?php             
        break;
      case 'buy_group_product_OrSelect':
      case 'action_group_product_OrSelect':
          ?>                          
          <div class="section">
            <?php  vtprd_show_and_or_each_message('or','Product'); ?>                                
           </div>
          <?php             
        break;
      case 'buy_group_product_EachSelect':
          ?>                          
          <div class="section">
            <?php  vtprd_show_and_or_each_message('each','Product'); ?> 
           </div>
          <?php             
        break;
        
      case 'buy_group_var_name_AndSelect':
      case 'action_group_var_name_AndSelect':
          ?>                          
          <div class="section">
            <?php  vtprd_show_and_or_each_message('and','Variation Name'); ?>                                
           </div>
          <?php             
        break;
      case 'buy_group_var_name_OrSelect':
      case 'action_group_var_name_OrSelect':
          ?>                          
          <div class="section">
            <?php  vtprd_show_and_or_each_message('or','Variation Name'); ?>                               
           </div>
          <?php             
        break;
      case 'buy_group_brands_AndSelect':
      case 'action_group_brands_AndSelect':
          ?>                          
          <div class="section">
            <?php  vtprd_show_and_or_each_message('and','Brand'); ?>                                
           </div>
          <?php             
        break;
      case 'buy_group_brands_OrSelect':
      case 'action_group_brands_OrSelect':
          ?>                          
          <div class="section">
            <?php  vtprd_show_and_or_each_message('or','Brand'); ?>                                 
           </div>
          <?php             
        break;         
        //*************
        //v2.0.0 end 
        //************* 
                  
      case 'cart_or_catalog_select':
          ?>  
                
          <!-- catalogorcart--> 
          <div class="section">
            <a name="blueprint.catalogorcart" data-type="group"></a><h2>Discount applied in Cart or Catalog</h2>
             <p class="larger-strong">
              <strong>When and where does the discount happen?</strong>
                <ul class="">
                  <li><strong>Add to CART Discount</strong>
                  <br> - &nbsp;&nbsp; Discount <em>first applied</em>&nbsp; when a product is <em>added to cart</em> <strong> (Most Deals!)</strong>
                  </li>
                  <li><strong>Catalog Price Reduction</strong>
                  <br> - &nbsp;&nbsp; Discount <em>first applied</em>&nbsp; when the product is <em>seen in the catalog</em>&nbsp; (just like a product sale price)
                  </li>
               </ul>
             </p>                
          </div> <!-- //catalogorcart--> 
           
          <?php             
        break;
                
      case 'pricing_type_select':
          ?>  
          
          <!-- dealtype-->         
          <div class="section">
            <p class="larger-strong">
                <strong>What kind of Pricing Deal do you want to offer?</strong>
               <ul class="">
                  <li><em>Just Discount the Items</em>                
                      <br><strong> - "10% Off All Laptops"</strong>
                  </li>
                  <li><em>Buy One Get One &nbsp;&nbsp;(Bogo)</em>                
                      <br><strong> - "Buy 1 Apple, get 1 50% off"</strong>
                      <br><strong> - "Buy a Laptop, get a mouse free"</strong>
                  </li>
                  <li><em>Package Pricing</em>                                     
                      <br><strong> - "Buy 5 Apples for $5"</strong>
                      <br><strong> - "Buy 5 Vegetables for the price of 4"</strong>
                  </li> 
                  <li><em>Discount Cheapest / Most Expensive</em>                
                      <br><strong> - "Buy 2 Laptops, get 20% off Most Expensive"</strong>
                  </li>
                  <li><em>Whole Store / Catalog on Sale</em>                
                      <br><strong> - (Just what it says!)</strong>
                  </li>
              
               </ul>            
            </p>                            
                                               
          </div> 
  
          <?php             
        break;
         
       case 'minimum_purchase_select':
          //v1.1.8.1 reworded
          ?>  
 
          <!-- dealaction-->
          <div class="section">
            <a name="blueprint.dealaction" data-type="group"></a><h2>Deal Action</h2>
            <p class="narrower-paragraph larger-strong">
                <strong>What are we discounting? </strong>
               <ul>
                  <li><strong>Buy 5 things, discount 1 of these 5</strong></li>
                  <li>&nbsp;&nbsp; - Choose <em>"Discount the item"</em></li> 
                  <li><strong>OR,</strong></li> 
                  <li><strong>Buy 5 things, discount the Next 1 </strong></li>
                  <li>&nbsp;&nbsp; - Choose <em>"Discount *Next* item"</em></li>                                                                                                         
               </ul>

            </p>                                                    
          </div> 

          <?php             
        break;
        
      case 'scheduling':
          ?>       
          <!-- scheduling-->
          <div class="section">
            <a name="blueprint.scheduling" data-type="group"></a><h2>Deal Schedule</h2>
            <p class="narrower-paragraph larger-strong">
                <strong>When is the Deal active?</strong>

               <ul class="">
                  <li>Rule is ON + Begin / End Dates&nbsp;&nbsp;=</li>
                  <li>&nbsp;&nbsp; Rule is active with scheduling</li>
                  <li>Rule is ON Always &nbsp;&nbsp;=</li> 
                  <li>&nbsp;&nbsp; Rule is active with NO scheduling limits</li>
                  <li>Rule is OFF &nbsp;&nbsp;=</li> 
                  <li>&nbsp;&nbsp; Shut off the rule</li>                
               </ul> 
                <?php //v2.0.0.5 UL added ?>
               <ul class="">
                  <li>Scheduling Begin time is 12:01 am on the begin date, end time is 12 midnight on the end date.</li>
                  <li>&nbsp;&nbsp; All time calculations are based on the Wordpress timezone.</li>
                  <li>Wordpress Timezone is set on the Settings/General Settings page</li> 
                  <li>Wordpress Timezone can in turn can be overriden for Pricing Deals processing on your Pricing Deals Rules/Pricing Deals Settings page, at the "Select Store Time Zone" setting.</li>                
               </ul>                              
            </p>
          </div>  <!-- //scheduling--> 
 
          <?php             
        break;
        
      case 'wizard_on_off_sw_select':
          ?>  
          <div class="section">
            <a name="blueprint.showme" data-type="group"></a><h2>Hover Help Wizard</h2>
            <p class="narrower-paragraph larger-strong">
                <strong>Wizard is On = 
                <br>Show Hover in-Depth Info</strong>
            </p>                                                               
          </div>             

          <?php             
        break; 
         
      case 'hover-help':
          ?>       
            <p class="narrower-paragraph">
               <ul class="">
                  <li><em>- Turn on Hover Help Wizard</em></li> 
                  <li>&nbsp;</li> 
                  <li><b>Hover over the Label Names </li> 
                  <li>&nbsp;&nbsp;&nbsp; in the Left Column</b></li> 
                  <li>&nbsp;</li>
                  <li>&nbsp;&nbsp;&nbsp; to see Hover Wizard Help</li>            
               </ul> 
            </p> 
 
          <?php             
        break;
          
      //v2.0.0 recoded
      case 'apply_deal_to_cheapest':
          ?>       
          <!-- apply_deal_to_cheapest-->
          <div class="section">
            <a name="blueprint.apply_deal_to_cheapest" data-type="group"></a><h2>Apply Discount to ...Cart Item First</h2>
            <p class="narrower-paragraph larger-strong"><em>Can only be used with BOGO Next deals</em></p>
            <p class="narrower-paragraph larger-strong"><h2>1. Discount Cheapest Item first</h2></p>
            <p class="narrower-paragraph larger-strong"><h2>2. Discount Most Expensive Item first</h2></p>
            <p class="narrower-paragraph larger-strong">
                <ul class="">
                  <li><h2>3. Discount Equal or <br>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Lesser Value Item first</h2></li>
                  <li>&nbsp;&nbsp;&nbsp; Equal or Lesser Value</li>
                  <li><em>&nbsp;&nbsp;&nbsp; - Discount the item(s) in the GET Group</em></li>  
                  <li><em>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; of equal or lesser value to the most</em></li> 
                  <li><em>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; expensive item in the BUY Group</em></li>                
               </ul>
            </p>                           
          </div>  <!-- //apply_deal_to_cheapest --> 
          <?php             
        break;
                    
      //v1.1.0.8
      case 'only_for_this_coupon_name':
          ?>       
          <!-- only_for_this_coupon_name-->
          <div class="section">
            <a name="blueprint.only_for_this_coupon_name" data-type="group"></a><h2>Acivate by Coupon Only</h2>
            <p class="narrower-paragraph larger-strong">
                <strong>With a coupon name entered here, the rule can only be activated when this coupon has been redeemed in the order.</strong>             
            </p>
          </div>  <!-- //only_for_this_coupon_name--> 
          <?php             
        break;
                                
      case 'rule-type-select':
          ?>  
          
          <!-- showme-->
          <div class="section">
            <a name="blueprint.showme" data-type="group"></a><h2>Show Me</h2>
            <p class="narrower-paragraph larger-strong">
                <strong>Basic Rule layout or Advanced?</strong>
                <ul class="">
                  <li>Basic rule &nbsp; =</li>
                  <li>&nbsp;&nbsp;&nbsp; <em>just the stuff you need to make a rule work</em> . &nbsp;(default)</li>  
                  <li>Advanced rule &nbsp; =</li> 
                  <li>&nbsp;&nbsp;&nbsp; <em>the whole shooting match,</em>&nbsp; with all of the bells and whistles.</li>                
               </ul>  
            </p>                                                            
          </div>  <!-- //showme-->             

          <?php             
        break; 
        
      case 'buy_amt_type':
          ?>  
                     
          <!-- buyamount-->
          <div class="section">
            <a name="buygroup.buyamount" data-type="group"></a><h2>Buy Group Amount</h2>
            <p class="larger-strong">
               <strong>How Many do we have to Buy to carry on processing this Deal?</strong>  
                <ol class="">
                  <li><em>Buy</em>&nbsp; <strong>XX</strong> &nbsp;<em>get a discount</em></li>
                  <li><em>Buy</em>&nbsp; <strong>XX</strong> &nbsp;<em>Get yy a discount</em></li>                 
               </ol>                                             
            </p>                      
          </div>            
  <!-- //buyamount-->

          <?php             
        break;
      case 'buy_amt_applies_to':
          ?>  
          
          <div class="section subsection">
            <a name="buygroup.buyamountapplies" data-type="group"></a><h2>
              <a class="subsection-title-smaller" href="<?php echo esc_js('javascript:void(0);');?>">Buy Group Amount Applies To</a></h2>          
            <p>
                <strong>How is the count Applied?</strong>                                                 
                 <ul class="list-more-margin">
                    <li><em>All Products</em> 
                    <br> - <b>All Products of the group are tallied together</b>
                    </li>

                    <li><em>Each Product</em> 
                    <br> - <b>Each product is tallied as a separate product total</b>.
                    </li>
                 </ul>                                                                   
            </p>
            
          </div>
          <?php             
        break;
      
      case 'inPop':
          ?>  

          <!-- buyfilter-->           
          <div class="section">
            <a name="buygroup.buyfilter" data-type="group"></a><h2>Buy Group Filter</h2>
            <p class="larger-strong">
                <strong> Does the Buy Group apply to:</strong>                                                              
                 <ul class="list-more-margin">
                    <li>All the products from the catalog?  
                    </li>

                    <li>Or only some of the products from the catalog?  
                    </li>
                 </ul>  
            </p>
            <p class="">
              <span class="bold-black">BUY Filter &nbsp;=&nbsp;</span> <em>Specifying what products are candidates for the Deal.</em>
            </p> 
                              
          </div>  <!-- //buyfiltercat--> 
        
          <?php             
        break; 
        
       //v1.1.7.1 begin
      case 'varName':
           esc_attr_e('Apply discounts across products using Variation (Product Attribute) Name(s).', 'vtprd');
              ?><br><?php
           esc_attr_e('Multiple variations may be listed, separated by:  &nbsp; "|" ', 'vtprd');
              ?><br><?php
           esc_attr_e(' &nbsp;&nbsp; Example: &nbsp; "large|green|blue"', 'vtprd');           
              ?><br><?php
           esc_attr_e('Multiple unique variation names may be strung together, separated by:  &nbsp; "+" ', 'vtprd');           
              ?><br><?php
           esc_attr_e(' &nbsp;&nbsp; Example: &nbsp; "large + green | large + blue | polo  + red + large"', 'vtprd');
              ?><br><br><?php 
            esc_attr_e('NOTE1: You <strong>Must use</strong> the <strong>FULL attribute name</strong>.', 'vtprd');           
              ?><br><?php
           esc_attr_e(' &nbsp;&nbsp; Example: &nbsp; If you have an attribute such as "extra large"', 'vtprd');           
              ?><br><?php                  
          esc_attr_e(' &nbsp;&nbsp; A search for "extra" or "large" will NOT be found', 'vtprd');  
              ?><br><br><?php
          esc_attr_e('NOTE2: <strong>Unique variation name combinations are required.</strong>', 'vtprd'); 
              ?><br><?php
          esc_attr_e(' &nbsp;&nbsp; So "chrome + chrome" will find anything with "chrome" in it.', 'vtprd');                                      
              ?><br><br><?php                             
        break;  
        //v1.1.7.1 end   
             
       case 'buy_amt_mod':
          ?>  

          <!-- buyminmax--> 
          <div class="section subsection clickable-subsection">
            <a name="buygroup.minmax" data-type="group"></a><h2>Buy Group Min / Max</h2>  
            <p class="larger-strong">
                <strong>Set a Minimum or Maximum $$ Value Condition </strong>

               <ol class="">
                  <li>Buy any 5 vegetables <b>for a minimum total of $5</b>, get 20% off </li>
                  <li>Buy any Laptop <b>for a maximum price of $2000</b>, get 10% off </li>          
               </ol>               
            </p>

          </div>  <!-- //buyminmax-->          
 
          <?php             
        break;
        
      case 'buy_repeat_condition':
          ?>  

          <!-- buyrepeat--> 
          <div class="section subsection clickable-subsection">
            <a name="buygroup.repeat" data-type="group"></a><h2>Buy Group / Rule Usage Count</h2>  
            <p class="larger-strong">
                <strong>How many times does the Buy Group get counted, and the Rule repeated?</strong>

               <ol class="">
                  <li>Apply Rule Once per Cart
                  </li>                  
                  <li>Unlimited Rule Usage Counts per Cart
                  </li> 
                  <li>Rule Usage Count Times, per Cart &nbsp;+&nbsp; a Count
                  </li> 
               </ol>                              
            </p>
            <p class="larger-strong">
                <strong>To Limit how many times a Customer can get a Discount,</strong>
                
                <em>Go to "Customer Rule Limit"<br> below (Advanced Rule)</em>              
            </p>                                                                                                     
          </div>  <!-- //buyrepeat-->          
 
          <?php             
        break;
 
         
       //v1.1.8.0 begin
      case 'pricingTable':
          ?>  

          <!-- pricingTable--> 
          <div class="section subsection clickable-subsection">
            <a name="pricingTable" data-type="group"></a><h2>Pricing Table / Bulk Discount / Pricing Tiers.</h2>  
            <p class="larger-strong">
                <strong>Discount based on Quantity Purchased - either by Unit Quantity or $$ Total</strong>

               <ol class="">
                  <li>"Count by Units or Currency" - Discount based on Unit Quantity or Dollar purchased
                  </li>                  
                  <li>"Begin / End Ranges Apply To" - Do you count the total in the group, or by Product line subtotal?
                  </li> 
                  <li>Pricing Table rows:
                      <br>&nbsp;&nbsp;Begin Quantity and End Quantity apply inclusively - 
                      <br>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;they count from and to <em>including the listed values</em>
                      <br>&nbsp;&nbsp;If you are counting by $$, be sure to include <strong>pennies (decimals)</strong> in establishing your range. 
                      <br>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;$5 - $10, $11-100, etc... 
                      <br>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Row 1:: Begin: $5  End: $10
                      <br>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Row 2:: Begin: $10.01  End: $10
                  </li> 
               </ol>                              
            </p>
                                                                                                     
          </div>  <!-- //pricingTable-->          
 
          <?php                             
        break;  
        //v1.1.8.0 end 
        
      case 'action_amt_type':
          ?>  
                    
          <!-- getamount-->                         
          <div class="section">
            <a name="getgroup.getamount" data-type="group"></a><h2>Get Group Amount</h2>
            <p class="larger-strong">
               <strong>How Many do we have to Get to carry on processing this Deal?</strong>
                 <ol class="">
                  <li><em>Buy xx Get </em>&nbsp; <strong>YY</strong> &nbsp;<em>a discount</em></li>                 
               </ol>                                              
            </p>          
            <p>
                <strong>How is the Get (Discount) Group Counted?</strong>                                                 
            </p>              
           </div>


          <?php             
        break;
      case 'action_amt_applies_to':
          ?>  
          
          <div class="section subsection">
            <a name="getgroup.getamountapplies" data-type="group"></a><h2>
              <a class="subsection-title-smaller" href="<?php echo esc_js('javascript:void(0);');?>">Get Group Amount Applies To</a></h2>          
            <p>
                <strong>How is the count Applied?</strong>                                                 

                 <ul class="list-more-margin">
                    <li><em>All Products</em> 
                    <br> - <b>All Products of the group are tallied together</b>
                    </li>

                    <li><em>Each Product</em> 
                    <br> - <b>Each product is tallied as a separate product total</b>
                    </li>
                 </ul>                                                                   
            </p>
                
          </div>  <!-- //getamount-->

          <?php             
        break;
        
      case 'actionPop':
          ?>  
 
          <!-- getfilter-->           
          <div class="section">
            <a name="getgroup.getfilter" data-type="group"></a><h2>Get Group Filter</h2>
            <p class="larger-strong">
                <strong> Does the Get Group apply to:</strong>                                                              
                 <ul class="list-more-margin">
                    <li>All the products from the catalog? 
                    </li>

                    <li>Or only some of the products from the catalog?  
                    </li>
                 </ul> 
            </p>
            <p class="">
              <span class="bold-black">Filter &nbsp;=&nbsp;</span> <em>Specifying what products are candidates for the Deal.</em>
            </p>
                         
          </div>  <!-- //getfilter-->  
 

          <?php             
        break;
        
     case 'action_amt_mod':
          ?>  

          <!-- getminmax--> 
          <div class="section subsection clickable-subsection">
            <a name="getgroup.minmax" data-type="group"></a><h2>Get Group Min / Max</h2>  
            <p class="larger-strong">
                <strong>Set a Minimum or Maximum $$ Value Condition </strong>

               <ul class="">
                  <li>None
                  </li>                  
                  <li>Minimum $$ Value  &nbsp;+&nbsp; Value
                  </li> 
                  <li>Maximum $$ Value  &nbsp;+&nbsp; Value
                  </li> 
               </ul>                              

               <ol class="">
                  <li>Buy any 5 vegetables, get the Next 5 Vegetables <em>which have a minimum total of $5</em>&nbsp;, for 20% off </li>
                  <li>Buy any 5 vegetables, get the Next 5 Vegetables <em>which have a maximimum total of $5</em>&nbsp;, for 20% off </li>          
               </ol>               
            </p>
                                                                               
          </div>  <!-- //getminmax-->          
       
          <?php             
        break; 
        
       case 'action_repeat_condition':
          ?>  
 
          <!-- getrepeat--> 
          <div class="section subsection clickable-subsection">
            <a name="getgroup.repeat" data-type="group"></a><h2>Get Group Repeat</h2>  
            <p class="larger-strong">
                <strong>How many times does the Get Group get counted, <em>once the Buy Group count has been satisfied?</em></strong>

               <ol class="list-more-margin">
                  <li><b>None</b>
                  </li>                  
                  <li><b>Unlimited Discount Group Repeats</b>
                  </li> 
                  <li><b>Discount Group Repeat Count &nbsp;+&nbsp; a Count</b>
                  </li> 
               </ol>                              
            </p>           
                                                                                           
          </div>   <!-- //getrepeat-->          

          <?php             
        break;
        
      case 'discount_amt_type':
          ?>  

          <!-- discountamount-->                         
          <div class="section">
            <a name="discount.discountamount" data-type="group"></a><h2>Discount Amount</h2>
            <p class="larger-strong">
               <strong>What $ Value Discount are we Offering?  How is that $ Discount computed?</strong>                                             
            </p>
          </div>  
 
          <?php             
        break;
        
      case 'discount_free':
          ?>  
                                         
          <!-- discountfree-->        
          <div class="section subsection clickable-subsection">
            <a  name="discount.discountfree" data-type="group"></a><h2>Free, with Auto Add</h2>
             <p class="larger-strong">
                <strong>Discount Amount Type - &nbsp;Free&nbsp; -</strong>  a Free Product can be Added Automatically to Cart                                                
            </p>
            <p>
              You can instruct the rule to Add a Free product to the cart automatically, when Discount Type = "Free". 
            </p>             

           <p>
                <b>Note:</b>&nbsp; <b>Auto Add</b> of free products is <em>only</em>&nbsp; <b>available when the Discount Group is a single, unique product</b>
                <br> - (otherwise auto add would not know what to add!)
            </p>
          </div>  <!-- //discountfree--> 


          <?php             
        break;
                
      case 'discount_applies_to':
          ?>  
          <!-- discountappliesto-->                         
          <div class="section">
            <a name="discount.discountappliesto" data-type="group"></a><h2>Discount Applies To</h2>       
            <p>
                <strong>How is the count Applied?</strong>                                                 
            </p>
            <p>
                 <ul class="list-more-margin">
                    <li><em>All Products</em> 
                    <br> - <b>All Products are tallied as a unified group</b>
                    </li>

                    <li><em>Each Product</em> 
                    <br> - <b>Each product is tallied as a separate product total</b>
                    </li>
                 </ul>                                                                   
            </p>
           
          </div>
          <?php             
        break;
        
      case 'discount_product_short_msg':
          ?>  
        
          <div class="section">
            <a name="messages.checkout" data-type="group"></a><h2>Checkout Message</h2>
            <p>
                 The short <strong>checkout message</strong> <em>summarizes your deal,</em>&nbsp; and is used both in the mini-cart and at checkout 
                 <br>for cart purchases <em>only.</em>                                              
            </p>
            <p>
                 <strong>The short checkout message is Never used for a Catalog Discount.</strong>                                               
            </p>       
          </div> 
     
          <?php             
        break;
        
      case 'discount_product_full_msg':
          $url = esc_url("http://www.varktech.com/documentation/pricing-deals/shortcodes");
          ?>  
      
          <div class="section">
            <a name="messages.marketing" data-type="group"></a><h2> Advertising Message</h2>
            <p>
                 The  <strong>Advertising Message</strong> is the place for you to put in your full <b>Deal marketing message</b>.                                              
            </p>
           <p>
                 The <b> Advertising Messages</b> can be shown in your Website using <a class="commentURL" target="_blank" href="<?php echo esc_url($url);?>"><?php esc_attr_e('Shortcodes', 'vtprd');?></a> .                         
            </p>           
                                                               
          </div>                 
          
          <?php             
        break;
        
      case 'discount_lifetime_max_amt_type':
          ?>  
       
          <div class="section">
            <a name="limits.percustomer" data-type="group"></a><h2>Customer Rule Limit</h2>
            <p class="larger-strong">
                 <strong>Controls the Number of times a customer can use a Discount. &nbsp;&nbsp;Ever.</strong>                                              

                 <ol class="">
                    <li><em>The Number of times a customer can use a Discount.</em> &nbsp;&nbsp;<strong>Ever.</strong></li>

                    <li><em>The $$ value total a customer can receive from a Discount.</em> &nbsp;&nbsp;<strong>Ever.</strong></li>
                 </ol>                                            
            </p>

          </div>
                   
          <?php             
        break; 
        
      case 'discount_rule_max_amt_type':
          ?>  
        
          <div class="section">
            <a name="limits.percart" data-type="group"></a><h2>Cart Limit</h2>
            <p class="larger-strong">
                 <strong>Controls the Number of times a Cart can use a Discount..</strong>                                              

                 <ol class="">
                    <li><em>The percentage value</em>&nbsp; a Cart can use a Discount. </li>
                    <li><em>The Number of times</em>&nbsp; a Cart can use a Discount.</li>
                    <li><em>The $$ value total</em>&nbsp; a Cart can receive from a Discount.</li>
                 </ol>                                            
            </p>

          </div>                    

          <?php             
        break;
        
        
      case 'discount_rule_cum_max_amt_type':
          ?>  
      
          <div class="section">
            <a name="limits.perproduct" data-type="group"></a><h2>Product Limit</h2>
            <p class="larger-strong">
                 <strong>Controls the Number of times a Product can use a Discount.</strong>                                              

                 <ol class="">
                    <li><em>The percentage value</em>&nbsp; a customer can use a Discount in the product. </li>
                    <li><em>The Number of times</em>&nbsp; a customer can use a Discount in the product.</li>
                    <li><em>The $$ value total</em>&nbsp; a customer can receive from a Discount in the product.</li>
                 </ol>                                            
            </p>
 
          </div>
          <?php             
        break;
        
        
      case 'cumulativeRulePricing':
          ?>  
          
          <div class="section">
            <a name="workingwith.otherrules" data-type="group"></a><h2>Work with Other Rule Discounts</h2>
            <p>
                <strong>Does this rule work with other Rule Discounts?</strong>                                              

                 <ul class="list-more-margin">
                    <li><b>Yes</b> 
                        <br> - This discount will apply <em>in addition to</em>&nbsp; any other Rule Discounts. 
                    </li>
                    <li><b>No</b> 
                        <br> - If nother Rule Discount is present, <em>this discount will not be applied.</em> 
                    </li>
                   
                 </ul>                                            
            </p>           
     
          </div>  
    
          <?php             
        break;
        
      case 'cumulativeCouponPricing':
          ?>  

          <div class="section">
            <a name="workingwith.coupons" data-type="group"></a><h2>Working with Coupons</h2>
            <p>
                <strong>Does this rule work with other Coupons?</strong>                                             

                 <ul class="list-more-margin">
                    <li><b>Yes</b> 
                        <br> - This discount will apply <em>in addition to</em>&nbsp; any Coupon Discount. 
                    </li>
                    <li><b>No</b> 
                        <br> - If a Coupon is presented, <em>this discount will not be applied.</em> 
                    </li>
                   
                 </ul>                                            
            </p>                                          
          </div>  
         
          <?php             
        break;
        
      case 'cumulativeSalePricing':
          ?>  
        
          <div class="section">
            <a name="workingwith.saleprice" data-type="group"></a><h2>Working with Product Sale Pricing</h2>
            <p>
                <strong>Is the Product already on Sale?</strong>                                              

                 <ol class="list-more-margin">
                    <li><b> No</b> - if product already on Sale, no further discount  
                    </li>
                    <li><b>Apply Deal Discount to Product Sale Price</b>  
                    </li>
                    <li><b>Apply Discount to Regular Price, if Less than Sale Price</b>  </li>                
                 </ol>                                            
            </p>
                     
          </div>  
          <?php             
        break;
 
        
      case '':
          ?>  

          <?php             
        break;
     
    } //end switch                  
  } 
  
    
  function vtprd_show_object_hover_wizard_text($context) {          
    switch($context) {           
      //************
      //v2.0.0 begin
      //************    
      case 'buy_group_prod_cat_incl':
          ?>                           
          <div class="section">
            <a name="buygroup.buy_group_prod_cat_incl" data-type="group"></a><h2>Product Category Inclusion</h2>
            <p class="larger-strong">
               <strong>Product Categories that the Deal will be applied to, or that need to be in the cart in order for the discount to be applied</strong>                                             
            </p>                        
           </div>
          <?php             
        break;                   
      case 'buy_group_prod_cat_excl':
          ?>                           
          <div class="section">
            <a name="buygroup.buy_group_prod_cat_incl" data-type="group"></a><h2>Product Category Exclusion</h2>
            <p class="larger-strong">
               <strong>Product Categories that the Deal will not be applied to, or that cannot be in the cart in order for the discount to be applied</strong>                                             
            </p>                        
           </div>
          <?php             
        break;
      case 'buy_group_plugin_cat_incl':
          ?>                           
          <div class="section">
            <a name="buygroup.buy_group_plugin_cat_incl" data-type="group"></a><h2>Pricing Deals Category Inclusion</h2>
            <p class="larger-strong">
               <strong>Pricing Deals Categories that the Deal will be applied to, or that need to be in the cart in order for the discount to be applied</strong>                                             
            </p>                        
           </div>
          <?php             
        break;        
      case 'buy_group_plugin_cat_excl':
          ?>                           
          <div class="section">
            <a name="buygroup.buy_group_plugin_cat_incl" data-type="group"></a><h2>Pricing Deals Category Exclusion</h2>
            <p class="larger-strong">
               <strong>Pricing Deals Categories that the Deal will not be applied to, or that cannot be in the cart in order for the discount to be applied</strong>                                             
            </p>                        
           </div>
          <?php             
        break;
      case 'buy_group_product_incl':
          ?>                           
          <div class="section">
            <a name="buygroup.buy_group_product_incl" data-type="group"></a><h2>Product Inclusion</h2>
            <p class="larger-strong">
               <strong>Products that the Deal will be applied to, or that need to be in the cart in order for the discount to be applied</strong>                                             
            </p>                        
           </div>
          <?php             
        break;        
      case 'buy_group_product_excl':
          ?>                           
          <div class="section">
            <a name="buygroup.buy_group_product_incl" data-type="group"></a><h2>Product Exclusion</h2>
            <p class="larger-strong">
               <strong>Products that the Deal will not be applied to, or that cannot be in the cart in order for the discount to be applied</strong>                                             
            </p>                        
           </div>
          <?php             
        break;
      case 'buy_group_var_name_incl':
          ?>                           
          <div class="section">
            <a name="buygroup.buy_group_var_name_incl" data-type="group"></a><h2>Variation Name (across products) Inclusion</h2>
            <p class="larger-strong">
               <strong>Variation Names (across products) that the Deal will be applied to, or that need to be in the cart in order for the discount to be applied</strong>                                             
            </p>                        
           </div>
          <?php             
        break;        
      case 'buy_group_var_name_excl':
          ?>                           
          <div class="section">
            <a name="buygroup.buy_group_var_name_incl" data-type="group"></a><h2>Variation Name (across products) Exclusion</h2>
            <p class="larger-strong">
               <strong>Variation Names (across products) that the Deal will not be applied to, or that cannot be in the cart in order for the discount to be applied</strong>                                             
            </p>                        
           </div>
          <?php             
        break;
      case 'buy_group_varName_catalog_info':
          ?>                           
          <div class="section">
            <a name="buygroup.buy_group_var_name_incl" data-type="group"></a><h2>Variation Name (across products) NOTE</h2>
            <p class="larger-strong">
               <strong>Only <em>"priceable"</em> attributes can be used in a <em>CATALOG</em> rule.</strong>
               <br><br>&nbsp;&nbsp;&nbsp;In the Product Edit screen
               <br>&nbsp;&nbsp;&nbsp;If you can't <em>separately price</em> an attribute,
               <br>&nbsp;&nbsp;&nbsp;you <em>can't</em> use that attribute
               <br>&nbsp;&nbsp;&nbsp;in a Variation Name selection
               <br>&nbsp;&nbsp;&nbsp;for a <em>Catalog</em> rule.
               <br><br>&nbsp;&nbsp;&nbsp;ANY attribute
               <br>&nbsp;&nbsp;&nbsp;is fine in a <em>CART</em> rule, though!!!                                           
            </p>                        
           </div>
          <?php             
        break;
      case 'buy_group_brands_incl':
            $url1 = esc_url("https://wordpress.org/plugins/product-brands-for-woocommerce/");
           $url2 = esc_url("https://wordpress.org/plugins/perfect-woocommerce-brands/");
           $url3 = esc_url("https://wordpress.org/plugins/brands-for-woocommerce/");
           $url4 = esc_url("https://wordpress.org/plugins/yith-woocommerce-brands-add-on/");
           $url5 = esc_url("https://wordpress.org/plugins/ultimate-woocommerce-brands/");
           $url6 = esc_url("https://wordpress.org/plugins/wc-brand/");
          ?>                          
          <div class="section">
            <a name="buygroup.brands" data-type="group"></a><h2>Brand Inclusion</h2>
            <p class="larger-strong">
               <strong>Brands that the Deal will be applied to, or that need to be in the cart in order for the discount to be applied</strong>                                             
            </p>
            <p class="larger-strong">
                <span class='varName_addl_info  clear-left'> 
                  <?php esc_attr_e('( These FREE Brands plugins are supported by Pricing Deals natively )', 'vtprd'); ?>
                   <br>&nbsp;&nbsp;&nbsp; <a href="<?php echo esc_url($url1);?>">Product Brands For WooCommerce</a>  
                   <br>&nbsp;&nbsp;&nbsp; <a href="<?php echo esc_url($url2);?>">Perfect WooCommerce Brands</a> 
                   <br>&nbsp;&nbsp;&nbsp; <a href="<?php echo esc_url($url3);?>">Brands for WooCommerce</a> 
                   <br>&nbsp;&nbsp;&nbsp; <a href="<?php echo esc_url($url4);?>">YITH WooCommerce Brands Add-On</a> 
                   <br>&nbsp;&nbsp;&nbsp; <a href="<?php echo esc_url($url5);?>">Ultimate WooCommerce Brands</a> 
                   <br>&nbsp;&nbsp;&nbsp; <a href="<?php echo esc_url($url6);?>">Woocommerce Brands</a>          
                </span>                                             
            </p>
            <p class="larger-strong  clear-left">
               <br>
               <strong>If you'd like to have another plugin supported, drop Varktech a line </strong>                                            
            </p>            
            <br>
           </div>
          <?php             
        break;
      case 'buy_group_brands_excl':
           $url1 = esc_url("https://wordpress.org/plugins/product-brands-for-woocommerce/");
           $url2 = esc_url("https://wordpress.org/plugins/perfect-woocommerce-brands/");
           $url3 = esc_url("https://wordpress.org/plugins/brands-for-woocommerce/");
           $url4 = esc_url("https://wordpress.org/plugins/yith-woocommerce-brands-add-on/");
           $url5 = esc_url("https://wordpress.org/plugins/ultimate-woocommerce-brands/");
           $url6 = esc_url("https://wordpress.org/plugins/wc-brand/");
          ?>                          
          <div class="section">
            <a name="buygroup.brands" data-type="group"></a><h2>Brand Exclusion</h2>
            <p class="larger-strong">
               <strong>Brands that the Deal will not be applied to, or that cannot be in the cart in order for the discount to be applied</strong>                                             
            </p>
            <p class="larger-strong">
                <span class='varName_addl_info  clear-left'> 
                  <?php esc_attr_e('( <em>These are the Brands plugins that Pricing Deals supports natively </em>)', 'vtprd'); ?>
                   <br>&nbsp;&nbsp;&nbsp; <a href="<?php echo esc_url($url1);?>">Product Brands For WooCommerce</a>  
                   <br>&nbsp;&nbsp;&nbsp; <a href="<?php echo esc_url($url2);?>">Perfect WooCommerce Brands</a> 
                   <br>&nbsp;&nbsp;&nbsp; <a href="<?php echo esc_url($url3);?>">Brands for WooCommerce</a> 
                   <br>&nbsp;&nbsp;&nbsp; <a href="<?php echo esc_url($url4);?>">YITH WooCommerce Brands Add-On</a> 
                   <br>&nbsp;&nbsp;&nbsp; <a href="<?php echo esc_url($url5);?>">Ultimate WooCommerce Brands</a> 
                   <br>&nbsp;&nbsp;&nbsp; <a href="<?php echo esc_url($url6);?>">Woocommerce Brands</a>      
                </span>                                             
            </p>
            <br>
            <p class="larger-strong  clear-left">
               <strong>If you'd like to have another plugin supported, drop Varktech a line </strong>                                            
            </p>            
            <br>
           </div>
          <?php             
        break;        
      case 'buy-group-and-or-AndSelect':
          ?>                          
          <div class="section">
            <a name="buygroup.AndSelect" data-type="group"></a><h2>Customer Inclusion Attribute Required</h2>
            <p class="larger-strong">
               <strong>"AND" = <br>ONE of entries in the Role, Email, Groups or Membership Lists MUST be satisfied, in order for the discount to be applied.</strong>                                             
            </p>
            <p>
              "AND" Rule example - "Buy 3 of Category X and logged as Wholesale, get a discount" 
            </p>  
            <p>
              <em>(exclusions don't care about "and" or "or" - they apply regardless)</em> 
            </p> 
            
            <p> And/Or <strong>Processing Sequence</strong>: 
              <br>1. Exclusions 
              <br>2. Inclusions with 'AND' 
                <br>&nbsp;&nbsp;&nbsp; - <em> All </em> 'AND' inclusions
                <br>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<em>must</em> be satisfied
              <br>3. Inclusions with 'OR' 
                <br>&nbsp;&nbsp;&nbsp; - <em> Any </em> 'OR' inclusion 
                <br>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;can "activate" the deal
            </p>                              
           </div>
          <?php             
        break;
       case 'buy-group-and-or-OrSelect':
          ?>                           
          <div class="section">
            <a name="buygroup.AndSelect" data-type="group"></a><h2>Customer Attribute Selected for this Rule</h2>
            <p class="larger-strong">
              <strong>"OR" = <br>ANY of the listed items below will satisfy the Buy group participation criteria</strong>                                                             
            </p>
            <p class="larger-strong">
               <strong>Any entry in the Role, Email, Groups or Membership Lists can "activate" the deal.</strong>                                                            
            </p>
            
            <p> And/Or <strong>Processing Sequence</strong>: 
              <br>1. Exclusions 
              <br>2. Inclusions with 'AND' 
                <br>&nbsp;&nbsp;&nbsp; - <em> All </em> 'AND' inclusions
                <br>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<em>must</em> be satisfied
              <br>3. Inclusions with 'OR' 
                <br>&nbsp;&nbsp;&nbsp; - <em> Any </em> 'OR' inclusion 
                <br>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;can "activate" the deal
            </p>                                   
           </div>
          <?php             
        break;
      case 'buy_group_role_incl':
          ?>                           
          <div class="section">
            <a name="buygroup.buy_group_role_incl" data-type="group"></a><h2>Role Inclusion</h2>
            <p class="larger-strong">
               <strong>Roles that the Deal will be applied to, or that need to be in the cart in order for the discount to be applied</strong>                                             
            </p>                        
           </div>
          <?php             
        break;                   
      case 'buy_group_role_excl':
          ?>                           
          <div class="section">
            <a name="buygroup.buy_group_role_incl" data-type="group"></a><h2>Role Exclusion</h2>
            <p class="larger-strong">
               <strong>Roles that the Deal will not be applied to, or that cannot be in the cart in order for the discount to be applied</strong>                                             
            </p>                        
           </div>
          <?php             
        break;        
      case 'buy_group_email_incl':
          ?>                           
          <div class="section">
            <a name="buygroup.buy_group_email_incl" data-type="group"></a><h2>Email Inclusion</h2>
            <p class="larger-strong">
               <strong>Emails or Customer Names that the Deal will be applied to, or that need to be in the cart in order for the discount to be applied</strong>                                             
            </p>                        
           </div>
          <?php             
        break;                   
      case 'buy_group_email_excl':
          ?>                           
          <div class="section">
            <a name="buygroup.buy_group_email_incl" data-type="group"></a><h2>Email Exclusion</h2>
            <p class="larger-strong">
               <strong>Emails or Customer Names that the Deal will not be applied to, or that cannot be in the cart in order for the discount to be applied</strong>                                             
            </p>                        
           </div>
          <?php             
        break;
      case 'buy_group_groups_incl':
          ?>                           
          <div class="section">
            <a name="buygroup.buy_group_groups_incl" data-type="group"></a><h2>Groups Inclusion</h2>
            <p class="larger-strong">
               <strong>Groups that the Deal will be applied to, or that need to be in the cart in order for the discount to be applied</strong>                                             
            </p>                        
           </div>
          <?php             
        break;        
      case 'buy_group_groups_excl':
          ?>                           
          <div class="section">
            <a name="buygroup.buy_group_groups_incl" data-type="group"></a><h2>Groups Exclusion</h2>
            <p class="larger-strong">
               <strong>Groups that the Deal will not be applied to, or that cannot be in the cart in order for the discount to be applied</strong>                                             
            </p>                        
           </div>
          <?php             
        break;
      case 'buy_group_memberships_incl':
          ?>                           
          <div class="section">
            <a name="buymembership.buy_membership_memberships_incl" data-type="membership"></a><h2>Memberships Inclusion</h2>
            <p class="larger-strong">
               <strong>Memberships that the Deal will be applied to, or that need to be in the cart in order for the discount to be applied</strong>                                             
            </p>                        
           </div>
          <?php             
        break;        
      case 'buy_group_memberships_excl':
          ?>                           
          <div class="section">
            <a name="buymembership.buy_membership_memberships_incl" data-type="membership"></a><h2>Memberships Exclusion</h2>
            <p class="larger-strong">
               <strong>Memberships that the Deal will not be applied to, or that cannot be in the cart in order for the discount to be applied</strong>                                             
            </p>                        
           </div>
          <?php             
        break; 
       case 'buy_group_groups_needed':
           $url = esc_url("https://wordpress.org/plugins/groups/");
          ?>                           
          <div class="section">
            <br>
            <a name="buygroups.buy_group_groups_needed" data-type="groups"></a><h2>To search by Groups, &nbsp;  Free &nbsp; <a id="" class="" href="<?php echo esc_url($url);?>">Groups</a> &nbsp; plugin needed </h2>
            <p><?php echo esc_url($url);?></p>
            <br>                        
           </div>
          <?php             
        break; 
       case 'buy_group_memberships_needed':
          $url = esc_url("https://woocommerce.com/products/woocommerce-memberships/");
          ?>                           
          <div class="section">  
            <br>
            <a name="buygroups.buy_group_groups_needed" data-type="groups"></a><h2>To search by Membership, &nbsp; <a id="" class="" href="<?php echo esc_url($url);?>">WooCommerce Memberships</a> &nbsp; plugin needed </h2>
            <p><?php echo esc_url($url);?></p>
            <br>  
           </div>
          <?php             
        break; 
      case 'buy_group_show_and_or_switches_YesSelect':
          ?>                          
          <div class="section">
            <h2>Show &nbsp;&nbsp; AND | OR | EACH  <br>in the "Select Products" box below</h2>
            <p> DEFAULTS to "OR" </p>
            <p> And/Or <strong>Processing Sequence</strong>: 
              <br>1. Exclusions 
              <br>2. Inclusions with 'AND' 
                <br>&nbsp;&nbsp;&nbsp; - <em> All </em> 'AND' inclusions
                <br>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<em>must</em> be satisfied
              <br>3. Inclusions with 'OR' 
                <br>&nbsp;&nbsp;&nbsp; - <em> Any </em> 'OR' inclusion 
                <br>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;can "activate" the deal
            </p>                              
           </div>
          <?php             
        break;      
      case 'action_group_show_and_or_switches_YesSelect':
          ?>                          
          <div class="section">            
            <h2>Show &nbsp;&nbsp; AND | OR  <br>in the "Select Products" box below</h2>
            <p> DEFAULTS to "OR" </p>
            <p> And/Or <strong>Processing Sequence</strong>: 
              <br>1. Exclusions 
              <br>2. Inclusions with 'AND' 
                <br>&nbsp;&nbsp;&nbsp; - <em> All </em> 'AND' inclusions
                <br>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<em>must</em> be satisfied
              <br>3. Inclusions with 'OR' 
                <br>&nbsp;&nbsp;&nbsp; - <em> Any </em> 'OR' inclusion 
                <br>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;can "activate" the deal
            </p>                               
           </div>
          <?php             
        break;   
      case 'buy_group_show_and_or_switches_NoSelect':
          ?>                          
          <div class="section">
            <h2>Show &nbsp;&nbsp; AND | OR | EACH  <br>in the "Select Products" box below</h2>
            <p> DEFAULTS to "OR" </p>
            <p> And/Or <strong>Processing Sequence</strong>: 
              <br>1. Exclusions 
              <br>2. Inclusions with 'AND' 
                <br>&nbsp;&nbsp;&nbsp; - <em> All </em> 'AND' inclusions
                <br>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<em>must</em> be satisfied
              <br>3. Inclusions with 'OR' 
                <br>&nbsp;&nbsp;&nbsp; - <em> Any </em> 'OR' inclusion 
                <br>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;can "activate" the deal
            </p>                              
           </div>
          <?php             
        break;      
      case 'action_group_show_and_or_switches_NoSelect':
          ?>                          
          <div class="section">            
            <h2>Show &nbsp;&nbsp; AND | OR  <br>in the "Select Products" box below</h2>
            <p> DEFAULTS to "OR" </p>
            <p> And/Or <strong>Processing Sequence</strong>: 
              <br>1. Exclusions 
              <br>2. Inclusions with 'AND' 
                <br>&nbsp;&nbsp;&nbsp; - <em> All </em> 'AND' inclusions
                <br>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<em>must</em> be satisfied
              <br>3. Inclusions with 'OR' 
                <br>&nbsp;&nbsp;&nbsp; - <em> Any </em> 'OR' inclusion 
                <br>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;can "activate" the deal
            </p>                              
           </div>
          <?php             
        break;
      case 'buy_group_prod_cat_AndSelect':
      case 'action_group_prod_cat_AndSelect':
          ?>                          
          <div class="section">
            <?php  vtprd_show_and_or_each_message('and','Category'); ?>                                
          </div>
          <?php             
        break;
      case 'buy_group_prod_cat_OrSelect':
      case 'action_group_prod_cat_OrSelect':
          ?>                          
          <div class="section">
            <?php  vtprd_show_and_or_each_message('or','Category'); ?>                              
           </div>
          <?php             
        break;
      case 'buy_group_prod_cat_EachSelect':
          ?>                          
          <div class="section">
           <?php  vtprd_show_and_or_each_message('each','Category'); ?> 
          </div>
          <?php             
        break;
               
      case 'buy_group_plugin_cat_AndSelect':
      case 'action_group_plugin_cat_AndSelect':
          ?>                          
          <div class="section">
            <?php  vtprd_show_and_or_each_message('and','Category'); ?>                                
           </div>
          <?php             
        break;
      case 'buy_group_plugin_cat_OrSelect':
      case 'action_group_plugin_cat_OrSelect':
          ?>                          
          <div class="section">
            <?php  vtprd_show_and_or_each_message('or','Category'); ?>                                
           </div>
          <?php             
        break;
      case 'buy_group_plugin_cat_EachSelect':
          ?>                          
          <div class="section">
            <?php  vtprd_show_and_or_each_message('each','Category'); ?> 
          </div>
          <?php             
        break; 
                	
      case 'buy_group_product_AndSelect':
      case 'action_group_product_AndSelect':
          ?>                          
          <div class="section">
            <?php  vtprd_show_and_or_each_message('and','Product'); ?>                                
           </div>
          <?php             
        break;
      case 'buy_group_product_OrSelect':
      case 'action_group_product_OrSelect':
          ?>                          
          <div class="section">
            <?php  vtprd_show_and_or_each_message('or','Product'); ?>                                
           </div>
          <?php             
        break;
      case 'buy_group_product_EachSelect':
          ?>                          
          <div class="section">
            <?php  vtprd_show_and_or_each_message('each','Product'); ?> 
           </div>
          <?php             
        break;
        
      case 'buy_group_var_name_AndSelect':
      case 'action_group_var_name_AndSelect':
          ?>                          
          <div class="section">
            <?php  vtprd_show_and_or_each_message('and','Variation Name'); ?>                                
           </div>
          <?php             
        break;
      case 'buy_group_var_name_OrSelect':
      case 'action_group_var_name_OrSelect':
          ?>                          
          <div class="section">
            <?php  vtprd_show_and_or_each_message('or','Variation Name'); ?>                               
           </div>
          <?php             
        break;
      case 'buy_group_brands_AndSelect':
      case 'action_group_brands_AndSelect':
          ?>                          
          <div class="section">
            <?php  vtprd_show_and_or_each_message('and','Brand'); ?>                                
           </div>
          <?php             
        break;
      case 'buy_group_brands_OrSelect':
      case 'action_group_brands_OrSelect':
          ?>                          
          <div class="section">
            <?php  vtprd_show_and_or_each_message('or','Brand'); ?>                                 
           </div>
          <?php             
        break;         
        //*************
        //v2.0.0 end 
        //*************  
              
      case 'cart_or_catalog_select':
          ?>  
                
          <!-- catalogorcart--> 
          <div class="section">
            <a name="blueprint.catalogorcart" data-type="group"></a><h2>Discount applied in Cart or Catalog</h2>
            <p class="larger-strong">
              <strong>When and where does the discount happen?</strong>
                <ul class="">
                  <li><strong>Add to CART Discount</strong>
                  <br> - &nbsp;&nbsp; Discount <em>first applied</em>&nbsp; when a product is <em>added to cart</em> <strong> (Most Deals!)</strong>
                  </li>
                  <li><strong>CATALOG Display Discount</strong>
                  <br> - &nbsp;&nbsp; Discount <em>first applied</em>&nbsp; when the product is <em>seen in the catalog</em>&nbsp; (just like a product sale price)
                  </li>
               </ul>
             </p>

             <p class="larger-strong">
               <em>Examples of CATALOG Display Discount</em>
               <ol class="">
                  <li>For Membership or Wholesaler (by logged-in Role) Catalog Discount</li>
                  <li>Any Direct Catalog Discount Sale</li>
               </ol> 
             </p>
              <p class="larger-strong">
                  <b>Note:</b>&nbsp; <b>Catalog Rules always apply to the entire Filter Group!</b>
              </p>                   
          </div> <!-- //catalogorcart--> 
          
          <?php             
        break;
                
      case 'pricing_type_select':
          ?>  
          
          <!-- dealtype-->         
          <div class="section">

            <p class="larger-strong">
                <strong>What kind of Pricing Deal do you want to offer?</strong>
               <ul class="">
                  <li><em>Just Discount the Items</em>                
                      <br><strong> - "10% Off All Laptops"</strong>
                  </li>
                  <li><em>Buy One Get One &nbsp;&nbsp;(Bogo)</em>                
                      <br><strong> - "Buy 1 Apple, get 1 50% off"</strong>
                      <br><strong> - "Buy a Laptop, get a mouse free"</strong>
                  </li>
                  <li><em>Package Pricing</em>                                     
                      <br><strong> - "Buy 5 Apples for $5"</strong>
                      <br><strong> - "Buy 5 Vegetables for the price of 4"</strong>
                  </li> 
                  <li><em>Discount Cheapest / Most Expensive</em>                
                      <br><strong> - "Buy 2 Laptops, get 20% off Most Expensive"</strong>
                  </li>
                  <li><em>Whole Store / Catalog on Sale</em>                
                      <br><strong> - (Just what it says!)</strong>
                  </li>
              
               </ul>            
            </p>                             
                                                     
          </div>  <!-- //bogo, baby--> 
          
          <?php             
        break;
         
       case 'minimum_purchase_select':
          ?>  
 
          <!-- dealaction-->
          <div class="section">
            <a name="blueprint.dealaction" data-type="group"></a><h2>Deal Action</h2>
            <p class="narrower-paragraph larger-strong">
                <strong>What are we discounting?</strong>
            </p> 
            
            <p class="">
               <h3 class="subtitle-h3 ">Does the Deal need a Gateway Value? That is,</h3>
               <ul class="list-more-margin larger-strong">
                  <li><strong>Do you have to <em>purchase something first,</em> 
                     <br>before you can purchase the discounted item?</strong>. 
                  </li> 
                 <li>If <b>"Yes"</b>, Choose <em><b>"Buy Something, Discount the *Next* item"</b></em>  
                 </li> 
                 <li>If <b>"No"</b>,&nbsp; Choose <em><b>"Buy Something, Discount the item"</b></em>  
                 </li>                                                                      
               </ul>

                Once we satisfy the BUY Group requirements, 
                <br>- do we Discount something we've already counted, 
                <br>- or Discount something not yet counted ?
            </p>                                                    
          </div> 
                  
          <div class="section subsection">
            <a name="blueprint.dealaction1" data-type="group"></a><h2>
              <a class="subsection-title-smaller" href="<?php echo esc_js('javascript:void(0);');?>">Buy Something, Discount the *Next* Item</a></h2>
             <p>
              This Deal <strong>requires that a BUY Group <em>Gateway Value</em>&nbsp; be reached</strong>, <br>before the discount is applied to the <strong><em>Next</em></strong> &nbsp;item.

               <ul class="list-more-margin">
                  <li>Buy a Laptop, Get <em>a mouse</em> &nbsp;free</li>                  
                  <li>Buy a Laptop, Get a <em>2nd Laptop</em> &nbsp;at 20% off</li>                  
               </ul>                              
            </p>
          </div> 
                  
          <div class="section subsection">
            <a name="blueprint.dealaction2" data-type="group"></a><h2>
              <a class="subsection-title-smaller" href="<?php echo esc_js('javascript:void(0);');?>">Buy Something, Discount the Item</a></h2>
             <p>
              This Deal <strong>applies the discount directly to the BUY Group &nbsp;(<em>This</em>&nbsp; Group )</strong>

               <ul class="">
                  <li>" Buy a Laptop, Get 10% off "</li>
                  <li>" Buy a 2 Laptops, Get $200 off "</li>                  
               </ul>               
            </p>
          </div>  <!-- //dealaction-->   
       
          <?php             
        break;
        
      case 'scheduling':
          ?>       
          <!-- scheduling-->
          <div class="section">
            <a name="blueprint.scheduling" data-type="group"></a><h2>Deal Schedule</h2>
            <p class="narrower-paragraph larger-strong">
                <strong>When is the Deal active?</strong>
            </p> 
            <p>
               <h3 class="subtitle-h3">Deals Can be Scheduled in a few ways:</h3>
               <ul class="">
                  <li>" Rule is ON " + Begin / End Dates  &nbsp;&nbsp;=&nbsp;&nbsp; Rule is active between the dates &nbsp;&nbsp;(including begin day / end day)                  
                      <br>&nbsp;&nbsp; - A deal can be scheduled to begin now or in the future.
                  </li>
                  <li>" Rule is ON Always " &nbsp;&nbsp;=&nbsp;&nbsp; Rule is active with NO scheduling limits</li> 
                  <li>" Rule is OFF " &nbsp;&nbsp;=&nbsp;&nbsp; Shut off the rule</li>                 
               </ul>
                <?php //v2.0.0.5 UL added ?>
               <ul class="">
                  <li>Scheduling Begin time is 12:01 am on the begin date, end time is 12 midnight on the end date.</li>
                  <li>&nbsp;&nbsp; All time calculations are based on the Wordpress timezone.</li>
                  <li>Wordpress Timezone is set on the Settings/General Settings page</li> 
                  <li>Wordpress Timezone can in turn can be overriden for Pricing Deals processing on your Pricing Deals Rules/Pricing Deals Settings page, at the "Select Store Time Zone" setting.</li>                
               </ul>                               
            </p>
            <br>
            <p class="larger-strong">
                <b>Note:</b>&nbsp; Default = <b>"Rule is ON" ,&nbsp; Begin Date: <em>today</em> ,&nbsp;  End Date: <em>in 1 year</em>.</b>
            </p>
          </div>  <!-- //scheduling--> 
 
          <?php             
        break;
    
      case 'rule-type-select':
          ?>  
          
          <!-- showme-->
          <div class="section">
            <a name="blueprint.showme" data-type="group"></a><h2>Show Me</h2>
            <p class="narrower-paragraph larger-strong">
                <strong>Basic Rule layout or Advanced?</strong>
            </p> 
            <p>
               Basic rule &nbsp; = &nbsp; <em>just the stuff you need to make a rule work</em> . &nbsp;(default)
            </p> 
            <p>
               Advanced rule &nbsp; = &nbsp; <em>the whole shooting match,</em>&nbsp; with all of the bells and whistles.
            </p>                                                              
          </div>  <!-- //showme-->             

          <?php             
        break; 
        
       //v1.1.7.1 begin
      case 'varName':
           esc_attr_e('Apply discounts across products', 'vtprd');
              ?><br><?php
           esc_attr_e(' &nbsp;&nbsp; by Variation (Product Attribute) Names.', 'vtprd');
              ?><br><br><?php              
           esc_attr_e('Multiple unique variations may be listed, separated by:  &nbsp; "|" ', 'vtprd');
              ?><br><?php
           esc_attr_e(' &nbsp;&nbsp; Example: &nbsp; "large|green|blue"', 'vtprd');           
              ?><br><br><?php
           esc_attr_e('Multiple variation names may be strung together, separated by:  &nbsp; "+" ', 'vtprd');           
              ?><br><?php
           esc_attr_e(' &nbsp;&nbsp; Example: &nbsp; "large + green | large + blue | polo  + red + large"', 'vtprd'); 
              ?><br><br><?php 
           esc_attr_e('NOTE1: You <strong>Must use</strong> the <strong>FULL attribute name</strong>.', 'vtprd');           
              ?><br><?php
           esc_attr_e(' &nbsp;&nbsp; Example: &nbsp; If you have an attribute such as "extra large"', 'vtprd');           
              ?><br><?php                  
          esc_attr_e(' &nbsp;&nbsp; A search for "extra" or "large" will NOT be found', 'vtprd');                        
              ?><br><br><?php  
          esc_attr_e('NOTE2: <strong>Unique variation name combinations are required.</strong>', 'vtprd'); 
              ?><br><?php
          esc_attr_e(' &nbsp;&nbsp; So "chrome + chrome" will find anything with "chrome" in it.', 'vtprd');                                  
              ?><br><br><?php                          
        break;  
        //v1.1.7.1 end    
                
        
      case 'buy_amt_type':
          ?>  
                     
          <!-- buyamount-->
          <div class="section">
            <a name="buygroup.buyamount" data-type="group"></a><h2>Buy Group Amount</h2>
            <p class="larger-strong">
               <strong>How Many do we have to Buy to carry on processing this Deal?</strong>
                <ol class="">
                  <li><em>Buy</em>&nbsp; <strong>XX</strong> &nbsp;<em>get a discount</em></li>
                  <li><em>Buy</em>&nbsp; <strong>XX</strong> &nbsp;<em>Get yy a discount</em></li>                 
               </ol>                                                
            </p>
          </div>           
          
          <div class="section subsection">
            <a name="buygroup.buyamounttype" data-type="group"></a><h2>
              <a class="subsection-title-smaller" href="<?php echo esc_js('javascript:void(0);');?>">Buy Group Amount Type</a></h2>          
            <p>
                <strong>How is the Buy Group Counted?</strong>                                                 
            </p>            
            <p>
                 <ul class="list-more-margin">
                    <li><em>Buy Each Unit</em> 
                    <br> - by single product units
                    </li> 

                    <li><em>Buy Unit Quntity</em> 
                    <br> - by a quantity of product units
                    </li>

                    <li><em>Buy $$ Value</em> 
                    <br> - by a $$ Value of product units
                    </li>  

                 </ul>                                                                                                  
            </p>

            <p>
                Buy Group Amount Type &nbsp; is a <em>required field.</em>                                                
            </p>
          </div>        
          
          <div class="section subsection">
            <a name="buygroup.buyamountcount" data-type="group"></a><h2>
              <a class="subsection-title-smaller" href="<?php echo esc_js('javascript:void(0);');?>">Buy Group Amount Count</a></h2>          
            <p>
                <strong>The Count box contains the actual number Quantity or $$ Value</strong> we have to purchase to gain access to this Deal                                                 
            </p>

            <p>
                Buy Group Amount Count &nbsp; is a <em>required field, if</em>&nbsp;  the &nbsp; Buy Group Amount Type &nbsp; needs it.                                               
            </p>             
          </div> 
  <!-- //buyamount-->

          <?php             
        break;
      case 'buy_amt_applies_to':
          ?>  
          
          <div class="section subsection">
            <a name="buygroup.buyamountapplies" data-type="group"></a><h2>
              <a class="subsection-title-smaller" href="<?php echo esc_js('javascript:void(0);');?>">Buy Group Amount Applies To</a></h2>          
            <p>
                <strong>How is the count Applied?</strong>                                                 
            </p>
            <p>
                 <ul class="list-more-margin">
                    <li><em>All Products</em> 
                    <br> - <b>All Products of the group are tallied together</b>
                    <br>&nbsp;&nbsp;For example: 2 Oranges and 3 Apples in the Buy Group &nbsp;=&nbsp; <b>a single total of 5 units.</b>
                    </li>

                    <li><em>Each Product</em> 
                    <br> - <b>Each product is tallied as a separate product total</b>
                    <br>&nbsp;&nbsp;For example: 2 Oranges and 3 Apples in the Buy Group &nbsp;=&nbsp; <b>separate totals of 2 and 3 units respectively</b>.
                    </li>
                 </ul>                                                                   
            </p>

            <p>
                Buy Group Amount Applies To &nbsp; is an <em>optional field,</em>&nbsp; available under <em>Advanced Rule.</em>  &nbsp;&nbsp;Default &nbsp;=&nbsp; <b>" Each Product "</b>                                               
            </p>            
          </div>
          <?php             
        break;
      
      case 'inPop':
          ?>  

          <!-- buyfilter-->           
          <div class="section">
            <a name="buygroup.buyfilter" data-type="group"></a><h2>Buy Group Filter</h2>
            <p class="larger-strong">
                <strong> Does the Buy Group apply to:</strong>                                                              
                 <ul class="list-more-margin">
                    <li>All the products from the catalog?  
                    </li>

                    <li>Or only some of the products from the catalog?  
                    </li>
                 </ul>  
            </p>
            <p class="">
              <span class="bold-black">Filter &nbsp;=&nbsp;</span> <em>Specifying what products are candidates for the Deal.</em>
            </p> 

            <p>
                Buy Group Filter &nbsp; is a <em>required field.</em>                                               
            </p>            
          </div>  <!-- //buyfilter-->  


          <!-- buyfilterany--> 
          <div class="section subsection">
            <a name="buygroup.buyfilterany" data-type="group"></a><h2>
              <a class="subsection-title-smaller" href="<?php echo esc_js('javascript:void(0);');?>">Filter by Any Product</a></h2>           
             <p>
              <strong>Any Product</strong> &nbsp;=&nbsp Buy Group is Any Product in the  <strong>Whole Store / Whole Cart</strong>.
            </p>          
          </div>  <!-- //buyfilterany--> 
          
               
          <!-- buyfiltersinglevar-->
          <div class="section subsection">
            <a name="buygroup.buyfiltersinglevar" data-type="group"></a><h2>
              <a class="subsection-title-smaller" href="<?php echo esc_js('javascript:void(0);');?>">By Category / Role / Product / Variation / Variation Name / Customer /</a></h2>          
             <p class="">
              <strong>Buy Group Selected amongs a number of Options - Include/Exclude, by Product, Category, Role, Brand...</strong>.
             
            </p>                      
          </div>  <!-- //buyfiltersinglevar-->

 
        
          <?php             
        break; 
        
       case 'buy_amt_mod':
          ?>  

          <!-- buyminmax--> 
          <div class="section subsection clickable-subsection">
            <a name="buygroup.minmax" data-type="group"></a><h2>Buy Group Min / Max</h2>  
            <p class="larger-strong">
                <strong>Set a Minimum or Maximum $$ Value Condition </strong>
            </p>
           
            <p>
                You can set a Minimum or Maximum $$ Value for the entire Buy Group, as an additional gateway value test for the Pricing Deal.                                                 
            </p>        
            <p>
               <h3 class="subtitle-h3">Options are:</h3>
               <ul class="">
                  <li>" None "
                  </li>                  
                  <li>" Minimum $$ Value "  &nbsp;+&nbsp; Value
                  </li> 
                  <li>" Maximum $$ Value "  &nbsp;+&nbsp; Value
                  </li> 
               </ul>                              

               <ol class="">
                  <li>" Buy any 5 vegetables <b>for a minimum total of $5</b>, get 20% off " </li>
                  <li>" Buy any Laptop <b>for a maximum price of $2000</b>, get 10% off " </li>          
               </ol>               
            </p>

            <p>
                Buy Group Min / Max &nbsp; is an <em>optional field,</em>&nbsp; available under <em>Advanced Rule.</em>  &nbsp;&nbsp;Default &nbsp;=&nbsp; <b>" None "</b>                                               
            </p>
          </div>  <!-- //buyminmax-->          
 
          <?php             
        break;
        
      case 'buy_repeat_condition':
          ?>  

          <!-- buyrepeat--> 
          <div class="section subsection clickable-subsection">
            <a name="buygroup.repeat" data-type="group"></a><h2>Buy Group / Rule Usage Count</h2>  
            <p class="larger-strong">
                <strong>How many times does the Buy Group get counted, and the Rule repeated?</strong>
            </p> 
            <p>
               <h3 class="subtitle-h3">Options are:</h3>
               <ul class="">
                  <li>" Apply Rule Once per Cart "
                  </li>                  
                  <li>" Unlimited Rule Usage Counts per Cart "
                  </li> 
                  <li>" Rule Usage Count Times, per Cart " &nbsp;+&nbsp; a Count
                  </li> 
               </ul>                              
            </p>           

            <p class="larger-strong">
                <strong>To Limit how many times a Customer can get a Discount,</strong>
                <br>
                <em>Go to "Customer Rule Limit" below (Advanced Rule)</em>              
            </p>                                                                             
          </div>  <!-- //buyrepeat-->          
 
          <?php             
        break;
 
         
       //v1.1.8.0 begin
      case 'pricingTable':
          ?>  

          <!-- pricingTable--> 
          <div class="section subsection clickable-subsection">
            <a name="pricingTable" data-type="group"></a><h2>Pricing Table / Bulk Discount / Pricing Tiers.</h2>  
            <p class="larger-strong">
                <strong>Discount based on Quantity Purchased - either by Unit Quantity or $$ Total</strong>

               <ol class="">
                  <li>"Count by Units or Currency" - Discount based on Unit Quantity or Dollar purchased
                  </li>                  
                  <li>"Begin / End Ranges Apply To" - Do you count the total in the group, or by Product line subtotal?
                  </li> 
                  <li>Pricing Table rows:
                      <br>&nbsp;&nbsp;Begin Quantity and End Quantity apply inclusively - 
                      <br>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;they count from and to <em>including the listed values</em>
                      <br>&nbsp;&nbsp;If you are counting by $$, be sure to include <strong>pennies (decimals)</strong> in establishing your range. 
                      <br>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;$5 - $10, $11-100, etc... 
                      <br>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Row 1:: Begin: $5  End: $10
                      <br>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Row 2:: Begin: $10.01  End: $10
                  </li> 
               </ol>                              
            </p>
                                                                                                     
          </div>  <!-- //pricingTable-->          
 
          <?php                             
        break;  
        //v1.1.8.0 end   
           
                
      case 'action_amt_type':
          ?>  
                    
          <!-- getamount-->                         
          <div class="section">
            <a name="getgroup.getamount" data-type="group"></a><h2>Get Group Amount</h2>
            <p class="larger-strong">
               <strong>How Many do we have to Get to carry on processing this Deal?</strong> 
               <ol class="">
                  <li><em>Buy xx Get </em>&nbsp; <strong>YY</strong> &nbsp;<em>a discount</em></li>                 
               </ol>                                             
            </p>
          </div>  
          
          <div class="section subsection">
            <a name="getgroup.getamounttype" data-type="group"></a><h2>
              <a class="subsection-title-smaller" href="<?php echo esc_js('javascript:void(0);');?>">Get Group Amount Type</a></h2>          
            <p>
                <strong>How is the Get (Discount) Group Counted?</strong>                                                 
            </p>            
            <p>
                 <ul class="list-more-margin">
                    <li><em>Discount Each Unit</em> 
                    <br> - Apply the Discount to <em>Each Unit</em> in the Get Group
                    </li> 

                    <li><em>Discount Next One (Single Unit)</em> 
                    <br> - Allows you to Discount the next unit
                    </li>

                    <li><em>Discount Unit Quantity</em> 
                    <br> - Discount a quantity of product units 
                    </li>  

                    <li><em>Discount $$ Value</em> 
                    <br> - Discount a $$ Value of product units
                    </li>   
                    <li><em>Discount Nth Unit</em> 
                    <br> - Discount by a repeating pattern of items, based on a count
                    </li>  
                 </ul>                                                                                                  
            </p>
            
            
            <p>
                Get Group Amount Type &nbsp; is a <em>required field.</em>                                             
            </p>            
          </div>        
          
          <div class="section subsection">
            <a name="getgroup.getamountcount" data-type="group"></a><h2>
              <a class="subsection-title-smaller" href="<?php echo esc_js('javascript:void(0);');?>">Get Group Amount Count</a></h2>          
            <p>
                <strong>The Count box contains the actual number Quantity or $$ Value</strong> we have to purchase to gain access to this Deal                                                 
            </p>
            
            
            <p>
                Get Group Amount Count &nbsp; is a <em>required field, if</em>&nbsp;  the  &nbsp; Get Group Amount Type &nbsp; needs it.                                               
            </p>             
          </div> 
          <!-- //getamount-->


          <?php             
        break;
      case 'action_amt_applies_to':
          ?>  
          
          <div class="section subsection">
            <a name="getgroup.getamountapplies" data-type="group"></a><h2>
              <a class="subsection-title-smaller" href="<?php echo esc_js('javascript:void(0);');?>">Get Group Amount Applies To</a></h2>          
            <p>
                <strong>How is the count Applied?</strong>                                                 
            </p>
            <p>
                 <ul class="list-more-margin">
                    <li><em>All Products</em> 
                    <br> - <b>All Products of the group are tallied together</b>
                    <br>&nbsp;&nbsp;For example: 2 Oranges and 3 Apples in the Get Group &nbsp;=&nbsp; <b>a single total of 5 units.</b>
                    </li>

                    <li><em>Each Product</em> 
                    <br> - <b>Each product is tallied as a separate product total</b>
                    <br>&nbsp;&nbsp;For example: 2 Oranges and 3 Apples in the Get Group &nbsp;=&nbsp; <b>separate totals of 2 and 3 units respectively</b>.
                    </li>
                 </ul>                                                                   
            </p>
 
            <p>
                Get Group Amount Applies To &nbsp; is an <em>optional field,</em>&nbsp; available under <em>Advanced Rule.</em>   &nbsp;&nbsp;Default &nbsp;=&nbsp; <b>" All Products "</b>                         
            </p>                
          </div>  <!-- //getamount-->

          <?php             
        break;
        
      case 'actionPop':
          ?>  
 
          <!-- getfilter-->           
          <div class="section">
            <a name="getgroup.getfilter" data-type="group"></a><h2>Get Group Filter</h2>
            <p class="larger-strong">
                <strong> Does the Get Group apply to:</strong>                                                              
                 <ul class="list-more-margin">
                    <li>All the products from the catalog? 
                    </li>

                    <li>Or only some of the products from the catalog?  
                    </li>
                 </ul> 
            </p>
            <p class="">
              <span class="bold-black">Filter &nbsp;=&nbsp;</span> <em>Specifying what products are candidates for the Deal.</em>
            </p>
                         
          </div>  <!-- //getfilter-->  
 

          <!-- getfiltersame--> 
          <div class="section subsection">
            <a name="getgroup.getfiltersame" data-type="group"></a><h2>
              <a class="subsection-title-smaller" href="<?php echo esc_js('javascript:void(0);');?>">Discount Group Same as Buy Group</a></h2>           
             <p>
              <strong>Get (Discount) Group is exactly the same as the Buy Group</strong>.
            </p>
             <p>
              This filter option allows you to declare the same products for the Get Group as the Buy Group.
              The group can be counted or viewed differently, to create the Deal Discount.
            </p>
             <p>
              For Example: " Buy any 2 Laptops, get the 3rd Laptop 30% off "
            </p>                                   
          </div>  <!-- //getfiltersame--> 



          <!-- getfilterany--> 
          <div class="section subsection">
            <a name="getgroup.getfilterany" data-type="group"></a><h2>
              <a class="subsection-title-smaller" href="<?php echo esc_js('javascript:void(0);');?>">Filter by Any Product</a></h2>           
             <p>
              <strong>Any Product</strong> &nbsp;=&nbsp Get Group is Any Product in the  <strong>Whole Store / Whole Cart</strong>.
            </p>          
          </div>  <!-- //getfilterany--> 


          
          <!-- getfiltercat-->  
          <div class="section subsection">
            <a name="getgroup.getfiltercat" data-type="group"></a><h2>          
             <a class="subsection-title-smaller" href="<?php echo esc_js('javascript:void(0);');?>">By Cateogry/Product/Variation/Variation Name/Brands</a></h2>
             <p class="">
              Specify which products are Get Group candidates 
              <br> - <strong>Include/Exclude By Cateogry/Product/Variation/Variation Name/Brands</strong>.

                                                                 
            </p>
                                         
          </div> <!-- //getfiltercat--> 
 
                             

          <?php             
        break;
        
     case 'action_amt_mod':
          ?>  

          <!-- getminmax--> 
          <div class="section subsection clickable-subsection">
            <a name="getgroup.minmax" data-type="group"></a><h2>Get Group Min / Max</h2>  
            <p class="larger-strong">
                <strong>Set a Minimum or Maximum $$ Value Condition </strong>
            </p>
           
            <p>
                You can set a Minimum or Maximum $$ Value for the entire Get Group, as an additional gateway value test for the Pricing Deal.                                                 
            </p>        
            <p>
               <h3 class="subtitle-h3">Options are:</h3>
               <ul class="">
                  <li>" None "
                  </li>                  
                  <li>" Minimum $$ Value "  &nbsp;+&nbsp; Value
                  </li> 
                  <li>" Maximum $$ Value "  &nbsp;+&nbsp; Value
                  </li> 
               </ul>                              

               <ol class="">
                  <li>" Buy any 5 vegetables, get the Next 5 Vegetables <em>which have a minimum total of $5</em>&nbsp;, for 20% off " </li>
                  <li>" Buy any 5 vegetables, get the Next 5 Vegetables <em>which have a maximimum total of $5</em>&nbsp;, for 20% off " </li>          
               </ol>               
            </p>
 
            <p>
                Get Group Min / Max &nbsp; is an <em>optional field,</em>&nbsp; available under <em>Advanced Rule.</em>   &nbsp;&nbsp;Default &nbsp;=&nbsp; <b>" None "</b>                        
            </p>                                                                                
          </div>  <!-- //getminmax-->          
       
          <?php             
        break; 
        
       case 'action_repeat_condition':
          ?>  
 
          <!-- getrepeat--> 
          <div class="section subsection clickable-subsection">
            <a name="getgroup.repeat" data-type="group"></a><h2>Get Group Repeat</h2>  
            <p class="larger-strong">
                <strong>How many times does the Get Group get counted, <em>once the Buy Group count has been satisfied?</em></strong>
            </p> 
            <p>
               <h3 class="subtitle-h3">Options are:</h3>
               <ul class="list-more-margin">
                  <li><b>" None "</b>
                      <br> - So no repeats, the Discount Group is counted only <b>once</b>.  Default value.
                  </li>                  
                  <li><b>" Unlimited Discount Group Repeats"</b>
                      <br> - Example: " Buy a Laptop, <em>get any other purchases 10% off</em> &nbsp;"
                  </li> 
                  <li><b>" Discount Group Repeat Count " &nbsp;+&nbsp; a Count</b>
                      <br> - Example: " Buy a Laptop, <em>get the next 3 purchases 10% off</em> &nbsp;"
                  </li> 
               </ul>                              
            </p>           
 
            <p>
                Get Group Repeat &nbsp; is an <em>optional field,</em>&nbsp; available under <em>Advanced Rule.</em> &nbsp;&nbsp;Default &nbsp;=&nbsp; <b>" None "</b> 
                <br>&nbsp;&nbsp;&nbsp;(no Repeats, Discount Group counted once)                       
            </p>                                                                                           
          </div>   <!-- //getrepeat-->          

          <?php             
        break;
        
      case 'discount_amt_type':
          ?>  

          <!-- discountamount-->                         
          <div class="section">
            <a name="discount.discountamount" data-type="group"></a><h2>Discount Amount</h2>
            <p class="larger-strong">
               <strong>What $ Value Discount are we Offering?</strong>                                             
            </p>
          </div>  
          
          <div class="section subsection">
            <a name="discount.discountamounttype" data-type="group"></a><h2>
              <a class="subsection-title-smaller" href="<?php echo esc_js('javascript:void(0);');?>">Discount Amount Type</a></h2>          
            <p>
                <strong>How is the Discount Counted?</strong>                                                 
            </p>            
            <p>
                 <ul class="list-more-margin">
                    <li><b>% Off</b> 
                    <br> - Apply a percentage off of each product unit or group, to obtain the Discount
                    </li> 

                    <li><b>$ Off</b> 
                    <br> - Subtract a Currency amount from the cost of each product unit or group, to obtain the Discount 
                    </li>

                    <li><b>Fixed Unit Price</b> 
                    <br> - Offer a product unit or group at a fixed $ cost.
                    <br> - The Discount is the difference between the original price and the new price.  
                    </li>  

                    <li><b>Free</b> 
                    <br> - Discount is the entire product unit or group price.
                    <br> - (see below for free auto-add) 
                    </li> 
                     
                    <li><b>Package Price</b> 
                    <br> - Offer a Product Package for a fixed price, <em>"X Units for the Price of $$"</em>
                    <br> - The Discount is the difference between the original price and the new price.                    
                    <br> - (see below for details) 
                    </li>
                     
                    <li><b>Package Price by Unit Count Pricing</b> 
                    <br> - Offer a Product Package for a computed price, <em>"X Units for the Price of Y Units"</em>
                    <br> - The Discount is the difference between the original price and the new price.
                    <br> - (see below for details)
                    </li>
                 
                 </ul>                                                                                                  
            </p>
            
        
            <p>
                Discount Amount Type &nbsp; is a <em>required field.</em>                             
            </p>
            
          </div>        
          
          <div class="section subsection">
            <a name="discount.discountamountcount" data-type="group"></a><h2>
              <a class="subsection-title-smaller" href="<?php echo esc_js('javascript:void(0);');?>">Discount Amount Count</a></h2>          
            <p>
                <strong>The Count box contains the actual number Quantity or $$ Value</strong> we have to purchase to gain access to this Deal                                                                 
            </p>
            
        
            <p>
                Discount Amount Count &nbsp; is a <em>required field, if</em>&nbsp; the  &nbsp; Discount Amount Type &nbsp; needs it.                                               
            </p>
             
          </div> 

          <!-- //discountamount-->    
       
       
          <!-- //discount--> 
 
          <?php             
        break;
        
      case 'discount_free':
          ?>  
                                         
          <!-- discountfree-->        
          <div class="section subsection clickable-subsection">
            <a  name="discount.discountfree" data-type="group"></a><h2>Free, with Auto Add</h2>
             <p class="larger-strong">
                <strong>Discount Amount Type - &nbsp;Free&nbsp; -</strong>  a Free Product can be Added Automatically to Cart                                                
            </p>
            <p>
              You can instruct the rule to Add a Free product to the cart automatically, when Discount Type = "Free". 
            </p>             

           <p>
                <b>Note:</b>&nbsp; <b>Auto Add</b> of free products is <em>only</em>&nbsp; <b>available when the Discount Group is a single, unique product</b>
                <br> - (otherwise auto add wouldn't know what to add!)
            </p>
          </div>  <!-- //discountfree--> 


          <?php             
        break;
                
      case 'discount_applies_to':
          ?>  
          <!-- discountappliesto-->                         
          <div class="section">
            <a name="discount.discountappliesto" data-type="group"></a><h2>Discount Applies To</h2>       
            <p>
                <strong>How is the count Applied?</strong>                                                 
            </p>
            <p>
                 <ul class="list-more-margin">
                    <li><em>All Products</em> 
                    <br> - <b>All Products are tallied as a unified group</b>
                    <br>&nbsp;&nbsp;For example: 2 Oranges and 3 Apples in the Discount Group &nbsp;=&nbsp; <b>a single total of 5 units.</b>
                    </li>

                    <li><em>Each Product</em> 
                    <br> - <b>Each product is tallied as a separate product total</b>
                    <br>&nbsp;&nbsp;For example: 2 Oranges and 3 Apples in the Discount Group &nbsp;=&nbsp; <b>separate totals of 2 and 3 units respectively</b>.
                    </li>
                 </ul>                                                                   
            </p>

            
            <p>
                Discount Applies To &nbsp; is an <em>optional field,</em>&nbsp; available under <em>Advanced Rule.</em>   &nbsp;&nbsp;Default &nbsp;=&nbsp; <b>" Each Product "</b>,     
                <br>- but switches automatically to " All Products " for package deals.
            </p>            
          </div>
          <?php             
        break;
        
      case 'discount_product_short_msg':
          ?>  
        
          <div class="section">
            <a name="messages.checkout" data-type="group"></a><h2>Checkout Message</h2>
            <p>
                 The short <strong>checkout message</strong> <em>summarizes your deal,</em>&nbsp; and is used both in the mini-cart and at checkout 
                 <br>for cart purchases <em>only.</em>                                              
            </p>
             <p>
                 Checkout Message shows by default for purchases with a Cart Purchase rule.                                                
            </p>
             <p>
                 <b>Checkout Message display for Cart Purchases</b> <em>can be shut off,</em>&nbsp; in both the mini-cart and the checkout,  
                <br>using settings available <em>on the Settings Screen.</em>                                                
            </p>
             <p>
                 <b>Checkout Message is <em>never</em>&nbsp; displayed for Catalag Purchases.</b> <em>A default value of "Unused for Catalog Discount"</em>
                 is automatically inserted into Checkout Message, as a placeholder, for Catalag Purchase Rules.                                                
            </p>                             
            <p>
                Checkout Message &nbsp; is a <em>required field.</em>                                              
            </p>
                        
          </div> 
     
          <?php             
        break;
        
      case 'discount_product_full_msg':
          $url = esc_url("http://www.varktech.com/documentation/pricing-deals/shortcodes");
          ?>  
      
          <div class="section">
            <a name="messages.marketing" data-type="group"></a><h2> Advertising Message</h2>
            <p>
                 The  <strong>Advertising Message</strong> is the place for you to put in your full <b>Deal marketing message</b>.                                              
            </p>
           <p>
                 The <b> Advertising Messages</b> from all your active Pricing Deals
                 <br><b>can be shown in your Website using <em>Shortcodes</em></b> (see below).                         
            </p> 
           <p class="larger-strong">
                 These 
                 <a class="commentURL" target="_blank" href="<?php echo esc_url($url);?>"><?php esc_attr_e('Shortcodes', 'vtprd');?></a> 
                 can be placed all through your theme and site,
                 <br><strong>to take advantage of the Marketing Power your deals will bring.</strong>                                              
            </p>

            <p>
                Advertising Message &nbsp; is an <em>optional field,</em>&nbsp; available under <em>both the Basic and Advanced rule screen modes</em> 
            </p>            
                                                               
          </div>                 
          
          <?php             
        break;
        
      case 'discount_lifetime_max_amt_type':
          ?>  
       
          <div class="section">
            <a name="limits.percustomer" data-type="group"></a><h2>Customer Rule Limit</h2>
            <p class="larger-strong">
                 <strong>Controls the Number of times a customer can use a Discount. &nbsp;&nbsp;Ever.</strong>                                              
            </p>
            <p>
                 <h3 class="subtitle-h3">Customer Lifetime Limit Controls: </h3>
                 <ul class="">
                    <li><em>The Number of times a customer can use a Discount.</em> &nbsp;&nbsp;<strong>Ever.</strong></li>

                    <li><em>The $$ value total a customer can receive from a Discount.</em> &nbsp;&nbsp;<strong>Ever.</strong></li>
                 </ul>                                            
            </p>
            

           <p>
                 <h3 class="subtitle-h3">Customer Rule Limits Are: </h3>
                 <ul class="list-more-margin">
                    <li><b>None</b> 
                        <br> - Each customer has unlimited access to this Deal. 
                    </li>
                    <li><b>How many times can the Customer use this Discount?</b> 
                        <br> - Customer limit by: the Number of Times the Customer has received this Discount. 
                    </li>
                    <li><b>How much $$ value can the Customer receive from this Discount?</b> 
                        <br> - Customer limit by: the $$ Value Total that the Customer has received from this Discount 
                    </li>                    
                 </ul>                                            
            </p>
            <p>
                 If the Customer Rule Limit for this Discount has been reached,
                 <br><b><em>the Discount will be reduced until the Customer Lifetime Limit has been satisfied.</em></b>                                            
            </p>
                         
            <p>
                Customer Lifetime Limit &nbsp; is an <em>optional field,</em>&nbsp; available under <em>Advanced Rule.</em>   &nbsp;&nbsp;Default &nbsp;=&nbsp; <b>" None "</b>     
            </p>            
                                   
          </div> 
          <div class="section subsection">
            <a name="discount.percustomercount" data-type="group"></a><h2>
              <a class="subsection-title-smaller" href="<?php echo esc_js('javascript:void(0);');?>">Per Customer  Usage Limit Count</a></h2>          
            <p>
                <strong>The Count box contains the actual number Quantity or $$ Value</strong> applied to this Limit                                                                 
            </p> 
          </div>
                   
          <?php             
        break; 
        
      case 'discount_rule_max_amt_type':
          ?>  
        
          <div class="section">
            <a name="limits.percart" data-type="group"></a><h2>Cart Limit</h2>
            <p class="larger-strong">
                 <strong>Controls the Number of times a Cart can use a Discount..</strong>                                              
            </p>
           <p>
                 <h3 class="subtitle-h3">Per Cart Limit Controls: </h3>
                 <ul class="">
                    <li><em>The percentage value a Cart can use a Discount.</em> </strong></li>
                    <li><em>The Number of times a Cart can use a Discount.</em> </strong></li>
                    <li><em>The $$ value total a Cart can receive from a Discount.</em></li>
                 </ul>                                            
            </p>
           <p>
                 <h3 class="subtitle-h3">Per Cart Limits Are: </h3>
                 <ul class="list-more-margin">
                    <li><b>None</b> 
                        <br> - No Cart Limit. 
                    </li>
                    <li><b>Cart Discount Max - Percentage of Total Value</b> 
                        <br> - Cart limit by: percentage value the Cart has received for this Discount. 
                    </li>
                    <li><b>Cart Discount Max - Number of Times Used</b> 
                        <br> - Cart limit by: the Number of Times  the Cart has received this Discount. 
                    </li>
                    <li><b>Cart Discount Max - $$ Value</b> 
                        <br> - Cart limit by: the $$ Value Total  the Cart  has received from this Discount. 
                    </li>                    
                 </ul>                                            
            </p>

           <br> 
            <p>
                Cart Limit &nbsp; is an <em>optional field,</em>&nbsp; available under <em>Advanced Rule.</em>   &nbsp;&nbsp;Default &nbsp;=&nbsp; <b>" None "</b>     
            </p>            
             
          </div> 
          
          <div class="section subsection">
            <a name="limits.percartcount" data-type="group"></a><h2>
              <a class="subsection-title-smaller" href="<?php echo esc_js('javascript:void(0);');?>">Per Cart Usage Limit Count</a></h2>          
            <p>
                <strong>The Count box contains the actual number Quantity or $$ Value</strong> applied to this Limit                                                                 
            </p> 
          </div>                    

          <?php             
        break;
        
        
      case 'discount_rule_cum_max_amt_type':
          ?>  
      
          <div class="section">
            <a name="limits.perproduct" data-type="group"></a><h2>Product Limit</h2>
            <p class="larger-strong">
                 <strong>Controls the Number of times a Product can use a Discount.</strong>                                              
            </p>
           <p>
                 <h3 class="subtitle-h3">Per Product Limit Controls: </h3>
                 <ul class="">
                    <li><em>The percentage value a customer can use a Discount in the product.</em> </strong></li>
                    <li><em>The Number of times a customer can use a Discount in the product.</em> </strong></li>
                    <li><em>The $$ value total a customer can receive from a Discount in the product.</em></li>
                 </ul>                                            
            </p>
           <p>
                 <h3 class="subtitle-h3">Per Product Limits Are: </h3>
                 <ul class="list-more-margin">
                    <li><b>None</b> 
                        <br> - No Product Limit. 
                    </li>
                    <li><b>Product Discount Max - Percentage of Total Value</b> 
                        <br> - Product limit by: percentage value in the product has received for this Discount in the Cart. 
                    </li>
                    <li><b>Product Discount Max - Number of Times Used</b> 
                        <br> - Product limit by: the Number of Times in the product has received this Discount in the Cart. 
                    </li>
                    <li><b>Product Discount Max - $$ Value</b> 
                        <br> - Product limit by: the $$ Value Total in the product has received from this Discount in the Cart 
                    </li>                    
                 </ul>                                            
            </p>

            <p>
                Product Limit &nbsp; is an <em>optional field,</em>&nbsp; available under <em>Advanced Rule.</em>   &nbsp;&nbsp;Default &nbsp;=&nbsp; <b>" None "</b>     
            </p>            
                                                              
          </div> 
          
          <div class="section subsection">
            <a name="limits.perproductcount" data-type="group"></a><h2>
              <a class="subsection-title-smaller" href="<?php echo esc_js('javascript:void(0);');?>">Per Product Limit Count</a></h2>          
            <p>
                <strong>The Count box contains the actual number Quantity or $$ Value</strong> applied to this Limit                                                                 
            </p> 
          </div>
          <?php             
        break;
        
      //v1.1.0.8 new entry  
      case 'only_for_this_coupon_name':
          ?>  
      
          <div class="section">
            <a name="only.coupon" data-type="group"></a><h2>Discount only when This Coupon Code is Presented</h2>
            <p class="larger-strong">
                 <strong>When a coupon code is entered in the rule, <br> - the rule discount will not activate in the Cart <br> - until the coupon code is redeemed in the cart.</strong>                                              
            </p>
           <p>
                 <h3 class="subtitle-h3">Coupon Setup: </h3>
                 <ol class="">
                    <li><em>Go to Woocommerce/Coupons</em> </strong></li>
                    <li><em>Click on Add Coupon at top of screen.</em> </strong></li>
                    <li><em>Enter the Coupon Title (this will be your Coupon Code!!).</em></li>
                    <li><em>'Discount Type' = Cart Discount.</em></li>
                    <li><em>'Coupon Amount' = 0.</em></li>
                    <li><em>Enter what other criteria you desire</em></li>
                    <li><em>Publish</em></li>
                 </ol>                                            
            </p>


            <p>
                Discount Coupon Code &nbsp; is an <em>optional field,</em>&nbsp; available under <em>Advanced Rule.</em>   &nbsp;&nbsp;Default &nbsp;=&nbsp; <b>"[blank]"</b>     
            </p>            
                                                              
          </div> 
          
          <?php             
        break;
        
               
        
      case 'cumulativeRulePricing':
          ?>  
          
          <div class="section">
            <a name="workingwith.otherrules" data-type="group"></a><h2>Working with Other Rule Discounts</h2>
            <p>
                <strong>Does this rule work with other Rule Discounts?</strong>                                              

                 <ul class="list-more-margin">
                    <li><b>Yes</b> 
                        <br> - This discount will apply <em>in addition to</em>&nbsp; any other Rule Discounts. 
                    </li>
                    <li><b>No</b> 
                        <br> - If nother Rule Discount is present, <em>this discount will not be applied.</em> 
                    </li>
                   
                 </ul>                                            
            </p>           
            
            <p>
                If "Yes", set a sort priority to establish which Rule Goes first. Default sort priority is "10".                                                
            </p>

            <p>
                Working with Other Rule Discounts &nbsp; is an <em>optional field,</em>&nbsp; available under <em>Advanced Rule.</em>   &nbsp;&nbsp;Default &nbsp;=&nbsp; <b>" Yes "</b>     
            </p>            
                                    
          </div>  
    
          <?php             
        break;
        
      case 'cumulativeCouponPricing':
          ?>  

          <div class="section">
            <a name="workingwith.coupons" data-type="group"></a><h2>Working with Coupons</h2>
            <p>
                <strong>Does this rule work with other Coupons?</strong>                                             

                 <ul class="list-more-margin">
                    <li><b>Yes</b> 
                        <br> - This discount will apply <em>in addition to</em>&nbsp; any Coupon Discount. 
                    </li>
                    <li><b>No</b> 
                        <br> - If a Coupon is presented, <em>this discount will not be applied.</em> 
                    </li>
                   
                 </ul>                                            
            </p>            
  
            <p>
                Working with Coupons &nbsp; is an <em>optional field,</em>&nbsp; available under <em>Advanced Rule.</em>   &nbsp;&nbsp;Default &nbsp;=&nbsp; <b>" Yes "</b>     
            </p>            
                                               
          </div>  
         
          <?php             
        break;
        
      case 'cumulativeSalePricing':
          ?>  
        
          <div class="section">
            <a name="workingwith.saleprice" data-type="group"></a><h2>Working with Product Sale Pricing</h2>
            <p>
                <strong>Is the Product already on Sale?  &nbsp;Working with Product Sale Pricing is a bit more involved.</strong>                                              
            </p>


            <p>
                 <h3 class="subtitle-h3">There are three options: </h3>
                 <ul class="list-more-margin">
                    <li><b> No</b> - if product already on Sale, no further discount  
                    </li>
                    <li><b>Apply Deal Discount to Product Sale Price</b>  
                    </li>
                    <li><b>Apply Discount to Regular Price, if Less than Sale Price</b> 
                        <br> - So apply the Deal discount to the Regular price, and compare the savings with those from the sale price. 
                        <br> - If the Deal Discount with the Regular Price gives a greater discount, apply the Discount.
                        <br> - Otherwise, let the Product Sale Price stand.                   
                 </ul>                                            
            </p>

            <p>
                Working with Product Sale Pricing &nbsp; is an <em>optional field,</em>&nbsp; available under <em>Advanced Rule.</em>   &nbsp;&nbsp;Default &nbsp;=&nbsp; <b>" No "</b>     
            </p>            
                                      
          </div>  
          <?php             
        break;
        
      case '':
          ?>  

          <?php             
        break;
   
    } //end switch           
  } //end function
            
  //v2.0.0 New Function
  function vtprd_show_and_or_each_message($type,$selector) {
      
      $message = null;
      switch($type) { 
        case 'or':
            $message .= '<h2>"OR"  = <br>ANY ' .$selector. '<br>from the include list <br>can select a product for the deal</h2>';
          break;  
        case 'and':
            $message .= '<h2>"AND"  = <br>ONE ' .$selector. '<br>from the include list <br>is REQUIRED  to select a product for the deal</h2>';        
          break;
        case 'each':
            $message .= '<h2>';
            $message .= '"EACH"  =  "AND EACH" <br><br>"Buy 1 from  ' .$selector. ' X<br>&nbsp;&nbsp;&nbsp;&nbsp;AND<br>&nbsp;&nbsp;Buy 1 from  ' .$selector. ' Y, <br>&nbsp;&nbsp;&nbsp;&nbsp;get a discount..."';                                
            
            $message .= '<br><br>&nbsp;&nbsp;&nbsp; "AND" part  = <br>ONE ' .$selector. '<br>from the include list <br>is REQUIRED  to select a product for the deal';  
            $message .= '<br><br>&nbsp;&nbsp;&nbsp; "EACH" part  = <br>ONE of EACH ' .$selector. '<br>from the include list <br>is REQUIRED  <br>to be IN THE CART <br>to "activate" the deal</h2>';
            
            $message .= '</h2>';

            //$message .= '<h2>"EACH"  =  "AND EACH" <br><br>"Buy 1 from  ' .$selector. ' X<br>&nbsp;&nbsp;&nbsp;&nbsp;AND<br>&nbsp;&nbsp;Buy 1 from  ' .$selector. ' Y, <br>&nbsp;&nbsp;&nbsp;&nbsp;get a discount..." <br><br>One from EACH<br>&nbsp;&nbsp;&nbsp;&nbsp;Category listed<br>must be in the Cart<br>to "activate" the deal</h2>';                                

          break;                  
      }
      if ($message) {
         $allowed_html = vtprd_get_allowed_html(); //v2.0.3
         echo wp_kses($message ,$allowed_html ); //v2.0.3
      }
  }  
