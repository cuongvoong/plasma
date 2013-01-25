<?php

class Skill {
    private $avg_speed_ans;
    private $avg_aban_time;
    private $aban_calls;
    private $avg_acd_time;
    private $acd_calls;
    private $oldest_call_waiting;
    private $inqueue;
    
    public function __set($property, $value) 
    {
        if(property_exists($this, $property))
        {
            $this->$property = $value;
        }
    }
    public function __get($property) 
    {
        if(property_exists($this, $property))
            return $this->$property;
    }

}
