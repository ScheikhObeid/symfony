<?php

namespace App\Controller;

use App\Entity\User;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\RepeatedType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

final class RegisterController extends AbstractController
{
    #[Route('/register', name: 'app_register')]
    public function register(Request $request, UserPasswordHasherInterface $passwordHasher, EntityManagerInterface $entityManager): Response
    {
        $registerForm = $this->createFormBuilder();
        $registerForm 
            ->add('username', TextType::class, [
                'label' => 'User'
            ])
            ->add('password', RepeatedType::class, [
                'type' => PasswordType::class,
                'required' => true, // ✅ fixed "require"
                'first_options' => ['label' => 'Password'], // ✅ fixed "first_option" + "lebel"
                'second_options' => ['label' => 'Repeat password'], // ✅ fixed "second_option" + "lebel"
            ])
            ->add('register', SubmitType::class);
    
        $form = $registerForm->getForm(); // ✅ must call getForm() outside chain if $registerForm used
    
        $form->handleRequest($request);
        if($form->isSubmitted()){
            if ($form->isValid()) {
                $input = $form->getData();
                $user = new User();
                $user->setUsername($input['username']);
                $hashedPassword = $passwordHasher->hashPassword($user, $input['password']);
                $user->setPassword($hashedPassword);
                $entityManager->persist($user);
                $entityManager->flush();
            } else {
                dump('invalid');
            }
        }

        return $this->render('register/index.html.twig', [
            'regform' => $form->createView(), // ✅ use $form here
            'controller_name' => 'RegisterController',
        ]);
    }
}
