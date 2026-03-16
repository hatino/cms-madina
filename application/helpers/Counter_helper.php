<?php

use SebastianBergmann\Environment\Console;

function simpan_kunjungan() {
    //session_start();
    date_default_timezone_set("Asia/Jakarta");
    //include 'conn.php';
    
    $session_id = session_id();
   
    $ip = getUserIP();
    $vistor_key = getVisitorKey();

    if ($ip == '::1') {
        $ip = '127.0.0.1';
    }

    $now = date("Y-m-d H:i:s");

    // Cek apakah session sudah tercatat
    //$query = "SELECT * FROM visitors WHERE visitor_key='$vistor_key' and DATE(visit_time) = DATE('$now') ";
    //$check = $conn->query($query);
    
    //$data = $check->fetch_assoc();     
    // echo "<pre>";
    // echo $vistor_key;
    // print_r($data);
    // echo "</pre>";
    // exit;
    // 
    /*
    if ($check->num_rows == 0) {    
        // Insert jika belum ada
        $conn->query("INSERT INTO visitors (ip_address, visit_time, session_id, visitor_key ) 
                    VALUES ('$ip', '$now', '$session_id', '$vistor_key') ");
    }else{
        $conn->query("UPDATE visitors SET  visit_time = '$now' 
        WHERE visitor_key='$vistor_key' 
        and DATE(visit_time) = DATE('$now') 
        ");
                    
    }*/
    
    $tanggal = date('Y-m-d', strtotime($now));
    $CI =& get_instance();
    $CI->load->database();

    $query = $CI->db->get_where('visitors', ['visitor_key' => $vistor_key, 'DATE(visit_time) =' => $tanggal]);    
    // $data = $query->row_array();
    // print_r($data);
    $row = $query->row();
   
    if (!$row) {
        // insert
        $CI->db->insert('visitors', [
            'ip_address' => $ip,
            'visit_time' => $now,
            'session_id' => $session_id,
            'visitor_key' => $vistor_key
        ]);
    }else{
        $CI->db->where([
            'visitor_key' => $vistor_key,
            'DATE(visit_time) =' => $tanggal
        ]);

        $CI->db->update('visitors', [
            'visit_time' => $now
        ]);
    }

    
}

function getUserIP() {
    if (!empty($_SERVER['HTTP_CLIENT_IP'])) {
        return $_SERVER['HTTP_CLIENT_IP'];
    }

    if (!empty($_SERVER['HTTP_X_FORWARDED_FOR'])) {
        return $_SERVER['HTTP_X_FORWARDED_FOR'];
    }

    return $_SERVER['REMOTE_ADDR'];
}

function getVisitorKey() {
    // $ip = $_SERVER['REMOTE_ADDR'];
    // $agent = $_SERVER['HTTP_USER_AGENT'];

    // return md5($ip . $agent);

    if (!isset($_COOKIE['bez_app_visitor_key'])) {
        $visitor_key = uniqid('v_', true);
        setcookie("bez_app_visitor_key", $visitor_key, time() + (86400 * 365), "/");
    } else {
        $visitor_key = $_COOKIE['bez_app_visitor_key'];
    }

    return $visitor_key;
}

?>