<!doctype html>
<html>
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
        <META HTTP-EQUIV="refresh" CONTENT="10">
        <title>PLASMA</title>
    </head>
    <body>
        <?php
        include_once 'config.php';
        include_once 'include/CMS.php';
        include_once 'include/Agent.php';
        include_once 'include/Skill.php';

        $employee = new CMS($db['host'], $db['user'], $db['password'], $db['database']);
        $employee->getConfig();

        $skills_array = $employee->getSkills('skills.txt');
        $agents_array = $employee->getAgents('agents.txt');
        
        ?>
        <div id="container">
            <div class="row-fluid">
                <div class="span12">
                    <div id="skills">
                        <table id="skills_detail">
                            <thead>
                                <tr>
                                    <th>Split/Skill</th>
                                    <th>Avg Speed Ans</th>
                                    <th>Avg Aban Time</th>
                                    <th>Aban Calls</th>
                                    <th>Avg ACD Time</th>
                                    <th>ACD Calls</th>
                                    <th>Oldest Call Waiting</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                arsort($skills_array);

                                foreach ($skills_array as $key => $skill) {
                                    if ($skill->avg_aban_time != '0' || $skill->aban_calls != '0' || $skill->avg_acd_time != '0' || $skill->acd_calls != '0' || $skill->avg_speed_ans != '0' || $skill->oldest_call_waiting != '0:00') {
                                        echo '<tr>';
                                        echo '
                             <td>' . str_replace('_', ' ', $key) . '</td>
                             <td class="asa center">' . $skill->avg_speed_ans . '</td>
                             <td class="center">' . $skill->avg_aban_time . '</td>
                             <td class="center">' . $skill->aban_calls . '</td>
                             <td class="center">' . $skill->avg_acd_time . '</td>
                             <td class="center">' . $skill->acd_calls . '</td>
                             <td class="center">' . $skill->oldest_call_waiting . '</td>
                             ';
                                        echo '</tr>';
                                    }
                                }
                                ?>
                            </tbody>

                        </table>
                    </div>
                </div>
            </div>

            <p></p>
            <div class="row-fluid">
                <div id="agents" class="span9">
                    <table id="agents_detail">
                        <thead>
                            <tr>
                                <th>Agent Name</th>
                                <th>Login ID</th>
                                <th>Extn</th>
                                <th>AUX Reason</th>
                                <th>State</th>
                                <th>Direction</th>
                                <th>Active Split/Skill</th>
                                <th>Time</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            usort($agents_array, array("Agent", "cmp"));

                            $lunch = 0;
                            $break = 0;
                            $project = 0;

                            foreach ($agents_array as $agent) {
                                if ($agent->aux_reason == 'Lunch') {
                                    ++$lunch;
                                }
                                if ($agent->aux_reason == 'Break') {
                                    ++$break;
                                }
                                if ($agent->aux_reason == 'Project') {
                                    ++$project;
                                }
                                echo '<tr>';
                                echo '
                                    <td>';
                                if ($agent->aux_reason == 'Project' || $agent->aux_reason == 'Lunch' || $agent->aux_reason == 'Break')
                                    echo '<img src="images/ag5.gif"> ';
                                else if ($agent->state == 'ACW')
                                    echo '<img src="images/ag4.gif"> ';
                                else if ($agent->state == 'AVAIL')
                                    echo '<img src="images/ag2.gif"> ';
                                else if ($agent->direction == 'IN')
                                    echo '<img src="images/ag3.gif"> ';
                                else if ($agent->direction == 'OUT')
                                    echo '<img src="images/ag5.gif"> ';
                                echo $agent->lastname . ', ' . $agent->firstname . '</td>
                                    <td class="center">' . $agent->login_id . '</td>
                                    <td class="center">' . $agent->extn . '</td>
                                    <td class="aux_reason center">' . $agent->aux_reason . '</td>
                                    <td class="state center">' . $agent->state . '</td>
                                    <td class="center">' . $agent->direction . '</td>
                                    <td>' . $agent->active_split . '</td>
                                    <td class="time center">' . $agent->time . '</td>
                                    ';
                                echo '</tr>';
                            }
                            ?>
                        </tbody>
                    </table>
                </div>
                <div class="span3">
                    <div id="lunch">
                        <div class="aux_header"><h4 class="center">Lunch</h4></div>
                        <h2 class="center"><?php echo $lunch; ?></h2>
                    </div>
                    <br />
                    <div id="break">
                        <div class="aux_header"><h4 class="center">Break</h4></div>
                        <h2 class="center"><?php echo $break; ?></h2>
                    </div>
                    <br />
                    <div id="project">
                        <div class="aux_header"><h4 class="center">Project</h4></div>
                        <h2 class="center"><?php echo $project; ?></h2>
                    </div>
                </div>
            </div>
        </div>
        <script src="bootstrap/js/bootstrap.min.js"></script>
        <link rel="stylesheet" href="bootstrap/css/bootstrap.min.css" />
        <script src="jquery/jquery-1.9.0.min.js"></script>
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