<?php

use App\src\DAO\ChapterDAO;

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
            $chapters = $donnees->getChapters();

            while($chapter = $chapters->fetch())
            {
                ?>
                <div>
                <h2>
                    <a href = "index.php?route=chapitre&chapterId=<?= htmlspecialchars($chapter->id); ?>"><?= htmlspecialchars($chapter->title);?></a>
                </h2>
                <p><?= nl2br(htmlspecialchars($chapter->content));?></p>
                <p>Créé le : <?= htmlspecialchars($chapter->created_at);?></p>
                </div>
                <br>
                <?php
            }
        $chapters->closeCursor();
        ?>
    </div>
</body>
</html>