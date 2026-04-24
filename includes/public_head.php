<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
<link rel="stylesheet" href="assets/css/style.css">
<style>
  .public-top-bar { height: 6px; background: linear-gradient(90deg, #c4122d, #9b111e); }
  .public-navbar { background:#fff; box-shadow: 0 2px 10px rgba(0,0,0,.06); position: sticky; top:0; z-index: 1020; }
  .public-navbar .brand { display:flex; align-items:center; gap: 14px; text-decoration:none; }
  .public-navbar .brand-logo {
    width: 54px; height: 54px; object-fit: contain;
    filter: drop-shadow(0 2px 4px rgba(0,0,0,.08));
  }
  .public-navbar .brand-divider {
    width: 2px; height: 40px; background: #e5e5e5; border-radius: 1px;
  }
  .public-navbar .brand-text h1 { font-size: 17px; margin:0; color:#222; font-weight:800; letter-spacing: .2px; }
  .public-navbar .brand-text p { font-size: 11px; margin:0; color:#888; font-weight:600; letter-spacing: 1px; }
  .public-navbar .nav-link {
    color:#333 !important; font-weight: 500; padding: 8px 14px !important;
    position: relative; transition: color .2s;
  }
  .public-navbar .nav-link:hover, .public-navbar .nav-link.active { color: #c4122d !important; }
  .public-navbar .nav-link.active::after {
    content: ''; position: absolute; bottom: -2px; left: 14px; right: 14px;
    height: 3px; background: #c4122d; border-radius: 2px;
  }
  .btn-login-red, .public-navbar .nav-link.btn-login-red {
    background: #c4122d; color:#fff !important; border-radius: 999px;
    padding: 8px 20px !important; font-weight: 700;
    box-shadow: 0 3px 10px rgba(196,18,45,.3);
    transition: all .2s;
  }
  .btn-login-red:hover, .public-navbar .nav-link.btn-login-red:hover { background: #9b111e; color:#fff !important; transform: translateY(-2px); box-shadow: 0 6px 16px rgba(196,18,45,.4); }
  .btn-login-red i { color:#fff !important; }
  .public-navbar .dropdown-menu { border:0; box-shadow: 0 6px 20px rgba(0,0,0,.1); border-radius: 10px; margin-top: 8px; }
  .public-navbar .dropdown-item { padding: 8px 16px; font-weight: 500; }
  .public-navbar .dropdown-item:hover { background: #fff0f2; color: #c4122d; }
</style>
