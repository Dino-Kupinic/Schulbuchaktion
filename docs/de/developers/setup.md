# Einrichten

## Installation für die Entwicklung

1. Klonen Sie das Repository:

```bash
git clone https://github.com/Dino-Kupinic/Schulbuchaktion.git
```

## Frontend

1. Wechseln Sie in das Frontend-Verzeichnis

```bash
cd frontend
```

2. Pakete installieren

```bash
pnpm i
```

::: tip TIPP
Wenn Sie pnpm nicht installiert haben, schauen Sie unter https://pnpm.io/installation nach, um es für Ihr Betriebssystem zu installieren.
:::

3. Starten Sie den Entwicklungs-Server

```bash
pnpm run dev
```

4. Gehe zu http://localhost:3000/

## Backend

1. Wechseln Sie in das Backend-Verzeichnis

```bash
cd ../backend
```

2. Umgebungsvariablen definieren

Erstelle eine `.env` Datei und schauen Sie sich die `.env.example` an. Kopieren Sie den Inhalt in Ihre `.env` und ersetzen 
Sie die Felder `SECRET_PASSWORD`, `USERNAME`, `BIND_PORT`, `APP_SECRET` mit Ihren eigenen.

::: danger GEFAHR
Für das `APP_SECRET` schauen Sie bitte unter https://symfony.com/doc/current/reference/configuration/framework.html#secret für die
neuesten Anforderungen.
:::

3. Starten Sie Docker

```bash
docker compose up -d
```

::: tip TIPP
Wenn Sie Docker nicht installiert haben, schauen Sie unter https://www.docker.com/products/docker-desktop/, um es für Ihr
Betriebssystem zu installieren.
:::

4. Installieren Sie die Abhängigkeiten

```bash
composer install
```

5. Starten Sie den Entwicklungs-Server

```bash
symfony server:start
```

::: warning WARNUNG
Wenn Sie symfony cli nicht installiert haben, schauen Sie unter https://symfony.com/download#step-1-install-symfony-cli nach, um es
für Ihr Betriebssystem zu installieren.
:::

6. Rufen Sie http://127.0.0.1:8000 auf.

## Docs

1. Wechseln Sie in das Verzeichnis docs

```bash
cd ../docs
```

2. Pakete installieren

```bash
pnpm i
```

::: tip TIPP
Wenn Sie pnpm nicht installiert haben, schauen Sie unter https://pnpm.io/installation nach, um es für Ihr Betriebssystem zu installieren.
:::

3. Starten Sie den Entwicklungs-Server

```bash
pnpm run docs:dev
```

4. Gehen Sie zu http://localhost:5173/

