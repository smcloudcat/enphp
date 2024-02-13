<?php
//BY：云猫
//QQ3522934828
include("func_v2.php");

// Check if a file has been uploaded
if (isset($_FILES["file"]) && $_FILES["file"]["error"] === 0) {
    $uploadDir = "enphp/";
    // 获取上传信息
    $fileName = $_FILES["file"]["name"];
    $fileTmp = $_FILES["file"]["tmp_name"];
    $imageFileType = strtolower(pathinfo($fileName, PATHINFO_EXTENSION));

    // 检查文件类型
    if ($imageFileType != "zip") {
        echo json_encode(['error' => 'zip']);
        exit; // exit if the file is not a zip
    }

    // 创建临时文件夹
    $tempDir = "temp_" . time() . "/";
    mkdir($tempDir);

    // 移动上传的zip文件到临时文件夹
    $targetFile = $tempDir . $fileName;
    move_uploaded_file($fileTmp, $targetFile);

    // 解压缩文件
    $zip = new ZipArchive;
    if ($zip->open($targetFile) === TRUE) {
        $zip->extractTo($tempDir);
        $zip->close();
    } else {
        echo json_encode(['error' => '解压失败']);
        exit; // exit if unable to extract zip
    }

    // 获取解压后的文件列表
    $files = glob($tempDir . "*.php");

    // 加密
    foreach ($files as $file) {
        $content = file_get_contents($file);
        $encryptedContent = base64_encode($content);
        file_put_contents($file, enphp("<?php eval(base64_decode('$encryptedContent')); ?>", $options));
    }

    // 压缩
    $newZipName = "encrypted_" . time() . ".zip";
    $zip = new ZipArchive;
    if ($zip->open($uploadDir . $newZipName, ZipArchive::CREATE) === TRUE) {
        foreach ($files as $file) {
            $zip->addFile($file, basename($file));
        }
        $zip->close();

        // 删除临时文件夹及其内容
        foreach ($files as $file) {
            unlink($file);
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
    // If no file is uploaded, display message
    echo json_encode(['error' => '请上传文件']);
}
?>