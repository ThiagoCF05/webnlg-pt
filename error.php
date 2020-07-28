<?php 
  session_start();

  $servername = "mysql.dcc.ufmg.br";
  $username = "felipealco";
  $password = "Queiph0a";
  $dbname = "felipealco";

  // Create connection
  $conn = new mysqli($servername, $username, $password, $dbname);
  // Check connection
  if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
  }
  mysqli_set_charset($conn,"utf8");
  
  $sql = "SELECT LinearPosEditing.id as linear_id, LinearPosEditing.text as post, Translation.text as trans, Translation.id as translation_id, Lex.text as lex FROM LinearPosEditing INNER JOIN Translation ON LinearPosEditing.translation_id = Translation.id INNER JOIN Lex ON Translation.lex_id = Lex.id LEFT JOIN (select * from Error where Error.source_table = 'Lex') as Error ON Lex.id = Error.table_id WHERE LinearPosEditing.status != 'dontknow' AND Translation.id <= 4148 AND Error.comment IS NULL ORDER BY RAND() LIMIT 1;";
  $result = $conn->query($sql);
  $row = $result->fetch_assoc();

  if(isset($_POST['source'])){
    $comma_separated = implode(",", $_POST['source']);
    $sql = "INSERT INTO Error (source_table, table_id, errors, comment) VALUES ('Lex', '" . $_POST['translation_id'] . "', '" . $comma_separated . "', '" . $_POST['source_comment'] . "');";
    $result = $conn->query($sql);
  } else {
    $sql = "INSERT INTO Error (source_table, table_id, errors, comment) VALUES ('Lex', '" . $_POST['translation_id'] . "', 'NO ERRORS', 'NO ERRORS');";
    $result = $conn->query($sql);
  }
  if(isset($_POST['machine'])){
    $comma_separated = implode(",", $_POST['machine']);
    $sql = "INSERT INTO Error (source_table, table_id, errors, comment) VALUES ('Translation', '" . $_POST['translation_id'] . "', '" . $comma_separated . "', '" . $_POST['machine_comment'] . "');";
    $result = $conn->query($sql);
  }
  if(isset($_POST['postedition'])){
    $comma_separated = implode(",", $_POST['postedition']);
    $sql = "INSERT INTO Error (source_table, table_id, errors, comment) VALUES ('LinearPosEditing', '" . $_POST['linear_id'] . "', '" . $comma_separated . "', '" . $_POST['postedition_comment'] . "');";
    $result = $conn->query($sql);
  }
?>

<!DOCTYPE html>
<html lang="pt-br">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<head>
<meta charset="utf-8"/>
<link rel="icon" href="img/logo.png">

<script src="https://code.jquery.com/jquery-3.2.1.slim.min.js"
        integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN"
        crossorigin="anonymous"></script>

<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.11.0/umd/popper.min.js"
        integrity="sha384-b/U6ypiBEHpOf/4+1nzFpr53nxSS+GLCkfwBdFNTxtclqqenISfwAzpKaMNFNmj4"
        crossorigin="anonymous"></script>

<script src="https://code.jquery.com/jquery-3.4.1.js" integrity="sha256-WpOohJOqMqqyKL9FccASB9O0KwACQJpFTUBLTYOVvVU="
        crossorigin="anonymous"></script>

<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.2.1/css/bootstrap.min.css" integrity="sha384-GJzZqFGwb1QTTN6wy59ffF1BuGJpLSa9DkKMp0DgiMDm4iYMj70gZWKYbI706tWS" crossorigin="anonymous">
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.2.1/js/bootstrap.min.js" integrity="sha384-B0UglyR+jN6CkvvICOB2joaf5I4l3gm9GU6Hc1og6Ls7i6U/mkkaduKaBhlAXv9k" crossorigin="anonymous"></script>

<!-- annotation.js -->
<script src="js/error.js"></script>

<link rel="stylesheet" href="css/error.css">
<title>
  Semantic Data
</title>
</head>
<body>

