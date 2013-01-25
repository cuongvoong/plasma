<?php

class CMS
{

    private $mysqli = NULL;
    private $asa_threshold_yellow;
    private $asa_threshold_red;
    private $lunch_threshold;
    private $break_threshold;
    private $available_threshold;
    private $acw_threshold;

    function __construct($host, $user, $password, $database)
    {
        if ($this->mysqli == NULL)
        {
            $this->mysqli = new mysqli($host, $user, $password, $database);
            if ($this->mysqli->connect_errno)
            {
                echo "Failed to connect to MySQL: (" . $this->mysqli->connect_errno . ") " . $this->mysqli->connect_error;
            }
        }
    }

    public function __set($property, $value)
    {
        if (property_exists($this, $property))
        {
            $this->$property = $value;
        }
    }

    public function __get($property)
    {
        if (property_exists($this, $property))
            return $this->$property;
    }

    function getAgents($filename)
    {

        if (!$handle = @fopen($filename, 'r'))
        {
            echo 'Could not load ' . $filename;
            die;
        }

        if (!flock($handle, LOCK_EX))
        {
            echo 'Could not lock ' . $filename;
            die;
        }
        
        if(!$this->is_current($filename))
        {
            echo 'The PLASMA has not updated for over 3 minutes!';
            die;
        }
        else
        {
            //Remove the first two unused line
            $fread_line = fgets($handle);
            //$fread_line = fgets($handle);
            $fread_line = fgets($handle);

            $agents_detail = array();
            $agents_array = array();

            while (!feof($handle))
            {
                $fread_line = fgets($handle);
                $agents_detail[] = preg_split('/\t/', $fread_line);

                if (isset($agents_detail[0][0]) && $agents_detail[0][0] != '')
                {
                    $name = explode(', ', $agents_detail[0][3]);
                    $firstname = strtolower(trim($name[1]));
                    $lastname = strtolower(trim($name[0]));

                    if (!isset(${$lastname . '_' . $firstname}))
                    {
                        ${$lastname . '_' . $firstname} = new Agent();
                        ${$lastname . '_' . $firstname}->firstname = ucfirst($firstname);
                        ${$lastname . '_' . $firstname}->lastname = ucfirst($lastname);
                        $agents_array[$lastname . '_' . $firstname] = ${$lastname . '_' . $firstname};
                    }
                    if ($lastname != '' && $firstname != '')
                    {
                        ${$lastname . '_' . $firstname}->set_skills($agents_detail[0][0]);
                        if (!isset(${$lastname . '_' . $firstname}->state))
                            ${$lastname . '_' . $firstname}->state = $agents_detail[0][6];
                        if (!isset(${$lastname . '_' . $firstname}->login_id))
                            ${$lastname . '_' . $firstname}->login_id = $agents_detail[0][2];
                        if (!isset(${$lastname . '_' . $firstname}->extn))
                            ${$lastname . '_' . $firstname}->extn = $agents_detail[0][4];
                        if (!isset(${$lastname . '_' . $firstname}->aux_reason))
                            ${$lastname . '_' . $firstname}->aux_reason = $agents_detail[0][5];
                        if (!isset(${$lastname . '_' . $firstname}->direction))
                            ${$lastname . '_' . $firstname}->direction = $agents_detail[0][7];
                        if (!isset(${$lastname . '_' . $firstname}->active_split))
                            ${$lastname . '_' . $firstname}->active_split = $agents_detail[0][8];
                        if (!isset(${$lastname . '_' . $firstname}->time))
                        {
                            if ($agents_detail[0][10][0] == ':')
                            {
                                ${$lastname . '_' . $firstname}->time = date('H:i:s', strtotime('00' . $agents_detail[0][10]));
                            }
                            else
                            {
                                ${$lastname . '_' . $firstname}->time = date('H:i:s', strtotime($agents_detail[0][10]));
                            }
                        }
                    }
                }
                unset($agents_detail);
            }

            fclose($handle);

            return $agents_array;
        }
        return FALSE;
    }

    function getSkills($filename)
    {

        if (!$handle = @fopen($filename, 'r'))
        {
            echo 'Could not load ' . $filename;
            die;
        }

        if (!flock($handle, LOCK_EX))
        {
            echo 'Could not lock ' . $filename;
            die;
        }
        
        if(!$this->is_current($filename))
        {
            echo 'The PLASMA has not updated for over 3 minutes!';
            die;
        }
        else
        {
            //Remove the first two unused line
            $fread_line = fgets($handle);
            $fread_line = fgets($handle);

            $skills_detail = array();
            $skills_array = array();

            while (!feof($handle))
            {
                $fread_line = fgets($handle);
                $skills_detail[] = preg_split('/\t/', $fread_line);

                if ($skills_detail[0][0] != '')
                {
                    $skill_name = str_replace(' ', '_', $skills_detail[0][0]);
                    if (!isset(${$skill_name}))
                    {
                        ${$skill_name} = new Skill();
                        $skills_array[$skill_name] = ${$skill_name};
                    }
                    if (!isset(${$skill_name}->avg_aban_time))
                    {
                        ${$skill_name}->avg_aban_time = $skills_detail[0][1];
                        if ($skills_detail[0][1][0] == ':')
                            ${$skill_name}->avg_aban_time = '0' . $skills_detail[0][1];
                    }
                    if (!isset(${$skill_name}->aban_calls))
                        ${$skill_name}->aban_calls = $skills_detail[0][2];
                    if (!isset(${$skill_name}->avg_acd_time))
                    {
                        ${$skill_name}->avg_acd_time = $skills_detail[0][3];
                        if ($skills_detail[0][3][0] == ':')
                            ${$skill_name}->avg_acd_time = '0' . $skills_detail[0][3];
                    }
                    if (!isset(${$skill_name}->acd_calls))
                        ${$skill_name}->acd_calls = $skills_detail[0][4];
                    if (!isset(${$skill_name}->avg_speed_ans))
                    {
                        ${$skill_name}->avg_speed_ans = $skills_detail[0][5];
                        if ($skills_detail[0][5][0] == ':')
                            ${$skill_name}->avg_speed_ans = '0' . $skills_detail[0][5];
//                    if (strlen(${$skill_name}->avg_speed_ans) == 4)
//                        ${$skill_name}->avg_speed_ans = '0:0' . ${$skill_name}->avg_speed_ans;
                    }
                    if (!isset(${$skill_name}->inqueue))
                        ${$skill_name}->inqueue = $skills_detail[0][6];
                    if (!isset(${$skill_name}->oldest_call_waiting))
                    {
                        ${$skill_name}->oldest_call_waiting = trim($skills_detail[0][7]);
                        if ($skills_detail[0][7][0] == ':')
                            ${$skill_name}->oldest_call_waiting = '0' . trim($skills_detail[0][7]);
                    }
                }
                unset($skills_detail);
            }

            fclose($handle);

            return $skills_array;
        }
    }

    public function getConfig()
    {
        $query = 'SELECT * FROM config';

        if ($result = $this->mysqli->query($query))
        {
            while ($row = $result->fetch_assoc())
            {
                $this->asa_threshold_yellow = $row['asa_threshold_yellow'];
                $this->asa_threshold_red = $row['asa_threshold_red'];
                $this->lunch_threshold = $row['lunch_threshold'];
                $this->break_threshold = $row['break_threshold'];
                $this->available_threshold = $row['available_threshold'];
                $this->acw_threshold = $row['acw_threshold'];
            }
        }
    }
    
    public function is_current($filename)
    {
        //if(time() - filemtime($filename) < 180)
            return true;
        //else
        //    return false;
    }

}