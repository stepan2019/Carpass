<?php /* Smarty version 3.1.24, created on 2019-08-27 18:31:53
         compiled from "E:/workspace/carpass/admin/templates/default/data/fancybox.html" */ ?>
<?php
/*%%SmartyHeaderCode:8140286545d657719e112e1_25820657%%*/
if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    'e217f979fe1609ae66aaf5797847912c9e912620' => 
    array (
      0 => 'E:/workspace/carpass/admin/templates/default/data/fancybox.html',
      1 => 1307796276,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '8140286545d657719e112e1_25820657',
  'variables' => 
  array (
    'live_site' => 0,
  ),
  'has_nocache_code' => false,
  'version' => '3.1.24',
  'unifunc' => 'content_5d657719e164d7_68566713',
),false);
/*/%%SmartyHeaderCode%%*/
if ($_valid && !is_callable('content_5d657719e164d7_68566713')) {
function content_5d657719e164d7_68566713 ($_smarty_tpl) {

$_smarty_tpl->properties['nocache_hash'] = '8140286545d657719e112e1_25820657';
?>
<?php echo '<script'; ?>
 type="text/javascript" src="<?php echo $_smarty_tpl->tpl_vars['live_site']->value;?>
/libs/jQuery/plugins/fancybox/jquery.fancybox-1.3.4.pack.js"><?php echo '</script'; ?>
>
<link rel="stylesheet" href="<?php echo $_smarty_tpl->tpl_vars['live_site']->value;?>
/libs/jQuery/plugins/fancybox/jquery.fancybox-1.3.4.min.css" type="text/css" media="screen" />
<?php }
}
?>