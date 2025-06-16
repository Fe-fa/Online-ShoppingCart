<?php
$conn = new mysqli("localhost", "root", "", "classic_store");

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $name = $_POST['name'];
    $description = $_POST['description'];
    $amount = $_POST['amount'];
    $quantity = $_POST['quantity'];
    $category = $_POST['category']; // new

    $target_dir = "uploads/";
    $image_name = basename($_FILES["image"]["name"]);
    $target_file = $target_dir . time() . "_" . $image_name;

    if (move_uploaded_file($_FILES["image"]["tmp_name"], $target_file)) {
        $stmt = $conn->prepare("INSERT INTO products (name, description, amount, quantity, image, category) VALUES (?, ?, ?, ?, ?, ?)");
     $stmt->bind_param("sssdss", $name, $description, $amount, $quantity, $target_file, $category);
        $stmt->execute();
        $stmt->close();
        echo "<script>alert('Product posted successfully');</script>";
    } else {
        echo "<script>alert('Image upload failed.');</script>";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <title>Admin - Post Products</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet"/>
</head>
<body class="bg-light">
  <div class="container mt-5">
    <h2 class="mb-4">Post New Product</h2>
    <form action="" method="POST" enctype="multipart/form-data" class="border p-4 bg-white shadow-sm rounded">
      <div class="mb-3">
        <label class="form-label">Product Name</label>
        <input type="text" name="name" class="form-control" required />
      </div>
      <div class="mb-3">
        <label class="form-label">Description</label>
        <textarea name="description" class="form-control" required></textarea>
      </div>
      <div class="mb-3">
        <label class="form-label">Amount (Ksh)</label>
        <input type="number" name="amount" step="0.01" class="form-control" required />
      </div>
      <div class="mb-3">
        <label class="form-label">Quantity</label>
        <input type="number" name="quantity" class="form-control" required />
      </div>
      <div class="mb-3">
        <label class="form-label">Category</label>
        <select name="category" class="form-control" required>
          <option value="">-- Select Category --</option>
          <option value="Clothing">Clothing</option>
          <option value="Electronics">Electronics</option>
          <option value="Footwear">Footwear</option>
          <option value="Accessories">Accessories</option>
          <option value="Beauty">Beauty</option>
        </select>
      </div>
      <div class="mb-3">
        <label class="form-label">Product Image</label>
        <input type="file" name="image" accept="image/*" class="form-control" required />
      </div>
      <button type="submit" class="btn btn-warning">Post Product</button>
    </form>
  </div>
</body>
</html>
