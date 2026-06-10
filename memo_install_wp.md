

## Étape 1 : Créer la base de données (via phpMyAdmin)

Avant de lancer l'assistant WordPress, il lui faut une base de données vide.

1. Ouvrez votre navigateur et accédez à **phpMyAdmin** (généralement `http://localhost/phpmyadmin`).
2. Connectez-vous avec votre compte `root` (ou l'utilisateur MySQL que vous avez configuré).
3. Cliquez sur l'onglet **Bases de données** (Databases).
4. Dans le champ "Créer une base de données", entrez le nom de votre choix (par exemple : `wordpress_db`).
5. Choisissez l'interclassement **`utf8mb4_unicode_ci`** pour une compatibilité optimale.
6. Cliquez sur **Créer**.

---

## Étape 2 : Ajuster les permissions des fichiers (Crucial sur WSL/Ubuntu)

Si vous venez d'extraire l'archive, les fichiers appartiennent probablement à votre utilisateur WSL ou à `root`. Pour que WordPress puisse installer des extensions, des thèmes ou téléverser des images, le serveur web (`www-data`) doit en être le propriétaire.

Ouvrez votre terminal WSL et exécutez les commandes suivantes :

```bash
# 1. Naviguez vers votre dossier parent
cd /var/www/html

# 2. Donnez la propriété au serveur web (www-data) sur le dossier wordpress
# (Adaptez le nom du dossier si vous l'avez extrait directement dans html ou dans un sous-dossier "wordpress")
sudo chown -R www-data:www-data wordpress/

# 3. Ajustez les permissions des dossiers (755) et des fichiers (644)
sudo find wordpress/ -type d -exec chmod 755 {} \;
sudo find wordpress/ -type f -exec chmod 644 {} \;

```

---

## Étape 3 : S'assurer que les modules PHP requis sont là

WordPress a besoin de quelques extensions PHP pour tourner correctement (notamment pour gérer les images ou les requêtes curl). Souvent, l'installation de phpMyAdmin en installe une bonne partie, mais par sécurité, vous pouvez lancer :

```bash
sudo apt update
sudo apt install php-curl php-gd php-mbstring php-xml php-xmlrpc php-soap php-intl php-zip

```

*Si vous faites des modifications ici, redémarrez Apache pour les prendre en compte :*

```bash
sudo service apache2 restart

```

---

## Étape 4 : Lancer l'assistant de configuration WordPress

1. Ouvrez votre navigateur et accédez à l'URL de votre dossier (par exemple : `http://localhost/wordpress` ou `http://localhost/` si les fichiers sont à la racine de `html`).
2. L'assistant de configuration WordPress s'affiche. Choisissez votre langue et cliquez sur **Continuer**.
3. Sur l'écran suivant, cliquez sur **C'est parti !**.
4. Remplissez les informations de connexion à la base de données :
* **Nom de la base de données :** `wordpress_db` (ou le nom choisi à l'étape 1).
* **Identifiant :** Votre identifiant MySQL (ex: `root`).
* **Mot de passe :** Le mot de passe associé (laissez vide si votre `root` local n'a pas de mot de passe, même si c'est rare avec phpMyAdmin).
* **Adresse de la base de données :** `localhost`
* **Préfixe des tables :** `wp_` (vous pouvez le laisser par défaut ou le modifier pour plus de sécurité).


5. Cliquez sur **Envoyer**.

> **Note :** Grâce à l'étape 2 (les permissions `www-data`), WordPress va créer automatiquement le fichier `wp-config.php`. Si jamais il vous demande de le créer manuellement, copiez le texte affiché à l'écran, créez un fichier nommé `wp-config.php` dans votre dossier WordPress et collez-y le contenu.

---

## Étape 5 : Finaliser l'installation de votre site

Il ne vous reste plus qu'à remplir les détails de votre site :

* **Titre du site**
* **Identifiant** (Évitez "admin" pour des raisons de sécurité, même en local, c'est une bonne habitude).
* **Mot de passe** (Générez-en un solide).
* **Adresse e-mail**

Cliquez sur **Installer WordPress**. C'est terminé ! Vous pouvez maintenant vous connecter à votre tableau de bord via `http://localhost/wordpress/wp-admin`.