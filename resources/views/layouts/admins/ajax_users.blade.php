<?php if(count($users)>0){ ?>
  <table class="table table-striped">
    <thead>
      <tr>
        <th>#</th>
        <th>Name</th>
        <th>Email Address</th>
        <th>Phone Number</th>
        <th>Registed Date</th>
      </tr>
    </thead>
    <tbody>
    <?php $i=1; ?>
      @foreach($users as $user)                      
        <tr>
          <th scope="row"><?php echo ($pagination['current_page']-1)*$pagination['item_per_page']+$i; ?></th>
          <td> {{ $user->name }} </td>
          <td> {{ $user->email }} </td>
          <td> {{ $user->phone_number }}</td>
          <td> {{ date('d- M -Y',strtotime($user->created_at)) }}
          </td>
        </tr>
        <?php $i++; ?>
      @endforeach
    </tbody>
  </table>

  <?php }else { ?>
  <div class="card">
    <div class="card-body">
      <h3>Opps, sounds like users are not available..</h3>
      <small>Try reseting filter form.</small>
    </div>
  </div>
  <?php } ?>
<div class="paging_simple_numbers">
  <ul class="pagination">
    <?php 
    echo paginate_function($pagination['item_per_page'],$pagination['current_page'],$pagination['total_records'],$pagination['total_pages']);
    ?>
  </ul>
</div>
  
<?php

function paginate_function($item_per_page, $current_page, $total_records, $total_pages){
  $pagination = '';
  if($total_pages > 0 && $total_pages != 1 && $current_page <= $total_pages){ //verify total pages and current page number
    $right_links  = $current_page + 3; 
    $previous    = $current_page - 3; //previous link 
    $next     = $current_page + 1; //next link
    $first_link  = true; //boolean var to decide our first link
    
    if($current_page > 1){
    $previous_link = ($previous<=0)?1:$previous;
      $pagination .= '<li class="page-item "><a class="paginate_link page-link" aria-controls="datatable1" data-page="1" title="First">&laquo;</a></li>'; //first link
      $pagination .= '<li class="page-item "><a class="paginate_link page-link" aria-controls="datatable1" data-page="'.$previous_link.'" title="Previous">&lt;</a></li>'; //previous link
        for($i = ($current_page-2); $i < $current_page; $i++){ //Create left-hand side links
          if($i > 0){
            $pagination .= '<li class="page-item "><a class="paginate_link page-link" data-page="'.$i.'" aria-controls="datatable1" title="Page'.$i.'">'.$i.'</a></li>';
          }
        }   
      $first_link = false; //set first link to false
    }
    
    if($first_link){ //if current active page is first link
      $pagination .= '<li class="page-item active">
      <a class="paginate_link page-link" aria-controls="datatable1">'.$current_page.'</a></li>';
    }elseif($current_page == $total_pages){ //if it's the last active link
      $pagination .= '<li class="page-item active">
      <a class="paginate_link page-link" aria-controls="datatable1">'.$current_page.'</a></li>';
    }else{ //regular current link
      $pagination .= '<li class="page-item active">
      <a class="paginate_link page-link" aria-controls="datatable1">'.$current_page.'</a></li>';
    }
        
    for($i = $current_page+1; $i < $right_links ; $i++){ //create right-hand side links
      if($i<=$total_pages){
        $pagination .= '<li class="page-item "><a class="paginate_link page-link" href="#" aria-controls="datatable1" data-page="'.$i.'" title="Page '.$i.'">'.$i.'</a></li>';
      }
    }
    if($current_page < $total_pages){ 
    $next_link = ($i > $total_pages)? $total_pages : $i;
    $pagination .= '<li class="page-item "><a class="paginate_link page-link" href="#" aria-controls="datatable1" data-page="'.$next_link.'" title="Next">&gt;</a></li>'; //next link
    $pagination .= '<li class="page-item "><a class="paginate_link page-link" href="#" aria-controls="datatable1" data-page="'.$total_pages.'" title="Last">&raquo;</a></li>'; //last link
    }
  }
  return $pagination; //return pagination links
}
?>