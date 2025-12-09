<?php
ob_start();

try {
    require_once 'config.php';
    $stmt = $pdo->prepare('SELECT * FROM historial ORDER BY id DESC');
    $stmt->execute();
    $results = $stmt->fetchAll();

    // Limpiar cualquier output buffer
    ob_clean();

    $horario = array_column($results, 'momento');
    
    if ($results && count($results) > 0) {
        
        echo json_encode([
            'success' => true,
            'horarios' => $horario
        ], JSON_UNESCAPED_UNICODE);
    } else {
        echo json_encode([
            'success' => false,
            'message' => 'No hay horario programado',
            'horarios' => null
        ], JSON_UNESCAPED_UNICODE);
    }



} catch (Exception $e) {
    // Limpiar output buffer en caso de error
    ob_clean();

    http_response_code(500);
    echo json_encode([
        'success' => false,
        'message' => 'Error del servidor',
        'error' => $e->getMessage()
    ], JSON_UNESCAPED_UNICODE);
}

?>