<div class="mobile-menu-overlay"></div>

<div class="main-container">
  <div class="pd-20 bg-white border-radius-4 box-shadow mb-30">
    <!-- Simple Datatable start -->
    <div class="card-box mb-30">
      <div class="pd-20 d-flex">
        <h4 class="text-blue h4">Employee List </h4>
      </div>
      <div class="pb-20">
        <table class="data-table table stripe hover nowrap">
          <thead>
            <tr>
              <th class="table-plus datatable-nosort">Name</th>
              <th class="datatable-nosort">Action</th>
            </tr>
          </thead>
          <tbody>
            <?php foreach($employee_list as $row): ?>
              <tr>
                <td><?= $row['last_name'] .','. $row['first_name']?> </td>
                <td>
                  <div class="dropdown">
                    <a class="btn btn-link font-24 p-0 line-height-1 no-arrow dropdown-toggle" href="#" role="button" data-toggle="dropdown">
                      <i class="dw dw-more"></i>
                    </a>
                    <div class="dropdown-menu dropdown-menu-right dropdown-menu-icon-list">
                      <a class="dropdown-item" onclick="openModal(event, <?= $row['ID'] ?>, '<?= htmlspecialchars($row['first_name']." ".$row['last_name'], ENT_QUOTES) ?>')"><i class="dw dw-eye"></i> View/set</a>
                    </div>
                  </div>
                </td>
              </tr>
            <?php endforeach; ?>
          </tbody>
        </table>
      </div>
    </div>
  </div>
</div>

<!-- Modal -->
<div class="modal fade" id="exampleModal11" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Select Date</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <div class="col-md-12">
            <label>From</label>
            <input type="date" id="start_date" name="from" class="form-control">
        </div>
        <div class="col-md-12" style="margin-top:15px">
            <label>To</label>
            <input type="date" id="end_date" name="to" class="form-control">
        </div>
        <!-- Hidden input fields -->
        <input type="hidden" id="userIdInput">
        <input type="hidden" id="nameInput">
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
        <button type="button" class="btn btn-primary" onclick="seePayslip()">See Payslip</button>
      </div>
    </div>
  </div>
</div>

<script>
  function openModal(event, userId, name) {
  event.preventDefault();
  
  document.getElementById('userIdInput').value = userId;
  document.getElementById('nameInput').value = name;
  
  $('#exampleModal11').modal('show');
}

function seePayslip() {
    var start_date = document.getElementById("start_date").value;
    var end_date = document.getElementById("end_date").value;
    var userId = document.getElementById("userIdInput").value;
    var name = document.getElementById("nameInput").value;

    var url = "https://interlinkiq.com/pay_summary.php?from=" + start_date + "&user_id=" + userId + "&name=" + name + "&to="+end_date;
    window.open(url, '_blank');
}
</script>
