# MÉMORANDUM TECHNIQUE

## 1. Technologies Front-End : HTML et CSS

Le développement d'interfaces web repose sur la séparation stricte entre la structure des données et leur présentation.

### HyperText Markup Language (HTML)

HTML est un langage de balisage structurant le contenu d'une page web. Il utilise des éléments imbriqués (balises) pour s'adresser au navigateur.

* **Sémantique :** Il est crucial d'utiliser les balises appropriées (`<header>`, `<nav>`, `<main>`, `<article>`, `<footer>`) pour garantir l'accessibilité (SEO et lecteurs d'écran).
* **Structure de base :**
```html
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Titre du Document</title>
</head>
<body>
    <h1>Titre Principal</h1>
    <p>Contenu textuel.</p>
</body>
</html>

```



### Cascading Style Sheets (CSS)

CSS gère la mise en forme, la disposition et l'aspect visuel des éléments HTML.

* **Sélecteurs :** Permettent de cibler les éléments par balise, classe (`.ma-classe`) ou identifiant (`#mon-id`).
* **Modèle de boîte (Box Model) :** Tout élément HTML est modélisé sous forme de boîte comprenant le contenu, le rembourrage (`padding`), la bordure (`border`) et la marge externe (`margin`).
* **Mise en page moderne :** L'alignement et le positionnement des éléments s'effectuent principalement via les modules **Flexbox** (unidimensionnel) et **CSS Grid** (bidimensionnel).

---

## 2. Développement Back-End : PHP (Hypertext Preprocessor)

PHP est un langage de script côté serveur, principalement exécuté pour générer dynamiquement le code HTML envoyé au client.

### Les Variables

En PHP, une variable est un espace de stockage temporaire identifié par le symbole `$`. Elle est faiblement typée (le type est déterminé par le contexte).

```php
$nomAuteur = "Dupont"; // Chaîne de caractères (string)
$age = 42;            // Entier (integer)
$estActif = true;     // Booléen (boolean)

```

### Les Structures de Données (Tableaux)

PHP utilise principalement les tableaux (`array`) pour organiser les collections de données.

* **Tableau indexé :** Accessible via un index numérique commençant à 0.
```php
$fruits = ['Pomme', 'Banane', 'Orange'];

```


* **Tableau associatif :** Associe une clé textuelle à une valeur (clé $\rightarrow$ valeur).
```php
$ecrivain = [
    'nom' => 'Hugo',
    'prenom' => 'Victor',
    'email' => 'victor.hugo@email.com'
];

```



### Les Boucles (Structures Itératives)

Les boucles permettent d'exécuter un bloc de code de manière répétitive.

* **Boucle `for` :** Idéale lorsque le nombre d'itérations est connu à l'avance.
```php
for ($i = 0; $i < 5; $i++) {
    echo "Itération : " . $i;
}

```


* **Boucle `foreach` :** Spécifiquement conçue pour parcourir les structures de données (tableaux).
```php
foreach ($fruits as $fruit) {
    echo $fruit;
}

```



### Classes et Programmation Orientée Objet (POO)

La POO structure le code en entités logiques appelées objets, instanciées à partir de classes.

```php
class Article {
    // Propriétés
    private string $titre;
    private string $contenu;

    // Constructeur
    public function __construct(string $titre, string $contenu) {
        $this->titre = $titre;
        $this->contenu = $contenu;
    }

    // Méthode (Getter)
    public function getTitre(): string {
        return $this->titre;
    }
}

// Instanciation
$monArticle = new Article("Titre de l'article", "Corps du texte...");

```

### Récupération des Paramètres (Superglobales)

PHP utilise des tableaux superglobaux pour intercepter les données transmises par le protocole HTTP.

* **`$_GET` :** Récupère les données transitant directement dans l'URL (ex: `index.php?id=10`).
```php
$idArticle = $_GET['id'] ?? null; // Utilisation de l'opérateur de coalescence nulle

```


* **`$_POST` :** Récupère les données transmises de manière sécurisée via le corps d'une requête HTTP (souvent issues d'un formulaire HTML).
```php
$emailSaisi = $_POST['email'] ?? null;

```



### Gestion des Sessions

Les sessions permettent de maintenir l'état et de stocker des informations d'un utilisateur d'une page à une autre, palliant le protocole HTTP qui est par nature "stateless" (sans mémoire).

* **Initialisation :** Doit impérativement être appelée avant tout envoi de contenu HTML.
```php
session_start();

```


* **Stockage et Lecture :** Utilisation de la superglobale `$_SESSION`.
```php
// Stockage
$_SESSION['utilisateur_id'] = 123;

// Lecture
$idConnecte = $_SESSION['utilisateur_id'] ?? null;

```


* **Destruction :** Pour la déconnexion de l'utilisateur.
```php
session_destroy();

```