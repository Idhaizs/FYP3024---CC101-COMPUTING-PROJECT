<?php
@include 'connection.php';

$data = json_decode(file_get_contents("php://input"));

$orderId = $data->orderId;
$newStatus = $data->newStatus;

$update_query = "UPDATE `order` SET status = '$newStatus' WHERE id = '$orderId'";
if ($conn->query($update_query) === TRUE) {
    echo json_encode(array('success' => true));
} else {
    echo json_encode(array('success' => false, 'error' => $conn->error));
}

$conn->close();
?>
