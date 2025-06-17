<?php

class AboutEducations extends dbClass
{
    public function __construct()
    {
        parent::__construct();
    }

    // --- Tüm eğitimleri getir ---
    public function all()
    {
        $q = $this->q("SELECT * FROM about_educations ORDER BY id ASC");

        $data = [];
        while ($r = $this->object($q)) {
            $data[] = $r;
        }
        return $data;
    }

    // --- Belirli bir eğitimi getir ---
    public function get($id)
    {
        $id = intval($id);
        $q = $this->q("SELECT * FROM about_educations WHERE id = {$id} LIMIT 1");
        return $this->object($q);
    }
}

$ae = new AboutEducations();

?>