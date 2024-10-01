<?php /* Template Name: gas-calculator */?>
<?php get_header(); ?>
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
<script src='https://api.mapbox.com/mapbox-gl-js/v2.3.1/mapbox-gl.js'></script>
<link href='https://api.mapbox.com/mapbox-gl-js/plugins/mapbox-gl-directions/v4.0.0/mapbox-gl-directions.css' rel='stylesheet' />
<script src='https://api.mapbox.com/mapbox-gl-js/plugins/mapbox-gl-directions/v4.0.0/mapbox-gl-directions.js'></script>
<style>
    .main-container {
    display: flex;
    flex-wrap: nowrap; /* Prevents flex items from wrapping */
    gap: 20px; /* Adjusts the gap between the form and map */
}

.left-container,
.right-container {
    flex: 1; /* Allows both children to grow */
}

#map {
    width: 650px; /* Ensures that the map takes the full width of its container */
    /* If you set a max-height, ensure it's reasonable so the map is not too small */
    height: 595px; /* Adjusts the height of the map */
    border-radius: 8px;
    box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
}
    form {
    background-color: #ffffff;
    padding: 20px;
    width: 100%; 
    border-radius: 10px;
    box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
    margin:0px;
    /* padding: 20px; */
}
.mapboxgl-ctrl-directions {
    width: 100%;
    min-width: 100px;
    max-width: 1200px;
}
label {
    display: block;
    margin-bottom: 5px;
    font-weight: bold;
    color: #555;
}
input[type="text"], select {
    width: 100%;
    padding: 10px;
    margin-bottom: 20px;
    border: 1px solid #ddd;
    border-radius: 5px;
    font-size: 16px;
}
input[type="submit"] {
    background-color: #ff6600;
    color: #fff;
    border: none;
    border-radius: 5px;
    padding: 10px 15px;
    font-size: 16px;
    cursor: pointer;
    transition: background-color 0.3s ease;
}
input[type="submit"]:hover {
    background-color: #00b32a;
}
/* Add some styles for divs containing additional options */
div[id$="Options"] {
    background-color: #f7f7f7;
    padding: 10px;
    border-radius: 5px;
    margin-bottom: 20px;
}

/* cost estimation container */
 #share-button {
    width:100% !important;
    display: block; /* Make the button a block element to fill the form width */
    width: calc(100% - 20px); /* Subtract padding from the width */
    padding: 8px 15px; /* Padding inside the button */
    margin: 10px auto; /* Center the button with automatic horizontal margins */
    background-color: transparent; /* Transparent background */
    color: #027CBA;/* Blue text color */
    border: 2px solid #027CBA; /* Blue border */
    border-radius: 10px; /* Rounded corners */
    font-size: 16px; /* Text size */
    cursor: pointer; /* Cursor changes to pointer to indicate it's clickable */
    text-align: center; /* Align the text and icon to the left */
    transition: all 0.3s ease; /* Smooth transition for hover effects */
    text-decoration: none; /* Remove underline from text */
    position: relative; /* Positioning context for the icon */
}
 #share-button:hover {
    background-color: rgba(0, 123, 255, 0.1); /* Slight blue background on hover */
    border-color: #0056b3; /* Slightly darker border on hover */
    color: #027CBA;
}
 #share-button:before {
    content: ''; /* Add before pseudo-element for the icon */
    display: inline-block; /* Make the pseudo-element an inline block */
    height: 16px; /* Icon height */
    width: 16px; /* Icon width */
    background-size: cover; /* Cover the area with the background image */
    margin-right: 10px; /* Space between the icon and text */
    vertical-align: middle; /* Align the icon vertically with the text */
}
#share-button:before {
    background-image: url('https://www.personaldrivers.com/wp-content/uploads/share.png'); /* Your share icon URL here */
}
label {
    display: block;
    margin-bottom: 8px;
    font-weight: 600;
    color: #333;
    font-size: 15px;
}
input[type="text"], select, .pac-target-input {
    max-width: 1200px;
    background-color: #eeeeee;
    /* padding: 13px 15px; */
    /* margin:-8px; */
    margin-bottom: 5px;
    border: 2px solid #e6e6e6;
    border-radius: 6px;
    font-size: 16px;
    color: #666 !important;
    width: 100%;
}
input[type="submit"] {
    background-color: #027CBA;
    color: #fff;
    border: none;
    border-radius: 8px;
    padding: 10px 20px;
    font-size: 16px;
    cursor: pointer;
    transition: background-color 0.3s ease;
    box-shadow: 5px 5px 10px 0 rgba(0,0,0,.1);
    width: 100%;
}
input[type="submit"]:hover {
    background-color: #333;
}
.select-list {max-width: 600px;}
div[id$="Options"] {
    background-color: #f7f7f7;
    padding: 10px;
    border-radius: 5px;
    margin-bottom: 20px;
}
.mapbox-directions-route-summary {
    /* display: none;  */
    background-color:#027CBA;
}
.mapbox-directions-route-summary {
    font-size: 18px; /* Adjust the font size as needed */
    text-align:center;
}
/* Add this CSS to hide the turn-by-turn directions panel */
.mapbox-directions-instructions {
    display: none;
}
.mapboxgl-ctrl-attrib-button
{
    display:none;
}
.mapboxgl-ctrl-attrib-inner{
    display:none;
}
#share-modal {
    position: fixed;
    top: 50%;
    left: 50%;
    transform: translate(-50%, -50%);
    background-color: white;
    padding: 20px;
    border-radius: 5px;
    box-shadow: 0px 0px 10px rgba(0, 0, 0, 0.25);
    z-index: 1000; /* Ensure it's above other elements */
    display: none; /* Hidden by default */
}
/* Share Icons Container */
#share-icons {
    text-align: center;
    padding: 10px 0;
}
/* Icon Style */
#share-icons a {
    margin: 0 10px;
    display: inline-block;
}
#share-icons img {
    margin:5px;
    width: 20px;  /* Adjust the size as needed */
    height: 20px; /* Adjust the size as needed */
}
/* Close Button Style */
#close-modal {
    display: block;
    margin: 20px auto;
    padding: 10px 20px;
    background-color: #027cba; /* Blue background */
    color: white; /* White text */
    border: none;
    border-radius: 5px;
    cursor: pointer;
    font-size: 16px;
}
#close-modal:hover {
    background-color: #333333; /* Darker blue background on hover */
}
#qr-code-container{
    margin-bottom:10px;
}
.dropdown {
    width: 100%;
    position: relative;
    max-width: 1200px;
    min-width: 200px;
  font-size: 13px;
}
.dropdown-options {
    display:none;
    position: absolute;
    background-color: #ffffff;
    box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
    border: 1px solid #ccc;
    border-radius: 6px;
    max-height: 300px;
    overflow-y: auto;
    width: 100%; /* Set the width to match the parent */
    z-index: 100; /* Make sure it's on top of other elements */
    top: 100%; /* Position right below the dropdown-selected */
    right: 0; /* Align to the left edge of the dropdown-selected */
}
.dropdown-options li {
  display: flex;
  align-items: center;
  justify-content: space-between;
  padding: 10px;
  cursor: pointer;
  border-bottom: 1px solid #eee; /* Adds a light border to each dropdown item */
}
.dropdown-options li:hover {
  background-color: #f6f6f6;
}

