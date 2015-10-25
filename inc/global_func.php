<?php
set_error_handler("errorMessage");

// Beautifier code
function prettyJson($json, $table = null)
{
    $result = '';
    $level = 0;
    $in_quotes = false;
    $in_escape = false;
    $ends_line_level = NULL;
    $json_length = strlen($json);

    for ($i = 0; $i < $json_length; $i ++) {
        $char = $json[$i];
        $new_line_level = NULL;
        $post = "";
        if ($ends_line_level !== NULL) {
            $new_line_level = $ends_line_level;
            $ends_line_level = NULL;
        }
        if ($in_escape) {
            $in_escape = false;
        } else if ($char === '"') {
            $in_quotes = !$in_quotes;
        } else if (!$in_quotes) {
            switch ($char) {
                case '}':
                case ']':
                    $level --;
                    $ends_line_level = NULL;
                    $new_line_level = $level;
                    break;

                case '{':
                case '[':
                    $level ++;
                case ',':
                    $ends_line_level = $level;
                    break;

                case ':':
                    $post = " ";
                    break;

                case " ":
                case "\t":
                case "\n":
                case "\r":
                    $char = "";
                    $ends_line_level = $new_line_level;
                    $new_line_level = NULL;
                    break;
            }
        } else if ($char === '\\') {
            $in_escape = true;
        }

        if ($new_line_level !== NULL) {
            $result .= "\n" . str_repeat("\t", $new_line_level);
        }
        $result .= $char . $post;
    }

    return replaceString($result, $table);
}

// Replace character, make string like json format
function replaceString($string, $table = null)
{
    $patterns = ['/": "/', '/{/', '/}/'];
    $replacements = ['" => "', '[', ']'];

    $tableName = empty($table) ? 'nama_tabel' : $table;

    // add string text
    $res = preg_replace($patterns, $replacements, $string);
    $hasil = "// truncate record\nDB::table('" . $tableName . "')->truncate();\n\n\$data"  . $res . ";\n\n// insert batch\nDB::table('" . $tableName . "')->insert(\$data);";

    return $hasil;
}

// Custom error handling
function errorMessage($error, $str)
{
    echo "<strong>Something wrong:</strong> [$error] $str<br>";
    die();
}
