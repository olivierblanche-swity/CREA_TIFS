<?php

/**
 * @var array $projet 
 * variable disponible projet[projetId,projetTitre,projetText,projetDate, projetImage, creatifPseudo, creatifId]
 * @var array $projetTags
 * 
 */
use \Core\Helpers;
?>

<div class="container ct-content-wrap">
  <div class="row">
    <main class="col-lg-8">
      <h1><?php echo Helpers\escape($projet['projetTitre']); ?></h1>
      <p class="ct-byline">par <a href="creatifs/<?php echo (int) $projet['creatifId']; ?>/<?php echo Helpers\slugify($projet['creatifPseudo']); ?>.html"><?php echo Helpers\escape($projet['creatifPseudo']); ?></a> · <?php echo Helpers\dateFormator($projet['projetDate']); ?></p>

      <div class="mb-4">
        <!-- routes: /projects/id/slug/edit/form.html — /projets/delete/id/slug.html -->
        <a href="projects/<?php echo (int) $projet['projetId']; ?>/<?php echo Helpers\slugify($projet['projetTitre']); ?>/edit/form.html" class="ct-btn ct-btn--primary">Éditer le projet</a>
        <a href="projets/delete/<?php echo (int) $projet['projetId']; ?>/<?php echo Helpers\slugify($projet['projetTitre']); ?>.html" class="ct-btn ct-btn--danger" onclick="return confirm('Supprimer définitivement ce projet ?');">Supprimer le projet</a>
      </div>

      <article class="ct-card">
        <div class="row">
          <?php if (!empty($projet['projetImage'])): ?>
          <div class="col-md-6">
            <img class="img-fluid mb-3 mb-md-0" src="images/<?php echo Helpers\escape($projet['projetImage']); ?>" alt="<?php echo Helpers\escape($projet['projetTitre']); ?>" />
          </div>
          <?php endif; ?>
          <div class="<?php echo empty($projet['projetImage']) ? 'col-12' : 'col-md-6'; ?>">
            <p class="lead" style="font-weight: 600">
              <?php echo Helpers\escape($projet['projetText']); ?>
            </p>
            <hr />
            <p>
              Lorem ipsum dolor sit amet, consectetur adipisicing elit. Magnam
              dolorum sed, consequatur, beatae veritatis, laboriosam soluta
              expedita aliquid quam, cupiditate non. Maiores, itaque
              repudiandae. Maiores dolorum eligendi, aut ipsam officia.
            </p>
            <hr />
            <ul class="ct-tags">
              <?php foreach ($projetTags as $tag): ?>
                <li>
                  <a class="ct-tag" href="tags/<?php echo (int) $tag['id']; ?>/<?php echo Helpers\slugify($tag['nom']); ?>.html">
                    <?php echo Helpers\escape($tag['nom']); ?>
                  </a>
                </li>
              <?php endforeach; ?>
            </ul>
          </div>
        </div>
      </article>
    </main>

    <?php include '../app/views/templates/partials/_aside.php'; ?>
  </div>
</div>