.dropdown-options img{
height:28px !important;
}

.dropdown-selected img{
    height:30px !important;
}
.dropdown-selected {
    display: flex;
    align-items: center; /* Align items vertically */
    justify-content: space-between; /* Space out the child elements */
    width: 415px; 
    padding: 10px;
    background-color: #fff;
    border: 1px solid #ccc; /* Same border as the select element */
    border-radius: 6px; /* Rounded corners */
    cursor: pointer;
    position: relative; /* Required to position the arrow icon */
    z-index: 10; /* Stack order */
}
.dropdown-selected span {
    margin-right: 5px; /* Adjust the gap as needed */
    white-space: nowrap;
    flex-grow: 1; /* Allows the text to take up available space */
    font-size:14px;
}
.dropdown-selected:after {
    /* content: ''; */
    position: absolute;
    right: 10px; /* Adjust as needed for spacing */
    top: 50%;
    transform: translateY(-50%);
    border: 5px solid transparent; /* Creates a triangle */
    border-top-color: #000; /* Triangle color */
}
.mapbox-directions-route-summary h1 {
    font-weight: 800;
    color:white;
    display: inline;
    font: 20px 'Helvetica Neue', Arial, Helvetica, sans-serif;
}
.mapbox-directions-route-summary span {
    /* color: rgba(255,255,255,0.5); */
    color:white;
    font-size: 20px;
    margin: 0 5px;
}
#Trip{
    padding:5px;
}

