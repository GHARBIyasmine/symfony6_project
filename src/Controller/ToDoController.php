<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
#[Route ('/todo')]
class ToDoController extends AbstractController
{
    #[Route('/', name: 'todo')]
    public function index(Request $request): Response
    {
        $session = $request->getSession();
        if (!$session->has('todo')){
            $todo = [
                'achat'=>'acheter clé usb',
                'cours'=>'Finaliser mon cours',
                'correction'=>'corriger mes examens'
            ];
            $this->addFlash('init',"ToDo list initialized");
            $session->set('todo',$todo);
        }
        return $this->render('to_do/index.html.twig');
    }

     #[Route('/add/{name}/{content}', name: 'to_do.add')]
    public  function  addToDo(Request $request, $name,$content ):RedirectResponse{
         $session = $request->getSession();
        //verify the existence of todo in session
         if ($session->has('todo')) {
             // if yes
             $todo= $session->get('todo');
             //verify if name exists
             if (isset($todo[$name])) {
                 //if yes
                 //error
                 $this->addFlash('error','name already exists');
             }
             else {
                 //if not
                 // add todo + success message
                 $todo[$name]=$content;
                 $session->set('todo',$todo);
                 $this->addFlash('success','ToDo item added with success ');
             }
         }
         else {
             //if no
              //print error and redirect to controller index
             $this->addFlash('error', "The ToDo list has yet to be initialized");
         }
      return $this->redirectToRoute('todo');
     }

    #[Route('/remove/{name}', name: 'to_do.remove')]
    public  function  removeToDo(Request $request,$name):RedirectResponse{
        $session = $request->getSession();
        //verify the existence of todo in session
        if ($session->has('todo')) {
            // if yes
            $todo= $session->get('todo');
            //verify if name exists
            if (isset($todo[$name])) {
                //if yes
                //remove + success message
                unset($todo[$name]);
                $session->set('todo',$todo);
                $this->addFlash('success','Item removed successfully');
            }
            else {
                //if not
                // error
                $this->addFlash('error','ToDo item does not exist ');
            }
        }
        else {
            //if no
            //print error and redirect to controller index
            $this->addFlash('error', "The ToDo list has yet to be initialized");
        }
        return $this->redirectToRoute('todo');
    }

    #[Route('/reset', name: 'to_do.reset')]
    public  function  resetToDo(Request $request ):RedirectResponse{
        $session = $request->getSession();
        //verify the existence of todo in session
        if ($session->has('todo')) {
            // if yes
            $session->clear();
                $this->addFlash('success','ToDo list reset successfully');
            }


        else {
            //if not
            //print error and redirect to controller index
            $this->addFlash('error', "The ToDo list has yet to be initialized");
        }
        return $this->redirectToRoute('todo');
    }

    #[Route('/update/{name}/{content}', name: 'to_do.update')]
    public  function  updateToDo(Request $request, $name, $content ):RedirectResponse{
        $session = $request->getSession();
        //verify the existence of todo in session
        if ($session->has('todo')) {
            // if yes
            $todo= $session->get('todo');
            //verify if name exists
            if (isset($todo[$name])) {
                //if yes
                //update + success message
                $todo[$name]=$content;
                $session->set('todo',$todo);
                $this->addFlash('success','Item updated successfully');
            }
            else {
                //if not
                // error
                $this->addFlash('error','ToDo item does not exist ');
            }
        }
        else {
            //if no
            //print error and redirect to controller index
            $this->addFlash('error', "The ToDo list has yet to be initialized");
        }
        return $this->redirectToRoute('todo');
    }
}
