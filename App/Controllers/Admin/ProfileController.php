<?php
namespace App\Controllers\Admin;
use Core\Controller;

class ProfileController extends Controller
{
    public function save()
    {
        $json = [];
        $user = $this->get('load')->model('Login')->user();
        if ($this->isValid($user->id)) {
            if ($this->get('token')->check($this->get('request')->post('token'))) {
                $this->get('load')->model('Users')->update($user->id, $user->user_group_id);
                $json['success'] = 'تم التحديث بنجاح!';
                $json['redirect'] = url('/admin/users');
            } else {
                return redirectTo('/404');
            }
        } else {
            $json['errors'] = implode('<br>', $this->get('valid')->getErrorMessages());
        }

        return $this->json($json);
    }

    private function isValid($id = null)
    {
        if (is_null($id)) {
            return false;
        }

        $this->get('valid')->required('first-name', 'الاسم الأول مطلوب');
        $this->get('valid')->required('last-name', 'الاسم الأخير مطلوب');
        $this->get('valid')->required('email', 'البريد الإلكتروني مطلوب')->email('email')->unique('email', [
            'users',
            'email',
            'id',
            $id,
        ]);
        $this->get('valid')->required('token');

        if ($this->get('request')->post('password')) {
            $this->get('valid')->required('password', 'كلمة المرور مطلوبة')->minLength('password', 8, 'كلمة المرور يجب أن تكون على الأقل 8 أحرف')->maxLength('password', 30, 'كلمة المرور يجب أن تكون على الأكثر 30 حرف')->match('password', 'confirm-password', 'كلمتي المرور يجب ان تكونا متطابقتان');
        }

        $this->get('valid')->image('image', 'امتداد الصورة غير صحيح');

        return $this->get('valid')->passes();
    }
}

?>
