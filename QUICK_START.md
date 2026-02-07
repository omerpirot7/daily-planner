# Quick Setup Commands

## Run these commands in order to set up the authentication system:

### 1. Install PHP Dependencies
```bash
composer require laravel/socialite
```

### 2. Install JavaScript Dependencies
```bash
npm install
```

### 3. Run Database Migrations
```bash
php artisan migrate
```

### 4. Build Assets
```bash
npm run dev
```

### 5. Start Development Server
```bash
php artisan serve
```

---

## Environment Setup

Don't forget to configure your `.env` file:

```env
# Google OAuth (required for Google sign-in)
GOOGLE_CLIENT_ID=your_client_id_here
GOOGLE_CLIENT_SECRET=your_client_secret_here
GOOGLE_REDIRECT_URI=http://localhost:8000/auth/google/callback

# Email Configuration (for password reset & verification)
MAIL_MAILER=smtp
MAIL_HOST=smtp.mailtrap.io
MAIL_PORT=2525
MAIL_USERNAME=your_mailtrap_username
MAIL_PASSWORD=your_mailtrap_password
MAIL_ENCRYPTION=tls
MAIL_FROM_ADDRESS="hello@zenplan.com"
MAIL_FROM_NAME="${APP_NAME}"
```

---

## Test the System

1. Visit: http://localhost:8000
2. Click "Sign up for free"
3. Create an account
4. Check your email (Mailtrap) for verification
5. Verify your email
6. Access the dashboard

---

## Routes Available

- `/login` - Login page
- `/register` - Registration page
- `/forgot-password` - Password reset request
- `/dashboard` - User dashboard (protected)
- `/auth/google` - Google OAuth login

---

## Need Help?

See `AUTH_SETUP_GUIDE.md` for detailed documentation.
