<?php
header('Content-Type: application/json');
require '../connection.php'; // Ensure this file contains the database connection logic

session_start();
// user_id in session عفوري 
// $user_id = $_SESSION['user_id'];
// test purpose pls fix aseel

$user_id = 3;

$firstname = $_POST['firstname'];
$lastname = $_POST['lastname'];
$address = $_POST['address'];
$building = $_POST['building'];
$city = $_POST['city'];
$phone = $_POST['phone'];

$sql = "SELECT * FROM Billing_information WHERE user_id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $user_id);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows > 0) {
    // Update existing billing information
    $sql = "UPDATE Billing_information SET firstname = ?, lastname = ?, address = ?, building = ?, city = ?, phone = ? WHERE user_id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ssssssi", $firstname, $lastname, $address, $building, $city, $phone, $user_id);
} else {
    // Insert new billing information
    $sql = "INSERT INTO Billing_information (user_id, firstname, lastname, address, building, city, phone) VALUES (?, ?, ?, ?, ?, ?, ?)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("isssssi", $user_id, $firstname, $lastname, $address, $building, $city, $phone);
}

$stmt->execute();

if ($stmt->affected_rows > 0) {
    echo json_encode(['success' => 'Billing information updated successfully']);
} else {
    echo json_encode(['error' => 'Failed to update billing information']);
}

$stmt->close();
$conn->close();