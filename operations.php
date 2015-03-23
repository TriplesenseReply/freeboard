<?php
require_once 'lib/php/Freeboard.php';

if (empty($_POST) || (!isset($_POST['board_data']) && !isset($_POST['board_name']))) {
    header ('Location: /');
}

$boardName = $_POST['board_name'];
$boardData = $_POST['board_data'];

if (!empty($boardName)) {
    $boardFilename = urlencode(str_replace(' ', '_', strtolower($boardName))) . '.json';
} else {
    $boardFilename = $_POST['board_file'];
    $freeboard->setBoard($boardFilename);
    $boardName = $freeboard->getBoard()->getName();
}

$boardJson = sprintf('{ "name": "%s", "data": %s }', $boardName, $boardData);
$freeboard->setBoard($boardJson);

if ($freeboard->getBoard()->save($boardFilename)) {
    echo sprintf('{ "response": "success", "board_file": "%s" }', $boardFilename);
} else {
    echo sprintf('{ "response": "error", "error_msg": "Could not save \'%s\'." }', $boardFilename);
}