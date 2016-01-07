<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">
    <link rel="icon" href="img/favicon.png">
    <title>Personal Convert - Generate Laravel 5.2</title>
    <link href="css/bootstrap.min.css" rel="stylesheet">
    <link href="css/style.css" rel="stylesheet">
    <!--[if lt IE 9]>
    <script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
    <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->
</head>
<body>
<?php
require('inc/laravel_52_func.php');
require('inc/navbar.php');
?>
<div class="container">
    <div class="row">
        <div class="col-md-12">
            <div class="well">
                <h2>Info</h2>

                <p>Generate Route, Migrate, Controller, Repository, Request, Model more faster.</p>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-md-12">
            <div class="well">
                <h2>Input Type Data</h2>

                <form id="frm_def" name="frm_def" class="form-inline"
                      action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>"
                      method="post">
                    <div class="form-group">
                        <div id="div_multi">
                            <input type="hidden" id="def_length" name="def_length" value="1">
                            <input type="hidden" id="is_process" name="is_process" value="all">
                            <input type="hidden" id="namespace" name="namespace">
                            <input type="hidden" id="prefix" name="prefix">
                            <!-- Type Generate 1: on this page; 2= create to app -->
                            <input type="hidden" id="tipe_generate" name="tipe_generate" value="1">

                            <div id="frm_def_ls_1">
                                <input id="def_name_1" name="def_name_1" type="text"
                                       class="form-control input-expand-sm def_name"
                                       placeholder="Nama field"
                                       autofocus="autofocus">
                                <label for="def_jenis_1" class="sr-only">Jenis</label>
                                <select id="def_jenis_1" name="def_jenis_1"
                                        class="form-control input-expand-sm def_jenis">
                                    <option value="string">String</option>
                                    <option value="integer">Integer</option>
                                    <option value="double">Double</option>
                                    <option value="text">Text</option>
                                    <option value="boolean">Boolean</option>
                                    <option value="timestamp">Timestamp</option>
                                    <option value="bigIncrements">Big Increments</option>
                                    <option value="bigInteger">Big Integer</option>
                                    <option value="binary">Binary</option>
                                    <option value="char">Char</option>
                                    <option value="date">Date</option>
                                    <option value="dateTime">Date Time</option>
                                    <option value="decimal">Decimal</option>
                                    <option value="enum">Enum</option>
                                    <option value="float">Float</option>
                                    <option value="increments">Increments</option>
                                    <option value="longText">Long Text</option>
                                    <option value="mediumInteger">Medium Integer</option>
                                    <option value="mediumText">Medium Text</option>
                                    <option value="morphs">Morphs</option>
                                    <option value="smallInteger">Small Integer</option>
                                    <option value="tinyInteger">Tiny Integer</option>
                                    <option value="time">Time</option>
                                </select>
                                <input id="def_opt_1" name="def_opt_1" type="text"
                                       class="form-control input-expand-wd def_opt"
                                       placeholder="Optional. ex: default($value), nullable(), unsigned()">
                            </div>
                        </div>
                        <button id="btn_def" type="button" class="btn btn-primary pull-right" title="Add Row"
                                onclick="addElement()">
                            <i class="glyphicon glyphicon-plus"></i>
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-md-12">
            <div class="well">
                <form class="form-inline" method="post">
                    <h2>Setting</h2>

                    <div class="form-group">
                        <label for="proc_type" class="sr-only">Type</label>
                        <select name="proc_type" id="proc_type" class="form-control input-expand" required="required"
                                style="margin-right: 10px">
                            <option value="all">All Type</option>
                            <option value="mig">Migrate</option>
                            <option value="con">Controller</option>
                            <option value="rep">Repository</option>
                            <option value="req">Request</option>
                            <option value="mod">Model</option>
                        </select>
                        <label for="proc_namespace" class="sr-only">Namespace</label>
                        <input id="proc_namespace" name="proc_namespace" type="text" class="form-control input-expand"
                               placeholder="Namespace" required="required" style="margin-right: 10px; width:230px">
                        <input id="proc_prefix" name="proc_prefix" type="text" class="form-control input-expand"
                               placeholder="Prefix" required="required" style="margin-right: 10px; width:215px">
                        <button name="generate" id="generate" type="button" class="btn btn-primary btn-lg"
                                style="margin-top: -5px; margin-right: 5px">
                            Start Generate
                        </button>
                        <button name="create" id="create" type="button" class="btn btn-success btn-lg"
                                style="margin-top: -5px">
                            Create to App
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <!--  Textarea migrate  -->
    <div class="row" style="margin-bottom: 30px">
        <div class="col-md-12">
            <form class="form-stacked" name="f" id="output-form">
                <h2>Migrate Generated</h2>
                <fieldset>
                    <div class="clearfix">
                        <div class="input">
                            <textarea wrap="soft" class="col-md-12" rows="15" name="txt_migrate"
                                      id="txt_migrate"><?php echo $resultMigrate; ?></textarea>
                        </div>
                    </div>
                    <div class="actions pull-right">
                        <button class="btn btn-lg btn-danger" type="button" onClick="Clear('txt_migrate');">
                            Clear
                        </button>
                        <button class="btn btn-lg btn-primary" type="button" onClick="ClipBoard('txt_migrate');">
                            Select All
                        </button>
                    </div>
                </fieldset>
            </form>
        </div>
    </div>
    <!--  Textarea controller  -->
    <div class="row" style="margin-bottom: 30px">
        <div class="col-md-12">
            <form class="form-stacked">
                <h2>Controller Generated</h2>
                <fieldset>
                    <div class="clearfix">
                        <div class="input">
                            <textarea wrap="soft" class="col-md-12" rows="15" name="txt_controller"
                                      id="txt_controller"><?php echo $resultController; ?></textarea>
                        </div>
                    </div>
                    <div class="actions pull-right">
                        <button class="btn btn-lg btn-danger" type="button" onClick="Clear('txt_controller');">
                            Clear
                        </button>
                        <button class="btn btn-lg btn-primary" type="button" onClick="ClipBoard('txt_controller');">
                            Select All
                        </button>
                    </div>
                </fieldset>
            </form>
        </div>
    </div>
    <!--  Textarea repository  -->
    <div class="row" style="margin-bottom: 30px">
        <div class="col-md-12">
            <form class="form-stacked">
                <h2>Repository Generated</h2>
                <fieldset>
                    <div class="clearfix">
                        <div class="input">
                            <textarea wrap="soft" class="col-md-12" rows="15" name="txt_repository"
                                      id="txt_repository"><?php echo $resultRepository; ?></textarea>
                        </div>
                    </div>
                    <div class="actions pull-right">
                        <button class="btn btn-lg btn-danger" type="button" onClick="Clear('txt_repository');">
                            Clear
                        </button>
                        <button class="btn btn-lg btn-primary" type="button" onClick="ClipBoard('txt_repository');">
                            Select All
                        </button>
                    </div>
                </fieldset>
            </form>
        </div>
    </div>
    <!--  Textarea request  -->
    <div class="row" style="margin-bottom: 30px">
        <div class="col-md-12">
            <form class="form-stacked">
                <h2>Form Request Generated</h2>
                <fieldset>
                    <div class="clearfix">
                        <div class="input">
                            <textarea wrap="soft" class="col-md-12" rows="15" name="txt_request"
                                      id="txt_request"><?php echo $resultRequest; ?></textarea>
                        </div>
                    </div>
                    <div class="actions pull-right">
                        <button class="btn btn-lg btn-danger" type="button" onClick="Clear('txt_request');">
                            Clear
                        </button>
                        <button class="btn btn-lg btn-primary" type="button" onClick="ClipBoard('txt_request');">
                            Select All
                        </button>
                    </div>
                </fieldset>
            </form>
        </div>
    </div>
    <!--  Textarea model  -->
    <div class="row" style="margin-bottom: 30px">
        <div class="col-md-12">
            <form class="form-stacked">
                <h2>Model Generated</h2>
                <fieldset>
                    <div class="clearfix">
                        <div class="input">
                            <textarea wrap="soft" class="col-md-12" rows="15" name="txt_model"
                                      id="txt_model"><?php echo $resultModel; ?></textarea>
                        </div>
                    </div>
                    <div class="actions pull-right">
                        <button class="btn btn-lg btn-danger" type="button" onClick="Clear('txt_model');">
                            Clear
                        </button>
                        <button class="btn btn-lg btn-primary" type="button" onClick="ClipBoard('txt_model');">
                            Select All
                        </button>
                    </div>
                </fieldset>
            </form>
        </div>
    </div>
