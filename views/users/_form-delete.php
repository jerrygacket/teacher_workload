<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

$form = ActiveForm::begin([
    'id' => 'user-delete-form'.$model->id,
    'method' => 'POST',
    'action' => Yii::$app->homeUrl.'users/delete',
    'options' => ['class' => 'form-inline', 'style' => 'margin: 0; padding: 0;'],
    'fieldConfig' => ['options' => ['class' => 'd-none']],
]);
echo $form->field($model,'id')->hiddenInput(['class' => ''])->label(false);
//echo '<div class="form-group">';
echo Html::submitButton('<i class="fas fa-times" style="color:red"></i>', [
    'class' => 'btn btn-link p-0',
    'style' => 'display: inline;',
    'name' => 'save',
    'onclick' => 'if(confirm("Хотите удалить?")){
                                         return true;
                                        }else{
                                         return false;
                                        }',
]);
//echo '</div>';
//echo '<button class="btn btn-link btn-inline" type="submit"><i class="fas fa-times" style="color:red"></i></button>';
//\yii\helpers\Html::button('<i class="fas fa-times" style="color:red"></i>', [
//                        'onclick' => 'if(confirm("Хотите удалить?")){
//                                         return true;
//                                        }else{
//                                         return false;
//                                        }',
//                    ]);
ActiveForm::end();