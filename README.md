# Schulbuchaktion

Application for teachers to easily manage the upcoming books for each classroom at the HTL Steyr.

> [!CAUTION]
> Schulbuchaktion is still in Development. You will find bugs and broken/unfinished features.

## ✨ Installation and Configuration

### Installation for Development

1. clone the repository:

```bash
git clone https://github.com/Dino-Kupinic/Schulbuchaktion.git
```

### Frontend

1. go into the frontend directory

```bash
cd frontend
```

2. install packages

```bash
pnpm i 
```

> [!TIP]  
> If you don't have pnpm installed, checkout https://pnpm.io/installation to install for your operating system.

3. run dev server

```bash
pnpm run dev
```

4. Head to http://localhost:3000/

If it works, great!

> [!IMPORTANT]
> Following instruction is optional and may be skipped. If you have slow internet, it may take a while to 
> install Chrome, Safari and Firefox (~150 MB)

5. Install playwright browsers
```
npx playwright install     
```

### Backend

1. go into the backend directory

```bash
cd ../backend
```

2. define enviroment variables

Create a `.env` file and checkout the `.env.example`. Copy the content into your `.env` and replace
the `SECRET_PASSWORD`, `USERNAME`, `BIND_PORT`, `APP_SECRET`  fields with your own.

> [!IMPORTANT]  
> For the `APP_SECRET` checkout https://symfony.com/doc/current/reference/configuration/framework.html#secret to see the
> latest requirements.

3. start docker

```bash
docker compose up -d
```

> [!TIP]  
> If you don't have docker installed, checkout https://www.docker.com/products/docker-desktop/ to install for your
> operating system.

4. install dependencies

```bash
composer install
```

5. start the dev server

```bash
symfony server:start
```

> [!IMPORTANT]  
> If you don't have symfony cli installed, checkout https://symfony.com/download#step-1-install-symfony-cli to install
> for your operating system.

6. head to http://127.0.0.1:8000

### Docs

1. go into the docs directory

```bash
cd ../docs
```

2. install packages

```bash
pnpm i 
```

> [!TIP]  
> If you don't have pnpm installed, checkout https://pnpm.io/installation to install for your operating system.

3. run dev server

```bash
pnpm run docs:dev
```

4. Head to http://localhost:5173/

## 🚀 Deployment

> [!NOTE]  
> The frontend operates as a "Single Page
> Application" [SPA](https://nuxt.com/docs/guide/concepts/rendering#client-side-rendering), requiring the client to
> handle all rendering tasks. It's essential to acknowledge that due to this architecture, there may be limitations in
> terms of SEO optimization. However, it's worth noting that the application's primary use case doesn't heavily rely on
> search engine visibility, since it is meant to be used as an internal tool.

### Frontend

1. run build

```bash
pnpm run build
```

2. check if everything works as it should

```bash
pnpm run preview
```

3. Head to http://localhost:3000/
4. All generated assets can be found in `./output`

> [!TIP]
> Further information regarding deployment can be found on https://nuxt.com/deploy

### Backend

The latest information regarding deploying symfony can be found
here: https://symfony.com/doc/current/deployment.html#symfony-deployment-basics

### Docs

> [!NOTE]  
> The documentation uses the same principle as the frontend. More
> infos: https://vitepress.dev/guide/what-is-vitepress#performance

1. run build

```bash
pnpm run docs:build
```

2. check if everything works as it should

```bash
pnpm run docs:preview
```

3. Head to http://localhost:4173/
4. All generated assets can be found in `./vitepress/dist`

> [!TIP]
> Further information regarding deployment can be found on https://vitepress.dev/guide/deploy

## 😄 Authors

- [@Dino Kupinic](https://www.github.com/Dino-Kupinic)
- [@Michael Ploier](https://www.github.com/MPloier)
- [@Jannick Angerer](https://www.github.com/Neuery17Alt)
- [@Daniel Samhaber](https://www.github.com/dsamhabe)
- [@Lukas Bauer](https://www.github.com/dsamhabe)

## 🐥 Team Organization:

### Scrum Master + Full Stack:

- Dino Kupinic

### Frontend

- Daniel Samhaber
- Jannick Angerer

### Backend

- Michael Ploier
- Lukas Bauer

## 🛠️ Tech Stack

- Symfony
- Nuxt 3
- MySQL
- Docker

#### Frontend

You can find all dependencies in the `package.json` and for the `nuxt.config.ts` in the `modules` section.

#### Backend

You can find all dependencies in the `composer.json`.

## 😊 License

[MIT](https://choosealicense.com/licenses/mit/)
