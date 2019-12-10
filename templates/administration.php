<?php $title; ?>

<h1>Mon blog</h1>
<p>En construction</p>

<?= $this->_session->show('add_chapter'); ?>
<?= $this->_session->show('edit_chapter'); ?>
<?= $this->_session->show('delete_chapter'); ?>
<?= $this->_session->show('delete_comment'); ?>
<?= $this->_session->show('unflag_comment'); ?>
<?= $this->_session->show('delete_user'); ?>

<h2>Articles</h2>
<a href="../public/index.php?route=addChapter">Nouvel article</a>

<table class="table table-bordered">
    <thead class="thead-dark">
        <tr>
            <td scope="col">Titre</td>
            <td scope="col">Contenu</td>
            <td scope="col">Auteur</td>
            <td scope="col">Date</td>
            <td scope="col">Actions</td>
        </tr>
    </thead>
    <tbody>
        <?php
        foreach ($chapters as $chapter)
        { ?>
            <tr>
                <td><a href="../public/index.php?route=chapitre&chapterId=<?= htmlspecialchars($chapter->getId());?>"><?= htmlspecialchars($chapter->getTitle());?></a></td>
                <td><?= substr(htmlspecialchars($chapter->getContent()), 0, 150);?></td><!-- Limit 150 caracters -->
                <td><?= htmlspecialchars($chapter->getUsername());?></td>
                <td>Créé le : <?= htmlspecialchars($chapter->getCreated_at());?></td>
                <td>
                    <a href="../public/index.php?route=editChapter&chapterId=<?= $chapter->getId(); ?>">Modifier</a>
                    <a href="../public/index.php?route=deleteChapter&chapterId=<?= $chapter->getId(); ?>">Supprimer</a>
                </td>
            </tr>
            <?php
        } ?>
    </tbody>
</table>

<h2>Commentaires signalés</h2>
<table>
    <tr>
        <td>Id</td>
        <td>Pseudo</td>
        <td>Message</td>
        <td>Date</td>
        <td>Actions</td>
    </tr>
    <?php
    foreach ($comments as $comment)
    {
        ?>
        <tr>
            <td><?= htmlspecialchars($comment->getId());?></td>
            <td><?= htmlspecialchars($comment->getUsername());?></td>
            <td><?= substr(htmlspecialchars($comment->getContent()), 0, 150);?></td>
            <td>Créé le : <?= htmlspecialchars($comment->getCreated_at());?></td>
            <td>
                <a href="../public/index.php?route=unflagComment&commentId=<?= $comment->getId(); ?>">Désignaler le commentaire</a>
                <a href="../public/index.php?route=deleteComment&commentId=<?= $comment->getId(); ?>">Supprimer le commentaire</a>
            </td>
        </tr>
        <?php
    }
    ?>
</table>

<h2>Utilisateurs</h2>

<table>
    <tr>
        <td>Id</td>
        <td>Pseudo</td>
        <td>Date</td>
        <td>Rôle</td>
        <td>Actions</td>
    </tr>
    <?php
    foreach ($users as $user)
    {
        ?>
        <tr>
            <td><?= htmlspecialchars($user->getId());?></td>
            <td><?= htmlspecialchars($user->getUsername());?></td>
            <td>Créé le : <?= htmlspecialchars($user->getCreated_at());?></td>
            <td><?= htmlspecialchars($user->getRole());?></td>
            <td><?php
                if($user->getRole() != 'admin') {
                ?>
                <a href="../public/index.php?route=deleteUser&userId=<?= $user->getId(); ?>">Supprimer</a>
                <?php }
                else { ?>
                Suppression impossible
                <?php } ?>
            </td>
        </tr>
    <?php
    }
    ?>
</table>

<a href="index.php">Retour à l'accueil</a>