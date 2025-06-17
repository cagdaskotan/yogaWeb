<?php

class EventArticles extends dbClass {

    var $event;
    var $article;

    public function __construct()
    {
        parent::__construct();

        if (isset($_GET['event_id'])) {
            $hash = $this->rescape($_GET['event_id']);
            $q = $this->q("SELECT id FROM events WHERE MD5(CONCAT('zsistem', id)) = '{$hash}' LIMIT 1");
            if ($this->numrows($q)) {
                $row = $this->object($q);
                $this->event = $row->id;
            }
        }

        if(isset($_GET['art']))
        {
            $this->article = $this->rescape($_GET['art']);
        }
    }

    public function getArticle()
    {
        $q = $this->q(
            "SELECT *
            FROM events_articles
            WHERE MD5(CONCAT('zsistem', id)) = '{$this->article}'"
        );

        if($this->numrows($q) > 0)
        {
            $r = $this->object($q);
            return $r;
        } else {
            return null;
        }
    }

    public function getArticles($order = 'ASC')
    {
        if (!$this->event) return []; // event_id tanımlı değilse boş array dön

        $data = [];
        $q = $this->q(
            "SELECT a.*, e.title as event_title
            FROM events_articles as a
            LEFT JOIN events as e ON e.id = a.event_id
            WHERE a.event_id = {$this->event}
            ORDER BY a.id {$order}"
        );

        while ($r = $this->object($q)) {
            $data[] = $r;
        }

        return $data;
    }

    public function getEvent()
    {
        $q = $this->q("SELECT * FROM events WHERE id = {$this->event} LIMIT 1");
        return $this->numrows($q) > 0 ? $this->object($q) : null;
    }

    public function getArticlesByEventId($event_id, $limit = 1)
    {
        $event_id = intval($event_id);
        $data = [];

        $q = $this->q("
            SELECT *
            FROM events_articles
            WHERE event_id = {$event_id}
            ORDER BY id DESC
            LIMIT {$limit}
        ");

        while ($r = $this->object($q)) {
            $data[] = $r;
        }

        return $data;
    }

}

$art = new EventArticles();
