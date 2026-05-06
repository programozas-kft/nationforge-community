<h1 align="center">
  <br>
  NationForge
  <br>
</h1>

<p align="center">
  <strong>Community & Political Organization Management Platform</strong><br>
  Built with Laravel 12 · Livewire 3 · Spatie Permission
</p>

<p align="center">
  <img src="https://img.shields.io/badge/Laravel-12-FF2D20?style=flat-square&logo=laravel&logoColor=white" alt="Laravel 12">
  <img src="https://img.shields.io/badge/PHP-8.2+-777BB4?style=flat-square&logo=php&logoColor=white" alt="PHP 8.2+">
  <img src="https://img.shields.io/badge/Livewire-3-FB70A9?style=flat-square" alt="Livewire 3">
  <img src="https://img.shields.io/badge/License-MIT-0ab39c?style=flat-square" alt="MIT License">
</p>

<p align="center">
  <img src="docs/hero.png" alt="NationForge – Erősebb közösségek. Több mozgósítás. Valódi változás." width="100%">
</p>

---

## What is NationForge?

NationForge is an open-core platform built for **political movements, civic organizations, and community groups** to manage their operations from a single, self-hosted admin panel.

Running an organization means juggling hundreds of contacts, events, volunteers, donors, and internal communication — all at once. Generic CRMs are expensive and built for sales teams, not communities. NationForge is purpose-built for the way civic organizations actually work.

**Own your data. Host it yourself. Extend it freely.**

---

## Features

### Contacts (CRM)
- Full people database: name, status, address, phone, email, subscriptions
- Status workflow: **Prospect → Supporter → Member → Volunteer → Donor → VIP → Inactive**
- Photo upload, group assignment, custom notes
- Searchable, filterable list with inline editing

### Groups
- Types: Community, Campaign, Chapter, Committee, Team
- Privacy levels: Public / Private / Secret
- 28 custom icons per group
- Built-in **real-time group chat** (Livewire)
- Member list with role and type badges

### Events
- Types: Meetup, Rally, Webinar, Fundraiser, Volunteer, Conference
- Online & offline support with venue/city info
- RSVP tracking per event
- Status workflow: Draft → Published → Completed / Cancelled

### Donations
- Donor records linked to contacts
- Amount, date, payment status per donation
- Monthly totals shown on the dashboard

### Projects & Tasks
- Project management with assigned team members
- Task list with status updates and deadlines

### Dashboard
- Stat cards: total contacts, upcoming events, donation totals, newsletter subscribers
- **Chart.js charts**: monthly donations (bar), contact growth (dual-axis line), status distribution (doughnut)
- Upcoming events panel, latest contacts feed

### Users & Roles
- Role-based access control: **Super Admin, Admin, Editor, Member**
- Powered by [Spatie Laravel Permission](https://github.com/spatie/laravel-permission)
- Users can be assigned to groups with roles

### Link Collection
- Configurable link library for the whole team (social media, news, resources)
- Category grouping, custom colors, sort order
- Managed directly from Settings — no code needed

### Quick Links Bar
- Top navigation bar with instant access to external resources (YouTube, Drive, Instagram, News, etc.)
- Links configurable per deployment

### Help & Documentation
- Built-in help article editor with image lightbox
- Accessible to all users from the admin panel

---

## Tech Stack

| Layer | Technology |
|---|---|
| Backend | PHP 8.2+, Laravel 12 |
| Templating | Blade |
| Reactivity | Livewire 3 + Volt |
| Auth | Laravel Breeze |
| Roles & Permissions | Spatie Laravel Permission |
| Media | Spatie Laravel MediaLibrary |
| Charts | Chart.js 4.4 |
| CSS | Tailwind CSS |
| Database | MySQL 8+ / SQLite |

---

## Requirements

- PHP >= 8.2
- Composer 2
- Node.js >= 18 + NPM
- MySQL 8+ (or SQLite for local development)

---

## Installation

```bash
# 1. Clone the repository
git clone https://github.com/programozas-kft/nationforge.git
cd nationforge

# 2. Install PHP & JS dependencies
composer install
npm install

# 3. Set up environment
cp .env.example .env
php artisan key:generate

# 4. Configure database in .env
# DB_DATABASE=nationforge
# DB_USERNAME=root
# DB_PASSWORD=

# 5. Run migrations & link storage
php artisan migrate
php artisan storage:link

# 6. Build frontend assets
npm run build
```

Or use the one-command setup:

```bash
composer run setup
```

### Create your first admin user

```bash
php artisan tinker
```
```php
$user = User::create(['name' => 'Admin', 'email' => 'admin@example.com', 'password' => bcrypt('password')]);
$user->assignRole('super-admin');
```

---

## Local Development

```bash
composer run dev
```

Starts the Laravel server, Vite, queue listener and log watcher concurrently.

---

## Open Core Model

NationForge follows an **Open Core** strategy — the community foundation is MIT-licensed and free forever, while advanced enterprise features are available in the Pro tier.

| Feature | Community (this repo) | [Pro / Enterprise](https://github.com/programozas-kft/nationforge-pro) |
|---|:---:|:---:|
| Full source code | ✅ | ✅ |
| Contacts, Groups, Events | ✅ | ✅ |
| Donations, Projects, Tasks | ✅ | ✅ |
| Built-in chat | ✅ | ✅ |
| Advanced analytics & reports | — | ✅ |
| Email campaign sender | — | ✅ |
| Multi-organization / Multi-tenant | — | ✅ |
| Two-factor authentication | — | ✅ |
| REST API | — | ✅ |
| White-label & custom domain | — | ✅ |
| Priority support & SLA | — | ✅ |
| Managed cloud hosting | — | ✅ |

> **Interested in Pro or managed hosting?**
> → [View NationForge Pro](https://github.com/programozas-kft/nationforge-pro) · [programozas.kft@gmail.com](mailto:programozas.kft@gmail.com)

---

## Roadmap

- [ ] Public event registration page
- [ ] Email campaign sender (Mailgun / SMTP)
- [ ] Volunteer shift scheduling
- [ ] REST API for mobile clients
- [ ] SMS / push notification integration
- [ ] Multi-tenant support *(Pro)*
- [ ] Advanced reporting & export *(Pro)*

---

## Contributing

Pull requests are welcome for bug fixes, UI improvements, and translations.

1. Fork the repository
2. Create your branch: `git checkout -b fix/your-fix`
3. Commit: `git commit -m "Fix: description"`
4. Push and open a Pull Request

For larger features, **please open an Issue first** so we can discuss direction before you invest the time.

---

## Security

If you discover a security vulnerability, please email [programozas.kft@gmail.com](mailto:programozas.kft@gmail.com) instead of opening a public issue. All reports are addressed promptly.

---

## License

The NationForge Community Edition is released under the **[MIT License](LICENSE)**.

---

<p align="center">
  Built with Laravel ·
  <a href="https://github.com/programozas-kft/nationforge/issues">Report a Bug</a> ·
  <a href="https://github.com/programozas-kft/nationforge/discussions">Discussions</a> ·
  <a href="mailto:programozas.kft@gmail.com">Contact</a>
</p>
