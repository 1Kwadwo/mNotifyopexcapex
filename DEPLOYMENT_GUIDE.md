# 🚀 Deploying mNotify BudgetIQ to Render

## Prerequisites

1. **GitHub Account** - Your code should be in a GitHub repository
2. **Render Account** - Sign up at [render.com](https://render.com)
3. **PostgreSQL Database** - Will be created automatically

## Step-by-Step Deployment Guide

### 1. Prepare Your Repository

Make sure all files are committed to your GitHub repository:

```bash
git add .
git commit -m "Prepare for Render deployment"
git push origin main
```

### 2. Create a Render Account

1. Go to [render.com](https://render.com)
2. Sign up with your GitHub account
3. Authorize Render to access your repositories

### 3. Deploy Using Blueprint (Recommended)

#### Option A: Using render.yaml (Automated)

1. In Render Dashboard, click **"New +"** → **"Blueprint"**
2. Connect your GitHub repository
3. Render will automatically detect `render.yaml`
4. Click **"Apply"** to create all services

#### Option B: Manual Setup

If you prefer manual setup:

##### Create PostgreSQL Database

1. Click **"New +"** → **"PostgreSQL"**
2. Name: `mnotify-budgetiq-db`
3. Database: `mnotify_budgetiq`
4. User: `mnotify_user`
5. Region: Choose closest to your users
6. Plan: **Starter** (Free tier available)
7. Click **"Create Database"**

##### Create Web Service

1. Click **"New +"** → **"Web Service"**
2. Connect your GitHub repository
3. Configure:
   - **Name**: `mnotify-budgetiq`
   - **Region**: Same as database
   - **Branch**: `main`
   - **Runtime**: `Docker`
   - **Plan**: **Starter** ($7/month) or **Free** (with limitations)

### 4. Configure Environment Variables

In your Web Service settings, add these environment variables:

#### Required Variables

```env
APP_NAME=mNotify BudgetIQ
APP_ENV=production
APP_DEBUG=false
APP_URL=https://your-app-name.onrender.com
APP_KEY=base64:YOUR_GENERATED_KEY

# Database (Auto-filled if using Blueprint)
DB_CONNECTION=pgsql
DB_HOST=your-db-host.render.com
DB_PORT=5432
DB_DATABASE=mnotify_budgetiq
DB_USERNAME=mnotify_user
DB_PASSWORD=your-db-password

# Session & Cache
SESSION_DRIVER=database
QUEUE_CONNECTION=database
CACHE_DRIVER=database

# Mail Configuration (Optional - for notifications)
MAIL_MAILER=smtp
MAIL_HOST=smtp.gmail.com
MAIL_PORT=587
MAIL_USERNAME=your-email@gmail.com
MAIL_PASSWORD=your-app-password
MAIL_ENCRYPTION=tls
MAIL_FROM_ADDRESS=your-email@gmail.com
MAIL_FROM_NAME="mNotify BudgetIQ"
```

#### Generate APP_KEY

Run locally:
```bash
php artisan key:generate --show
```

Copy the output and paste it as `APP_KEY` in Render.

### 5. Database Connection

If using Blueprint, database credentials are automatically linked.

If manual setup:
1. Go to your PostgreSQL database in Render
2. Copy the **Internal Database URL**
3. Parse it into individual environment variables:
   - Format: `postgresql://user:password@host:port/database`

### 6. Deploy!

1. Click **"Manual Deploy"** → **"Deploy latest commit"**
2. Wait for build to complete (5-10 minutes first time)
3. Monitor logs for any errors

### 7. Post-Deployment Setup

Once deployed, your app will automatically:
- ✅ Run database migrations
- ✅ Seed demo data
- ✅ Cache configurations
- ✅ Optimize routes and views

### 8. Access Your Application

Your app will be available at:
```
https://mnotify-budgetiq.onrender.com
```

#### Default Login Credentials

**CEO Account:**
- Email: `ceo@mnotify.com`
- Password: `password`

**Finance Manager:**
- Email: `finance@mnotify.com`
- Password: `password`

**Staff:**
- Email: `staff@mnotify.com`
- Password: `password`

**⚠️ IMPORTANT:** Change these passwords immediately after first login!

## Custom Domain Setup (Optional)

### Add Custom Domain

1. Go to your Web Service settings
2. Click **"Custom Domains"**
3. Add your domain (e.g., `budgetiq.mnotify.com`)
4. Update DNS records as instructed by Render
5. Update `APP_URL` environment variable

### DNS Configuration

Add these records to your domain:

```
Type: CNAME
Name: budgetiq (or @)
Value: your-app-name.onrender.com
```

## Troubleshooting

### Build Fails

**Issue:** Composer or NPM errors

**Solution:**
```bash
# Locally test the build
composer install --no-dev
npm ci && npm run build
```

### Database Connection Errors

**Issue:** Can't connect to database

**Solution:**
1. Verify database is running in Render
2. Check environment variables are correct
3. Ensure database and web service are in same region

### 500 Server Error

**Issue:** Application error after deployment

**Solution:**
1. Check logs in Render dashboard
2. Verify `APP_KEY` is set
3. Ensure storage permissions are correct
4. Run: `php artisan config:clear`

### Assets Not Loading

**Issue:** CSS/JS files not found

**Solution:**
1. Verify `npm run build` completed successfully
2. Check `public/build` directory exists
3. Ensure `APP_URL` is correct

## Monitoring & Maintenance

### View Logs

```bash
# In Render Dashboard
Services → Your App → Logs
```

### Database Backups

Render automatically backs up PostgreSQL databases daily.

To create manual backup:
1. Go to your database
2. Click **"Backups"**
3. Click **"Create Backup"**

### Update Application

```bash
# Push changes to GitHub
git add .
git commit -m "Update application"
git push origin main

# Render will auto-deploy (if enabled)
# Or manually deploy from Render dashboard
```

## Performance Optimization

### Enable Auto-Deploy

1. Go to Web Service settings
2. Enable **"Auto-Deploy"**
3. Render will deploy on every push to main branch

### Scale Your Application

Upgrade your plan for:
- More memory
- More CPU
- Better performance
- Custom domains
- SSL certificates

## Security Checklist

- [ ] Change default passwords
- [ ] Set `APP_DEBUG=false`
- [ ] Use strong `APP_KEY`
- [ ] Enable HTTPS (automatic on Render)
- [ ] Set up database backups
- [ ] Configure mail settings
- [ ] Review user permissions
- [ ] Enable 2FA for admin accounts

## Cost Estimate

### Free Tier
- PostgreSQL: Free (90 days, then $7/month)
- Web Service: Free (with limitations)
- **Total: $0** (first 90 days)

### Starter Plan
- PostgreSQL: $7/month
- Web Service: $7/month
- **Total: $14/month**

### Professional Plan
- PostgreSQL: $20/month
- Web Service: $25/month
- **Total: $45/month**

## Support

### Render Documentation
- [Render Docs](https://render.com/docs)
- [Laravel on Render](https://render.com/docs/deploy-laravel)

### Application Support
- Check logs in Render dashboard
- Review Laravel logs in `storage/logs`
- Contact mNotify support

## Next Steps

1. ✅ Deploy application
2. ✅ Test all features
3. ✅ Change default passwords
4. ✅ Configure email settings
5. ✅ Set up custom domain
6. ✅ Train users
7. ✅ Monitor performance

**Your mNotify BudgetIQ application is now live! 🎉**
