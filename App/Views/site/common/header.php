<!DOCTYPE html>
<html dir="rtl">
<head>
    <title><?php echo $title; ?></title>
    <meta name="description" content="<?php echo $settings->desc; ?>">
    <meta name="keywords" content="<?php echo $settings->tags; ?>">
    <meta charset="utf-8"/>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="<?php echo assets('/css/bootstrap/bootstrap.green.css'); ?>"/>
    <link rel="stylesheet" href="<?php echo assets('/css/bootstrap/bootstrap-rtl.min.css'); ?>"/>
    <link rel="stylesheet" href="<?php echo assets('/css/style.css'); ?>"/>
    <link rel="stylesheet" href="<?php echo assets('/css/font-awesome/css/font-awesome.min.css'); ?>">
    <link rel="stylesheet" href="<?php echo assets('/css/slick/slick.css'); ?>"/>
    <link rel="stylesheet" href="<?php echo assets('/css/slick/slick-theme.css'); ?>"/>
    <?php if ($settings->animate === 'enabled') { ?>
        <link rel="stylesheet" href="<?php echo assets('/css/animate/animate.min.css'); ?>">
    <?php } ?>
    <link rel="stylesheet" href="<?php echo assets('/css/select2/select2.min.css'); ?>">
</head>
<body>
<nav class="navbar navbar-inverse navbar-static-top" role="navigation">
    <div class="container">
        <div class="navbar-header">
            <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar"
                    aria-expanded="false" aria-controls="navbar">
                <span class="sr-only">Toggle navigation</span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
            </button>
        </div>
        <div id="navbar" class="collapse navbar-collapse">
            <ul class="nav navbar-nav pull-right">
                <li><a href="<?php echo url('/'); ?>">الرئيسية</a></li>
                <?php if ($categories) { ?>
                    <li class="dropdown">
                        <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button"
                           aria-haspopup="true"
                           aria-expanded="false">التصنيفات <span class="caret"></span></a>
                        <ul class="dropdown-menu">
                            <?php foreach ($categories AS $cat) { ?>
                                <li>
                                    <a href="<?php echo url('/category/'.seo($cat->name).'/'.$cat->id); ?>"><?php echo $cat->name; ?>
                                        <i class="badge badge-default"><?php echo $cat->total_books; ?></i></a></li>
                            <?php } ?>
                        </ul>
                    </li>
                <?php } ?>
                <li><a href="<?php echo url('/contact'); ?>">اتصل بنا</a></li>
            </ul>
            <form action="<?php echo url('/search'); ?>" class="navbar-form navbar-right" method="get">
                <div class="form-group">
                    <input type="text" name="s" class="form-control" placeholder="ادخل اسم الكتاب...">
                </div>
                <button type="submit" class="btn btn-default">بحث</button>
            </form>
            <ul class="nav navbar-nav navbar-left">
                <?php if ($user) { ?>
                    <li class="dropdown">
                        <a id="userProfile" href="#" class="dropdown-toggle"
                           data-toggle="dropdown">
                            <img id="user_image" width="20" height="20"
                                 src="<?php echo assets('/images/'.($user->image === '' ? 'site/default-avatar.png' : $user->image)); ?>"
                                 class="profile-image img-circle"> <span
                                    id="UserName"><?php echo $user->first_name.' '.$user->last_name; ?></span>
                            <b
                                    class="caret"></b></a>
                        <ul class="dropdown-menu">
                            <?php if ($user AND $user->user_group_id == 1) { ?>
                                <li><a href="<?php echo url('/admin'); ?>">لوحة التحكم</a></li>
                            <?php } ?>
                            <?php if ($user->user_group_id == $settings->allowed_group_addbooks) { ?>
                                <li><a href="<?php echo url('/addbook'); ?>">إضافة كتاب</a></li>
                            <?php } ?>
                            <li><a href="<?php echo url('/profile'); ?>">حسابي</a></li>
                            <li><a href="<?php echo url('/logout'); ?>">تسجيل الخروج</a></li>
                        </ul>
                    </li>
                <?php } else { ?>
                    <li class="dropdown">
                    <a href="#" class="dropdown-toggle" data-toggle="dropdown">تسجيل
                        الدخول<span class="caret"></span></a>
                    <ul class="dropdown-menu">
                        <div class="col-lg-12">
                            <div class="text-center"><h3><b>تسجيل الدخول</b></h3></div>
                            <form action="<?php echo url('/login/submit'); ?>" id="SiteForm" method="post">
                                <div id="form-results"></div>
                                <div class="form-group">
                                    <input class="form-control" placeholder="البريد الإلكتروني" name="email"
                                           type="text">
                                </div>
                                <div class="form-group">
                                    <input class="form-control" placeholder="كلمة المرور" name="password"
                                           type="password">
                                </div>
                                <input type="hidden" name="token" value="<?php echo $token; ?>">
                                <button type="button" class="btn btn-success submit-btn">الدخول</button>
                            </form>
                        </div>
                        <li class="pull-left">
                            <a href="<?php echo url('/lostpw') ?>">استعادة</a>
                        </li>
                    </ul>
                    <?php if ($settings->can_register === 'enabled') { ?>
                        <li><a href="<?php echo url('/register'); ?>">التسجيل</a></li>
                    <?php } ?>
                <?php } ?>
            </ul>
        </div>
    </div>
</nav>
<header>
    <nav class="navbar">
        <div class="container">
            <ul class="nav navbar-nav">
                <li><a href="<?php echo url('/'); ?>"><img id="logo-navbar-middle"
                                                           src="<?php echo assets('/images/site/logo.png'); ?>"
                                                           width="200" alt="<?php echo $settings->name; ?>"></a></li>
            </ul>
        </div>
    </nav>
</header>
<div id="main-show" class="container">
    <div class="row">
        <div class="main-show">

