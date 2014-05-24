<?php
class IndexAction extends UserAction{
	//公众帐号列表
	public function index(){
		$where['uid']=session('uid');
		$group=D('User_group')->select();
		foreach($group as $key=>$val){
			$groups[$val['id']]['did']=$val['diynum'];
			$groups[$val['id']]['cid']=$val['connectnum'];
		}
		unset($group);
		$db=M('Wxuser');
		$count=$db->where($where)->count();
		$page=new Page($count,25);
		$info=$db->where($where)->limit($page->firstRow.','.$page->listRows)->select();
		$this->assign('info',$info);
		$this->assign('group',$groups);
		$this->assign('page',$page->show());
		$this->display();
	}
	//添加公众帐号
	public function add(){
		$randLength=6;
		$chars='abcdefghijklmnopqrstuvwxyz';
		
		$len=strlen($chars);
		$randStr='';
		for ($i=0;$i<$randLength;$i++){
			$randStr.=$chars[rand(0,$len-1)];
		}
		$tokenvalue=$randStr.time();
		$this->assign('tokenvalue',$tokenvalue);
		$this->assign('email',time().'@yourdomain.com');
		//地理信息
		if (C('baidu_map_api')){
			//$locationInfo=json_decode(file_get_contents('http://api.map.baidu.com/location/ip?ip='.$_SERVER['REMOTE_ADDR'].'&coor=bd09ll&ak='.C('baidu_map_api')),1);
			///$this->assign('province',$locationInfo['content']['address_detail']['province']);
			//$this->assign('city',$locationInfo['content']['address_detail']['city']);
			//var_export($locationInfo);
		}
	
		
		$this->display();
	}
	public function edit(){
		$id=$this->_get('id','intval');
		$where['uid']=session('uid');
		$res=M('Wxuser')->where($where)->find($id);
		$this->assign('info',$res);
		$this->display();
	}
	
	public function del(){
		$where['id']=$this->_get('id','intval');
		$where['uid']=session('uid');
		$myArr = M('Wxuser')->where($where)->find();
		$tokenTall = $myArr['token'];
		if(D('Wxuser')->where($where)->delete()){
			
			//如果不是主号，则同步删除自己的商品资料   by zcb 20140331
			if ($tokenTall != $_SESSION['master_token']) {
				//分类
				M('item_cate')->where(array('tokenTall'=>$tokenTall))->delete();
				//品牌
				M('brandlist')->where(array('tokenTall'=>$tokenTall))->delete();
				//商品
				M('item')->where(array('tokenTall'=>$tokenTall))->delete();
			}
			//end by zcb 20140331
			
			$this->success('操作成功',U(MODULE_NAME.'/index'));
		}else{
			$this->error('操作失败',U(MODULE_NAME.'/index'));
		}
	}
	
	public function upsave(){
		$this->all_save('Wxuser');
	}
	
	public function insert(){
		$data=M('User_group')->field('wechat_card_num')->where(array('id'=>session('gid')))->find();
		$users=M('Users')->field('wechat_card_num')->where(array('id'=>session('uid')))->find();
		/*if($users['wechat_card_num']<$data['wechat_card_num']){
			
		}else{
			$this->error('您的VIP等级所能创建的公众号数量已经到达上限，请购买后再创建',U('User/Index/index'));exit();
		}*/
		//$this->all_insert('Wxuser');
		//
		$db=D('Wxuser');
		if($db->create()===false){
			$this->error($db->getError());
		}else{
			//判断微信号是否已经开店
			$flag = false;
			$wecha_shop=M('wecha_shop');
			$haveuse["wxname"]=$_POST["wxname"];
			$olduser=$db->where($haveuse)->find();
			if ($olduser["wxuser"] != "") {
				$this->error('该微信号已经存在其他用户中，请选择其他公众号！',U('Index/index'));
			}else{				
			
				$id=$db->add();
				if($id){
					M('Users')->field('wechat_card_num')->where(array('id'=>session('uid')))->setInc('wechat_card_num');
					$this->addfc();
					$weChaShop = M("wecha_shop");
					$data1["name"] = $_POST["wxname"];
					$headurl = $_POST["headerpic"];
					$data1["headurl"] = substr($headurl, 0,strlen($headurl));
					$data1["weName"] = $_POST["wxname"];
					$data1["HaveReal"] = 0;
					$data1["credit"] = 0;
					$where_shop['weName']=$_POST["wxname"];					
					$Have_token = $wecha_shop->where($where_shop)->find();
					
					if ($Have_token['tokenTall'] != "") {
						$data1["tokenTall"] = $Have_token['tokenTall'];
						$tokenData["token"] = $Have_token['tokenTall'];
						$flag = true;
						$where_shopw['wxname']=$_POST["wxname"];
						$db->where($where_shopw)->save($tokenData);
					}else{
						$data1["tokenTall"] = $_POST['token'];
						$weChaShop->add($data1);
					}
					
					
					//如果添加不是主号，则同步主号商品资料到自己   by zcb 20140331
					$me = $db->where(array('id'=>$id))->find();
					if ($me['token'] != $_SESSION['master_token']) {
						//分类
						$item_cates_mod = M('item_cate');
						$item_cates = $item_cates_mod->where(array('tokenTall'=>$_SESSION['master_token']))->order('id')->select();
						foreach ($item_cates as $onecate){
							$othercate = $onecate;
							unset($othercate['id']);
							$othercate['tokenTall'] = $me['token'];
							$othercate['fromid'] = $onecate['id'];
							if ($othercate['pid'] != '0') {
								$pidarr = $item_cates_mod->where("tokenTall='".$me['token']."' and fromid=".$othercate['pid'])->find();
								$othercate['pid'] = $pidarr['id'];
								$othercate['spid'] = $this->get_spid($othercate['pid']);
							}
							$item_cates_mod->add($othercate);
						}
						//品牌
						$item_brands_mod = M('brandlist');
						$item_brands = $item_brands_mod->where(array('tokenTall'=>$_SESSION['master_token']))->order('id')->select();
						foreach ($item_brands as $onebrand){
							$otherbrand = $onebrand;
							unset($otherbrand['id']);
							$otherbrand['tokenTall'] = $me['token'];
							$otherbrand['fromid'] = $onebrand['id'];
							$item_brands_mod->add($otherbrand);
						}
						//商品
						$items_mod = M('item');
						$items = $items_mod->where(array('tokenTall'=>$_SESSION['master_token']))->select();
						foreach ($items as $oneitem){
							$otheritem = $oneitem;
							unset($otheritem['id']);
							$otheritem['tokenTall'] = $me['token'];
							$otheritem['fromid'] = $oneitem['id'];
							
							$item_cate_rec = M('item_cate')->where(array('fromid'=>$otheritem['cate_id'], 'tokenTall'=>$me['token']))->find();
							$otheritem['cate_id'] = $item_cate_rec['id'];
							$item_brand_rec = M('brandlist')->where(array('fromid'=>$otheritem['brand'], 'tokenTall'=>$me['token']))->find();
							$otheritem['brand'] = $item_brand_rec['id'];
					
							$item_other_id = $items_mod->add($otheritem);
							
							//商品相册处理
							if ($item_other_id) {
								$item_other_img_mod = M('item_img');
								$item_other_img_mod->add(array('item_id'=>$item_other_id, 'url'=>$oneitem['img'], 'status'=>1));
							}
						}
					}
					//end by zcb 20140331
					
					
					
					
					if($flag){
						$this->success('欢迎回来',U('Index/index'));
					}else{
						$this->success('操作成功',U('Index/index'));
					}
					
				}else{
					$this->error('操作失败',U('Index/index'));
				}
			}
		}
		
	}
	
