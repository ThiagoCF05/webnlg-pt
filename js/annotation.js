function create_dropdown(index, word){
  var elem = "<span class='dropdown'>" +
              "<span class='dropbtn'>" + word + "</span>" +
              "<span class='dropdown-content'>" +
                 "<a href='#' class='delete'>Excluir</a>" +
                  "<a href='#' class='addright'>Adicionar à direita</a>" +
                  "<a href='#' class='addleft'>Adicionar à esquerda</a>" +
                  "<a href='#' class='move'>Mover para a direita</a>" +
                  "<input class='update' type='text' placeholder='Digite uma palavra'>" +
              "</span>" +
              "<input type='hidden' value='" + index + "'/>" +
            "</span>";
  return elem;
}

function save_rewriting_history(data){
  $.ajax({
    url: "https://homepages.dcc.ufmg.br/~felipealco/webnlg-pt/rewriting.php",
    type: "POST",
    data: data,
    error: function (jqXHR, exception) {
      console.log(jqXHR);
    },
    success: function (data){
    },
    dataType: "json"
  });
}

$(document).ready(function(){

  $(function () {
    $('[data-toggle="tooltip"]').tooltip()
  })

  var results;
  var totalSeconds_hidden = 0;
  var history = Array();
  $("#buttons").css("display", "none");
  $("#loading").css("display", "inline-block");

  //stopwatcher https://stackoverflow.com/a/45808943
    var secondsLabel = document.getElementById('seconds'),
        minutesLabel = document.getElementById('minutes'), 
	pauseButton = document.getElementById('pause'), 
	timer = null,
        timer_hidden = null,
        totalSeconds = 0,
        blink_id;

    pauseButton.onclick = function() {
      if (timer) {
        //timer
        clearInterval(timer);
        timer = null;
        //timer hidden
        timer_hidden = setInterval(setTime_hidden, 1000);
        //blink
        blink_id = setInterval(blink_text, 800);
        //button text
        document.getElementById('pause').innerHTML = "Retomar";
      } else {
        //timer
       timer = setInterval(setTime, 1000);
       //timer hidden
       clearInterval(timer_hidden);
       timer_hidden = null;
       //blink
       clearInterval(blink_id);
        //button text
        document.getElementById('pause').innerHTML = "Pausar";
     }
    };

    function setTime() {
      totalSeconds++;
      secondsLabel.innerHTML = pad(totalSeconds % 60);
      minutesLabel.innerHTML = pad(parseInt(totalSeconds / 60));
    }

    function setTime_hidden() {
      totalSeconds_hidden++;
    }

    function pad(val) {
      var valString = val + "";
      if (valString.length < 2) {
        return "0" + valString;
      } else {
        return valString;
      }
    }
		
    function blink_text() {
      $('#middle').fadeOut(400);
      $('#middle').fadeIn(400);
    }
 
    timer = setInterval(setTime, 1000);
 
  $.ajax({
    url: "https://homepages.dcc.ufmg.br/~felipealco/webnlg-pt/routing.php",
    type: "GET",
    data: {},
    error: function (jqXHR, exception) {
    },
    success: function (data){
      results = data;
      results.created_at = new Date().toISOString().slice(0, 19).replace('T', ' ');
      $("#original_text").empty();
      $("#original_text").append(results.original);

      $("#cat").empty();
      $("#cat").append(results.category);

      var user_text = $('#user').text().split(' / ')[0] + ' / Anotação ' + results.finished_trials.toString() ;
      $('#user').text(user_text);

      results.pos_editings = Array();
      results.translation.split(' ').forEach(function (word, index){
        results.pos_editings.push({
          // "idx": index, 
          "word": word, 
          "action":"original", 
          "updated_word": null, 
          "created_at": new Date().toISOString().slice(0, 19).replace('T', ' '),
          "updated_at": null
        });
      });

      $("#pos-edition-env").empty();
      results.pos_editings.forEach(function (item, index){
        var elem = create_dropdown(index, item.word);
        $("#pos-edition-env").append(elem);
      });

      $("#rewriting-env").empty();
      $("#rewriting-env").text(results.rewriting);
      var h = document.getElementById("rewriting-env").scrollHeight + 6;
      $("#rewriting-env").css("height", h + "px");
    
      results.status = "rewritten";
      
      $("#pos-edition-env").css("display", "none");
      $("#rewriting-env").css("display", "block");
      
      $("#buttons").css("display", "inline-block");
      $("#loading").css("display", "none");

      results.updated_at = null; //new Date().toISOString().slice(0, 19).replace('T', ' ');
    },
    dataType: "json"
  });

  $("#noneed").click(function (e){
    results.status = "noneed";
    e.preventDefault();
    $("#submit").click();
  });
  
  $("#dontknow").click(function (e){
    results.status = "dontknow";
    e.preventDefault();
    $("#submit").click();
  });
  
  $("#submit").click(function (e){
    results.pause = totalSeconds_hidden;
    results.updated_at = new Date().toISOString().slice(0, 19).replace('T', ' ');
    e.preventDefault();

    $("#buttons").css("display", "none");
    $("#loading").css("display", "inline-block");

    $.ajax({
      url: "https://homepages.dcc.ufmg.br/~felipealco/webnlg-pt/routing.php",
      type: "POST",
      data: results,
      error: function (jqXHR, exception) {
        console.log(jqXHR);
      },
      success: function (data){
        results = data;
        //results.created_at = new Date().toISOString().slice(0, 19).replace('T', ' ');

        $("#original_text").empty();
        $("#original_text").append(results.original);

        $("#cat").empty();
        $("#cat").append(results.category);

        var user_text = $('#user').text().split(' / ')[0] + ' / Anotação ' + results.finished_trials.toString() ;
        $('#user').text(user_text);

        results.pos_editings = Array();
        results.translation.split(' ').forEach(function (word, index){
          results.pos_editings.push({
            // "idx": index, 
            "word": word, 
            "action":"original", 
            "updated_word": null, 
            "created_at": new Date().toISOString().slice(0, 19).replace('T', ' '),
            "updated_at": null
          });
        });

        $("#pos-edition-env").empty();
        results.pos_editings.forEach(function (item, index){
          var elem = create_dropdown(index, item.word);
          $("#pos-edition-env").append(elem);
        });
        
        $("#rewriting-env").val(results.rewriting);

        $("#buttons").css("display", "inline-block");
        $("#loading").css("display", "none");

        if ($('#rewriting').is(':checked')) {
          results.status = "rewritten";
        } else {
         results.status = "posEdited";
        }

        if (timer) {
          totalSeconds = 0;
          totalSeconds_hidden = 0;
          stop();
        }

	results.updated_at = new Date().toISOString().slice(0, 19).replace('T', ' ');
      },
      dataType: "json"
    });
    
    doc = { 'participant_id':results.participant_id, 'translation_id':results.translation_id, 'history': history.slice() };
    history = Array();
    save_rewriting_history(doc);
  });

  // POS-EDITING X REWRITING EVENTS
  $("#pos-edition").click(function (){
    results.status = "posEdited";
    $("#pos-edition-env").css("display", "block");
    $("#rewriting-env").css("display", "none");
  });

  $("#rewriting").click(function (){
    results.status = "rewritten";
    $("#pos-edition-env").css("display", "none");
    $("#rewriting-env").css("display", "block");
  });

  //BLACKOUT PAUSE
  $("#pause").click(function (){
    $('.darklayer').toggleClass('active');
  });

  // Update REWRITING EVENT
  $('body').on('input', '#rewriting-env', function (e) {
    var text = $(this).val();
    results.rewriting = text;

    // add log at every second
    now = new Date();
    input = { 'text': text, 'created_at': results.created_at, 'updated_at': now.toISOString().slice(0, 19).replace('T', ' '), 'time': now };
    history_len = history.length;
    if (history_len == 0){
        history.push(input);
    } else {
      prev_input = history[history_len-1];
      diff = input['time'] - prev_input['time'];
      // greater than one second
      if (diff >= 1000){
        history.push(input);
      }
    }

    // if the buffer's length is greater than 50, save the logs into the database
    history_len = history.length;
    if (history_len >= 50){
      doc = { 'participant_id':results.participant_id, 'translation_id':results.translation_id, 'history': history.slice() };
      history = Array();
      save_rewriting_history(doc);
    }
  });

  // DELETE EVENT
  $('body').on('click', '.delete', function (e) {
    var dropdown = $(this).parent().parent();
    var children = $(dropdown).children();
    // get delete button
    var btn_delete = $(children[1]).children()[0];
    // get dropbtn class
    var dropbtn = children[0];

    // get token index and update token
    var index = $(children[2]).val();
    var action = results.pos_editings[index].action;

    if (action == "deleted"){
      // get textual content within <del> tag
      var text = $(dropbtn).children()[0].textContent;
      $(dropbtn).text("");
      $(dropbtn).append(text);

      // update label in delete button
      btn_delete.textContent = "Excluir";

      results.pos_editings[index].action = "undeleted";
    } else {
      // put word within <del> tag
      var d = $("<del></del>").text(dropbtn.textContent);   // Create with jQuery
      $(dropbtn).text("");
      $(dropbtn).append(d);

      // update label in delete button
      btn_delete.textContent = "Desfazer excluir";

      results.pos_editings[index].action = "deleted";
    }
    
    results.pos_editings[index].updated_at = new Date().toISOString().slice(0, 19).replace('T', ' ');
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

  // SHIFT EVENT
  $('body').on('click', '.move', function (e) {
    var env = $('#pos-edition-env').children();

    var dropdown = $(this).parent().parent();
    var children = $(dropdown).children();
    var index = Number($(children[2]).val());

    if (index+1 != env.length){
      results.pos_editings[index].action = "shift-right";
      results.pos_editings[index+1].action = "shift-left";

      // shift the order on the pos-editings
      let cutOut = results.pos_editings.splice(index, 1) [0]; 
      results.pos_editings.splice(index+1, 0, cutOut);
      
      $("#pos-edition-env").empty();
      results.pos_editings.forEach(function (item, index){
        var elem = create_dropdown(index, item.word);
        $("#pos-edition-env").append(elem);
      });
    }
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
          "<button class='btn added'>Adicionar</button>" +
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
        "<button class='btn added'>Adicionar</button>" +
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
    var elem = create_dropdown(index, text);
    $(parent).append(elem);

    $(input_group).remove();
  });
  
});

