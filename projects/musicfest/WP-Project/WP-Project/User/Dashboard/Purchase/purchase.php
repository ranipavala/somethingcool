<?php 
    // Start the session
    session_start();
    // Check if the session variable 'email' exists
    if (!isset($_SESSION["email"])) {
        $page = 'xSession'; // Redirect page for session error
        include 'sessionError.php'; // Include session error page
        exit(); // Include session error page
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
    // Custom Tailwind configuration
    tailwind.config = {
      darkMode: 'class', // Enables dark mode using class
      theme: {
        extend: {
          colors: {
            'purple-custom': '#9b59b6',
            'yellow-custom': '#f4d03f',
            'zone-a': '#ef4444',
            'zone-b': '#3b82f6',
            'zone-c': '#10b981'
          },
          backgroundImage: {
            'p-y-gradient': 'linear-gradient(to bottom, #9b59b6, #f4d03f)', // Gradient for background
          },
        }
      }
    }
</script>
    <!-- External Stylesheet -->
    <link rel="stylesheet" href="../../../Common/style.css">
</head>
<body x-data="{ open: true, darkMode: false, openLogoutModal: false }" :class="darkMode ? 'dark' : ''">
    <div class="relative flex bg-p-y-gradient dark:bg-gray-900">
        <!-- Sidebar Navigation-->
        <div class="relative flex">
            <aside class="sidebar-container">
                <?php
                    $page = 'purchase'; // Specify the current page
                    include 'sidebar.php'; // Include the sidebar
                ?>
            </aside>
        </div>  
      <!-- Main Content Area -->
      <main class="main-content p-6 mt-6">
            <div class="container mx-auto px-4">
                <!-- Event Header Section-->
                <div class="text-center mb-10">
                    <h2 class="heading-receipt border-l-4 border-yellow-400 pl-4 mb-10 font-josefin">Buy Ticket - Purello: Rasa Gila, Sound Gempak</h2>
                </div>

                <!-- Event Poster Section-->
                <div class="flex justify-center mb-10">
                    <img src="WEB_prog_POSTER.png" alt="Event Poster" class="rounded-xl shadow-lg max-w-full h-auto" style="max-height: 500px;">
                </div>

                <!-- Pricing and Info Section -->
                <div class="grid grid-cols-1 lg:grid-cols-2 gap-8 mb-10">
                    <!-- Pricing Card Section-->
                    <div class="bg-white dark:bg-gray-800 rounded-xl shadow-md p-6">
                        <h3 class="text-xl font-semibold text-gray-800 dark:text-white mb-4">Ticket Pricing</h3>
                        <img src="TicketPriceTable.png" alt="Ticket Pricing" class="w-full rounded-lg mb-4">
                        
                        <div class="bg-purple-50 dark:bg-gray-700 p-4 rounded-lg">
                            <h4 class="font-medium text-purple-800 dark:text-purple-300 mb-2">Special Offers</h4>
                            <ul class="list-disc pl-5 text-gray-700 dark:text-gray-300">
                                <li>Early Bird discount available for limited time</li>
                                <li>Early access to soundcheck with VIP tickets</li>
                                <li>Surprise giveaways for the first 50 attendees</li>
                            </ul>
                        </div>
                    </div>

                    <!-- Important Info Card Section -->
                    <div class="bg-white dark:bg-gray-800 rounded-xl shadow-md p-6">
                        <h3 class="text-xl font-semibold text-gray-800 dark:text-white mb-4">Important Information</h3>
                        
                        <div class="space-y-4">
                            <!--First info-->
                            <div class="flex items-start">
                                <div class="flex-shrink-0 mt-1">
                                    <svg class="h-5 w-5 text-yellow-500" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd" d="M8.257 3.099c.765-1.36 2.722-1.36 3.486 0l5.58 9.92c.75 1.334-.213 2.98-1.742 2.98H4.42c-1.53 0-2.493-1.646-1.743-2.98l5.58-9.92zM11 13a1 1 0 11-2 0 1 1 0 012 0zm-1-8a1 1 0 00-1 1v3a1 1 0 002 0V6a1 1 0 00-1-1z" clip-rule="evenodd" />
                                    </svg>
                                </div>
                                <div class="ml-3">
                                    <p class="text-sm text-gray-700 dark:text-gray-300">
                                        Early Bird is available for Standard Pass only, for a limited time.
                                    </p>
                                </div>
                            </div>
                            <!--Second info-->
                            <div class="flex items-start">
                                <div class="flex-shrink-0 mt-1">
                                    <svg class="h-5 w-5 text-yellow-500" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd" d="M8.257 3.099c.765-1.36 2.722-1.36 3.486 0l5.58 9.92c.75 1.334-.213 2.98-1.742 2.98H4.42c-1.53 0-2.493-1.646-1.743-2.98l5.58-9.92zM11 13a1 1 0 11-2 0 1 1 0 012 0zm-1-8a1 1 0 00-1 1v3a1 1 0 002 0V6a1 1 0 00-1-1z" clip-rule="evenodd" />
                                    </svg>
                                </div>
                                <div class="ml-3">
                                    <p class="text-sm text-gray-700 dark:text-gray-300">Bag checks will be conducted at all entry points.</p>
                                </div>
                            </div>
                            <!--Third info-->
                            <div class="flex items-start">
                                <div class="flex-shrink-0 mt-1">
                                    <svg class="h-5 w-5 text-yellow-500" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd" d="M8.257 3.099c.765-1.36 2.722-1.36 3.486 0l5.58 9.92c.75 1.334-.213 2.98-1.742 2.98H4.42c-1.53 0-2.493-1.646-1.743-2.98l5.58-9.92zM11 13a1 1 0 11-2 0 1 1 0 012 0zm-1-8a1 1 0 00-1 1v3a1 1 0 002 0V6a1 1 0 00-1-1z" clip-rule="evenodd" />
                                    </svg>
                                </div>
                                <div class="ml-3">
                                    <p class="text-sm text-gray-700 dark:text-gray-300">Rain or shine, the event will go on. Bring appropriate gear.</p>
                                </div>
                            </div>
                            <!--Fourth info-->
                            <div class="flex items-start">
                                <div class="flex-shrink-0 mt-1">
                                    <svg class="h-5 w-5 text-purple-500" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd" d="M11.3 1.046A1 1 0 0112 2v5h4a1 1 0 01.82 1.573l-7 10A1 1 0 018 18v-5H4a1 1 0 01-.82-1.573l7-10a1 1 0 011.12-.38z" clip-rule="evenodd" />
                                    </svg>
                                </div>
                                <div class="ml-3">
                                    <p class="text-sm text-gray-700 dark:text-gray-300">The VIP Pass includes a Meet & Greet session and exclusive merchandise.</p>
                                </div>
                            </div>
                            <!--Fifth info-->
                            <div class="bg-yellow-50 dark:bg-gray-700 p-4 rounded-lg mt-4">
                                <h4 class="font-medium text-yellow-800 dark:text-yellow-300 mb-2">Pro Tip</h4>
                                <p class="text-sm text-gray-700 dark:text-gray-300">Want the best spot near the stage? Buy a Zone A ticket along with your pass to access the front zone!</p>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Zone Section -->
                <section id="zone" class="mb-12">
                    <div class="text-center mb-8">
                        <h3 class="heading-receipt border-l-4 border-yellow-400 pl-4 mb-10 font-josefin">Choose Your Perfect Spot</h3>
                    </div>
                    
                    <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
                        <!-- Zone Map -->
                        <div class="bg-white dark:bg-gray-800 rounded-xl shadow-md overflow-hidden">
                            <div class="p-6">
                                <h4 class="text-lg font-semibold text-gray-800 dark:text-white mb-4">Venue Map</h4>
                                <img src="zone.jpg" alt="Standing Zone Map" class="w-full rounded-lg border border-gray-200 dark:border-gray-700">
                            </div>
                        </div>
                        
                        <!-- Zone Details -->
                        <div class="space-y-4">
                            <!-- Zone A -->
                            <div class="zone-card bg-white dark:bg-gray-800 rounded-xl shadow-md overflow-hidden border-l-4 border-zone-a">
                                <div class="p-6 flex justify-between items-center">
                                    <div>
                                        <h4 class="text-lg font-semibold text-zone-a">Zone A (Front Stage)</h4>
                                        <p class="text-gray-600 dark:text-gray-300">Closest to the stage with premium viewing experience</p>
                                    </div>
                                    <span class="bg-zone-a text-white px-3 py-1 rounded-full text-sm font-medium">+RM100</span>
                                </div>
                            </div>
                            
                            <!-- Zone B -->
                            <div class="zone-card bg-white dark:bg-gray-800 rounded-xl shadow-md overflow-hidden border-l-4 border-zone-b">
                                <div class="p-6 flex justify-between items-center">
                                    <div>
                                        <h4 class="text-lg font-semibold text-zone-b">Zone B (Middle)</h4>
                                        <p class="text-gray-600 dark:text-gray-300">Great balance of view and sound quality</p>
                                    </div>
                                    <span class="bg-zone-b text-white px-3 py-1 rounded-full text-sm font-medium">+RM50</span>
                                </div>
                            </div>
                            
                            <!-- Zone C -->
                            <div class="zone-card bg-white dark:bg-gray-800 rounded-xl shadow-md overflow-hidden border-l-4 border-zone-c">
                                <div class="p-6 flex justify-between items-center">
                                    <div>
                                        <h4 class="text-lg font-semibold text-zone-c">Zone C (Back)</h4>
                                        <p class="text-gray-600 dark:text-gray-300">General admission with comfortable space</p>
                                    </div>
                                    <span class="bg-zone-c text-white px-3 py-1 rounded-full text-sm font-medium">+RM0</span>
                                </div>
                            </div>
                            <!--Info-->
                            <div class="bg-blue-50 dark:bg-gray-700 p-4 rounded-lg">
                                <p class="text-sm text-blue-800 dark:text-blue-300"><strong>Note:</strong> All zones are standing zone!</p>
                            </div>
                        </div>
                    </div>
                </section>

                <!-- Purchase Section -->
                <section id="purchase" class="mb-12">
                    <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
                        <!-- Purchase Form -->
                        <div class="lg:col-span-2">
                            <div class="bg-white dark:bg-gray-800 rounded-xl shadow-md p-6">
                                <h3 class="text-xl font-semibold text-gray-800 dark:text-white mb-6">Complete Your Purchase</h3>
                                
                                <form name="ticketForm" action="../../../User/Dashboard/Receipt/receipt.php" method="post" class="space-y-4">
                                    <!-- Ticket Type -->
                                    <div>
                                        <label for="ticketType" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Ticket Type</label>
                                        <select class="w-full px-4 py-2 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-purple-500 focus:border-purple-500 dark:bg-gray-700 dark:text-white" 
                                                name="ticketType" id="ticketType" required>
                                            <option value="" selected disabled>Select Ticket Type</option>
                                            <option value="Early Bird-266-326">Early Bird - RM266 (MY) / RM326 (Non-MY)</option>
                                            <option value="Standard-288-348">Standard - RM288 / RM348</option>
                                            <option value="VIP Pass-688-748">VIP Pass - RM688 / RM748</option>
                                        </select>
                                    </div>
                                    
                                    <!-- Category -->
                                    <div>
                                        <label for="category" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Category</label>
                                        <select class="w-full px-4 py-2 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-purple-500 focus:border-purple-500 dark:bg-gray-700 dark:text-white" 
                                                name="category" id="category" required>
                                            <option value="" selected disabled>Select Category</option>
                                            <option value="malaysian">Malaysian</option>
                                            <option value="non-malaysian">Non-Malaysian</option>
                                        </select>
                                    </div>
                                    
                                    <!-- Standing Zone -->
                                    <div>
                                        <label for="seatingZone" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Standing Zone</label>
                                        <select class="w-full px-4 py-2 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-purple-500 focus:border-purple-500 dark:bg-gray-700 dark:text-white" 
                                                name="seatingZone" id="seatingZone" required>
                                            <option value="" selected disabled>Select Standing Zone</option>
                                            <option value="Zone A - RM 100">Zone A - RM 100</option>
                                            <option value="Zone B - RM 50">Zone B - RM 50</option>
                                            <option value="Zone C - RM 0">Zone C - RM 0</option>
                                        </select>
                                    </div>
                                    
                                    <!-- Quantity -->
                                    <div>
                                        <label for="quantity" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Quantity (Max 5)</label>
                                        <input type="number" class="w-full px-4 py-2 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-purple-500 focus:border-purple-500 dark:bg-gray-700 dark:text-white" name="quantity" id="quantity" min="1" max="5" value="1" required>
                                    </div>
                                    
                                    <!--total price-->
                                    <input type="hidden" name="totalPrice" id="hiddenTotalPrice">

                                    <!--Submit button-->
                                    <button type="submit" class="w-full bg-purple-custom hover:bg-purple-700 text-white font-bold py-3 px-4 rounded-lg transition duration-300 mt-6">Confirm Purchase</button>
                                </form>
                            </div>
                        </div>
                        
                        <!-- Order Summary -->
                        <div>
                            <div class="bg-white dark:bg-gray-800 rounded-xl shadow-md p-6 sticky-summary">
                                <h3 class="text-xl font-semibold text-gray-800 dark:text-white mb-6">Order Summary</h3>
                                
                                <div class="space-y-4">
                                    <div class="flex justify-between">
                                        <span class="text-gray-600 dark:text-gray-300">Ticket Type:</span>
                                        <span id="displayTicketType" class="font-medium">-</span>
                                    </div>
                                    
                                    <div class="flex justify-between">
                                        <span class="text-gray-600 dark:text-gray-300">Category:</span>
                                        <span id="displayCategory" class="font-medium">-</span>
                                    </div>
                                    
                                    <div class="flex justify-between">
                                        <span class="text-gray-600 dark:text-gray-300">Ticket Price (each):</span>
                                        <span id="priceEach" class="font-medium">-</span>
                                    </div>
                                    
                                    <div class="flex justify-between">
                                        <span class="text-gray-600 dark:text-gray-300">Quantity:</span>
                                        <span id="priceQuantity" class="font-medium">0</span>
                                    </div>
                                    
                                    <div class="flex justify-between">
                                        <span class="text-gray-600 dark:text-gray-300">Standing Zone:</span>
                                        <span id="displaySeatingZone" class="font-medium">-</span>
                                    </div>
                                    
                                    <div class="border-t border-gray-200 dark:border-gray-700 pt-4 mt-4">
                                        <div class="flex justify-between">
                                            <span class="text-lg font-bold text-gray-800 dark:text-white">Total Price:</span>
                                            <span id="totalPrice" class="text-lg font-bold text-purple-600 dark:text-purple-400">RM0</span>
                                        </div>
                                    </div>
                                </div>
                                
                                <div class="mt-6 bg-purple-50 dark:bg-gray-700 p-4 rounded-lg">
                                    <p class="text-sm text-purple-800 dark:text-purple-300">Tickets are limited — secure yours now for an epic music experience!</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </section>
            </div>
        </main>
    </div>

  <script>
  document.addEventListener('DOMContentLoaded', function() {
    const ticketType = document.getElementById('ticketType');
    const category = document.getElementById('category');
    const quantity = document.getElementById('quantity');
    const seatingZone = document.getElementById('seatingZone');
    const displayTicketType = document.getElementById('displayTicketType');
    const displayCategory = document.getElementById('displayCategory');
    const priceEach = document.getElementById('priceEach');
    const priceQuantity = document.getElementById('priceQuantity');
    const displaySeatingZone = document.getElementById('displaySeatingZone');
    const totalPrice = document.getElementById('totalPrice');
    
    function updatePrice() {
      if (!ticketType.value || !seatingZone.value) return;

      const [ticketName, malaysianPriceStr, nonMalaysianPriceStr] = ticketType.value.split("-");
      const ticketPriceVal = category.value === 'malaysian' ? parseInt(malaysianPriceStr) : parseInt(nonMalaysianPriceStr);
      const seatingPrice = parseInt(seatingZone.value.split(" - RM ")[1]);
      const qty = parseInt(quantity.value) || 0;

      displayTicketType.textContent = ticketName;
      displayCategory.textContent = category.value === 'malaysian' ? 'Malaysian' : 'Non-Malaysian';
      priceEach.textContent = `RM ${ticketPriceVal}`;
      displaySeatingZone.textContent = seatingZone.value;
      priceQuantity.textContent = qty;

      const calculatedTotal = (ticketPriceVal + seatingPrice) * qty;
      totalPrice.textContent = `RM ${calculatedTotal}`;
      document.getElementById('hiddenTotalPrice').value = calculatedTotal;
    }

    // Add event listeners
    if (ticketType) ticketType.addEventListener('change', updatePrice);
    if (category) category.addEventListener('change', updatePrice);
    if (quantity) quantity.addEventListener('input', updatePrice);
    if (seatingZone) seatingZone.addEventListener('change', updatePrice);
    
    // Initialize
    updatePrice();
  });
</script>
</body>
</html>