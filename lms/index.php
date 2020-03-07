<?php
include('config.php');
$token = md5(APP_SECRET);
$apiUrl = API_URL;
?>
<html lang="en">
    <head>
        <title>Cost Forecast</title>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <link rel="icon" href="https://lifetrackmed.com/wp-content/uploads/2018/07/LMSlogo-fav16.png" type="image/png" sizes="16x16"/>
        <link rel="icon" href="https://lifetrackmed.com/wp-content/uploads/2018/07/LMSlogo-fav32.png" type="image/png" sizes="32x32"/>
        <link rel="stylesheet" href="/lms/css/bootstrap.min.css">
        <link rel="stylesheet" href="/lms/css/dataTables.bootstrap.min.css">
        <script src="/lms/js/jquery.min.js"></script>
        <script src="/lms/js/bootstrap.min.js"></script>
        <script src="/lms/js/dataTables.min.js"></script>  
        <script src="/lms/js/dataTables.bootstrap.min.js"></script>
    </head>
    <body>
        <div class="col-md-10 offset-md-1">
            <div class="card card-outline-secondary">
                <div class="card-header">
                    <h3 class="mb-0"><?= APP_NAME ?></h3>
                </div>
                <div class="card-body">
                    <div class="alert alert-danger alert-dismissible fade show" role="alert" style="display:none;">
                        Error Occurred, please check below.
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="form-group row">
                        <label class="col-lg-3 col-form-label form-control-label">Number of Study</label>
                        <div class="col-lg-9">
                            <input class="form-control" type="number" value="" id="nos" name="nos" placeholder="Please input number of study per day.">
                            <div id="nos_error"></div>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-lg-3 col-form-label form-control-label">Number of Study Growth</label>
                        <div class="col-lg-9">
                            <input class="form-control" id="growth" name="growth" type="number" value="" placeholder="Please input number of study growth percentage.">
                            <div id="growth_error"></div>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-lg-3 col-form-label form-control-label">No of Month</label>
                        <div class="col-lg-9">
                            <input class="form-control" type="number" id="month" name="month" value="" placeholder="Please input number of month to forecast.">
                            <div id="month_error"></div>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-lg-3 col-form-label form-control-label"><input type="button" class="btn btn-primary" id="forecast" value="Forecast"></label>
                        <div class="col-lg-9"></div>
                    </div>
                </div>
            </div>
        </div>
        <br />
        <div class="col-md-10 offset-md-1" id="result" style="display:none;">
            <div class="card card-outline-secondary">
                <div class="card-header">
                    <h3 class="mb-0">Result</h3>
                </div>
                <div class="card-body">
                    <table id="result_table" class="display" style="width:100%">
                        <thead>
                            <tr>
                                <th>Month Year</th>
                                <th>Number Studies</th>
                                <th>Cost Forecasted</th>
                            </tr>
                        </thead>
                        <tfoot>
                            <tr>
                                <th>Month Year</th>
                                <th>Number Studies</th>
                                <th>Cost Forecasted</th>
                            </tr>
                        </tfoot>
                    </table>
                </div>
            </div>
        </div>
    </body>
    <script type="application/javascript">
        $(document).ready(function() {
            //$('#result_table').DataTable();
        });
        $("#forecast").click(function() {
            var table = $('#result_table').DataTable();
            table.destroy();
            $.ajax({
                type: "POST",
                url: "<?= $apiUrl ?>",
                data: {
                    token : "<?= $token ?>",
                    nos : $('#nos').val(),
                    growth : $('#growth').val(),
                    month : $('#month').val(),
                },
                success: function(result) {
                    var result = JSON.parse(result);
                    if(result.status == 0) {
                        $('.alert').show();
                        if (typeof result.error.nos !== 'undefined') {
                            $("#nos_error").html("<span style='color:red;'>"+result.error.nos+"</span>");
                        } else {
                            $("#nos_error").hide();
                        }
                        if (typeof result.error.growth !== 'undefined') {
                            $("#growth_error").html("<span style='color:red;'>"+result.error.growth+"</span>");
                        } else {
                            $("#growth_error").hide();
                        }
                        if (typeof result.error.month !== 'undefined') {
                            $("#month_error").html("<span style='color:red;'>"+result.error.month+"</span>");
                        } else {
                            $("#month_error").hide();
                        }
                    } else {
                        $('.alert').hide();
                        console.log(result.data);
                        $('#result_table').DataTable( {
                            data: result.data,
                            "columns": [
                                { "data": "date" },
                                { "data": "nos" },
                                { "data": "cost" }
                            ]
                        });
                        $("#result").show();
                    }
                }
            });
        });
    </script>
</html>


