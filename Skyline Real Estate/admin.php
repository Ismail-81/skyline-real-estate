<?php
session_start();
include 'config.php';

// Only admin can access
if (!isset($_SESSION['admin'])) {
    header("Location: login.php");
    exit;
}

// Handle Delete property
if (isset($_GET['delete'])) {
    $id = intval($_GET['delete']);
    mysqli_query($conn, "DELETE FROM properties WHERE id = $id");
    header("Location: admin.php?msg=deleted");
    exit;
}

// Handle Approve request
if (isset($_GET['approve'])) {
    $request_id = intval($_GET['approve']);

    // Fetch request
    $res = mysqli_query($conn, "SELECT * FROM property_requests WHERE id = $request_id");
    $req = mysqli_fetch_assoc($res);

    if ($req) {
        if ($req['request_type'] == 'Add') {
            // Add property to properties table using uploaded image
            $ins = "INSERT INTO properties 
                    (title, description, price, location, image_path, category, type, sqrft, address, created_at)
                    VALUES
                    ('{$req['title']}', '{$req['description']}', {$req['price']}, '{$req['location']}', '{$req['image_path']}', '{$req['category']}', '{$req['type']}', {$req['sqrft']}, '{$req['address']}', NOW())";
            mysqli_query($conn, $ins);
        }
        // Update request status
        mysqli_query($conn, "UPDATE property_requests SET status='approved' WHERE id = $request_id");
    }
    header("Location: admin.php");
    exit;
}

// Handle Reject request
if (isset($_GET['reject'])) {
    $request_id = intval($_GET['reject']);
    mysqli_query($conn, "UPDATE property_requests SET status='rejected' WHERE id = $request_id");
    header("Location: admin.php");
    exit;
}

// Fetch all properties
$properties = mysqli_query($conn, "SELECT * FROM properties ORDER BY created_at DESC");

