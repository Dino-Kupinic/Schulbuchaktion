# Services
A service provides an easy and quick way to access, create, and update database tables.

### Example
An example of a service could be a `UserService`, which provides functions for creating, deleting, and editing users. The service could then be used in a `UserController` to create, delete, or edit users.

## Accessing a Service
To access a service, it must first be imported. The following code is used for this:
```PHP
use App\Services\UserService;
```

Functions of the service can then be called as follows:
```PHP
$exampleService = new ExampleService();
$result = $exampleService->exampleFunction();
```

## Code Excerpt
An example of a service could look like this:
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

## Using a Service in a Controller
A service can be used in a controller as follows:
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
A service can be tested as follows:
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





















