<?php

/*
Plugin Name: Meetergo
Plugin URI:  https://meetergo.com
Description: Meetergo integration
Version:     1.0.3
Author:      meetergo
Author URI:  https://webnature.io
License: GPLv2 or later
License URI: http://www.gnu.org/licenses/gpl-2.0.html
*/


class Meetergo {
	private $meetergo_options;

	public function __construct() {
		add_action( 'admin_menu', array( $this, 'meetergo_add_plugin_page' ) );
		add_action( 'admin_init', array( $this, 'meetergo_page_init' ) );
        $plugin = plugin_basename(__FILE__); 
        add_filter("plugin_action_links_$plugin", array($this,'my_plugin_settings_link') );
	}

	public function meetergo_add_plugin_page() {
		add_options_page(
			'meetergo', // page_title
			'meetergo', // menu_title
			'manage_options', // capability
			'meetergo', // menu_slug
			array( $this, 'meetergo_create_admin_page' ) // function
		);
	}

	public function meetergo_create_admin_page() {
		$this->meetergo_options = get_option( 'meetergo_options' ); ?>

		<div class="wrap">
			<h2>meetergo integration</h2>
			<p>Get meetergo company slug at your meetergo company page.</p>
			<?php settings_errors(); ?>

			<form method="post" action="options.php">
				<?php
					settings_fields( 'meetergo_option_group' );
					do_settings_sections( 'meetergo-admin' );
					submit_button();
				?>
			</form>
		</div>
	<?php }

	public function meetergo_page_init() {
		register_setting(
			'meetergo_option_group', // option_group
			'meetergo_options', // option_name
			array( $this, 'meetergo_sanitize' ) // sanitize_callback
		);

		add_settings_section(
			'meetergo_setting_section', // id
			'Settings', // title
			array( $this, 'meetergo_section_info' ), // callback
			'meetergo-admin' // page
		);

		add_settings_field(
			'company_key_0', // id
			'Company key', // title
			array( $this, 'company_key_0_callback' ), // callback
			'meetergo-admin', // page
			'meetergo_setting_section' // section
		);

		add_settings_field(
			'button_color_1', // id
			'Button color', // title
			array( $this, 'button_color_1_callback' ), // callback
			'meetergo-admin', // page
			'meetergo_setting_section' // section
		);

		add_settings_field(
			'button_text_color_2', // id
			'Button text color', // title
			array( $this, 'button_text_color_2_callback' ), // callback
			'meetergo-admin', // page
			'meetergo_setting_section' // section
		);
		add_settings_field(
			'button_text_3', // id
			'Button text', // title
			array( $this, 'button_text_3_callback' ), // callback
			'meetergo-admin', // page
			'meetergo_setting_section' // section
		);

		add_settings_field(
			'button_location_4', // id
			'Button location', // title
			array( $this, 'button_location_4_callback' ), // callback
			'meetergo-admin', // page
			'meetergo_setting_section' // section
		);
	}

	public function meetergo_sanitize($input) {
		$sanitary_values = array();
		if ( isset( $input['company_key_0'] ) ) {
			$sanitary_values['company_key_0'] = sanitize_text_field( $input['company_key_0'] );
		}

		if ( isset( $input['button_color_1'] ) ) {
			$sanitary_values['button_color_1'] = sanitize_text_field( $input['button_color_1'] );
		}

		if ( isset( $input['button_text_color_2'] ) ) {
			$sanitary_values['button_text_color_2'] = sanitize_text_field( $input['button_text_color_2'] );
		}

		if ( isset( $input['button_text_3'] ) ) {
			$sanitary_values['button_text_3'] = sanitize_text_field( $input['button_text_3'] );
		}
 
		if ( isset( $input['button_location_4'] ) ) {
			$sanitary_values['button_location_4'] = sanitize_text_field( $input['button_location_4'] );
		}

		return $sanitary_values;
	}

	public function meetergo_section_info() {
		
	}

	public function company_key_0_callback() {
		printf(
			'<input class="regular-text" type="text" name="meetergo_options[company_key_0]" id="company_key_0" value="%s">',
			isset( $this->meetergo_options['company_key_0'] ) ? esc_attr( $this->meetergo_options['company_key_0']) : ''
		);
	}

	public function button_color_1_callback() {
		printf(
			'<input class="regular-text" type="color" name="meetergo_options[button_color_1]" id="button_color_1" value="%s">',
			isset( $this->meetergo_options['button_color_1'] ) ? esc_attr( $this->meetergo_options['button_color_1']) : '#48BB78'
		);
	}

	public function button_text_color_2_callback() {
		printf(
			'<input class="regular-text" type="color" name="meetergo_options[button_text_color_2]" id="button_text_color_2" value="%s">',
			isset( $this->meetergo_options['button_text_color_2'] ) ? esc_attr( $this->meetergo_options['button_text_color_2']) : '#ffffff'
		);
	}

