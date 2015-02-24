<?php
/**
 * Plugin Name: Four Three Five RSS
 * Plugin URI: http://www.435digital.com
 * Description: A plugin to publish RSS feeds as posts.
 * Version: 1.0
 * Author: 435 Digital
 * Author URI: http://www.435digital.com
 * License: GPLv2 
 */
 
 /*  Copyright 2015 435 Digital  (email : jhaun@435digital.com)

    This program is free software; you can redistribute it and/or modify
    it under the terms of the GNU General Public License, version 2, as 
    published by the Free Software Foundation.

    This program is distributed in the hope that it will be useful,
    but WITHOUT ANY WARRANTY; without even the implied warranty of
    MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
    GNU General Public License for more details.

    You should have received a copy of the GNU General Public License
    along with this program; if not, write to the Free Software
    Foundation, Inc., 51 Franklin St, Fifth Floor, Boston, MA  02110-1301  USA
*/

/*
feed examples:
	- http://rss.tmsfeatures.com/tms/za_ask_amy.xml
	- http://rss.tmsfeatures.com/tms/xl_brewster.xml
	- http://rss.tmsfeatures.com/tms/nt_lean_in.xml
	- http://rss.tmsfeatures.com/tms/hs_living_space.xml
*/

defined('ABSPATH') or die();

/* INITIALIZE PLUGIN */

//activate
register_activation_hook(__FILE__,'ftf_rss_install');
function ftf_rss_install() { 
	global $wp_version;
	if(version_compare($wp_version,'4.0','<')) {
		deactivate_plugins(basename( __FILE__ ));
		//wp_die('This plugin requires WordPress version 4.0 or higher.');
	}
}

//deactivate
register_deactivation_hook(__FILE__,'ftf_rss_deactivate');
function ftf_rss_deactivate() { 
	//TODO: do we need to deactivate anything here?
}

//i18n (not happening yet)
//load_plugin_textdomain( ‘four-three-five-rss’, false, ‘four-three-five-rss/languages’ );

//get the 435 digital logo
function get_435_logo() {
	$logo = "<a href=\"http://www.435digital.com/\" title=\"435 Digital – A Tribune Company\" target=\"_blank\" /><img src=\"". plugins_url('/four-three-five-rss/images/435digital_logo.png') . "\" alt=\"435 Digital\" /></a>";
	return $logo;
}

//register custom post type for RSS posts
function four_three_five_rss_init() {
	$icon = plugins_url('/four-three-five-rss/images/rss.png');
	
    $args = array(
      	'label' => 'RSS Posts',
      	'description' => 'Posts that are created via the 435 RSS plugin.',
        'public' => true,
        'show_ui' => false,
        'capability_type' => 'post',
        'hierarchical' => false,
        'rewrite' => array('slug' => 'rss-post'),
        'query_var' => true,
        'menu_icon' => $icon,
        'taxonomies' => array('category'),
        'supports' => array(
            'title',
            'editor',
            'excerpt',
            'trackbacks',
            'custom-fields',
            'comments',
            'revisions',
            'thumbnail',
            'author',
            'page-attributes',)
        );
    register_post_type('rss-post',$args);
}
add_action('init','four_three_five_rss_init');

/* NON-PAGE FUNCTIONS */

//check xml
function is_valid_xml ($xml) {
	libxml_use_internal_errors(true);
	$doc = new DOMDocument('1.0', 'utf-8');
	$doc->loadXML($xml);
	$xmlerrors = libxml_get_errors();
	if($xmlerrors) {
		return false;
	} else {
		return true;
	}
}

//enable xml mime type so we can upload them
function extended_upload_mimes($mime_types=array()) {
   $mime_types['xml'] = 'text/xml';
   return $mime_types;
}
add_filter('upload_mimes', 'extended_upload_mimes');

//create slug (look up WP's way of doing this)
function human_urlencode($title) {
	$title = strip_tags($title);
	$title = mb_strtolower($title, 'UTF-8');
    $title = preg_replace('/&.+?;_/', ' ', $title);
    $title = preg_replace('/[^%a-z0-9 -]/', '', $title);
    $title = preg_replace('/\s+/', '-', $title);
	$title = preg_replace('|-+|', '-', $title);
    $title = str_replace('%', 'perc', $title);
    $title = trim($title, '-');
    return $title;
}

