<?php 
 
 include("functions.php");

 // Récupère le type des films
    $type = urldecode($_GET["type"]);
    
    // Trouver les films correspondant au type
    $finder = new Finder($data);
    $found = $finder->findByType($type);

 ?>

<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8" />
        <title><?php echo $title; ?></title>
        <link href="css/bootstrap.min.css" rel="stylesheet" />
        <script src="js/jquery-2.1.1.min.js"></script>
        <script src="js/bootstrap.min.js"></script>
    </head>
    <body>
        <nav class="navbar navbar-default" role="navigation">
            <div class="container">
                <div class="collapse navbar-collapse">
                    <ul class="nav navbar-nav">
                        <li class="active"><a href="/">Films</a></li>
                        <li><a href="#">A propos</a></li>
                        <li><a href="#">Contact</a></li>
                    </ul>
                </div>
            </div>
        </nav>
        <div class="container">
            <div class="jumbotron">
                <h1><?php echo $title; ?></h1>
                <p>Voici la liste des films que j'aime et qui sont sortis récemment au cinéma. Très bientôt, dans le module suivant,
                 nous apprendrons à créer une page de détail qui va nous permettre de visualiser les informations d'un film.</p>
            </div>           
            <?php if (count($data) > 1): ?>
            <h2><?php printf("Il y a actuellement %s films disponibles: ",count($data)-1); ?></h2>
            <div class="form-group">
               <div class="dropdown">
                   <button class="btn btn-default dropdown-toggle" type="button" id="dropdowntypes" data-toggle="dropdown">
                       Types
                       <span class="caret"></span>
                    </button>
                       <ul class="dropdown-menu" role="menu" aria-labelledby="dropdowntypes">                  
                   <?php show_select_types_items() ?>
                   </ul>
               </div>
            </div>           
            <table class="table table-striped">
               <?php for ($i = 0; $i < count($found); $i++): ?>            
                <?php show_row($found[$i]); ?>
                <?php endfor; ?>
            </table>
            <?php else: ?>
            <h2>Désolé, il n'y a aucun film disponible actuellement.</h2>
            <?php endif; ?>
        </div>
    </body>
</html>
