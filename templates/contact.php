<script src="https://www.google.com/recaptcha/api.js?render=6LeDLcgUAAAAALeYgj_EEJIeZ5RRHVPWej4JEywC"></script>

<h1>Formulaire de contact</h1>
<p>Une remarque ? Une suggestion ? N'hésitez-pas à m'écrire.</p>
<hr class="writerLine">
<div class="container">
    <form method="post" action="../public/index.php?route=contact">

        <div class="form-row">
            <div class="form-group col-md-6">
                <label for="name">Nom</label><br>
                <input class="form-control" type="text" id="name" name="name" value="<?= isset($post) ? htmlspecialchars($post->get('name')): ''; ?>">
                <?php if( isset($errors['name']) ) : ?>
                    <div class="alert alert-danger" role="alert">
                        <?= $errors['name'] ?>
                    </div>
                <?php endif ?>
            </div>
            <div class="form-group col-md-6">
                <label for="email">Email</label>
                <input class="form-control" type="text" id="email" name="email" placeholder="name@example.com" value="<?= isset($post) ? htmlspecialchars($post->get('email')): ''; ?>">
                <small id="emailHelp" class="form-text text-muted">Votre email ne sera jamais utilisé à des fins commerciales.</small>
                <?php if( isset($errors['email']) ) : ?>
                    <div class="alert alert-danger" role="alert">
                        <?= $errors['email'] ?>
                    </div>
                <?php endif ?>
            </div>
        </div>

        <div class="form-group">

            <label for="title">Titre</label>
            <input class="form-control" type="text" id="title" name="title" maxlength="100" value="<?= isset($post) ? htmlspecialchars($post->get('title')): ''; ?>">
            <?php if( isset($errors['title']) ) : ?>
                <div class="alert alert-danger" role="alert">
                    <?= $errors['title'] ?>
                </div>
            <?php endif ?>

            <label for="exampleFormControlTextarea1">Votre message</label>
            <textarea class="form-control" id="content" name="content" rows="3" ><?= isset($post) ? htmlspecialchars($post->get('content')): ''; ?></textarea>
            <?php if( isset($errors['content']) ) : ?>
                <div class="alert alert-danger" role="alert">
                    <?= $errors['content'] ?>
                </div>
            <?php endif ?>

        </div>

        <!-- Content token capcha -->
        <input type="hidden" name="recaptcha_response" id="recaptchaResponse">
        
        <input class="btn btn-primary" type="submit" value="Envoyer votre message" id="submit" name="submit">

    </form>

</div>
<!-- JS for execute ReCaptcha V3 by Google -->
<script>
    grecaptcha.ready(function() {
        grecaptcha.execute('6LeDLcgUAAAAALeYgj_EEJIeZ5RRHVPWej4JEywC', {action: 'contact'}).then(function(token) {
            var recaptchaResponse = document.getElementById('recaptchaResponse');
            recaptchaResponse.value = token;
        });;
    });
  </script>