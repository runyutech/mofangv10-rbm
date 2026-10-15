<?php
namespace server\rainyunrbm\model;

use think\Model;
use server\rainyunrbm\Rainyunrbm;
use think\facade\Cache;

class ProductModel extends Model
{
    protected $name = 'rainyun_rbm_product_config';

    protected $type = [
        'pid' => 'integer',
        'product_id' => 'integer',
        'price_rate' => 'float',
    ];
    public function getRbmPid($productId)
    {
        return $this->where('product_id', $productId)->value('pid') ?? false;
    }
    public function getPlanList(){
        $cacheData = Cache::get('rainyun_rbm_plan_list');
        if ($cacheData) {
            return $cacheData;
        }

        $rainyunrbm = new Rainyunrbm();
        $header = ["Content-Type: application/json; charset=utf-8"];
        $result = $rainyunrbm->Curl("https://api.v2.rainyun.com/product/rbm/models", [], 30, 'GET', $header);
        if(isset($result['code']) && $result['code'] == 200){
            $data = ['code' => 200, 'data' => $result['data']];
            Cache::set('rainyun_rbm_plan_list', $data, 60);
            return $data;
        }else{
            return ['code' => 400, 'msg' => '获取套餐列表失败'];
        }
    }
    public function getProductInfo($productId)
    {
        $cacheKey = 'rainyun_rbm_product_info_' . $productId;
        $cacheData = Cache::get($cacheKey);
        if ($cacheData) {
            return $cacheData;
        }

        $productList = $this->getPlanList();
        if($productList['code'] != 200){
            return $productList;
        }
        $rbmPid = $this->getRbmPid($productId);
        foreach ($productList['data'] as $product){
            if($product['id'] == $rbmPid){
                $product['id'] = $productId; 
                $data = [
                    'code' => 200,
                    'data' => $product,
                ];
                Cache::set($cacheKey, $data, 30);
                return $data;
                break;
            }
        }
        return [
            'code' => 404,
            'msg' => '产品未找到'
        ];
    }
    public function getOsTemplates() {
        $rainyunrbm = new Rainyunrbm();
        $header = ["Content-Type: application/json; charset=utf-8"];
        $result = $rainyunrbm->Curl("https://api.v2.rainyun.com/product/rbm/os-templates", [], 30, 'GET', $header);
        if(isset($result['code']) && $result['code'] == 200){
            return $result;
        }else{
            return [
                'code' => 400,
                'msg' => '获取操作系统模板列表失败'
            ];
        }
    }
}