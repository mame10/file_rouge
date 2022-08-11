<?php

namespace App\Services;

use Twig\Environment;
use Symfony\Component\Mime\Email;
use Symfony\Component\Mailer\MailerInterface;
// use Symfony\Component\DependencyInjection\Loader\Configurator\twig;

class MailerService
{

    public function __construct(MailerInterface $mailer, Environment $twig)
    {
        $this->mailer = $mailer;
        $this->twig = $twig;
    }
    // src/Controller/MailerController.php

    public function sendEmail($user, $object = 'creation de compte')
    {
        $email = (new Email())
            ->from('mame@mamemalick.com')
            ->to('mame@mamemalick.com')
            ->subject($object)
            ->html($this->twig->render('mailer/index.html.twig', ['user' => $user]));

        $this->mailer->send($email);
    }
}
