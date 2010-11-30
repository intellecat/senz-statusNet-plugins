<?php
/**
 * Sync Plugin
 *
 * @category Plugin
 * @package  Statusnet
 * @author   chuck911
 * @license  http://www.fsf.org/licensing/licenses/agpl-3.0.html GNU Affero General Public License version 3.0
 * @version  CommonStylePlugin.php,v 0.1
 *
 */

if (!defined('STATUSNET')) {
    exit(1);
}

class SyncPlugin extends Plugin
{
    function onEndNoticeSaveWeb($action,$notice){
        $this->toSina($notice);
        $this->toDigu($notice);
    }
    
    function toSina($notice){
        $params = array('status'=>$notice->content,'source'=>'3268519186');
        $request = HTTPClient::start();
        $request->setConfig(array(
            'follow_redirects' => true,
            'connect_timeout' => 120,
            'timeout' => 120,
            'ssl_verify_peer' => false,
            'ssl_verify_host' => false
        ));
        $request->setAuth('chuck911@126.com', '123456');
        $headers = array();//array('Expect:');//http://api.t.sina.com.cn/statuses/update
        $response = $request->post('http://api.t.sina.com.cn/statuses/update.xml', $headers, $params);
        $code = $response->getStatus();
    }
    
    function toDigu($notice){
        $params = array('content'=>$notice->content,'source'=>'statusNet');
        $request = HTTPClient::start();
        $request->setConfig(array(
            'follow_redirects' => true,
            'connect_timeout' => 120,
            'timeout' => 120,
            'ssl_verify_peer' => false,
            'ssl_verify_host' => false
        ));
        $request->setAuth('chuck911@126.com', '123456');
        $headers = array();//array('Expect:');//http://api.t.sina.com.cn/statuses/update
        $response = $request->post('http://api.minicloud.com.cn/statuses/update.json',$headers, $params);
        $code = $response->getStatus();
    }
}