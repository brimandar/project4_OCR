<!-- basic template -->
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="Blog de l'écrivain Jean Forteroche">
    <meta name="author" content="Mark Otto, Jacob Thornton, and Bootstrap contributors">
    <title><?= $title ?></title>
    <!-- CSS -->
    <link href="../public/css/style.css" rel="stylesheet">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css" integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">
    <link href="../public/css/bootstrap.css" rel="stylesheet">
    <!-- Favicons -->
    <link rel="icon" href="../public/img/favicon.png">
    <meta name="msapplication-config" content="/docs/4.4/assets/img/favicons/browserconfig.xml">
    <meta name="theme-color" content="#563d7c">
    <!-- JQuery-confirm -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/jquery-confirm/3.3.2/jquery-confirm.min.css">
</head>

<body>

<div class="container">
    <header class="blog-header py-3">
        <div class="row flex-nowrap justify-content-between align-items-center">

            <div class="col-3 pt-1">
                <?php if ($this->_session->get('username')) : ?>
                    <?php if ($this->_session->get('role') === 'admin') : ?>
                        <a href="../public/index.php?route=administration">Administration</a>
                    <?php else : ?>
                        <a href="../public/index.php?route=profile">Profil</a>
                    <?php endif; ?>
                <?php else : ?>
                    <a class="text-muted" href="../public/index.php?route=register">S'inscrire</a>
                <?php endif; ?>
            </div>

            <div class="col-6 text-center">
                <a class="blog-header-logo text-dark" href="index.php">Billet simple pour l'Alaska</a>
            </div>
            <div class="col-3 d-flex justify-content-end align-items-center">
                <a class="text-muted" href="#" aria-label="Search">
                <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" class="mx-3" role="img" viewBox="0 0 24 24" focusable="false"><title>Search</title><circle cx="10.5" cy="10.5" r="7.5"/><path d="M21 21l-5.2-5.2"/></svg>
                </a>
                <?php if ($this->_session->get('username')) : ?>
                    <a class="btn btn-sm btn-outline-danger" href="../public/index.php?route=logout">Déconnexion</a>
                <?php else : ?>
                    <a class="btn btn-sm btn-outline-secondary" href="../public/index.php?route=login">Se connecter</a>
                <?php endif; ?>
            </div>
        </div>
    </header>

    <div class="nav-scroller py-1 mb-2">
        <nav class="nav d-flex justify-content-between">
        <a class="p-2 text-muted" href="index.php">Accueil</a>
        <a class="p-2 text-muted" href="../public/index.php?route=allChapters">Le roman</a>
        <a class="p-2 text-muted" href="#">Biographie</a>
        <a class="p-2 text-muted" href="../public/index.php?route=contact">Me contacter</a>
        </nav>
    </div>

    <div id="content">
        <?= $content ?>
    </div>

</div>
</body>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js" integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo" crossorigin="anonymous"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js" integrity="sha384-wfSDF2E50Y2D1uUdj0O3uMBJnjuUD4Ih7YwaYd1iqfktj0Uod8GCExl3Og8ifwB6" crossorigin="anonymous"></script>
<script src="../public/js/admin.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-confirm/3.3.2/jquery-confirm.min.js"></script>
<!-- TinyMCE -->
<script src="https://cdn.tiny.cloud/1/irmbudytgj8u8svw00m9xt5gq7tqa8m85x1w1a0j6owdpjdm/tinymce/5/tinymce.min.js" referrerpolicy="origin"></script>
        <script>
            tinymce.init({
                    selector: 'textarea#contentText',
                    language_url : '../config/languages/fr_FR.js',
                    language: 'fr_FR',
                    entity_encoding: "numeric",//This will send the emoticon to DB as HTML Dec code
                    menubar: "insert",
                    plugins: [
                    'advlist autolink lists link image charmap print preview anchor',
                    'searchreplace visualblocks code fullscreen',
                    'insertdatetime media table paste code  emoticons wordcount fullscreen'
                    ],
                    toolbar: 'undo redo | formatselect | ' +
                    ' bold italic forecolor backcolor | alignleft aligncenter ' +
                    ' alignright alignjustify | bullist numlist outdent indent |' +
                    ' removeformat |  emoticons | fullscreen',   
                    // file_picker_callback: function(callback, value, meta) {
                    // if (meta.filetype == 'image') {
                    //     $('#upload').trigger('click');
                    //     $('#upload').on('change', function() {
                    //     var file = this.files[0];
                    //     var reader = new FileReader();
                    //     reader.onload = function(e) {
                    //         callback(e.target.result, {
                    //         alt: ''
                    //         });
                    //     };
                    //     reader.readAsDataURL(file);
                    //     });
                    // }
                    // },  
            });

        </script>
</html>