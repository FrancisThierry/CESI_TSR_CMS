
# 1. Installer Caddy

```bash
sudo apt update
sudo apt install -y debian-keyring debian-archive-keyring apt-transport-https curl

curl -1sLf 'https://dl.cloudsmith.io/public/caddy/stable/gpg.key' \
| sudo gpg --dearmor -o /usr/share/keyrings/caddy-stable-archive-keyring.gpg

curl -1sLf 'https://dl.cloudsmith.io/public/caddy/stable/debian.deb.txt' \
| sudo tee /etc/apt/sources.list.d/caddy-stable.list

sudo apt update
sudo apt install caddy
```

Vérification :

```bash
caddy version
```

---

# 2. Installer PHP-FPM

⚠️ Ne pas installer uniquement PHP, il faut aussi PHP-FPM.

```bash
sudo apt install php8.1 php8.1-fpm
```

Vérifier :

```bash
php -v
```

Démarrer PHP-FPM :

```bash
sudo service php8.1-fpm start
```

Vérifier que le socket existe :

```bash
ls -l /run/php/
```

Vous devez voir :

```text
php8.1-fpm.sock
```

---

# 3. Créer un site PHP

Créer un fichier de test :

```bash
sudo nano /var/www/html/index.php
```

Contenu :

```php
<?php
phpinfo();
```

---

# 4. Configurer Caddy

Modifier :

```bash
sudo nano /etc/caddy/Caddyfile
```

## HTTP

```caddy
:80 {
    root * /var/www/html

    php_fastcgi unix//run/php/php8.1-fpm.sock

    file_server
}
```

---

## HTTPS local (WSL)

```caddy
localhost {
    root * /var/www/html

    php_fastcgi unix//run/php/php8.1-fpm.sock

    file_server

    tls internal
}
```

⚠️ Ne pas laisser `:80` si vous voulez HTTPS.

---

# 5. Vérifier la configuration

```bash
caddy validate --config /etc/caddy/Caddyfile
```

Vous devez obtenir :

```text
Valid configuration
```

---

# 6. Démarrer Caddy

Sous Ubuntu classique :

```bash
sudo systemctl restart caddy
```

Sous WSL :

```bash
sudo caddy run --config /etc/caddy/Caddyfile
```

Laissez ce terminal ouvert.

---

# 7. Tester

## HTTP

```text
http://localhost/index.php
```

Vous devez voir la page `phpinfo()`.

## HTTPS local

```text
https://localhost/index.php
```

---

# 8. Si PHP est téléchargé au lieu d'être exécuté

Votre Caddyfile est probablement incomplet.

Mauvais :

```caddy
:80 {
    root * /var/www/html
    file_server
}
```

Bon :

```caddy
:80 {
    root * /var/www/html

    php_fastcgi unix//run/php/php8.1-fpm.sock

    file_server
}
```

---

# 9. Si vous obtenez une erreur 502

Vérifiez :

```bash
ls -l /run/php/
```

et

```bash
ps aux | grep php-fpm
```

L'erreur la plus fréquente est :

```text
dial unix /run/php/php8.1-fpm.sock: no such file or directory
```

=> PHP-FPM n'est pas démarré ou le socket n'existe pas.

---

# 10. HTTPS avec un vrai domaine

Si vous avez un domaine :

```caddy
monsite.fr {
    root * /var/www/html

    php_fastcgi unix//run/php/php8.1-fpm.sock

    file_server
}
```

Caddy obtient automatiquement un certificat TLS de Let's Encrypt et vous aurez directement :

```text
https://monsite.fr
```

sans configuration supplémentaire.

---

Pour votre cas (WSL + PHP 8.1), commencez par faire fonctionner :

```text
http://localhost/index.php
```

avant d'essayer d'activer le HTTPS. C'est la meilleure façon de valider que PHP-FPM et Caddy communiquent correctement.
