# Deploying BharatPaye to the Hostinger VPS

This assumes a fresh Ubuntu VPS. Skip steps for anything already installed —
run `bash deploy/vps_check.sh` (or ask for it) first to see what's there.

## 1. Server packages

```bash
sudo apt update && sudo apt upgrade -y
sudo apt install -y nginx mysql-server git unzip curl software-properties-common

# PHP 8.3+ (adjust version to whatever's available/newest on your distro)
sudo add-apt-repository ppa:ondrej/php -y
sudo apt update
sudo apt install -y php8.3-fpm php8.3-cli php8.3-mysql php8.3-mbstring \
    php8.3-xml php8.3-curl php8.3-zip php8.3-bcmath php8.3-gd php8.3-intl

# Composer
curl -sS https://getcomposer.org/installer | php
sudo mv composer.phar /usr/local/bin/composer

# Node.js (for building Vite assets)
curl -fsSL https://deb.nodesource.com/setup_20.x | sudo -E bash -
sudo apt install -y nodejs
```

## 2. Database

```bash
sudo mysql -u root -p
```
```sql
CREATE DATABASE fintech_portal CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
CREATE USER 'bharatpaye'@'127.0.0.1' IDENTIFIED BY 'a-strong-password-here';
GRANT ALL PRIVILEGES ON fintech_portal.* TO 'bharatpaye'@'127.0.0.1';
FLUSH PRIVILEGES;
EXIT;
```

## 3. Get the code onto the server

```bash
sudo mkdir -p /var/www/bharatpaye
sudo chown $(whoami):$(whoami) /var/www/bharatpaye
git clone <your-repo-url> /var/www/bharatpaye
cd /var/www/bharatpaye
```

If you're not using git, upload the project (minus `vendor/`, `node_modules/`,
`.env`) via `rsync`/`scp`/SFTP instead.

## 4. Configure the environment

```bash
cp .env.example .env
nano .env
```

Fill in, at minimum:
- `APP_URL` — your real domain, with `https://`
- `DB_DATABASE` / `DB_USERNAME` / `DB_PASSWORD` — from step 2
- `BILLAVENUE_AGENT_ID` / `BILLAVENUE_ACCESS_CODE` / `BILLAVENUE_WORKING_KEY` /
  `BILLAVENUE_INSTITUTE_ID` — your real BillAvenue credentials
- `BILLAVENUE_ENV` — keep as `uat` until BillAvenue confirms the VPS IP is
  whitelisted on their **live** environment too (UAT and live whitelists are
  separate); switch to `live` only then

Then generate the app key:

```bash
php artisan key:generate
```

## 5. Web server

Use whichever you installed:
- Nginx: copy `deploy/nginx.conf.example` → `/etc/nginx/sites-available/bharatpaye.conf`,
  edit the domain + PHP-FPM socket path, symlink into `sites-enabled`, `nginx -t && systemctl reload nginx`.
- Apache: copy `deploy/apache.conf.example` instead, following the comments in that file.

Point your domain's DNS A record at the VPS's public IP before continuing (SSL
issuance needs it to resolve already).

## 6. First deploy

```bash
bash deploy/deploy.sh
```

This installs Composer/npm dependencies for production, builds assets,
migrates the database, caches config/routes/views, fixes storage permissions,
and restarts PHP-FPM. Re-run it on every future deploy.

## 7. SSL (Let's Encrypt)

```bash
sudo apt install -y certbot python3-certbot-nginx   # or python3-certbot-apache
sudo certbot --nginx -d yourdomain.com -d www.yourdomain.com   # or --apache
```

Certbot rewrites the server block to add the HTTPS listener and redirect
automatically. After this succeeds, set `SESSION_SECURE_COOKIE=true` in `.env`
(already the default in `.env.example`) and run `php artisan config:cache`
again so session cookies are only sent over HTTPS.

## 8. Seed the admin account (first deploy only)

```bash
php artisan db:seed --class=AdminSeeder
```

Then immediately log in at `https://yourdomain.com/admin/login` and change the
password — the seeded password (`password`) is a placeholder, not meant for
production use. (There's no self-service "change admin password" screen yet;
update it via `php artisan tinker` — `Admin::first()->update(['password' => 'new-password'])` —
until one exists.)

## 9. Smoke test

- `https://yourdomain.com/up` → should return 200 (Laravel's built-in health check)
- Register/login as a user, and confirm OTP works
- Try a real electricity/fastag/recharge flow to confirm BillAvenue calls
  succeed from the VPS's IP (this is the actual point of this deploy —
  BillAvenue whitelisting is IP-specific, so a working call from your dev
  machine doesn't guarantee the VPS works until tested here)
- Log into `/admin/login` and check the dashboard/users/transactions pages

## Notes

- `storage/` and `bootstrap/cache/` must stay writable by the PHP-FPM user
  (`deploy/deploy.sh` handles this, but if you change the FPM pool's `user`/`group`
  directive, update the `chown` line in that script to match).
- `.env` is never committed (see `.gitignore`) — it lives only on the server.
- No queue workers are required right now — nothing in the app dispatches
  queued jobs (OTP/BillAvenue calls are synchronous), so `QUEUE_CONNECTION=database`
  in `.env` is just Laravel's default and doesn't need a `queue:work` process.
