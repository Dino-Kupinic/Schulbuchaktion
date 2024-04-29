<?php

namespace App\Tests;

use App\Entity\Subject;
use App\Repository\SubjectRepository;
use App\Service\SubjectService;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;

class SubjectServiceTest extends KernelTestCase
{
    public function testSomething(): void
    {
        $kernel = self::bootKernel();

        $this->assertSame('test', $kernel->getEnvironment());
        // $routerService = static::getContainer()->get('router');
        // $myCustomService = static::getContainer()->get(CustomService::class);

      $subject1 = ObjectFactory::createSubject();

      try {
        $subjectService = new SubjectService();

        $em = $this->createMock(EntityManagerInterface::class);

        $em->expects($this->once())
          ->method('persist')
          ->with($this->equalTo($subject1));

        $em->expects($this->once())
          ->method('flush');

        $subjectService->createSubject($subject1, $em);
      } finally {
        restore_exception_handler();
      }
    }

  /**
   * @throws Exception
   */
  public function testGetSubject(): void
  {
    $subjectService = new SubjectService();
    $subjectRepository = $this->createMock(SubjectRepository::class);
    $expectedResult = [new Subject(), new Subject()];

    $subjectRepository->expects($this->once())
      ->method('findAll')
      ->willReturn($expectedResult);

    $result = $subjectService->getSubjects($subjectRepository);

    $this->assertSame($expectedResult, $result);
  }
}
