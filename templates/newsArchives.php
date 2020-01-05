<!-- security TinyMCE HTML Purifier -->
<?php
    $config = HTMLPurifier_Config::createDefault();
    $purifier = new HTMLPurifier($config);
?>

<h1>Archives des newsletters</h1>
<p class="mb-4">Vous trouverez ici, mes anciennes actualités.</p>

<table id="allChaptersTable" class=" col-12 table table-bordered table-striped">
                <thead class="thead-dark">
                    <tr>
                        <td scope="col">Titre</td>
                        <td scope="col">Contenu</td>
                        <td scope="col">Ajouté le</td>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    foreach ($news as $new)
                    { ?>
                        <tr>
                            <td><?= htmlspecialchars($new->getTitle());?></a></td>
                            <td><?= $purifier->purify($new->getContent());?></td>
                            <td><?= htmlspecialchars($new->getCreated_at());?></td>
                        </tr>
                        <?php
                    } ?>
                </tbody>
            </table>
<hr>

<?php 