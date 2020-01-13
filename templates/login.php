<h1>Se connecter</h1>

<?= $this->_session->show('error_login'); ?>

<form method="post" action="index.php?route=login">
    <div class="form-group col-md-6">

        <label for="username">Pseudo</label><br>
        <input class="form-control" type="text" id="username" name="username" value="<?= isset($post) ? htmlspecialchars($post->get('username')): ''; ?>"><br>

        <label for="password">Mot de passe</label><br>
        <input class="form-control" type="password" id="password" name="password"><br>

        <input class="btn btn-primary" type="submit" value="Connexion" id="submit" name="submit">

    </div>

</form>

<script src="/js/login.js"></script>

<?php
if (isset($confirmationMsg)) {
    echo "<i>Merci de vous être enregistré. Vous pouvez vous connecter.</i>";
}
?>