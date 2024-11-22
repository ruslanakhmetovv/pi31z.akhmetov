<?php

require_once('IFigure.php');

class Queen extends Figure {
    protected array $icon = ["\u{265B}", "\u{2655}"];
    public function canMove(int $from_row, int $from_col, int $to_row, int $to_col, Board $board): bool {
       
        if ($from_row === $to_row || $from_col === $to_col) {
            return $this->isPathClear($from_row, $from_col, $to_row, $to_col, $board);
        }

        if (abs($from_row - $to_row) === abs($from_col - $to_col)) {
            return $this->isPathClear($from_row, $from_col, $to_row, $to_col, $board);
        }

        return false;
    }

    private function isPathClear(int $from_row, int $from_col, int $to_row, int $to_col, Board $board): bool {

        $rowStep = $from_row === $to_row ? 0 : ($to_row > $from_row ? 1 : -1);
        $colStep = $from_col === $to_col ? 0 : ($to_col > $from_col ? 1 : -1);

        $currentRow = $from_row + $rowStep;
        $currentCol = $from_col + $colStep;

        while ($currentRow !== $to_row || $currentCol !== $to_col) {
            if ($board->getItem($currentRow, $currentCol) !== null) {
                return false; 
            }
            $currentRow += $rowStep;
            $currentCol += $colStep;
        }

        return true; 
}
}