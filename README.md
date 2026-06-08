# CuraLab

[![MIT License](https://img.shields.io/badge/License-MIT-green.svg)](https://choosealicense.com/licenses/mit/)

Applicazione web di un **poliambulatorio** (progetto Engim 2026): i pazienti possono
scoprire medici, servizi e sedi, registrarsi, accedere e **prenotare visite** dalla
propria area personale.

🎨 [Design su Canva](https://www.canva.com/design/DAHHeDhaGNE/w3SU2pnLftNqB4rD_uCyVw/edit?ui=e30)

L'intera interfaccia e tutti i messaggi (compresi gli errori) sono in **italiano**.

---

## Caratteristiche

- **Catalogo pubblico**: medici (con specializzazione e biografia), servizi e sedi.
- **Ricerca** in homepage per tipo di medico e sede.
- **Autenticazione pazienti** tramite token (registrazione, login, logout).
- **Prenotazione appuntamenti** con scelta di medico, servizio, sede e data/ora.
- **Area personale**: elenco appuntamenti e cancellazione (regola delle 24 ore).
- **Form contatti** (disponibile anche agli utenti non registrati).
- UI **responsive**, **accessibile** (WCAG, navigazione da tastiera) e con **animazioni** (GSAP).

---

## Stack tecnologico (e come viene usato)

### Front-end (`frontend/`)

| Tecnologia | Come viene usata |
|------------|------------------|
| **Next.js 16** (App Router) | Routing, rendering. Le pagine pubbliche sono **statiche/ISR** (`revalidate`), i dati vengono letti lato server e inseriti nell'HTML. |
| **React 19** | Libreria UI a componenti. |
| **React Compiler** | Memoizzazione automatica dei componenti (`reactCompiler: true`). |
| **TypeScript** | Tipizzazione di tutto il codice e dei payload dell'API (`lib/types.ts`). |
| **React Query** (TanStack) | Fetching/caching lato client per le aree dinamiche e autenticate (prenotazione, area personale). |
| **Tailwind CSS v4** | Stile utility-first, con i token del brand definiti in `app/globals.css` (`@theme`). |
| **GSAP** (`@gsap/react`) | Animazioni d'ingresso (componente `Reveal`), nel rispetto di `prefers-reduced-motion`. |
| **Cypress** | Test end-to-end (`frontend/cypress/`). |
| **Turbopack** | Bundler di sviluppo e build di Next. |

### Back-end (`backend/`)

| Tecnologia | Come viene usata |
|------------|------------------|
| **Laravel 12** | API REST in JSON (nessuna vista server-side per la SPA). |
| **PHP 8.2+** | Linguaggio del back-end. |
| **MySQL 8** | Database relazionale (schema in `database/migrations/`, dati in `database/seeders/`). |
| **Laravel Sanctum** | Autenticazione tramite **token Bearer** (`Authorization: Bearer <token>`). |

### DevOps

| Tecnologia | Come viene usata |
|------------|------------------|
| **GitHub Actions** | CI in `.github/workflows/ci.yml`: lint + type-check + build del frontend, e migrate + seed + test del backend. |
| **Docker / Dev Container** | Ambiente di sviluppo riproducibile in `.devcontainer/` (PHP + MySQL, porte 8000 e 3306). |
| **pnpm workspaces** | Monorepo con i pacchetti `frontend` e `backend`. |

---

## Struttura del progetto

```
Progetto-CuraLab/
├── frontend/            App Next.js (App Router, TypeScript)
│   ├── app/             Route e componenti
│   │   ├── (con-header)/  Pagine con header/footer (home, medici, servizi, …)
│   │   └── _components/   Componenti privati (header, carosello, ui, …)
│   └── lib/             api.ts, server-api.ts, types.ts, auth.tsx
├── backend/             API Laravel
│   ├── app/             Models e Controllers (Api/…)
│   ├── routes/api.php   Endpoint dell'API
│   ├── database/        Migrations + seeders
│   └── lang/it/         Messaggi di validazione in italiano
├── docs/                Documentazione API e schema del database
├── scripts/dev-db.sh    Avvia un'istanza MySQL locale dedicata
├── .github/workflows/   CI (GitHub Actions)
└── .devcontainer/       Configurazione Codespaces / Dev Container
```

---

## Prerequisiti

- **Node.js 20+** e **pnpm 10+**
- **PHP 8.2+** e **Composer**
- **MySQL 8**

> In **GitHub Codespaces** è tutto già configurato dal Dev Container: PHP, MySQL, il
> database `curalab` e il file `.env` vengono creati automaticamente.

---

## Avvio del progetto (in locale)

### 1. Clona il repository e installa le dipendenze del frontend

```bash
git clone <url-del-repo>
cd Progetto-CuraLab
pnpm install
```

### 2. Database MySQL

Serve un database `curalab` con un utente `curalab`. Due possibilità:

**A) MySQL di sistema** — crea database e utente:

```sql
CREATE DATABASE curalab CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
CREATE USER 'curalab'@'127.0.0.1' IDENTIFIED BY 'curalab';
GRANT ALL PRIVILEGES ON curalab.* TO 'curalab'@'127.0.0.1';
FLUSH PRIVILEGES;
```

**B) Istanza MySQL dedicata (senza permessi di amministratore)** — usa lo script
incluso, che avvia un'istanza MySQL personale e persistente sulla porta **3308**:

```bash
./scripts/dev-db.sh
```

> Lo script inizializza i dati in `~/.local/share/curalab-mysql/data` e può essere
> reso automatico all'avvio del sistema con un servizio `systemctl --user`.

### 3. Configura e prepara il back-end

```bash
cd backend
composer install
cp .env.example .env   # oppure crea il .env manualmente
php artisan key:generate
```

Imposta nel `backend/.env` i parametri del database (la porta deve corrispondere a
quella scelta sopra: `3306` per il MySQL di sistema, `3308` per lo script):

```env
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3308
DB_DATABASE=curalab
DB_USERNAME=curalab
DB_PASSWORD=curalab
APP_LOCALE=it
```

Crea le tabelle e carica i dati di esempio:

```bash
php artisan migrate --seed
```

### 4. Configura il front-end

Crea `frontend/.env.local` con l'indirizzo dell'API:

```env
NEXT_PUBLIC_API_BASE_URL=http://localhost:8000/api
```

### 5. Avvia tutto insieme

Dalla cartella principale:

```bash
pnpm dev
```

- Front-end → http://localhost:3000
- API back-end → http://localhost:8000

---

## Script disponibili

Dalla **root** del progetto:

| Comando | Descrizione |
|---------|-------------|
| `pnpm dev` | Avvia front-end **e** back-end insieme |
| `pnpm dev:web` | Solo front-end (Next.js) |
| `pnpm dev:api` | Solo back-end (`php artisan serve`) |
| `pnpm --filter frontend <script>` | Esegue uno script del frontend (`dev`, `build`, `lint`, `test`) |
| `./scripts/dev-db.sh` | Avvia/ inizializza il database MySQL locale dedicato |

Nel **frontend**: `pnpm --filter frontend build`, `... lint`, `... test` (Cypress).

---

## Dati di test

Dopo `php artisan migrate --seed` il database contiene:
**7 specializzazioni · 7 servizi · 5 sedi · 7 medici · 18 disponibilità · 3 pazienti · 4 appuntamenti**.

Account paziente di prova (password: `password`):

| Email | Password |
|-------|----------|
| luca.bianchi@email.it | password |
| sofia.greco@email.it | password |
| marco.ferrari@email.it | password |

---

## API

Base URL: `http://localhost:8000/api`. Header obbligatori:
`Content-Type: application/json` e `Accept: application/json`.
Le route protette richiedono `Authorization: Bearer <token>`.

| Metodo | Endpoint | Auth | Descrizione |
|--------|----------|:----:|-------------|
| POST | `/register` | – | Registrazione paziente |
| POST | `/login` | – | Login (restituisce un token) |
| POST | `/logout` | 🔒 | Logout |
| GET | `/user` | 🔒 | Dati del paziente autenticato |
| GET | `/medici` | – | Elenco medici |
| GET | `/servizi` | – | Elenco servizi |
| GET | `/sedi` | – | Elenco sedi |
| POST | `/contatti` | – | Invio messaggio dal form contatti |
| GET | `/appuntamenti` | 🔒 | Appuntamenti del paziente |
| POST | `/appuntamenti` | 🔒 | Prenotazione |
| DELETE | `/appuntamenti/{id}` | 🔒 | Cancellazione (regola 24h) |

Documentazione completa: [`docs/CuraLab_API_Documentazione.md`](docs/CuraLab_API_Documentazione.md).

---

## Integrazione continua (CI)

Ad ogni `push` o `pull request` verso `main`, GitHub Actions
([`.github/workflows/ci.yml`](.github/workflows/ci.yml)) esegue:

- **Frontend**: installazione dipendenze → `lint` → `tsc --noEmit` → `build`.
- **Backend**: avvio di un servizio MySQL → `composer install` → `migrate --seed` → `php artisan test`.

---

## Autori

- [@ouisalelhayyani110-collab](https://www.github.com/ouisalelhayyani110-collab) — Project manager
- [@puria-79](https://www.github.com/puria-79) — Front-end
- [@mariaruffo](https://github.com/mariaruffo) — Back-end
