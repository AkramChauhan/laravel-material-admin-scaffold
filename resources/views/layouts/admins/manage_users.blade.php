@extends('layouts.admins.app')
@section('content')
  <div class="container-fluid">
    <div class="row clearfix">
      <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
          <div class="card">
              <div class="header">
                  <h2>
                      Manage Users
                      <small>Few more line description</small>
                  </h2>

                  <hr />
                  <div class="row">
                    <div class="col-md-4">
                      <div class="form-group">
                        <div class="form-line searchUserField">
                          <input type="text" class="form-control searchUser" id="searchUser" aria-describedby="searchHelp" placeholder="Search by User Name">
                        </div>
                      </div>
                    </div>
                    <div class="col-md-2">
                      <div class="form-group">
                        <input type="submit" class="btn btn-success searchUserBtn" value="Search">
                        <input type="reset" class="btn btn-primary resetBtn" value="RESET">
                      </div>
                    </div>
              </div>
              <div class="table-responsive">
                <div id="displayLoader" align="center">
                  <h2>Loading...</h2>
                </div>
                <div id="loadUsers"></div>
              </div>
          </div>
      </div>
    </div>  
  </div>
@endsection
@section('additional_scripts')
<!-- <script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.10/js/select2.min.js"></script> -->
<script>

  function loadUsers(item_per_page=10,current_page = 1){
    $("html, body").animate({ scrollTop: 0 }, "slow");
    $("#loadUsers").hide();
    $("#displayLoader").show();
    search_str = $("#searchUser").val();
    token = '{{ csrf_token() }}';
    data = "search_str="+search_str+"&_token="+token+"&current_page="+current_page+"&item_per_page="+item_per_page;
    $.ajax({
      type: "POST",
      url: '{{ route("admin-manage-users") }}',
      data: data,
      success: function(response){
        setTimeout(function(){
          $("#loadUsers").show();
          $("#loadUsers").html(response.data);
          $("#displayLoader").hide();
         
        },1000);
      }
    });
  }
  $(document).ready(function(){
    // $('.group_type_dropdown').select2();
    // $('.group_categories_dropdown').select2();

    $("#searchUser").keyup(function(){
      $("#searchUser").removeClass('is-invalid');
      $(".searchUserField").removeClass('focused error');
    });
    $(".searchUserBtn").click(function(){
      $("#searchUser").removeClass('is-invalid');
      $(".searchUserField").removeClass('focused error');
      var searchStr = $("#searchUser").val();
      if(searchStr.trim()==''){
        $("#searchUser").addClass('is-invalid');
        $(".searchUserField").addClass('focused error');
        return false;
      }else{
        loadUsers();
      }
    });
    $(".resetBtn").click(function(){
      $("#searchUser").val('');
      
      $("#category_id").val('default');
      $("#group_type_id").val('default');
      
      $("#category_id").selectpicker("refresh");
      $("#group_type_id").selectpicker("refresh");
      loadUsers();
    });
    $("#loadUsers").on( "click", ".paging_simple_numbers a", function (e){
      e.preventDefault();
      var current_page = $(this).attr("data-page");
      var limit = 10;
      loadUsers(limit,current_page);
    });

    $("#group_type_id").on('change',function(){
      loadUsers();
    });
    $("#category_id").on('change',function(){
      loadUsers();
    });

    loadUsers();

  });
  
</script>
@endsection