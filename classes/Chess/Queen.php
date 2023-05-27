<?php
namespace ChessGame\Chess;

use ChessGame\BoardGame\Player;
use ChessGame\Chess\Rook;
use ChessGame\Chess\Bishop;

class Queen extends ChessPiece {
    
    public function __construct($color, Player $player, $x, $y) {
        parent::__construct($color, $player);
        $this->setPosition($x, $y);
        $this->setColor($color);
    }

    public function isValidMove($from, $to): bool {
        // Calculate the absolute difference in x and y coordinates
        $dx = abs($to[0] - $from[0]);
        $dy = abs($to[1] - $from[1]);
    
        // Horizontal move (same row, different columns)
        $horizontalMove = ($dx == 0 && $dy > 0);
        // Vertical move (same column, different rows)
        $verticalMove = ($dy == 0 && $dx > 0);
    
        // Diagonal move (equal change in rows and columns)
        $diagonalMove = ($dx == $dy && $dx > 0);  
if ($horizontalMove || $verticalMove || $diagonalMove)
echo "Queen valid move !\n";
        // The queen can move in any one of these three ways
        return ($horizontalMove || $verticalMove || $diagonalMove);
    }
    
/*     public function isValidMove($from, $to): bool {
        // The queen combines the power of the rook and bishop and can move any number of squares
        // along a rank, file, or diagonal, but it may not leap over other pieces.
    
        // If the move is valid for either a rook or a bishop, it's valid for the queen.
        $rook = new Rook($this->color, $this->player,$this->getX(),$this->getY());
        $bishop = new Bishop($this->color, $this->player,$this->getX(),$this->getY());
    
        return $rook->isValidMove($from, $to) || $bishop->isValidMove($from, $to);
    } */

    /* public function isPathClear(array $from, array $to, ChessBoard $board): bool {
        // The Queen can move like a Rook or a Bishop
        $bishop = new Bishop($this->color, $this->player,$this->getX(),$this->getY());
        $rook = new Rook($this->color, $this->player,$this->getX(),$this->getY());

        return $bishop->isPathClear($from, $to, $board) || $rook->isPathClear($from, $to, $board);
    } */

    public function isPathClear(array $from, array $to, ChessBoard $board): bool {
        $dx = abs($to[0] - $from[0]);
        $dy = abs($to[1] - $from[1]);
    
        // Check if the movement is diagonal (like a bishop)
        if ($dx === $dy) {
            $xStep = $to[0] > $from[0] ? 1 : -1;
            $yStep = $to[1] > $from[1] ? 1 : -1;
    
            $x = $from[0] + $xStep;
            $y = $from[1] + $yStep;
            while ($x != $to[0] && $y != $to[1]) {
                if ($board->getPieceAt([$x, $y]) !== null) {
                    return false;
                }
                $x += $xStep;
                $y += $yStep;
            }
        }
        // Check if the movement is straight (like a rook)
        else if ($dx === 0 || $dy === 0) {
            $xStep = $dx !== 0 ? ($to[0] > $from[0] ? 1 : -1) : 0;
            $yStep = $dy !== 0 ? ($to[1] > $from[1] ? 1 : -1) : 0;
    
            $x = $from[0] + $xStep;
            $y = $from[1] + $yStep;
            while ($x != $to[0] || $y != $to[1]) {
                if ($board->getPieceAt([$x, $y]) !== null) {

                    return false;
                }
                $x += $xStep;
                $y += $yStep;
            }
        } else {
            // If it's neither diagonal nor straight, it's not a valid Queen move.
            return false;
        }
        echo "Queen path clear\n";

        return true;
    }
    
}
