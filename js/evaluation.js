function format_candidate(index, i, sentence, checked){
  var temp = '<h5 class="text-center">Candidate ' + index + '</h5> \
              <p style="font-size:25px" id="radio">' + sentence + '</p> \
              <form id="radio' + i + '" class="text-center"> \
                  <input type="radio" name="score" value="1" style="margin-left:0.5cm"> very poor \
                  <input type="radio" name="score" value="2" style="margin-left:0.5cm"> poor \
                  <input type="radio" name="score" value="3" style="margin-left:0.5cm"> medium \
                  <input type="radio" name="score" value="4" style="margin-left:0.5cm"> good \
                  <input type="radio" name="score" value="5" style="margin-left:0.5cm"> very good \
              </form> \
              <br/>';

  $('.sentences').append(temp);              
  if(checked != null)
    $('input[name=score]', '#radio' + i).filter('[value=' + checked +']').prop('checked', true);
}

function shuffle(array) {
//https://stackoverflow.com/q/962802
  var tmp, current, top = array.length;

  if(top) while(--top) {
    current = Math.floor(Math.random() * (top + 1));
    tmp = array[current];
    array[current] = array[top];
    array[top] = tmp;
  }

  return array;
}

$(document).ready(function(){

  var results;
  
  $("#buttons").css("display", "none");
 
  $.ajax({
    url: "https://homepages.dcc.ufmg.br/~felipealco/webnlg-pt/routing_eval.php",
    type: "GET",
    data: {},
    error: function (jqXHR, exception) {
    },
    success: function (data){
      results = data;

      var user_text = $('#user').text().split(' / ')[0] + ' / Avaliações ' + results.finished_trials.toString() ;
      $('#user').text(user_text);
      
      $("#category").empty();
      $("#category").append(results.category);
      
      $("#original").empty();
      $("#original").append(results.original);

      $(".sentences").empty();
      
      var size = Object.keys(results.sentences).length

      for(var order = [], i=0; i < size; ++i) order[i]=i+1;

      shuffle(order); 
      
      index = 0
      for(var i = 0; i < size; ++i)
        format_candidate(++index, order[i], results.sentences[order[i]], results.scores[order[i]]);
      
      $("#buttons").css("display", "inline-block");

      results.created_at = new Date().toISOString().slice(0, 19).replace('T', ' ');
    },
    dataType: "json"
  });

  $("#submit").click(function (e){
    e.preventDefault();
    
    results.evaluation = {};
    for(var i in results.sentences)
      results.evaluation[i] = $('input[name=score]:checked', '#radio' + i).val();

    $("#buttons").css("display", "none");
    
    $.ajax({
      url: "https://homepages.dcc.ufmg.br/~felipealco/webnlg-pt/routing_eval.php",
      type: "POST",
      data: results,
      error: function (jqXHR, exception) {
        console.log(jqXHR);
      },
      success: function (data){
        results = data;

        var user_text = $('#user').text().split(' / ')[0] + ' / Avaliações ' + results.finished_trials.toString() ;
        $('#user').text(user_text);
              
        $("#category").empty();
        $("#category").append(results.category);
        
        $("#original").empty();
        $("#original").append(results.original);

        $(".sentences").empty();
        var size = Object.keys(results.sentences).length

        for(var order = [], i=0; i < size; ++i) order[i]=i+1;

        shuffle(order); 
        
        index = 0
        for(var i = 0; i < size; ++i)
          format_candidate(++index, order[i], results.sentences[order[i]]);
        
        $("#buttons").css("display", "inline-block");
        
        results.created_at = new Date().toISOString().slice(0, 19).replace('T', ' ');
      },
      dataType: "json"
    });
    
  });
  
  //BLACKOUT PAUSE
  $("#pause").click(function (){
    $('.darklayer').toggleClass('active');
  });
});