.form-map-container {
    display: flex;
    flex-direction: column; /* Stack vertically on mobile */
    width: 100%; /* Full width of the container */
    align-items: center; /* Center-align children */
    margin-top: 20px;
}
/* Overlay for the popup */
.overlay {
    position: fixed;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    background: rgba(0, 0, 0, 0.5); /* Semi-transparent black background */
    display: flex;
    justify-content: center;
    align-items: center;
    z-index: 1000; /* Ensure it's above other elements */
}
/* Toll cost estimation container modified for popup */
#toll-cost-estimation {
    background-color: #ffffff;
    width: 40%; /* or any other size you prefer */
    max-width: 1200px; /* Adjust the max-width as needed */
    padding: 20px;
    margin: 0; /* Reset margin */
    box-shadow: 0 2px 4px rgba(0,0,0,0.3); /* More prominent shadow */
    border-radius: 8px;
    height: auto; /* Auto height */
    z-index: 1001; /* Above the overlay */
    position: relative; /* For positioning close button */
}
/* Title of the toll cost estimation panel */
#toll-cost-estimation h2 {
    background-color: #027CBA; /* Blue background */
    color: white; /* White text color */
    padding: 10px;
    border-radius: 4px; /* Rounded corners for the title */
    text-align:center;
}
#toll-cost-estimation table {
    width: 100%; /* Full width of the container */
    margin-top: 20px; /* Space between title and table */
    border-collapse: collapse; /* Collapse the borders */
}
#toll-cost-estimation th,
#toll-cost-estimation td {
    text-align: left;
    padding: 6px;
    font-size:16px;
    border-bottom: 1px solid #dee2e6; /* Light border for each row */
}
#toll-cost-estimation th {
    background-color: #027CBA; /* Blue background for header */
    color: white; /* White text color */
}
table {
    width: 100%;
    height:400px;
    max-width: 1200px;
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
.close-btn {
    margin: 1%;
    margin-left: 93%;
    position: relative;
    /* top: -10px;
    right: -10px; */
    border: none;
    background: #027CBA;
    color: #fffff;
    border-radius: 100%;
    width: 48px;
    /* height: 30px; */
    font-size: 16px;
    line-height: 20px;
    font-weight: 500;
    box-shadow: 0 4px 10px rgba(0, 0, 0, 0.2);
    z-index: 10;
}
#toll-cost-estimation #print-button {
    background-color: #027CBA; /* Match the header color */
    color: white; /* Text color */
    padding: 10px 20px; /* Padding for the button */
    margin-top: 10px; /* Space from the content above */
    border: none; /* No border */
    border-radius: 4px; /* Rounded corners */
    cursor: pointer; /* Pointer cursor on hover */
    font-size: 1rem; /* Font size */
    float:right;
}
#result-share-button{
    background-color: #027CBA; /* Match the header color */
    color: white; /* Text color */
    padding: 10px 20px; /* Padding for the button */
    margin-top: 10px; /* Space from the content above */
    margin-right: 10px; /* Space from the content above */
    border: none; /* No border */
    border-radius: 4px; /* Rounded corners */
    cursor: pointer; /* Pointer cursor on hover */
    font-size: 1rem; /* Font size */
    float:right;
}
@media only screen and (max-width: 760px) {
   
    form {
    margin: 0;
    padding: 0;
}
    #toll-cost-estimation {
    background-color: #ffffff;
    width: 100%; /* or any other size you prefer */
    max-width: 1200px; /* Adjust the max-width as needed */
    padding: 20px;
    margin: 0; /* Reset margin */
    box-shadow: 0 2px 4px rgba(0,0,0,0.3); /* More prominent shadow */
    border-radius: 8px;
    height: auto; /* Auto height */
    z-index: 1001; /* Above the overlay */
    position: relative; /* For positioning close button */
}
    /* Style the header of the popup to prevent word wrapping */
    #toll-cost-estimation h2 {
        font-size: 20px; /* Reduce font size to prevent wrapping */
        white-space: nowrap; /* Prevent wrapping */
        overflow: hidden; /* Hide overflow */
        text-overflow: ellipsis; /* Add ellipsis if the text is too long */
        padding: 10px; /* Adjust padding to reduce space */
    }
    /* Adjust the styling for form elements to ensure they fit within the popup */
    #toll-cost-estimation form {
        width: 100%; /* Ensure form elements do not overflow the popup width */
    }
    /* Adjust dropdowns and inputs to fit within the popup */
    #toll-cost-estimation .dropdown-selected,
    #toll-cost-estimation input[type="text"],
    #toll-cost-estimation select {
        width: 100%; /* Make these elements take up the full width of the popup */
        box-sizing: border-box; /* Include padding and borders in the width calculation */
    }
    .close-btn {
    margin: 10px;
    /* position: absolute; */
    top: -10px;
    right: -10px;
    border: none;
    background: #027CBA;
    color: #fffff;
    border-radius: 100%;
    width: 48px;
    /* height: 30px; */
    font-size: 18px;
    line-height: 10px;
    text-align: center;
    cursor: pointer;
    top: 100%;
    right: 0;
    box-shadow: 0 4px 10px rgba(0, 0, 0, 0.2);
    z-index: 10;
}
.dropdown-selected {
    width:100%;
    display: flex;
    align-items: center;
    justify-content: space-between;
    padding: 10px;
    border: 1px solid #ccc;
    border-radius: 6px;
    cursor: pointer;
    position: relative;
    overflow: hidden; /* Ensure that contents don't overflow */
  }
  .dropdown-selected span {
    display: block;
    white-space: nowrap;
    overflow: hidden;
    text-overflow: ellipsis;
    max-width: calc(100%); /* Reserve space for image and padding */
  }
  .dropdown{
    font-size: 12px;
  }
  .dropdown-options {
        display: none; /* Hide by default */
        position: absolute;
        width: calc(100% - 20px); /* Full width minus padding */
        top: 100%; /* Position right below the dropdown-selected */
        left: 0; /* Align with the left edge */
        background-color: #ffffff;
        box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
        border: 1px solid #ccc;
        border-radius: 6px;
        max-height: 300px;
        overflow-y: auto;
        z-index: 100;
        width: 100%; /* Full width of the dropdown */
    box-sizing: border-box; /* Include padding and borders in the width */
    right:0;
    margin:0;
    padding:0;
    }
    .dropdown-options li img{
        height:20px;
    }
    .main-container {
        flex-direction: column;
    }

    .left-container,
    .right-container {
        width: 100%;
        box-sizing: border-box;
    }

    #map {
        width: 100%; /* Make the map width responsive */
        height: auto; /* Adjust height as necessary, or keep it fixed if preferred */
        max-height: 400px; /* Optional: you can set a maximum height */
        margin: 0 auto; /* Center the map */
    }
    /* Ensures that padding and border are included in the width and height */
    *, *:before, *:after {
        box-sizing: border-box;
    }
    /* Additional style adjustments for the form and map */
    form {
        width: 100%;
        box-shadow: none;
    }
    input[type="text"], select, .pac-target-input, .dropdown-selected {
        /* Remove or reduce margins to ensure elements do not extend outside their container */
        margin: 0;
        max-width: none; /* This ensures the input uses the full width of its container */
    }
    /* Further styling adjustments for smaller screens */
