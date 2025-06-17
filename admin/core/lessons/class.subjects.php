<?php

class LessonsSubjects extends dbClass {

    private $t = 'lessons_subjects';

    public function __construct()
    {
        parent::__construct();
    }
    
    public function lessonName($lesson_id)
    {
        $q = $this -> q(
            "SELECT title
            FROM lessons
            WHERE id = '{$lesson_id}'"
        );

        $r = $this -> object($q);
        return $r -> title;
    }

    public function all()
    {
        $data = [];
        $q = $this -> q(
            "SELECT s.*, l.title as lesname
            FROM {$this -> t} as s
            LEFT JOIN lessons as l ON l.id = s.lesson_id
            WHERE s.is_delete = 0 ORDER BY id DESC"
        );

        while($r = $this -> object($q))
        {
            $x = new stdClass();
            $x->id = $r->id;
            $x->lesson = $r->lesname;
            $x->lesson_id = $r->lesson_id;
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
            $x->lesson_id = $r->lesson_id;
            $x->title = $r->title;
            $x->is_active = $r->is_active;

            $data[] = $x;
        }
        return $data;
    }
}

$sj = new LessonsSubjects();

?>