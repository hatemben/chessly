<?php

namespace ChessGame\Chess;

use ChessGame\BoardGame\Player;

class Pawn extends ChessPiece {

    public function __construct($color, Player $player, $x, $y) {
        parent::__construct($color, $player);
        $this->setPosition($x, $y);
        $this->setColor($color);
    }

    // isValidMove : Strategy pattern
    public function isValidMove($from, $to): bool {
        $dy = $to[0] - $from[0]; // Change in vertical direction (row)
        $dx = $to[1] - $from[1]; // Change in horizontal direction (column)
    
        // Normal move - move forward one square
        if ($dx === 0 && (($this->color === 'white' && $dy === -1) || ($this->color === 'black' && $dy === 1))) {
            return true;
        }
    
        // First move, can move forward two squares
        if ($dx === 0 && !$this->hasMoved && (($this->color === 'white' && $dy === -2) || ($this->color === 'black' && $dy === 2))) {
            return true;
        }
    
        // Capture - move diagonally one square
        if (abs($dx) === 1 && (($this->color === 'white' && $dy === -1) || ($this->color === 'black' && $dy === 1))) {
            return true;
        }
    
        return false;
    }     
    
    public function isPathClear(array $from, array $to, ChessBoard $board): bool {
        // Pawns can move forward without capturing only if the path is clear.
        // When capturing, they move diagonally, but they only move one square at a time, so no need to check the path.
        if ($from[0] == $to[0]) {
            // This is a non-capturing move, so we need to check if the path is clear.
            $direction = $this->color == ChessPiece::WHITE ? 1 : -1;
            if ($board->getPieceAt([$from[0], $from[1] + $direction]) !== null) {
                // There's a piece blocking the path
                return false;
            }
        }

        // The path is clear
        return true;
    }

    public function isCaptureMove(array $from, array $to, ChessBoard $board) {
        // Pawns capture differently from how they move normally, 
        // so we override the method here.

        // 1. Check if the target square is a diagonal forward from the pawn.
        $dx = $to[0] - $from[0];
        $dy = $to[1] - $from[1];
        if (abs($dx) !== 1 || $dy !== $this->getMoveDirection()) {
            return false;
        }
        // 2. and 3. Same as the base class.
        $targetPiece = $board->getPieceAt($to);
        if ($targetPiece === null || $targetPiece->getColor() === $this->getColor()) {
            return false;
        }
        // If all checks passed, this is a valid capture move.
        return true;
    }

    protected function getMoveDirection(): int {
        // Pawns move up for white and down for black.
        return $this->getColor() === 'white' ? 1 : -1;
    }
}
