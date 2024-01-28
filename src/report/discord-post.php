<?php
session_start();

$username = $_SESSION['username'];
$text = $_POST['text'];

function send_to_discord($username, $message) {
  $webhook_url = 'https://discord.com/api/webhooks/1200679522547290152/nZ3cbyrAb-juMuLcLIAYNIKQKYAktET_pZPN_OWsDE_vQgpX4MAjArSnCSU3oNHhdlMd';
  $option = array(
    'http'
  );

  $content = [
    'username' => $username,
    'content'  => $message,
  ];

  $ch = curl_init($webhook_url);
  curl_setopt($ch, CURLOPT_POST, true);
  curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/json; charset=utf-8'));
  curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
  curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
  curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($content));

  $response = curl_exec($ch);

  if (curl_errno($ch)) {
    echo 'Curl error: ' . curl_error($ch);
  } else {
    header('Location: /index.php');
    exit;
  }

  curl_close($ch);
}

send_to_discord($username, $text);
?>
