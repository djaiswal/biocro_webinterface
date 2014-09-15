<?php 
error_reporting(E_ALL);

if(!isset($_POST["query"])){
?><!DOCTYPE html> 
<html lang="en-US"> 
<head> 
<link href="bootstrap.min.css" rel="stylesheet">
<script type="text/javascript" src="https://ajax.googleapis.com/ajax/libs/jquery/1.7.2/jquery.min.js"></script> 
    <script type="text/javascript">
    $(document).ready(function () {
        function loadSample(num){
            $.post($("#query_sample_form").attr("action"), "num="+num,
                function(data) {
                    $("textarea").val(data);
                });
        }
        $("#sample1").click(function(event){
            event.preventDefault();
            loadSample(0);
            this.blur();
        });
        $("#sample2").click(function(event){
            event.preventDefault();
            loadSample(1);
            this.blur();
        });
        $("#sample3").click(function(event){
            event.preventDefault();
            loadSample(2);
            this.blur();
        });
        $("#sample4").click(function(event){
            event.preventDefault();
            loadSample(3);
            this.blur();
        });
        $("#sample5").click(function(event){
            event.preventDefault();
            loadSample(4);
            this.blur();
        });
        $("#submit").click(function(event){
            event.preventDefault();
            $("#result").html("processing..."); 
            $.post($("#query_form").attr("action"), $("#query_form").serialize(),
                function(data) {
                    $("#result").stop().hide(); 
                    $("#result").html(data);
                    $("#result").stop().fadeTo(100,1); 
                });
            this.blur();
        });
    });
    </script>
</head>
<body>
<form id="query_sample_form" class="well form-inline" action="samples.php" method="post">
<button type="submit" id="sample1">Load Sample 1</button>
<button type="submit" id="sample2">Load Sample 2</button>
<button type="submit" id="sample3">Load Sample 3</button>
<button type="submit" id="sample4">Load Sample 4</button>
<button type="submit" id="sample5">Load Sample 5</button>
</form>
<form id="query_form" class="well form-inline" method="post">
<textarea type="text" class="input-xlarge" rows="9" style="width:700px;" name="query" ></textarea>
<br />
<button type="submit" id="submit">Submit Query</button>
</form>

<div id="result"></div>

</body>
</html>
<?php
}else{
    $q=$_POST["query"];

    $host = 'localhost';
    $port = '5432';
    $database = 'SSURGO';
    $user = 'ebi';
    $password = 'ebi~~!';
    $connectString = 'host=' . $host . ' port=' . $port . ' dbname=' . $database . ' user=' . $user . ' password=' . $password; 
    $link = pg_connect ($connectString);
    if (!$link) {
        die('Error: Could not connect: ' . pg_last_error()); 
    } 
    $query = $q; 
    $result = pg_query($query); 
    if($result!=false){
        $i = 0; 
        echo '<table style="width:auto" class="table table-condensed table-bordered table-striped"><thead><tr>'; 
        while ($i < pg_num_fields($result)) { 
            $fieldName = pg_field_name($result, $i); 
            echo '<th>' . $fieldName . '</th>'; 
            $i = $i + 1; } echo '</tr></thead>'; 
            $i = 0; 
            while ($row = pg_fetch_row($result)) { 
                echo '<tr>'; 
                $count = count($row); 
                $y = 0; 
                while ($y < $count) { 
                    $c_row = current($row); 
                    echo '<td>' . htmlspecialchars($c_row) . '</td>'; 
                    next($row); 
                    $y = $y + 1; 
                } 
                echo '</tr>'; 
                $i = $i + 1; 
                if($i>100)
                    break;
            } 
            pg_free_result($result); 
            echo '</table>'; 
    }else{
        print pg_last_error($link);
    }
    pg_close($link);
}
?>
