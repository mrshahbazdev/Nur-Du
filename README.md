# Nur-Du — Vision Alignment Tool

A lightweight Laravel tool that keeps your company's long-term vision alive by integrating it into everyday decisions, quarterly priorities, and monthly reflections.

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

## Tech Stack

- **Backend:** PHP 8.3, Laravel 11
- **Frontend:** Blade, Tailwind CSS, Alpine.js
- **Auth:** Laravel Breeze
- **Database:** SQLite (default), MySQL/PostgreSQL supported

## Setup

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

## Development

```bash
npm run dev          # Vite dev server with HMR
php artisan serve    # Laravel dev server
```

## Philosophy

> Make vision visible → check regularly → translate into decisions

Regularity beats perfection. This tool is deliberately minimal — no OKR circus, no complex frameworks. Just a clear vision, lightweight priorities, and a simple decision filter that creates long-term orientation automatically.
