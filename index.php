<?php require('convert.php') ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">
    <link rel="icon" href="img/favicon.png">
    <title>Personal Convert - Tool Generate in KodeSoft</title>
    <link href="css/bootstrap.min.css" rel="stylesheet">
    <link href="css/style.css" rel="stylesheet">
    <!--[if lt IE 9]>
    <script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
    <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->
</head>
<body>
<!-- navbar -->
<nav class="navbar navbar-default navbar-static-top">
    <div class="container">
        <div class="navbar-header">
            <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar"
                    aria-expanded="false" aria-controls="navbar">
                <span class="sr-only">Toggle navigation</span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
            </button>
            <a class="navbar-brand" href="#">Personal Convert</a>
        </div>
        <div id="navbar" class="navbar-collapse collapse">
            <ul class="nav navbar-nav">
                <li class="active"><a href="/">Seed</a></li>
                <li><a href="fpdf.php">Fpdf</a></li>
            </ul>
        </div>
    </div>
</nav>
<div class="container">
    <div class="row">
        <div class="col-md-12">
            <div class="well">
                <h2>INFO</h2>

                <p>Convert file CSV(excel) menjadi sesuai format Seed Laravel.</p>
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
                        <input type="text" name="tbl_name" id="tbl_name" class="form-control" placeholder="Nama tabel"
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