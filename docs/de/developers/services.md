# Services
Ein Service bietet die Möglichkeit einfach und schnell den Zugriff, die Erstellung und das Updaten von Datenbank-Tabellen zu ermöglichen.

### Beispiel
Ein Beispiel für einen Service könnte ein `UserService` sein, welcher Funktionen zum Erstellen, Löschen und Bearbeiten von Benutzern bereitstellt. Der Service könnte dann in einem `UserController` verwendet werden, um Benutzer zu erstellen zu löschen oder zu bearbeiten.

## Auf Service zugreifen
Um auf einen Service zuzugreifen, muss dieser zuerst importiert werden. Dazu wird folgender Code verwendet:
```PHP
use App\Services\BeispielService;
```
Funktionen des Services können dann wie folgt aufgerufen werden:
```PHP
$beispielService = new BeispielService();
$result = $beispielService->beispielFunktion();
```

## Code Auszug
Ein Beispiel für einen Service könnte wie folgt aussehen:
```PHP
<?php

namespace App\Service;

use App\Entity\BookOrder;
use App\Repository\BookOrderRepository;
use Doctrine\ORM\EntityManagerInterface;

class BookOrderService
{
  public function updateBookOrder(BookOrder $bookOrder, EntityManagerInterface $em): void
  {
    $bookOrderUpdate = $em->getRepository(BookOrder::class)->find($bookOrder->getId());
    $bookOrderUpdate->setSchoolClass($bookOrder->getSchoolClass());
    $bookOrderUpdate->setBookId($bookOrder->getBookId());
    $bookOrderUpdate->setYear($bookOrder->getYear());
    $bookOrderUpdate->setCount($bookOrder->getCount());
    $bookOrderUpdate->setTeacherCopy($bookOrder->getTeacherCopy());
    $bookOrderUpdate->setLastUser($bookOrder->getLastUser());
    $bookOrderUpdate->setCreationUser($bookOrder->getCreationUser());
    $em->flush();
  }
}
```

## Service in Controller verwenden
Ein Service kann in einem Controller wie folgt verwendet werden:
```PHP
<?php

namespace App\Controller;

use App\Service\BookOrderService;

class BookOrderController extends AbstractController
{
  public function updateBookOrder(BookOrderService $bookOrderService, EntityManagerInterface $em): Response
  {
    $bookOrder = new BookOrder();
    $bookOrder->setId(1);
    $bookOrder->setSchoolClass('1A');
    $bookOrder->setBookId(1);
    $bookOrder->setYear(2021);
    $bookOrder->setCount(10);
    $bookOrder->setTeacherCopy(false);
    $bookOrder->setLastUser('admin');
    $bookOrder->setCreationUser('admin');
    $bookOrderService->updateBookOrder($bookOrder, $em);
    return new Response('BookOrder updated');
  }
}
```

## Service Tests
Ein Service kann wie folgt getestet werden:
```PHP
<?php

namespace App\Tests;

use App\Entity\BookOrder;
use App\Repository\BookOrderRepository;
use App\Service\BookOrderService;
use Doctrine\ORM\EntityManagerInterface;
use PHPUnit\Framework\MockObject\Exception;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;

class BookOrderServiceTest extends KernelTestCase
{
  /**
   * @throws Exception
   */
  public function testSomething(): void
    {
      $bookOrder1 = ObjectFactory::createBookOrder();

      try {
        $bookOrderService = new BookOrderService();

        $em = $this->createMock(EntityManagerInterface::class);

        $em->expects($this->once())
          ->method('persist')
          ->with($this->equalTo($bookOrder1));

        $em->expects($this->once())
          ->method('flush');

        $bookOrderService->createBookOrder($bookOrder1, $em);
      } finally {
        restore_exception_handler();
      }
    }

  /**
   * @throws Exception
   */
  public function testGetBookOrders(): void
  {
    $bookOrderService = new BookOrderService();
    $bookOrderRepository = $this->createMock(BookOrderRepository::class);
    $expectedResult = [new BookOrder(), new BookOrder()];

    $bookOrderRepository->expects($this->once())
      ->method('findAll')
      ->willReturn($expectedResult);

    $result = $bookOrderService->getBookOrders($bookOrderRepository);

    $this->assertSame($expectedResult, $result);
  }
}
```
