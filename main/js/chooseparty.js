$(document).ready(function () {
  let suggestions;
  // Trigger AJAX search on input
  $("#partySelect").on("input", function () {
    var query = $(this).val();
    if (query.length > 0) {
      $.ajax({
        url: "../get_ajax/searchParty/getparty.php",
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
        var suggestion = suggestions.eq(focusedIndex);
        var name = suggestion.text().trim();
        var mobileNumber = suggestion.data("mobno");
        // Set the selected name and mobile number in the appropriate inputs
        $("#partySelect").val(name);
        $("#party_mobno").val(mobileNumber); // Assuming you have an input for mobile number

        $("#suggestions").html("");
      } else {
        // No suggestion selected; assume new entry
        var newpartySelect = $("#partySelect").val().trim();
        if (newpartySelect.length > 0) {
          $.ajax({
            url: "../get_ajax/searchParty/getparty.php",
            method: "POST",
            data: {
              new_party: newpartySelect,
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
