<?php

class Instructors extends dbClass {

    private $table = "instructors";

    public function __construct() {
        parent::__construct();
    }

    // Tüm eğitmenleri getir
    public function all() {
        $data = [];
        $q = $this->q("SELECT * FROM {$this->table} ORDER BY id ASC");
        while ($r = $this->object($q)) {
            $data[] = $r;
        }
        return $data;
    }

    // Belirli bir eğitmeni getir
    public function get($id) {
        $id = intval($id);
        $q = $this->q("SELECT * FROM {$this->table} WHERE id = {$id} LIMIT 1");
        return $this->object($q);
    }
}

$instructors = new Instructors();

?>
