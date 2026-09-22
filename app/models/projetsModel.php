<?php

/**
 * ../app/models/projetsModel.php
 */

namespace App\Models\ProjetsModel;

use \PDO;


// Recupere les projets de la page demandee, du plus recent au plus ancien.
function findAll(PDO $conn, int $limit = 10, int $offset = 0)
{
    $sql = "SELECT p.id AS projetId, p.titre AS projetTitre, p.texte AS projetText,
                   p.dateCreation AS projetDate, p.image AS projetImage,
                   c.pseudo AS creatifPseudo, c.id AS creatifId
            FROM projets p
            JOIN creatifs c ON p.creatif = c.id
            ORDER BY p.dateCreation DESC
            LIMIT {$limit} OFFSET {$offset}";

    return $conn->query($sql)->fetchAll(PDO::FETCH_ASSOC);
}

// Compte tous les projets pour calculer le nombre de pages.
function countAll(PDO $conn): int
{
    return (int) $conn->query('SELECT COUNT(*) FROM projets')->fetchColumn();
}

// Liste les creatifs et le nombre de leurs projets pour la barre laterale et les formulaires.
function findCreatifs(PDO $conn)
{
    $sql = 'SELECT c.id, c.pseudo, c.bio, c.image, COUNT(p.id) AS projetCount
            FROM creatifs c
            LEFT JOIN projets p ON p.creatif = c.id
            GROUP BY c.id, c.pseudo, c.bio, c.image
            ORDER BY c.pseudo';
    return $conn->query($sql)->fetchAll(PDO::FETCH_ASSOC);
}

// Recupere un projet et son auteur a partir de son identifiant.
function findOneById(PDO $conn, int $id)
{
    $sql = 'SELECT p.id AS projetId, p.titre AS projetTitre, p.texte AS projetText,
                   p.dateCreation AS projetDate, p.image AS projetImage,
                   c.pseudo AS creatifPseudo, c.id AS creatifId
            FROM projets p
            JOIN creatifs c ON p.creatif = c.id
            WHERE p.id = :id';

    $rs = $conn->prepare($sql);
    $rs->bindValue(':id', $id, PDO::PARAM_INT);
    $rs->execute();

    return $rs->fetch(PDO::FETCH_ASSOC);
}

// Ajoute un projet puis ses associations aux tags dans une meme transaction.
function insert(PDO $conn, array $projet, array $tags)
{
    $conn->beginTransaction();
    $sql = 'INSERT INTO projets (titre, texte, dateCreation, image, creatif)
            VALUES (:titre, :texte, NOW(), :image, :creatif)';
    $rs = $conn->prepare($sql);
    $rs->bindValue(':titre', $projet['titre'], PDO::PARAM_STR);
    $rs->bindValue(':texte', $projet['texte'], PDO::PARAM_STR);
    $rs->bindValue(':image', $projet['image'], $projet['image'] === null ? PDO::PARAM_NULL : PDO::PARAM_STR);
    $rs->bindValue(':creatif', (int) $projet['creatif'], PDO::PARAM_INT);
    if (!$rs->execute()) {
        $conn->rollBack();
        return false;
    }

    $projetId = $conn->lastInsertId();
    $rs = $conn->prepare('INSERT INTO projets_has_tags (projet, tag) VALUES (:projet, :tag)');
    foreach (array_unique($tags) as $tagId) {
        $rs->bindValue(':projet', (int) $projetId, PDO::PARAM_INT);
        $rs->bindValue(':tag', (int) $tagId, PDO::PARAM_INT);
        if (!$rs->execute()) {
            $conn->rollBack();
            return false;
        }
    }
    return $conn->commit();
}

// Supprime les associations aux tags avant le projet (cle etrangere).
function delete(PDO $conn, int $id)
{
    $conn->beginTransaction();

    $rs = $conn->prepare('DELETE FROM projets_has_tags WHERE projet = :id');
    $rs->bindValue(':id', $id, PDO::PARAM_INT);
    if (!$rs->execute()) {
        $conn->rollBack();
        return false;
    }

    $rs = $conn->prepare('DELETE FROM projets WHERE id = :id');
    $rs->bindValue(':id', $id, PDO::PARAM_INT);
    if (!$rs->execute()) {
        $conn->rollBack();
        return false;
    }

    return $conn->commit();
}

// Modifie le projet et remplace ses associations aux tags.
function update(PDO $conn, int $id, array $projet, array $tags)
{
    $conn->beginTransaction();
    $sql = 'UPDATE projets SET titre = :titre, texte = :texte,
            image = :image, creatif = :creatif WHERE id = :id';
    $rs = $conn->prepare($sql);
    $rs->bindValue(':id', $id, PDO::PARAM_INT);
    $rs->bindValue(':titre', $projet['titre'], PDO::PARAM_STR);
    $rs->bindValue(':texte', $projet['texte'], PDO::PARAM_STR);
    $rs->bindValue(':image', $projet['image'], $projet['image'] === null ? PDO::PARAM_NULL : PDO::PARAM_STR);
    $rs->bindValue(':creatif', (int) $projet['creatif'], PDO::PARAM_INT);
    if (!$rs->execute()) {
        $conn->rollBack();
        return false;
    }

    $rs = $conn->prepare('DELETE FROM projets_has_tags WHERE projet = :id');
    $rs->bindValue(':id', $id, PDO::PARAM_INT);
    if (!$rs->execute()) {
        $conn->rollBack();
        return false;
    }

    $rs = $conn->prepare('INSERT INTO projets_has_tags (projet, tag) VALUES (:projet, :tag)');
    foreach (array_unique($tags) as $tagId) {
        $rs->bindValue(':projet', $id, PDO::PARAM_INT);
        $rs->bindValue(':tag', (int) $tagId, PDO::PARAM_INT);
        if (!$rs->execute()) {
            $conn->rollBack();
            return false;
        }
    }
    return $conn->commit();
}
