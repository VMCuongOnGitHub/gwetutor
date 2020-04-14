<?php
    if(!isset($_SESSION))
    {
        session_start();
    }

    if (!isset($_SESSION['username'])) {
        $_SESSION['msg'] = "You must log in first";
        header('location: login.php');
        if ($_SESSION['user_role'] == 'tutor') {
            $_SESSION['msg'] = "Unauthorized Access";
            header('location: login.php');
        }
    }

    if (isset($_GET['logout'])) {
        session_destroy();
        unset($_SESSION['username']);
        header("location: login.php");
    }
?>
<?php include('header.php') ?>


<div class="wrapper">
    <!-- Sidebar Holder -->
    <nav id="sidebar">
        <div class="sidebar-header">
            <h3>Tutor</h3>
            <p> <a href="index.php?logout='1'" style="color: red;">logout</a> </p>
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
            <ul class="nav nav-tabs" role="tablist">
                <li class="nav-item ">
                    <a class="nav-link active" data-toggle="tab" href="#schedule-form">Schedule</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" data-toggle="tab" href="#request-form">Request</a>
                </li>
            </ul>

            <div class="tab-content">
                <div id="schedule-form" class="tab-pane fade show active"><br>
                    <form class="" action="">
                        <div class="form-row">
                            <div class="col-md-8">
                                <label>Setup Schedule</label>
                                <input class="form-control" type="datetime-local" value="2011-08-19T13:45:00" id="example-datetime-local-input">
                                <label for="title-schedule">Title</label>
                                <input class="form-control" id="title-schedule">
                                <label for="description-schedule">Description</label>
                                <textarea class="form-control" id="description-schedule"></textarea>
                                <button type="submit" class="btn btn-primary">Submit</button>
                            </div>
                            <div class="col-md-4">
                                <label for="title-schedule">Related Document</label>
                                <input class="form-control" type="file">
                                <ul>
                                    <li>1</li>
                                    <li>2</li>
                                    <li>3</li>
                                </ul>
                            </div>
                        </div>

                    </form>
                </div>

                <div id="request-form" class="tab-pane fade"><br>
                    <form action="">
                        <label for="comment">Post Content</label>
                        <textarea class="form-control" rows="5" id="comment"></textarea>
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

<script type="text/javascript">
    $(document).ready(function () {
        $('#sidebarCollapse').on('click', function () {
            $('#sidebar').toggleClass('active');
            $(this).toggleClass('active');
        });
        $(".form_datetime").datetimepicker({format: 'yyyy-mm-dd hh:ii'});
    });
</script>

<?php include('footer.php') ?>

