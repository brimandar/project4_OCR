<?php $this->title="Accueil"; ?>

<h1>Mon blog</h1>
<p>En construction</p>

<!-- confirmation message -->
<?= $this->_session->show('add_comment'); ?>
<?= $this->_session->show('flag_comment'); ?>
<?= $this->_session->show('delete_comment'); ?>
<?= $this->_session->show('register'); ?>
<?= $this->_session->show('login'); ?>
<?= $this->_session->show('logout'); ?>
<?= $this->_session->show('delete_account'); ?>
<?= $this->_session->show('need_login'); ?>
<?= $this->_session->show('not_admin'); ?>


<?php
if ($this->_session->get('username')) 
{
    ?>
    <a href="../public/index.php?route=logout">Déconnexion</a>
    <a href="../public/index.php?route=profile">Profil</a>
    <!-- If role=admin, access to admin menu -->
    <?php if($this->_session->get('role') === 'admin') { ?>
        <a href="../public/index.php?route=administration">Administration</a>
    <?php } ?>
    <?php
} else {
    ?>
    <a href="../public/index.php?route=register">Inscription</a>
    <a href="../public/index.php?route=login">Connexion</a>
    <?php
}
?>

<?php
foreach ($chapters as $chapter)
{
?>
    <div>
    <h2>
        <a href = "index.php?route=chapitre&chapterId=<?= htmlspecialchars($chapter->getId()); ?>"><?= htmlspecialchars($chapter->getTitle());?></a>
    </h2>
    <p><?= substr(nl2br(htmlspecialchars($chapter->getContent())),0,1000);?>...</p>
    <p>Créé le : <?= htmlspecialchars($chapter->getCreated_at());?></p>
    </div>
    <br>
<?php
}
?>
