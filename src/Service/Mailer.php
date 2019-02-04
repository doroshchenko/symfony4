<?php

namespace App\Service;

use App\Entity\User;
use App\Helper\CommonHelper;
use Symfony\Component\HttpFoundation\RequestStack;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;
use Symfony\Component\Templating\EngineInterface;

class Mailer
{
    const SEND_FROM             = 'send@example.com';

    const TYPE_ACTIVATE_ACCOUNT = 'activateAccount';

    /**
     * @var \Swift_Mailer
     */
    private $sender;

    /**
     * @var \Swift_Message
     */
    private $message;

    /**
     * @var EngineInterface
     */
    private $templating;

    /**
     * @var UrlGeneratorInterface
     */
    private $router;

    /**
     * @var RequestStack
     */
    private $requestStack;

    public function __construct(
        \Swift_Mailer $sender,
        EngineInterface $templating,
        UrlGeneratorInterface $router,
        RequestStack $requestStack
    ) {
        $this->sender       = $sender;
        $this->templating   = $templating;
        $this->router       = $router;
        $this->requestStack = $requestStack;
        $this->message      = new \Swift_Message();
        $this->message->setFrom(self::SEND_FROM);
    }

    public function send(User $to, string $type) : bool
    {
        $message = new \Swift_Message();

        switch ($type) {
            case self::TYPE_ACTIVATE_ACCOUNT:
                $this->setActivateAccountMessage($to, $message);
                break;
            default:
                break;
        }

        return $this->sender->send($this->message);
    }

    /**
     * @param User $to
     */
    public function setActivateAccountMessage(User $to) : void
    {
        $proceedLink = $this->requestStack->getCurrentRequest()->getBaseUrl()
            . $this->router->generate('app_activate_profile', ['hash' => urlencode(CommonHelper::encrypt($to->getEmail()))]);

        $body = $this->templating->render(
            'emails/registration.html.twig',
            [
                'userName'    => $to->getUsername(),
                'proceedLink' => $proceedLink,
            ]
        );

        $this->message->setSubject('Activate your account')
            ->setTo($to->getEmail())
            ->setBody($body, 'text/html');
    }
}
