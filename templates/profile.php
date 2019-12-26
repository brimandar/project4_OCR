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
</div>