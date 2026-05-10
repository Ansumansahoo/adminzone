# AdminZone — Premium Admin Dashboard

![AdminZone Banner](https://img.shields.io/badge/AdminZone-Premium%20Dashboard-6366f1?style=for-the-badge&logo=data:image/svg+xml;base64,PHN2ZyB4bWxucz0iaHR0cDovL3d3dy53My5vcmcvMjAwMC9zdmciIHZpZXdCb3g9IjAgMCAyNCAyNCI+PHBhdGggZmlsbD0id2hpdGUiIGQ9Ik0xMiAyQzYuNDggMiAyIDYuNDggMiAxMnM0LjQ4IDEwIDEwIDEwIDEwLTQuNDggMTAtMTBTMTcuNTIgMiAxMiAyem0tMiAxNEg4di02aDJ2NnptNCAwaC0yVjhoMnY4eiIvPjwvc3ZnPg==)
[![Live Demo](https://img.shields.io/badge/Live%20Demo-ansumansahoo.github.io-22c55e?style=for-the-badge)](https://ansumansahoo.github.io/adminzone/)
[![GitHub Pages](https://img.shields.io/badge/Hosted%20on-GitHub%20Pages-181717?style=for-the-badge&logo=github)](https://ansumansahoo.github.io/adminzone/)

A fully functional, responsive, single-file admin dashboard built with pure HTML, CSS, and JavaScript. No build tools. No backend. No framework. Just open `index.html` and it works.

---

## Table of Contents

1. [Live Demo](#live-demo)
2. [Features](#features)
3. [Project Architecture](#project-architecture)
4. [Getting Started](#getting-started)
5. [Demo Credentials](#demo-credentials)
6. [Pages & Functionality](#pages--functionality)
7. [Code Structure](#code-structure)
8. [CSS Design System](#css-design-system)
9. [JavaScript Architecture](#javascript-architecture)
10. [Data Layer (localStorage)](#data-layer-localstorage)
11. [Authentication System](#authentication-system)
12. [How to Customize](#how-to-customize)
13. [Competitive Analysis & Design Decisions](#competitive-analysis--design-decisions)
14. [MoSCoW Feature Breakdown](#moscow-feature-breakdown)
15. [Browser Support](#browser-support)
16. [Deployment](#deployment)
17. [FAQ](#faq)

---

## Live Demo

**URL:** https://ansumansahoo.github.io/adminzone/

| Credential | Value |
|---|---|
| Email | `admin@adminzone.com` |
| Password | `admin123` |

---

## Features

### Core Features
- **7 fully functional pages** — Dashboard, Users, Notices, Posts, Shoutbox, Profile, Settings
- **Authentication** — Login / Signup with session management via localStorage
- **Dark & Light mode** — Toggle with instant theme switching, persisted across reloads
- **Fully responsive** — Works on mobile, tablet, and desktop
- **Zero dependencies** — No npm, no build step, no server required

### Dashboard
- 4 KPI stat cards (Total Users, Posts, Notices, Shoutbox Messages)
- Animated bar chart (Chart.js) showing weekly post activity
- Live activity feed showing the last 10 admin actions
- Real-time clock in the top bar

### User Management
- Full CRUD — Create, Read, Update, Delete users
- Role assignment (Admin, Moderator, User)
- Status toggle (Active / Inactive)
- Search and filter by name/email
- Paginated table (5 users per page)
- Modal-based edit form

### Notice Board
- Scrolling live ticker at the top of the page
- Create notices with Priority (High, Medium, Low)
- Notices displayed as cards with color-coded badges
- Delete notices with confirmation

### Posts Manager
- Posts table with category and status columns
- Status labels: Published, Draft, Archived
- View, Edit, Delete actions per row
- Create new post modal
- Search and paginate posts

### Shoutbox
- Real-time style chat interface (localStorage-backed)
- Send messages with Enter key or click
- Messages show avatar, name, timestamp
- Clear all messages option

### Profile Page
- Gradient hero header with avatar initials
- Edit full name, username, email, phone, bio
- Change password form (validates current password)
- Account info sidebar (member since, role, status)

### Settings Page
- Theme toggle (Dark/Light)
- Export all data as JSON file
- Reset demo data (restores factory state)
- Clear all data (wipes localStorage)

---

## Project Architecture

```
adminzone/
  index.html        <- The entire application (HTML + CSS + JS in one file)
  README.md         <- This documentation file
```

AdminZone is a **Single Page Application (SPA)** with no router library. Navigation between pages is handled by showing/hiding `<div>` sections in JavaScript. All data is stored in the browser's `localStorage`.

### Why a single file?

- **GitHub Pages compatible** — No server needed, no PHP, no Node.js
- **Zero build tooling** — Just edit and commit
- **Portable** — Download the file, open in any browser, it works offline

---

## Getting Started

### Option 1 — View online
Visit https://ansumansahoo.github.io/adminzone/

### Option 2 — Run locally
```bash
# Clone the repository
git clone https://github.com/Ansumansahoo/adminzone.git

# Open in browser (no server needed)
open adminzone/index.html
# OR on Windows:
start adminzone/index.html
```

### Option 3 — Fork & deploy your own
1. Fork this repository on GitHub
2. Go to **Settings → Pages**
3. Set source to **Deploy from branch → master → / (root)**
4. Your site will be live at `https://YOUR_USERNAME.github.io/adminzone/`

---

## Demo Credentials

On first load, the app automatically seeds demo data:

| Field | Value |
|---|---|
| Email | `admin@adminzone.com` |
| Password | `admin123` |
| Role | Super Admin |

### Additional demo users (seeded automatically)

| Name | Email | Password | Role |
|---|---|---|---|
| Jane Mod | `jane@adminzone.com` | `mod123` | Moderator |
| Bob User | `bob@adminzone.com` | `user123` | User |
| Alice Editor | `alice@adminzone.com` | `edit123` | User |

---

## Pages & Functionality

### 1. Login Screen (`#ls`)
The login/signup screen shown before authentication.

- **Sign In tab** — Email + password form, calls `doLogin()`
- **Sign Up tab** — Full name, email, password form, calls `doSignup()`
- Tab switching via `switchTab('in')` or `switchTab('up')`

### 2. Dashboard (`#dash`)
Main landing page after login.

| Element | Description |
|---|---|
| Stats Row | 4 cards: Users, Posts, Notices, Shouts — pulled from localStorage counts |
| Bar Chart | Chart.js bar chart showing post activity for the last 7 days |
| Activity Feed | Last 10 entries from `az_activity` localStorage key |

### 3. Users (`#users`)
Full user management interface.

| Action | Function | Description |
|---|---|---|
| View all | `renderUsers()` | Renders paginated table |
| Add user | `openUserMod()` | Opens empty add modal |
| Edit user | `editUser(id)` | Opens prefilled edit modal |
| Delete user | `delUser(id)` | Confirm then delete |
| Save | `saveUser()` | Saves add/edit to localStorage |
| Search | Input event on `#uSearch` | Filters users by name/email |
| Paginate | `userPg(n)` | Navigate pages (5 per page) |

### 4. Notice Board (`#notices`)
Announcement/notice management.

| Element | Description |
|---|---|
| Ticker | Live scrolling text: all notice titles joined with separator |
| Add Form | Title + content + priority dropdown |
| Notice Cards | Each card shows title, content, priority badge, delete button |

### 5. Posts (`#posts`)
Blog/content post management.

| Action | Function | Description |
|---|---|---|
| View all | `renderPosts()` | Paginated posts table |
| View post | `viewPost(id)` | Read-only modal |
| Edit post | `editPost(id)` | Prefilled edit modal |
| Add new | `openPostMod()` | Empty create modal |
| Delete | `delPost(id)` | Confirm and remove |
| Save | `savePost()` | Add/update in localStorage |

### 6. Shoutbox (`#shoutbox`)
Real-time style message board.

| Action | Function | Description |
|---|---|---|
| Send message | `sendShout()` | Adds message to `az_shouts` |
| Send on Enter | `shoutKey(e)` | Keyboard shortcut |
| Clear all | `clearShouts()` | Empties shoutbox after confirm |
| Render | `renderShouts()` | Rebuilds message list from storage |

### 7. Profile (`#profile`)
Current user profile and password management.

| Section | Function | Description |
|---|---|---|
| View profile | `renderProfile()` | Loads session user data |
| Edit profile | `savePr()` | Updates name, email, phone, bio |
| Change password | `changePw()` | Validates current, saves new |

### 8. Settings (`#settings`)
Application settings and data management.

| Action | Function | Description |
|---|---|---|
| Toggle theme | `toggleTheme()` | Switches dark/light + saves to `az_theme` |
| Export data | `exportData()` | Downloads `adminzone_data.json` |
| Reset demo | `resetDemo()` | Clears data and re-seeds defaults |
| Clear all | `clearAll()` | Wipes all AdminZone localStorage keys |

---

## Code Structure

The `index.html` file is organized into 3 main sections:

```
index.html
├── <head>
│   ├── Meta tags (charset, viewport)
│   ├── Google Fonts (Inter)
│   ├── Font Awesome 6.5 (icons)
│   ├── Chart.js 4.4 (charts)
│   └── <style> — Complete CSS (~600 lines)
│
├── <body>
│   ├── #ls — Login Screen
│   │   ├── .login-tabs — Sign In / Sign Up tabs
│   │   ├── #tab-in — Sign In form
│   │   └── #tab-up — Sign Up form
│   │
│   ├── #app — Main Application (hidden until login)
│   │   ├── .az-sb — Sidebar
│   │   │   ├── .sb-logo — Logo + brand name
│   │   │   ├── nav — Navigation buttons
│   │   │   └── .sb-foot — User info + logout
│   │   │
│   │   ├── .az-main — Main Content Area
│   │   │   ├── .az-top — Top bar (search, clock, theme toggle)
│   │   │   └── .az-body — Page container
│   │   │       ├── #dash — Dashboard page
│   │   │       ├── #users — Users page
│   │   │       ├── #notices — Notice Board page
│   │   │       ├── #posts — Posts page
│   │   │       ├── #shoutbox — Shoutbox page
│   │   │       ├── #profile — Profile page
│   │   │       └── #settings — Settings page
│   │   │
│   │   └── Modals
│   │       ├── #uMod — User add/edit modal
│   │       ├── #pMod — Post add/edit modal
│   │       ├── #pView — Post view modal
│   │       └── #conf — Confirmation dialog
│   │
│   └── <script> — All JavaScript (~1,200 lines)
│
└── </html>
```

---

## CSS Design System

### Color Tokens (CSS Custom Properties)

AdminZone uses CSS custom properties (variables) defined on `:root` for both dark and light themes.

#### Dark Theme (default)
```css
:root {
  --bg:   #0f1117;   /* Main background */
  --bg2:  #1a1d27;   /* Card / panel background */
  --bg3:  #222638;   /* Input / secondary background */
  --sb:   #13151f;   /* Sidebar background */
  --bdr:  #2e3356;   /* Border color */
  --card: #1e2235;   /* Card surface */
  --card2:#252a3d;   /* Card hover */
  --tx:   #e8eaf0;   /* Primary text */
  --tx2:  #9ba3c0;   /* Secondary / muted text */
  --tx3:  #5e6585;   /* Placeholder / disabled text */
  --pr:   #6366f1;   /* Primary accent (Indigo) */
  --pr2:  #818cf8;   /* Primary hover */
  --pdm:  rgba(99,102,241,.15); /* Primary dim */
  --gn:   #22c55e;   /* Success / Green */
  --gdm:  rgba(34,197,94,.15);  /* Green dim */
  --rd:   #ef4444;   /* Error / Red */
  --rdm:  rgba(239,68,68,.15);  /* Red dim */
  --yw:   #f59e0b;   /* Warning / Yellow */
  --ywdm: rgba(245,158,11,.15); /* Yellow dim */
  --pk:   #ec4899;   /* Pink / Secondary */
  --pkdm: rgba(236,72,153,.15); /* Pink dim */
  --sw:   260px;     /* Sidebar width */
  --tr:   .2s ease;  /* Transition speed */
  --rad:  12px;      /* Border radius */
}
```

#### Light Theme
When `[data-theme="light"]` is applied to `<html>`:
```css
[data-theme="light"] {
  --bg:   #f0f2f9;
  --bg2:  #ffffff;
  --bg3:  #f5f6fa;
  --sb:   #1e2235;   /* Sidebar stays dark in light mode */
  --bdr:  #e2e5f0;
  --card: #ffffff;
  --card2:#f8f9fe;
  --tx:   #1a1d2e;
  --tx2:  #5a607a;
  --tx3:  #9ba3c0;
}
```

### Shortened CSS Class Names

To avoid JavaScript string parsing issues with apostrophes, all CSS classes use abbreviated names:

| Class | Full Name | Used For |
|---|---|---|
| `.az-sb` | AdminZone Sidebar | Sidebar container |
| `.az-main` | AdminZone Main | Main content area |
| `.az-top` | AdminZone Topbar | Top navigation bar |
| `.az-body` | AdminZone Body | Page content container |
| `.nav-btn` | Nav Button | Sidebar navigation item |
| `.sc` | Stat Card | Dashboard KPI card |
| `.si` | Stat Icon | Icon container on stat card |
| `.sv` | Stat Value | Number on stat card |
| `.badge` | Badge | Status/role labels |
| `.mo` | Modal | Modal overlay |
| `.mo-box` | Modal Box | Modal content box |
| `.mo-hd` | Modal Header | Modal title row |
| `.pgn` | Pagination | Pagination container |

### Typography

- **Font family:** Inter (Google Fonts)
- **Weights loaded:** 300, 400, 500, 600, 700, 800
- **Base font size:** 14px–15px
- **Headings:** 16px–22px

### Responsive Breakpoints

```css
/* Mobile */
@media (max-width: 768px) {
  .az-sb { transform: translateX(-100%); }  /* Sidebar hidden off-screen */
  .az-main { margin-left: 0; width: 100%; } /* Full width content */
}
```

On mobile, the sidebar is hidden by default. A hamburger menu button appears in the top bar to open/close it.

---

## JavaScript Architecture

All JavaScript is written as plain ES5/ES6 in a single `<script>` tag at the bottom of `<body>`. Functions are declared at the **global scope** (not wrapped in an IIFE) so they can be called directly from HTML `onclick` attributes.

### Module Grouping (by function name prefix)

| Group | Functions | Purpose |
|---|---|---|
| **DB** | `DB.get/set/del` | localStorage abstraction object |
| **Helpers** | `uid, ini, fmtDate, fmtTime, roleBadge, statBadge` | Utility functions |
| **UI** | `toast, confirm2, openMo, closeMo, logAct` | UI feedback and modals |
| **Data Init** | `initDemo` | Seeds default data on first run |
| **Auth** | `switchTab, doLogin, doSignup, doLogout, startApp, checkSession` | Login/session management |
| **Navigation** | `goPg, updateCounts, toggleSB, closeSB, globalSearch` | SPA routing and layout |
| **Dashboard** | `renderDash, buildChart` | Dashboard page rendering |
| **Users** | `renderUsers, openUserMod, editUser, saveUser, delUser, userPg` | User CRUD |
| **Notices** | `renderNotices, addNotice, delNotice` | Notice management |
| **Posts** | `renderPosts, openPostMod, editPost, viewPost, savePost, delPost, postPg` | Post CRUD |
| **Shoutbox** | `renderShouts, sendShout, shoutKey, clearShouts` | Chat board |
| **Profile** | `renderProfile, savePr, changePw` | Profile editing |
| **Settings** | `renderSettings, applyTheme, toggleTheme, exportData, resetDemo, clearAll` | App settings |
| **Init** | IIFE at bottom | Bootstrap on page load |

---

## Data Layer (localStorage)

AdminZone uses the browser's `localStorage` as its database. There is no backend, no API, and no server.

### Storage Keys

| Key | Type | Description |
|---|---|---|
| `az_users` | JSON Array | All user accounts |
| `az_posts` | JSON Array | All blog/content posts |
| `az_notices` | JSON Array | All notice board items |
| `az_shouts` | JSON Array | All shoutbox messages |
| `az_activity` | JSON Array | Activity log entries |
| `az_session` | JSON Object | Current logged-in user |
| `az_theme` | String | `"dark"` or `"light"` |

### DB Object (Data Access Layer)

```javascript
var DB = {
  get: function(key) {
    try { return JSON.parse(localStorage.getItem(key)) || []; }
    catch(e) { return []; }
  },
  set: function(key, val) {
    localStorage.setItem(key, JSON.stringify(val));
  },
  del: function(key) {
    localStorage.removeItem(key);
  }
};
```

### User Object Schema

```json
{
  "id": "u_1738000000000",
  "name": "Super Admin",
  "username": "superadmin",
  "email": "admin@adminzone.com",
  "password": "admin123",
  "role": "Admin",
  "status": "active",
  "joined": "2026-02-10",
  "bio": "System administrator",
  "phone": "+1 555 0100",
  "avatar": "SA"
}
```

### Post Object Schema

```json
{
  "id": "p_1738000000001",
  "title": "Getting Started with AdminZone",
  "content": "Full post content here...",
  "category": "Tutorial",
  "status": "Published",
  "author": "Super Admin",
  "date": "2026-02-10"
}
```

### Notice Object Schema

```json
{
  "id": "n_1738000000002",
  "title": "System Maintenance Tonight",
  "content": "Scheduled maintenance from 2:00 AM to 4:00 AM.",
  "priority": "High",
  "date": "2026-02-10",
  "author": "Super Admin"
}
```

### Shout Object Schema

```json
{
  "id": "sh_1738000000003",
  "text": "Hello everyone!",
  "author": "Super Admin",
  "avatar": "SA",
  "time": "10:30 AM"
}
```

### Activity Log Schema

```json
{
  "id": "a_1738000000004",
  "msg": "User Jane Mod was created",
  "time": "10:30 AM",
  "date": "Feb 10, 2026",
  "icon": "fa-user-plus",
  "color": "var(--gn)"
}
```

---

## Authentication System

### Login Flow

```
User enters email + password
        ↓
doLogin() called
        ↓
Read az_users from localStorage
        ↓
Find user where email AND password match
        ↓
If found:
  - Save user object to az_session
  - Log activity "Logged in"
  - Call startApp()
    - Hide #ls (login screen)
    - Show #app (dashboard)
    - Render dashboard
If not found:
  - Show toast "Invalid credentials"
```

### Signup Flow

```
User enters name + email + password
        ↓
doSignup() called
        ↓
Check if email already exists in az_users
        ↓
If email taken: Show toast error
If new:
  - Create user object with role "User"
  - Push to az_users
  - Auto-login (save to az_session)
  - Start app
```

### Session Management

- Session stored in `localStorage.getItem('az_session')`
- `checkSession()` runs on every page load
- If session found → `startApp()` auto-logs in
- `doLogout()` clears `az_session` and shows login screen

---

## How to Customize

### Change the Brand Name & Logo

In `index.html`, find:
```html
<div class="sb-logo">
  <div class="logo-ico"><i class="fas fa-shield-halved"></i></div>
  <span>AdminZone</span>
</div>
```
Replace `fa-shield-halved` with any Font Awesome icon, and `AdminZone` with your brand name.

### Change the Color Scheme

In the `<style>` block, modify the CSS variables in `:root`:
```css
:root {
  --pr:  #6366f1;   /* Change this to your primary color */
  --pr2: #818cf8;   /* Change this to a lighter shade */
}
```

### Add a New Page

1. Add a nav button in the sidebar:
```html
<button class="nav-btn" onclick="goPg('mypage', this)">
  <i class="fas fa-star"></i><span>My Page</span>
</button>
```

2. Add the page div in `.az-body`:
```html
<div id="mypage" class="pg" style="display:none">
  <h2>My Page</h2>
  <!-- your content -->
</div>
```

3. Add a render function in the `<script>`:
```javascript
function renderMypage() {
  document.getElementById('mypage').innerHTML = '...';
}
```

4. Add a case in `goPg()`:
```javascript
case 'mypage': renderMypage(); break;
```

### Change Default Demo Data

Find the `initDemo()` function in the `<script>` block. It contains arrays for users, posts, notices, and shouts. Modify these to match your use case.

### Add a New User Role

In `openUserMod()` and the user modal HTML, find the role select:
```html
<select id="uRole">
  <option>Admin</option>
  <option>Moderator</option>
  <option>User</option>
</select>
```
Add your new role as an `<option>`.

---

## Competitive Analysis & Design Decisions

AdminZone was designed after analyzing three leading admin dashboard templates:

### Tabler (tabler.io)
- **Takeaways:** Clean minimal UI, welcome hero card, KPI sparklines, breadcrumbs
- **Applied to AdminZone:** Dark/light theme system, indigo accent palette, clean card layout

### AdminLTE 3 (adminlte.io)
- **Takeaways:** Rich feature set, colored stat cards, Chart.js integration, to-do lists, full sidebar nav, chat widget
- **Applied to AdminZone:** Chart.js bar chart on dashboard, colored stat card icons, paginated data tables, shoutbox as chat widget

### CoreUI (coreui.io)
- **Takeaways:** Component library approach, consistent spacing system, badge system
- **Applied to AdminZone:** Consistent badge design (role badges, status badges, priority badges), spacing system via CSS variables

---

## MoSCoW Feature Breakdown

### Must Have (Implemented)
- [x] Responsive layout (mobile sidebar, flexible grid)
- [x] Login / Signup with session persistence
- [x] Dashboard with KPI cards and bar chart
- [x] User management with full CRUD
- [x] Notice board with priority levels
- [x] Posts manager with status management
- [x] Shoutbox / message board
- [x] Profile editing
- [x] Dark / Light mode toggle
- [x] Toast notifications
- [x] Confirmation dialogs

### Should Have (Implemented)
- [x] Activity log feed on dashboard
- [x] Search / filter on Users and Posts tables
- [x] Paginated data tables
- [x] Export data as JSON
- [x] Reset demo data function
- [x] Real-time clock in top bar
- [x] Global search bar
- [x] Live notice ticker

### Could Have (Future Enhancements)
- [ ] Audit Log / Activity Timeline — dedicated page for all admin actions
- [ ] Role-Based Access Control (RBAC) — hide actions from non-admin users
- [ ] Inline Post Editor — markdown preview / rich text editor
- [ ] Bulk Actions — checkboxes and bulk delete/status change
- [ ] Dashboard Welcome Card — personalized hero widget
- [ ] Data visualization — additional chart types (pie, line, area)
- [ ] Notification system — bell icon with unread count
- [ ] Calendar view for events and scheduling

---

## Browser Support

| Browser | Version | Status |
|---|---|---|
| Chrome | 90+ | Fully supported |
| Firefox | 88+ | Fully supported |
| Safari | 14+ | Fully supported |
| Edge | 90+ | Fully supported |
| Opera | 76+ | Fully supported |
| IE 11 | — | Not supported |

**Minimum requirements:** Support for `CSS Custom Properties`, `localStorage`, `Array.from`, `JSON.parse/stringify`.

---

## Deployment

### GitHub Pages (Current)
The project is deployed on GitHub Pages from the `master` branch root directory.

```
Settings → Pages → Source: Deploy from branch
Branch: master / (root)
```

Live URL: https://ansumansahoo.github.io/adminzone/

### Any Static Host
Since this is a single HTML file, it can be deployed to:
- **Netlify** — drag and drop the `index.html` file
- **Vercel** — connect the GitHub repo
- **Cloudflare Pages** — connect the GitHub repo
- **AWS S3** — upload to an S3 bucket with static website hosting
- **Any web server** — just copy `index.html` to the web root

---

## FAQ

**Q: Does this require a database?**
A: No. All data is stored in the browser's `localStorage`. There is no backend database.

**Q: Can multiple users use this simultaneously?**
A: Not out of the box — localStorage is per-browser. To support multiple concurrent users, you would need to replace the `DB` object with API calls to a backend service (e.g., Supabase, Firebase, a REST API).

**Q: Is the data persistent across sessions?**
A: Yes — localStorage persists until the user clears their browser data. Data survives page refreshes and browser restarts.

**Q: How do I reset to factory defaults?**
A: Go to **Settings** and click **"Reset Demo Data"**. This clears all data and re-seeds the original demo users, posts, notices, and shouts.

**Q: Can I export my data?**
A: Yes — go to **Settings** and click **"Export Data"**. It downloads a JSON file with all users, posts, notices, shouts, and activity logs.

**Q: How do I add it to my existing project?**
A: Copy the entire `<style>` block for the CSS design system and copy individual JavaScript functions as needed. The modular function grouping makes it easy to extract specific features.

**Q: Why are CSS class names so short?**
A: Shortened names like `.az-sb` and `.sc` were used to avoid JavaScript string parsing issues that can occur when apostrophes appear inside template literals. This keeps the entire file safely parseable as a single JS string during development.

---

## Tech Stack

| Technology | Version | Purpose |
|---|---|---|
| HTML5 | — | Structure and markup |
| CSS3 | — | Styling and animations |
| JavaScript (ES6) | — | All application logic |
| Chart.js | 4.4.0 | Dashboard bar chart |
| Font Awesome | 6.5.0 | Icons throughout UI |
| Inter (Google Fonts) | — | Typography |
| localStorage API | — | Data persistence |
| GitHub Pages | — | Hosting |

---

## License

This project is open source and available under the MIT License.

---

## Author

Built by **Ansumansahoo**
- GitHub: https://github.com/Ansumansahoo
- Repo: https://github.com/Ansumansahoo/adminzone

---

*AdminZone — A premium admin dashboard template. Built fast, runs everywhere.*
