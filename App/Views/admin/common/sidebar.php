<!--left navigation start-->
<aside class="sidebar-navigation">
    <div class="nav-side-menu">
        <li data-toggle="collapse" data-target="#settings" class="collapsed active">
            <a><i class="fa fa-gears fa-lg pull right"></i> الإعدادات <i
                        class="fa fa-fw fa-angle-down pull-left"></i></a>
        </li>
        <ul class="sub-menu collapse" id="settings">
            <li><a href="<?php echo url('/admin/settings/site'); ?>"> معلومات الموقع </a></li>
            <li><a href="<?php echo url('/admin/settings/register'); ?>">خيارات التسجيل</a></li>
            <li><a href="<?php echo url('/admin/settings/mail'); ?>">خيارات SMTP</a></li>
            <li><a href="<?php echo url('/admin/settings/books'); ?>">خيارات الكتب</a></li>
            <li><a href="<?php echo url('/admin/settings/recaptcha'); ?>"> جوجل Recaptcha </a></li>
        </ul>
        <li data-toggle="collapse" data-target="#books" class="collapsed active">
            <a><i class="fa fa-book fa-lg pull right"></i> الكتب <i class="fa fa-fw fa-angle-down pull-left"></i></a>
        </li>
        <ul class="sub-menu collapse" id="books">
            <li><a href="<?php echo url('/admin/books'); ?>"> قائمة الكتب</a></li>
            <li><a href="<?php echo url('/admin/books/add'); ?>"> إضافة كتاب جديد </a></li>
        </ul>
        <li data-toggle="collapse" data-target="#users" class="collapsed active">
            <a><i class="fa fa-user fa-lg"></i> المستخدمين <i class="fa fa-fw fa-angle-down pull-left"></i></a>
        </li>
        <ul class="sub-menu collapse" id="users">
            <li><a href="<?php echo url('/admin/users'); ?>"> قائمة المستخدمين</a></li>
            <li><a href="<?php echo url('/admin/users/add'); ?>"> إضافة مستخدم جديد </a></li>
        </ul>
        <li data-toggle="collapse" data-target="#authors" class="collapsed active">
            <a><i class="fa fa-pencil fa-lg"></i> المؤلفين <i class="fa fa-fw fa-angle-down pull-left"></i></a>
        </li>
        <ul class="sub-menu collapse" id="authors">
            <li><a href="<?php echo url('/admin/authors'); ?>"> قائمة المؤلفين</a></li>
            <li><a href="<?php echo url('/admin/authors/add'); ?>"> إضافة مؤلف جديد </a></li>
        </ul>
        <li data-toggle="collapse" data-target="#categories" class="collapsed active">
            <a><i class="fa fa-folder fa-lg"></i> التصنيفات <i class="fa fa-fw fa-angle-down pull-left"></i></a>
        </li>
        <ul class="sub-menu collapse" id="categories">
            <li><a href="<?php echo url('/admin/categories'); ?>"> قائمة التصنيفات</a></li>
            <li><a href="<?php echo url('/admin/categories/add'); ?>"> إضافة تصنيف جديد </a></li>
        </ul>
        <li data-toggle="collapse" data-target="#users-groups" class="collapsed active">
            <a><i class="fa fa-group fa-lg"></i> مجموعات المستخدمين <i class="fa fa-fw fa-angle-down pull-left"></i></a>
        </li>
        <ul class="sub-menu collapse" id="users-groups">
            <li><a href="<?php echo url('/admin/users-groups'); ?>"> قائمة المجموعات </a></li>
            <li><a href="<?php echo url('/admin/users-groups/add'); ?>"> إضافة مجموعة جديدة </a></li>
        </ul>
        <li><a href="<?php echo url('/admin/comments'); ?>"><i class="fa fa-comment fa-lg"></i> التعليقات </a></li>
        <li><a href="<?php echo url('/admin/contacts'); ?>"><i class="fa fa-envelope fa-lg"></i> الرسائل </a></li>
    </div><!--Scrollbar wrapper-->
</aside>
<!--left navigation end-->