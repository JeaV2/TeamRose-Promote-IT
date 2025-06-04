<?php
function clog($data) {
    $output = $data;
    if (is_array($output))
        $output = implode(',', $output);
    echo "<script>console.log('Php log: " . $output . "' );</script>";
}

function cinfo($data) {
    $output = $data;
    if (is_array($output))
        $output = implode(',', $output);
    echo "<script>console.info('Php info: " . $output . "' );</script>";
}

function cwarn($data) {
    $output = $data;
    if (is_array($output))
        $output = implode(',', $output);
    echo "<script>console.warn('Php warn: " . $output . "' );</script>";
}

function cerror($data) {
    $output = $data;
    if (is_array($output))
        $output = implode(',', $output);
    echo "<script>console.error('Php error: " . $output . "' );</script>";
}