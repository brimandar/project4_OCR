<head>
    <link href="../public/css/single.css" rel="stylesheet">
</head>
<!-- security TinyMCE HTML Purifier -->
<?php
    $config = HTMLPurifier_Config::createDefault();
    $purifier = new HTMLPurifier($config);
?>


<div class="post">
<?php if ($comments) : ?>

<?php foreach ($comments as $comment) : ?>
    <div class="item" id="<?= $comment->getId();?>">
        <h4 class="mt-4"><?= htmlspecialchars($comment->getUsername());?></h4>
        <p><?= htmlspecialchars($comment->getContent());?></p>
        <p class="mb-1">Posté le <?= htmlspecialchars($comment->getCreated_at());?></p>
        <!-- For each comment, if user connected -->
        <?php if ($this->_session->get('username')) : ?>
            <!-- If comment has been flagged  -->
            <?php if ($comment->isFlag()) : ?>
                <p>Ce commentaire a déjà été signalé</p>
            <!-- Else, show command to report a comment -->
            <?php else : ?>
                <p><a class="mr-2" href="../public/index.php?route=flagComment&commentId=<?= $comment->getId(); ?>">Signaler le contenu </a>
            <?php endif; ?>
            <!-- if the logged-on user is equal to the user who wrote the message, the delete command is visible -->
            <?php if ( strtolower($this->_session->get('username')) == strtolower(htmlspecialchars($comment->getUsername())) ) : ?>
            <?php endif; ?>
        <?php endif; ?>
    </div>
<?php endforeach ?>
<!-- If no comment -->
<?php else : ?>
<p>Pas de commentaires.</p>
<?php endif; ?>
</div>
