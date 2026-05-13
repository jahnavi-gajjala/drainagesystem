<!DOCTYPE html> <!-- Declares HTML5 document type -->
<html lang="en"> <!-- Starts the HTML document with English language -->
<head>
  <meta charset="UTF-8" /> <!-- Sets character encoding -->
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/> <!-- Ensures responsiveness on different devices -->
  <title>Drainage Health Portal</title> <!-- Sets the title of the web page -->
  <style>
    /* ========== Global Reset ========== */
    * {
      box-sizing: border-box; /* Ensures padding and border are included in element’s width and height */
    }

    body {
      font-family: Arial, sans-serif; /* Sets font for the page */
      margin: 0;
      background: #f4f4f4; /* Light gray background color */
    }

    /* ========== Header Styling ========== */
    header {
      background: #0288d1; /* Blue background */
      color: white;
      padding: 1rem; /* Padding around header text */
      text-align: center; /* Centers the text */
    }

    /* ========== Navigation Bar Styling ========== */
    nav {
      background: #0277bd;
      padding: 0.5rem;
      display: flex;
      justify-content: center;
      gap: 1rem; /* Space between nav links */
    }

    nav a {
      color: white;
      text-decoration: none; /* Removes underline */
      padding: 0.5rem 1rem;
    }

    nav a:hover {
      background: #01579b;
      border-radius: 5px;
    }

    /* ========== Main Container Styling ========== */
    .container {
      padding: 2rem;
      max-width: 800px;
      margin: auto;
      background: white;
      margin-top: 1rem;
    }

    /* ========== Complaint Card Styling ========== */
    .complaint-card {
      border: 1px solid #ccc;
      padding: 1rem;
      margin-bottom: 1.5rem;
      border-radius: 10px;
      background-color: #f9f9f9;
    }

    .complaint-card img {
      width: 200px;
      height: 200px;
      object-fit: contain; /* Ensures image fits in box without distortion */
      border-radius: 5px;
      margin-top: 0.5rem;
    }

    .story img {
      width: 100%;
      border-radius: 8px;
    }

    /* ========== Error Message Styling ========== */
    .error-msg {
      color: red;
      margin-top: -12px;
      margin-bottom: 10px;
      font-size: 14px;
    }

    .complaint_note_success {
      color: green;
    }

    .complaint_note_deny {
      color: red;
    }
  </style>
</head>
<body>
  <!-- ========== Header Section ========== -->
  <header>
    <h1>Drainage System Revitalization Portal</h1>
  </header>

  <!-- ========== Navigation Menu ========== -->
  <nav>
    <a href="home.html">Home</a>
    <!-- <a href="registercitizen.html">Register</a>
    <a href="report.html">Report</a> -->
    <a href="stories.html">Stories</a>
    <a href="policy.html">Policy</a>
    <a href="contact.html">Contact</a>
    <a href="sanitationteam.php">Sanitation</a>
  </nav>

  <!-- ========== GVMC Dashboard Container ========== -->
  <div class="container hidden" id="gvmcDashboard">
    <h2>GVMC Complaints Dashboard</h2>

<?php
// ========== PHP BACKEND: Database connection and complaint fetch ==========

// Database credentials
$servername = "localhost";
$username = "root";
$password = "";
$database = "drainage_system";

// Create connection
$conn = new mysqli($servername, $username, $password, $database);

// Check connection success
if ($conn->connect_error) {
  die("Connection failed: " . $conn->connect_error);
}

// Fetch all complaints from the database
$sql = "SELECT * FROM complaints";
$result = $conn->query($sql);

// If there are complaints in the database
if ($result->num_rows > 0) {
  while ($row = $result->fetch_assoc()) {
    // Sanitize data for safe output
    $issue = htmlspecialchars($row['issue']);
    $description = htmlspecialchars($row['complaint_description']);
    $area = htmlspecialchars($row['area']);
    $photo = htmlspecialchars($row['photo']);
    $approval = htmlspecialchars($row['approval']);
    $complaint_id = htmlspecialchars($row['id']);
?>

    <!-- ========== Complaint Card ========== -->
    <div class='complaint-card' data-area='$area'>
        <h3>Complaint from <?php echo $area; ?></h3>
        <p><strong>Issue:</strong> <?php echo $issue; ?></p>
        <p><strong>Description:</strong> <?php echo  $description; ?></p>
        <img src="<?php echo $row['photo']; ?>" width="300" alt="Uploaded Complaint Image">
        <div style='margin-top: 10px;'>
          <?php
          if($approval == "hold") {
            // Buttons only visible if complaint is not yet accepted or denied
          ?>
            <button class="complaint_action" type="accept" data-id="<?php echo  $complaint_id; ?>" style="pointer-events: <?php echo ($approval == 'accept') ? 'none' : 'unset' ; ?>">Accept</button>
            <button class="complaint_action" type="deny" data-id="<?php echo  $complaint_id; ?>" style="pointer-events: <?php echo ($approval == 'deny') ? 'none' : 'unset' ; ?>">Deny</button>
          <?php } ?>
          
          <!-- Status text below buttons -->
          <p class="complaint_status" style="color: <?php echo ($approval == 'accept') ? 'green' : 'red';?>">
            <?php
            if($approval == "accept") {
              echo 'Complaint Accepted';
            } else if($approval == "deny") {
              echo "Denied";
            } else {
              echo "";
            }
            ?>
          </p>

          <!-- Status feedback messages -->
          <p class="complaint_note_success"></p>
          <p class="complaint_note_deny"></p>
        </div>
      </div>
<?php
  } // end while
} // end if
?>
  </div>

  <!-- ========== jQuery + AJAX Script for Approval ========== -->
  <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
  <script>
    jQuery(document).ready(function() {
      // When "Accept" or "Deny" button is clicked
      jQuery(document).on('click', '.complaint_action', function() {
        let type = jQuery(this).attr('type'); // accept or deny
        let complaint_id = jQuery(this).attr('data-id');
        let $this = jQuery(this); // store reference to clicked button

        // AJAX call to update complaint approval status
        jQuery.ajax({
          url: "http://localhost/csp/csp/complaintapproval.php", // target PHP file
          type: "post",
          data: {
            approval: type,
            complaint_id: complaint_id,
          },
          success: function (response) {
            console.log(response); // log response for debugging
            if(response == 'success') {
              // Show relevant success message
              if(type == "accept") {
                jQuery($this).parent().find('.complaint_note_success').text('Complaint accepted');
              } else {
                jQuery($this).parent().find('.complaint_note_deny').text('Complaint denied');
              }  
              location.reload(); // reload to update interface
            } else {
              alert('Something went wrong'); // error feedback
            }
          },
          error: function(jqXHR, textStatus, errorThrown) {
            console.log("AJAX Error:", errorThrown); // error debug log
          }
        });
      });
    });
  </script>
</body>
</html>
