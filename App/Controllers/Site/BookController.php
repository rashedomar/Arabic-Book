<?php

namespace App\Controllers\Site;

use Core\Controller;

class BookController extends Controller
{
    public function index($title, $id)
    {
        $booksModel = $this->get('load')->model('Books');
        $book = $booksModel->getID($id);

        if (! $book OR is_null($book)) {
            return redirectTo('/404');
        }
        $booksModel->UpdatePageCount($book->page_count, $id);
        $book = $booksModel->getBookWithComments($id);
        if (! $book) {
            return redirectTo('/404');
        }
        $data['authorBooks'] = $booksModel->AuthorBooks($book->id, $book->author_id, 4);
        $data['categoryBooks'] = $booksModel->categoryBooks($book->id, $book->category_id, 4);
        $this->get('html')->setTitle($book->title);
        $data['book'] = $book;
        $data['recaptcha'] = $this->get('recaptcha')->widget();
        $data['token'] = $this->get('token')->generate();
        $view = $this->get('view')->render('site/book', $data);

        return $this->get('siteLayout')->render($view);
    }

    public function read($title, $id)
    {
        $booksModel = $this->get('load')->model('Books');
        $book = $booksModel->getID($id);
        if (! $book) {
            return redirectTo('/404');
        }
        $this->get('html')->setTitle($book->title);
        $book = $booksModel->getBookWithComments($id);
        $booksModel->UpdateViews($book->views, $id);
        $data['book'] = $book;
        $data['recaptcha'] = $this->get('recaptcha')->widget();
        $data['token'] = $this->get('token')->generate();
        $view = $this->get('view')->render('site/read', $data);

        return $this->get('siteLayout')->render($view);
    }

    public function download($title, $id)
    {
        $booksModel = $this->get('load')->model('Books');
        $book = $booksModel->getID($id);
        if (! $book) {
            return redirectTo('/404');
        }
        $booksModel->UpdateDownloads($book->downloads, $id);
        if (isLink($book->link)) {
            return redirectTo($book->link, true);
        } else {
            return redirectTo('/public/files/'.$book->link);
        }
    }

    public function addComment($title, $id)
    {
        $json = [];
        $booksModel = $this->get('load')->model('Books');
        $loginModel = $this->get('load')->model('Login');
        $book = $booksModel->getID($id);
        $recaptcha = $this->get('recaptcha');
        if ($recaptcha->response()) {
            if (! $loginModel->isLogged()) {
                $json['errors'] = 'يجب أن تسجل دخولك أولاً قبل التعليق!';
            } elseif (! $book) {
                $json['errors'] = 'الكتاب غير موجود!';
            } else {
                if (! $this->isValid()) {
                    $json['errors'] = implode('<br>', $this->get('valid')->getErrorMessages());
                } else {
                    if ($this->get('token')->check($this->get('request')->post('token'))) {
                        $booksModel->addNewComment($id, $loginModel->user()->id);
                        $json['success'] = 'تمت إضافة التعليق بنجاح!';
                    } else {
                        return redirectTo('/404');
                    }
                }
            }
        } else {
            $json['errors'] = 'فشل في التحقق البشري';
        }

        return $this->json($json);
    }

    private function isValid($addBook = false, $addByUrl = false)
    {
        if ($addBook) {
            $this->get('valid')->required('title', 'عنوان الكتاب مطلوب');
            $this->get('valid')->required('desc', 'وصف الكتاب مطلوب');
            $this->get('valid')->required('category', 'تصنيف الكتاب مطلوب')->isInt('category');
            $this->get('valid')->required('author', 'مؤلف الكتاب مطلوب')->isInt('author');
            $this->get('valid')->requiredFile('image', 'صورة الكتاب مطلوبة')->image('image', 'امتداد الصورة غير صحيح');
            if ($addByUrl) {
                $this->get('valid')->required('link', 'الرابط الخارجي مطلوب')->isURL('link', 'الرابط غير صحيح');
            } else {
                $this->get('valid')->requiredFile('link')->pdf('link', 'امتداد الملف غير صحيح');
            }
        } else {
            $this->get('valid')->required('comment', 'التعليق مطلوب!')->minLength('comment', 3, 'التعليق يجب ان يكون 3 أحرف على الأقل!');
        }
        $this->get('valid')->required('token');

        return $this->get('valid')->passes();
    }

    public function add()
    {
        $this->get('html')->setTitle('إضافة كتاب');
        $loginModelUser = $this->get('load')->model('Login')->user();
        $allowedGroup = $this->get('settings')['allowed_group_addbooks'];
        if ($loginModelUser->user_group_id === $allowedGroup) {
            $this->get('html')->setTitle('إضافة كتاب');
            $data['categories'] = $this->get('load')->model('Categories')->allWithSubCategories();
            $data['authors'] = $this->get('load')->model('Authors')->all();
            $data['recaptcha'] = $this->get('recaptcha')->widget();
            $data['token'] = $this->get('token')->generate();
            $view = $this->get('view')->render('site/addbook', $data);
        } else {
            $data['message'] = 'غير مسموح لك بإضافة الكتب.';
            $view = $this->get('view')->render('site/addbook', $data);
        }

        return $this->get('siteLayout')->render($view);
    }

    public function submit($addByUrl = false)
    {
        $recaptcha = $this->get('recaptcha');
        if ($recaptcha->response()) {
            if ($this->ByUrl()) {
                $addByUrl = true;
            }
            $json = [];

            if ($this->isValid(true, $addByUrl)) {
                if ($this->get('token')->check($this->get('request')->post('token'))) {
                    $status = $this->get('settings')['default_status_addbooks'];
                    $this->get('load')->model('Books')->create($addByUrl, $status);
                    $json['redirect'] = url('/profile');
                    $json['success'] = 'تمت الإضافة بنجاح';
                } else {
                    return redirectTo('/404');
                }
            } else {
                $json['errors'] = implode('<br>', $this->get('valid')->getErrorMessages());
            }
        } else {
            $json['errors'] = 'فشل في التحقق البشري';
        }

        return $this->json($json);
    }

    private function ByUrl()
    {
        return (strpos($this->get('request')->getUrl(), '/url') !== false);
    }
}
