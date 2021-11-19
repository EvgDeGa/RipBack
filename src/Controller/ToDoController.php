<?php

namespace App\Controller;

use App\Entity\ToDo;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

/**
 *
 *
 *
 * @Route(path="/todo")
 */
class ToDoController extends  AbstractController
{

    /**
     * @Route("/", name="get_todo",methods={"GET"})
     */
    public function getToDos(): Response
    {
        $em = $this->getDoctrine()->getManager();
        $todos = $em->getRepository(ToDo::class)->findAll();
        return $this->json(['data' => $todos]);
    }

    /**
     * @Route("/", name="add_todo", methods={"POST"})
     */
    public function addTodo(Request $request): Response
    {
        $em = $this->getDoctrine()->getManager();
        $decodedRequest = json_decode($request->getContent());
        print $decodedRequest->{'text'}; // 12345

        $todo = new ToDo();
        $todo->setText($decodedRequest->{'text'});
        $todo->setChecked(false);

        $em->persist($todo);
        $em->flush();
        return $this->json(["data" => $todo]);
    }

    /**
     * @Route("/{id}", name="getTodo", methods={"GET"})
     */
    public function getTodo($id): Response
    {
        $todo = $this->getDoctrine()
            ->getRepository(ToDo::class)
            ->find($id);
//        print json_decode($todo); // 12345

        if (!$todo) {
            return new Response($this->json(['message' => "No todo found for id $id"]), 404);
        }
        return $this->json(['data' => $todo]);
    }
    /**
     * @Route("/{id}", name="todo_update",methods={"PUT"})
     */
    public function updateTodo(Request $request, $id): Response
    {
        $entityManager = $this->getDoctrine()->getManager();
        $decodedRequest = json_decode($request->getContent());
        $todo = $entityManager->getRepository(ToDo::class)->find($id);
        if (!$todo) {
            return new Response($this->json(['message' => "No todo found for id $id"]), 404);
        }
        $todo->setText($decodedRequest->{'text'});

        $entityManager->flush();
        return $this->json(['message' => "todo successfully updated", 'data' => $todo]);
    }

    /**
     * @Route("/{id}", name="task_todo",methods={"DELETE"})
     */
    public function deleteTodo($id): Response
    {
        $entityManager = $this->getDoctrine()->getManager();
        $todo = $entityManager->getRepository(ToDo::class)->find($id);
        if (!$todo) {
            return new Response($this->json(['message' => "No todo found for id .$id"]), 404);
        }
        $entityManager->remove($todo);
        $entityManager->flush();
        return $this->json(['message' => "todo successfully removed"]);
    }

}