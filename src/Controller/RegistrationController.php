<?php

namespace App\Controller;

use App\Entity\User;
use App\Form\RegistrationFormType;
use App\Security\UserAuthenticator;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\Routing\Annotation\Route;


class RegistrationController extends AbstractController
{
    #[Route('admin/register', name: 'app_register')]
    public function register(Request $request, UserPasswordHasherInterface $userPasswordHasher,UserAuthenticator $userAuthenticator, UserAuthenticator $authenticator, EntityManagerInterface $entityManager): Response
    {
        $user = new User();
        $form = $this->createForm(RegistrationFormType::class, $user);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            // hasher le mot de passe clair 
            $user->setPassword(
                $userPasswordHasher->hashPassword(
                    $user,
                    $form->get('plainPassword')->getData()
                )
            );

            //récupère la valeur du champ "roles"
            $selectedRole = $form->get('roles')->getData();

            if($selectedRole){
                $user->setRoles([$selectedRole]);
            }else{
                $user->setRoles(['ROLE_USER']); //valeur par défaut
            }

            $entityManager->persist($user);
            $entityManager->flush();
            // do anything else you need here, like send an email

                return $this->redirectToRoute('admin_user');

        }

        return $this->render('admin/registration/register.html.twig', [
            'registrationForm' => $form->createView(),
        ]);
    }
}
