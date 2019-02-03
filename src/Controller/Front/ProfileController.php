<?php

namespace App\Controller\Front;

use Symfony\Component\HttpFoundation\Response;

class ProfileController
{
    public function index() : Response
    {
        return new Response('this is your profile');
    }
}
