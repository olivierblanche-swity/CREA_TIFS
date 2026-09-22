<?php
/**
 * Barre laterale du detail : profil du creatif et liste des tags.
 * @var array $creatif
 * @var array $tags
 */
use \Core\Helpers;
?>

<div class="col-lg-4">
  <!-- Profil du creatif associe au projet -->
  <div class="ct-side-card">
    <h5 class="ct-side-card__head">Le créa'tif</h5>
    <div class="ct-side-card__body">
      <div class="ct-profile">
        <?php if (!empty($creatif['image'])): ?>
          <img src="images/<?php echo Helpers\escape($creatif['image']); ?>" alt="<?php echo Helpers\escape($creatif['pseudo']); ?>" />
        <?php endif; ?>
        <div>
          <strong>
            <a href="creatifs/<?php echo (int) $creatif['id']; ?>/<?php echo Helpers\slugify($creatif['pseudo']); ?>.html"><?php echo Helpers\escape($creatif['pseudo']); ?></a>
          </strong>
          <p><?php echo Helpers\escape(Helpers\truncate($creatif['bio'], 50)); ?></p>
        </div>
      </div>
    </div>
  </div>

  <!-- Liste des tags -->
  <div class="ct-side-card">
    <h5 class="ct-side-card__head">Tags</h5>
    <div class="ct-side-card__body">
      <ul class="ct-tags">
        <?php foreach ($tags as $tag): ?>
          <li><a class="ct-tag" href="tags/<?php echo (int) $tag['id']; ?>/<?php echo Helpers\slugify($tag['nom']); ?>.html"><?php echo Helpers\escape($tag['nom']); ?></a></li>
        <?php endforeach; ?>
      </ul>
    </div>
  </div>
</div>
