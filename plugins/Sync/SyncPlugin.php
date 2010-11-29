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
        $params = array('status'=>$notice->content,'source'=>'statusNet');
        $request = HTTPClient::start();
        $request->setConfig(array(
            'follow_redirects' => true,
            'connect_timeout' => 120,
            'timeout' => 120,
            'ssl_verify_peer' => false,
            'ssl_verify_host' => false
        ));
        $request->setAuth('chuck911@126.com', '123456');
        $headers = array('Expect:');
        $response = $request->post('http://api.t.sina.com.cn/update.xml', $headers, $params);
        $code = $response->getStatus();
        echo 'code:'.$code;
    }
}