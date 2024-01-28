<?php
include_once 'database.php';

// Create Operation
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['add_product'])) {
    $name = $_POST['name'];
    $description = $_POST['description'];
    $price = $_POST['price'];

    // File upload handling
    $uploadDir = "uploads/";  // Create a directory named "uploads" to store uploaded images
    $uploadFile = $uploadDir . basename($_FILES['image']['name']);

    if (move_uploaded_file($_FILES['image']['tmp_name'], $uploadFile)) {
        // File successfully uploaded
        $image_url = $uploadFile;

        $sql = "INSERT INTO Products (name, description, price, image_url) VALUES (?, ?, ?, ?)";
        if ($stmt = $pdo->prepare($sql)) {
            $stmt->bindParam(1, $name);
            $stmt->bindParam(2, $description);
            $stmt->bindParam(3, $price);
            $stmt->bindParam(4, $image_url);

            if ($stmt->execute()) {
                header("location: {$_SERVER['PHP_SELF']}");
                exit();
            } else {
                echo "Something went wrong. Please try again later.";
            }
        }
        unset($stmt);
    } else {
        echo "Error uploading the file.";
    }
}

// Create Operation
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['add_product'])) {
    $name = $_POST['name'];
    $description = $_POST['description'];
    $price = $_POST['price'];
    $image_url = $_POST['image_url'];

    $sql = "INSERT INTO Products (name, description, price, image_url) VALUES (?, ?, ?, ?)";
    if ($stmt = $pdo->prepare($sql)) {
        $stmt->bindParam(1, $name);
        $stmt->bindParam(2, $description);
        $stmt->bindParam(3, $price);
        $stmt->bindParam(4, $image_url);

        if ($stmt->execute()) {
            header("location: {$_SERVER['PHP_SELF']}");
            exit();
        } else {
            echo "Something went wrong. Please try again later.";
        }
    }
    unset($stmt);
}

// Read Operation
$sql = "SELECT * FROM Products";
$result = $pdo->query($sql);

// Update Operation
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['update_product'])) {
    $name = $_POST['name'];
    $description = $_POST['description'];
    $price = $_POST['price'];
    $image_url = $_POST['image_url'];
    $id = $_POST['product_id'];

    $sql = "UPDATE Products SET name=?, description=?, price=?, image_url=? WHERE product_id=?";
    if ($stmt = $pdo->prepare($sql)) {
        $stmt->bindParam(1, $name);
        $stmt->bindParam(2, $description);
        $stmt->bindParam(3, $price);
        $stmt->bindParam(4, $image_url);
        $stmt->bindParam(5, $id);

        if ($stmt->execute()) {
            header("location: {$_SERVER['PHP_SELF']}");
            exit();
        } else {
            echo "Something went wrong. Please try again later.";
        }
    }
    unset($stmt);
}

