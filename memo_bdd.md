# MÉMORANDUM TECHNIQUE


## 1. L'Approche Relationnelle et Algèbre Relationnelle

### Le Modèle Relationnel

Théorisé par Edgar F. Codd, le modèle relationnel organise les données sous forme de **tables** (appelées *relations* en théorie).

* Une table est composée de **colonnes** (*attributs*) et de **lignes** (*uplets* ou *tuples*).
* L'objectif principal est d'assurer l'indépendance logique et physique des données tout en évitant la redondance grâce au processus de **normalisation** (Formes Normales).

### L'Algèbre Relationnelle

C'est la base mathématique du langage SQL. Elle définit les opérations permettant de manipuler les relations pour en extraire de nouvelles données. Les opérations fondamentales sont :

* **La Sélection (ou Restriction) :** Filtre les lignes répondant à un critère spécifique (notée $\sigma$). En SQL : `WHERE`.
* **La Projection :** Sélectionne uniquement certaines colonnes d'une table (notée $\pi$). En SQL : `SELECT`.
* **La Jointure :** Combine les données de deux tables ayant un attribut commun (notée $\bowtie$). En SQL : `JOIN`.

---

## 2. Intégrité des Données : Clés et Propriétés ACID

### Les Concepts de Clés

La cohérence d'une base relationnelle repose sur l'utilisation stricte des clés :

* **Clé Primaire (Primary Key) :** Un attribut (ou un ensemble d'attributs) qui identifie de manière unique chaque ligne d'une table. Elle ne peut pas être `NULL`.
* **Clé Étrangère (Foreign Key) :** Un attribut dans une table qui fait référence à la clé primaire d'une autre table. Elle matérialise le **lien relationnel** et garantit l'**intégrité référentielle** (interdiction d'avoir une clé étrangère qui pointe vers un élément inexistant).

### Les Propriétés ACID

Pour garantir la fiabilité d'une base de données lors d'exécutions simultanées ou de pannes, le SGBDR doit valider les transactions selon 4 piliers :

* **A - Atomicité (Atomicity) :** Une transaction s'exécute entièrement ou pas du tout ("Tout ou rien"). Si une étape échoue, la base revient à son état initial (*Rollback*).
* **C - Cohérence (Consistency) :** Une transaction fait passer la base d'un état valide à un autre état valide, en respectant toutes les contraintes d'intégrité.
* **I - Isolation (Isolation) :** Les effets d'une transaction en cours ne sont pas visibles par les autres transactions tant qu'elle n'est pas validée (*Commit*).
* **D - Durabilité (Durability) :** Une fois la transaction validée, les modifications sont enregistrées de façon permanente, même en cas de panne de courant ou de crash du système.

---

## 3. Définition des Données (Langage DDL)

Le Langage de Définition de Données (DDL) permet de créer et de modifier la structure de la base de données.

### Création de Table (`CREATE TABLE`)

Définit le nom de la table, ses colonnes, leurs types de données et les contraintes associées.

```sql
CREATE TABLE "writer" (
    "id" INTEGER NOT NULL,
    "last_name" TEXT NOT NULL,
    "email" TEXT UNIQUE,
    PRIMARY KEY("id" AUTOINCREMENT)
);

```

### Modification de Structure (`ALTER TABLE`)

Permet de faire évoluer une table existante sans détruire les données qu'elle contient (ajout/suppression de colonnes ou de contraintes).

```sql
-- Ajout d'une colonne de clé étrangère reliant l'article à son auteur
ALTER TABLE "article" 
ADD COLUMN "writer_id" INTEGER REFERENCES "writer"("id") ON DELETE SET NULL;

```

---

## 4. Manipulation des Données (Langage DML)

Le Langage de Manipulation de Données (DML) regroupe les commandes permettant d'agir directement sur le contenu des tables.

### Insertion (`INSERT INTO`)

Ajoute de nouvelles lignes dans une table.

```sql
INSERT INTO "writer" ("last_name", "email") 
VALUES ('Chopin', 'frederic@email.com');

```

### Modification (`UPDATE`)

Met à jour les valeurs de colonnes spécifiques pour une ou plusieurs lignes existantes. **La clause `WHERE` est critique** pour cibler précisément les lignes à modifier.

```sql
UPDATE "writer" 
SET "email" = 'f.chopin@email.com' 
WHERE "id" = 1; -- Sans le WHERE, tous les auteurs prendraient cet email

```

### Suppression (`DELETE`)

Supprime une ou plusieurs lignes d'une table. Tout comme l'`UPDATE`, l'omission du `WHERE` entraîne la suppression de l'intégralité des données de la table.

```sql
DELETE FROM "writer" 
WHERE "id" = 1;

```