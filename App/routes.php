<?php

return [

    /*
    *  sitePages
    */
    ['/', 'Site/Home', 'GET', 'مشاهدة الصفحة الرئيسية للموقع'],
    ['/book/:text/:id', 'Site/Book', 'GET', 'مشاهدة صفحة الكتاب'],
    ['/book/:text/:id/add-comment', 'Site/Book@addComment', 'POST', 'إضافة التعليقات للكتب'],
    ['/book/:text/:id/read', 'Site/Book@read', 'GET', 'مشاهدة صفحة قراءة الكتاب'],
    ['/book/:text/:id/download', 'Site/Book@download', 'GET', 'مشاهدة صفحة تحميل الكتاب'],
    ['/addbook', 'Site/Book@add', 'GET', 'مشاهدة صفحة إضافة كتاب'],
    ['/addbook/submit', 'Site/Book@submit', 'POST', 'حفظ بيانات الكتاب عند الإضافة'],
    ['/addbook/submit/url', 'Site/Book@submit', 'POST', 'حفظ بيانات الكتاب عند الإضافة كرابط خارجي '],
    ['/category/:text/:id', 'Site/Category', 'GET', 'مشاهدة صفحة التصنيف'],
    ['/author/:text/:id', 'Site/Author', 'GET', 'مشاهدة صفحة المؤلف'],
    ['/register', 'Site/Register', 'GET', 'مشاهدة صفحة التسجيل'],
    ['/active/:text', 'Site/Register@active', 'GET', 'القدرة على تفعيل الحساب عند التسجيل'],
    ['/register/submit', 'Site/Register@submit', 'POST', 'حفظ بيانات التسجيل'],
    ['/login/submit', 'Site/Login@submit', 'POST', 'حفظ بيانات تسجيل الدخول'],
    ['/profile', 'Site/Profile', 'GET', 'مشاهدة الملف الشخصي'],
    ['/profile/save', 'Site/Profile@save', 'POST', 'حفظ بيانات الملف الشخصي'],
    ['/logout', 'Site/Logout@signOut', 'GET', 'تسجيل الخروج من الموقع كاملاً'],
    ['/contact', 'Site/Contact', 'GET', 'الاتصال بنا'],
    ['/contact/submit', 'Site/Contact@submit', 'POST', 'حفظ بيانات الاتصال بنا'],
    ['/search', 'Site/Search', 'GET', 'البحث في الموقع'],
    ['/lostpw', 'Site/Login@lostPw', 'GET', 'صفحة استعادة كلمة المرور'],
    ['/lostpw/submit', 'Site/Login@lostPwSubmit', 'POST', 'حفظ بيانات استعادة كلمة المرور'],
    ['/newpw/:text', 'Site/Login@newPw', 'GET', 'صفحة إنشاء كلمة المرور الجديدة'],
    ['/newpw/submit', 'Site/Login@newPwSubmit', 'POST', 'حفظ بيانات صفحة إنشاء كلمة المرور الجديدة'],
    ['/404', 'NotFound', 'GET', 'مشاهدة صفحة خطأ 404'],

    /*
    *  /admin
    */
    ['/admin', 'Admin/Settings', 'GET', 'مشاهدة لوحة التحكم '],

    /*
     *  /admin/login
     */
    ['/admin/login', 'Admin/Login', 'GET', 'الدخول إلى صفحة تسجيل الدخول'],
    ['/admin/login/submit', 'Admin/Login@submit', 'POST', 'حفظ بيانات تسجيل الدخول'],

    /*
     *  /admin/users
     */
    ['/admin/users', 'Admin/Users', 'GET', 'مشاهدة قائمة المستخدمين'],
    ['/admin/users/add', 'Admin/Users@add', 'GET', 'الدخول على صفحة إضافة المستخدمين'],
    ['/admin/users/edit/:id', 'Admin/Users@edit', 'POST', 'الدخول على صفحة تعديل المستخدمين'],
    ['/admin/users/save/:id', 'Admin/Users@save', 'POST', 'حفظ بيانات المستخدمين عند التعديل'],
    ['/admin/users/submit', 'Admin/Users@submit', 'POST', 'حفظ بيانات المستخدمين عند الإضافة'],
    ['/admin/users/delete/:id', 'Admin/Users@delete', 'POST', 'حذف المستخدمين'],

    /*
     *  /admin/categories
     */
    ['/admin/categories', 'Admin/Categories', 'GET', 'مشاهدة قائمة التصنيفات'],
    ['/admin/categories/add', 'Admin/Categories@add', 'GET', 'الدخول على صفحة إضافة التصنيفات'],
    ['/admin/categories/edit/:id', 'Admin/Categories@edit', 'POST', 'الدخول على صفحة تعديل التصنيفات'],
    ['/admin/categories/save/:id', 'Admin/Categories@save', 'POST', 'حفظ بيانات التصنيفات عند التعديل'],
    ['/admin/categories/submit', 'Admin/Categories@submit', 'POST', 'حفظ بيانات التصنيفات عند الإضافة'],
    ['/admin/categories/delete/:id', 'Admin/Categories@delete', 'POST', 'حذف التصنيفات'],

    /*
     *  /admin/users-groups
     */
    ['/admin/users-groups', 'Admin/UsersGroups', 'GET', 'مشاهدة قائمة مجموعات الأعضاء'],
    ['/admin/users-groups/add', 'Admin/UsersGroups@add', 'GET', 'الدخول على صفحة إضافة مجموعات الأعضاء'],
    ['/admin/users-groups/edit/:id', 'Admin/UsersGroups@edit', 'POST', 'الدخول على صفحة تعديل مجموعات الأعضاء'],
    ['/admin/users-groups/save/:id', 'Admin/UsersGroups@save', 'POST', 'حفظ بيانات مجموعات الأعضاء عند التعديل'],
    ['/admin/users-groups/submit', 'Admin/UsersGroups@submit', 'POST', 'حفظ بيانات مجموعات الأعضاء عند الإضافة '],
    ['/admin/users-groups/delete/:id', 'Admin/UsersGroups@delete', 'POST', 'حذف مجموعات الأعضاء'],

    /*
    *  /admin/authors
    */
    ['/admin/authors', 'Admin/Authors', 'GET', 'مشاهدة قائمة المؤلفين '],
    ['/admin/authors/add', 'Admin/Authors@add', 'GET', 'الدخول على صفحة إضافة المؤلفين '],
    ['/admin/authors/edit/:id', 'Admin/Authors@edit', 'POST', 'الدخول على صفحة تعديل المؤلفين'],
    ['/admin/authors/save/:id', 'Admin/Authors@save', 'POST', 'حفظ بيانات المؤلفين عند التعديل'],
    ['/admin/authors/submit', 'Admin/Authors@submit', 'POST', 'حفظ بيانات المؤلفين عند الإضافة '],
    ['/admin/authors/delete/:id', 'Admin/Authors@delete', 'POST', 'حذف المؤلفين'],

    /*
    *  /admin/books
    */
    ['/admin/books', 'Admin/Books', 'GET', 'مشاهدة قائمة الكتب '],
    ['/admin/books/add', 'Admin/Books@add', 'GET', 'الدخول على صفحة إضافة الكتب '],
    ['/admin/books/edit/:id', 'Admin/Books@edit', 'POST', 'الدخول على صفحة تعديل الكتب'],
    ['/admin/books/save/:id', 'Admin/Books@save', 'POST', 'حفظ بيانات الكتب عند التعديل'],
    ['/admin/books/save/:id/url', 'Admin/Books@save', 'POST', 'حفظ بيانات الكتب عند التعديل كرابط خارجي'],
    ['/admin/books/submit', 'Admin/Books@submit', 'POST', 'حفظ بيانات الكتب عند الإضافة كملف '],
    ['/admin/books/submit/url', 'Admin/Books@submit', 'POST', 'حفظ بيانات الكتب عند الإضافة كرابط خارجي '],
    ['/admin/books/delete/:id', 'Admin/Books@delete', 'POST', 'حذف الكتب'],

    /*
    *  /admin/comments
    */
    ['/admin/comments', 'Admin/Comments', 'GET', 'مشاهدة قائمة التعليقات '],
    ['/admin/comments/edit/:id', 'Admin/Comments@edit', 'POST', 'الدخول على صفحة تعديل التعليقات'],
    ['/admin/comments/save/:id', 'Admin/Comments@save', 'POST', 'حفظ بيانات التعليقات عند التعديل'],
    ['/admin/comments/delete/:id', 'Admin/Comments@delete', 'POST', 'حذف التعليقات'],

    /*
    *  /admin/contacts
    */
    ['/admin/contacts', 'Admin/Contacts', 'GET', 'مشاهدة قائمة الرسائل '],
    ['/admin/contacts/show/:id', 'Admin/Contacts@show', 'GET', 'قراءة الرسائل'],
    ['/admin/contacts/reply/:id/submit', 'Admin/Contacts@submit', 'POST', 'الرد على الرسائل'],
    ['/admin/contacts/delete/:id', 'Admin/Contacts@delete', 'POST', 'حذف الرسائل'],

    /*
    *  /admin/settings
    */
    ['/admin/settings/site', 'Admin/Settings', 'GET', 'مشاهدة الإعدادات العامة '],
    ['/admin/settings/site/save', 'Admin/Settings@save', 'POST', 'حفظ بيانات الإعدادات العامة عند التعديل'],
    ['/admin/settings/mail', 'Admin/Settings', 'GET', 'مشاهدة خيارات البريد '],
    ['/admin/settings/mail/save', 'Admin/Settings@save', 'POST', 'حفظ خيارات البريد عند التعديل'],
    ['/admin/settings/register', 'Admin/Settings', 'GET', 'مشاهدة خيارات التسجيل '],
    ['/admin/settings/register/save', 'Admin/Settings@save', 'POST', 'حفظ خيارات التسجيل عند التعديل'],
    ['/admin/settings/books', 'Admin/Settings', 'GET', 'مشاهدة خيارات الكتب '],
    ['/admin/settings/books/save', 'Admin/Settings@save', 'POST', 'حفظ خيارات الكتب عند التعديل'],
    ['/admin/settings/recaptcha', 'Admin/Settings', 'GET', 'مشاهدة جوجل Recaptcha '],
    ['/admin/settings/recaptcha/save', 'Admin/Settings@save', 'POST', 'حفظ بيانات جوجل Recaptcha عند التعديل'],

    /*
    *  /admin/profile
    */
    ['/admin/profile/save', 'Admin/Profile@save', 'POST', 'حفظ بيانات الملف الشخصي'],

];