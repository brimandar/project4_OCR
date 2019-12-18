<!-- security TinyMCE HTML Purifier -->
<?php
    $config = HTMLPurifier_Config::createDefault();
    $purifier = new HTMLPurifier($config);
?>

    <?php
    $route = isset($chapter) && $chapter->getId() ? 'editChapter&chapterId='.$chapter->getId() : 'addChapter';
    $submit = $route === 'addChapter' ? 'Envoyer' : 'Mettre à jour';
    $title = isset($chapter) && $chapter->getTitle() ? htmlspecialchars($chapter->getTitle()) : '';
    $content = isset($chapter) && $purifier->purify($chapter->getContent()) ? $purifier->purify($chapter->getContent()) : '';
    $admin = $this->_request->getSession('username')->get('id');
    
    if( isset($post)) { 
        $title = $post->get('title');
        $content = $post->get('content');
     };

    ?>

    <form method="post" action="../public/index.php?route=<?= $route; ?>" enctype="multipart/form-data">
        <div class="form-group">
            <label for="title">Titre</label>
            <input class="form-control" type="text" id="title" name="title" value="<?= $title; ?>">
            <?php if( isset($errors['title']) ) : ?>
                    <div class="alert alert-danger" role="alert">
                        <?= $errors['title'] ?>
                    </div>
                <?php endif ?>
        </div>
        <div class="form-group">
            <label for="content">Contenu</label>
            <textarea id="contentText" name="content"><?= $content; ?></textarea>
            <?php if( isset($errors['content']) ) : ?>
                    <div class="alert alert-danger" role="alert">
                        <?= $errors['content'] ?>
                    </div>
                <?php endif ?>
        </div>
        <label for="fileToUpload">Ajouter une image (facultatif)</label><br>
        <input type="file" name="fileToUpload">
        <?php if( isset($errorImage) ) : ?>
                    <div class="alert alert-danger" role="alert">
                        <?= $errorImage ?>
                    </div>
                <?php endif ?>

        <hr>

        <input style="display:none;" name="image" type="file" id="upload" class="hidden" onchange="">
        <input type="submit" value="<?= $submit; ?>" id="submit" name="submit">

    </form>

