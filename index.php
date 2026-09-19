<?php

require_once 'KelasBioskop.php';
session_start();

if (!isset($_SESSION['daftarKelas']) || (isset($_SESSION['daftarKelas'][0]) && get_class($_SESSION['daftarKelas'][0]) === '__PHP_Incomplete_Class')) {
    $_SESSION['daftarKelas'] = [
        new KelasBioskop("101", "The Premier XXI", 40, 150000),
        new KelasBioskop("102", "IMAX", 300, 85000),
        new KelasBioskop("103", "Deluxe", 100, 65000)
    ];
}

$pesan = "";
$status = "";

// Fungsi pembantu untuk mencari index data berdasarkan ID
function cariIndexById($id) {
    foreach ($_SESSION['daftarKelas'] as $index => $item) {
        if ($item->getId() === $id) {
            return $index;
        }
    }
    return -1;
}

// Handling Form Submission (Tambah / Update)
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $action = $_POST['action'] ?? '';

    if ($action === 'tambah') {
        $id = trim($_POST['id']);
        $nama = trim($_POST['nama']);
        $harga = (float)$_POST['harga'];
        $kursi = (int)$_POST['kursi'];

        if (empty($id) || empty($nama)) {
            $pesan = "ID dan Nama Kelas tidak boleh kosong!";
            $status = "danger";
        } else if (cariIndexById($id) !== -1) {
            $pesan = "Error: ID sudah terdaftar!";
            $status = "danger";
        } else if ($harga <= 0 || $kursi < 0) {
            $pesan = "Error: Harga harus > 0 dan Kursi tidak boleh negatif!";
            $status = "danger";
        } else {
            $_SESSION['daftarKelas'][] = new KelasBioskop($id, $nama, $kursi, $harga);
            $pesan = "Data berhasil ditambahkan!";
            $status = "success";
        }
    } else if ($action === 'update') {
        $id = trim($_POST['id']);
        $idx = cariIndexById($id);

        if ($idx !== -1) {
            $nama = trim($_POST['nama']);
            $kursi = (int)$_POST['kursi'];
            $harga = (float)$_POST['harga'];

            if (empty($nama) || $harga <= 0 || $kursi < 0) {
                $pesan = "Error: Input tidak valid!";
                $status = "danger";
            } else {
                $_SESSION['daftarKelas'][$idx]->setNamaKelas($nama);
                $_SESSION['daftarKelas'][$idx]->setJumlahKursi($kursi);
                $_SESSION['daftarKelas'][$idx]->setHarga($harga);
                $pesan = "Data berhasil diperbarui!";
                $status = "success";
            }
        } else {
            $pesan = "Error: Data tidak ditemukan!";
            $status = "danger";
        }
    }
}

// Handling Hapus Data via Parameter GET
if (isset($_GET['delete'])) {
    $idx = cariIndexById($_GET['delete']);
    if ($idx !== -1) {
        array_splice($_SESSION['daftarKelas'], $idx, 1);
        $pesan = "Data berhasil dihapus!";
        $status = "success";
    } else {
        $pesan = "Error: Data tidak ditemukan!";
        $status = "danger";
    }
}

