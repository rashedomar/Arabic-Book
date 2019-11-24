<?php
require_once '../../System/Helpers/helpers.php';
function msg($type, $msg)
{
    if ($type == 'error') {
        $icon = 'times';
        $alert = 'danger';
    } else {
        $icon = 'check';
        $alert = 'success';
    }

    return '<p class="text-'.$alert.'" role="alert"><i class="fa fa-'.$icon.'" aria-hidden="true"></i> '.$msg.'</p>';
}

$tables = require('tables.php');
$db_errors = [];
$req_errors = [];
$user_errors = [];
$defaults_errors = [];
$defaults = false;

if (version_compare(phpversion(), '5.5', '<')) {
    $req_errors[] = msg('error', 'هذا السكربت يتطلب إصدار php5.5 على الأقل.');
} else {
    $req_errors[] = msg('ok', 'إصدار الـphp متوافق مع السكربت.');
}

if (extension_loaded('pdo')) {
    $req_errors[] = msg('ok', 'PDO مُفعله بالفعل.');
} else {
    $req_errors[] = msg('error', 'السكربت يتطلب إضافة PDO للتعامل مع قواعد البيانات.');
}

if (extension_loaded('openssl')) {
    $req_errors[] = msg('ok', 'openssl مٌفعله بالفعل.');
} else {
    $req_errors[] = msg('error', 'يتطلب تفعيل openssl.');
}

