<?php

include '../library/functions.php';
$pdo = pdo_connect_mysql();
$msg = '';

// periksa data yang dikirim dari methot POST
if (!empty($_POST)) {
    // jika POST data tidak kosong maka masukan  record baru
    // set-up variabel yang akan dimasukan
    $id = isset($_POST['id']) && !empty($_POST['id']) && $_POST['id'] != 'auto' ? $_POST['id'] : null;

    // menyiapkan data
    $nama = isset($_POST['nama']) ? $_POST['nama'] : '';
    $email = isset($_POST['email']) ? $_POST['email'] : '';
    $notelp = isset($_POST['notelp']) ? $_POST['notelp'] : '';
    $pekerjaan = isset($_POST['pekerjaan']) ? $_POST['pekerjaan'] : '';

    // memasukan data baru ke dalam databse
    $stmt = $pdo->prepare('INSERT INTO contact VALUE (?, ?, ?, ?, ?)');
    $stmt->execute([$id, $nama, $email, $notelp, $pekerjaan]);

    $msg = 'berhasil ditambahkan';
}
?>

<?= template_header('create') ?>
<div class="content update">
    <h2>Create Contact</h2>
    <form action="create.php" method="post">
        <label for="id">ID</label>
        <label for="nama">Nama</label>
        <input type="text" name="id" value="auto" id="id">
        <input type="text" name="nama" id="nama">
        <label for="email">Email</label>
        <label for="notelp">No. Telp</label>
        <input type="email" name="email" id="email">
        <input type="text" name="notelp" id="notelp">
        <label for="pekerjaan">Pekerjaan</label>
        <input type="text" name="pekerjaan" id="pekerjaan">
        <input type="submit" value="Create">
    </form>
</div>