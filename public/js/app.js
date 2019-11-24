$(document).ready(function () {

    $('#carouselCats').slick({
        rtl: true,
        infinite: true,
        speed: 300,
        slidesToShow: 5,
        slidesToScroll: 4,
        prevArrow: '<div class="catsSlide catsPreSlide"></div>',
        nextArrow: '<div class="catsSlide catsNexSlide"></div>',
    });

    $('.carousel').slick({
        rtl: true,
        infinite: true,
        speed: 300,
        slidesToShow: 6,
        slidesToScroll: 4,
        variableWidth: true,

        prevArrow: '<div class="BooksSlide preSlide"></div>',
        nextArrow: '<div class="BooksSlide nexSlide"></div>',
        responsive: [
            {
                breakpoint: 1024,
                settings: {
                    slidesToShow: 3,
                    slidesToScroll: 3,
                    infinite: true
                }
            },
            {
                breakpoint: 600,
                settings: {
                    slidesToShow: 3,
                    slidesToScroll: 2
                }
            },
            {
                breakpoint: 480,
                settings: {
                    centerMode: false,
                    slidesToShow: 2,
                    slidesToScroll: 1
                }
            }
            // You can unslick at a given breakpoint now by adding:
            // settings: "unslick"
            // instead of a settings object
        ]
    });
});

$(function () {
    $('#logo-navbar-middle').addClass('animated swing');
});

$('.add-comment').on('click', function (e) {
    e.preventDefault();

    var btn = $(this);
    var requestform = btn.parents('#add-comment');
    var requesturl = requestform.attr('action');
    var requestdata = new FormData(requestform[0]);
    var formResults = requestform.find('#form-results');
    var comment = requestform.find('textarea');
    var userImage = $('#user_image').attr('src');
    var userName = $('#userProfile span').text();
    var countComments = $('#CommentHead span').text();
    if (comment.val().length < 3) {
        formResults.removeClass().addClass('alert alert-danger').html('التعليق يجب أن يكون 3 أحرف على الأقل!');
        return false;
    }
    $.ajax({
        url: requesturl,
        type: 'POST',
        data: requestdata,
        dataType: 'json',
        beforeSend: function () {
            btn.data('loading-text', '<i class="fa fa-spinner fa-spin"></i>').button('loading');
        },
        success: function (results) {
            if (results.errors) {
                btn.button('reset');
                formResults.removeClass().addClass('alert alert-danger').html(results.errors);
                grecaptcha.reset();
            } else {
                if (results.success) {
                    btn.data('loading-text', '<i class="fa fa-check"></i>').button('loading');
                    $('#CommentHead span').text(parseInt(countComments, 10) + 1);
                    formResults.removeClass().addClass('alert alert-success').html(results.success);
                    $('#comments').append('<li class="clearfix"><img src="' + userImage + '" class="avatar"><div class="book-comments"><p class="meta">' + userName + '<i class="pull-left">' + '"الآن"' + '</i></p> <p>' + comment.val() + ' </p> </div> </li>');
                    comment.val('');
                }
            }

        },
        catch: false,
        processData: false,
        contentType: false
    });
});

$('.submit-btn').on('click', function (e) {
    e.preventDefault();

    var btn = $(this);
    var requestform = btn.parents('#SiteForm');
    var requesturl = requestform.attr('action');
    var requestdata = new FormData(requestform[0]);
    var formResults = requestform.find('#form-results');
    $.ajax({
        url: requesturl,
        type: 'POST',
        data: requestdata,
        dataType: 'json',
        beforeSend: function () {
            btn.data('loading-text', '<i class="fa fa-spinner fa-spin"></i>').button('loading');
        },
        success: function (results) {
            if (results.errors) {
                formResults.html('');
                btn.button('reset');
                requestform.find('input[name="search"]').addClass('form-control animated shake');
                results.errors.split('<br>').forEach(function (err) {
                    formResults.removeClass().addClass('alert alert-danger').append('<i class="fa fa-exclamation-circle"></i> ' + err + '.' + '<br>');
                });
                grecaptcha.reset();
            } else {
                if (results.success) {
                    btn.data('loading-text', '<i class="fa fa-check"></i>').button('loading');
                    formResults.removeClass().addClass('alert alert-success').html(results.success);
                    $('.registerPage').addClass('alert alert-success text-center').html(results.success);
                    setTimeout(function () {
                        if (results.redirect) {
                            window.location.href = results.redirect;
                        }
                    });
                }
            }

        },
        catch: false,
        processData: false,
        contentType: false
    });
});

$('.pdfOutLink').on('click', function (e) {
    e.preventDefault();

    var $btn = $(this);
    $btn.toggleClass('pdfOutLink');
    if ($btn.hasClass('pdfOutLink')) {

        $btn.parents('form').attr('action', $btn.parents('form').attr('action').replace('/url', ''));
        $btn.toggleClass('pdfInLink');
        $btn.text('الإضافة كرابط خارجي');
        $('#addPdf').replaceWith(
            '<div id="addPdf" class="form-group col-sm-6 animated shake"><label>ملف الكتاب</label><div class="input-group"><label class="input-group-btn"><span class="btn btn-warning">اختر...<input type="file" name="link" style="display: none;"></span></label><input type="text" class="form-control" readonly></div></div>');

    } else {
        $btn.addClass('pdfInLink');
        $btn.parents('form').attr('action', $btn.parents('form').attr('action') + '/url');
        $btn.text('الإضافة كملف');
        $('#addPdf').replaceWith(
            '<div id="addPdf" class="form-group col-sm-6 animated shake"><label>رابط الكتاب</label><div class="input-group"><span class="input-group-addon"><i class="fa fa-link"></i></span><input name="link" class="form-control" type="text"></div></div>');
    }
});
$(document).on('change', ':file', function () {
    var input = $(this),
        numFiles = input.get(0).files ? input.get(0).files.length : 1,
        label = input.val().replace(/\\/g, '/').replace(/.*\//, '');
    input.trigger('fileselect', [numFiles, label]);
});

// We can watch for our custom `fileselect` event like this
$(document).on('fileselect', ':file', function (event, numFiles, label) {
    var input = $(this).parents('.input-group').find(':text'),
        log = numFiles > 1 ? numFiles + ' files selected' : label;
    if (input.length) {
        input.val(log);
    }

});
$('.select-lookup').select2({

    dir: 'rtl'
});