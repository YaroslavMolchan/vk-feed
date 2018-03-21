(function ($) {
    "use strict"; // Start of use strict

    // Smooth scrolling using jQuery easing
    $('a[href*="#"]:not([href="#"])').click(function () {
        if (location.pathname.replace(/^\//, '') == this.pathname.replace(/^\//, '') && location.hostname == this.hostname) {
            var target = $(this.hash);
            target = target.length ? target : $('[name=' + this.hash.slice(1) + ']');
            if (target.length) {
                $('html, body').animate({
                    scrollTop: (target.offset().top - 48)
                }, 1000, "easeInOutExpo");
                return false;
            }
        }
    });

    // Activate scrollspy to add active class to navbar items on scroll
    $('body').scrollspy({
        target: '#mainNav',
        offset: 54
    });

    // Closes responsive menu when a link is clicked
    $('.navbar-collapse>ul>li>a').click(function () {
        $('.navbar-collapse').collapse('hide');
    });

    // Collapse the navbar when page is scrolled
    $(window).scroll(function () {
        if ($("#mainNav").offset().top > 100) {
            $("#mainNav").addClass("navbar-shrink");
        } else {
            $("#mainNav").removeClass("navbar-shrink");
        }
    });

    // Code form toggler
    $('.form-toggler').click(function (event) {
        event.preventDefault();
        var $formBlock = $('.code-form');

        if ($formBlock.is(':visible')) {
            $formBlock.hide(300);
        } else {
            $formBlock.show(300);
        }
    });

    $('.code-form form').submit(function (event) {
        event.preventDefault();

        $.ajax({
            type: 'POST',
            url: $(this).attr('action'),
            data: new FormData(this),
            dataType: 'json',
            processData: false,
            contentType: false
        }).done(function (response) {
            if (response.ok === true) {
                swal({
                    title: 'Поздравляем',
                    html: response.message
                })
            } else {
                swal({
                    type: 'error',
                    title: 'Oops...',
                    html: response.message
                })
            }
        }).fail(function (response) {
            if (response.status === 422) {
                var errorsList = '';
                $.each(response.responseJSON, function (field, message) {
                    errorsList += message + '<br>'
                });
                swal({
                    type: 'error',
                    title: 'Oops...',
                    html: errorsList
                })
            } else if (response.status === 420 || response.status === 500) {
                swal({
                    type: 'error',
                    title: 'Oops...',
                    html: response.responseJSON.message
                })
            }
            console.log('Error - can`t clear notifications!', response);
        });
    });

})(jQuery); // End of use strict
