# ZenPlan Authentication System - Setup Guide

## Overview
Complete authentication system with email/password login, Google OAuth, email verification, password reset, and a modern UI built with Laravel, Livewire, and Tailwind CSS.

---

## 🚀 Quick Setup

### 1. Install Dependencies

```bash
# Install Laravel Socialite
composer require laravel/socialite

# Install Alpine.js for interactive components
npm install alpinejs

# Install and build assets
npm install
npm run dev
```

### 2. Run Database Migrations

```bash
php artisan migrate
```

This will create the necessary `users` table and add `google_id` and `avatar` columns for OAuth.

### 3. Configure Environment Variables

Update your `.env` file with the following:

```env
# Application
APP_NAME="ZenPlan"
APP_URL=http://localhost:8000

# Database (already configured)
# ...your existing database config...

# Mail Configuration
MAIL_MAILER=smtp
MAIL_HOST=smtp.mailtrap.io  # or your mail provider
MAIL_PORT=2525
MAIL_USERNAME=your_username
MAIL_PASSWORD=your_password
MAIL_ENCRYPTION=tls
MAIL_FROM_ADDRESS="hello@zenplan.com"
MAIL_FROM_NAME="${APP_NAME}"

# Google OAuth (Get from Google Cloud Console)
GOOGLE_CLIENT_ID=your_google_client_id
GOOGLE_CLIENT_SECRET=your_google_client_secret
GOOGLE_REDIRECT_URI=http://localhost:8000/auth/google/callback
```

---

## 🔑 Setting Up Google OAuth

### Step 1: Create Google OAuth Credentials

