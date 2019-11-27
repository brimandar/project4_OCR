<?php

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
    </div>
</body>
</html>