<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">
    <link rel="icon" href="img/favicon.png">
    <title>Personal Convert - Convert CSV to Seeder Laravel</title>
    <link href="css/bootstrap.min.css" rel="stylesheet">
    <link href="css/style.css" rel="stylesheet">
    <!--[if lt IE 9]>
    <script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
    <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->
</head>
<body>
<?php
require('inc/convert.php');
require('inc/navbar.php');
?>
<div class="container">
    <div class="row">
        <div class="col-md-12">
            <div class="well">
                <h2>INFO</h2>

                <p>Convert file CSV (excel) kedalam bentuk format Seed Laravel.</p>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-md-12">
            <div class="well">
                <form name="file" class="form-inline"
                      action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>"
                      method="post"
                      enctype="multipart/form-data">
                    <div class="form-group">
                        <input type="file" name="csv" id="csv" class="form-control" required="required"/>
                        <input type="text" name="tbl_name" id="tbl_name" class="form-control input-expand" placeholder="Nama tabel"
                               required="required"/>
                        <button id="btn_csv" name="submit" type="submit" class="btn btn-primary btn-lg">
                            Convert to Seed
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <div class="row" style="margin-bottom: 30px">
        <div class="col-md-12">
            <form class="form-stacked" name="f" id="output-form">
                <fieldset>
                    <div class="clearfix">
                        <div class="input">
                            <textarea wrap="soft" class="col-md-12" rows="15" name="output"
                                      id="holdtext"><?php echo $hasilAkhir; ?></textarea>
                        </div>
                    </div>
                    <div class="actions pull-right">
                        <button class="btn btn-lg btn-danger" type="button" onClick="Clear();">
                            Clear
                        </button>
                        <button class="btn btn-lg btn-primary" type="button" onClick="ClipBoard();">
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
    var ht = $('#holdtext');

    $(document).ready(function () {
        $('#nav_seed').addClass('active');

        var tx = ht.val();
        if (tx != null && tx != 'Array' && tx != '') {
            // select textarea
            ht.select();
        }
    });

    function ClipBoard() {
        ht.select();
    }

    function Clear() {
        ht.val('');
        ht.focus();
    }
</script>
</body>
</html>