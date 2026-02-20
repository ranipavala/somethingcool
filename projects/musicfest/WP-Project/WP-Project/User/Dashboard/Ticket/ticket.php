<?php
	session_start();
	if (!isset($_SESSION["email"])) {
		$page = 'xSession';
        include 'sessionError.php';
        exit();
	}
	$con = mysqli_connect("localhost", "root", "", "music_festival") or die("Cannot connect to server." . mysqli_error($con));
	$user = $_SESSION["email"];
	$sql = "SELECT userID FROM users WHERE email='$user'";
	$result = mysqli_query($con, $sql) or die("Cannot execute sql: " . mysqli_error($con));
	$output = mysqli_fetch_array($result, MYSQLI_BOTH);

	if (isset($output['userID'])) {
		$user_id = $output['userID'];
		
		// Get all tickets for this user
		$ticket_sql = "SELECT * FROM event_registrations WHERE userID='$user_id' ORDER BY event_ID DESC";
		$ticket_result = mysqli_query($con, $ticket_sql) or die("Cannot get tickets: " . mysqli_error($con));
		
		if (mysqli_num_rows($ticket_result) > 0) {
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>My Tickets</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css"/>
    <link href="ticket.css" rel="stylesheet">
	<link href="style.css" rel="stylesheet">
    <!-- Tailwind CSS -->
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        body {
            background-image: linear-gradient(to bottom, #9b59b6, #f4d03f);
            min-height: 100vh;
			background-attachment:fixed;
        }
		.sticky-back {
            position: fixed;
            top: 20px;
            left: 20px;
            z-index: 100;
        }
        .dark body {
            background: #111827; /* Dark mode background */
        }
        .ticket-container {
            max-width: 1200px;
            margin: 0 auto;
        }
    </style>
</head>

<body x-data="{ darkMode: false }" :class="darkMode ? 'dark' : ''">
	<!--Sticky Back Button-->
	<div class="sticky-back">
        <a href="/WP-Project/User/Dashboard/Receipt/receipt.php" class="bg-white hover:bg-gray-100 text-purple-800 font-bold py-2 px-4 rounded-lg transition duration-300 inline-flex items-center shadow-lg">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" viewBox="0 0 20 20" fill="currentColor">
                <path fill-rule="evenodd" d="M9.707 16.707a1 1 0 01-1.414 0l-6-6a1 1 0 010-1.414l6-6a1 1 0 011.414 1.414L5.414 9H17a1 1 0 110 2H5.414l4.293 4.293a1 1 0 010 1.414z" clip-rule="evenodd" />
            </svg>
            Back
        </a>
    </div>
	
	<!--Display user basic info-->
	<div class="flex flex-col items-end mt-2 py-2 px-4 text-right">
    	<h1 class="text-hi text-black">Hi!</h1>
    	<!--Display welcome message-->
        <h4 class="text-user text-black"><?php echo "$user"; ?></h4>
    </div>  
	
    <!--Ticket Section-->
    <div class="ticket-container">
	<h2 class="heading-receipt border-l-4 border-yellow-400 pl-4">My Tickets</h2>
        
        <?php while($ticket_row = mysqli_fetch_array($ticket_result, MYSQLI_BOTH)): 
            $ticket_id = $ticket_row['ticket_id'];
        ?>
        <!--Ticket Template-->
        <div class="mb-12">
            <div class="ticket">
                <div class="left">
                    <div class="image">
                        <p class="admit-one">
                            <span>ADMIT ONE</span>
                            <span>ADMIT ONE</span>
                            <span>ADMIT ONE</span>
                        </p>
                        <div class="ticket-number">
                            <p><?php echo '#'.$ticket_id; ?></p>
                        </div>
                    </div>
                    <div class="ticket-info">
                        <p class="date">
                            <span>SATURDAY</span>
                            <span class="june-29">1 <sup>ST</sup> APRIL</span>
                            <span>2028</span>
                        </p>
                        <div class="show-name">
                            <h1>MUSIC FESTIVAL</h1>
                            <h2>Purello: Rasa Gila, Sound Gempak</h2>
                        </div>
                        <div class="time">
                            <p>10:00 AM <span>TO</span> 12:00 AM</p>
                            <p>DOORS <span>@</span> 9:00 AM</p>
                        </div>
                        <p class="location">
                            <span>Surf Beach @ Sunway Lagoon </span>
                            <span class="separator"><i class="far fa-smile">  </i></span>
                            <span> Petaling Jaya, Selangor, Malaysia</span>
                        </p>
                    </div>
                </div>
                <div class="right">
                    <p class="admit-one">
                        <span>ADMIT ONE</span>
                        <span>ADMIT ONE</span>
                        <span>ADMIT ONE</span>
                    </p>
                    <div class="right-info-container">
                        <div class="show-name">
                            <h1>MUSIC FESTIVAL</h1>
                        </div>
                        <div class="time">
                            <p>10:00 AM <span>TO</span> 12:00 AM</p>
                            <p>DOORS <span>@</span> 9:00 AM</p>
                        </div>
                        <div class="barcode">
                            <img src="https://external-preview.redd.it/cg8k976AV52mDvDb5jDVJABPrSZ3tpi1aXhPjgcDTbw.png?auto=webp&s=1c205ba303c1fa0370b813ea83b9e1bddb7215eb" alt="QR code">
                        </div>
                        <p class="ticket-number"><?php echo '#'.$ticket_id; ?></p>
                    </div>
                </div>
            </div>
        </div>
        <?php endwhile; ?>
    </div>

<?php
    }
	else{
		$page = 'xTicket';
        include 'sessionError.php';
        exit();
    }
}
	else{
		$page = 'xSession';
        include 'sessionError.php';
        exit();
  	}
mysqli_close($con);
?>

</body>
</html>