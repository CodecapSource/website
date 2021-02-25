<?php

    header("Access-Control-Allow-Origin: *");
    header("Access-Control-Allow-Headers: access");
    header("Access-Control-Allow-Methods: POST");
    header("Content-Type: application/json; charset=UTF-8");
    header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");

    set_time_limit(1);

    $unique_name = time();
    $code_folder = "code/".$unique_name."/";
    
    if (!isset($_POST['code']) || empty(trim($_POST['code']))) {
        die(json_encode(['status' => false, 'error' => 'E08.0']));
    }
    $code = $_POST['code'];

    $mkdir = mkdir($code_folder);
    $file = fopen($code_folder.'script.py', "a") or die(json_encode(['status' => false, 'error' => 'E08.1']));
    fwrite($file, $code) or die(json_encode(['status' => false, 'error' => 'E08.2']));
    fclose($file);

    // creating Dockerfile
    $file = fopen($code_folder.'Dockerfile', "a") or die(json_encode(['status' => false, 'error' => 'E08.3']));
    $dockerFile = "FROM python:3.8-slim\nADD script.py /\nCMD [ \"python\", \"./script.py\" ]";
    fwrite($file, $dockerFile) or die(json_encode(['status' => false, 'error' => 'E08.4']));

    $command = "sudo docker build -t $unique_name --rm ".$code_folder;
    exec($command, $o, $s);
    if ($s) {
        die(json_encode(['status' => false, 'error' => 'E08.5']));
    }
    
    $command = "sudo docker run -i --name c_$unique_name --rm $unique_name 2>&1";
    $ol = exec($command, $output, $status);
    
    // removing image
    $command = "sudo docker rmi $unique_name";
    exec($command, $o, $s);
    // removing folder and files
    unlink($code_folder.'script.py');
    unlink($code_folder.'Dockerfile');
    rmdir($code_folder);

    if ($status) {
        die(json_encode(['status' => true, 'type' => 'error', 'data' => $ol]));
    }

    die(json_encode(['status' => true, 'data' => $output]));
