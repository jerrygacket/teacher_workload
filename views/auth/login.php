<?php



/* @var $this \yii\web\View */
/* @var $model mixed */
?>
<section class="mt-3">
    <div class="row">
        <div class="col-md-8 offset-md-2 col-12">
            <!-- Card -->
            <div class="card">
                <!-- Card body -->
                <div class="card-body">
                    <?= $this->render('_loginForm', ['model' => $model]); ?>
                </div>
            </div>
        </div>
    </div>
</section>
