<?php
/**
 *
 */

namespace App\Service;


use App\Detector\DetectResult;
use App\Provider\ConnectionConfigProvider;

class CloudSuitTCenterCamDetectorService
{
    private array $cloudAccessManagementActionParam = [
        'DescribeRoleList' => [
            'Rp'     => 200,
            'Page'   => 1,
        ] ,
    ];

    private ConnectionConfigProvider $configProvider;

    /**
     * CloudSuitTCenterCamDetectorService constructor.
     * @param ConnectionConfigProvider $configProvider
     */
    public function __construct(ConnectionConfigProvider $configProvider)
    {
        $this->configProvider = $configProvider;
    }

    public function detect(string $action) :DetectResult
    {
        $config = $this->configProvider->provide();
        $secretId = $config['secret-id'];
        $secretKey = $config['secret-key'];
        $endpoint = $config['endpoint'];
        if (array_key_exists($action, $this->cloudAccessManagementActionParam)) {
            $requestParam = $this->signatureV3RequestParam($secretId, $secretKey, $action, $endpoint,
                $this->cloudAccessManagementActionParam[$action]);

            $opts = [
                'http' => [
                    'method'   =>  "POST",
                    'timeout'  =>  5,
                    'header'   =>  "Content-Type: application/x-www-form-urlencoded",
                    'content'  =>  $requestParam
                ]
            ];

            $context = stream_context_create($opts);
            $detectResult = new DetectResult();
            try {
                $content = file_get_contents('http://' . $endpoint, false, $context);
                if (mb_strrpos($content, '<') !== false && mb_strrpos($content, '<') >= 0) {
                    $detectResult->setCode(0);
                    $detectResult->setMessage('cam response contains invalid character "<" ');
                    return $detectResult;
                }
                $detectResult->setCode(1);
                $detectResult->setMessage($content);
                return $detectResult;
            } catch (\RuntimeException $exception) {
                $detectResult->setCode(0);
                $detectResult->setMessage($exception->getMessage());
                return $detectResult;
            }
        }
        return new DetectResult();
    }

    private function buildV3Param() : array
    {
        return [
            'Version'    =>   '2019-01-16',
            'Region'     =>   'chengdu',
            'Timestamp'  =>   time(),
            'Nonce'      =>   mt_rand(1048576, 1073741824),
        ];
    }

    private function signatureV3RequestParam(string $secretId, string $secretKey, string $action, string $camEndpoint, array $param) : string
    {
        $buildV3Param = $this->buildV3Param();
        $buildV3Param['Action'] = $action;
        $buildV3Param['SecretId'] =  $secretId;
        $buildParams = array_merge($buildV3Param, $param);

        ksort($buildParams);

        $paramStr = "";
        foreach ($buildParams as $key => $val) {
            $paramStr .= "{$key}={$val}&";
        }

        $sign = "POST" . $camEndpoint . "/?" . mb_substr($paramStr, 0, mb_strlen($paramStr) - 1);
        $signature = hash_hmac("sha1", $sign, $secretKey, true);

        $requestParam = "";

        foreach ($buildParams as $key => $val ) {
            $requestParam .= "{$key}=" . urlencode($val) . "&";
        }

        $requestParam = mb_substr($requestParam, 0, mb_strlen($requestParam) - 1);
        $requestParam .= "&Signature=" . urlencode(base64_encode($signature));
        return $requestParam;
    }
}