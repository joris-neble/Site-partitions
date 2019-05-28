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
            SELECT * FROM `Accords-Partitions` WHERE id_partition=?
        ');
        $requete->execute(array($_POST['id_partition']));
        $accord = $requete->fetchAll();
        $data->partition = [];
        for($cptAccord=0; $cptAccord<sizeof($accord); $cptAccord++){
            $requete = $baseDeDonnees->prepare('
                SELECT * FROM Accords WHERE id_accord=?
            ');
            $requete->execute(array($accord[$cptAccord]['id_accord']));
            $data->partition[$cptAccord] = $requete->fetch();
        }
        $data->success = true;
        $data->message = 'réussite';
    } catch (PDOException $e) {
        echo 'Connexion échouée : ' . $e->getMessage();
        $data->message = 'Une erreur est survenus lors de la connection à la base de données';
    }
    echo json_encode($data);