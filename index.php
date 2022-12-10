<?php
$jsonTestCases = file_get_contents('testcases.json');
$testCases = json_decode($jsonTestCases);
foreach($testCases as $caseName => $caseData) {
    echo "-----------------------------------<br />";
    echo $caseName . ' wordt getest<br />';
    echo 'expected output: <br />';
    echo str_replace("\n", '<br />', str_replace(' ', '&nbsp;', $caseData->expectedOutput)) . '<br /><br />';

    $inputlines = explode("\n", $caseData->input);

    // ugly code to accommodate for the actual casus' data
    $L = 3;
    switch($caseName) {
        case 'THEY have a great hall':
            $L = 2;
            break;
        case 'Not Euclidean':
            $L = 4;
            break;
    }
    $inputLinesArray = [];
    foreach ($inputlines as $i => $inputline) {
        $inputLinesArray[] = explode(' ', $inputline);
    }

    echo "-----------------------------------<br />";
    echo "actual output:<br />";

    extractOutputFromInput($inputLinesArray, $L);

    echo "<br />";
}

function extractOutputFromInput($cells, $L) {
    $lights = [];
    foreach ($cells as $i => $rows) {
        foreach ($rows as $j => $cell) {
            if (trim($cell) == 'C') {
                $lights[] = [$i, $j];
            }
        }
    }

    $amountOfEmptySpots = 0;
    foreach($cells as $i => $rows) {
        foreach($rows as $j => $cell) {
            if (trim($cell) == 'X') {
                $gotLight = false;
                foreach($lights as $light) {
                    if(abs($light[0] - $i) < $L && abs($light[1] - $j) < $L) {
                        $gotLight = true;
                    }
                }
                if(!$gotLight) {
                    $amountOfEmptySpots++;
                }
            }
        }
    }
    echo $amountOfEmptySpots;
}