<?php

namespace App\Controller;

use App\Security\LoginFormAuthenticator;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\RedirectResponse;

class IndexController extends AbstractController
{
    const PAGE_ADMIN   = 'admin_index';
    const PAGE_PROFILE = 'profile_index';

    /**
     * @return RedirectResponse
     */
    public function index() : RedirectResponse
    {
        $user = $this->getUser();

        if ($user->hasRole(LoginFormAuthenticator::ROLE_ADMIN)) {
            $route = self::PAGE_ADMIN;
        } elseif ($user->hasRole(LoginFormAuthenticator::ROLE_USER)) {
            $route = self::PAGE_PROFILE;
        }

        return $this->redirectToRoute($route ?? null);
    }
}
