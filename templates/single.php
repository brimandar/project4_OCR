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
    // $chapter = $chapters->fetch();
    
    ?>

    <div>
        <h2><?= htmlspecialchars($chapter->getTitle());?></h2>
        <p><?= nl2br(htmlspecialchars($chapter->getContent()));?></p>
        <p>Créé le : <?= htmlspecialchars($chapter->getCreated_at());?></p>
    </div>
    <br>
    <?php
    // $chapters->closeCursor();
    ?>

    <a href="index.php">Retour à l'accueil</a>
        <div id="comments" class="text-left" style="margin-left: 50px">
            <h3>Commentaires</h3>
            <?php
            
            if($comments) {
                    foreach ($comments as $comment) {
                    ?>
                    <h4><?= htmlspecialchars($comment->getUsername());?></h4>
                    <p><?= htmlspecialchars($comment->getContent());?></p>
                    <p>Posté le <?= htmlspecialchars($comment->getCreated_at());?></p>
                    <?php
                    }
                }
            ?>
        </div>

</div>
</body>
</html>