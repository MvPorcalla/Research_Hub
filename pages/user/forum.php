<?php include './../user/includes/session_check.php'; ?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>FORUM - LNHS Research Hub</title>
    <!-- Include the head-links-css.php file which contains all necessary CSS links for the page. -->
    <?php include './../user/includes/links_head-css.php'; ?>
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
                        <div class="col-md-12 mt-4">
                            <!--  Content -->
                            <div class="row text-left my-3">
                                <div class="col-lg-10 text-lg-right">
                                    <h1 class='fs-2'>Research Hub Forum</h1>
                                </div>

                                <div class='col-lg-2 text-center'>
                                    <button class="btn btn-sm btn-block btn-primary rounded-2 py-2 mb-2 bg-op-6" data-bs-toggle="modal" data-bs-target="#askQuestionModal">
                                        Ask a Question
                                    </button>
                                </div>
                            </div>

                            <!-- Modal -->
                            <div class="modal fade" id="askQuestionModal" tabindex="-1" aria-labelledby="askQuestionModalLabel" aria-hidden="true">
                                <div class="modal-dialog modal-dialog-centered">
                                    <div class="modal-content">
                                        <div class="modal-header bg-primary text-white">
                                            <h5 class="modal-title" id="askQuestionModalLabel">Ask a Question</h5>
                                        </div>
                                        <div class="modal-body">
                                            <form id="askQuestionForm" action="../../backend/entry.php" method="post">
                                                <div class="mb-3">
                                                    <label for="question" class="form-label">Your Question</label>
                                                    <textarea class="form-control" id="question" name="question" rows="4" placeholder="Type your question here..." maxlength="2000" required></textarea>
                                                    <div class="text-end">
                                                        <small id="charCounter" class="form-text text-muted"></small>
                                                    </div>
                                                </div>
                                                <p id="error" style="color: red;"></p>
                                                <button type="submit" class="btn btn-primary btn-block w-100">Submit</button>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div id="entriesContainer" data-user-id="<?php echo $_SESSION['user_id']; ?>" class="container ">
                                <!-- Data will be dynamically inserted here -->
                            </div>
                        </div>

                    </div>

                </div>
            </main>
        </div>
    </div>

    <!-- Include the links-footer-script.php file which contains all necessary JavaScript links for the page. -->
    <?php include './../user/includes/links_footer-script.php'; ?>
    
    <script src="../../includes/functions.js"></script>
    <script src="../../scripts/fetchEntriesComments.js"></script>
    <script src="../../scripts/toggleLike.js"></script>
    
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            handleStatus('entry');
            handleStatus('comment');
            handleInputSubmit('askQuestionForm','question', 'error');
            characterCounter('question', 'charCounter');
        });
    </script>
</body>

</html>

