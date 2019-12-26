<?php $this->title = 'Modifier mot mot de passe'; ?>

<h1>Modifier mon mot de passe</h1>

<div>

    <p>Le mot de passe de <?= $this->_session->get('username'); ?> sera modifié</p>

    <div class="row col-md-6">
        <form id="formUpdatePwd" method="post" action="../public/index.php?route=updatePassword">
            <div class="form-group">
                <label for="password">Mot de passe</label><br>
                <input class="form-control" type="password" id="password" name="password"><br>
                <label for="confirmpassword">Confirmer le mot de passe</label>
                <input class="form-control" type="password" id="confirmpassword" name="confirmpassword">
                <span></span>
                <?php if( isset($errors['password']) ) : ?>
                    <div class="alert alert-danger" role="alert">
                    <?= $errors['password'] ?>
                    </div>
                <?php endif ?>
            </div>
            <input class="btn btn-primary" type="submit" value="Mettre à jour" id="submit" name="submit">
        </form>
    </div>
</div>