#qr-code-container img {
        width: 100%; /* Make QR code responsive to container width */
        max-width: 300px; /* Set a max-width if needed */
        height: auto; /* Maintain aspect ratio */
    }
    /* Ensure the QR code container has padding or margin if needed so it doesn't touch the edges of the screen */
    #qr-code-container {
        padding: 10px;
        text-align: center; /* Center the QR code within the container */
    } 
}
#back-button {
    margin-top: 10px;
    background-color: #027CBA; /* Green background */
    color: white; /* White text */
    padding: 10px 20px; /* Padding for size */
    border: none; /* No border */
    border-radius: 4px; /* Rounded corners */
    cursor: pointer; /* Cursor indicates it's clickable */
    font-size: 1rem; /* Font size */
    transition: background-color 0.3s; /* Smooth transition for hover effect */
}
#new-search {
    width:100% !important;
    display: block; /* Make the button a block element to fill the form width */
    width: calc(100% - 20px); /* Subtract padding from the width */
    padding: 8px 15px; /* Padding inside the button */
    margin: 10px auto; /* Center the button with automatic horizontal margins */
    background-color: transparent; /* Transparent background */
    color: #027CBA; /* Blue text color */
    border: 2px solid #027CBA; /* Blue border */
    border-radius: 10px; /* Rounded corners */
    font-size: 16px; /* Text size */
    cursor: pointer; /* Cursor changes to pointer to indicate it's clickable */
    text-align: center; /* Align the text and icon to the left */
    transition: all 0.3s ease; /* Smooth transition for hover effects */
    text-decoration: none; /* Remove underline from text */
    position: relative; /* Positioning context for the icon */
}
#new-search:hover {
    background-color: rgba(0, 123, 255, 0.1); /* Slight blue background on hover */
    border-color: #0056b3; /* Slightly darker border on hover */
    color: #027CBA;
}
@media (max-width: 767px)
{
.gb-container-614b9fa9 {
    text-align: left;
    padding: 20px 30px;
    margin-top: 20px;
}
}
@media print {
    /* This will hide the print button when printing */
    #print-button, #back-button, #result-share-button, #close-btn {
        display: none !important;
    }
    /* Any additional print styles you want to add */
    #toll-cost-estimation {
        box-shadow: none; /* Removes shadow for printing */
        position: absolute;
        width:100%;
        justify-content:center;
        left: 0;
        top: 0;
    }
    /* Ensure the overlay doesn't affect print layout */
    .overlay {
        background: none;
        position: static;
    }
    /* Hide everything else on the page */
    body * {
        visibility: hidden;
        
    }
    /* Only the toll-cost-estimation div will be visible */
    #toll-cost-estimation, #toll-cost-estimation * {
        visibility: visible;
        page-break-inside: avoid; /* Avoids breaking inside the element */
        box-shadow: none; /* Removes shadow */      
    }
}

/* @media (max-width: 900px)
{
    #map {
    width: 250px; 
    height: 580px; 
    border-radius: 8px;
    box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
}
} */
/* @media only screen and (max-width: 760px and max-width: 1140px)
{
    #map {
    width: 450px; 
    height: 580px; 
    border-radius: 8px;
    box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
}
} */

@media only screen and (min-width: 761px) and (max-width: 860px) {
    #map {
        width: 280px; 
        height: 580px; 
        border-radius: 8px;
        box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
    }
   
}

@media only screen and (min-width: 861px) and (max-width: 960px) {
    #map {
        width: 380px; 
        height: 580px; 
        border-radius: 8px;
        box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
    }
    
    
}
@media only screen and (min-width: 961px) and (max-width: 1060px) {
    #map {
        width: 450px; 
        height: 580px; 
        border-radius: 8px;
        box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
    }
}
@media only screen and (min-width: 1061px) and (max-width: 1145px) {
    #map {
        width: 550px; 
        height: 580px; 
        border-radius: 8px;
        box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
    }
}

</style>
</head>
<body>
<?php
session_start(); // Ensure session is started
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Assign POST values to session variables
    $_SESSION['fromCity'] = $_POST['fromCity'];
    $_SESSION['toCity'] = $_POST['toCity'];
    $_SESSION['Trip'] = $_POST['Trip'];
    $_SESSION['type_of_vehicle'] = $_POST['type_of_vehicle'] ?? 'Car/SUV or Pickup Truck'; // Set default if not provided
} else {
    // Default values if not set
    if (!isset($_SESSION['type_of_vehicle'])) {
        $_SESSION['type_of_vehicle'] = 'Car/SUV or Pickup Truck';
    }
}
// Helper functions
function getFormFieldValue($fieldName) {
    return isset($_SESSION[$fieldName]) ? htmlspecialchars($_SESSION[$fieldName], ENT_QUOTES) : '';
}

function getSelectedOption($optionValue, $fieldName) {
    return isset($_SESSION[$fieldName]) && $_SESSION[$fieldName] == $optionValue ? 'selected' : '';
}
?>
<div class="container">
    <!-- <h1>Gas Calculator</h1>
    <h2 style="font-size:21px; display:block; font-weight:400;">Gas Calculator for planning your next road trip</h2> -->
<div class="main-container">
<div class="left-container">
    <form method="post">
        <label for="fromCity">From City:</label>
        <input type="text" id="fromCity" name="fromCity" placeholder="Enter address" value="<?php echo isset($_POST['fromCity']) ? htmlspecialchars($_POST['fromCity'], ENT_QUOTES) : ''; ?>" required><br><br>

        <label for="toCity">To City:</label>
        <input type="text" id="toCity" name="toCity" placeholder="Enter address" value="<?php echo isset($_POST['toCity']) ? htmlspecialchars($_POST['toCity'], ENT_QUOTES) : ''; ?>" required><br><br>

        <label for="type_of_vehicle">Type of Vehicle:</label>
        <div class="dropdown">
  <div class="dropdown-selected">
  <span id="vehicle-display">Car/SUV or Pickup Truck (2-Axles)</span>
        <input type="hidden" id="type_of_vehicle" name="type_of_vehicle" value="Car/SUV or Pickup Truck">
        <img width="70px" height="30px" class="selected-icon" src="https://www.personaldrivers.com/wp-content/uploads/car-2axle.svg" title = "Car 2 Axle Fare Calculator Icon"  alt="Icon Representing a 2-Axle Car for Fare Calculation" />
  </div>
  <ul class="dropdown-options" style="padding:0">
  <li data-value="Car/SUV or Pickup Truck">Car/SUV or Pickup Truck (2-Axles)  
  &nbsp; <img width="auto" height="auto" src="https://www.personaldrivers.com/wp-content/uploads/car-2axle.svg" title = "Car 2 Axle Fare Calculator Icon"  alt="Icon Representing a 2-Axle Car for Fare Calculation" />
</li>
<li data-value="Car/SUV or Pickup Truck (1-Axle-Trailer)">
  Car/SUV or Pickup Truck (1-Axle-Trailer)
  <img width="auto" height="auto" src="https://www.personaldrivers.com/wp-content/uploads/car-1axletrailer.svg" title="Car with attached one -axle trailer" alt="2 axle car towing a one-axle trailer icon" />
