<?php

class Desk {
    private $figures = [];    
    protected $isTurnBlack = false;

    public function __construct() {
        $this->figures['a'][1] = new Rook(false);
        $this->figures['b'][1] = new Knight(false);
        $this->figures['c'][1] = new Bishop(false);
        $this->figures['d'][1] = new Queen(false);
        $this->figures['e'][1] = new King(false);

        $this->figures['f'][1] = new Bishop(false);
        $this->figures['g'][1] = new Knight(false);
        $this->figures['h'][1] = new Rook(false);

        $this->figures['a'][2] = new Pawn(false);
        $this->figures['b'][2] = new Pawn(false);
        $this->figures['c'][2] = new Pawn(false);
        $this->figures['d'][2] = new Pawn(false);
        $this->figures['e'][2] = new Pawn(false);
        $this->figures['f'][2] = new Pawn(false);
        $this->figures['g'][2] = new Pawn(false);
        $this->figures['h'][2] = new Pawn(false);

        $this->figures['a'][7] = new Pawn(true);
        $this->figures['b'][7] = new Pawn(true);
        $this->figures['c'][7] = new Pawn(true);
        $this->figures['d'][7] = new Pawn(true);
        $this->figures['e'][7] = new Pawn(true);
        $this->figures['f'][7] = new Pawn(true);
        $this->figures['g'][7] = new Pawn(true);
        $this->figures['h'][7] = new Pawn(true);

        $this->figures['a'][8] = new Rook(true);
        $this->figures['b'][8] = new Knight(true);
        $this->figures['c'][8] = new Bishop(true);
        $this->figures['d'][8] = new Queen(true);
        $this->figures['e'][8] = new King(true);
        $this->figures['f'][8] = new Bishop(true);
        $this->figures['g'][8] = new Knight(true);
        $this->figures['h'][8] = new Rook(true);
    }

    public function getColorIsBlack() {
        return $this->isBlack;
    }
    
    public function nextTurn() {
        $this->isBlack = !$this->isBlack;
    } 
    
    public function move($move) {
        if (!preg_match('/^([a-h])(\d)-([a-h])(\d)$/', $move, $match)) {
            throw new \Exception("Incorrect move");
        }

        $xFrom = $match[1];
        $yFrom = $match[2];
        $xTo   = $match[3];
        $yTo   = $match[4];
        
        $colnumber = array('a' => 1, 'b' => 2, 'c' => 3, 'd' => 4, 'e' => 5, 'f' => 6, 'g' => 7, 'h' => 8); 

        if (isset($this->figures[$xFrom][$yFrom])) {
            $FigureIsBlack = $this->figures[$xFrom][$yFrom]->getColorIsBlack();
            if($color !== $this->getColorIsBlack())
                  throw new \Exception("Incorrect move color");
            if($this->figures[$xFrom][$yFrom] instanceof Pawn) {
                $deltamove = 1;
                if($yFrom == 7 and $FigureIsBlack) {
                    $deltamove = 2;
                }
                if($yFrom == 2 and !$FigureIsBlack) {
                    $deltamove = 2;
                }
                if($xFrom !== $xTo) {
                    if(!isset($this->figures[$xTo][$yTo]))
                        throw new \Exception("Incorrect diagonal move");
                    if(abs($colnumber[$xTo] - $colnumber[$xFrom]) > 1)
                        throw new \Exception("Incorrect big diagonal move");
                }
                if($FigureIsBlack and (($yFrom <= $yTo) or (abs($yFrom - $yTo) > $deltamove))) {
                    throw new \Exception("Incorrect move");
                }
                if(!$FigureIsBlack and (($yFrom >= $yTo) or (abs($yFrom - $yTo) > $deltamove))) {
                    throw new \Exception("Incorrect move");
                }
                if($deltamove == 2)
                    if(abs($colnumber[$xTo] - $colnumber[$xFrom]) == 2) {
                        if($FigureIsBlack and isset($this->figures[$xFrom][$yFrom-1]))
                            throw new \Exception("Incorrect move jump");
                        if(!$FigureIsBlack and isset($this->figures[$xFrom][$yFrom+1]))
                            throw new \Exception("Incorrect move jump");
                    }
      
            }
            $this->figures[$xTo][$yTo] = $this->figures[$xFrom][$yFrom];
        }
        unset($this->figures[$xFrom][$yFrom]);
        $this->nextTurn();
    }

    public function dump() {
        for ($y = 8; $y >= 1; $y--) {
            echo "$y ";
            for ($x = 'a'; $x <= 'h'; $x++) {
                if (isset($this->figures[$x][$y])) {
                    echo $this->figures[$x][$y];
                } else {
                    echo '-';
                }
            }
            echo "\n";
        }
        echo "  abcdefgh\n";
    }
}
