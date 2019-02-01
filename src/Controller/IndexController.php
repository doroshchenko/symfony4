<?php

namespace App\Controller;

use App\Security\LoginFormAuthenticator;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\RedirectResponse;

class IndexController extends AbstractController
{
    /**
     * @return RedirectResponse
     */
    public function index() : RedirectResponse
    {
        $user = $this->getUser();

        if ($user->hasRole(LoginFormAuthenticator::ROLE_ADMIN)) {
            $route = 'admin_index';
        } elseif ($user->hasRole(LoginFormAuthenticator::ROLE_USER)) {
            $route = 'user_profile';
        }

        return $this->redirectToRoute($route ?? null);
    }
}
