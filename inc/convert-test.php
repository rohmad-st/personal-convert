<?php
include('global_func.php');
set_error_handler("errorMessage");

$hasilAkhir = '';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $tmpName = '';
    if ($_FILES['csv']['error'] == 0) {
        $tmpName = $_FILES['csv']['tmp_name'];
    }

    // nama tabel
    $tableName = $_POST['tbl_name'];

    $row = 1;
    $result = [];
    $lastResult = [];
    $num = 0;
    if (($handle = fopen($tmpName, "r")) !== FALSE) {
        while (($data = fgetcsv($handle, 1000, ",")) !== FALSE) {
            $num = count($data);
            if ($row == 1) {
                for ($c = 0; $c < $num; $c ++) {
                    $val = empty($data[$c]) ? null : $data[$c];
                    // push data in first line to array
                    array_push($result, $val);
                }
            }

            if ($row > 1) {
                for ($d = 0; $d < $num; $d ++) {
                    $val = empty($data[$d]) ? null : $data[$d];
                    // push data in first line to array
                    array_push($lastResult, $val);
                }
            }

            $row ++;
        }

        fclose($handle);

        $lastResult = array_chunk($lastResult, (int)$num);

        $hasil = [];
        for ($i = 0; $i < count($lastResult); $i ++) {
            // combine key and value
            $arr = array_combine($result, $lastResult[$i]);

            // add created_at
            $create = ['created_at' => "date('Y-m-d')"];

            // result is array
            array_push($hasil, $arr + $create);
        }

        // replace character string
        $json = json_encode($hasil);

        // return with beauty json format
        echo prettyJson($json, $tableName);
    }
}
