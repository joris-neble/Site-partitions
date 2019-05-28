<?php
    session_start();
    $data = new StdClass();
    $data->success = false;
    $dsn = 'mysql:host=mysql-neblejoris.alwaysdata.net;dbname=neblejoris_partition-website';
    $user = '149339_joris';
    $pass = '1234rootRoot';

    try {
        $baseDeDonnees = new PDO($dsn, $user, $pass);
        $requete = $baseDeDonnees->prepare('
            SELECT * FROM `Partition` WHERE 1
        ');
        $requete->execute();
        $data->partitions = $requete->fetchAll();
        $data->success = true;
        $data->message = 'réussite';
    } catch (PDOException $e) {
        echo 'Connexion échouée : ' . $e->getMessage();
        $data->message = 'Une erreur est survenus lors de la connection à la base de données';
    }
    echo json_encode($data);