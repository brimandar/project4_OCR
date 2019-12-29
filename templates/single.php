<head>
    <link href="../public/css/single.css" rel="stylesheet">
</head>

    <!-- security TinyMCE HTML Purifier -->
    <?php
        $config = HTMLPurifier_Config::createDefault();
        $purifier = new HTMLPurifier($config);
    ?>

    <?php $title; ?>
    <?php if ($chapter->getImage()) {
        $pathImage = '"' . $chapter->getImage() . '"' ;
    } else {
        $pathImage = "../public/img/last_chapter.jpg";
    } ?>

    <img src=<?= $pathImage ?> class="rounded float-left img-fluid mr-2 mb-2" width="200" height="250" preserveAspectRatio="xMidYMid slice" focusable="false">

        <h2><?= htmlspecialchars($chapter->getTitle());?></h2>
        <i>Créé le : <?= htmlspecialchars($chapter->getCreated_at());?></i>
        <p class="mt-4 text-justify"><?= $purifier->purify($chapter->getContent());?></p>
    </div>
    <br>


    <div id="comments" style="margin-left: 50px">
    <div class="singlechapterId"><?= htmlspecialchars($chapter->getId())?></div>
    <div class="userIdentification"><?= htmlspecialchars($this->_session->get('username'));?></div>

        <h3>Commentaires</h3>

        <!-- Add comment -->
        <?php if ($this->_session->get('username')) : ?>
            <h3 class="mt-4">Ajouter un commentaire</h3>
            <form id="formAddCommentUser" class="form-group" method="post" action="#">
                <label for="content">Message</label><br>
                <textarea id="content" class="content form-control" name="content"></textarea><br>
                <input type="submit" class="btn btn-primary" id="btnAddComment" name="submit">
            </form>
        <?php else : ?>
            <p class="mt-4"> 
                <a href="../public/index.php?route=register">S'inscrire</a> 
                ou
                <a href="../public/index.php?route=login">Se connecter</a>
                pour commenter.
            </p>
        <?php endif; ?>
        <!-- Comments load with AJAX -->
        <?php include('comments.php'); ?>
    </div>

    <div id="loader"><img src="../public/img/loader.gif" alt="loader"></div>