1. Go to [Google Cloud Console](https://console.cloud.google.com/)
2. Create a new project or select existing one
3. Navigate to **APIs & Services** > **Credentials**
4. Click **Create Credentials** > **OAuth client ID**
5. Select **Web application**
6. Configure:
   - **Authorized JavaScript origins**: `http://localhost:8000`
   - **Authorized redirect URIs**: `http://localhost:8000/auth/google/callback`
7. Copy your **Client ID** and **Client Secret**

### Step 2: Update .env File

```env
GOOGLE_CLIENT_ID=123456789-abcdefg.apps.googleusercontent.com
GOOGLE_CLIENT_SECRET=your_secret_here
GOOGLE_REDIRECT_URI=http://localhost:8000/auth/google/callback
```

### Step 3: Production Setup

For production, update your Google OAuth authorized redirect URIs:
```
https://yourdomain.com/auth/google/callback
```

And update `.env`:
```env
GOOGLE_REDIRECT_URI=https://yourdomain.com/auth/google/callback
```

---

## 📧 Email Configuration

### Development - Mailtrap

1. Sign up at [Mailtrap.io](https://mailtrap.io/)
2. Get SMTP credentials from your inbox
3. Update `.env`:

```env
MAIL_MAILER=smtp
MAIL_HOST=smtp.mailtrap.io
MAIL_PORT=2525
MAIL_USERNAME=your_mailtrap_username
MAIL_PASSWORD=your_mailtrap_password
MAIL_ENCRYPTION=tls
```

### Production - Real Email Service

Use services like:
- **Mailgun**: Add mailgun config to `.env`
- **SendGrid**: Configure SMTP settings
- **AWS SES**: Use AWS credentials

Example for Mailgun:
```env
MAIL_MAILER=mailgun
MAILGUN_DOMAIN=your-domain.mailgun.org
MAILGUN_SECRET=your_mailgun_secret
```

---

## 🎨 Features Implemented

### ✅ Authentication Pages

1. **Login** (`/login`)
   - Email & password authentication
   - Google OAuth button
   - Remember me checkbox
   - Rate limiting (5 attempts per minute)
   - Form validation with error messages

2. **Register** (`/register`)
   - User registration form
   - Real-time password strength indicator
   - Google OAuth signup
   - Terms & conditions checkbox
   - Auto email verification trigger

3. **Forgot Password** (`/forgot-password`)
   - Password reset request
   - Email verification
   - Success state with instructions
   - Resend link functionality

4. **Reset Password** (`/reset-password/{token}`)
   - Secure password reset with token
   - Password strength indicator
   - Confirmation field validation
   - Auto-login after successful reset

5. **Email Verification** (`/email/verify`)
   - Email verification notice
   - Resend verification link
   - Auto-redirect when verified
   - User-friendly instructions

6. **Dashboard** (`/dashboard`)
   - Welcome message with user name
   - Quick stats (tasks, completed, productivity)
   - Email verification alert
   - User dropdown menu
   - Daily planner integration

---

## 🔒 Security Features

### Implemented

1. **Rate Limiting**
   - Login: 5 attempts per minute per email
   - Blocks brute force attacks
   - Clear error messages

2. **CSRF Protection**
   - Built-in Laravel CSRF tokens
   - All forms protected

3. **Password Security**
   - Minimum 8 characters
   - Bcrypt hashing
   - Strength indicator for user guidance

4. **Email Verification**
   - Signed URLs for verification links
   - Verified middleware on protected routes

5. **Session Management**
   - Session regeneration after login
   - Secure logout with token invalidation

6. **SQL Injection Protection**
   - Eloquent ORM with parameter binding

---

## 🎯 Routes Structure

### Guest Routes (unauthenticated)
```
GET  /                          → Redirect to login
GET  /login                     → Login page
GET  /register                  → Registration page
GET  /forgot-password           → Password reset request
GET  /reset-password/{token}    → Password reset form
GET  /auth/google               → Redirect to Google OAuth
GET  /auth/google/callback      → Handle Google OAuth callback
```

### Authenticated Routes
```
GET  /email/verify              → Email verification notice
GET  /email/verify/{id}/{hash}  → Verify email
POST /logout                    → Logout user
```

### Protected Routes (authenticated + verified)
```
GET  /dashboard                 → User dashboard
GET  /planner                   → Daily planner
```

---

## 🗂️ File Structure

```
app/
├── Http/Controllers/Auth/
│   └── GoogleAuthController.php
├── Livewire/
│   ├── Auth/
│   │   ├── Login.php
│   │   ├── Register.php
│   │   ├── ForgotPassword.php
│   │   ├── ResetPassword.php
│   │   └── VerifyEmail.php
│   └── Dashboard.php
└── Models/
    └── User.php (updated with google_id, avatar, MustVerifyEmail)

resources/views/
├── components/
│   ├── auth/
│   │   ├── auth-card.blade.php
│   │   ├── input.blade.php
│   │   ├── button.blade.php
│   │   ├── social-button.blade.php
│   │   └── divider.blade.php
│   └── layouts/
│       └── app.blade.php
└── livewire/
    ├── auth/
    │   ├── login.blade.php
    │   ├── register.blade.php
    │   ├── forgot-password.blade.php
    │   ├── reset-password.blade.php
    │   └── verify-email.blade.php
    └── dashboard.blade.php

database/migrations/
└── 2024_02_07_000001_add_google_oauth_to_users_table.php

routes/
└── web.php (updated with all auth routes)

config/
└── services.php (updated with Google OAuth config)
```

---

## 🧪 Testing the Authentication Flow

### 1. Test Email/Password Registration

```bash
php artisan serve
```

1. Visit `http://localhost:8000/register`
2. Fill in registration form
3. Check Mailtrap for verification email
4. Click verification link
5. Access dashboard

### 2. Test Login

1. Visit `http://localhost:8000/login`
2. Enter credentials
3. Test "Remember Me" functionality
4. Verify dashboard access

### 3. Test Password Reset

1. Click "Forgot Password" on login page
2. Enter email
3. Check Mailtrap for reset link
4. Click link and set new password
5. Auto-login to dashboard

### 4. Test Google OAuth

1. Click "Continue with Google" button
2. Authorize with Google account
3. Verify auto-registration and login
4. Check user is created in database

---

## 🎨 UI/UX Features

### Design System
- **Colors**: Indigo primary, slate grays, semantic colors
- **Font**: Plus Jakarta Sans (modern, readable)
- **Spacing**: Consistent 4px grid system
- **Border Radius**: 8px inputs, 12px cards, 16px modals

### Interactive Elements
- Password strength indicator (5 levels)
- Loading states on all buttons
- Smooth transitions and animations
- Error message animations
- Success notifications
- Toast messages

### Accessibility
- Proper ARIA labels
- Keyboard navigation support
- Focus indicators
- High contrast ratios (WCAG AA)
- Screen reader friendly
- Semantic HTML

### Responsive Design
- Mobile-first approach
- Breakpoints: sm (640px), md (768px), lg (1024px)
- Touch-friendly buttons (min 44px)
- Readable font sizes on all devices

---

## 🚀 Deployment Checklist

### Before Deploying

- [ ] Set `APP_ENV=production` in `.env`
- [ ] Set `APP_DEBUG=false`
- [ ] Generate new `APP_KEY` with `php artisan key:generate`
- [ ] Update `APP_URL` to production URL
- [ ] Configure production database
- [ ] Set up production mail service
- [ ] Update Google OAuth redirect URI
- [ ] Run migrations on production: `php artisan migrate --force`
- [ ] Build assets: `npm run build`
- [ ] Configure HTTPS/SSL certificate
- [ ] Set up proper file permissions
- [ ] Configure session and cache drivers
- [ ] Set up queue worker for emails (recommended)

### Post-Deployment

- [ ] Test all authentication flows
- [ ] Test email delivery
- [ ] Test Google OAuth
- [ ] Check error logs
- [ ] Monitor performance
- [ ] Set up backup strategy

---

## 📝 Customization Guide

### Change Brand Colors

Edit `resources/views/livewire/auth/*.blade.php`:
```
indigo-600 → your-color-600
indigo-700 → your-color-700
```

### Update Logo

Edit `resources/views/components/auth/auth-card.blade.php`:
```html
<h1 class="text-4xl font-extrabold text-indigo-600 mb-2">Your Brand</h1>
```

Or add an image:
```html
<img src="/logo.svg" alt="Your Brand" class="h-12">
```

### Modify Email Templates

Create custom notification classes:
```bash
php artisan make:notification CustomVerifyEmail
php artisan make:notification CustomResetPassword
```

### Add More OAuth Providers

1. Install provider: `composer require socialiteproviders/github`
2. Add to `config/services.php`
3. Create controller method
4. Add button in views
5. Add routes

---

## 🐛 Troubleshooting

### Issue: Google OAuth Error "redirect_uri_mismatch"
**Solution**: Ensure redirect URI in Google Console exactly matches `.env` value

### Issue: Emails not sending
**Solution**: Check mail configuration, test with `php artisan tinker`:
```php
Mail::raw('Test', function($msg) { $msg->to('test@example.com'); });
```

### Issue: Alpine.js not working
**Solution**: Run `npm install alpinejs && npm run dev`

### Issue: CSRF token mismatch
**Solution**: Clear cache with `php artisan config:clear && php artisan cache:clear`

### Issue: Migration error for google_id column
**Solution**: Drop and recreate: `php artisan migrate:fresh`

---

## 📚 Additional Resources

- [Laravel Documentation](https://laravel.com/docs)
- [Livewire Documentation](https://livewire.laravel.com/docs)
- [Tailwind CSS Documentation](https://tailwindcss.com/docs)
- [Laravel Socialite](https://laravel.com/docs/socialite)
- [Alpine.js Documentation](https://alpinejs.dev/)

---

## 🎉 You're All Set!

Your ZenPlan authentication system is ready to use. Start by creating your first user account and exploring the features!

Need help? Check the troubleshooting section or review the code comments for detailed explanations.
