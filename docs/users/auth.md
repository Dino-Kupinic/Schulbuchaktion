# Authentication

Schulbuchaktion has first-class integration with LDAP, which means you can use the same username and password you use
for logging into your school account.

## Login Page

Here you are prompted for your username and password.

![Login-Light.png](/login-light.png)

Clicking on the login button will authenticate you and redirect you to the dashboard.
You can now order books, view your orders, and manage the budget (if you have permissions). :tada:

::: info
Your credentials are not stored in the database, but are used to authenticate you against the LDAP server.
The data is transmitted securely using [HTTPS](https://en.wikipedia.org/wiki/HTTPS).
:::

## Logout

You can logout by clicking on the logout inside your profile dropdown menu.
This will redirect you to the login page.
