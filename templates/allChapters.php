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

<?php foreach ($chapters as $chapter) : ?>
    <div>
    <h2>
        <a href = "index.php?route=chapitre&chapterId=<?= htmlspecialchars($chapter->getId()); ?>"><?= htmlspecialchars($chapter->getTitle());?></a>
    </h2>
    <p><?= $purifier->purify(substr($chapter->getContent(),0,1000));?>...</p>
    <p>Créé le : <?= htmlspecialchars($chapter->getCreated_at());?></p>
    </div>
    <br>
<?php endforeach ?>

<hr>

<?php 
// For previous and next button pagination
$current_page = ((int)$this->_request->getGet()->get('page'));
$previous = 1;
$next = $nb_pages;
?>

<?php if(isset($current_page) && $current_page>1) {
    $previous = $current_page - 1;
} ?>
<?php if(isset($current_page) && $current_page<$nb_pages) {
    $next = $current_page + 1;
} ?>

<nav aria-label="...">
    <ul class="pagination">
        <li class="page-item previous">
        <a class="page-link" tabindex="-1" aria-disabled="true" href="../public/index.php?route=allChapters&page=<?= $previous;?>">Previous</a>
        </li>
        <?php for ($i=1; $i<=$nb_pages; $i++) : ?> 
            <li class="page-item"> 
                <a class="page-link" href="../public/index.php?route=allChapters&page=<?= $i;?> "> <?= $i; ?> </a>
            </li>
        <?php endfor; ?>
        <li class="page-item">
        <a class="page-link" href="../public/index.php?route=allChapters&page=<?= $next;?>">Next</a>
        </li>
    </ul>
</nav>