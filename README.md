# IronVault Epoxy Systems — Laravel 13 + Filament 3 Website, ERP & AI

Production-ready SME platform for a Fort Worth / DFW **epoxy flooring installer**: public marketing site, Filament admin ERP, knowledge base, and AI assistants for chat, content, automation ideas, and troubleshooting.

## Features
- 🏠 Premium public site (hero, services, about, dashboard preview, contact)
- 🧱 Service detail pages for garage, commercial, warehouse, metallic, prep & topcoats
- 📰 Blog / knowledge content with seeded posts
- 📬 Contact form that stores leads in the database
- 💬 Floating WhatsApp button + public AI chatbot widget
- 🗂️ Filament ERP at `/admin` (customers, jobs, inventory, invoices, payments, appointments)
- 👥 Roles: Admin, Manager, Staff
- 📊 Reports dashboard with stats + charts
- ⚙️ Settings page for company phone, WhatsApp, tax rate, and more
- 🤖 Admin AI Studio (blog/descriptions, automation suggestions, troubleshooting)
- 📚 Knowledge base: common issues, guides, admin manual, troubleshooting
- 🌱 Realistic demo seeders for a full walkthrough

## Tech Stack
- Laravel 13
- Filament 3
- Livewire + Alpine.js
- Tailwind-friendly public CSS (custom IronVault theme)
- MySQL or SQLite
- Spatie Laravel Permission
- OpenAI API with Gemini fallback keys (demo FAQ mode when keys are empty)

## Installation
```bash
git clone https://github.com/imranbru99/epoxy-flooring-installer.git
cd epoxy-flooring-installer
composer install
copy .env.example .env   # Windows
php artisan key:generate
# Ensure database/database.sqlite exists for SQLite demo
php artisan migrate --seed
php artisan serve
```

Admin ERP: `http://localhost:8000/admin`  
Public site: `http://localhost:8000`

### Admin login
- Email: `admin@example.com`
- Password: `password`

Optional AI keys in `.env`:
```
OPENAI_API_KEY=
GEMINI_API_KEY=
```

## Screenshots / Visual Dashboard
![Garage epoxy flooring](https://images.unsplash.com/photo-1558618666-fcd25c85cd64?auto=format&fit=crop&w=1600&q=80)

![Commercial warehouse floor](https://images.unsplash.com/photo-1586528116311-ad8dd3c8310d?auto=format&fit=crop&w=1600&q=80)

![Concrete floor preparation](https://images.unsplash.com/photo-1503387762-592deb58ef4e?auto=format&fit=crop&w=1600&q=80)

![Industrial shop floor](https://images.unsplash.com/photo-1487754180451-c456f719a1fc?auto=format&fit=crop&w=1600&q=80)

## Live Demo
Placeholder — deploy to your host and share the public URL + `/admin` demo credentials.

## SEO-optimized repo description suggestion
`IronVault Epoxy Systems — Laravel 13 + Filament 3 website, ERP, and AI chatbot for US epoxy flooring installers (garage, commercial, warehouse).`

---

## 🤝 Let's Connect & Collaborate
I am open to Senior Remote Full-Stack Roles, AI Platform Architecture Contracts, and Enterprise Technical Advisory.
Timezone: UTC+6 (Dhaka / Rangpur, Bangladesh) — Flexible overlap with US, UK, and European business hours.
Delivery Mode: Async-ready, Slack, Discord, Jira, GitHub, and production-first accountability.

| Channel | Address / Handle | Quick Action |
|---------|------------------|--------------|
| 🌐 Primary Portfolio | imrandev.bd | Visit Site ↗ |
| 📦 Packagist Packages | packagist.org/packages/imrandevbd/ | View Packages ↗ |
| 💼 LinkedIn Profile | linkedin.com/in/imranbru99 | Connect ↗ |
| 🐙 GitHub Profile | github.com/imranbru99 | Follow ↗ |
| 💬 WhatsApp Direct | +880 1576-918420 | Chat Now ↗ |
| 📧 Direct Email | me@imrandev.bd | Send Email ↗ |
| 🐦 X (Twitter) | @imrandev_bd | Follow ↗ |
| 📺 YouTube Tech | @ImranDevBD | Subscribe ↗ |
