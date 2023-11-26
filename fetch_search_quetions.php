<?php
$output='';

if($_POST['query'] != ''){
$connect = new PDO("mysql:host=localhost:3306; dbname=codetogether_db", "root", "");


session_start();

$query = '
SELECT title, describtion, qID FROM question WHERE title LIKE "%'.str_replace(' ', '%', $_POST['query']).'%" || describtion LIKE "%'.str_replace(' ', '%', $_POST['query']).'%"
';
;


$statement = $connect->prepare($query);
$statement->execute();
$total_data = $statement->rowCount();


$result = $statement->fetchAll();


if($total_data > 0)
{
  $output .= '
      <div class="faq-list">

      <ul>';
  foreach($result as $row)
  {
    $output .= '
    <li>
                                    <i class="bx bx-help-circle icon-help"></i> <a class="collapse">'.$row["title"].' <i class="bx bx-chevron-down icon-show"></i></a>
                                    <div class="collapse show">
                                        <p class="mb-3">
                                            '.$row["describtion"].'
                                        </p>
                                    </div>

                                </li>


    ';
  }
}
else
{
  $output .= '
  <div class="text-center">
  <h3>No Questions Found!!!!!</h3>
  </div>
  ';
}

$output .= '
</ul></div>
';


}


echo $output;

?>