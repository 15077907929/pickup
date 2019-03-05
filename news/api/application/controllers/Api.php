<?php
class ApiController extends Yaf_Controller_Abstract{

    public function indexAction(){
		echo 'hello world';
	}


    /**
     * Get token
     */
    public function getTokenByCodeAction()
    {
        $code = $this->getRequest()->getPost( "code", false );
        if (!$code){
             echo json_encode(array('status'=>0,'msg'=>'缺少参数'));
             exit();
        }
        $wechatModel = new WechatModel();
        $token = $wechatModel->getOpenId($code);
        if ($token){
            echo json_encode(array('status'=>1,'msg'=>'获取TOKEN成功','token'=>$token));
        }else{
            echo json_encode(array('status'=>0,'msg'=>'获取TOKEN失败','token'=>$token));
        }
	}


    /**
     * Verifying token
     */
    public function vaTokenAction()
    {
        $token = $this->getRequest()->getPost( "token", false );
        if (!$token){
            echo json_encode(array('status'=>0,'msg'=>'缺少参数'));
            exit();
        }
        $wechatModel = new WechatModel();
        $isExpire = $wechatModel->varification($token);
        if ($isExpire){
            echo json_encode(array('status'=>1,'msg'=>'TOKEN有效'));
        }else{
            echo json_encode(array('status'=>0,'msg'=>'TOKEN超时'));
        }
	}


    /**
     * 得到广告数据
     */
    public function getAdDataAction()
    {
        $appid = $this->getRequest()->getPost( "appid", false );
        if (!$appid){
            echo json_encode(array('status'=>0,'msg'=>'缺少参数'));
            exit();
        }
        $advertModel = new AdvertModel();
        $info = $advertModel->getAdRedis($appid);
        if (!$info){
            $info = $advertModel->getAdSql($appid);
        }
        if ($info){
            echo json_encode(array('status'=>1,'data'=>$info));
        }else
            echo json_encode(array('status'=>0,'msg'=>'未查到该应用广告信息'));
    }

    /**
     * 得到首页标题
     * Get the title of the article
     */
    public function getArticleTitleAction()
    {
        $appid = $this->getRequest()->getPost('appid',false);
        $count = $this->getRequest()->getPost('count',false);
        $page = $this->getRequest()->getPost('page',false);

        if (!$appid || !$count || !$page){
            echo json_encode(array('status'=>0,'msg'=>'缺少参数'));
            exit();
        }

        $articleModel = new ArticleModel();
        $res = $articleModel->getTitle($appid,$count,$page);
        if (!empty($res)){
            echo  json_encode(array('data'=>$res,'status'=>1));
        }else{
            $res = $articleModel->getRand($appid,$count);
            if (empty($res))
                echo  json_encode(array('msg'=>"没有文章信息",'status'=>2));
            else
                echo  json_encode(array('data'=>$res,'status'=>1));
        }
    }


    /**
     * 得到实际内容
     */
    public function getArticleAction()
    {
        $appid = $this->getRequest()->getPost('appid',false);
        $articleID = $this->getRequest()->getPost('article',false);
        $token = $_SERVER['HTTP_TOKEN'];
        if (!$appid || !$articleID || !$token){
            echo json_encode(array('status'=>0,'msg'=>'缺少参数'));
            exit();
        }

        $wechatModel = new WechatModel();
        if (!$wechatModel->varification($token)){
            echo json_encode(array('status'=>403,'msg'=>'token超时'));
            exit();
        }

        $articleModel = new ArticleModel();

        $res = $articleModel->getArticle($appid,$articleID);
        if (!empty($res)){
            echo  json_encode(array('data'=>$res,'status'=>1));
        }else{
            echo  json_encode(array('msg'=>"没有文章信息",'status'=>2));
        }
    }


    /**
     * 得到热搜的标题
     */
    public function getHotArticleAction()
    {
        $appid = $this->getRequest()->getPost('appid',false);
        $count = $this->getRequest()->getPost('count',false);
        $page = $this->getRequest()->getPost('page',false);

        if (!$appid || !$count || !$page){
            echo json_encode(array('status'=>0,'msg'=>'缺少参数'));
            exit();
        }

        $articleModel = new ArticleModel();
        $res = $articleModel->getHotArticle($appid,$count,$page);
        if (!empty($res)){
            echo  json_encode(array('data'=>$res,'status'=>1));
        }else{
            echo  json_encode(array('msg'=>"没有文章信息",'status'=>2));
        }
    }


