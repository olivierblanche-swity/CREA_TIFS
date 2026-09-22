<?php

namespace Core\Helpers;

// Coupe au dernier espace avant la limite, sans couper les mots ni les accents.
function truncate($text, $limit = 100)
{
    $text = trim($text ?? '');
    if (mb_strlen($text, 'UTF-8') <= $limit) {
        return $text;
    }

    $extrait = mb_substr($text, 0, $limit + 1, 'UTF-8');
    $espace = mb_strrpos($extrait, ' ', 0, 'UTF-8');

    // Si le premier mot depasse la limite, le conserve entier.
    if ($espace === false) {
        $espace = mb_strpos($text, ' ', 0, 'UTF-8');
    }
    if ($espace === false) {
        return $text;
    }

    return rtrim(mb_substr($text, 0, $espace, 'UTF-8')) . '...';
}

// Transforme un titre en slug : minuscules, sans accents, mots separes par des tirets.
function slugify(string $text): string
{
    $text = mb_strtolower($text, 'UTF-8');
    $text = str_replace(
        ['é', 'è', 'ê', 'ë', 'à', 'â', 'ä', 'ç', 'î', 'ï', 'ô', 'ö', 'ù', 'û', 'ü', 'ÿ', 'œ', 'æ'],
        ['e', 'e', 'e', 'e', 'a', 'a', 'a', 'c', 'i', 'i', 'o', 'o', 'u', 'u', 'u', 'y', 'oe', 'ae'],
        $text
    );

    // Remplace les espaces et la ponctuation par un seul tiret.
    $text = preg_replace('/[^a-z0-9]+/', '-', $text);
    $text = trim($text, '-');

    return $text === '' ? 'n-a' : $text;
}

// fonction pour le format des dates en francais

function dateFormator(string $date): string
{
    $months = [
        1 => 'janvier',
        2 => 'février',
        3 => 'mars',
        4 => 'avril',
        5 => 'mai',
        6 => 'juin',
        7 => 'juillet',
        8 => 'août',
        9 => 'septembre',
        10 => 'octobre',
        11 => 'novembre',
        12 => 'décembre',
    ];

    $dateTime = new \DateTimeImmutable($date);
    return $dateTime->format('d') . ' ' . $months[(int) $dateTime->format('n')] . ' ' . $dateTime->format('Y');
}

// Enregistre une photo et retourne son nom pour la base de donnees.
function uploadImage(array $file): ?string
{
    if (!$file || $file['error'] === UPLOAD_ERR_NO_FILE) {
        return null;
    }
    if ($file['error'] !== UPLOAD_ERR_OK) {
        exit("La photo n'a pas pu être envoyée.");
    }

    $photo = getimagesize($file['tmp_name']);
    $extensions = ['image/jpeg' => 'jpg', 'image/png' => 'png', 'image/webp' => 'webp'];
    $extension = $extensions[$photo['mime'] ?? ''] ?? null;
    if ($extension === null) {
        exit('Choisissez une image JPG, PNG ou WebP.');
    }

    $image = bin2hex(random_bytes(16)) . '.' . $extension;
    if (!move_uploaded_file($file['tmp_name'], __DIR__ . '/../public/images/' . $image)) {
        exit("La photo n'a pas pu être enregistrée.");
    }
    return $image;
}

// Prepare un texte pour l'afficher dans le HTML (texte ou attribut entre guillemets).
function escape(?string $text): string
{
    return htmlspecialchars($text ?? '', ENT_QUOTES, 'UTF-8');
}
