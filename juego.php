<?php
    class Carta
    {
        // Declaración de una propiedad
        private $numero;
        private $palo;

        //constructor
        public function __construct($numero,$palo) {
            $this->numero = $numero;

            //switch para cambiar de numero a palo
            switch ($palo){
                case 0:
                    $this->palo = 'Espadas';
                    break;
                case 1:
                    $this->palo = "Oro";
                    break;
                case 2:
                    $this->palo = "Basto";
                    break;
                case 3:
                    $this->palo = "copas";
                    break;
            }
        }
        // funcion para llevar de numero a nombre completo de la carta
        public function toString(Type $var = null)
        {
            switch ($this->numero){
                case 1: 
                    echo "As de ".$this->palo;
                    break;
                case 8:
                    echo "Sota de ".$this->palo;
                    break;
                case 9:
                    echo "Caballo de ".$this->palo;
                    break;
                case 10:
                    echo "Rey de ".$this->palo;
                    break;
                default:
                    echo $this->numero." de ".$this->palo;
                    break;
            }
        }

        public function valor(Type $var = null)
        {
            if($this->numero <= 7){
                return $this->numero;
            }else{
                return 0.5;
            }
        }
    }
    class Baraja
    {
        private $cartas = array();
        private $posBaraja;

        public function __construct() {
            $this->posBaraja = 0;
            $this->crearBaraja();
            $this->barajar();
        }

        public function reiniciarBaraja(){
        $this->posBaraja = 0;
        $this->barajar();
        }
        
        private function crearBaraja(){
            for ($i=0;$i<4;$i++){
                for($j=1;$j<=10;$j++){
                    $carta = new Carta($j,$i);
                    array_push($this->cartas, $carta);
                }
            }
        }

        private function barajar(Type $var = null)
        {
            $index = count($this->cartas);
            while (0 !== $index) {

                // Pick a remaining element...
                $randomIndex = rand(0,39);
                $index -= 1;
            
                // And swap it with the current element.
                $valorTemporal = $this->cartas[$index];
                $this->cartas[$index] = $this->cartas[$randomIndex];
                $this->cartas[$randomIndex] = $valorTemporal;
            }
        }
        public function pedirCarta(){
            if($this->posBaraja > 39){
                echo "ya no quedan cartas";
            }else{
            $carta = $this->cartas[$this->posBaraja++];
            return $carta;
            }
        }
    }
    
    //main del juego 

    //iniciando las variables
    $baraja = new Baraja();
    $x = true;

    //principio de while del juego
    while($x) {
    //variables necesarias cada vez que empieza el juego  
      $contPC = 0;
      $contUser = 0;
    //Inicio del juego
      echo "Siete y Media \n";
      echo 'pulse enter para empezar';
      $empezar = trim(fgets(STDIN));
          $carta = $baraja->pedirCarta();
          echo " has obtenido el ";
          $carta->toString();
          echo " llevas ". ($contUser+=$carta->valor()) . " puntos \n";
    //while del Juegador
      while(true) {
        echo 'pide un carta en "enter+c" o plantate en "enter+p": ';
        $pedir = trim(fgets(STDIN));

        if($pedir==="c"){
            $carta = $baraja->pedirCarta();
            echo " has obtenido el ";
            $carta->toString();
            echo " llevas ". ($contUser+=$carta->valor()) . " puntos \n";
        }

        if( $contUser > 7.5 || $contUser === 7.5 || $pedir === "p"){
            break;
        }
      } 
      //while de la pc solo juega al ser necesario 
      if($contUser < 7.5){
            while($contUser > $contPC) {
            $carta = $baraja->pedirCarta();
            echo " la pc ha obtenido el ";
            $carta->toString();
            echo " lleva ". ($contPC+=$carta->valor()) . " puntos \n";
            }
        } 

        if($contUser===$contPC){
          echo "La pc ha ganado, si empatas la pc gana \n";
        }elseif($contUser > 7.5){
          echo "lo siento has perdido, te has pasado de 7.5 \n";
        }elseif(7.5 < $contPC){
          echo "Has ganado felicidades, la pc se ha pasado de 7.5 \n";
        }
    //while del final del juego para volver a jugar o 
      while(true){
        echo 'Para volver a jugar "j + enter" para salir marca "s + enter" : ';
        $fin = trim(fgets(STDIN));
        if($fin === "s"){
          $x = false;
          break;
        }
        if($fin === "j"){
          $baraja->reiniciarBaraja();
          break;
        }
      }
    }
?>