function get_product_category_parents($id, $taxonomy = 'product_cat', $link = false, $separator = ',', $nicename = false, $visited = array()) {
	$chain = '';
	$parent = get_term( $id, $taxonomy );
	if(is_wp_error($parent)) { 
		return $parent;
	}
	if($nicename) {
		$name = $parent->slug;
	} else {
		$name = $parent->term_id;
	}
	if($parent->parent && ($parent->parent != $parent->term_id) && !in_array( $parent->parent, $visited)) {
		$visited[] = $parent->parent;
		$chain .= get_product_category_parents( $parent->parent, $taxonomy, $link, $separator, $nicename, $visited );
	}
	if($link) {
		$chain .= '<a href="' . esc_url( get_term_link( $parent,$taxonomy ) ) . '" title="' . esc_attr( sprintf( __( "View all posts in %s" ), $parent->name ) ) . '">'.$name.'</a>' . $separator;
	} else {
		$chain .= $name.$separator;
	}
	return $chain;
}

//create menus 
add_action( 'admin_menu', 'ftf_rss_create_menu' );

function ftf_rss_create_menu() {
	//create new top-level menu
	add_menu_page('435 RSS Plugin', '435 RSS', 'manage_options', 'ftf_rss_main_menu', 'ftf_rss_main_plugin_page', plugins_url('/images/rss.png', __FILE__ ));
	
	//create two sub-menus for the 'feed listing' page and 'add new feed' page
	add_submenu_page('ftf_rss_main_menu', '435 RSS Feeds','View RSS Feeds', 'manage_options', 'ftf_rss_feeds', 'ftf_rss_feeds_page');
	add_submenu_page('ftf_rss_main_menu', '435 RSS Add Feed','Add New RSS', 'manage_options', 'ftf_rss_add', 'ftf_rss_add_page');
}

/* PAGE FUNCTIONS */

//plugin main page - needs content

function ftf_rss_main_plugin_page() {
//include( plugin_dir_path( __FILE__ ) . 'pages/test.php');
?>
	<div class="wrap">
		<?php echo get_435_logo(); ?><br />
		<h1>Four Three Five RSS</h1>
		<h2>Instructions:</h2>
		<p>
			<ol>
				<li>This plugin requires the <a href="http://www.advancedcustomfields.com/" target="_blank" title="Advanced Custom Fields">Advanced Custom Fields</a> plugin to be installed in order to function correctly.</li>
				<li>TODO: Some info about Product Categories here (must use product_cat and must have is_product custom field)</li>
				<li>Product Categories taxonomy must be created?</li>
				<li>Product Categories must have the is_product custom field associated with them.<br /><img src="<?php echo plugins_url('/four-three-five-rss/images/is_product_acf.jpg'); ?>" /></li>
				<li>Product Categories must check/enable the is_product checkbox?</li>
				<li>...</li>
			</ol>
		</p>
	</div>
<?php
}

