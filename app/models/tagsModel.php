<?php

namespace App\Models\TagsModel;

use PDO;

function findAll(PDO $conn): array
{
    $sql = 'SELECT t.id, t.nom, COUNT(pht.projet) AS projetCount
            FROM tags t
            LEFT JOIN projets_has_tags pht ON pht.tag = t.id
            GROUP BY t.id, t.nom
            ORDER BY t.nom';

    $rs = $conn->query($sql);
    $tags = $rs->fetchAll(PDO::FETCH_ASSOC);

    return $tags;
}

function findProjects(PDO $conn, int $tagId): array
{
    $sql = 'SELECT p.id AS projetId, p.titre AS projetTitre,
                   p.texte AS projetText, p.dateCreation AS projetDate,
                   p.image AS projetImage, c.pseudo AS creatifPseudo,
                   c.id AS creatifId
            FROM projets p
            JOIN creatifs c ON c.id = p.creatif
            JOIN projets_has_tags pht ON pht.projet = p.id
            WHERE pht.tag = :tagId
            ORDER BY p.dateCreation DESC
            LIMIT 10';

    $rs = $conn->prepare($sql);
    $rs->bindValue(':tagId', $tagId, PDO::PARAM_INT);
    $rs->execute();
    $projets = $rs->fetchAll(PDO::FETCH_ASSOC);

    return $projets;
}
