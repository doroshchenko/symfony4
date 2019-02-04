<?php

namespace App\Controller\Front;

use App\Exception\MyCustomException;
use Symfony\Component\HttpFoundation\Response;

class ProfileController
{
    public function index() : Response
    {
        try {
            $date = new \DateTime('&');
        } catch (MyCustomException $customException) {
            echo $customException->getMessage();
        } catch(\Exception $e) {
            echo $e->getMessage();
            // write error to session
        }

        return new Response('this is your profile');
    }
}
