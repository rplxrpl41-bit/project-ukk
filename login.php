<?php
require 'config.php';
if (!empty($_SESSION['user'])) { header('Location: index.php'); exit; }
$error = '';
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = trim($_POST['email'] ?? '');
    $password = $_POST['password'] ?? '';
    $stmt = $conn->prepare("SELECT id,name,email,password,role FROM users WHERE email=? LIMIT 1");
    $stmt->bind_param('s', $email);
    $stmt->execute();
    $u = $stmt->get_result()->fetch_assoc();
    if ($u && $u['password'] === md5($password)) {
        unset($u['password']);
        $_SESSION['user'] = $u;
        header('Location: index.php');
        exit;
    }
    $error = 'Email atau password salah.';
}
?>
<!doctype html>
<html lang="id">
<head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width,initial-scale=1">
<title>Login • RestoPOS</title>
<link rel="icon" href="data:image/svg+xml,<svg xmlns=%22http://www.w3.org/2000/svg%22 viewBox=%220 0 100 100%22><text y=%22.9em%22 font-size=%2290%22>🍽️</text></svg>">
<link rel="preconnect" href="https://fonts.googleapis.com"><link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700;800&display=swap" rel="stylesheet">
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
<link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css" rel="stylesheet">
<style>
  :root{--primary:#2563eb;--indigo:#4f46e5;--ink:#172033;--muted:#7b879d}
  *{box-sizing:border-box}
  body{margin:0;min-height:100vh;font-family:Poppins,sans-serif;background:#f5f7fb;color:var(--ink)}
  .wrap{min-height:100vh;display:grid;grid-template-columns:1.1fr 1fr}
  .side{position:relative;overflow:hidden;background:linear-gradient(150deg,#1d4ed8,#4338ca 55%,#312e81);color:#fff;display:flex;flex-direction:column;justify-content:space-between;padding:54px}
  .side::before{content:'';position:absolute;width:420px;height:420px;border-radius:50%;background:radial-gradient(circle,#ffffff22,transparent 70%);top:-140px;right:-140px}
  .side::after{content:'';position:absolute;width:300px;height:300px;border-radius:50%;background:radial-gradient(circle,#ffffff14,transparent 70%);bottom:-80px;left:-80px}
  .side *{position:relative;z-index:2}
  .brandmark{display:flex;align-items:center;gap:13px}
  .brandmark .ico{width:48px;height:48px;border-radius:14px;background:#ffffff22;backdrop-filter:blur(6px);display:grid;place-items:center;font-size:22px;border:1px solid #ffffff33}
  .brandmark b{font-size:18px;letter-spacing:.3px}
  .brandmark small{display:block;font-size:11px;color:#dbeafe}
  .pitch h1{font-size:32px;font-weight:800;line-height:1.25;margin-bottom:14px}
  .pitch p{color:#dbeafe;font-size:13px;line-height:1.8;max-width:400px}
  .feat{display:flex;gap:12px;align-items:flex-start;margin-top:16px;font-size:12px;color:#e8edff}
  .feat i{background:#ffffff20;border-radius:9px;padding:7px;font-size:14px}
  .foot{font-size:10.5px;color:#c7d2fe}
  .formcol{display:flex;align-items:center;justify-content:center;padding:40px 32px}
  .panel{width:min(400px,100%)}
  .panel h3{font-weight:800;font-size:25px;margin-bottom:4px}
  .panel .sub{color:var(--muted);font-size:12.5px;margin-bottom:28px}
  label.small{font-size:11.5px;font-weight:600;color:#41506b}
  .form-control{border-radius:11px;padding:12px 14px;border-color:#e1e6ef;font-size:13px}
  .form-control:focus{border-color:#93c5fd;box-shadow:0 0 0 .2rem #2563eb14}
  .input-group .form-control{border-right:0}
  .input-group .btn-eye{border:1px solid #e1e6ef;border-left:0;border-radius:0 11px 11px 0;background:#fff;color:#8a95a8}
  .btn-primary{border:0;background:linear-gradient(90deg,var(--primary),var(--indigo));border-radius:11px;padding:12px;font-weight:700;font-size:13px;box-shadow:0 12px 26px #2563eb33}
  .btn-primary:hover{filter:brightness(1.05)}
  .demo{background:#f5f7fb;border:1px dashed #d7deeb;border-radius:12px;padding:12px 14px;font-size:11px;color:#5b6883;margin-top:26px}
  .demo b{color:var(--ink)}
  @media(max-width:860px){.wrap{grid-template-columns:1fr}.side{display:none}}
</style>
</head>
<body>
<div class="wrap">
  <div class="side">
    <div class="brandmark">
      <div class="ico"><i class="bi bi-shop"></i></div>
      <div><b>RestoPOS</b><small>Point of Sale • Restoran</small></div>
    </div>
    <div class="pitch">
      <h1>Kelola operasional<br>restoran Anda<br>dari satu layar.</h1>
      <p>Sistem kasir, manajemen menu, dan laporan penjualan dalam satu dashboard yang cepat dan rapi.</p>
      <div class="feat"><i class="bi bi-lightning-charge-fill"></i><div>Transaksi kasir cepat dengan keranjang real-time</div></div>
      <div class="feat"><i class="bi bi-bar-chart-fill"></i><div>Laporan penjualan &amp; pemantauan stok otomatis</div></div>
      <div class="feat"><i class="bi bi-shield-lock-fill"></i><div>Akses berbasis peran: Admin, Kasir, Manajer</div></div>
    </div>
    <div class="foot">© <?=date('Y')?> RestoPOS — Project UKK Rekayasa Perangkat Lunak</div>
  </div>

  <div class="formcol">
    <div class="panel">
      <h3>Selamat Datang 👋</h3>
      <div class="sub">Masuk untuk melanjutkan ke dashboard RestoPOS.</div>

      <?php if ($error): ?>
        <div class="alert alert-danger py-2 px-3" style="font-size:12px;border-radius:10px"><i class="bi bi-exclamation-circle me-1"></i><?=htmlspecialchars($error)?></div>
      <?php endif; ?>

      <form method="post" novalidate>
        <label class="small mb-1">Email</label>
        <input class="form-control mb-3" type="email" name="email" placeholder="nama@email.com" value="<?=htmlspecialchars($_POST['email'] ?? '')?>" required autofocus>

        <label class="small mb-1">Password</label>
        <div class="input-group mb-2">
          <input class="form-control" type="password" name="password" id="pwd" placeholder="Masukkan password" required>
          <button class="btn btn-eye" type="button" onclick="const p=document.getElementById('pwd');p.type=p.type==='password'?'text':'password';this.querySelector('i').classList.toggle('bi-eye');this.querySelector('i').classList.toggle('bi-eye-slash')"><i class="bi bi-eye"></i></button>
        </div>

        <button class="btn btn-primary w-100 mt-3"><i class="bi bi-box-arrow-in-right me-1"></i> Masuk ke Dashboard</button>
      </form>

      <div class="demo">
        <b>Akun demo</b><br>
        Admin — admin@example.com / password<br>
        Kasir — kasir@example.com / password<br>
        Manajer — manajer@example.com / password
      </div>
    </div>
  </div>
</div>
</body>
</html>
