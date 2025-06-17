<?php

class AboutGallery extends dbClass
{
    public function __construct()
    {
        parent::__construct();
    }

    // --- Tüm görselleri getir ---
    public function all()
    {
        $q = $this->q("SELECT * FROM about_gallery ORDER BY id DESC");

        $data = [];
        while ($r = $this->object($q)) {
            $data[] = $r;
        }
        return $data;
    }

    // --- Tek bir görsel getir ---
    public function get($id)
    {
        $id = intval($id);
        $q = $this->q("SELECT * FROM about_gallery WHERE id = {$id} LIMIT 1");
        return $this->object($q);
    }
}

$ag = new AboutGallery();
