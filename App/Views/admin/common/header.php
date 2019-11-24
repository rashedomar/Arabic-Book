<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title><?php echo $title; ?></title>
    <link rel="stylesheet" href="<?php echo assets('/css/bootstrap/bootstrap.green.css'); ?>"/>
    <link rel="stylesheet" href="<?php echo assets('/css/bootstrap/bootstrap-rtl.min.css'); ?>"/>
    <link rel="stylesheet" href="<?php echo assets('/css/admin.css'); ?>">
    <link rel="stylesheet" href="<?php echo assets('/css/animate/animate.min.css'); ?>">
    <link rel="stylesheet" href="<?php echo assets('/css/tagsinput/bootstrap-tagsinput.css'); ?>">
    <link rel="stylesheet" href="<?php echo assets('/css/select2/select2.min.css'); ?>">
    <link rel="stylesheet" type="text/css" href="<?php echo assets('/css/font-awesome/css/font-awesome.css'); ?>">
</head>
<body>
<div id="page-wrapper">
    <?php if ($settings->recaptcha_key == '' AND $settings->recaptcha_secret == '') { ?>
        <div class="bg-danger text-center" style="padding: 10px"><a class="text-muted"
                                                                    href="<?php echo url('/admin/settings/recaptcha') ?>">قم
                بجلب مفاتيح جوجل recaptcha من اجل التحقق البشري.</a></div>
    <?php } ?>
    <!-- Top Bar Start -->
    <div class="topbar">
        <nav class="navbar navbar-inverse navbar-static-top">
            <div class="container">
                <div class="pull-right">
                    <button type="button" class="button-menu-mobile visible-xs visible-sm">
                        <i class="fa fa-bars"></i>
                    </button>
                    <span class="clearfix"></span>
                </div>
                <!-- Top nav left menu -->
                <ul class="nav navbar-nav hidden-sm hidden-xs">
                    <li><a href="<?php echo url('/admin'); ?>"><i class="fa fa-cog"></i> لوحة التحكم </a></li>
                    <li class="divider-vertical"></li>
                    <li><a href="<?php echo url('/') ?>"><i class="fa fa-home"></i> الذهاب لرئيسية الموقع </a></li>
                    <li class="divider-vertical"></li>
                    <li><a href="<?php echo url('/admin/contacts') ?>"><i class="fa fa-envelope"></i> رسائل لم يتم
                            الرد
                            عليها <?php echo '<span class="badge badge-default">'.$unread->total_unread.'</span>'; ?>
                        </a></li>
                </ul>
                <ul class="nav navbar-nav navbar-left pull-left">
                    <li class="dropdown">
                        <a href="#" class="dropdown-toggle" data-toggle="dropdown" aria-expanded="true"><img
                                    height="24"
                                    width="24"
                                    src="<?php echo assets('/images/'.($user->image === '' ? 'site/default-avatar.png' : $user->image)); ?>"
                                    class="img-circle">
                        </a>
                        <ul class="dropdown-menu">
                            <li><a href="#" data-target="#user-profile" data-toggle="modal"><span
                                            class="fa fa-user-circle-o" aria-hidden="true"></span> حسابي </a></li>
                            <li class="divider"></li>
                            <li><a href="<?php echo url('/logout'); ?>"><span class="fa fa-power-off"
                                                                              aria-hidden="true"></span> تسجيل خروج</a>
                            </li>
                        </ul>
                    </li>
                </ul>
            </div>
        </nav>
    </div>
    <!-- Top Bar End -->
    <!-- Page content start -->
    <div class="page-contentbar">

