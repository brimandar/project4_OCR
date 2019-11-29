<?php $this->title="Accueil"; ?>

<h1>Mon blog</h1>
<p>En construction</p>
<?= $this->_session->show('add_article'); ?>
<a href="../public/index.php?route=addChapter">Nouveau chapitre</a>

<?php
foreach ($chapters as $chapter)
{
?>
    <div>
    <h2>
        <a href = "index.php?route=chapitre&chapterId=<?= htmlspecialchars($chapter->getId()); ?>"><?= htmlspecialchars($chapter->getTitle());?></a>
    </h2>
    <p><?= nl2br(htmlspecialchars($chapter->getContent()));?></p>
    <p>Créé le : <?= htmlspecialchars($chapter->getCreated_at());?></p>
    </div>
    <br>
<?php
}
?>
