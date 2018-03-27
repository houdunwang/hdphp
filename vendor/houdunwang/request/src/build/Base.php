<?php
/** .-------------------------------------------------------------------
 * |  Software: [HDCMS framework]
 * |      Site: www.hdcms.com
 * |-------------------------------------------------------------------
 * |    Author: 向军 <2300071698@qq.com>
 * |    WeChat: aihoudun
 * | Copyright (c) 2012-2019, www.houdunwang.com. All Rights Reserved.
 * '-------------------------------------------------------------------*/

namespace houdunwang\request\build;

use houdunwang\arr\Arr;
use houdunwang\cookie\Cookie;
use houdunwang\session\Session;
use houdunwang\tool\Tool;
use houdunwang\config\Config;

/**
 * 请求管理
 * Class Base
 *
 * @package houdunwang\request\build
 */
class Base {
	protected $items = [];

	/**
	 * 构造函数
	 * Base constructor.
	 */
	public function __construct() {
		$_SERVER['SCRIPT_NAME'] = str_replace( '\\', '/', $_SERVER['SCRIPT_NAME'] );
		//命令行时定义默认值
		if ( ! isset( $_SERVER['REQUEST_METHOD'] ) ) {
			$_SERVER['REQUEST_METHOD'] = '';
		}
		if ( ! isset( $_SERVER['HTTP_HOST'] ) ) {
			$_SERVER['HTTP_HOST'] = '';
		}
		if ( ! isset( $_SERVER['REQUEST_URI'] ) ) {
			$_SERVER['REQUEST_URI'] = '';
		}
		defined( 'NOW' ) or define( 'NOW', $_SERVER['REQUEST_TIME'] );
		defined( 'MICROTIME' ) or define( 'MICROTIME', $_SERVER['REQUEST_TIME_FLOAT'] );
		defined( '__URL__' ) or define( '__URL__', $this->url() );
		defined( '__HISTORY__' ) or define( "__HISTORY__", $this->history() );
		defined( '__ROOT__' ) or define( '__ROOT__', $this->domain() );
		defined( '__WEB__' ) or define( '__WEB__', $this->web() );
		define( 'DS', DIRECTORY_SEPARATOR );
		$this->defineRequestConst();
	}

	/**
	 * 当前链接地址
	 *
	 * @return string
	 */
	public function url() {
		return trim( 'http://' . $_SERVER['HTTP_HOST'] . '/' . trim( $_SERVER['REQUEST_URI'],
				'/\\' ), '/' );
	}

	/**
	 * 网站域名
	 *
	 * @return string
	 */
	public function domain() {
		return defined( 'RUN_MODE' ) && RUN_MODE != 'HTTP' ? ''
			: trim( 'http://' . $_SERVER['HTTP_HOST'] . dirname( $_SERVER['SCRIPT_NAME'] ), '/\\' );
	}

	/**
	 * 根据伪静态配置
	 * 添加带有入口文件的链接
	 *
	 * @return string
	 */
	public function web() {
		$root = $this->domain();

		return Config::get( 'http.rewrite' ) ? $root : $root . '/index.php';
	}

	/**
	 * 获取来源页
	 *
	 * @return string
	 */
	public function history() {
		return isset( $_SERVER["HTTP_REFERER"] ) ? $_SERVER["HTTP_REFERER"] : '';
	}