	public function get_spid($pid) {
		if (!$pid) {
			return 0;
		}
		$pspid = M('item_cate')->where(array('id'=>$pid))->getField('spid');
		if ($pspid) {
			$spid = $pspid . $pid . '|';
		} else {
			$spid = $pid . '|';
		}
		return $spid;
	}
	
	//功能
	public function autos(){
		$this->display();
	}
	
	public function addfc(){
		$token_open=M('Token_open');
		$open['uid']=session('uid');
		//判断微信号是否已经开店
		$wecha_shop=M('wecha_shop');
		$where_shop['weName']=$_POST["wxname"];
		$Have_token = $wecha_shop->where($where_shop)->find();
		if ($Have_token['tokenTall'] != "") {
			$open['token'] = $Have_token['tokenTall'];
		}else{
			$open['token']=$_POST['token'];
		}
		
		$gid=session('gid');
		$fun=M('Function')->field('funname,gid,isserve')->where('`gid` <= '.$gid)->select();
		foreach($fun as $key=>$vo){
			$queryname.=$vo['funname'].',';
		}
		$open['queryname']=rtrim($queryname,',');
		$token_open->data($open)->add();
	}
	
	public function usersave(){
		$pwd=$this->_post('password');
		if($pwd!=false){
			$data['password']=md5($pwd);
			$data['id']=$_SESSION['uid'];
			if(M('Users')->save($data)){
				$this->success('密码修改成功！',U('Index/index'));
			}else{
				$this->error('密码修改失败！',U('Index/index'));
			}
		}else{
			$this->error('密码不能为空!',U('Index/useredit'));
		}
	}
	//头像
	public function userpic(){
		if(IS_POST){
			$picurl=$this->_post('picurl');
			if($picurl!=false){
				$data['headerpic']=$picurl;
				$data['id']=$_SESSION['uid'];
				//更新users的headerpic字段
				if(M('Users')->save($data)){
					//同步更新下属公众号的头像
					$where['uid']=$_SESSION['uid'];
					$data2['headerpic']=$picurl;
					M('Wxuser')->where($where)->save($data2);
					
					$this->success('头像修改成功！',U('Index/index'));
				}else{
					$this->error('头像修改失败！',U('Index/userpic'));
				}
			}else{
				$this->error('头像不能为空!',U('Index/userpic'));
			}
		}else{
			$this->display();
		}
	}
	//处理关键词
	public function handleKeywords(){
		$Model = new Model();
		//检查system表是否存在
		$keyword_db=M('Keyword');
		$count = $keyword_db->where('pid>0')->count();
		//
		$i=intval($_GET['i']);
		//
		if ($i<$count){
			$img_db=M($data['module']);
			$back=$img_db->field('id,text,pic,url,title')->limit(9)->order('id desc')->where($like)->select();
			//
			$rt=$Model->query("CREATE TABLE IF NOT EXISTS `tp_system_info` (`lastsqlupdate` INT( 10 ) NOT NULL ,`version` VARCHAR( 10 ) NOT NULL) ENGINE = MYISAM CHARACTER SET utf8");
			$this->success('关键词处理中:'.$row['des'],'?g=User&m=Create&a=index');
		}else {
			exit('更新完成，请测试关键词回复');
		}
	}
}
?>