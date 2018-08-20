<?php
namespace app\admin\controller;

use app\admin\model\GoodsCategory;
use think\Db;
use think\Request;

class Goods extends Auth
{
    //商品列表
    public function goodsList()
    {
        $catId = $this->getVal($this->rqData, 'cat_id');
        $isOnSale = $this->getVal($this->rqData, 'is_on_sale');
        $goodsName = $this->getVal($this->rqData, 'goods_name');
        $other = $this->getVal($this->rqData, 'other');
        $map = [];
        if (!empty($catId)) $map['cat_id'] = $catId;
        if (!empty($goodsName)) $map['goods_name'] = ['like', '%' . $goodsName . '%'];
        if ($isOnSale !== '') $map['is_on_sale'] = $isOnSale;
        if ($other !== '') {
            if ($other == 1) {
                $map['is_hot'] = 1;
            } else if ($other == 2) {
                $map['is_recommend'] = 1;
            } else if ($other == 3) {
                $map['is_new'] = 1;
            }
        }
        //query 额外参数
        $goodsList = Db::name('goods')->where($map)->order(['on_time' => 'desc', 'is_on_sale' => 'desc'])->paginate(20, false, ['query' => $this->rqData]);
        $list = $this->getBaseCategory();
        $cateList = [];
        foreach ($list as $k => $v) {
            $v['char_name'] = getFirstCharter($v['name']) . ' ' . $v['name'];
            $cateList[$v['id']] = $v;
        }
        array_multisort(array_column($cateList, 'name'), SORT_ASC, $cateList);
        $this->assign('cateList', $cateList);
        $this->assign('goodsList', $goodsList);
        return $this->fetch();
    }

    public function getBaseCategory()
    {
        return Db::name('goods_category')->where('level', 2)->select();
    }

    //树，_child
    public function getCategoryTree()
    {
        $categoryList = Db::name('goods_category')->select();
        //从第二级开始
        $cateList = [];
        foreach ($categoryList as $k => $v) {
            if ($v['level'] == 1) {
                $cateList[$v['id']] = $v;
            } else if ($v['level'] == 2) {
                if (isset($cateList[$v['parent_id']])) {
                    $cateList[$v['parent_id']]['_child'][$v['id']] = $v;
                }
            }
        }
        return $cateList;
    }

    public function goodsAdd()
    {
        $id = $this->getVal($this->rqData, 'id', 0);
        if ($id) {
            $info = Db::name('goods_category')->where('id', $id)->find();
            $this->assign('info', $info);
        }
        $this->assign('cateList', $this->getCategoryList());
        return $this->fetch();
    }


    //列表
    public function getCategoryList()
    {
        $tree = $this->getCategoryTree();
        $cateList = [];
        foreach ($tree as $k => $v) {
            $t = $v;
            if (isset($v['_child'])) {
                unset($t['_child']);
                $t['name'] = '<span class="badge badge-secondary radius">' . $t['name'] . '</span>';
                $cateList[] = $t;
                foreach ($v['_child'] as $kk => $vv) {
                    $vv['name'] = '<span>&nbsp;├────── </span>' . $vv['name'];
                    $cateList[] = $vv;
                }
            }
        }
        return $cateList;
    }


    //分类列表,2级分类
    public function categoryList()
    {
        $this->assign('cateList', $this->getCategoryList());
        return $this->fetch();
    }


    public function categoryAdd()
    {
        $id = $this->getVal($this->rqData, 'id', 0);
        if ($id) {
            $info = Db::name('goods_category')->where('id', $id)->find();
            $this->assign('info', $info);
        }
        $this->assign('cateList', $this->getCategoryList());
        return $this->fetch();
    }