// Delete Operation
if (isset($_GET["product_id"]) && !empty(trim($_GET["product_id"]))) {
    $sql = "DELETE FROM Products WHERE product_id = ?";
    if ($stmt = $pdo->prepare($sql)) {
        $stmt->bindParam(1, $param_product_id);
        $param_product_id = trim($_GET["product_id"]);

        if ($stmt->execute()) {
            header("location: {$_SERVER['PHP_SELF']}");
            exit();
        } else {
            echo "Oops! Something went wrong. Please try again later.";
        }
    }
    unset($stmt);
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="styles.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.2/css/all.min.css"/>
    <!-- basic -->
      <meta charset="utf-8">
      <meta http-equiv="X-UA-Compatible" content="IE=edge">
      <!-- mobile metas -->
      <meta name="viewport" content="width=device-width, initial-scale=1">
      <meta name="viewport" content="initial-scale=1, maximum-scale=1">
      <!-- site metas -->
      <title>VERyWELL</title>
      <meta name="keywords" content="">
      <meta name="description" content="">
      <meta name="author" content="">
      <!-- site icon -->
      <link rel="icon" href="images/fevicon.png" type="image/png" />
      <!-- bootstrap css -->
      <link rel="stylesheet" href="css/bootstrap.min.css" />
      <!-- site css -->
      <link rel="stylesheet" href="style.css" />
      <!-- responsive css -->
      <link rel="stylesheet" href="css/responsive.css" />
      <!-- color css -->
      <link rel="stylesheet" href="css/colors.css" />
      <!-- select bootstrap -->
      <link rel="stylesheet" href="css/bootstrap-select.css" />
      <!-- scrollbar css -->
      <link rel="stylesheet" href="css/perfect-scrollbar.css" />
      <!-- custom css -->
      <link rel="stylesheet" href="css/custom.css" />
    <title>Product Management</title>
    
</head>

<body>
    <body class="dashboard dashboard_1">
      <div class="full_container">
         <div class="inner_container">
            <!-- Sidebar  -->
            <nav id="sidebar">
               <div class="sidebar_blog_1">
                  <div class="sidebar-header">
                     <div class="logo_section">
                        <a href="index.html"><img class="logo_icon img-responsive" src="images/logo/logo_icon.png" alt="#" /></a>
                     </div>
                  </div>
                  <div class="sidebar_user_info">
                     <div class="icon_setting"></div>
                     <div class="user_profle_side">
                        <div class="user_img"><img class="img-responsive" src="pro.png" alt="#" /></div>
                        <div class="user_info">
                           <h6>User</h6>
                           <p><span class="online_animation"></span> Online</p>
                        </div>
                     </div>
                  </div>
               </div>
               <div class="sidebar_blog_2">
                  <h4>General</h4>
                  <ul class="list-unstyled components">
                     <li class="active">
                        <a href="#dashboard" data-toggle="collapse" aria-expanded="false"><i class="fa fa-dashboard yellow_color"></i> <span>Dashboard</span></a>
                        
                     </li>
                    
                       
                     </li>
                     <li><a href="products.php"><i class="fa fa-table purple_color2"></i> <span>Products</span></a></li>
                     <li>
                       
                     
                        
               </div>
            </nav>
            <!-- end sidebar -->
            <!-- right content -->
            <div id="content">
               <!-- topbar -->
               <div class="topbar">
                  <nav class="navbar navbar-expand-lg navbar-light">
                     <div class="full">
                        <button type="button" id="sidebarCollapse" class="sidebar_toggle"><i class="fa fa-bars"></i></button>
                        <div class="logo_section">
                           <a href="user_dashboard.html"><img class="img-responsive" src="images/logo/logo-verywell.jpg" alt="#" /></a>
                        </div>
                        <div class="right_topbar">
                           <div class="icon_info">
                              <ul class="user_profile_dd">
                                 <li>
                                    <a class="dropdown-toggle" data-toggle="dropdown"><img class="img-responsive rounded-circle" src="pro.png" alt="#" /><span class="name_user">User</span></a>
                                    <div class="dropdown-menu">
                                       <a class="dropdown-item" href="profile.html">My Profile</a>
                                       
                                       <!-- Update the "Log Out" link -->
<a class="dropdown-item" href="logout.php"><span>Log Out</span> <i class="fa fa-sign-out"></i></a>
</a>
                                    </div>
                                 </li>
                              </ul>
                           </div>
                        </div>
                     </div>
                  </nav>
       


    <div class="container">

        <!-- Display Products -->
        <h2>Product List</h2>
        <table>
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Name</th>
                    <th>Description</th>
                    <th>Price</th>
                    <th>Image</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php
                // Fetch products from the database and display them
                $sql = "SELECT * FROM Products";
                $result = $pdo->query($sql);
                while ($row = $result->fetch(PDO::FETCH_ASSOC)) {
                    echo "<tr>";
                    echo "<td>{$row['product_id']}</td>";
                    echo "<td>{$row['name']}</td>";
                    echo "<td>{$row['description']}</td>";
                    echo "<td>{$row['price']}</td>";
                    echo "<td><img src='{$row['image_url']}' alt='Product Image' style='max-width: 100px; max-height: 100px;'></td>"; // Updated cell content
                    echo "<td>
                            <a class='btn btn-success' href='#editProductModal'>Edit</a>
                            <a class='btn btn-danger' href='{$_SERVER['PHP_SELF']}?product_id={$row['product_id']}'>Delete</a>
                          </td>";
                    echo "</tr>";
                }
                ?>
            </tbody>
        </table>

        <!-- Add Product Form -->
        <h2>Add New Product</h2>
        <form method="post" action="<?php echo $_SERVER['PHP_SELF']; ?>" enctype="multipart/form-data">
            <label for="name">Name:</label>
            <input type="text" name="name" required>

            <label for="description">Description:</label>
            <textarea name="description" required></textarea>

            <label for="price">Price:</label>
            <input type="text" name="price" required>

            <label for="image">Image:</label>
            <input type="file" name="image" accept="image/*" required>

            <input type="submit" name="add_product" class="btn btn-success" value="Add Product">
        </form>
    </div>
        </div>
            </div>
         </div>
      </div>
<!-- jQuery -->
      <script src="js/jquery.min.js"></script>
      <script src="js/popper.min.js"></script>
      <script src="js/bootstrap.min.js"></script>
      <!-- wow animation -->
      <script src="js/animate.js"></script>
      <!-- select country -->
      <script src="js/bootstrap-select.js"></script>
      <!-- owl carousel -->
      <script src="js/owl.carousel.js"></script> 
      <!-- chart js -->
      <script src="js/Chart.min.js"></script>
      <script src="js/Chart.bundle.min.js"></script>
      <script src="js/utils.js"></script>
      <script src="js/analyser.js"></script>
      <!-- nice scrollbar -->
      <script src="js/perfect-scrollbar.min.js"></script>
      <script>
         var ps = new PerfectScrollbar('#sidebar');
      </script>
      <!-- custom js -->
      <script src="js/custom.js"></script>
      <script src="js/chart_custom_style1.js"></script>
   </body>
</html>
