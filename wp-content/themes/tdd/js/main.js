// Cookie functions
function setCookie(key, value, expiry) {
    var expires = new Date();
    expires.setTime(expires.getTime() + (expiry * 24 * 60 * 60 * 1000));
    document.cookie = key + '=' + value + ';path=/' + ';expires=' + expires.toUTCString();
}

function getCookie(key) {
    var keyValue = document.cookie.match('(^|;) ?' + key + '=([^;]*)(;|$)');
    return keyValue ? keyValue[2] : null;
}

function eraseCookie(key) {
    var keyValue = getCookie(key);
    setCookie(key, keyValue, '-1');
}

// Adjust the content top padding based on the height of the fixed header
function adjustContentTop() {
    if ( jQuery('.site-header').length && ( jQuery('.site > .container').length || jQuery('.as4-tpl__wrapper.main-content').length ) ) {
        const headerHeight = jQuery('.site-header').outerHeight();

        jQuery('.site > .container, .as4-tpl__wrapper.main-content').css('padding-top', headerHeight);
    }
}

jQuery(document).ready( function() {

    // Readjust content top padding
    jQuery(window).on( 'load', function() {
        if ( jQuery('.home').length ) {
            // Do nothing
        } else {
            adjustContentTop();
        }
    });
    jQuery(window).on( 'resize', function() {
        if ( jQuery('.home').length ) {
            // Do nothing
        } else {
            adjustContentTop();
        }
    });

    // Identify when page is scrolled
    jQuery(window).on( 'load scroll', function() {
        if ( window.pageYOffset > 50 ) {
            jQuery( '.site-header' ).addClass( 'scrolled-header' );
        } else {
            jQuery( '.site-header' ).removeClass( 'scrolled-header' );
        }
    });

    // Testimonial Slider
    if ( jQuery( '.testimonial-slides' ).length ) {
        jQuery( '.testimonial-slides' ).slick({
            adaptiveHeight: false,
            autoplay: true,
            autoplaySpeed: 3500,
            fade: true,
            dots: false,
            arrows: true,
        });
    }

    // Case Study Carousel
    if ( jQuery( '.case-carousel' ).length ) {
        jQuery( '.case-carousel' ).slick({
            adaptiveHeight: false,
            autoplay: true,
            dots: false,
            arrows: true,
            fade: true,
            infinite: true,
            autoplaySpeed: 3500,
            // slidesToShow: 3,
            // slidesToScroll: 1,
            // responsive: [
            //     {
            //         breakpoint: 960,
            //         settings: {
            //             slidesToShow: 2,
            //             slidesToScroll: 1,
            //             centerMode: true,
            //         }
            //     },
            //     {
            //         breakpoint: 450,
            //         settings: {
            //             slidesToShow: 1,
            //             slidesToScroll: 1,
            //             centerMode: true,
            //         }
            //     },
            //   ]
        });
    }

    // Case Images/Video Slideshow
    if ( jQuery( '.case-single__slides' ).length ) {
        jQuery( '.case-single__slides' ).slick({
            adaptiveHeight: true,
            autoplay: false,
            dots: false,
            arrows: true,
            fade: true,
            infinite: true,
            autoplaySpeed: 3500,
        });
    }   

    // Tabs
    if ( jQuery('.tabs-horizontal').length ) {
        jQuery('.tabs-horizontal').tabs({
            show: 'fadeIn',
            hide: 'fadeOut',
        });
    }

    // Mobile Tabs
    if ( jQuery('.mtab-select').length ) {
        jQuery('.mtab-select').on( 'change', function(e) {
            e.preventDefault();

            const curVal = jQuery(this).val();
            const targetElem = jQuery('a[href="' + curVal + '"]');
            
            targetElem.trigger('click');
        });
    }

    // Webinar/Guides Mobile Tabs
    // if ( jQuery('.sf-mtab-select').length ) {
    //     jQuery('.sf-mtab-select').on( 'change', function(e) {
    //         e.preventDefault();

    //         const selectTarget = jQuery(this).data('target');
    //         const targetElem = '#' + selectTarget + ' ' + jQuery(this).val() + ' input[type="radio"]';

    //         jQuery(targetElem).trigger('click');
    //     });
    // }

    // Announcement Bar
    // if ( jQuery('.close-btn').length  ) {
    //     jQuery('.close-btn').on('click', function(e){
    //         if ( jQuery(this).parent().hasClass('content-announcement-bar') ) {
    //             setCookie('annclosed', '1', 1);
    //             jQuery(this).parent('.content-section').fadeOut('fast', adjustContentTop);
    //         }
    //     });
    // }

    // Toggle footer menus
    if ( jQuery('[class*="menu-column"] .footer-column-heading').length ) {
        jQuery(window).on( 'load resize', function(e) {
            jQuery('[class*="menu-column"] nav').each(function() {
                if ( jQuery(window).width() < 768 ) {
                    if ( !jQuery(this).hasClass('close-footer-menu') ) {
                        jQuery(this).addClass('close-footer-menu').stop().slideToggle('medium');
                    }
                } else {
                    if ( jQuery(this).hasClass('close-footer-menu') ) {
                        jQuery(this).removeClass('close-footer-menu').stop().slideDown();
                    }
                }
            });

            jQuery('[class*="menu-column"] .footer-column-heading').each(function() {
                if ( jQuery(window).width() < 768 ) {
                    if ( jQuery(this).hasClass('open-footer-menu') ) {
                        jQuery(this).removeClass('open-footer-menu');
                    }
                } else {
                    if ( !jQuery(this).hasClass('open-footer-menu') ) {
                        jQuery(this).addClass('open-footer-menu');
                    }
                }
            });
        });

        jQuery('[class*="menu-column"] .footer-column-heading').on( 'click', function(e) {
            if ( jQuery(window).width() < 768 ) {
                jQuery(this).toggleClass('open-footer-menu');
                jQuery(this).next('nav').toggleClass('close-footer-menu').stop().slideToggle('medium');
            }
        });
    }

    // Counter animation
    var section = document.querySelector('.content-statistics, .content-case-statistics');
    var hasEntered = false;
    
    ['load', 'scroll'].forEach(function(e) {
        window.addEventListener(e, function() {
            if ( document.body.contains(section) ) {
                var shouldAnimate = (window.scrollY + window.innerHeight) >= section.offsetTop;
    
                if ( shouldAnimate && !hasEntered) {
                    hasEntered = true;
                
                    jQuery('.counter-whole').each(function () {
                        jQuery(this).prop('Counter',0).animate({
                            Counter: jQuery(this).text()
                        }, {
                            duration: 3000,
                            easing: 'swing',
                            step: function (now) {
                                jQuery(this).text(Math.ceil(now));
                            }
                        });
                    });
                }
            }
        });
    });

    // Back button
    if ( jQuery('.go-back').length ) {
        jQuery('.go-back').on( 'click', function(e) {
            e.preventDefault();

            window.history.back();
        });
    }

    // Popup Youtube videos
    // if ( jQuery('.popup-youtube').length ) {
    //     jQuery('.popup-youtube').magnificPopup({
    //         // disableOn: 700,
    //         type: 'iframe',
    //         mainClass: 'mfp-fade',
    //         removalDelay: 160,
    //         preloader: false,
    //         fixedContentPos: false
    //     });
    // }

    if ( jQuery('.accordion-wrapper').length ) {
        jQuery('.accordion-wrapper').accrdion({
            openFirstByDefault: false,   // [true, false]
            displayStyle: 'any',     // ['single', 'any']
            scrollToActive: false,       // [true, false]
        });
    }

    if ( jQuery('.popup-with-zoom-anim').length ) {
        jQuery('.popup-with-zoom-anim').magnificPopup({
            type: 'inline',

            fixedContentPos: false,
            fixedBgPos: true,

            overflowY: 'auto',

            closeBtnInside: true,
            preloader: false,
            
            midClick: true,
            removalDelay: 300,
            mainClass: 'tdd-mfp-zoom-in'
        });
    }

    // Popup embed content
    if ( jQuery('.open-popup-link').length ) {
        jQuery('.open-popup-link').magnificPopup({
            type: 'inline',
            alignTop: false,
            showCloseBtn: true,
            closeBtnInside: true,
            midClick: true // Allow opening popup on middle mouse click. Always set it to true if you don't provide alternative source in href.
        });
    }

    // Vertical Tabs
    if ( jQuery('.tabs-vertical').length ) {
        jQuery('.tabs-vertical').tabs().addClass('ui-tabs-vertical ui-helper-clearfix');
        jQuery('.tabs-vertical li.tab-control-key').removeClass('ui-corner-top').addClass('ui-corner-left');
    }

    // Tooltips
    // if ( jQuery('.has-tooltip').length ) {
    //     jQuery('.has-tooltip').tipTop();
    // }

    // Sticky Sidebar
    if ( jQuery('.content-content-sidebar .hc-sticky').length ) {
        jQuery('.content-content-sidebar .hc-sticky').hcSticky({
            stickTo: jQuery('.pseudo-sidebar'),
            top: 100,
            bottom: 40,
            followScroll: false,
            responsive: {
                767: {
                    disable: true
                }
            },
        });
    }

    // Navigation Cards | Content Sidebar Menu
    if ( jQuery('.content-navigation-cards a').length || jQuery('.float-menu-item a').length ) {
        jQuery('.content-navigation-cards a, .float-menu-item a').on( 'click', function (e) {
            e.preventDefault();
    
            const targetHref = jQuery(this).attr('href');
            const targetElem = jQuery(targetHref);
            const targetOffset = 150;
    
            jQuery('html,body').animate({
                scrollTop: targetElem.offset().top - targetOffset
            }, 1500);
        });
    }
});