</li>
<li data-value="Car/SUV or Pickup Truck (2-Axle-Trailer)">
  Car/SUV or Pickup Truck (2-Axle-Trailer)
  <img width="auto" height="auto" src="https://www.personaldrivers.com/wp-content/uploads/car-2axletrailer.svg" title="Car with attached two -axle trailer" alt="Car with Two -Axle Trailer Icon" />
</li>
<li data-value="Moving Truck or Box Truck (2-Axles)">
  Moving Truck or Box Truck (2-Axles)
  <img  width="auto" height="auto" src="https://www.personaldrivers.com/wp-content/uploads/moving-truck-2axles.svg" title="Two-Axle Moving Truck Icon" alt="Moving Truck with two axle icon " />
</li>
<li data-value="Dual-Axle Box Truck with 1-Axle Trailer">
Dual-Axle Box Truck with 1-Axle Trailer
  <img width="auto" height="auto" src="https://www.personaldrivers.com/wp-content/uploads/truck-1axle-trailer.svg" title="Icon of a dual-axle box truck with a one-axle trailer" alt="dual-axle box truck with a one-axle trailer icon" />
</li>
<li data-value="Dual-Axle Box Truck with 2-Axle Trailer">
Dual-Axle Box Truck with 2-Axle Trailer
   <img width="auto" height="auto" src="https://www.personaldrivers.com/wp-content/uploads/truck-2axle-trailer.svg" title="Icon of a dual-axle box truck with a two-axle trailer" alt="dual-axle box truck with a two-axle trailer icon" />
</li>
<li data-value="Dual-Axle Box Truck with 3-Axle Trailer">
Dual-Axle Box Truck with 3-Axle Trailer
  <img width="auto" height="auto" src="https://www.personaldrivers.com/wp-content/uploads/truck-3axle-trailer.svg" title="Dual-Axle Box Truck with Three-Axle Trailer Icon" alt="Dual-Axle Box Truck with Three-Axle Trailer Icon" />
</li>
<li data-value="Moving Truck or Box Truck (3-Axles)">
Moving Truck or Box Truck (3-Axles)
  <img width="auto" height="auto" src="https://www.personaldrivers.com/wp-content/uploads/truck2.svg" title="Moving or Box Truck with Three Axles Icon" alt="Moving or Box Truck with Three Axles Icon" />
</li>
<li data-value="Three-Axle Box Truck with 1-Axle Trailer">
Three-Axle Box Truck with 1-Axle Trailer
  <img width="auto" height="auto" src="https://www.personaldrivers.com/wp-content/uploads/truck2-1axle-trailer.svg" title="Three-Axle Box Truck with One-Axle Trailer Icon" alt="Three-Axle Box Truck with One-Axle Trailer Icon" />
</li>
<li data-value="Three-Axle Box Truck with 2-Axle Trailer">
Three-Axle Box Truck with 2-Axle Trailer
  <img width="auto" height="auto" src="https://www.personaldrivers.com/wp-content/uploads/truck2-2axle-trailer.svg" title="Three-Axle Box Truck with Two-Axle Trailer Icon" alt="Three-Axle Box Truck with Two-Axle Trailer Icon" />
</li>
<li data-value="Three-Axle Box Truck with 3-Axle Trailer">
Three-Axle Box Truck with 3-Axle Trailer
  <img width="auto" height="auto" src="https://www.personaldrivers.com/wp-content/uploads/truck2-3axle-trailer.svg" title="Three-Axle Box Truck with Three-Axle Trailer Icon" alt="Three-Axle Box Truck with Three-Axle Trailer Icon" />
</li>
<li data-value="RV (2-Axles)">
  RV (2-Axles)
  <img width="auto" height="auto" src="https://www.personaldrivers.com/wp-content/uploads/RV-2axle.svg" title="RV with two axles" alt="Two Axle RV icon" />
</li>
<li data-value="Two-Axle RV with 1-Axle Trailer">
Two-Axle RV with 1-Axle Trailer
  <img width="auto" height="auto" src="https://www.personaldrivers.com/wp-content/uploads/RV-1axle-trailer.svg" title="Two-Axle RV with One-Axle Trailer Icon" alt="Two-Axle RV with One-Axle Trailer Icon" />
</li>
<li data-value="RV (3-Axles)">
RV (3-Axles)
  <img width="auto" height="auto" src="https://www.personaldrivers.com/wp-content/uploads/rv-3axle.svg" title="Three-Axle RV icon" alt="Three-Axle RV icon" />
</li>
<li data-value="Three-Axle RV with 1-Axle Trailer">
Three-Axle RV with 1-Axle Trailer
  <img width="auto" height="auto" src="https://www.personaldrivers.com/wp-content/uploads/rv2-1axletrailer.svg" title="Three-Axle RV with One-Axle Trailer Icon" alt="Three-Axle RV with One-Axle Trailer Icon" />
</li>
<li data-value="Bus (2-Axles)">
  Bus (2-Axles)
  <img width="auto" height="auto" src="https://www.personaldrivers.com/wp-content/uploads/bus-2axle.svg" title="Two-Axle Bus Icon" alt="Two-Axle Bus Icon" />
</li>
<li data-value="Bus (3-Axles)">
  Bus (3-Axles)
  <img width="auto" height="auto" src="https://www.personaldrivers.com/wp-content/uploads/bus-3axle.svg" title="Three-Axle Bus Icon" alt="Three-Axle Bus Icon" />
</li>
  </ul>
