<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

$servername = "127.0.0.1";
$username = "AdrianaP";
$password = "C@nel@23";
$dbname = "bank";

// Crear la conexión
$conn = new mysqli($servername, $username, $password, $dbname);

// Verificar la conexión
if ($conn->connect_error) {
    die("Conexión fallida: " . $conn->connect_error);
}

// Obtener el saldo actual de la cuenta
$account_id = 1; // El ID de la cuenta que deseas modificar
$sql = "SELECT balance FROM accounts WHERE id = $account_id";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    $row = $result->fetch_assoc();
    $current_balance = $row['balance'];
} else {
    die("Cuenta no encontrada.");
}

// Cantidad a retirar
$withdraw_amount = 100.00; // Ajusta este valor según tus necesidades

// Verificar si el retiro es posible
if ($current_balance >= $withdraw_amount) {
    $new_balance = $current_balance - $withdraw_amount;

    // Actualizar el saldo de la cuenta
    $sql = "UPDATE accounts SET balance = $new_balance WHERE id = $account_id";
    if ($conn->query($sql) === TRUE) {
        echo "Retiro exitoso. Nuevo saldo: $new_balance";

        // Registrar la transacción en logs
        $timestamp = date('Y-m-d H:i:s');
        $sql = "INSERT INTO logs (amount, balance_after, timestamp) VALUES ($withdraw_amount, $new_balance, '$timestamp')";
        if ($conn->query($sql) === TRUE) {
            echo "Transacción registrada en logs.";
        } else {
            echo "Error al registrar la transacción: " . $conn->error;
        }
    } else {
        echo "Error al actualizar el saldo: " . $conn->error;
    }
} else {
    echo "Fondos insuficientes.";
}

$conn->close();
?>
