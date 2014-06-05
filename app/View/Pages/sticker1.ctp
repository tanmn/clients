<?php
$phone = $_POST["phone"];
$result = array();

    $result["path"] = $this->QrCode->base_url . urlencode($phone) . $this->QrCode->_optionsString(array());
    $result["status"] = true;
    die( json_encode($result));
?>