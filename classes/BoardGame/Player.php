<?php

namespace ChessGame\BoardGame;

use ChessGame\Chess\ChessPiece;

class Player {
    private $name;
    private $color;
    private $pieces = []; // New property

    public function __construct(string $name, string $color) {
        $this->name = $name;
        $this->color = $color;
    }

    public function getName(): string {
        return $this->name;
    }

    public function getColor(): string {
        return $this->color;
    }

    public function addPiece(ChessPiece $piece): void {
        $this->pieces[] = $piece;
    }
    public function getPieces(): array {
        return $this->pieces;
    }

    public function removePiece($piece) {
        $index = array_search($piece, $this->pieces);
        if($index !== false) {
            unset($this->pieces[$index]);
        }
    }
}