</div>
<br>
        <label for="Trip">Trip Type:</label>
        <select id="Trip" name="Trip">
        <option value="OneWay" <?php echo getSelectedOption('OneWay', 'Trip'); ?>>One Way</option>
        <option value="Return" <?php echo getSelectedOption('Return', 'Trip'); ?>>Return</option>  
        </select><br><br>
        <input type="hidden" id="distanceField" name="distanceField">
        <input type="submit" value="Calculate">
        <button type="button" id="new-search">New Search</button>
        <button id="share-button">Share</button>
    </form>
<div id="share-modal" style="display: none;">
    <div id="share-icons">
        <h3 style="text-align:center;">Share with</h3>
        <div id="qr-code-container">
</div>
<a id="share-whatsapp" href="#"><img src="https://www.personaldrivers.com/wp-content/uploads/whatsapp.png" alt="Share on WhatsApp"></a>
<a id="share-facebook" href="#"><img src="https://www.personaldrivers.com/wp-content/uploads/facebook.png" alt="Share on Facebook"></a>
<a id="share-email" href="#"><img src="https://www.personaldrivers.com/wp-content/uploads/gmail.png" alt="Share via Email"></a>
<a id="share-linkedin" href="#"><img src="https://www.personaldrivers.com/wp-content/uploads/linkedin.png" alt="Share on LinkedIn"></a>
<a id="share-twitter" href="#"><img src="https://www.personaldrivers.com/wp-content/uploads/twitter.png" alt="Share on Twitter"></a>
<a id="copy-link" href="#"><img src="https://www.personaldrivers.com/wp-content/uploads/link.png" alt="Copy Link"></a>
    </div>
    <button id="close-modal">Close</button>
</div>
</div>
    <div class="right-container">
    <div id="map" ></div> 
    </div>
</div>
</div>

    <?php if ($_SERVER["REQUEST_METHOD"] == "POST"): ?>
