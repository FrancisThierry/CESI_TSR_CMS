

# Travaux Dirigés : Architecture et Personnalisation WordPress



## Partie 1 : Développement d’une extension de métriques de lecture

### Objectif

Créer une extension qui calcule le nombre de mots d'un article ainsi que son temps de lecture estimé, puis injecte ces informations dans le pied de page des articles uniques.

### Cahier des charges

1. **Initialisation :** Dans le répertoire `wp-content/plugins/`, créer un dossier nommé `wp-metrics-footer` contenant le fichier principal `wp-metrics-footer.php`. Rédiger l'en-tête de commentaires standard requis par WordPress.
2. **Logique métier :** Développer une fonction qui effectue les actions suivantes :
* Restreindre l'exécution aux seuls articles de type unique (*single post*).
* Récupérer le contenu textuel de l'article courant.
* Nettoyer les balises HTML afin de ne pas fausser les statistiques.
* Compter le nombre de mots et calculer le temps de lecture sur la base d'une vitesse moyenne de **200 mots par minute** (arrondir à l'entier supérieur).


3. **Affichage :** Structurer la sortie textuelle dans un bloc `<div>` portant la classe CSS `custom-metrics-footer`.
4. **Enregistrement :** Associer la fonction au hook d'action approprié pour un affichage en fin de page.

### Indices de code

* **Fonctions de l'API WordPress :** `is_single()`, `get_post_field()`, `get_the_ID()`.
* **Fonctions natives PHP :** `str_word_count()`, `strip_tags()`, `ceil()`.
* **Hook d'action :** `wp_footer`.

---

## Partie 2 : Création du thème enfant et intégration des animations CSS

### Objectif

Créer un thème enfant pour appliquer une feuille de style personnalisée et animer l'apparition du texte de l'article ainsi que du bloc de métriques créé en Partie 1.

### Cahier des charges

1. **Structure :** Dans le répertoire `wp-content/themes/`, créer le dossier du thème enfant. Déclarer la dépendance au thème parent dans le fichier `style.css` via la directive `Template`.
2. **Chargement des styles :** Via le fichier `functions.php`, utiliser l'API de WordPress pour charger la feuille de style du thème parent, puis celle du thème enfant (respect des dépendances).
3. **Animation CSS :** Concevoir une animation de type `@keyframes` nommée `fadeInUp` (transition combinée d'opacité et de translation verticale).
4. **Application :** Cibler les paragraphes de l'article ainsi que la classe `.custom-metrics-footer` pour leur appliquer cette animation lors du chargement de la page.

### Indices de code

**Fichier `functions.php` (Structure d'enfilement) :**

```php
function enqueue_child_theme_styles() {
    // Chargement du style du thème parent
    wp_enqueue_style( 'parent-style', get_template_directory_uri() . '/style.css' );
    
    // Chargement du style du thème enfant avec dépendance
    wp_enqueue_style( 'child-style', get_stylesheet_uri(), array( 'parent-style' ) );
}
add_action( 'wp_enqueue_scripts', 'enqueue_child_theme_styles' );

```

**Fichier `style.css` (Structure de l'animation) :**

```css
/* Définition de la transition */
@keyframes fadeInUp {
    from {
        opacity: 0;
        transform: translateY(20px);
    }
    to {
        opacity: 1;
        transform: translateY(0);
    }
}

/* Ciblage des éléments */
.entry-content p, 
.custom-metrics-footer {
    animation: fadeInUp 0.6s ease-out forwards;
}

```
Exemple d'animation : https://developer.mozilla.org/fr/docs/Web/CSS/Guides/Animations/Using