# Nur-Du — Vision Alignment Tool

A lightweight Laravel tool that keeps your company's long-term vision alive by integrating it into everyday decisions, quarterly priorities, and monthly reflections.

**Bilingual:** Full English & German support with language switcher.

## Core Features

### Vision Statement Module
- One clear vision statement (max 2 lines)
- 3–5 guiding principles that explain how you achieve the vision

### Quarterly Focus
- Define 1–3 strategic priorities per quarter
- Assign an owner and measurable KPI to each priority
- Track status: On Track / At Risk / Off Track

### Decision Alignment Check
- Traffic light system for every major decision:
  - **Green** — Strengthens the vision
  - **Yellow** — Neutral
  - **Red** — Weakens the vision (must be actively justified)
- Visual alignment bar showing overall decision health

### Monthly Vision Check
- 3 fixed reflection questions:
  1. Does what we are doing now clearly pay into our vision?
  2. What decision or activity is currently most moving us away from the vision?
  3. What is the one thing we need to change in the next period to get closer to the vision?
- Notes and action items with completion tracking

### Dashboard
- Vision statement with guiding principles at a glance
- Current quarter priorities with status
- Decision alignment statistics with visual bar
- Recent decisions and latest vision check summary

### Language Support (i18n)
- Full English and German translations (150+ strings)
- Language switcher (EN | DE) on all pages
- Session-based locale persistence

## Tech Stack

- **Backend:** PHP 8.3, Laravel 11
- **Frontend:** Blade, Tailwind CSS, Alpine.js
- **Auth:** Laravel Breeze
- **Database:** SQLite (default), MySQL/PostgreSQL supported
- **Build:** Vite

## Requirements

- PHP >= 8.2
- Composer
- Node.js >= 18 (for building assets, optional on shared hosting if using pre-built assets)

## Installation

### Local Development

```bash
# Clone
git clone https://github.com/mrshahbazdev/Nur-Du.git
cd Nur-Du

# Install dependencies
composer install
npm install

# Environment
cp .env.example .env
php artisan key:generate

# Database
touch database/database.sqlite
php artisan migrate

# Build assets
npm run build

# Serve
php artisan serve
```

### Shared Hosting Deployment

1. Upload the entire project to your hosting (e.g. via FTP/File Manager)
2. Set the **document root** (public directory) to the `public/` folder
3. Copy `.env.example` to `.env` and configure:
   ```
   APP_ENV=production
   APP_DEBUG=false
   APP_URL=https://yourdomain.com

   DB_CONNECTION=mysql
   DB_HOST=127.0.0.1
   DB_PORT=3306
   DB_DATABASE=your_database_name
   DB_USERNAME=your_database_user
   DB_PASSWORD=your_database_password
   ```
4. Generate app key:
   ```bash
   php artisan key:generate
   ```
5. Run migrations:
   ```bash
   php artisan migrate --force
   ```
6. The `public/build/` folder already contains pre-built CSS/JS assets — no need to run `npm` on the server.

**Note:** The `.htaccess` file in `public/` handles URL rewriting for Apache. If your hosting uses Nginx, configure the equivalent rewrite rules.

## Development

```bash
npm run dev          # Vite dev server with HMR
php artisan serve    # Laravel dev server
php artisan test     # Run test suite (25 tests)
```

## Project Structure

```
app/
├── Http/Controllers/     # Vision, Quarterly, Decision, Check, Language controllers
├── Http/Middleware/       # SetLocale middleware for i18n
├── Models/               # Vision, GuidingPrinciple, QuarterlyFocus, Decision, etc.
lang/
├── en.json               # English translations
├── de.json               # German translations
├── en/ & de/             # System message translations
resources/views/
├── auth/                 # Login, register, password reset pages
├── checks/               # Vision check pages
├── components/           # Language switcher, UI components
├── decisions/            # Decision alignment pages
├── layouts/              # App and guest layouts
├── quarterly/            # Quarterly focus pages
├── vision/               # Vision statement pages
├── dashboard.blade.php   # Main dashboard
├── welcome.blade.php     # Landing page
```

## Philosophy

> Make vision visible → check regularly → translate into decisions

Regularity beats perfection. This tool is deliberately minimal — no OKR circus, no complex frameworks. Just a clear vision, lightweight priorities, and a simple decision filter that creates long-term orientation automatically.

## License

Open source.
