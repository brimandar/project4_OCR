<head>
<link href="../public/css/home.css" rel="stylesheet">
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
<script src="../public/js/home.js"></script>
</head>

<?php $title; ?>

<!-- confirmation message -->
<div class="alert alert-success messageConfirmation">
    <?php if (
        $this->_session->get('login') ||
        $this->_session->get('add_comment') ||
        $this->_session->get('flag_comment') ||
        $this->_session->get('delete_comment') ||
        $this->_session->get('register') ||
        $this->_session->get('logout') ||
        $this->_session->get('delete_account') ||
        $this->_session->get('need_login') ||
        $this->_session->get('not_admin')
        ) : ?>
        <script>
            // alert("Bonjour");
            afficherMessageConfirmation();
        </script>
    <?php endif ?>
    <?= $this->_session->show('add_comment'); ?>
    <?= $this->_session->show('flag_comment'); ?>
    <?= $this->_session->show('delete_comment'); ?>
    <?= $this->_session->show('register'); ?>
    <?= $this->_session->show('login'); ?>
    <?= $this->_session->show('logout'); ?>
    <?= $this->_session->show('delete_account'); ?>
    <?= $this->_session->show('need_login'); ?>
    <?= $this->_session->show('not_admin'); ?>
</div>
<!-- Presentation bloc (author and img)  -->
<div class="jumbotron p-4 p-md-5 text-white rounded bg-dark">
    <div class="row">
        <div class="col-6 px-0">
            <h1 class="display-4">Mon nouveau roman en ligne <br> <span class="font-italic" >Jean Forteroche</span></h1>
            <p class="lead my-3">Ecrivain dans l'air du temps, je vous présente mon nouveau roman sur ce blog. Je publierai chaque nouveau chapitre à interval régulier. Si vous vous inscrivez, vous pourrez me laisser vos commentaires.</p>
            <p class="lead mb-0"><a href="#" class="text-white font-weight-bold">Continue reading...</a></p>
        </div>
        <div class="col-6 px-0 media">
            <img class="rounded img-fluid" src="../public/img/alaska.jpg" alt="" srcset="">
        </div>
    </div>

</div>

<?php
foreach ($chapters as $chapter)
{
    
?>
    <div>
    <h2>
        <a href = "index.php?route=chapitre&chapterId=<?= htmlspecialchars($chapter->getId()); ?>"><?= htmlspecialchars($chapter->getTitle());?></a>
    </h2>
    <p><?= substr(nl2br(htmlspecialchars($chapter->getContent())),0,1000);?>...</p>
    <p>Créé le : <?= htmlspecialchars($chapter->getCreated_at());?></p>
    </div>
    <br>
<?php
}
?>

