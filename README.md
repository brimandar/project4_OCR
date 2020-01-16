# project4_OCR
Create a blog for a writer
PROJET 4 Parcours Développeur Web Junior - OpenClassRooms

1 - Base de données

Le fichier blogwriter.sql à la racine du dossier contient la base de données (structure et données).
Importer ce fichier dans une base MySQL (version 5) nommée "blogwriter".


2 - Sources

Le dossier "PROJET4" contient les sources.
Importer l'ensemble du dossier sur un serveur local ou distant en PHP 7.


NOTE IMPORTANTE : 
L'application dispose de 2 environnements, dev et prod.
Allez dans PROJET4/config/dev.php et prod.php
Configurer les constantes :
- de connexion de la BDD
- le répertoire de stockage des images (facultatif) et la taille maxi (en octets) des images à uploader (default 500 Ko)
- l'adresse mail servant à recevoir les messages du formulaire de contact
- l'URL de l'accueil du site pour la confirmation d'inscription
- les clés recaptacha V de Google

Le choix de l'environnement s'effectue dans index.php ligne 3 (PROJET4/public)