	/**
	 * 定义请求常量
	 */
	protected function defineRequestConst() {
		$this->items['POST']    = $_POST;
		$this->items['GET']     = $_GET;
		$this->items['REQUEST'] = $_REQUEST;
		$this->items['SERVER']  = $_SERVER;
		$this->items['GLOBALS'] = $GLOBALS;
		$this->items['SESSION'] = Session::all();
		$this->items['COOKIE']  = Cookie::all();
		if ( empty( $_POST ) ) {
			$input = file_get_contents( 'php://input' );
			if ( $data = json_decode( $input, true ) ) {
				$this->items['POST'] = $data;
			}
		}
		defined( 'IS_GET' ) or define( 'IS_GET', $this->isMethod( 'get' ) );
		defined( 'IS_POST' ) or define( 'IS_POST', $this->isMethod( 'post' ) );
		defined( 'IS_DELETE' ) or define( 'IS_DELETE', $this->isMethod( 'delete' ) );
		defined( 'IS_PUT' ) or define( 'IS_PUT', $this->isMethod( 'put' ) );
		defined( 'IS_AJAX' ) or define( 'IS_AJAX', $this->isAjax() );
		defined( 'IS_WECHAT' ) or define( 'IS_WECHAT', $this->isWeChat() );
		defined( 'IS_MOBILE' ) or define( 'IS_MOBILE', $this->isMobile() );
	}

	/**
	 * 获取请求头信息
	 *
	 * @return mixed
	 */
	public function getallheaders() {
		foreach ( $_SERVER as $name => $value ) {
			if ( substr( $name, 0, 5 ) == 'HTTP_' ) {
				$headers[ str_replace( ' ', '-',
					ucwords( strtolower( str_replace( '_', ' ', substr( $name, 5 ) ) ) ) ) ]
					= $value;
			}
		}

		return $headers;
	}

	/**
	 * 判断请求类型
	 *
	 * @param $action
	 *
	 * @return bool
	 */
	public function isMethod( $action ) {
		switch ( strtoupper( $action ) ) {
			case 'GET':
				return $_SERVER['REQUEST_METHOD'] == 'GET';
			case 'POST':
				return $_SERVER['REQUEST_METHOD'] == 'POST' || ! empty( $this->items['POST'] );
			case 'DELETE':
				return $_SERVER['REQUEST_METHOD'] == 'DELETE'
					?: ( isset( $_POST['_method'] ) && $_POST['_method'] == 'DELETE' );
			case 'PUT':
				return $_SERVER['REQUEST_METHOD'] == 'PUT'
					?: ( isset( $_POST['_method'] ) && $_POST['_method'] == 'PUT' );
			case 'AJAX':
				return $this->isAjax();
			case 'wechat':
				return $this->isWeChat();
			case 'mobile':
				return $this->isMobile();
		}
	}

	/**
	 * 获取请求的类型
	 * GET/POST/DELETE/PUT
	 *
	 * @return mixed
	 */
	public function getRequestType() {
		$type = [ 'PUT', 'DELETE', 'POST', 'GET' ];
		foreach ( $type as $t ) {
			if ( $this->isMethod( $t ) ) {
				return $t;
			}
		}
	}

	/**
	 * 是否为异步提交
	 *
	 * @return bool
	 */
	public function isAjax() {
		return isset( $_SERVER['HTTP_X_REQUESTED_WITH'] )
		       && strtolower( $_SERVER['HTTP_X_REQUESTED_WITH'] ) == 'xmlhttprequest';
	}

	/**
	 * 获取数据
	 *
	 * @param       $name
	 * @param       $value
	 * @param array $method
	 *
	 * @return null
	 */
	public function query( $name, $value = null, $method = [] ) {
		$exp = explode( '.', $name );
		if ( count( $exp ) == 1 ) {
			array_unshift( $exp, 'request' );
		}
		$action = array_shift( $exp );

		return $this->__call( $action, [ implode( '.', $exp ), $value, $method ] );
	}

	/**
	 * 设置值
	 *
	 * @param $name 类型如get.name,post.id
	 * @param $value
	 *
	 * @return bool
	 */
	public function set( $name, $value ) {
		$info   = explode( '.', $name );
		$action = strtoupper( array_shift( $info ) );
		if ( isset( $this->items[ $action ] ) ) {
			$this->items[ $action ] = Arr::set( $this->items[ $action ], implode( '.', $info ),
				$value );

			return true;
		}
	}

