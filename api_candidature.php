<?php
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: POST");
header("Access-Control-Max-Age: 3600");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");

// Activation du débogage
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

// Logging de la requête
file_put_contents('api_log.txt', date('Y-m-d H:i:s') . " - Requête reçue\n", FILE_APPEND);
file_put_contents('api_log.txt', print_r($_POST, true) . "\n", FILE_APPEND);
file_put_contents('api_log.txt', file_get_contents("php://input") . "\n\n", FILE_APPEND);

// Configuration de la base de données
define('DB_HOST', '4w0vau.myd.infomaniak.com');
define('DB_NAME', '4w0vau_gsprint');
define('DB_USER', '4w0vau_gsprint');
define('DB_PASS', 'Pidou2016');

// Clé API générée
define('API_KEY', '7f58dcfb3a4a9b9be8e0ae0914e8738a9b4c9860f28b199b3f0c7d3f7b5e23d1');

// Vérification de la clé API
$headers = getallheaders();
$api_key_received = str_replace('Bearer ', '', $headers['Authorization'] ?? '');

if ($api_key_received !== API_KEY) {
    file_put_contents('api_log.txt', date('Y-m-d H:i:s') . " - Accès non autorisé\n", FILE_APPEND);
    http_response_code(401);
    echo json_encode(array("message" => "Accès non autorisé."));
    exit();
}

// Connexion à la base de données
try {
    $db = new PDO("mysql:host=" . DB_HOST . ";dbname=" . DB_NAME, DB_USER, DB_PASS);
    $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    file_put_contents('api_log.txt', date('Y-m-d H:i:s') . " - Connexion à la base de données réussie\n", FILE_APPEND);
} catch(PDOException $e) {
    file_put_contents('api_log.txt', date('Y-m-d H:i:s') . " - Erreur de connexion à la base de données: " . $e->getMessage() . "\n", FILE_APPEND);
    http_response_code(500);
    echo json_encode(array("message" => "Erreur de connexion à la base de données: " . $e->getMessage()));
    exit();
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $data = json_decode(file_get_contents("php://input"));
    
    file_put_contents('api_log.txt', date('Y-m-d H:i:s') . " - Données reçues: " . print_r($data, true) . "\n", FILE_APPEND);
    
    if (
        !empty($data->nom) &&
        !empty($data->email) &&
        !empty($data->telephone) &&
        !empty($data->type_emploi) &&
        !empty($data->motivation)
    ) {
        $query = "INSERT INTO candidatures 
                  SET nom = :nom, 
                      email = :email, 
                      telephone = :telephone, 
                      type_emploi = :type_emploi, 
                      motivation = :motivation,
                      cv_nom = :cv_nom";

        try {
            $stmt = $db->prepare($query);

            $stmt->bindParam(":nom", $data->nom);
            $stmt->bindParam(":email", $data->email);
            $stmt->bindParam(":telephone", $data->telephone);
            $stmt->bindParam(":type_emploi", $data->type_emploi);
            $stmt->bindParam(":motivation", $data->motivation);
            $stmt->bindParam(":cv_nom", $data->cv_nom);

            if ($stmt->execute()) {
                file_put_contents('api_log.txt', date('Y-m-d H:i:s') . " - Insertion réussie\n", FILE_APPEND);
                http_response_code(201);
                echo json_encode(array("message" => "La candidature a été enregistrée avec succès."));
            } else {
                file_put_contents('api_log.txt', date('Y-m-d H:i:s') . " - Échec de l'insertion\n", FILE_APPEND);
                http_response_code(503);
                echo json_encode(array("message" => "Impossible d'enregistrer la candidature."));
            }
        } catch(PDOException $e) {
            file_put_contents('api_log.txt', date('Y-m-d H:i:s') . " - Erreur lors de l'insertion : " . $e->getMessage() . "\n", FILE_APPEND);
            http_response_code(503);
            echo json_encode(array("message" => "Erreur lors de l'enregistrement de la candidature: " . $e->getMessage()));
        }
    } else {
        file_put_contents('api_log.txt', date('Y-m-d H:i:s') . " - Données incomplètes\n", FILE_APPEND);
        http_response_code(400);
        echo json_encode(array("message" => "Impossible d'enregistrer la candidature. Données incomplètes."));
    }
} else {
    file_put_contents('api_log.txt', date('Y-m-d H:i:s') . " - Méthode non autorisée\n", FILE_APPEND);
    http_response_code(405);
    echo json_encode(array("message" => "Méthode non autorisée."));
}
?>