if (extension_loaded('curl')) {
    $req_errors[] = msg('ok', 'curl مٌفعله بالفعل.');
} else {
    $req_errors[] = msg('error', 'يتطلب تفعيل curl.');
}
try {

    $db = require_once '../../config.php';
    if (empty($db['db_host']) || empty($db['db_name']) || empty($db['db_user'])) {
        $db_errors[] = msg('error', 'تأكد من إدخالك لكافة معلومات قاعدة البيانات في ملف config.php.');
    } else {
        $pdo = new PDO('mysql:host='.$db['db_host'].';dbname='.$db['db_name'], $db['db_user'], $db['db_pass']);
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        $pdo->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_OBJ);
        $pdo->exec('SET NAMES utf8');
        $db_errors[] = msg('ok', 'تم الإتصال بقاعد البيانات.');
        foreach ($tables as $table => $stm) {
            if ($pdo->query($stm)) {
                $db_errors[] = msg('ok', 'الجدول '.$table.' تم إنشاءه بنجاح.');
            }
        }

        $stmt = $pdo->prepare("SELECT id FROM `users_groups` WHERE `id`=1");
        $stmt->execute();
        $result = $stmt->fetchAll();
        if (! empty($result)) {
            $defaults = true;
        }
        if (isset($_POST['first-name']) && isset($_POST['last-name']) && isset($_POST['email']) && isset($_POST['password']) && ! $defaults) {
            if (strlen($_POST['password']) >= 8) {
                $now = time();
                $code = generateRandom(23);
                $stmt = $pdo->prepare("INSERT INTO `users` (`user_group_id`, `first_name`, `last_name`, `email`, `password`,`image`,`status`, `ip`, `code`, `created`, `verification_code`) VALUES (1,?,?,?,?,'','enabled', '','ZWNlZjMzYjFlYmI2MTVjYTM',$now, '')");
                $arr = [
                    $_POST['first-name'],
                    $_POST['last-name'],
                    $_POST['email'],
                    password_hash($_POST['password'], PASSWORD_DEFAULT),
                ];
                $stmt->execute($arr);
                $default_settings = $pdo->prepare("INSERT INTO `settings` (`key`, `value`) VALUES
('tags', 'كتابي,كتب إلكترونية,قراءة,تحميل,تصفح'),
('close_msg', 'الموقع مغلق حالياً.'),
('status', 'enabled'),
('can_register', 'enabled'),
('animate', 'enabled'),
('recaptcha_key', ''),
('recaptcha_secret', ''),
('desc', 'موقع لقراءة وتحميل الكتب الإلكترونية'),
('default_users_group', '2'),
('email', 'admin@admin.com'),
('allowed_group_addbooks', '2'),
('smtp_password', 'bk7@2017'),
('smtp_username', 'script.mybook@gmail.com'),
('smtp_port', '587'),
('smtp_host', 'smtp.gmail.com'),
('smtp_status', 'enabled'),
('default_status_addbooks', 'disabled'),
('smtp_secure', 'tls'),
('name', 'سكربت كتابي')");

                $default_settings->execute();

                $default_groups = $pdo->prepare("INSERT INTO `users_groups` (`name`) VALUES ('الإدارة'),('الأعضاء')");
                $default_groups->execute();

                $default_privileges = $pdo->prepare("INSERT INTO `users_groups_privileges` (`users_groups_id`, `page`) VALUES
(1, '/admin/settings/recaptcha/save'),
(1, '/admin/settings/recaptcha'),
(1, '/admin/settings/books/save'),
(1, '/admin/settings/books'),
(1, '/admin/settings/register'),
(1, '/admin/settings/register/save'),
(1, '/admin/settings/mail/save'),
(1, '/admin/settings/mail'),
(1, '/admin/settings/site/save'),
(1, '/admin/settings/site'),
(1, '/admin/contacts/delete/:id'),
(1, '/admin/contacts/reply/:id/submit'),
(1, '/admin/contacts/show/:id'),
(1, '/admin/contacts'),
(1, '/admin/comments/delete/:id'),
(1, '/admin/comments/save/:id'),
(1, '/admin/comments/edit/:id'),
(1, '/admin/comments'),
(1, '/admin/books/delete/:id'),
(1, '/admin/books/submit/url'),
(1, '/admin/books/save/:id'),
(1, '/admin/books/save/:id/url'),
(1, '/admin/books/submit'),
(1, '/admin/books/edit/:id'),
(1, '/admin/books/add'),
(1, '/admin/books'),
(1, '/admin/authors/delete/:id'),
(1, '/admin/authors/submit'),
(1, '/admin/authors/save/:id'),
(1, '/admin/authors/add'),
(1, '/admin/authors/edit/:id'),
(1, '/admin/authors'),
(1, '/admin/users-groups/delete/:id'),
(1, '/admin/users-groups/submit'),
(1, '/admin/users-groups/save/:id'),
(1, '/admin/users-groups/edit/:id'),
(1, '/admin/users-groups/add'),
(1, '/admin/users-groups'),
(1, '/admin/categories/delete/:id'),
(1, '/admin/categories/submit'),
(1, '/admin/categories/save/:id'),
(1, '/admin/categories/edit/:id'),
(1, '/admin/categories/add'),
(1, '/admin/categories'),
(1, '/admin/users/delete/:id'),
(1, '/admin/users/submit'),
(1, '/admin/users/save/:id'),
(1, '/admin/users/edit/:id'),
(1, '/admin/users/add'),
(1, '/admin/users'),
(1, '/admin/login/submit'),
(1, '/admin/login'),
(1, '/admin'),
(1, '/admin/profile/save');");
                $default_privileges->execute();
                $defaults = true;
            } else {
                $user_errors[] = msg('error', 'كلمة المرور يجب أن تكون 8 أحرف على الأقل.');
            }
        }
    }
} catch (PDOException $e) {
    $db_errors[] = msg('error', 'خطأ في الإتصال بقاعدة البيانات: <br>'.$e->getMessage());
}

?>
<DOCTYPE html>
    <html>
    <head>
        <meta http-equiv="content-type" content="text/html; charset=UTF-8">
        <meta charset="utf-8">
        <title>تنصيب سكربت كتابي</title>
        <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
        <link rel="stylesheet" href="../css/font-awesome/css/font-awesome.min.css"/>
        <link rel="stylesheet" href="../css/bootstrap/bootstrap.green.css"/>
        <link rel="stylesheet" href="../css/bootstrap/bootstrap-rtl.min.css"/>
        <link rel="stylesheet" href="../css/style.css"/>
    </head>
    <body>
    <main>
        <div class="container">
            <div class="row">
                <div class="col-md-8 col-md-offset-2 well well-lg">
                    <div class="text-center">
                        <img id="logo-navbar-middle" src="../images/site/logo.png" width="200"
                             alt="Logo Thing main logo">
                        <h3>التثبيت</h3>
                    </div>
                    <hr>
                    <?php if ($defaults) { ?>
                        <?php
                        echo msg('ok', 'تمت عملية التنصيب بنجاح!');
                        if (is_dir('../install')) { ?>
                            <h4 class="alert alert-danger">تحذير: يجب عليك حذف مجلد <code>install</code> بكافة متحوياته.
                            </h4>
                        <?php } ?>
                    <?php } else { ?>
                        <form action="index.php" method="post" class="form-horizontal">
                            <h4>المتطلبات</h4>
                            <hr>
                            <?php
                            if (count($req_errors) > 0) {
                                foreach ($req_errors as $error) {
                                    echo $error;
                                }
                            }
                            ?>
                            <hr>
                            <h4>قاعدة البيانات</h4>
                            <hr>
                            <?php
                            if (count($db_errors) > 0) {
                                foreach ($db_errors as $error) {
                                    echo $error;
                                }
                            }
                            ?>
                            <hr>
                            <h4>قم بإنشاء حساب مدير لوحة التحكم</h4>
                            <hr>
                            <div class="form-group col-sm-12"><label>الأسم الأول</label> <input class="form-control"
                                                                                                name="first-name"
                                                                                                placeholder="الاسم الأول"
                                                                                                type="text"></div>
                            <div class="form-group col-sm-12"><label>الأسم الأخير</label> <input class="form-control"
                                                                                                 name="last-name"
                                                                                                 placeholder="الاسم الأخير"
                                                                                                 type="text"></div>
                            <div class="form-group col-sm-12"><label>البريد الإلكتروني </label> <input
                                        class="form-control" name="email" placeholder="البريد الإلكتروني " type="email">
                            </div>
                            <div class="form-group col-sm-12"><label> كلمة المرور </label> <input class="form-control"
                                                                                                  name="password"
                                                                                                  placeholder="كلمة المرور "
                                                                                                  type="password"></div>
                            <div class="clearfix"></div>
                            <div class="form-group text-center">
                                <button type="submit" class="btn btn-primary">إنشاء</button>
                                <button type="reset" class="btn btn-default">إعادة</button>
                            </div>
                            <?php
                            if (count($user_errors) > 0) {
                                foreach ($user_errors as $error) {
                                    echo $error;
                                }
                            }
                            ?>
                            <hr>
                        </form>
                    <?php } ?>
                </div>
            </div>
        </div>
    </main>

    <script src="../js/jquery.min.js"></script>
    <script src="../js/bootstrap/bootstrap.min.js"></script>

    </body>
    </html>