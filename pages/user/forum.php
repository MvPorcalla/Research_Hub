<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>HOME PAGE - LNHS Research Hub</title>
    <link rel="icon" href="../../assets/icons/LNHS-icon.png" type="image/png">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="../../css/mainStyle.css">
</head>

<body>
    <!-- header -->
    <?php include './../user/components/header.php'; ?>

    <!-- main content with sidebar -->
    <div class="container-fluid">
        <div class="row ">
            <!-- sidebar -->
            <?php include './../user/components/sidebar.php'; ?>

            <!-- Main content area -->
            <main class="col-md-9 ms-sm-auto col-lg-9 px-md-4">
                <div class="container">
                    <div class="row">

                        <div class="mt-5 mb-3 text-center">
                            <h1 class='admin-subtitle'>Forum</h1>
                        </div>

                        <div class="col-md-12">
                             <!-- filter Content -->
                            <div class="row text-left mb-3">
                                <div class="col-lg-4 mb-2 mb-sm-0">
                                    <div class="dropdown bootstrap-select form-control form-control-sm bg-white bg-op-9 text-sm" style="width: 100%;">
                                        <select class="form-control form-control-sm bg-white bg-op-9 text-sm" data-toggle="select">
                                            <option> Categories </option>
                                            <option> Research Methods </option>
                                            <option> Data Analysis </option>
                                            <option> Literature Review </option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-lg-4 text-lg-right">
                                    <div class="dropdown bootstrap-select form-control form-control-sm bg-white bg-op-9 ml-auto text-sm" style="width: 100%;">
                                        <select class="form-control form-control-sm bg-white bg-op-9 ml-auto text-sm" data-toggle="select">
                                            <option> Filter by </option>
                                            <option> Most Recent </option>
                                            <option> Most Votes </option>
                                            <option> Most Replies </option>
                                        </select>
                                    </div>
                                </div>

                                <div class='col-lg-4 text-center'>
                                    <a class="btn btn-sm btn-block btn-success rounded-0 py-2 mb-2 bg-op-6" href="#">Ask a Question</a>
                                </div>
                            </div>

                           

                            <!-- Forum Posts -->
                            <div class="card row-hover pos-relative py-3 px-3 mb-3 border-warning border-top-0 border-right-0 border-bottom-0 rounded-0">
                                <div class="row align-items-center">
                                    <div class="col-md-8 mb-3 mb-sm-0">
                                        <h5>
                                            <a href="#" class="text-primary">Challenges in Conducting Qualitative Research</a>
                                        </h5>
                                        <p class="text-sm"><span class="op-6">Posted</span> <a class="text-black" href="#">10 minutes</a> <span class="op-6">ago by</span> <a class="text-black" href="#">JaneDoe</a></p>
                                        <div class="text-sm op-5">
                                            <a class="text-black mr-2" href="#">#Qualitative</a>
                                            <a class="text-black mr-2" href="#">#Challenges</a>
                                        </div>
                                    </div>
                                    <div class="col-md-4 op-7">
                                        <div class="row text-center op-7">
                                            <div class="col px-1">
                                                <i class="ion-connection-bars icon-1x"></i> <span class="d-block text-sm">87 Votes</span>
                                            </div>
                                            <div class="col px-1">
                                                <i class="ion-ios-chatboxes-outline icon-1x"></i> <span class="d-block text-sm">45 Replies</span>
                                            </div>
                                            <div class="col px-1">
                                                <i class="ion-ios-eye-outline icon-1x"></i> <span class="d-block text-sm">150 Views</span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="card row-hover pos-relative py-3 px-3 mb-3 border-primary border-top-0 border-right-0 border-bottom-0 rounded-0">
                                <div class="row align-items-center">
                                    <div class="col-md-8 mb-3 mb-sm-0">
                                        <h5>
                                            <a href="#" class="text-primary">Best Practices for Data Analysis in Research</a>
                                        </h5>
                                        <p class="text-sm"><span class="op-6">Posted</span> <a class="text-black" href="#">1 hour</a> <span class="op-6">ago by</span> <a class="text-black" href="#">JohnSmith</a></p>
                                        <div class="text-sm op-5">
                                            <a class="text-black mr-2" href="#">#DataAnalysis</a>
                                            <a class="text-black mr-2" href="#">#BestPractices</a>
                                        </div>
                                    </div>
                                    <div class="col-md-4 op-7">
                                        <div class="row text-center op-7">
                                            <div class="col px-1">
                                                <i class="ion-connection-bars icon-1x"></i> <span class="d-block text-sm">112 Votes</span>
                                            </div>
                                            <div class="col px-1">
                                                <i class="ion-ios-chatboxes-outline icon-1x"></i> <span class="d-block text-sm">78 Replies</span>
                                            </div>
                                            <div class="col px-1">
                                                <i class="ion-ios-eye-outline icon-1x"></i> <span class="d-block text-sm">200 Views</span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <!-- /End of forum posts -->
                        </div>

                    
                    </div>
                    
                </div>
            </main>
        </div>
    </div>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/js/all.min.js"></script>
    <script src="..\..\includes\functions.js"></script>

      
</body>

</html>
