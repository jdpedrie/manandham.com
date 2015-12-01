'use strict';

function initClock(deadline, endText) {
  var days = document.querySelector('[data-days]');
  var hours = document.querySelector('[data-hours]');
  var minutes = document.querySelector('[data-minutes]');
  var seconds = document.querySelector('[data-seconds]');
  var countDownText = document.querySelector('.countdown h3');
  var numbers = document.querySelectorAll('.number-group .number');
  var form = document.querySelector('form');

  updateDisplay();

  function updateDisplay() {
    var remainingTime = getTimeRemaining(deadline);

    days.innerHTML = remainingTime.days;
    hours.innerHTML = remainingTime.hours;
    minutes.innerHTML = remainingTime.minutes;
    seconds.innerHTML = remainingTime.seconds;

    if (remainingTime.total <= 0) {
      clearInterval(interval);
      countDownText.innerHTML = endText;
      form.style.display = 'none';

      for(var i = 0; i < numbers.length; i++) {
        numbers[i].innerHTML = '0';
      }
    }
  }

  var interval = setInterval(function() {
    updateDisplay();
  }, 1000);
}

function getTimeRemaining(endtime) {
  var t = Date.parse(endtime) - Date.parse(new Date());
  var seconds = Math.floor( (t/1000) % 60 );
  var minutes = Math.floor( (t/1000/60) % 60 );
  var hours = Math.floor( (t/(1000*60*60)) % 24 );
  var days = Math.floor( t/(1000*60*60*24) );

  return {
    'total': t,
    'days': days,
    'hours': hours,
    'minutes': minutes,
    'seconds': seconds
  };
}

var forms = document.getElementsByTagName('form');
for (var i = 0; i < forms.length; i++) {
    forms[i].noValidate = true;
    forms[i].addEventListener('submit', function(event) {
        if (!event.target.checkValidity()) {
            event.preventDefault();
            $('.errors').text('Please fill out all fields').show();
        }
    }, false);
}

$(document).ready(function() {
  $('input.expirationDate').payment('formatCardExpiry');
  $('input.cardNumber').payment('formatCardNumber');

  $('#paymentForm').submit(function(event) {
    var $form = $(this);
    event.preventDefault();

    $form.find('button').prop('disabled', true);

    var expiration = $form.find('.expirationDate').val();
    var matches = expiration.match(/([0-9]{2}) \/ ([0-9]{4})/);

    if (matches === null) {
      $form.find('.errors').text('Expiration Date must be entered as MM/YYYY').show();
      $form.find('button').prop('disabled', false);
      return false;
    }

    Stripe.card.createToken({
      number: $form.find('.cardNumber').val(),
      exp_month: matches[1],
      exp_year: matches[2]
    }, function(status, res) {
      if (res.error) {
        $form.find('.errors').text(res.error.message).show();
        $form.find('button').prop('disabled', false);
      }
      else {
        var token = res.id;
        $form.append($('<input type="hidden" name="stripeToken" />').val(token));
        $form.get(0).submit();
      }
    });
  });
});