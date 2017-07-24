<?php
namespace Tests\AppBundle\Repository;

use AppBundle\Entity\Task;
use Doctrine\Common\Persistence\ObjectManager;
use Doctrine\Common\Persistence\ObjectRepository;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;

class TodoListRepositoryTest extends KernelTestCase
{
    /**
     * @var \Doctrine\ORM\EntityManager
     */
    private $em;

    /**
     * {@inheritDoc}
     */
    protected function setUp()
    {
        self::bootKernel();

        $this->em = static::$kernel->getContainer()
            ->get('doctrine')
            ->getManager();
    }

    public function testEntityTask()
    {
        $task = $this->em->getRepository('AppBundle:Task')->find(5);


        $this->assertContains('tache super simple', $task->getContent());

        $task->setContent('tache super simple modifier par phpuni');
        $this->em->persist($task);
        $this->em->flush();
    }


    public function testWithMock()
    {
        $task = new Task();
        $task->setTitle('test Mock');

        $taskRepository = $this->createMock(ObjectRepository::class);

        $taskRepository->expects($this->any())
            ->method('find')
            ->willReturn($task);

        $taskEm = $taskRepository->find(1);
        $this->assertContains(
            'test Mock',
            $taskEm->getTitle()
        );

    }
}