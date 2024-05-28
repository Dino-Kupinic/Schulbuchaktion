# Security
Following content describes, how the middleware and user-permission works.

## Permission
For checking permission the file `security.xml` is used. In this XML you find the permission
for each group which are defined in `.env`. You can find the XML in `/config/security/security.xml`
based on your project root.

### Form
The tags for the route permission is split in two part. The first part is the name of the controller
which is defined in the controller's `#[Route ...]` tag. The second part is the name of the functions
of the controller which is also defined in the function's `#[Route ...]` tag.
The XML file contains following tags:
  + groups --> root-tag
  + role --> name of specific role (e.g. `<ADMIN_ROLE>`)
  + routes --> fixed tag which contains all routes (combination controller/function)
  + controller --> name of controller (e.g. YearController is `<year>`)
  + function --> value of this tag contains the function name (e.g. getYear is `<function>get</function>`)

### Generation
You can genrate the XML file with the command `php bin/console security:create-security-xml`. This command
generates the file `security.generated.xml` in the security-config-path.
You have to rename or copy the file in `security.xml`.

:::danger
This command generates a XML file with all permission for each role. You have to delete manually controller or function tags
to deny access for a specific role.
:::


### Example
Following XML files represents the permission for the roles `ADMIN` and `USER`.
`ADMIN` is permitted for the functions `get`, `update` and `delete` of the controller `user`.
`USER` is only permitted for the function `info`.
```XML
<?xml version="1.0" encoding="UTF-8" ?>
<groups>
  <ADMIN>
    <routes>
      <user>
        <function>get</function>
        <function>update</function>
        <function>delete</function>
      </user>
    </routes>
  </ADMIN>
  <USER>
    <routes>
      <user>
        <function>info</function>
      </user>
    </routes>
  </USER>
</groups>
```