</div>
<script src="js/jquery.min.js"></script>
<script src="js/bootstrap.min.js"></script>
<script>
    $(document).ready(function () {
        var pt = $('#proc_type');
        var pp = $('#proc_prefix');

        $('#nav_laravel5').addClass('active');
        document.getElementById('is_process').value = pt.val();

        // submit form generate
        $('#generate').on('click', function () {
            var pn = $('#proc_namespace');
            if (pn.val() == '' || pn.val() == null) {
                alert('please input namespace!');
                pn.focus();

            } else {
                document.getElementById('tipe_generate').value = '1';

                // set namespace in form on top
                document.getElementById('namespace').value = pn.val();
                // set prefix in form on top
                document.getElementById('prefix').value = pp.val();

                document.getElementById('frm_def').submit();
            }
        });

        // submit form generate to directory app
        $('#create').on('click', function () {
            var pn = $('#proc_namespace');
            if (pn.val() == '' || pn.val() == null) {
                alert('please input namespace!');
                pn.focus();

            } else {
                document.getElementById('tipe_generate').value = '2';
                // set namespace in form on top
                document.getElementById('namespace').value = pn.val();
                // set prefix in form on top
                document.getElementById('prefix').value = pp.val();
                document.getElementById('frm_def').submit();
            }
        });

        pt.on('change', function () {
            var x = pt.val();

            // set to var hidden
            $('#is_process').val(x);
        })
    });

    function addElement() {

        // get current number in input hidden
        var len = $('#def_length').val();

        // for definite number in form
        var num = parseInt(len) + 1;

        // definite variabel
        var id = "<div id='frm_def_ls_" + num + "'>";
        var def_name = "<input id='def_name_" + num + "' name='def_name_" + num + "' type='text' class='form-control input-expand-sm def_name' placeholder='Nama field'>";
        var val = "<option value='string'>String</option><option value='integer'>Integer</option><option value='double'>Double</option><option value='text'>Text</option><option value='boolean'>Boolean</option><option value='timestamp'>Timestamp</option><option value='bigIncrements'>Big Increments</option><option value='bigInteger'>Big Integer</option><option value='binary'>Binary</option><option value='char'>Char</option><option value='date'>Date</option><option value='dateTime'>Date Time</option><option value='decimal'>Decimal</option><option value='enum'>Enum</option><option value='float'>Float</option><option value='increments'>Increments</option><option value='longText'>Long Text</option><option value='mediumInteger'>Medium Integer</option><option value='mediumText'>Medium Text</option><option value='morphs'>Morphs</option><option value='smallInteger'>Small Integer</option><option value='tinyInteger'>Tiny Integer</option><option value='time'>Time</option>";
        var def_jenis = "<label for='def_jenis_" + num + "' class='sr-only'>Jenis</label><select id='def_jenis_" + num + "' name='def_jenis_" + num + "' class='form-control input-expand-sm def_jenis'>" + val + "</select>";

        var def_opt = "<input id='def_opt_" + num + "' name='def_opt_" + num + "' type='text' class='form-control input-expand-wd def_opt' placeholder='Optional. ex: default($value), nullable(), unsigned()'>";
        var id_last = "</div>";

        // merge all element
        var app = id + def_name + ' ' + def_jenis + ' ' + def_opt + ' ' + id_last;

        // append element to div & increment current number
        $('#div_multi').append(app);

        // Increment hidden input number using id
        incrementValue('def_length');
    }

    function incrementValue(id) {
        var value = parseInt(document.getElementById(id).value, 10);
        value = isNaN(value) ? 0 : value;
        value++;
        document.getElementById(id).value = value;
    }

    function ClipBoard(id) {
        $('#' + id).select();
    }

    function Clear(id) {
        var x = $('#' + id);
        x.val('');
        x.focus();
    }
</script>
</body>
</html>