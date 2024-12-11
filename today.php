<?php
// Database connection
$servername = "localhost";
$username = "root";
$password = "hetanshi16";
$dbname = "girltalk"; // Replace with your actual database name

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Retrieve user's period dates from the database
$user_id = 1; // Replace with session or dynamic user ID
$period_dates = [];

$sql = "SELECT date FROM period_dates WHERE user_id = $user_id";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $period_dates[] = $row['date'];
    }
}

// Handle form submission to save selected period dates
if ($_SERVER["REQUEST_METHOD"] === "POST") {
    if (isset($_POST['period_dates'])) {
        foreach ($_POST['period_dates'] as $selected_date) {
            // Check if the date already exists to avoid duplicates
            $stmt = $conn->prepare("INSERT IGNORE INTO period_dates (user_id, date) VALUES (?, ?)");
            $stmt->bind_param("is", $user_id, $selected_date);
            $stmt->execute();
            $stmt->close();
        }
        // Redirect to the same page to refresh the data
        header("Location: " . $_SERVER['PHP_SELF']);
        exit;
    }
}

// For navigating months and years
$month = isset($_GET['month']) ? (int)$_GET['month'] : date('m');
$year = isset($_GET['year']) ? (int)$_GET['year'] : date('Y');


// Adjust month and year based on user navigation
if (isset($_GET['action'])) {
    if ($_GET['action'] === 'prev') {
        if ($month == 1) {
            $month = 12;
            $year--;
        } else {
            $month--;
        }
    } elseif ($_GET['action'] === 'next') {
        if ($month == 12) {
            $month = 1;
            $year++;
        } else {
            $month++;
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Today</title>
  
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Bubblegum+Sans&display=swap" rel="stylesheet">

    <style>
        body {
            font-family: 'Bubblegum Sans', sans-serif;
            text-align: center;
            background-color: #f1a7c0;
            margin: 0;
            padding: 20px;
            color: #333;
        }

        h1 {
            font-size: 50px;
            margin-top: 20px;
            color: #d81b60;
        }

        #today-date {
            font-size: 30px;
            margin-bottom: 20px;
            color: #ad1457;
        }

        .calendar-container {
            margin-top: 30px;
        }

        .calendar-header {
            display: flex;
            justify-content: center;
            padding: 0 20px;
            font-size: 24px;
            color: #ad1457;
        }

        .calendar-header h2 {
            font-size: 30px;
        }

        .days-of-week {
            display: grid;
            grid-template-columns: repeat(7, 1fr);
            margin-top: 20px;
            color: #d81b60;
            font-weight: bold;
        }

        .calendar-grid {
            display: grid;
            grid-template-columns: repeat(7, 1fr);
            grid-gap: 10px;
            padding: 20px;
        }

        .calendar-day {
            background-color: #fff0f6;
            border: 5px solid #d81b60;
            padding: 10px;
            border-radius: 10px;
            text-align: center;
        }

        .selected-day {
            background-color: #f06292;
            border-radius: 10px;
            color: #fff;
        }

        footer {
            margin-top: 40px;
            font-size: 16px;
            color: #ad1457;
        }
    </style>
</head>

<body>
    <h1>Today's Date</h1>
    <div id="today-date"><?php echo date('F j, Y'); ?></div>

    <div class="calendar-container">
        <div class="calendar-header">
            <h2><?php echo date('F Y', strtotime("$year-$month-01")); ?></h2>
        </div>

        <div class="days-of-week">
            <div>Sun</div>
            <div>Mon</div>
            <div>Tue</div>
            <div>Wed</div>
            <div>Thu</div>
            <div>Fri</div>
            <div>Sat</div>
        </div>

        <form method="POST">
            <div class="calendar-grid">
                <?php
                $days_in_month = cal_days_in_month(CAL_GREGORIAN, $month, $year);
                $first_day_of_month = date('w', strtotime("$year-$month-01"));

                // Empty cells before the first day of the month
                for ($i = 0; $i < $first_day_of_month; $i++) {
                    echo '<div></div>';
                }

                // Days of the month
                for ($day = 1; $day <= $days_in_month; $day++) {
                    $date_string = "$year-$month-" . str_pad($day, 2, '0', STR_PAD_LEFT);
                    $is_selected = in_array($date_string, $period_dates) ? 'selected-day' : '';
                    
                    echo "<div class='calendar-day $is_selected'>
                            $day <br>
                            <input type='checkbox' name='period_dates[]' value='$date_string' " . (in_array($date_string, $period_dates) ? 'checked' : '') . ">
                          </div>";
                }
                ?>
            </div>
            <button type="submit" style="margin-top: 20px; background-color: #d81b60; color: white; border: none; padding: 10px 20px; border-radius: 5px;">Save Dates</button>
        </form>
    </div>

    <div class="navigation">
        <a href="?month=<?php echo ($month == 1) ? 12 : $month - 1; ?>&year=<?php echo ($month == 1) ? $year - 1 : $year; ?>">Previous</a>
        <a href="?month=<?php echo ($month == 12) ? 1 : $month + 1; ?>&year=<?php echo ($month == 12) ? $year + 1 : $year; ?>">Next</a>
    </div>


    <footer>
        <p>Girl Talk - Your health and hygiene platform</p>
    </footer>
</body>
</html

<?php $conn->close(); ?>