<?php

class Lessons extends dbClass {
    public function __construct()
    {
        parent::__construct();
    }

    public function all()
    {
        $data = [];
        $q = $this -> q(
            "SELECT *
            FROM lessons
            WHERE is_delete = 0 ORDER BY id ASC"
        );
        
        while($r = $this -> object($q))
        {
            $x = new stdClass();
            $x->id = $r->id;
            $x->title = $r->title;
            $x->is_active = $r->is_active;

            $data[] = $x;
        }
        return $data;
    }

    public function all_x()
    {
        $data = [];
        $q = $this -> q(
            "SELECT *
            FROM lessons ORDER BY id ASC"
        );

        while($r = $this -> object($q))
        {
            $x = new stdClass();
            $x->id = $r->id;
            $x->title = $r->title;
            $x->is_active = $r->is_active;

            $data[] = $x;
        }
        return $data;
    }

    public function get($id)
    {
        $id = intval($id);
        $q = $this->q("SELECT * FROM lessons WHERE id = {$id} AND is_delete = 0 LIMIT 1");
        return $this->object($q);
    }

    public function subjects($lesson_id)
    {
        $data = [];
        $q = $this -> q(
            "SELECT *
            FROM lessons_subjects
            WHERE lesson_id = {$lesson_id} AND is_delete = 0 ORDER BY id ASC"
        );

        while($r = $this -> object($q))
        {
            $x = new stdClass();
            $x->id = $r->id;
            $x->title = $r->title;
            $x->is_active = $r->is_active;
            $x->slug = $r->slug;

            $data[] = $x;
        }
        return $data;
    }

    public function getSubject($subject_id)
    {
        $q = $this->q(
            "SELECT * FROM lessons_subjects WHERE id = {$subject_id} AND is_delete = 0 LIMIT 1"
        );

        if ($this->numrows($q) > 0) {
            return $this->object($q);
        } else {
            return null;
        }
    }

}

$ls = new Lessons();

?>
