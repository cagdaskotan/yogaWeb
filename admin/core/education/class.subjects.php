<?php

class EducationSubjects extends dbClass {

    private $t = 'education_subjects';

    public function __construct()
    {
        parent::__construct();
    }
    
    public function educationName($education_id)
    {
        $q = $this -> q(
            "SELECT title
            FROM education
            WHERE id = '{$education_id}'"
        );

        $r = $this -> object($q);
        return $r -> title;
    }

    public function all()
    {
        $data = [];
        $q = $this -> q(
            "SELECT s.*, l.title as eduname
            FROM {$this -> t} as s
            LEFT JOIN education as l ON l.id = s.education_id
            WHERE s.is_delete = 0 ORDER BY id DESC"
        );

        while($r = $this -> object($q))
        {
            $x = new stdClass();
            $x->id = $r->id;
            $x->education = $r->eduname;
            $x->education_id = $r->education_id;
            $x->title = $r->title;
            $x->is_active = $r->is_active;
            $x->slug = $r->slug;

            $data[] = $x;
        }
        return $data;
    }

    public function all_x()
    {
        $data = [];
        $q = $this -> q(
            "SELECT *
            FROM {$this -> t} ORDER BY id ASC"
        );

        while($r = $this -> object($q))
        {
            $x = new stdClass();
            $x->id = $r->id;
            $x->education_id = $r->education_id;
            $x->title = $r->title;
            $x->is_active = $r->is_active;

            $data[] = $x;
        }
        return $data;
    }
}

$sj = new EducationSubjects();

?>