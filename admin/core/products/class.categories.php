<?php

class Categories extends dbClass {

    public function __construct() {
        parent::__construct();
    }

    // Tüm kategorileri getir
    public function all() {
        $data = [];
        $q = $this->q("SELECT * FROM categories ORDER BY id DESC");
        while ($r = $this->object($q)) {
            $data[] = $r;
        }
        return $data;
    }

    // Belirli bir kategoriyi getir
    public function get($id) {
        $id = intval($id);
        $q = $this->q("SELECT * FROM categories WHERE id = {$id} LIMIT 1");
        return $this->object($q);
    }
}

$categories = new Categories();

?>