<?php

namespace ChessGame\Chess;


use ChessGame\BoardGame\Player;

class King extends ChessPiece {

    public function __construct($color, Player $player, $x, $y) {
        parent::__construct($color, $player);
        $this->setPosition($x, $y);
        $this->setColor($color);
    }
    
    public function isValidMove($from, $to): bool {
        // The king moves one square in any direction.
        $dx = abs($to[1] - $from[1]);
        $dy = abs($to[0] - $from[0]);
    
        // Check if the move is at most one square in any direction
        return $dx <= 1 && $dy <= 1;
    }

    public function isPathClear(array $from, array $to, ChessBoard $board): bool {
        // The King can move to any adjacent square, so no need to check the path.
        return true;
    }
}
