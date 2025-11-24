# 🚀 Deploying mNotify BudgetIQ to Render (SQLite Version)

## Prerequisites

1. **GitHub Account** - Your code is already pushed ✅
2. **Render Account** - Sign up at [render.com](https://render.com)

## Why SQLite on Render?

Your app uses SQLite, which is perfect for:
- ✅ Simple deployment (no separate database service)
- ✅ Lower cost (no database fees)
- ✅ Fast performance for small to medium apps
- ✅ Easy backups

**Note:** Render provides persistent disk storage for SQLite, so your data is safe!

## Step-by-Step Deployment

### 1. Your Code is Ready ✅

Your repository is at:
```
https://github.com/1Kwadwo/mNotifyopexcapex
```

### 2. Create Render Account

1. Go to [render.com](https://render.com)
2. Click **"Get Started"**
3. Sign up with your GitHub account
4. Authorize Render to access your repositories

### 3. Deploy with Blueprint (Easiest Method)

1. In Render Dashboard, click **"New +"** → **"Blueprint"**
2. Select repository: `1Kwadwo/mNotifyopexcapex`
3. Render will detect `render.yaml` automatically
4. Click **"Apply"**
5. Wait 10-15 minutes for deployment

**That's it!** Render will automatically:
- ✅ Build your Docker container
- ✅ Create persistent disk for SQLite database
- ✅ Run migrations
- ✅ Seed demo data
- ✅ Deploy your app

### 4. Manual Deployment (Alternative)

If Blueprint doesn't work:

#### A. Create Web Service

1. Click **"New +"** → **"Web Service"**
2. Connect repository: `1Kwadwo/mNotifyopexcapex`
3. Configure:
   - **Name**: `mnotify-budgetiq`
   - **Runtime**: `Docker`
   - **Branch**: `main`
   - **Plan**: **Starter** ($7/month)

#### B. Add Persistent Disk

1. In your Web Service, go to **"Disks"**
2. Click **"Add Disk"**
3. Configure:
   - **Name**: `mnotify-data`
   - **Mount Path**: `/var/www/html/database`
   - **Size**: `1 GB`
4. Click **"Save"**

#### C. Set Environment Variables

Click **"Environment"** and add:

```env
APP_NAME=mNotify BudgetIQ
APP_ENV=production
APP_DEBUG=false
APP_URL=https://mnotify-budgetiq.onrender.com
```

Generate APP_KEY:
```bash
php artisan key:generate --show
```

Add the key:
```env
APP_KEY=base64:your-generated-key-here
```

Database settings (SQLite):
```env
DB_CONNECTION=sqlite
DB_DATABASE=/var/www/html/database/database.sqlite
```

Session & Cache:
```env
SESSION_DRIVER=database
QUEUE_CONNECTION=database
CACHE_DRIVER=database
```

#### D. Deploy

1. Click **"Manual Deploy"** → **"Deploy latest commit"**
2. Wait 10-15 minutes
3. Monitor logs for progress

## 🔗 Access Your Application

Your app will be available at:
```
https://mnotify-budgetiq.onrender.com
```

## 🔑 Default Login Credentials

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

## 💾 Database Backups

### Automatic Backups

Render automatically backs up your persistent disk daily.

### Manual Backup

To download your SQLite database:

1. Go to your Web Service
2. Click **"Shell"**
3. Run:
```bash
cat /var/www/html/database/database.sqlite > /tmp/backup.sqlite
```
4. Download from Render dashboard

### Restore from Backup

1. Upload your backup file
2. Copy to database location:
```bash
cp /tmp/backup.sqlite /var/www/html/database/database.sqlite
```
3. Restart your service

## 📊 Monitoring

### View Logs

1. Go to your Web Service
2. Click **"Logs"**
3. Monitor real-time application logs

### Check Database

Access shell:
```bash
sqlite3 /var/www/html/database/database.sqlite
```

Run queries:
```sql
SELECT COUNT(*) FROM users;
SELECT * FROM payment_requests LIMIT 5;
```

## 🔄 Updates & Redeployment

### Automatic Deployment

Enable auto-deploy:
1. Go to Web Service settings
2. Enable **"Auto-Deploy"**
3. Every push to `main` branch will auto-deploy

### Manual Deployment

```bash
# Make changes locally
git add .
git commit -m "Update application"
git push origin main

# In Render dashboard
# Click "Manual Deploy" → "Deploy latest commit"
```

## 💰 Cost Breakdown

### Starter Plan (Recommended)
- **Web Service**: $7/month
- **Persistent Disk (1GB)**: $0.25/month
- **Total**: ~$7.25/month

### Free Tier
- **Web Service**: Free (with limitations)
- **Persistent Disk**: Not available on free tier
- **Note**: Free tier services sleep after inactivity

**Recommendation:** Use Starter plan for production ($7/month)

## 🚀 Performance Tips

### 1. Enable Caching

Already configured in your app:
- Route caching
- Config caching
- View caching

### 2. Optimize Database

Run periodically:
```bash
sqlite3 /var/www/html/database/database.sqlite "VACUUM;"
```

### 3. Monitor Disk Usage

Check disk space:
```bash
du -sh /var/www/html/database/
```

## 🔒 Security Checklist

- [ ] Change all default passwords
- [ ] Set `APP_DEBUG=false`
- [ ] Use strong `APP_KEY`
- [ ] Enable HTTPS (automatic on Render)
- [ ] Set up regular backups
- [ ] Configure mail settings
- [ ] Review user permissions
- [ ] Monitor logs regularly

## 🐛 Troubleshooting

### Database Permission Errors

```bash
# Fix permissions
chmod 664 /var/www/html/database/database.sqlite
chown www-data:www-data /var/www/html/database/database.sqlite
```

### Database Locked

```bash
# Check for locks
fuser /var/www/html/database/database.sqlite

# Restart service if needed
```

### Disk Full

```bash
# Check disk usage
df -h /var/www/html/database

# Clean up old logs
php artisan log:clear
```

### Migration Errors

```bash
# Reset migrations (⚠️ WARNING: Deletes all data!)
php artisan migrate:fresh --seed --force
```

## 📈 Scaling Considerations

### When to Upgrade from SQLite

Consider PostgreSQL when:
- More than 100 concurrent users
- Database size > 1GB
- Need advanced features (full-text search, etc.)
- Multiple app instances (horizontal scaling)

### Migration to PostgreSQL

If you need to migrate later:
1. Create PostgreSQL database on Render
2. Export SQLite data
3. Import to PostgreSQL
4. Update environment variables
5. Redeploy

## 🎉 Success!

Your mNotify BudgetIQ is now live with SQLite!

### Next Steps

1. ✅ Access your app
2. ✅ Change default passwords
3. ✅ Test all features
4. ✅ Configure email (optional)
5. ✅ Set up custom domain (optional)
6. ✅ Train your users
7. ✅ Monitor performance

## 📞 Support

- **Render Docs**: [render.com/docs](https://render.com/docs)
- **Laravel Docs**: [laravel.com/docs](https://laravel.com/docs)
- **SQLite Docs**: [sqlite.org/docs.html](https://sqlite.org/docs.html)

**Your app is ready to go! 🧡**
