<?php /* Smarty version Smarty-3.1.6, created on 2018-01-23 15:52:27
         compiled from "../shop/Home/View/Cart/info.html" */ ?>
<?php /*%%SmartyHeaderCode:2659590595a60096a1a70e7-50315384%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '4a91de6ce63a5cf7da146d3c6a4c34524dc5d260' => 
    array (
      0 => '../shop/Home/View/Cart/info.html',
      1 => 1516584555,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '2659590595a60096a1a70e7-50315384',
  'function' => 
  array (
  ),
  'version' => 'Smarty-3.1.6',
  'unifunc' => 'content_5a60096a1f270',
  'variables' => 
  array (
    'result_arr' => 0,
    'item' => 0,
  ),
  'has_nocache_code' => false,
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_5a60096a1f270')) {function content_5a60096a1f270($_smarty_tpl) {?><!doctype html>
<html>
<head>
<meta http-equiv="content-type" content="text/html;charset=utf-8">
<meta name="description" content="">
<meta name="keywords" content="">
<link type="text/css" href="/shop/Public/Common/css/bootstrap.min.css" rel="stylesheet">
<link rel="stylesheet" type="text/css" href="/shop/Public/Common/css/base.css">
<link rel="stylesheet" type="text/css" href="/shop/Public/Home/css/home.css">
<script type="text/javascript" src="/shop/Public/Common/js/jquery-3.2.1.min.js"></script>
<script type="text/javascript" src="/shop/Public/Common/js/bootstrap.min.js"></script>
<script type="text/javascript" src="/shop/Public/Home/js/base.js"></script>
<script type="text/javascript" src="/shop/Public/Home/js/function.js"></script>
<title>萌女郎</title>
</head>
<body>

<?php echo $_smarty_tpl->getSubTemplate ("Public/header.html", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, null, null, array(), 0);?>


<div class="container">
	<div class="left">
		
		<?php echo $_smarty_tpl->getSubTemplate ("Public/search.html", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, null, null, array(), 0);?>
		

		<?php echo $_smarty_tpl->getSubTemplate ("Public/category.html", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, null, null, array(), 0);?>

		
		<div class="cart">
			<h4>购物车</h4>
			<div class="bd">
				<div class="product_num">
					购物车产品数： <?php echo cookie('total_num');?>

				</div>			
				<div class="total_price">
					总价： <?php echo cookie('total_price');?>
 $
				</div>			
				<div class="detail">
					<a href="index.php?m=Home&c=Cart&a=index">查看购物车</a>
				</div>
			</div>
		</div>	
	</div>
	<div class="main">
		<h5 class="breadcrumb"><a href="index.php">首页</a>-<a href="#">结账成功</a></h5>
		<div class="order">
			<p><font color="#f00">您的订单成功提交,下面是您的订单信息 ! </font></p>
			<table width="100%" class="order_info">
				<tr>
					<th width="70%">产品名称</th>
					<th>数量</th>
					<th>价格</th>
					<th>总价</th>
				</tr>
				<?php  $_smarty_tpl->tpl_vars['item'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['item']->_loop = false;
 $_smarty_tpl->tpl_vars['key'] = new Smarty_Variable;
 $_from = $_smarty_tpl->tpl_vars['result_arr']->value['order']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['item']->key => $_smarty_tpl->tpl_vars['item']->value){
$_smarty_tpl->tpl_vars['item']->_loop = true;
 $_smarty_tpl->tpl_vars['key']->value = $_smarty_tpl->tpl_vars['item']->key;
?>	
					<tr>
						<td><?php echo $_smarty_tpl->tpl_vars['item']->value['name'];?>
</td>
						<td><?php echo $_smarty_tpl->tpl_vars['item']->value['quantity'];?>
</td>
						<td><?php echo $_smarty_tpl->tpl_vars['item']->value['price'];?>
 $</td>
						<td><?php echo $_smarty_tpl->tpl_vars['item']->value['prices'];?>
 $</td>
				<?php } ?>
			</table>
			<div class="total">
				<span class="num">产品数量：<?php echo $_smarty_tpl->tpl_vars['result_arr']->value['total_num'];?>
 , </span>
				<span class="price">总价：<?php echo $_smarty_tpl->tpl_vars['result_arr']->value['total_price'];?>
 $ </span>
			</div>
			<table width="60%" class="user_info">
				<tr>
					<td width="40%">用户名<font color="#f00">*</font>：</td>
					<td><?php echo cookie('username');?>
</td>
				</tr>
				<tr>
					<td>邮箱地址<font color="#f00">*</font>：</td>
					<td><?php echo $_smarty_tpl->tpl_vars['result_arr']->value['user']['email'];?>
</td>
				</tr>
				<tr>
					<td>国家<font color="#f00">*</font>：</td>
					<td><?php echo $_smarty_tpl->tpl_vars['result_arr']->value['user']['country'];?>
</td>
				</tr>		
				<tr>
					<td>姓名：</td>
					<td><?php echo $_smarty_tpl->tpl_vars['result_arr']->value['user']['realname'];?>
</td>
				</tr>
				<tr>
					<td>电话：</td>
					<td><?php echo $_smarty_tpl->tpl_vars['result_arr']->value['user']['tel'];?>
</td>
				</tr><tr>
					<td>手机：</td>
					<td><?php echo $_smarty_tpl->tpl_vars['result_arr']->value['user']['mobile'];?>
</td>
				</tr>
				<tr>
					<td>邮政编码：</td>
					<td><?php echo $_smarty_tpl->tpl_vars['result_arr']->value['user']['zip_code'];?>
</td>
				</tr>
				<tr>
					<td>性别：</td>
					<td><?php if ($_smarty_tpl->tpl_vars['result_arr']->value['user']['sex']==1){?>男<?php }elseif($_smarty_tpl->tpl_vars['result_arr']->value['user']['sex']==2){?>女<?php }?> 
					</td>
				</tr>
				<tr>
					<td>地址：</td>
					<td><?php echo $_smarty_tpl->tpl_vars['result_arr']->value['user']['address'];?>
</td>
				</tr>
				<tr>
					<td>备注：</td>
					<td><?php echo $_smarty_tpl->tpl_vars['result_arr']->value['user']['note'];?>
</td>
				</tr>
			</table>
		</div>
	</div>			
</div>

<?php echo $_smarty_tpl->getSubTemplate ("Public/footer.html", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, null, null, array(), 0);?>


</body>
</html><?php }} ?>