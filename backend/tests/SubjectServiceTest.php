<?php

namespace App\Tests;

use App\Entity\Subject;
use App\Repository\SubjectRepository;
use App\Service\SubjectService;
use Doctrine\ORM\EntityManagerInterface;
use PHPUnit\Framework\MockObject\Exception;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;

class SubjectServiceTest extends KernelTestCase
{
  /**
   * @throws Exception
   */
  public function testPersistSubject(): void
  {
    $kernel = self::bootKernel();

    $this->assertSame('test', $kernel->getEnvironment());

    try {
      $subject1 = ObjectFactory::createSubject();

      $subjectRepository = $this->createMock(SubjectRepository::class);
      $em = $this->createMock(EntityManagerInterface::class);

      $subjectService = new SubjectService($em, $subjectRepository);

      $em->expects($this->once())
        ->method('persist')
        ->with($this->equalTo($subject1));

      $em->expects($this->once())
        ->method('flush');

      $subjectService->createSubject($subject1);
    } catch (Exception $e) {
      $this->fail($e->getMessage());
    } catch (\Exception $e) {
      $this->fail($e->getMessage());
    } finally {
      restore_exception_handler();
    }
  }

  /**
   * @throws Exception
   */
  public function testGetSubjects(): void
  {
    $entityManager = $this->createMock(EntityManagerInterface::class);
    $subjectRepository = $this->createMock(SubjectRepository::class);
    $expectedResult = [new Subject(), new Subject()];

    $subjectRepository->expects($this->once())
      ->method('findAll')
      ->willReturn($expectedResult);

    $subjectService = new SubjectService($entityManager, $subjectRepository);
    $result = $subjectService->getSubjects();

    $this->assertSame($expectedResult, $result);
  }
}
