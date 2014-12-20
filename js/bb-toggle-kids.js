jQuery(document).ready(function($) {
  var $show_open_by_default = bb_toggle_vars.expanded;
  var $showtext = bb_toggle_vars.show;
  var $hidetext = bb_toggle_vars.hide;
  var $speed = parseInt(bb_toggle_vars.toggle_down); // make it an integer
  var $easing = bb_toggle_vars.easing;
  
  if($show_open_by_default != 1) { // if setting is unchecked...
      $('.comment .children').hide(); // hide all children on load
  }

  // TwentyTwelve and below
  $('.commentlist > li, .comment-list > li').each(function() {
    if( $(this).find('.children').length > 0 ) {
      
      //if($('.commentlist > li').length()) { // TwentyTwelve and below
        $('li:has(ul), li:has(ol)').addClass('parent');
      //}
      
      if($show_open_by_default == 1) {
            $(this).find('.children').before('<div class="replylink"><span class="show">'+$hidetext+'</span></div>');
      } else {
            $(this).find('.children').before('<div class="replylink"><span class="show">'+$showtext+'</span></div>');
      }
    }
  });

  $('.replylink').hover(function() {       // when hovering the replylink...
    $(this).css('cursor','pointer');       // change the cursor...
  }, function() { 
    $(this).css('cursor','auto'); 
  }).click(function() {                     // and on click...
    // change the text
    if($show_open_by_default == 1) {
      $(this).text( $(this).text() == $showtext ? $hidetext : $showtext);
    } else {
      $(this).text( $(this).text() == $hidetext ? $showtext : $hidetext); 
    }
    
    // animate the visibility of the children
    var $nextDiv = $(this).next();
    var $visibleSiblings = $nextDiv.siblings('div:visible');
    
    if ($visibleSiblings.length == 0 ) {
        $visibleSiblings.slideToggle($speed, $easing);      
    } else { 
        $nextDiv.slideToggle($speed, $easing);
    }
  });
});