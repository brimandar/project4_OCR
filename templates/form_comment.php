<?php
$route = isset($post) && $post->get('id') ? 'editComment' : 'addComment';
$submit = $route === 'addComment' ? 'Ajouter' : 'Mettre à jour';
?>

<form class="form-group" method="post" action="../public/index.php?route=<?= $route; ?>&chapterId=<?= htmlspecialchars($chapter->getId()); ?>">
    
    <label for="content">Message</label><br>
    <textarea id="content" class="form-control" name="content"><?= isset($post) ? htmlspecialchars($post->get('content')): ''; ?></textarea><br>
    <?= isset($errors['content']) ? $errors['content'] : ''; ?>
    <button type="submit" class="btn btn-primary" id="btnAddComment" name="submit" ><?= $submit; ?></button>

</form>