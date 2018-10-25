<?php
// 本类由系统自动生成，仅供测试用途
namespace Home\Controller;
use Think\Controller;
class ArticleController extends CommonController {
    public function index(){
		$method = I('get.method') ? I('get.method') : 'list';
		$db=M('article');
		switch ($method) {
			case 'list':
				$this->assign('cur_nav','list');
				$res['count']=$db->count();
				$Page=new \Think\Page($res['count'],10000);
				$res['show']= $Page->show();// 分页显示输出
				$res['list'] = $db->order('art_id desc')->limit($Page->firstRow.','.$Page->listRows)->select();
				foreach($res['list'] as &$val){
					$val['art_cate']=M('category')->where('cate_id='.$val['art_cate'])->find()['cate_name'];
				}
				$this->assign('res',$res);	// 赋值分页输出
				$this->display('list');
			break;	
			case 'add':
				$this->assign('cur_nav','add');
				$res['cates']=M('category')->where('cate_id>21')->select();
				$res['art_keyword']=M('article')->distinct(true)->where('art_keyword!=\'\'')->field('art_keyword')->select();
				$this->assign('res',$res);
				if(I('post.sub')){
					$arr=array(
						'art_cate'=>I('post.art_cate'),
						'art_tit'=>I('post.art_tit'),
						'art_img'=>I('post.art_img'),
						'art_view'=>I('post.art_view'),
						'art_content'=>I('post.art_content'),
						'art_addtime'=>date('Y-m-d')
					);
					if($db->add($arr)){
						$this->success('添加成功');
						$this->redirect(U('index.php?m=Home&c=Article&a=index&method=list'));
					}else{
						$this->error('添加失败');
					}
				}
				$this->display('add');
			break;			
			case 'edit':
				$res['field']=$db->where('art_id='.$_GET['art_id'])->find();
				$res['art_keyword']=M('article')->distinct(true)->where('art_keyword!=\'\'')->field('art_keyword')->select();
				$res['cates']=M('category')->where('cate_id>21')->select();
				$this->assign('cur_nav','edit');
				$this->assign('res',$res);
				
				if(I('post.sub')){
					$field=$db->where('art_id='.$_POST['art_id'])->find();
					preg_match_all('/<img [^\']*src="([^\"]*)"[^\']*\/>/iU', $field['art_content'], $img_arr);
					if(!empty($img_arr)){
						$old_img_arr=$img_arr[1];
					}

					preg_match_all('/<img [^\']*src="([^\"]*)"[^\']*\/>/iU', htmlspecialchars_decode(I('post.art_content')), $img_arr);
					if(!empty($img_arr)){
						$new_img_arr=$img_arr[1];
					}
											
					foreach($old_img_arr as $val){
						$find=false;
						foreach($new_img_arr as $v){
							if($val==$v){
								$find=true;
							}
						}
						if(!$find){
							if(file_exists('/opt/data/web/news/admin'.$val)){
								unlink('/opt/data/web/news/admin'.$val);
							}								
						}
					}
					if($field['art_img']!=I('post.art_img')){
						if(file_exists($field['art_img'])){
							unlink($field['art_img']);
						}
					}
					$arr=array(
						'art_cate'=>I('post.art_cate'),
						'art_tit'=>I('post.art_tit'),
						'art_img'=>I('post.art_img'),
						'art_view'=>I('post.art_view'),
						'art_order'=>I('post.art_order'),
						'art_status'=>2,
						'art_content'=>I('post.art_content')
					);
					if($db->where('art_id='.$_POST['art_id'])->save($arr)){
						$this->success('修改成功');
						$this->redirect(U('index.php?m=Home&c=Article&a=index&method=list'));
						exit;
					}else{
						$this->error('修改失败');exit;
					}
				}
				$this->display('edit');
			break;
			case 'move':
				$field=$db->where('art_id='.$_POST['art_id'])->find();
				$field['art_cate']=I('post.art_cate');
				$field['art_tit']=I('post.art_tit');
				$field['art_img']=I('post.art_img');
				$field['art_view']=I('post.art_view');
				$field['art_order']=I('post.art_order');
				$field['art_content']=I('post.art_content');
				
				$field['art_status']=2;
				$field['art_addtime']=date('Y-m-d H:i:s');
				$db->where('art_id='.$field['art_id'])->save($field);
				
				
				if(empty($_POST['table'])){
					$this->error('另存为失败');exit;
				}else{
					foreach($_POST['table'] as $table){
						$max=M($table)->order('art_id desc')->limit(1)->select()[0];
						$field['art_id']=$max['art_id']+1;
						M($table)->add($field);
					}
					$this->success('另存为成功');exit;
				}
			break;			
			case 'moveAll':
				$art_id_arr=explode(',',$_POST['art_ids']);
				foreach($art_id_arr as $val){
					$field=$db->where('art_id='.$val)->find();
					$field['art_status']=2;
					$field['art_addtime']=date('Y-m-d H:i:s');
					$db->where('art_id='.$field['art_id'])->save($field);
					if(empty($_POST['table'])){
					$this->error('另存为失败');exit;
					}else{
						foreach($_POST['table'] as $table){
							M($table)->add($field);
						}
					}
				}
				$this->success('另存为成功');exit;
			break;
			case 'del':	
				$field=$db->where('art_id='.I('get.art_id'))->find();
				if($db->where('art_id='.I('get.art_id'))->delete()){
					if(file_exists($field['art_img'])){
						unlink($field['art_img']);
					}
					preg_match_all('/<img [^\']*src="([^\"]*)"[^\']*\/>/iU', $field['art_content'], $img_arr);
					if(!empty($img_arr)){
						$img_arr=$img_arr[1];
					}
					foreach($img_arr as $key=>$val){
						if(file_exists('/opt/data/web/news/admin'.$val)){
							unlink('/opt/data/web/news/admin'.$val);
						}					
					}
					$this->success('删除成功');exit;
				}else{
					$this->error('删除失败');exit;
				}
			break;
			case 'search':
				if($_GET['art_status']){
					$where='art_status='.$_GET['art_status'];
				}else{
					$where='';
				}
				$res['count']=$db->where($where)->count();
				$Page=new \Think\Page($res['count'],100);
				$res['show']= $Page->show();// 分页显示输出
				$res['list'] = $db->where($where)->limit($Page->firstRow.','.$Page->listRows)->select();
				foreach($res['list'] as &$val){
					$val['art_cate']=M('category')->where('cate_id='.$val['art_cate'])->find()['cate_name'];
				}
				$this->assign('cur_status',$_GET['art_status']);
				$this->assign('res',$res);
				$this->display('search');
			break;
		}
	}
	
	public function pickup(){
		$this->assign('cur_nav','pickup');
		$method = I('get.method') ? I('get.method') : 'pickup';
		$db=M('article');
		switch ($method) {
			case 'pickup':
				$this->display('pickup');		
			break;
			case 'pick':
				exec('/opt/php/bin/php /opt/data/web/news/admin/index.php Pickup/PickupArts/pickupKeyword/art_keyword/'.$_POST['art_keyword'].'/num/'.$_POST['num'], $output, $result);
				echo '<pre>';
				print_r($output);
				echo '</pre>';
			break;
		}
	}
	
	public function keyword(){
		$this->assign('cur_nav','keyword');
		$res['list']=M('article')->distinct(true)->where('art_keyword!=\'\'')->field('art_keyword')->select();
		foreach($res['list'] as &$val){
			$val['art_addtime']=M('article')->where('art_keyword!=\''.$val['art_keyword'].'\'')->field('art_addtime')->find()['art_addtime'];
		}
		$this->assign('res',$res);
		$this->display('keyword');		
	}
}