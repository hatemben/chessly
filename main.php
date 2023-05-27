<?php

require_once 'classes/BoardGame/BoardGame.php';
require_once 'classes/BoardGame/Player.php';
require_once 'classes/BoardGame/Observer.php';
require_once 'classes/BoardGame/MoveCommand.php';

require_once 'classes/Chess/ChessGame.php';
require_once 'classes/Chess/ChessPiece.php';
require_once 'classes/Chess/Pawn.php';
require_once 'classes/Chess/Rook.php';
require_once 'classes/Chess/Bishop.php';
require_once 'classes/Chess/King.php';
require_once 'classes/Chess/Knight.php';
require_once 'classes/Chess/Queen.php';

require_once 'classes/Chess/ChessObserver.php';
require_once 'classes/Chess/ChessCommand.php';
require_once 'classes/Chess/ChessPieceFactory.php';
require_once 'classes/Chess/ChessBoard.php';
require_once 'classes/CLIBoardGameController.php';

use ChessGame\BoardGame\Player;
use ChessGame\Chess\ChessGame;
use ChessGame\CLIBoardGameController;
use ChessGame\Chess\ChessObserver;

$players = [new Player('Player 1', 'white'), new Player('Player 2', 'black')];
$game = new ChessGame($players);
$chessObserver = new ChessObserver();
$game->addObserver($chessObserver);
$controller = new CLIBoardGameController($game, $players);
$controller->start();
