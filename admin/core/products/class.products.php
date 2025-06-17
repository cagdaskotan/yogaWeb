<?php

class Products extends dbClass {

    public function __construct() {
        parent::__construct();
    }

    // Tüm ürünler
    public function all($onlyActive = true) {
        $data = [];
        $where = $onlyActive ? "WHERE p.is_active = 1" : "";

        $q = $this->q(
            "SELECT p.*, c.name AS category_name
            FROM products p
            LEFT JOIN categories c ON p.category_id = c.id
            $where
            ORDER BY p.id DESC"
        );
        while ($r = $this->object($q)) {
            $data[] = $r;
        }
        return $data;
    }

    // Belirli bir ürün
    public function get($id) {
        $id = intval($id);
        $q = $this->q(
            "SELECT p.*, c.name AS category_name
            FROM products p
            LEFT JOIN categories c ON p.category_id = c.id
            WHERE p.id = {$id}
            LIMIT 1"
        );
        return $this->object($q);
    }


    // Son eklenen 10 ürün
    public function latest($count = 10) {
        $data = [];
        $q = $this->q(
            "SELECT p.*, c.name AS category_name
            FROM products p
            LEFT JOIN categories c ON p.category_id = c.id
            WHERE p.is_active = 1
            ORDER BY p.id DESC
            LIMIT {$count}"
        );
        while ($r = $this->object($q)) {
            $data[] = $r;
        }
        return $data;
    }

    public function getBySlug($slug) {
        $slug = $this->rescape($slug);
        $q = $this->q(
            "SELECT p.*, c.name AS category_name
            FROM products p
            LEFT JOIN categories c ON p.category_id = c.id
            WHERE p.slug = '{$slug}'
            LIMIT 1"
        );
        return $this->object($q);
    }
}

$products = new Products();

?>
