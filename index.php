<!doctype html>
<html>
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
        <title>PLASMA</title>
    </head>
    <body>
        <?php
        include_once 'config.php';
        include_once 'include/CMS.php';
        
        $employee = new CMS($db['host'], $db['user'], $db['password'], $db['database']);
        $employee->getConfig();

        ?>
        <div id="container">
            <div class="row-fluid">
                <div id="skills"></div>
            </div>

            <p></p>
            <div class="row-fluid">
                <div id="agents"></div>
            </div>
        </div>
        
        <script src="jquery/jquery-1.9.0.min.js"></script>
        <script src="bootstrap/js/bootstrap.min.js"></script>
        <link rel="stylesheet" href="bootstrap/css/bootstrap.min.css" />
        <script src="jquery/jquery-ui-1.10.0.custom.min.js"></script>
        <link rel="stylesheet" href="jquery/css/smoothness/jquery-ui-1.10.0.custom.min.css" />
        <link rel="stylesheet" href="css/stylesheet.css" />
        <script>
            var asa_threshold_yellow = "<?php echo $employee->asa_threshold_yellow; ?>";
            var asa_threshold_red = "<?php echo $employee->asa_threshold_red; ?>";
            var lunch_threshold = "<?php echo $employee->lunch_threshold; ?>";
            var break_threshold = "<?php echo $employee->break_threshold; ?>";
            var available_threshold = "<?php echo $employee->available_threshold; ?>";
            var acw_threshold = "<?php echo $employee->acw_threshold; ?>";
        </script>
        <script src="js/jquery.js"></script>
    </body>
</html>