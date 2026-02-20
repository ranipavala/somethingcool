<?php
  // Start the session
  session_start();
  // Check if the session variable 'email' exists
  if (!isset($_SESSION["email"])) {
    $page = 'xSession';
    include 'sessionError.php';
    exit();
  }
  $user = $_SESSION["email"]; // Assign session value to $user
  $con=mysqli_connect("localhost", "root", "","music_festival") or die("Cannot connect to server.".mysqli_error($con));
  $id = $_SESSION["email"];
  $sql="SELECT * FROM users WHERE email='$id'";
  $result=mysqli_query($con,$sql) or die("Cannot execute sql.");
  $row=mysqli_fetch_array($result,MYSQLI_BOTH);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>User Profile</title>

    <!-- Tailwind CSS -->
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            darkMode: 'class',
        }
    </script>

    <!-- Alpine.js for interactivity -->
    <script src="https://unpkg.com/alpinejs" defer></script>
    
    <script>
        tailwind.config = {
          darkMode: 'class',
          theme: {
            extend: {
              colors: {
                'purple-custom': '#9b59b6',
                'yellow-custom': '#f4d03f'
              },
              backgroundImage: {
                'p-y-gradient': 'linear-gradient(to bottom, #9b59b6, #f4d03f)',
              }
            }
          }
        }
    </script>

    <link rel="stylesheet" href="style.css">
</head>

<!--Template from Tailwind-->
<body x-data="{ open: true, darkMode: false, openLogoutModal: false }" :class="darkMode ? 'dark' : ''">
    <div class="relative flex bg-p-y-gradient dark:bg-gray-900">
        <!-- Sidebar Navigation-->
        <div class="relative flex">
            <aside class="sidebar-container">
            <?php
              $page = 'userProfile';
              include 'sidebar.php';
            ?>
            </aside>
        </div>
        
        <div class="container-receipt my-5 px-10 mt-10">
          <h2 class="heading-receipt border-l-4 border-yellow-400 pl-4">Update User Profile</h2>
          <h6 class="mt-2 mb-5 text-lg" style="font-family: 'Josefin Sans', sans-serif;">Modify your information by clicking on the relevant fields.</h6>
          <h6 class="mt-2 mb-5 text-lg" style="font-family: 'Josefin Sans', sans-serif;"># indicates a read-only field</h6>

          <div class="receipt-card">
              <div class="card-body">

      <form name="userUpdate" method="post" action="user_updateData.php">
        
        <div class="row">
          <div class="col-sm-3">
            <h6 class="mb-0">User ID #</h6>
          </div>
          <div class="col-sm-9 text-secondary">
            <input name="userid" type="text" value="<?php echo $row[0]; ?>" readonly class="form-control">
          </div>
        </div>
        <hr>

        <div class="row">
          <div class="col-sm-3">
            <h6 class="mb-0">Fullname</h6>
          </div>
          <div class="col-sm-9 text-secondary">
            <input name="fullname" type="text" value="<?php echo $row[1]; ?>" class="form-control">
          </div>
        </div>
        <hr>

        <div class="row">
          <div class="col-sm-3">
            <h6 class="mb-0">Contact</h6>
          </div>
          <div class="col-sm-9 text-secondary">
            <input name="contact" type="text" value="<?php echo $row[4]; ?>" class="form-control">
          </div>
        </div>
        <hr>

        <div class="row">
          <div class="col-sm-3">
            <h6 class="mb-0">Password</h6>
          </div>
          <div class="col-sm-9 text-secondary">
            <input name="password" type="text" value="<?php echo $row[6]; ?>" class="form-control">
          </div>
        </div>
        <hr>
        <div class="mt-6 text-end">
      <button type="submit" class="bg-purple-custom hover:bg-purple-700 text-white font-bold py-3 px-4 rounded-lg transition duration-300">
        Submit
      </button>
    </div>
      </form>
    </div>
  </div>
</div>


</body> 
</html>