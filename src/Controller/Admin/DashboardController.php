<?php

namespace App\Controller\Admin;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class DashboardController extends AbstractController
{
    /**
     * @param Request $request
     *
     * @return Response
     */
    public function index(Request $request) : Response
    {
       // $this->denyAccessUnlessGranted('ROLE_ADMIN');
       // $this->denyAccessUnlessGranted('ROLE_ADMIN', null, 'User tried to access a page without having ROLE_ADMIN');
        return new Response(
            '<html><body><h1>Admin dashboard</h1></body>'
        );
    }
}
