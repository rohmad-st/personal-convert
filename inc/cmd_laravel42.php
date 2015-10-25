<?php
set_error_handler("errorMessage");

// generate migrate
function CmdMigrate(array $data, $namespace)
{
    $result = '';
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

        $result .= "\t\$table->" . $row['jenis'] . "('" . $row['name'] . "')" . $string . ";\n";
    }

    // last result
    $nm_table = fixNamescape($namespace, 5);
    $lastResult = "Schema::create('" . $nm_table . "', function (\$table) {\n\t\$table->engine = 'InnoDB';\n\t\$table->string('_id');\n" . $result . "\t\$table->string('user_id');\n\t\$table->string('organisasi_id')->nullable()->default(null);\n\t\$table->string('user_creator')->nullable()->default(null);\n\t\$table->string('user_updater')->nullable()->default(null);\n\t\$table->timestamps();\n\t\$table->primary('_id');\n\t\$table->softDeletes();\n}";

    return $lastResult;
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

    $fieldLara = $result;

    // open templates
    $template = 'templates/controller.txt';

    $fh = fopen($template, 'r');
    $txtRead = '';
    while ($line = fgets($fh)) {

        // replace character
        $txtRead .= RegexController($line, $namespace, $fieldLara);
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

    $fieldLara = $result;

    // open templates
    $template = 'templates/repository.txt';

    $fh = fopen($template, 'r');
    $txtRead = '';
    while ($line = fgets($fh)) {

        // replace character
        $txtRead .= RegexRepository($line, $namespace, $fieldLara);
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
    $fieldLara = $result;

    // open templates
    $template = 'templates/model.txt';

    $fh = fopen($template, 'r');
    $txtRead = '';
    while ($line = fgets($fh)) {

        // replace character
        $txtRead .= RegexModel($line, $namespace, $fieldLara, $search);
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

    // combine result
    $rules = $res_rules;
    $attr = $res_attr;
    $input = $res_input;

    // open templates
    $template = 'templates/request.txt';

    $fh = fopen($template, 'r');
    $txtRead = '';
    while ($line = fgets($fh)) {

        // replace character
        $txtRead .= RegexRequest($line, $namespace, $rules, $attr, $input);
    }

    fclose($fh);

    // result
    return $txtRead;
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