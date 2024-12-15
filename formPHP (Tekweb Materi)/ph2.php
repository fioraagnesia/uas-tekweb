<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    <?php
    require("fun.php");
    echo testme(4,5);
    echo "<br>";
    class Hello {
        protected $lang;
        function __construct($lang) { echo "\$lang defined<br>"; }
        function greet() { echo "Hello from Hello"; }
    }
    
    class Social extends Hello {
        function bye() {
        if ( $this->lang == 'fr' ) return 'Au revoir';
        if ( $this->lang == 'es' ) return 'Adios';
        return 'goodbye';
        }
    }
    
    $hi = new Social('es');
    echo $hi->greet()."<br>\n";
    echo $hi->bye()."<br>\n";
    


    ?>
</body>
</html>