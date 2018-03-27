<?php

class BaseTest extends \PHPUnit\Framework\TestCase
{
    protected $data;

    public function setUp()
    {
        parent::setUp();
        date_default_timezone_set('Asia/Shanghai');
        \houdunwang\config\Config::set('aliyun', [
            'regionId'  => 'cn-hangzhou',
            'accessId'  => 'VUFGPITAyRwwi296',
            'accessKey' => 'DQDn3RSYzZ8OgZrUUfcRrnPYJgZ43r',
        ]);
    }

    public function testPushLive()
    {

        $client  = \houdunwang\aliyun\Aliyun::client();
        $request = new \live\Request\V20161101\AddLivePullStreamInfoConfigRequest();
        $request->setActionName('AddLivePullStreamInfoConfig');
        $request->setDomainName('live.houdunren.com');
        $request->setAppName('houdunren');
        $request->setStreamName('app');
        $request->setSourceUrl('houdunren.hdcms.com');
        $request->setStartTime(\Carbon\Carbon::instance(new DateTime('2017-10-25 3:33:12'))->format('Y-m-d\TH:i:s\Z'));
        $request->setEndTime(\Carbon\Carbon::instance(new DateTime('2017-10-27 3:33:12'))->format('Y-m-d\TH:i:s\Z'));
        $response = $client->getAcsResponse($request);
        print_r($response);
    }

    public function atestGetPushInfo()
    {
        $client  = \houdunwang\aliyun\Aliyun::client();
        $request = new \live\Request\V20161101\DescribeLiveStreamsOnlineListRequest();
        $request->setActionName('DescribeLiveStreamsOnlineList');
        $request->setDomainName('live.houdunren.com');
        $request->setAppName('houdunren');
        $response = $client->getAcsResponse($request);
        print_r($response);
        die;
    }

    public function atestLive()
    {
        $client  = \houdunwang\aliyun\Aliyun::client();
        $request = new \live\Request\V20161101\DescribeLiveStreamsPublishListRequest();
        $request->setActionName('DescribeLiveStreamsPublishList');
        $request->setDomainName('live.houdunren.com');
        $request->setStartTime(\Carbon\Carbon::instance(new DateTime('2017-05-22 3:33:12'))->format('Y-m-d\TH:i:s\Z'));
        $request->setEndTime(\Carbon\Carbon::instance(new DateTime('2017-05-23 3:33:12'))->format('Y-m-d\TH:i:s\Z'));
        $response = $client->getAcsResponse($request);
        print_r($response);
    }

    public function atestMail()
    {
        $client  = \houdunwang\aliyun\Aliyun::client();
        $request = new \Dm\Request\V20151123\SingleSendMailRequest();
        $request->setAccountName("edu@vip.houdunren.com");
        //发信人昵称
        $request->setFromAlias("后盾向军");
        $request->setAddressType(1);
        $request->setTagName("控制台创建的标签");
        $request->setReplyToAddress("true");
        $request->setToAddress("2300071698@qq.com");
        $request->setSubject("邮件主题-后盾人");
        $request->setHtmlBody("邮件正文-后盾人 人人做后盾");
        try {
            $response = $client->getAcsResponse($request);
            print_r($response);
        } catch (ClientException  $e) {
            print_r($e->getErrorCode());
            print_r($e->getErrorMessage());
        } catch (ServerException  $e) {
            print_r($e->getErrorCode());
            print_r($e->getErrorMessage());
        }
    }
}