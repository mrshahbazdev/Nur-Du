# North-Star — Vision Alignment Tool

A lightweight Laravel tool that keeps your company's long-term vision alive by integrating it into everyday decisions, quarterly priorities, and monthly reflections.

**Bilingual:** Full English & German support with language switcher.
**Team Collaboration:** Invite members, assign roles, share data within teams.

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

### Team Collaboration
- **Create & manage teams** — Multiple teams per user
- **Invite members** — Email-based invitations with shareable token links
- **Roles** — Admin, Manager, Member with different permission levels:
  - **Admin** — Full access: manage team settings, invite/remove members, change roles
  - **Manager** — Can create/edit all data within the team
  - **Member** — Can view and contribute data
- **Team switcher** — Quick dropdown in navbar to switch between teams
- **Scoped data** — All vision, decisions, quarterly focus, and checks are isolated per team
- **Auto personal team** — Every new user gets a personal team automatically

### Dashboard
- Vision statement with guiding principles at a glance
- Current quarter priorities with status
- Decision alignment statistics with visual bar
- Recent decisions and latest vision check summary

### Language Support (i18n)
- Full English and German translations (180+ strings)
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
   - If your hosting doesn't allow changing document root, the root `.htaccess` handles it automatically
3. Copy `.env.example` to `.env` and configure:
   ```
   APP_NAME=North-Star
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
6. The `public/build/` folder already contains pre-built CSS/JS assets — **no need to run `npm` on the server**.

**Note:** Two `.htaccess` files are included:
- **Root `.htaccess`** — Redirects all requests to the `public/` folder (for shared hosting where you can't change document root)
- **`public/.htaccess`** — Laravel's standard URL rewriting to `index.php`

### Updating on Shared Hosting

When pulling updates:
```bash
git pull origin devin/1777303406-vision-alignment-tool
php artisan migrate --force
```
No need to rebuild assets — they are committed to `public/build/`.

## Development

```bash
npm run dev          # Vite dev server with HMR
php artisan serve    # Laravel dev server
php artisan test     # Run test suite (25 tests)
```

## Project Structure

```
app/
├── Http/Controllers/     # Vision, Quarterly, Decision, Check, Team, Language controllers
├── Http/Middleware/       # SetLocale (i18n), EnsureTeam (team context)
├── Models/               # Vision, Decision, QuarterlyFocus, Team, TeamMember, User, etc.
database/migrations/      # All database schema definitions
lang/
├── en.json               # English translations (180+ strings)
├── de.json               # German translations (180+ strings)
├── en/ & de/             # System message translations
resources/views/
├── auth/                 # Login, register, password reset pages
├── checks/               # Vision check pages
├── components/           # Language switcher, UI components
├── decisions/            # Decision alignment pages
├── layouts/              # App and guest layouts with team switcher
├── quarterly/            # Quarterly focus pages
├── teams/                # Team management: index, create, settings
├── vision/               # Vision statement pages
├── dashboard.blade.php   # Main dashboard
├── welcome.blade.php     # Landing page
```

## Team Workflow

1. **Register** → A personal team is auto-created for you
2. **Create a team** → Go to Teams → Create Team
3. **Invite members** → Team Settings → Enter email + select role → Send Invitation
4. **Share invite link** → Members can accept via link (existing or new users)
5. **Switch teams** → Use the team switcher dropdown in the navbar
6. **All data is per-team** — Vision, decisions, quarterly focus, and checks belong to the active team

## Philosophy

> Make vision visible → check regularly → translate into decisions

Regularity beats perfection. This tool is deliberately minimal — no OKR circus, no complex frameworks. Just a clear vision, lightweight priorities, and a simple decision filter that creates long-term orientation automatically.

## License

Open source.
