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
    $prefix = empty($_POST['prefix']) ? $namespace : $_POST['prefix'];
    $tipe_generate = $_POST['tipe_generate'];

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

    switch ($tipe_generate) {
        case 1:
            // Generate on page
            $hasil = GenerateOnPage($process, $lastResult, $namespace, $prefix);
            $resultMigrate = $hasil['resultMigrate'];
            $resultController = $hasil['resultController'];
            $resultInterface = $hasil['resultInterface'];
            $resultRepository = $hasil['resultRepository'];
            $resultRequest = $hasil['resultRequest'];
            $resultModel = $hasil['resultModel'];
            break;

        case 2:
            // Generate to directory
            $hasil = GenerateToDir($process, $lastResult, $namespace, $prefix);
            $resultMigrate = $hasil['resultMigrate'];
            $resultController = $hasil['resultController'];
            $resultInterface = $hasil['resultInterface'];
            $resultRepository = $hasil['resultRepository'];
            $resultRequest = $hasil['resultRequest'];
            $resultModel = $hasil['resultModel'];
            break;
    }
}

function GenerateOnPage($process, $lastResult, $namespace, $prefix)
{
    $resultMigrate = '';
    $resultController = '';
    $resultInterface = '';
    $resultRepository = '';
    $resultRequest = '';
    $resultModel = '';

    // Do by type process
    switch ($process) {
        case 'mig':
            $resultMigrate = CmdMigrate($lastResult, $namespace);
            break;

        case 'con':
            $resultController = CmdController($lastResult, $namespace, $prefix);
            break;

        case 'int':
            $resultInterface = CmdInterface($namespace, $prefix);
            break;

        case 'rep':
            $resultRepository = CmdRepository($lastResult, $namespace, $prefix);
            break;

        case 'req':
            $resultRequest = CmdRequest($lastResult, $namespace, $prefix);
            break;

        case 'mod':
            $resultModel = CmdModel($lastResult, $namespace);
            break;

        case 'all':
            $resultMigrate = CmdMigrate($lastResult, $namespace);
            $resultController = CmdController($lastResult, $namespace, $prefix);
            $resultInterface = CmdInterface($namespace, $prefix);
            $resultRepository = CmdRepository($lastResult, $namespace, $prefix);
            $resultRequest = CmdRequest($lastResult, $namespace, $prefix);
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

    return [
        'resultMigrate'    => $resultMigrate,
        'resultController' => $resultController,
        'resultInterface'  => $resultInterface,
        'resultRepository' => $resultRepository,
        'resultRequest'    => $resultRequest,
        'resultModel'      => $resultModel,
    ];
}

function GenerateToDir($process, $lastResult, $namespace, $prefix)
{
    // Open setting.ini
    $iniFile = parse_ini_file("setting.ini", true) or die('Cannot open file setting.ini');

    // Default Name. result: NameSpace
    $nm = fixNamescape($namespace, 1);

    // prefix/group
    $pref = fixNamescape($prefix, 1);
    $group = empty($prefix) ? $nm . '/' : $pref . '/';

    // location
    $loc_migrate = $iniFile['location']['migrate'];
    $loc_controller = $iniFile['location']['controller'] . $group;
    $loc_interface = $iniFile['location']['interface'] . $group;
    $loc_repository = $iniFile['location']['repository'] . $group;
    $loc_request = $iniFile['location']['request'] . $group;
    $loc_model = $iniFile['location']['model'];

    // result: 2015_10_26_171248_create_table_nama_tabel
    $nm_migrate = date('Y_m_d_His') . '_create_table_' . fixNamescape($namespace, 5);
    $nm_controller = $nm . 'Controller';
    $nm_interface = $nm . 'Interface';
    $nm_repository = $nm . 'Repository';
    $nm_request = $nm . 'CreateForm';
    $nm_model = $nm;

    $resultMigrate = '';
    $resultController = '';
    $resultInterface = '';
    $resultRepository = '';
    $resultRequest = '';
    $resultModel = '';

    // Do by type process
    switch ($process) {
        case 'mig':
            $string = CmdMigrate($lastResult, $namespace);
            $resultMigrate = CreateWriteFile($loc_migrate, $nm_migrate, $string);
            break;

        case 'con':
            $string = CmdController($lastResult, $namespace, $prefix);
            $resultController = CreateWriteFile($loc_controller, $nm_controller, $string);
            break;

        case 'int':
            $string = CmdInterface($namespace, $prefix);
            $resultInterface = CreateWriteFile($loc_interface, $nm_interface, $string);
            break;

        case 'rep':
            $string = CmdRepository($lastResult, $namespace, $prefix);
            $resultRepository = CreateWriteFile($loc_repository, $nm_repository, $string);
            break;

        case 'req':
            $string = CmdRequest($lastResult, $namespace, $prefix);
            $resultRequest = CreateWriteFile($loc_request, $nm_request, $string);
            break;

        case 'mod':
            $string = CmdModel($lastResult, $namespace);
            $resultModel = CreateWriteFile($loc_model, $nm_model, $string);
            break;

        case 'all':
            $string = CmdMigrate($lastResult, $namespace);
            $resultMigrate = CreateWriteFile($loc_migrate, $nm_migrate, $string);

            $string = CmdController($lastResult, $namespace, $prefix);
            $resultController = CreateWriteFile($loc_controller, $nm_controller, $string);

            $string = CmdInterface($namespace, $prefix);
            $resultInterface = CreateWriteFile($loc_interface, $nm_interface, $string);

            $string = CmdRepository($lastResult, $namespace, $prefix);
            $resultRepository = CreateWriteFile($loc_repository, $nm_repository, $string);

            $string = CmdRequest($lastResult, $namespace, $prefix);
            $resultRequest = CreateWriteFile($loc_request, $nm_request, $string);

            $string = CmdModel($lastResult, $namespace);
            $resultModel = CreateWriteFile($loc_model, $nm_model, $string);
            break;

        default:
            $resultMigrate = '';
            $resultController = '';
            $resultInterface = '';
            $resultRepository = '';
            $resultRequest = '';
            $resultModel = '';
    }

    return [
        'resultMigrate'    => $resultMigrate,
        'resultController' => $resultController,
        'resultInterface'  => $resultInterface,
        'resultRepository' => $resultRepository,
        'resultRequest'    => $resultRequest,
        'resultModel'      => $resultModel,
    ];
}