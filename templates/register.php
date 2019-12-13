<?php $title; ?>

<h1>Inscription</h1>
<p>En vous inscrivant, vous pourrez commenter les chapitres.</p>

<div>
    <form method="post" action="../public/index.php?route=register">
        <div class="form-group">
            <label for="username">Pseudo</label><br>
            <input class="form-control" type="text" id="username" name="username" value="<?= isset($post) ? htmlspecialchars($post->get('username')): ''; ?>"><br>
            <?php if( isset($errors['username']) ) : ?>
                <div class="alert alert-danger" role="alert">
                    <?= $errors['username'] ?>
                </div>
            <?php endif ?>
        </div>
        <div class="form-group">
            <label for="password">Mot de passe</label>
            <input class="form-control" type="password" id="password" name="password"><br>
            <?php if( isset($errors['password']) ) : ?>
                <div class="alert alert-danger" role="alert">
                    <?= $errors['password'] ?>
                </div>
            <?php endif ?>
        </div>
        <div class="form-group">
            <label for="email">Email</label>
            <input class="form-control" type="text" id="email" name="email" placeholder="name@example.com">
            <small id="emailHelp" class="form-text text-muted">Votre email ne sera jamais utilisé à des fins commerciales.</small>
            <?php if( isset($errors['email']) ) : ?>
                <div class="alert alert-danger" role="alert">
                    <?= $errors['email'] ?>
                </div>
            <?php endif ?>
        </div>
            <input class="btn btn-primary" type="submit" value="Inscription" id="submit" name="submit">

    </form>

</div>