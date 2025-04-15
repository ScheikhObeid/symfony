<?php

namespace App\Controller;

use Symfony\Component\Mime\Email;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

final class EmailController extends AbstractController
{
    // https://auth.topicsdict.eu/email
    #[Route('/email', name: 'app_email')]
    public function sendTest(MailerInterface $mailer): Response
    {
        $email = (new Email())
            ->from('abdulrahman404@hotmail.com') // ggf. durch verifizierte Adresse ersetzen
            ->to('a.scheikh.obeid@gmail.com')   // Zieladresse hier eintragen
            ->subject('Testmail über Brevo')
            ->text('Das ist ein Test über Symfony und Brevo.');

        $mailer->send($email);
        
        return new Response('✅ E-Mail wurde gesendet!');
    }
}
