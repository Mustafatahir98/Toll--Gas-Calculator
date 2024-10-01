<?php /* Template Name: log */ ?>

<?php
 if ( !is_user_logged_in() ) {

    wp_redirect('/wp-login.php?redirect_to=log');

}
global $wpdb; // Make sure you have access to the global $wpdb object

// The table name
// $table_name = $wpdb->prefix . 'toll_calculations'; // 'wp_' is the prefix
$table_name = 'toll_calculations';

// Data to insert
$form_data = $_POST; // Ensure you sanitize and validate this data
$initialOneWaytollCost = 0;/* Your logic to calculate one-way toll cost */;
$initialOneWayfuel = 0;/* Your logic to calculate one-way fuel cost */;

// Double the costs for a return trip
if ($form_data['Trip'] == 'Return') {
    $tollCost = $initialOneWaytollCost * 2;
    $fuelCost = $initialOneWayfuel * 2;
} else {
    $tollCost = $initialOneWaytollCost;
    $fuelCost = $initialOneWayfuel;
}
// Insert data into the database using $wpdb->insert
$inserted = $wpdb->insert(
    $table_name,
    array(
        'fromCity' => $form_data['fromCity'],
        'toCity' => $form_data['toCity'],
        'type_of_vehicle' => $form_data['type_of_vehicle'],
        'Trip' => $form_data['Trip'],
        'tollCost' => $initialOneWaytollCost,
        'fuelCost' => $initialOneWayfuel
      
    ),
    array('%s', '%s', '%s', '%s', '%f', '%f', '%f') // Specify the format corresponding to each value
);

// Check if the insert was successful
// if (false === $inserted) {
//     echo "Error inserting data: " . $wpdb->last_error;
// } else {
//     echo "Data inserted successfully";
// }

// Handle delete requests
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_POST['delete_entry'])) {
        // Check if the delete button for a specific entry is clicked
        $entry_id = $_POST['delete_entry'];
        $delete_sql = "DELETE FROM toll_calculations WHERE id = $entry_id";
        if ($wpdb->query($delete_sql)) {
            // echo "Record deleted successfully";
        } else {
            // echo "Error deleting record: " . $wpdb->last_error;
        }
    } elseif (isset($_POST['delete_all'])) {
        // Check if the delete all button is clicked
        $delete_all_sql = "DELETE FROM toll_calculations";
        if ($wpdb->query($delete_all_sql)) {
            // echo "All records deleted successfully";
        } else {
            // echo "Error deleting records: " . $wpdb->last_error;
        }
    }
}

// Retrieve data from the database using $wpdb->get_results
$results = $wpdb->get_results("SELECT * FROM {$table_name}");

// Output the retrieved data in a table format
if (!empty($results)) {
    echo "<form method='post'><table border='1'>";
    echo "<tr><th>From City</th><th>To City</th><th>Type of Vehicle</th><th>Trip</th><th>Toll Cost</th><th>Fuel Cost</th><th>Action</th></tr>";
    foreach ($results as $row) {
        echo "<tr>";
        echo "<td>" . $row->fromCity . "</td>";
        echo "<td>" . $row->toCity . "</td>";
        echo "<td>" . $row->type_of_vehicle . "</td>";
        echo "<td>" . $row->Trip . "</td>";
        echo "<td>" . $row->tollCost . "</td>";
        echo "<td>" . $row->fuelCost . "</td>";
        echo "<td><button type='submit' name='delete_entry' value='" . $row->id . "'>Delete</button></td>";
        echo "</tr>";
    }
    echo "</table></form>";
    echo "<form method='post'><button type='submit' name='delete_all'>Delete All Entries</button></form>";
} else {
    echo "No records found.";
}
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>log</title>
    <style>
        body {
    font-family: Arial, sans-serif;
    margin: 50px;
    background-color: #f4f4f4;
}

h2 {
    color: #444;
    text-align: center;
    margin-bottom: 30px;
}

table {
    width: 100%;
    max-width: 600px;
    margin: 0 auto;
    border-collapse: collapse;
    background-color: #fff;
    box-shadow: 0 2px 12px rgba(0, 0, 0, 0.1);
}

th, td {
    padding: 10px 15px;
    border: 1px solid #ddd;
}

th {
    background-color: #f2f2f2;
    text-transform: uppercase;
    font-weight: bold;
}

td {
    color: #555;
}

tr:hover {
    background-color: #f5f5f5;
}
/* Add these styles to your existing CSS file or create a new one */

table {
    border-collapse: collapse;
    width: 100%;
}

table, th, td {
    border: 1px solid black;
}

th, td {
    padding: 10px;
    text-align: left;
}

th {
    background-color: #f2f2f2;
}

button {
    background-color: #027cba;
    /* background-color: #ff0000;  */
    color: #fff; /* White text color */
    border: none;
    padding: 5px 10px;
    text-align: center;
    text-decoration: none;
    display: inline-block;
    font-size: 14px;
    cursor: pointer;
}

button:hover {
    background-color: #cc0000; /* Darker red on hover */
}
body {
            font-family: Arial, sans-serif;
            margin: 50px;
            background-color: #f4f4f4;
        }
 
        h2 {
            color: #444;
            text-align: center;
            margin-bottom: 30px;
        }
 
        table {
            width: 100%;
            max-width: 70%;
            margin: 0 auto;
            border-collapse: collapse;
            background-color: #fff;
            box-shadow: 0 2px 12px rgba(0, 0, 0, 0.1);
        }
 
        th, td {
            padding: 10px 15px;
            border: 1px solid #ddd;
        }
 
        th {
            background-color: #f2f2f2;
            text-transform: uppercase;
            font-weight: bold;
        }
 
        td {
            color: #555;
        }
 
        tr:hover {
            background-color: #f5f5f5;
        }

        /* Mobile devices */
@media only screen and (max-width: 600px) {
    body {
        margin: 20px; /* Reduced margin for mobile screens */
    }
    
    h2 {
        margin-bottom: 20px; /* Reduced margin-bottom for mobile screens */
    }

    table {
        max-width: 100%; /* Full width on mobile screens */
        margin: 0; /* Remove margin to use the full width */
        box-shadow: none; /* Optional: remove shadow to fit better on smaller screens */
    }

    th, td {
        padding: 8px; /* Reduced padding for mobile screens */
    }

    /* Adjust button size for mobile */
    button {
        padding: 5px 8px;
        font-size: 12px;
    }

    /* If you have a navigation menu or other elements, add responsive adjustments here */
}

/* Tablet devices */
@media only screen and (min-width: 601px) and (max-width: 1024px) {
    body {
        margin: 30px; /* Slightly larger margin for tablet screens */
    }

    h2 {
        margin-bottom: 25px; /* Adjusted margin-bottom for tablet screens */
    }

    table {
        max-width: 90%; /* Adjust max-width for tablet screens for better readability */
    }

    th, td {
        padding: 9px; /* Adjusted padding for tablet screens */
    }

    /* Adjust button size for tablet */
    button {
        padding: 6px 9px;
        font-size: 13px;
    }

    /* Add any additional tablet-specific styles here */
}
    </style>
    <!-- <link rel="stylesheet" href="style1.css">
    <link rel="stylesheet" href="style2.css">
    <link rel="stylesheet" href="style11.css"> -->
</head>
<body>
    
</body>
</html>
