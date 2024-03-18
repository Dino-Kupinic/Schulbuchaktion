# Extending

Schulbuchaktion is designed to be modular and easily extendible. Not only that, we also have a standardised way of
working (Git-Flow, GitHub Projects, Issues, Pull Requests, ...).

It is **strongly** recommended to follow these guidelines.

## Learning

Before working on Schulbuchaktion, you should have a solid grasp of following things:

::: info
While you should know the basics, you don't need to know everything by heart.
Very important topics are marked in bold.
:::

#### Languages

- TypeScript (**JavaScript**)
- **PHP**


#### Frameworks & Libraries

- **Vue 3**
- Nuxt 3
- Pinia
- Vue Router
- Vitest (Jest)
- Playwright
- Symfony

#### Tools

- Docker
- Vite
- Composer
- **Git**

Extending the Documentation requires only markdown knowledge.

## Architecture

Schulbuchaktion makes use of the monolithic architecture. The repository contains following main
directories, `/frontend`, `/backend` and `/docs`. As you can see, we also have a monorepo instead of splitting the
services into seperate git repositories, e.g. `Schulbuchkation-client`, `Schulbuchkation-backend`, ... .

### REST-API

In this project, Symfony only acts as a REST-API without serving any twig templates.

### Nuxt

Nuxt is a **Full-stack** framework, which means it can be used for both frontend and backend. We ignore the `/server`
directory and only use Nuxt's frontend features.

## Containerization

The whole project is setup inside a single `docker-compose.yml`. The MySQL database has a volume (`mysql_data`) that is
mounted in `/backend`.

## Recommended IDE and Tools

Schulbuchaktion was made in **PHPStorm**, it is advised to use it aswell, since it provides everything out of the box.
If you want to use VSCode, you will need to provide your own `.vscode` config.
<br>
NeoVim and Vim users should know how to configure their enviroment themselves.

For manual API Testing we use **Postman**.

## Dependabot

We use GitHub's **Dependabot** to keep our dependencies up to date. It is configured to check weekly.

## CommitCheck

We use the **CommitCheck** Bot to check for correct commit messages. It is configured to
follow [Conventional Commits](https://www.conventionalcommits.org/en/v1.0.0/).

RegEx Filter: `^(feat|fix|chore|docs|style|refactor|perf|test|build|ci|revert)(\([^\)]+\))?(\!)?\: .+`

## Designs

UI/UX Designs are done in **Figma**. If you want to take a look, here is
the [link](https://www.figma.com/file/tq8UhxGHnaj2MaDZE0KuRQ/Schulbuchaktion?type=design&node-id=0%3A1&mode=design&t=RsFq3WRm9AgRYYKV-1).
We use **NuxtUI** as a base for the components.

## Conventions

Head to the [Conventions](./code-style) Section to learn more.