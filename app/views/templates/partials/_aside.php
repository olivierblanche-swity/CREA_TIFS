<?php

/**
 * Barre laterale liste des creatifs et  liste des tags.
 * ../app/views/templates/partials/_aside.php
 * @var array $creatifs
 * @var array $tags
 * 
 * $creatifs id,pseudo,bio,image,projetCount
 * $tags id,nom,projetCount
 *
 */
use \Core\Helpers;
?>

<div class="col-lg-4">
  <!-- Widget Créa'tifs -->
  <div class="ct-side-card">
    <h5 class="ct-side-card__head">Les créa'tifs</h5>
    <div class="ct-side-card__body">
      <ul class="ct-creatif-list">
        <?php foreach ($creatifs as $creatif): ?>
          <li>
            <img class="ct-avatar" src="images/<?php echo Helpers\escape($creatif['image']); ?>" alt="" />
            <a href="creatifs/<?php echo (int) $creatif['id']; ?>/<?php echo Helpers\slugify($creatif['pseudo']); ?>.html"><?php echo Helpers\escape($creatif['pseudo']); ?></a>
            <span class="ct-count"><?php echo (int) $creatif['projetCount']; ?></span>
          </li>
        <?php endforeach; ?>
      </ul>
    </div>
  </div>

  <!-- Widget Tags -->
  <div class="ct-side-card">
    <h5 class="ct-side-card__head">Tags</h5>
    <div class="ct-side-card__body">
      <ul class="ct-tags">
        <?php foreach ($tags as $tag): ?>
          <li><a class="ct-tag" href="tags/<?php echo (int) $tag['id']; ?>/<?php echo Helpers\slugify($tag['nom']) ?>.html"><?php echo Helpers\escape($tag['nom']); ?></a></li>
        <?php endforeach; ?>
      </ul>
    </div>
  </div>
</div>