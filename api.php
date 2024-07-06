<?php
include 'koneksi.php';

function getBooks() {
    global $conn;
    $sql = "SELECT b.Book_ID, b.Judul, b.Cover, b.Display, u.Username, b.Genre, b.Kategori, b.Keterangan, b.Ringkasan, b.Sinopsis
            FROM buku b
            JOIN pengguna u ON b.User_ID = u.User_ID";
    $result = $conn->query($sql);
    $books = $result->fetch_all(MYSQLI_ASSOC);
    echo json_encode($books);
}

function getBook($id) {
    global $conn;
    $sql = "SELECT * FROM buku WHERE Book_ID = $id";
    $result = $conn->query($sql);
    $book = $result->fetch_assoc();
    echo json_encode($book);
}

function createBook() {
    global $conn;
    $judul = $_POST['judul'];
    $cover = $_FILES['cover']['name'];
    $display = $_FILES['display']['name'];
    $user_id = $_POST['user_id'];
    $genre = $_POST['genre'];
    $kategori = $_POST['kategori'];
    $keterangan = $_POST['keterangan'];
    $ringkasan = $_POST['ringkasan'];
    $sinopsis = $_POST['sinopsis'];

    if ($cover) {
        $target_dir = "uploads/";
        $target_file = $target_dir . basename($cover);
        move_uploaded_file($_FILES["cover"]["tmp_name"], $target_file);
    }

    if ($display) {
        $target_dir = "uploads/";
        $target_file = $target_dir . basename($display);
        move_uploaded_file($_FILES["display"]["tmp_name"], $target_file);
    }

    $sql = "INSERT INTO buku (Judul, Cover, Display, User_ID, Genre, Kategori, Keterangan, Ringkasan, Sinopsis)
            VALUES ('$judul', '$cover', '$display', '$user_id', '$genre', '$kategori', '$keterangan', '$ringkasan', '$sinopsis')";

    if ($conn->query($sql) === TRUE) {
        echo json_encode(["message" => "Book created successfully"]);
    } else {
        echo json_encode(["message" => "Error: " . $sql . "<br>" . $conn->error]);
    }
}

function updateBook() {
    global $conn;
    $data = $_POST;
    $id = $data['id'];

    $judul = $data['judul'];
    $cover = $_FILES['cover']['name'];
    $display = $_FILES['display']['name'];
    $user_id = $data['user_id'];
    $genre = $data['genre'];
    $kategori = $data['kategori'];
    $keterangan = $data['keterangan'];
    $ringkasan = $data['ringkasan'];
    $sinopsis = $data['sinopsis'];

    if ($cover) {
        $target_dir = "uploads/";
        $target_file = $target_dir . basename($cover);
        move_uploaded_file($_FILES["cover"]["tmp_name"], $target_file);
        $cover_sql = "Cover='$cover',";
    } else {
        $cover_sql = "";
    }

    if ($display) {
        $target_dir = "uploads/";
        $target_file = $target_dir . basename($display);
        move_uploaded_file($_FILES["display"]["tmp_name"], $target_file);
        $display_sql = "Display='$display',";
    } else {
        $display_sql = "";
    }

    $sql = "UPDATE buku SET Judul='$judul', $cover_sql $display_sql User_ID='$user_id', Genre='$genre', Kategori='$kategori', Keterangan='$keterangan', Ringkasan='$ringkasan', Sinopsis='$sinopsis' WHERE Book_ID='$id'";

    if ($conn->query($sql) === TRUE) {
        echo json_encode(["message" => "Book updated successfully"]);
    } else {
        echo json_encode(["message" => "Error: " . $sql . "<br>" . $conn->error]);
    }
}

function deleteBook($id) {
    global $conn;
    $sql = "DELETE FROM buku WHERE Book_ID = $id";

    if ($conn->query($sql) === TRUE) {
        echo json_encode(["message" => "Book deleted successfully"]);
    } else {
        echo json_encode(["message" => "Error: " . $sql . "<br>" . $conn->error]);
    }
}

// Handle HTTP request method
$method = $_SERVER['REQUEST_METHOD'];

if ($method == 'GET' && isset($_GET['id'])) {
    getBook($_GET['id']);
} elseif ($method == 'GET') {
    getBooks();
} elseif ($method == 'POST' && isset($_POST['_method']) && $_POST['_method'] == 'PUT') {
    updateBook();
} elseif ($method == 'POST') {
    createBook();
} elseif ($method == 'DELETE') {
    parse_str(file_get_contents("php://input"), $_DELETE);
    deleteBook($_DELETE['id']);
}
?>
