<?php $title; ?>

<h1>Mon blog</h1>
<p>En construction</p>

<div>
    <h2><?= htmlspecialchars($chapter->getTitle());?></h2>
    <p><?= nl2br($chapter->getContent());?></p>
    <p>Créé le : <?= htmlspecialchars($chapter->getCreated_at());?></p>
</div>
<br>

<a href="index.php">Retour à l'accueil</a>
<div id="comments" class="text-left" style="margin-left: 50px">

    <?php
    if ($this->_session->get('username'))
    { ?>
        <h3>Ajouter un commentaire</h3>
        <?php include('form_comment.php'); ?>
    <?php 
    } ?>

    <h3>Commentaires</h3>
        
    <?php
    if ($comments) 
    {
        foreach ($comments as $comment) 
        {
    ?>
            <h4><?= htmlspecialchars($comment->getUsername());?></h4>
            <p><?= htmlspecialchars($comment->getContent());?></p>
            <p>Posté le <?= htmlspecialchars($comment->getCreated_at());?></p>

            <?php
            if ($this->_session->get('username'))
            {
                if ($comment->isFlag()) 
                {
                    ?> <p>Ce commentaire a déjà été signalé</p> <?php
                } else {
                    ?> <p><a href="../public/index.php?route=flagComment&commentId=<?= $comment->getId(); ?>">Signaler le commentaire</a></p> <?php
                }
                ?>
                <!-- if the logged-on user is equal to the user who wrote the message, the delete command is visible -->
                <?php
                if ( $this->_session->get('username') === htmlspecialchars($comment->getUsername()) )
                { ?>
                <p><a href="../public/index.php?route=deleteComment&commentId=<?= $comment->getId(); ?>">Supprimer le commentaire</a></p>
                <?php 
                } 
            }
            ?>
    
    <?php
        }
    }
    ?>
</div>

