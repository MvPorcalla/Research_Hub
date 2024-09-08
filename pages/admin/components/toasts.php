<!-- Toast Container -->
<div class="toast-container position-fixed bottom-0 end-0 p-3">
  <div id="liveToast" class="toast border border-dark" role="alert" aria-live="assertive" aria-atomic="true" data-bs-autohide="true">
    <div class="toast-header text-light bg-dark">
      <span id="recordCount" class="badge rounded-pill bg-danger me-2"></span>
      <strong id="toastTitle" class="me-auto"></strong>
      <small id="time" style="cursor: pointer"></small>
      <button type="button" class="btn-close" data-bs-dismiss="toast" aria-label="Close"></button>
    </div>
    <div id="toastBody" class="toast-body"></div>
  </div>
</div>
