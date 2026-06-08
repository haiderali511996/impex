# IMPEX Football — WordPress E-Commerce Website

Premium football manufacturer e-commerce store built on WordPress + WooCommerce with a custom dark theme, gold accents, and 12 sample products across 6 categories.

---

## Project Structure

```
impex/
├── wp-content/
│   ├── themes/
│   │   └── impex-football/           ← Custom WordPress Theme
│   │       ├── style.css             ← Theme header + full CSS (~700 lines)
│   │       ├── functions.php         ← Theme setup, WooCommerce hooks, helpers
│   │       ├── front-page.php        ← Homepage: hero, categories, features, products
│   │       ├── header.php            ← Site header with logo, nav, cart
│   │       ├── footer.php            ← Footer with links, contact, social
│   │       ├── index.php             ← Blog / fallback template
│   │       ├── page.php              ← Generic page template
│   │       ├── single.php            ← Single post template
│   │       ├── archive.php           ← Archive/blog list template
│   │       ├── woocommerce/
│   │       │   ├── archive-product.php   ← Shop & category pages
│   │       │   ├── single-product.php    ← Product detail page
│   │       │   └── content-product.php   ← Product card in loop
│   │       ├── assets/
│   │       │   ├── images/logo.svg   ← SVG logo
│   │       │   ├── css/main.css      ← Additional CSS (search, toasts, mini-cart)
│   │       │   └── js/main.js        ← Mobile menu, cart, scroll-to-top, toasts
│   │       └── screenshot.png        ← Theme screenshot placeholder
│   │
│   └── plugins/
│       └── impex-setup/
│           └── impex-setup.php       ← One-click store setup plugin
│
├── database/
│   └── impex-sample-data.sql        ← MySQL dump with all data
│
├── wp-config-sample.php             ← WordPress config template
└── README.md                        ← This file
```

---

## Quick Start

### Prerequisites

- PHP 8.0+
- MySQL 5.7+ or MariaDB 10.3+
- WordPress 6.0+
- WooCommerce 7.0+

---

### Installation Steps

#### 1. Install WordPress

```bash
# Download WordPress core into the impex/ directory
curl -o wordpress.zip https://wordpress.org/latest.zip
unzip wordpress.zip
cp -r wordpress/* /home/user/impex/
rm -rf wordpress wordpress.zip
```

#### 2. Create the Database

```sql
CREATE DATABASE impex_football_db CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
CREATE USER 'impex_db_user'@'localhost' IDENTIFIED BY 'your_strong_password';
GRANT ALL PRIVILEGES ON impex_football_db.* TO 'impex_db_user'@'localhost';
FLUSH PRIVILEGES;
```

#### 3. Configure WordPress

```bash
cp /home/user/impex/wp-config-sample.php /home/user/impex/wp-config.php
```

Edit `wp-config.php` and update:
- `DB_NAME` → `impex_football_db`
- `DB_USER` → `impex_db_user`
- `DB_PASSWORD` → your password
- `DB_HOST` → `localhost` (or your host)
- Authentication keys → generate at https://api.wordpress.org/secret-key/1.1/salt/

#### 4. Run WordPress Installer

Visit `http://localhost/impex/` and complete the WordPress installation wizard.

#### 5. Activate Theme

1. Log into WordPress Admin → Appearance → Themes
2. Activate **IMPEX Football**

#### 6. Install WooCommerce

1. Admin → Plugins → Add New → Search "WooCommerce"
2. Install and Activate WooCommerce
3. Run the WooCommerce setup wizard

#### 7. Run IMPEX Setup Plugin

1. Admin → Plugins → Activate **IMPEX Football Store Setup**
2. A yellow notice will appear — click **"Run Setup Now"**
3. Or go to Admin → IMPEX Setup → Run Setup Now

This will automatically create:
- 6 product categories
- 12 sample football products
- WooCommerce required pages (Shop, Cart, Checkout, My Account)
- Store settings (currency, units, etc.)

#### 8. (Optional) Import SQL Directly

If you prefer to import data directly into MySQL:

```bash
mysql -u impex_db_user -p impex_football_db < /home/user/impex/database/impex-sample-data.sql
```

> **Note:** The SQL file uses table IDs starting at 200 for products to avoid conflicts. Run only after WordPress + WooCommerce tables are created.

---

## Product Catalogue