// Fetch all pending requests
$requests = mysqli_query($conn, "SELECT * FROM property_requests WHERE status='pending' ORDER BY created_at DESC");
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Panel | Skyline Estates</title>
    <link rel="icon" type="image/x-icon" href="images/Title.png">
    <link href="https://fonts.cdnfonts.com/css/blanka" rel="stylesheet">
    <style>
        body {
            font-family: 'Segoe UI', sans-serif;
            margin: 0;
            padding: 0;
            background: #f5f7fa;
        }

        .header {
            background: #fff;
            border-bottom: 2px solid #f0f0f0;
            padding: 0.5rem 0;
            position: fixed;
            width: 100%;
            top: 0;
            z-index: 1000;
            box-shadow: 0 3px 10px rgba(0, 0, 0, 0.05);
        }

        .nav-container {
            max-width: 1200px;
            margin: 0 auto;
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 0 1.5rem;
        }

       
    .logo {
      margin-left: -120px;
      display: flex;
      align-items: center;
      font-size: 2rem;
      color: #002446;
      font-family: 'Blanka', sans-serif;
      font-style: normal;
    }

        .lg {
            height: 80px;
            width: 150px;
            margin-right: 10px;
        }

        .nav-links {
            display: flex;
            gap: 1.5rem;
            align-items: center;
            margin-right: -120px;

        }

        .nav-links a {
            color: #002446;
            text-decoration: none;
            font-weight: 500;
            transition: 0.3s;
        }

        .nav-links a:hover {
            color: #17457a;
        }

        .auth-links {
            display: flex;
            align-items: center;
            gap: 0.8rem;
            margin-left: 1.5rem;
        }

        .container {
            max-width: 1200px;
            margin: 121px auto 50px;
            background: #fff;
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0 3px 10px rgba(0, 0, 0, 0.1);
        }

        h2 {
            text-align: center;
            color: #002446;
            background: #ffffff;
            border-radius: 8px;
            box-shadow: 0 0.5px 8px rgba(0, 0, 0, 0.2);
            padding: 10px 0;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }

        th,
        td {
            border: 1px solid #ddd;
            padding: 10px;
            text-align: left;
        }

        th {
            background: #002446;
            color: white;
        }

        img {
            width: 120px;
            border-radius: 6px;
        }

        .actions a {
            text-decoration: none;
            padding: 8px 12px;
            border-radius: 3px;
            width: 78%;
            text-align: center;
            margin: 2px;
            display: inline-block;
        }

        .edit-btn {
            background: #007bff;
            color: white;
        }

        .delete-btn {
            background: #dc3545;
            color: white;
        }

        .approve-btn {
            background: #28a745;
            color: white;
        }

        .reject-btn {
            background: #dc3545;
            color: white;
        }

        .add-btn {
            margin: 10px 0;
            display: inline-block;
        }

        .btn {
            padding: 0.5rem 1.2rem;
            border-radius: 6px;
            border: none;
            cursor: pointer;
            font-weight: 600;
            transition: 0.3s;
            text-decoration: none;
            display: inline-block;
        }

        .btn-primary {
            background: #002446;
            color: #fff !important;

        }

        .btn-primary:hover {
            background: #17457a;
            color: #fff !important;
        }



        /* Sidebar (fixed) */
        .sidebar {
            position: fixed;
            left: 0;
            top: 0;
            width: 230px;
            height: 100vh;
            /* background: #ffffff; */
            border-right: 1px solid #e6e6e6;
            padding-top: 120px;
            /* space for header */
            z-index: 900;
        }

        .sidebar .menu {
            display: flex;
            background: #ffffff;
            flex-direction: column;
            gap: 6px;
            padding: 12px 12px;
            height: 100%;
            border-radius: 8px;
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.04);
        }

        .sidebar a {
            display: block;
            padding: 12px 14px;
            color: #002446;
            text-decoration: none;
            font-weight: 600;
            border-radius: 6px;
        }

        .sidebar a:hover {
            background: #002446;
            color: #f0f4f8;
        }


        .container {
            margin-left: 250px;

        }


        .cards-grid {
            display: grid;
            grid-template-columns: repeat(3, 1fr);
            gap: 16px;
            margin-top: 12px;
        }

        .prop-card {
            background: #fff;
            border: 1px solid #e9eef3;
            border-radius: 8px;
            overflow: hidden;
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.04);
            display: flex;
            flex-direction: column;
            height: 100%;
        }

        .prop-card .image {
            width: 100%;
            height: 180px;
            object-fit: cover;
            background: #ddd;
        }

        .prop-card .body {
            padding: 12px;
            display: flex;
            flex-direction: column;
            gap: 6px;
            flex: 1;
        }

        .prop-title {
            font-weight: 700;
            color: #002446;
            font-size: 16px;
        }

        .prop-meta {
            color: #555;
            font-size: 14px;
        }

        .prop-row {
            display: flex;
            gap: 10px;
            flex-wrap: wrap;
            align-items: center;
        }

        .prop-actions {
            display: flex;
            gap: 8px;
            padding: 12px;
            border-top: 1px solid #f0f0f0;
            background: #fafafa;
        }

        .action-btn {
            flex: 1;
            padding: 8px;
            text-align: center;
            border-radius: 6px;
            text-decoration: none;
            color: #fff;
            font-weight: 700;
        }

        .action-edit {
            background: #002592;
        }

        .action-delete {
            background: #DC351F;
        }

        /* Requests card grid */
        .requests-grid {
            display: grid;
            grid-template-columns: repeat(3, 1fr);
            gap: 14px;
            margin-top: 12px;
        }

        .req-card {
            background: #fff;
            border: 1px solid #e9eef3;
            border-radius: 8px;
            padding: 12px 12px 0 12px;
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.04);
            display: flex;
            flex-direction: column;
            gap: 6px;
        }

        .req-row {
            font-size: 14px;
            color: #333;
        }

        .req-actions {
            display: flex;
            gap: 8px;
            padding: 12px;
            border-top: 1px solid #f0f0f0;
            background: #fafafa;
        }

        .req-btn {
            flex: 1;
            padding: 8px;
            text-align: center;
            border-radius: 6px;
            text-decoration: none;
            color: #fff;
            font-weight: 700;
        }

        .req-approve {
            background: #0a8526;
        }

        .req-reject {
            background: #ff0000;
        }

        /* Empty state */
        .empty {
            text-align: center;
            padding: 24px;
            color: #666;
            background: #fff;
            border-radius: 8px;
            border: 1px dashed #e0e0e0;
        }
        .footer {
            background: #002446;
            color: #fff;
            text-align: center;
            padding: 1.2rem;
            margin-top: 50px;
        }

        /* Responsive: switch to single column on small screens */
        @media (max-width: 992px) {

            .cards-grid,
            .requests-grid {
                grid-template-columns: repeat(2, 1fr);
            }
        }

        @media (max-width: 640px) {
            .sidebar {
                display: none;
            }

            .container {
                margin-left: 0;
                margin-top: 120px;
            }

            .cards-grid,
            .requests-grid {
                grid-template-columns: 1fr;
            }
        }
    </style>
</head>

