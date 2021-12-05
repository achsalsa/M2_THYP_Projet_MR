<?php

function liste_mots_vides($mabdd){
    $sql =  'SELECT Mot_v FROM Mots_vides';
    $requete=$mabdd->query($sql);

    $results=$requete->fetchAll();
    $results = array_column($results, 'Mot_v');
    return $results;
}
//trouver l'id du mot
function trouver_id_mot($mabdd, $mot){
    $sql =  "SELECT id_mot FROM Mots where mot='$mot'";
    $requete=$mabdd->query($sql);

    $results=$requete->fetchAll();
    $results = array_column($results, 'id_mot');
    return $results[0];
}
//inserrer un mot si il n'existe pas dans la table mots
function insertion_mot($mabdd, $mot){
    $sql = "INSERT INTO Mots (Mot) VALUES ('$mot')";
    $mabdd->exec($sql);
    $last_id = $mabdd->lastInsertId();
    return $last_id;
}

//insersion d'une occurence
function insertion_occurence($mabdd, $id_mot, $id_fichier){
    $sql = "INSERT INTO Occurrences (Id_source_s, Id_mot_m, Cote) VALUES ($id_fichier, $id_mot, 1)";
    $mabdd->exec($sql);
}

//inserrer voir si un mot existe ou dans la base
function check_mot_exist($mabdd, $mot){
    $sql =  "SELECT Mot FROM Mots Where mot='$mot'";
    $requete=$mabdd->query($sql);
    $results=$requete->fetchAll();
    $results = array_column($results, 'Mot');
    return $results;
}

//insertion du fichier dans la base de donnes
function insert_fichier($mabdd, $file){
    $sql =  "INSERT INTO Sources (Nom_fichier, Type_fichier, Titre, Resume) VALUES ('$file[0]', '$file[1]', '$file[2]', '$file[3]')";
    $mabdd->exec($sql);
    $last_id = $mabdd->lastInsertId();
    return $last_id;
}

?>