	public function button_text_3_callback() {
		printf(
			'<input class="regular-text" name="meetergo_options[button_text_3]" id="button_text_3" value="%s">',
			isset( $this->meetergo_options['button_text_3'] ) ? esc_attr( $this->meetergo_options['button_text_3']) : 'Book an appointment'
		);
	}
	public function button_location_4_callback() {
		?> <fieldset>
		<?php $checked = ( isset( $this->meetergo_options['button_location_4'] ) && $this->meetergo_options['button_location_4'] === 'bottom-right' ) ? 'checked' : '' ; ?>
		<label for="button_location_4-0"><input type="radio" name="meetergo_options[button_location_4]" id="button_location_4-0" value="bottom-right" <?php echo $checked; ?>>  Bottom Right</label><br>
		<?php $checked = ( isset( $this->meetergo_options['button_location_4'] ) && $this->meetergo_options['button_location_4'] === 'bottom-left' ) ? 'checked' : '' ; ?>
		<label for="button_location_4-1"><input type="radio" name="meetergo_options[button_location_4]" id="button_location_4-1" value="bottom-left" <?php echo $checked; ?>>  Bottom Left</label><br> 
		<?php $checked = ( isset( $this->meetergo_options['button_location_4'] ) && $this->meetergo_options['button_location_4'] === 'top-right' ) ? 'checked' : '' ; ?>
		<label for="button_location_4-2"><input type="radio" name="meetergo_options[button_location_4]" id="button_location_4-2" value="top-right" <?php echo $checked; ?>>  Top Right</label><br> 
		<?php $checked = ( isset( $this->meetergo_options['button_location_4'] ) && $this->meetergo_options['button_location_4'] === 'top-left' ) ? 'checked' : '' ; ?>
		<label for="button_location_4-3"><input type="radio" name="meetergo_options[button_location_4]" id="button_location_4-3" value="top-left" <?php echo $checked; ?>>  Top Left</label></fieldset> <?php
	}
        // Settings link in plugin page
        public function my_plugin_settings_link($links) { 
            $settings_link = '<a href="options-general.php?page=meetergo">Settings</a>'; 
            array_unshift($links, $settings_link); 
            return $links; 
          }

}
if ( is_admin() )
	$meetergo = new Meetergo();

/* 
 * Retrieve this value with:
 * $meetergo_options = get_option( 'meetergo_options' ); // Array of All Options
 * $company_key_0 = $meetergo_options['company_key_0']; // Company key
 * $button_color_1 = $meetergo_options['button_color_1']; // Button color
 * $button_text_color_2 = $meetergo_options['button_text_color_2']; // Button text color
 * $button_text_3 = $meetergo_options['button_text_3']; // Button text
 * $button_location_4 = $meetergo_options['button_location_4']; // Button location
 */



// Display widget
function meetergo_display_widget() {
    $locale = get_locale();
    $options = get_option( 'meetergo_options' );
    $companyUID = $options['company_key_0'];
    $buttonColor = $options['button_color_1'];
    $buttonTextColor = $options['button_text_color_2'];
	$buttonText = $options['button_text_3'];
	$buttonLocation = $options['button_location_4'];
    ?>
      <script>

      document.addEventListener(
        'DOMContentLoaded',
        function () {   
          let liveExpert = document.createElement('a')
          liveExpert.innerHTML = '<?php if($companyUID){ if($buttonText !== ''){
			  echo esc_html($buttonText);
		  } else if($locale === "de_DE") { 
			  echo "Termin vereinbaren"; 
		  } else {echo "Book an appointment"; }
		 } else { echo "Enter meetergo key in settings"; } ?>'
          liveExpert.href = "<?php echo esc_url("https://my.meetergo.com/$companyUID") ?>"
          liveExpert.target = "_blank"
          liveExpert.style.cssText =
            `position:fixed;background:<?php 
            if($companyUID){
                if($buttonColor){
                     echo esc_attr($buttonColor); 
                }else{
                   echo "#48BB78";
                } 
            }else {
                echo "#FF0000";
            } 
            ?>;
            color: <?php if($buttonTextColor){echo esc_attr($buttonTextColor);} else{ echo "white"; } ?>;
            padding: 0.5rem 1rem;
            border-radius:0.325rem;
            <?php 
			// Top or bottom
			if($buttonLocation === 'top-left' || $buttonLocation === 'top-right'){
				echo 'top';
			} else if($buttonLocation === 'bottom-left' || $buttonLocation === 'bottom-right'){
				echo 'bottom';
			} else {
				echo 'bottom';
			}
			?>:10px; <?php 
			// Left or right
			if($buttonLocation === 'bottom-right' || $buttonLocation === 'top-right'){
				echo 'right';
			} else if($buttonLocation === 'bottom-left' || $buttonLocation === 'top-left'){
				echo 'left';
			} else {
				echo 'right';
			}
			?>:10px;
            text-decoration: none !important;
            z-index:2000;`
            document.body.insertBefore(liveExpert, document.body.firstChild);
        },
        false
      )
    </script>

    <?php
}
  
add_action('wp_head', 'meetergo_display_widget');


?>
