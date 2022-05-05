<?php

namespace App\Controller;

use App\Entity\Personne;
use App\Form\PersonneType;
use Doctrine\Persistence\ManagerRegistry;
use phpDocumentor\Reflection\Types\This;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
#[Route('/personne')]
class PersonneController extends AbstractController
{

    #[Route ('/', name: 'personne.list')]
    public function index(ManagerRegistry $doctrine): Response
    {
        $manager = $doctrine->getRepository(Personne::class);
        $personnes = $manager->findAll();

        return $this->render('personne/index.html.twig', ['personnes' => $personnes, 'isPaginated'=>false]);
    }

    #[Route ('/all/age/{ageMin<\d+>?18}/{ageMax<\d+>?35}', name: 'personne.list.age')]
    public function age(ManagerRegistry $doctrine, $ageMin, $ageMax): Response
    {
        $manager = $doctrine->getRepository(Personne::class);
        $personnes = $manager->findByAge($ageMin,$ageMax);

        return $this->render('personne/index.html.twig', ['personnes' => $personnes, 'isPaginated'=>false]);
    }

    #[Route ('/all/{page<\d+>?1}/{nbr<\d+>?2}', name: 'personne.list.by')]
    public function find(ManagerRegistry $doctrine, $page, $nbr): Response
    {
        $manager = $doctrine->getRepository(Personne::class);
        $nbPersonnes = $manager->count([]);
        $nbpage = ceil($nbPersonnes / $nbr);
        $personnes = $manager->findby([], [], $nbr, (($page - 1) * $nbr));

        return $this->render('personne/index.html.twig', [
            'personnes' => $personnes,
            'nbpages' => $nbpage,
            'nbr' => $nbr,
            'page' => $page,
            'isPaginated' => true

        ]);
    }


    #[Route ('/{id<\d+>}', name: 'personne.detail')]
    public function detail(ManagerRegistry $doctrine, $id, Personne $personne = null): Response
    {
        //        $manager = $doctrine->getRepository(Personne::class);
        //        $personne = $manager->find($id);

        if (!$personne) {

            $this->addFlash('error', 'id not existent ');
            return $this->redirectToRoute('personne.list');

        }

        return $this->render('personne/detail.html.twig', ['personne' => $personne]);
    }


    #[Route('/add', name: 'personne')]
    public function addPersonne(ManagerRegistry $doctrine): Response
    {
        $manager = $doctrine->getManager();
        $personne = new Personne();
        $personne->setName('yasmine');
        $personne->setAge('20');
        $personne->setLastname('gharbi');

        $manager->persist($personne);
        $manager->flush();

        return $this->render('personne/detail.html.twig', [
            'personne' => $personne,
        ]);
    }

    #[Route('/edit/{id?0}', name: 'personne.form')]
    public function addPersonneForm(ManagerRegistry $doctrine , Request $request, Personne $personne=null): Response
    {
       if (!$personne){
           $personne = new Personne();
       }

        $form = $this->createForm(PersonneType::class, $personne);

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()){

            $manager = $doctrine->getManager();
            $manager->persist($personne);
            $manager->flush();
            $this->addFlash('success','form submitted successfully');
            return $this->redirectToRoute('personne.list');
        }
        else{
            return $this->render('personne/from.html.twig', [
                'form' => $form->createView()
            ]);
        }


    }


    #[Route('/remove/{id<\d+>?0}', name: 'removePersonne')]
    public function remove(ManagerRegistry $doctrine, Personne $personne = null): RedirectResponse
    {
        if (!$personne) {
            $this->addFlash('error', 'id non existent');

        } else {
            $manager = $doctrine->getManager();
            $manager->remove($personne);
            $manager->flush();
            $this->addFlash('success', 'entry removed successfully');
        }
        return $this->redirectToRoute('personne.list');
    }


    #[Route('/update/{id}/{name}/{lastname}/{age}', name: 'updatePersonne')]
    public function update( $name, $lastname, $age,ManagerRegistry $doctrine,Personne $personne = null): RedirectResponse
    {
     if (!$personne){
         $this->addFlash('error', 'id non existent');

     }
        else{
            $personne->setName($name);
            $personne->setLastname($lastname);
            $personne->setAge($age);
            $manager= $doctrine->getManager();
            $manager->persist($personne);
            $manager->flush();
            $this->addFlash('success', 'entry updated successfully');
        }

     return $this->redirectToRoute('personne.list');
    }
}