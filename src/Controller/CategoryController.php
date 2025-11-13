<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;

final class CategoryController extends AbstractController
{
    public function NavbarCategories(): Response
    {
        return $this->render('_partials/navbar.html.twig');
    }
}