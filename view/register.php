<h1>Register Yourself</h1>
<?php $form=app\core\form\Form::beginform('','post') ?>
<?php echo $form->field($params['model'],'firstname')->data() ?>
<?php echo $form->field($params['model'],'lastname')->data() ?>
<?php echo $form->field($params['model'],'email')->data() ?>
<?php echo $form->field($params['model'],'password')->data() ?>
<?php echo $form->field($params['model'],'confirmpassword')->data() ?>
<button type="submit" class="btn btn-primary">Submit</button>
<?php app\core\form\Form::endform() ?>