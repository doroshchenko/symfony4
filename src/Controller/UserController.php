<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;

class UserController extends AbstractController
{
    /**
     * @return Response
     */
    public function profile() : Response
    {
  /*      $user        = $this->getUser();
        $userManager = $this->container->get('userManager');

        try {
            $userManager->login($user);
        } catch (\Exception $e) {
            $e->getMessage();
        }*/

        return new Response(
            'this is response'
        );
    }
}
