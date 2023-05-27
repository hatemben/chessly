<?php

namespace ChessGame\BoardGame;

interface MoveCommand {
    public function execute();
    public function undo();
}
