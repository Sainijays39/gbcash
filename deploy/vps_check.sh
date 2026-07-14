#!/bin/bash
echo "===== OS ====="
cat /etc/os-release 2>/dev/null | head -3

echo -e "\n===== Web server ====="
which nginx 2>/dev/null && nginx -v 2>&1
which apache2 2>/dev/null && apache2 -v 2>&1
which httpd 2>/dev/null && httpd -v 2>&1

echo -e "\n===== PHP ====="
which php 2>/dev/null && php -v
php -m 2>/dev/null | grep -Ei 'curl|openssl|mbstring|pdo_mysql|fileinfo|zip|bcmath'

echo -e "\n===== PHP-FPM ====="
systemctl status php*-fpm --no-pager 2>/dev/null | head -5
ls /etc/php/*/fpm/pool.d/ 2>/dev/null

echo -e "\n===== MySQL / MariaDB ====="
which mysql 2>/dev/null && mysql --version
systemctl status mysql --no-pager 2>/dev/null | head -3
systemctl status mariadb --no-pager 2>/dev/null | head -3

echo -e "\n===== Composer ====="
which composer 2>/dev/null && composer --version

echo -e "\n===== Node / npm ====="
which node 2>/dev/null && node -v
which npm 2>/dev/null && npm -v

echo -e "\n===== Git ====="
which git 2>/dev/null && git --version

echo -e "\n===== Existing app directories ====="
ls -la /var/www/ 2>/dev/null
ls -la /home/*/domains/ 2>/dev/null
ls -la /home/*/public_html/ 2>/dev/null

echo -e "\n===== Firewall / open ports ====="
which ufw 2>/dev/null && ufw status
ss -tlnp 2>/dev/null | grep -E ':80|:443|:22|:3306'

echo -e "\n===== Public IP ====="
curl -s ifconfig.me
echo ""

echo -e "\n===== SSL / certbot ====="
which certbot 2>/dev/null && certbot --version

echo -e "\n===== Disk / memory ====="
df -h / 2>/dev/null
free -h 2>/dev/null
