<!-- Form use to add or edit chapter -->

<!-- security TinyMCE HTML Purifier -->
<?php
    $config = HTMLPurifier_Config::createDefault();
    $purifier = new HTMLPurifier($config);
?>

    <?php
    // add chapter or edit chapter ?
    $route = isset($chapter) && $chapter->getId() ? 'editChapter&chapterId='.$chapter->getId() : 'addChapter';
    $submit = $route === 'addChapter' ? 'Envoyer' : 'Mettre à jour';
    $title = isset($chapter) && $chapter->getTitle() ? htmlspecialchars($chapter->getTitle()) : '';
    $content = isset($chapter) && $purifier->purify($chapter->getContent()) ? $purifier->purify($chapter->getContent()) : '';
    $imageText = $route === 'addChapter' ? 'Ajouter une image (facultatif)' : 'Modifier cette image';
    $imageLoaded = isset($chapter) && $chapter->getImage() ? $chapter->getImage() : '';
    $admin = $this->_request->getSession('username')->get('id');
    
    if( isset($post)) { 
        $route = $post->get('route');
        $submit = $route === 'addChapter' ? 'Envoyer' : 'Mettre à jour';
        $title = $post->get('title');
        $content = $post->get('content');
        $imageLoaded = $post->get('imageURL');
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
        <label>Image illustrant le chapitre :</label>
        <div class="d-none d-lg-block">
                <?php if(isset($chapter) && $chapter->getId()) : ?>
                    <?php if ($purifier->purify($chapter->getImage())) {
                    $pathImage = '"' . $chapter->getImage() . '"' ;
                    } else {
                    $pathImage = "../public/img/last_chapter.jpg";
                    } ?>
                    <img src=<?= $pathImage ?> class="bd-placeholder-img" width="200" height="200"
                        preserveAspectRatio="xMidYMid slice" focusable="false">
                <?php endif ?>
            </div>
        <label for="fileToUpload"><?= $imageText; ?></label>
        <input type="file" name="fileToUpload">
        <input type="hidden" name="imageURL" id="imageURL" value="<?= $imageLoaded; ?>">
        <input type="hidden" name="route" id="route" value="<?= $route; ?>">
        <?php if( isset($errorImage) ) : ?>
                    <div class="alert alert-danger" role="alert">
                        <?= $errorImage ?>
                    </div>
                <?php endif ?>

        <hr>

        <input style="display:none;" name="image" type="file" id="upload" class="hidden" onchange="">
        <input type="submit" class="btn btn-primary" value="<?= $submit; ?>" id="submit" name="submit">

    </form>

