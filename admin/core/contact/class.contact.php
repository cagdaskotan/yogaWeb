<?php

class Contact extends dbClass {

    public function __construct() {
        parent::__construct();
    }

    // Tüm verileri çek
    public function all() {
        $q = $this->q("SELECT * FROM contact LIMIT 1");

        $data = [];
        while ($r = $this->object($q)) {
            $data[] = $r;
        }
        return $data;
    }

    // Belirli bir ID'ye ait veriyi çek
    public function get($id) {
        $id = intval($id);
        $q = $this->q("SELECT * FROM contact WHERE id = {$id} LIMIT 1");
        return $this->object($q);
    }
}

$contact = new Contact();

?>