// Handling Pencarian
$searchKeyword = $_GET['search'] ?? '';
$displayData = $_SESSION['daftarKelas'];
if (!empty($searchKeyword)) {
    $displayData = array_filter($displayData, function($item) use ($searchKeyword) {
        return $item->getId() === $searchKeyword;
    });
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Kelola Kelas Bioskop</title>
    <style>
        body { font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif; background-color: #f4f6f9; margin: 20px; }
        .container { max-width: 900px; margin: auto; background: white; padding: 25px; border-radius: 8px; box-shadow: 0 2px 8px rgba(0,0,0,0.1); }
        h2 { color: #333; margin-top: 0; }
        .alert { padding: 12px; margin-bottom: 15px; border-radius: 4px; }
        .alert-success { background-color: #d4edda; color: #155724; border: 1px solid #c3e6cb; }
        .alert-danger { background-color: #f8d7da; color: #721c24; border: 1px solid #f5c6cb; }
        .form-group { margin-bottom: 12px; }
        label { display: block; margin-bottom: 5px; font-weight: bold; }
        input[type="text"], input[type="number"] { width: 100%; padding: 8px; box-sizing: border-box; border: 1px solid #ccc; border-radius: 4px; }
        .btn { padding: 8px 15px; border: none; border-radius: 4px; cursor: pointer; color: white; display: inline-block; }
        .btn-primary { background-color: #007bff; }
        .btn-warning { background-color: #ffc107; color: #212529; }
        .btn-danger { background-color: #dc3545; text-decoration: none; font-size: 13px; padding: 5px 10px; }
        table { width: 100%; border-collapse: collapse; margin-top: 15px; }
        th, td { border: 1px solid #ddd; padding: 10px; text-align: left; }
        th { background-color: #007bff; color: white; }
        tr:nth-child(even) { background-color: #f9f9f9; }
        .form-row { display: flex; gap: 10px; }
    </style>
</head>
<body>

<div class="container">
    <h2>Kelola Kelas Tempat Duduk Bioskop</h2>

    <?php if ($pesan): ?>
        <div class="alert alert-<?= $status ?>"><?= htmlspecialchars($pesan) ?></div>
    <?php endif; ?>

    <!-- Form Tambah / Edit -->
    <form method="POST" action="index.php">
        <input type="hidden" name="action" id="form-action" value="tambah">
        <div class="form-row">
            <div class="form-group" style="flex:1;">
                <label>ID Kelas</label>
                <input type="text" name="id" id="input-id" required>
            </div>
            <div class="form-group" style="flex:2;">
                <label>Nama Kelas</label>
                <input type="text" name="nama" id="input-nama" required>
            </div>
        </div>
        <div class="form-row">
            <div class="form-group" style="flex:1;">
                <label>Jumlah Kursi</label>
                <input type="number" name="kursi" id="input-kursi" required>
            </div>
            <div class="form-group" style="flex:1;">
                <label>Harga Tiket (Rp)</label>
                <input type="number" name="harga" id="input-harga" required>
            </div>
        </div>
        <button type="submit" id="btn-submit" class="btn btn-primary">Tambah Kelas</button>
        <button type="button" onclick="resetForm()" class="btn" style="background:#6c757d;">Reset</button>
    </form>

    <hr style="margin: 25px 0;">

    <!-- Form Pencarian berdasarkan ID -->
    <form method="GET" action="index.php" class="form-row">
        <input type="text" name="search" placeholder="Cari berdasarkan ID..." value="<?= htmlspecialchars($searchKeyword) ?>">
        <button type="submit" class="btn btn-primary">Cari</button>
        <?php if ($searchKeyword): ?>
            <a href="index.php" class="btn" style="background:#6c757d; text-decoration:none;">Reset Cari</a>
        <?php endif; ?>
    </form>

    <!-- Tabel Data -->
    <table>
        <thead>
            <tr>
                <th>ID</th>
                <th>Nama</th>
                <th>Kursi</th>
                <th>Harga (Rp)</th>
                <th>Aksi</th>
            </tr>
        </thead>
        <tbody>
            <?php if (empty($displayData)): ?>
                <tr><td colspan="5" style="text-align:center;">Data tidak ditemukan.</td></tr>
            <?php else: ?>
                <?php foreach ($displayData as $k): ?>
                    <tr>
                        <td><?= htmlspecialchars($k->getId()) ?></td>
                        <td><?= htmlspecialchars($k->getNamaKelas()) ?></td>
                        <td><?= $k->getJumlahKursi() ?></td>
                        <td>Rp <?= number_format($k->getHarga(), 0, ',', '.') ?></td>
                        <td>
                            <button class="btn btn-warning" onclick="editData('<?= $k->getId() ?>', '<?= addslashes($k->getNamaKelas()) ?>', <?= $k->getJumlahKursi() ?>, <?= $k->getHarga() ?>)">Edit</button>
                            <a href="index.php?delete=<?= urlencode($k->getId()) ?>" class="btn btn-danger" onclick="return confirm('Yakin hapus data ini?')">Hapus</a>
                        </td>
                    </tr>
                <?php endforeach; ?>
            <?php endif; ?>
        </tbody>
    </table>
</div>

<script>
function editData(id, nama, kursi, harga) {
    document.getElementById('form-action').value = 'update';
    document.getElementById('input-id').value = id;
    document.getElementById('input-id').readOnly = true;
    document.getElementById('input-nama').value = nama;
    document.getElementById('input-kursi').value = kursi;
    document.getElementById('input-harga').value = harga;
    document.getElementById('btn-submit').innerText = 'Update Kelas';
    document.getElementById('btn-submit').className = 'btn btn-warning';
}

function resetForm() {
    document.getElementById('form-action').value = 'tambah';
    document.getElementById('input-id').value = '';
    document.getElementById('input-id').readOnly = false;
    document.getElementById('input-nama').value = '';
    document.getElementById('input-kursi').value = '';
    document.getElementById('input-harga').value = '';
    document.getElementById('btn-submit').innerText = 'Tambah Kelas';
    document.getElementById('btn-submit').className = 'btn btn-primary';
}
</script>

</body>
</html>
