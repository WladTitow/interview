<?php

class Figure {
    protected $isBlack;

    public function __construct($isBlack) {
        $this->isBlack = $isBlack;
    }   
    
    public function getColorIsBlack() {
        return $this->isBlack;
    }
    
    public function checkTurn() {
        return true;
    }

    /** @noinspection PhpToStringReturnInspection */
    public function __toString() {
        throw new \Exception("Not implemented");
    }
}
