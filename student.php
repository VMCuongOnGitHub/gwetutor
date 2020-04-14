<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">

    <title>Collapsible sidebar using Bootstrap 4</title>

    <!-- Bootstrap CSS CDN -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.0/css/bootstrap.min.css">
    <!-- Our Custom CSS -->
    <link rel="stylesheet" href="css/sidebar.css">

    <!-- Font Awesome JS -->
    <script defer src="https://use.fontawesome.com/releases/v5.0.13/js/solid.js"></script>
    <script defer src="https://use.fontawesome.com/releases/v5.0.13/js/fontawesome.js"></script>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>
</head>

<body>
<div class="wrapper">
    <!-- Sidebar Holder -->
    <nav id="sidebar">
        <div class="sidebar-header">
            <h3>Student</h3>
        </div>
    </nav>
    <!-- Page Content Holder -->
    <div id="content">


        <nav class="navbar navbar-expand-lg navbar-light bg-light">

            <div class="container-fluid">
                <button type="button" id="sidebarCollapse" class="navbar-btn">
                    <span></span>
                    <span></span>
                    <span></span>
                </button>

                <button class="btn btn-dark d-inline-block d-lg-none ml-auto" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                    <i class="fas fa-align-justify"></i>
                </button>
            </div>
        </nav>
        <div class="container-fluid"  style="background-color: #1b4b72; padding: 30px 20px 30px 20px">
            <!-- Nav tabs -->
            <ul class="nav nav-tabs" role="tablist">
                <li class="nav-item">
                    <a class="nav-link active" data-toggle="tab" href="#post-form">Post</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" data-toggle="tab" href="#schedule-form">Schedule</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" data-toggle="tab" href="#request-form">Request</a>
                </li>
            </ul>

            <div class="tab-content">
                <div id="post-form" class="container-fluid tab-pane active"><br>
                    <form action="">
                        <div class="form-group" style="margin-top: 10px">
                            <label for="comment">Post Content</label>
                            <textarea class="form-control" rows="5" id="comment"></textarea>
                        </div>
                        <button type="submit" class="btn btn-primary">Submit</button>
                    </form>
                </div>
                <div id="schedule-form" class="container-fluid tab-pane fade"><br>

                    <form class="" action="">
                        <div class="row">
                            <div class="col-sm-10">
                                <label>Setup Schedule</label>
                                <input class="form-control" type="datetime-local" value="2011-08-19T13:45:00" id="example-datetime-local-input">
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-sm-10">
                                <div class="form-group" style="margin-top: 10px">
                                    <label for="title-schedule">Title</label>
                                    <input class="form-control" id="comment">

                                    <label for="description-schedule">Description</label>
                                    <textarea class="form-control" id="description-schedule"></textarea>
                                </div>

                            </div>
                            <div class="col-sm-2">
                                <button type="submit" class="btn btn-primary">Submit</button>
                            </div>
                        </div>


                        <button type="submit" class="btn btn-primary">Submit</button>
                    </form>
                </div>
                <div id="request-form" class="container tab-pane fade"><br>
                    <form action="">
                        <div class="form-group" style="margin-top: 10px">
                            <label for="comment">Post Content</label>
                            <textarea class="form-control" rows="5" id="comment"></textarea>
                        </div>
                        <button type="submit" class="btn btn-primary">Submit</button>
                    </form>
                </div>
            </div>
        </div>

        <div class="container-fluid" style="background-color: #1d68a7; margin-top: 10px; padding: 20px 10px 20px 10px">
            <div class="row">
                <div class="col-sm-2">
                    <div class="text-center">
                        <div style="padding-top: 10px; padding-bottom: 10px; background-color: #1d643b; margin-bottom: 10px">
                            <h1>13</h1>
                            <h3>March</h3>
                        </div>

                        <h4>4/10/2020</h4>
                        <h4 style="margin-top: 20px">Status</h4>
                        <h4>In Comming</h4>
                    </div>

                </div>
                <div class="col-sm-10">
                    <h1>Schedule Title</h1>
                    <p>Postman is a collaboration platform for API development. Postman's features simplify each step of building an API and streamline collaboration so you can create better APIs—faster.</p>
                    <h1>Related Document</h1>
                    <ul>
                        <li>something1</li>
                        <li>something1</li>
                        <li>something1</li>
                    </ul>
                </div>
            </div>
        </div>

        <div class="container-fluid" style="background-color: #1d68a7; margin-top: 10px; padding: 20px 10px 20px 10px">
            <div class="row">
                <div class="col-sm-12">
                    <div class="image-post text-center">
                        <img src="https://dummyimage.com/600x400/3d3d3d/fff" class="img-fluid" alt="Responsive image">
                    </div>
                    <div class="content-post" style="margin-top: 10px">
                        <p>Lorem ipsum dolor sit, amet consectetur adipisicing elit. Recusandae nihil hic delectus excepturi ipsam
                            reprehenderit iusto rem, quam, repellendus accusantium culpa reiciendis sit dolorum aut aperiam a
                            architecto. Fuga, sit.</p>
                        <p>4/10/2020 - 3:40</p>
                    </div>
                </div>

            </div>
            <hr>
            <div class="row">
                <form action="">
                    <div class="col-sm-10">
                        <div class="form-group" style="margin-top: 10px">
                            <input class="form-control" rows="5"  id="comment-post" placeholder="Comment here">
                        </div>
                    </div>
                    <div class="col-sm-2">
                        <button type="submit" class="btn btn-primary">Submit</button>
                    </div>
                </form>
            </div>
            <hr>
        </div>

        <div class="container-fluid" style="background-color: #1d68a7; margin-top: 10px; padding: 20px 10px 20px 10px">
            <div class="row">
                <div class="col-sm-12">
                    <div class="image-post text-center">
                        <img src="https://dummyimage.com/0x0/3d3d3d/fff" class="img-fluid" alt="Responsive image">
                    </div>
                    <div class="content-post" style="margin-top: 10px">
                        <p>Lorem ipsum dolor sit, amet consectetur adipisicing elit. Recusandae nihil hic delectus excepturi ipsam
                            reprehenderit iusto rem, quam, repellendus accusantium culpa reiciendis sit dolorum aut aperiam a
                            architecto. Fuga, sit.</p>
                        <p>4/10/2020 - 3:40</p>
                    </div>
                </div>

            </div>
            <hr>
            <div class="row">
                <form action="">
                    <div class="col-sm-10">
                        <div class="form-group" style="margin-top: 10px">
                            <input class="form-control" rows="5"  id="comment-post" placeholder="Comment here">
                        </div>
                    </div>
                    <div class="col-sm-2">
                        <button type="submit" class="btn btn-primary">Submit</button>
                    </div>
                </form>
            </div>
            <hr>

            <hr>
            <div class="row">

                <div class="col-md-2 text-center">
                    <div style="background-color: #3f9ae5; height: 100px; width: 100px; margin-left: auto">

                    </div>
                </div>
                <div class="col-md-10">
                    <h1>cuong@cuong</h1>
                    <p>Lorem ipsum dolor sit, amet consectetur adipisicing elit.</p>
                    <p>4/10/2020 - 3:40</p>

                    <div style="background-color: #1b1e21; height: 1px; width: 100%"></div>
                </div>

            </div>

            <div class="row">

                <div class="col-md-2 text-center">
                    <div style="background-color: #3f9ae5; height: 100px; width: 100px; margin-left: auto">

                    </div>
                </div>
                <div class="col-md-10">
                    <h1>cuong@cuong</h1>
                    <p>Lorem ipsum dolor sit, amet consectetur adipisicing elit.</p>
                    <p>4/10/2020 - 3:40</p>
                    <div style="background-color: #1b1e21; height: 1px; width: 100%"></div>
                </div>

            </div>

        </div>

    </div>


</div>



<!-- jQuery CDN - Slim version (=without AJAX) -->
<script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
<!-- Popper.JS -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.0/umd/popper.min.js" integrity="sha384-cs/chFZiN24E4KMATLdqdvsezGxaGsi4hLGOzlXwp5UZB1LY//20VyM2taTB4QvJ" crossorigin="anonymous"></script>
<!-- Bootstrap JS -->
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.0/js/bootstrap.min.js" integrity="sha384-uefMccjFJAIv6A+rW+L4AHf99KvxDjWSu1z9VI8SKNVmz4sk7buKt/6v9KI65qnm" crossorigin="anonymous"></script>

<script type="text/javascript">
    $(document).ready(function () {
        $('#sidebarCollapse').on('click', function () {
            $('#sidebar').toggleClass('active');
            $(this).toggleClass('active');
        });
        $(".form_datetime").datetimepicker({format: 'yyyy-mm-dd hh:ii'});
    });
</script>
</body>

</html>

