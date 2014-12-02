<?php
    
    /*
     *Cette page va permettre d'affiche une liste de 
     *fimls récemmet sortis au cinéma.
     */
    
    // Contient la date courante
    $current_date = date("d/n/Y");
    
    // Contient le titre de la page
    $title = "MVA - Ma Liste de Films du " . $current_date;
    
    //Contient les films du fichier csv
    $data = array();
    
    //Ouvrir le fichier csv en read et récuperer les lignes de films dans un array
    if (($handle = fopen("films.csv", "r")) !== FALSE)
    {
        while (($row = fgetcsv($handle, 1000, ",")) !== FALSE){
           //array_push($data, $row);
           $data[] = $row;
        }
    
        fclose($handle);  
    }
    
    //Visualiser le contenu de $data
    //var_dump($data);
    
    //fonction destinée à afficher un élément de la liste
    
    function show_row($film)
    {
       //$film = new Film($row);
       //echo "<li><a href='detail.php?film=" . $film->id ."'>" . $film . "</a></li>";
       echo "<tr><td><a href='detail.php?film=" . $film->id . "'>" . $film->title . "</a></td><td>" . $film->type . "</td></tr>";
    }

    //Fonction destinée à afficher un select des types de films
    function show_select_types_items()
    {
        global $data;
        $types = array();
        foreach ($data as $row)
        {
            if (!in_array($row[3], $types) && $row[3] != "Type")
            {
                $types[] = $row[3];
                //echo "<li role='type'><a role='menuitem' href='#'>" . $row[3] . "</a></li>";
                echo "<li role='type'><a role='menuitem' href='/?type=" . urlencode($row[3]) . "'>" . $row[3] . "</a></li>"; 
            }
        }
    }
   
    /** 
     * Classe destinée à contenir les propriétés 
     * d'un film. 
     */
    class Film{

        public $id;
        public $title;
        public $image;
        public $type;
        public $year;
        public $country;
        public $director;
        public $length;
        public $abstract;

        public function __construct($row)
        {
            $this->id = $row[0]; 
            $this->title = $row[1]; 
            $this->image = $row[2]; 
            $this->type= $row[3]; 
            $this->year = $row[4]; 
            $this->country = $row[5];
            $this->director = $row[6]; 
            $this->length = $row[7]; 
            $this->abstract = $row[8];
        }

        public function __toString()
        {
            return $this->title . ",  " . $this->type;
        }
    }

    /** 
     * Classe destinée à retrouver 
     *un film dans les données. 
     */
    class Finder {
        
        private $_data;

        public function __construct($data){
            $this->_data = $data;

        }

       public function find($id){ 
           foreach ($this->_data as $row) { 
               if ($row[0] == $id) { 
                   return new Film($row); 
               } 
            } 
            return NULL; 
       }

       // Méthode qui permet de trouver un ensemble de films en fonction d'un type
        public function findByType($type) {
            $found = array();
            if (!empty($type)) {
                foreach ($this->_data as $row) {
                    if ($row[3] == $type) {
                        $found[] = new Film($row);
                    }
                } 
            }
            else { // On renvoie tous les films quand le type est non renseigné
                foreach ($this->_data as $row) {
                    if ($row[1] != "Title") {
                        $found[] = new Film($row);
                    }
                }
            }
            return $found;
        }

    }
?>
