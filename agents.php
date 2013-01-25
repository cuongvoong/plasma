<?php
include_once 'config.php';
include_once 'include/CMS.php';
include_once 'include/Agent.php';

$employee = new CMS($db['host'], $db['user'], $db['password'], $db['database']);

$agents_array = $employee->getAgents('agents.txt');

usort($agents_array, array("Agent", "cmp"));

$lunch = 0;
$break = 0;
$project = 0;

$html = '
    <div class="span9">
        <table id = "agents_detail">
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
';

foreach ($agents_array as $agent)
{

    if ($agent->aux_reason == 'Lunch')
    {
        ++$lunch;
    }
    if ($agent->aux_reason == 'Break')
    {
        ++$break;
    }
    if ($agent->aux_reason == 'Project')
    {
        ++$project;
    }

$html .= '<tr><td>';
if ($agent->aux_reason == 'Project' || $agent->aux_reason == 'Lunch' || $agent->aux_reason == 'Break')
    $html .= '<img src="images/ag5.gif"> ';
    else if ($agent->state == 'ACW')
    $html .= '<img src="images/ag4.gif"> ';
    else if ($agent->state == 'AVAIL')
    $html .= '<img src="images/ag2.gif"> ';
    else if ($agent->direction == 'IN')
    $html .= '<img src="images/ag3.gif"> ';
    else if ($agent->direction == 'OUT')
    $html .= '<img src="images/ag5.gif"> ';
    $html .= $agent->lastname . ', ' . $agent->firstname . '</td>
        <td class="center">' . $agent->login_id . '</td>
        <td class="center">' . $agent->extn . '</td>
        <td class="aux_reason center">' . $agent->aux_reason . '</td>
        <td class="state center">' . $agent->state . '</td>
        <td class="center">' . $agent->direction . '</td>
        <td>' . $agent->active_split . '</td>
        <td class="time center">' . $agent->time . '</td>
        ';
    $html .= '</tr>';
}

$html .= '
        </tbody>
    </table>
</div>';

$html .= '
<div class = "span3">
    <div id = "lunch">
        <div class="aux_header">
            <h4 class="center">Lunch</h4>
        </div>
        <h2 class="center">' . $lunch . '</h2>
    </div>
    <br />
    <div id="break">
        <div class="aux_header">
            <h4 class="center">Break</h4>
        </div>
        <h2 class="center">' . $break . '</h2>
    </div>
    <br />
    <div id="project">
        <div class="aux_header">
            <h4 class="center">Project</h4>
        </div>
        <h2 class="center">' . $project . '</h2>
    </div>
</div>';

echo $html;