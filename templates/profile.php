<?php $this->title = 'Mon profil'; ?>

<h1>Mon blog</h1>
<p>En construction</p>

<?= $this->_session->show('update_password'); ?>

<div>
    <h2><?= $this->_session->get('username'); ?></h2>
    <p><?= $this->_session->get('id'); ?></p>
    <a href="../public/index.php?route=updatePassword">Modifier son mot de passe</a>
    <a href="../public/index.php?route=deleteAccount">Supprimer mon compte</a>
</div>
<br>
<a href="../public/index.php">Retour à l'accueil</a>