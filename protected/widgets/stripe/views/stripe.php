<?php
$year = date('y') + 1;
$month = date('m');
?>
Price is <?= $this->advert->amount ?>
<div class="form">
    <form class="well form-horizontal" action="" method="POST" id="payment-form">
        <div class="row">
            <div class="col-sm-8 border-right">
                <h2>Billing Information</h2>
                <p>Enter your payment details bellow</p>

                <h3>1.Card Accepted<span class="asterisk">*</span></h3>
                <img src="<?= $publish ?>/img/visa.png" alt="visa">
                <img src="<?= $publish ?>/img/master_card.png" alt="master card">
                <img src="<?= $publish ?>/img/american_express.png" alt="american express">
                <div class="separator"></div>

                <h3>2.Credit Card<span class="asterisk">*</span></h3>

                <div class="form-group col-sm-6">
                    <input class="form-control" type="text" data-stripe="number">
                    <label class="text-left">First Name</label>
                </div>

                <div class="form-group col-sm-6">
                    <input class="form-control" type="text" data-stripe="number">
                    <label class="text-left">Last Name</label>
                </div>


                <div class="form-group col-sm-12">
                    <input class="form-control" type="text" data-stripe="number" maxlength="16">
                    <label class="text-left">Credit Card Number</label>
                </div>


                <div class="form-group col-sm-4">
                    <div class="spinner"><input type="number" value="<?= $month ?>" placeholder="<?= $month ?>" class="form-control" data-stripe="exp-month" maxlength="2"></div>
                    <label class="text-left">Expiration Month</label>
                </div>

                <div class="form-group col-sm-4">
                    <div class="spinner"><input type="number" value="<?= $year ?>" placeholder="<?= $year ?>" class="form-control" data-stripe="exp-year" maxlength="2"></div>
                    <label class="text-left">Year</label>
                </div>


                <div class="form-group col-sm-4">
                    <input class="form-control" type="text" data-stripe="cvc" maxlength="3">
                    <label class="text-left">Code/CVV</label>
                </div>

            </div><!-- /.col-sm-8-->
            <div class="col-sm-4 text-center">
                <img src="<?= $publish ?>/img/card_sample.png" alt="card example" />
            </div><!-- /.col-sm-4-->
        </div><!-- /.row  -->

        <div class="row">
            <div class="col-sm-8 text-center">
                <button class="btn" type="submit">Submit payment</button>
                <div class="payment-errors"></div>
            </div><!-- /.col-sm-8 -->
        </div><!-- /.row  -->

    </form>
</div><!-- /.form -->

<script>
    Stripe.setPublishableKey('<?= Yii::app()->params['stripe.public'] ?>');
</script>