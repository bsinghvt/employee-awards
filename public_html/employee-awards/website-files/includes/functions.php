<?php
function strip_zeros_from_date($markedString = "") {
    $noZeros = str_replace('*0', '', $markedString);
    $cleanString = str_replace('*', '', $noZeros);
    return $cleanString;
}
function redirect_to($location = NULL) {
    if ($location != NULL) {
        header("Location: {$location}");
        exit;
    }
}

function output_message ($message = "") {
    if (!empty($message)) {
        return '<p class="message">'.$message.'</p>';
    } else {
        return "";
    }
}

function get_template($template = "", $arr = array()) {
	extract($arr);
    include(SITE_ROOT.DS.'public'.DS.'layouts'.DS.$template);
}
function log_actions($action, $message="") {
    if (!file_exists(SITE_ROOT.DS."logs")) {
        mkdir(SITE_ROOT.DS."logs");
        $fileName = SITE_ROOT.DS."logs".DS."logs.txt";
        $filePtr = fopen($fileName, 'w');
        $timeStamp = strftime("%Y-%m-%d %H:%M:%S", time());
        $content = $timeStamp."|".$action.":".$message."\n";
        if (fwrite($filePtr, $content)) {
            fclose($filePtr);
        }
    }
    
    else {
        $fileName = SITE_ROOT.DS."logs".DS."logs.txt";
        $filePtr = fopen($fileName, 'a');
        $timeStamp = strftime("%Y-%m-%d %H:%M:%S", time());
        $content = $timeStamp."|".$action.":".$message."\n";
        if (fwrite($filePtr, $content)) {
            fclose($filePtr);
        }
    }
}
?>
