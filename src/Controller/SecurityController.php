<?php

namespace App\Controller;

use App\Entity\User;
use App\Form\RegistrationType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

/**
 * @Route("/security", name="security_")
 */
class SecurityController extends AbstractController
{
    /**
     * @Route("/registration", name="registration")
     */
    public function registration(Request $request, UserPasswordEncoderInterface $encoder)
    {
        $manager = $this->getDoctrine()->getManager();

        $user = new User();

        $form = $this->createForm(RegistrationType::class, $user);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid())
        {
            $hash = $encoder->encodePassword($user, $user->getPassword());
            $user->setPassword($hash);

            $manager->persist($user);
            $manager->flush();

            return $this->redirectToRoute('security_login');
        }

        return $this->render("security/registration.html.twig", [
            "form" => $form->createView()
        ]);
    }

    /**
     * @Route("/login", name="login")
     */
    public function login()
    {
        // the identification is done thanks Symfony security configuration

        return $this->render("security/login.html.twig");
    }

    /**
     * @Route("/logout", name="logout")
     */
    public function logout()
    {
        // nothing to do here

        return $this->render('index.html.twig');
    }
}
