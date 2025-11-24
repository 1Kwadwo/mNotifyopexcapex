# 🎨 mNotify BudgetIQ - Branding Guide

## Brand Identity

### Full Brand Name
**mNotify BudgetIQ**

### Tagline
"OPEX/CAPEX Management System"

---

## Logo Design

### Login Page Logo
```
┌─────────────────────────────────────┐
│                                     │
│     mNotify  |  BudgetIQ           │
│     ━━━━━━      ━━━━━━━━           │
│     (blue)      (gradient)          │
│                                     │
│  OPEX/CAPEX Management System       │
│                                     │
└─────────────────────────────────────┘
```

### Color Scheme

**mNotify:**
- "m" - Blue (#2563EB / blue-600)
- "Notify" - Dark Gray/White

**BudgetIQ:**
- "Budget" - Gradient (Blue to Purple)
  - From: #2563EB (blue-600)
  - To: #9333EA (purple-600)
- "IQ" - Dark Gray/White

**Separator:** Gray (#9CA3AF / gray-400)

---

## Implementation

### Files Updated

1. **resources/views/components/auth-header.blade.php**
   - Added brand logo to login page
   - Includes tagline
   - Centered design

2. **resources/views/components/app-logo.blade.php**
   - Updated sidebar logo
   - Gradient icon background
   - Compact brand name

3. **.env**
   - Changed APP_NAME to "mNotify BudgetIQ"

---

## Visual Elements

### Login Page
```
┌─────────────────────────────────────────┐
│                                         │
│         mNotify | BudgetIQ              │
│    OPEX/CAPEX Management System         │
│                                         │
│      Log in to your account             │
│  Enter your email and password below    │
│                                         │
│         [Email Input]                   │
│         [Password Input]                │
│         [Remember Me]                   │
│         [Log in Button]                 │
│                                         │
└─────────────────────────────────────────┘
```

### Sidebar Logo
```
┌──────────────────────────────┐
│  [🛡️]  mNotify | BudgetIQ    │
│  (icon) (brand name)         │
└──────────────────────────────┘
```

---

## Typography

### Brand Name
- **Font Weight:** Bold (700)
- **Font Size:** 
  - Login: 3xl (30px)
  - Sidebar: sm (14px)

### Tagline
- **Font Weight:** Normal (400)
- **Font Size:** sm (14px)
- **Color:** Gray-600 / Gray-400 (dark mode)

---

## Icon Design

### Shield Icon (Budget Protection)
```svg
<svg viewBox="0 0 24 24">
  <path d="M12 2L2 7v10c0 5.55 3.84 10.74 9 12 
           5.16-1.26 9-6.45 9-12V7l-10-5z
           m0 18c-3.31 0-6-2.69-6-6s2.69-6 6-6 
           6 2.69 6 6-2.69 6-6 6z
           m-1-9h2v2h-2v-2z
           m0 4h2v2h-2v-2z"/>
</svg>
```

**Symbolism:**
- Shield = Protection & Security
- Dollar signs = Budget Management
- Gradient = Modern & Professional

---

## Color Palette

### Primary Colors
| Color | Hex | Usage |
|-------|-----|-------|
| Blue | #2563EB | mNotify "m", primary actions |
| Purple | #9333EA | BudgetIQ gradient end |
| Gray | #9CA3AF | Separator, secondary text |

### Gradient
```css
background: linear-gradient(to right, #2563EB, #9333EA);
```

### Dark Mode
- Text: White (#FFFFFF)
- Background: Zinc-900 (#18181B)
- Accents: Blue-400 (#60A5FA)

---

## Brand Voice

### Personality
- **Professional** - Enterprise-grade solution
- **Intelligent** - "IQ" suggests smart automation
- **Reliable** - "mNotify" implies communication & alerts
- **Modern** - Clean, gradient design

### Messaging
- "Smart Budget Management"
- "Streamlined OPEX/CAPEX Tracking"
- "Intelligent Financial Oversight"
- "Automated Approval Workflows"

---

## Usage Guidelines

### Do's ✅
- Use the full "mNotify BudgetIQ" name
- Maintain color consistency
- Keep gradient smooth (blue to purple)
- Use shield icon for brand identity
- Include tagline on login/marketing materials

### Don'ts ❌
- Don't separate "mNotify" and "BudgetIQ"
- Don't change gradient colors
- Don't use different icons
- Don't alter spacing/separator
- Don't use lowercase for brand name

---

## Responsive Design

### Desktop
- Full logo with tagline
- Large brand name (3xl)
- Prominent icon

### Mobile
- Compact logo
- Smaller text (xl)
- Icon only in tight spaces

### Sidebar
- Icon + compact name
- Gradient icon background
- Single line layout

---

## Brand Assets

### Logo Variations

1. **Full Logo** (Login Page)
   - mNotify | BudgetIQ
   - With tagline
   - Large format

2. **Compact Logo** (Sidebar)
   - Icon + Name
   - Single line
   - Small format

3. **Icon Only** (Favicon)
   - Shield with gradient
   - 32x32px minimum

---

## Technical Implementation

### Tailwind Classes Used

**Brand Name:**
```html
<span class="text-3xl font-bold text-blue-600 dark:text-blue-400">m</span>
<span class="text-3xl font-bold text-gray-900 dark:text-white">Notify</span>
<span class="text-2xl text-gray-400">|</span>
<span class="text-3xl font-bold bg-gradient-to-r from-blue-600 to-purple-600 bg-clip-text text-transparent">Budget</span>
<span class="text-3xl font-bold text-gray-900 dark:text-white">IQ</span>
```

**Icon Background:**
```html
<div class="bg-gradient-to-br from-blue-600 to-purple-600">
```

---

## Future Enhancements

### Potential Additions
- [ ] Animated logo on login
- [ ] Loading spinner with brand colors
- [ ] Email templates with branding
- [ ] PDF report headers
- [ ] Favicon with shield icon
- [ ] Social media graphics
- [ ] Marketing materials

---

## Summary

**mNotify BudgetIQ** represents:
- **m** = Mobile/Modern
- **Notify** = Communication & Alerts
- **Budget** = Financial Management
- **IQ** = Intelligence & Automation

The brand combines professional blue tones with a modern purple gradient, symbolizing trust, innovation, and intelligent financial management.

---

**Status:** ✅ Branding Implemented  
**Files Updated:** 3  
**Visual Impact:** Professional & Modern  
**Brand Recognition:** High
