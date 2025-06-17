<?php

class Events extends dbClass {

    public function __construct() {
        parent::__construct();
    }

    public function all() {
        $q = $this->q("SELECT * FROM events ORDER BY id DESC");

        $data = [];
        while ($r = $this->object($q)) {
            $data[] = $r;
        }
        return $data;
    }

    public function get($id) {
        $id = intval($id);
        $q = $this->q("SELECT * FROM events WHERE id = {$id} LIMIT 1");
        return $this->object($q);
    }

    public function getBySlug($slug) {
        $slug = $this->rescape($slug);
        $q = $this->q("SELECT * FROM events WHERE slug = '{$slug}' AND is_active = 1 LIMIT 1");
        return $this->object($q);
    }

}

$events = new Events();

?>