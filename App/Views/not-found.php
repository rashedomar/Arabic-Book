<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>الصفحة غير موجودة</title>
    <link rel="stylesheet" href="<?php echo assets('/css/bootstrap/bootstrap.min.css'); ?>">
    <link href="https://fonts.googleapis.com/css?family=El+Messiri" rel="stylesheet">
    <style>
        body {
            font-family: 'El Messiri', 'Noto Kufi Arabic', 'Noto Sans', 'Helvetica Neue', Arial, Helvetica, sans-serif;
        }

        .error {
            margin: 0 auto;
            text-align: center;
            max-width: 480px;
            padding: 60px 30px;
        }

        .error-code {
            color: #2d353c;
            font-size: 96px;
            line-height: 100px;
        }

        .error-details {
            font-size: 12px;
            color: #647788;
        }

        .error-actions {
            margin: 30px 0;
        }
    </style>
</head>
<body>
<div class="container">
    <div class="row">
        <div class="error">
            <h1 class="error-code">404</h1>
            <h2>الصفحة غير موجودة!</h2>
            <div class="error-details">معذرةً ، الصفحة المطلوبة لم يتم العثور عليها...</div>
            <div class="error-actions">
                <a href="<?php echo Core\App::getInstance()->get('request')->getBaseUrl(); ?>"
                   class="btn btn-primary">
                    الذهاب للرئيسية
                </a>
            </div>
        </div>
    </div>
</div>
</body>
</html>
