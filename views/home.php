<?php $this->layout('layout') ?>

    <img class="crest" src="/assets/x_crest.png" alt="M&amp;H X">

    <?= $this->insert('countdown', [
      'header' => 'Registration Closes in'
    ]); ?>

    <form method="post" action="guest">
      <p class="errors"></p>
      <?php if ($invalidPassword) : ?>
      <p><strong>That is not a valid founders name. try again. or leave.</strong></p>
      <?php endif; ?>

      <p class="half">
        <input required type="text" name="first" placeholder="first name">
      </p>

      <p class="half">
        <input required type="text" name="last" placeholder="last name">
      </p>

      <p class="full">
        <input required type="text" name="founder" placeholder="enter the last name of one founder">
      </p>

      <p>
        <button type="submit">Continue</button>
      </p>
    </form>

    <script>
      $(document).ready(function() {
        initClock('<?=getenv("DEADLINE"); ?>', 'Registration has closed.');
      });
    </script>