//the form to add a new feed
function ftf_rss_add_page() {
	global $wpdb;

	//if a delete id is passed, delete the post and redirect to the listing page!
	if($_REQUEST['delete'] > 0) {
		echo $_REQUEST['delete'];
		wp_delete_post((int)$_REQUEST['delete'], true);
		wp_redirect('/wp-admin/admin.php?page=ftf_rss_feeds');
	}

	if(isset($_POST['rss_name'])) {

		//check nonce
		check_admin_referer('ftf_rss_form','ftf_rss_nonce_field');

		$items = $_REQUEST;
        $errors = array();
		
        //validate everything...
        if(empty($items['rss_name'])) {
			$errors[] = "An RSS Name is required.";
		}
		
		//check if this feed has already been posted
		if(!empty($items['rss_name']) && !isset($_REQUEST['edit'])) {
			$post_id = $wpdb->get_var( "SELECT ID FROM $wpdb->posts WHERE post_title = '" . $items['rss_name'] . "'" );
			if($post_id) {
				$errors[] = "The '" . $items['rss_name'] . "' RSS feed already exists! You cannot post the same RSS feed twice!";
			}
		}
		
		//make sure name is only letters/spaces
		if (!preg_match("/^[a-zA-Z ]*$/",$items['rss_name'])) {
  			$errors[] = "Only letters and white space allowed in the RSS Name"; 
		} else {
			$items['rss_name'] = sanitize_text_field($items['rss_name']);
		}
        
        //must have an RSS!
        if(empty($items['rss_url'])) {
			$errors[] = "An RSS Feed URL is required.";
		}
		
		//the url should be syntactically correct
		if(!empty($items['rss_url']) && !preg_match("/\b(?:(?:https?|ftp):\/\/|www\.)[-a-z0-9+&@#\/%?=~_|!:,.;]*[-a-z0-9+&@#\/%=~_|]/i",$items['rss_url'])) {
  			$errors[] = "The URL you entered appears to be invalid"; 
  			$goodurl = false;
		}
		
		//does the url actually exist...
		if(!empty($items['rss_url']) && $goodurl) {
			if(!class_exists('WP_Http')) {
				include_once( ABSPATH . WPINC. '/class-http.php');
			}
			$http = new WP_Http;
			$output = $http->request($items['rss_url']);
			if($output instanceof WP_Error) {
  				$errors[] = "There was a problem with the RSS address you entered. Please check the URL and try again.";
			}
		}
		
		//check to make sure the RSS is an XML
		if(!empty($items['rss_url']) && $goodurl) {
			$xml = file_get_contents($items['rss_url']);
			if(!is_valid_xml($xml)) {
				$errors[] = "The RSS you entered does not appear to be valid XML.";
			}
		}

		//check to make sure 'feed type' is a valid selection
		if($items['feed_type'] == 0) {
			$errors[] = "You must select a Feed Type.";
		}
		
		//check to make sure the post author has been selected
		if(empty($items['use_rss_author']) && $items['post_author'] == 0) {
			$errors[] = "You must either Choose a Post Author, or Use Author From the RSS.";
		} 
		
		//make sure both articla author _and_ post author are not selected at the same time!
		if(!empty($items['use_rss_author']) && $items['post_author'] != 0) {
			$errors[] = "You must either Choose a Post Author, or Use Author From the RSS. You cannot choose both.";
		}
		
		//there must be a post product associated with all RSS feeds.
		//if($items['post_product'] == 0) {
		//	$errors[] = "You must Choose an Associated Product for the RSS feed.";
		//}

		if($items['post_category'] == 0 && ($items['parent_category'] == 0 && empty($items['create_post_category']))) {
			$errors[] = "You must either Choose a Product Category or Create a New Product Category.";
		}

		//make sure people know what they want :)
		if($items['post_category'] != 0 && ($items['parent_category'] != 0 || !empty($items['create_post_category']))) {
			$errors[] = "You must either Choose a Product Category -OR- Create a New Product Category. You cannot do both.";
			$showcreate = false;
		} else {
			$showcreate = true;
		}
		
		//new category validation
		if($items['parent_category'] == 0 && !empty($items['create_post_category']) && $showcreate) {
			$errors[] = "You must Choose a Parent Category when you Create a New Product Category";
		}
		
		if($items['parent_category'] != 0 && empty($items['create_post_category']) && $showcreate) {
			$errors[] = "You must Enter a New Category Name";
		}
		
		if($catexists = get_term_by('name',$items['create_post_category'],'product_cat')) {
			$errors[] = "The New Category: '".$items['create_post_category']."' already exists! You can select it from the Choose a Product Category field above.";
		}

		//ACF must be installed because we're using get_field() and other ACF functions
        if(!is_plugin_active('advanced-custom-fields/acf.php')) {
			$errors[] = "This plugin requires the <a href=\"http://www.advancedcustomfields.com/\" target=\"_blank\" title=\"Advanced Custom Fields\">Advanced Custom Fields</a> plugin to be installed in order to function correctly.";
		}

		if(!$errors) {	
			//everything is good so far, let's see if we can upload and parse it.
			include_once( ABSPATH . WPINC . '/feed.php' );
			require_once(ABSPATH . "wp-admin" . '/includes/file.php');
			$rss = fetch_feed($items['rss_url']);
			
			if(!is_wp_error($rss)) {
				$quantity = $rss->get_item_quantity();
				$rssitems = $rss->get_items(0,$quantity);
					
				if($quantity == 0) {
					//there are no articles...
					$errors[] = "The RSS contains no articles.";
				} else {
					//upload the original xml as an attachment and get the url and id of that attachment
					$tmp = download_url($items['rss_url']);
					$now = time();
					$name = basename($items['rss_url']);
					
					$file_array = array(
						'name' => $now."_".$name,
						'tmp_name' => $tmp
					);
					
					if(is_wp_error($tmp)) {
						@unlink($file_array['tmp_name']);
						$errors[] = "There was a problem with uploading the RSS/XML file.";
						return $tmp;
					}
					
					$attachment_id = media_handle_sideload($file_array, 0);
					if(is_wp_error($attachment_id)) {
						@unlink($file_array['tmp_name']);
						$errors[] = "There was a problem with creating the RSS/XML attachment.";
						return $attachment_id;
					}
					
					$attachment_url = wp_get_attachment_url($attachment_id);
					
					if(!$errors) {
						
						//create a new category if requested
						$new_cat = array(
							'cat_name' => $items['create_post_category'],
							'category_description' => '',
							'category_nicename' => '',
							'category_parent' => $items['parent_category'],
							'taxonomy' => 'product_cat' 
						);
						
						$new_cat_id = wp_insert_category($new_cat);
						$values['choices'] = 'product';
						$field = get_field_object('cat-type');
						update_field($field['key'],$values, 'product_cat_'.$new_cat_id);
						
						$feeds = array(); //set up feeds array...
						$k=1; //set up counter
						foreach($rssitems as $temp) {
							if($items['use_rss_author'] == 1) {
								//use the feed author instead of the post author...
								if($author = $temp->get_author()) {
									//why is the author showing up in simplepie's get_email() instead of get_name()?
									$feeds[$k]['author'] = esc_html($author->get_email());
								}
							}

							$feeds[$k]['title'] = $temp->get_title();
							$feeds[$k]['slug'] = human_urlencode($temp->get_title());
							$feeds[$k]['content'] = $temp->get_content();
							$feeds[$k]['link'] =  esc_url($temp->get_permalink());
							$feeds[$k]['date'] = esc_html($temp->get_date('j F Y | g:i a'));
							if($items['feed_type'] == 1 || $items['feed_type'] == 2) { //text only - no images
								$feeds[$k]['content'] = $temp->get_content();
							} else if($items['feed_type'] == 3 || $items['feed_type'] == 4) { 
								//parse images using original URL. We cannot parse tiffs (yet).
								if($enclosure = $temp->get_enclosure()) {
									$feeds[$k]['image'] = $enclosure->get_link();
								}
								//images only. no conttent.
								$feeds[]['content'] = ' ';
							} else { //both text and images
								$items['feed_type'] = 5; //force to only feed_type left
								//parse images using original URL? We cannot parse tiffs
								if($enclosure = $temp->get_enclosure()) {
									$feeds[$k]['image'] = $enclosure->get_link();
								}
								$feeds[$k]['content'] = $temp->get_content();
							}
							$k++;
						}
					} //end if(!$errors) inner		
				}
			}
		}
        
        //no errors!
		if(!$errors) {
			//we are good! now we save everything...
		
			//set things up
			$author_id = (int)$items['post_author'];
			$status = $items['draft_publish'] == 1 ? "draft" : "publish";
			
			//get post, post meta
			$postid = (int)$items['post_product'];
			$product = get_post($postid);
			$title = get_the_title($postid);
			$thumbnail = get_the_post_thumbnail($postid,'thumbnail');
			
			//get author avatar
			$avatar = get_avatar(get_the_author_meta($postid),160);
			
			if($items['id'] > 0) {
				//we're editing an existing feed
				$id = (int)$items['id'];
				//get the feed we're editing so we can check things.
				$rsspost = get_post($id);
				
				if(!$rsspost) {
					$errors[] = "There has been a problem getting the RSS you're trying to edit. Please try again";
				} else {
					//save the RSS info:
					$feedinfo = array(
						'ID'			=>  $items['id'],
						'post_title'	=>	$items['rss_name'],
						'post_name'		=>	human_urlencode($items['rss_name']),
						'post_content'	=>	$items['rss_url'],
						'post_author'		=>	$user_ID,
						'post_status'		=>	'publish',
						'post_type'		=>	'rss-post',
						'post_category'  => (int)$items['post_category'],
						'post_date' 	=> date('Y-m-d H:i:s'),
						'post_date_gmt' => date('Y-m-d H:i:s')
					);

					//insert the post into the database
					$post_id = wp_insert_post($feedinfo);
					
					update_post_meta($post_id, '_draft_publish',$items['draft_publish']);
					update_post_meta($post_id, '_publish_date',$items['publish_date']);
					update_post_meta($post_id, '_feed_type',$items['feed_type']);
					if($items['use_rss_author']) {
						update_post_meta($post_id, '_post_author',0);
						update_post_meta($post_id, '_use_rss_author',$items['use_rss_author']);
					} else {
						update_post_meta($post_id, '_use_rss_author',0);
						update_post_meta($post_id, '_post_author',$items['post_author']);
					}
					if($new_cat_id) {
						update_post_meta($post_id, '_post_category',$new_cat_id);
					} else {
						update_post_meta($post_id, '_post_category',(int)$items['post_category']);
					}
					update_post_meta($post_id, '_parent_category',(int)$items['parent_category']);
					update_post_meta($post_id, '_create_post_category',$items['create_post_category']);
					
					$cat_parents = get_product_category_parents($new_cat_id?$new_cat_id:$items['post_category']);
					$cats = explode(",",$cat_parents);
					
					foreach($feeds as $feed) {
						//check data against existing 'feed posts'. We will not be updating old feed posts, but only adding new ones if necessary
						if(get_page_by_title($feed['title'], ARRAY_A, 'article') == null) {
							//$categories = get_category_parents();
							$args = array(
								'post_title'		=>	$feed['title'],
								'post_author'		=>	$user_ID,
								'post_content'	=>	$feed['content'],
								'post_name'		=>	$feed['slug'],
								'post_status'		=>	$status,
								'post_type'		=>	'article'
							);
						
							//save each of the rss articles as posts!
							$post_id = wp_insert_post($args);
							if($feed['image']) {
								//attach the image
								media_sideload_image($feed['image'], $post_id);
							}
							//assign categories to post
							if($cats) {
								wp_set_post_terms($post_id,$cats,'product_cat',false);
							}
						}
					}
				}
			} else { //no id, so we're adding a new feed...
				//insert the rss feed info
				$feedinfo = array(
					'post_title'	=>	$items['rss_name'],
					'post_name'		=>	human_urlencode($items['rss_name']),
					'post_content'	=>	$items['rss_url'],
					'post_author'		=>	$user_ID,
					'post_status'		=>	'publish',
					'post_type'		=>	'rss-post',
					'post_category'  => (int)$items['post_category'],
					'post_date' 	=> date('Y-m-d H:i:s'),
					'post_date_gmt' => date('Y-m-d H:i:s')
				);
				
				$post_id = wp_insert_post($feedinfo);
				
				add_post_meta($post_id, '_draft_publish',$items['draft_publish']);
				add_post_meta($post_id, '_publish_date',$items['publish_date']);
				add_post_meta($post_id, '_feed_type',$items['feed_type']);
				if($items['use_rss_author']) {
					add_post_meta($post_id, '_post_author',0);
					add_post_meta($post_id, '_use_rss_author',$items['use_rss_author']);
				} else {
					add_post_meta($post_id, '_use_rss_author',0);
					add_post_meta($post_id, '_post_author',$items['post_author']);
				}
				if($new_cat_id) {
					add_post_meta($post_id, '_post_category',$new_cat_id);
				} else {
					add_post_meta($post_id, '_post_category',(int)$items['post_category']);
				}
				add_post_meta($post_id, '_parent_category',(int)$items['parent_category']);
				add_post_meta($post_id, '_create_post_category',$items['create_post_category']);

				$cat_parents = get_product_category_parents($new_cat_id?$new_cat_id:$items['post_category']);
				$cats = explode(",",$cat_parents);

				foreach($feeds as $feed) {
					$args = array(
						'post_title'		=>	$feed['title'],
						'post_author'		=>	$user_ID,
						'post_content'	=>	$feed['content'],
						'post_name'		=>	$feed['slug'],
						'post_status'		=>	$status,
						'post_type'		=>	'article'
					);
				
					//save each of the rss articles as posts!
					$post_id = wp_insert_post($args);
					if($feed['image']) {
						//attach the image
						media_sideload_image($feed['image'], $post_id);
					}
					//assign categories to post
					if($cats) {
						wp_set_post_terms($post_id,$cats,'product_cat',false);
					}
				} //end foreach($feeds as $feed)
			}
		} // end if(!$errors)

		if($errors) {
        	//display errors...
        	//TODO: make external stylesheet for plugin?
        	echo '<div style="width:98%;color:red;background:#ffecec;border:1px solid #f5aca6;padding:10px;margin-top:15px;">';
        	foreach($errors as $error) {
        		echo '* ' . $error . '<br />';
        	}
        	echo '</div>';
        } else {
        	//all good!
			wp_redirect('/wp-admin/admin.php?page=ftf_rss_feeds');
		} 
	} //end if($_POST)
	
	if($_REQUEST['edit'] > 0) {
		$thepost = get_post($_REQUEST['edit'],ARRAY_A);
		if($thepost) {
			$draft_publish = get_post_meta($thepost['ID'], '_draft_publish', true);
			$publish_date = get_post_meta($thepost['ID'], '_publish_date', true);
			$feed_type = get_post_meta($thepost['ID'], '_feed_type', true);
			$use_rss_author = get_post_meta($thepost['ID'], '_use_rss_author', true);
			$post_author = get_post_meta($thepost['ID'], '_post_author', true);
			$post_category = get_post_meta($thepost['ID'], '_post_category', true);
			$parent_category = get_post_meta($thepost['ID'], '_parent_category', true);
			$create_post_category = get_post_meta($thepost['ID'], '_create_post_category', true);
		}
	}
?>
<div class="wrap">
<?php //echo get_435_logo(); ?><br />
<?php //$term = get_term($post_category,'product_cat',ARRAY_A); ?>
<h2><?php echo $_REQUEST['edit'] ? "Edit " . $thepost['post_title'] . " RSS: " : "Add a New RSS"; ?></h2>

	<form accept-charset="UTF-8" action="<?php echo esc_url(add_query_arg('page','ftf_rss_add')) ?>" method="post" enctype="multipart/form-data">
	<?php wp_nonce_field('ftf_rss_form','ftf_rss_nonce_field'); //set nonce ?>
	<input type="hidden" name="id" value="<?php echo $_REQUEST['edit']; ?>" />
		<table class="form-table rss-form-table">
			<tr>	
				<th width-"400">Enter the Name of Your RSS</th>
				<td><input type="text" name="rss_name" size="30" value="<?php echo $thepost['post_title'] ? esc_html($thepost['post_title']) : esc_html($items['rss_name']); ?>" /><br /></td>
			</tr>
			<tr>	
				<th>Enter the URL of RSS Feed</th>
				<td><input type="text" name="rss_url" size="80" value="<?php echo $thepost['post_content'] ? esc_html($thepost['post_content']) : esc_url($items['rss_url']); ?>" /><br /></td>
			</tr>
			<tr>
				<th>Draft or Live?</th>
				<td>
				<select name="draft_publish">
					<option value="1" <?php selected($draft_publish ? $draft_publish : $items['draft_publish'],1,true); ?>>Save Draft</option>
					<option value="2" <?php selected($draft_publish ? $draft_publish : $items['draft_publish'],2,true); ?>>Publish Live</option>
				</select>
				<br />
				</td>
			</tr>
			<tr>
				<th>Use Date in RSS as Post Publish Date?</th>
				<td>
				<select name="publish_date">
					<option value="no" <?php selected($publish_date ? $publish_date : $items['publish_date'],"no",true); ?>>No</option>
					<option value="yes" <?php selected($publish_date ? $publish_date : $items['publish_date'],"yes",true); ?>>Yes</option>
				</select>
				<br />
				</td>
			</tr>
			<tr>
				<th>Feed Type</th>
				<td>
				<select name="feed_type">
					<option value="0" <?php selected($items['feed_type'],0,true); ?>>Choose a Feed Type</option>
					<option value="1" <?php selected($feed_type ? $feed_type : $items['feed_type'],1,true); ?>>Text-only</option>
					<option value="2" <?php selected($feed_type ? $feed_type : $items['feed_type'],2,true); ?>>Text-only for Magazines</option>
					<option value="3" <?php selected($feed_type ? $feed_type : $items['feed_type'],3,true); ?>>Images-only for Editorial Cartoons</option>
					<option value="4" <?php selected($feed_type ? $feed_type : $items['feed_type'],4,true); ?>>Images-only for Comic Strips</option>
					<option value="5" <?php selected($feed_type ? $feed_type : $items['feed_type'],5,true); ?>>Text and Images</option>
					
				</select>
				<br />
				</td>
			</tr>
			<tr>
				<th>Use Author From RSS</th>
				<td><input type="checkbox" value="1" name="use_rss_author" id="rss_author" <?php checked($use_rss_author ? $use_rss_author : $items['use_rss_author'],1,true); ?> />
				<br />
				</td>
			</tr>
			<tr>
				<th>
				- OR -
				</th>
				<td></td>
			</tr>
			<tr>
				<th>Choose a Post Author</th>
				<td>
				<select name="post_author">
					<option value="0">Choose an Author</option>
		<?php
			//get post authors.
			$authors = get_users(array('fields' => array('display_name','ID')));
			if($authors) {
				//cycle through authors..
				foreach($authors as $author) {
		?>
				<option value="<?php echo $author->ID; ?>" <?php selected($post_author ? $post_author : $items['post_author'],$author->ID,true); ?>><?php echo esc_html($author->display_name); ?></option>
		<?php
				} //end foreach($authors as $author)
			} //end if($authors)
		?>
				</select>
				</td>
			</tr>
			<tr>
				<th>Choose a Product Category</th>
				<td>
				<select name="post_category">
					<option value="0">Choose Category</option>
			<?php 
				$postcat = array(
					//'type'                     => 'article',
					'child_of'                 => 0,
					'parent'                   => '',
					'orderby'                  => 'name',
					'order'                    => 'ASC',
					'hide_empty'               => 1,
					'hierarchical'             => 1,
					'exclude'                  => '',
					'include'                  => '',
					'number'                   => '',
					'taxonomy'                 => 'product_cat',
					'pad_counts'               => false 

				); 
				$categories = get_categories($postcat);
				//print_r($categories);
				if($categories) {
					foreach($categories as $category) {
						$product = get_field('cat-type','product_cat_'.$category->term_id);
						if(in_array('product', $product) || $product == 'product') { //only show is_product categories
			?>
				<option value="<?php echo $category->term_id; ?>" <?php selected($post_category ? $post_category : $items['post_category'],$category->term_id,true); ?>><?php echo $category->name; ?><?php //print_r($product); ?></option>
			<?php		}
					}
				}
			?>
				</select>
				</td>
			</tr>
			<tr>
				<th>
				- OR -
				</th>
				<td></td>
			</tr>
			<tr>	
				<th>Create a NEW Product Category</th>
				<td>
				<select name="parent_category">
					<option value=="0">Choose a Parent Category</option>
					<?php 
					$parentcat = array(
						'type'                     => 'post',
						//'child_of'                 => 0,
						'parent'                   => 11, //show only what is directly under this category ID
						'orderby'                  => 'name',
						'order'                    => 'ASC',
						'hide_empty'               => 1,
						'hierarchical'             => 1,
						'exclude'                  => '',
						'include'                  => '',
						'number'                   => '',
						'taxonomy'                 => 'product_cat',
						'pad_counts'               => false 

					); 
					$parents = get_categories($parentcat);
					if($parents) {
					foreach($parents as $parent) {
			?>
				<option value="<?php echo $parent->term_id; ?>" <?php selected($_POST['parent_category'] ? $_POST['parent_category'] : 0,$parent->term_id,true); ?>><?php echo $parent->name; ?></option>
			<?php		
					}
				}
			?>
				</select>
					<input type="text" name="create_post_category" size="50" value="<?php echo $thepost['create_post_category'] ? esc_html($thepost['create_post_category']) : $_POST ? esc_html($items['create_post_category']) : ""; ?>" /><br /></td>
			</tr>
			<tr>
				<td colspan="2" align="right">
				<input type="submit" class="button-primary" name="submit" value="<?php echo $_REQUEST['edit'] ? "Update RSS" : "Add a New RSS"; ?>" />
				</td>
			</tr>
		</table>
		
	</form>
</div>
<?php
} //end ftf_rss_add_page()

