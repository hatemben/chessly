<?php

namespace ChessGame\Chess;

use ChessGame\BoardGame\BoardGame;
use ChessGame\BoardGame\Player;
use ChessGame\Chess\King;
use Exception;

class ChessGame extends BoardGame {
    // Chess specific implementation

    private $scores;
    private $gameOver = false;
    private $moveHistory = [];


    public function getBoard() {
        return $this->board;
    }
    public function __construct(array $players) {
        if (count($players) !== 2) {
            throw new Exception("Chess game requires exactly 2 players");
        }
        parent::__construct($players);
        $this->board = ChessBoard::getInstance($players); // Singleton pattern
      //  $this->board = new ChessBoard($players); Without singleton pattern
        $this->initScores();
    }
    

    private function initScores(): void {
        foreach ($this->players as $player) {
            $this->scores[$player->getName()] = 0;
        }
    }

    //...
    public function getGameState(): array {
        $state = [];
        foreach ($this->board->getGrid() as $row) {
            $rowState = '';
            foreach ($row as $cell) {
                if ($cell === null) {
                    $rowState .= '.';
                } else {
                    $rowState .= $cell->getName()[0];  // assuming getName() returns the name of the piece
                }
            }
            $state[] = $rowState;
        }
        return $state;
    }    

    public function getScores(): array {
        return $this->scores;
    }

    public function isOver(): bool {
        return $this->gameOver;
    }
    

    public function makeMove(Player $player, array $move): bool {
        [$from, $to] = [$move['from'], $move['to']];
        $piece = $this->getBoard()->getPieceAt($from);

        if ($piece === null || $piece->getColor() !== $player->getColor()) {
            return false;
        }

        if (!$piece->isValidMove($from, $to)) {
            return false;
        }

        // Check if the path is clear for the move
        if (!$piece->isPathClear($from, $to, $this->getBoard())) {
            return false;
        }
        
        // Create a new move command
        $command = new ChessMoveCommand($piece, $from, $to, $this);
    
        // Execute the move command
        $command->execute();
    
        // Add the move command to the history
        $this->moveHistory[] = $command;
    
        // Check if the opponent's king is in check
         $opponent = $this->getOpponent($player);
        if ($this->isKingInCheck($player)) {
            // Trigger the "check" event
            $this->notifyObservers('check', $opponent->getName());
        } //*/

        // Switch player
        $this->nextPlayer();
    
        return true;
    }
    

    public function undoLastMove(): void {
        $lastMove = array_pop($this->moveHistory);
        if ($lastMove) {
            $lastMove->undo();
            $this->nextPlayer();
        }
    }
    
    
    public function removeChessPiece(ChessPiece $piece): void {
        if ($piece->isKing()) {
            $this->gameOver = true;
        //    echo "Game Over! Player " . ($piece->getColor() == 'white' ? 2 : 1) . " wins!";
            $this->notifyObservers('gameOver', $piece->getColor() == 'white' ? 2 : 1); // With Observer Pattern
        }
        // Remove the piece from the board
        $this->getBoard()->removePiece($piece->getX(), $piece->getY());
        
        // Remove the piece from the player's list of pieces
        $piece->getPlayer()->removePiece($piece);

        // Notify about piece removal
        $this->notifyObservers('pieceRemoved', $piece);
    }
    


    public function getCurrentPlayerIndex(): int {
        return $this->currentPlayerIndex;
    }
    public function getPlayers(): array {
        return $this->players;
    }

    public function nextPlayer(): void {
        // Switch between player 1 and player 2
        $this->currentPlayerIndex = $this->currentPlayerIndex === 0 ? 1 : 0;
    }
    
    public function isKingInCheck(Player $player): bool {
        // Get the King's location
        $kingLocation = $this->getKing($this->getOpponent($player));

        // Get all current player's pieces
        $currentPlayerPieces = $this->getPieces($player);
    
        foreach ($currentPlayerPieces as $piece) 
        {
            $captureMove = $piece->isCaptureMove($piece->getLocation(), $kingLocation, $this->board, true);
            $clearPath = $piece->isPathClear($piece->getLocation(), $kingLocation, $this->board);
    
            if ($captureMove && $clearPath) {
                return true;  // King is in check
            }
        }
        return false;  // King is not in check
    }
    
    
    private function getKing(Player $player) {
        // Get all pieces of the player
        $pieces = $this->getPieces($player);
    
        // Find the King among the pieces
        foreach ($pieces as $piece) {
            if ($piece instanceof King) {
                return [$piece->getX(), $piece->getY()];
            }
        }
        
        throw new Exception("King not found for player.");
    }    
    

    private function getPieces(Player $player): array {
        // Collect all pieces for a player
        $pieces = [];
        for ($row = 0; $row < 8; $row++) {
            for ($col = 0; $col < 8; $col++) {
                $piece = $this->board->getPieceAt([$row, $col]);
                if ($piece !== null && $piece->getPlayer() === $player) {
                    $pieces[] = $piece;
                }
            }
        }
        return $pieces;
    }
    
    private function getOpponent(Player $player): Player {
        foreach ($this->players as $p) {
            if ($p !== $player) {
                return $p;
            }
        }
        
        throw new Exception("Opponent not found for player.");
    }
}