<body>

    <header class="header">
        <nav class="nav-container">
            <div class="logo"><img src="images/logo.png" class="lg">Skyline Estates</div>
            <div class="nav-links">
                <a href="homepage.php">Home</a>
                <a href="properties.php">Properties</a>
                <a href="about.php">About</a>
                <a href="homepage.php#whyus">Why Choose Us</a>
                <a href="homepage.php#contact">Contact</a>
                <div class="auth-links">
                    <a href="logout.php" class="btn btn-primary" style="padding: 10.5px 15px;">Logout</a>
                </div>
            </div>
        </nav>
    </header>

    <!-- Sidebar-->
    <aside class="sidebar" aria-label="Admin menu">
        <div class="menu">
            <a href="admin.php">Dashboard</a>
            <a href="addProperty.php">Add Property</a>
            <a href="#properties">Properties</a>
            <a href="#requests">Requests</a>
            <!-- <a href="logout.php">Logout</a> -->
        </div>
    </aside>

    <!-- Main container -->
    <div class="container">

        <h2>Admin - Manage Properties</h2>
        <center><a href="addProperty.php" class="btn btn-primary add-btn">+ Add New Property</a></center>

        <!-- Properties  -->
        <section id="properties">
            <div class="cards-grid">
                <?php
                mysqli_data_seek($properties, 0);
                $prop_count = 0;
                while ($row = mysqli_fetch_assoc($properties)) {
                    $prop_count++;
                ?>
                    <div class="prop-card" role="article" aria-label="<?= htmlspecialchars($row['title']); ?>">
                        <img class="image" src="<?= htmlspecialchars($row['image_path']); ?>" alt="Property image">
                        <div class="body">
                            <div class="prop-title"><?= htmlspecialchars($row['title']); ?></div>
                            <div class="prop-row prop-meta">
                                <div><strong>Category:</strong> <?= htmlspecialchars($row['category']); ?></div>
                                <div><strong>Type:</strong> <?= htmlspecialchars($row['type'] ?? '-'); ?></div>
                            </div>
                            <div class="prop-row">
                                <div class="prop-meta"><strong>Price:</strong> ₹<?= number_format($row['price']); ?></div>
                                <div class="prop-meta"><strong>Area:</strong> <?= $row['sqrft'] ?? '-'; ?> sq.ft</div>
                            </div>
                            <div class="prop-row prop-meta"><strong>Location:</strong> <?= htmlspecialchars($row['location']); ?></div>
                            <div class="prop-row prop-meta"><strong>Address:</strong> <?= htmlspecialchars($row['address'] ?? '-'); ?></div>
                        </div>
                        <div class="prop-actions">
                            <a href="editProperty.php?id=<?= $row['id']; ?>" class="action-btn action-edit">Edit</a>
                            <a href="admin.php?delete=<?= $row['id']; ?>" onclick="return confirm('Are you sure you want to delete this property?');" class="action-btn action-delete">Delete</a>
                        </div>
                    </div>
                <?php } ?>

                <?php if ($prop_count == 0) { ?>
                    <div class="empty">No properties found. Add your first property!</div>
                <?php } ?>
            </div>
        </section>

        <!-- Requests  -->
        <section id="requests">
            <h2 style="margin-top:32px;color:#002446;">Pending Requests</h2>
            <div class="requests-grid">
                <?php
                mysqli_data_seek($requests, 0);
                $req_count = 0;
                while ($req = mysqli_fetch_assoc($requests)) {
                    $req_count++;
                    $price = '-';
                    $location = '-';
                    $sqrft = '-';
                    $address = '-';
                    $titleOrMsg = '-';

                    if ($req['request_type'] == 'Buy' && !empty($req['property_id'])) {
                        $prop_res = mysqli_query($conn, "SELECT price, location, sqrft, address FROM properties WHERE id=" . intval($req['property_id']));
                        $prop = mysqli_fetch_assoc($prop_res);
                        if ($prop) {
                            $price = '₹' . number_format($prop['price']);
                            $location = htmlspecialchars($prop['location']);
                            $sqrft = $prop['sqrft'] ?? '-';
                            $address = htmlspecialchars($prop['address'] ?? '-');
                        }
                        $titleOrMsg = htmlspecialchars($req['message']);
                    } elseif ($req['request_type'] == 'Add') {
                        $price = '₹' . number_format($req['price']);
                        $location = htmlspecialchars($req['location']);
                        $sqrft = $req['sqrft'] ?? '-';
                        $address = htmlspecialchars($req['address'] ?? '-');
                        $titleOrMsg = htmlspecialchars($req['title']);
                    }
                ?>
                    <div class="req-card" role="article" aria-label="Request <?= intval($req['id']); ?>">
                        <div class="req-row"><strong>Request ID:</strong> <?= intval($req['id']); ?></div>
                        <div class="req-row"><strong>Type:</strong> <?= ucfirst($req['request_type']); ?></div>
                        <div class="req-row"><strong>Title/Message:</strong> <?= $titleOrMsg; ?></div>
                        <div class="req-row"><strong>User ID:</strong> <?= htmlspecialchars($req['user_id'] ?? '-'); ?></div>
                        <div class="req-row"><strong>Price:</strong> <?= $price; ?></div>
                        <div class="req-row"><strong>Location:</strong> <?= $location; ?></div>
                        <div class="req-row"><strong>Area:</strong> <?= $sqrft; ?> sq.ft</div>
                        <div class="req-row"><strong>Address:</strong> <?= $address; ?></div>

                        <div class="req-actions">
                            <a href="admin.php?approve=<?= $req['id']; ?>" class="req-btn req-approve" onclick="return confirm('Approve this request?');">Approve</a>
                            <a href="admin.php?reject=<?= $req['id']; ?>" class="req-btn req-reject" onclick="return confirm('Reject this request?');">Reject</a>
                        </div>
                    </div>
                <?php } ?>

                <?php if ($req_count == 0) { ?>
                    <div class="empty">No pending requests at the moment.</div>
                <?php } ?>
            </div>
        </section>

        <footer class="footer" id="contact">
            <p>&copy; 2025 Skyline Estates. All rights reserved.</p>
        </footer>
    </div>

</body>

</html>