<?php
//BY：云猫
include("func_v2.php");
    // 文件保存地址，自己修改
$uploadDir = "uploads/";

// Check if a file has been uploaded
if (isset($_FILES["file"]) && $_FILES["file"]["error"] === 0) {
    // 获取上传信息
    $targetFile = $uploadDir . basename($_FILES["file"]["name"]);
    $fileName = $_FILES["file"]["name"];
    $fileTmp = $_FILES["file"]["tmp_name"];
    $imageFileType = strtolower(pathinfo($targetFile,PATHINFO_EXTENSION));

// 检查文件类型
if($imageFileType != "zip") {
    echo json_encode(['error' => 'zip']);
    $uploadOk = 0;
}

    move_uploaded_file($fileTmp, $uploadDir . $fileName);

    // 处理压缩包
    $zip = new ZipArchive;
    $zip->open($uploadDir . $fileName);
    $zip->extractTo($uploadDir);
    $zip->close();

    $files = glob($uploadDir . "*.php");
    foreach ($files as $file) {
        $content = file_get_contents($file);
        $content = preg_replace('/<\?php/', '', $content);
        $content = preg_replace('/\?>/','',$content);
        file_put_contents($file, $content);
    }

    // 加密
    foreach ($files as $file) {
        $content = file_get_contents($file);
        $encryptedContent = base64_encode($content);
        file_put_contents($file, enphp("<?php eval(base64_decode('$encryptedContent')); ?>",$options));
    }
    // 压缩。。。
    $timestamp = time();
    $newZipName = $timestamp . ".zip";
    $zip = new ZipArchive;
    if ($zip->open($uploadDir . $newZipName, ZipArchive::CREATE) === TRUE) {
        foreach ($files as $file) {
            $zip->addFile($file, basename($file));
        }
        $zip->close();
        
         echo json_encode([
            'filename' =>  $fileName,
            'result' => "加密成功",
            'url' => $uploadDir.$newZipName
        ]);
        unlink($uploadDir . $fileName);
    } else {
        echo json_encode(['error' => '打包失败，请检查权限']);
    }

    foreach ($files as $file) {
        unlink($file);
    }
} else {
    // If no file is uploaded, display message
    echo json_encode(['error' => '请上传文件']);
}
?>