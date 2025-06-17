<?php

class Schedule extends dbClass {

    private $table = "schedule";

    public function __construct() {
        parent::__construct();
    }

    public function all($onlyActive = true) {
        $data = [];
        $where = $onlyActive ? "WHERE s.is_active = 1" : "";

        $q = $this->q(
            "SELECT s.*, c.class as class_name, i.name as instructor_name, i.surname as instructor_surname
            FROM {$this->table} s
            LEFT JOIN classes c ON c.id = s.class_id
            LEFT JOIN instructors i ON i.id = s.instructor_id
            $where
            ORDER BY s.schedule_day, s.start_time"
        );
        while ($r = $this->object($q)) {
            $data[] = $r;
        }
        return $data;
    }

    public function get($id) {
        $q = $this->q("SELECT * FROM {$this->table} WHERE id = " . intval($id));
        return $this->object($q);
    }
}

?> 