	/**
	 * 获取数据
	 * 示例: Request::get('name')
	 *
	 * @param $action    类型如get,post
	 * @param $arguments 参数结构如下
	 *                   [
	 *                   'name'=>'变量名',//config.a 可选
	 *                   'value'=>'默认值',//可选
	 *                   'method'=>'回调函数',//数组类型 可选
	 *                   ]
	 *
	 * @return mixed
	 */
	public function __call( $action, $arguments ) {
		$action = strtoupper( $action );
		if ( empty( $arguments ) ) {
			return $this->items[ $action ];
		}

		$data = Arr::get( $this->items[ $action ], $arguments[0] );

		if ( ! is_null( $data ) && ! empty( $arguments[2] ) ) {
			return Tool::batchFunctions( $arguments[2], $data );
		}

		return ! is_null( $data ) ? $data : ( isset( $arguments[1] ) ? $arguments[1] : null );
	}

	/**
	 * 客户端IP
	 *
	 * @param int $type
	 *
	 * @return mixed|string
	 */
	public function ip( $type = 0 ) {
		$type = intval( $type );
		//保存客户端IP地址
		if ( isset( $_SERVER ) ) {
			if ( isset( $_SERVER["HTTP_X_FORWARDED_FOR"] ) ) {
				$ip = $_SERVER["HTTP_X_FORWARDED_FOR"];
			} else if ( isset( $_SERVER["HTTP_CLIENT_IP"] ) ) {
				$ip = $_SERVER["HTTP_CLIENT_IP"];
			} else if ( isset( $_SERVER["REMOTE_ADDR"] ) ) {
				$ip = $_SERVER["REMOTE_ADDR"];
			} else {
				return '';
			}
		} else {
			if ( getenv( "HTTP_X_FORWARDED_FOR" ) ) {
				$ip = getenv( "HTTP_X_FORWARDED_FOR" );
			} else if ( getenv( "HTTP_CLIENT_IP" ) ) {
				$ip = getenv( "HTTP_CLIENT_IP" );
			} else if ( getenv( "REMOTE_ADDR" ) ) {
				$ip = getenv( "REMOTE_ADDR" );
			} else {
				return '';
			}
		}
		$long     = ip2long( $ip );
		$clientIp = $long ? [ $ip, $long ] : [ "0.0.0.0", 0 ];

		return $clientIp[ $type ];
	}

	/**
	 * 判断请求来源是否为本网站域名
	 *
	 * @return bool
	 */
	public function isDomain() {
		if ( isset( $_SERVER['HTTP_REFERER'] ) ) {
			$referer = parse_url( $_SERVER['HTTP_REFERER'] );

			return $referer['host'] == $_SERVER['HTTP_HOST'];
		}

		return false;
	}

	/**
	 * https请求
	 *
	 * @return bool
	 */
	public function isHttps() {
		if ( isset( $_SERVER['HTTPS'] )
		     && ( '1' == $_SERVER['HTTPS']
		          || 'on' == strtolower( $_SERVER['HTTPS'] ) ) ) {
			return true;
		} elseif ( isset( $_SERVER['SERVER_PORT'] ) && ( '443' == $_SERVER['SERVER_PORT'] ) ) {
			return true;
		}

		return false;
	}

	/**
	 * 微信客户端检测
	 *
	 * @return bool
	 */
	public function isWeChat() {
		return isset( $_SERVER['HTTP_USER_AGENT'] )
		       && strpos( $_SERVER['HTTP_USER_AGENT'], 'MicroMessenger' ) !== false;
	}

