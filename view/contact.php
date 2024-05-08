<?php $form=app\core\form\Form::beginform('','post') ?>
<?php echo $form->field($params['model'],'Subject')->data() ?>
<?php echo $form->field($params['model'],'Email')->data() ?>
<?php echo $form->field($params['model'],'Body')->data() ?>
<button type="submit" class="btn btn-primary">Submit</button>
<?php app\core\form\Form::endform() ?>

