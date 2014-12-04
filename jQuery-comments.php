<?php 
/*
Plugin Name: jQuery Comment Replies 2
Plugin URI: http://wordpress.org/extend/plugins/jquery-expandable-comments/
Description: Make your multi-level comment replies show on demand with a slick jQuery slideToggle() action.
Author: Shelly Cole
Version: 1.2.5
Author URI: http://brassblogs.com

    Copyright 2009-2011  Michelle Cole  (email : shelly@brassblogs.com)

    This program is free software; you can redistribute it and/or modify
    it under the terms of the GNU General Public License as published by
    the Free Software Foundation; either version 2 of the License, or
    (at your option) any later version.

    This program is distributed in the hope that it will be useful,
    but WITHOUT ANY WARRANTY; without even the implied warranty of
    MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
    GNU General Public License for more details.

    You should have received a copy of the GNU General Public License
    along with this program; if not, write to the Free Software
    Foundation, Inc., 51 Franklin St, Fifth Floor, Boston, MA  02110-1301  USA
*/

/**
 * Languages
 *
 * @since jQuery-comments 1.2
 */
function bb_jcr_languages() {
	load_plugin_textdomain('bb_jcr_languages', false, basename( dirname( __FILE__ ) ) . '/langs/' );
}

/**
 * Option defaults
 *
 * @since jQuery-comments 1.0
 */
function bb_add_jcr_options() {
	$options = get_option('bb_jcr_options');
        
        $update = array('login_text' 		=> $options['login_text'],
                        'expanded' 		=> $options['expanded'],
                        'show_replies' 		=> $options['show_replies'],
                        'hide_replies' 		=> $options['hide_replies'],
                        'toggle_down'		=> $options['toggle_down'],
                        'easing'		=> $options['easing'],
                       );

        $add    = array('login_text' 		=> __('Log in to Reply', 'bb_jcr_languages'),
                        'expanded'		=> '',
                        'show_replies' 		=> __('Show Replies', 'bb_jcr_languages'),
                        'hide_replies' 		=> __('Hide Replies', 'bb_jcr_languages'),
                        'toggle_down'		=> '3000',
                        'easing'		=> 'linear',
                       );

        if(array_key_exists('avatar_size', $options)) {
            update_option('bb_jcr_options', $update);
        } else {
            add_option('bb_jcr_options', $add, '', 'yes');
        }
}


/**
 * Optional custom comment format callback
 *
 * called into wp_list_comments through the options page, 
 * or through the comments template file
 * via wp_list_comments( array( 'callback' => 'bb_jcr_format_comment' ) );
 *
 * @since jQuery-comments 1.0
 * @deprecated jQuery-Comments 1.2.3
 */
function bb_jcr_format_comment($comment, $args, $depth) {
   $GLOBALS['comment'] = $comment; 
   $class = ''; //setup
   $id = get_comment_ID();
   $info = get_comment($id);
   $parent = $info->comment_parent; 
   if($args['has_children']) $class .= "parent ";
   if($parent > 0) $class .= "reply ";  
   $class .= 'clear'; ?>

   <li id="comment-<?php comment_ID(); ?>" <?php comment_class($class);?>>

   <?php if ($comment->comment_approved == '0') : ?>
   <em><?php __('Your comment is awaiting moderation.', 'bb_jcr_languages') ?></em><br />
   <?php endif; ?>
   
   <?php echo get_avatar($comment,32); ?>
   <div class="comment-author vcard clear">
     <?php comment_text(); ?> 

     <span class="authorinfo">
       <?php printf(__('%s'), get_comment_author_link()) ?>
       <a class="date" href="<?php echo htmlspecialchars( get_comment_link( $comment->comment_ID ) ) ?>">
         <?php printf(__('%1$s at %2$s'), get_comment_date(),  get_comment_time()) ?></a>
     <?php edit_comment_link(__('e'),'  | ','') ?>
     <?php comment_reply_link(array_merge( $args, array('add_below' => 'div-comment', 'depth' => $depth, 'max_depth' => $args['max_depth']))) ?>  
     </span>

   <!--/comment-author-->
   </div>
   
<?php
}


/**
 * Localize vars
 *
 * @since jQuery-comments 1.2
 */
function bb_localize_vars() {
	$options     = get_option('bb_jcr_options');
	$scriptstuff = array('expanded'     => $options['expanded'], 
                             'hide'         => $options['hide_replies'], 
                             'show'         => $options['show_replies'], 
                             'toggle_down'  => $options['toggle_down'],
                             'easing'       => $options['easing']);
	return $scriptstuff;
}


