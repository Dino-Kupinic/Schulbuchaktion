# Database

## ER-Diagram
The ER diagram was created with the web tool GenMyModel.

![er-diagram.png](/er-diagram.png)


## Implementation in Symfony
The database was implemented with Doctrine ORM in Symfony. The entities were created with the command `php bin/console make:entity`. The entities were then converted into a migration using the command `php bin/console make:migration`. The migration was then transferred to the database using the command `php bin/console doctrine:migrations:migrate`.

