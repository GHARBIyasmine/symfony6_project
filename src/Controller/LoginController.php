<?php

namespace App\Controller;


use App\Entity\Profile;
use App\Form\ProfileType;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
#[Route('/login')]
class LoginController extends AbstractController
{
    #[Route('/', name: 'join')]
    // the first page
    public function index(): Response
    {
        return $this->render('login/index.html.twig',

        );
    }

//    #[Route('/signup/{id?0}', name: 'join.signup')]
//   // sign up or edit profile
//    public function signUp(ManagerRegistry $doctrine , Request $request, Profile $profile=null): Response
//    {
//        if (!$profile) {
//            $profile = new Profile();
//        }
//
//        $form = $this->createForm(ProfileType::class, $profile);
//
//        $form->handleRequest($request);
//        if ($form->isSubmitted() && $form->isValid()) {
//
//            $manager = $doctrine->getManager();
//            $manager->persist($profile);
//            $manager->flush();
//            $this->addFlash('success', 'form submitted successfully');
//            return $this->redirectToRoute('home');
//        } else {
//            return $this->render('login/from.html.twig', [
//                'form' => $form->createView()
//            ]);
//        }



















}
