<?php
/* Smarty version 3.1.31, created on 2017-09-30 23:52:37
  from "C:\Users\Matt\OneDrive - Nova Scotia Community College\Projects\cachachart.nscctruro.ca\tools\FormTools3.0.0-alpha-20170930\formtools\install\templates\index.tpl" */

/* @var Smarty_Internal_Template $_smarty_tpl */
if ($_smarty_tpl->_decodeProperties($_smarty_tpl, array (
  'version' => '3.1.31',
  'unifunc' => 'content_59d05875165537_55678688',
  'has_nocache_code' => false,
  'file_dependency' => 
  array (
    '87e1a01e88702cdad20378f7093e0d88f080140f' => 
    array (
      0 => 'C:\\Users\\Matt\\OneDrive - Nova Scotia Community College\\Projects\\cachachart.nscctruro.ca\\tools\\FormTools3.0.0-alpha-20170930\\formtools\\install\\templates\\index.tpl',
      1 => 1506826165,
      2 => 'file',
    ),
  ),
  'includes' => 
  array (
    'file:../../install/templates/install_header.tpl' => 1,
    'file:messages.tpl' => 1,
    'file:../../install/templates/install_footer.tpl' => 1,
  ),
),false)) {
function content_59d05875165537_55678688 (Smarty_Internal_Template $_smarty_tpl) {
$_smarty_tpl->_subTemplateRender("file:../../install/templates/install_header.tpl", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, $_smarty_tpl->cache_lifetime, array(), 0, false);
?>


<h2><?php echo $_smarty_tpl->tpl_vars['LANG']->value['word_welcome'];?>
</h2>

<?php $_smarty_tpl->_subTemplateRender('file:messages.tpl', $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, $_smarty_tpl->cache_lifetime, array(), 0, false);
?>


<form action="<?php echo $_smarty_tpl->tpl_vars['same_page']->value;?>
" method="post">
	<table cellspacing="0" cellpadding="0">
		<tr>
			<td width="100" class="label"><?php echo $_smarty_tpl->tpl_vars['LANG']->value['word_language'];?>
</td>
			<td>
				<select name="lang_file" class="margin_right">
					<?php
$_from = $_smarty_tpl->smarty->ext->_foreach->init($_smarty_tpl, $_smarty_tpl->tpl_vars['available_languages']->value, 'row');
if ($_from !== null) {
foreach ($_from as $_smarty_tpl->tpl_vars['row']->value) {
?>
						<option value="<?php echo $_smarty_tpl->tpl_vars['row']->value->code;?>
" <?php if ($_smarty_tpl->tpl_vars['lang']->value == $_smarty_tpl->tpl_vars['row']->value->code) {?>selected<?php }?>><?php echo $_smarty_tpl->tpl_vars['row']->value->lang;?>
</option>
					<?php
}
}
$_smarty_tpl->smarty->ext->_foreach->restore($_smarty_tpl, 1);
?>

				</select>
			</td>
			<td>
				<input type="submit" name="select_language"	 value="<?php echo $_smarty_tpl->tpl_vars['LANG']->value['word_select'];?>
" />
			</td>
		</tr>
	</table>

	<p>
		<input type="submit" name="next" value="<?php echo $_smarty_tpl->tpl_vars['LANG']->value['word_continue_rightarrow'];?>
" />
	</p>
</form>

<?php $_smarty_tpl->_subTemplateRender("file:../../install/templates/install_footer.tpl", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, $_smarty_tpl->cache_lifetime, array(), 0, false);
?>

<?php }
}
