<?php
set_error_handler("errorMessage");

// generate migrate
function CmdMigrate(array $data, $namespace)
{
    // field for params msg validate
    $result = '';
    $no = 1;
    foreach ($data as $row) {
        $string = '';
        $opt = empty($row['optional']) ? null : $row['optional'];

        // if there optional
        if ($opt != null) {
            $str = preg_replace('/\s+/', '', $opt);
            $optional = explode(',', $str);

            foreach ($optional as $val) {
                $string .= '->' . $val;
            }
        }

        if ($no == 1) {
            $result .= "\$table->" . $row['jenis'] . "('" . $row['name'] . "')" . $string . ";";

        } else {
            $result .= "\n\t\t\$table->" . $row['jenis'] . "('" . $row['name'] . "')" . $string . ";";
        }

        $no ++;
    }

    // open templates
    $template = 'templates/migrate.txt';

    $fh = fopen($template, 'r');
    $txtRead = '';
    while ($line = fgets($fh)) {

        // replace character
        $txtRead .= RegexMigrate($line, $namespace, $result);
    }

    fclose($fh);

    // result
    return $txtRead;
}

// generate controller
function CmdController(array $data, $namespace)
{
    // field for params msg validate
    $result = '';
    $no = 1;
    foreach ($data as $row) {

        if ($no == 1) {
            $result .= "\t'" . $row['name'] . "' => \$message->first('" . $row['name'] . "'),";
        } else {
            $result .= "\n\t\t\t'" . $row['name'] . "' => \$message->first('" . $row['name'] . "'),";
        }

        $no ++;
    }

    // open templates
    $template = 'templates/controller.txt';

    $fh = fopen($template, 'r');
    $txtRead = '';
    while ($line = fgets($fh)) {

        // replace character
        $txtRead .= RegexController($line, $namespace, $result);
    }

    fclose($fh);

    // result
    return $txtRead;
}

// generate interface
function CmdInterface($namespace)
{
    // open templates
    $template = 'templates/interface.txt';

    $fh = fopen($template, 'r');
    $txtRead = '';
    while ($line = fgets($fh)) {

        // replace character
        $txtRead .= RegexInterface($line, $namespace);
    }

    fclose($fh);

    // result
    return $txtRead;
}

// generate repository
function CmdRepository(array $data, $namespace)
{
    // field for params insert
    $result = '';
    $no = 1;
    foreach ($data as $row) {
        if ($no == 1) {
            $result .= "\$" . fixNamescape($namespace, 2) . "->" . $row['name'] . " = e(\$data['" . $row['name'] . "']);";

        } else {
            $result .= "\n\t\t\$" . fixNamescape($namespace, 2) . "->" . $row['name'] . " = e(\$data['" . $row['name'] . "']);";
        }

        $no ++;
    }

    // open templates
    $template = 'templates/repository.txt';

    $fh = fopen($template, 'r');
    $txtRead = '';
    while ($line = fgets($fh)) {

        // replace character
        $txtRead .= RegexRepository($line, $namespace, $result);
    }

    fclose($fh);

    // result
    return $txtRead;
}

// generate model
function CmdModel(array $data, $namespace)
{
    // field for params msg validate
    $result = '';
    $no = 1;
    $search = '';

    foreach ($data as $row) {

        if ($no == 1) {
            $search = $row['name'];
            $result .= "'" . $row['name'] . "',";

        } else {
            $result .= "\n\t'" . $row['name'] . "',";
        }

        $no ++;
    }

    $result .= "\n\t'user_id',\n\t'organisasi_id',";

    // open templates
    $template = 'templates/model.txt';

    $fh = fopen($template, 'r');
    $txtRead = '';
    while ($line = fgets($fh)) {

        // replace character
        $txtRead .= RegexModel($line, $namespace, $result, $search);
    }

    fclose($fh);

    // result
    return $txtRead;
}

// generate request/ validation
function CmdRequest(array $data, $namespace)
{
    // field for params msg validate
    $res_rules = '';
    $res_attr = '';
    $res_input = '';
    $no = 1;

    foreach ($data as $row) {

        $jenis = empty($row['jenis']) ? null : $row['jenis'];

        switch ($jenis) {
            case 'string' :
                $status = 'required|max:255';
                break;
            case 'integer':
            case 'double':
                $status = 'required|integer|max:2000000000';
                break;
            case 'smallInteger':
                $status = 'required|integer|max:10';
                break;
            default:
                $status = 'required';
        }

        $name = empty($row['name']) ? 'noname' : $row['name'];

        // name attributes
        $nm = preg_replace('/_/', ' ', $name);
        $nm_attr = ucwords(strtolower($nm));
        if ($no == 1) {
            $res_rules .= "\t'" . $name . "' => '" . $status . "',";
            $res_attr .= "\t'" . $name . "' => '" . $nm_attr . "',";
            $res_input .= "\t'" . $name . "',";

        } else {
            $res_rules .= "\n\t\t'" . $name . "' => '" . $status . "',";
            $res_attr .= "\n\t\t'" . $name . "' => '" . $nm_attr . "',";
            $res_input .= "\n\t\t'" . $name . "',";
        }

        $no ++;
    }

    // open templates
    $template = 'templates/request.txt';

    $fh = fopen($template, 'r');
    $txtRead = '';
    while ($line = fgets($fh)) {

        // replace character
        $txtRead .= RegexRequest($line, $namespace, $res_rules, $res_attr, $res_input);
    }

    fclose($fh);

    // result
    return $txtRead;
}