    /**
     * 随机得到首页标题
     * Get the title of the article
     */
    public function getRandomAction()
    {
        $appid = $this->getRequest()->getPost('appid',false);
        $count = $this->getRequest()->getPost('count',false);

        if (!$appid || !$count){
            echo json_encode(array('status'=>0,'msg'=>'缺少参数'));
            exit();
        }

        $articleModel = new ArticleModel();
        $res = $articleModel->getRand($appid,$count);
        if (!empty($res)){
            echo  json_encode(array('data'=>$res,'status'=>1));
        }else{
            echo  json_encode(array('msg'=>"没有文章信息",'status'=>2));
        }
    }

    /**
     * 随机得到同类推荐
     */
    public function getRandomRecommendedAction()
    {
        $appid = $this->getRequest()->getPost('appid',false);
        $cate = $this->getRequest()->getPost('cate',false);
        $count = $this->getRequest()->getPost('count',false);

        if (!$cate || !$count){
            echo json_encode(array('status'=>0,'msg'=>'缺少参数'));
            exit();
        }

        $articleModel = new ArticleModel();
        $res = $articleModel->getRandomRecommended($appid,$cate,$count);
        if (!empty($res)){
            echo  json_encode(array('data'=>$res,'status'=>1));
        }else{
            echo  json_encode(array('msg'=>"没有文章信息",'status'=>2));
        }
    }


    //Get all the advertising information

    /**
     * 得到所有广告信息
     */
    public function getAllAdAction()
    {
        $appid = $this->getRequest()->getPost( "appid", false );
        if (!$appid){
            echo json_encode(array('status'=>0,'msg'=>'缺少参数'));
            exit();
        }
        $advertModel = new AdvertModel();
        $info = $advertModel->getSimpleAdSQL($appid);
        if ($info){
            echo json_encode(array('status'=>1,'data'=>$info));
        }else
            echo json_encode(array('status'=>0,'msg'=>'未查到该应用广告信息'));
    }


    /**
     * 获取分享封面
     */
    public function shareCoverAction()
    {
        $appid = $this->getRequest()->getPost( "appid", false );
        if (!$appid){
            echo json_encode(array('status'=>0,'msg'=>'缺少参数'));
            exit();
        }
        $advertModel = new AdvertModel();
        $url = $advertModel->getRandCover($appid);
        if ($url){
            echo json_encode(array('status'=>1,'url'=>$url));
        }else
            echo json_encode(array('status'=>0,'msg'=>'未查到该应用封面信息'));
    }

	public function getGzAction(){
		$appid = $this->getRequest()->getPost( "appid", false );
        if (!$appid){
            echo json_encode(array('status'=>0,'msg'=>'缺少参数'));
            exit();
        }
		$sql='select * from wechat_app where app_id=\''.$_POST['appid'].'\'';
		$app=JoyDb::query($sql)[0];
		echo  json_encode(array('data'=>$app,'status'=>1));
	}
	
	public function getInnerAdAction(){
		$appid = $this->getRequest()->getPost( "appid", false );
        if (!$appid){
            echo json_encode(array('status'=>0,'msg'=>'缺少参数'));
            exit();
        }
		$sql='select * from wechat_ad_to_app where app_id=\''.$_POST['appid'].'\'';
		$ads=JoyDb::query($sql);
		foreach($ads as $val){
			$sql='select * from wechat_simple_ad where id='.$val['ad_id'];
			$ad=JoyDb::query($sql)[0];
			if($ad['is_top']==2){
				$res=$ad;
			}
		}
		echo  json_encode(array('data'=>$res,'status'=>1));
	}

    /**
     * 得到跳转信息
     */
    public function getJumpAction()
    {
        $appid = $this->getRequest()->getPost( "appid", false );
        if (!$appid){
            echo json_encode(array('status'=>0,'msg'=>'缺少参数'));
            exit();
        }
        $wechatModel = new WechatModel();
        $rs = $wechatModel->getJumpInfo($appid);
        if ($rs){
            echo json_encode(array('status'=>1,'data'=>$rs));
        }else{
            echo json_encode(array('status'=>0,'msg'=>'未查到该应用跳转信息'));
        }

    }

}
