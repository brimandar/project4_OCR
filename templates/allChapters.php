<!-- security TinyMCE HTML Purifier -->
<?php
    $config = HTMLPurifier_Config::createDefault();
    $purifier = new HTMLPurifier($config);
?>

<h1>Tous les chapitres</h1>
<p class="mb-4">Vous trouverez ici, l'ensemble des chapitres disponibles.</p>

<table id="allChaptersTable" class=" col-12 table table-bordered table-striped">
                <thead class="thead-dark">
                    <tr>
                        <td scope="col">Titre</td>
                        <td scope="col">Extrait</td>
                        <td scope="col">Ajouté le</td>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    foreach ($chapters as $chapter)
                    { ?>
                        <tr>
                            <td><a href="chapitre-<?= htmlspecialchars($chapter->getId());?>"><?= htmlspecialchars($chapter->getTitle());?></a></td>
                            <td><?= $purifier->purify(substr($chapter->getContent(), 0, 1000));?></td>
                            <td><?= htmlspecialchars($chapter->getCreated_at());?></td>
                        </tr>
                        <?php
                    } ?>
                </tbody>
            </table>
<hr>