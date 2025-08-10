<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Registrasi Berhasil</title>
</head>
<body>
    <h2>Halo {{ $name }},</h2>
    <p>Terima kasih telah mendaftar. Berikut adalah informasi akun Anda:</p>

    <p><strong>Email:</strong> {{ $email }}</p>
    <p><strong>Password:</strong> {{ $password }}</p>

    <p><b>⚠ PENTING:</b> Jangan pernah membagikan informasi akun ini kepada siapa pun, karena akun ini berisi data pribadi Anda.</p>

    <p>Salam,<br>Tim Kami</p>
</body>
</html>
