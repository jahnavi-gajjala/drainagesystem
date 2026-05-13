<!DOCTYPE html> <!-- Declares HTML5 document -->
<html lang="en"> <!-- Opens HTML document and specifies language -->

<head>
  <meta charset="UTF-8" /> <!-- Sets character encoding -->
  <meta name="viewport" content="width=device-width, initial-scale=1" /> <!-- Responsive design for mobile devices -->
  <title>Register - MedLink</title> <!-- Title displayed in browser tab -->

  <style>
    /* ========== GLOBAL STYLES ========== */
    * {
      box-sizing: border-box; /* Ensures padding/margin don’t affect element size */
    }

    body {
      font-family: Arial, sans-serif;
      margin: 0;
      background: #f4f4f4;
    }

    /* ========== HEADER STYLING ========== */
    header {
      background: #0288d1;
      color: white;
      padding: 1rem;
      text-align: center;
    }

    /* ========== NAVIGATION BAR ========== */
    nav {
      background: #0277bd;
      padding: 0.5rem;
      display: flex;
      justify-content: center;
      gap: 1rem;
    }

    nav a {
      color: white;
      text-decoration: none;
      padding: 0.5rem 1rem;
    }

    nav a:hover {
      background: #01579b;
      border-radius: 5px;
    }

    a.active {
      background-color: grey; /* Style for active nav item */
    }

    /* ========== CONTAINER ========== */
    .container {
      padding: 2rem;
      max-width: 800px;
      margin: auto;
      background: white;
      margin-top: 1rem;
    }

    /* Hides content initially */
    .hidden {
      display: none;
    }

    /* ========== FORM AND INPUT STYLING ========== */
    form {
      display: flex;
      flex-direction: column;
      gap: 1rem;
    }

    input, select, textarea {
      padding: 10px;
      width: 100%;
    }

    /* ========== BUTTON STYLES ========== */
    button {
      padding: 10px;
      background: #0288d1;
      color: white;
      border: none;
      cursor: pointer;
      width: 100%;
    }

    button:hover {
      background: #0277bd;
    }

    /* ========== COMPLAINT CARD STYLING ========== */
    .complaint-card {
      border: 1px solid #ccc;
      padding: 1rem;
      margin-bottom: 1.5rem;
      border-radius: 10px;
      background-color: #f9f9f9;
    }

    .complaint-card img {
      width: 100%;
      border-radius: 5px;
      margin-top: 0.5rem;
    }

    .story img {
      width: 100%;
      border-radius: 8px;
    }

    /* ========== ERROR MESSAGE STYLING ========== */
    .error-msg {
      color: red;
      margin-top: -12px;
      margin-bottom: 10px;
      font-size: 14px;
    }

    label {
      display: block;
      margin-bottom: 6px;
      font-weight: bold;
      color: #333;
    }

    input[type="text"], input[type="email"], input[type="tel"], select {
      padding: 10px 12px;
      font-size: 16px;
      margin-bottom: 18px;
      box-sizing: border-box;
    }

    input:focus, select:focus {
      border-color: #2a7a3b;
      outline: none;
    }
  </style>
</head>

<body>
  <!-- HEADER -->
  <header>
    <h1>Drainage System Revitalization Portal</h1>
  </header>

  <!-- NAVIGATION LINKS -->
  <nav>
    <a href="home.html">Home</a>
    <!-- Commented-out links -->
    <!-- <a href="registercitizen.html">Register</a>
    <a href="report.html">Report</a> -->
    <a href="stories.html">Stories</a>
    <a href="policy.html">Policy</a>
    <a href="contact.html">Contact</a>
    <a href="sanitationteam.php" class="active">Sanitation</a> <!-- Active tab -->
  </nav>

  <!-- DASHBOARD FOR SANITATION TEAM -->
  <div class="container hidden" id="sanitationDashboard">
    <h2>Sanitation Team Dashboard</h2>

    <?php
    // Connect to MySQL
    $servername = "localhost";
    $username = "root";
    $password = "";
    $database = "drainage_system";

    // Create connection
    $conn = new mysqli($servername, $username, $password, $database);

    // Check if connection failed
    if ($conn->connect_error) {
      die("Connection failed: " . $conn->connect_error);
    }

    // Fetch all approved complaints
    $sql = "SELECT * FROM complaints WHERE approval='accept'";
    $result = $conn->query($sql);

    // Check if complaints exist
    if ($result->num_rows > 0) {
      // Loop through each complaint row
      while ($row = $result->fetch_assoc()) {
        // Sanitize output
        $issue = htmlspecialchars($row['issue']);
        $description = htmlspecialchars($row['complaint_description']);
        $area = htmlspecialchars($row['area']);
        $photo = htmlspecialchars($row['photo']);
        $approval = htmlspecialchars($row['approval']);
        $complaint_id = htmlspecialchars($row['id']);
    ?>

    <!-- Render one complaint card -->
    <div class='complaint-card' data-area='<?php echo $area; ?>'>
      <h3>Complaint from <?php echo $area; ?></h3>
      <p><strong>Issue:</strong> <?php echo $issue; ?></p>
      <p><strong>Description:</strong> <?php echo  $description; ?></p>
      <img src='<?php echo $photo; ?>' alt='Issue Image'>
      <div style='margin-top: 10px;'>
        <p class="complaint_status" style="color: <?php echo ($approval == 'accept') ? 'green' : 'red';?>">
          Status: Complaint Accepted
        </p>
      </div>
    </div>

    <?php
      } // end while
    } // end if
    ?>
  </div>
</body>
</html>
