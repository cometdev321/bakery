$(function () {
  function updateMultiCharts(salesData, purchaseData) {
    var options;

    // Generate month labels from Jan to Dec
    var months = [
      "Jan",
      "Feb",
      "Mar",
      "Apr",
      "May",
      "Jun",
      "Jul",
      "Aug",
      "Sep",
      "Oct",
      "Nov",
      "Dec",
    ];

    var dataMultiple = {
      labels: months,
      series: [
        {
          name: "series-sales",
          data: salesData,
        },
        {
          name: "series-purchase",
          data: purchaseData,
        },
      ],
    };

    options = {
      lineSmooth: false,
      height: "230px",
      low: 0,
      high: "auto",
      series: {
        "series-purchase": {
          showPoint: true,
        },
      },
      plugins: [
        Chartist.plugins.legend({
          legendNames: ["Sales", "Purchase"],
        }),
        Chartist.plugins.tooltip({
          appendToBody: true,
        }),
      ],
    };

    new Chartist.Line("#multiple-chart", dataMultiple, options);
  }
  $.when(
    $.ajax({
      url: "get_ajax/dashboard/fetch_sales_data.php",
      type: "GET",
      dataType: "json",
    }),
    $.ajax({
      url: "get_ajax/dashboard/fetch_purchase_data.php",
      type: "GET",
      dataType: "json",
    })
  )
    .done(function (salesResponse, purchaseResponse) {
      var salesData = Object.values(salesResponse[0]);
      var purchaseData = Object.values(purchaseResponse[0]);
      updateMultiCharts(salesData, purchaseData);
    })
    .fail(function () {
      console.log("Error fetching sales or purchase data.");
    });
});

$(document).ready(function () {
  function updateCharts(salesData) {
    var options;

    // Generate month labels from Jan to Dec
    var months = [
      "Jan",
      "Feb",
      "Mar",
      "Apr",
      "May",
      "Jun",
      "Jul",
      "Aug",
      "Sep",
      "Oct",
      "Nov",
      "Dec",
    ];

    var data1 = {
      labels: months,
      series: [Object.values(salesData)],
    };

    var data2 = {
      labels: months,
      series: [Object.values(salesData)],
    };

    // line chart
    options = {
      height: "300px",
      showPoint: true,
      axisX: {
        showGrid: true,
      },
      lineSmooth: false,
      plugins: [
        Chartist.plugins.tooltip({
          appendToBody: true,
        }),
      ],
    };

    new Chartist.Line("#line-chart", data1, options);

    // bar chart
    options = {
      height: "300px",
      axisX: {
        showGrid: true,
      },
      plugins: [
        Chartist.plugins.tooltip({
          appendToBody: true,
        }),
      ],
    };
    new Chartist.Bar("#bar-chart", data2, options);
  }

  $.ajax({
    url: "get_ajax/dashboard/fetch_purchase_data.php",
    type: "GET",
    dataType: "json",
    success: function (response) {
      updateCharts(response);
    },
    error: function (error) {
      console.log("Error fetching sales data:", error);
    },
  });
});
//get sales
$(document).ready(function () {
  function updateChartsSales(salesData) {
    var options;

    // Generate month labels from Jan to Dec
    var months = [
      "Jan",
      "Feb",
      "Mar",
      "Apr",
      "May",
      "Jun",
      "Jul",
      "Aug",
      "Sep",
      "Oct",
      "Nov",
      "Dec",
    ];

    var data1 = {
      labels: months,
      series: [Object.values(salesData)],
    };

    var data2 = {
      labels: months,
      series: [Object.values(salesData)],
    };

    // line chart
    options = {
      height: "300px",
      showPoint: true,
      axisX: {
        showGrid: true,
      },
      lineSmooth: false,
      plugins: [
        Chartist.plugins.tooltip({
          appendToBody: true,
        }),
      ],
    };

    new Chartist.Line("#line-chartSales", data1, options);

    // bar chart
    options = {
      height: "300px",
      axisX: {
        showGrid: true,
      },
      plugins: [
        Chartist.plugins.tooltip({
          appendToBody: true,
        }),
      ],
    };
    new Chartist.Bar("#bar-chartSales", data2, options);
  }

  $.ajax({
    url: "get_ajax/dashboard/fetch_sales_data.php",
    type: "GET",
    dataType: "json",
    success: function (response) {
      updateChartsSales(response);
    },
    error: function (error) {
      console.log("Error fetching sales data:", error);
    },
  });
});
