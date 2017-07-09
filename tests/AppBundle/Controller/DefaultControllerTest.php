<?php

namespace Tests\AppBundle\Controller;

use AppBundle\Form\TaskType;
use AppBundle\Entity\Task;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class DefaultControllerTest extends WebTestCase
{
    public function testIndex()
    {
        $client = static::createClient();

        $crawler = $client->request('GET', '/');

        $this->assertEquals(302, $client->getResponse()->getStatusCode());
    }

    public function testLoginUser()
    {
        $formLogin = array(
          '_username' => 'user',
            '_password' => 'user'
        );
        $client = static::createClient();
        $client->followRedirects(true);
        $crawler = $client->request('GET', '/');

        $this->assertEquals(200, $client->getResponse()->getStatusCode());
        $form = $crawler->selectButton('btn-login')->form();
        $crawler = $client->submit($form, $formLogin);


        $this->assertContains(
            'Bienvenue sur Todo List',
            $client->getResponse()->getContent()
        );

        //ask for the task's list
        $crawler = $client->request('GET', '/tasks');
        $this->assertEquals(200, $client->getResponse()->getStatusCode());
        $this->assertContains(
            'tache non rattachee',
            $client->getResponse()->getContent()
        );


        //create a task
        $crawler = $client->request('GET', '/tasks/create');
        $dataTask = array(
            'task[title]' => 'test task',
            'task[content]' => 'cree pour des tests',
        );
        $formTask = $crawler->selectButton('Ajouter')->form();
        $crawler = $client->submit($formTask,$dataTask );

        $crawler = $client->request('GET', '/logout');

        //ask for the task's list
        $client->followRedirects(false);
        $crawler = $client->request('GET', '/tasks');
        $this->assertEquals(302, $client->getResponse()->getStatusCode());
    }


    public function testEditDeleteTaskAsUser()
    {

        $formLogin = array(
            '_username' => 'user',
            '_password' => 'user'
        );
        $client = static::createClient();
        $client->followRedirects(true);
        $crawler = $client->request('GET', '/login');

        $this->assertEquals(200, $client->getResponse()->getStatusCode());
        $form = $crawler->selectButton('btn-login')->form();
        $crawler = $client->submit($form, $formLogin);

        $crawler = $client->request('GET', '/tasks/3/edit');
        $dataTask = array(
            'task[title]' => 'Modifier task',
            'task[content]' => 'cree pour des tests',
        );
        $formTask = $crawler->selectButton('Modifier')->form();
        $crawler = $client->submit($formTask,$dataTask );

        $this->assertContains(
            'anonyme',
            $client->getResponse()->getContent()
        );

        $crawler = $client->request('GET', '/tasks/3/delete');
        $this->assertContains(
            'Droit insuffisant pour supprimer',
            $client->getResponse()->getContent()
        );

        $crawler = $client->request('GET', '/tasks/5/delete');
        $this->assertContains(
            'La tâche a bien été supprimée.',
            $client->getResponse()->getContent()
        );

        $crawler = $client->request('GET', '/logout');
    }

    public function testAdmin()
    {
        $formLogin = array(
            '_username' => 'admin',
            '_password' => 'admin'
        );
        $client = static::createClient();
        $client->followRedirects(true);
        $crawler = $client->request('GET', '/login');

        $this->assertEquals(200, $client->getResponse()->getStatusCode());
        $form = $crawler->selectButton('btn-login')->form();
        $crawler = $client->submit($form, $formLogin);

        $this->assertContains(
            'Créer un utilisateur',
            $client->getResponse()->getContent()
        );


        $crawler = $client->request('GET', '/users');
        $this->assertEquals(200, $client->getResponse()->getStatusCode());
        $this->assertContains(
            'Liste des utilisateurs',
            $client->getResponse()->getContent()
        );

        $crawler = $client->request('GET', '/users/create');
        $dataUser = array(
            'user[username]' => 'Nouvel top utilisateur',
            'user[password][first]' => 'mdp',
            'user[password][second]' => 'mdp',
            'user[email]' => 'mdp@mdp.fr',
            'user[roles]' => 'ROLE_USER'
        );
        $formCreateUser = $crawler->selectButton('Ajouter')->form();
        $crawler = $client->submit($formCreateUser,$dataUser );

        $crawler = $client->request('GET', '/users');
        $this->assertEquals(200, $client->getResponse()->getStatusCode());
        $this->assertContains(
            'Nouvel top utilisateur',
            $client->getResponse()->getContent()
        );



        $crawler = $client->request('GET', '/users/5/edit');
        $dataUseredit = array(
            'user_edit[roles]' => 'ROLE_ADMIN'
        );
        $formEditUser = $crawler->selectButton('Modifier')->form();
        $crawler = $client->submit($formEditUser,$dataUseredit );

        $crawler = $client->request('GET', '/users');
        $this->assertEquals(200, $client->getResponse()->getStatusCode());
        $this->assertContains(
            'Nouvel top utilisateur',
            $client->getResponse()->getContent()
        );


        $crawler = $client->request('GET', '/tasks/3/delete');
        $this->assertContains(
            'La tâche a bien été supprimée.',
            $client->getResponse()->getContent()
        );
        $crawler = $client->request('GET', '/logout');
    }


    public function testUserFuncitonAsUser()
    {
        $formLogin = array(
            '_username' => 'user',
            '_password' => 'user'
        );
        $client = static::createClient();
        $client->followRedirects(true);
        $crawler = $client->request('GET', '/login');

        $this->assertEquals(200, $client->getResponse()->getStatusCode());
        $form = $crawler->selectButton('btn-login')->form();
        $crawler = $client->submit($form, $formLogin);


        $crawler = $client->request('GET', '/users');
        $this->assertEquals(403, $client->getResponse()->getStatusCode());

        $crawler = $client->request('GET', '/users/5/edit');
        $this->assertEquals(403, $client->getResponse()->getStatusCode());

        $crawler = $client->request('GET', '/logout');
    }
}
