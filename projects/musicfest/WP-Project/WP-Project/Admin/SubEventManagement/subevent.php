<?php
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

// Check if admin is logged in
if (!isset($_SESSION["admin_email"])) {
  $page = 'xAdminSession';
  include 'sessionError.php';
  exit();
}
$admin = $_SESSION["admin_email"];

// Connect to the database
$conn = new mysqli("localhost", "root", "", "music_festival");
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Insert data when form is submitted
if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $name = $_POST["subevent_name"];
    $day = $_POST["day"];
    $time = $_POST["time"];
    $place = $_POST["place"];
    $organizer = $_POST["organizer"];
    $description = $_POST["description"];

    $stmt = $conn->prepare("INSERT INTO subevent (subevent_name, event_day, event_time, place, organizer, description) VALUES (?, ?, ?, ?, ?, ?)");
    $stmt->bind_param("ssssss", $name, $day, $time, $place, $organizer, $description);
    
    if ($stmt->execute()) {
        $_SESSION['success_message'] = "Sub event added successfully!";
    } else {
        $_SESSION['error_message'] = "Error adding sub event: " . $stmt->error;
    }
    $stmt->close();
    header("Location: ".$_SERVER['PHP_SELF']);
    exit();
}

// Fetch all events
$events = $conn->query("SELECT * FROM subevent ORDER BY event_day, event_time ASC");

$page = "subevent";
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sub Event Management</title>
    
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
                        'table-header-light': '#f3e8ff',
                        'table-header-dark': '#4c1d95',
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
        <?php include 'sidebar.php'; ?>
      </aside>
    </div>
    
    <!-- Main Content -->
    <div class="container-receipt my-5 px-10 mt-10 w-full">
      <h2 class="heading-receipt border-l-4 border-yellow-400 pl-4 text-2xl font-bold text-gray-800 dark:text-white mb-6">Sub Event Management</h2>
      
      <!-- Add New Event Form -->
      <div class="bg-white dark:bg-gray-800 rounded-lg shadow p-6 mb-8">
        <h3 class="text-lg font-semibold text-gray-800 dark:text-white mb-4">Add New Sub Event</h3>
        <form method="POST" class="space-y-4">
          <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
            <div>
              <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Event Name</label>
              <input type="text" name="subevent_name" placeholder="Sub Event Name" required
                class="w-full px-3 py-2 border rounded-lg focus:ring-2 focus:ring-purple-custom focus:border-purple-custom dark:bg-gray-700 dark:border-gray-600 dark:text-white">
            </div>
            <div>
              <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Date</label>
              <input type="date" name="day" required
                class="w-full px-3 py-2 border rounded-lg focus:ring-2 focus:ring-purple-custom focus:border-purple-custom dark:bg-gray-700 dark:border-gray-600 dark:text-white">
            </div>
            <div>
              <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Time</label>
              <input type="time" name="time" required
                class="w-full px-3 py-2 border rounded-lg focus:ring-2 focus:ring-purple-custom focus:border-purple-custom dark:bg-gray-700 dark:border-gray-600 dark:text-white">
            </div>
            <div>
              <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Location</label>
              <input type="text" name="place" placeholder="Venue" required
                class="w-full px-3 py-2 border rounded-lg focus:ring-2 focus:ring-purple-custom focus:border-purple-custom dark:bg-gray-700 dark:border-gray-600 dark:text-white">
            </div>
            <div>
              <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Organizer</label>
              <input type="text" name="organizer" placeholder="Organizer" required
                class="w-full px-3 py-2 border rounded-lg focus:ring-2 focus:ring-purple-custom focus:border-purple-custom dark:bg-gray-700 dark:border-gray-600 dark:text-white">
            </div>
          </div>
          <div>
            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Description</label>
            <textarea name="description" placeholder="Event description..." required rows="3"
              class="w-full px-3 py-2 border rounded-lg focus:ring-2 focus:ring-purple-custom focus:border-purple-custom dark:bg-gray-700 dark:border-gray-600 dark:text-white"></textarea>
          </div>
          <button type="submit" 
            class="bg-purple-custom hover:bg-purple-700 text-white font-medium py-2 px-4 rounded-lg transition duration-300">
            Save Event
          </button>
        </form>
      </div>
      
      <!-- Events Table -->
      <div class="rounded-lg overflow-hidden">
        <table class="custom-table w-full">
          <thead>
            <tr>
              <th class="text-gray-700 dark:text-gray-300">Name</th>
              <th class="text-gray-700 dark:text-gray-300">Date</th>
              <th class="text-gray-700 dark:text-gray-300">Time</th>
              <th class="text-gray-700 dark:text-gray-300">Location</th>
              <th class="text-gray-700 dark:text-gray-300">Organizer</th>
              <th class="text-gray-700 dark:text-gray-300">Description</th>
              <th class="text-gray-700 dark:text-gray-300">Actions</th>
            </tr>
          </thead>
          <tbody>
            <?php if ($events->num_rows > 0): ?>
              <?php while ($row = $events->fetch_assoc()): ?>
                <tr class="text-gray-900 dark:text-white">
                  <td><?= htmlspecialchars($row['subevent_name']) ?></td>
                  <td><?= htmlspecialchars($row['event_day']) ?></td>
                  <td><?= htmlspecialchars($row['event_time']) ?></td>
                  <td><?= htmlspecialchars($row['place']) ?></td>
                  <td><?= htmlspecialchars($row['organizer']) ?></td>
                  <td class="truncate max-w-[200px]"><?= htmlspecialchars($row['description']) ?></td>
                  <td>
                    <form method="POST" action="/WP-Project/Admin/SubEventManagement/php2.php" onsubmit="return confirm('Are you sure you want to delete this event?');">
                      <input type="hidden" name="id" value="<?= $row['id'] ?>">
                      <button type="submit" class="text-red-600 hover:text-red-900 dark:text-red-400 dark:hover:text-red-300 font-medium">
                        Delete
                      </button>
                    </form>
                  </td>
                </tr>
              <?php endwhile; ?>
            <?php else: ?>
              <tr>
                <td colspan="7" class="text-center py-4 text-gray-500 dark:text-gray-400">No sub events found.</td>
              </tr>
            <?php endif; ?>
          </tbody>
        </table>
      </div>
    </div>
  </div>
</body>
</html>