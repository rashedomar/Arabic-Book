<?php
namespace App\Controllers\Admin;
use Core\Controller;

class SettingsController extends Controller
{
    private $page;

    public function index()
    {
        $this->page = str_replace('/admin/settings/', '', $this->get('request')->getUrl());
        if ($this->page === '/admin') {
            $this->page = 'site';
        }
        $this->setTitle();
        if ($this->page == 'register' OR $this->page == 'books') {
            $data['usersGroups'] = $this->get('load')->model('UsersGroups')->all();
        }
        $data['settings'] = (object) $this->get('settings');
        $data['action'] = url('/admin/settings/'.$this->page.'/save');
        $data['errors'] = $this->get('session')->has('errors') ? $this->get('session')->pull('errors') : null;
        $data['success'] = $this->get('session')->has('success') ? $this->get('session')->pull('success') : null;
        $data['token'] = $this->get('token')->generate();
        $view = $this->get('view')->render('admin/settings/'.$this->page, $data);

        return $this->get('adminLayout')->render($view);
    }

    private function setTitle()
    {
        if ($this->page === 'site') {
            $this->get('html')->setTitle('الإعدادات العامة');
        } elseif ($this->page === 'mail') {
            $this->get('html')->setTitle('خيارات SMTP');
        } elseif ($this->page === 'register') {
            $this->get('html')->setTitle('خيارات التسجيل');
        } elseif ($this->page === 'recaptcha') {
            $this->get('html')->setTitle('جوجل Recaptcha');
        } elseif ($this->page === 'books') {
            $this->get('html')->setTitle('خيارات الكتب');
        } else {
            $this->get('html')->setTitle('لوحة التحكم');
        }
    }

    public function save()
    {
        $page = str_replace('/save', '', $this->get('request')->getUrl());
        $this->page = str_replace('/admin/settings/', '', $page);
        if ($this->isValid()) {
            if ($this->get('token')->check($this->get('request')->post('token'))) {

                $this->get('load')->model('Settings')->update();
                $this->get('session')->set('success', 'تم التحديث بنجاح!');

                return redirectTo($page);
            } else {
                return redirectTo('/404');
            }
        } else {
            $this->get('session')->set('errors', implode('<br>', $this->get('valid')->getErrorMessages()));

            return redirectTo($page);
        }
    }

    private function isValid()
    {
        if ($this->page === 'site') {
            $this->get('valid')->required('name', 'عنوان الموقع مطلوب');
            $this->get('valid')->required('desc', 'وصف الموقع مطلوب');
            $this->get('valid')->required('tags', 'الكلمات المفتاحية مطلوبة');
            $this->get('valid')->required('email', 'بريد الموقع مطلوب')->email('email', 'تنسيق البريد الإلكتروني غير صحيح');
            $this->get('valid')->required('status', 'الحالة مطلوبة')->expectedValues('status', [
                'enabled',
                'disabled',
            ]);
            $this->get('valid')->required('animate', 'حالة عرض الـ Animations مطلوبة')->expectedValues('status', [
                'enabled',
                'disabled',
            ]);
            $this->get('valid')->required('close_msg', 'رسالة غلق الموقع مطلوبة');
        } elseif ($this->page === 'mail') {
            $this->get('valid')->required('smtp_status', 'حالة SMTP مطلوبة');
            if ($this->get('request')->post('smtp_status') === 'enabled') {
                $this->get('valid')->required('smtp_host', 'مزود الخدمة مطلوب');
                $this->get('valid')->required('smtp_username', 'اسم المستخدم مطلوب');
                $this->get('valid')->required('smtp_password', 'كلمة المرور مطلوبة');
                $this->get('valid')->required('smtp_port', ' المنفذ مطلوب');
                $this->get('valid')->required('smtp_secure', 'نوع التشفير مطلوب');
            }
        } elseif ($this->page === 'register') {
            $this->get('valid')->required('can_register', 'حقل إمكانية التسجيل مطلوب')->expectedValues('can_register', [
                'enabled',
                'disabled',
            ]);
            $this->get('valid')->required('default_users_group', 'المجموعة الإفتراضية مطلوبة')->isInt('default_users_group');
        } elseif ($this->page === 'recaptcha') {
            $this->get('valid')->required('recaptcha_key', 'مفتاح الموقع مطلوب');
            $this->get('valid')->required('recaptcha_secret', 'المفتاح الخفي مطلوب');
        } elseif ($this->page === 'books') {
            $this->get('valid')->required('allowed_group_addbooks', 'المجموعة المسموح لها بالإضافة مطلوبة');
            $this->get('valid')->required('default_status_addbooks', 'حالة الكتب عند الإضافة مطلوبة')->expectedValues('default_status_addbooks', [
                'enabled',
                'disabled',
            ]);
        } else {
            return false;
        }

        $this->get('valid')->required('token');

        return $this->get('valid')->passes();
    }
}

?>
