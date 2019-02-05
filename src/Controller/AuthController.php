<?php

namespace App\Controller;

use App\Exception\MailerException;
use App\Form\LoginFormType;
use App\Service\Mailer;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;
use App\Entity\User;
use App\Form\RegistrationFormType;
use App\Helper\CommonHelper;
use App\Security\LoginFormAuthenticator;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;
use Symfony\Component\Security\Guard\GuardAuthenticatorHandler;

class AuthController extends AbstractController
{
    const AUTH_ERROR = 'authError';

    /**
     * @param AuthenticationUtils $authenticationUtils
     *
     * @return Response
     */
    public function login(AuthenticationUtils $authenticationUtils) : Response
    {
        $error        = $authenticationUtils->getLastAuthenticationError();
        $lastUsername = $authenticationUtils->getLastUsername();

        $loginForm = $this->createForm(LoginFormType::class);

        return $this->render('security/login.html.twig',
            [
                'loginForm'     => $loginForm->createView(),
                'last_username' => $lastUsername,
                'error'         => $error
            ]
        );
    }

    public function register(
        Request $request,
        UserPasswordEncoderInterface $passwordEncoder,
        GuardAuthenticatorHandler $guardHandler,
        LoginFormAuthenticator $authenticator,
        Mailer $mailer,
        EntityManagerInterface $em
    ): Response {
        try {
            $user = new User();
            $form = $this->createForm(RegistrationFormType::class, $user);
            $form->handleRequest($request);

            if ($form->isSubmitted() && $form->isValid()) {
                $user
                    ->setEnabled(false)
                    ->setSalt(CommonHelper::generateHash())
                    ->setPassword($passwordEncoder->encodePassword($user, $form->get('plainPassword')->getData()));

                if (!$mailer->send($user, Mailer::TYPE_ACTIVATE_ACCOUNT)) {
                    throw new MailerException('Activate account email was not sen\'t for '. $user->getEmail()
                        . ' .Registration in failed');
                }

                $em->persist($user);
                $em->flush();

                return $guardHandler->authenticateUserAndHandleSuccess(
                    $user,
                    $request,
                    $authenticator,
                    'main'
                );
            }
        } catch (MailerException $mailerException) {
            $error = $mailerException->getMessage();
        } catch (\Exception $exception) {
            $error = $exception->getMessage();
        }

        return $this->render('security/register.html.twig', [
            'registrationForm' => $form->createView(),
            'error'            => $error ?? null,
        ]);
    }

    /**
     * @param Request $request
     * @param string $hash
     * @param EntityManagerInterface $em
     * @return RedirectResponse
     */
    public function activateProfile(Request $request, string $hash, EntityManagerInterface $em) : RedirectResponse
    {
        try {
            $email = CommonHelper::decrypt(urldecode($hash));
            $user  = $em->getRepository(User::class)->findOneByEmail($email);
            $user->setEnabled(true);

            $em->persist($user);
            $em->flush();
        } catch (\Exception $e) {
            if ($request->hasSession()) {
                $request->getSession()->set(self::AUTH_ERROR, $e);
            }
        }

        return $this->redirectToRoute('index');
    }
}
