<!doctype html>
<html>
  <head>
    <title>Man &amp; Ham X</title>
    <link rel="stylesheet" href="/assets/style.css">
    <script src="https://use.typekit.net/bxn0bkq.js"></script>
    <script>try{Typekit.load({ async: true });}catch(e){}</script>
    <link href='https://fonts.googleapis.com/css?family=Open+Sans:400,300,300italic' rel='stylesheet' type='text/css'>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <script src="https://code.jquery.com/jquery-1.11.3.min.js"></script>
  </head>
  <body>
    <div class="container">
      <?=$this->section('content')?>
    </div>

    <script src="https://js.stripe.com/v2/"></script>
    <script src="https://cdn.rawgit.com/stripe/jquery.payment/88b1088b2f7d14743750ad450c7468a6b8f2ef6c/lib/jquery.payment.min.js"></script>
    <script>
      var deadline = '<?=getenv("DEADLINE"); ?>';
    </script>
    <script src="/assets/app.js"></script>
    <script>
      (function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){
      (i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),
      m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)
      })(window,document,'script','//www.google-analytics.com/analytics.js','ga');

      ga('create', 'UA-70086677-1', 'auto');
      ga('send', 'pageview');

      Stripe.setPublishableKey('<?=getenv('STRIPE_PUBKEY'); ?>');
    </script>
  </body>
</html>
