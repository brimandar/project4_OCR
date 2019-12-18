<?php
    $config = HTMLPurifier_Config::createDefault();
    $purifier = new HTMLPurifier($config);
?>
    

    <?php
    $route = isset($news) && $news->getId() ? 'editNews&newsId='.$news->getId() : 'addNews';
    $submit = $route === 'addNews' ? 'Envoyer' : 'Mettre à jour';
    $title = isset($news) && $news->getTitle() ? htmlspecialchars($news->getTitle()) : '';
    $content = isset($news) && $news->getContent() ? $purifier->purify($news->getContent()) : '';
    $admin = $this->_request->getSession('username')->get('id');
    ?>

    <form method="post" action="../public/index.php?route=<?= $route; ?>">
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
        <input type="submit" value="<?= $submit; ?>" id="submit" name="submit">

    </form>

