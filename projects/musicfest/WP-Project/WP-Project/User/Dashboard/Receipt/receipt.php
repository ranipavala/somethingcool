<?php
    session_start();
    // Check if session exists
    if (!isset($_SESSION["email"])) {
      $page = 'xSession';
      include 'sessionError.php';
      exit();
    }
    $con=mysqli_connect("localhost", "root", "", "music_festival") or die("Cannot connect to server.".mysqli_error($con));
    $user=$_SESSION["email"];
    //Query the database to get user ID based on email
    $sql="SELECT userID FROM users WHERE email='$user'";
    $result=mysqli_query($con,$sql) or die("Cannot execute sql: ".mysqli_error($con));
    $output=mysqli_fetch_array($result,MYSQLI_BOTH);
    //If user ID is found
    if(isset($output['userID']))
    {
        $user_id=$output['userID'];
        
        //If the user submitted a ticket purchase form
        //Handle new purchase (POST request) 
        if($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST["ticketType"]))
        {
            $ticket_type=$_POST["ticketType"];
            $category=$_POST["category"];
            $seating_zone=$_POST["seatingZone"];
            $quantity=$_POST["quantity"];
            $total_price=$_POST["totalPrice"];

            //Process purchase
            $temp_ticket_id = rand(1000, 9999);
            $insert_sql="INSERT INTO event_registrations VALUES (null, '$temp_ticket_id', '$ticket_type', '$category', '$seating_zone', '$quantity', '$total_price', '$user_id')";
            $status=mysqli_query($con,$insert_sql) or die("Error in inserting data: ".mysqli_error($con));

            //If insert successful, update ticket ID with custom format
            if($status)
            {
                $id=mysqli_insert_id($con);
                $ticket_id = strtoupper($user_id . $ticket_type . $seating_zone ."-". $quantity);
                $update_sql="UPDATE event_registrations SET ticket_id='$ticket_id' WHERE event_ID=$id";
                mysqli_query($con,$update_sql) or die("Error updating ticket ID: ".mysqli_error($con));
            }
        }

        //Retrieve purchase history for the logged-in user
        $history_sql="SELECT * FROM event_registrations WHERE userID='$user_id' ORDER BY event_ID DESC";
        $history_result=mysqli_query($con,$history_sql) or die("Cannot get purchase history: ".mysqli_error($con));
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Payment Details</title>
    <!--Tailwind CSS-->
    <script src="https://cdn.tailwindcss.com"></script>
    <!--Alpine.js for interactivity-->
    <script src="https://unpkg.com/alpinejs" defer></script>
    
    <script>
    //Single tailwind config
    tailwind.config = {
      darkMode: 'class',
      theme: {
        extend: {
          colors: {
            'purple-custom': '#9b59b6',
            'yellow-custom': '#f4d03f',
          },
          backgroundImage: {
            'p-y-gradient': 'linear-gradient(to bottom, #9b59b6, #f4d03f)',
          },
        }
      }
    }
</script>
    <link rel="stylesheet" href="style.css">
</head>

<body x-data="{ open: true, darkMode: false, openLogoutModal: false }" :class="darkMode ? 'dark' : ''">
    <div class="relative flex bg-p-y-gradient dark:bg-gray-900">
        <!-- Sidebar Navigation-->
        <div class="relative flex">
          <aside class="sidebar-container">
            <?php
              $page = 'receipt';
              include 'sidebar.php';
            ?>
          </aside>
        </div>
        <!--Payment detail-->
        <div class="container-receipt my-5 px-10 mt-10">
            <!--Success Message After Ticket Purchase-->
            <?php if(isset($status) && $status): ?>
            <div class="mb-4 p-4 bg-green-100 text-green-800 rounded-lg">
                Purchase successful! Your ticket ID: <?php echo $ticket_id; ?>
            </div>
            <?php endif; ?>

            <!--Purchase History Section-->
            <h2 class="heading-receipt border-l-4 border-yellow-400 pl-4">Purchase History</h2>
            <div class="receipt-card" id="receipt">
                <?php while($row=mysqli_fetch_array($history_result,MYSQLI_BOTH)): ?>
                <div class="mb-6 p-4 border rounded-lg">
                    <h4 class="font-bold">Ticket #<?php echo $row['ticket_id']; ?></h4>
                    <ul class="receipt-list">
                        <li>Type: <?php echo $row['ticket_type']; ?></li>
                        <li>Category: <?php echo $row['category']; ?></li>
                        <li>Zone: <?php echo $row['seating_zone']; ?></li>
                        <li>Quantity: <?php echo $row['quantity']; ?></li>
                        <li>Total: RM <?php echo $row['total_price']; ?></li>
                    </ul>
                </div>
                <?php endwhile; ?>
            </div>
            
            <!--View ticket button-->
            <div class="mt-6 text-right">
                <a href="/WP-Project/User/Dashboard/Ticket/ticket.php" class="w-full bg-purple-custom hover:bg-purple-700 text-white font-bold py-3 px-4 rounded-lg transition duration-300 mt-6">View My Tickets</a>
            </div>
        </div>
    </div>

    <?php 
    }
    else
    {
      $page = 'xSession';
      include 'sessionError.php';
      exit();
    }
    mysqli_close($con);
?>
</body>
</html>