# Navbar User

The `NavUser` is accessable in the top left corner
of the Navbar.

It contains four Buttons. A button to access all the teachers
`All teachers`, one to access the books a user lent `My Books`.

Besides a Button to get to your profile, there is also a Button to
`Logout` of your account.

The Dropdown list `<NavUserDropdown />`, which shows when clicking on the `<NavUserAvatar />`
is implemented like this:

 - Items of Dropdown

```js
const items = [
  [
    {
      label: "Dino Kupinic",
      link: "#",
      slot: "account",
    },
  ],
]
```

 - The List itself

For the Dropdown the Nuxt component `<UDropdown />` is used.

