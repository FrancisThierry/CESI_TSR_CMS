# MÉMORANDUM TECHNIQUE


## 1. Architecture et Connexion : L'extension PDO

Pour interagir avec un SGBDR (comme MySQL, PostgreSQL ou SQLite) depuis PHP, l'utilisation de l'extension **PDO (PHP Data Objects)** est la norme standard. Elle offre une couche d'abstraction permettant d'utiliser les mêmes fonctions quel que soit le moteur de base de données sous-jacent.

### Initialisation d'une connexion sécurisée

La connexion instancie un objet PDO. Il est recommandé de l'envelopper dans un bloc `try...catch` pour intercepter les pannes réseau ou les erreurs d'identifiants sans divulguer d'informations sensibles (comme le mot de passe dans la pile d'erreur).

```php
$dsn = 'mysql:host=localhost;dbname=ma_base;charset=utf8mb4';
$user = 'db_user';
$password = 'secure_password';

try {
    $pdo = new PDO($dsn, $user, $password, [
        // Active la levée d'exceptions pour une gestion rigoureuse des erreurs SQL
        PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
        // Force le mode de récupération par défaut en tableau associatif
        PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
        // Désactive l'émulation des requêtes préparées (sécurité accrue)
        PDO::ATTR_EMULATE_PREPARES => false,
    ]);
} catch (PDOException $e) {
    // En production, journaliser l'erreur et afficher un message générique
    error_log($e->getMessage());
    die("Une erreur technique est survenue.");
}

```

---

## 2. Exécution des Requêtes : Sécurité contre les Injections SQL

Il existe deux méthodes pour soumettre des requêtes SQL à une table. Le choix dépend de la présence ou non de variables dynamiques (saisies utilisateurs).

### A. Les requêtes directes (`PDO::query`)

À utiliser **uniquement** si la requête ne contient aucune variable ou donnée externe.

```php
// Exemple : Lecture simple sans paramètre
$stmt = $pdo->query("SELECT * FROM writer");
$auteurs = $stmt->fetchAll();

```

### B. Les requêtes préparées (`PDO::prepare`) — Impératif de Sécurité

Dès qu'une variable (issue de `$_POST`, `$_GET`, ou d'une session) intervient dans la requête, l'utilisation des requêtes préparées est **obligatoire**. Elle sépare le code SQL des données, neutralisant ainsi toute tentative d'**injection SQL**.

On utilise des marqueurs nommés (ex: `:id`) ou interrogatifs (ex: `?`).

---

## 3. Opérations CRUD sur les Tables

### Insertion de Données (Create)

L'insertion associe la préparation de la requête et l'exécution en passant un tableau de paramètres.

```php
$sql = "INSERT INTO writer (first_name, last_name, email) 
        VALUES (:firstname, :lastname, :email)";

$stmt = $pdo->prepare($sql);
$stmt->execute([
    'firstname' => 'Francis',
    'lastname'  => 'Boulanger',
    'email'     => 'f.boulanger@email.com'
]);

// Récupération de l'ID généré par l'AUTOINCREMENT
$nouvelId = $pdo->lastInsertId();

```

### Lecture de Données (Read)

Pour récupérer les lignes d'une table, on exécute la requête préparée puis on extrait les données.

* **Lecture de plusieurs lignes (`fetchAll`) :**

```php
$sql = "SELECT id, last_name FROM writer WHERE last_name LIKE :search";
$stmt = $pdo->prepare($sql);
$stmt->execute(['search' => 'Dupont%']);

$auteurs = $stmt->fetchAll(); // Retourne un tableau bidimensionnel

foreach ($auteurs as $auteur) {
    echo $auteur['last_name'];
}

```

* **Lecture d'une seule ligne (`fetch`) :**

```php
$sql = "SELECT * FROM writer WHERE id = :id";
$stmt = $pdo->prepare($sql);
$stmt->execute(['id' => $idRecherche]);

$auteur = $stmt->fetch(); // Retourne un tableau simple (ou false si non trouvé)
if ($auteur) {
    echo $auteur['email'];
}

```

### Modification de Données (Update)

L'écriture reste identique, mais il est crucial de vérifier le nombre de lignes effectivement impactées.

```php
$sql = "UPDATE writer SET email = :email WHERE id = :id";
$stmt = $pdo->prepare($sql);
$stmt->execute([
    'email' => 'nouveau.email@email.com',
    'id'    => 3
]);

// Compte le nombre de lignes modifiées
$lignesModifiees = $stmt->rowCount();

```

### Suppression de Données (Delete)

```php
$sql = "DELETE FROM writer WHERE id = :id";
$stmt = $pdo->prepare($sql);
$stmt->execute(['id' => 5]);

```

---

## 4. Gestion Avancée : Les Transactions

Lorsqu'une action métier nécessite de manipuler plusieurs tables de manière atomique (ex: insérer un nouvel auteur ET lui affecter immédiatement son premier article), il faut utiliser les transactions de l'objet PDO. Cela garantit le respect de la propriété **ACID**.

```php
try {
    // Désactive le mode auto-commit et démarre la transaction
    $pdo->beginTransaction();

    // Étape 1 : Insertion de l'auteur
    $stmtWriter = $pdo->prepare("INSERT INTO writer (last_name) VALUES (:name)");
    $stmtWriter->execute(['name' => 'Auster']);
    $writerId = $pdo->lastInsertId();

    // Étape 2 : Insertion de l'article lié
    $stmtArticle = $pdo->prepare("INSERT INTO article (firstparagraph, writer_id) VALUES (:text, :writer_id)");
    $stmtArticle->execute([
        'text' => 'Premier paragraphe du roman...',
        'writer_id' => $writerId
    ]);

    // Validation définitive des deux opérations
    $pdo->commit();
    
} catch (Exception $e) {
    // En cas d'erreur sur l'une des deux étapes, on annule tout
    $pdo->rollBack();
    error_log("Échec de la transaction : " . $e->getMessage());
}

```