<?php
/*
	Plugin Name: 			Kevinjohn Gallagher: Pure Web Brilliant's Image Controls
	Description: 			Framework extension that allows the use of Image selector. 
	Version: 				2.1
	Author: 				Kevinjohn Gallagher
	Author URI: 			http://kevinjohngallagher.com/
	
	Contributors:			kevinjohngallagher, purewebbrilliant 
	Donate link:			http://kevinjohngallagher.com/
	Tags: 					kevinjohn gallagher, pure web brilliant, framework, cms, simple, multisite, images 
	Requires at least:		3.0
	Tested up to: 			3.4
	Stable tag: 			2.1
*/
/**
 *
 *	Kevinjohn Gallagher: Pure Web Brilliant's Image Controls
 * =============================================================
 *
 *	Framework extension that allows the use of Image selector. 
 *
 *
 *	This program is free software; you can redistribute it and/or modify it under the terms of the GNU 
 *	General Public License as published by the Free Software Foundation; either version 3 of the License, 
 *	or (at your option) any later version.
 *
 * 	This program is distributed in the hope that it will be useful, but WITHOUT ANY WARRANTY; 
 *	without even the implied warranty of MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.
 *
 *	See the GNU General Public License (http://www.gnu.org/licenses/gpl-3.0.txt) for more details.
 *
 *	You should have received a copy of the GNU General Public License along with this program.  
 * 	If not, see http://www.gnu.org/licenses/ or http://www.gnu.org/licenses/gpl-3.0.txt
 *
 *
 *	Copyright (C) 2008-2012 Kevinjohn Gallagher / http://www.kevinjohngallagher.com
 *
 *
 *	@package				Pure Web Brilliant
 *	@version 				2.1
 *	@author 				Kevinjohn Gallagher <wordpress@kevinjohngallagher.com>
 *	@copyright 				Copyright (c) 2012, Kevinjohn Gallagher
 *	@link 					http://kevinjohngallagher.com
 *	@license 				http://www.gnu.org/licenses/gpl-3.0.txt
 *
 *
 */



 	if ( ! defined( 'ABSPATH' ) )
 	{ 
 			die( 'Direct access not permitted.' ); 
 	}
 	
 	
 	



	define( '_KEVINJOHN_GALLAGHER___image_controls', '2.1' );



	if (class_exists('kevinjohn_gallagher')) 
	{
		
		
		class	kevinjohn_gallagher___image_controls 
		extends kevinjohn_gallagher
		{
		
				/*
				**
				**		VARIABLES
				**
				*/
				const PM		=	'_kevinjohn_gallagher___image_controls';
				
				var					$instance;
				var 				$plugin_name;
				var					$uniqueID;
				var					$plugin_dir;
				var					$plugin_url;
				var 				$http_or_https;
				var 				$jquery_new_url;
				var 				$jquery_image_url;
				var 				$plugin_options;
				
		
				/*
				**
				**		CONSTRUCT
				**
				*/
				public	function	__construct() 
				{
						$this->instance					=	&$this;
						$this->uniqueID 				=	self::PM;
						$this->plugin_name				=	"Kevinjohn Gallagher: Pure Web Brilliant's IMAGE controls";
						
						add_action( 'init',				array( $this, 'init' ) );
						add_action( 'init',				array( $this, 'init_child' ) );
						add_action(	'admin_init',		array( $this, 'admin_init_register_settings'));
					//	add_action( 'admin_menu',		array( $this, 'add_plugin_to_menu'));
						
						add_action( 'admin_init',		array( $this, 'stolen_admin_setup' ) );
												
				}
				
				
				
				
				/*
				**
				**		INIT_CHILD
				**
				*/
				public function init_child() 
				{
				
				
						$this->plugin_dir										=	plugin_dir_path(__FILE__);	
						$this->plugin_url										=	plugin_dir_url(__FILE__);				
				
						$this->child_settings_sections 							=	array();
						$this->child_settings_array 							=	array();
						
//						$this->define_child_settings();
						
//						add_action(	'wp_head',	array( $this,	'wp_head_image_controls') );

//						$this->child_settings_sections['section']					= 'its a section';
//						$this->output_image_upload();

				}
				
 				
				public 	function 	define_child_settings()
				{
				


						
				}


				/*
				**
				**		ADD_PLUGIN0_TO_MENU
				**
				*/
				/*				
				public 	function 	add_plugin_to_menu()
				{
						$this->framework_admin_menu_child(	'image control', 
															'image control', 
															'image-control', 
															array($this, 'child_admin_page')
														);
				
				}
				*/
				

				/*
				**
				**		CHILD ADMIN PAGE
				**
				*/
				/*				
				public 	function 	child_admin_page()
				{				
						$this->framework_admin_page_header('image Control', 'icon_class');
						
						$this->framework_admin_page_footer();				
				}
				*/
				
				

				/**
				 *		
				 *		 
				 * 		
				 * 		
				 */
				 
				public 	function 	stolen_admin_setup() 
				{
						
						global $pagenow;
						
						if ( 'admin.php' == $pagenow ) 
						{		
								if( $this->is_page_mine() )
								{
										wp_enqueue_script(	'media-upload'	); 		
										wp_enqueue_script(	'thickbox'	);
										wp_enqueue_style(	'thickbox'	);
										
										wp_enqueue_script(	'pwbImageUploader', 
															plugins_url('_javascripts/kevinjohn_gallagher__image_controls.js', __FILE__), 
															array('thickbox'), 
															FALSE, 
															TRUE 
														);
														
										wp_enqueue_style(	'pwb_image_control', 
															plugins_url('_stylesheets/kevinjohn_gallagher__image_controls.css', __FILE__),
															array(), 
															'1.0', 
															'all'
														);
								}
											
							
						}
						
						if ( 'media-upload.php' == $pagenow || 'async-upload.php' == $pagenow ) 
						{
						
								add_filter( 'image_send_to_editor',		array( $this,	'image_send_to_editor'), 		1, 8 );
						
								if( $this->is_thickbox_mine('image-test') )
								{
						
									add_filter( 'gettext', 					array( $this, 'replace_text_in_thickbox' ), 	1, 3 );
									add_filter( 'media_upload_tabs', 		array( $this, 'media_upload_tabs' ) );
									
									wp_enqueue_style(	'pwb_image_control', 
														plugins_url('_stylesheets/kevinjohn_gallagher__image_controls.css', __FILE__),
														array(), 
														'1.0', 
														'all'
													);
								}
						}
						
						$this->fix_async_upload_image();
				}
				
				



				/**
				 *		THIS IS TAKEN FROM "IMAGE WIDGET"
				 * 		
				 * 		
				 */

				public 	function 	fix_async_upload_image() 
				{
						if(isset($_REQUEST['attachment_id'])) 
						{
							$id 				=	(int) $_REQUEST['attachment_id'];
							$GLOBALS['post'] 	=	get_post( $id );
						}		
				}

				/**
				 * Somewhat hacky way of replacing "Insert into Post" with "Insert into Widget"
				 *
				 * @param string $translated_text text that has already been translated (normally passed straight through)
				 * @param string $source_text text as it is in the code
				 * @param string $domain domain of the text
				 * @author Modern Tribe, Inc. (Peter Chester)
				 */
				function replace_text_in_thickbox($translated_text, $source_text, $domain) {
					//if ( $this->is_sp_widget_context() ) {
						if ('Insert into Post' == $source_text) 
						{
								return 'Select Image';
						}
					//}
					return $translated_text;
				}

				/**
				 * Remove from url tab until that functionality is added to widgets.
				 *
				 * @param array $tabs
				 * @author Modern Tribe, Inc. (Peter Chester)
				 */
				function media_upload_tabs($tabs) {
					//	if ( $this->is_thickbox_mine('image-test') ) 
					//	{
							unset($tabs['type_url']);
					//	}
						return $tabs;
				}


				/**
				 * Filter image_end_to_editor results
				 *
				 * @param string $html
				 * @param int $id
				 * @param string $alt
				 * @param string $title
				 * @param string $align
				 * @param string $url
				 * @param array $size
				 * @return string javascript array of attachment url and id or just the url
				 * @author Modern Tribe, Inc. (Peter Chester)
				 */
				public 	function 	image_send_to_editor( $html, $id, $caption, $title, $align, $url, $size, $alt = '' ) 
				{
					// Normally, media uploader return an HTML string (in this case, typically a complete image tag surrounded by a caption).
					// Don't change that; instead, send custom javascript variables back to opener.
					// Check that this is for the widget. Shouldn't hurt anything if it runs, but let's do it needlessly.
				//	if ( $this->is_thickbox_mine('image-test') ) 
				//	{
						if ($alt=='') $alt = $title;
						?>
						<script type="text/javascript">
							// send image variables back to opener
							var win			=	window.dialogArguments || opener || parent || top;
							win.IW_html		=	'<?php echo addslashes($html); ?>';
							win.IW_img_id	=	'<?php echo $id; ?>';
							win.IW_alt 		=	'<?php echo addslashes($alt); ?>';
							win.IW_caption	=	'<?php echo addslashes($caption); ?>';
							win.IW_title 	=	'<?php echo addslashes($title); ?>';
							win.IW_align 	=	'<?php echo esc_attr($align); ?>';
							win.IW_url 		=	'<?php echo esc_url($url); ?>';
							win.IW_size 	=	'<?php echo esc_attr($size); ?>';
							
						</script>
						<?php
				//	}
					return $html;
				}

				


		public 	function	is_thickbox_mine($this_is_me='') 
		{
				
				if( isset( $_SERVER['HTTP_REFERER'] ) )
				{
						$refferer	=	$_SERVER['HTTP_REFERER'];
						
				}	elseif( isset( $_REQUEST['_wp_http_referer'] ) ) {
					
						$refferer	=	$_REQUEST['_wp_http_referer'];
				}
				
//				echo $refferer;
				
//				die();
				
		
				$is_it_mine	=	false;		
				
				if( strpos( $refferer , "kjg" ) !== false || strpos( $refferer , "pwb" ) !== false )
				{
						$is_it_mine	=	true;
						
				}	elseif( !empty( $this_is_me ) ) {
				
						if( strpos( $refferer , $this_is_me ) !== false )
						{
								$is_it_mine	=	true;					
						}


				}
				
				return 	$is_it_mine;
				
		
		}







				


			/**
			 *		Outputs WordPress default Image Upload for a WP settings page
			 *		 
			 * 		@args  		array
			 * 		@options	array
			 */
			
			public function 	framework_display_setting_type_wp_image_upload($args, $options)
			{
					extract($args);

					$media_upload_iframe_src		=	"media-upload.php?type=image&post_id=0"; 
					$image_upload_iframe_src		=	apply_filters('image_upload_iframe_src', "$media_upload_iframe_src");

					if( !empty( $options[$id] )  )
					{
							$display_image			=	'<img src="' . $options[$id.'-url'] . '" />';


							$display_image 			=	$display_image . 	'<a		
																					href="#" 
																					id="remove-wp-image-upload-' . $id . '" 
																					class="remove-wp-image-style" 
																					title=" Remove Image " 
																					onClick="return false;" 
																					style="text-decoration:none"
																				>
																				
																					Remove Image
																			</a>
																			<span
																					class="remove-wp-image-span">
																			
																			</span>
																			';
				
							
					} else {

							$display_image			=	'<img 	src="images/media-button-image.gif" 
																alt="Add Image" 
																align="absmiddle" 
																class="no-style" 
															/> ';
															
							$display_image			=	$display_image. ' &nbsp; Add Image';

							$display_image			=	$display_image. ' <noscript> 
																				I am very sorry to say that this requires JavaScript. 
																			</noscript>';

						
					}
					
					

					/*
					//
					//	So I think I should do this...
					//	But it looks like WordPress has it covered.
					//
					//	Very awesome, but, I'm sure the documentation says otehrwise.
					//
					
					add_settings_field( 
										$id .'-id', 
										$title, 
										array( $this, 'framework_valid_callback' ),  
										$this->uniqueID . '___options', 
										$section, 
										$field_args );
					*/

					/*
					echo 	'<style>
					
								
					
							</style>
					
							';
					*/

					echo 	'<div 	id="wp-image-upload-' . $id . '"> <!-- v important	-->';

					echo 	'<a		
									href="'. $image_upload_iframe_src .'&TB_iframe=true" 
									id="replace-wp-image-upload-' . $id . '" 
									class="thickbox replace-wp-image-style" 
									title="'. $image_title .'" 
									onClick="return false;" 
									style="text-decoration:none"
								>
							';

					
					
					echo $display_image;

					echo 	'</a>		
							';


							
					echo	'<input 
									type="hidden"					
									class="regular-text ' . $field_class . '" 
									name="'. $this->uniqueID . '___options[' . $id . ']"
									id="pwb-wp-image-upload-' . $id . '" 
									placeholder="' . $std . '" 
									value="' . esc_attr( $options[$id.''] ) . '" 
								/>';


					echo	'<input 
									type="hidden"					
									class="regular-text ' . $field_class . '" 
									name="'. $this->uniqueID . '___options[' . $id . '-id]"
									id="pwb-wp-image-upload-' . $id . '-id" 
									placeholder="' . $std . '" 
									value="' . esc_attr( $options[$id.'-id'] ) . '" 
								/>';

//					echo 	"<br/><br/>";


					echo	'<input 
									type="hidden"					
									class="regular-text ' . $field_class . '" 
									name="'. $this->uniqueID . '___options[' . $id . '-html]"
									id="pwb-wp-image-upload-' . $id . '-html" 
									placeholder="' . $std . '" 
									value="' . esc_attr( $options[$id.'-html'] ) . '" 
								/>';

//					echo 	"<br/><br/>";

					echo	'<input 
									type="hidden"					
									class="regular-text ' . $field_class . '" 
									name="'. $this->uniqueID . '___options[' . $id . '-width]"
									id="pwb-wp-image-upload-' . $id . '-width" 
									placeholder="' . $std . '" 
									value="' . esc_attr( $options[$id.'-width'] ) . '" 
								/>';

//					echo 	"<br/><br/>";

					echo	'<input 
									type="hidden"					
									class="regular-text ' . $field_class . '" 
									name="'. $this->uniqueID . '___options[' . $id . '-height]"
									id="pwb-wp-image-upload-' . $id . '-height" 
									placeholder="' . $std . '" 
									value="' . esc_attr( $options[$id.'-height'] ) . '" 
								/>';

//					echo 	"<br/><br/>";

					echo	'<input 
									type="hidden"					
									class="regular-text ' . $field_class . '" 
									name="'. $this->uniqueID . '___options[' . $id . '-align]"
									id="pwb-wp-image-upload-' . $id . '-align" 
									placeholder="' . $std . '" 
									value="' . esc_attr( $options[$id.'-align'] ) . '" 
								/>';

//					echo 	"<br/><br/>";

					echo	'<input 
									type="hidden"					
									class="regular-text ' . $field_class . '" 
									name="'. $this->uniqueID . '___options[' . $id . '-title]"
									id="pwb-wp-image-upload-' . $id . '-title" 
									placeholder="' . $std . '" 
									value="' . esc_attr( $options[$id.'-title'] ) . '" 
								/>';

//					echo 	"<br/><br/>";

					echo	'<input 
									type="hidden"					
									class="regular-text ' . $field_class . '" 
									name="'. $this->uniqueID . '___options[' . $id . '-caption]"
									id="pwb-wp-image-upload-' . $id . '-caption" 
									placeholder="' . $std . '" 
									value="' . esc_attr( $options[$id.'-caption'] ) . '" 
								/>';

//					echo 	"<br/><br/>";

					echo	'<input 
									type="hidden"					
									class="regular-text ' . $field_class . '" 
									name="'. $this->uniqueID . '___options[' . $id . '-alt]"
									id="pwb-wp-image-upload-' . $id . '-alt" 
									placeholder="' . $std . '" 
									value="' . esc_attr( $options[$id.'-alt'] ) . '" 
								/>';

//					echo 	"<br/><br/>";

					echo	'<input 
									type="hidden"					
									class="regular-text ' . $field_class . '" 
									name="'. $this->uniqueID . '___options[' . $id . '-url]"
									id="pwb-wp-image-upload-' . $id . '-url" 
									placeholder="' . $std . '" 
									value="' . esc_attr( $options[$id.'-url'] ) . '" 
								/>';

//					echo 	"<br/><br/>";



								
					echo 	'</div> 	<!-- 	#wp-image-upload-' . $id . '	--> <!-- v important	-->';			
					
			}
			



		
		
		}	//	class
		
	
		$kevinjohn_gallagher___image_controls			=	new kevinjohn_gallagher___image_controls();
		
	
	} else {
	

			function kevinjohn_gallagher___image_controls___parent_needed()
			{
					echo	"<div id='message' class='error'>";
					
					echo	"<p>";
					echo	"<strong>Kevinjohn Gallagher: Pure Web Brilliant's Image Controls</strong> ";	
					echo	"requires the parent framework to be installed and activated";
					echo	"</p>";
			} 

			add_action('admin_footer', 'kevinjohn_gallagher___image_controls___parent_needed');	
	
	}


