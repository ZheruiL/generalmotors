<!DOCTYPE html>
<!-- saved from url=(0053) -->
<html lang="en">
<head><meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>Manager Test</title>

    <link rel="canonical" href="">

    <!-- Bootstrap core CSS -->
  <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">

    <!-- Custom styles for this template -->
    <link href="css/dashboard.css?v=7" rel="stylesheet">
  <body>
    <nav class="navbar navbar-dark fixed-top bg-dark flex-md-nowrap p-0 shadow">
      <span class="navbar-brand col-sm-3 col-md-2 mr-0">Manager test</span>
      <input class="form-control form-control-dark w-100" id="general_search" type="text" placeholder="Search user, task..." aria-label="Search">
      <div id="search_result" class="card" style="display: none; position: fixed; top: 45px; margin:0 auto;left:16.5%;right:1%; z-index: 500;">

      </div>
      <ul class="navbar-nav px-3">
        <li class="nav-item text-nowrap">
        </li>
      </ul>
    </nav>

    <div class="container-fluid">
      <div class="row">
        <nav class="col-md-2 d-none d-md-block bg-light sidebar">
          <div class="sidebar-sticky">
            <ul class="nav flex-column">
              <li class="nav-item">
                <a class="nav-link active m-link" href="javascript:void(0)" data-page="users">
                  <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-users"><path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"></path><circle cx="9" cy="7" r="4"></circle><path d="M23 21v-2a4 4 0 0 0-3-3.87"></path><path d="M16 3.13a4 4 0 0 1 0 7.75"></path></svg>
                  Users
                </a>
              </li>
              <li class="nav-item">
                <a class="nav-link m-link" href="javascript:void(0)" data-page="tasks">
                  <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-file"><path d="M13 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V9z"></path><polyline points="13 2 13 9 20 9"></polyline></svg>
                  Task
                </a>
              </li>
              <li class="nav-item">
                <a class="nav-link m-link" href="javascript:void(0)" data-page="about">
                  <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-layers"><polygon points="12 2 2 7 12 12 22 7 12 2"></polygon><polyline points="2 17 12 22 22 17"></polyline><polyline points="2 12 12 17 22 12"></polyline></svg>
                  About
                </a>
              </li>
            </ul>
          </div>
        </nav>

        <main role="main" class="col-md-9 ml-sm-auto col-lg-10 px-4"><div class="chartjs-size-monitor" style="position: absolute; left: 0px; top: 0px; right: 0px; bottom: 0px; overflow: hidden; pointer-events: none; visibility: hidden; z-index: -1;"><div class="chartjs-size-monitor-expand" style="position:absolute;left:0;top:0;right:0;bottom:0;overflow:hidden;pointer-events:none;visibility:hidden;z-index:-1;"><div style="position:absolute;width:1000000px;height:1000000px;left:0;top:0"></div></div><div class="chartjs-size-monitor-shrink" style="position:absolute;left:0;top:0;right:0;bottom:0;overflow:hidden;pointer-events:none;visibility:hidden;z-index:-1;"><div style="position:absolute;width:200%;height:200%;left:0; top:0"></div></div></div>
          <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3"> <!-- border-bottom-->
            <h1 class="h2" id="page_title"></h1>
          </div>
          <div id="page_content">
          </div>
        </main>
      </div>
    </div>

    <script src="js/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>

    <script src="js/main.js?v=<?php echo time()?>"></script>
    <script src="js/tasks_page.js?v=<?php echo time()?>"></script>
    <script src="js/users_page.js?v=<?php echo time()?>"></script>
    <script src="js/user_page.js?v=<?php echo time()?>"></script>
    <script src="js/about_page.js?v=<?php echo time()?>"></script>
    <script>
      const timestamp=new Date().getTime();
      const base_url = '../';
      $(function() {
        reloadPage('users');
        $('.m-link').click(function () {
          $('.m-link').removeClass('active');
          $(this).addClass('active');
          localStorage.removeItem('user_id');
          reloadPage($(this).data('page'));
        });
      });
      // click outside to hide the search result
      $(window).click(function() {
        $("#search_result").hide();
      });
      $('#search_result').click(function(event){
        event.stopPropagation();
      });
      $("#general_search").click(function (event) {
        event.stopPropagation();
      });

      $("#general_search").donetyping(function(){
        if($(this).val()!==''){
          $("#search_result").show().html(spinner());

          let ajax_search_task = $.ajax({
            type: 'GET',
            url: base_url + 'tasks',
            data: {search_q : $(this).val()},
            error: function (jqXHR, textStatus, errorThrown) {
              alert(textStatus+errorThrown);
            }
          });
          let ajax_search_user = $.ajax({
            type: 'GET',
            url: base_url + 'users',
            data: {search_q : $(this).val()},
            error: function (jqXHR, textStatus, errorThrown) {
              alert(textStatus+errorThrown);
            }
          });
          // show the result when all the searches are done
          $.when(ajax_search_task, ajax_search_user).done(function(tasks, users){
            //tasks = JSON.parse(tasks[0]);
            //users = JSON.parse(users[0]);
            tasks = tasks[0];
            users = users[0];
            let user_html = '<h6>Users</h6><div class="list-group">';
            if(users==null){
              user_html+='no result';
            }
            users.forEach(function(user){
              user_html+='<a href="javascript:void(0)" onclick="showUser('+user.id+')" class="list-group-item list-group-item-action">'+user.name+'---'+user.email+'</a>';
            });
            user_html+='</div>';

            let task_html = '<h6>Tasks</h6><div class="list-group">';
            if(tasks==null){
              task_html+='no result';
            }
            tasks.forEach(function(task){
              task_html+='<a href="javascript:void(0)" class="list-group-item list-group-item-action">'+task.title+'</a>';
            });
            task_html+='</div>';

            $("#search_result").html(user_html+'<hr>'+task_html);
            if(tasks[0]==null&&users[0]==null){
              $("#search_result").html("no result");
            }
          });
        }
        else{
          $("#search_result").hide();
        }

      });


    </script>
  

</body></html>