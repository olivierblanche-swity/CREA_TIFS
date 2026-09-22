<?php

/**
 * ../app/views/templates/partials/_aside.php
 * 
 * $creatifs id,pseudo,bio,image,projetCount
 * $tags id,nom,projetCount
 *
 */
?>

<div class="col-lg-4">
  <!-- Widget Créa'tifs -->
  <div class="ct-side-card">
    <h5 class="ct-side-card__head">Les créa'tifs</h5>
    <div class="ct-side-card__body">
      <ul class="ct-creatif-list">
        <?php foreach ($creatifs ?? [] as $creatif): ?>
          <li>
            <img class="ct-avatar" src="images/<?php echo htmlspecialchars($creatif['image'], ENT_QUOTES, 'UTF-8'); ?>" alt="" />
            <a href="creatifs/<?php echo (int) $creatif['id']; ?>/<?php echo \Core\Helpers\slugify($creatif['pseudo']); ?>.html"><?php echo htmlspecialchars($creatif['pseudo'], ENT_QUOTES, 'UTF-8'); ?></a>
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
        <?php foreach ($tags ?? [] as $tag): ?>
          <li><a class="ct-tag" href="?tags=show&amp;id=<?php echo (int) $tag['id']; ?>"><?php echo htmlspecialchars($tag['nom'], ENT_QUOTES, 'UTF-8'); ?></a></li>
        <?php endforeach; ?>
      </ul>
    </div>
  </div>
</div>