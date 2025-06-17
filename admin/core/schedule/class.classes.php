<?php

class Classes extends dbClass {

    private $table = "classes";

    public function __construct() {
        parent::__construct();
    }

    // Tüm sınıfları getir
    public function all() {
        $data = [];
        $q = $this->q("SELECT * FROM {$this->table} ORDER BY id ASC");
        while ($r = $this->object($q)) {
            $data[] = $r;
        }
        return $data;
    }

    // Belirli bir sınıfı getir
    public function get($id) {
        $id = intval($id);
        $q = $this->q("SELECT * FROM {$this->table} WHERE id = {$id} LIMIT 1");
        return $this->object($q);
    }
}

$classes = new Classes();

?>