<?php
$form_data = $_POST;
$vehicleTypeMapping = array(
    'Car/SUV or Pickup Truck' => '2AxlesAuto',
    'Car/SUV or Pickup Truck (1-Axle-Trailer)' => '3AxlesAuto',
    'Car/SUV or Pickup Truck (2-Axle-Trailer)' => '4AxlesAuto',
        'Moving Truck or Box Truck (2-Axles)' => '2AxlesTruck',
        'Dual-Axle Box Truck with 1-Axle Trailer' => '3AxlesTruck',
        'Dual-Axle Box Truck with 2-Axle Trailer' => '4AxlesTruck',
        'Dual-Axle Box Truck with 3-Axle Trailer' => '5AxlesTruck',
    'Moving Truck or Box Truck (3-Axles)' => '3AxlesTruck',
    'Three-Axle Box Truck with 1-Axle Trailer' => '4AxlesTruck',
    'Three-Axle Box Truck with 2-Axle Trailer' => '5AxlesTruck',
    'Three-Axle Box Truck with 3-Axle Trailer' => '6AxlesTruck',
        'RV (2-Axles)' => '2AxlesRv',
        'Two-Axle RV with 1-Axle Trailer' => '3AxlesRv',
        'RV (3-Axles)' => '3AxlesRv',
        'Three-Axle RV with 1-Axle Trailer' => '4AxlesRv',
        'Bus (2-Axles)' => '2AxlesBus',
        'Bus (3-Axles)' => '3AxlesBus'
);
$apiVehicleType = isset($vehicleTypeMapping[$form_data['type_of_vehicle']]) ? $vehicleTypeMapping[$form_data['type_of_vehicle']] : '2AxlesAuto';
if ($apiVehicleType == 'Car/SUV or Pickup Truck') {
    $vehicleType = "2AxlesAuto";
}
elseif ($apiVehicleType == 'Car/SUV or Pickup Truck (1-Axle-Trailer)') {
    $apiVehicleType = "3AxlesAuto";
}
elseif ($apiVehicleType == 'Car/SUV or Pickup Truck (2-Axle-Trailer)') {
    $apiVehicleType = "4AxlesAuto";
}
elseif ($apiVehicleType == 'Moving Truck or Box Truck (2-Axles)') {
    $vehicleType = "2AxlesTruck";
}
elseif ($apiVehicleType == 'Dual-Axle Box Truck with 1-Axle Trailer') {
    $vehicleType = "3AxlesTruck";
}
elseif ($apiVehicleType == 'Dual-Axle Box Truck with 2-Axle Trailer') {
    $vehicleType = "4AxlesTruck";
}
elseif ($apiVehicleType == 'Dual-Axle Box Truck with 3-Axle Trailer') {
    $vehicleType = "5AxlesTruck";
}
elseif ($apiVehicleType == 'Moving Truck or Box Truck (3-Axles)') {
    $vehicleType = "3AxlesTruck";
}
elseif ($apiVehicleType == 'Three-Axle Box Truck with 1-Axle Trailer') {
    $vehicleType = "3AxlesTruck";
}
elseif ($apiVehicleType == 'Three-Axle Box Truck with 2-Axle Trailer') {
    $vehicleType = "5AxlesTruck";
}
elseif ($apiVehicleType == 'Three-Axle Box Truck with 3-Axle Trailer') {
    $vehicleType = "6AxlesTruck";
}
  elseif ($apiVehicleType == 'RV (2-Axles)') {
    $apiVehicleType = "2AxlesRv";
}
elseif ($apiVehicleType == 'Two-Axle RV with 1-Axle Trailer') {
    $apiVehicleType = "3AxlesRv";
}
elseif ($apiVehicleType == 'RV (3 Axles)') {
    $apiVehicleType = "4AxlesRv";
}
elseif ($apiVehicleType == 'Three-Axle RV with 1-Axle Trailer') {
    $apiVehicleType = "4AxlesRv";
}
elseif ($apiVehicleType == 'Bus (2-Axles)') {
    $apiVehicleType = "2AxlesBus";
}
elseif ($apiVehicleType == 'Bus (3-Axles)') {
    $apiVehicleType = "3AxlesBus";
};
$payload = array(
    "from" => array("address" => $form_data["fromCity"] ),
    "to" => array("address" => $form_data["toCity"] ),
    "vehicleType" => $apiVehicleType
);
$postFields = json_encode($payload);
$curl = curl_init();
curl_setopt_array($curl, [
    CURLOPT_URL => "https://apis.tollguru.com/toll/v2/origin-destination-waypoints",
    CURLOPT_RETURNTRANSFER => true,
    CURLOPT_CUSTOMREQUEST => "POST",
    CURLOPT_POSTFIELDS => $postFields,
    CURLOPT_HTTPHEADER => [
        "content-type: application/json",
        "x-api-key: dGj8Rn4tDpp7bjmGjLrDr293tg8m3F4F"  
    ],
]);
$response = curl_exec($curl);
curl_close($curl);
// Decode the API response
$response_data = json_decode($response, true);
// Extract distance in meters from the API response
$distanceInMeters = $response_data['routes'][0]['distance'] ?? 0;
// Convert distance from meters to miles (1 meter = 0.000621371 miles)
$distanceInMiles = $distanceInMeters * 0.000621371;
// Decode and display the response (for testing purposes)
$response_data = json_decode($response, true);
// Extracting the toll price from API Response
$initialOneWaytollCost = 0;  // initialize with default value
if (isset($response_data['routes'][0]['summary']['hasTolls']) && $response_data['routes'][0]['summary']['hasTolls'] == 1) {
    $costs = $response_data['routes'][0]['costs'];
 
    if (!empty($costs['tag'])) {
        $initialOneWaytollCost = $costs['tag'];
    } elseif (!empty($costs['cash'])) {
        $initialOneWaytollCost = $costs['cash'];
    } elseif (!empty($costs['licensePlate'])) {
        $initialOneWaytollCost = $costs['licensePlate'];
    } elseif (!empty($costs['prepaidCard'])) {
        $initialOneWaytollCost = $costs['prepaidCard'];
    }
}
// Integrating the provided code snippet to extract fuel cost from API Response
$initialOneWayfuel = 0; // default value
if (!empty($response_data['routes'][0]['costs']['fuel'])) {
    $initialOneWayfuel = $response_data['routes'][0]['costs']['fuel'];
}
$apiVehicleType = isset($vehicleTypeMapping[$form_data['type_of_vehicle']]) ? $vehicleTypeMapping[$form_data['type_of_vehicle']] : '2AxlesAuto';
// Calculate the Return Trip Fuel Cost if 'Trip' is 'Return'
$initialReturnfuel = 0;
$initialReturntollCost = 0;
if($form_data["Trip"] == "Return") {
    $initialReturnfuel = $initialOneWayfuel;
    $initialReturntollCost = $initialOneWaytollCost;
}
// Define fuel efficiency for each vehicle type
$fuelEfficiencyMapping = array(
    'Car/SUV or Pickup Truck' => array('city' => 20, 'highway' => 27),
    'Car/SUV or Pickup Truck (1-Axle-Trailer)' => array('city' => 18, 'highway' => 24),
    'Car/SUV or Pickup Truck (2-Axle-Trailer)' => array('city' => 16, 'highway' => 21),
    'Moving Truck or Box Truck (2-Axles)' => array('city' => 12, 'highway' => 15),
    'Dual-Axle Box Truck with 1-Axle Trailer' => array('city' => 11, 'highway' => 13),
    'Dual-Axle Box Truck with 2-Axle Trailer' => array('city' => 9, 'highway' => 11),
    'Dual-Axle Box Truck with 3-Axle Trailer' => array('city' => 7, 'highway' => 9),
    'Moving Truck or Box Truck (3-Axles)' => array('city' => 8, 'highway' => 12),
    'Three-Axle Box Truck with 1-Axle Trailer' => array('city' => 8, 'highway' => 11),
    'Three-Axle Box Truck with 2-Axle Trailer' => array('city' => 7, 'highway' => 10),
    'Three-Axle Box Truck with 3-Axle Trailer' => array('city' => 6, 'highway' => 8),
    'RV (2-Axles)' => array('city' => 8, 'highway' => 12),
    'Two-Axle RV with 1-Axle Trailer' => array('city' => 7, 'highway' => 11),
    'RV (3-Axles)' => array('city' => 6, 'highway' => 9),
    'Three-Axle RV with 1-Axle Trailer' => array('city' => 6, 'highway' => 8),
    'Bus (2-Axles)' => array('city' => 4, 'highway' => 6),
    'Bus (3-Axles)' => array('city' => 3, 'highway' => 5),
);
$cityDistance = $response_data['routes'][0]['cityDistance'] ?? 0;
$highwayDistance = $response_data['routes'][0]['highwayDistance'] ?? 0;
$vehicleEfficiency = isset($fuelEfficiencyMapping[$form_data['type_of_vehicle']]) ? $fuelEfficiencyMapping[$form_data['type_of_vehicle']] : array('city' => 20, 'highway' => 25);  // Default values if not found
$cityFuelUsed = $cityDistance / $vehicleEfficiency['city'];
$highwayFuelUsed = $highwayDistance / $vehicleEfficiency['highway'];
// Combine both for total fuel used:
$fuelUsed = $cityFuelUsed + $highwayFuelUsed;
// Check if the form has been submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Retrieve the distance value
    $distanceMiles = isset($_POST['distanceField']) ? $_POST['distanceField'] : 'Not available';
}
?>
<div class="overlay">
    <div id="toll-cost-estimation">
        <button class="close-btn" id="close-btn" onclick="closePopup()">×</button>
        <h2>Trip Cost Estimation</h2>
