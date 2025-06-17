<?php

class About extends dbClass
{
    public function __construct()
    {
        parent::__construct();
    }

    public function get()
    {
        $q = $this->q("SELECT * FROM about WHERE id = 1 LIMIT 1");
        return $this->object($q);
    }
}

$about = new About();
