jQuery(document).ready(function() {
  reorganize_header();
  jQuery(window).resize(reorganize_header);
});


function reorganize_header() {
  if (jQuery(window).width() >= 1170 || jQuery(window).width() <= 767) {
    jQuery('.navbar').addClass('navbar-fixed-top');
  } else {
    jQuery('.navbar').removeClass('navbar-fixed-top');
  }
}