| SKU           | Product Name                      | Category               | Price   |
|---------------|-----------------------------------|------------------------|---------|
| IMP-PRO-001   | IMPEX Pro Match Ball FIFA Approved | Professional Match Balls | $89.99 |
| IMP-ELT-002   | IMPEX Elite Match Ball            | Professional Match Balls | $74.99 |
| IMP-TRN-003   | IMPEX Training Pro                | Training Balls          | $45.99 |
| IMP-CLB-004   | IMPEX Club Trainer                | Training Balls          | $34.99 |
| IMP-YTH-005   | IMPEX Youth Star                  | Youth & Junior Balls    | $29.99 |
| IMP-JNR-006   | IMPEX Junior League               | Youth & Junior Balls    | $24.99 |
| IMP-FUT-007   | IMPEX Futsal Master               | Futsal Balls            | $49.99 |
| IMP-FUT-008   | IMPEX Futsal Club                 | Futsal Balls            | $39.99 |
| IMP-BCH-009   | IMPEX Beach King                  | Beach Soccer Balls      | $44.99 |
| IMP-BCH-010   | IMPEX Beach Pro                   | Beach Soccer Balls      | $37.99 |
| IMP-CUS-011   | IMPEX Custom Logo Ball (MOQ 50)   | Custom & Branded Balls  | $12.99/unit |
| IMP-CUS-012   | IMPEX Branded Team Ball (MOQ 100) | Custom & Branded Balls  | $10.99/unit |

---

## Theme Design

### Colour Palette

| Token            | Hex       | Usage                     |
|------------------|-----------|---------------------------|
| `--color-black`  | `#0a0a0a` | Main background           |
| `--color-dark`   | `#111111` | Section backgrounds       |
| `--color-dark-2` | `#1a1a1a` | Cards, sidebars           |
| `--color-gold`   | `#FFD700` | Primary accent, headings  |
| `--color-accent` | `#FFA500` | Secondary gold            |
| `--color-white`  | `#ffffff` | Text, icons               |
| `--color-grey`   | `#666666` | Muted text                |

### Typography

- **Headings:** Arial Black / Arial Bold (system font stack)
- **Body:** Arial / Helvetica Neue (system font stack)
- No external font dependencies — fast loading

### Sections (Homepage)

1. **Hero** — Animated SVG football, headline, stats, CTAs
2. **Product Categories** — 6 category cards with SVG icons
3. **Why Choose Us** — 6 feature highlights
4. **Featured Products** — Live WooCommerce product grid
5. **Promo Banner** — Custom orders call-to-action

---

## JavaScript Features

- Mobile hamburger menu with animated toggle
- Sticky header with scroll shadow
- Search bar toggle
- Scroll-to-top button
- Toast notifications for cart actions
- AJAX add-to-cart with cart count updater
- Lazy image loading polyfill
- Smooth anchor scrolling

---

## WooCommerce Customisations

- Custom WooCommerce templates (archive, single, product card)
- All WooCommerce default styles removed — 100% custom CSS
- 4-column product grid by default
- 12 products per page
- Custom product badges (HOT, SALE, NEW)
- Shop page has sidebar filter panel

---

## Deployment Checklist

- [ ] Update `wp-config.php` with live database credentials
- [ ] Generate fresh authentication keys/salts
- [ ] Set `WP_DEBUG` to `false` in production
- [ ] Set `WP_ENVIRONMENT_TYPE` to `'production'`
- [ ] Enable `FORCE_SSL_ADMIN` with a valid SSL certificate
- [ ] Enable `DISALLOW_FILE_EDIT` in production
- [ ] Configure SMTP email (WP Mail SMTP or similar plugin)
- [ ] Set up payment gateway (Stripe, PayPal) in WooCommerce
- [ ] Configure shipping zones and rates in WooCommerce
- [ ] Replace `screenshot.png` with a real 1200x900 theme screenshot
- [ ] Add real product images for all 12 products
- [ ] Update store address, phone, email in footer.php
- [ ] Set up WooCommerce tax settings if applicable
- [ ] Install an SEO plugin (Yoast SEO or Rank Math)
- [ ] Install a caching plugin (WP Super Cache or W3 Total Cache)

---

## Contact

**IMPEX Football Manufacturing**
123 Football Drive, Sialkot, Punjab, Pakistan 51310
Email: info@impexfootball.com
Phone: +92 52 123 4567

---

*Built with WordPress + WooCommerce | Theme: IMPEX Football v1.0.0*
