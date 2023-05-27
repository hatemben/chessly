<?php

namespace ChessGame\Chess;

use ChessGame\BoardGame\Player;

abstract class ChessPiece {
    // Define constants for colors
    const WHITE = 'white';
    const BLACK = 'black';

    protected $color;
    protected $player;
    protected $hasMoved;
    protected $x;
    protected $y;

    public function __construct(string $color, Player $player) {
        $this->color = $color;
        $this->player = $player;

    }
    abstract public function isValidMove($from, $to): bool;
    abstract public function isPathClear(array $from, array $to, ChessBoard $board): bool;
    public function isCaptureMove(array $from, array $to, ChessBoard $board) {
        // 1. Check if the move is valid.
        if (!$this->isValidMove($from, $to)) {
            return false;
        }
        // 2. Check if there's a piece at the destination.
        $targetPiece = $board->getPieceAt($to);
        if ($targetPiece === null) {
            return false;
        }
        // 3. Check if the piece at the destination belongs to the enemy.
        if ($targetPiece->getColor() === $this->getColor()) {
            return false;
        }
        // If all checks passed, this is a valid capture move.
        return true;
    }

    // Add getName method here:
    public function getName(): string {
        $name = substr(strrchr(get_class($this), "\\"), 1);
        return $this->color === 'white' ? strtoupper($name[0]) : strtolower($name[0]);
    }

    public function getPlayer() {
        return $this->player;
    }

    public function hasMoved(): bool {
        return $this->hasMoved;
    }

    public function setHasMoved(bool $hasMoved) {
        $this->hasMoved = $hasMoved;
    }

    public function getColor() {
        return $this->color;
    }

    public function setColor($color) {
        $this->color = $color;
    }
 
    public function getX(): int {
        return $this->x;
    }

    public function getY(): int {
        return $this->y;
    }

    public function setX(int $x): void {
        $this->x = $x;
    }

    public function setY(int $y): void {
        $this->y = $y;
    }

    public function isKing(): bool {
        // Check if the piece is a king
        return get_class($this) === King::class;
    }

    public function setPosition(int $x, int $y): void {
        $this->x = $x;
        $this->y = $y;
    }
    
    public function getLocation(): array {
        return [$this->getX(), $this->getY()];
    }    
}
