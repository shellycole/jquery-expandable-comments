jQuery(document).ready(function($) {

  $('.comment .children').hide();

  // TwentyTwelve and below
  $('.commentlist > li').each(function() {
    if( $(this).find('.children').length > 0 ) {
      $('li:has(ul), li:has(ol)').addClass('parent');
      $(this).find('.children').before('<div class="replylink"><span class="show">'+bb_toggle_vars.show+'</span></div>');
    }
  });

  // TwentyThirteen +
  $('.comment-list > li').each(function() {
    if( $(this).find('.children').length > 0 ) {
      $(this).find('.children').before('<div class="replylink"><span class="show">'+bb_toggle_vars.show+'</span></div>');
    }
  });

  $('.replylink').hover(function() {       // when hovering the replylink...
    $(this).css('cursor','pointer');       // change the cursor...
  }, function() { 
    $(this).css('cursor','auto'); 
  }).click(function() {                     // and on click...
    // change the text
    $(this).text( $(this).text() == bb_toggle_vars.hide ? bb_toggle_vars.show : bb_toggle_vars.hide); 
    // animate the vibility of the children
    var $nextDiv = $(this).next();
    var $visibleSiblings = $nextDiv.siblings('div:visible');
    if ($visibleSiblings.length == 0 ) {
        $visibleSiblings.slideToggle(bb_toggle_vars.toggle_down, bb_toggle_vars.easing);        
    } else {
        $nextDiv.slideToggle(bb_toggle_vars.toggle_up, bb_toggle_vars.easing);
    }
  });
});