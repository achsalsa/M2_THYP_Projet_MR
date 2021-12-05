<?php
function resultats_recherche($mabdd, $mot){
    $mots_tab = explode(" ", $mot);
    $liste="(";
    foreach($mots_tab as $tab)
    {
        $liste=$liste."'".$tab."',";
    }
    $liste.=')';
    $liste = str_replace(",)", ")", $liste);
    $sql="SELECT count(*) as counter, Mots.Mot, Occurrences.Id_source_s, Occurrences.Id_mot_m, Sources.Nom_fichier, Sources.Type_fichier, Sources.Date_ajout_sr, Sources.Resume, Sources.Titre, Sources.Type_fichier, DATE_FORMAT(Sources.Date_modification_sr, '%d/%m/%Y') as Date_modification_sr  FROM Occurrences
    LEFT JOIN Mots ON Occurrences.Id_mot_m=Mots.Id_mot
    LEFT JOIN Sources ON Occurrences.Id_source_s=Sources.Id_source
    WHERE Mots.Mot IN $liste
    GROUP BY Occurrences.Id_mot_m, Occurrences.Id_source_s
    ORDER BY counter ";
    $requete=$mabdd->query($sql);
    $results=$requete->fetchAll();
    $oresults=array();
    
    $files_liste=array();
    foreach ($results as $key=>$value){
        if(!in_array($value['Nom_fichier'], $files_liste)){
            $new=['Nom_fichier'=>$value['Nom_fichier'],'Type_fichier'=>$value['Type_fichier'],'Date_ajout_sr'=>$value['Date_ajout_sr'],'Resume'=>$value['Resume'],'Titre'=>$value['Titre'],'Type_fichier'=>$value['Type_fichier'],'Date_modification_sr'=>$value['Date_modification_sr'],'liste_mots'=>[['mot'=>$value['Mot'], 'occurence'=>$value['counter']]],'compteur'=>$value['counter']];
            // $value['Mot'],
            array_push($oresults, $new);
            array_push($files_liste, $value['Nom_fichier']);
        }
        else{
            $ligne=['mot'=>$value['Mot'], 'occurence'=>$value['counter']];
            foreach ($oresults as $key2 => $value2) {
                if($value2['Nom_fichier']==$value['Nom_fichier']){
                    array_push($oresults[$key2]['liste_mots'], $ligne);
                    $oresults[$key2]['compteur']=(int) $oresults[$key2]['compteur']+(int) $value['counter'];
                }
            }
        }
    }
    return $oresults;
}
?>