<?php
header('Content-Type: application/json');
require_once '../includes/Seguridad.php';
require_once '../includes/Cliente.php';

$seguridad = new Seguridad();
$seguridad->access_page();

$cliente = new Cliente();
$idcliente = $seguridad->get_id_cliente();

if (file_get_contents('php://input') != null) {
    $entityBody = file_get_contents('php://input');
    $data = json_decode($entityBody, true);
    $fileId = $data['id'];
    
    // Get file info before deletion
    $fileInfo = $cliente->get_archivo_privado($fileId);
    
    if ($fileInfo[0] && !empty($fileInfo[1])) {
        $filePath = '../../' . $fileInfo[1][0]['ruta'];
        
        // Delete file from database
        $result = $cliente->delete_archivo_privado($fileId);
        
        if ($result[0]) {
            // Delete physical file if exists
            if (file_exists($filePath)) {
                unlink($filePath);
            }
            echo json_encode(['success' => true]);
        } else {
            http_response_code(500);
            echo json_encode(['error' => 'Error al eliminar el archivo de la base de datos']);
        }
    } else {
        http_response_code(404);
        echo json_encode(['error' => 'Archivo no encontrado']);
    }
} else {
    http_response_code(400);
    echo json_encode(['error' => 'Solicitud inválida']);
}