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
//require('inc/convert.php');
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
                <form id="frm_csv" name="frm_csv" class="form-inline"
                      method="post"
                      enctype="multipart/form-data">
                    <div class="form-group">
                        <input type="file" name="csv" id="csv" class="form-control" required="required"/>
                        <input type="text" name="tbl_name" id="tbl_name" class="form-control input-expand"
                               placeholder="Nama tabel"
                               required="required"/>
                        <button id="btn_csv" name="btn_csv" type="button" class="btn btn-primary btn-lg">
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

        $('#btn_csv').on('click', function () {
            var a = new FormData;
            a.append("file", document.getElementById("csv").files[0]);
            a.append("tbl_name", $("#tbl_name").val());
            var i = new XMLHttpRequest;

            i.open("POST", "inc/convert-test.php");
            i.onreadystatechange = function () {

                alert(i.responseText);
//                if (4 == i.readyState) {
//                    var a = i.responseText,
//                        e = a.indexOf("Warning");
//                    -1 != e ? (CloseSpinner(), $("#notif").html("<div class='alert'><button data-dismiss='alert' class='close' type='button'>×</button>" + a + "</div>"), $("#notif").show(), scrollToElement(".header", 500), setTimeout(function () {
//                        $("#notif").fadeOut()
//                    }, 6e3)) : (CloseSpinner(), TampilData(), TombolBatal(), $("#notif").html("<div class='alert alert-success'><button data-dismiss='alert' class='close' type='button'>×</button><strong>Sukses : </strong> Data berhasil disimpan.</div>"), $("#notif").show(), scrollToElement(".header", 500))
//                }
            };
            i.send(a)
        });
    });


    function SimpanData() {
        OpenSpinner();
        var a = new FormData;
        a.append("file", document.getElementById("fileupload").files[0]),
            a.append("ext", $("#ext").val()),
            a.append("ref_id",
                $("#ref_id").val()),
            a.append("ref_sumber", $("#ref_sumber").val()), a.append("nama", $("#nama").val()), a.append("ukuran", $("#ukuran").val()), a.append("jenis", $("#jenis").val()), a.append("info", $("#info").val()), a.append("file_lama", $("#file_lama").val()), a.append("catatan", $("#catatan").val()), a.append("_id", $("#_id").val());
        var e = $("#cmd").val(),
            i = new XMLHttpRequest;
        i.open("POST", "/efiling-upload.aspx?cmd=" + e), i.onreadystatechange = function () {
            if (4 == i.readyState) {
                var a = i.responseText,
                    e = a.indexOf("Warning");
                -1 != e ? (CloseSpinner(), $("#notif").html("<div class='alert'><button data-dismiss='alert' class='close' type='button'>×</button>" + a + "</div>"), $("#notif").show(), scrollToElement(".header", 500), setTimeout(function () {
                    $("#notif").fadeOut()
                }, 6e3)) : (CloseSpinner(), TampilData(), TombolBatal(), $("#notif").html("<div class='alert alert-success'><button data-dismiss='alert' class='close' type='button'>×</button><strong>Sukses : </strong> Data berhasil disimpan.</div>"), $("#notif").show(), scrollToElement(".header", 500))
            }
        }, i.send(a)
    }

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