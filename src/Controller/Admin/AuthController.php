<?php

namespace App\Controller\Admin;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class AuthController extends AbstractController
{
    public function auth_boxed_signin(): Response
    {
        return $this->render('admin/auth/boxed-signin.html.twig');
    }

    public function auth_boxed_signup(): Response
    {
        return $this->render('admin/auth/boxed-signup.html.twig');
    }

    public function auth_boxed_lockscreen(): Response
    {
        return $this->render('admin/auth/boxed-lockscreen.html.twig');
    }

    public function auth_boxed_password_reset(): Response
    {
        return $this->render('admin/auth/boxed-password-reset.html.twig');
    }

    public function auth_cover_login(): Response
    {
        return $this->render('admin/auth/cover-login.html.twig');
    }

    public function auth_cover_register(): Response
    {
        return $this->render('admin/auth/cover-register.html.twig');
    }

    public function auth_cover_lockscreen(): Response
    {
        return $this->render('admin/auth/cover-lockscreen.html.twig');
    }

    public function auth_cover_password_reset(): Response
    {
        return $this->render('admin/auth/cover-password-reset.html.twig');
    }

}
