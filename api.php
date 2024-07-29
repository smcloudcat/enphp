<?php
//BY：云猫
//QQ3522934828
include("func_v2.php");

if (isset($_FILES["file"]) && $_FILES["file"]["error"] === 0) {
    $uploadDir = "enphp/";
    $fileName = basename($_FILES["file"]["name"]);
    $fileTmp = $_FILES["file"]["tmp_name"];
    $imageFileType = strtolower(pathinfo($fileName, PATHINFO_EXTENSION));
    if ($imageFileType != "php") {
        echo json_encode(['error' => '只能上传PHP文件']);
        exit;
    }
    $tempDir = "temp_" . time() . "/";
    if (!mkdir($tempDir) && !is_dir($tempDir)) {
        echo json_encode(['error' => '无法创建临时目录']);
        exit;
    }
    $targetFile = $tempDir . $fileName;
    if (!move_uploaded_file($fileTmp, $targetFile)) {
        echo json_encode(['error' => '文件上传失败']);
        exit;
    }
    $content = file_get_contents($targetFile);
    $content = str_replace(['<?php', '?>'], '', $content);

    $options = [
        'comment'=>$_POST['xiaophp']
    ];
    file_put_contents($targetFile, enphp("<?php" . $content . "?>", $options));
    $newZipName = "encrypted_" . time() . ".zip";
    $zip = new ZipArchive;
    if ($zip->open($uploadDir . $newZipName, ZipArchive::CREATE) === TRUE) {
        $zip->addFile($targetFile, basename($targetFile));
        $zip->close();
        unlink($targetFile);
        function deleteDirectory($dir) {
            if (!file_exists($dir)) {
                return true;
            }
            if (!is_dir($dir)) {
                return unlink($dir);
            }
            foreach (scandir($dir) as $item) {
                if ($item == '.' || $item == '..') {
                    continue;
                }
                if (!deleteDirectory($dir . DIRECTORY_SEPARATOR . $item)) {
                    return false;
                }
            }
            return rmdir($dir);
        }

        deleteDirectory($tempDir);

        echo json_encode([
            'filename' => $newZipName,
            'result' => "加密成功",
            'url' => $uploadDir . $newZipName
        ]);
    } else {
        echo json_encode(['error' => '打包失败，请检查权限']);
    }
} else {
    echo json_encode(['error' => '请上传文件']);
}
?>