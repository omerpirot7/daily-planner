# 🌿 Daily Planner

A beautiful, minimal, and fast daily planner built with **Laravel**, **Livewire**, and **Tailwind CSS**. Plan your day, track your tasks, and see your productivity at a glance.

This app is designed to feel calm, modern, and delightful to use — from the glassmorphism auth pages to the clean dashboard and planner view.

---

## ✨ Features

- **Secure authentication**
  - Email/Password login & registration
  - Email verification and password reset
  - Optional Google login with Socialite
- **Beautiful onboarding experience**
  - Custom auth card with glassmorphism design
  - Clear, friendly copy and validation messages
- **Modern dashboard**
  - Welcome header with your name and avatar
  - Quick stats: total tasks, completed tasks, productivity percentage
  - One-click navigation to your Daily Planner
- **Daily planner view**
  - Create, edit, and complete tasks
  - Tasks grouped by day: **Today**, **Yesterday**, and previous dates
  - Priority-based styling for important tasks
  - Clean, distraction-free layout
- **Fast interactions**
  - Livewire-powered updates with no full page reloads
  - Optimistic UI checkboxes: tasks feel instant when you toggle them
- **Responsive & accessible**
  - Works on desktop, tablet, and mobile
  - Accessible colors, focus states, and keyboard-friendly

---

## 🧠 Tech Stack

- **Backend:** Laravel
- **Frontend:** Blade, Tailwind CSS, Alpine.js, Livewire
- **Database:** PostgreSQL (configured via `.env`)
- **Auth:** Laravel Breeze-style flow with email verification + Socialite (Google)

For a deeper technical breakdown of the authentication system, see:
- `AUTH_SETUP_GUIDE.md`
- `IMPLEMENTATION_SUMMARY.md`
- `QUICK_START.md`

---

## 🚀 Getting Started

### Prerequisites

- PHP 8.1+ (or Laravel Herd on macOS/Windows)
- Composer
- Node.js & npm
- PostgreSQL database

### 1. Clone the repository

```bash
git clone https://github.com/your-username/daily-planner.git
cd daily-planner
```

### 2. Install PHP dependencies

```bash
composer install
```

### 3. Install JavaScript dependencies

```bash
npm install
```

### 4. Environment configuration

Copy `.env.example` to `.env` and update the values:

```bash
cp .env.example .env
php artisan key:generate
```

Set your database and (optionally) Google OAuth + mail settings:

```env
DB_CONNECTION=pgsql
DB_HOST=your_host
DB_PORT=5432
DB_DATABASE=your_database
DB_USERNAME=your_username
DB_PASSWORD=your_password

# Google OAuth (optional)
GOOGLE_CLIENT_ID=your_client_id_here
GOOGLE_CLIENT_SECRET=your_client_secret_here
GOOGLE_REDIRECT_URI=http://localhost:8000/auth/google/callback

# Mail (for verification & password reset)
MAIL_MAILER=smtp
MAIL_HOST=smtp.mailtrap.io
MAIL_PORT=2525
MAIL_USERNAME=your_mailtrap_username
MAIL_PASSWORD=your_mailtrap_password
MAIL_ENCRYPTION=tls
MAIL_FROM_ADDRESS="hello@example.com"
MAIL_FROM_NAME="Daily Planner"
```

### 5. Run migrations

```bash
php artisan migrate
```

### 6. Build assets

For local development:

```bash
npm run dev
```

For production build:

```bash
npm run build
```

### 7. Start the development server

```bash
php artisan serve
```

Visit: http://localhost:8000

---

## 🧭 Main Screens

- `/register` – Create a new account
- `/login` – Log in to your account
- `/dashboard` – Overview with stats and quick actions
- `/planner` – Your daily planner with tasks grouped by date

---

## 📝 Project Goals

This project was created to be:

- **Simple** – Easy to set up and easy to use
- **Beautiful** – Calming colors, soft shadows, and clear typography
- **Helpful** – Encourages you to plan your day and actually finish your tasks
- **Realistic** – Uses production-ready patterns for authentication and state management

If you're exploring the code, good starting points are:

- Livewire components: `app/Livewire/Dashboard.php`, `app/Livewire/DailyPlanner.php`
- Planner UI: `resources/views/livewire/daily-planner.blade.php`
- Dashboard UI: `resources/views/livewire/dashboard.blade.php`
- Auth layout: `resources/views/components/auth/auth-card.blade.php`

---

## 🤝 Contributing

Suggestions, ideas, or improvements are always welcome.

You can:
- Open an issue with your idea
- Fork the repo and submit a pull request

---

## ❤️ A Note from the Creator

This Daily Planner was built with care to make everyday planning feel a little more peaceful and a lot more productive. If it helps you stay organized or brings you even a bit of joy while working through your day, then it has done its job.

Enjoy planning 🌿
