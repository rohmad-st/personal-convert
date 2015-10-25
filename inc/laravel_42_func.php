<?php
include('global_func.php');
include('cmd_laravel42.php');

set_error_handler("errorMessage");

// definite variabel
$resultMigrate = '';
$resultController = '';
$resultInterface = '';
$resultRepository = '';
$resultRequest = '';
$resultModel = '';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // get field, type data, optional
    $length = $_POST['def_length'];
    $process = $_POST['is_process'];
    $namespace = $_POST['namespace'];

    $lastResult = [];
    for ($i = 1; $i < (int)$length + 1; $i ++) {
        $name = $_POST['def_name_' . $i];
        $jenis = $_POST['def_jenis_' . $i];
        $opt = $_POST['def_opt_' . $i];

        $result = [
            'name'     => $name,
            'jenis'    => $jenis,
            'optional' => $opt,
        ];

        array_push($lastResult, $result);
    }

    // Do by type process
    switch ($process) {
        case 'mig':
            $resultMigrate = CmdMigrate($lastResult, $namespace);
            break;

        case 'con':
            $resultController = CmdController($lastResult, $namespace);
            break;

        case 'int':
            $resultInterface = CmdInterface($namespace);
            break;

        case 'rep':
            $resultRepository = CmdRepository($lastResult, $namespace);
            break;

        case 'req':
            $resultRequest = CmdRequest($lastResult, $namespace);
            break;

        case 'mod':
            $resultModel = CmdModel($lastResult, $namespace);
            break;

        case 'all':
            $resultMigrate = CmdMigrate($lastResult, $namespace);
            $resultController = CmdController($lastResult, $namespace);
            $resultInterface = CmdInterface($namespace);
            $resultRepository = CmdRepository($lastResult, $namespace);
            $resultRequest = CmdRequest($lastResult, $namespace);
            $resultModel = CmdModel($lastResult, $namespace);
            break;

        default:
            $resultMigrate = '';
            $resultController = '';
            $resultInterface = '';
            $resultRepository = '';
            $resultRequest = '';
            $resultModel = '';

    }

}
