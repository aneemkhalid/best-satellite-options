//Invoca Code for https://www.highspeedoptions.com
(function(i,n,v,o,c,a) { i.InvocaTagId = o; var s = n.createElement('script'); s.type = 'text/javascript'; s.async = true; s.src = ('https:' === n.location.protocol ? 'https://' : 'http://' ) + v; var fs = n.getElementsByTagName('script')[0]; fs.parentNode.insertBefore(s, fs); })(window, document, 'solutions.invocacdn.com/js/invoca-latest.min.js', '1886/3934625857');

addGclidToInternalLinks();
populateAffClickID();

jQuery(function($){  

  $('.provider-more-info .collapse').on('show.bs.collapse', function() {
    console.log('show');
    var view = $(this).parents('.collapsed-content').find('.view-more-btn');
    view.css('border-bottom-color', '#CDCDCD');
    view.find('.detail-text').text('Hide Details');
    view.find('.icon').css('transform', 'rotate(180deg)')
    $(this).find('.nav-tabs li:first a').addClass('active');
    $(this).find('.tab-content div:first-of-type').addClass('active show');
    
  });
  $('.provider-more-info .collapse').on('hide.bs.collapse', function() {
    var view = $(this).parents('.collapsed-content').find('.view-more-btn');
    view.css('border-bottom-color', 'transparent');
    view.find('.detail-text').text('View Details');
    view.find('.icon').css('transform', 'rotate(0deg)')
  });
});