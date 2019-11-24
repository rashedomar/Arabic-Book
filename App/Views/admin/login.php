<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>تسجيل الدخول</title>
    <link rel="stylesheet" type="text/css" href="<?php echo assets('/css/font-awesome/css/font-awesome.css'); ?>">
    <link rel="stylesheet" href="<?php echo assets('/css/animate/animate.min.css'); ?>">
    <link rel="stylesheet" href="<?php echo assets('/css/bootstrap/bootstrap.green.css'); ?>"/>
    <link rel="stylesheet" href="<?php echo assets('/css/bootstrap/bootstrap-rtl.min.css'); ?>"/>
    <style>
        @import url('http://fonts.googleapis.com/earlyaccess/notokufiarabic.css');

        html, body {
            background-color: #DADADA;
        }

        body {
            font-family: 'Noto Kufi Arabic', Arial, Helvetica, sans-serif;
        }

        #login {
            position: absolute;
            top: 0;
            right: 0;
            bottom: 0;
            left: 0;
            z-index: 99;
            margin: auto;
            height: 400px;
        }

        .loginbox {
            margin-top: 5%;
            border-top: 6px solid #337AB7;
            padding: 20px;
        }
    </style>
</head>
<body>
<div class="container">
    <div class="row">
        <div id="login" class="col-md-3 col-md-offset-4">
            <div class="panel panel-default loginbox">
                <div class="panel-heading">
                    <h3 class="panel-title">تسجيل الدخول</h3>
                </div>
                <div class="panel-body">
                    <form action="<?php echo url('/admin/login/submit'); ?>" role="form" id="login-form"
                          method="post">
                        <div id="message"></div>
                        <fieldset>
                            <div class="form-group">
                                <input class="form-control" placeholder="البريد الإلكتروني" name="email"
                                       type="text">
                            </div>
                            <div class="form-group">
                                <input class="form-control" placeholder="كلمة المرور" name="password"
                                       type="password">
                            </div>
                            <button type="submit" class="btn btn-primary btn-block" id="btn">دخول</button>
                        </fieldset>
                        <input type="hidden" name="token" value="<?php echo $token; ?>">
                        <br>
                        <div id="red"></div>
                    </form>
                    <small class="pull-left"><a href="<?php echo url('/lostpw') ?>">استعادة</a></small>
                </div>
            </div>
        </div>
    </div>
</div>
<script src="<?php echo assets('/js/jquery.min.js'); ?>"></script>
<script src="<?php echo assets('/js/bootstrap/bootstrap.min.js'); ?>"></script>
<script>
    $('#login-form').on('submit', function (e) {
        e.preventDefault();

        var flag = false;

        if (flag === true) {
            return false;
        }

        var requestForm = $(this);
        var requestURL = requestForm.attr('action');
        var requestMethod = requestForm.attr('method');
        var requestData = requestForm.serialize();
        var loginMsg = $('#message');

        $.ajax({
            url: requestURL,
            type: requestMethod,
            data: requestData,
            dataType: 'json',

            beforeSend: function () {
                flag = true;
                $('#login').removeClass('animated shake');
                $('#btn').data('loading-text', '<i class="fa fa-spinner fa-spin"></i>').button('loading');
            },
            success: function (results) {
                if (results.errors) {
                    loginMsg.html('');
                    $('#btn').button('reset');
                    $('#login').addClass('animated shake');
                    results.errors.split('<br>').forEach(function (err) {
                        loginMsg.removeClass().addClass('alert alert-danger').append('<i class="fa fa-exclamation-circle"></i> ' + err + '.' + '<br>');
                    });
                    flag = false;
                } else {
                    if (results.success) {
                        $('#btn').removeClass().addClass('btn btn-success btn-block');
                        $('#btn').data('loading-text', '<i class="fa fa-check"></i>').button('loading');
                        loginMsg.removeClass().addClass('alert alert-success').html(results.success);
                        var html = '<i class="notched circle loading icon"></i><div class="content">جاري تحويلك .. خلال ثلاثة ثوان!</div>';
                        $('#red').addClass('alert alert-info').html(html);
                        setTimeout(function () {
                            if (results.redirect) {
                                window.location.href = results.redirect;
                            }
                        }, 3000);
                    }
                }
            }
        });
    });
</script>
</body>
</html>
