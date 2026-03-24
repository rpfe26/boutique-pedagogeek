<?php

/**
 * Provide a admin area view for the plugin
 *
 * This file is used to markup the admin-facing aspects of the plugin.
 *
 * @link       https://coderockz.com
 * @since      1.0.0
 *
 * @package    Coderockz_Woo_Delivery
 * @subpackage Coderockz_Woo_Delivery/admin/partials
 */

$date_settings = get_option('coderockz_woo_delivery_date_settings');
$time_settings = get_option('coderockz_woo_delivery_time_settings');
if(isset($date_settings['delivery_days'])) {
	$selected_delivery_day = explode(',', get_option('coderockz_woo_delivery_date_settings')['delivery_days']);
} else {
	$selected_delivery_day = array();
}

$pickup_date_settings = get_option('coderockz_woo_delivery_pickup_date_settings');
if($pickup_date_settings != false && isset($pickup_date_settings['pickup_days']) && $pickup_date_settings['pickup_days'] != "" ) {
	$selected_pickup_day = explode(',', $pickup_date_settings['pickup_days']);
} else {
	$selected_pickup_day = [];
}

$delivery_option_settings = get_option('coderockz_woo_delivery_option_delivery_settings');
$pickup_time_settings = get_option('coderockz_woo_delivery_pickup_settings');
$other_settings = get_option('coderockz_woo_delivery_other_settings');
$localization_settings = get_option('coderockz_woo_delivery_localization_settings');

$currency_code = get_woocommerce_currency();
$store_location_timezone = isset($time_settings['store_location_timezone']) && $time_settings['store_location_timezone'] != ""? $time_settings['store_location_timezone'] : "";

?>
<div class="coderockz-woo-delivery-wrap">

