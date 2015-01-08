<?php
/**
 *
 *
 * CakePHP(tm) : Rapid Development Framework (http://cakephp.org)
 * Copyright (c) Cake Software Foundation, Inc. (http://cakefoundation.org)
 *
 * Licensed under The MIT License
 * For full copyright and license information, please see the LICENSE.txt
 * Redistributions of files must retain the above copyright notice.
 *
 * @copyright     Copyright (c) Cake Software Foundation, Inc. (http://cakefoundation.org)
 * @link          http://cakephp.org CakePHP(tm) Project
 * @package       app.View.Errors
 * @since         CakePHP(tm) v 0.10.0.1076
 * @license       http://www.opensource.org/licenses/mit-license.php MIT License
 */
?>
<h2>Something went wrong...<?php //echo $name; ?></h2>
<div style="background: url('../../img/error_face.jpg'); height: 600px; background-repeat:no-repeat;">
	<p class="error">
		<strong><?php echo __d('cake', 'Oops'); ?>: </strong>
		<?php echo __d('cake', 'Looks like we broke something... (Please contact an OnQ administrator if this happens again)'); ?>
	</p>
</div>
<?php
if (Configure::read('debug') > 0):
	echo $this->element('exception_stack_trace');
endif;
?>
