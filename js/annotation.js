function startTimer(duration, display) {
    var timer = duration, minutes, seconds;
    var interval = setInterval(function () {
        minutes = parseInt(timer / 60, 10);
        seconds = parseInt(timer % 60, 10);

        minutes = minutes < 10 ? "0" + minutes : minutes;
        seconds = seconds < 10 ? "0" + seconds : seconds;

        display.textContent = minutes + ":" + seconds;

        if (--timer < 0) {
            timer = duration;
            document.getElementById('button').removeAttribute('disabled');
            document.getElementById('timer').style.display = 'none';
        }
    }, 1000);
}

window.onload = function () {
    document.getElementById('button').setAttribute('disabled', 'true');
    var fiveMinutes = 1,
        display = document.querySelector('#timer');
    startTimer(fiveMinutes, display);
};

$(document).ready(function(){
  var results;
  $("#button").css("display", "none");
  $("#loading").css("display", "inline-block");

  $.ajax({
    url: "http://localhost:8080/felipe/routing.php",
    type: "GET",
    data: {},
    error: function (jqXHR, exception) {
    },
    success: function (data){
      results = data;
      results.created_at = new Date().toISOString().slice(0, 19).replace('T', ' ');
      $("#original_text").empty();
      $("#original_text").append(results.original);

      var user_text = $('#user').text().split(' / ')[0] + ' / Anotação ' + results.finished_trials.toString() ;
      $('#user').text(user_text);

      results.pos_editings = Array();
      results.translation.split(' ').forEach(function (word, index){
        results.pos_editings.push({
          "idx": index, 
          "word": word, 
          "action":"original", 
          "updated_word": null, 
          "created_at": new Date().toISOString().slice(0, 19).replace('T', ' '),
          "updated_at": null
        });
      });

      $("#pos-edition-env").empty();
      results.pos_editings.forEach(function (item, index){
        var elem = "<span class='dropdown'>" +
                      "<span class='dropbtn'>" + item.word + "</span>" +
                      "<span class='dropdown-content'>" +
                         "<a href='#' class='delete'>Delete</a>" +
                          "<a href='#' class='addright'>Add to Right</a>" +
                          "<a href='#' class='addleft'>Add to Left</a>" +
                          "<input class='update' type='text' placeholder='Update'>" +
                      "</span>" +
                      "<input type='hidden' value='" + index + "'/>" +
                    "</span>";
        $("#pos-edition-env").append(elem);
      });

      $("#rewriting-env").empty();
      $("#rewriting-env").text(results.rewriting);

      $("#button").css("display", "inline-block");
      $("#loading").css("display", "none");
    },
    dataType: "json"
  });

  $("#button").click(function (e){
    e.preventDefault();

    $("#button").css("display", "none");
    $("#loading").css("display", "inline-block");

    $.ajax({
      url: "http://localhost:8080/felipe/routing.php",
      type: "POST",
      data: results,
      error: function (jqXHR, exception) {
        console.log(jqXHR);
      },
      success: function (data){
        results = data;
        results.created_at = new Date().toISOString().slice(0, 19).replace('T', ' ');
        $("#original_text").empty();
        $("#original_text").append(results.original);

        var user_text = $('#user').text().split(' / ')[0] + ' / Anotação ' + results.finished_trials.toString() ;
        $('#user').text(user_text);

        results.pos_editings = Array();
        results.translation.split(' ').forEach(function (word, index){
          results.pos_editings.push({
            "idx": index, 
            "word": word, 
            "action":"original", 
            "updated_word": null, 
            "created_at": new Date().toISOString().slice(0, 19).replace('T', ' '),
            "updated_at": null
          });
        });

        $("#pos-edition-env").empty();
        results.pos_editings.forEach(function (item, index){
          var elem = "<span class='dropdown'>" +
                        "<span class='dropbtn'>" + item.word + "</span>" +
                        "<span class='dropdown-content'>" +
                           "<a href='#' class='delete'>Delete</a>" +
                            "<a href='#' class='addright'>Add to Right</a>" +
                            "<a href='#' class='addleft'>Add to Left</a>" +
                            "<input class='update' type='text' placeholder='Update'>" +
                        "</span>" +
                        "<input type='hidden' value='" + index + "'/>" +
                      "</span>";
          $("#pos-edition-env").append(elem);
        });
        
        $("#rewriting-env").val(results.rewriting);

        results.isPosedited = 1;
        results.isRewritten = 0;
        $("#pos-edition-env").css("display", "block");
        $("#rewriting-env").css("display", "none");

        $("#button").css("display", "inline-block");
        $("#loading").css("display", "none");
      },
      dataType: "json"
    });
  });

  // POS-EDITING X REWRITING EVENTS
  $("#pos-edition").click(function (){
    results.isPosedited = 1;
    results.isRewritten = 0;
    $("#pos-edition-env").css("display", "block");
    $("#rewriting-env").css("display", "none");
  });

  $("#rewriting").click(function (){
    results.isPosedited = 0;
    results.isRewritten = 1;
    $("#pos-edition-env").css("display", "none");
    $("#rewriting-env").css("display", "block");
  });

  // Update EVENT
  $('body').on('input', '#rewriting-env', function (e) {
    var text = $(this).val();
    results.rewriting = text;
  });

  // DELETE EVENT
  $('body').on('click', '.delete', function (e) {
    var dropdown = $(this).parent().parent();
    var children = $(dropdown).children();
    // get dropbtn class
    var dropbtn = children[0];

    var d = $("<del></del>").text(dropbtn.textContent);   // Create with jQuery

    // get token index and update token
    var index = $(children[2]).val();
    results.pos_editings[index].action = "deleted";
    results.pos_editings[index].updated_at = new Date().toISOString().slice(0, 19).replace('T', ' ');

    $(dropbtn).text("");
    $(dropbtn).append(d);
  });

  // Update EVENT
  $('body').on('input', '.update', function (e) {
    var text = $(this).val();

    var dropdown = $(this).parent().parent();
    var children = $(dropdown).children();
    // get dropbtn class
    var dropbtn = children[0];
    var d = $("<u></u>").text(text);   // Create with jQuery

    // get token index and update token
    var index = $(children[2]).val();
    results.pos_editings[index].action = "updated";
    results.pos_editings[index].updated_word = text;
    results.pos_editings[index].updated_at = new Date().toISOString().slice(0, 19).replace('T', ' ');

    $(dropbtn).text("");
    $(dropbtn).append(d);
  });

  // ADDITION EVENTS
  $('body').on('click', '.addright', function (e) {
    var text = $(this).val();
    var dropdown = $(this).parent().parent();
    var children = $(dropdown).children();
    // get token index
    var index = Number($(children[2]).val())+1;
    results.pos_editings.splice(index, 0, { "word": "ADD", "action":null, "updated_word": null, "updated_at": null });

    $.each($('#pos-edition-env').children(), function (idx, item){
      var idx_ = Number(idx);
      if (idx_ >= index){
        var children = $(item).children();
        $(children[2]).val(idx_+1);
      }
    });

    var elem = $("<span class='dropdown dropadded'>" +
          "<div class='input-group'>" +
          "<input type='text' class='form-control added-input' />" +
          "<button class='btn added'>Add</button>" +
          "</div>" +
          "<input type='hidden' value='" + index + "'/>" +
          "</span>");

    $(elem).insertAfter(dropdown);
  });

  $('body').on('click', '.addleft', function (e) {
      var text = $(this).val();
      var dropdown = $(this).parent().parent();
      var children = $(dropdown).children();
      // get token index
      var index = Number($(children[2]).val());
      results.pos_editings.splice(index, 0, { "word": "ADD", "action":null, "updated_word": null, "updated_at": null });

      $.each($('#pos-edition-env').children(), function (idx, item){
        var idx_ = Number(idx);
        if (idx_ >= index){
          var children = $(item).children();
          $(children[2]).val(idx_+1);
        }
      });

      var elem = $("<span class='dropdown dropadded'>" +
        "<div class='input-group'>" +
        "<input type='text' class='form-control added-input' />" +
        "<button class='btn added'>Add</button>" +
        "</div>" +
        "<input type='hidden' value='" + index + "'/>" +
      "</span>");

      $(elem).insertBefore(dropdown);
    });

  $('body').on('click', '.added', function () {
    var input_group = $(this).parent();
    var text = $(input_group).children()[0];
    var text = $(text).val();

    var parent = $(input_group).parent();
    var children = $(parent).children();
    var index = $(children[1]).val();
    results.pos_editings[index].action = "added";
    results.pos_editings[index].word = text;
    results.pos_editings[index].updated_at = new Date().toISOString().slice(0, 19).replace('T', ' ');
    $(children[1]).remove();

    $(parent).css('background-color', 'red');
    var elem = "<span class='dropbtn'>" + text + "</span>" +
            "<span class='dropdown-content'>" +
                "<a href='#' class='delete'>Delete</a>" +
                "<a href='#' class='addright'>Add to Right</a>" +
                "<a href='#' class='addleft'>Add to Left</a>" +
                "<input class='update' type='text' placeholder='Update'>" +
            "</span>" +
            "<input type='hidden' value='" + index + "'/>";
    $(parent).append(elem);

    $(input_group).remove();

  });
});