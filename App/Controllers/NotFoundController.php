<?php

namespace App\Controllers;

use Core\Controller;

class NotFoundController extends Controller
{
    public function index()
    {
        return $this->get('view')->render('not-found');
    }
}
