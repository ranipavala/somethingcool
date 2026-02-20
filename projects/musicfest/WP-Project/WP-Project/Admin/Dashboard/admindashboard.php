<?php 
// Start the session
session_start();
// Display success/error messages if they exist
$alertClasses = [
  'error' => 'bg-red-100 border-red-400 text-red-700',
  'success' => 'bg-green-100 border-green-400 text-green-700'
];

if (isset($_SESSION['error_message'])) {
  echo '<div class="'.$alertClasses['error'].' px-4 py-3 rounded relative mb-4" role="alert">
          <span class="block sm:inline">'.htmlspecialchars($_SESSION['error_message']).'</span>
          <span class="absolute top-0 bottom-0 right-0 px-4 py-3" onclick="this.parentElement.remove()">
              <svg class="fill-current h-6 w-6" role="button" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20">
                  <title>Close</title>
                  <path d="M14.348 14.849a1.2 1.2 0 0 1-1.697 0L10 11.819l-2.651 3.029a1.2 1.2 0 1 1-1.697-1.697l2.758-3.15-2.759-3.152a1.2 1.2 0 1 1 1.697-1.697L10 8.183l2.651-3.031a1.2 1.2 0 1 1 1.697 1.697l-2.758 3.152 2.758 3.15a1.2 1.2 0 0 1 0 1.698z"/>
              </svg>
          </span>
        </div>';
  unset($_SESSION['error_message']);
}

if (isset($_SESSION['success_message'])) {
  echo '<div class="'.$alertClasses['success'].' px-4 py-3 rounded relative mb-4" role="alert">
          <span class="block sm:inline">'.htmlspecialchars($_SESSION['success_message']).'</span>
          <span class="absolute top-0 bottom-0 right-0 px-4 py-3" onclick="this.parentElement.remove()">
              <svg class="fill-current h-6 w-6" role="button" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20">
                  <title>Close</title>
                  <path d="M14.348 14.849a1.2 1.2 0 0 1-1.697 0L10 11.819l-2.651 3.029a1.2 1.2 0 1 1-1.697-1.697l2.758-3.15-2.759-3.152a1.2 1.2 0 1 1 1.697-1.697L10 8.183l2.651-3.031a1.2 1.2 0 1 1 1.697 1.697l-2.758 3.152 2.758 3.15a1.2 1.2 0 0 1 0 1.698z"/>
              </svg>
          </span>
        </div>';
  unset($_SESSION['success_message']);
}

// Check if the session variable 'admin_email' exists
if (!isset($_SESSION["admin_email"])) {
  $page = 'xAdminSession';
  include 'sessionError.php';
  exit();
}
$admin = $_SESSION["admin_email"]; // Assign session value to admin

$con = mysqli_connect("localhost", "root", "", "music_festival") or die("Cannot connect to server." . mysqli_error($con));

$search = isset($_GET['search']) ? mysqli_real_escape_string($con, $_GET['search']) : '';

$searchCondition = '';
if (!empty($search)) {
    $searchCondition = "WHERE u.fullname LIKE '%$search%' OR u.email LIKE '%$search%'";
}

$sql = "SELECT 
            u.*,
            GROUP_CONCAT(er.ticket_type SEPARATOR ', ') AS ticket_types
        FROM 
            users u
        LEFT JOIN 
            event_registrations er ON u.userID = er.userID
        $searchCondition
        GROUP BY 
            u.userID";

$result = mysqli_query($con, $sql) or die("Cannot execute SQL: " . mysqli_error($con));
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard</title>

    <!-- Tailwind CSS -->
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
          darkMode: 'class',
          theme: {
            extend: {
              colors: {
                'purple-custom': '#9b59b6',
                'yellow-custom': '#f4d03f',
                'table-header-light': '#f3e8ff', // Light purple
                'table-header-dark': '#4c1d95', // Dark purple
                'table-row-light': '#ffffff',
                'table-row-dark': '#1f2937',
                'table-hover-light': '#f5f3ff',
                'table-hover-dark': '#111827',
              },
              backgroundImage: {
                'p-y-gradient': 'linear-gradient(to bottom, #9b59b6, #f4d03f)',
              }
            }
          }
        }
    </script>

    <!-- Alpine.js for interactivity -->
    <script src="https://unpkg.com/alpinejs" defer></script>
    <link href="style.css" rel="stylesheet">
    
    <style>
        .custom-table {
            width: 100%;
            border-collapse: separate;
            border-spacing: 0;
            box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1), 0 2px 4px -1px rgba(0, 0, 0, 0.06);
        }
        
        .custom-table thead th {
            font-weight: 600;
            text-transform: uppercase;
            letter-spacing: 0.05em;
            padding: 1rem;
            text-align: left;
            background-color: #f3e8ff;
        }
        
        .dark .custom-table thead th {
            background-color: #4c1d95;
        }
        
        .custom-table tbody td {
            padding: 1rem;
            border-bottom: 1px solid #e5e7eb;
            background-color: #ffffff;
        }
        
        .dark .custom-table tbody td {
            border-bottom-color: #374151;
            background-color: #1f2937;
        }
        
        .custom-table tbody tr:hover td {
            background-color: #f5f3ff;
        }
        
        .dark .custom-table tbody tr:hover td {
            background-color: #111827;
        }
        
    </style>
