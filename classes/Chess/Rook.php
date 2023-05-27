<?php

namespace ChessGame\Chess;

use ChessGame\BoardGame\Player;

class Rook extends ChessPiece {

    
    public function __construct($color, Player $player, $x, $y) {
        parent::__construct($color, $player);
        $this->setPosition($x, $y);
        $this->setColor($color);
    }

    public function isValidMove($from, $to): bool {
        // The rook can move any number of squares along any rank or file,
        // but may not leap over other pieces.
        $dx = abs($to[1] - $from[1]);
        $dy = abs($to[0] - $from[0]);
    
        // Check if the move is along a rank or file (not diagonally)
        return $dx == 0 || $dy == 0;
    }

    public function isPathClear(array $from, array $to, ChessBoard $board): bool {
        // Rooks move in straight lines along ranks and files
        $dx = abs($to[0] - $from[0]);
        $dy = abs($to[1] - $from[1]);

        if ($dx != 0 && $dy != 0) {
            // This isn't a straight move
            return false;
        }

        $xStep = $dx != 0 ? ($to[0] > $from[0] ? 1 : -1) : 0;
        $yStep = $dy != 0 ? ($to[1] > $from[1] ? 1 : -1) : 0;

        // Starting from the next square, we check all squares along the path
        $x = $from[0] + $xStep;
        $y = $from[1] + $yStep;
        while ($x != $to[0] || $y != $to[1]) {
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
