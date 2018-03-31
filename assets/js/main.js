// JS is equivalent to the normal "bootstrap" package
require('bootstrap');

var $ = require('jquery');

// ...rest of JavaScript code here
require('./public/assets/frontend/vendor/jquery-migrate/jquery-migrate.min.js'),
require('./public/assets/frontend/vendor/popper.min.js'),
require('./public/assets/frontend/vendor/bootstrap/offcanvas.js'),
require('./public/assets/frontend/vendor/hs-megamenu/src/hs.megamenu.js'),
require('./public/assets/frontend/vendor/dzsparallaxer/dzsparallaxer.js'),
require('./public/assets/frontend/vendor/dzsparallaxer/dzsscroller/scroller.js'),
require('./public/assets/frontend/vendor/dzsparallaxer/advancedscroller/plugin.js'),
require('./public/assets/frontend/vendor/masonry/dist/masonry.pkgd.min.js'),
require('./public/assets/frontend/vendor/imagesloaded/imagesloaded.pkgd.min.js'),
require('./public/assets/frontend/vendor/slick-carousel/slick/slick.js'),
require('./public/assets/frontend/vendor/fancybox/jquery.fancybox.min.js'),
require('./public/assets/frontend/vendor/gmaps/gmaps.min.js'),
require('./public/assets/frontend/js/hs.core.js'),
require('./public/assets/frontend/js/components/gmap/hs.map.js'),
require('./public/assets/frontend/js/components/hs.header.js'),
require('./public/assets/frontend/js/helpers/hs.hamburgers.js'),
require('./public/assets/frontend/js/components/hs.popup.js'),
require('./public/assets/frontend/js/components/hs.carousel.js'),
require('./public/assets/frontend/js/components/hs.go-to.js'),
require('./public/assets/frontend/js/custom.js')

// no need to set this to a variable, just require it
$(document).on('ready', function() {
    // initialization of go to
    $.HSCore.components.HSGoTo.init('.js-go-to');

    // initialization of carousel
    $.HSCore.components.HSCarousel.init('.js-carousel');

    $('#we-provide').slick('setOption', 'responsive', [
        {
            breakpoint: 992,
            settings: {
                slidesToShow: 2
            }
        }, {
            breakpoint: 576,
            settings: {
                slidesToShow: 1
            }
        }
    ], true);

    // initialization of carousel
    $.HSCore.components.HSCarousel.init('.js-carousel');

    // initialization of masonry
    $('.masonry-grid').imagesLoaded().then(function () {
        $('.masonry-grid').masonry({
            columnWidth: '.masonry-grid-sizer',
            itemSelector: '.masonry-grid-item',
            percentPosition: true
        });
    });

    // initialization of popups
    $.HSCore.components.HSPopup.init('.js-fancybox');
});

$(window).on('load', function () {
    // initialization of header
    $.HSCore.components.HSHeader.init($('#js-header'));
    $.HSCore.helpers.HSHamburgers.init('.hamburger');

    // initialization of HSMegaMenu component
    $('.js-mega-menu').HSMegaMenu({
        event: 'hover',
        pageContainer: $('.container'),
        breakpoint: 991
    });
});
