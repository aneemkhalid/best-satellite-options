jQuery(document).ready(function ($) {
    $( document ).on( "click", ".more-articles-btn", function(e) {
        e.preventDefault();
        load_posts();
    });

    var pageNumber = 0;

    function load_posts(){
        var ppp = 4;
        var pageNumber = $('#pageno').val();
        var str = 'pageNumber=' + pageNumber + '&ppp=' + ppp + '&action=resources_post_load_more';
        $.ajax({
            type: "POST",
            dataType: "html",
            url: bso_ajax.ajaxurl,
            data: str,
            success: function(data){ 
                console.log(data);
                if(data === ''){
                    $(".all-articles").append(data);
                    $(".more-articles-btn").css({"display": "none"});
                } else {
                    $('#pageno').val( pageNumber );
                    $(".all-articles").append(data);
                    $(".more-articles-btn").css({"display": "inline-block"});
                    pageNumber++;
                    $('#pageno').val(pageNumber);
                }
            }
        });
        return false;
    }

    if ($('.zip_search_overview').length > 0){
        //var city;
        //var state;
      
      $.ajax(bso_ajax.ajaxurl, {
        dataType: "json",
        type: "POST",
        data: {
            action: 'load_zip_search',
            //city: city,
            //state: state,
        },
        success: function(data) {
            //console.log(data);
            $('.zip_search_overview').html(data.satellite);
            $('.zip-search-internet').html(data.internet);
            $('.internet_search_overview').show();
            
            //var currentCount = $('.zip_search .provider-count').text();
            // if(data.count > currentCount){
            //     $('.zip_search .provider-count').text(data.count);
            // }

            $('.count-container').show();
            // if (bso_ajax.site_environment === 'development'){
            //     $.getScript(bso_ajax.theme_path+"/js/header-scripts-delayed-dev.js");
            // } else {
            //     $.getScript(bso_ajax.theme_path+"/js/header-scripts-delayed.js");
            // }
            $.getScript(bso_ajax.theme_path+"/js/footer-scripts-delayed.js");
            $('.zip_search_overview').removeClass('zip_search_overview-load-height');

        }
    //   }, function(response) {
    //     console.log(response);
    //     $('.zip_search_overview').html(response.satellite).promise().done(function(){
    //         $('.provider-count').html(response.count);
    //         // if (bso_ajax.site_environment === 'development'){
    //         //     $.getScript(bso_ajax.theme_path+"/js/header-scripts-delayed-dev.js");
    //         // } else {
    //         //     $.getScript(bso_ajax.theme_path+"/js/header-scripts-delayed.js");
    //         // }
    //         $.getScript(bso_ajax.theme_path+"/js/footer-scripts-delayed.js");
    //         $('.zip_search_overview').removeClass('zip_search_overview-load-height');
    //     });
        //$('.zip_search_nav').show();
        // if (is_city && !is_programmatic_city_page){
        //     var zip = getUrlParameter('zip');
        //     if (zip != null){
        //         saveBDAPIDataforZip(zip);
        //     }
        // }
      });
    }
});