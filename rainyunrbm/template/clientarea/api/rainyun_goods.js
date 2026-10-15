function getProductInfo(id) {
    return Axios.get(`/rainyunrbm/product/${id}`);
}
// 获取IP类型映射
function getIpTypeMap(id) {
    return Axios.get(`/rainyunrbm/product/${id}/ip_types`);
}
// 获取操作系统模板列表
function getOsTemplates(id) {
    return Axios.get(`/rainyunrbm/product/${id}/os_templates`);
}
// 计算价格（复用系统 product/:id/config_option 接口）
function calcPrice(params) {
    return Axios.post(`/product/${params.id}/config_option`, params);
}
// 应用优惠码（系统标准接口）
function apiApplyPromoCode(params) {
    return Axios.post(`/promo_code/apply`, params);
}
// 加入购物车
function addToCart(params) {
    return Axios.post('/cart', params);
}
// 获取购物车列表
function cartList() {
    return Axios.get('/cart');
}
// 获取雨云论坛话题内容（服务端代理，避免跨域）
function getForumTopicContent(topicId) {
    return Axios.get(`/rainyunrbm/forum_topic/${topicId}`);
}