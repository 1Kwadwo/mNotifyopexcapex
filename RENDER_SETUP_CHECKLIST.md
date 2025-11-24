# ✅ Render Setup Checklist - Step by Step

## 📋 Complete Setup Guide

Follow these steps in order:

---

## Step 1: Create Web Service ✅

1. Go to [render.com](https://render.com)
2. Sign in with GitHub
3. Click **"New +"** button (top right)
4. Select **"Web Service"**
5. Connect repository: `1Kwadwo/mNotifyopexcapex`
6. Click **"Connect"**

---

## Step 2: Configure Service Settings ✅

### Basic Settings:
- **Name**: `mnotify-budgetiq` (or your choice)
- **Region**: Choose closest to you (e.g., Oregon, Frankfurt)
- **Branch**: `main`
- **Runtime**: Select **"Docker"**

### Build Settings:
- **Dockerfile Path**: `./Dockerfile` (should auto-detect)

### Plan:
- **Free** (for testing) or **Starter** ($7/month - recommended)

Click **"Create Web Service"** (don't worry about environment variables yet)

---

## Step 3: Add Persistent Disk (IMPORTANT!) 💾

**⚠️ Skip this if using Free tier (won't work with SQLite)**

1. In your Web Service, find **"Disks"** in left sidebar
2. Click **"Add Disk"**
3. Configure:
   - **Name**: `mnotify-data`
   - **Mount Path**: `/var/www/html/database`
   - **Size**: `1 GB`
4. Click **"Create"**

---

## Step 4: Add Environment Variables 🔧

1. Click **"Environment"** in left sidebar
2. Click **"Add Environment Variable"** button

### Add These Variables (one by one):

#### Essential Variables (Required):

| Key | Value |
|-----|-------|
| `APP_NAME` | `mNotify BudgetIQ` |
| `APP_ENV` | `production` |
| `APP_DEBUG` | `false` |
| `APP_KEY` | `base64:Hj44p78csAo8yWoae6KyzWpNySMu63mJb0Yz1YWiC/w=` |
| `APP_URL` | `https://mnotify-budgetiq.onrender.com` |
| `LOG_CHANNEL` | `stack` |
| `LOG_LEVEL` | `info` |

#### Database Variables (Required):

| Key | Value |
|-----|-------|
| `DB_CONNECTION` | `sqlite` |
| `DB_DATABASE` | `/var/www/html/database/database.sqlite` |

#### Session & Cache (Required):

| Key | Value |
|-----|-------|
| `SESSION_DRIVER` | `database` |
| `QUEUE_CONNECTION` | `database` |
| `CACHE_DRIVER` | `database` |

#### Mail Settings (Optional - Skip for now):

| Key | Value |
|-----|-------|
| `MAIL_MAILER` | `smtp` |
| `MAIL_HOST` | `smtp.gmail.com` |
| `MAIL_PORT` | `587` |
| `MAIL_ENCRYPTION` | `tls` |

3. Click **"Save Changes"** at the bottom

---

## Step 5: Deploy! 🚀

1. Click **"Manual Deploy"** at top
2. Select **"Deploy latest commit"**
3. Wait 10-15 minutes (first deployment takes longer)
4. Watch the logs for progress

### What to Look For in Logs:

✅ Good signs:
```
Building...
Successfully built
Running migrations...
Database seeded successfully
Starting Apache...
```

❌ Bad signs:
```
Error: APP_KEY not set
Database connection failed
Permission denied
```

---

## Step 6: Update APP_URL (After First Deploy) 🔗

1. After deployment completes, copy your actual Render URL
   - Example: `https://mnotify-budgetiq-abc123.onrender.com`
2. Go to **"Environment"** tab
3. Find `APP_URL` variable
4. Click **"Edit"**
5. Update with your actual URL
6. Click **"Save Changes"**
7. **Redeploy** (Manual Deploy → Deploy latest commit)

---

## Step 7: Test Your App ✅

1. Open your Render URL in browser
2. You should see the login page
3. Try logging in:
   - **Email**: `ceo@mnotify.com`
   - **Password**: `password`

### If Login Works:
✅ **Success!** Your app is live!

### If Login Fails:
1. Check logs for errors
2. Verify all environment variables
3. Make sure persistent disk is added
4. Try redeploying

---

## Step 8: Change Default Passwords 🔐

**IMPORTANT:** Change these immediately!

1. Login as CEO: `ceo@mnotify.com` / `password`
2. Go to profile settings
3. Change password
4. Repeat for other accounts:
   - Finance Manager: `finance@mnotify.com`
   - Staff: `staff@mnotify.com`

---

## 🎯 Quick Reference

### Your App URLs:
- **Production**: `https://your-app-name.onrender.com`
- **Logs**: Render Dashboard → Your Service → Logs
- **Environment**: Render Dashboard → Your Service → Environment

### Default Logins:
- **CEO**: `ceo@mnotify.com` / `password`
- **Finance Manager**: `finance@mnotify.com` / `password`
- **Staff**: `staff@mnotify.com` / `password`

### Important Files:
- Environment variables: `RENDER_ENVIRONMENT_VARIABLES.md`
- Full deployment guide: `DEPLOYMENT_GUIDE_SQLITE.md`
- Quick start: `RENDER_QUICK_START.md`

---

## 🐛 Common Issues & Solutions

### Issue: "APP_KEY not set"
**Solution:** 
- Make sure APP_KEY includes `base64:` prefix
- Copy entire value: `base64:Hj44p78csAo8yWoae6KyzWpNySMu63mJb0Yz1YWiC/w=`

### Issue: "Database not found"
**Solution:**
- Verify persistent disk is added
- Check DB_DATABASE path: `/var/www/html/database/database.sqlite`
- Redeploy

### Issue: "500 Server Error"
**Solution:**
- Check logs in Render dashboard
- Verify APP_ENV is `production`
- Make sure APP_DEBUG is `false`
- Check all environment variables are set

### Issue: "Page not loading"
**Solution:**
- Wait 30 seconds (free tier wakes up slowly)
- Check APP_URL matches your actual Render URL
- Verify deployment completed successfully

### Issue: "Data disappears after restart"
**Solution:**
- You need persistent disk (not available on free tier)
- Upgrade to Starter plan ($7/month)
- Or switch to PostgreSQL database

---

## 💰 Cost Summary

### Free Tier:
- **Web Service**: Free
- **Persistent Disk**: Not available ❌
- **Limitations**: Sleeps after 15 min, no persistent storage
- **Best for**: Testing only

### Starter Plan (Recommended):
- **Web Service**: $7/month
- **Persistent Disk (1GB)**: $0.25/month
- **Total**: ~$7.25/month
- **Best for**: Production use

---

## ✅ Final Checklist

Before going live:

- [ ] Web Service created
- [ ] Persistent disk added (if using Starter plan)
- [ ] All environment variables set
- [ ] APP_URL updated with actual Render URL
- [ ] App deployed successfully
- [ ] Login page loads
- [ ] Can login with default credentials
- [ ] Default passwords changed
- [ ] All features tested
- [ ] Email configured (optional)

---

## 🎉 You're Done!

Your mNotify BudgetIQ is now live on Render!

### Next Steps:
1. ✅ Test all features
2. ✅ Train your users
3. ✅ Monitor logs regularly
4. ✅ Set up backups
5. ✅ Configure custom domain (optional)

**Congratulations! 🧡**
