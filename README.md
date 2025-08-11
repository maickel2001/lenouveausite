# SMM Premium — PHP (Hostinger-ready)

Minimal skeleton:
- Front controller routing (`public/index.php` + `.htaccess`)
- Views with layout and CSS variables (mobile-first, dark, primary color `#ff7a00`)
- Session, Auth, CSRF helpers
- Admin dashboard placeholder with Chart.js
- Maintenance mode via env `MAINTENANCE_MODE`

## Configure
Set environment variables in your hosting panel:
- SITE_NAME, BASE_URL
- DB_HOST, DB_NAME, DB_USER, DB_PASS
- MAIL_FROM, MAIL_BCC, MAIL_RETURN_PATH
- PRIMARY_COLOR (e.g. `#ff7a00`)
- MAINTENANCE_MODE (`true`/`false`)

## Deploy
- Point web root to `public/`
- Ensure `storage/` and `logs/` are writable
- Import `database/schema.sql`

