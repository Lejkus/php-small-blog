<?php
function czasTemu($dataSql) {
    $dataTimestamp = strtotime($dataSql);
    $roznica = time() - $dataTimestamp;

    if ($roznica < 60) {
        return 'Mniej niż minutę temu';
    } elseif ($roznica < 3600) {
        $minuty = floor($roznica / 60);
        return "$minuty " . ($minuty == 1 ? 'minutę temu' : 'minuty temu');
    } elseif ($roznica < 86400) {
        $godziny = floor($roznica / 3600);
        return "$godziny " . ($godziny == 1 ? 'godzinę temu' : 'godziny temu');
    } elseif ($roznica < 2592000) {
        $dni = floor($roznica / 86400);
        return "$dni " . ($dni == 1 ? 'dzień temu' : 'dni temu');
    } elseif ($roznica < 31536000) {
        $miesiace = floor($roznica / 2592000);
        return "$miesiace " . ($miesiace == 1 ? 'miesiąc temu' : 'miesiące temu');
    } else {
        $lata = floor($roznica / 31536000);
        return "$lata " . ($lata == 1 ? 'rok temu' : 'lata temu');
    }
}

// Przykład użycia:
// $dataSql = '2023-01-01 12:34:56';
// echo czasTemu($dataSql);
?>