/**
 * Enqueue scripts
 *
 * @since jQuery-comments 1.0
 */
function bb_start_jquery() {
	wp_enqueue_script('jquery'); //get that jQuery started up 
	wp_enqueue_script('easing', plugins_url('js/jquery-ui-effects.js', __FILE__), array('jquery'), '', true); // easing
	wp_enqueue_script('bb_toggle_kids', plugins_url('js/bb-toggle-kids.js', __FILE__),  array('jquery'), '', true); // actual show/hide script
	wp_localize_script('bb_toggle_kids', 'bb_toggle_vars', bb_localize_vars()); // localize the script
}


/**
 * Enqueue stylesheet
 *
 * @since jQuery-comments 1.2.3
 */
function bb_start_styles() {
	//get whatever current theme is being used
	$theme = get_option('template');

	// add a list of all the default WordPress themes so we can pull in the matching stylesheet
	$themes = array('twentyten' 		=> 'bb_expandable_comments_2010.css', 
                        'twentyeleven'          => 'bb_expandable_comments_2011.css', 
			'twentytwelve'          => 'bb_expandable_comments_2012.css', 
			'twentythirteen'	=> 'bb_expandable_comments_2013.css', 
			'twentyfourteen'	=> 'bb_expandable_comments_2014.css');
        
	wp_enqueue_style( 'bb_toggle_comments', plugins_url( 'css/' . $themes[$theme], __FILE__) );
}


/**
 * Options page setup
 *
 * @since jQuery-comments 1.0
 */
function bb_jquery_comment_replies() {
	add_options_page('jQuery Comment Replies', __('jQuery Comment Replies', 'bb_jcr_languages'), 'manage_options', 'bb_jcr', 'bb_jcr_options_page');
}

function bb_jcr_options_page() { 															// the actual page contents ?>
<div class="wrap">
	<div id="icon-options-general" class="icon32"><br /></div>
	<h2><?php _e('jQuery Comment Replies', 'bb_jcr_languages'); ?></h2>
	<form action="options.php" method="post">
		<?php settings_fields('bb_jcr_options'); ?>
		<?php do_settings_sections('bb_jcr'); ?>
		<p><input name="submit" type="submit" id="submit" class="button-primary" value="<?php _e('Save Changes', 'bb_jcr_languages'); ?>" /></p>
	</form>
</div>
<?php } 

function bb_jcr_admin_init(){																// the options settings
	register_setting(    'bb_jcr_options', 			'bb_jcr_options', 				'bb_jcr_options_validate' );
	add_settings_section('bb_jcr_main', 			'', 						'bb_jcr_section_text', 				'bb_jcr'); 
	add_settings_field(  'bb_jcr_login_text', 		__('Login Text', 'bb_jcr_languages'), 		'bb_jcr_setting_string_login_text', 		'bb_jcr', 'bb_jcr_main');
	add_settings_field(  'bb_jcr_expanded',                 __('Expanded by default?', 'bb_jcr_languages'), 'bb_jcr_setting_string_expanded', 		'bb_jcr', 'bb_jcr_main');
	add_settings_field(  'bb_jcr_show_replies',             __('Show Replies Text', 'bb_jcr_languages'), 	'bb_jcr_setting_string_show_replies', 		'bb_jcr', 'bb_jcr_main');
	add_settings_field(  'bb_jcr_hide_replies',             __('Hide Replies Text', 'bb_jcr_languages'), 	'bb_jcr_setting_string_hide_replies', 		'bb_jcr', 'bb_jcr_main');
	add_settings_field(  'bb_jcr_toggle_down', 		__('Slide Speed', 'bb_jcr_languages'), 		'bb_jcr_setting_string_toggle_down', 		'bb_jcr', 'bb_jcr_main');
	add_settings_field(  'bb_jcr_easing', 			__('Easing Type', 'bb_jcr_languages'), 		'bb_jcr_setting_string_easing', 		'bb_jcr', 'bb_jcr_main');
}

function bb_jcr_section_text() {																
	echo '<p>' . __(sprintf('You can read up on the details of these parameters settings in the %1$sWP Codex%2$s.', '<a href="http://codex.wordpress.org/Function_Reference/wp_list_comments#Parameters" target="_blank">', '</a>'), 'bb_jcr_languages') . '</p>'; 
        echo '<p>' . __(sprintf('This plugin is now on %1$sGithub%2$s, if you\'d like to contribute or fork.', '<a href="https://github.com/shellycole/jquery-expandable-comments" target="_blank">', '</a>'), 'bb_jcr_languages') . '</p>';
        echo '<p>' . __(sprintf('%1$s Donate %2$s', '<a href="http://brassblogs.com/donate" target="_blank" style="display:inline-block; width:74px; height:21px; text-indent:-999px; overflow:hidden; background:url(\'https://www.paypal.com/en_US/i/btn/btn_donate_SM.gif\') no-repeat left top;">', '</a>'), 'bb_jcr_languages') . '</p>';
}

