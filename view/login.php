<?php
/** @var $model \app\model\users */
?>

<h1>Login</h1>
<?php $form=app\core\form\Form::beginform('','post') ?>
<?php echo $form->field($params['model'],'email')->data() ?>
<?php echo $form->field($params['model'],'password')->data() ?>
<button type="submit" class="btn btn-primary">Submit</button>
<?php app\core\form\Form::endform() ?>