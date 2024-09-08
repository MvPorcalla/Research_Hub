<?php
    // Sample data for a single notification
    $notification = [
        'count' => 23,
        'time' => '11 mins ago.',
    ];
?>

<!-- Toast Container -->
<div class="toast-container position-fixed bottom-0 end-0 p-3">
  <div id="liveToast" class="toast border border-dark" role="alert" aria-live="assertive" aria-atomic="true" data-bs-autohide="true">
    <div class="toast-header text-light bg-dark">
      <span id="abstractCount" class="badge rounded-pill bg-danger me-2">
        <?php echo htmlspecialchars($notification['count']); ?>
      </span>
      <strong class="me-auto">New abstract</strong>
      <small>
        <?php echo htmlspecialchars($notification['time']); ?>
      </small>
      <button type="button" class="btn-close" data-bs-dismiss="toast" aria-label="Close"></button>
    </div>
    <div class="toast-body">
      A <span class="fw-bold text-danger">new abstract has been uploaded</span>. Please take a moment to review it.
    </div>
  </div>
</div>
