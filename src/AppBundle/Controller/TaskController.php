<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Task;
use AppBundle\Form\Type\TaskType;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

class TaskController extends Controller
{
    /**
     * @Route("/tasks", name="task_list")
     */
    public function listAction()
    {
    	return $this->render('task/list.html.twig', $this->getTasks('tasks'));
    }
    
    /**
     * @Route("/tasks/open", name="open_task_list")
     */
    public function openListAction()
    {
    	return $this->render('task/list.html.twig', $this->getTasks('openTasks'));
    }
    
    /**
     * @Route("/tasks/close", name="close_task_list")
     */
    public function closeListAction()
    {
    	return $this->render('task/list.html.twig', $this->getTasks('closeTasks'));
    }

    
    /**
     * @Route("/tasks/create", name="task_create")
     */
    public function createAction(Request $request)
    {
        $task = new Task();
        $form = $this->createForm(TaskType::class, $task);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();

            $task->setUser($this->container->get('security.token_storage')->getToken()->getUser());
            $em->persist($task);
            $em->flush();
            $this->cleanCache();
            $this->addFlash('success', 'La tâche a été bien été ajoutée.');

            return $this->redirectToRoute('task_list');
        }

        return $this->render('task/create.html.twig', ['form' => $form->createView()]);
    }

    /**
     * @Route("/tasks/{id}/edit", name="task_edit")
     */
    public function editAction(Task $task, Request $request)
    {
        $form = $this->createForm(TaskType::class, $task);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();
            $this->cleanCache();

            $this->addFlash('success', 'La tâche a bien été modifiée.');

            return $this->redirectToRoute('task_list');
        }

        return $this->render('task/edit.html.twig', [
            'form' => $form->createView(),
            'task' => $task,
        ]);
    }

    /**
     * @Route("/tasks/{id}/toggle", name="task_toggle")
     */
    public function toggleTaskAction(Task $task)
    {
        $task->toggle(!$task->isDone());
        $this->getDoctrine()->getManager()->flush();
        $this->cleanCache();
        $this->addFlash('success', sprintf('La tâche %s a bien été marquée comme faite.', $task->getTitle()));

        return $this->redirectToRoute('task_list');
    }

    /**
     * @Route("/tasks/{id}/delete", name="task_delete")
     */
    public function deleteTaskAction(Task $task, Request $request)
    {
    	
    	if ($this->isCsrfTokenValid('authenticate',  $request->get('_csrf_token')))
    	{
	        if (($task->getUser() &&  $task->getUser() === $this->container->get('security.token_storage')->getToken()->getUser()) 
	        		|| ($this->get('security.authorization_checker')->isGranted('ROLE_ADMIN')))
	        {
	        	$em = $this->getDoctrine()->getManager();
	        	$em->remove($task);
	        	$em->flush();
	        	$this->cleanCache();
	        	$this->addFlash('success', 'La tâche a bien été supprimée.');
	        	
	        	return $this->redirectToRoute('task_list');
	        } else {
	        	$this->addFlash('success', 'Droit insuffisant pour supprimer la tâche.');
	        	
	        	return $this->redirectToRoute('task_list');
	        }
    	}
    	return $this->redirectToRoute('task_list');
    }
    
    private function getTasks($cacheName)
    {
    	$cachedTasks = $this->get('cache.app')->getItem($cacheName);
    	
    	if (!$cachedTasks->isHit()) {
    		if ($cacheName == 'tasks'){
    			$tasks = array('tasks' => $this->getDoctrine()->getRepository('AppBundle:Task')->findAll());
    		}
    		else if ($cacheName == 'openTasks'){
    			$tasks = array('tasks' => $this->getDoctrine()->getRepository('AppBundle:Task')->findOpen(false));
    		}
    		else {
    			$tasks = array('tasks' => $this->getDoctrine()->getRepository('AppBundle:Task')->findOpen(true));
    		}
    		$cachedTasks->set($tasks);
    		$this->get('cache.app')->save($cachedTasks);
    	} else {
    		$tasks = $cachedTasks->get();
    	}
    	return $tasks;
    }
    
    private function cleanCache()
    {
    	$this->get('cache.app')->deleteItem('tasks');
    	$this->get('cache.app')->deleteItem('openTasks');
    	$this->get('cache.app')->deleteItem('closeTasks');
    }
}
