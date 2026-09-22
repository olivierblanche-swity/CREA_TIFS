<?php

/**
 * ../app/models/projetsModel.php
 */

namespace App\Models\ProjetsModel;

use \PDO;


function findAll(PDO $conn, int $limit = 10, int $offset = 0): array
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

function countAll(PDO $conn): int
{
    return (int) $conn->query('SELECT COUNT(*) FROM projets')->fetchColumn();
}

function findCreatifs(PDO $conn): array
{
    $sql = 'SELECT c.id, c.pseudo, c.bio, c.image, COUNT(p.id) AS projetCount
            FROM creatifs c
            LEFT JOIN projets p ON p.creatif = c.id
            GROUP BY c.id, c.pseudo, c.bio, c.image
            ORDER BY c.pseudo';
    return $conn->query($sql)->fetchAll(PDO::FETCH_ASSOC);
}