function bb_jcr_setting_string() {
	
	$options = get_option('bb_jcr_options');

	echo '<p class="description" style="display:block;">' . __(sprintf("The chosen format for your comments display. Note that DIV is not an option, due to the way WordPress core functions work. %s Using DIV with this plugin, because of the addition of markup, will break your site's layout.", '<br />'), 'bb_jcr_languages') . '</p>';
	
	echo '<input id="bb_jcr_style" name="bb_jcr_options[style]" size="40" type="radio" value="ul" ' 	. (isset($options["style"]) && $options["style"] == "ul" ? 'checked="checked" ' : '') 	. '/> ul<br />' . "\n";
	echo '<input id="bb_jcr_style" name="bb_jcr_options[style]" size="40" type="radio" value="ol" ' 	. (isset($options["style"]) && $options["style"] == "ol" ? 'checked="checked" ' : '') 	. '/> ol<br />' . "\n\n";
}

function bb_jcr_setting_string_type() {
	
	$options = get_option('bb_jcr_options');

	echo '<p class="description" style="display:block;">' . __('The type of comments to display. ("Ping" is trackbacks and pingbacks together.)', 'bb_jcr_languages') . '</p>'; 
	
	echo '<input id="bb_jcr_type" name="bb_jcr_options[type]" size="40" type="radio" value="all" ' 			. (isset($options["type"]) && $options["type"] == "all" 		? 'checked="checked" ' : '') 	. '/> ' . __('All', 		'bb_jcr_languages' ) . '<br />' 	. "\n";
	echo '<input id="bb_jcr_type" name="bb_jcr_options[type]" size="40" type="radio" value="comment" ' 		. (isset($options["type"]) && $options["type"] == "comment" 	? 'checked="checked" ' : '') 	. '/> ' . __('Comment', 	'bb_jcr_languages' ) . '<br />' 	. "\n";
	echo '<input id="bb_jcr_type" name="bb_jcr_options[type]" size="40" type="radio" value="trackback" ' 	. (isset($options["type"]) && $options["type"] == "trackback" 	? 'checked="checked" ' : '') 	. '/> ' . __('Trackback', 	'bb_jcr_languages' ) . '<br />' 	. "\n";
	echo '<input id="bb_jcr_type" name="bb_jcr_options[type]" size="40" type="radio" value="pingback" ' 	. (isset($options["type"]) && $options["type"] == "pingback" 	? 'checked="checked" ' : '') 	. '/> ' . __('Pingback', 	'bb_jcr_languages' ) . '<br />' 	. "\n";
	echo '<input id="bb_jcr_type" name="bb_jcr_options[type]" size="40" type="radio" value="pings" ' 		. (isset($options["type"]) && $options["type"] == "pings" 		? 'checked="checked" ' : '') 	. '/> ' . __('Pings', 		'bb_jcr_languages' ) . '<br />' 	. "\n\n";
}	

function bb_jcr_setting_string_login_text() {
	
	$options = get_option('bb_jcr_options');
	
	echo '<p class="description" style="display:block;">' . __('Text to display for the "login" message. Default is "Log in to Reply"', 'bb_jcr_languages') . '</p>' . "\n\n";

	echo '<input id="bb_jcr_login_text" name="bb_jcr_options[login_text]" size="40" type="text" value="' . $options["login_text"] . '"/>' . "\n\n";
}	

function bb_jcr_setting_string_expanded() {
	
	$options = get_option('bb_jcr_options');
        
	echo '<p class="description" style="display:block;">' . __('Check this box if you\'d like all the comments to show by default.', 'bb_jcr_languages') . '</p>' . "\n";

	echo '<input id="bb_jcr_expanded" name="bb_jcr_options[expanded]" type="checkbox" value="' . $options["expanded"] . '" ' . (!empty($options["expanded"]) ? 'checked="checked"' : '') . '/>' . "\n\n";
}	