<div class="container">
  <div class="text-justified">
    <div class="sticky-top">
      <table class="table table-hover" style="height: 100px;">
  
      <?php
      
        echo '<tr><td><b>ID</b></td><td>' . $row["linear_id"] . '</td></tr>';
        echo '<tr><td><b>Source/Natural Language Generated</b></td><td>' . $row["lex"] . '</td></tr>';
        echo '<tr><td><b>Machine Translation</b></td><td>' . $row["trans"] . '</td></tr>';
        echo '<tr><td><b>Target/Human Postedited</b></td><td>' . $row["post"] . '</td></tr>';
      
      $score_table = [
        1 => "very poor",
        2 => "poor",
        3 => "medium",
        4 => "good",
        5 => "very good"
        ];
        
      ?>
      
      </table>
    </div>

  <form action="/~felipealco/webnlg-pt/error.php" method="post">

    <div class="form-check">
      <div class="row">
      <h3>Source/Natural Language Generated</h3>
      </div>
      <div class=row style="font-size:12px;">
        <div class="col">
          Lexis
          <ul style="list-style-type: square;">
            <li>Mistranslation</li>
            <ul>
              <li>
                <input class="form-check-input" type="checkbox" name="source[]" value="Common Noun">
                <label class="form-check-label" for="Common Noun">Common Noun</label>
              </li>
              <li>
                <input class="form-check-input" type="checkbox" name="source[]" value="Proper Noun">
                <label class="form-check-label" for="Proper Noun">Proper Noun</label>
              </li>
              <li>
                <input class="form-check-input" type="checkbox" name="source[]" value="Terminology">
                <label class="form-check-label" for="Terminology">Terminology</label>
              </li>
            </ul>
            <li>
              <input class="form-check-input" type="checkbox" name="source[]" value="Addition">
              <label class="form-check-label" for="Addition">Addition</label>
            </li>
            <li>
              <input class="form-check-input" type="checkbox" name="source[]" value="Omission">
              <label class="form-check-label" for="exampleRadios2">Omission</label>
            </li>
            <li>
              <input class="form-check-input" type="checkbox" name="source[]" value="Untranslated">
              <label class="form-check-label" for="exampleRadios2">Untranslated</label>
            </li>
            <li>
              <input class="form-check-input" type="checkbox" name="source[]" value="Should not be translated">
              <label class="form-check-label" for="exampleRadios2">Should not be translated</label>
            </li>
          </ul>
        </div>
        <div class="col">
          Morphology
          <ul style="list-style-type: square;">
            <li>Inflection</li>
            <ul>
              <li>
                <input class="form-check-input" type="checkbox" name="source[]" value="Tense">
                <label class="form-check-label" for="exampleRadios2">Tense</label>
              </li>
              <li>
                <input class="form-check-input" type="checkbox" name="source[]" value="Number">
                <label class="form-check-label" for="exampleRadios2">Number</label>
              </li>
              <li>
                <input class="form-check-input" type="checkbox" name="source[]" value="Person">
                <label class="form-check-label" for="exampleRadios2">Person</label>
              </li>
              <li>
                <input class="form-check-input" type="checkbox" name="source[]" value="Gender">
                <label class="form-check-label" for="exampleRadios2">Gender</label>
              </li>
            </ul>
            <li>
              <input class="form-check-input" type="checkbox" name="source[]" value="Clitics">
              <label class="form-check-label" for="exampleRadios2">Clitics</label>
            </li>
            <li>Derivation</li>
            <ul>
              <li>
                <input class="form-check-input" type="checkbox" name="source[]" value="Part of speech">
                <label class="form-check-label" for="exampleRadios2">Part of speech</label>
              </li>
              <li>
                <input class="form-check-input" type="checkbox" name="source[]" value="Verb aspect">
                <label class="form-check-label" for="exampleRadios2">Verb aspect</label>
              </li>
            </ul>
            <li>
              <input class="form-check-input" type="checkbox" name="source[]" value="Composition">
              <label class="form-check-label" for="exampleRadios2">Composition</label>
            </li>
          </ul>
        </div>
        <div class="col">
          Orthography
          <ul>
            <li>
              <input class="form-check-input" type="checkbox" name="source[]" value="Capitalisation">
              <label class="form-check-label" for="exampleRadios2">Capitalisation</label>
            </li>
            <li>
              <input class="form-check-input" type="checkbox" name="source[]" value="Punctuation">
              <label class="form-check-label" for="exampleRadios2">Punctuation</label>
            </li>
            <li>
              <input class="form-check-input" type="checkbox" name="source[]" value="Spelling">
              <label class="form-check-label" for="exampleRadios2">Spelling</label>
            </li>
          </ul>
          Grammar
          <ul>
            <li>
              <input class="form-check-input" type="checkbox" name="source[]" value="Noun phrase">
              <label class="form-check-label" for="exampleRadios2">Noun phrase</label>
            </li>
            <li>
              <input class="form-check-input" type="checkbox" name="source[]" value="Verb phrase">
              <label class="form-check-label" for="exampleRadios2">Verb phrase</label>
            </li>
            <li>
              <input class="form-check-input" type="checkbox" name="source[]" value="Prepositional phrase">
              <label class="form-check-label" for="exampleRadios2">Prepositional phrase</label>
            </li>
          </ul>
        </div>
        <div class="col">
          Syntax
          <ul>
            <li>
              <input class="form-check-input" type="checkbox" name="source[]" value="Word order">
              <label class="form-check-label" for="exampleRadios2">Word order</label>
            </li>
            <li>
              <input class="form-check-input" type="checkbox" name="source[]" value="Phrase order">
              <label class="form-check-label" for="exampleRadios2">Phrase order</label>
            </li>
            <li>
              <input class="form-check-input" type="checkbox" name="source[]" value="Clause order">
              <label class="form-check-label" for="exampleRadios2">Clause order</label>
            </li>
          </ul>
          Semantic
          <ul>
            <li>
              <input class="form-check-input" type="checkbox" name="source[]" value="Multi-word expressions">
              <label class="form-check-label" for="exampleRadios2">Multi-word expressions</label>
            </li>
            <li>
              <input class="form-check-input" type="checkbox" name="source[]" value="Collocations">
              <label class="form-check-label" for="exampleRadios2">Collocations</label>
            </li>
            <li>
              <input class="form-check-input" type="checkbox" name="source[]" value="Disambiguation">
              <label class="form-check-label" for="exampleRadios2">Disambiguation</label>
            </li>
          </ul>
          <input class="form-check-input" type="checkbox" name="source[]" value="Measure Unit Notation">
          <label class="form-check-label" for="exampleRadios2">Measure Unit Notation</label>
        </div>
        <label for="exampleFormControlTextarea1"></label>
        <textarea class="form-control" id="comment" name="source_comment" rows="1"></textarea>
      </div> <!--source-->
      
      <div class="row" style="margin-top:50px;">
      <h3>Machine Translation</h3>
      </div>
      <div class=row style="font-size:12px;">
        <div class="col">
          Lexis
          <ul style="list-style-type: square;">
            <li>Mistranslation</li>
            <ul>
              <li>
                <input class="form-check-input" type="checkbox" name="machine[]" value="Common Noun">
                <label class="form-check-label" for="Common Noun">Common Noun</label>
              </li>
              <li>
                <input class="form-check-input" type="checkbox" name="machine[]" value="Proper Noun">
                <label class="form-check-label" for="Proper Noun">Proper Noun</label>
              </li>
              <li>
                <input class="form-check-input" type="checkbox" name="machine[]" value="Terminology">
                <label class="form-check-label" for="Terminology">Terminology</label>
              </li>
            </ul>
            <li>
              <input class="form-check-input" type="checkbox" name="machine[]" value="Addition">
              <label class="form-check-label" for="Addition">Addition</label>
            </li>
            <li>
              <input class="form-check-input" type="checkbox" name="machine[]" value="Omission">
              <label class="form-check-label" for="exampleRadios2">Omission</label>
            </li>
            <li>
              <input class="form-check-input" type="checkbox" name="machine[]" value="Untranslated">
              <label class="form-check-label" for="exampleRadios2">Untranslated</label>
            </li>
            <li>
              <input class="form-check-input" type="checkbox" name="machine[]" value="Should not be translated">
              <label class="form-check-label" for="exampleRadios2">Should not be translated</label>
            </li>
          </ul>
        </div>
        <div class="col">
          Morphology
          <ul style="list-style-type: square;">
            <li>Inflection</li>
            <ul>
              <li>
                <input class="form-check-input" type="checkbox" name="machine[]" value="Tense">
                <label class="form-check-label" for="exampleRadios2">Tense</label>
              </li>
              <li>
                <input class="form-check-input" type="checkbox" name="machine[]" value="Number">
                <label class="form-check-label" for="exampleRadios2">Number</label>
              </li>
              <li>
                <input class="form-check-input" type="checkbox" name="machine[]" value="Person">
                <label class="form-check-label" for="exampleRadios2">Person</label>
              </li>
              <li>
                <input class="form-check-input" type="checkbox" name="machine[]" value="Gender">
                <label class="form-check-label" for="exampleRadios2">Gender</label>
              </li>
            </ul>
            <li>
              <input class="form-check-input" type="checkbox" name="machine[]" value="Clitics">
              <label class="form-check-label" for="exampleRadios2">Clitics</label>
            </li>
            <li>Derivation</li>
            <ul>
              <li>
                <input class="form-check-input" type="checkbox" name="machine[]" value="Part of speech">
                <label class="form-check-label" for="exampleRadios2">Part of speech</label>
              </li>
              <li>
                <input class="form-check-input" type="checkbox" name="machine[]" value="Verb aspect">
                <label class="form-check-label" for="exampleRadios2">Verb aspect</label>
              </li>
            </ul>
            <li>
              <input class="form-check-input" type="checkbox" name="machine[]" value="Composition">
              <label class="form-check-label" for="exampleRadios2">Composition</label>
            </li>
          </ul>
        </div>
        <div class="col">
          Orthography
          <ul>
            <li>
              <input class="form-check-input" type="checkbox" name="machine[]" value="Capitalisation">
              <label class="form-check-label" for="exampleRadios2">Capitalisation</label>
            </li>
            <li>
              <input class="form-check-input" type="checkbox" name="machine[]" value="Punctuation">
              <label class="form-check-label" for="exampleRadios2">Punctuation</label>
            </li>
            <li>
              <input class="form-check-input" type="checkbox" name="machine[]" value="Spelling">
              <label class="form-check-label" for="exampleRadios2">Spelling</label>
            </li>
          </ul>
          Grammar
          <ul>
            <li>
              <input class="form-check-input" type="checkbox" name="machine[]" value="Noun phrase">
              <label class="form-check-label" for="exampleRadios2">Noun phrase</label>
            </li>
            <li>
              <input class="form-check-input" type="checkbox" name="machine[]" value="Verb phrase">
              <label class="form-check-label" for="exampleRadios2">Verb phrase</label>
            </li>
            <li>
              <input class="form-check-input" type="checkbox" name="machine[]" value="Prepositional phrase">
              <label class="form-check-label" for="exampleRadios2">Prepositional phrase</label>
            </li>
          </ul>
        </div>
        <div class="col">
          Syntax
          <ul>
            <li>
              <input class="form-check-input" type="checkbox" name="machine[]" value="Word order">
              <label class="form-check-label" for="exampleRadios2">Word order</label>
            </li>
            <li>
              <input class="form-check-input" type="checkbox" name="machine[]" value="Phrase order">
              <label class="form-check-label" for="exampleRadios2">Phrase order</label>
            </li>
            <li>
              <input class="form-check-input" type="checkbox" name="machine[]" value="Clause order">
              <label class="form-check-label" for="exampleRadios2">Clause order</label>
            </li>
          </ul>
          Semantic
          <ul>
            <li>
              <input class="form-check-input" type="checkbox" name="machine[]" value="Multi-word expressions">
              <label class="form-check-label" for="exampleRadios2">Multi-word expressions</label>
            </li>
            <li>
              <input class="form-check-input" type="checkbox" name="machine[]" value="Collocations">
              <label class="form-check-label" for="exampleRadios2">Collocations</label>
            </li>
            <li>
              <input class="form-check-input" type="checkbox" name="machine[]" value="Disambiguation">
              <label class="form-check-label" for="exampleRadios2">Disambiguation</label>
            </li>
          </ul>
          <input class="form-check-input" type="checkbox" name="machine[]" value="Measure Unit Notation">
          <label class="form-check-label" for="exampleRadios2">Measure Unit Notation</label>
        </div>
        <label for="exampleFormControlTextarea1"></label>
        <textarea class="form-control" id="comment" name="machine_comment" rows="1"></textarea>
      </div> <!--machine-->
      
      <div class="row" style="margin-top:50px;">
      <h3>Target/Human Postedited</h3>
      </div>
      <div class=row style="font-size:12px;">
        <div class="col">
          Lexis
          <ul style="list-style-type: square;">
            <li>Mistranslation</li>
            <ul>
              <li>
                <input class="form-check-input" type="checkbox" name="postedition[]" value="Common Noun">
                <label class="form-check-label" for="Common Noun">Common Noun</label>
              </li>
              <li>
                <input class="form-check-input" type="checkbox" name="postedition[]" value="Proper Noun">
                <label class="form-check-label" for="Proper Noun">Proper Noun</label>
              </li>
              <li>
                <input class="form-check-input" type="checkbox" name="postedition[]" value="Terminology">
                <label class="form-check-label" for="Terminology">Terminology</label>
              </li>
            </ul>
            <li>
              <input class="form-check-input" type="checkbox" name="postedition[]" value="Addition">
              <label class="form-check-label" for="Addition">Addition</label>
            </li>
            <li>
              <input class="form-check-input" type="checkbox" name="postedition[]" value="Omission">
              <label class="form-check-label" for="exampleRadios2">Omission</label>
            </li>
            <li>
              <input class="form-check-input" type="checkbox" name="postedition[]" value="Untranslated">
              <label class="form-check-label" for="exampleRadios2">Untranslated</label>
            </li>
            <li>
              <input class="form-check-input" type="checkbox" name="postedition[]" value="Should not be translated">
              <label class="form-check-label" for="exampleRadios2">Should not be translated</label>
            </li>
          </ul>
        </div>
        <div class="col">
          Morphology
          <ul style="list-style-type: square;">
            <li>Inflection</li>
            <ul>
              <li>
                <input class="form-check-input" type="checkbox" name="postedition[]" value="Tense">
                <label class="form-check-label" for="exampleRadios2">Tense</label>
              </li>
              <li>
                <input class="form-check-input" type="checkbox" name="postedition[]" value="Number">
                <label class="form-check-label" for="exampleRadios2">Number</label>
              </li>
              <li>
                <input class="form-check-input" type="checkbox" name="postedition[]" value="Person">
                <label class="form-check-label" for="exampleRadios2">Person</label>
              </li>
              <li>
                <input class="form-check-input" type="checkbox" name="postedition[]" value="Gender">
                <label class="form-check-label" for="exampleRadios2">Gender</label>
              </li>
            </ul>
            <li>
              <input class="form-check-input" type="checkbox" name="postedition[]" value="Clitics">
              <label class="form-check-label" for="exampleRadios2">Clitics</label>
            </li>
            <li>Derivation</li>
            <ul>
              <li>
                <input class="form-check-input" type="checkbox" name="postedition[]" value="Part of speech">
                <label class="form-check-label" for="exampleRadios2">Part of speech</label>
              </li>
              <li>
                <input class="form-check-input" type="checkbox" name="postedition[]" value="Verb aspect">
                <label class="form-check-label" for="exampleRadios2">Verb aspect</label>
              </li>
            </ul>
            <li>
              <input class="form-check-input" type="checkbox" name="postedition[]" value="Composition">
              <label class="form-check-label" for="exampleRadios2">Composition</label>
            </li>
          </ul>
        </div>
        <div class="col">
          Orthography
          <ul>
            <li>
              <input class="form-check-input" type="checkbox" name="postedition[]" value="Capitalisation">
              <label class="form-check-label" for="exampleRadios2">Capitalisation</label>
            </li>
            <li>
              <input class="form-check-input" type="checkbox" name="postedition[]" value="Punctuation">
              <label class="form-check-label" for="exampleRadios2">Punctuation</label>
            </li>
            <li>
              <input class="form-check-input" type="checkbox" name="postedition[]" value="Spelling">
              <label class="form-check-label" for="exampleRadios2">Spelling</label>
            </li>
          </ul>
          Grammar
          <ul>
            <li>
              <input class="form-check-input" type="checkbox" name="postedition[]" value="Noun phrase">
              <label class="form-check-label" for="exampleRadios2">Noun phrase</label>
            </li>
            <li>
              <input class="form-check-input" type="checkbox" name="postedition[]" value="Verb phrase">
              <label class="form-check-label" for="exampleRadios2">Verb phrase</label>
            </li>
            <li>
              <input class="form-check-input" type="checkbox" name="postedition[]" value="Prepositional phrase">
              <label class="form-check-label" for="exampleRadios2">Prepositional phrase</label>
            </li>
          </ul>
        </div>
        <div class="col">
          Syntax
          <ul>
            <li>
              <input class="form-check-input" type="checkbox" name="postedition[]" value="Word order">
              <label class="form-check-label" for="exampleRadios2">Word order</label>
            </li>
            <li>
              <input class="form-check-input" type="checkbox" name="postedition[]" value="Phrase order">
              <label class="form-check-label" for="exampleRadios2">Phrase order</label>
            </li>
            <li>
              <input class="form-check-input" type="checkbox" name="postedition[]" value="Clause order">
              <label class="form-check-label" for="exampleRadios2">Clause order</label>
            </li>
          </ul>
          Semantic
          <ul>
            <li>
              <input class="form-check-input" type="checkbox" name="postedition[]" value="Multi-word expressions">
              <label class="form-check-label" for="exampleRadios2">Multi-word expressions</label>
            </li>
            <li>
              <input class="form-check-input" type="checkbox" name="postedition[]" value="Collocations">
              <label class="form-check-label" for="exampleRadios2">Collocations</label>
            </li>
            <li>
              <input class="form-check-input" type="checkbox" name="postedition[]" value="Disambiguation">
              <label class="form-check-label" for="exampleRadios2">Disambiguation</label>
            </li>
          </ul>
          <input class="form-check-input" type="checkbox" name="postedition[]" value="Measure Unit Notation">
          <label class="form-check-label" for="exampleRadios2">Measure Unit Notation</label>
        </div>
        <label for="exampleFormControlTextarea1"></label>
        <textarea class="form-control" id="comment" name="postedition_comment" rows="1"></textarea>
      </div> <!--postedition-->
      
    </div> <!--form-check-->
    
    <?php echo '<input type="hidden" id="linear_id" name="linear_id" value="' .$row["linear_id"] . '">'?>
    <?php echo '<input type="hidden" id="translation_id" name="translation_id" value="' .$row["translation_id"] . '">'?>
    

    
    <?php echo "<a href=\"error.php\" class=\"btn btn-secondary\" role=\"button\" aria-pressed=\"true\">Skip</a>"; ?>
    <button type="submit" class="btn btn-primary" style="margin: 50px; float:">Submit</button>
  </form>
</div>
</div>




  </div>
</div>
</body>
</html>
