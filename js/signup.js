function create_dropdown(index, word){
  var elem = "<span class='dropdown'>" +
              "<span class='dropbtn'>" + word + "</span>" +
              "<span class='dropdown-content'>" +
                 "<a href='#' class='delete'>Delete</a>" +
                  "<a href='#' class='addright'>Add to Right</a>" +
                  "<a href='#' class='addleft'>Add to Left</a>" +
                  "<a href='#' class='move'>Shift</a>" +
                  "<input class='update' type='text' placeholder='Type Word'>" +
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
  $("#original_text").empty();
  $("#original_text").append("Michael Manley created the comic character, Ballistic, who has the alternative name, Kelvin Mao.");

  var pos_editings = Array();
  "Michael Manley criou o personagem de quadrinhos , Ballistic , que tem o nome alternativo , Kelvin Mao .".split(' ').forEach(function (word, index){
    pos_editings.push({
      "word": word, 
      "action":"original", 
      "updated_word": null, 
      "created_at": new Date().toISOString().slice(0, 19).replace('T', ' '),
      "updated_at": null
    });
  });

  $("#pos-edition-env").empty();
  pos_editings.forEach(function (item, index){
    var elem = create_dropdown(index, item.word);
    $("#pos-edition-env").append(elem);
  });


  $("#rewriting-env").empty();
  $("#rewriting-env").text("Michael Manley criou o personagem de quadrinhos, Ballistic, que tem o nome alternativo, Kelvin Mao.");
  var h = document.getElementById("rewriting-env").scrollHeight + 6;
  $("#rewriting-env").css("height", h + "px");

  $("#noneed").click(function (e){
    e.preventDefault();
  });
  
  $("#dontknow").click(function (e){
    e.preventDefault();
  });
  
  $("#submit").click(function (e){
    e.preventDefault();
  });

  // POS-EDITING X REWRITING EVENTS
  $("#pos-edition").click(function (){
    $("#pos-edition-env").css("display", "block");
    $("#rewriting-env").css("display", "none");
  });

  $("#rewriting").click(function (){
    $("#pos-edition-env").css("display", "none");
    $("#rewriting-env").css("display", "block");
  });

  // DELETE EVENT
  $('body').on('click', '.delete', function (e) {
    e.preventDefault();
    var dropdown = $(this).parent().parent();
    var children = $(dropdown).children();
    // get delete button
    var btn_delete = $(children[1]).children()[0];
    // get dropbtn class
    var dropbtn = children[0];

    // get token index and update token
    var index = $(children[2]).val();
    var action = pos_editings[index].action;

    if (action == "deleted"){
      // get textual content within <del> tag
      var text = $(dropbtn).children()[0].textContent;
      $(dropbtn).text("");
      $(dropbtn).append(text);

      // update label in delete button
      btn_delete.textContent = "Delete";

      pos_editings[index].action = "undeleted";
    } else {
      // put word within <del> tag
      var d = $("<del></del>").text(dropbtn.textContent);   // Create with jQuery
      $(dropbtn).text("");
      $(dropbtn).append(d);

      // update label in delete button
      btn_delete.textContent = "Cancel Delete";

      pos_editings[index].action = "deleted";
    }
    
    pos_editings[index].updated_at = new Date().toISOString().slice(0, 19).replace('T', ' ');
  });

  // Update EVENT
  $('body').on('input', '.update', function (e) {
    e.preventDefault();
    var text = $(this).val();

    var dropdown = $(this).parent().parent();
    var children = $(dropdown).children();
    // get dropbtn class
    var dropbtn = children[0];
    var d = $("<u></u>").text(text);   // Create with jQuery

    // get token index and update token
    var index = $(children[2]).val();
    pos_editings[index].action = "updated";
    pos_editings[index].updated_word = text;
    pos_editings[index].updated_at = new Date().toISOString().slice(0, 19).replace('T', ' ');

    $(dropbtn).text("");
    $(dropbtn).append(d);
  });

  // SHIFT EVENT
  $('body').on('click', '.move', function (e) {
    e.preventDefault();
    var env = $('#pos-edition-env').children();

    var dropdown = $(this).parent().parent();
    var children = $(dropdown).children();
    var index = Number($(children[2]).val());

    if (index+1 != env.length){
     pos_editings[index].action = "shift-right";
     pos_editings[index+1].action = "shift-left";

      // shift the order on the pos-editings
      let cutOut = pos_editings.splice(index, 1) [0]; 
      pos_editings.splice(index+1, 0, cutOut);
      
      $("#pos-edition-env").empty();
      pos_editings.forEach(function (item, index){
        var elem = create_dropdown(index, item.word);
        $("#pos-edition-env").append(elem);
      });
    }
  });

  // ADDITION EVENTS
  $('body').on('click', '.addright', function (e) {
    e.preventDefault();
    var text = $(this).val();
    var dropdown = $(this).parent().parent();
    var children = $(dropdown).children();
    // get token index
    var index = Number($(children[2]).val())+1;
    pos_editings.splice(index, 0, { "word": "ADD", "action":null, "updated_word": null, "updated_at": null });

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
    e.preventDefault();
      var text = $(this).val();
      var dropdown = $(this).parent().parent();
      var children = $(dropdown).children();
      // get token index
      var index = Number($(children[2]).val());
      pos_editings.splice(index, 0, { "word": "ADD", "action":null, "updated_word": null, "updated_at": null });

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

    pos_editings[index].action = "added";
    pos_editings[index].word = text;
    pos_editings[index].updated_at = new Date().toISOString().slice(0, 19).replace('T', ' ');
    $(children[1]).remove();

    $(parent).css('background-color', 'red');
    var elem = create_dropdown(index, text);
    $(parent).append(elem);

    $(input_group).remove();
  });
  
});