    public function categorySave()
    {
        $id = $this->getVal($this->rqData, 'id', 0);
        $name = $this->getVal($this->rqData, 'name');
        $parent_id = $this->getVal($this->rqData, 'parent_id', 0);
        $sort_order = $this->getVal($this->rqData, 'sort_order');
        $is_show = $this->getVal($this->rqData, 'is_show');
        $is_hot = $this->getVal($this->rqData, 'is_hot');
        $save_name = $this->getVal($this->rqData, 'save_name');
        if (empty($name) || empty($save_name)) {
            $this->error('数据提交失败');
        }
        $goodsCategoryMod = new GoodsCategory();
        $f = 0;
        if (!empty($id)) {
            //更新
            $goodsCategory = $goodsCategoryMod->get($id);
            $goodsCategory->name = $name;
            $goodsCategory->parent_id = $parent_id;
            $goodsCategory->is_show = $is_show == 'on' ? 1 : 0;
            $goodsCategory->is_hot = $is_hot == 'on' ? 1 : 0;
            $goodsCategory->sort_order = empty($sort_order) ? 50 : $sort_order;
            $goodsCategory->image = $save_name;
            $goodsCategory->parent_id_path = '';
            $goodsCategory->level = $parent_id == 0 ? 1 : 2;
            $f = $goodsCategory->save();
            if ($f > 0) {
                $goodsCategory->parent_id_path = $parent_id == 0 ? '0_' . $goodsCategory->id : '0_' . $parent_id . '_' . $goodsCategory->id;
                $goodsCategory->save();
            }
        } else {
            //新增
            $goodsCategoryMod->name = $name;
            $goodsCategoryMod->parent_id = $parent_id;
            $goodsCategoryMod->is_show = $is_show == 'on' ? 1 : 0;
            $goodsCategoryMod->is_hot = $is_hot == 'on' ? 1 : 0;
            $goodsCategoryMod->sort_order = empty($sort_order) ? 50 : $sort_order;
            $goodsCategoryMod->image = $save_name;
            $goodsCategoryMod->parent_id_path = '';
            $goodsCategoryMod->level = $parent_id == 0 ? 1 : 2;
            $f = $goodsCategoryMod->save();
            if ($f > 0) {
                $goodsCategoryMod->parent_id_path = $parent_id == 0 ? '0_' . $goodsCategoryMod->id : '0_' . $parent_id . '_' . $goodsCategoryMod->id;
                $goodsCategoryMod->save();
            }
        }
        $f > 0 ? $this->success('操作成功') : $this->error('操作失败');
    }

    public function categoryDel()
    {
        $id = $this->getVal($this->rqData, 'id', 0);
        $f = 0;
        if ($id) {
            $f = Db::name('goods_category')->where('id', $id)->delete();
        }
        $f = $f > 0 ? 0 : 1;    //0 成功
        return ['code' => $f, 'msg' => 'normal', 'data' => []];
    }

    public function fileUpload()
    {
        //webUpload插件名称file
        $file = request()->file('file');
        if ($file) {
            $path = config('UPLOADS_PATH') . 'category';
            $webPath = config('WEB_UPLOADS_PATH') . 'category' . DS;
            $info = $file->validate(['size' => 2 * 1024 * 1024, 'ext' => 'jpg,jpeg,bmp,png'])->rule('date')->move($path);
            if ($info) {
                echo json_encode(['code' => 0, 'msg' => '上传成功了哦。。。', 'data' => ['save_name' => str_replace('\\', '/', $webPath . $info->getSaveName())]]);
                exit;
            } else {
                // 上传失败获取错误信息
                echo $file->getError();
            }
        }
    }

    /**
     * 商品类型  用于设置商品的属性
     */
    public function goodsTypeList(){
        $list = Db::name('goods_type')->select();
        return $this->fetch('',['list'=>$list]);
    }


    /**
     * 商品类型  用于设置商品的属性
     */
    public function goodsTypeAdd(){
        $id = $this->getVal($this->rqData,'id',0);
        $info = [];
        if($id > 0){
            $info = Db::name('goods_type')->where('id',$id)->find();
        }
        return $this->fetch('',['info'=>$info]);
    }

    /**
     * 商品类型  用于设置商品的属性
     */
    public function goodsTypeSave(){
        $id = $this->getVal($this->rqData,'id',0);
        $name = $this->getVal($this->rqData,'name');
        if($id > 0 && $name){
            //更新
            $f = Db::name('goods_type')->where('id',$id)->update(['name'=>$name]);
        } else {
            //新增
            $f = Db::name('goods_type')->insert(['name'=>$name]);
        }
        return $f > 0 ? ['code'=>0,'msg'=>'success','data'=>[]] : ['code'=>1,'msg'=>'fail','data'=>[]];
    }

    public function goodsTypeDel()
    {
        $id = $this->getVal($this->rqData, 'id', 0);
        $f = 0;
        if ($id) {
            $f = Db::name('goods_type')->where('id', $id)->delete();
        }
        $f = $f > 0 ? 0 : 1;    //0 成功
        return ['code' => $f, 'msg' => 'normal', 'data' => []];
    }

