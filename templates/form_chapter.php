<?php
$route = isset($chapter) && $chapter->getId() ? 'editChapter&chapterId='.$chapter->getId() : 'addChapter';
$submit = $route === 'addChapter' ? 'Envoyer' : 'Mettre à jour';
$title = isset($chapter) && $chapter->getTitle() ? htmlspecialchars($chapter->getTitle()) : '';
$content = isset($chapter) && $chapter->getContent() ? htmlspecialchars($chapter->getContent()) : '';
$admin = $this->_request->getSession('username')->get('id');
var_dump($admin);
?>

<form method="post" action="../public/index.php?route=<?= $route; ?>">

    <label for="title">Titre</label><br>
    <input type="text" id="title" name="title" value="<?= $title; ?>"><br>

    <label for="content">Contenu</label><br>
    <textarea id="content" name="content"><?= $content; ?></textarea><br>

    <input type="submit" value="<?= $submit; ?>" id="submit" name="submit">

</form>