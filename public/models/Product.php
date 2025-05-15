<?php
require_once "Database.php";

class Product {
    private $conn;

    public function __construct() {
        $database = new Database();
        $this->conn = $database->getConnection();
    }

    public function getAllProducts($sortColumn = null, $sortDirection = 'ASC') {
        $allowedColumns = ['price', 'name'];
        $allowedDirections = ['ASC', 'DESC'];

        $orderBy = '';
        if ($sortColumn && in_array($sortColumn, $allowedColumns)) {
            $direction = in_array(strtoupper($sortDirection), $allowedDirections) ? strtoupper($sortDirection) : 'ASC';
            $orderBy = " ORDER BY $sortColumn $direction";
        }

        $sql = "SELECT * FROM product" . $orderBy;
        return $this->conn->query($sql);
    }

    public function getProductById($id) {
        $stmt = $this->conn->prepare("SELECT * FROM product WHERE id = ?");
        $stmt->bind_param("i", $id);
        $stmt->execute();
        return $stmt->get_result()->fetch_assoc();
    }

    public function createProduct($name, $price, $img, $stock) {
        $stmt = $this->conn->prepare("INSERT INTO product (name, price, img, stock) VALUES (?, ?, ?, ?)");
        $stmt->bind_param("sisi", $name, $price, $img, $stock);
        return $stmt->execute();
    }

    public function updateProduct($id, $name, $price, $img, $stock) {
        $stmt = $this->conn->prepare("UPDATE product SET name='$name', price=$price, img='$img', stock=$stock WHERE id = $id");
        $stmt = $this->conn->prepare("UPDATE product SET name=?, price=?, img=?, stock=? WHERE id=?");
        $stmt->bind_param("sisii", $name, $price, $img, $stock, $id);
        return $stmt->execute();
    }

    public function uploadImage() {
        $fileName = $_FILES['img']['name'];
        $fileSize = $_FILES['img']['size'];
        $fileError = $_FILES['img']['error'];
        $fileTmpName = $_FILES['img']['tmp_name'];

        //cek ada gambar yang diupload/tidak
        if($fileError === 4) {
            echo '<script>alert("Gambar tidak ditemukan!");</script>';
            return false;
        }

        //cek jenis file
        $allowedExtensions = array('jpg', 'jpeg', 'png');
        $fileExtension = strtolower(pathinfo($fileName, PATHINFO_EXTENSION));
        if(!in_array($fileExtension, $allowedExtensions)) {
            echo '<script>alert("File tidak diperbolehkan!");</script>';
            return false;
        }

        //cek ukuran file
        if($fileSize > 2097152) {
            echo '<script>alert("Ukuran file terlalu besar!");</script>';
            return false;
        }

        //upload file
        $newFileName = uniqid();
        $newFileName .= '.' . $fileExtension;

        move_uploaded_file($fileTmpName, '../uploads/img/' . $newFileName);
        return $newFileName;
    }

    public function searchProduct($keyword) {
        $stmt = $this->conn->prepare("SELECT * FROM product WHERE name LIKE ?");
        $search = '%' . $keyword . '%';
        $stmt->bind_param("s", $search);
        $stmt->execute();
        $result = $stmt->get_result();
    
        return $result->num_rows > 0 ? $result : false;
    }    

    public function deleteProduct($id) {
        $stmt = $this->conn->prepare("DELETE FROM product WHERE id = ?");
        $stmt->bind_param("i", $id);
        return $stmt->execute();
    }


public function buyProduct($id, $stock) {
    $stmt = $this->conn->prepare("UPDATE product SET stock = ? WHERE id = ?");
    $stmt->bind_param("ii", $stock, $id);
    return $stmt->execute();
}

}

?>