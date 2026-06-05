<?php
header('Content-Type: application/json');
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: GET, POST, OPTIONS');
header('Access-Control-Allow-Headers: Content-Type, Authorization');

if ($_SERVER['REQUEST_METHOD'] === 'OPTIONS') {
    http_response_code(200);
    exit;
}

require_once __DIR__ . '/db.php';

function getBaseUrl() {
    $scheme = (!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off') ? 'https' : 'http';
    $host = $_SERVER['HTTP_HOST'];
    $path = rtrim(dirname($_SERVER['SCRIPT_NAME']), '/\\');
    return $scheme . '://' . $host . $path;
}

function handleList($pdo) {
    $stmt = $pdo->query('SELECT id, title, description, thumbnail, file_url AS file, DATE_FORMAT(date_added, "%d-%m-%Y") AS date FROM podcasts ORDER BY date_added DESC, id DESC');
    $rows = $stmt->fetchAll();
    echo json_encode($rows);
}

function sanitizePathSegment($name) {
    return preg_replace('/[^A-Za-z0-9._-]/', '_', $name);
}

function saveUpload($fieldName, $subFolder, $baseUrl) {
    if (!isset($_FILES[$fieldName]) || $_FILES[$fieldName]['error'] !== UPLOAD_ERR_OK) {
        return null;
    }

    $file = $_FILES[$fieldName];
    $extension = pathinfo($file['name'], PATHINFO_EXTENSION);
    $filename = time() . '_' . uniqid() . '.' . $extension;
    $targetDir = __DIR__ . '/uploads/' . $subFolder;
    if (!is_dir($targetDir)) {
        mkdir($targetDir, 0755, true);
    }
    $targetPath = $targetDir . '/' . $filename;

    if (!move_uploaded_file($file['tmp_name'], $targetPath)) {
        return null;
    }

    return $baseUrl . '/uploads/' . $subFolder . '/' . $filename;
}

$action = $_REQUEST['action'] ?? 'list';
$baseUrl = getBaseUrl();

try {
    switch ($action) {
        case 'list':
            handleList($pdo);
            break;

        case 'add':
            $title = trim($_POST['title'] ?? '');
            $description = trim($_POST['description'] ?? '');
            $thumbnail = trim($_POST['thumbnail'] ?? '');
            $fileUrl = trim($_POST['file'] ?? '');

            $uploadedThumbnail = saveUpload('thumbnailFile', 'thumbnails', $baseUrl);
            if ($uploadedThumbnail) {
                $thumbnail = $uploadedThumbnail;
            }

            $uploadedAudio = saveUpload('audioFile', 'audio', $baseUrl);
            if ($uploadedAudio) {
                $fileUrl = $uploadedAudio;
            }

            if (!$title || !$description || !$thumbnail || !$fileUrl) {
                http_response_code(400);
                echo json_encode(['error' => 'All fields are required (title, description, thumbnail, file).']);
                break;
            }

            $stmt = $pdo->prepare('INSERT INTO podcasts (title, description, thumbnail, file_url, date_added) VALUES (?, ?, ?, ?, CURDATE())');
            $stmt->execute([$title, $description, $thumbnail, $fileUrl]);
            $newId = $pdo->lastInsertId();
            $stmt = $pdo->prepare('SELECT id, title, description, thumbnail, file_url AS file, DATE_FORMAT(date_added, "%d-%m-%Y") AS date FROM podcasts WHERE id = ?');
            $stmt->execute([$newId]);
            echo json_encode($stmt->fetch());
            break;

        case 'update':
            $id = intval($_POST['id'] ?? 0);
            $title = trim($_POST['title'] ?? '');
            $description = trim($_POST['description'] ?? '');
            $thumbnail = trim($_POST['thumbnail'] ?? '');
            $fileUrl = trim($_POST['file'] ?? '');

            if ($id <= 0) {
                http_response_code(400);
                echo json_encode(['error' => 'Invalid id']);
                break;
            }

            $stmt = $pdo->prepare('SELECT thumbnail, file_url FROM podcasts WHERE id = ?');
            $stmt->execute([$id]);
            $existing = $stmt->fetch();
            if (!$existing) {
                http_response_code(404);
                echo json_encode(['error' => 'Podcast not found']);
                break;
            }

            $uploadedThumbnail = saveUpload('thumbnailFile', 'thumbnails', $baseUrl);
            if ($uploadedThumbnail) {
                $thumbnail = $uploadedThumbnail;
            } else {
                $thumbnail = $thumbnail ?: $existing['thumbnail'];
            }

            $uploadedAudio = saveUpload('audioFile', 'audio', $baseUrl);
            if ($uploadedAudio) {
                $fileUrl = $uploadedAudio;
            } else {
                $fileUrl = $fileUrl ?: $existing['file_url'];
            }

            if (!$title || !$description || !$thumbnail || !$fileUrl) {
                http_response_code(400);
                echo json_encode(['error' => 'All fields are required (title, description, thumbnail, file).']);
                break;
            }

            $stmt = $pdo->prepare('UPDATE podcasts SET title = ?, description = ?, thumbnail = ?, file_url = ? WHERE id = ?');
            $stmt->execute([$title, $description, $thumbnail, $fileUrl, $id]);
            $stmt = $pdo->prepare('SELECT id, title, description, thumbnail, file_url AS file, DATE_FORMAT(date_added, "%d-%m-%Y") AS date FROM podcasts WHERE id = ?');
            $stmt->execute([$id]);
            echo json_encode($stmt->fetch());
            break;

        case 'delete':
            $id = intval($_POST['id'] ?? 0);
            if ($id <= 0) {
                http_response_code(400);
                echo json_encode(['error' => 'Invalid id']);
                break;
            }
            $stmt = $pdo->prepare('DELETE FROM podcasts WHERE id = ?');
            $stmt->execute([$id]);
            echo json_encode(['success' => true]);
            break;

        default:
            http_response_code(400);
            echo json_encode(['error' => 'Unknown action']);
            break;
    }
} catch (Exception $e) {
    http_response_code(500);
    echo json_encode(['error' => $e->getMessage()]);
}
