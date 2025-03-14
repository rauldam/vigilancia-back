<?php
header('Content-Type: application/json');
require_once '../includes/Seguridad.php';
require_once '../includes/Cliente.php';

$seguridad = new Seguridad();
$seguridad->access_page();

$cliente = new Cliente();
$idcliente = $seguridad->get_id_cliente();
$cif = $_SESSION['cif'];
$red = "1";

if (!empty($_FILES)) {
    $file = $_FILES['file'];
    $fileName = basename($file['name']);
    $fileType = strtolower(pathinfo($fileName, PATHINFO_EXTENSION));
    
    // Validate file type
    $allowedTypes = array('pdf', 'docx', 'xlsx');
    if (!in_array($fileType, $allowedTypes)) {
        http_response_code(400);
        echo json_encode(['error' => 'Tipo de archivo no permitido']);
        exit;
    }
    
    // Create upload directory if it doesn't exist
    $uploadDir = '../../uploads/' . $cif . '/';
    if (!file_exists($uploadDir)) {
        mkdir($uploadDir, 0755, true);
    }
    
    // Generate unique filename
    $uniqueFileName = uniqid() . '_' . $fileName;
    $uploadPath = $uploadDir . $uniqueFileName;
    
    if (move_uploaded_file($file['tmp_name'], $uploadPath)) {
        // Save file info to database
        $param = array(
            'idcliente' => $idcliente,
            'red' => $red,
            'nombre' => $fileName,
            'ruta' => 'uploads/' . $cif . '/' . $uniqueFileName,
            'tipo' => $fileType
        );
        
        $result = $cliente->save_archivo_privado($param);
        
        if ($result[0]) {
            echo json_encode(['success' => true]);
        } else {
            unlink($uploadPath);
            http_response_code(500);
            echo json_encode(['error' => 'Error al guardar en la base de datos']);
        }
    } else {
        http_response_code(500);
        echo json_encode(['error' => 'Error al subir el archivo']);
    }
} else {
    http_response_code(400);
    echo json_encode(['error' => 'No se recibió ningún archivo']);
}