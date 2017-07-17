<?php
namespace Tests\BileMoBundle\Repository;

use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;

class RepositoryTest extends KernelTestCase
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
	
	
	public function testsRepo()
	{
		$phones = $this->em->getRepository('BileMoBundle:Phone')->find(1);
		
		$this->assertContains('Galaxy', $phones->getName());
		
		$this->assertContains('Galaxy', $phones->getDescription());
	}
}