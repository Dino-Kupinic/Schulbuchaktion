# Services

A service abstracts the business logic of an application from the controller. It is used to perform operations on the
database, such as creating, deleting, or editing entities. Services are used to keep controllers clean and to separate
the business logic from the controller logic.

### Example

An example of a service could be a `UserService`, which provides functions for creating, deleting, and editing users.
The service could then be used in a `UserController` to create, delete, or edit users.

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

## Example

An example of a service method could look like this:

```PHP
  /**
   * Create a new book order.
   *
   * @param BookOrder $bookOrder The book order object to persist
   * @return BookOrder The persisted book order object
   * @throws Exception If an error occurs during transaction
   */
  public function createBookOrder(BookOrder $bookOrder): BookOrder
  {
    $this->entityManager->persist($bookOrder);
    $this->entityManager->flush();
    return $bookOrder;
  }
```

::: tip
When creating methods in a service, it is important to remember that the service should only contain business logic.
Prefixing the method name with the action it performs is a good practice.
:::

## Using a Service in a Controller

A service can be used in a controller as follows:

```PHP{1,8,12}
use App\Service\BookOrderService;
// ...

#[Route("api/v1/bookOrders")]
class BookOrderController extends AbstractController
{
  #[Route(path: "/", methods: ["GET"])]
  public function getBooks(BookOrderService $bookOrderService): Response
  {
    // ...
    try {
      $bookOrders = $bookOrderService->getBookOrders();
      // ...
    } catch (Exception $e) {
      // ...
    }
  }
```

::: warning
The Service **must** be the first argument in the controller method.
:::
