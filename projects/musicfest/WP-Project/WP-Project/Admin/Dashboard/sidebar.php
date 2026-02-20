<link rel="stylesheet" href="style.css">
<!-- Sidebar Navigation-->
<aside class="flex flex-col w-64 h-screen px-4 py-8 overflow-y-auto bg-white opacity-85 border-r dark:bg-gray-900 dark:border-gray-700">
    <!--Display admin basic info-->
    <div class="flex flex-col items-center mt-6 px-4 text-center">
        <h1 class="text-hi">Hello! Admin</h1>
        <!--Display welcome message-->
        <h4 class="mt-2 text-user"><?php echo $admin; ?></h4>
    </div>              

    <div class="flex flex-col justify-between flex-1 mt-10">
        <nav>
            <!--ADMIN Dashboard section-->
            <a class="flex items-center px-4 py-2 rounded-lg 
                <?php if ($page == 'dashboard') { ?>
                    text-gray-700 bg-gray-100 dark:bg-gray-800 dark:text-gray-200
                <?php } else { ?>
                    text-gray-600 transition-colors duration-300 transform dark:text-gray-400 hover:bg-gray-100 dark:hover:bg-gray-800 dark:hover:text-gray-200 hover:text-gray-700
                <?php } ?>" 
                href="/WP-Project/Admin/Dashboard/admindashboard.php">

                <!-- SVG Icon -->
                <svg class="w-5 h-5" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <path d="M19 11H5M19 11C20.1046 11 21 11.8954 21 13V19C21 20.1046 20.1046 21 19 21H5C3.89543 21 3 20.1046 3 19V13C3 11.8954 3.89543 11 5 11M19 11V9C19 7.89543 18.1046 7 17 7M5 11V9C5 7.89543 5.89543 7 7 7M7 7V5C7 3.89543 7.89543 3 9 3H15C16.1046 3 17 3.89543 17 5V7M7 7H17" 
                          stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                </svg>
                <span class="mx-4 font-medium">Dashboard</span>
            </a>

            <!--ADMIN Add Sub Event section-->
            <a class="flex items-center px-4 py-2 mt-5 rounded-lg 
                <?php if ($page == 'subevent') { ?>
                    text-gray-700 bg-gray-100 dark:bg-gray-800 dark:text-gray-200
                <?php } else { ?>
                    text-gray-600 transition-colors duration-300 transform dark:text-gray-400 hover:bg-gray-100 dark:hover:bg-gray-800 dark:hover:text-gray-200 hover:text-gray-700
                <?php } ?>" 
                href="/WP-Project/Admin/SubEventManagement/subevent.php">
                
                <svg class="w-5 h-5" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <path d="M12 5V19M5 12H19" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                    <path d="M3 10H21V8C21 6.89543 20.1046 6 19 6H5C3.89543 6 3 6.89543 3 8V10Z" 
                          stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                </svg>
                <span class="mx-4 font-medium">Sub Event Management</span>
            </a>

            <!--ADMIN Accounts section-->
            <a class="flex items-center px-4 py-2 mt-5 rounded-lg 
                <?php if ($page == 'account') { ?>
                    text-gray-700 bg-gray-100 dark:bg-gray-800 dark:text-gray-200
                <?php } else { ?>
                    text-gray-600 transition-colors duration-300 transform dark:text-gray-400 hover:bg-gray-100 dark:hover:bg-gray-800 dark:hover:text-gray-200 hover:text-gray-700
                <?php } ?>" 
                href="/WP-Project/Admin/Account/adminProfile.php">

                <!-- SVG Icon -->
                <svg class="w-5 h-5" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <path d="M16 7C16 9.20914 14.2091 11 12 11C9.79086 11 8 9.20914 8 7C8 4.79086 9.79086 3 12 3C14.2091 3 16 4.79086 16 7Z" 
                          stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                    <path d="M12 14C8.13401 14 5 17.134 5 21H19C19 17.134 15.866 14 12 14Z" 
                          stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                </svg>
                <span class="mx-4 font-medium">Accounts</span>
            </a>
              
            <!--ADMIN Logout section-->
                <button @click="openLogoutModal = true" class="flex items-center w-full px-4 py-2 mt-5 text-gray-600 transition-colors duration-300 transform rounded-lg dark:text-gray-400 hover:bg-red-100 dark:hover:bg-red-800 dark:hover:text-white hover:text-red-700">
                  <!-- Logout Icon -->
                    <svg class="w-5 h-5 text-red-500" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                      <path stroke-linecap="round" stroke-linejoin="round" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a2 2 0 01-2 2H7a2 2 0 01-2-2V7a2 2 0 012-2h4a2 2 0 012 2v1" />
                    </svg>
                    <span class="mx-4 font-medium text-red-600">Logout</span>
                </button>

              </nav>
          </div>
    
    <footer class="mt-7 text-sm text-gray-400 dark:text-gray-500">
        <p class="text-gray-600 dark:text-gray-300">&copy; 2025 vibe divas | Terms of Service</p>
    </footer>
</aside>

 <!-- Logout Modal to confirm if the user wants to log out -->
   <div x-show="openLogoutModal" x-cloak class="fixed inset-0 z-50 flex items-center justify-center bg-black bg-opacity-50">
        <div @click.away="openLogoutModal = false" class="bg-white dark:bg-gray-800 rounded-lg shadow-lg w-96 p-6">
          <div class="flex items-center justify-between mb-4">
            <h2 class="text-xl font-semibold text-gray-800 dark:text-gray-100">Logout</h2>
            <button @click="openLogoutModal = false" class="text-gray-500 hover:text-gray-800 dark:hover:text-gray-300">&times;</button>
          </div>
          <p class="text-gray-700 dark:text-gray-300">You are about to log out. Are you sure?</p>
          <div class="flex justify-end mt-6">
            <button @click="openLogoutModal = false" class="px-4 py-2 mr-2 text-sm text-gray-600 bg-gray-200 rounded hover:bg-gray-300 dark:bg-gray-700 dark:text-gray-300 dark:hover:bg-gray-600">Cancel</button>
            <a href="/WP-Project/Admin/Logout/admin_logout.php" class="px-4 py-2 text-sm text-white bg-red-600 rounded hover:bg-red-700">Logout</a>
          </div>
        </div>
  </div>