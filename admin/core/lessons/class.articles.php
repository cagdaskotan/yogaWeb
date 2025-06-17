<?php

class LessonsArticles extends dbClass {

    var $subject;
    var $article;

    public function __construct()
    {
        parent::__construct();

        if(isset($_GET['subject']))
        {
            $this -> subject = $this -> rescape($_GET['subject']);
        }

        if(isset($_GET['art']))
        {
            $this -> article = $this -> rescape($_GET['art']);
        }
    }

    public function subject($subjectHash)
    {
        $q = $this -> q(
            "SELECT *
            FROM lessons_subjects
            WHERE MD5(CONCAT('zsistem', id)) = '{$subjectHash}'"
        );

        if($this -> numrows($q) > 0)
        {
            $r = $this -> object($q);
            return $r;
        } else {
            return null;
        }
    }

    public function getArticle()
    {
        $q = $this -> q(
            "SELECT *
            FROM lessons_articles
            WHERE MD5(CONCAT('zsistem', id)) = '{$this -> article}'"
        );

        if($this -> numrows($q) > 0)
        {
            $r = $this -> object($q);
            return $r;
        } else {
            return null;
        }
    }

    public function getArticles($subject_id, $order = 'ASC')
    {
        $subject_id = intval($subject_id);
        $data = [];

        $q = $this->q(
            "SELECT a.*, s.title as subject_title, l.title as lesson_title
            FROM lessons_articles as a
            LEFT JOIN lessons_subjects as s ON s.id = a.subject_id
            LEFT JOIN lessons as l ON l.id = s.lesson_id
            WHERE a.subject_id = {$subject_id}
            ORDER BY a.id {$order}"
        );
        
        while ($r = $this->object($q)) {
            $x = new stdClass();
            $x->id = $r->id;
            $x->article = $r->article;
            $x->subject_id = $r->subject_id;
            $x->subject_title = $r->subject_title;
            $x->lesson_title = $r->lesson_title;

            $data[] = $x;
        }
        return $data;
    }

    public function getSubjectBySlug($slug)
    {
        $slug = $this->rescape($slug);
        $q = $this->q("SELECT * FROM lessons_subjects WHERE slug = '{$slug}' AND is_delete = 0 LIMIT 1");

        return $this->object($q);
    }
}

$art = new LessonsArticles();

?>