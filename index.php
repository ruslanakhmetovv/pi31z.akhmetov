<?php
ini_set('display_errors', 1);

require_once ('src/color.php');
require_once ('src/Board.php');

$board = new Board();
while (True) {
    $board->printBoard();
    echo PHP_EOL;
    echo 'Команды:' . PHP_EOL;
    echo '    exit                          -- выход' . PHP_EOL;
    echo '    <col1><row1> <col2><row2>     -- ход из клетки (col1, row1)' . PHP_EOL;
    echo '                                     в клетку (col2, row2)' . PHP_EOL;
    echo 'Ход ';
    echo ($board->getPlayer() === Color::White ? 'белых' : 'черных') . ':' . PHP_EOL;
    $cmd = readline();
    $cmd = strtolower(trim($cmd));
    if ($cmd === 'exit') {
        exit;
    }
    if (!preg_match('/^([A-H])([1-8]) ([A-H])([1-8])$/i', $cmd, $founds)) {
        echo 'Неверная команда (для продолжения нажмите Enter)' . PHP_EOL;
        readline();
        continue;
    }
    $from_col = ord($founds[1]) - ord('a');
    $from_row = intval($founds[2]) - 1;
    $to_col = ord($founds[3]) - ord('a');
    $to_row = intval($founds[4]) - 1;
    try {
        $board->move($from_row, $from_col, $to_row, $to_col);
    } catch(Exception $e) {
        echo $e->getMessage();
        echo ' (для продолжения нажмите Enter)' . PHP_EOL;
        readline();
    }
}