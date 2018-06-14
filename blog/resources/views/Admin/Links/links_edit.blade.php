<!doctype html>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>主要内容区main</title>
<link href="{{asset('Admin/css/base.css')}}" rel="stylesheet" type="text/css" />
<link href="{{asset('Admin/css/style.css')}}" type="text/css" rel="stylesheet" />
<script type="text/javascript" src="{{asset('Common/js/jquery-3.3.1.min.js')}}"></script>
<script type="text/javascript" src="{{asset('Admin/js/check.js')}}"></script>
</head>
<body>
<div class="main">
	<div class="breadcrumbs">
		<div class="breadcrumb">
			您的位置：<a href="{{url('admin/links')}}">链接管理</a>&nbsp;&nbsp;>&nbsp;&nbsp;新增链接
		</div>
	</div>
    <form method="post" action="{{url('admin/links/'.$field->id)}}" name="links" onsubmit="return check_links();">{{csrf_field()}}
		<input type="hidden" name="_method" value="put" />
		<table class="ftab">
			<tr>
				<td align="right" class="bggray" width="8%">&nbsp;</td>
				<td align="left">
					<span class="back_msg">
						@foreach($errors->all() as $key=>$error)
							<font color="#f00">@if(count($errors->all())>1){{$key+1}}.@endif{{$error}}</font>&nbsp;&nbsp;&nbsp;
						@endforeach
					</span>
				</td>
			</tr>
			<tr>
				<td align="right" class="bggray">链接名称：</td>
				<td align="left">
					<input type="text" name="name" value="{{$field->name}}" />
					<em class="require"> * </em>
				</td>
			</tr>
			<tr>
				<td align="right" class="bggray">链接标题：</td>
				<td align="left">
					<input type="text" name="title" value="{{$field->title}}" />
				</td>
			</tr>
			<tr>
				<td align="right" class="bggray">链接地址：</td>
				<td align="left">
					<input type="text" name="url" value="{{$field->url}}" />
					<em class="require"> * </em>
				</td>
			</tr>						
			<tr>
				<td align="right" class="bggray">链接序号：</td>
				<td align="left">
					<input type="text" name="no_order" value="{{$field->no_order}}" />
				</td>
			</tr>
			<tr>
				<td align="right" class="bggray">&nbsp;</td>
				<td align="left">
					<input name="sub" type="submit" value="提交">
					<input name="res" type="reset" value="重置">
				</td>
			</tr>
		</table>
    </form>
</body>
</html>