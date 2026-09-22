<?php
/**
 * 
 * app/views/projets/editForm.php
 * @var array $creatifs
 * @var array $tags
 * @var array $projet
 * @var array $selectedTags
 *  
 */ 
use \Core\Helpers;
?>


<div class="container" style="margin-top: 2.5rem">
      <div class="row">
        <!-- Colonne principale -->
        <div class="col-lg-8 py-3">
          <!-- Formulaire prerempli avec les informations du projet. -->
          <h1 class="mb-4">Modifier un projet</h1>

          <form action="projects/<?php echo (int) $projet['projetId']; ?>/<?php echo Helpers\slugify($projet['projetTitre']); ?>/edit/update.html" method="post" enctype="multipart/form-data" class="ct-form-card">
            <label for="title">Titre du projet</label>
            <input
              type="text"
              name="titre"
              value="<?php echo Helpers\escape($projet['projetTitre']); ?>"
              id="title" maxlength="45" required
              class="form-control"
              placeholder="Ex : Frange Kamikaze"
            />

            <label for="text">Description</label>
            <textarea
              id="text"
              name="texte"
              class="form-control"
              rows="5"
              placeholder="Racontez l'histoire (courageuse) de ce projet..."
            ><?php echo Helpers\escape($projet['projetText'] ?? ''); ?></textarea>

            <?php if (!empty($projet['projetImage'])): ?>
              <img src="images/<?php echo Helpers\escape($projet['projetImage']); ?>" alt="Photo actuelle" class="img-fluid mb-3" style="max-height: 180px" />
            <?php endif; ?>
            <p>Sans nouvelle photo, la photo actuelle sera conservée.</p>
            <label for="creatif-file">Photo du résultat</label>
            <div class="ct-dropzone">
              ✂️ Glissez une image ou choisissez-la ci-dessous
              <input
                type="file"
                class="form-control-file"
                id="creatif-file"
                name="image" accept="image/jpeg,image/png,image/webp"
              />
            </div>

            <label for="category">Créa'tif</label>
            <select id="category" name="creatif" class="form-control" required>
              <option value="" disabled>Sélectionnez le créa'tif</option>
              <?php foreach ($creatifs as $creatif): ?>
                <option value="<?php echo (int) $creatif['id']; ?>" <?php echo (int) $creatif['id'] === (int) $projet['creatifId'] ? 'selected' : ''; ?>>
                  <?php echo Helpers\escape($creatif['pseudo']); ?>
                </option>
              <?php endforeach; ?>
            </select>

            <label>Tags <span style="font-weight:400;font-size:.8rem;color:#4a3a5a">(facultatif)</span></label>
            <div class="ct-tag-choice">
              <?php foreach ($tags as $tag): ?>
                <label>
                  <input type="checkbox" name="tags[]" value="<?php echo (int) $tag['id']; ?>" <?php echo in_array($tag['id'], $selectedTags) ? 'checked' : ''; ?> />
                  <?php echo Helpers\escape($tag['nom']); ?>
                </label>
              <?php endforeach; ?>
            </div>

            <div>
              <input class="ct-btn ct-btn--primary" type="submit" value="Enregistrer" />
              <input class="ct-btn ct-btn--ghost" type="reset" value="Réinitialiser" />
            </div>
          </form>
        </div>

        <!-- Colonne latérale -->
        <?php include '../app/views/templates/partials/_aside.php'; ?>
      </div>
      <!-- /.row -->
    </div>