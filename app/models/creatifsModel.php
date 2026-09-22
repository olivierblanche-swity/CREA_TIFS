<?php

namespace App\Models\CreatifsModel;

use PDO;

// Recupere les dix derniers projets du creatif choisi.
function findAll(PDO $conn, int $creatifId): array
{
    $sql = "SELECT p.id AS projetId, p.titre AS projetTitre, p.texte AS projetText,
                   p.dateCreation AS projetDate, p.image AS projetImage,
                   c.pseudo AS creatifPseudo, c.id AS creatifId
            FROM projets p
            JOIN creatifs c ON p.creatif = c.id
            WHERE p.creatif = :creatifId
            ORDER BY p.dateCreation DESC
            LIMIT 10";

    $rs = $conn->prepare($sql);
    $rs->bindValue(':creatifId', $creatifId, PDO::PARAM_INT);
    $rs->execute();

    return $rs->fetchAll(PDO::FETCH_ASSOC);
}

// Liste les creatifs avec leur nombre de projets.
function findCreatifs(PDO $conn): array
{
    $sql = 'SELECT c.id, c.pseudo, c.bio, c.image, COUNT(p.id) AS projetCount
            FROM creatifs c
            LEFT JOIN projets p ON p.creatif = c.id
            GROUP BY c.id, c.pseudo, c.bio, c.image
            ORDER BY c.pseudo';

    return $conn->query($sql)->fetchAll(PDO::FETCH_ASSOC);
}
