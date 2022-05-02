<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
#[Route('/tab')]
class TabController extends AbstractController
{
    #[Route('/{num<\d+>?5}', name: 'app_tab')]
    public function index($num): Response
    {  $tab=[];
        for ($i=0 ; $i<$num;$i++)
        {
            $number = rand(0, 20);
            $tab[] = $number;
        }

        return $this->render('tab/index.html.twig', [
            'tab' => $tab
        ]);
    }
}



