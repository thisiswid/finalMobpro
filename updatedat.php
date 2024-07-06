<?php
include 'koneksi.php';

if (isset($_GET['edit'])) {
    $id = $_GET['edit'];
    $sql = "SELECT * FROM buku WHERE Book_ID = $id";
    $result = $conn->query($sql);
    $book = $result->fetch_assoc();

    // Fetch Users for Dropdown
    $sql_users = "SELECT * FROM pengguna";
    $result_users = $conn->query($sql_users);
    $users = $result_users->fetch_all(MYSQLI_ASSOC);
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Update Buku</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
</head>
<body>
    <div class="container">
        <h3>Update Buku</h3><br>
        <div class="card border-dark" style="max-width: 50rem;">
            <div class="card-header bg-transparent border-dark">Update Data Buku</div>
            <div class="card-body text-dark">
                <form id="updateBookForm" action="api.php" method="POST" enctype="multipart/form-data">
                    <input type="hidden" name="_method" value="PUT">
                    <input type="hidden" name="id" value="<?php echo $book['Book_ID']; ?>">
                    <div class="mb-3">
                        <label for="judul" class="form-label">Judul:</label>
                        <input type="text" class="form-control" name="judul" id="judul" value="<?php echo $book['Judul']; ?>" required>
                    </div>
                    <div class="mb-3">
                        <label for="cover" class="form-label">Cover :</label>
                        <input class="form-control" type="file" id="cover" name="cover">
                        <img src="uploads/<?php echo $book['Cover']; ?>" width="70">
                    </div>
                    <div class="mb-3">
                        <label for="display" class="form-label">Display :</label>
                        <input class="form-control" type="file" id="display" name="display">
                        <img src="uploads/<?php echo $book['Display']; ?>" width="70">
                    </div>
                    <div class="mb-3">
                        <label for="user_id" class="form-label">User ID:</label><br>
                        <select name="user_id" id="user_id" class="form-select" required>
                            <?php foreach ($users as $user): ?>
                                <option value="<?php echo $user['User_ID']; ?>" <?php echo $user['User_ID'] == $book['User_ID'] ? 'selected' : ''; ?>><?php echo $user['Username']; ?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label for="genre" class="form-label">Genre:</label><br>
                        <select name="genre" id="genre" class="form-select" required>
                                <option value="horror" <?php echo $book['Genre'] == 'horror' ? 'selected' : ''; ?>>horror</option>
                                <option value="aksi" <?php echo $book['Genre'] == 'aksi' ? 'selected' : ''; ?>>aksi</option>
                                <option value="komedi" <?php echo $book['Genre'] == 'komedi' ? 'selected' : ''; ?>>komedi</option>
                                <option value="romantis" <?php echo $book['Genre'] == 'romantis' ? 'selected' : ''; ?>>romantis</option>
                                <option value="drama" <?php echo $book['Genre'] == 'drama' ? 'selected' : ''; ?>>drama</option>
                                <option value="fantasi" <?php echo $book['Genre'] == 'fantasi' ? 'selected' : ''; ?>>fantasi</option>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label for="kategori" class="form-label">Kategori:</label>
                        <select name="kategori" id="kategori" class="form-select" required>
                                <option value="komik" <?php echo $book['Kategori'] == 'komik' ? 'selected' : ''; ?>>komik</option>
                                <option value="novel" <?php echo $book['Kategori'] == 'novel' ? 'selected' : ''; ?>>novel</option>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label for="keterangan" class="form-label">Keterangan:</label><br>
                        <select name="keterangan" id="keterangan" class="form-select" required>
                                <option value="normal" <?php echo $book['Keterangan'] == 'normal' ? 'selected' : ''; ?>>normal</option>
                                <option value="hits" <?php echo $book['Keterangan'] == 'hits' ? 'selected' : ''; ?>>hits</option>
                                <option value="populer" <?php echo $book['Keterangan'] == 'populer' ? 'selected' : ''; ?>>populer</option>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label for="ringkasan" class="form-label">Ringkasan</label>
                        <textarea class="form-control" id="ringkasan" name="ringkasan" required rows="3"><?php echo $book['Ringkasan']; ?></textarea>
                    </div>
                    <div class="mb-3">
                        <label for="sinopsis" class="form-label">Sinopsis</label>
                        <textarea class="form-control" id="sinopsis" name="sinopsis" required rows="3"><?php echo $book['Sinopsis']; ?></textarea>
                    </div>
                    <button type="submit" class="btn btn-outline-info">Update</button>
                </form>
            </div>
        </div>
    </div>
</body>
</html>
