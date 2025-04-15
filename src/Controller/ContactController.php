<?php

namespace App\Controller;

use App\Entity\Contact;
use App\Form\ContactType;
use Symfony\Component\Mime\Email;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

final class ContactController extends AbstractController
{
    // https://auth.topicsdict.eu/email
    #[Route('/contact', name: 'app_contanct')]
    public function sendTest(Request $request, MailerInterface $mailer, EntityManagerInterface $entityManager): Response
    {
        $contact = new Contact();
        $contact->setCreatedAt(new \DateTimeImmutable());

        $form = $this->createForm(ContactType::class, $contact);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            // Save to DB
            $entityManager->persist($contact);
            $entityManager->flush();

            // Send email
            $email = (new Email())
                ->from('abdulrahman404@hotmail.com') // ggf. durch verifizierte Adresse ersetzen
                ->to('a.scheikh.obeid@gmail.com')   // Zieladresse hier eintragen
                ->subject('New contact message')
                ->text("From: {$contact->getEmail()}\n\n{$contact->getName()}\n\n{$contact->getMessage()}");
            $mailer->send($email);

            $this->addFlash('success', 'Your message has been sent and saved.');
        }

        return $this->render('contact/index.html.twig', [
            'contactForm' => $form->createView(),
        ]);
    }
}