function bb_jcr_setting_string_show_replies() {
	
	$options = get_option('bb_jcr_options');
	
	echo '<p class="description" style="display:block;">' . __('Text to display for the "Show Replies" link. Default is "Show Replies". Please see the readme.txt file for further information.', 'bb_jcr_languages') . '</p>' . "\n";

	echo '<input id="bb_jcr_show_replies" 		name="bb_jcr_options[show_replies]" 	  size="40" type="text" 	value="' 		. $options["show_replies"] . '"/>' . "\n\n";
}	

function bb_jcr_setting_string_hide_replies() {
	
	$options = get_option('bb_jcr_options');
	
	echo '<p class="description" style="display:block;">' . __('Text to display for the "Hide Replies" link. Default is "Hide Replies". Please see the readme.txt file for further information.', 'bb_jcr_languages') . '</p>' . "\n";

	echo '<input id="bb_jcr_hide_replies" 		name="bb_jcr_options[hide_replies]" 	  size="40" type="text" 	value="' 		. $options["hide_replies"] . '"/>' . "\n\n";
}

function bb_jcr_setting_string_toggle_down() {
	
	$options = get_option('bb_jcr_options');

	echo '<p class="description" style="display:block;">' . __('Speed of slide when opening/closing the replies. Enter in the number of milliseconds you would like it to take.  Default is 3000.', 'bb_jcr_languages') . '</p>' . "\n\n";

	echo '<input id="bb_jcr_toggle_down" name="bb_jcr_options[toggle_down]" size="40" type="text" value="' . $options['toggle_down'] . '"/>' . "\n\n";
}

function bb_jcr_setting_string_easing() {
	
	$options = get_option('bb_jcr_options');
	
	echo '<p class="description" style="display:block;">' . __(sprintf('Type of easing you would like the slide to use.  Default is "linear". You can see visual examples of other types you can use %1$s here %2$s.', '<a href="http://matthewlein.com/experiments/easing.html" target="_blank">', '</a>'), 'bb_jcr_languages') . '</p>' . "\n\n";

	// setup array
	$choices = array();
	$choices['Linear'] 		= 'linear';
	$choices['Swing'] 		= 'swing';
	$choices['EaseInOutQuad'] 	= 'easeInOutQuad';
	$choices['EaseInOutCubic'] 	= 'easeInOutCubic';
	$choices['EaseInOutQuart'] 	= 'easeInOutQuart';
	$choices['EaseInOutQuint'] 	= 'easeInOutQuint';
	$choices['EaseInOutSine'] 	= 'easeInOutSine';
	$choices['EaseInOutExpo'] 	= 'easeInOutExpo';
	$choices['EaseInOutCirc'] 	= 'easeInOutCirc';
	$choices['EaseInOutElastic'] 	= 'easeInOutElastic';
	$choices['EaseInOutBack']       = 'easeInOutBack';
	$choices['EaseInOutBounce'] 	= 'easeInOutBounce';

	echo '<p><select id="bb_jcr_easing" name="bb_jcr_options[easing]">' . "\n";
		
	foreach($choices as $key => $value) {
		if (isset($options["easing"]) && $options["easing"] == $value) $selected = ' selected="selected"';
		else $selected = '';
		echo '<option value="' . $value . '"' . $selected . '>' . $key .'</option>' . "\n";
	}	
	
	echo '</select></p>' . "\n";

}

function bb_jcr_options_validate($input) {
	isset($input['expanded'])                       ? $newinput['expanded']                 = 1                                             : $newinput['expanded']                 = 0;
	isset($input['login_text']) 			? $newinput['login_text'] 		= trim($input['login_text']) 			: $newinput['login_text'] 		= '';
	isset($input['show_replies']) 			? $newinput['show_replies'] 		= trim($input['show_replies']) 			: $newinput['show_replies'] 		= '';
	isset($input['hide_replies']) 			? $newinput['hide_replies'] 		= trim($input['hide_replies']) 			: $newinput['hide_replies'] 		= '';
	isset($input['toggle_down']) 			? $newinput['toggle_down'] 		= intval($input['toggle_down'])     		: $newinput['toggle_down'] 		= '';
	isset($input['easing']) 			? $newinput['easing'] 			= trim($input['easing']) 			: $newinput['easing'] 			= '';
	return $newinput;
}


/**
 * Start 'er up!
 *
 */
add_action('init', 		'bb_jcr_languages');		// languages
add_action('admin_init', 	'bb_add_jcr_options');		// options
add_action('init', 		'bb_start_jquery'); 		// scripts
add_action('init', 		'bb_start_styles'); 		// styles
add_action('admin_menu', 	'bb_jquery_comment_replies'); 	// options page/settings
add_action('admin_init', 	'bb_jcr_admin_init');		// option page/settings init

