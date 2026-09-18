<?php
session_start();
$host='localhost';
$user='root';
$pass='';
$db='db_kasir_restoran';
$conn=new mysqli($host,$user,$pass,$db);
if($conn->connect_error){ die('Koneksi database gagal: '.$conn->connect_error); }
$conn->set_charset('utf8mb4');
function rupiah($n){ return 'Rp '.number_format((int)$n,0,',','.'); }
function auth(){ if(empty($_SESSION['user'])){ header('Location: login.php'); exit; } }
function role($roles=[]){ auth(); if($roles && !in_array($_SESSION['user']['role'],$roles,true)){ http_response_code(403); die('Akses ditolak.'); } }
