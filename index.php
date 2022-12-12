<?php
$jsonTestCases = file_get_contents('testcases.json');
$testCases = json_decode($jsonTestCases);
foreach ($testCases as $caseName => $caseData) {
    echo "-----------------------------------<br />";
    echo $caseName . ' wordt getest<br />';
    echo 'expected output: <br />';
    echo str_replace("\n", '<br />', str_replace(' ', '&nbsp;', $caseData->expectedOutput)) . '<br /><br />';

    $input = getInput($caseData);

    echo "-----------------------------------<br />";
    echo "actual output:<br />";

    extractOutputFromInput($input, $caseData->L);

    echo "<br />";
}

function extractOutputFromInput(array $cells, int $L): void {
    $lights = getLights($cells);

    $amountOfEmptySpots = 0;
    foreach ($cells as $i => $rows) {
        foreach ($rows as $j => $cell) {
            if ($cell !== 'X') {
                continue;
            }

            $gotLight = false;
            foreach ($lights as $light) {
                if (abs($light[0] - $i) < $L && abs($light[1] - $j) < $L) {
                    $gotLight = true;
                }
            }

            if ($gotLight) {
                continue;
            }

            $amountOfEmptySpots++;
        }
    }
    echo $amountOfEmptySpots;
}

function getInput(stdClass $caseData): array {
    $inputLines = explode("\n", $caseData->input);

    $inputLinesArray = [];
    foreach ($inputLines as $inputLine) {
        $inputLinesArray[] = explode(' ', $inputLine);
    }

    return $inputLinesArray;
}

function getLights(array $cells): array {
    $lights = [];
    foreach ($cells as $i => $rows) {
        foreach ($rows as $j => $cell) {
            if ($cell === 'C') {
                $lights[] = [$i, $j];
            }
        }
    }

    return $lights;
}