<?php 
session_start();

if (!isset($_SESSION['admin'])) {
    header("Location: login.php");
    exit();
}

$username = $_SESSION['admin'];

$url = "http://localhost/blood_api/api/admin_info.php?username=" . $username;
$response = file_get_contents($url);
$result = json_decode($response, true);

if (isset($result['status']) && $result['status'] == "success") {
    $admin = $result['data'];
} else {
    $error = "Failed to fetch admin info.";
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<title>Admin Dashboard</title>

<!-- Tailwind -->
<script src="https://cdn.tailwindcss.com"></script>

<!-- Font Awesome Icons -->
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">

<!-- DataTables -->
<link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/jquery.dataTables.min.css">
<script src="https://code.jquery.com/jquery-3.7.0.min.js"></script>
<script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>

<style>
body {
    font-family: 'Segoe UI', sans-serif;
}

/* Glass effect */
.glass {
    background: rgba(255,255,255,0.7);
    backdrop-filter: blur(10px);
}

/* DataTable search box */
.dataTables_wrapper .dataTables_filter input {
    border-radius: 8px;
    padding: 6px;
    border: 1px solid #ccc;
}
</style>
</head>
<body class="bg-gradient-to-br from-gray-100 to-gray-200">

<!-- MOBILE MENU BUTTON -->
<button id="menuBtn" 
    class="lg:hidden fixed top-4 left-4 z-50 bg-red-600 text-white p-2 rounded shadow">
    <i class="fa-solid fa-bars"></i>
</button>

<div class="flex">

    <!-- SIDEBAR -->
    <aside id="sidebar" 
    class="fixed lg:static w-64 bg-red-600 text-white min-h-screen p-5 shadow-lg 
    transform -translate-x-full lg:translate-x-0 transition-transform duration-300 z-40">

        <h2 class="text-2xl font-bold mb-8">
            <i class="fa-solid fa-droplet"></i> Blood Admin
        </h2>

        <nav class="space-y-4">
            <a href="#" class="block hover:bg-red-700 p-2 rounded">
                <i class="fa-solid fa-chart-line mr-2"></i> Dashboard
            </a>

            <a href="#" class="block hover:bg-red-700 p-2 rounded">
                <i class="fa-solid fa-users mr-2"></i> Donors
            </a>

            <a href="#" class="block hover:bg-red-700 p-2 rounded">
                <i class="fa-solid fa-hospital mr-2"></i> Requests
            </a>

            <a href="logout.php" class="block hover:bg-red-700 p-2 rounded">
                <i class="fa-solid fa-right-from-bracket mr-2"></i> Logout
            </a>
        </nav>
    </aside>

    <!-- OVERLAY FOR MOBILE -->
    <div id="overlay" 
    class="fixed inset-0 bg-black bg-opacity-40 hidden z-30 lg:hidden"></div>

    <!-- MAIN CONTENT -->
    <main class="flex-1 p-4 lg:p-6 w-full">

        <!-- TOP BAR -->
        <div class="flex flex-col sm:flex-row sm:justify-between sm:items-center gap-3 mb-6">
            <h1 class="text-xl sm:text-2xl font-semibold text-gray-700">
                Dashboard
            </h1>

            <div class="flex items-center gap-2">
                <i class="fa-solid fa-user-circle text-xl sm:text-2xl text-gray-600"></i>
                <span class="text-sm sm:text-base"><?php echo htmlspecialchars($username); ?></span>
            </div>
        </div>

        <!-- PROFILE CARD -->
        <div class="glass p-6 rounded-xl shadow mb-6">
            <h2 class="text-lg font-semibold mb-4">
                <i class="fa-solid fa-user mr-2"></i> Admin Profile
            </h2>

            <?php if (isset($admin)): ?>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <p><strong>Name:</strong> <?php echo htmlspecialchars($admin['full_name']); ?></p>
                    <p><strong>Username:</strong> <?php echo htmlspecialchars($admin['username']); ?></p>
                    <p><strong>Email:</strong> <?php echo htmlspecialchars($admin['email']); ?></p>
                    <p><strong>Phone:</strong> <?php echo htmlspecialchars($admin['phone']); ?></p>
                </div>
            <?php else: ?>
                <div class="text-red-500"><?php echo $error; ?></div>
            <?php endif; ?>
        </div>

        <!-- HEADER -->
        <div class="flex justify-between items-center mb-4">
            <h2 class="text-lg font-semibold">
                <i class="fa-solid fa-users mr-2"></i> Donor List
            </h2>

            <a href="add_donor.php" 
               class="bg-green-600 text-white px-4 py-2 rounded-lg shadow hover:bg-green-700">
               <i class="fa-solid fa-plus"></i> Add Donor
            </a>
        </div>

        <!-- TABLE -->
        <div class="glass p-4 rounded-xl shadow overflow-x-auto">
            <table id="donorTable" class="display w-full text-sm">
                <thead>
                    <tr class="bg-red-600 text-white">
                        <th>ID</th>
                        <th>Name</th>
                        <th>Blood</th>
                        <th>City</th>
                        <th>Phone</th>
                        <th>Date</th>
                        <th>Actions</th>
                    </tr>
                </thead>

                <tbody>
                <?php 
                $data = json_decode(file_get_contents("http://localhost/blood_api/api/donors"), true);

                if (!empty($data['data'])):
                    foreach($data['data'] as $donor):
                ?>
                    <tr>
                        <td><?php echo $donor['id']; ?></td>
                        <td><?php echo $donor['name']; ?></td>

                        <td>
                            <span class="bg-red-500 text-white px-3 py-1 rounded-full text-sm">
                                <?php echo $donor['blood_type']; ?>
                            </span>
                        </td>

                        <td><?php echo $donor['city']; ?></td>
                        <td><?php echo $donor['phone']; ?></td>
                        <td><?php echo $donor['last_donation_date']; ?></td>

                        <td>
                            <div class="flex flex-wrap gap-2">
                                <a href="edit_donor.php?id=<?php echo $donor['id']; ?>" 
                                   class="bg-blue-500 text-white px-2 py-1 rounded hover:bg-blue-600">
                                   <i class="fa-solid fa-pen"></i>
                                </a>

                                <a href="delete_donor.php?id=<?php echo $donor['id']; ?>" 
                                   onclick="return confirm('Are you sure?')"
                                   class="bg-red-500 text-white px-2 py-1 rounded hover:bg-red-600">
                                   <i class="fa-solid fa-trash"></i>
                                </a>
                            </div>
                        </td>
                    </tr>
                <?php endforeach; endif; ?>
                </tbody>
            </table>
        </div>

    </main>

</div>

<!-- SIDEBAR TOGGLE SCRIPT -->
<script>
const menuBtn = document.getElementById('menuBtn');
const sidebar = document.getElementById('sidebar');
const overlay = document.getElementById('overlay');

menuBtn.addEventListener('click', () => {
    sidebar.classList.toggle('-translate-x-full');
    overlay.classList.toggle('hidden');
});

overlay.addEventListener('click', () => {
    sidebar.classList.add('-translate-x-full');
    overlay.classList.add('hidden');
});
</script>

<!-- DataTable Init -->
<script>
$(document).ready(function () {
    $('#donorTable').DataTable({
        pageLength: 5,
        lengthMenu: [5, 10, 25, 50]
    });
});
</script>

</body>
</html>