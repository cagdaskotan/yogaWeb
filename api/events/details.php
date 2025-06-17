<?php
header("Content-Type: application/json");
require_once("../../env/class.db.php");

$event_id = intval($_GET['event_id'] ?? 0);

if ($event_id <= 0) {
    echo json_encode(['status' => 400, 'message' => 'Geçersiz ID']);
    exit;
}

$q = $db->q("SELECT article FROM events_articles WHERE event_id = {$event_id} ORDER BY id DESC LIMIT 1");

if ($db->numrows($q)) {
    $r = $db->object($q);
    echo json_encode(['status' => 200, 'article' => $r->article]);
} else {
    echo json_encode(['status' => 404, 'message' => 'İçerik bulunamadı']);
}
