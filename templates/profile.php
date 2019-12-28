<?php $title; ?>

<div class="container">

    <div class="row">
        <h1 class="col-12">Bienvenue <?= $this->_session->get('username');?></h1>
        <p class="col-12 mb-4">Ici, vous pouvez modifier vote mot de passe ou supprimer votre compte.</p>
    </div>
    <div class="row">
        <ul>
            <li class="mb-4"><a href="../public/index.php?route=updatePassword">Modifier son mot de passe</a></li>
            <li><a href="../public/index.php?route=deleteAccount">Supprimer mon compte</a></li>
        </ul>
    </div>

    <div class="row" id="myComments">
            <h2>Mes commentaires</h2>
            <?php if($comments) : ?>
            <table class="table table-bordered table-responsive-sm">
                <thead class="thead-dark">
                    <tr>
                        <td scope="col">Date</td>
                        <td scope="col">Chapitre</td>
                        <td scope="col">Message</td>
                        <td scope="col">Actions</td>
                    </tr>
                </thead>
                <?php
                foreach ($comments as $comment)
                {
                    ?>
                    <tr>
                        <td><?= htmlspecialchars(date("d-m-Y", strtotime($comment->getCreated_at())));?></td>
                        <td><a href="../public/index.php?route=chapitre&chapterId=<?= $comment->getChapter_id();?>"><?= htmlspecialchars($comment->getTitleChapter());?></a></td>
                        <td><?= htmlspecialchars($comment->getContent());?></td>
                        <td>
                            <a id="commandSupprCommentAdmin_<?= $comment->getId();?>" class="commandSupprCommentAdmin_" href="#commandSupprCommentAdmin_">Supprimer</a>
                        </td>
                    </tr>
                    <?php
                }
                ?>
            </table>
            <?php else : ?>
                <p>Aucun commentaire.</p>
            <?php endif; ?>
        </div>

</div>