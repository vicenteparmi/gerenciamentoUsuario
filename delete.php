<?php

// Start session if not already started
if(!isset($_SESSION))
{
    session_start();
}

// Get the id from the URL
$id = $_GET['id'];

// Connect to the database
$pdo = new PDO('mysql:host=localhost;dbname=agenda', 'root', '');

// Delete contact phones
$stmt = $pdo->prepare('DELETE FROM telefone WHERE ContatoID = :id');
$stmt->bindValue(':id', $id);
$stmt->execute();

// Delete email addresses
$stmt = $pdo->prepare('DELETE FROM email WHERE ContatoID = :id');
$stmt->bindValue(':id', $id);
$stmt->execute();

// Delete contact from database
$sql = "DELETE FROM contato WHERE ContatoID = :id";
$stmt = $pdo->prepare($sql);
$stmt->bindParam(':id', $id);
$stmt->execute();

// Redirect to the index page
header('Location: index.php');