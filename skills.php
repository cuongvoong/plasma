<?php

include_once 'config.php';
include_once 'include/CMS.php';
include_once 'include/Skill.php';

$employee = new CMS($db['host'], $db['user'], $db['password'], $db['database']);

$skills_array = $employee->getSkills('skills.txt');

arsort($skills_array);

$html = '
<div class="span12">
    <table id="skills_detail">
        <thead>
            <tr>
                <th>Split/Skill</th>
                <th>Avg Speed Ans</th>
                <th>Calls Waiting</th>
                <th>Avg Aban Time</th>
                <th>Aban Calls</th>
                <th>Avg ACD Time</th>
                <th>ACD Calls</th>
                <th>Oldest Call Waiting</th>
            </tr>
        </thead>
    <tbody>
    ';

foreach ($skills_array as $key => $skill)
{
    if ($skill->avg_aban_time != '0' || $skill->aban_calls != '0' || $skill->avg_acd_time != '0' || $skill->acd_calls != '0' || $skill->avg_speed_ans != '0' || $skill->oldest_call_waiting != '0:00')
    {
        $html .= '<tr>';
        $html .= '
            <td>' . str_replace('_', ' ', $key) . '</td>
            <td class="asa center">' . $skill->avg_speed_ans . '</td>
            <td class="center">' . $skill->inqueue . '</td>
            <td class="center">' . $skill->avg_aban_time . '</td>
            <td class="center">' . $skill->aban_calls . '</td>
            <td class="center">' . $skill->avg_acd_time . '</td>
            <td class="center">' . $skill->acd_calls . '</td>
            <td class="center">' . $skill->oldest_call_waiting . '</td>
            ';
        $html .= '</tr>';
    }
}

$html .= '
    </tbody>
</table>
</div>
';

echo $html;