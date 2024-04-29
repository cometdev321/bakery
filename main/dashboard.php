<?php 
include('common/header.php');

include('common/sidebar.php');
?>
<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <link
      href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css"
      rel="stylesheet"
    />
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins&display=swap" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <title>Dashboard</title>
  </head>
  <style>
    body{
      font-family: "Poppins", sans-serif;
    font-weight: 400;
    font-style:normal;
    background-color:rgb(249,249,249),
    }
  </style>
  <body>
    <section class="text-gray-600 body-font">
      <div class="container px-5 py-24 mx-auto lg:ml-1/5 mt-10">
        <!-- Adjusted container div to leave space for the sidebar and added mt-10 for margin-top -->
        <div class="flex flex-wrap -m-4">
          <!-- Sidebar -->
          <div class="lg:w-1/5">
            <!-- Sidebar content goes here -->
          </div>

          <!-- First Card -->
          <div class="p-4 lg:w-3/5 lg:h-98 bg-white rounded-lg">
            <!-- Set width of the first card to 2/3 and add padding -->
            <!-- <div class="h-full bg-gray-300 bg-opacity-75 px-8 pt-16 pb-24 rounded-lg overflow-hidden text-center relative"> -->
              <h2 class="tracking-widest text-xs title-font font-medium text-gray-400 mb-1 text-centers">
                Sales
              </h2>
              <h1 class="title-font sm:text-2xl text-xl font-medium text-gray-900 mb-3"></h1>
              <canvas id="salesChart" class="w-full h-full"></canvas> <!-- Adjusted canvas class -->
            <!-- </div> -->
          </div>
          

          <!-- Second Card -->
          <div class="p-4 lg:w-1/5 lg:h-98 ">
            <!-- Set width of the second card to 1/3 and add padding -->
            <div style="background-color: rgb(231, 1, 19); color: white;"
              class="h-full   bg-opacity-75 px-8 pt-16 pb-24 rounded-lg shadow-lg overflow-hidden text-center relative"
            >
              <h2
                class="tracking-widest text-xl text-white-500 title-font font-medium mb-1 absolute top-6 left-6"
              >
                Sales Today
              </h2>
              <div
                class="text-center mt-2 leading-none flex justify-center absolute bottom-0 left-0 w-full py-4"
              ></div>
            </div>
          </div>
          <div class="lg:w-1/4">
            <!-- Sidebar content goes here -->
          </div>

          <!-- Third Card -->
          <div class="p-4 lg:w-1/4 lg:pl-4 lg:h-64 ">
            <!-- Set width of the third card to 1/3 and add padding -->
            <div
              class="h-full mt-10 bg-white-300 bg-opacity-75 px-8 pt-16 pb-24 rounded-lg overflow-hidden text-center relative bg-white"
            >
              <h2
                class="tracking-widest text-xl title-font font-medium text-black-400 mb-1 absolute top-6 left-6 text-black"
              >
                You'll Receive
              </h2>
              <div
                class="text-center mt-2 leading-none flex justify-center absolute bottom-0 left-0 w-full py-4"
              ></div>
            </div>
          </div>

          <!-- Fourth Card -->
          <div class="p-4 lg:w-1/4 lg:pl-4 lg:h-64  ">
            <!-- Set width of the fourth card to 1/3 and add padding -->
            <div
              class="h-full mt-10   bg-white-300 bg-opacity-75 px-8 pt-16 pb-24 rounded-lg overflow-hidden text-center relative bg-white"
            >
              <h2
                class="tracking-widest text-xl title-font font-medium text-400 mb-1 text-black absolute top-6 left-6"
              >
                <!-- You'll Pay -->
                i am not paying 
              </h2>
              <div
                class="text-center mt-2 leading-none flex justify-center absolute bottom-0 left-0 w-full py-4"
              ></div>
            </div>
          </div>
          <!-- Fifth Card -->
          <div class="p-4 lg:w-1/4 lg:pl-4 lg:h-64  ">
            <!-- Set width of the fifth card to 1/3 and add padding -->
            <div
              class="h-full bg-white-300 mt-10 bg-opacity-75 px-8 pt-16 pb-24 rounded-lg overflow-hidden text-center relative bg-white"
            >
              <h2
                class="tracking-widest  text-xl title-font font-medium text-400 mb-1 absolute text-black top-6 left-6"
              >
                Purchase
              </h2>
              <div
                class="text-center mt-2 leading-none flex justify-center absolute bottom-0 left-0 w-full py-4"
              ></div>
            </div>
          </div>
        </div>
      </div>
    </section>
  </body>
  <script>
    // Mock sales data
    var ctx = document.getElementById("salesChart").getContext("2d");

// Define the data
var data = {
      labels: ["January", "February", "March", "April", "May", "June", "July"],
      datasets: [{
        label: "Sales",
        data: [65, 59, 80, 81, 56, 55, 40],
        fill: false,
        borderColor: "rgb(231, 1, 19)", // Line color with transparency
        backgroundColor: "rgba(75, 192, 192, 0.2)", // Background color with transparency
        borderWidth: 1,
        pointBackgroundColor:  "rgba(75, 192, 192, 0.2)",// Point color
        pointRadius: 1,
        // pointBorderWidth: 2,
        // pointBorderColor: "#fff", // Point border color
        // pointHoverRadius: 8,
        pointHoverBackgroundColor: "rgba(75, 192, 192, 1)", // Point hover color
        pointHoverBorderColor: "#fff", // Point hover border color
      }]
    };

// Define chart options
var options = {
  responsive: true,
  title: {
    display: true,
    text: 'Sales Performance',
    fontSize: 25,
    fontColor: '#333'
  },
  scales: {
        y: {
          ticks: {
            beginAtZero: true,
            fontColor: '#666' // Y-axis label color
          },
          grid: {
            display: false // Hide Y-axis grid lines
          }
        },
        x: {
          ticks: {
            fontColor: '#666' // X-axis label color
          },
          grid: {
            display: false // Hide X-axis grid lines
          }
        }
      },
      plugins: {
        legend: {
          labels: {
            font: {
              family: 'Poppins', // Change font family
              size: 16, // Change font size
              // style: 'italic', // Change font style
              weight: 'bold' // Change font weight
            },
            boxWidth: 20, // Change width of the label rectangle box
            boxHeight: 20, // Change height of the label rectangle box
            backgroundColor: 'red'
          }
        }
      }
};

// Create the line chart
var myLineChart = new Chart(ctx, {
  type: 'line',
  data: data,
  options: options
});
  </script>
</html>
