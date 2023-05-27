<?php

namespace ChessGame\Chess;

use ChessGame\BoardGame\Player;

class Bishop extends ChessPiece {

    public function __construct($color, Player $player, $x, $y) {
        parent::__construct($color, $player);
        $this->setPosition($x, $y);
        $this->setColor($color);
    }

    public function isValidMove($from, $to): bool {
        // The bishop can move any number of squares diagonally,
        // but may not leap over other pieces.
        $dx = abs($to[1] - $from[1]);
        $dy = abs($to[0] - $from[0]);
    
        // Check if the move is diagonally
        return $dx == $dy;
    }

    public function isPathClear(array $from, array $to, ChessBoard $board): bool {
        // Bishops move diagonally
        $dx = abs($to[0] - $from[0]);
        $dy = abs($to[1] - $from[1]);
        
        if ($dx !== $dy) {
            // This isn't a diagonal move
            return false;
        }

        $xStep = $to[0] > $from[0] ? 1 : -1;
        $yStep = $to[1] > $from[1] ? 1 : -1;

        // Starting from the next square, we check all squares along the path
        $x = $from[0] + $xStep;
        $y = $from[1] + $yStep;
        while ($x != $to[0] && $y != $to[1]) {
            if ($board->getPieceAt([$x, $y]) !== null) {
                // There's a piece blocking the path
                return false;
            }
            $x += $xStep;
            $y += $yStep;
        }
        // The path is clear
        return true;
    }
}
