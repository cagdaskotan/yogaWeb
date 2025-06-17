<?php
header("Content-Type: application/json");
require_once("../../env/class.db.php");

$q = $db->q("SELECT id, title, start_date, end_date FROM events WHERE is_active = 1 ORDER BY id DESC");

$data = [];
while ($r = $db->object($q)) {
    $data[] = [
        'id' => $r->id,
        'title' => $r->title,
        'start_date' => $r->start_date,
        'end_date' => $r->end_date
    ];
}

echo json_encode(['status' => 200, 'data' => $data]);