<table>
    <tr>
        <th>From City</th>
        <td><?php echo htmlspecialchars($form_data['fromCity']); ?></td>
    </tr>
    <tr>
        <th>To City</th>
        <td><?php echo htmlspecialchars($form_data['toCity']); ?></td>
    </tr>
    <tr>
        <th>Type of Vehicle</th>
        <td><?php echo htmlspecialchars($form_data['type_of_vehicle']); ?></td>
    </tr>
    <tr>
    <th>City Mileage (MPG)</th>
    <td><?php echo htmlspecialchars($vehicleEfficiency['city']); ?></td>
</tr>
<tr>
    <th>Highway Mileage (MPG)</th>
    <td><?php echo htmlspecialchars($vehicleEfficiency['highway']); ?></td>
</tr>
    <tr>
        <th>Trip Type</th>
        <td><?php echo htmlspecialchars($form_data['Trip']); ?></td>
    </tr>
    <tr>
        <th>Estimated Toll Cost</th>
        <td>$<?php echo number_format($initialOneWaytollCost, 2); ?></td>
    </tr>
    <tr>
        <th>Estimated Fuel Cost</th>
        <td>$<?php echo number_format($initialOneWayfuel, 2); ?></td>
    </tr>
    <tr>
        <th>Total Cost (Toll + Fuel)</th>
        <td>$<?php echo number_format($initialOneWaytollCost + $initialOneWayfuel, 2); ?></td>
    </tr>
    <?php if($form_data["Trip"] == "Return"): ?>
    <tr>
        <th>Return Toll Cost</th>
        <td>$<?php echo number_format($initialReturntollCost, 2); ?></td>
    </tr>
    <tr>
        <th>Return Fuel Cost</th>
        <td>$<?php echo number_format($initialReturnfuel, 2); ?></td>
    </tr>
    <tr>
        <th>Total Cost (Round Trip)</th>
        <td>$<?php echo number_format(($initialOneWaytollCost + $initialOneWayfuel + $initialReturntollCost + $initialReturnfuel), 2); ?></td>
    </tr>
    <?php endif; ?>    
</table>
<button onclick="printResult()" id="print-button">Print</button>
<button id="result-share-button">Share</button>
<button onclick="closePopup()" id="back-button">Back</button>
    </div>
</div>
<?php
global $wpdb; // Make sure you have access to the global $wpdb object
$table_name = 'toll_calculations';
// Data to insert
$form_data = $_POST; // Ensure you sanitize and validate this data
// Insert data into the database using $wpdb->insert
$inserted = $wpdb->insert(
    $table_name,
    array(
        'fromCity' => $form_data['fromCity'],
        'toCity' => $form_data['toCity'],
        'type_of_vehicle' => $form_data['type_of_vehicle'],
        'Trip' => $form_data['Trip'],
        'tollCost' => $initialOneWaytollCost,
        'fuelCost' => $initialOneWayfuel,
    ),
    array('%s', '%s', '%s', '%s', '%f', '%f', '%f') // Specify the format corresponding to each value
);
// Check if the insert was successful
if (false === $inserted) {
    echo "Error inserting data: " . $wpdb->last_error;
} else {
    // echo "Data inserted successfully";
}
// Retrieve data from the database using $wpdb->get_results
$results = $wpdb->get_results("SELECT * FROM {$table_name}");
// Output the retrieved data
foreach ($results as $row) {
}
?>
<?php endif; ?>
</div>
</div>
</body>
<html>
<?php
get_footer();
?>
<script>
     document.getElementById('new-search').addEventListener('click', function() {
    // Clear the form fields
    document.getElementById('fromCity').value = '';
    document.getElementById('toCity').value = '';
    document.getElementById('Trip').value = 'OneWay';
    // Set the vehicle type dropdown and hidden input to default values
    document.getElementById('vehicle-display').textContent = 'Car/SUV or Pickup Truck (2-Axles)';
    document.getElementById('type_of_vehicle').value = 'Car/SUV or Pickup Truck'; // This should be the value attribute of the default option
    document.querySelector('.selected-icon').src = 'https://www.personaldrivers.com/wp-content/uploads/car-2axle.svg'; // Set to default image
    if (hiddenVehicleInput) {
        hiddenVehicleInput.value = '';
    }
    localStorage.removeItem('fromCity');
    localStorage.removeItem('toCity');
    localStorage.removeItem('type_of_vehicle');
    localStorage.removeItem('Trip');
    localStorage.removeItem('mapboxOrigin');
    localStorage.removeItem('mapboxDestination');
    // Reset Mapbox Directions
    if (mapboxDirections) {
        mapboxDirections.removeRoutes(); // If this method is not available, you may need to use a different one based on Mapbox Directions API
    }
    // Clear local storage values for mapbox locations
    localStorage.removeItem('mapboxOrigin');
    localStorage.removeItem('mapboxDestination');
    // Reset the map view to the default center and zoom
    map.flyTo({
        center: [-98.5795, 39.8283], // Default center coordinates
        zoom: 4 // Default zoom level
    });  
});
</script>
<script>
document.addEventListener("DOMContentLoaded", function() {
    var storedType = "<?php echo getFormFieldValue('type_of_vehicle'); ?>";
    var dropdownOptions = document.querySelectorAll('.dropdown-options li');

    dropdownOptions.forEach(function(option) {
        if (option.getAttribute('data-value') === storedType) {
            var selectedText = option.textContent.trim();
            var selectedImageSrc = option.querySelector('img') ? option.querySelector('img').src : '';

            // Update the dropdown display, hidden input, and image
            document.getElementById('vehicle-display').textContent = selectedText;
            document.getElementById('type_of_vehicle').value = storedType;
            document.querySelector('.selected-icon').src = selectedImageSrc;
        }
    });
});
</script>