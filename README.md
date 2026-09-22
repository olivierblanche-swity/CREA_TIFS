# CREA_TIFS — Examen de scripts serveur

Projet réalisé dans le cadre de l'examen de **scripts serveur** de la formation **Webdev (développement web)** à l'**EAFC Fléron, en Belgique**.

CREA_TIFS est une application PHP de présentation de projets de coiffure. Chaque projet est associé à un créatif et peut recevoir plusieurs tags. Le projet met en pratique une architecture MVC simple, les échanges avec une base de données et le traitement de formulaires.

## Objectifs pédagogiques

- Organiser le code en modèles, vues et contrôleurs (MVC).
- Découper les routeurs et les éléments communs du template en partials.
- Utiliser la réécriture d'URL avec Apache et un fichier `.htaccess`.
- Lire et modifier les données avec PDO et des requêtes préparées utilisant `bindValue()`.
- Gérer les formulaires d'ajout et de modification, ainsi que l'envoi de photos.
- Créer des fonctions réutilisables pour les slugs, les extraits de texte et l'affichage HTML.
- Commenter le code des contrôleurs, modèles et vues.

Les consignes de référence sont disponibles dans `documents/consignes.txt` (session 1 — 2022).

## Fonctionnalités

- Liste des projets avec 10 projets par page et pagination sur l'accueil.
- Extraits de description limités autour de 100 caractères, sans couper les mots. Un premier mot dépassant cette limite est conservé entier.
- Affichage du détail d'un projet, de son auteur, de sa photo et de ses tags.
- Affichage des projets par créatif ou par tag, limité aux 10 derniers résultats.
- Ajout d'un projet avec une photo facultative et sélection de tags.
- Modification à partir d'un formulaire prérempli ; conservation de la photo actuelle si aucune nouvelle photo n'est envoyée.
- Suppression d'un projet et de ses associations aux tags.
- Retour à l'accueil après un ajout, une modification ou une suppression réussis.

## Technologies

- PHP et PDO
- MySQL ou MariaDB
- Apache et `mod_rewrite`
- HTML, CSS, Bootstrap et JavaScript
- WampServer pour l'environnement de développement local

## Installation locale

1. Placer le projet dans le dossier des sites de WampServer, par exemple `C:\wamp64\www\CREA_TIFS`.
2. Démarrer Apache et MySQL/MariaDB.
3. Créer une base de données puis y importer `documents/db/db_remplie.sql`, par exemple avec phpMyAdmin.
4. Copier `app/config/params_exemple.php` vers `app/config/params.php` et renseigner `DBHOST`, `DBNAME`, `DBUSER` et `DBPWD` avec les paramètres de la base locale.
5. Vérifier que les extensions PHP `pdo_mysql` et `mbstring` sont activées et qu'Apache autorise les règles `.htaccess` avec `mod_rewrite`.
6. Vérifier que PHP peut écrire dans `public/images/` pour enregistrer les photos.
7. Ouvrir `http://localhost/CREA_TIFS/public/`. Adapter cette adresse si le projet est installé dans un autre dossier.

Le point d'entrée de l'application est `public/index.php`.

## Organisation du projet

```text
app/
├── config/          Paramètres de connexion
├── controllers/     Préparation des données et traitement des actions
├── models/          Requêtes SQL avec PDO
├── routers/         Choix du contrôleur et de l'action
└── views/
    ├── projets/     Liste, détail et formulaires
    └── templates/   Template commun et partials
core/                Initialisation, connexion, constantes et helpers
documents/           Consignes, base SQL et documents de référence
public/              Point d'entrée, .htaccess, images et ressources du site
```

## Routes principales

Les chemins ci-dessous sont relatifs au dossier `public/`.

| Action | Chemin |
| --- | --- |
| Accueil | `/` ou `/projects` |
| Détail d'un projet | `/projets/id/slug.html` |
| Suppression d'un projet | `/projets/delete/id/slug.html` |
| Formulaire d'ajout | `/projects/add/form.html` |
| Enregistrement de l'ajout | `/projects/add/insert.html` |
| Formulaire de modification | `/projects/id/slug/edit/form.html` |
| Enregistrement de la modification | `/projects/id/slug/edit/update.html` |
| Projets d'un créatif | `/creatifs/id/slug.html` |
| Projets d'un tag | `/tags/id/slug.html` |

`id` représente l'identifiant en base et `slug` est calculé à partir du titre ou du nom. Les slugs ne sont pas stockés dans les tables. L'alternance entre `projects` et `projets` dans les routes principales suit les consignes de l'examen.

## Helpers

Les fonctions communes se trouvent dans `core/helpers.php` :

- `slugify()` : transforme un texte en slug, en minuscules, sans accents et avec des tirets.
- `truncate()` : produit un extrait en respectant les mots et les caractères accentués.
- `escape()` : utilise `htmlspecialchars()` pour afficher du texte dans le HTML et accepte les valeurs nulles.
- `dateFormator()` : présente une date en français.
- `uploadImage()` : enregistre une photo JPG, PNG ou WebP avec un nom unique dans `public/images/`. Seul le nom du fichier est enregistré dans la base.

Ce dépôt constitue un travail pédagogique réalisé pour l'examen.
