<div>

    <div class=>
        <h1 >Bienvenue <?= $this->_session->get('username');?></h1>
        <p class="mb-4">Ici, vous pouvez modifier vote mot de passe ou supprimer votre compte.</p>
    </div>
    <div>
        <ul>
            <li class="mb-4"><a href="modifierMDP">Modifier son mot de passe</a></li>
            <li><a href="/index.php?route=deleteAccount">Supprimer mon compte</a></li>
        </ul>
    </div>

    <div id="myComments">
            <h2>Mes commentaires</h2>
            <?php if($comments) : ?>
                <table id="table-comments-profil" class="table table-bordered table-striped">
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
                            <td><a href="chapitre-<?= $comment->getChapter_id();?>"><?= htmlspecialchars($comment->getTitleChapter());?></a></td>
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

