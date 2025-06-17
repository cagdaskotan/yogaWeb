<?php
header('Content-Type: application/json');

require_once("../../env/class.db.php");
require_once("../../admin/core/products/class.products.php");
require_once("../utils/auth.php");

$auth = new Auth();
$payload = $auth->verifyToken();

if (!$payload) {
    http_response_code(401);
    echo json_encode(["error" => "Yetkisiz erişim"]);
    exit;
}

$products = new Products();
$all = $products->all();

$filtered = array_map(function ($item) {
    return [
        'id' => $item->id,
        'title' => $item->name,
        'price' => $item->price,
        'image' => "http://10.20.11.48/yoga/" . $item->image,
        'description' => $item->description,
    ];
}, array_filter($all, fn($p) => $p->is_active == 1));

echo json_encode($filtered);
