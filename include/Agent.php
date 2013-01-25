<?php

class Agent
{

    private $skills;
    private $firstname;
    private $lastname;
    private $login_id;
    private $extn;
    private $aux_reason;
    private $state;
    private $direction;
    private $active_split;
    private $time;

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

    public function set_skills($array)
    {
        $this->skills[] = $array;
    }

    public function cmp($a, $b)
    {
        if ($a->state == 'AVAIL' && $b->state == 'AVAIL')
            return strcmp($b->time, $a->time);
        else if ($a->state == 'AVAIL' && $b->state != 'AVAIL')
            return -1;
        else if ($b->state == 'AVAIL' && $a->state != 'AVAIL')
            return 1;
        else if ($a->state == 'ACD' && $b->state == 'ACD')
            return strcmp($b->time, $a->time);
        else if ($a->state == 'ACD' && $b->state != 'ACD')
            return -1;
        else if ($b->state == 'ACD' && $a->state != 'ACD')
            return 1;
        else if ($a->state == 'ACW' && $b->state == 'ACW')
            return strcmp($b->time, $a->time);
        else if ($a->state == 'ACW' && $b->state != 'ACW')
            return -1;
        else if ($b->state == 'ACW' && $a->state != 'ACW')
            return 1;
        else if ($a->state == 'AUX' && $b->state == 'AUX')
            return strcmp($b->time, $a->time);
        else if ($a->state == 'AUX' && $b->state != 'AUX')
            return -1;
        else if ($b->state == 'AUX' && $a->state != 'AUX')
            return 1;
    }

}
