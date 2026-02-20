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
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>User Dashboard</title>

    <!-- Tailwind CSS -->
    <script src="https://cdn.tailwindcss.com"></script>
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
              },
            }
          }
        }
    </script>
    <!--link to external style sheet-->
    <link rel="stylesheet" href="card.css">
    <link rel="stylesheet" href="style.css">
</head>

<!--Template from Tailwind-->
<body x-data="{ open: true, darkMode: false, openLogoutModal: false }" :class="darkMode ? 'dark' : ''">
    <div class="relative min-h-screen flex bg-p-y-gradient dark:bg-gray-900">
        <!-- Sidebar Navigation-->
        <div class="relative flex">
            <aside class="sidebar-container">
            <?php
              $page = 'dashboard';
              include 'sidebar.php';
            ?>
            </aside>
        </div>
        <!--Main Content-->
        <div class="mt-10 px-10">
          <!-- Title Section -->
          <h2 class="heading-receipt border-l-4 border-yellow-400 pl-4 mb-10 font-josefin">Don't Miss These</h2>
          <!-- Cards Section -->
          <div class="flex flex-wrap gap-10">
            <!-- Card 1 -->
            <article class="card">
              <img class="card__background" src="UDS3.jpg" alt="Photo" width="1920" height="2193"/>
              <div class="card__content | flow">
                <div class="card__content--container | flow">
                  <h2 class="card__title text-white">SUNSET BEACH BASH</h2>
                  <p class="text-white">"Where waves meet beats—sun, sand & sound collide"</p>
                </div>
                <button class="card__button">Buy Now<button>
              </div>
            </article>

            <!-- Card 2 -->
            <article class="card">
              <img class="card__background" src="UDS1.jpg" alt="Photo" width="1920" height="2193"/>
              <div class="card__content | flow">
                <div class="card__content--container | flow">
                  <h2 class="card__title text-white">MONSTER ROCK FEST</h2>
                  <p class="text-white">"Where eardrums go to die — pure rock madness unleashed"</p>
                </div>
                <button class="card__button">Buy Now</button>
              </div>
            </article>

            <!-- Card 3 -->
            <article class="card">
              <img class="card__background" src="UDS2.jpg" alt="Photo" width="1920" height="2193"/>
              <div class="card__content | flow">
                <div class="card__content--container | flow">
                  <h2 class="card__title text-white">ECHOES OF JAZZ</h2>
                  <p class="text-white">"Where smooth jazz meets soft lights and timeless vibes"</p>
                </div>
                <button class="card__button">Buy Now</button>
              </div>
            </article>
        </div>
      </div>
    </div>
</body>
</html>
