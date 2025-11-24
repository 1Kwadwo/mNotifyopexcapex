# 🔧 Render Environment Variables - Copy & Paste

## In Render Dashboard

After creating your Web Service, go to **"Environment"** tab and add these variables:

---

## Required Variables (Copy these exactly)

### 1. APP_NAME
```
mNotify BudgetIQ
```

### 2. APP_ENV
```
production
```

### 3. APP_DEBUG
```
false
```

### 4. APP_KEY
```
base64:Hj44p78csAo8yWoae6KyzWpNySMu63mJb0Yz1YWiC/w=
```

### 5. APP_URL
**⚠️ IMPORTANT:** Replace with your actual Render URL after deployment

**Before deployment, use:**
```
https://mnotify-budgetiq.onrender.com
```

**After deployment, update to your actual URL:**
```
https://your-actual-app-name.onrender.com
```

### 6. LOG_CHANNEL
```
stack
```

### 7. LOG_LEVEL
```
info
```

---

## Database Variables (SQLite)

### 8. DB_CONNECTION
```
sqlite
```

### 9. DB_DATABASE
```
/var/www/html/database/database.sqlite
```

---

## Session & Cache

### 10. SESSION_DRIVER
```
database
```

### 11. QUEUE_CONNECTION
```
database
```

### 12. CACHE_DRIVER
```
database
```

---

## Mail Settings (Optional - Skip for now)

You can add these later if you want email notifications:

### 13. MAIL_MAILER
```
smtp
```

### 14. MAIL_HOST
```
smtp.gmail.com
```

### 15. MAIL_PORT
```
587
```

### 16. MAIL_USERNAME
```
your-email@gmail.com
```
*(Replace with your actual email)*

### 17. MAIL_PASSWORD
```
your-app-password
```
*(Use Gmail App Password, not your regular password)*

### 18. MAIL_ENCRYPTION
```
tls
```

### 19. MAIL_FROM_ADDRESS
```
your-email@gmail.com
```
*(Same as MAIL_USERNAME)*

### 20. MAIL_FROM_NAME
```
mNotify BudgetIQ
```

---

## 📋 Quick Copy Format

For easy copy-paste in Render, here's the format:

**Key** → **Value**

```
APP_NAME → mNotify BudgetIQ
APP_ENV → production
APP_DEBUG → false
APP_KEY → base64:Hj44p78csAo8yWoae6KyzWpNySMu63mJb0Yz1YWiC/w=
APP_URL → https://mnotify-budgetiq.onrender.com
LOG_CHANNEL → stack
LOG_LEVEL → info
DB_CONNECTION → sqlite
DB_DATABASE → /var/www/html/database/database.sqlite
SESSION_DRIVER → database
QUEUE_CONNECTION → database
CACHE_DRIVER → database
```

---

## 🎯 Step-by-Step in Render

1. **Go to your Web Service** in Render dashboard
2. **Click "Environment"** tab on the left
3. **Click "Add Environment Variable"**
4. **For each variable:**
   - Enter the **Key** (e.g., `APP_NAME`)
   - Enter the **Value** (e.g., `mNotify BudgetIQ`)
   - Click **"Add"**
5. **Repeat** for all variables above
6. **Click "Save Changes"** at the bottom

---

## ⚠️ Important Notes

### APP_KEY
- ✅ Already generated for you
- ✅ Keep it secret
- ✅ Never share publicly
- ✅ Don't change it after deployment (will break sessions)

### APP_URL
- ⚠️ Must update after first deployment
- ⚠️ Use your actual Render URL
- Example: `https://mnotify-budgetiq-abc123.onrender.com`

### DB_DATABASE
- ✅ Must be exactly: `/var/www/html/database/database.sqlite`
- ✅ Don't change this path
- ✅ Render will create the file automatically

### Mail Settings
- 📧 Optional - skip if you don't need email
- 📧 Can add later when needed
- 📧 Use Gmail App Password (not regular password)

---

## ✅ Verification Checklist

After adding all variables:

- [ ] APP_NAME is set
- [ ] APP_ENV is `production`
- [ ] APP_DEBUG is `false`
- [ ] APP_KEY is set (starts with `base64:`)
- [ ] APP_URL is set (will update after deployment)
- [ ] DB_CONNECTION is `sqlite`
- [ ] DB_DATABASE path is correct
- [ ] SESSION_DRIVER is `database`
- [ ] QUEUE_CONNECTION is `database`
- [ ] CACHE_DRIVER is `database`

---

## 🚀 After Adding Variables

1. **Click "Save Changes"**
2. **Deploy your app** (Manual Deploy → Deploy latest commit)
3. **Wait 10-15 minutes**
4. **Update APP_URL** with your actual Render URL
5. **Redeploy** if you changed APP_URL

---

## 🆘 Troubleshooting

### "APP_KEY not set" error
- Make sure APP_KEY includes `base64:` prefix
- Copy the entire value: `base64:Hj44p78csAo8yWoae6KyzWpNySMu63mJb0Yz1YWiC/w=`

### Database errors
- Verify DB_DATABASE path is exactly: `/var/www/html/database/database.sqlite`
- Make sure you added a persistent disk

### Can't access app
- Check APP_URL matches your actual Render URL
- Make sure APP_ENV is `production`
- Check logs for errors

---

## 📞 Need Help?

If you get stuck:
1. Check Render logs (Logs tab)
2. Verify all variables are set correctly
3. Make sure persistent disk is added
4. Try redeploying

**Your environment is ready! 🎉**
