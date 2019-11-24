<?php

use App\src\DAO\ChapterDAO;
use App\src\DAO\CommentDAO;

?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="utf-8">
    <title>Mon blog</title>
</head>

<body>
<div>
    <h1>Mon blog</h1>
    <p>En construction</p>
    <?php
    $donnees = new ChapterDAO();
    $chapters = $donnees->getChapter($_GET['chapterId']);
    $chapter = $chapters->fetch()
    ?>
    <div>
        <h2><?= htmlspecialchars($chapter->title);?></h2>
        <p><?= nl2br(htmlspecialchars($chapter->content));?></p>
        <p>Créé le : <?= htmlspecialchars($chapter->created_at);?></p>
    </div>
    <br>
    <?php
    $chapters->closeCursor();
    ?>

    <a href="index.php">Retour à l'accueil</a>
        <div id="comments" class="text-left" style="margin-left: 50px">
            <h3>Commentaires</h3>
            <?php
            $comment = new CommentDAO();
            $comments = $comment->getCommentsFromChapter($_GET['chapterId']);
            while($comment = $comments->fetch())
            {
                ?>
                <h4><?= htmlspecialchars($comment->username);?></h4>
                <p><?= htmlspecialchars($comment->content);?></p>
                <p>Posté le <?= htmlspecialchars($comment->created_at);?></p>
                <?php
            }
            $comments->closeCursor();
            ?>
        </div>

</div>
</body>
</html>