</head>

<body x-data="{ open: true, darkMode: false, openLogoutModal: false }" :class="darkMode ? 'dark' : ''">
  <div class="relative flex bg-p-y-gradient dark:bg-gray-900 min-h-screen">
    <!-- Sidebar Navigation -->
    <div class="relative flex">
      <aside class="sidebar-container fixed h-full">
        <?php
            $page = 'dashboard';
            include 'sidebar.php';
        ?>
      </aside>
    </div>
    
    <!-- Main Content -->
    <div class="container-receipt my-5 px-10 mt-10">
      <h2 class="heading-receipt border-l-4 border-yellow-400 pl-4 text-2xl font-bold text-gray-800 dark:text-white mb-6">Registered Users</h2>

        <!-- Search Form -->
        <div class="mb-6">
            <form method="GET" class="flex items-center">
                <div class="relative w-full max-w-md">
                    <input 
                        type="text" 
                        name="search" 
                        placeholder="Search by name or email..." 
                        value="<?= htmlspecialchars($search) ?>"
                        class="w-full pl-10 pr-4 py-2 border rounded-lg focus:ring-2 focus:ring-purple-custom focus:border-purple-custom dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white"
                    />
                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                        <svg class="h-5 w-5 text-gray-400" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M8 4a4 4 0 100 8 4 4 0 000-8zM2 8a6 6 0 1110.89 3.476l4.817 4.817a1 1 0 01-1.414 1.414l-4.816-4.816A6 6 0 012 8z" clip-rule="evenodd"></path>
                        </svg>
                    </div>
                </div>
                <button type="submit" class="ml-2 bg-purple-custom hover:bg-purple-700 text-white font-medium py-2 px-4 rounded-lg transition duration-300">
                    Search
                </button>
            </form>
        </div>

        <!-- Users Table -->
        <div class="rounded-lg overflow-hidden">
            <table class="custom-table w-full">
                <thead>
                    <tr>
                        <th class="text-gray-700 dark:text-gray-300">Full Name</th>
                        <th class="text-gray-700 dark:text-gray-300">Email</th>
                        <th class="text-gray-700 dark:text-gray-300">Contact No</th>
                        <th class="text-gray-700 dark:text-gray-300">IC/PassPort</th>
                        <th class="text-gray-700 dark:text-gray-300">Ticket Type</th>
                        <th class="text-gray-700 dark:text-gray-300">Action</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (mysqli_num_rows($result) > 0): ?>
                        <?php while($row = mysqli_fetch_assoc($result)): ?>
                            <tr class="text-gray-900 dark:text-white">
                                <td class="truncate max-w-[200px]"><?= htmlspecialchars($row['fullname']) ?></td>
                                <td class="truncate max-w-[200px]"><?= htmlspecialchars($row['email']) ?></td>
                                <td><?= htmlspecialchars($row['contact']) ?></td>
                                <td><?= htmlspecialchars($row['ic']) ?></td>
                                <td><?= !empty($row['ticket_types']) ? htmlspecialchars($row['ticket_types']) : 'No tickets purchased' ?></td>
                                <td>
                                    <form method="POST" action="php1.php" onsubmit="return confirm('Are you sure to delete this user?');">
                                        <input type="hidden" name="id" value="<?= $row['userID'] ?>">
                                        <button type="submit" class="text-red-600 hover:text-red-900 dark:text-red-400 dark:hover:text-red-300 font-medium">
                                            Delete
                                        </button>
                                    </form>
                                </td>
                            </tr>
                        <?php endwhile; ?>
                    <?php else: ?>
                        <tr>
                            <td colspan="6" class="text-center py-4 text-gray-500 dark:text-gray-400">No registered users found.</td>
                        </tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>
  </div>
</body>
</html>