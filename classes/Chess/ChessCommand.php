<?php

namespace ChessGame\Chess;

use ChessGame\BoardGame\MoveCommand;

class ChessMoveCommand implements MoveCommand {
    private $piece;
    private $source;
    private $destination;
    private $chessGame;
    private $capturedPiece;

    public function __construct(ChessPiece $piece, array $source, array $destination, ChessGame $chessGame) {
        $this->piece = $piece;
        $this->source = $source;
        $this->destination = $destination;
        $this->chessGame = $chessGame;
    }

    public function execute() {
        // Keep track of the piece at the destination in case we need to undo this move
        $this->capturedPiece = $this->chessGame->getBoard()->getPieceAt($this->destination);
    
        // Check if the move is a capture move
        if ($this->piece->isCaptureMove($this->source, $this->destination, $this->chessGame->getBoard())) {
            // If it is, remove the captured piece from the game
            if ($this->capturedPiece !== null) {
                $this->chessGame->removeChessPiece($this->capturedPiece);
            }
        }
    
        // Perform the move
        $this->chessGame->getBoard()->movePiece($this->source, $this->destination);
    
        // Update the piece's position
        $this->piece->setPosition($this->destination[0], $this->destination[1]);
    }
    

    public function undo() {
        // Move the piece back to its original location
        $this->chessGame->getBoard()->forceMovePiece($this->destination, $this->source);
        
        // If a piece was captured, put it back
        if ($this->capturedPiece) {
            $this->chessGame->getBoard()->setPieceAt($this->destination, $this->capturedPiece);
        }
    }
}
