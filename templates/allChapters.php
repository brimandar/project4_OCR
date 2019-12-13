<head>
<link href="../public/css/home.css" rel="stylesheet">
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
<script src="../public/js/home.js"></script>
</head>

<?php $title; ?>

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

