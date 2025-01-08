<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Party Name Search</title>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <style>
        #suggestions {
    position: absolute;
    width: 100%;
    max-height: 200px;
    overflow-y: auto;
    border: 1px solid #ccc;
    background-color: #fff;
    z-index: 1000; /* Ensure it's above other content */
    display: none; /* Initially hidden */
}

#suggestions .suggestion-box {
    padding: 10px;
    cursor: pointer;
    border-bottom: 1px solid #eee;
    background-color: #f9f9f9;
}

#suggestions .suggestion-box:hover,
#suggestions .suggestion-box.suggestion-selected {
    background-color: #e9e9e9;
}

    </style>
</head>
<body>
    <input type="text" id="partySelect" placeholder="Enter party name">
    <div id="suggestions"></div>
  <script>$(document).ready(function () {
  let suggestions;
  // Trigger AJAX search on input
  $("#partySelect").on("input", function () {
    var query = $(this).val();
    if (query.length > 0) {
      $.ajax({
        url: "search.php",
        method: "POST",
        data: { query: query },
        success: function (data) {
          $("#suggestions").html(data);
          suggestions = $("#suggestions .suggestion-box");
        },
      });
    } else {
      $("#suggestions").html("");
    }
  });

  // Handle suggestion selection by click
  $(document).on("click", ".suggestion-box", function () {
    var name = $(this).text().trim();
    $("#partySelect").val(name);
    $("#suggestions").html("");
  });

  // Handle keyboard navigation
  $("#partySelect").on("keydown", function (e) {
    var focusedIndex = suggestions.index(
      suggestions.filter(".suggestion-selected")
    );

    if (e.key === "ArrowDown") {
      e.preventDefault();
      if (focusedIndex < suggestions.length - 1) {
        focusedIndex++;
        suggestions.removeClass("suggestion-selected");
        suggestions.eq(focusedIndex).addClass("suggestion-selected");
      }
    } else if (e.key === "ArrowUp") {
      e.preventDefault();
      if (focusedIndex > 0) {
        focusedIndex--;
        suggestions.removeClass("suggestion-selected");
        suggestions.eq(focusedIndex).addClass("suggestion-selected");
      }
    } else if (e.key === "Enter") {
      e.preventDefault();
      if (focusedIndex >= 0) {
        // Select the focused suggestion
        var name = suggestions.eq(focusedIndex).text().trim();
        $("#partySelect").val(name);
        $("#suggestions").html("");
      } else {
        // No suggestion selected; assume new entry
        var newpartySelect = $("#partySelect").val().trim();
        if (newpartySelect.length > 0) {
          $.ajax({
            url: "search.php",
            method: "POST",
            data: {
              new_party: newpartySelect,
              session: "user_session_value", // Replace with actual session value
            },
            success: function (response) {
              alert(response); // Display response from the server
              $("#suggestions").html("");
            },
          });
        }
      }
    }
  });

  // Focus suggestion on hover for keyboard accessibility
  $(document).on("mouseover", ".suggestion-box", function () {
    suggestions.removeClass("suggestion-selected");
    $(this).addClass("suggestion-selected");
  });
});
</script>
</body>
</html>
