<?php $this->layout('layout') ?>

<h3><em>Welcome To</em></h3>

<img class="heading" src="/assets/manandhamtype.png" alt="M&amp;H X">

<p>
  You are cordially invited to Man &amp; Ham X.  Man &amp; Ham's blessed
  heritage has brought joy to the face of our Lord and strength to Men's hearts.
  It is a decade long tradition that has brought together the greatest Men from
  around the world under one garage.  A boy born on the eve of M&amp;H
  year I is now in 4th grade and “felt weird” last Tuesday when his young
  teacher, Miss Shaw, touched his arm.  He is now embarrassed he ever
  accidentally called her Mom on the third day of school.
</p>

<p>
  It is with great deliberation that the Founders have deemed you an exceptional
  Man among Men.  It is a prodigious honor to be one of the few Men invited to
  share in our 10th anniversary.  M&amp;H X will be held on <strong><em>Monday, December 28,
  2015</em></strong> and will cost $<?=$guest->paymentAmount()->getConvertedAmount(); ?>.
  The Founders never profit from M&amp;H, but it is with great responsibility
  that our funds provide everyone with the most lavish night of the year.
</p>

<p>
  Glory, glory, Man &amp; Ham!
</p>

<form id="paymentForm" method="post" action="<?=sprintf('/process/%d', $guest->id()); ?>">
  <p class="errors"></p>

  <p class="half">
    <input required class="cardNumber" type="text" placeholder="credit card number">
  </p>

  <p class="half">
    <input required class="expirationDate" type="text" placeholder="expiration date">
  </p>

  <p></p>

  <p class="half">
    <input required type="text" name="firstName" placeholder="first name" value="<?=$this->e($guest->firstName()); ?>">
  </p>


  <p class="half">
    <input required type="text" name="lastName" placeholder="last name" value="<?=$this->e($guest->lastName()); ?>">
  </p>

  <p></p>

  <p class="half">
    <input required type="text" name="emailAddress" placeholder="emailAddress" value="<?=$this->e($guest->emailAddress()); ?>">
  </p>


  <p class="half">
    <input required type="text" name="phoneNumber" placeholder="phone number" value="<?=$this->e($guest->phoneNumber()); ?>">
  </p>

  <p class="full">
    <input required type="text" name="address" placeholder="address" value="<?=$this->e($guest->address()); ?>">
  </p>

  <p>
    <button type="submit">Register &amp; Pay $<?=$guest->paymentAmount()->getConvertedAmount(); ?></button><br>
  </p>

  <div class="disclaimers">
    <p>When you click this button, we will charge your card.</p>
    <p class="tiny">This site uses <a href="https://stripe.com/" target="_blank">stripe</a> for payments. Your card information is sent directly to stripe, and is not seen or stored by the manandham.com website.</p>
  </div>
</form>