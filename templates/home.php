<head>
<link href="../public/css/home.css" rel="stylesheet">
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
<script src="../public/js/home.js"></script>
</head>
  
<!-- security TinyMCE HTML Purifier -->
<?php
    $config = HTMLPurifier_Config::createDefault();
    $purifier = new HTMLPurifier($config);
?>

<?php $title;?>

<body>

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
            <p class="lead mb-0"><a href="../public/index.php?route=allChapters" class="text-white font-weight-bold">Accès au livre...</a></p>
        </div>
        <div class="col-6 px-0 media">
            <img class="rounded img-fluid" src="../public/img/alaska.jpg" alt="" srcset="">
        </div>
    </div>

</div>
<!-- The last chapter -->
<div class="row mb-2">
    <div class="col-md-12">
      <div class="row no-gutters border rounded overflow-hidden flex-md-row mb-4 shadow-sm h-md-250 position-relative">
        <div class="col p-4 d-flex flex-column position-static">
            <strong class="d-inline-block mb-2 text-primary">Dernier chapitre</strong>
            <h3 class="mb-0"><?= htmlspecialchars($chapter->getTitle());?></h3>
            <div class="mb-1 text-muted"><?= $chapter->getCreated_at();?></div>
                <p class="card-text mb-auto"><?= $purifier->purify(substr($chapter->getContent(),0,200));?>...</p>
                <a href="index.php?route=chapitre&chapterId=<?= htmlspecialchars($chapter->getId()); ?>" class="stretched-link">Continuer à lire</a>
            </div>
        <div class="col-auto d-none d-lg-block">
            <?php if ($purifier->purify($chapter->getImage())) {
                $pathImage = '"' . $chapter->getImage() . '"' ;
            } else {
                $pathImage = "../public/img/last_chapter.jpg";
            } ?>
            <img src=<?= $pathImage ?> class="bd-placeholder-img" width="200" height="250" preserveAspectRatio="xMidYMid slice" focusable="false">
        </div>
    </div>
</div>
<!-- Newsletters -->
<main role="main" class="container">
  <div class="row">
    <div class="col-md-8 blog-main">
      <h3 class="derrierePlume pb-4 mb-4 font-italic border-bottom">
        Derrière la plume...<br>Mes dernières nouvelles
      </h3>

    <hr>

        <?php foreach ($news as $new) : ?>
            <div class="blog-post">
                <h2 class="blog-post-title"><?= htmlspecialchars($new->getTitle()) ?></h2>
                <p class="blog-post-meta"><?= htmlspecialchars($new->getCreated_at()) ?></p>
                <p class="blog-post-meta"><?= $purifier->purify($new->getContent()) ?></p>
                </div>
                <hr>
        <?php endforeach; ?>

    </div>

    <aside class="col-md-4 blog-sidebar">
      <div class="p-4 mb-3 bg-light rounded">
        <h4 class="font-italic">About</h4>
        <p class="mb-0">Etiam porta <em>sem malesuada magna</em> mollis euismod. Cras mattis consectetur purus sit amet fermentum. Aenean lacinia bibendum nulla sed consectetur.</p>
      </div>
    <!-- Archives (dynamic) -->
      <div class="p-4">
        <h4 class="font-italic">Archives</h4>
        <ol class="list-unstyled mb-0">
            <?php foreach($monthsChapter as $monthChapter) : ?>
                <li><a href="../public/index.php?route=archives&year=<?= date('Y', strtotime($monthChapter)); ?>&month=<?= date('m', strtotime($monthChapter)); ?>"><?= $monthChapter ?></a></li>
            <?php endforeach; ?>
        </ol>
      </div>

      <div class="p-4">
        <h4 class="font-italic">Elsewhere</h4>
        <ol class="list-unstyled">
          <li><a href="#">GitHub</a></li>
          <li><a href="#">Twitter</a></li>
          <li><a href="#">Facebook</a></li>
        </ol>
      </div>
    </aside><!-- /.blog-sidebar -->

  </div><!-- /.row -->

</main><!-- /.container -->

</body>