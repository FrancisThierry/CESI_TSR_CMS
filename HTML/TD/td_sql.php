<?php
/* intéroger les tables de la bdd Blog
*/


// 1. CONFIGURATION DE LA CONNEXION (À adapter avec tes identifiants)
$host = 'localhost';
$dbname = 'blogTD';
$username = 'monusername';
$password = 'monmotdepasse';

try {
    // Connexion à la base de données avec activation des erreurs
    $pdo = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8mb4", $username, $password, [
        PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
        PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC // Les résultats seront des tableaux associatifs
    ]);

    // 2. PRÉPARATION ET EXÉCUTION DE LA REQUÊTE
    // On sélectionne tous les articles
    $query = "SELECT id, firstparagraph, secondparagraph, link, image FROM article";
    $stmt = $pdo->prepare($query);
    $stmt->execute();

    // 3. RÉCUPÉRATION DES RÉSULTATS
    // fetchAll() récupère toutes les lignes d'un coup
    $articles = $stmt->fetchAll();

} catch (PDOException $e) {
    // Gestion simplifiée de l'erreur en cas de problème de connexion ou de requête
    die("Erreur de base de données : " . $e->getMessage());
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Liste des Articles</title>
    <style>
        .article-card {
            border: 1px solid #ccc;
            padding: 15px;
            margin-bottom: 20px;
            border-radius: 5px;
        }
    </style>
</head>
<body>

    <h1>Articles disponibles</h1>

    <?php if (!empty($articles)): ?>
        <?php foreach ($articles as $article): ?>
            <div class="article-card">
                <h2>Article n°<?php echo $article['id']; ?></h2>
                
                <p><strong>Premier paragraphe :</strong><br>
                   <?php echo htmlspecialchars($article['firstparagraph']); ?>
                </p>
                
                <?php if (!empty($article['secondparagraph'])): ?>
                    <p><strong>Second paragraphe :</strong><br>
                       <?php echo htmlspecialchars($article['secondparagraph']); ?>
                    </p>
                <?php endif; ?>

                <?php if (!empty($article['link'])): ?>
                    <p><a href="<?php echo htmlspecialchars($article['link']); ?>" target="_blank">Lien vers l'article</a></p>
                <?php endif; ?>
            </div>
        <?php endforeach; ?>
    <?php else: ?>
        <p>Aucun article trouvé.</p>
    <?php endif; ?>

</body>
</html>