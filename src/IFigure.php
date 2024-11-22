<?php
require_once('color.php');
require_once('Board.php');

interface IFigure {
    public function __construct(Color $color);
    public function getColor(): Color;
    public function getIcon(): string;
    public function canMove(int $from_row, int $from_col, int $to_row, int $to_col, Board $board): bool;
    public function canAttack(int $from_row, int $from_col, int $to_row, int $to_col, Board $board): bool;
}

abstract class Figure implements IFigure {
    private Color $color;
    protected array $icon = [];

    public function __construct(Color $color){
        $this->color = $color;
    }

    public function getColor(): Color {
        return $this->color;
    }

    public function getIcon(): string {
        switch ($this->color) {
            case Color::Black: $index = 0; break;
            case Color::White: $index = 1; break;
            default: return '';
        }
        return array_key_exists($index, $this->icon)
            ? $this->icon[$index]
            : '';
    }

    public function canMove(int $from_row, int $from_col, int $to_row, int $to_col, Board $board): bool {
        return false;
    }

    public function canAttack(int $from_row, int $from_col, int $to_row, int $to_col, Board $board): bool {
        return false;
    }
}