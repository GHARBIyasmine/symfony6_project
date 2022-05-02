<?php

namespace App\Controller;

use App\Entity\Personne;
use Doctrine\Persistence\ManagerRegistry;
use phpDocumentor\Reflection\Types\This;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
#[Route('/personne')]
class PersonneController extends AbstractController
{

    #[Route ('/', name: 'personne.list')]
    public function index(ManagerRegistry $doctrine):Response {
        $repository = $doctrine->getRepository(Personne::class);
        $personnes = $repository->findAll();

     return $this->render('personne/index.html.twig', ['personnes'=>$personnes]);
    }

    #[Route ('/{page<\d+>?1}/{nbr<\d+>?2}', name: 'personne.list.by')]
    public function find(ManagerRegistry $doctrine, $page , $nbr):Response {
        $repository = $doctrine->getRepository(Personne::class);
        $personnes = $repository->findby([],[] ,$nbr,(($page - 1)*$nbr));

        return $this->render('personne/index.html.twig', ['personnes'=>$personnes]);
    }




    #[Route ('/{id<\d+>}', name: 'personne.detail')]
    public function detail(ManagerRegistry $doctrine, $id , Personne $personne = null):Response {
//        $repository = $doctrine->getRepository(Personne::class);
//        $personne = $repository->find($id);

        if (!$personne){

            $this->addFlash('error', 'id not existent ');
            return $this->redirectToRoute('personne.list');

        }

        return $this->render('personne/detail.html.twig', ['personne'=>$personne]);
    }




    #[Route('/add', name: 'personne')]
    public function addPersonne(ManagerRegistry $doctrine): Response
    {   $manager = $doctrine->getManager();
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
}
