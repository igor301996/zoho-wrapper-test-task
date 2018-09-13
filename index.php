<?php
include 'utils.php';
session_start();
?>
<html>
<head>
  <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css">
</head>
<body>
<div class="container">
  <div class="row mt-4">
    <div class="col-8 m-auto">
      <div class="card">
        <div class="card-header">Form</div>
        <div class="card-body">
          <h3 class="card-title">Form</h3>
            <?php if (is_message()): ?>
              <div class="alert alert-info">
                  <?= get_message(); ?>
              </div>
            <? endif; ?>
          <form action="/record_handler.php" method="post">

            <div class="form-group">
              <label>Last Name</label>
              <input class="form-control" name="last_name" type="text">
            </div>

            <div class="form-group">
              <label>First Name</label>
              <input class="form-control" name="first_name" type="text">
            </div>

            <div class="form-group">
              <label>Email</label>
              <input class="form-control" name="email" type="email">
            </div>

            <div class="form-group">
              <label>Company Name</label>
              <input class="form-control" name="company" type="text">
            </div>

            <div class="form-group">
              <label>Phone</label>
              <input class="form-control" name="phone" type="text">
            </div>

            <div class="form-group float-right">
              <button class="btn btn-success" type="submit">
                Send
              </button>
            </div>


          </form>
        </div>
      </div>
    </div>
  </div>
</div>
</body>
</html>