$(function () {
    // INITIALIZATIONS

    activateLinks();

    var sidebarWrapper = $('.sidebar:first-child').parents('.side-wrapper:first');
    var profileContent = $('#profile-content');

    $('.sidebar-toggle').on('click', function () {

        sidebarWrapper.toggle(0, 'swing', onSidebarToggle());

    });

    $(window).on('resize', function () {
        if (window.innerWidth < 768) {
            sidebarWrapper.fadeIn(200);

        } else if (window.innerWidth >= 768) {
            var d = sidebarWrapper.css('display');
            if (d === 'block') {
                //profileContent.removeClass('col-md-12 col-sm-12').addClass('col-md-9 col-sm-8');
                profileContent.removeClass('col-md-12 col-sm-12')
                    .addClass('col-md-9 col-sm-8')
                    .parents('#mainContainer')
                    .removeClass('container')
                    .addClass('container-fluid')
            }
        }
    });


    // FUNCTIONS

    function onSidebarToggle() {
        var d = sidebarWrapper.css('display');

        if (!d || d === 'none') {
            profileContent.removeClass('col-md-12 col-sm-12')
                .addClass('col-md-9 col-sm-8')
                .parents('#mainContainer')
                .removeClass('container')
                .addClass('container-fluid')

        } else if (d === 'block') {
            profileContent.removeClass('col-md-9 col-sm-8')
                .addClass('col-md-12 col-sm-12')
                .parents('#mainContainer')
                .removeClass('container-fluid')
                .addClass('container');
        }
    }

    function activateLinks() {
        var currHref = location.href.replace('#', '');
        var currPath = location.pathname.replace('#', '');
        //var fullPath = currPath + location.search;

        //console.log(fullPath);

        var navs = $('.nav:not(.nav-static)');

        navs.each(function () {
            var nav = $(this);
            var currLink = nav.find('a').filter(function () {
                var cl = $(this);
                if (cl.prop('href') === currHref) {
                    return true;
                } else {
                    // TODO://
                }
            });

            if (!currLink.length) return;

            currLink.attr('current', true);
            nav.find('.active').removeClass('active');
            currLink.parent().addClass('active');
        });
    }
});