<div class="coderockz-woo-delivery-container">
	<div class="coderockz-woo-delivery-container-header">
		<img style="max-width: 75px;float: left;display: block;padding-bottom: 2px;" src="<?php echo CODEROCKZ_WOO_DELIVERY_URL; ?>admin/images/woo-delivery-logo.png" alt="coderockz-woo-delivery">
		<div style="float:left;margin-left:15px;">
		<p style="margin: 0!important;text-transform:uppercase;border-bottom:2px solid #1F9E60;padding-bottom:3px;font-size: 20px;font-weight: 700;color: #654C29;">WooCommerce</p>
		<p style="margin: 0!important;text-transform:uppercase;padding-top:3px;font-size: 11px;color: #654C29;font-weight: 600;">Delivery & Pickup Date Time</p>
		</div>
		
		<!-- <a style="float: right;margin-top: 10px;" href="https://coderockz.com/woo-delivery/its-my-life/" target="_blank" class="coderockz-woo-delivery-buy-now-btn">Live Demo</a> -->
		<a style="float: right;margin-top: 10px;margin-right:10px;" href="https://coderockz.com/downloads/woocommerce-delivery-date-time-wordpress-plugin/" target="_blank" class="coderockz-woo-delivery-buy-now-btn">Get Pro</a>
	</div>
	<div class="coderockz-woo-delivery-free-vertical-tabs">
		<div class="coderockz-woo-delivery-free-tabs">
			<button data-tab="tab2"><i class="dashicons dashicons-plugins-checked" style="margin-bottom: 3px;margin-right: 10px;"></i><?php _e('Order Settings', 'woo-delivery'); ?></button>
			<button data-tab="tab3"><i class="dashicons dashicons-calendar-alt" style="margin-bottom: 3px;margin-right: 10px;"></i><?php _e('Delivery Date', 'woo-delivery'); ?></button>
			<button data-tab="tab4"><i class="dashicons dashicons-calendar" style="margin-bottom: 3px;margin-right: 10px;"></i><?php _e('Pickup Date', 'woo-delivery'); ?></button>
			<button data-tab="tab5"><i class="dashicons dashicons-hidden" style="margin-bottom: 3px;margin-right: 10px;"></i><?php _e('Off Days', 'woo-delivery'); ?></button>
			<button data-tab="tab6"><i class="dashicons dashicons-clock" style="margin-bottom: 3px;margin-right: 10px;"></i><?php _e('Delivery Time', 'woo-delivery'); ?></button>
			<button data-tab="tab7"><i class="dashicons dashicons-cart" style="margin-bottom: 3px;margin-right: 10px;"></i><?php _e('Pickup Time', 'woo-delivery'); ?></button>
			<button data-tab="tab8"><i class="dashicons dashicons-translation" style="margin-bottom: 3px;margin-right: 10px;"></i><?php _e('Localization', 'woo-delivery'); ?></button>
			<button data-tab="tab9"><i class="dashicons dashicons-admin-settings" style="margin-bottom: 3px;margin-right: 10px;"></i><?php _e('Others', 'woo-delivery'); ?></button>
			<button data-tab="tab10"><i class="dashicons dashicons-clipboard" style="margin-bottom: 3px;margin-right: 10px;"></i><?php _e('Free VS Pro', 'woo-delivery'); ?></button>
		</div>
		<div class="coderockz-woo-delivery-maincontent">
			<div data-tab="tab2" class="coderockz-woo-delivery-tabcontent">
				<div class="coderockz-woo-delivery-card">
					<p class="coderockz-woo-delivery-card-header"><?php _e('Order Type Settings', 'woo-delivery'); ?></p>
					<div class="coderockz-woo-delivery-card-body">
						<p class="coderockz-woo-delivery-delivery-option-notice"><span class="dashicons dashicons-yes"></span><?php _e(' Settings Changed Successfully', 'woo-delivery'); ?></p>
	                    <form action="" method="post" id ="coderockz_delivery_delivery_option_form_submit">
	                        <?php wp_nonce_field('coderockz_woo_delivery_nonce'); ?>

	                        <div class="coderockz-woo-delivery-form-group">
	                        	<span class="coderockz-woo-delivery-form-label" style="width:426px!important"><?php _e('Give Option to choose from Delivery or Pickup', 'woo-delivery'); ?></span>
	                        	<p class="coderockz-woo-delivery-tooltip" tooltip="Enable it if you want to give the freedom to customer whether he wants Home delivery or he picks the ordered products from a pickup location. Default is disable."><span class="dashicons dashicons-editor-help"></span></p>
							    <label class="coderockz-woo-delivery-toogle-switch" for="coderockz_enable_option_time_pickup">
							       <input type="checkbox" name="coderockz_enable_option_time_pickup" id="coderockz_enable_option_time_pickup" <?php echo (isset($delivery_option_settings['enable_option_time_pickup']) && !empty($delivery_option_settings['enable_option_time_pickup'])) ? "checked" : "" ?>/>
							       <div class="coderockz-woo-delivery-toogle-slider coderockz-woo-delivery-toogle-round"></div>
							    </label>
	                    	</div>
	                    	<div class="coderockz-woo-delivery-form-group">
	                    		<label class="coderockz-woo-delivery-form-label" for="coderockz_woo_delivery_delivery_option_label"><?php _e('Order Type Field Label', 'woo-delivery'); ?></label>
	                    		<p class="coderockz-woo-delivery-tooltip" tooltip="Order Type field label. Default is Order Type."><span class="dashicons dashicons-editor-help"></span></p>
	                        	<input id="coderockz_woo_delivery_delivery_option_label" name="coderockz_woo_delivery_delivery_option_label" type="text" class="coderockz-woo-delivery-input-field" value="<?php echo (isset($delivery_option_settings['delivery_option_label']) && !empty($delivery_option_settings['delivery_option_label'])) ? stripslashes($delivery_option_settings['delivery_option_label']) : "" ?>" placeholder="" autocomplete="off"/>
	                    	</div>
	                    	<div class="coderockz-woo-delivery-form-group">
	                    		<label class="coderockz-woo-delivery-form-label" for="coderockz_woo_delivery_option_delivery_label"><?php _e('Delivery Option Label', 'woo-delivery'); ?></label>
	                    		<p class="coderockz-woo-delivery-tooltip" tooltip="Order Type's Home Delivery option label. Default is Delivery."><span class="dashicons dashicons-editor-help"></span></p>
	                        	<input id="coderockz_woo_delivery_option_delivery_label" name="coderockz_woo_delivery_option_delivery_label" type="text" class="coderockz-woo-delivery-input-field" value="<?php echo (isset($delivery_option_settings['delivery_label']) && !empty($delivery_option_settings['delivery_label'])) ? stripslashes($delivery_option_settings['delivery_label']) : "" ?>" placeholder="" autocomplete="off"/>
	                    	</div>

	                    	<div class="coderockz-woo-delivery-form-group">
	                    		<label class="coderockz-woo-delivery-form-label" for="coderockz_woo_delivery_option_pickup_label"><?php _e('Self Pickup Option Label', 'woo-delivery'); ?></label>
	                    		<p class="coderockz-woo-delivery-tooltip" tooltip="Order Type's Self Pickup option label. Default is Pickup."><span class="dashicons dashicons-editor-help"></span></p>
	                        	<input id="coderockz_woo_delivery_option_pickup_label" name="coderockz_woo_delivery_option_pickup_label" type="text" class="coderockz-woo-delivery-input-field" value="<?php echo (isset($delivery_option_settings['pickup_label']) && !empty($delivery_option_settings['pickup_label'])) ? stripslashes($delivery_option_settings['pickup_label']) : "" ?>" placeholder="" autocomplete="off"/>
	                    	</div>
	                    	<div class="coderockz-woo-delivery-form-group">
	                        	<span class="coderockz-woo-delivery-form-label" style="width:30%!important;"><?php _e('Dynamically Enable/Disable Delivery/Pickup Based on WooCommerce Shipping', 'woo-delivery'); ?><span style="font-size: 11px;font-style: italic;color: lightseagreen;display:block;">( <?php _e('To know more about the feature: ', 'coderockz-woo-delivery'); ?><a href="https://coderockz.com/documentations/dynamically-enable-disable-delivery-pickup-based-on-woocommerce-shipping/" target="_blank">Click here</a> )</span></span>
	                        	<p class="coderockz-woo-delivery-tooltip" tooltip="Enable it if you want to see the delivery or pickup option based on your WoCommerce Shipping. Default is disable."><span class="dashicons dashicons-editor-help"></span></p>
							    <label class="coderockz-woo-delivery-toogle-switch" for="coderockz_woo_delivery_enable_dynamic_order_type">
							       <input type="checkbox" name="coderockz_woo_delivery_enable_dynamic_order_type" id="coderockz_woo_delivery_enable_dynamic_order_type" class="coderockz_woo_delivery_enable_dynamic_order_type"/>
							       <div class="coderockz-woo-delivery-toogle-slider coderockz-woo-delivery-toogle-round"></div>
							    </label>
	                    	</div>

	                        <input class="coderockz-woo-delivery-submit-btn" type="submit" name="coderockz_delivery_delivery_option_form_submit" value="<?php _e('Save Changes', 'woo-delivery'); ?>" />

	                    </form>
                	</div>

                </div>

			</div>

			<div data-tab="tab3" class="coderockz-woo-delivery-tabcontent">
				
				<div class="coderockz-woo-delivery-card">
					<p class="coderockz-woo-delivery-card-header"><?php _e('General Delivery Date Settings', 'woo-delivery'); ?></p>
					<div class="coderockz-woo-delivery-card-body">
						<p class="coderockz-woo-delivery-date-tab-notice"><span class="dashicons dashicons-yes"></span><?php _e(' Settings Changed Successfully', 'woo-delivery'); ?></p>
	                    <form action="" method="post" id ="coderockz_delivery_date_form_submit">
	                        <?php wp_nonce_field('coderockz_woo_delivery_nonce'); ?>

	                    	<div class="coderockz-woo-delivery-form-group">
	                        	<span class="coderockz-woo-delivery-form-label"><?php _e('Enable Delivery Date', 'woo-delivery'); ?></span>
	                        	<p class="coderockz-woo-delivery-tooltip" tooltip="Enable Delivery Date input field in woocommerce order checkout page."><span class="dashicons dashicons-editor-help"></span></p>
							    <label class="coderockz-woo-delivery-toogle-switch" for="coderockz_enable_delivery_date">
							       <input type="checkbox" name="coderockz_enable_delivery_date" id="coderockz_enable_delivery_date" <?php echo (isset($date_settings['enable_delivery_date']) && !empty($date_settings['enable_delivery_date'])) ? "checked" : "" ?>/>
							       <div class="coderockz-woo-delivery-toogle-slider coderockz-woo-delivery-toogle-round"></div>
							    </label>
	                    	</div>
	                    	<div class="coderockz-woo-delivery-form-group">
	                        	<span class="coderockz-woo-delivery-form-label"><?php _e('Make Delivery Date Field Mandatory', 'woo-delivery'); ?></span>
	                        	<p class="coderockz-woo-delivery-tooltip" tooltip="Make Delivery Date input field mandatory in woocommerce order checkout page. Default is optional."><span class="dashicons dashicons-editor-help"></span></p>
							    <label class="coderockz-woo-delivery-toogle-switch" for="coderockz_delivery_date_mandatory">
							       <input type="checkbox" name="coderockz_delivery_date_mandatory" id="coderockz_delivery_date_mandatory" <?php echo (isset($date_settings['delivery_date_mandatory']) && !empty($date_settings['delivery_date_mandatory'])) ? "checked" : "" ?>/>
							       <div class="coderockz-woo-delivery-toogle-slider coderockz-woo-delivery-toogle-round"></div>
							    </label>
	                    	</div>
	                    	<div class="coderockz-woo-delivery-form-group">
	                    		<label class="coderockz-woo-delivery-form-label" for="coderockz_delivery_date_field_label"><?php _e('Delivery Date Field Label', 'woo-delivery'); ?></label>
	                    		<p class="coderockz-woo-delivery-tooltip" tooltip="Delivery Date input field label and placeholder. Default is Delivery Date."><span class="dashicons dashicons-editor-help"></span></p>
	                        	<input id="coderockz_delivery_date_field_label" name="coderockz_delivery_date_field_label" type="text" class="coderockz-woo-delivery-input-field" value="<?php echo (isset($date_settings['field_label']) && !empty($date_settings['field_label'])) ? esc_attr($date_settings['field_label']) : "" ?>" placeholder="" autocomplete="off"/>
	                    	</div>

	                    	<div class="coderockz-woo-delivery-form-group">
	                    		<label class="coderockz-woo-delivery-form-label" for="coderockz_delivery_date_selectable_date"><?php _e('Allow Delivery in Next Available Days', 'woo-delivery'); ?></label>
	                    		<p class="coderockz-woo-delivery-tooltip" tooltip="User can only select the number of date from calander that is specified Here. Other dates are disabled. Only numerical value is excepted. Default is 365 days."><span class="dashicons dashicons-editor-help"></span></p>
	                        	<input onkeyup="if(!Number.isInteger(Number(this.value)) || this.value < 1) this.value = null;" id="coderockz_delivery_date_selectable_date" name="coderockz_delivery_date_selectable_date" type="number" class="coderockz-woo-delivery-number-field" value="<?php echo (isset($date_settings['selectable_date']) && !empty($date_settings['selectable_date'])) ? stripslashes(esc_attr($date_settings['selectable_date'])) : ""; ?>" placeholder="" autocomplete="off"/>
	                    	</div>

	                    	<div class="coderockz-woo-delivery-form-group">
	                    		<label class="coderockz-woo-delivery-form-label" for="coderockz_delivery_date_week_starts_from"><?php _e('Week Starts From', 'woo-delivery'); ?></label>
	                    		<p class="coderockz-woo-delivery-tooltip" tooltip="Delivery Date's calendar will start from the day that is selected Here. Default is Sunday."><span class="dashicons dashicons-editor-help"></span></p>
	                    		<select class="coderockz-woo-delivery-select-field" name="coderockz_delivery_date_week_starts_from">
	                    			<option value="" <?php if(isset($date_settings['week_starts_from']) && $date_settings['week_starts_from'] == ""){ echo "selected"; } ?>><?php _e('Select Day', 'woo-delivery'); ?></option>
									<option value="0" <?php if(isset($date_settings['week_starts_from']) && $date_settings['week_starts_from'] == "0"){ echo "selected"; } ?>>Sunday</option>
									<option value="1" <?php if(isset($date_settings['week_starts_from']) && $date_settings['week_starts_from'] == "1"){ echo "selected"; } ?>>Monday</option>
									<option value="2" <?php if(isset($date_settings['week_starts_from']) && $date_settings['week_starts_from'] == "2"){ echo "selected"; } ?>>Tuesday</option>
									<option value="3" <?php if(isset($date_settings['week_starts_from']) && $date_settings['week_starts_from'] == "3"){ echo "selected"; } ?>>Wednesday</option>
									<option value="4" <?php if(isset($date_settings['week_starts_from']) && $date_settings['week_starts_from'] == "4"){ echo "selected"; } ?>>Thursday</option>
									<option value="5" <?php if(isset($date_settings['week_starts_from']) && $date_settings['week_starts_from'] == "5"){ echo "selected"; } ?>>Friday</option>
									<option value="6" <?php if(isset($date_settings['week_starts_from']) && $date_settings['week_starts_from'] == "6"){ echo "selected"; } ?>>Saturday</option>
								</select>
	                    	</div>

	                    	<div class="coderockz-woo-delivery-form-group">
	                    		<label class="coderockz-woo-delivery-form-label" for="coderockz_delivery_date_format"><?php _e('Delivery Date Format', 'woo-delivery'); ?></label>
	                    		<p class="coderockz-woo-delivery-tooltip" tooltip="Date format that is used in everywhere which is available by this plugin. Default is F j, Y ( ex. March 6, 2011 )."><span class="dashicons dashicons-editor-help"></span></p>
	                    		<select class="coderockz-woo-delivery-select-field" name="coderockz_delivery_date_format">
									<option value="F j, Y" <?php if(isset($date_settings['date_format']) && $date_settings['date_format'] == "F j, Y"){ echo "selected"; } ?>>F j, Y ( ex. March 6, 2011 )</option>
									<option value="d-m-Y" <?php if(isset($date_settings['date_format']) && $date_settings['date_format'] == "d-m-Y"){ echo "selected"; } ?>>d-m-Y ( ex. 29-03-2011 )</option>
									<option value="m/d/Y" <?php if(isset($date_settings['date_format']) && $date_settings['date_format'] == "m/d/Y"){ echo "selected"; } ?>>m/d/Y ( ex. 03/29/2011 )</option>
									<option value="d.m.Y" <?php if(isset($date_settings['date_format']) && $date_settings['date_format'] == "d.m.Y"){ echo "selected"; } ?>>d.m.Y ( ex. 29.03.2011 )</option>
								</select>
	                    	</div>
	                    	<div class="coderockz-woo-delivery-form-group">
	                        	<span class="coderockz-woo-delivery-form-label"><?php _e('Auto Select 1st Available Date', 'woo-delivery'); ?></span>
	                        	<p class="coderockz-woo-delivery-tooltip" tooltip="Enable the option if you want to select the first available date automatically and shown in the delivery date field. Default is disable."><span class="dashicons dashicons-editor-help"></span></p>
							    <label class="coderockz-woo-delivery-toogle-switch" for="coderockz_auto_select_first_date">
							       <input type="checkbox" name="coderockz_auto_select_first_date" id="coderockz_auto_select_first_date" <?php echo (isset($date_settings['auto_select_first_date']) && !empty($date_settings['auto_select_first_date'])) ? "checked" : "" ?>/>
							       <div class="coderockz-woo-delivery-toogle-slider coderockz-woo-delivery-toogle-round"></div>
							    </label>
	                    	</div>
	                    	<div class="coderockz-woo-delivery-form-group">
	                    		<label class="coderockz-woo-delivery-form-label coderockz-woo-delivery-checkbox-label" for="coderockz_delivery_date_delivery_days"><?php _e('Delivery Days', 'woo-delivery'); ?></label>
	                    		<p class="coderockz-woo-delivery-tooltip coderockz-woo-delivery-checkbox-tooltip" tooltip="Delivery is only available in those days that are checked. Other dates corresponding to the unchecked days are disabled in the calendar."><span class="dashicons dashicons-editor-help"></span></p>
	                    		<div id="coderockz_delivery_date_delivery_days" style="display:inline-block">
	                    		<input type="checkbox" name="coderockz_delivery_date_delivery_days[]" value="6" <?php echo in_array("6",$selected_delivery_day) ? "checked" : "";?>><label class="coderockz-woo-delivery-checkbox-field-text">Saturday</label><br/>
								<input type="checkbox" name="coderockz_delivery_date_delivery_days[]" value="0" <?php echo in_array("0",$selected_delivery_day) ? "checked" : "";?>><label class="coderockz-woo-delivery-checkbox-field-text">Sunday</label><br/>
								<input type="checkbox" name="coderockz_delivery_date_delivery_days[]" value="1" <?php echo in_array("1",$selected_delivery_day) ? "checked" : "";?>><label class="coderockz-woo-delivery-checkbox-field-text">Monday</label><br/>
								<input type="checkbox" name="coderockz_delivery_date_delivery_days[]" value="2" <?php echo in_array("2",$selected_delivery_day) ? "checked" : "";?>><label class="coderockz-woo-delivery-checkbox-field-text">Tuesday</label><br/>
								<input type="checkbox" name="coderockz_delivery_date_delivery_days[]" value="3" <?php echo in_array("3",$selected_delivery_day) ? "checked" : "";?>><label class="coderockz-woo-delivery-checkbox-field-text">Wednesday</label><br/>
								<input type="checkbox" name="coderockz_delivery_date_delivery_days[]" value="4" <?php echo in_array("4",$selected_delivery_day) ? "checked" : "";?>><label class="coderockz-woo-delivery-checkbox-field-text">Thursday</label><br/>
								<input type="checkbox" name="coderockz_delivery_date_delivery_days[]" value="5" <?php echo in_array("5",$selected_delivery_day) ? "checked" : "";?>><label class="coderockz-woo-delivery-checkbox-field-text">Friday</label><br/>
								</div>
	                    	</div>

	                        <input class="coderockz-woo-delivery-submit-btn" type="submit" name="coderockz_delivery_date_form_submit" value="<?php _e('Save Changes', 'woo-delivery'); ?>" />

	                    </form>
                	</div>

                </div>

			</div>

			<div data-tab="tab4" class="coderockz-woo-delivery-tabcontent">
				<div class="coderockz-woo-delivery-card">
					<p class="coderockz-woo-delivery-card-header"><?php _e('General Pickup Date Settings', 'woo-delivery'); ?></p>
					<div class="coderockz-woo-delivery-card-body">
						<p class="coderockz-woo-delivery-pickup-date-tab-notice"><span class="dashicons dashicons-yes"></span><?php _e(' Settings Changed Successfully', 'woo-delivery'); ?></p>
	                    <form action="" method="post" id ="coderockz_delivery_pickup_date_form_submit">
	                        <?php wp_nonce_field('coderockz_woo_delivery_nonce'); ?>

	                    	<div class="coderockz-woo-delivery-form-group">
	                        	<span class="coderockz-woo-delivery-form-label"><?php _e('Enable Pickup Date', 'woo-delivery'); ?></span>
	                        	<p class="coderockz-woo-delivery-tooltip" tooltip="Enable Pickup Date input field in woocommerce order checkout page."><span class="dashicons dashicons-editor-help"></span></p>
							    <label class="coderockz-woo-delivery-toogle-switch" for="coderockz_enable_pickup_date">
							       <input type="checkbox" name="coderockz_enable_pickup_date" id="coderockz_enable_pickup_date" <?php echo (isset($pickup_date_settings['enable_pickup_date']) && !empty($pickup_date_settings['enable_pickup_date'])) ? "checked" : "" ?>/>
							       <div class="coderockz-woo-delivery-toogle-slider coderockz-woo-delivery-toogle-round"></div>
							    </label>
	                    	</div>
	                    	<div class="coderockz-woo-delivery-form-group">
	                        	<span class="coderockz-woo-delivery-form-label"><?php _e('Make Pickup Date Field Mandatory', 'woo-delivery'); ?></span>
	                        	<p class="coderockz-woo-delivery-tooltip" tooltip="Make Pickup Date input field mandatory in woocommerce order checkout page. Default is optional."><span class="dashicons dashicons-editor-help"></span></p>
							    <label class="coderockz-woo-delivery-toogle-switch" for="coderockz_pickup_date_mandatory">
							       <input type="checkbox" name="coderockz_pickup_date_mandatory" id="coderockz_pickup_date_mandatory" <?php echo (isset($pickup_date_settings['pickup_date_mandatory']) && !empty($pickup_date_settings['pickup_date_mandatory'])) ? "checked" : "" ?>/>
							       <div class="coderockz-woo-delivery-toogle-slider coderockz-woo-delivery-toogle-round"></div>
							    </label>
	                    	</div>

	                    	<div class="coderockz-woo-delivery-form-group">
	                    		<label class="coderockz-woo-delivery-form-label" for="coderockz_pickup_date_field_label"><?php _e('Pickup Date Field Label', 'woo-delivery'); ?></label>
	                    		<p class="coderockz-woo-delivery-tooltip" tooltip="Pickup Date input field heading. Default is Pickup Date."><span class="dashicons dashicons-editor-help"></span></p>
	                        	<input id="coderockz_pickup_date_field_label" name="coderockz_pickup_date_field_label" type="text" class="coderockz-woo-delivery-input-field" value="<?php echo (isset($pickup_date_settings['pickup_field_label']) && !empty($pickup_date_settings['pickup_field_label'])) ? stripslashes(esc_attr($pickup_date_settings['pickup_field_label'])) : "" ?>" placeholder="" autocomplete="off"/>
	                    	</div>

	                    	<div class="coderockz-woo-delivery-form-group">
	                    		<label class="coderockz-woo-delivery-form-label" for="coderockz_pickup_date_selectable_date"><?php _e('Allow Pickup in Next Available Days', 'woo-delivery'); ?></label>
	                    		<p class="coderockz-woo-delivery-tooltip" tooltip="User can only select the number of date from calander that is specified Here. Other dates are disabled. Only numerical value is excepted. Default is 365 days."><span class="dashicons dashicons-editor-help"></span></p>
	                        	<input onkeyup="if(!Number.isInteger(Number(this.value)) || this.value < 1) this.value = null;" id="coderockz_pickup_date_selectable_date" name="coderockz_pickup_date_selectable_date" type="number" class="coderockz-woo-delivery-number-field" value="<?php echo (isset($pickup_date_settings['selectable_date']) && !empty($pickup_date_settings['selectable_date'])) ? stripslashes(esc_attr($pickup_date_settings['selectable_date'])) : "" ?>" placeholder="" autocomplete="off"/>
	                    	</div>

	                    	<div class="coderockz-woo-delivery-form-group">
	                    		<label class="coderockz-woo-delivery-form-label" for="coderockz_pickup_date_week_starts_from"><?php _e('Week Starts From', 'woo-delivery'); ?></label>
	                    		<p class="coderockz-woo-delivery-tooltip" tooltip="Pickup Date's calendar will start from the day that is selected Here. Default is Sunday."><span class="dashicons dashicons-editor-help"></span></p>
	                    		<select class="coderockz-woo-delivery-select-field" name="coderockz_pickup_date_week_starts_from">
	                    			<option value="" <?php if(isset($pickup_date_settings['week_starts_from']) && $pickup_date_settings['week_starts_from'] == ""){ echo "selected"; } ?>><?php _e('Select Day', 'woo-delivery'); ?></option>
									<option value="0" <?php if(isset($pickup_date_settings['week_starts_from']) && $pickup_date_settings['week_starts_from'] == "0"){ echo "selected"; } ?>>Sunday</option>
									<option value="1" <?php if(isset($pickup_date_settings['week_starts_from']) && $pickup_date_settings['week_starts_from'] == "1"){ echo "selected"; } ?>>Monday</option>
									<option value="2" <?php if(isset($pickup_date_settings['week_starts_from']) && $pickup_date_settings['week_starts_from'] == "2"){ echo "selected"; } ?>>Tuesday</option>
									<option value="3" <?php if(isset($pickup_date_settings['week_starts_from']) && $pickup_date_settings['week_starts_from'] == "3"){ echo "selected"; } ?>>Wednesday</option>
									<option value="4" <?php if(isset($pickup_date_settings['week_starts_from']) && $pickup_date_settings['week_starts_from'] == "4"){ echo "selected"; } ?>>Thursday</option>
									<option value="5" <?php if(isset($pickup_date_settings['week_starts_from']) && $pickup_date_settings['week_starts_from'] == "5"){ echo "selected"; } ?>>Friday</option>
									<option value="6" <?php if(isset($pickup_date_settings['week_starts_from']) && $pickup_date_settings['week_starts_from'] == "6"){ echo "selected"; } ?>>Saturday</option>
								</select>
	                    	</div>

	                    	<div class="coderockz-woo-delivery-form-group">
	                    		<label class="coderockz-woo-delivery-form-label" for="coderockz_pickup_date_format"><?php _e('Pickup Date Format', 'woo-delivery'); ?></label>
	                    		<p class="coderockz-woo-delivery-tooltip" tooltip="Date format that is used in everywhere which is available by this plugin. Default is F j, Y ( ex. March 6, 2011 )."><span class="dashicons dashicons-editor-help"></span></p>
	                    		<select class="coderockz-woo-delivery-select-field" name="coderockz_pickup_date_format">
	                    			<option value="F j, Y" <?php if(isset($pickup_date_settings['date_format']) && $pickup_date_settings['date_format'] == "F j, Y"){ echo "selected"; } ?>>F j, Y ( ex. March 6, 2011 )</option>
									<option value="d-m-Y" <?php if(isset($pickup_date_settings['date_format']) && $pickup_date_settings['date_format'] == "d-m-Y"){ echo "selected"; } ?>>d-m-Y ( ex. 29-03-2011 )</option>
									<option value="m/d/Y" <?php if(isset($pickup_date_settings['date_format']) && $pickup_date_settings['date_format'] == "m/d/Y"){ echo "selected"; } ?>>m/d/Y ( ex. 03/29/2011 )</option>
									<option value="d.m.Y" <?php if(isset($pickup_date_settings['date_format']) && $pickup_date_settings['date_format'] == "d.m.Y"){ echo "selected"; } ?>>d.m.Y ( ex. 29.03.2011 )</option>
									
								</select>
	                    	</div>

	                    	<div class="coderockz-woo-delivery-form-group">
	                        	<span class="coderockz-woo-delivery-form-label"><?php _e('Auto Select 1st Available Date', 'woo-delivery'); ?></span>
	                        	<p class="coderockz-woo-delivery-tooltip" tooltip="Enable the option if you want to select the first available date automatically and shown in the pickup date field. Default is disable."><span class="dashicons dashicons-editor-help"></span></p>
							    <label class="coderockz-woo-delivery-toogle-switch" for="coderockz_auto_select_first_pickup_date">
							       <input type="checkbox" name="coderockz_auto_select_first_pickup_date" id="coderockz_auto_select_first_pickup_date" <?php echo (isset($pickup_date_settings['auto_select_first_pickup_date']) && !empty($pickup_date_settings['auto_select_first_pickup_date'])) ? "checked" : "" ?>/>
							       <div class="coderockz-woo-delivery-toogle-slider coderockz-woo-delivery-toogle-round"></div>
							    </label>
	                    	</div>

	                    	<div class="coderockz-woo-delivery-form-group">
	                    		<label class="coderockz-woo-delivery-form-label coderockz-woo-delivery-checkbox-label" for="coderockz_pickup_date_delivery_days"><?php _e('Pickup Days', 'woo-delivery'); ?></label>
	                    		<p class="coderockz-woo-delivery-tooltip coderockz-woo-delivery-checkbox-tooltip" tooltip="Pickup is only available in those days that are checked. Other dates corresponding to the unchecked days are disabled in the calendar."><span class="dashicons dashicons-editor-help"></span></p>
	                    		<div id="coderockz_pickup_date_delivery_days" style="display:inline-block">
	                    		<input type="checkbox" name="coderockz_pickup_date_delivery_days[]" value="6" <?php echo in_array("6",$selected_pickup_day) ? "checked" : "";?>><label class="coderockz-woo-delivery-checkbox-field-text">Saturday</label><br/>
								<input type="checkbox" name="coderockz_pickup_date_delivery_days[]" value="0" <?php echo in_array("0",$selected_pickup_day) ? "checked" : "";?>><label class="coderockz-woo-delivery-checkbox-field-text">Sunday</label><br/>
								<input type="checkbox" name="coderockz_pickup_date_delivery_days[]" value="1" <?php echo in_array("1",$selected_pickup_day) ? "checked" : "";?>><label class="coderockz-woo-delivery-checkbox-field-text">Monday</label><br/>
								<input type="checkbox" name="coderockz_pickup_date_delivery_days[]" value="2" <?php echo in_array("2",$selected_pickup_day) ? "checked" : "";?>><label class="coderockz-woo-delivery-checkbox-field-text">Tuesday</label><br/>
								<input type="checkbox" name="coderockz_pickup_date_delivery_days[]" value="3" <?php echo in_array("3",$selected_pickup_day) ? "checked" : "";?>><label class="coderockz-woo-delivery-checkbox-field-text">Wednesday</label><br/>
								<input type="checkbox" name="coderockz_pickup_date_delivery_days[]" value="4" <?php echo in_array("4",$selected_pickup_day) ? "checked" : "";?>><label class="coderockz-woo-delivery-checkbox-field-text">Thursday</label><br/>
								<input type="checkbox" name="coderockz_pickup_date_delivery_days[]" value="5" <?php echo in_array("5",$selected_pickup_day) ? "checked" : "";?>><label class="coderockz-woo-delivery-checkbox-field-text">Friday</label><br/>
								</div>
	                    	</div>

	                        <input class="coderockz-woo-delivery-submit-btn" type="submit" name="coderockz_delivery_pickup_date_form_submit" value="<?php _e('Save Changes', 'woo-delivery'); ?>" />

	                    </form>
                	</div>

                </div>
			</div>

			<div data-tab="tab5" class="coderockz-woo-delivery-tabcontent">
				<div class="coderockz-woo-delivery-card">
					<p class="coderockz-woo-delivery-card-header"><?php _e('Off Days', 'woo-delivery'); ?></p>
					<div class="coderockz-woo-delivery-card-body">
						<p class="coderockz-woo-delivery-date-tab-offdays-notice"></p>
						<input class="coderockz-woo-delivery-add-year-btn" type="button" value="<?php _e('Add New Year', 'woo-delivery'); ?>">
	                    <form action="" method="post" id ="coderockz_delivery_date_offdays_form_submit">
	                        <?php wp_nonce_field('coderockz_woo_delivery_nonce'); ?>
	                        <div id="coderockz-woo-delivery-offdays" class="coderockz-woo-delivery-offdays">
							    
	                        	<?php
	                        		$month_array = ['january','february','march','april','may','june','july','august','september','october','november','december'];
									$offdays_html = "";
									$offdays_years = get_option('coderockz_woo_delivery_date_settings');
									if(isset($offdays_years['off_days']) && !empty($offdays_years['off_days'])) {
										foreach($offdays_years['off_days'] as $year=>$months) {
											
											$offdays_html .= '<div class="coderockz-woo-delivery-add-year-html coderockz-woo-delivery-form-group">';
											if(array_keys($offdays_years['off_days'])[0] == $year) {
												$offdays_html .= '<img class="coderockz-arrow" src="'. CODEROCKZ_WOO_DELIVERY_URL .'/admin/images/arrow.png" alt="" style="width: 20px;vertical-align: top;margin-top: 12px;margin-right: 15px;">';	

											} else {
												$offdays_html .= '<button class="coderockz-offdays-year-remove"><span class="dashicons dashicons-trash"></span></button>';
											}
											
											$offdays_html .= '<input style="width:125px" class="coderockz-woo-delivery-input-field coderockz_woo_delivery_offdays_year" maxlength="4" type="text" value="'.$year.'" placeholder="'.__('Year (ex. 2019)', 'woo-delivery').'" style="vertical-align:top;" autocomplete="off" name="coderockz_woo_delivery_offdays_year_'.$year.'">';
											$offdays_html .= '<div style="display:inline-block;" class="coderockz_woo_delivery_offdays_another_month coderockz_woo_delivery_offdays_another_month_'.$year.'">';
											foreach($months as $month=>$date) {
												$offdays_html .= '<div class="coderockz_woo_delivery_offdays_add_another_month">';
												$offdays_html .= '<select style="width:125px!important" class="coderockz-woo-delivery-select-field" name="coderockz_woo_delivery_offdays_month_'.$year.'[]">';
												$offdays_html .= '<option value="">'.__('Select Month', 'woo-delivery').'</option>';
												foreach($month_array as $single_month) {
													$single_month == $month ? $selected = "selected" : $selected = "";
													$offdays_html .= '<option value="'.$single_month.'"'.$selected.'>'.ucfirst($single_month).'</option>';
												}
												$offdays_html .= '</select>';
												$offdays_html .= '<input id="coderockz_woo_delivery_offdays_dates" type="text" class="coderockz-woo-delivery-input-field" value="'.$date.'" placeholder="'.__('Comma(,) Separeted Date', 'woo-delivery').'" style="width:200px;vertical-align:top;" autocomplete="off" name="coderockz_woo_delivery_offdays_dates_'.$month.'_'.$year.'">';
												if(array_keys($months)[0] != $month) {
													
													$offdays_html .= '<button class="coderockz-offdays-month-remove"><span class="dashicons dashicons-trash"></span></button>';
												}
												$offdays_html .= '</div>';
											}
											$offdays_html .= '</div>';
											$offdays_html .= '<br>
												    	  <span style="position:relative;left:35%">
														    <input class="coderockz-woo-delivery-add-month-btn" type="button" value="'.__("Add Month", "woo-delivery").'">
														    <div class="coderockz-woo-delivery-dummy-btn" style="position:absolute; left:0; right:0; top:0; bottom:0; cursor: pointer;"></div>
														  </span>';
											
											$offdays_html .= '</div>';
										}
										echo $offdays_html;
									} else {
	                        	?>

							    <div class="coderockz-woo-delivery-add-year-html coderockz-woo-delivery-form-group">
							    	<img class="coderockz-arrow" src="<?php echo CODEROCKZ_WOO_DELIVERY_URL ?>/admin/images/arrow.png" alt="" style="width: 20px;vertical-align: top;margin-top: 12px;margin-right: 15px;">
							        <input style="width:125px" class="coderockz-woo-delivery-input-field coderockz_woo_delivery_offdays_year" maxlength="4" type="text" value="<?php  ?>" placeholder="<?php _e('Year (ex. 2019)', 'woo-delivery'); ?>" style="vertical-align:top;" autocomplete="off"/>
							        <div class="coderockz_woo_delivery_offdays_another_month" style="display:inline-block;">
								        <div class="coderockz_woo_delivery_offdays_add_another_month">
									        <select style="width:125px!important" class="coderockz-woo-delivery-select-field" disabled="disabled">
									        	<option value=""><?php _e('Select Month', 'woo-delivery'); ?></option>
									        	<?php
									        	$month_array = ['january','february','march','april','may','june','july','august','september','october','november','december'];
									        	foreach($month_array as $single_month) {
													echo '<option value="'.$single_month.'">'.ucfirst($single_month).'</option>';
												}
									        	?>
									            
										    </select>
									        <input style="width:200px" id="coderockz_woo_delivery_offdays_dates" type="text" class="coderockz-woo-delivery-input-field" value="<?php  ?>" placeholder="<?php _e('Comma(,) Separeted Date', 'woo-delivery'); ?>" style="vertical-align:top;" autocomplete="off" disabled="disabled"/>
								    	</div>
							    	</div>
							    	<br/>
							    	<span style="position:relative;left:18%">
									  <input class="coderockz-woo-delivery-add-month-btn" type="button" value="<?php _e('Add Month', 'woo-delivery'); ?>" disabled="disabled">
									  <div class="coderockz-woo-delivery-dummy-btn" style="position:absolute; left:0; right:0; top:0; bottom:0; cursor: pointer;"></div>
									</span>


							    </div>
								<?php } ?>
							</div>
	                        <input class="coderockz-woo-delivery-submit-btn" type="submit" name="coderockz_delivery_date_offdays_form_submit" value="<?php _e('Save Changes', 'woo-delivery'); ?>" />

	                    </form>
                	</div>

                </div>
			</div>

			<div data-tab="tab6" class="coderockz-woo-delivery-tabcontent">
				<div class="coderockz-woo-delivery-card">
					<p class="coderockz-woo-delivery-card-header"><?php _e('General Delivery Time Settings', 'woo-delivery'); ?></p>
					<div class="coderockz-woo-delivery-card-body">
						<p class="coderockz-woo-delivery-time-tab-notice"><span class="dashicons dashicons-yes"></span><?php _e(' Settings Changed Successfully', 'woo-delivery'); ?></p>
	                    <form action="" method="post" id ="coderockz_delivery_time_form_submit">
	                        <?php wp_nonce_field('coderockz_woo_delivery_nonce'); ?>

	                    	<div class="coderockz-woo-delivery-form-group">
	                        	<span class="coderockz-woo-delivery-form-label"><?php _e('Enable Delivery Time', 'woo-delivery'); ?></span>
	                        	<p class="coderockz-woo-delivery-tooltip" tooltip="Enable Delivery Time select field in woocommerce order checkout page."><span class="dashicons dashicons-editor-help"></span></p>
							    <label class="coderockz-woo-delivery-toogle-switch" for="coderockz_enable_delivery_time">
							       <input type="checkbox" name="coderockz_enable_delivery_time" id="coderockz_enable_delivery_time" <?php echo (isset($time_settings['enable_delivery_time']) && !empty($time_settings['enable_delivery_time'])) ? "checked" : "" ?>/>
							       <div class="coderockz-woo-delivery-toogle-slider coderockz-woo-delivery-toogle-round"></div>
							    </label>
	                    	</div>
	                    	<div class="coderockz-woo-delivery-form-group">
	                        	<span class="coderockz-woo-delivery-form-label"><?php _e('Make Delivery Time Field Mandatory', 'woo-delivery'); ?></span>
	                        	<p class="coderockz-woo-delivery-tooltip" tooltip="Make Delivery Time select field mandatory in woocommerce order checkout page. Default is optional."><span class="dashicons dashicons-editor-help"></span></p>
							    <label class="coderockz-woo-delivery-toogle-switch" for="coderockz_delivery_time_mandatory">
							       <input type="checkbox" name="coderockz_delivery_time_mandatory" id="coderockz_delivery_time_mandatory" <?php echo (isset($time_settings['delivery_time_mandatory']) && !empty($time_settings['delivery_time_mandatory'])) ? "checked" : "" ?>/>
							       <div class="coderockz-woo-delivery-toogle-slider coderockz-woo-delivery-toogle-round"></div>
							    </label>
	                    	</div>
	                    	<div class="coderockz-woo-delivery-form-group">
	                    		<label class="coderockz-woo-delivery-form-label" for="coderockz_delivery_time_field_label"><?php _e('Delivery Time Field Label', 'woo-delivery'); ?></label>
	                    		<p class="coderockz-woo-delivery-tooltip" tooltip="Delivery Time select field label and placeholder. Default is Delivery Time."><span class="dashicons dashicons-editor-help"></span></p>
	                        	<input id="coderockz_delivery_time_field_label" name="coderockz_delivery_time_field_label" type="text" class="coderockz-woo-delivery-input-field" value="<?php echo (isset($time_settings['field_label']) && !empty($time_settings['field_label'])) ? esc_attr($time_settings['field_label']) : "" ?>" placeholder="" autocomplete="off"/>
	                    	</div>
	                    	<?php 
                    			$start_hour = "";
            					$start_min = "";
            					$start_format= "am";
                    			
                    			if(isset($time_settings['delivery_time_starts']) && $time_settings['delivery_time_starts'] !='') {
                    				$delivery_time_starts = (int)$time_settings['delivery_time_starts'];

                    				if($delivery_time_starts == 0) {
		            					$start_hour = "12";
		            					$start_min = "00";
		            					$start_format= "am";
		            				} elseif($delivery_time_starts > 0 && $delivery_time_starts <= 59) {

                    					$start_hour = "12";
                    					$start_min = sprintf("%02d", $delivery_time_starts);
                    					$start_format= "am";
                    				} elseif($delivery_time_starts > 59 && $delivery_time_starts <= 719) {
										$start_min = sprintf("%02d", (int)$delivery_time_starts%60);
										$start_hour = sprintf("%02d", ((int)$delivery_time_starts-$start_min)/60);
										$start_format= "am";
										
                    				} elseif($delivery_time_starts > 719 && $delivery_time_starts <= 1439) {
										$start_min = sprintf("%02d", (int)$delivery_time_starts%60);
										$start_hour = sprintf("%02d", ((int)$delivery_time_starts-$start_min)/60);
										if($start_hour>12) {
											$start_hour = sprintf("%02d", $start_hour-12);
										}
										$start_format= "pm";
                    				} elseif($delivery_time_starts == 1440) {
										$start_min = "00";
										$start_hour = "12";
										$start_format= "am";
                    				}

                    			}
                    		?>
	                    	<div class="coderockz-woo-delivery-form-group">
	                    		<label class="coderockz-woo-delivery-form-label" for="coderockz_delivery_time_slot_starts"><?php _e('Time Slot Starts From', 'woo-delivery'); ?></label>
	                    		<p class="coderockz-woo-delivery-tooltip" tooltip="Delivery Time starts from the time that is specified here. Only numerical value is accepted."><span class="dashicons dashicons-editor-help"></span></p>
	                    		<div id="coderockz_delivery_time_slot_starts" class="coderockz_delivery_time_slot_starts">
	                    			
	                        	<input name="coderockz_delivery_time_slot_starts_hour" type="number" class="coderockz-woo-delivery-number-field" max="12" min="1" onkeyup="if(!Number.isInteger(Number(this.value)) || this.value > 12 || this.value < 1) this.value = null;" value="<?php echo $start_hour; ?>" placeholder="Hour" autocomplete="off"/>
	                        	<input name="coderockz_delivery_time_slot_starts_min" type="number" class="coderockz-woo-delivery-number-field" max="59" min="0" onkeyup="if(!Number.isInteger(Number(this.value)) || this.value > 59 || this.value < 0) this.value = null;" value="<?php echo $start_min; ?>" placeholder="Minute" autocomplete="off"/>
	                        	<select class="coderockz-woo-delivery-select-field" name="coderockz_delivery_time_slot_starts_format">
									<option value="am" <?php selected($start_format,"am",true); ?>>AM</option>
									<option value="pm" <?php selected($start_format,"pm",true); ?>>PM</option>
								</select>
	                        	</div>
	                    	</div>
	                    	<?php 
                    			$end_hour = "";
            					$end_min = "";
            					$end_format= "am";
                    			
                    			if(isset($time_settings['delivery_time_ends']) && $time_settings['delivery_time_ends'] !='') {
                    				$delivery_time_ends = (int)$time_settings['delivery_time_ends'];
                    				if($delivery_time_ends == 0) {
		            					$end_hour = "12";
		            					$end_min = "00";
		            					$end_format= "am";
		            				} elseif($delivery_time_ends > 0 && $delivery_time_ends <= 59) {
                    					$end_hour = "12";
                    					$end_min = sprintf("%02d", $delivery_time_ends);
                    					$end_format= "am";
                    				} elseif($delivery_time_ends > 59 && $delivery_time_ends <= 719) {
										$end_min = sprintf("%02d", (int)$delivery_time_ends%60);
										$end_hour = sprintf("%02d", ((int)$delivery_time_ends-$end_min)/60);
										$end_format= "am";
										
                    				} elseif($delivery_time_ends > 719 && $delivery_time_ends <= 1439) {
										$end_min = sprintf("%02d", (int)$delivery_time_ends%60);
										$end_hour = sprintf("%02d", ((int)$delivery_time_ends-$end_min)/60);
										if($end_hour>12) {
											$end_hour = sprintf("%02d", $end_hour-12);
										}
										$end_format= "pm";
                    				} elseif($delivery_time_ends == 1440) {
										$end_min = "00";
										$end_hour = "12";
										$end_format= "am";
                    				}

                    			}
                    		?>
	                    	<div class="coderockz-woo-delivery-form-group">
	                    		<label class="coderockz-woo-delivery-form-label" for="coderockz_delivery_time_slot_ends"><?php _e('Time Slot Ends At', 'woo-delivery'); ?></label>
	                    		<p class="coderockz-woo-delivery-tooltip" tooltip="Delivery Time ends at the time that is specified here. Only numerical value is accepted."><span class="dashicons dashicons-editor-help"></span></p>
	                    		<div id="coderockz_delivery_time_slot_ends" class="coderockz_delivery_time_slot_ends">
	                        	<input name="coderockz_delivery_time_slot_ends_hour" type="number" class="coderockz-woo-delivery-number-field" max="12" min="1" onkeyup="if(!Number.isInteger(Number(this.value)) || this.value > 12 || this.value < 1) this.value = null;" value="<?php echo $end_hour; ?>" placeholder="Hour" autocomplete="off"/>
	                        	<input name="coderockz_delivery_time_slot_ends_min" type="number" class="coderockz-woo-delivery-number-field" max="59" min="0" onkeyup="if(!Number.isInteger(Number(this.value)) || this.value > 59 || this.value < 0) this.value = null;" value="<?php echo $end_min; ?>" placeholder="Minute" autocomplete="off"/>
	                        	<select class="coderockz-woo-delivery-select-field" name="coderockz_delivery_time_slot_ends_format">
									<option value="am" <?php selected($end_format,"am",true); ?>>AM</option>
									<option value="pm" <?php selected($end_format,"pm",true); ?>>PM</option>
								</select>
	                        	</div>
	                        	<p class="coderockz_end_time_greater_notice"><?php _e('End Time Must after Start Time', 'woo-delivery'); ?></p>
	                    	</div>
	                    	<?php
	                    		$duration = ""; 
	                    		$identity = "min";
	                    		$time_settings = get_option('coderockz_woo_delivery_time_settings');
                    			if(isset($time_settings['each_time_slot']) && !empty($time_settings['each_time_slot'])) {
                    				$time_slot_duration = (int)$time_settings['each_time_slot'];
                    				if($time_slot_duration <= 59) {
                    					$duration = $time_slot_duration;
                    				} else {
                    					$time_slot_duration = $time_slot_duration/60;
                    					$helper = new Coderockz_Woo_Delivery_Helper();
                    					if($helper->containsDecimal($time_slot_duration)){
                    						$duration = $time_slot_duration*60;
                    						$identity = "min";
                    					} else {
                    						$duration = $time_slot_duration;
                    						$identity = "hour";
                    					}
                    				}
                    			}
	                    	?>
	                    	<div class="coderockz-woo-delivery-form-group">
	                    		<label class="coderockz-woo-delivery-form-label" for="coderockz_delivery_time_slot_duration"><?php _e('Each Time Slot Duration', 'woo-delivery'); ?></label>
	                    		<p class="coderockz-woo-delivery-tooltip" tooltip="Each delivery time slot duration that is specified here. Only numerical value is accepted. Default is 3 hours."><span class="dashicons dashicons-editor-help"></span></p>
	                    		<div id="coderockz_delivery_time_slot_duration" class="coderockz_delivery_time_slot_duration">
	                        	<input name="coderockz_delivery_time_slot_duration_time" type="number" min="1" onkeyup="if(!Number.isInteger(Number(this.value)) || this.value < 1) this.value = null;" class="coderockz-woo-delivery-number-field" value="<?php echo $duration; ?>" placeholder="" autocomplete="off"/>
	                        	<select class="coderockz-woo-delivery-select-field" name="coderockz_delivery_time_slot_duration_format">
									<option value="min" <?php selected($identity,"min",true); ?>>Minutes</option>
									<option value="hour" <?php selected($identity,"hour",true); ?>>Hour</option>
								</select>
	                        	</div>
	                    	</div>

	                    	<div class="coderockz-woo-delivery-form-group">
	                    		<label class="coderockz-woo-delivery-form-label" for="coderockz_delivery_time_maximum_order"><?php _e('Maximum Order Per Time Slot', 'woo-delivery'); ?></label>
	                    		<p class="coderockz-woo-delivery-tooltip" tooltip="Each time slot take maximum number of orders that is specified here. After reaching the maximum order, the time slot is disabled automaticaly. Only numerical value is accepted. Blank this field or 0 value means each time slot takes unlimited order."><span class="dashicons dashicons-editor-help"></span></p>
	                        	<input id="coderockz_delivery_time_maximum_order" name="coderockz_delivery_time_maximum_order" type="number" class="coderockz-woo-delivery-number-field" min="1" onkeyup="if(!Number.isInteger(Number(this.value)) || this.value < 1) this.value = null;" value="<?php echo (isset($time_settings['max_order_per_slot']) && !empty($time_settings['max_order_per_slot'])) ? stripslashes(esc_attr($time_settings['max_order_per_slot'])) : ""; ?>" placeholder="" autocomplete="off"/>
	                    	</div>

	                    	<div class="coderockz-woo-delivery-form-group">
	                    		<label class="coderockz-woo-delivery-form-label" for="coderockz_delivery_time_format"><?php _e('Delivery Time format', 'woo-delivery'); ?></label>
	                    		<p class="coderockz-woo-delivery-tooltip" tooltip="Time format that is used in everywhere which is available by this plugin. Default is 12 Hours."><span class="dashicons dashicons-editor-help"></span></p>
	                    		<select class="coderockz-woo-delivery-select-field" name="coderockz_delivery_time_format">

	                    			<option value="" <?php if(isset($time_settings['time_format']) && $time_settings['time_format'] == ""){ echo "selected"; } ?>><?php _e('Select Time Format', 'woo-delivery'); ?></option>
									<option value="12" <?php if(isset($time_settings['time_format']) && $time_settings['time_format'] == "12"){ echo "selected"; } ?>>12 Hours</option>
									<option value="24" <?php if(isset($time_settings['time_format']) && $time_settings['time_format'] == "24"){ echo "selected"; } ?>>24 Hours</option>
								</select>
	                    	</div>

	                    	<div class="coderockz-woo-delivery-form-group">
	                        	<span class="coderockz-woo-delivery-form-label"><?php _e('Disable Current Time Slot', 'woo-delivery'); ?></span>
	                        	<p class="coderockz-woo-delivery-tooltip" tooltip="Make the time slot disabled that has the current time. In default, the time slot isn't disabled that has the current time."><span class="dashicons dashicons-editor-help"></span></p>
							    <label class="coderockz-woo-delivery-toogle-switch" for="coderockz_delivery_time_disable_current_time_slot">
							       <input type="checkbox" name="coderockz_delivery_time_disable_current_time_slot" id="coderockz_delivery_time_disable_current_time_slot" <?php echo (isset($time_settings['disabled_current_time_slot']) && !empty($time_settings['disabled_current_time_slot'])) ? "checked" : "" ?>/>
							       <div class="coderockz-woo-delivery-toogle-slider coderockz-woo-delivery-toogle-round"></div>
							    </label>
	                    	</div>

	                    	<div class="coderockz-woo-delivery-form-group">
	                        	<span class="coderockz-woo-delivery-form-label"><?php _e('Auto Select 1st Available Time', 'woo-delivery'); ?></span>
	                        	<p class="coderockz-woo-delivery-tooltip" tooltip="Enable the option if you want to select the first available time based on date automatically and shown in the delivery time field. Default is disable."><span class="dashicons dashicons-editor-help"></span></p>
							    <label class="coderockz-woo-delivery-toogle-switch" for="coderockz_auto_select_first_time">
							       <input type="checkbox" name="coderockz_auto_select_first_time" id="coderockz_auto_select_first_time" <?php echo (isset(get_option('coderockz_woo_delivery_time_settings')['auto_select_first_time']) && !empty(get_option('coderockz_woo_delivery_time_settings')['auto_select_first_time'])) ? "checked" : "" ?>/>
							       <div class="coderockz-woo-delivery-toogle-slider coderockz-woo-delivery-toogle-round"></div>
							    </label>
	                    	</div>


	                        <input class="coderockz-woo-delivery-submit-btn" type="submit" name="coderockz_delivery_time_form_submit" value="<?php _e('Save Changes', 'woo-delivery'); ?>" />

	                    </form>
                	</div>

                </div>
			</div>
			<div data-tab="tab7" class="coderockz-woo-delivery-tabcontent">
				<div class="coderockz-woo-delivery-card">
					<p class="coderockz-woo-delivery-card-header"><?php _e('General Pickup Time Settings', 'woo-delivery'); ?></p>
					<div class="coderockz-woo-delivery-card-body">
						<p class="coderockz-woo-delivery-pickup-time-tab-notice"><span class="dashicons dashicons-yes"></span><?php _e(' Settings Changed Successfully', 'woo-delivery'); ?></p>
	                    <form action="" method="post" id ="coderockz_pickup_time_form_submit">
	                        <?php wp_nonce_field('coderockz_woo_delivery_nonce'); ?>

	                    	<div class="coderockz-woo-delivery-form-group">
	                        	<span class="coderockz-woo-delivery-form-label"><?php _e('Enable Pickup Time', 'woo-delivery'); ?></span>
	                        	<p class="coderockz-woo-delivery-tooltip" tooltip="Enable Pickup Time select field in woocommerce order checkout page."><span class="dashicons dashicons-editor-help"></span></p>
							    <label class="coderockz-woo-delivery-toogle-switch" for="coderockz_enable_pickup_time">
							       <input type="checkbox" name="coderockz_enable_pickup_time" id="coderockz_enable_pickup_time" <?php echo (isset($pickup_time_settings['enable_pickup_time']) && !empty($pickup_time_settings['enable_pickup_time'])) ? "checked" : "" ?>/>
							       <div class="coderockz-woo-delivery-toogle-slider coderockz-woo-delivery-toogle-round"></div>
							    </label>
	                    	</div>
	                    	<div class="coderockz-woo-delivery-form-group">
	                        	<span class="coderockz-woo-delivery-form-label"><?php _e('Make Pickup Time Field Mandatory', 'woo-delivery'); ?></span>
	                        	<p class="coderockz-woo-delivery-tooltip" tooltip="Make Pickup Time select field mandatory in woocommerce order checkout page. Default is optional."><span class="dashicons dashicons-editor-help"></span></p>
							    <label class="coderockz-woo-delivery-toogle-switch" for="coderockz_pickup_time_mandatory">
							       <input type="checkbox" name="coderockz_pickup_time_mandatory" id="coderockz_pickup_time_mandatory" <?php echo (isset($pickup_time_settings['pickup_time_mandatory']) && !empty($pickup_time_settings['pickup_time_mandatory'])) ? "checked" : "" ?>/>
							       <div class="coderockz-woo-delivery-toogle-slider coderockz-woo-delivery-toogle-round"></div>
							    </label>
	                    	</div>
	                    	<div class="coderockz-woo-delivery-form-group">
	                    		<label class="coderockz-woo-delivery-form-label" for="coderockz_pickup_time_field_label"><?php _e('Pickup Time Field Label', 'woo-delivery'); ?></label>
	                    		<p class="coderockz-woo-delivery-tooltip" tooltip="Pickup Time select field heading. Default is Pickup Time."><span class="dashicons dashicons-editor-help"></span></p>
	                        	<input id="coderockz_pickup_time_field_label" name="coderockz_pickup_time_field_label" type="text" class="coderockz-woo-delivery-input-field" value="<?php echo (isset($pickup_time_settings['field_label']) && !empty($pickup_time_settings['field_label'])) ? stripslashes(esc_attr($pickup_time_settings['field_label'])) : "" ?>" placeholder="" autocomplete="off"/>
	                    	</div>
	                    	<?php 
                    			$pickup_start_hour = "";
            					$pickup_start_min = "";
            					$pickup_start_format= "am";
                    			
                    			if(isset($pickup_time_settings['pickup_time_starts']) && $pickup_time_settings['pickup_time_starts'] !='') {
                    				$pickup_time_starts = (int)$pickup_time_settings['pickup_time_starts'];

                    				if($pickup_time_starts == 0) {
		            					$pickup_start_hour = "12";
		            					$pickup_start_min = "00";
		            					$pickup_start_format= "am";
		            				} elseif($pickup_time_starts > 0 && $pickup_time_starts <= 59) {

                    					$pickup_start_hour = "12";
                    					$pickup_start_min = sprintf("%02d", $pickup_time_starts);
                    					$pickup_start_format= "am";
                    				} elseif($pickup_time_starts > 59 && $pickup_time_starts <= 719) {
										$pickup_start_min = sprintf("%02d", (int)$pickup_time_starts%60);
										$pickup_start_hour = sprintf("%02d", ((int)$pickup_time_starts-$pickup_start_min)/60);
										$pickup_start_format= "am";
										
                    				} else {
										$pickup_start_min = sprintf("%02d", (int)$pickup_time_starts%60);
										$pickup_start_hour = sprintf("%02d", ((int)$pickup_time_starts-$pickup_start_min)/60);
										if($pickup_start_hour>12) {
											$pickup_start_hour = sprintf("%02d", $pickup_start_hour-12);
										}
										$pickup_start_format= "pm";
                    				}

                    			}
                    		?>
	                    	<div class="coderockz-woo-delivery-form-group">
	                    		<label class="coderockz-woo-delivery-form-label" for="coderockz_pickup_time_slot_starts"><?php _e('Pickup Time Slot Starts From', 'woo-delivery'); ?></label>
	                    		<p class="coderockz-woo-delivery-tooltip" tooltip="Pickup Time starts from the time that is specified here. Only numerical value is accepted."><span class="dashicons dashicons-editor-help"></span></p>
	                    		<div id="coderockz_pickup_time_slot_starts" class="coderockz_pickup_time_slot_starts">
	                    			
	                        	<input name="coderockz_pickup_time_slot_starts_hour" type="number" class="coderockz-woo-delivery-number-field" max="12" min="1" onkeyup="if(!Number.isInteger(Number(this.value)) || this.value > 12 || this.value < 1) this.value = null;" value="<?php echo $pickup_start_hour; ?>" placeholder="Hour" autocomplete="off"/>
	                        	<input name="coderockz_pickup_time_slot_starts_min" type="number" class="coderockz-woo-delivery-number-field" max="59" min="0" onkeyup="if(!Number.isInteger(Number(this.value)) || this.value > 59 || this.value < 0) this.value = null;" value="<?php echo $pickup_start_min; ?>" placeholder="Minute" autocomplete="off"/>
	                        	<select class="coderockz-woo-delivery-select-field" name="coderockz_pickup_time_slot_starts_format">
									<option value="am" <?php selected($pickup_start_format,"am",true); ?>>AM</option>
									<option value="pm" <?php selected($pickup_start_format,"pm",true); ?>>PM</option>
								</select>
	                        	</div>
	                    	</div>
	                    	<?php 
                    			$pickup_end_hour = "";
            					$pickup_end_min = "";
            					$pickup_end_format= "am";
                    			
                    			if(isset($pickup_time_settings['pickup_time_ends']) && $pickup_time_settings['pickup_time_ends'] !='') {
                    				$pickup_time_ends = (int)$pickup_time_settings['pickup_time_ends'];
                    				if($pickup_time_ends == 0) {
		            					$pickup_end_hour = "12";
		            					$pickup_end_min = "00";
		            					$pickup_end_format= "am";
		            				} elseif($pickup_time_ends > 0 && $pickup_time_ends <= 59) {
                    					$pickup_end_hour = "12";
                    					$pickup_end_min = sprintf("%02d", $pickup_time_ends);
                    					$pickup_end_format= "am";
                    				} elseif($pickup_time_ends > 59 && $pickup_time_ends <= 719) {
										$pickup_end_min = sprintf("%02d", (int)$pickup_time_ends%60);
										$pickup_end_hour = sprintf("%02d", ((int)$pickup_time_ends-$pickup_end_min)/60);
										$pickup_end_format= "am";
										
                    				} elseif($pickup_time_ends > 719 && $pickup_time_ends <= 1439) {
										$pickup_end_min = sprintf("%02d", (int)$pickup_time_ends%60);
										$pickup_end_hour = sprintf("%02d", ((int)$pickup_time_ends-$pickup_end_min)/60);
										if($pickup_end_hour>12) {
											$pickup_end_hour = sprintf("%02d", $pickup_end_hour-12);
										}
										$pickup_end_format= "pm";
                    				} elseif($pickup_time_ends == 1440) {
										$pickup_end_min = "00";
										$pickup_end_hour = "12";
										$pickup_end_format= "am";
                    				}


                    			}
                    		?>
	                    	<div class="coderockz-woo-delivery-form-group">
	                    		<label class="coderockz-woo-delivery-form-label" for="coderockz_delivery_time_slot_ends"><?php _e('Pickup Time Slot Ends At', 'woo-delivery'); ?></label>
	                    		<p class="coderockz-woo-delivery-tooltip" tooltip="Pickup Time ends at the time that is specified here. Only numerical value is accepted."><span class="dashicons dashicons-editor-help"></span></p>
	                    		<div id="coderockz_pickup_time_slot_ends" class="coderockz_pickup_time_slot_ends">
	                        	<input name="coderockz_pickup_time_slot_ends_hour" type="number" class="coderockz-woo-delivery-number-field" max="12" min="1" onkeyup="if(!Number.isInteger(Number(this.value)) || this.value > 12 || this.value < 1) this.value = null;" value="<?php echo $pickup_end_hour; ?>" placeholder="Hour" autocomplete="off"/>
	                        	<input name="coderockz_pickup_time_slot_ends_min" type="number" class="coderockz-woo-delivery-number-field" max="59" min="0" onkeyup="if(!Number.isInteger(Number(this.value)) || this.value > 59 || this.value < 0) this.value = null;" value="<?php echo $pickup_end_min; ?>" placeholder="Minute" autocomplete="off"/>
	                        	<select class="coderockz-woo-delivery-select-field" name="coderockz_pickup_time_slot_ends_format">
									<option value="am" <?php selected($pickup_end_format,"am",true); ?>>AM</option>
									<option value="pm" <?php selected($pickup_end_format,"pm",true); ?>>PM</option>
								</select>
	                        	</div>
	                        	<!-- <p class="coderockz_pickup_end_time_greater_notice">End Time Must after Start Time</p> -->
	                    	</div>
	                    	<?php
	                    		$pickup_duration = ""; 
	                    		$pickup_identity = "min";
                    			if(isset($pickup_time_settings['each_time_slot']) && !empty($pickup_time_settings['each_time_slot'])) {
                    				$pickup_time_slot_duration = (int)$pickup_time_settings['each_time_slot'];
                    				if($pickup_time_slot_duration <= 59) {
                    					$pickup_duration = $pickup_time_slot_duration;
                    				} else {
                    					$pickup_time_slot_duration = $pickup_time_slot_duration/60;
                    					$helper = new Coderockz_Woo_Delivery_Helper();
                    					if($helper->containsDecimal($pickup_time_slot_duration)){
                    						$pickup_duration = $pickup_time_slot_duration*60;
                    						$pickup_identity = "min";
                    					} else {
                    						$pickup_duration = $pickup_time_slot_duration;
                    						$pickup_identity = "hour";
                    					}
                    				}
                    			}
	                    	?>
	                    	<div class="coderockz-woo-delivery-form-group">
	                    		<label class="coderockz-woo-delivery-form-label" for="coderockz_pickup_time_slot_duration"><?php _e('Each Pickup Time Slot Duration', 'woo-delivery'); ?></label>
	                    		<p class="coderockz-woo-delivery-tooltip" tooltip="Each pickup time slot duration that is specified here. Only numerical value is accepted."><span class="dashicons dashicons-editor-help"></span></p>
	                    		<div id="coderockz_pickup_time_slot_duration" class="coderockz_pickup_time_slot_duration">
	                        	<input name="coderockz_pickup_time_slot_duration_time" type="number" min="1" onkeyup="if(!Number.isInteger(Number(this.value)) || this.value < 1) this.value = null;" class="coderockz-woo-delivery-number-field" value="<?php echo $pickup_duration; ?>" placeholder="" autocomplete="off"/>
	                        	<select class="coderockz-woo-delivery-select-field" name="coderockz_pickup_time_slot_duration_format">
									<option value="min" <?php selected($pickup_identity,"min",true); ?>>Minutes</option>
									<option value="hour" <?php selected($pickup_identity,"hour",true); ?>>Hour</option>
								</select>
	                        	</div>
	                    	</div>

	                    	<div class="coderockz-woo-delivery-form-group">
	                    		<label class="coderockz-woo-delivery-form-label" for="coderockz_pickup_time_maximum_order"><?php _e('Maximum Pickup Per Time Slot', 'woo-delivery'); ?></label>
	                    		<p class="coderockz-woo-delivery-tooltip" tooltip="Each time slot take maximum number of pickups that is specified here. After reaching the maximum pickup, the time slot is disabled automaticaly. Only numerical value is accepted. Blank this field means each time slot takes unlimited pickup."><span class="dashicons dashicons-editor-help"></span></p>
	                        	<input id="coderockz_pickup_time_maximum_order" name="coderockz_pickup_time_maximum_order" type="number" class="coderockz-woo-delivery-number-field" min="1" onkeyup="if(!Number.isInteger(Number(this.value)) || this.value < 1) this.value = null;" value="<?php echo (isset($pickup_time_settings['max_pickup_per_slot']) && !empty($pickup_time_settings['max_pickup_per_slot'])) ? stripslashes(esc_attr($pickup_time_settings['max_pickup_per_slot'])) : ""; ?>" placeholder="" autocomplete="off"/>
	                    	</div>

	                    	<div class="coderockz-woo-delivery-form-group">
	                    		<label class="coderockz-woo-delivery-form-label" for="coderockz_pickup_time_format"><?php _e('Pickup Time format', 'woo-delivery'); ?></label>
	                    		<p class="coderockz-woo-delivery-tooltip" tooltip="Time format that is used in everywhere which is available by this plugin. Default is 12 Hours."><span class="dashicons dashicons-editor-help"></span></p>
	                    		<select class="coderockz-woo-delivery-select-field" name="coderockz_pickup_time_format">

	                    			<option value="" <?php if(isset($pickup_time_settings['time_format']) && $pickup_time_settings['time_format'] == ""){ echo "selected"; } ?>><?php _e('Select Time Format', 'woo-delivery'); ?></option>
									<option value="12" <?php if(isset($pickup_time_settings['time_format']) && $pickup_time_settings['time_format'] == "12"){ echo "selected"; } ?>>12 Hours</option>
									<option value="24" <?php if(isset($pickup_time_settings['time_format']) && $pickup_time_settings['time_format'] == "24"){ echo "selected"; } ?>>24 Hours</option>
								</select>
	                    	</div>

	                    	<div class="coderockz-woo-delivery-form-group">
	                        	<span class="coderockz-woo-delivery-form-label"><?php _e('Disable Current Time Slot', 'woo-delivery'); ?></span>
	                        	<p class="coderockz-woo-delivery-tooltip" tooltip="Make the time slot disabled that has the current time. In default, the time slot isn't disabled that has the current time."><span class="dashicons dashicons-editor-help"></span></p>
							    <label class="coderockz-woo-delivery-toogle-switch" for="coderockz_pickup_time_disable_current_time_slot">
							       <input type="checkbox" name="coderockz_pickup_time_disable_current_time_slot" id="coderockz_pickup_time_disable_current_time_slot" <?php echo (isset($pickup_time_settings['disabled_current_pickup_time_slot']) && !empty($pickup_time_settings['disabled_current_pickup_time_slot'])) ? "checked" : "" ?>/>
							       <div class="coderockz-woo-delivery-toogle-slider coderockz-woo-delivery-toogle-round"></div>
							    </label>
	                    	</div>
	                    	<div class="coderockz-woo-delivery-form-group">
	                        	<span class="coderockz-woo-delivery-form-label"><?php _e('Auto Select 1st Available Time', 'woo-delivery'); ?></span>
	                        	<p class="coderockz-woo-delivery-tooltip" tooltip="Enable the option if you want to select the first available time based on date automatically and shown in the pickup time field. Default is disable."><span class="dashicons dashicons-editor-help"></span></p>
							    <label class="coderockz-woo-delivery-toogle-switch" for="coderockz_auto_select_first_pickup_time">
							       <input type="checkbox" name="coderockz_auto_select_first_pickup_time" id="coderockz_auto_select_first_pickup_time" <?php echo (isset(get_option('coderockz_woo_delivery_pickup_settings')['auto_select_first_time']) && !empty(get_option('coderockz_woo_delivery_pickup_settings')['auto_select_first_time'])) ? "checked" : "" ?>/>
							       <div class="coderockz-woo-delivery-toogle-slider coderockz-woo-delivery-toogle-round"></div>
							    </label>
	                    	</div>
	                        <input class="coderockz-woo-delivery-submit-btn" type="submit" name="coderockz_pickup_time_form_submit" value="<?php _e('Save Changes', 'woo-delivery'); ?>" />

	                    </form>
                	</div>

                </div>
			</div>
			<div data-tab="tab8" class="coderockz-woo-delivery-tabcontent">
				<div class="coderockz-woo-delivery-card">
					<p class="coderockz-woo-delivery-card-header"><?php _e('Localization', 'woo-delivery'); ?></p>
					<div class="coderockz-woo-delivery-card-body">
						<p class="coderockz-woo-delivery-localization-settings-notice"><span class="dashicons dashicons-yes"></span><?php _e(' Settings Changed Successfully', 'woo-delivery'); ?></p>
	                    <form action="" method="post" id ="coderockz_delivery_localization_settings_form_submit">
	                        <?php wp_nonce_field('coderockz_woo_delivery_nonce'); ?>

	                        <div class="coderockz-woo-delivery-form-group">
	                    		<label class="coderockz-woo-delivery-form-label" for="coderockz_woo_delivery_order_limit_notice"><?php _e('Maximum Delivery Limit Exceed', 'woo-delivery'); ?></label>
	                    		<p class="coderockz-woo-delivery-tooltip" tooltip="Maximum delivery limit notice. Default is Maximum delivery limit exceed."><span class="dashicons dashicons-editor-help"></span></p>
	                        	<input id="coderockz_woo_delivery_order_limit_notice" name="coderockz_woo_delivery_order_limit_notice" type="text" class="coderockz-woo-delivery-input-field" value="<?php echo (isset(get_option('coderockz_woo_delivery_localization_settings')['order_limit_notice']) && !empty(get_option('coderockz_woo_delivery_localization_settings')['order_limit_notice'])) ? get_option('coderockz_woo_delivery_localization_settings')['order_limit_notice'] : "" ?>" placeholder="" autocomplete="off"/>
	                    	</div>
	                    	<div class="coderockz-woo-delivery-form-group">
	                    		<label class="coderockz-woo-delivery-form-label" for="coderockz_woo_delivery_pickup_limit_notice"><?php _e('Maximum Pickup Limit Exceed', 'woo-delivery'); ?></label>
	                    		<p class="coderockz-woo-delivery-tooltip" tooltip="Maximum pickup limit notice. Default is Maximum pickup limit exceed."><span class="dashicons dashicons-editor-help"></span></p>
	                        	<input id="coderockz_woo_delivery_pickup_limit_notice" name="coderockz_woo_delivery_pickup_limit_notice" type="text" class="coderockz-woo-delivery-input-field" value="<?php echo (isset(get_option('coderockz_woo_delivery_localization_settings')['pickup_limit_notice']) && !empty(get_option('coderockz_woo_delivery_localization_settings')['pickup_limit_notice'])) ? stripslashes(esc_attr(get_option('coderockz_woo_delivery_localization_settings')['pickup_limit_notice'])) : "" ?>" placeholder="" autocomplete="off"/>
	                    	</div>
	                    	<div class="coderockz-woo-delivery-form-group">
	                    		<label class="coderockz-woo-delivery-form-label" for="coderockz_woo_delivery_delivery_details_text"><?php _e('Delivery Details', 'woo-delivery'); ?></label>
	                    		<p class="coderockz-woo-delivery-tooltip" tooltip="Delivery Details text in order page, single order page, customer account page. Default is Delivery Details."><span class="dashicons dashicons-editor-help"></span></p>
	                        	<input id="coderockz_woo_delivery_delivery_details_text" name="coderockz_woo_delivery_delivery_details_text" type="text" class="coderockz-woo-delivery-input-field" value="<?php echo (isset(get_option('coderockz_woo_delivery_localization_settings')['delivery_details_text']) && !empty(get_option('coderockz_woo_delivery_localization_settings')['delivery_details_text'])) ? get_option('coderockz_woo_delivery_localization_settings')['delivery_details_text'] : "" ?>" placeholder="" autocomplete="off"/>
	                    	</div>

	                    	<div class="coderockz-woo-delivery-form-group">
	                    		<label class="coderockz-woo-delivery-form-label" for="coderockz_woo_delivery_order_metabox_heading"><?php _e('Single Order Page Metabox Heading', 'woo-delivery'); ?></label>
	                    		<p class="coderockz-woo-delivery-tooltip" tooltip="Single order page metabox heading text. Default is Delivery Date & Time."><span class="dashicons dashicons-editor-help"></span></p>
	                        	<input id="coderockz_woo_delivery_order_metabox_heading" name="coderockz_woo_delivery_order_metabox_heading" type="text" class="coderockz-woo-delivery-input-field" value="<?php echo (isset(get_option('coderockz_woo_delivery_localization_settings')['order_metabox_heading']) && !empty(get_option('coderockz_woo_delivery_localization_settings')['order_metabox_heading'])) ? get_option('coderockz_woo_delivery_localization_settings')['order_metabox_heading'] : "" ?>" placeholder="" autocomplete="off"/>
	                    	</div>
	                    	<div class="coderockz-woo-delivery-form-group">
	                    		<label class="coderockz-woo-delivery-form-label" for="coderockz_woo_delivery_checkout_delivery_option_notice"><?php _e('Order Type Checkout Page Notice', 'woo-delivery'); ?></label>
	                    		<p class="coderockz-woo-delivery-tooltip" tooltip="Notice if you make the order type field required but not given any value to the field. Default is Please Select Your Order Type."><span class="dashicons dashicons-editor-help"></span></p>
	                        	<input id="coderockz_woo_delivery_checkout_delivery_option_notice" name="coderockz_woo_delivery_checkout_delivery_option_notice" type="text" class="coderockz-woo-delivery-input-field" value="<?php echo (isset(get_option('coderockz_woo_delivery_localization_settings')['checkout_delivery_option_notice']) && !empty(get_option('coderockz_woo_delivery_localization_settings')['checkout_delivery_option_notice'])) ? get_option('coderockz_woo_delivery_localization_settings')['checkout_delivery_option_notice'] : "" ?>" placeholder="" autocomplete="off"/>
	                    	</div>
	                    	<div class="coderockz-woo-delivery-form-group">
	                    		<label class="coderockz-woo-delivery-form-label" for="coderockz_woo_delivery_checkout_date_notice"><?php _e('Delivery Date Checkout Page Notice', 'woo-delivery'); ?></label>
	                    		<p class="coderockz-woo-delivery-tooltip" tooltip="Notice if you make the delivery date field required but not given any value to the field. Default is Please Enter Delivery Date."><span class="dashicons dashicons-editor-help"></span></p>
	                        	<input id="coderockz_woo_delivery_checkout_date_notice" name="coderockz_woo_delivery_checkout_date_notice" type="text" class="coderockz-woo-delivery-input-field" value="<?php echo (isset(get_option('coderockz_woo_delivery_localization_settings')['checkout_date_notice']) && !empty(get_option('coderockz_woo_delivery_localization_settings')['checkout_date_notice'])) ? get_option('coderockz_woo_delivery_localization_settings')['checkout_date_notice'] : "" ?>" placeholder="" autocomplete="off"/>
	                    	</div>
	                    	<div class="coderockz-woo-delivery-form-group">
	                    		<label class="coderockz-woo-delivery-form-label" for="coderockz_woo_delivery_checkout_pickup_date_notice"><?php _e('Pickup Date Checkout Page Notice', 'woo-delivery'); ?></label>
	                    		<p class="coderockz-woo-delivery-tooltip" tooltip="Notice if you make the pickup date field required but not given any value to the field. Default is Please Enter Pickup Date."><span class="dashicons dashicons-editor-help"></span></p>
	                        	<input id="coderockz_woo_delivery_checkout_pickup_date_notice" name="coderockz_woo_delivery_checkout_pickup_date_notice" type="text" class="coderockz-woo-delivery-input-field" value="<?php echo (isset(get_option('coderockz_woo_delivery_localization_settings')['checkout_pickup_date_notice']) && !empty(get_option('coderockz_woo_delivery_localization_settings')['checkout_pickup_date_notice'])) ? stripslashes(esc_attr(get_option('coderockz_woo_delivery_localization_settings')['checkout_pickup_date_notice'])) : "" ?>" placeholder="" autocomplete="off"/>
	                    	</div>
	                    	<div class="coderockz-woo-delivery-form-group">
	                    		<label class="coderockz-woo-delivery-form-label" for="coderockz_woo_delivery_checkout_time_notice"><?php _e('Delivery Time Checkout Page Notice', 'woo-delivery'); ?></label>
	                    		<p class="coderockz-woo-delivery-tooltip" tooltip="Notice if you make the delivery time field required but not given any value to the field. Default is Please Enter Delivery Time."><span class="dashicons dashicons-editor-help"></span></p>
	                        	<input id="coderockz_woo_delivery_checkout_time_notice" name="coderockz_woo_delivery_checkout_time_notice" type="text" class="coderockz-woo-delivery-input-field" value="<?php echo (isset(get_option('coderockz_woo_delivery_localization_settings')['checkout_time_notice']) && !empty(get_option('coderockz_woo_delivery_localization_settings')['checkout_time_notice'])) ? get_option('coderockz_woo_delivery_localization_settings')['checkout_time_notice'] : "" ?>" placeholder="" autocomplete="off"/>
	                    	</div>
	                    	<div class="coderockz-woo-delivery-form-group">
	                    		<label class="coderockz-woo-delivery-form-label" for="coderockz_woo_delivery_checkout_pickup_time_notice"><?php _e('Pickup Time Checkout Page Notice', 'woo-delivery'); ?></label>
	                    		<p class="coderockz-woo-delivery-tooltip" tooltip="Notice if you make the pickup time field required but not given any value to the field. Default is Please Enter Pickup Time."><span class="dashicons dashicons-editor-help"></span></p>
	                        	<input id="coderockz_woo_delivery_checkout_pickup_time_notice" name="coderockz_woo_delivery_checkout_pickup_time_notice" type="text" class="coderockz-woo-delivery-input-field" value="<?php echo (isset(get_option('coderockz_woo_delivery_localization_settings')['checkout_pickup_time_notice']) && !empty(get_option('coderockz_woo_delivery_localization_settings')['checkout_pickup_time_notice'])) ? stripslashes(esc_attr(get_option('coderockz_woo_delivery_localization_settings')['checkout_pickup_time_notice'])) : "" ?>" placeholder="" autocomplete="off"/>
	                    	</div>
	                        <input class="coderockz-woo-delivery-submit-btn" type="submit" name="coderockz_delivery_localization_settings_form_submit" value="<?php _e('Save Changes', 'woo-delivery'); ?>" />

	                    </form>
                	</div>

                </div>
			</div>
			<div data-tab="tab9" class="coderockz-woo-delivery-tabcontent">
				<div class="coderockz-woo-delivery-card">
					<p class="coderockz-woo-delivery-card-header"><?php _e('Other Settings', 'woo-delivery'); ?></p>
					<div class="coderockz-woo-delivery-card-body">
						<p class="coderockz-woo-delivery-other-settings-notice"><span class="dashicons dashicons-yes"></span><?php _e(' Settings Changed Successfully', 'woo-delivery'); ?></p>
	                    <form action="" method="post" id ="coderockz_delivery_other_settings_form_submit">
	                        <?php wp_nonce_field('coderockz_woo_delivery_nonce'); ?>

	                        <div class="coderockz-woo-delivery-form-group">
	                        	<span class="coderockz-woo-delivery-form-label"><?php _e('Show Plugin Module For Virtual/Downloadable Products', 'coderockz-woo-delivery'); ?></span>
	                        	<p class="coderockz-woo-delivery-tooltip" tooltip="<?php _e("Enable the delivery fields if there is any virtual or downloadable products in the cart. Default is disable.", 'coderockz-woo-delivery'); ?>"><span class="dashicons dashicons-editor-help"></span></p>
							    <label class="coderockz-woo-delivery-toogle-switch" for="coderockz_disable_fields_for_downloadable_products">
							       <input type="checkbox" name="coderockz_disable_fields_for_downloadable_products" id="coderockz_disable_fields_for_downloadable_products" <?php echo (isset($other_settings['disable_fields_for_downloadable_products']) && !empty($other_settings['disable_fields_for_downloadable_products'])) ? "checked" : "" ?>/>
							       <div class="coderockz-woo-delivery-toogle-slider coderockz-woo-delivery-toogle-round"></div>
							    </label>
	                    	</div>
	                    	<div class="coderockz-woo-delivery-form-group">
	                        	<span class="coderockz-woo-delivery-form-label"><?php _e('Show Plugin Module For (Virtual/Downloadable + Regular) Products', 'coderockz-woo-delivery'); ?></span>
	                        	<p class="coderockz-woo-delivery-tooltip" tooltip="<?php _e("Enable the delivery fields if there is any virtual/downloadable products as well as regular products in the cart. Default is disable.", 'coderockz-woo-delivery'); ?>"><span class="dashicons dashicons-editor-help"></span></p>
							    <label class="coderockz-woo-delivery-toogle-switch" for="coderockz_disable_fields_for_downloadable_regular_products">
							       <input type="checkbox" name="coderockz_disable_fields_for_downloadable_regular_products" id="coderockz_disable_fields_for_downloadable_regular_products" <?php echo (isset($other_settings['disable_fields_for_downloadable_regular_products']) && !empty($other_settings['disable_fields_for_downloadable_regular_products'])) ? "checked" : "" ?>/>
							       <div class="coderockz-woo-delivery-toogle-slider coderockz-woo-delivery-toogle-round"></div>
							    </label>
	                    	</div>

	                    	<div class="coderockz-woo-delivery-form-group">
	                    		<label class="coderockz-woo-delivery-form-label" for="coderockz_woo_delivery_delivery_heading_checkout" style="display:unset!important"><?php _e('Heading On The Checkout Page', 'woo-delivery'); ?></label>
	                    		<p class="coderockz-woo-delivery-tooltip" tooltip="Checkout heading text of delivery section. Default is Delivery Information."><span class="dashicons dashicons-editor-help"></span></p>
	                        	<input id="coderockz_woo_delivery_delivery_heading_checkout" name="coderockz_woo_delivery_delivery_heading_checkout" type="text" class="coderockz-woo-delivery-input-field" value="<?php echo (isset($other_settings['delivery_heading_checkout']) && !empty($other_settings['delivery_heading_checkout'])) ? stripslashes(esc_attr($other_settings['delivery_heading_checkout'])) : "" ?>" placeholder="" autocomplete="off"/>
	                    	</div>

	                        <?php if(WC_Blocks_Utils::has_block_in_page( wc_get_page_id('checkout'), 'woocommerce/checkout' )) { ?>

		                    	<div class="coderockz-woo-delivery-form-group">
		                    		<label class="coderockz-woo-delivery-form-label" for="coderockz_delivery_time_format"><?php _e('Field Position', 'coderockz-woo-delivery'); ?></label>
		                    		<p class="coderockz-woo-delivery-tooltip" tooltip="<?php _e("Position of all the fields that are enabled by this plugin. Default is after order notes.", 'coderockz-woo-delivery'); ?>"><span class="dashicons dashicons-editor-help"></span></p>
		                    		<select class="coderockz-woo-delivery-select-field" name="coderockz_woo_delivery_block_field_position">
		                    			<option value="" <?php if(isset($other_settings['block_field_position']) && $other_settings['block_field_position'] == ""){ echo "selected"; } ?>><?php _e('Select Position', 'coderockz-woo-delivery'); ?></option>
										<option value="contact-information" <?php if(isset($other_settings['block_field_position']) && $other_settings['block_field_position'] == "contact-information"){ echo "selected"; } ?>><?php _e('After Contact Information Section', 'coderockz-woo-delivery'); ?></option>
										<option value="shipping-address" <?php if(isset($other_settings['block_field_position']) && $other_settings['block_field_position'] == "shipping-address"){ echo "selected"; } ?>><?php _e('After Shipping Address Section', 'coderockz-woo-delivery'); ?></option>
										<option value="billing-address" <?php if(isset($other_settings['block_field_position']) && $other_settings['block_field_position'] == "billing-address"){ echo "selected"; } ?>><?php _e('After Billing Address Section', 'coderockz-woo-delivery'); ?></option>

									</select>
		                    	</div>
	                        
	                    	<?php } else {?>
	                    		<div class="coderockz-woo-delivery-form-group">
		                    		<label class="coderockz-woo-delivery-form-label" for="coderockz_delivery_time_format"><?php _e('Field Position', 'coderockz-woo-delivery'); ?></label>
		                    		<p class="coderockz-woo-delivery-tooltip" tooltip="<?php _e("Position of all the fields that are enabled by this plugin. Default is after order notes.", 'coderockz-woo-delivery'); ?>"><span class="dashicons dashicons-editor-help"></span></p>
		                    		<select class="coderockz-woo-delivery-select-field" name="coderockz_woo_delivery_field_position">
		                    			<option value="" <?php if(isset($other_settings['field_position']) && $other_settings['field_position'] == ""){ echo "selected"; } ?>><?php _e('Select Position', 'coderockz-woo-delivery'); ?></option>
										<option value="before_billing" <?php if(isset($other_settings['field_position']) && $other_settings['field_position'] == "before_billing"){ echo "selected"; } ?>><?php _e('Before Billing Address', 'coderockz-woo-delivery'); ?></option>
										<option value="after_billing" <?php if(isset($other_settings['field_position']) && $other_settings['field_position'] == "after_billing"){ echo "selected"; } ?>><?php _e('After Billing Address', 'coderockz-woo-delivery'); ?></option>
										<option value="before_shipping" <?php if(isset($other_settings['field_position']) && $other_settings['field_position'] == "before_shipping"){ echo "selected"; } ?>><?php _e('Before Shipping Address', 'coderockz-woo-delivery'); ?></option>
										<option value="after_shipping" <?php if(isset($other_settings['field_position']) && $other_settings['field_position'] == "after_shipping"){ echo "selected"; } ?>><?php _e('After Shipping Address', 'coderockz-woo-delivery'); ?></option>
										<option value="before_notes" <?php if(isset($other_settings['field_position']) && $other_settings['field_position'] == "before_notes"){ echo "selected"; } ?>><?php _e('Before Order Notes', 'coderockz-woo-delivery'); ?></option>
										<option value="after_notes" <?php if(isset($other_settings['field_position']) && $other_settings['field_position'] == "after_notes"){ echo "selected"; } ?>><?php _e('After Order Notes', 'coderockz-woo-delivery'); ?></option>
										<option value="before_payment" <?php if(isset($other_settings['field_position']) && $other_settings['field_position'] == "before_payment"){ echo "selected"; } ?>><?php _e('Between Your Order And Payment Section', 'coderockz-woo-delivery'); ?></option>
										<option value="before_your_order" <?php if(isset($other_settings['field_position']) && $other_settings['field_position'] == "before_your_order"){ echo "selected"; } ?>><?php _e('Before Your Order Section', 'coderockz-woo-delivery'); ?></option>
										<option value="before_customer_details" <?php if(isset($other_settings['field_position']) && $other_settings['field_position'] == "before_customer_details"){ echo "selected"; } ?>><?php _e('Before Customer Details', 'coderockz-woo-delivery'); ?></option>
									</select>
	                    		</div>
	                    	<?php } ?>
	                    	<div class="coderockz-woo-delivery-form-group">
	                    		<label class="coderockz-woo-delivery-form-label" style="display:unset!important"><?php _e('Custom CSS', 'woo-delivery'); ?></label>
	                    		<p class="coderockz-woo-delivery-tooltip" tooltip="If you want some custom css to avoid the plugin/theme conflict, put the css code here."><span class="dashicons dashicons-editor-help"></span></p>
	                        	<textarea id="coderockz_woo_delivery_code_editor_css" name="coderockz_woo_delivery_code_editor_css" class="coderockz-woo-delivery-textarea-field" placeholder="" autocomplete="off"><?php echo (isset($other_settings['custom_css']) && !empty($other_settings['custom_css'])) ? stripslashes(esc_attr($other_settings['custom_css'])) : "" ?>
                                </textarea>
	                    	</div>

	                        <input class="coderockz-woo-delivery-submit-btn" type="submit" name="coderockz_delivery_other_settings_form_submit" value="<?php _e('Save Changes', 'woo-delivery'); ?>" />

	                    </form>
                	</div>

                </div>
			</div>
			<div data-tab="tab10" class="coderockz-woo-delivery-tabcontent">
				<div class="coderockz-woo-delivery-card" style="box-sizing: border-box;padding: 30px 0 30px 30px;">
					<table width="100%">
					    <tr >
					        <th style="padding: 20px 20px 20px 10px;font-size: 18px;text-align: left;" width="50%">Features</th>
					        <th width="25%" style="text-align: center;font-size:18px">Free</th>
					        <th width="25%" style="text-align: center;font-size:18px">PRO</th>
					    </tr>
					    <tr>
					        <td class="coderockz-woo-delivery-proFree-feature">Block Checkout Page Compatibility</td>
					        <td class="coderockz-woo-delivery-proFree-free"><span class="dashicons dashicons-yes"></span></td>
					        <td class="coderockz-woo-delivery-proFree-pro"><span class="dashicons dashicons-yes"></span></td>
					    </tr>
					    <tr>
					        <td class="coderockz-woo-delivery-proFree-feature">HPOS Compatibility</td>
					        <td class="coderockz-woo-delivery-proFree-free"><span class="dashicons dashicons-yes"></span></td>
					        <td class="coderockz-woo-delivery-proFree-pro"><span class="dashicons dashicons-yes"></span></td>
					    </tr>
					    <tr>
					        <td class="coderockz-woo-delivery-proFree-feature">Hide Shipping Address Section for Pickup</td>
					        <td class="coderockz-woo-delivery-proFree-free"><span class="dashicons dashicons-no-alt"></span></td>
					        <td class="coderockz-woo-delivery-proFree-pro"><span class="dashicons dashicons-yes"></span></td>
					    </tr>
					    <tr>
					        <td class="coderockz-woo-delivery-proFree-feature">Disable same day Delivery/Pickup</td>
					        <td class="coderockz-woo-delivery-proFree-free"><span class="dashicons dashicons-no-alt"></span></td>
					        <td class="coderockz-woo-delivery-proFree-pro"><span class="dashicons dashicons-yes"></span></td>
					    </tr>
					    <tr>
					        <td class="coderockz-woo-delivery-proFree-feature">Delivery Date</td>
					        <td class="coderockz-woo-delivery-proFree-free"><span class="dashicons dashicons-yes"></span></td>
					        <td class="coderockz-woo-delivery-proFree-pro"><span class="dashicons dashicons-yes"></span></td>
					    </tr>
					    <tr>
					        <td class="coderockz-woo-delivery-proFree-feature">Delivery Time</td>
					        <td class="coderockz-woo-delivery-proFree-free"><span class="dashicons dashicons-yes"></span></td>
					        <td class="coderockz-woo-delivery-proFree-pro"><span class="dashicons dashicons-yes"></span></td>
					    </tr>
					    <tr>
					        <td class="coderockz-woo-delivery-proFree-feature">Individual Pickup Date</td>
					        <td class="coderockz-woo-delivery-proFree-free"><span class="dashicons dashicons-yes"></span></td>
					        <td class="coderockz-woo-delivery-proFree-pro"><span class="dashicons dashicons-yes"></span></td>
					    </tr>
					    <tr>
					        <td class="coderockz-woo-delivery-proFree-feature">Individual Pickup Time</td>
					        <td class="coderockz-woo-delivery-proFree-free"><span class="dashicons dashicons-yes"></span></td>
					        <td class="coderockz-woo-delivery-proFree-pro"><span class="dashicons dashicons-yes"></span></td>
					    </tr>
					    <tr>
					        <td class="coderockz-woo-delivery-proFree-feature">Option for Selecting Home Delivery or Self Pickup</td>
					        <td class="coderockz-woo-delivery-proFree-free"><span class="dashicons dashicons-yes"></span></td>
					        <td class="coderockz-woo-delivery-proFree-pro"><span class="dashicons dashicons-yes"></span></td>
					    </tr>
					    <tr>
					        <td class="coderockz-woo-delivery-proFree-feature">Holidays</td>
					        <td class="coderockz-woo-delivery-proFree-free"><span class="dashicons dashicons-yes"></span></td>
					        <td class="coderockz-woo-delivery-proFree-pro"><span class="dashicons dashicons-yes"></span></td>
					    </tr>
					    <tr>
					        <td class="coderockz-woo-delivery-proFree-feature">Plugin Field Position</td>
					        <td class="coderockz-woo-delivery-proFree-free"><span class="dashicons dashicons-yes"></span></td>
					        <td class="coderockz-woo-delivery-proFree-pro"><span class="dashicons dashicons-yes"></span></td>
					    </tr>
					    <tr>
					        <td class="coderockz-woo-delivery-proFree-feature">Wide variety of Plugin Field Position</td>
					        <td class="coderockz-woo-delivery-proFree-free"><span class="dashicons dashicons-no-alt"></span></td>
					        <td class="coderockz-woo-delivery-proFree-pro"><span class="dashicons dashicons-yes"></span></td>
					    </tr>
					    <tr>
					        <td class="coderockz-woo-delivery-proFree-feature">All Texts are Translatable</td>
					        <td class="coderockz-woo-delivery-proFree-free"><span class="dashicons dashicons-yes"></span></td>
					        <td class="coderockz-woo-delivery-proFree-pro"><span class="dashicons dashicons-yes"></span></td>
					    </tr>
					    <tr>
					        <td class="coderockz-woo-delivery-proFree-feature">Change Delivery Details from Order Page</td>
					        <td class="coderockz-woo-delivery-proFree-free"><span class="dashicons dashicons-yes"></span></td>
					        <td class="coderockz-woo-delivery-proFree-pro"><span class="dashicons dashicons-yes"></span></td>
					    </tr>
					    <tr>
					        <td class="coderockz-woo-delivery-proFree-feature">Pickup Location</td>
					        <td class="coderockz-woo-delivery-proFree-free"><span class="dashicons dashicons-no-alt"></span></td>
					        <td class="coderockz-woo-delivery-proFree-pro"><span class="dashicons dashicons-yes"></span></td>
					    </tr>
					    <tr>
					        <td class="coderockz-woo-delivery-proFree-feature">Separate Holidays for Delivery & Pickup</td>
					        <td class="coderockz-woo-delivery-proFree-free"><span class="dashicons dashicons-no-alt"></span></td>
					        <td class="coderockz-woo-delivery-proFree-pro"><span class="dashicons dashicons-yes"></span></td>
					    </tr>
					    <tr>
					        <td class="coderockz-woo-delivery-proFree-feature">Hide Plugin Module depending on Category/Product/Shipping Method/User Role/Order Amount</td>
					        <td class="coderockz-woo-delivery-proFree-free"><span class="dashicons dashicons-no-alt"></span></td>
					        <td class="coderockz-woo-delivery-proFree-pro"><span class="dashicons dashicons-yes"></span></td>
					    </tr>					    
					    <tr>
					        <td class="coderockz-woo-delivery-proFree-feature">Category/product/zone/state/postcode/Shipping method wise offdays</td>
					        <td class="coderockz-woo-delivery-proFree-free"><span class="dashicons dashicons-no-alt"></span></td>
					        <td class="coderockz-woo-delivery-proFree-pro"><span class="dashicons dashicons-yes"></span></td>
					    </tr>
					    <tr>
					        <td class="coderockz-woo-delivery-proFree-feature">Specific dates as offdays for category/product/Shipping Zone</td>
					        <td class="coderockz-woo-delivery-proFree-free"><span class="dashicons dashicons-no-alt"></span></td>
					        <td class="coderockz-woo-delivery-proFree-pro"><span class="dashicons dashicons-yes"></span></td>
					    </tr>
					    <tr>
					        <td class="coderockz-woo-delivery-proFree-feature">Set Specific dates/Weekdays as offdays for Delivery and Pickup individually</td>
					        <td class="coderockz-woo-delivery-proFree-free"><span class="dashicons dashicons-no-alt"></span></td>
					        <td class="coderockz-woo-delivery-proFree-pro"><span class="dashicons dashicons-yes"></span></td>
					    </tr>
					    <tr>
					        <td class="coderockz-woo-delivery-proFree-feature">Current Week Off/Next Week Off/Next Month Off for Certain Category</td>
					        <td class="coderockz-woo-delivery-proFree-free"><span class="dashicons dashicons-no-alt"></span></td>
					        <td class="coderockz-woo-delivery-proFree-pro"><span class="dashicons dashicons-yes"></span></td>
					    </tr>
					    <tr>
					        <td class="coderockz-woo-delivery-proFree-feature">Date Calendar Language</td>
					        <td class="coderockz-woo-delivery-proFree-free"><span class="dashicons dashicons-no-alt"></span></td>
					        <td class="coderockz-woo-delivery-proFree-pro"><span class="dashicons dashicons-yes"></span></td>
					    </tr>
					    <tr>
					        <td class="coderockz-woo-delivery-proFree-feature">Custom Delivery/Pickup Time Slot</td>
					        <td class="coderockz-woo-delivery-proFree-free"><span class="dashicons dashicons-no-alt"></span></td>
					        <td class="coderockz-woo-delivery-proFree-pro"><span class="dashicons dashicons-yes"></span></td>
					    </tr>
					    <tr>
					        <td class="coderockz-woo-delivery-proFree-feature">Hide/Show Timeslot Based on Shipping Zone/State/Postal Code/Shipping Method</td>
					        <td class="coderockz-woo-delivery-proFree-free"><span class="dashicons dashicons-no-alt"></span></td>
					        <td class="coderockz-woo-delivery-proFree-pro"><span class="dashicons dashicons-yes"></span></td>
					    </tr>
					    <tr>
					        <td class="coderockz-woo-delivery-proFree-feature">Ability To Sort Orders Based on Delivery Details on The Woocommerce Orders Page</td>
					        <td class="coderockz-woo-delivery-proFree-free"><span class="dashicons dashicons-no-alt"></span></td>
					        <td class="coderockz-woo-delivery-proFree-pro"><span class="dashicons dashicons-yes"></span></td>
					    </tr>
					    <tr>
					        <td class="coderockz-woo-delivery-proFree-feature">Hide/Show Timeslot Based on Cart Categories/Products</td>
					        <td class="coderockz-woo-delivery-proFree-free"><span class="dashicons dashicons-no-alt"></span></td>
					        <td class="coderockz-woo-delivery-proFree-pro"><span class="dashicons dashicons-yes"></span></td>
					    </tr>
					    <tr>
					        <td class="coderockz-woo-delivery-proFree-feature">Hide Timeslot at a Specific Time</td>
					        <td class="coderockz-woo-delivery-proFree-free"><span class="dashicons dashicons-no-alt"></span></td>
					        <td class="coderockz-woo-delivery-proFree-pro"><span class="dashicons dashicons-yes"></span></td>
					    </tr>
					    <tr>
					        <td class="coderockz-woo-delivery-proFree-feature">Hide Timeslot for Current day</td>
					        <td class="coderockz-woo-delivery-proFree-free"><span class="dashicons dashicons-no-alt"></span></td>
					        <td class="coderockz-woo-delivery-proFree-pro"><span class="dashicons dashicons-yes"></span></td>
					    </tr>
					    <tr>
					        <td class="coderockz-woo-delivery-proFree-feature">Enable Timeslot only for Specific Date</td>
					        <td class="coderockz-woo-delivery-proFree-free"><span class="dashicons dashicons-no-alt"></span></td>
					        <td class="coderockz-woo-delivery-proFree-pro"><span class="dashicons dashicons-yes"></span></td>
					    </tr>
					    <tr>
					        <td class="coderockz-woo-delivery-proFree-feature">Hide/Show Pickup timeslot Based on Pickup Location</td>
					        <td class="coderockz-woo-delivery-proFree-free"><span class="dashicons dashicons-no-alt"></span></td>
					        <td class="coderockz-woo-delivery-proFree-pro"><span class="dashicons dashicons-yes"></span></td>
					    </tr>
					    <tr>
					        <td class="coderockz-woo-delivery-proFree-feature">Time slot with single time</td>
					        <td class="coderockz-woo-delivery-proFree-free"><span class="dashicons dashicons-no-alt"></span></td>
					        <td class="coderockz-woo-delivery-proFree-pro"><span class="dashicons dashicons-yes"></span></td>
					    </tr>
					    <tr>
					        <td class="coderockz-woo-delivery-proFree-feature">Disable same day delivery/pickup</td>
					        <td class="coderockz-woo-delivery-proFree-free"><span class="dashicons dashicons-no-alt"></span></td>
					        <td class="coderockz-woo-delivery-proFree-pro"><span class="dashicons dashicons-yes"></span></td>
					    </tr>
					    <tr>
					        <td class="coderockz-woo-delivery-proFree-feature">Delivery/Pickup Details on a Calendar View</td>
					        <td class="coderockz-woo-delivery-proFree-free"><span class="dashicons dashicons-no-alt"></span></td>
					        <td class="coderockz-woo-delivery-proFree-pro"><span class="dashicons dashicons-yes"></span></td>
					    </tr>
					    <tr>
					        <td class="coderockz-woo-delivery-proFree-feature">WooCommerce shipping methods automatically changed based on Delivey/Pickup</td>
					        <td class="coderockz-woo-delivery-proFree-free"><span class="dashicons dashicons-no-alt"></span></td>
					        <td class="coderockz-woo-delivery-proFree-pro"><span class="dashicons dashicons-yes"></span></td>
					    </tr>
					    <tr>
					        <td class="coderockz-woo-delivery-proFree-feature">Dynamically Enable/Disable Delivery/Pickup Based on WooCommerce Shipping</td>
					        <td class="coderockz-woo-delivery-proFree-free"><span class="dashicons dashicons-no-alt"></span></td>
					        <td class="coderockz-woo-delivery-proFree-pro"><span class="dashicons dashicons-yes"></span></td>
					    </tr>
					    <tr>
					        <td class="coderockz-woo-delivery-proFree-feature">Delivery Tips Option</td>
					        <td class="coderockz-woo-delivery-proFree-free"><span class="dashicons dashicons-no-alt"></span></td>
					        <td class="coderockz-woo-delivery-proFree-pro"><span class="dashicons dashicons-yes"></span></td>
					    </tr>
					    <tr>
					        <td class="coderockz-woo-delivery-proFree-feature">Disable Delivery/Pickup for Specific Days</td>
					        <td class="coderockz-woo-delivery-proFree-free"><span class="dashicons dashicons-no-alt"></span></td>
					        <td class="coderockz-woo-delivery-proFree-pro"><span class="dashicons dashicons-yes"></span></td>
					    </tr>
					    <tr>
					        <td class="coderockz-woo-delivery-proFree-feature">Restrict Delivery/Pickup Option Based on Cart Amount</td>
					        <td class="coderockz-woo-delivery-proFree-free"><span class="dashicons dashicons-no-alt"></span></td>
					        <td class="coderockz-woo-delivery-proFree-pro"><span class="dashicons dashicons-yes"></span></td>
					    </tr>

					    <tr>
					        <td class="coderockz-woo-delivery-proFree-feature">Restrict Delivery/Pickup Option Based on Category/Product</td>
					        <td class="coderockz-woo-delivery-proFree-free"><span class="dashicons dashicons-no-alt"></span></td>
					        <td class="coderockz-woo-delivery-proFree-pro"><span class="dashicons dashicons-yes"></span></td>
					    </tr>
					    <tr>
					        <td class="coderockz-woo-delivery-proFree-feature">Restrict Free Shipping(Cart Amount Base)</td>
					        <td class="coderockz-woo-delivery-proFree-free"><span class="dashicons dashicons-no-alt"></span></td>
					        <td class="coderockz-woo-delivery-proFree-pro"><span class="dashicons dashicons-yes"></span></td>
					    </tr>
					    <tr>
					        <td class="coderockz-woo-delivery-proFree-feature">Hide/Show free shipping only for today or some specific dates or any weekdays</td>
					        <td class="coderockz-woo-delivery-proFree-free"><span class="dashicons dashicons-no-alt"></span></td>
					        <td class="coderockz-woo-delivery-proFree-pro"><span class="dashicons dashicons-yes"></span></td>
					    </tr>
					    <tr>
					        <td class="coderockz-woo-delivery-proFree-feature">Enable/disable Free Shipping only for current date delivery</td>
					        <td class="coderockz-woo-delivery-proFree-free"><span class="dashicons dashicons-no-alt"></span></td>
					        <td class="coderockz-woo-delivery-proFree-pro"><span class="dashicons dashicons-yes"></span></td>
					    </tr>					    
					    <tr>
					        <td class="coderockz-woo-delivery-proFree-feature">Special Open Days</td>
					        <td class="coderockz-woo-delivery-proFree-free"><span class="dashicons dashicons-no-alt"></span></td>
					        <td class="coderockz-woo-delivery-proFree-pro"><span class="dashicons dashicons-yes"></span></td>
					    </tr>
					    <tr>
					        <td class="coderockz-woo-delivery-proFree-feature">Set Category Wise Special Open Days for Delivery and Pickup Individually</td>
					        <td class="coderockz-woo-delivery-proFree-free"><span class="dashicons dashicons-no-alt"></span></td>
					        <td class="coderockz-woo-delivery-proFree-pro"><span class="dashicons dashicons-yes"></span></td>
					    </tr>
					    <tr>
					        <td class="coderockz-woo-delivery-proFree-feature">Delivery Reports with auto sorting</td>
					        <td class="coderockz-woo-delivery-proFree-free"><span class="dashicons dashicons-no-alt"></span></td>
					        <td class="coderockz-woo-delivery-proFree-pro"><span class="dashicons dashicons-yes"></span></td>
					    </tr>
					    <tr>
					        <td class="coderockz-woo-delivery-proFree-feature">Report of Product Quantity</td>
					        <td class="coderockz-woo-delivery-proFree-free"><span class="dashicons dashicons-no-alt"></span></td>
					        <td class="coderockz-woo-delivery-proFree-pro"><span class="dashicons dashicons-yes"></span></td>
					    </tr>
					    <tr>
					        <td class="coderockz-woo-delivery-proFree-feature">One Tab To Control All Deliveries</td>
					        <td class="coderockz-woo-delivery-proFree-free"><span class="dashicons dashicons-no-alt"></span></td>
					        <td class="coderockz-woo-delivery-proFree-pro"><span class="dashicons dashicons-yes"></span></td>
					    </tr>
					    <tr>
					        <td class="coderockz-woo-delivery-proFree-feature">Delivery Reports As Excel Sheet(xlsx format)</td>
					        <td class="coderockz-woo-delivery-proFree-free"><span class="dashicons dashicons-no-alt"></span></td>
					        <td class="coderockz-woo-delivery-proFree-pro"><span class="dashicons dashicons-yes"></span></td>
					    </tr>
					    <tr>
					        <td class="coderockz-woo-delivery-proFree-feature">Product Quantity Reports As Excel Sheet(xlsx format)</td>
					        <td class="coderockz-woo-delivery-proFree-free"><span class="dashicons dashicons-no-alt"></span></td>
					        <td class="coderockz-woo-delivery-proFree-pro"><span class="dashicons dashicons-yes"></span></td>
					    </tr>
					    <tr>
					        <td class="coderockz-woo-delivery-proFree-feature">WooCommerce App Support Using Order Note</td>
					        <td class="coderockz-woo-delivery-proFree-free"><span class="dashicons dashicons-no-alt"></span></td>
					        <td class="coderockz-woo-delivery-proFree-pro"><span class="dashicons dashicons-yes"></span></td>
					    </tr>
					    <tr>
					        <td class="coderockz-woo-delivery-proFree-feature">Filtering and Bulk Action Functionality on WooCommerce Order page </td>
					        <td class="coderockz-woo-delivery-proFree-free"><span class="dashicons dashicons-no-alt"></span></td>
					        <td class="coderockz-woo-delivery-proFree-pro"><span class="dashicons dashicons-yes"></span></td>
					    </tr>
					    
					    <tr>
					        <td class="coderockz-woo-delivery-proFree-feature">Controlling Store closing Time</td>
					        <td class="coderockz-woo-delivery-proFree-free"><span class="dashicons dashicons-no-alt"></span></td>
					        <td class="coderockz-woo-delivery-proFree-pro"><span class="dashicons dashicons-yes"></span></td>
					    </tr>
					    <tr>
					        <td class="coderockz-woo-delivery-proFree-feature">Different Store closing Time for Different Weekdays</td>
					        <td class="coderockz-woo-delivery-proFree-free"><span class="dashicons dashicons-no-alt"></span></td>
					        <td class="coderockz-woo-delivery-proFree-pro"><span class="dashicons dashicons-yes"></span></td>
					    </tr>
					    <tr>
					        <td class="coderockz-woo-delivery-proFree-feature">Disable Current day or Next Day or Further Day After a Certain Time</td>
					        <td class="coderockz-woo-delivery-proFree-free"><span class="dashicons dashicons-no-alt"></span></td>
					        <td class="coderockz-woo-delivery-proFree-pro"><span class="dashicons dashicons-yes"></span></td>
					    </tr>
					    <tr>
					        <td class="coderockz-woo-delivery-proFree-feature">Category wise Cutoff Time</td>
					        <td class="coderockz-woo-delivery-proFree-free"><span class="dashicons dashicons-no-alt"></span></td>
					        <td class="coderockz-woo-delivery-proFree-pro"><span class="dashicons dashicons-yes"></span></td>
					    </tr>
					    <tr>
					        <td class="coderockz-woo-delivery-proFree-feature">Different Processing Days for Delivery and Pickup</td>
					        <td class="coderockz-woo-delivery-proFree-free"><span class="dashicons dashicons-no-alt"></span></td>
					        <td class="coderockz-woo-delivery-proFree-pro"><span class="dashicons dashicons-yes"></span></td>
					    </tr>
					    <tr>
					        <td class="coderockz-woo-delivery-proFree-feature">Category/Product/Weekday/Shipping Zone/Shipping Method Wise Processing Days</td>
					        <td class="coderockz-woo-delivery-proFree-free"><span class="dashicons dashicons-no-alt"></span></td>
					        <td class="coderockz-woo-delivery-proFree-pro"><span class="dashicons dashicons-yes"></span></td>
					    </tr>
					    <tr>
					        <td class="coderockz-woo-delivery-proFree-feature">Different Processing Time for Delivery and Pickup</td>
					        <td class="coderockz-woo-delivery-proFree-free"><span class="dashicons dashicons-no-alt"></span></td>
					        <td class="coderockz-woo-delivery-proFree-pro"><span class="dashicons dashicons-yes"></span></td>
					    </tr>
					    <tr>
					        <td class="coderockz-woo-delivery-proFree-feature">Category/Product/Weekday Wise/Shipping Zone Processing Time</td>
					        <td class="coderockz-woo-delivery-proFree-free"><span class="dashicons dashicons-no-alt"></span></td>
					        <td class="coderockz-woo-delivery-proFree-pro"><span class="dashicons dashicons-yes"></span></td>
					    </tr>
					    <tr>
					        <td class="coderockz-woo-delivery-proFree-feature">Time Slot Fee</td>
					        <td class="coderockz-woo-delivery-proFree-free"><span class="dashicons dashicons-no-alt"></span></td>
					        <td class="coderockz-woo-delivery-proFree-pro"><span class="dashicons dashicons-yes"></span></td>
					    </tr>
					    <tr>
					        <td class="coderockz-woo-delivery-proFree-feature">Deliver Date Fee</td>
					        <td class="coderockz-woo-delivery-proFree-free"><span class="dashicons dashicons-no-alt"></span></td>
					        <td class="coderockz-woo-delivery-proFree-pro"><span class="dashicons dashicons-yes"></span></td>
					    </tr>
					    <tr>
					        <td class="coderockz-woo-delivery-proFree-feature">Weekday wise Delivery Fee</td>
					        <td class="coderockz-woo-delivery-proFree-free"><span class="dashicons dashicons-no-alt"></span></td>
					        <td class="coderockz-woo-delivery-proFree-pro"><span class="dashicons dashicons-yes"></span></td>
					    </tr>
					    <tr>
					        <td class="coderockz-woo-delivery-proFree-feature">Delivery Fee/Shipping Method within X Minutes/Hours</td>
					        <td class="coderockz-woo-delivery-proFree-free"><span class="dashicons dashicons-no-alt"></span></td>
					        <td class="coderockz-woo-delivery-proFree-pro"><span class="dashicons dashicons-yes"></span></td>
					    </tr>
					    <tr>
					        <td class="coderockz-woo-delivery-proFree-feature">Specific Shipping Method Only for First X Days</td>
					        <td class="coderockz-woo-delivery-proFree-free"><span class="dashicons dashicons-no-alt"></span></td>
					        <td class="coderockz-woo-delivery-proFree-pro"><span class="dashicons dashicons-yes"></span></td>
					    </tr>
					    <tr>
					        <td class="coderockz-woo-delivery-proFree-feature">Delivery Date Wise Discount Coupon</td>
					        <td class="coderockz-woo-delivery-proFree-free"><span class="dashicons dashicons-no-alt"></span></td>
					        <td class="coderockz-woo-delivery-proFree-pro"><span class="dashicons dashicons-yes"></span></td>
					    </tr>
					    <tr>
					        <td class="coderockz-woo-delivery-proFree-feature">Additional Field</td>
					        <td class="coderockz-woo-delivery-proFree-free"><span class="dashicons dashicons-no-alt"></span></td>
					        <td class="coderockz-woo-delivery-proFree-pro"><span class="dashicons dashicons-yes"></span></td>
					    </tr>
					    <tr>
					        <td class="coderockz-woo-delivery-proFree-feature">Notify Customer About Delivery Details Changing</td>
					        <td class="coderockz-woo-delivery-proFree-free"><span class="dashicons dashicons-no-alt"></span></td>
					        <td class="coderockz-woo-delivery-proFree-pro"><span class="dashicons dashicons-yes"></span></td>
					    </tr>
					    <tr>
					        <td class="coderockz-woo-delivery-proFree-feature">Laundry Service</td>
					        <td class="coderockz-woo-delivery-proFree-free"><span class="dashicons dashicons-no-alt"></span></td>
					        <td class="coderockz-woo-delivery-proFree-pro"><span class="dashicons dashicons-yes"></span></td>
					    </tr>

					    <tr>
					        <td class="coderockz-woo-delivery-proFree-feature">Google Calendar Sync</td>
					        <td class="coderockz-woo-delivery-proFree-free"><span class="dashicons dashicons-no-alt"></span></td>
					        <td class="coderockz-woo-delivery-proFree-pro"><span class="dashicons dashicons-yes"></span></td>
					    </tr>
					    
					    <tfoot>
					        <tr>
					            <td class="coderockz-woo-delivery-proFree-feature"></td>
					            <td class="coderockz-woo-delivery-proFree-free"></td>
					            <td class="coderockz-woo-delivery-proFree-pro"><a href="https://coderockz.com/downloads/woocommerce-delivery-date-time-wordpress-plugin/" target="_blank" class="coderockz-woo-delivery-buy-now-btn">Buy Now</a></td>
					        </tr>
					    </tfoot>
					</table>
				</div>
			</div>
		</div>
	</div>

</div>

</div>



