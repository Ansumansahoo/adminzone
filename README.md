# AdminZone — Premium Admin Dashboard

![AdminZone Banner](https://img.shields.io/badge/AdminZone-Premium%20Dashboard-6366f1?style=for-the-badge&logo=data:image/svg+xml;base64,PHN2ZyB4bWxucz0iaHR0cDovL3d3dy53My5vcmcvMjAwMC9zdmciIHZpZXdCb3g9IjAgMCAyNCAyNCI+PHBhdGggZmlsbD0id2hpdGUiIGQ9Ik0xMiAyQzYuNDggMiAyIDYuNDggMiAxMnM0LjQ4IDEwIDEwIDEwIDEwLTQuNDggMTAtMTBTMTcuNTIgMiAxMiAyem0tMiAxNEg4di02aDJ2NnptNCAwaC0yVjhoMnY4eiIvPjwvc3ZnPg==)
[![Live Demo](https://img.shields.io/badge/Live%20Demo-ansumansahoo.github.io-ec4899?style=flat-square)](https://ansumansahoo.github.io/adminzone/)
[![GitHub](https://img.shields.io/badge/GitHub-Ansumansahoo%2Fadminzone-181717?style=flat-square&logo=github)](https://github.com/Ansumansahoo/adminzone)
[![License](https://img.shields.io/badge/license-MIT-06b6d4?style=flat-square)](LICENSE)
![No Build](https://img.shields.io/badge/build-none%20required-22c55e?style=flat-square)
![Single File](https://img.shields.io/badge/architecture-single%20file-f59e0b?style=flat-square)

> **A fully-featured, zero-dependency admin dashboard built in a single `index.html` file.** Dark/light theme, CRUD operations, role-based access control, markdown post editor, bulk actions, audit log, real-time clock — all running on localStorage with no backend, no build step, no npm install.

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
11. [Authentication & RBAC](#authentication--rbac)
12. [New Features Deep Dive](#new-features-deep-dive)
13. [How to Customize](#how-to-customize)
14. [Competitive Analysis & Design Decisions](#competitive-analysis--design-decisions)
15. [MoSCoW Feature Breakdown](#moscow-feature-breakdown)
16. [Browser Support](#browser-support)
17. [Deployment](#deployment)
18. [FAQ](#faq)
19. [Tech Stack](#tech-stack)
20. [License](#license)

---

## Live Demo

| URL | Description |
|-----|-------------|
| [ansumansahoo.github.io/adminzone/](https://ansumansahoo.github.io/adminzone/) | Production live demo |
| [github.com/Ansumansahoo/adminzone](https://github.com/Ansumansahoo/adminzone) | Source repository |

**Login credentials for the demo:**

| Email | Password | Role |
|-------|----------|------|
| `admin@adminzone.com` | `admin123` | Super Admin |
| `mod@adminzone.com` | `mod123` | Moderator |
| `user@adminzone.com` | `user123` | User (read-only) |

---

## Features

### Dashboard
- Personalized **Welcome Card** with live stats, today's date, and quick-action buttons
- Stats cards: Total Users, Total Posts, Total Notices, Total Shouts
- Interactive **bar chart** for post activity (pure CSS + JS, no chart library)
- Recent activity feed with timestamped entries
- Real-time clock in the header

### User Management
- Full **CRUD**: add, edit, delete users
- Role assignment: Admin, Moderator, User
- Status toggling: Active / Inactive
- **Bulk actions**: select multiple users → bulk delete or bulk status change
- Per-row checkboxes with a select-all header checkbox
- Role badge coloring: indigo (Admin), cyan (Moderator), slate (User)

### Audit Log *(new)*
- Dedicated page showing a **chronological activity timeline**
- Color-coded action tags: LOGIN (green), CREATED (indigo), EDITED (amber), DELETED (red)
- Filter timeline by action type via dropdown
- Live count of displayed entries

### Posts Manager
- Full **CRUD** for posts with title, category, content, and status
- **Markdown Post Editor** with split-pane layout:
  - **Write** pane: textarea with toolbar buttons
  - **Preview** pane: live-rendered HTML
  - Toolbar: H2, H3, Bold, Italic, Bullet List, Numbered List, Code block, Blockquote
- **Bulk actions**: select multiple posts → bulk delete or bulk status change
- Status: Published / Draft

### Notice Board
- Add/delete notices with priority: High, Medium, Low
- Priority badge coloring

### Shoutbox
- Public message board
- Add and delete shouts in real time (localStorage)
- Relative timestamps ("2 min ago")

### Role-Based Access Control (RBAC) *(new)*
- Three roles with different UI permissions:
  - **Admin**: full access — add, edit, delete, bulk delete everything
  - **Moderator**: can view and edit, but cannot add users, delete anything, or use bulk delete
  - **User**: read-only — no add/edit/delete buttons visible
- RBAC applied immediately on login via `applyRBAC(session)`

### Profile & Settings
- Edit display name, email, avatar initial
- Toggle dark / light theme (persisted to localStorage)
- Danger zone: reset all demo data

---## Project Architecture

AdminZone is intentionally built as a **single `index.html` file** — no bundler, no framework, no server. Everything — HTML, CSS, and JavaScript — lives in one file.

### Why a single file?

| Concern | Answer |
|---------|--------|
| Portability | Open it on any device — USB stick, email, file share — it just works |
| Zero dependencies | No npm, no node_modules, no build pipeline to maintain |
| GitHub Pages compatible | Push once, live forever with no CI/CD required |
| Learning-friendly | All logic visible and greppable in one place |
| Performance | Single HTTP request for the app shell; CDN for fonts only |

### High-Level Architecture

```
index.html
├── <head>
│   ├── Google Fonts (Inter) — only external resource
│   └── <style> — all CSS (~23,000 chars)
└── <body>
    ├── Sidebar navigation (#sidebar)
    ├── Main content area (#main)
    │   ├── Header (clock, theme toggle, user avatar)
    │   ├── Login screen (#ls)
    │   ├── Dashboard (#dash)
    │   │   └── Welcome Card (#wcWrap)
    │   ├── Users (#users)
    │   ├── Notice Board (#notices)
    │   ├── Posts (#posts)
    │   ├── Shoutbox (#shoutbox)
    │   ├── Profile (#profile)
    │   ├── Audit Log (#pg-audit)
    │   └── Settings (#settings)
    └── Modals
        ├── User Modal (#uMod)
        ├── Post Modal (#pMod) — with markdown editor
        ├── View Modal (#vMod)
        └── Confirm Dialog (#cfMod)
    └── <script> — all JavaScript (~67,000 chars)
```

### Data Flow

```
User action → Event listener → DB helper → localStorage
                                    ↓
                           Re-render function
                                    ↓
                           innerHTML update → DOM
```

No virtual DOM. No state management library. Plain JS with direct DOM manipulation.

---

## Getting Started

### Option 1 — View online

Visit [ansumansahoo.github.io/adminzone/](https://ansumansahoo.github.io/adminzone/) — no setup needed.

### Option 2 — Run locally

```bash
# Clone the repository
git clone https://github.com/Ansumansahoo/adminzone.git
cd adminzone

# Open in browser (no server needed)
open index.html

# OR on Windows:
start index.html
```

### Option 3 — Fork & deploy your own

1. Fork [Ansumansahoo/adminzone](https://github.com/Ansumansahoo/adminzone)
2. Go to **Settings → Pages**
3. Set source: **Deploy from a branch** → **master** → **/ (root)**
4. Your site will be live at `https://<your-username>.github.io/adminzone/`

---

## Demo Credentials

### Primary admin account

| Field | Value |
|-------|-------|
| Email | `admin@adminzone.com` |
| Password | `admin123` |
| Role | Super Admin |
| Name | Super Admin |

### Additional demo users (seeded automatically)

| Name | Email | Password | Role | Status |
|------|-------|----------|------|--------|
| Moderator User | `mod@adminzone.com` | `mod123` | Moderator | Active |
| Regular User | `user@adminzone.com` | `user123` | User | Active |
| Inactive User | `inactive@adminzone.com` | `inactive123` | User | Inactive |

> All demo data is stored in `localStorage`. Use **Settings → Reset Demo Data** to restore to factory defaults.

---

## Pages & Functionality

### 1. Login Screen (`#ls`)

The login screen is shown whenever no valid session exists in localStorage.

**Features:**
- Email + password authentication
- "Remember me" checkbox (extends session)
- Toggle to signup form for new account creation
- Demo credentials hint displayed below the form

**Technical notes:**
- Passwords are stored in plain text (demo only — not for production)
- Session stored as JSON in `localStorage` under key `az_session`
- On login, `applyRBAC(session)` immediately configures the UI for the user's role

---

### 2. Dashboard (`#dash`)

The main overview page after login.

**Welcome Card (`#wcWrap`)**

A gradient hero card at the top of the dashboard that shows:
- Personalized greeting: "Welcome back, [Name]! 👋"
- Today's date in long format (e.g., "Sunday, May 11, 2026")
- Live stats: Active Users, Published Posts, Active Notices
- Three quick-action buttons: Manage Users, New Post, View Audit Log

The quick-action buttons use `data-wc-go` attributes and an event listener (no inline onclick) to navigate to the corresponding page.

**Stats Row**

Four cards showing totals: Users, Posts, Notices, Shouts.

**Bar Chart**

A pure CSS/JS bar chart showing post-count-by-category. No external chart libraries.

**Recent Activity**

Last 10 activity log entries from `az_activity` localStorage key, rendered as a feed.

---

### 3. Users (`#users`)

Full user management with RBAC-aware UI.

**Features:**
- Table with: avatar initial, name, email, role badge, status badge, joined date, action buttons
- Add User modal (Admin only — hidden for Moderators and Users)
- Edit user inline via modal
- Delete user (Admin only)
- **Bulk Actions bar** — appears when one or more checkboxes are selected:
  - Bulk Delete (Admin only)
  - Set Active / Set Inactive
- Select-all checkbox in table header
- Pagination (10 users per page)

**RBAC visibility rules:**

| Element | Admin | Moderator | User |
|---------|-------|-----------|------|
| Add User button | Visible | Hidden | Hidden |
| Edit button | Visible | Visible | Hidden |
| Delete button | Visible | Hidden | Hidden |
| Bulk Delete | Visible | Hidden | Hidden |
| Bulk Status | Visible | Visible | Hidden |

---

### 4. Notice Board (`#notices`)

Simple announcements board.

**Features:**
- Add notices with title, content, and priority (High / Medium / Low)
- Delete notices
- Priority badges color-coded: red (High), amber (Medium), green (Low)
- Notices sorted by creation time (newest first)

---

### 5. Posts (`#posts`)

Blog-post style content management with Markdown editor.

**Features:**
- Table with: title, category, status badge, author, date, action buttons
- Add / Edit post via modal
- View post (read-only preview)
- Delete post (Admin only)
- **Bulk Actions bar**: bulk delete or bulk status change
- **Markdown Editor** (split-pane inside the modal):
  - Left pane: `<textarea id="pContent">` for writing
  - Right pane: `<div id="mdPrev">` for live preview
  - Toolbar buttons: H2, H3, Bold, Italic, Bullet List, Numbered List, Code, Quote
  - Preview updates on every keystroke

**Markdown syntax supported:**

| Syntax | Output |
|--------|--------|
| `## Heading` | `<h2>` |
| `### Heading` | `<h3>` |
| `**bold**` | `<strong>` |
| `*italic*` | `<em>` |
| `- item` | `<ul><li>` |
| `1. item` | `<ol><li>` |
| `\`code\`` | `<code>` |
| `> quote` | `<blockquote>` |
| Blank line | New paragraph |

---

### 6. Shoutbox (`#shoutbox`)

Public real-time message board (localStorage-backed).

**Features:**
- Post new shouts with your display name
- Delete any shout
- Relative timestamps ("just now", "5 min ago", "2 hr ago")
- Newest shouts appear at top

---

### 7. Audit Log (`#pg-audit`)

A full chronological activity timeline.

**Features:**
- Every login, CRUD operation, and status change is logged to `az_activity`
- Timeline view with icon + description + timestamp
- Color-coded action tags:
  - 🟢 **LOGIN** — green
  - 🟣 **CREATED** — indigo
  - 🟡 **EDITED** — amber
  - 🔴 **DELETED** — red
- Filter dropdown (`#audFlt`): All Actions, LOGIN, CREATED, EDITED, DELETED
- Entry count display (`#audCt`)

---

### 8. Profile (`#profile`)

User account settings.

**Features:**
- Edit display name and email
- Avatar initial auto-generated from name
- Shows current role and account status

---

### 9. Settings (`#settings`)

App-wide preferences.

**Features:**
- **Dark / Light theme toggle** — persisted to `localStorage` (`az_theme`)
- **Reset Demo Data** — clears all localStorage and re-seeds factory data (with confirmation dialog)

---## Code Structure

The entire application is one file (`index.html`), approximately **91,000 characters** (as of the latest commit). Here is how it is organized internally:

```
index.html (~91,000 chars)
│
├── Lines 1-2       DOCTYPE + <html lang="en">
├── Lines 3-10      <head> — meta tags, title, Google Fonts link
├── Lines 11-750    <style> — all CSS (23,000+ chars)
│                   ├── CSS custom properties (color tokens, spacing)
│                   ├── Reset + base styles
│                   ├── Layout: sidebar, main, header
│                   ├── Component styles: cards, tables, badges, buttons
│                   ├── Form + modal styles
│                   ├── New: .wc-* (Welcome Card)
│                   ├── New: .aud-* (Audit Log timeline)
│                   ├── New: .md-* (Markdown editor)
│                   ├── New: .bulk-bar, .chk-* (Bulk Actions)
│                   └── Responsive media queries
│
├── Lines 751-900   <body> structure
│                   ├── #sidebar — navigation links
│                   ├── #main — content wrapper
│                   │   ├── #hdr — header bar
│                   │   ├── #ls — login screen
│                   │   ├── #dash — dashboard
│                   │   ├── #users — user table
│                   │   ├── #notices — notice board
│                   │   ├── #posts — posts table
│                   │   ├── #shoutbox — shout feed
│                   │   ├── #profile — profile form
│                   │   ├── #pg-audit — audit log timeline (new)
│                   │   └── #settings — settings form
│                   └── Modals: #uMod, #pMod, #vMod, #cfMod
│
└── Lines 901-end   <script> — all JavaScript (~67,000 chars)
                    ├── DB helpers (get, set, del, getObj)
                    ├── initDemo() — seed factory data
                    ├── Auth: doLogin(), doSignup(), doLogout()
                    ├── applyRBAC() — hide/show elements by role (new)
                    ├── Navigation: goPg(), goPageByName()
                    ├── Clock: updateClock()
                    ├── Dashboard: renderDash(), renderWelcomeCard() (new)
                    ├── Users CRUD: renderUsers(), addUser(), editUser(), delUser()
                    ├── Bulk Users: bulkDelUsers(), bulkStatusUsers() (new)
                    ├── Posts CRUD: renderPosts(), addPost(), editPost(), delPost()
                    ├── Markdown: parseMd(), updatePreview() (new)
                    ├── Bulk Posts: bulkDelPosts(), bulkStatusPosts() (new)
                    ├── Notices CRUD: renderNotices(), addNotice(), delNotice()
                    ├── Shoutbox: renderShouts(), addShout(), delShout()
                    ├── Audit Log: renderAudit(), auditTag() (new)
                    ├── Profile: renderProfile(), saveProfile()
                    ├── Settings: renderSettings()
                    └── init() — entry point called on DOMContentLoaded
```

---

## CSS Design System

### Color Tokens (CSS Custom Properties)

#### Dark Theme (default)

```css
:root {
  --bg: #0f1117;      /* Page background */
  --sb: #161b27;      /* Sidebar background */
  --cd: #1e2435;      /* Card / panel background */
  --br: #2a3148;      /* Border color */
  --tx: #e2e8f0;      /* Primary text */
  --t2: #94a3b8;      /* Secondary text */
  --pr: #6366f1;      /* Primary accent (indigo) */
  --sc: #ec4899;      /* Secondary accent (pink) */
  --gn: #22c55e;      /* Success / active green */
  --rd: #ef4444;      /* Danger / delete red */
  --am: #f59e0b;      /* Warning / amber */
  --cy: #06b6d4;      /* Cyan — Moderator badge, audit icons */
}
```

#### Light Theme

```css
body.light {
  --bg: #f0f2f9;
  --sb: #ffffff;
  --cd: #ffffff;
  --br: #e2e8f0;
  --tx: #1e293b;
  --t2: #64748b;
}
```

### Shortened CSS Class Names

AdminZone uses abbreviated class names to keep file size small:

| Class | Meaning |
|-------|---------|
| `.cd` | Card container |
| `.btn` | Base button |
| `.btn-p` | Primary button (indigo) |
| `.btn-d` | Danger button (red) |
| `.btn-s` | Success button (green) |
| `.btn-o` | Outline button |
| `.bdg` | Badge (inline chip) |
| `.tbl` | Data table |
| `.frm` | Form container |
| `.inp` | Input / select |
| `.mod` | Modal overlay |
| `.mod-bx` | Modal box / dialog |
| `.toast` | Toast notification |
| `.wc` | Welcome Card hero |
| `.aud-item` | Audit log timeline entry |
| `.aud-tag` | Audit action tag badge |
| `.md-wrap` | Markdown editor split-pane |
| `.md-tb` | Markdown toolbar |
| `.bulk-bar` | Bulk-action floating bar |
| `.chk` | Checkbox cell in table |

### Typography

- **Font family**: Inter (Google Fonts CDN — the only external resource)
- **Base size**: 15px
- **Weights used**: 400 (body), 500 (labels), 600 (headings), 700 (badges)

### Responsive Breakpoints

| Breakpoint | Behavior |
|-----------|---------|
| `> 900px` | Full sidebar + main side by side |
| `≤ 900px` | Sidebar collapses to icon-only strip |
| `≤ 600px` | Tables scroll horizontally; stats stack vertically |

---

## JavaScript Architecture

The JavaScript section (~67,000 chars) is organized into logical groups by function name prefix. There are no classes or modules — everything is plain function declarations in a single `<script>` tag.

### Function Groups

| Prefix / Name | Purpose |
|---------------|---------|
| `DB.*` | Data access layer — thin wrapper around localStorage JSON |
| `initDemo()` | Seeds factory data if localStorage is empty |
| `doLogin()` | Validates credentials, writes session, calls `applyRBAC()` |
| `doSignup()` | Creates new user account |
| `doLogout()` | Clears session, returns to login screen |
| `applyRBAC()` | Reads session role and shows/hides buttons accordingly |
| `goPg(id)` | Switches the visible page div, updates sidebar active state |
| `goPageByName(name)` | Navigates by human name (e.g. "users") — used by Welcome Card |
| `updateClock()` | Updates header clock every second |
| `renderDash()` | Renders stats, chart, and activity feed |
| `renderWelcomeCard()` | Renders personalized hero with live stats |
| `renderUsers(pg)` | Renders paginated user table with checkboxes |
| `addUser()` | Opens add-user modal with empty form |
| `editUser(id)` | Opens edit-user modal pre-filled |
| `saveUser()` | Saves user from modal (add or edit) |
| `delUser(id)` | Opens confirm dialog then deletes user |
| `toggleAllUsers(el)` | Select-all checkbox handler for users table |
| `bulkDelUsers()` | Deletes all selected users (Admin only) |
| `bulkStatusUsers(s)` | Sets status for all selected users |
| `renderPosts(pg)` | Renders paginated posts table with checkboxes |
| `addPost()` | Opens add-post modal with empty markdown editor |
| `editPost(id)` | Opens edit-post modal with existing content |
| `savePost()` | Saves post from modal (add or edit) |
| `delPost(id)` | Opens confirm dialog then deletes post |
| `toggleAllPosts(el)` | Select-all checkbox for posts table |
| `bulkDelPosts()` | Deletes all selected posts (Admin only) |
| `bulkStatusPosts(s)` | Sets status for all selected posts |
| `parseMd(text)` | Converts markdown text to safe HTML |
| `updatePreview()` | Reads textarea and calls parseMd, updates #mdPrev |
| `mdInsert(before,after)` | Inserts markdown syntax around selected text |
| `renderNotices()` | Renders notice board |
| `addNotice()` | Adds new notice |
| `delNotice(id)` | Deletes notice |
| `renderShouts()` | Renders shoutbox feed |
| `addShout()` | Posts new shout |
| `delShout(id)` | Deletes shout |
| `renderAudit()` | Renders audit log timeline with optional filter |
| `auditTag(msg)` | Classifies activity message → LOGIN/CREATED/EDITED/DELETED |
| `renderProfile()` | Renders profile form |
| `saveProfile()` | Saves profile changes |
| `renderSettings()` | Renders settings page |
| `toast(msg)` | Shows a floating toast notification for 3 seconds |
| `showModal(id)` / `closeModal(id)` | Opens/closes a modal overlay |
| `confirm(msg, fn)` | Shows confirm dialog, calls `fn` if confirmed |
| `log(msg)` | Appends entry to `az_activity` |
| `init()` | Bootstrap — called on DOMContentLoaded |

### Event Delegation Pattern

To avoid issues with quote-escaping inside dynamically generated `innerHTML`, AdminZone uses **data attributes + event delegation** for all action buttons in tables:

```javascript
// Instead of:
td.innerHTML = '<button onclick="editUser(' + id + ')">Edit</button>';

// We use:
td.innerHTML = '<button data-edit-user="' + id + '">Edit</button>';

// Then after innerHTML is set:
wrap.querySelectorAll('[data-edit-user]').forEach(btn => {
  btn.addEventListener('click', () => editUser(btn.dataset.editUser));
});
```

This pattern is used for all dynamic tables. Data attributes used:

| Attribute | Handler |
|-----------|---------|
| `data-edit-user` | `editUser(id)` |
| `data-del-user` | `delUser(id)` |
| `data-sel-user` | User checkbox selection |
| `data-view-post` | `viewPost(id)` |
| `data-edit-post` | `editPost(id)` |
| `data-del-post` | `delPost(id)` |
| `data-sel-post` | Post checkbox selection |
| `data-del-notice` | `delNotice(id)` |
| `data-pg-u` | User pagination |
| `data-pg-p` | Post pagination |
| `data-wc-go` | Welcome Card quick-action navigation |

---## Data Layer (localStorage)

All data is persisted to the browser's `localStorage`. There is no backend, no API, and no database.

### Storage Keys

| Key | Type | Description |
|-----|------|-------------|
| `az_users` | JSON array | All user accounts |
| `az_posts` | JSON array | All posts |
| `az_notices` | JSON array | All notices |
| `az_shouts` | JSON array | All shoutbox messages |
| `az_activity` | JSON array | Audit log entries (max 200) |
| `az_session` | JSON object | Current logged-in session |
| `az_theme` | string | `"dark"` or `"light"` |

### DB Object (Data Access Layer)

```javascript
const DB = {
  get(key) {
    // Returns parsed JSON array from localStorage, or []
  },
  getObj(key) {
    // Returns parsed JSON object from localStorage, or null
  },
  set(key, value) {
    // JSON.stringify and store
  },
  del(key) {
    // Remove from localStorage
  }
};
```

### User Object Schema

```json
{
  "id": "u1234567890",
  "name": "Super Admin",
  "email": "admin@adminzone.com",
  "password": "admin123",
  "role": "Admin",
  "status": "Active",
  "joined": "2024-01-15T10:30:00.000Z"
}
```

### Post Object Schema

```json
{
  "id": "p1234567890",
  "title": "Getting Started with AdminZone",
  "category": "Tutorial",
  "content": "## Introduction\n\nThis is **markdown** content...",
  "status": "Published",
  "author": "Super Admin",
  "date": "2024-01-15T10:30:00.000Z"
}
```

### Notice Object Schema

```json
{
  "id": "n1234567890",
  "title": "System Maintenance Tonight",
  "content": "We will be down from 2-4 AM UTC.",
  "priority": "High",
  "date": "2024-01-15T10:30:00.000Z"
}
```

### Shout Object Schema

```json
{
  "id": "s1234567890",
  "name": "Super Admin",
  "msg": "Hello everyone!",
  "time": 1705312200000
}
```

### Activity Log Schema

```json
{
  "msg": "Admin logged in",
  "time": "2024-01-15T10:30:00.000Z"
}
```

Activity is logged by calling `log(msg)`. The log capped at the most recent 200 entries. The `auditTag(msg)` helper classifies a message string into one of: `LOGIN`, `CREATED`, `EDITED`, `DELETED`, or `OTHER` for color-coding in the timeline.

---

## Authentication & RBAC

### Login Flow

```
1. User submits email + password
2. doLogin() looks up user in az_users array
3. If match: write session to az_session, call applyRBAC(session)
4. applyRBAC() sets window._isAdmin and window._isMod flags
5. applyRBAC() hides/shows buttons based on role
6. Navigate to dashboard: goPg('dash')
7. log('Admin logged in') appended to az_activity
```

### Signup Flow

```
1. User fills in name, email, password
2. doSignup() checks for duplicate email
3. New user object created with role = 'User', status = 'Active'
4. Appended to az_users array in localStorage
5. Auto-login: session written, applyRBAC called
```

### Session Object

```json
{
  "id": "u1234567890",
  "name": "Super Admin",
  "email": "admin@adminzone.com",
  "role": "Admin"
}
```

Stored in `az_session`. On page load, `init()` reads this and either shows the dashboard or the login screen.

### RBAC — Role-Based Access Control

`applyRBAC(session)` is called immediately after login. It reads the `session.role` field and configures the UI:

```javascript
function applyRBAC(sess) {
  window._isAdmin = sess.role === 'Admin';
  window._isMod   = sess.role === 'Moderator';

  if (!window._isAdmin) {
    // Hide: Add User button, all Delete buttons, Bulk Delete
    document.querySelectorAll('#addUserBtn, .btn-d, #bulkDelUserBtn, #bulkDelPostBtn')
      .forEach(el => el.style.display = 'none');
  }
  if (!window._isAdmin && !window._isMod) {
    // Hide: Add Post, all Edit buttons
    document.querySelectorAll('#addPostBtn, .btn-edit')
      .forEach(el => el.style.display = 'none');
  }
}
```

RBAC is also re-applied after each `renderUsers()` and `renderPosts()` call, since those functions regenerate `innerHTML` and would otherwise re-insert hidden buttons.

**Role Permission Matrix:**

| Permission | Admin | Moderator | User |
|------------|-------|-----------|------|
| View all pages | ✅ | ✅ | ✅ |
| Add User | ✅ | ❌ | ❌ |
| Edit User | ✅ | ✅ | ❌ |
| Delete User | ✅ | ❌ | ❌ |
| Bulk Delete Users | ✅ | ❌ | ❌ |
| Bulk Status Users | ✅ | ✅ | ❌ |
| Add Post | ✅ | ✅ | ❌ |
| Edit Post | ✅ | ✅ | ❌ |
| Delete Post | ✅ | ❌ | ❌ |
| Bulk Delete Posts | ✅ | ❌ | ❌ |
| Bulk Status Posts | ✅ | ✅ | ❌ |
| Add Notice | ✅ | ✅ | ❌ |
| Delete Notice | ✅ | ❌ | ❌ |
| View Audit Log | ✅ | ✅ | ✅ |
| Reset Demo Data | ✅ | ❌ | ❌ |

---

## New Features Deep Dive

### 1. Dashboard Welcome Card

The Welcome Card is the first thing an admin sees after login. It is a gradient hero block rendered inside `#wcWrap` by `renderWelcomeCard()`.

**What it shows:**
- Personalized greeting with the user's display name
- Today's date formatted as "Weekday, Month DD, YYYY"
- Three live counters: Active Users, Published Posts, Active Notices
- Three quick-action navigation buttons

**How quick-actions work:**

```html
<button data-wc-go="users">Manage Users</button>
```

```javascript
document.querySelectorAll('[data-wc-go]').forEach(btn => {
  btn.addEventListener('click', () => goPageByName(btn.dataset.wcGo));
});
```

`goPageByName(name)` maps human names like "users" or "audit" to actual page IDs and calls `goPg()`.

---

### 2. Audit Log Timeline

The Audit Log page (`#pg-audit`) shows a timeline of all recorded activity.

**Activity is logged automatically** whenever a user logs in, creates, edits, or deletes any record.

**Timeline entry HTML structure:**

```html
<div class="aud-item">
  <div class="aud-icon">🖊</div>
  <div class="aud-body">
    <span class="aud-tag tag-edited">EDITED</span>
    <span class="aud-msg">Admin edited user John Doe</span>
    <span class="aud-time">May 11, 2026, 3:15 AM</span>
  </div>
</div>
```

**Tag classification by `auditTag(msg)`:**

```javascript
function auditTag(msg) {
  var m = msg.toLowerCase();
  if (m.indexOf('log') > -1) return 'LOGIN';
  if (m.indexOf('creat') > -1 || m.indexOf('add') > -1) return 'CREATED';
  if (m.indexOf('edit') > -1 || m.indexOf('updat') > -1 || m.indexOf('chang') > -1) return 'EDITED';
  if (m.indexOf('delet') > -1 || m.indexOf('remov') > -1) return 'DELETED';
  return 'OTHER';
}
```

**Filtering:** The dropdown (`#audFlt`) triggers `renderAudit()` with the selected value, which filters the activity array before rendering.

---

### 3. Markdown Post Editor

The post modal (`#pMod`) contains a split-pane markdown editor.

**HTML structure:**

```html
<div class="md-wrap">
  <div class="md-pane">
    <div class="md-tb">
      <!-- toolbar buttons with data-md-* attributes -->
    </div>
    <textarea id="pContent" oninput="updatePreview()"></textarea>
  </div>
  <div class="md-pane md-prev-pane">
    <div id="mdPrev"></div>
  </div>
</div>
```

**parseMd(text) — markdown parser:**

The parser uses safe regex patterns (character classes instead of backslash escapes) to handle the CM6 editor injection constraint:

```javascript
function parseMd(t) {
  // Split on blank lines for paragraphs
  var nl = String.fromCharCode(10);
  var ps = t.split(nl + nl);

  return ps.map(function(block) {
    // Headings
    if (/^[#][#][#] /.test(block)) return '<h3>' + block.slice(4) + '</h3>';
    if (/^[#][#] /.test(block))    return '<h2>' + block.slice(3) + '</h2>';
    if (/^[#] /.test(block))       return '<h1>' + block.slice(2) + '</h1>';

    // Lists
    if (/^[-] /.test(block))       return '<ul>' + block.split(nl).map(l => '<li>' + l.slice(2) + '</li>').join('') + '</ul>';
    if (/^[0-9][.] /.test(block))  return '<ol>' + block.split(nl).map(l => '<li>' + l.replace(/^[0-9]+[.] /,'') + '</li>').join('') + '</ol>';

    // Blockquote
    if (/^[>] /.test(block))       return '<blockquote>' + block.slice(2) + '</blockquote>';

    // Inline: bold, italic, code (character class patterns)
    var line = block
      .replace(/[*][*]([^*]+)[*][*]/g, '<strong>$1</strong>')
      .replace(/[*]([^*]+)[*]/g, '<em>$1</em>')
      .replace(/[`]([^`]+)[`]/g, '<code>$1</code>');

    return '<p>' + line + '</p>';
  }).join('');
}
```

**Toolbar buttons** use `mdInsert(before, after)` to wrap selected text:

```javascript
function mdInsert(before, after) {
  var ta = document.getElementById('pContent');
  var start = ta.selectionStart;
  var end = ta.selectionEnd;
  var sel = ta.value.substring(start, end);
  ta.value = ta.value.substring(0, start) + before + sel + after + ta.value.substring(end);
  updatePreview();
}
```

---

### 4. Bulk Actions

Both the Users table and Posts table support bulk operations.

**How it works:**

1. Each data row has a `<input type="checkbox" data-sel-user="id">` (or `data-sel-post`)
2. Checking a box adds the ID to `window._uSel[]` (or `window._pSel[]`)
3. When at least one item is selected, the `#uBulk` / `#pBulk` bar slides into view
4. The bar shows the count (`#uBulkCt` / `#pBulkCt`) and action buttons
5. Clicking a bulk action button calls the relevant function on all selected IDs
6. After the operation, selection is cleared and the table is re-rendered

**User bulk action bar HTML:**

```html
<div id="uBulk" class="bulk-bar" style="display:none">
  <span id="uBulkCt">0 selected</span>
  <button id="bulkDelUserBtn" onclick="bulkDelUsers()">Delete Selected</button>
  <button onclick="bulkStatusUsers('Active')">Set Active</button>
  <button onclick="bulkStatusUsers('Inactive')">Set Inactive</button>
</div>
```

---## How to Customize

### Change the Brand Name & Logo

Search for `AdminZone` in `index.html` and replace all instances with your brand name.

The logo in the sidebar is rendered as text. To change it:

```html
<!-- Find in sidebar HTML -->
<div class="logo">AdminZone</div>
```

### Change the Color Scheme

Edit the CSS custom properties in the `:root` block at the top of the `<style>` section:

```css
:root {
  --pr: #6366f1;   /* Change primary accent from indigo to any color */
  --sc: #ec4899;   /* Change secondary accent from pink to any color */
}
```

### Add a New Page

1. Add a nav link in `#sidebar`:
```html
<a href="#" onclick="goPg('mypage')">My Page</a>
```

2. Add the page div inside `#main`:
```html
<div id="mypage" class="pg" style="display:none">
  <h2>My Page</h2>
  <!-- content here -->
</div>
```

3. Add a `renderMyPage()` function in the `<script>` section.

4. In `goPg(id)`, add a case for your page:
```javascript
if (id === 'mypage') renderMyPage();
```

5. Add a localStorage key for your data in the DB section if needed.

### Change Default Demo Data

Edit the `initDemo()` function in the `<script>` section. This function runs once when localStorage is empty. Change the seed arrays to match your use case.

### Add a New User Role

1. Add the role name to the role `<select>` options in the User Modal.
2. Update `applyRBAC()` to handle the new role's permissions.
3. Add a badge color for the new role in the CSS.

---

## Competitive Analysis & Design Decisions

AdminZone was built after analyzing three leading open-source admin dashboard templates:

### Tabler (tabler.io)
**What they do well:** Clean, minimal Bootstrap-based design; excellent component library; strong documentation.
**Our take:** AdminZone borrows Tabler's color discipline and card-based layouts. We skip Bootstrap to keep the single-file constraint.

### AdminLTE 3 (adminlte.io)
**What they do well:** Feature-rich; sidebar with nested menus; many widget types; jQuery-based.
**Our take:** AdminLTE showed us that dashboards need a strong sidebar hierarchy. We added the section labels (MAIN, CONTENT, ADMIN) for the same navigational clarity, without jQuery.

### CoreUI (coreui.io)
**What they do well:** React/Angular/Vue versions; enterprise-grade; roles and permissions concept.
**Our take:** CoreUI's RBAC concept directly inspired our `applyRBAC()` implementation. Their split between "what you can see" (navigation) and "what you can do" (CRUD buttons) shaped our role permission matrix.

### Our Differentiators

| Feature | AdminZone | Tabler | AdminLTE | CoreUI |
|---------|-----------|--------|----------|--------|
| Single file | ✅ | ❌ | ❌ | ❌ |
| No npm/build | ✅ | ❌ | ❌ | ❌ |
| localStorage backend | ✅ | ❌ | ❌ | ❌ |
| RBAC built-in | ✅ | Partial | ❌ | ✅ |
| Markdown editor | ✅ | ❌ | ❌ | ❌ |
| Audit log | ✅ | ❌ | ❌ | Partial |
| Bulk actions | ✅ | ✅ | Partial | ✅ |
| Dark mode | ✅ | ✅ | Partial | ✅ |
| Zero dependencies | ✅ | ❌ | ❌ | ❌ |

---

## MoSCoW Feature Breakdown

### Must Have ✅ (All Implemented)

- [x] Login / Logout with session persistence
- [x] Dashboard with stats and charts
- [x] User CRUD (Create, Read, Update, Delete)
- [x] Notice Board CRUD
- [x] Dark / Light theme toggle
- [x] Responsive layout (mobile-friendly)
- [x] Toast notifications
- [x] Confirm dialogs for destructive actions

### Should Have ✅ (All Implemented)

- [x] Posts manager with CRUD
- [x] Shoutbox / message board
- [x] Profile page (edit name, email)
- [x] Settings page
- [x] Signup flow
- [x] Activity log (basic — shown on dashboard)
- [x] Pagination for tables
- [x] Role badges and status badges

### Could Have ✅ (All Implemented)

- [x] **Dashboard Welcome Card** — personalized hero with live stats and quick-action buttons
- [x] **Audit Log page** — dedicated timeline with action tags and filter dropdown
- [x] **Role-Based Access Control (RBAC)** — UI adapts to Admin / Moderator / User role
- [x] **Markdown Post Editor** — split-pane write + preview with toolbar
- [x] **Bulk Actions** — checkboxes, select-all, bulk delete / status change

### Won't Have (Out of scope for single-file demo)

- [ ] Real backend / database (by design — localStorage only)
- [ ] Email notifications (no server)
- [ ] File uploads (no server)
- [ ] Multi-tenant organizations
- [ ] Two-factor authentication
- [ ] Real-time collaborative editing
- [ ] Advanced chart library (Chart.js, D3)

---

## Browser Support

| Browser | Version | Support |
|---------|---------|---------|
| Chrome | 90+ | ✅ Full |
| Firefox | 88+ | ✅ Full |
| Safari | 14+ | ✅ Full |
| Edge | 90+ | ✅ Full |
| Opera | 76+ | ✅ Full |
| IE 11 | — | ❌ Not supported |

Requirements: ES6+ (arrow functions, template literals, `const`/`let`), `localStorage`, CSS custom properties.

---

## Deployment

### GitHub Pages (Current)

The repo is deployed via GitHub Pages (Settings → Pages → Deploy from master branch).

- No CI/CD pipeline needed
- Pushes to master auto-deploy in ~60 seconds
- Custom domain: configurable in Pages settings

### Any Static Host

Since AdminZone is a single HTML file with no build step:

```bash
# Netlify drop
# Drag & drop the index.html onto app.netlify.com/drop

# Vercel CLI
vercel --prod

# Amazon S3
aws s3 cp index.html s3://my-bucket/ --acl public-read

# Any web server
cp index.html /var/www/html/
```

### Progressive Web App (PWA)

To make it installable as a PWA, add a `manifest.json` and a `service-worker.js` alongside `index.html`. The app already functions offline since it has no API calls.

---

## FAQ

**Q: Can I use this in a real project?**
A: For internal tools, prototypes, or demos — absolutely. For production apps with real users, replace the localStorage layer with a real backend API.

**Q: Is the data secure?**
A: No — passwords are stored in plain text in localStorage. This is intentional for demo simplicity. For production, use a real auth system with hashed passwords and HTTPS.

**Q: Can I add more pages?**
A: Yes — see the "Add a New Page" section in How to Customize.

**Q: Why is everything in one file?**
A: Portability. Open it on a USB drive, email it, or drop it in any host — it works everywhere with no setup. See Project Architecture for the full reasoning.

**Q: How do I reset the data?**
A: Go to Settings → Reset Demo Data, or call `resetDemo()` in the browser console.

**Q: The data I added is gone after a browser restart.**
A: localStorage is persistent across restarts unless you clear browser data. Check your browser privacy settings.

**Q: Can I contribute?**
A: Yes — fork the repo, make changes, and open a pull request at [github.com/Ansumansahoo/adminzone](https://github.com/Ansumansahoo/adminzone).

---

## Tech Stack

| Layer | Technology |
|-------|-----------|
| Markup | HTML5 (semantic) |
| Styling | CSS3 (custom properties, flexbox, grid) |
| Logic | Vanilla JavaScript (ES6+) |
| Persistence | Browser localStorage (JSON) |
| Fonts | Inter — Google Fonts CDN |
| Hosting | GitHub Pages |
| Build | None |
| Dependencies | None (zero npm packages) |

---

## License

MIT License — free to use, modify, and distribute. See [LICENSE](LICENSE) for details.

---

## Author

Built and maintained by **[Ansuman Sahoo](https://github.com/Ansumansahoo)**.

- GitHub: [@Ansumansahoo](https://github.com/Ansumansahoo)
- Project: [AdminZone](https://github.com/Ansumansahoo/adminzone)
- Live Demo: [ansumansahoo.github.io/adminzone/](https://ansumansahoo.github.io/adminzone/)

---

*AdminZone — because every project deserves a premium admin panel.*
