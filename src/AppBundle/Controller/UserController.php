<?php

namespace AppBundle\Controller;

use AppBundle\Entity\User;
use AppBundle\Form\Type\UserEditType;
use AppBundle\Form\Type\UserType;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

class UserController extends Controller
{
    /**
     * @Route("/users", name="user_list")
     */
    public function listAction()
    {
    	
    	$cachedUsers = $this->get('cache.app')->getItem('users');
    	    
    	if (!$cachedUsers->isHit()) {
    		$users= array('users' => $this->getDoctrine()->getRepository('AppBundle:User')->findAll());
    		$cachedUsers->set($users);
    		$this->get('cache.app')->save($cachedUsers);
    	} else {
    		$users= $cachedUsers->get();
    	}
    	
    	return $this->render('user/list.html.twig', $users);
    }

    /**
     * @Route("/users/create", name="user_create")
     */
    public function createAction(Request $request)
    {
        $user = new User();
        $form = $this->createForm(UserType::class, $user);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $user->setPassword($this->get('security.password_encoder')->encodePassword($user, $user->getPassword()));
            
            $role = $form->get('roles')->getData();
            $roles = [];
            foreach ($role as $key => $value) {
                $roles[] = $value;
            }
            $user->setRoles($roles);

            $em->persist($user);
            $em->flush();
            $this->get('cache.app')->deleteItem('users');
            $this->addFlash('success', "L'utilisateur a bien été ajouté.");

            return $this->redirectToRoute('user_list');
        }

        return $this->render('user/create.html.twig', ['form' => $form->createView()]);
    }

    /**
     * @Route("/users/{id}/edit", name="user_edit")
     */
    public function editAction(User $user, Request $request)
    {
        $form = $this->createForm(UserEditType::class, $user);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $role = $form->get('roles')->getData();
            $roles = [];
            foreach ($role as $key => $value) {
                $roles[] = $value;
            }
            $user->setRoles($roles);

            $this->getDoctrine()->getManager()->flush();
            $this->get('cache.app')->deleteItem('users');
            $this->addFlash('success', "L'utilisateur a bien été modifié");

            return $this->redirectToRoute('user_list');
        }

        return $this->render('user/edit.html.twig', ['form' => $form->createView(), 'user' => $user]);
    }
}
