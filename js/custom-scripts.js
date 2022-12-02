jQuery(function($){  
     //add custom js in here.  you can use $()
    $('.faq-title-container').on('click', e => {
        $(e.currentTarget).next().slideToggle(400);
        $(e.currentTarget).find('img').toggleClass('rotate-180');
    });

    //nav menu
    $( '.primary-menu li' ).hover(
      function() {
        if ($(window).width() > 1199) {
            $( this ).find('.menu-item-link').addClass('hover-nav-color');
            $( this ).find('.menu-item-link').addClass('hover-nav-underline');
            $( this ).find('svg').addClass('icon-hover');
            $( this ).find('.submenu-container').show();
        }
      }, function() {
        if ($(window).width() > 1199) {
            $( this ).find('.menu-item-link').removeClass('hover-nav-color');
            $( this ).find('.menu-item-link').removeClass('hover-nav-underline');
            $( this ).find('svg').removeClass('icon-hover');
            $( this ).find('.submenu-container').hide();
        }
      }
    );

    
    $( '.primary-menu li.is_parent_nav>.menu-item-link' ).click(
      function(e) {
        if ($(window).width() < 1200 && e.target === e.currentTarget ) {
            e.preventDefault();
            $('.menu-item').addClass('slide-out-menu');
            $('.menu-item').removeClass('slide-in-menu');
        }
      }
    );

    $( '.primary-menu .back-item' ).click(
      function(e) {
        if ($(window).width() < 1200) {
            e.stopPropagation();
            $('.menu-item').removeClass('slide-out-menu');
            $('.menu-item').addClass('slide-in-menu');
        }
      }
    );

    $('.search-open').on('click', e => {
        $('.main-nav-header .search-container').animate({'margin-right': '0'}, 400, function() {
            $('.main-nav-header .search-container').css("z-index", "0");
        });
        $(e.currentTarget).hide();

        if ($(window).width() < 767) {
           $('.custom-logo-link').hide();
        }
    });

    $('#toggle-hamburger').on('click', e => {
        $(e.currentTarget).find('#navbar-hamburger').toggle();
        $(e.currentTarget).find('#navbar-close').toggle();
        $('body').toggleClass('mobile-menu-active');
        $('.overlay').toggle(0, () => {
        $('#primary-menu-sidebar').toggleClass('active');
        });
        $('.submenu').removeClass('active');
        $('.menu-item').removeClass('slide-out-menu');
        $('.menu-item').removeClass('slide-in-menu');
   });
   
   $('.overlay').on('click', e => {
        if(e.target === e.currentTarget) {  
            $('#toggle-hamburger').find('#navbar-hamburger').toggle();
            $('#toggle-hamburger').find('#navbar-close').toggle();
            $('body').toggleClass('mobile-menu-active');
            $('.overlay').toggle();
            $('.submenu').removeClass('active');
            $('#primary-menu-sidebar').toggleClass('active');

        }
   });



    $("#ez-toc-container .ez-toc-list li:first-child").addClass("active");
    
    var addClassOnScroll = function () {
        var windowTop = jQuery(window).scrollTop();
        jQuery('.entry-content h2 span[id]').each(function (index, elem) {
            var offsetTop = jQuery(elem).offset().top;
            var outerHeight = jQuery(this).outerHeight(true);
            var widnowsHeight = jQuery( window ).height();

            if( windowTop >= offsetTop - 100) {
                var elemId = jQuery(elem).attr('id');
                jQuery(".ez-toc-list li.active").removeClass('active');
                jQuery(".ez-toc-list li a[href='#" + elemId + "']").parent().addClass('active');
            }
        });
    };

    jQuery(function () {
        jQuery(window).on('scroll', function () {
            addClassOnScroll();
        });
        jQuery('body').on('click','.ez-toc-list > li',function(){
            addClassOnScroll();
        });
    });

    $('.zip-popup-btn').on('click', function(e) {
        e.preventDefault;
        $(this).parent().addClass('expanded');
    });

    $('.zip-cancel-btn').on('click', function(e) {
        e.preventDefault;
        $(this).parent().removeClass('expanded');
    });
    
    
    ////////////////////////////////////////////////////////////////////////////////////////////////////
    
    
    function getUrlParameter(sParam) {
    var sPageURL = window.location.search.substring(1),
        sURLVariables = sPageURL.split('&'),
        sParameterName,
        i;

    for (i = 0; i < sURLVariables.length; i++) {
        sParameterName = sURLVariables[i].split('=');

        if (sParameterName[0] === sParam) {
            if(sParameterName[0] == 'gclid') {
                sessionStorage.setItem('gclid', decodeURIComponent(sParameterName[1]));
            }
            return typeof sParameterName[1] === undefined ? true : decodeURIComponent(sParameterName[1]);
        }
    }
    if(sParam == 'gclid' && sessionStorage.getItem('gclid')) {
        return sessionStorage.getItem('gclid');
    }
    return false; 
};

function addGclidToInternalLinks(){
    var $gcidPresent = getUrlParameter('gclid');
    if ($gcidPresent && $gcidPresent != null){
        var domainsToDecorate = [
            'bestsatelliteoptions.com', //add or remove domains (without https or trailing slash)             
            'wpengine.com',
            'localhost:8888',
            'bestsatelliteoptions.test'
        ],
        queryParams = [
            'gclid', //add or remove query parameters you want to transfer
        ]
        // do not edit anything below this line
        var links = document.querySelectorAll('a'); 

        // check if links contain domain from the domainsToDecorate array and then decorates
        for (var linkIndex = 0; linkIndex < links.length; linkIndex++) {
            for (var domainIndex = 0; domainIndex < domainsToDecorate.length; domainIndex++) { 
                if (links[linkIndex].href.indexOf(domainsToDecorate[domainIndex]) > -1 && links[linkIndex].href.indexOf("#") === -1 && links[linkIndex].href.indexOf("gclid") === -1) {
                    links[linkIndex].href = decorateUrl(links[linkIndex].href);
                }
            }
        }
    }
    // decorates the URL with query params
    function decorateUrl(urlToDecorate) {
        urlToDecorate = (urlToDecorate.indexOf('?') === -1) ? urlToDecorate + '?' : urlToDecorate + '&';
        var collectedQueryParams = [];
        for (var queryIndex = 0; queryIndex < queryParams.length; queryIndex++) {
            if (getQueryParam(queryParams[queryIndex])) {
                collectedQueryParams.push(queryParams[queryIndex] + '=' + getQueryParam(queryParams[queryIndex]))
            }
            else if(sessionStorage.getItem('gclid')) {
                collectedQueryParams.push('gclid=' + sessionStorage.getItem('gclid'));
            }
        }
        return urlToDecorate + collectedQueryParams.join('&');
    }
    //retrieves the value of a query parameter
    function getQueryParam(name) {
        if (name = (new RegExp('[?&]' + encodeURIComponent(name) + '=([^&]*)')).exec(window.location.search))
            return decodeURIComponent(name[1]);
    }
}

//adds gclid to search forms
function addGclidToSearch(){
    var gclid = getUrlParameter('gclid');
    if (gclid && $('.zip_search_form .zip_search_input').length){
        $('.zip_search_form .zip_search_input').after('<input type="hidden" name="gclid" value="'+gclid+'">');
    }
}

/**
 * Retrieves gclid param from url and injects it into all
 * href values that contain the {$gclid} substring variable
 */
function populateAffClickID() {
    const urlParams = new URLSearchParams(window.location.search);
    const gclid = getUrlParameter('gclid');

    
    if(gclid) {
        // select all a tags where the value of href
        // contains the substring "gclid"
        $('a[href*="gclid"]').each((i, el) => {
           
            // some of the urls have encoded special characters
            const trackingUrl = decodeURI($(el).attr('href'));
            const trackingUrlParams = new URLSearchParams(trackingUrl);

                const updatedLink = trackingUrl.replace('{$gclid}', gclid).replace('$gclid', gclid);
                $(el).attr('href', updatedLink);

        });
    }

    const ifLoadedInvoca =   setInterval(function(){ handleInvocaParam(ifLoadedInvoca) }, 513);
    const ifLoadedGA =   setInterval(function(){ handleGAParam(ifLoadedGA) }, 499);
        
   
}


//check if Invoca loaded
var numOfTriesInvoca = 0;
const handleInvocaParam = (ifLoadedInvoca) => {
    
    numOfTriesInvoca++;    
    
     //turn off if 8 seconds has passed
    if(numOfTriesInvoca === 16 ) {  
        clearInterval(ifLoadedInvoca);
    }

        if (typeof Invoca !== undefined ) {            
     
             clearInterval(ifLoadedInvoca);   
            
             var thisTelNumber = [ "tel:", "PhoneNumber" ];            
             const trackingPageURLOrg = window.location.href;
             const trackingPageURL = trackingPageURLOrg.replace(/\=/g, "-");
            
            //buy flow tracking links
            
            $('a[href*="bsopageurl"]').each((i, el) => {

                 
                var checkIfDivReal = $(el).closest('div').find('a[href*="tel:"]').attr('href');
           
                 if( checkIfDivReal !== undefined){
                     
                     thisTelNumber = $(el).closest('div').find('a[href*="tel:"]').attr('href');                 
                     
                    if (thisTelNumber.indexOf('+') != -1 ) {
                       thisTelNumber = thisTelNumber.split("+");

                    } else {
                        thisTelNumber = thisTelNumber.split(":");
                    }
                 }
                // some of the urls have encoded special characters
                const trackingUrl = decodeURI($(el).attr('href'));
                const trackingUrlParams = new URLSearchParams(trackingUrl);
      

                const updatedLink = trackingUrl.replace('{$bsopageurl}', trackingPageURL).replace('$bsopageurl', trackingPageURL).replace('{$bsophonenum}', thisTelNumber[1]).replace('$bsophonenum', thisTelNumber[1]);
                $(el).attr('href', updatedLink);

            });
 
            
        }    
   
}


//add the client id to the href links

var numOfTries = 0;

const handleGAParam = (ifLoadedGA) => {
    
    numOfTries++;    

     //turn off if 8 seconds has passed
    if(numOfTries === 16 ) {  
        clearInterval(ifLoadedGA);
    }
 
    if(window.ga && ga.loaded) {    

        //a check for FF private tab that blocks GA
        if (ga.getAll()[0] !== undefined ) {
            
            const gaparam = ga.getAll()[0].get('clientId');
            clearInterval(ifLoadedGA);

                $('a[href*="clientid"]').each((i, el) => {

                    const trackingUrl = decodeURI($(el).attr('href'));
                    const trackingUrlParams = new URLSearchParams(trackingUrl);
             
                        const updatedLink = trackingUrl.replace('{$clientid}', gaparam).replace('$clientid', gaparam);        
                        $(el).attr('href', updatedLink);
      

                });
        }    
    }
   
}
    
    //add gclid to all internal links on page
    addGclidToInternalLinks();

    //add gclid to all search forms
    addGclidToSearch();

    // Pass gclid param to cta links
    populateAffClickID();    

});

