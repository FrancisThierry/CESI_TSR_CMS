
# 📝 MÉMO : Création de Plugin WordPress

## 1. Structure des Fichiers (Standard)

Toujours créer un dossier dédié dans `wp-content/plugins/`. Le fichier principal doit porter le **même nom** que le dossier.

```text
📁 wp-content/plugins/
└── 📁 mon-plugin/
    └── 📄 mon-plugin.php  <-- Fichier principal PHP

```

*Note : Évitez les noms génériques comme `server.js` ou `app.php` pour le fichier principal, WordPress ne les détectera pas correctement dans un sous-dossier.*

---

## 2. L'En-tête Obligatoire (Le passeport du plugin)

À placer tout en haut du fichier principal PHP. Sans cela, WordPress ignore le plugin.

```php
<?php
/**
 * Plugin Name: Nom de mon Plugin
 * Description: Ce que fait le plugin en une phrase.
 * Version:     1.0.0
 * Author:      Votre Nom
 * License:     GPL2
 */

// Sécurité : Bloque l'accès direct par URL (ex: monsite.com/wp-content/plugins/.../mon-plugin.php)
if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

```

---

## 3. Actions vs Filtres (Les Hooks)

WordPress fonctionne avec des "crochets" (Hooks). On distingue deux types :

### A. Les FILTRES (`add_filter`) ➔ *Modifier de la donnée*

On reçoit une variable, on la transforme, et on la **renvoie obligatoirement** avec un `return`.

* **Hook commun :** `the_content` (le texte des articles/pages).
* **Exemple :**

```php
function mon_plugin_modifier_contenu( $content ) {
    $texte_ajoute = '<p>Texte injecté !</p>';
    return $content . $texte_ajoute; // Toujours retourner la variable
}
add_filter( 'the_content', 'mon_plugin_modifier_contenu' );

```

### B. Les ACTIONS (`add_action`) ➔ *Injecter du comportement / HTML*

On n'attend pas de retour (`return`). On exécute du code ou on fait un `echo` de HTML à un moment précis du chargement.

* **Hooks communs :** `wp_footer` (pied de page), `wp_enqueue_scripts` (charger du CSS/JS), `init` (initialisation).
* **Exemple :**

```php
function mon_plugin_injecter_footer() {
    echo '<script>console.log("Plugin actif !");</script>';
}
add_action( 'wp_footer', 'mon_plugin_injecter_footer' );

```

---

## 4. Antisèche de Diagnostic (En cas de bug)

| Symptôme | Cause probable | Solution |
| --- | --- | --- |
| **Le plugin n'apparaît pas** dans l'admin | Mauvais dossier ou en-tête mal écrite | Vérifier les noms du dossier/fichier et les commentaires d'en-tête. |
| **Page Blanche / Erreur critique** | Erreur de syntaxe PHP (ex: apostrophe non échappée `'d\'avoir'`) | Activer le mode debug dans `wp-config.php` : `define('WP_DEBUG', true);` |
| **Le code est lu mais rien ne s'affiche** | Le thème court-circuite le hook (ex: n'utilise pas `the_content()`) | Tester avec un thème par défaut (Twenty Twenty-Four) ou changer de hook (ex: `wp_footer`). |
| **Erreur 404 sur les articles** | Problème de réécriture d'URL (Docker/Apache) | Aller dans *Réglages > Permaliens* et cliquer sur *Enregistrer* (ou repasser en mode "Simple"). |

---

## 5. Astuce VS Code (Faux positifs)

Si l'éditeur souligne `add_filter` ou `add_action` en rouge (*Call to unknown function*) :

* Installer l'extension **Intelephense**.
* Ajouter `"wordpress"` dans le paramètre `intelephense.stubs` de VS Code pour qu'il indexe les fonctions natives de WordPress.