    // 商品规格列表
    public function goodsTypeSpecList()
    {
        $typeId = $this->getVal($this->rqData,'type_id');
        $list = [];
        if($typeId > 0){
            $list = Db::name('spec')->where('type_id',$typeId)->order(['order'=>'asc'])->select();
        }
        //获取所有规格
        $goodsTypeList = Db::name('goods_type')->select();
        return $this->fetch('',['goodsTypeList'=>$goodsTypeList,'list'=>$list]);
    }

    // 编辑某个规格
    public function goodsTypeSpecEdit()
    {
        $typeId = $this->getVal($this->rqData,'type_id');
        $id = $this->getVal($this->rqData,'id');
        (int) $typeId == 0 && $this->error('请选择模型',null,'',1);
        $goodTypeInfo = Db::name('goods_type')->where('id',$typeId)->find();
        $info = Db::name('spec')->where('id',$id)->find();
        //获取对应模型
        return $this->fetch('',['goodTypeInfo'=>$goodTypeInfo,'info'=>$info]);
    }

    // 保存规格
    public function goodsTypeSpecSave()
    {
        $id = $this->getVal($this->rqData,'id',0);
        $typeId = $this->getVal($this->rqData,'type_id');
        $name = $this->getVal($this->rqData,'name');
        $order = $this->getVal($this->rqData,'order');
        if($id > 0 && $name && $order){
            //更新
            $f = Db::name('spec')->where('id',$id)->update(['name'=>$name,'order'=>$order]);
        } else {
            //新增
            $f = Db::name('spec')->insert(['type_id'=>$typeId,'name'=>$name,'order'=>$order]);
        }
        return $f > 0 ? ['code'=>0,'msg'=>'success','data'=>[]] : ['code'=>1,'msg'=>'fail','data'=>[]];
    }


    public function goodsTypeSpecDel()
    {
        $id = $this->getVal($this->rqData, 'id', 0);
        $f = 0;
        if ($id) {
            $f = Db::name('spec')->where('id', $id)->delete();
        }
        $f = $f > 0 ? 0 : 1;    //0 成功
        return ['code' => $f, 'msg' => 'normal', 'data' => []];
    }

    // 编辑规格项
    public function specItemEdit()
    {
        $specId = $this->getVal($this->rqData,'spec_id');
        $id = $this->getVal($this->rqData,'id');
        (int) $specId == 0 && $this->error('请选择规格项',null,'',1);
        //获取规格项列表
        $list = Db::name('spec_item')->where('spec_id',$specId)->select();
        $text = '';
        if(!empty($list)){
            $text = implode("\r\n",array_column($list,'item'));
        }
        //获取对应规格
        $specInfo = Db::name('spec')->where('id',$specId)->find();
        return $this->fetch('',['specInfo'=>$specInfo,'text'=>$text]);
    }

    // 保存规格项
    public function specItemSave()
    {
        $specId = $this->getVal($this->rqData,'spec_id');
        $item = $this->getVal($this->rqData,'item');
        $ret = ['code'=>1,'msg'=>'fail','data'=>[]];
        if($specId > 0 && $item){
            //更新
            $itemList = Db::name('spec_item')->where('spec_id',$specId)->field('id,item')->select();
            $oldItemArr = [];
            if(!empty($itemList)){
                foreach ($itemList as $v){
                    $oldItemArr[$v['id']] = $v['item'];
                }
            }
            $updateItemArr = explode("\r\n",$item);
            //计算交集,还存在的数组：第一个数组为主值，有值时，保留第一个数组的键名
            //$update = array_intersect($oldItemArr,$updateItemArr);
            //新增数组
            $add = array_diff($updateItemArr,$oldItemArr);
            //删除的数组
            $delete = array_keys(array_diff($oldItemArr,$updateItemArr));
            //逐个更新
            !empty($delete) && Db::name('spec_item')->where('id','in',$delete)->delete();
            $insert = [];
            foreach ($add as $v) {
                if(trim($v) == '') continue;
                $insert[] =  ['spec_id'=>$specId,'item'=>$v];
            }
            !empty($insert) && Db::name('spec_item')->insertAll($insert);
            $ret = ['code'=>0,'msg'=>'success','data'=>[]];
        }
        return $ret;
    }
}