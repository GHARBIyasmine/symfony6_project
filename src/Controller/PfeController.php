<?php

namespace App\Controller;

use App\Entity\Entreprise;
use App\Entity\Pfe;
use App\Form\PfeType;

use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
#[Route('/pfe')]
class PfeController extends AbstractController
{
    #[Route('/add', name: 'pfe.add')]
    public function index( ManagerRegistry $doctrine, Request $request): Response
    {
      $manager= $doctrine->getManager();



      $pfe= new Pfe();
      $form = $this->createForm(PfeType::class, $pfe);
      // to make the submit button works
      $form->handleRequest($request);
      if ($form->isSubmitted()){
          $this->addFlash('success', 'entry added successfully');
          $manager->persist($pfe);
          $manager->flush();
          return $this->redirectToRoute('pfe.detail', [
              'id' => $pfe->getId()
          ]);

      }

  else {
      // to display the form
      return $this->render('pfe/add.html.twig', [
          'form' => $form->createView()
      ]);
  }
    }

    #[Route('/detail/{id?0}', name: 'pfe.detail')]
    public function detail( ManagerRegistry $doctrine, Pfe $pfe =null ): Response {

        if (!$pfe) {

            $this->addFlash('error', 'id not existent ');
            return $this->redirectToRoute('pfe.add');

        }

        return $this->render('pfe/detail.html.twig', ['pfe'=> $pfe]);
    }

    #[Route('/stats', name: 'pfe.stats')]
    public function stats( ManagerRegistry $doctrine): Response {
        $tab = [];
        $repository = $doctrine->getRepository(Entreprise::class);
        $entreprises = $repository->findAll();
        $repository2 = $doctrine->getRepository(Pfe::class);
        $tab=$repository2->statsPfe();

        for ($i =0 ; $i < count($tab); $i++){
            $ent = $entreprises[$i];
            $tab[$i][]= $ent->getName();
        }
    return $this->render('pfe/stats.html.twig',[
        'tab'=>$tab

    ]);
    }

}