//the feed listing page...
function ftf_rss_feeds_page() {

	//if WP_List_Table is not available, get it.
	if(!class_exists('WP_List_Table')) {
		require_once(ABSPATH . 'wp-admin/includes/class-wp-list-table.php');
	}

	//the class for the list table...
	class Four_Three_Five_RSS_List_Table extends WP_List_Table {
            
		function __construct() {
    		global $status, $page, $wp;
 			parent::__construct(array(
            			'singular'  => __( 'feed', 'rsslisttable' ),    
            			'plural'    => __( 'feeds', 'rsslisttable' ), 
            			'ajax'      => false
        		));	
		
			add_action('admin_head', array( &$this, 'admin_header'));            
 
		}
 
		function admin_header() {
			$page = (isset($_GET['page'])) ? esc_attr($_GET['page']) : false;
			//if('rss_list' != $page ) return;
				
			echo '<style type="text/css">';
			//echo '.wp-list-table .column-cb { width: 5%; }';
			echo '.wp-list-table .column-name { width: 10%; }';
			echo '.wp-list-table .column-url { width: 25%; }';
			echo '.wp-list-table .column-status { width: 5%; }';
			echo '.wp-list-table .column-embargo { width: 15%; }';
			echo '.wp-list-table .column-author { width: 15%; }';
			echo '.wp-list-table .column-product { width: 15%;}';
			echo '.wp-list-table .column-action { width: 10%;}';
			echo '</style>';
		}
 
  		function no_items() {
			_e( 'No feeds exist!' );
		}
 
		function column_default($item, $column_name) {
    		switch($column_name) { 
        		case 'name':
        		case 'url':
        		case 'status':
        		case 'embargo':
        		case 'author':
				case 'product':
				case 'action':
            		return $item[$column_name];
        	
        		default:
            		return print_r($item, true);
    			}
		} 

		function get_sortable_columns() {
  			$sortable_columns = array(
    			'name'  => array('name',false),
    			'url'  => array('url',false),
    			'status'  => array('status',false),
    			'embargo'  => array('embargo',false),
    			'author' => array('author',false)
    			//'product'   => array('product',false)
  			);
			return $sortable_columns;
		}

		function get_columns(){
  			$columns = array(
  				//'cb' => '<input type="checkbox" />',
    			'name' => __('Name','rsslisttable'),
    			'url' => __('Feed URL','rsslisttable'),
    			'status' => __('Status','rsslisttable'),
    			'embargo' => __('Use "Embargo Date"','rsslisttable'),
    			'author' => __('Author','rsslisttable'),
    			'product' => __('Product','rsslisttable'),
    			'action' => __('Action','rsslisttable')
  			);
 		 
			return $columns;
		} // end get_columns function
		
		function usort_reorder( $a, $b ) {
			//default to name
			$orderby = (!empty($_GET['orderby'])) ? $_GET['orderby'] : 'name';
			//default to asc
			$order = (!empty($_GET['order'])) ? $_GET['order'] : 'asc';
  			//sort order
  			$result = strcmp( $a[$orderby], $b[$orderby] );
  			//final sort direction, usort
  			return ($order === 'asc') ? $result : -$result;
		}
		
		function column_rssname($item){
			$actions = array(
            	'edit'      => sprintf('<a href="?page=%s&action=%s&feed=%s">Edit</a>',$_REQUEST['page'],'edit',$item['ID']),
            	'delete'    => sprintf('<a href="?page=%s&action=%s&feed=%s">Delete</a>',$_REQUEST['page'],'delete',$item['ID']),
        	);
  			return sprintf('%1$s %2$s', $item['name'], $this->row_actions($actions) );
		}
		
		/*function get_bulk_actions() {
  			$actions = array(
    				'delete'    => 'Delete'
  			);
  			
			return $actions;
		}*/
		
		function column_cb($item) {
        	return sprintf('<input type="checkbox" name="feed[]" value="%s" />', $item['ID']);
    	}
		
		function prepare_items() {
			global $wpdb, $_wp_column_headers;
			$screen = get_current_screen();		
			
			$query= "SELECT p.ID, 
							p.post_title as name,
							p.post_content as url,
				   			p.post_status as status,
				   			u.user_email as author,
				   			p.post_date as embargo
					FROM $wpdb->posts p,
							$wpdb->users u
					WHERE u.ID = p.post_author
					AND p.post_type = 'rss-post'
					AND p.post_status = 'publish'";
			
			$orderby = !empty($_GET["orderby"]) ? mysql_real_escape_string($_GET["orderby"]) : 'ASC';
			$order = !empty($_GET["order"]) ? mysql_real_escape_string($_GET["order"]) : '';
			if(!empty($orderby) & !empty($order)){ $query.=' ORDER BY '.$orderby.' '.$order; }

			$totalitems = $wpdb->query($query);
			$perpage = 20;
			$paged = !empty($_GET["paged"]) ? mysql_real_escape_string($_GET["paged"]) : '';

			if(empty($paged) || !is_numeric($paged) || $paged<=0 ){ $paged=1; }

			$totalpages = ceil($totalitems/$perpage);

			if(!empty($paged) && !empty($perpage)) {
				$offset=($paged-1)*$perpage;
				$query.=' LIMIT '.(int)$offset.','.(int)$perpage;
			}

			$this->set_pagination_args( array(
				"total_items" => $totalitems,
				"total_pages" => $totalpages,
			 	"per_page" => $perpage,
			) );

			$columns = $this->get_columns();
			$hidden   = array();
			$sortable = $this->get_sortable_columns();
			$this->_column_headers = array($columns, $hidden, $sortable);
			$current_page = $this->get_pagenum();
			$this->found_data = array_slice($wpdb->get_results($query),(($current_page-1) * $perpage), $perpage);
			
			//$_wp_column_headers[$screen->id]=$columns;
			$results = $wpdb->get_results($query, ARRAY_A);
			if($results) {
				$i=1;
				foreach($results as $result) {
					$post_category = (int)get_post_meta($result['ID'], '_post_category', true);
					$term = get_term($post_category,'product_cat',ARRAY_A);
					$final[$i]['ID'] = $result['ID'];
					$final[$i]['name'] = $result['name'];
					$final[$i]['url'] = '<a href="'.$result['url'].'" target="_blank">'.$result['url'].'</a>';
					$final[$i]['status'] = ucfirst($result['status']);
					$final[$i]['embargo'] = $result['embargo'];
					$final[$i]['author'] = '<a href="mailto:'.$result['author'].'" target="_blank">'.$result['author'].'</a>';
					$final[$i]['product'] = $term['name'];
					$final[$i]['action'] = '<a href="/wp-admin/admin.php?page=ftf_rss_add&edit='.$result['ID'].'" title="EDIT">EDIT</a> | <a href="/wp-admin/admin.php?page=ftf_rss_add&delete='.$result['ID'].'" title="DELETE" onclick="javascript:return confirm(\'Are you sure you wish to delete the &quot;'.$result['name'].'&quot; RSS feed?\');">DELETE</a>';
					$i++;
				}
			}
			$this->items = $final;
		}
		
		
	} // end Four_Three_Five_RSS_List_Table class

?>
<div class="wrap">
	<?php //echo get_435_logo(); ?><br />
	<div id="icon-users" class="icon32"></div>
		<h2>Feeds <a href="admin.php?page=ftf_rss_add" class="add-new-h2">Add New</a></h2>
		<form method="post">
    		<input type="hidden" name="page" value="rss_list_table" />
<?php
	$rssListTable = new Four_Three_Five_RSS_List_Table();
	
	$rssListTable->prepare_items();
	$rssListTable->admin_header();
	
	$rssListTable->display();	
?>
		</form>
	</div>
</div>
<?php
} //end ftf_rss_feeds_page()
//EOF!
