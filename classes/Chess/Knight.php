<?php

namespace ChessGame\Chess;

use ChessGame\BoardGame\Player;

class Knight extends ChessPiece {

    public function __construct($color, Player $player, $x, $y) {
        parent::__construct($color, $player);
        $this->setPosition($x, $y);
        $this->setColor($color);
    }

    public function isValidMove($from, $to): bool {
        // The knight moves to any of the squares immediately adjacent to it
        // and then makes one further step at a right angle.
        $dx = abs($to[1] - $from[1]);
        $dy = abs($to[0] - $from[0]);

        // Check if the move is an "L" shape
        return ($dx == 2 && $dy == 1) || ($dx == 1 && $dy == 2);
    }

    public function isPathClear(array $from, array $to, ChessBoard $board): bool {
        // The Knight can jump over other pieces, so no need to check the path.
        return true;
    }
}