	/**
	 * 手机客户端判断
	 *
	 * @return bool
	 */
	public function isMobile() {
		//微信客户端检测
		if ( $this->isWeChat() ) {
			return true;
		}
		if ( ! empty( $_GET['_mobile'] ) ) {
			return true;
		}
		if ( ! isset( $_SERVER['HTTP_USER_AGENT'] ) ) {
			return false;
		}
		$_SERVER['ALL_HTTP'] = isset( $_SERVER['ALL_HTTP'] ) ? $_SERVER['ALL_HTTP'] : '';
		$mobile_browser      = '0';
		if ( preg_match( '/(up.browser|up.link|mmp|symbian|smartphone|midp|wap|phone|iphone|ipad|ipod|android|xoom)/i',
			strtolower( $_SERVER['HTTP_USER_AGENT'] ) ) ) {
			$mobile_browser ++;
		}
		if ( ( isset( $_SERVER['HTTP_ACCEPT'] ) )
		     and ( strpos( strtolower( $_SERVER['HTTP_ACCEPT'] ), 'application/vnd.wap.xhtml+xml' )
		           !== false ) ) {
			$mobile_browser ++;
		}
		if ( isset( $_SERVER['HTTP_X_WAP_PROFILE'] ) ) {
			$mobile_browser ++;
		}
		if ( isset( $_SERVER['HTTP_PROFILE'] ) ) {
			$mobile_browser ++;
		}
		$mobile_ua     = strtolower( substr( $_SERVER['HTTP_USER_AGENT'], 0, 4 ) );
		$mobile_agents = [
			'w3c ',
			'acs-',
			'alav',
			'alca',
			'amoi',
			'audi',
			'avan',
			'benq',
			'bird',
			'blac',
			'blaz',
			'brew',
			'cell',
			'cldc',
			'cmd-',
			'dang',
			'doco',
			'eric',
			'hipt',
			'inno',
			'ipaq',
			'java',
			'jigs',
			'kddi',
			'keji',
			'leno',
			'lg-c',
			'lg-d',
			'lg-g',
			'lge-',
			'maui',
			'maxo',
			'midp',
			'mits',
			'mmef',
			'mobi',
			'mot-',
			'moto',
			'mwbp',
			'nec-',
			'newt',
			'noki',
			'oper',
			'palm',
			'pana',
			'pant',
			'phil',
			'play',
			'port',
			'prox',
			'qwap',
			'sage',
			'sams',
			'sany',
			'sch-',
			'sec-',
			'send',
			'seri',
			'sgh-',
			'shar',
			'sie-',
			'siem',
			'smal',
			'smar',
			'sony',
			'sph-',
			'symb',
			't-mo',
			'teli',
			'tim-',
			'tosh',
			'tsm-',
			'upg1',
			'upsi',
			'vk-v',
			'voda',
			'wap-',
			'wapa',
			'wapi',
			'wapp',
			'wapr',
			'webc',
			'winw',
			'winw',
			'xda',
			'xda-',
		];
		if ( in_array( $mobile_ua, $mobile_agents ) ) {
			$mobile_browser ++;
		}
		if ( strpos( strtolower( $_SERVER['ALL_HTTP'] ), 'operamini' ) !== false ) {
			$mobile_browser ++;
		}
		// Pre-final check to reset everything if the user is on Windows
		if ( strpos( strtolower( $_SERVER['HTTP_USER_AGENT'] ), 'windows' ) !== false ) {
			$mobile_browser = 0;
		}
		// But WP7 is also Windows, with a slightly different characteristic
		if ( strpos( strtolower( $_SERVER['HTTP_USER_AGENT'] ), 'windows phone' ) !== false ) {
			$mobile_browser ++;
		}
		if ( $mobile_browser > 0 ) {
			return true;
		} else {
			return false;
		}
	}

	/**
	 * 获取主机名
	 *
	 * @param string $url 链接地址
	 *
	 * @return string
	 */
	public function getHost( $url ) {
		$arr = parse_url( $url );

		return isset( $arr['host'] ) ? $arr['host'] : '';
	}

	/**
	 * 添加或移除$_GET参数并转为字符串
	 *
	 * @param string $name 变量名
	 * @param bool   $type
	 *
	 * @return string
	 */
	public function getToStr( $name = null, $value = null ) {
		$arr = $_GET;
		if ( ! is_null( $name ) ) {
			if ( is_null( $value ) ) {
				$arr = Arr::getExtName( $arr, [ $name ] );
			} else {
				$arr[ $name ] = $value;
			}
		}
		$build = '';
		foreach ( (array) $arr as $k => $v ) {
			$build .= $k . '=' . $v . '&';
		}

		return trim( $build, '&' );
	}
}