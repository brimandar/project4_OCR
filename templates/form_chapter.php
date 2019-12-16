<!-- TinyMCE -->
    <script src="https://cdn.tiny.cloud/1/irmbudytgj8u8svw00m9xt5gq7tqa8m85x1w1a0j6owdpjdm/tinymce/5/tinymce.min.js" referrerpolicy="origin"></script>
    <script>
        tinymce.init({
                selector: 'textarea#contentText',
                language_url : '../config/languages/fr_FR.js',
                language: 'fr_FR',
                menubar: false,
                plugins: [
                'advlist autolink lists link image charmap print preview anchor',
                'searchreplace visualblocks code fullscreen',
                'insertdatetime media table paste code emoticons wordcount'
                ],
                toolbar: 'undo redo | formatselect | ' +
                ' bold italic forecolor backcolor | alignleft aligncenter ' +
                ' alignright alignjustify | bullist numlist outdent indent |' +
                ' removeformat | emoticons',
                });
    </script>
<!-- security TinyMCE HTML Purifier -->
<?php
    $config = HTMLPurifier_Config::createDefault();
    $purifier = new HTMLPurifier($config);
?>

    <?php
    $route = isset($chapter) && $chapter->getId() ? 'editChapter&chapterId='.$chapter->getId() : 'addChapter';
    $submit = $route === 'addChapter' ? 'Envoyer' : 'Mettre à jour';
    $title = isset($chapter) && $chapter->getTitle() ? htmlspecialchars($chapter->getTitle()) : '';
    $content = isset($chapter) && $chapter->getContent() ? $purifier->purify($chapter->getContent()) : '';
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

