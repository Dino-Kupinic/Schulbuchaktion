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
> [!IMPORTANT]  
> If you don't have pnpm installed, checkout https://pnpm.io/installation to install for your operating system.

3. run dev server
```bash
pnpm run dev
```
5. Head to http://localhost:3000/

### Backend
1. go into the backend directory
```bash
cd backend
```
2. install dependencies
```bash
composer install
```
3. define enviroment variables

Create a `.env` file and checkout the `.env.example`. You can copy the content and replace the `SECRET_PASSWORD` field with a password of your choosing.

4. start the dev server
```
symfony server:start
```
> [!IMPORTANT]  
> If you don't have symfony cli installed, checkout https://symfony.com/download#step-1-install-symfony-cli to install for your operating system.

5. head to http://127.0.0.1:8000

## 🚀 Deployment
### Frontend
1. run build
```bash
npm run build
```
2. check if everything works as it should
```bash
npm run preview
```
3. Head to http://localhost:3000/
4. All generated assets can be found in `./output`

> [!TIP]
> Further information regarding deployment can be found on https://nuxt.com/deploy

### Backend
// TODO: Add Backend deploy steps

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
