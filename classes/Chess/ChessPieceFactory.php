<?php

namespace ChessGame\Chess;
use Exception;

use ChessGame\BoardGame\Player;

class ChessPieceFactory {
    public function create($type, $color, Player $player, $x, $y): ChessPiece {
        $piece = null;
        switch ($type) {
            case 'Pawn':
                $piece = new Pawn($color,$player, $x, $y);
                break;
            case 'Rook':
                $piece = new Rook($color,$player, $x, $y);
                break;
            case 'Knight':
                $piece = new Knight($color,$player, $x, $y);
                break;
            case 'Bishop':
                $piece = new Bishop($color,$player, $x, $y);
                break;
            case 'Queen':
                $piece = new Queen($color,$player, $x, $y);
                break;
            case 'King':
                $piece = new King($color,$player, $x, $y);
                break;
            default:
                throw new Exception("Invalid piece type: $type");
        }
        
        // Add the piece to the player's list
        $player->addPiece($piece);
        
        return $piece;
    }
    
}

