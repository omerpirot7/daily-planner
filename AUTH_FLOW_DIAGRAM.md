# 🔐 ZenPlan Authentication Flow Diagram

## Visual Overview of Authentication System

```
┌─────────────────────────────────────────────────────────────────────────┐
│                          USER AUTHENTICATION FLOW                        │
└─────────────────────────────────────────────────────────────────────────┘

                              START
                                │
                                ▼
                        ┌───────────────┐
                        │  Landing Page │
                        │      (/)      │
                        └───────┬───────┘
                                │
                                ▼
                    ┌─────────────────────┐
                    │   LOGIN PAGE        │
                    │   /login            │
                    │                     │
                    │  • Email/Password   │
                    │  • Google OAuth     │
                    │  • Remember Me      │
                    │  • Rate Limited     │
                    └──────┬──────┬───────┘
                           │      │
                  ┌────────┘      └────────┐
                  │                        │
                  ▼                        ▼
        ┌──────────────────┐     ┌──────────────────┐
        │  Email/Password  │     │  Google OAuth    │
        │  Authentication  │     │  Authentication  │
        └────────┬─────────┘     └─────────┬────────┘
                 │                          │
                 └──────────┬───────────────┘
                            ▼
                    ┌───────────────┐
                    │   Logged In   │
                    └───────┬───────┘
                            │
                            ▼
                ┌───────────────────────┐
                │  Email Verified?      │
                └───────┬───────────────┘
                        │
              ┌─────────┴─────────┐
              │                   │
              ▼ No                ▼ Yes
    ┌──────────────────┐   ┌──────────────┐
    │ Verify Email Page│   │  DASHBOARD   │
    │  /email/verify   │   │  /dashboard  │
    │                  │   │              │
    │  • Resend Link   │   │  • Stats     │
    │  • Instructions  │   │  • Tasks     │
    └──────────────────┘   │  • Profile   │
                          └──────────────┘


═══════════════════════════════════════════════════════════════════════════

                        REGISTRATION FLOW

                        START
                          │
                          ▼
                ┌──────────────────┐
                │ REGISTER PAGE    │
                │  /register       │
                │                  │
                │ • Name           │
                │ • Email          │
                │ • Password       │
                │ • Confirmation   │
                │ • Terms & Conds  │
                │ • Google OAuth   │
                └────────┬─────────┘
                         │
            ┌────────────┴────────────┐
            │                         │
            ▼                         ▼
   ┌──────────────────┐      ┌──────────────────┐
   │  Email/Password  │      │  Google OAuth    │
   │  Registration    │      │  Sign Up         │
   └────────┬─────────┘      └─────────┬────────┘
            │                           │
            └──────────┬────────────────┘
                       ▼
            ┌──────────────────────┐
            │  Account Created     │
            │  User Auto-Logged In │
            └──────────┬───────────┘
                       │
                       ▼
            ┌──────────────────────┐
            │ Verification Email   │
            │      Sent            │
            └──────────┬───────────┘
                       │
                       ▼
            ┌──────────────────────┐
            │  Verify Email Page   │
            │   /email/verify      │
            └──────────────────────┘


═══════════════════════════════════════════════════════════════════════════

                    PASSWORD RESET FLOW

                        START
                          │
                          ▼
                ┌──────────────────┐
                │   LOGIN PAGE     │
                │                  │
                │ "Forgot Password"│
                └────────┬─────────┘
                         │
                         ▼
            ┌──────────────────────────┐
            │  FORGOT PASSWORD PAGE    │
            │  /forgot-password        │
            │                          │
            │  • Enter Email           │
            │  • Validation            │
            └────────┬─────────────────┘
                     │
                     ▼
            ┌──────────────────────────┐
            │  Reset Link Email Sent   │
            └────────┬─────────────────┘
                     │
                     ▼
            ┌──────────────────────────┐
            │  User Clicks Link        │
            └────────┬─────────────────┘
                     │
                     ▼
            ┌──────────────────────────┐
            │  RESET PASSWORD PAGE     │
            │  /reset-password/{token} │
            │                          │
            │  • New Password          │
            │  • Confirmation          │
            │  • Strength Indicator    │
            └────────┬─────────────────┘
                     │
                     ▼
            ┌──────────────────────────┐
            │  Password Changed        │
            │  Redirect to Login       │
            └──────────────────────────┘


═══════════════════════════════════════════════════════════════════════════

                    MIDDLEWARE & ROUTE PROTECTION

┌─────────────────────────────────────────────────────────────────────────┐
│                                                                          │
│  GUEST ROUTES (unauthenticated)                                         │
│  ┌────────────────────────────────────────────────────────┐            │
│  │  • /                    → Redirect to /login           │            │
│  │  • /login               → Login page                   │            │
│  │  • /register            → Registration page            │            │
│  │  • /forgot-password     → Password reset request       │            │
│  │  • /reset-password      → Password reset form          │            │
│  │  • /auth/google         → Google OAuth redirect        │            │
│  │  • /auth/google/callback→ OAuth callback               │            │
│  └────────────────────────────────────────────────────────┘            │
│                                                                          │
│  AUTH ROUTES (authenticated)                                            │
│  ┌────────────────────────────────────────────────────────┐            │
│  │  • /email/verify        → Email verification notice    │            │
│  │  • /email/verify/{id}   → Verify email link           │            │
│  │  • /logout              → Logout (POST)                │            │
│  └────────────────────────────────────────────────────────┘            │
│                                                                          │
│  PROTECTED ROUTES (authenticated + verified)                            │
│  ┌────────────────────────────────────────────────────────┐            │
│  │  • /dashboard           → User dashboard               │            │
│  │  • /planner             → Daily planner                │            │
│  └────────────────────────────────────────────────────────┘            │
│                                                                          │
└─────────────────────────────────────────────────────────────────────────┘


═══════════════════════════════════════════════════════════════════════════

                        SECURITY LAYERS

┌─────────────────────────────────────────────────────────────────────────┐
│                                                                          │
│  Layer 1: CSRF Protection                                               │
│  ├─ Laravel CSRF tokens on all forms                                    │
│  └─ Automatic token validation                                          │
│                                                                          │
│  Layer 2: Rate Limiting                                                 │
│  ├─ Login: 5 attempts per minute                                        │
│  └─ Blocks brute force attacks                                          │
│                                                                          │
│  Layer 3: Password Security                                             │
│  ├─ Minimum 8 characters required                                       │
│  ├─ Bcrypt hashing (cost: 10)                                           │
│  └─ Password strength indicator                                         │
│                                                                          │
│  Layer 4: Email Verification                                            │
│  ├─ Signed URLs with expiration                                         │
│  ├─ Required for protected routes                                       │
│  └─ Resend functionality with throttling                                │
│                                                                          │
│  Layer 5: Session Security                                              │
│  ├─ Session regeneration after login                                    │
│  ├─ Token invalidation on logout                                        │
│  └─ HTTPOnly cookies                                                    │
│                                                                          │
│  Layer 6: Database Security                                             │
│  ├─ Eloquent ORM (prepared statements)                                  │
│  ├─ SQL injection protection                                            │
│  └─ Mass assignment protection                                          │
│                                                                          │
│  Layer 7: XSS Protection                                                │
│  ├─ Blade automatic escaping                                            │
│  └─ Input sanitization                                                  │
│                                                                          │
└─────────────────────────────────────────────────────────────────────────┘


═══════════════════════════════════════════════════════════════════════════

                        COMPONENT ARCHITECTURE

┌─────────────────────────────────────────────────────────────────────────┐
│                                                                          │
│  REUSABLE COMPONENTS                                                    │
│  ┌────────────────────────────────────────────────────────┐            │
│  │  <x-auth.auth-card>                                    │            │
│  │    └─ Wrapper for all auth pages                       │            │
│  │                                                         │            │
│  │  <x-auth.input>                                        │            │
│  │    └─ Form input with validation & errors              │            │
│  │                                                         │            │
│  │  <x-auth.button>                                       │            │
│  │    └─ Styled button with loading states                │            │
│  │                                                         │            │
│  │  <x-auth.social-button>                                │            │
│  │    └─ OAuth provider buttons (Google)                  │            │
│  │                                                         │            │
│  │  <x-auth.divider>                                      │            │
│  │    └─ "or" divider between options                     │            │
│  └────────────────────────────────────────────────────────┘            │
│                                                                          │
│  LIVEWIRE COMPONENTS                                                    │
│  ┌────────────────────────────────────────────────────────┐            │
│  │  Login          → Email/password authentication        │            │
│  │  Register       → User registration with validation    │            │
│  │  ForgotPassword → Password reset request               │            │
│  │  ResetPassword  → Password reset with token            │            │
│  │  VerifyEmail    → Email verification notice            │            │
│  │  Dashboard      → Protected user dashboard             │            │
│  └────────────────────────────────────────────────────────┘            │
│                                                                          │
│  CONTROLLERS                                                            │
│  ┌────────────────────────────────────────────────────────┐            │
│  │  GoogleAuthController                                  │            │
│  │    ├─ redirect()  → Send to Google OAuth              │            │
│  │    └─ callback()  → Handle OAuth response             │            │
│  └────────────────────────────────────────────────────────┘            │
│                                                                          │
└─────────────────────────────────────────────────────────────────────────┘


═══════════════════════════════════════════════════════════════════════════

                        FILE STRUCTURE

project/
├── app/
│   ├── Http/Controllers/Auth/
│   │   └── GoogleAuthController.php
│   ├── Livewire/
│   │   ├── Auth/
│   │   │   ├── Login.php
│   │   │   ├── Register.php
│   │   │   ├── ForgotPassword.php
│   │   │   ├── ResetPassword.php
│   │   │   └── VerifyEmail.php
│   │   └── Dashboard.php
│   └── Models/
│       └── User.php (updated)
│
├── resources/views/
│   ├── components/
│   │   └── auth/
│   │       ├── auth-card.blade.php
│   │       ├── input.blade.php
│   │       ├── button.blade.php
│   │       ├── social-button.blade.php
│   │       └── divider.blade.php
│   └── livewire/
│       ├── auth/
│       │   ├── login.blade.php
│       │   ├── register.blade.php
│       │   ├── forgot-password.blade.php
│       │   ├── reset-password.blade.php
│       │   └── verify-email.blade.php
│       └── dashboard.blade.php
│
├── database/migrations/
│   └── 2024_02_07_000001_add_google_oauth_to_users_table.php
│
├── routes/
│   └── web.php (updated)
│
├── config/
│   └── services.php (updated)
│
└── Documentation/
    ├── AUTH_SETUP_GUIDE.md
    ├── QUICK_START.md
    └── IMPLEMENTATION_SUMMARY.md


═══════════════════════════════════════════════════════════════════════════

                    TECHNOLOGY STACK

┌─────────────────────────────────────────────────────────────────────────┐
│                                                                          │
│  Backend:                                                               │
│  • Laravel 11.x                                                         │
│  • Livewire 3.x                                                         │
│  • Laravel Socialite                                                    │
│  • PostgreSQL (Neon)                                                    │
│                                                                          │
│  Frontend:                                                              │
│  • Tailwind CSS 4.x                                                     │
│  • Alpine.js 3.x                                                        │
│  • Plus Jakarta Sans Font                                               │
│  • Vite                                                                 │
│                                                                          │
│  Authentication:                                                        │
│  • Session-based auth                                                   │
│  • Google OAuth 2.0                                                     │
│  • Email verification                                                   │
│  • Password reset tokens                                                │
│                                                                          │
└─────────────────────────────────────────────────────────────────────────┘
```

## Quick Reference

### Routes
- Login: `/login`
- Register: `/register`
- Dashboard: `/dashboard` (protected)
- Reset: `/forgot-password`

### Key Features
✅ Modern, clean UI
✅ Mobile responsive
✅ Password strength indicator
✅ Google OAuth
✅ Email verification
✅ Rate limiting
✅ Accessibility ready

### Next Steps
1. Run `composer require laravel/socialite`
2. Run `npm install && npm run dev`
3. Run `php artisan migrate`
4. Configure `.env` for Google OAuth
5. Start server: `php artisan serve`

**See QUICK_START.md for detailed commands!**
