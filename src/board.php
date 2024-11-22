<?php
require_once('color.php');
require_once('IFigure.php');
require_once('Pawn.php');
require_once('Rook.php');
require_once('Knight.php');

class Board {
    private Color $player = Color::White;

    private array $board = [];

    public function __construct() {
        for ($i = 0; $i < 8; $i += 1) {
            $this->board[] = [];
            for ($j = 0; $j < 8; $j += 1) {
                $this->board[$i][] = null;
            }
        }
        foreach ([6, 1] as $row) {
            for ($col = 0; $col < 8; $col += 1) {
                try {
                    $this->setItem(
                        $row,
                        $col,
                        new Pawn(
                            $row === 1 ? Color::White : Color::Black
                        )
                    );
                } catch(Exception $e){
                    print_r([$row, $col]);
                }
            }
        }
        foreach ([7, 0] as $row) {
            foreach ([0, 7] as $col) {
                $this->setItem(
                    $row,
                    $col,
                    new Rook(
                        $row === 0 ? Color::White : Color::Black
                    )
                );
            }
            foreach ([1, 6] as $col) {
                $this->setItem(
                    $row,
                    $col,
                    new Knight(
                        $row === 0 ? Color::White : Color::Black
                    )
                );
            }
        }
    }

    public function getItem(int $row, int $col): IFigure | null {
        if (!$this->isCorrectCoordinate($row, $col)) {
            return null;
        }
        return $this->board[$row][$col];
    }

    private function isCorrectCoordinate(int $row, int $col): bool {
        return $row < 8 && $row >= 0 && $col < 8 && $col >= 0;
    }

    private function setItem(int $row, int $col, IFigure | null $item) : void {
        if ($this->isCorrectCoordinate($row, $col)) {
            $this->board[$row][$col] = $item;
        }
    }

    public function printBoard(): void {
        $line = implode('', [
            '   ',
            '+',
            str_repeat('---+', 8),
        ]) . PHP_EOL;
        echo $line;
        for ($i = 7; $i >= 0; $i -= 1) {
            echo $i + 1;
            echo '  |';
            for ($j = 0; $j < 8; $j += 1) {
                echo ' ';
                $item = $this->getItem($i, $j);
                if ($item) {
                    echo $item->getIcon();
                } else {
                    echo ' ';
                }
                echo ' |';
            }
            echo PHP_EOL;
            echo $line;
        }
        echo '   ';
        for ($i = 0; $i < 8; $i += 1) {
            echo '  ';
            echo chr(ord('A') + $i);
            echo ' ';
        }
        echo PHP_EOL;
    }

    private function changePlayer() {
        $this->player = $this->getPlayer() === Color::White
            ? Color::Black
            : Color::White;
    }

    public function getPlayer(): Color {
        return $this->player;
    }

    public function move(int $from_row, int $from_col, int $to_row, int $to_col): void {
        $item = $this->getItem($from_row, $from_col);
        if (!$item) {
            throw new Exception('Фигура отсутствует');
        }
        if ($this->getPlayer() !== $item->getColor()) {
            throw new Exception('Сейчас не ваш ход');
        }
        if ($from_col == $to_col && $from_row == $to_row) {
            throw new Exception('Мы топчимся на месте');
        }
        $opponent = $this->getItem($to_row, $to_col);
        if (!$opponent) {
            if (!$item->canMove($from_row, $from_col, $to_row, $to_col, $this)) {
                throw new Exception('Так ' . $item->getIcon() . ' ходить не может');
            }
        } else if ($opponent->getColor() === $item->getColor()) {
            throw new Exception('Мы не можем срубить свою фигуру');
        } else {
            if (!$item->canAttack($from_row, $from_col, $to_row, $to_col, $this)) {
                throw new Exception('Так ' . $item->getIcon() . ' ходить не может');
            }
        }
        $this->setItem($from_row, $from_col, null);
        $this->setItem($to_row, $to_col, $item);
        $this->changePlayer();
    }
}