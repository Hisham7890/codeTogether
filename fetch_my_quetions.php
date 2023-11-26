<?php

$connect = new PDO("mysql:host=localhost:3306; dbname=codeTogether_db", "root", "");

session_start();

$limit = '10';
$page = 1;
if(isset($_POST['page']) && $_POST['page'] > 1)
{
  $start = (($_POST['page'] - 1) * $limit);
  $page = $_POST['page'];
}
else
{
  $start = 0;
}

$query = "
SELECT title, describtion, qID FROM question WHERE posted_by ='". $_SESSION['username']."'
";

if($_POST['query'] != '')
{
  $query .= '
   AND (title LIKE "%'.str_replace(' ', '%', $_POST['query']).'%" || describtion LIKE "%'.str_replace(' ', '%', $_POST['query']).'%")
  ';
}


$filter_query = $query . 'LIMIT '.$start.', '.$limit.'';

$statement = $connect->prepare($query);
$statement->execute();
$total_data = $statement->rowCount();

$statement = $connect->prepare($filter_query);
$statement->execute();
$result = $statement->fetchAll();

$total_filter_data = $statement->rowCount();

$output = '
<h5 class="faq-list">Total Matched Questions - '.$total_data.'</h5>';
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
                                        <a class="getstarted d-inline btn btn-info" href="edit_question.php?qID='.$row["qID"].'">Edit Question</a>
                                        <a class="getstarted d-inline btn btn-danger float-end" href="delete_question.php?qID='.$row["qID"].'">Delete Question</a>
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
  <a class="getstarted btn btn-primary" href="new_question.php">Create a Question</a>
  </div>
  ';
}

$output .= '
</ul></div>
<br />
<div align="center" class="p-0-100">
  <ul class="pagination">
';

$total_links = ceil($total_data/$limit);
$previous_link = '';
$next_link = '';
$page_link = '';



if($total_links > 4)
{
  if($page < 5)
  {
    for($count = 1; $count <= 5; $count++)
    {
      $page_array[] = $count;
    }
    $page_array[] = '...';
    $page_array[] = $total_links;
  }
  else
  {
    $end_limit = $total_links - 5;
    if($page > $end_limit)
    {
      $page_array[] = 1;
      $page_array[] = '...';
      for($count = $end_limit; $count <= $total_links; $count++)
      {
        $page_array[] = $count;
      }
    }
    else
    {
      $page_array[] = 1;
      $page_array[] = '...';
      for($count = $page - 1; $count <= $page + 1; $count++)
      {
        $page_array[] = $count;
      }
      $page_array[] = '...';
      $page_array[] = $total_links;
    }
  }
}
else
{
  for($count = 1; $count <= $total_links; $count++)
  {
    $page_array[] = $count;
  }
}

if(isset($page_array)) {
  for($count = 0; $count < count($page_array); $count++)
  {
    if($page == $page_array[$count])
    {
      $page_link .= '
      <li class="page-item active">
        <a class="page-link" href="#">'.$page_array[$count].' <span class="sr-only">(current)</span></a>
      </li>
      ';

      $previous_id = $page_array[$count] - 1;
      if($previous_id > 0)
      {
        $previous_link = '<li class="page-item"><a class="page-link" href="javascript:void(0)" data-page_number="'.$previous_id.'">Previous</a></li>';
      }
      else
      {
        $previous_link = '
        <li class="page-item disabled">
          <a class="page-link" href="#">Previous</a>
        </li>
        ';
      }
      $next_id = $page_array[$count] + 1;
      if($next_id >= $total_links)
      {
        $next_link = '
        <li class="page-item disabled">
          <a class="page-link" href="#">Next</a>
        </li>
          ';
      }
      else
      {
        $next_link = '<li class="page-item"><a class="page-link" href="javascript:void(0)" data-page_number="'.$next_id.'">Next</a></li>';
      }
    }
    else
    {
      if($page_array[$count] == '...')
      {
        $page_link .= '
        <li class="page-item disabled">
            <a class="page-link" href="#">...</a>
        </li>
        ';
      }
      else
      {
        $page_link .= '
        <li class="page-item"><a class="page-link" href="javascript:void(0)" data-page_number="'.$page_array[$count].'">'.$page_array[$count].'</a></li>
        ';
      }
    }
  }
}

$output .= $previous_link . $page_link . $next_link;
$output .= '
  </ul>

</div>
';

echo $output;

?>