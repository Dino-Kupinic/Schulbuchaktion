# Code Style

## Eslint & Prettier

Eslint and Prettier is configured in the `/frontend` directory.
In PHPStorm, Prettier can be configured to format on save.

Prettier for PHP is currently not fully functional, so it is recommended to follow the legacy guidelines.
Since the `/docs` directory is mostly markdown we don't really need Prettier.

## Legacy

Following section applies to before our switch to ESLint/Prettier.

Code committed to Schulbuchaktion should follow these guidelines:

- empty line should be EOF
- spaces instead of tabs
- camelCase

::: tip
You can press CTRL + SHIFT + L in **PHPStorm** to apply your formatting options.
You should configure these in your settings.
:::

You should also configure these settings:

| Setting        | Value                 |
|----------------|-----------------------|
| Indentation    | 2                     |
| Double Quotes  | Always                |
| Trailing Comma | Always when multiline |
| Semicolon      | Never (TypeScript)    |

In TypeScript, prefer arrow functions and `async/await` syntax.
