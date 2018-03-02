<?php

$gen_count = 1000;
$ascii = '3456789ABCDEFGHJKLMNPQRSTUVWXY';
$gen_code_format = '**********-**';


// MEMO 30文字16桁で↓のパターン生成
// 430,467,210,000,000,000,000,000

$range_min = 0;
$range_max = strlen($ascii) - 1;

$gen_code_array = array();

$file_name = 'serial_list_' . date('mdHis') . '.txt';

$fp = fopen($file_name, "wb");

for ($i = 0; $i < $gen_count; $i ++) {

    $gen_code = '';

    for ($j = 0; $j < strlen($gen_code_format); $j ++) {

        if (substr($gen_code_format, $j, 1) == '-') {

            $gen_code .= substr($gen_code_format, $j, 1);

        } else if (substr($gen_code_format, $j, 1) == '*') {

            $gen_code .= get_unique_ascii($ascii, $range_min, $range_max);
        }

    }

    $gen_code_array[] = $gen_code;

    fwrite($fp, $gen_code . "\n");
}

fclose($fp);

// ユニークにする　生成件数とユニーク後で件数が変わったら、もう一回生成し直したほうがいい
var_dump(count($gen_code_array));
$uniqued_array = array_unique($gen_code_array);
var_dump(count($uniqued_array));


function get_unique_ascii($ascii, $range_min, $range_max)
{
    mt_srand();
    usleep(1);
    $randval = mt_rand($range_min, $range_max);

    return substr($ascii, $randval, 1);
}

