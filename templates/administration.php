<head>
    <link href="../public/css/admin.css" rel="stylesheet">
</head>
<?php $title; ?>

<!-- security TinyMCE HTML Purifier -->
<?php
    $config = HTMLPurifier_Config::createDefault();
    $purifier = new HTMLPurifier($config);
?>

<h1 class="p-3 mb-2 bg-dark text-white">Administration</h1>
<hr class="softenedLine">
<div class="row">
    <div id="list-example" class="col-sm-4 col-md-2 list-group">
        <a class="select1 active list-group-item list-group-item-action" href="#list-item-1">Chapitres</a>
        <a class="select2 list-group-item list-group-item-action" href="#list-item-2">Commentaires</a>
        <a class="select3 list-group-item list-group-item-action" href="#list-item-3">Utilisateurs</a>
        <a class="select4 list-group-item list-group-item-action" href="#list-item-4">News</a>
    </div>
    <div id="modulesAdmin" class="col-sm-8 col-md-10">
        <!-- Chapters admin -->
        <div id="chapter_admin" class="col-12">
            <h2>Le roman</h2>
            <a class="btn btn-primary btn-lg mb-2" href="../public/index.php?route=addChapter">Nouveau chapitre</a>
            <table id="table_chapters_admin" class="table table-bordered table-striped">
                <thead class="thead-dark">
                    <tr>
                        <td scope="col">Titre</td>
                        <td scope="col">Contenu</td>
                        <td scope="col">Auteur</td>
                        <td scope="col">Créé le</td>
                        <td scope="col">Actions</td>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    foreach ($chapters as $chapter)
                    { ?>
                    <tr>
                        <td><a
                                href="../public/index.php?route=chapitre&chapterId=<?= htmlspecialchars($chapter->getId());?>"><?= htmlspecialchars($chapter->getTitle());?></a>
                        </td>
                        <td><?= $purifier->purify(substr($chapter->getContent(), 0, 150));?></td><!-- Limit 150 caracters -->
                        <td><?= htmlspecialchars($chapter->getUsername());?></td>
                        <td><?= htmlspecialchars($chapter->getCreated_at());?></td>
                        <td>
                            <a
                                href="../public/index.php?route=editChapter&chapterId=<?= $chapter->getId(); ?>">Modifier</a>
                            <a id="commandSupprChapter_<?= $chapter->getId();?>" class="commandSupprChapter_"
                                href="#commandSupprChapter_">Supprimer</a>
                        </td>
                    </tr>
                    <?php
                    } ?>
                </tbody>
            </table>
        </div>
        <!-- Comments admin -->
        <div id="comment_admin">
            <h2>Commentaires signalés</h2>
            <?php if($comments) : ?>
            <table class="table table-bordered">
                <thead class="thead-dark">
                    <tr>
                        <td scope="col">Pseudo</td>
                        <td scope="col">Message</td>
                        <td scope="col">Date</td>
                        <td scope="col">Actions</td>
                    </tr>
                </thead>
                <?php foreach ($comments as $comment)
                { ?>
                <tr>
                    <td><?= htmlspecialchars($comment->getUsername());?></td>
                    <td><?= substr(htmlspecialchars($comment->getContent()), 0, 150);?></td>
                    <td>Créé le : <?= htmlspecialchars($comment->getCreated_at());?></td>
                    <td>
                        <a href="../public/index.php?route=unflagComment&commentId=<?= $comment->getId(); ?>">Désignaler
                            le commentaire</a>
                        <a id="commandSupprCommentAdmin_<?= $comment->getId();?>" class="commandSupprCommentAdmin_"
                            href="#commandSupprCommentAdmin_">Supprimer le commentaire</a>
                    </td>
                </tr>
                <?php } ?>
            </table>
            <?php else : ?>
            <p>Aucun commentaire n'a été signalé.</p>
            <?php endif; ?>
        </div>
        <!-- Newsletter -->
        <div id="news_admin" class="col-12">
            <h2>Newsletters (visibles sur la page d'accueil)</h2>
            <a class="btn btn-primary btn-lg mb-2" href="../public/index.php?route=addNews">Publier une news</a>
            <?php if($news) : ?>
            <table id="table_newsletters_admin" class="table table-bordered table-striped">
                <thead class="thead-dark">
                    <tr>
                        <td scope="col">Titre</td>
                        <td scope="col">Contenu</td>
                        <td scope="col">Date de création</td>
                        <td scope="col">Actions</td>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    foreach ($news as $new)
                    { ?>
                    <tr>
                        <td><?= htmlspecialchars($new->getTitle());?></td>
                        <td><?= $purifier->purify(substr($new->getContent(), 0, 150));?></td><!-- Limit 150 caracters -->
                        <td><?= htmlspecialchars($new->getCreated_at());?></td>
                        <td>
                            <a href="../public/index.php?route=editNews&newsId=<?= $new->getId(); ?>">Modifier</a>
                            <a id="btnDeleteNews_<?= $new->getId(); ?>" class="btnDeleteNews_" href="#">Supprimer</a>
                        </td>
                    </tr>
                    <?php } ?>
                </tbody>
            </table>
            <?php else : ?>
            <p>Aucune newsletter.</p>
            <?php endif; ?>
        </div>
        <!-- Users admin -->
        <div id="users_admin" class="col-12">
            <h2>Gestion des membres</h2>
            <table id="table_users_admin" class="col-12 table table-bordered">
                <thead class="thead-dark">
                    <tr>
                        <td scope="col">Pseudo</td>
                        <td scope="col">Créé le</td>
                        <td scope="col">Rôle</td>
                        <td scope="col">Actions</td>
                    </tr>
                </thead>
                <?php
                foreach ($users as $user)
                { ?>
                <tr>
                    <td><?= htmlspecialchars($user->getUsername());?></td>
                    <td><?= htmlspecialchars($user->getCreated_at());?></td>
                    <td><?= htmlspecialchars($user->getRole());?></td>
                    <td><?php
                            if($user->getRole() != 'admin') {
                            ?>
                        <a id="btnDeleteUser_<?= $user->getId(); ?>" class="btnDeleteUser_" href="#">Supprimer</a>
                        <?php }
                            else { ?>
                        Suppression impossible
                        <?php } ?>
                    </td>
                </tr>
                <?php
                } ?>
            </table>
        </div>
    </div>
</div>