<?php
include 'koneksi.php';

// Fetch Users for Dropdown
$sql_users = "SELECT * FROM pengguna";
$result_users = $conn->query($sql_users);
$users = $result_users->fetch_all(MYSQLI_ASSOC);
?>

<!DOCTYPE html>
<html>
<head>
    <title>Manajemen Buku</title>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <script>
        document.addEventListener("DOMContentLoaded", function() {
            loadBooks();

            document.getElementById("bookForm").addEventListener("submit", function(e) {
                e.preventDefault();
                createBook();
            });
        });

        function loadBooks() {
            fetch("api.php")
                .then(response => response.json())
                .then(data => {
                    let table = document.getElementById("bookTable");
                    table.innerHTML = "";
                    data.forEach(book => {
                        let row = table.insertRow();
                        row.innerHTML = `
                            <td>${book.Book_ID}</td>
                            <td>${book.Judul}</td>
                            <td><img src="uploads/${book.Cover}" width="70"></td>
                            <td><img src="uploads/${book.Display}" width="70"></td>
                            <td>${book.Username}</td>
                            <td>${book.Genre}</td>
                            <td>${book.Kategori}</td>
                            <td>${book.Keterangan}</td>
                            <td>${book.Ringkasan}</td>
                            <td>${book.Sinopsis}</td>
                            <td>
                                <a class="btn btn-outline-success" href="update.php?edit=${book.Book_ID}">Edit</a><br><br>
                                <button class="btn btn-outline-danger" onclick="deleteBook(${book.Book_ID})">Delete</button>
                            </td>
                        `;
                    });
                });
        }

        function createBook() {
            let formData = new FormData(document.getElementById("bookForm"));
            fetch("api.php", {
                method: "POST",
                body: formData
            }).then(response => response.json())
              .then(data => {
                  alert(data.message);
                  loadBooks();
                  document.getElementById("bookForm").reset();
              });
        }

        function deleteBook(id) {
            fetch(`api.php`, {
                method: "DELETE",
                headers: {
                    "Content-Type": "application/x-www-form-urlencoded"
                },
                body: `id=${id}`
            }).then(response => response.json())
              .then(data => {
                  alert(data.message);
                  loadBooks();
              });
        }
    </script>
</head>
<body>
    <nav class="navbar navbar-expand-lg bg-body-tertiary">
        <div class="container-fluid">
            <a class="navbar-brand" href="#">E-literasi Dashboard</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav">
                    <li class="nav-item">
                        <a class="nav-link active" aria-current="page" href="Kelalola.php">Karya</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="index.html">User</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="index_komentar.html">Ulasan</a>
                    </li>
                </ul>
            </div>
        </div>
    </nav><br>

    <div class="container justify-content-center align-items-center">
        <h3>Manajemen Karya</h3><br>
        <div class="card border-dark" style="max-width: 50rem;">
            <div class="card-header bg-transparent border-dark">Input Data Karya</div>
            <div class="card-body text-dark">
                <form id="bookForm" enctype="multipart/form-data">
                    <div class="mb-3">
                        <label for="judul" class="form-label">Judul:</label>
                        <input type="text" class="form-control" name="judul" id="judul" required>
                    </div>
                    <div class="mb-3">
                        <label for="cover" class="form-label">Cover :</label>
                        <input class="form-control" type="file" id="cover" name="cover">
                    </div>
                    <div class="mb-3">
                        <label for="display" class="form-label">Display :</label>
                        <input class="form-control" type="file" id="display" name="display">
                    </div>
                    <div class="mb-3">
                        <label for="user_id" class="form-label">User ID:</label><br>
                        <select name="user_id" id="user_id" class="form-select" required>
                            <?php foreach ($users as $user): ?>
                                <option value="<?php echo $user['User_ID']; ?>"><?php echo $user['Username']; ?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label for="genre" class="form-label">Genre:</label><br>
                        <select name="genre" id="genre" class="form-select" required>
                                <option value="horror">horror</option>
                                <option value="aksi">aksi</option>
                                <option value="komedi">komedi</option>
                                <option value="romantis">romantis</option>
                                <option value="drama">drama</option>
                                <option value="fantasi">fantasi</option>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label for="kategori" class="form-label">Kategori:</label>
                        <select name="kategori" id="kategori" class="form-select" required>
                                <option value="komik">komik</option>
                                <option value="novel">novel</option>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label for="keterangan" class="form-label">Keterangan:</label><br>
                        <select name="keterangan" id="keterangan" class="form-select" required>
                                <option value="normal">normal</option>
                                <option value="hits">hits</option>
                                <option value="populer">populer</option>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label for="ringkasan" class="form-label">Ringkasan</label>
                        <textarea class="form-control" id="ringkasan" name="ringkasan" required rows="3"></textarea>
                    </div>
                    <div class="mb-3">
                        <label for="sinopsis" class="form-label">Sinopsis</label>
                        <textarea class="form-control" id="sinopsis" name="sinopsis" required rows="3"></textarea>
                    </div>
                    <button type="submit" class="btn btn-outline-info">Simpan</button>
                </form>
            </div>
        </div><br>

        <h3>Daftar Karya</h3>
        <table class="table table-striped" style="max-width: 70rem; table-layout: fixed; word-wrap: break-word;">
            <thead>
                <tr>
                    <th>Book ID</th>
                    <th>Judul</th>
                    <th>Cover</th>
                    <th>Display</th>
                    <th>User</th>
                    <th>Genre</th>
                    <th>Kategori</th>
                    <th>Keterangan</th>
                    <th>Ringkasan</th>
                    <th>Sinopsis</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody id="bookTable"></tbody>
        </table>
    </div>
</body>
</html>
