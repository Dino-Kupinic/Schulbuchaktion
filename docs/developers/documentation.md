# Documentation

Below you can find an easy guide to extend the documentation.

## Adding a group to the sidebar

Adding a sidebar is done in the `sidebarUsers()` or `sidebarDevelopers()` function in `docs/.vitepress/en.ts` (English)
and `docs/.vitepress/de.ts` (German) respectively.

To add a new group, you need to add a new object to the array:

```ts
function sidebarUsers(): DefaultTheme.SidebarItem[] {
  return [
    {
      text: "Introduction",
      collapsed: false,
      items: [
        {
          // ...
        },
      ],
    },
    { // [!code ++]
      text: "Donations", // [!code ++] // group title
      collapsed: false, // [!code ++]  // set to true for the user to open it
      items: [ // [!code ++]
        { // [!code ++]
          text: "Getting Started", // [!code ++] // title 
          link: "getting-started", // [!code ++] // corresponding .md (markdown file), don't add a file extension or path!
        }, // [!code ++]
      ], // [!code ++]
    }, // [!code ++]
  ]
}
```

Do the same in `de.ts` and **only** translate the `text`, don't change the `link`.

## Adding a markdown file

After you create the sidebar links, you now need to create the markdown files. The english versions are added in the
root directory under `/users` and `/developers` and german versions are added under `/de`.

::: danger
Having dead links (missing markdown files) will result in a build error!
:::