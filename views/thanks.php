<?php $this->layout('layout') ?>

<div>

  <?= $this->insert('countdown', [
    'header' => 'You are now registered. Man &amp; Ham X begins in'
  ]); ?>

  <h3>What you need to know:</h3>

  <p>
    If you would like to present something you, as a Man, know,
    that other Men need to know, send your request to <?=getenv('EMAIL_ADDRESS'); ?>.
  </p>

  <p>
    You will surrender your phone upon entering Man &amp; Ham. If your wife is heavy with
    child and needs an emergency contact number, please give her the following: 248-670-8790.
  </p>

  <p>
    You will be given the location via email 24 hours before Man &amp; Ham.
  </p>

  <p>
    This is a private event. There is no #manandham, nor will there ever be.
  </p>

  <p>
    The <em>Tom Butler Award</em> will be up for grabs again this year.
  </p>

  <p>
    Everything is included. Bring nothing except a fork.
  </p>

  <p>Direct any further questions to <?=getenv('EMAIL_ADDRESS'); ?>.</p>

  <p>
    Man &amp; Ham has a rich heritage. It shall not be shat upon.
  </p>

</div>

<script>
  $(document).ready(function() {
    initClock('<?=getenv("START"); ?>', 'Man &amp; Ham X Has Begun');
  });
</script>