// method regex laravel templates for templates migrate
function RegexMigrate($str, $namespace, $field)
{

    $patterns = ['/{{namespace}}/', '/{{var_table}}/', '/{{var_field}}/'];
    $replacements = [fixNamescape($namespace, 1), fixNamescape($namespace, 5), $field];

    // add string text
    return preg_replace($patterns, $replacements, $str);
}

// method regex laravel templates for templates controller
function RegexController($str, $namespace, $field)
{

    $patterns = ['/{{namespace}}/', '/{{var_namespace}}/', '/{{var_comment}}/', '/{{var_field}}/'];
    $replacements = [fixNamescape($namespace, 1), fixNamescape($namespace, 2), fixNamescape($namespace, 3), $field];

    // add string text
    return preg_replace($patterns, $replacements, $str);
}

// method regex laravel templates for templates interface
function RegexInterface($str, $namespace)
{

    $patterns = ['/{{namespace}}/', '/{{var_namespace}}/', '/{{var_comment}}/'];
    $replacements = [fixNamescape($namespace, 1), fixNamescape($namespace, 2), fixNamescape($namespace, 3)];

    // add string text
    return preg_replace($patterns, $replacements, $str);
}

// method regex laravel templates for templates repository
function RegexRepository($str, $namespace, $field)
{

    $patterns = ['/{{namespace}}/', '/{{var_namespace}}/', '/{{var_comment}}/', '/{{var_tags}}/', '/{{var_field}}/'];
    $replacements = [fixNamescape($namespace, 1), fixNamescape($namespace, 2), fixNamescape($namespace, 3), fixNamescape($namespace, 4), $field];

    // add string text
    return preg_replace($patterns, $replacements, $str);
}

// method regex laravel templates for templates model
function RegexModel($str, $namespace, $field, $search)
{

    $patterns = [
        '/{{namespace}}/',
        '/{{var_namespace}}/',
        '/{{var_comment}}/',
        '/{{var_tags}}/',
        '/{{var_table}}/',
        '/{{var_fillable}}/',
        '/{{var_search}}/'
    ];
    $replacements = [
        fixNamescape($namespace, 1),
        fixNamescape($namespace, 2),
        fixNamescape($namespace, 3),
        fixNamescape($namespace, 4),
        fixNamescape($namespace, 5),
        $field,
        $search
    ];

    // add string text
    return preg_replace($patterns, $replacements, $str);
}

// method regex laravel templates for templates request
function RegexRequest($str, $namespace, $rules, $attr, $input)
{

    $patterns = [
        '/{{namespace}}/',
        '/{{var_rules}}/',
        '/{{var_attributes}}/',
        '/{{var_input}}/'
    ];
    $replacements = [
        fixNamescape($namespace, 1),
        $rules,
        $attr,
        $input
    ];

    // add string text
    return preg_replace($patterns, $replacements, $str);
}

// method fix namespace
function fixNamescape($str, $jenis = 0)
{
    switch ($jenis) {
        case 1:
            // default namespace. ex: NameSpace
            $str = strtolower($str); // change to lowercase
            $str = ucwords($str); // uppercase each word
            return preg_replace('/\s+/', '', $str); // remove space
            break;

        case 2:
            // variable from namespace. ex: nameSpace
            $str = strtolower($str); // change to lowercase
            $str = ucwords($str); // uppercase each word
            $str = preg_replace('/\s+/', '', $str); // remove space

            return lcfirst($str);
            break;

        case 3:
            // text comment. ex: name space
            return strtolower($str);
            break;

        case 4:
            // tags name for cache. ex: name-space
            $str = strtolower($str);

            return preg_replace('/\s+/', '-', $str);
            break;

        case 5:
            // table name. ex: name_space
            $str = strtolower($str);

            return preg_replace('/\s+/', '_', $str);
            break;

        default:
            return $str;
    }

}

function CreateWriteFile($dir, $fileName, $string, $extension = 'php')
{
    // Check is exist directory
    if (!file_exists($dir)) {
        //  create directory and stop if failed
        mkdir($dir, 0777, true) or die('Cannot create folder ' . $dir);
    }

    if (empty($fileName)) {
        die('Please input specific name!');
    }

    // check empty and fix if extension has dot (.)
    // $ext = empty($extension) ? 'php' : preg_replace('/./', '', $extension);

    $newFileName = $dir . $fileName . "." . $extension;

    if (file_put_contents($newFileName, $string) != false) {
        return "Success create file " . $fileName . "\nYou can check your directory in " . $dir;
    } else {
        return "Cannot create file " . $fileName;
    }
}