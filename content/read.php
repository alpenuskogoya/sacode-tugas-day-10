<?php
include '../library/functions.php';
// koneksi ke database
$pdo = pdo_connect_mysql();
// mendapatkan halaman dari url parameter hanya page jika tidak ada maka tampilkan halaman default 
$page = isset($_GET['page']) && is_numeric($_GET['page']) ? (int)$_GET['page'] : 1;
// data yg ditampilkan perhalaman 
$records_per_page = 5;

// mengambil data dari tabel kontak berdasarkan id
$stmt = $pdo->prepare('SELECT * FROM contact ORDER BY id LIMIT : current_page, :record_per_page');
$stmt->bindValue(':current_page', ($page - 1) * $records_per_page, PDO::PARAM_INT);
$stmt->bindValue(':record_per_page', $records_per_page, PDO::PARAM_INT);
$stmt->execute();

$contacts = $stmt->fetchAll(PDO::FETCH_ASSOC);

$num_contacts = $pdo->query('SELECT COUNT(*) FROM contact')->fetchColumn();

?>
// memasukan template header
<?= template_header('Read') ?>

<div class="content read">
    <h2>Read Contacts</h2>
    <a href="create.php" class="create-contact">Create Contact</a>
    <table>
        <thead>
            <tr>
                <td>#</td>
                <td>Nama</td>
                <td>Email</td>
                <td>No. Telp</td>
                <td>Pekerjaan</td>
                <td></td>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($contacts as $contact) : ?>
                <tr>
                    <td><?= $contact['id'] ?></td>
                    <td><?= $contact['nama'] ?></td>
                    <td><?= $contact['email'] ?></td>
                    <td><?= $contact['notelp'] ?></td>
                    <td><?= $contact['pekerjaan'] ?></td>
                    <td class="actions">
                        <a href="update.php?id=<?= $contact['id'] ?>" class="edit"><i class="fa-solid fa-pen-to-square"></i></a>
                        <a href="delete.php?id=<?= $contact['id'] ?>" class="trash"><i class="fa-solid fa-trash-can"></i></a>
                    </td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
    <div class="pagination">
        <?php if ($page > 1) : ?>
            <a href="read.php?page=<?= $page - 1 ?>"><i class="fa-solid fa-angles-left"></i></a>
        <?php endif ?>
        <?php if ($page * $records_per_page < $num_contacts) : ?>
            <a href="read.php?page=<?= $page + 1 ?>"><i class="fa-solid fa-angles-right"></i></a>
        <?php endif; ?>
    </div>
</div>

<?= template_footer() ?>