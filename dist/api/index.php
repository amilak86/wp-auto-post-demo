<?php
sleep(15);

$data = ['status' => '1'];
header('Content-Type: application/json; charset=utf-8');
echo json_encode($data);
