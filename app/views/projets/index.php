<?php

/**
 * ../app/views/projets/index.php
 * @var array $projets 
 * Champs : projetId, projetTitre, projetText, projetDate, projetImage, creatifPseudo, creatifId
 * @var int $totalPages
 * @var int $page
 */
use \Core\Helpers;
?>

<?php include '../app/views/templates/partials/_hero.php'; ?>

<div class="container ct-content-wrap">
    <div class="row">
        <main class="col-lg-8">
            <?php foreach ($projets as $projet):; ?>
                <article class="ct-card">
                    <div class="row">
                        <?php if (!empty($projet['projetImage'])): ?>
                        <div class="col-md-4">
                            <a href="projets/<?php echo $projet['projetId']; ?>/<?php echo Helpers\slugify($projet['projetTitre']); ?>.html">
                                <img class="img-fluid mb-3 mb-md-0" src="images/<?php echo Helpers\escape($projet['projetImage']); ?>" alt="<?php echo Helpers\escape($projet['projetTitre']); ?>" />
                            </a>
                        </div>
                        <?php endif; ?>
                        <div class="<?php echo empty($projet['projetImage']) ? 'col-12' : 'col-md-8'; ?>">
                            <h3><a href="projets/<?php echo $projet['projetId']; ?>/<?php echo Helpers\slugify($projet['projetTitre']); ?>.html"><?php echo Helpers\escape($projet['projetTitre']); ?></a></h3>
                            <p class="ct-byline">par <a href="creatifs/<?php echo $projet['creatifId']; ?>/<?php echo Helpers\slugify($projet['creatifPseudo']); ?>.html"><?php echo Helpers\escape($projet['creatifPseudo']); ?></a> · <?php echo Helpers\dateFormator($projet['projetDate']); ?></p>
                            <p><?php echo Helpers\escape(Helpers\truncate($projet['projetText'])); ?></p>
                            <a class="ct-btn ct-btn--primary ct-btn--sm" href="projets/<?php echo $projet['projetId']; ?>/<?php echo Helpers\slugify($projet['projetTitre']); ?>.html">Voir le projet</a>
                        </div>
                    </div>
                </article>
            <?php endforeach; ?>

            <?php if ($totalPages > 1): ?>
                <?php $paginationPrefix = isset($_GET['creatifs']) ? 'creatifs=show&amp;id=' . (int) ($_GET['id'] ?? 0) . '&amp;' : (isset($_GET['tags']) ? 'tags=show&amp;id=' . (int) ($_GET['id'] ?? 0) . '&amp;' : ''); ?>
                <nav aria-label="Navigation entre les pages de projets">
                    <ul class="pagination ct-pagination" style="justify-content: center">
                        <li class="page-item<?php echo $page <= 1 ? ' disabled' : ''; ?>">
                            <a class="page-link" href="?<?php echo $paginationPrefix; ?>page=<?php echo max(1, $page - 1); ?>" aria-label="Page précédente">Précédent</a>
                        </li>
                        <?php for ($pageNumber = 1; $pageNumber <= $totalPages; $pageNumber++): ?>
                            <li class="page-item<?php echo $pageNumber === $page ? ' active' : ''; ?>">
                                <a class="page-link" href="?<?php echo $paginationPrefix; ?>page=<?php echo $pageNumber; ?>"><?php echo $pageNumber; ?></a>
                            </li>
                        <?php endfor; ?>
                        <li class="page-item<?php echo $page >= $totalPages ? ' disabled' : ''; ?>">
                            <a class="page-link" href="?<?php echo $paginationPrefix; ?>page=<?php echo min($totalPages, $page + 1); ?>" aria-label="Page suivante">Suivant</a>
                        </li>
                    </ul>
                </nav>
            <?php endif; ?>
        </main>

        <?php include '../app/views/templates/partials/_aside.php'; ?>
    </div>
</div>
