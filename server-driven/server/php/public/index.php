<?php

require_once 'shared.php';

try {
  $readers = $stripe->terminal->readers->all();
} catch (\Stripe\Exception\ApiErrorException $e) {
  http_response_code(400);
  error_log($e->getError()->message);
?>
  <h1>Error</h1>
  <p>Failed to list Readers</p>
  <p>Please check the server logs for more information</p>
<?php
  exit;
} catch (Exception $e) {
  error_log($e);
  http_response_code(500);
  exit;
}
?>

<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>Stripe Terminal Sample</title>
    <link rel="icon" href="favicon.ico" type="image/x-icon" />
    <link rel="stylesheet" href="css/normalize.css" />
    <link rel="stylesheet" href="css/global.css" />
    <script src="./payment.js" defer></script>
    <script src="./utils.js" defer></script>
    <script src="./index.js" defer></script>
  </head>
  <body>
    <header>
    </header>
    <div class="sr-root">
      <div class="sr-main">
        <section class="container">
          <h2>Step 1: Prompt reader for payment</h2>
          <p>Select a reader and input an amount for the transaction. At this stage, the reader is online ready for payment.</p>
          <form action="/create-payment-intent.php" method="POST">
            <div class="sr-form-row">
              <label>Select Reader: </label>
              <select name="reader" class="sr-select">
                <?php foreach($readers as $reader) { ?>
                  <option value="<?= $reader->id; ?>"><?= $reader->label; ?> (<?= $reader->id ?>)</option>
                <?php } ?>
              </select>
            </div>
            <div class="sr-form-row">
              <label for="amount">Amount:</label>
              <input type="text" name="amount" class="sr-input">
            </div>
            <div class="button-row">
              <button id="confirm">Confirm</button>
            </div>
          </form>
        </section>
        <div id="messages" role="alert" style="display: none;"></div>
      </div>
    </div>
  </body>
</html>
