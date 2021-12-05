<?php
    include('./INC/bdd_connect_f.php');
    include('./INC/bdd_requete_res.php');
    $mybdd=bdd_connect_f();
    $search_value="Mots à Rechercher";
    if(isset($_POST['searchVal']) || isset( $_POST['search_res'])){
        if(isset($_POST['searchVal'])){
            $search_value=$_POST['searchVal'];
        }
        else{
            $search_value=$_POST['searchValue'];
        }
        $resultats=resultats_recherche($mybdd, $search_value);
    }
?>


<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Resultats de recherche</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta2/css/all.min.css"/>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bulma@0.9.3/css/bulma.min.css"/>
    <link rel="stylesheet" href="./css/result_s.css"/>
  </head>
  <body>

  <!-- nuage de mots modal -->
  <div class="modal modal_ndm">
    <div class="modal-background"></div>
    <div class="modal-card">
        <header class="modal-card-head">
        <p class="modal-card-title">Modal title</p>
        <button class="delete ndp_delete" aria-label="close"></button>
        </header>
        <section class="modal-card-body">
        <!-- Content ... -->
        </section>
        <footer class="modal-card-foot">
        <button class="button ndp_btn">Cancel</button>
        </footer>
    </div>
  </div>
   <!-- nuage de stars modal -->
   <div class="modal modal_stars">
    <div class="modal-background"></div>
    <div class="modal-card">
        <header class="modal-card-head">
        <p class="modal-card-title">Modal title</p>
        <button class="delete stars_delete" aria-label="close"></button>
        </header>
        <section class="modal-card-body">
        <!-- Content ... -->
        </section>
        <footer class="modal-card-foot">
        <button class="button stars_btn">Cancel</button>
        <button class="button ">Cancel</button>
        </footer>
    </div>
  </div>

  <section class="section">
    <div class="container">
    <form action="resultat.php" method="POST">
        <div class="columns">
            
                <div class="column" id="logo"><a href="./index.php"><i class="fas fa-user-ninja"></i> NinjaSearch</a></div>
                <div class="column is-four-fifths">
                    <input class="input is-rounded is-fullwidth" type="text" placeholder="Mots à Rechercher" value="<?php echo $search_value;?>" name="searchValue">
                </div>
                <div class="column">
                    <button type="submit" name="search_res" class="button is-link is-rounded is-fullwidth"><i class="fas fa-search"></i></button>
                </div>
        </div>
    </form>
    <nav class="navbar mb-5" role="navigation" aria-label="main navigation">
        <div id="navbarBasicExample" class="navbar-menu">
            <div class="navbar-start">
                <a class="navbar-item">
                    <div class="field is-grouped is-grouped-multiline">
                        <div class="control">
                            <div class="tags has-addons">
                            <span class="tag is-dark">Resultats: </span>
                            <span class="tag is-info">10</span>
                            </div>
                        </div>
                    </div>
                </a>
                <a class="navbar-item">
                    <div class="field is-grouped is-grouped-multiline">
                        <div class="control">
                            <div class="tags has-addons">
                            <span class="tag is-dark">Temps: </span>
                            <span class="tag is-primary">10 ms</span>
                            </div>
                        </div>
                    </div>
                </a>
                <a class="navbar-item">
                    Accueil
                </a>

                <a class="navbar-item">
                    Recherche simple
                </a>
                <a class="navbar-item">
                    Recherche composée
                </a>
                <div class="navbar-item has-dropdown is-hoverable">
                    <a class="navbar-link">
                    type de documents
                    </a>

                    <div class="navbar-dropdown">
                    <a class="navbar-item">
                        <label class="checkbox">
                        <input type="checkbox">
                        Format PDF
                        </label>
                    </a>
                    <a class="navbar-item">
                        <label class="checkbox">
                        <input type="checkbox">
                        Format Text
                        </label>
                    </a>
                    <a class="navbar-item">
                        <label class="checkbox">
                        <input type="checkbox">
                        HTML local
                        </label>
                    </a>

                    <a class="navbar-item">  
                        <label class="checkbox">
                        <input type="checkbox">
                        Fomrat word
                        </label>
                    </a>
                    
                    <a class="navbar-item">
                        <label class="checkbox">
                            <input type="checkbox">
                            HTML web
                        </label>
                    </a>
                    <hr class="navbar-divider">
                    <a class="navbar-item has-text-centered">
                        <button class="button is-link is-outlined ">
                            <span class="icon"><i class="fas fa-search"></i></span> <span>Rechercher</span>
                        </button>  
                    </a>
                </div>
        </div>
    </div>
        </div>
</nav>

    <?php 
    if(isset($resultats)){
        foreach($resultats as $key=>$value){
    ?>
    <div class="columns mt-5">
        <div class="card">
            <div class="card-content">
                <div class="content">
                <div class="columns">
                    <div class="column two-fourth">
                        <h3 class="title is-4"><?php echo $value['Titre'];?></h3>
                        <h5 class="subtitle is-5 mb-0 has-text-weight-light	">sources/<?php echo $value['Nom_fichier'].'.'.$value['Type_fichier'];?></h5>
                    </div>
                    <div class="column two-fourth has-text-right">
                    <button class="button is-black is-small is-rounded cloud_btn"><i class="fas fa-cloud"></i></button>
                    <button class="button is-black is-small is-rounded stars_btn"><i class="far fa-star"></i></button>
                    </div>
                </div>

                <div class="columns">
                    <div class="column">
                        <p><?php echo $value['Resume'];?><a href=""> lire la suite</a></p>
                        <?php foreach($value['liste_mots'] as $key2=>$value2){
                            if($key2%2==0){
                        ?>
                            <span class="tag is-black"><?php echo $value2['mot'].' ('.$value2['occurence'].')';?></span>
                            <?php 
                            } else{
                            ?>
                            <span class="tag is-light"><?php echo $value2['mot'].' ('.$value2['occurence'].')';?></span>
                        <?php
                            }
                            }
                        ?>
                        <h5 class="subtitle is-6 mb-0 has-text-right">Derniere mise à jour le: <?php echo $value['Date_modification_sr'];?></h5>
                        <h5 class="subtitle is-6 mb-0 has-text-right mt-1"><i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i><i class="far fa-star"></i></h5>

                    </div>

                </div>
            </div>
            </div>
        </div>
    </div>
    <?php
        }
    }
    ?>
  </section>
<script src="./JS/results_script.js"></script>

</body>
 
</html>