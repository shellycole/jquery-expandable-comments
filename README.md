# jQuery Comment Replies

jQuery Comment Replies WordPress plugin.  You can find it in the [WordPress repository here](https://wordpress.org/support/view/plugin-reviews/jquery-expandable-comments).

Simple plugin to show/hide comment replies, rather than have them all listed.  An options page makes it really easy to change different parts of your comment calls.

#### Features  
This keeps the default "[`wp_list_comments()`](http://codex.wordpress.org/Function_Reference/wp_list_comments)" features.  A clickable span that triggers the action to expand the replies is also added.  


#### Options Page

The items you can mess with here will edit the arguments for `wp_list_comments()`, so you no longer need to add arguments to your call. In fact, if you have arguments in your old `bb_list_comments` call (from previous versions of this plugin -that function is now deprecated), they will be ignored.  The only sections to comment on (because they are not a part of the Codex) are:

  * __Show Replies Text/Hide Replies Text.__  These items are the text you set for the show/hide links.  

  * __Stylesheets.__  The plugin will see what theme you are using.  If you're using a default WordPress theme, then styles will be applied that match your active theme. Otherwise, no styles will be applied. You can go to the wp-content/plugins/jquery-expandable-comments/css folder and use any of these stylesheets as a reference to style it yourself in your own theme stylesheet.

  * __Slide Speed (both open and close).__  This is the speed of the animation for opening and closing the replies.  You MUST enter a numeric value, default is 3000. The numeric value should be in milliseconds.  If left blank, the animation will be disabled.

  * __Easing Type.__  The jQuery Easing plugin has been added so you have more animation options.  Simply choose which animation you want to use, and it will be applied to both the opening and closing of replies.


__Other Notes:__ The "callback" section is discussed in the codex, but there's no example of how to use it.  If you want to format the layout of your comments, then you need to use a callback function to rearrange the HTML.  This plugin comes with a callback function you can use (`bb_jcr_format_comment`), if you like.  It's mostly unstyled if you choose to use it, so you'll have to edit your stylesheet for it.  If you want to customize your own layout, feel free to copy the function (located within jQuery-comments.php, around line 76) and paste it into your theme's functions.php file.  __You WILL have to rename the function, or you'll get a fatal error.__  Once you rename the function (or if you choose to use the one supplied), take that name and pop it into the `wp_list_comments()` array in your comments.php file.

There's several tutorials available for how to edit the comment layout, but [Jeremy Clark](http://clark-technet.com/2008/11/wordpress-27-comment-callback-function)'s is the one that actually started this plugin.


#### Frequently Asked Questions 

__How do I use an image for the Show/Hide Replies text?__
If you want to use an image in place of (or with) the text, then use CSS to pull that off (this example has the image, named "sprite.png", uploaded to the theme's images directory).  An example:

    .replylink span {
    	display:inline-block;
    	background:url("images/sprite.png") no-repeat left top;
    	width:20px;
    	height:20px;
    	overflow:hidden;
    	line-height:50px; /* make text disappear */
    }

__No other questions at this time.__
But if you have any, by all means, feel free to ask away.  I'd also love input on features you'd like added or things you'd like to see to improve this plugin.  

#### Screenshots
1. Example of the comment replies being hidden.
![alt text](https://ps.w.org/jquery-expandable-comments/assets/screenshot-1.png?rev=687061 "Example of hidden state")

2. Example of the comment replies being shown.
![alt text](https://ps.w.org/jquery-expandable-comments/assets/screenshot-2.png?rev=687061 "Example of open state")


#### Changelog 

__1.2.5__

* added in an option to have all comments expanded by default
* fixed stylesheet call to pull in proper template
* swapped the old jQuery easing plugin for the updated jQuery UI Effects
* put language files in the correct folder
* fixed CSS to work better in IE
* edited settings page to fix slide speed - you must now use an integer
* removed options that are set within the `wp_list_comments()` function within your theme's comments.php file:  
  * reverse children
  * avatar size (note, in Twenty Fourteen, you also have to edit the style.css file)
  * list style option
  * type
  * callback
  * reply

__1.2.4__

* further troubleshooting issues with bb-toggle-kids.js - issues repaired.
* tested in default WordPress themes from Twenty Ten to Twenty Fourteen.
* edited and streamlined options page a bit
* deprecated the "Callback" in the options page. You can still use it, but I'd move away from it - the next release will only have it as a reference and not use it at all.

__1.2.2__

* further troubleshooting issues with the repository.  Discovered the CDN is not allowed to be added to the plugin, so have reverted back to including the jQuery easing js file.

__1.2.1__

* had some issues with updating the WordPress repository (for some reason, wouldn't upload certain files, refused to delete others). Finally got it all sorted.  Sorry for the delay.

__1.2__

*  removed local jquery easing library, reverted to cdn
*  edited script to work with TwentyThirteen (TwentyThirteen renamed the 'li.commentlist' to 'li.comment-list')
* added previously unavailable "div" option.
* fixed script localization
* removed the necessity of rewriting the Walker_Comment class.  This renders the use of `bb_list_comments()` unneccessary.
* previously, there were no styles set for this plugin, but due to popular demand, I've put in a default stylesheet.
* finally actually figured out how to set up translation correctly. Yay! pot/mo files added.

__1.1__

*  fixed a bug when clicking show/hide made the child divs "bounce"

__1.0__

* Newly revamped code, been rewritten for Wordpress 3.5 and cleaned up a bit.
* Options page added to make it really easy to edit text, animations, and speed, as well as making other options for `wp_list_comments` easy to manage.

__0.3__

*  Edited code to better detect what Pages/posts to add the script on.
* Added text changing functionality to the "Show/Hide Replies" link, so now it'll say "Show Replies" when child comments are closed, and "Hide Replies" when they are open.

__0.2.1__ 

* Edited readme file and stable version of plugin.

__0.2__

* Upgraded for 3.1 usage
* cleaned up/streamlined/updated code
* made it easier to install - no more renaming/moving files around. Simply upload and activate.
* no extra jQuery files - uses WP's system instead. 

__0.1__

* First release.
