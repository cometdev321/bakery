$(document).ready(function () {
  let suggestions = $(); // Initialize as an empty jQuery object

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
          suggestions = $("#suggestions .suggestion-box"); // Update suggestions
        },
      });
    } else {
      $("#suggestions").html("");
    }
  });

  // Handle suggestion selection by click
  $(document).on("click", ".suggestion-box", function (e) {
    e.preventDefault(); // Prevent default behavior (e.g., form submission)
    var name = $(this).text().trim();
    var mobileNumber = $(this).data("mobno");
    var partyid = $(this).data("id");
    $("#partySelect").val(name);
    $("#party_mobno").val(mobileNumber); // Assuming you have an input for mobile number
    $("#party_id").val(partyid); // Assuming you have an input for party ID
    $("#suggestions").html(""); // Clear suggestions
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
        var partyid = suggestion.data("id");
        $("#partySelect").val(name);
        $("#party_mobno").val(mobileNumber); // Assuming you have an input for mobile number
        $("#party_id").val(partyid); // Assuming you have an input for party ID
        $("#suggestions").html(""); // Clear suggestions
      } else {
        // No suggestion selected; assume new entry
        var newpartySelect = $("#partySelect").val().trim();
        if (newpartySelect.length > 0) {
          $.ajax({
            url: "../get_ajax/searchParty/getparty.php",
            method: "POST",
            data: { new_party: newpartySelect },
            success: function (response) {
              alert("New party added");
              $("#party_id").val(response); // Assuming the server returns the new party ID
              $("#suggestions").html(""); // Clear suggestions
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

  // Close suggestions when clicking outside
  $(document).on("click", function (e) {
    if (!$(e.target).closest("#partySelect, #suggestions").length) {
      $("#suggestions").html(""); // Clear suggestions if click outside
    }
  });
});

function addNewParty() {
  var newpartySelect = $("#partySelect").val().trim();
  if (newpartySelect.length > 0) {
    $.ajax({
      url: "../get_ajax/searchParty/getparty.php",
      method: "POST",
      data: { new_party: newpartySelect },
      success: function (response) {
        alert("New party added");
        $("#party_id").val(response); // Assuming the server returns the new party ID
        $("#suggestions").html(""); // Clear suggestions
      },
    });
  }
}
