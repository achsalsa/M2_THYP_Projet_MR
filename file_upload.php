<?php
    include('./INC/bdd_connect_f.php');
    include('./INC/bdd_requete_traitements.php');
    $bdd=bdd_connect_f();
    //scan de mon dossier avant d'uploader les fichiers
    function dirScan($src){
        $files_list = scandir($src);
        return $files_list;
    }

    if(isset($_POST['file_upload'])){
        $filesName=array();
        $filesExist=[];
        $target_dir = "SOURCES/";
        //recuperer la liste des mots vides dans un tableau 
        $mot_vides=liste_mots_vides($bdd);
        $index=1;            
        foreach ($_FILES as $key => $value) {
            var_dump($_FILES);
            echo $key;
            $target_file = $target_dir . basename($_FILES[$key]["name"]);
            $FileType = strtolower(pathinfo($target_file,PATHINFO_EXTENSION));
            $folder=dirScan($target_dir);

            if($FileType != "pdf" && $FileType != "doc" && $FileType != "docx" && $FileType != "html" && $FileType != "txt") {
                array_push($filesName, basename($_FILES[$key]["name"]));
            }
            else{
                if(in_array($_FILES[$key]["name"], $folder)){
                    array_push($filesExist, $_FILES[$key]["name"]);
                }
                else{
                    move_uploaded_file($_FILES[$key]["tmp_name"], $target_file);
                    $file_prop= [basename($_FILES[$key]["name"], '.'.$FileType),$FileType, $_POST['fichier'.$index]['titre'], $_POST['fichier'.$index]['resume']];
                    $id_fichier=insert_fichier($bdd, $file_prop);
                    if($FileType=="txt"){

                    //lecture du fichier et mise en liste de tout les mots inclus dans le fichier    
                    $filecontents = file_get_contents($target_file);
                    $filecontents = strtolower($filecontents);
                    $words = preg_split('/[\s,\’]+/', $filecontents, -1, PREG_SPLIT_NO_EMPTY);
                    var_dump($mot_vides);
                    //checker si les mots existent dans la liste de mots vides contenu dans la base et enlver les mots ayant une taille inferieur à 2
                    foreach ($words as $key => $value){
                        if(strlen($value)<=2 || in_array($value, $mot_vides)){
                            unset($words[$key]);
                        }
                        else{
                            //regarder si le mot existe deja la liste des mots
                            if(check_mot_exist($bdd, $words[$key]))
                            {
                                $id_mot=trouver_id_mot($bdd, $words[$key]);
                                insertion_occurence($bdd, $id_mot, $id_fichier);
                            }
                            else{
                                $id_mot=insertion_mot($bdd, $words[$key]);
                                insertion_occurence($bdd, $id_mot, $id_fichier);
                            }
                        }
                    }

                    //

                    //epurer le tabeau(enlever les mots vides et les mots à deux lettre)
                        //connection a la base de données
                    
                    //connection a la base pour recuperer l'ensemble des mots vide et mettre ca dans un tableau

                    //lecture du fichier

                    }
                }
            }
            $index++;
        }

    }
    else if(isset($_POST['online_link'])){
        echo "file ssss set";
    }
    var_dump($_POST);
?>
<!DOCTYPE html>
<html>

<head>
  <title>transfer de fichier</title>
  <link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=Roboto:ital,wght@0,400;0,700;1,300;1,400;1,700&display=swap" rel="stylesheet">
  <link rel="stylesheet" href="./CSS/file_upload.css">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.12.1/css/all.min.css">
</head>

<body>
    <section class="container max-w-xl mx-auto flex flex-col py-8">
        <h3>Nombre de fichier que vous compter uploader: <span id="compteur">1</span></h3>
        <div class="py-8">
        <form action="file_upload.php" method="post" enctype="multipart/form-data">
            <div class="line" id="line1">
                <label for="" class="f-line">Titre du document</label>
                <input type="text" value="titre du document" name="fichier1[titre]">
                <label for="" class="f-line">Resumé</label>
                <textarea id="" cols="30" rows="10" name="fichier1[resume]">mettre un resumé du text</textarea>
                <label for="default" class="block text-sm leading-5 font-medium text-gray-700 mb-4">Nom du fichier</label>
                <!-- This is a normal file input -->
                <input type="file" name="file1" id="file1" class="border p-2"><button id="plus" type="button"><i class="fas fa-plus"></i></button>
            </div>
            <div id="submit_button">
                <button type="submit" name="file_upload">soumettre</button>
            </div>
        </form>
        </div>
    </section>
    <section class="container max-w-xl mx-auto flex flex-col py-8">
        <h3>Nombre de lien que vous compter ajouter</h3>
    </section>
<script src="./JS/upload_script.js"></script>
</body>

</html>