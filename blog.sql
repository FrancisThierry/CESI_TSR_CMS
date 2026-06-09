-- ============================================================================
-- 1. NETTOYAGE DES TABLES EXISTANTES (Pour éviter les conflits au re-séquençage)
-- ============================================================================
SET FOREIGN_KEY_CHECKS = 0;
DROP TABLE IF EXISTS `article`;
DROP TABLE IF EXISTS `writer`;
SET FOREIGN_KEY_CHECKS = 1;

-- ============================================================================
-- 2. CRÉATION DES TABLES
-- ============================================================================

-- Création de la table 'writer' (Table parente)
CREATE TABLE `writer` (
    `id` INT AUTO_INCREMENT,
    `first_name` VARCHAR(100) NOT NULL,
    `last_name` VARCHAR(100) NOT NULL,
    `email` VARCHAR(150) UNIQUE NOT NULL,
    PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Création de la table 'article' (Table enfant avec liaison)
CREATE TABLE `article` (
    `id` INT AUTO_INCREMENT,
    `firstparagraph` TEXT NOT NULL,
    `secondparagraph` TEXT,
    `link` VARCHAR(255),
    `image` VARCHAR(255),
    `writer_id` INT,
    PRIMARY KEY (`id`),
    CONSTRAINT `fk_article_writer` 
        FOREIGN KEY (`writer_id`) 
        REFERENCES `writer` (`id`) 
        ON DELETE SET NULL 
        ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ============================================================================
-- 3. INSERTION DES DONNÉES DE TEST
-- ============================================================================

-- Insertion des 3 auteurs (Génère automatiquement les ID 1, 2 et 3)
INSERT INTO `writer` (`first_name`, `last_name`, `email`) VALUES
('Paul', 'Auster', 'paul.auster@email.com'),
('Colette', 'Sidonie', 'colette@email.com'),
('Jean', 'Giono', 'jean.giono@email.com');

-- Insertion des 5 articles (Affectation répartie entre les auteurs 1, 2 et 3)
INSERT INTO `article` (`firstparagraph`, `secondparagraph`, `link`, `image`, `writer_id`) VALUES
(
    'Ceci est le premier paragraphe du premier article.', 
    'Voici le développement de l intrigue dans le second paragraphe.', 
    'https://monsite.com/article-1', 
    'couverture1.jpg', 
    1 -- Associé à Paul Auster
),
(
    'Dans les grandes forêts de Haute-Provence, le vent souffle fort.', 
    'Les collines s étendent à perte de vue sous le soleil de plomb.', 
    'https://monsite.com/article-2', 
    'provence.jpg', 
    3 -- Associé à Jean Giono
),
(
    'Le jardin s éveille doucement sous la fraîcheur du matin.', 
    'Les parfums de la nature se mêlent aux souvenirs d enfance.', 
    'https://monsite.com/article-3', 
    'jardin.jpg', 
    2 -- Associé à Colette
),
(
    'Le hasard joue un rôle déterminant dans la structure de nos vies.', 
    'Chaque coïncidence cache peut-être un sens plus profond.', 
    'https://monsite.com/article-4', 
    'hasard.jpg', 
    1 -- Associé à Paul Auster (Deuxième article pour cet auteur)
),
(
    'Une chronique sur les moeurs de la vie rurale au début du siècle.', 
    NULL, -- Pas de second paragraphe pour cet article
    'https://monsite.com/article-5', 
    'chronique.jpg', 
    3 -- Associé à Jean Giono (Deuxième article pour cet auteur)
);