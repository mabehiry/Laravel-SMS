<?php
namespace Mabehiry\Sms\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Mabehiry\Sms\Models\SmsSetting;

class SmsController extends Controller
{
    protected static $gateway;

    public static function run($gatewayName = false)
    {
        if (!$gatewayName)
        {
            $smsSetting = SmsSetting::where('user_id', Auth::user()->id)->first();
            if ($smsSetting) {
                $gatewayName = $smsSetting->gateway;
                $parameters = $smsSetting->parameters;
            }else{
                $gatewayName = config('sms.default');
                $parameters = config("sms.gateways")[$gatewayName]['parameters'];
            }
        }

        $gatewayProperties = config("sms.gateways")[$gatewayName];
        $gatewayProperties['parameters'] = $parameters;
        static::$gateway = $gatewayProperties;
    }

    public static function getUserGateway()
    {
        $smsSetting = SmsSetting::where('user_id', Auth::user()->id)->first();
        if ($smsSetting) {
            return $smsSetting->gateway;
        }
        return null;
    }

    public function showSettings()
    {
        $smsSetting = SmsSetting::where('user_id', Auth::user()->id)->first();
        if(!$smsSetting)
        {
            $smsSetting = new SmsSetting;
            $smsSetting->user_id = Auth::user()->id;
            $smsSetting->gateway = '';
            $smsSetting->parameters = '{}';
            $smsSetting->save();
        }

        $userGateway = $smsSetting->gateway;
        $smsGateways = config("sms.gateways");
        $gateways = array_keys($smsGateways);
        $parameters = [];

        foreach($smsGateways as $gateway => $properties)
        {
            $parameters[$gateway] = $properties['parameters'];
            foreach($parameters[$gateway] as $property => $value)
            {
                if($userGateway == $gateway && $smsSetting->parameters[$property]) $parameters[$gateway][$property] = $smsSetting->parameters[$property];
            }
        }
        return view('sms::settings', compact('gateways', 'parameters', 'userGateway'));
    }

    public function updateSettings(Request $request)
    {
        $smsSetting = SmsSetting::where('user_id', Auth::user()->id)->first();
        if (!$smsSetting) {
            $smsSetting = new SmsSetting;
            $smsSetting->user_id = Auth::user()->id;
        }
        $smsSetting->gateway = $request->gateway;
        $smsSetting->parameters = $request->paramters;
        $smsSetting->save();
        return redirect()->to('sms/settings')->with('message', 'Succesfully updated');
    }

    public static function SendRequest($type, $url, $parameters)
    {
        $ch = curl_init();
        if ($type == 'post') 
        {
            curl_setopt($ch, CURLOPT_URL, $url);
            curl_setopt($ch, CURLOPT_POST, 1);
            curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($parameters));
            //echo $url . "<br />" . http_build_query($parameters) . "<br />";
        }else{
            curl_setopt($ch, CURLOPT_URL, $url . "?" . http_build_query($parameters));
            //echo $url."?". http_build_query($parameters)."<br />";
        }
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_HEADER, 0);
        curl_setopt($ch, CURLOPT_TIMEOUT, 5);
        $result = curl_exec($ch);
        return $result;
    }

    public static function Balance($gatewayName = false)
    {
        static::run($gatewayName);
        $gateway = static::$gateway;
        $parameters[$gateway['userParameter']] = $gateway['parameters'][$gateway['userParameter']];
        if(!empty($gateway['passwordParameter'])) $parameters[$gateway['passwordParameter']] = $gateway['parameters'][$gateway['passwordParameter']];
        $request = static::SendRequest($gateway['method'], $gateway['links']['getCredit'], $parameters);
        return $request;
    }

    public static function Send($numbers, $message, $dateTime = false, $senderName = false, $gatewayName = false)
    {
        static::run($gatewayName);
        $gateway = static::$gateway;
        $numbers = self::format_numbers($numbers, $gateway['numbersSeparator']);
        $parameters = $gateway['parameters'];
        $parameters[$gateway['recipientsParameter']] = $numbers;
        $parameters[$gateway['messageParameter']] = $message;
        if ($senderName)
            $parameters[$gateway['senderParameter']] = $senderName;
        if ($dateTime) {
            $dateTimeObject = \DateTime::createFromFormat('Y-m-d H:i:s', $dateTime);
            if (isset($gateway['dateTimeParameter'])) {
                $parameters[$gateway['dateTimeParameter']] = $dateTimeObject->format($gateway['dateTimeFormat']);
            } else {
                $parameters[$gateway['dateParameter']] = $dateTimeObject->format($gateway['dateFormat']);
                $parameters[$gateway['timeParameter']] = $dateTimeObject->format($gateway['timeFormat']);
            }
        }
        $request = static::SendRequest($gateway['method'], $gateway['links']['sendBulk'], $parameters);
        return $request;
    }

    public static function format_numbers($numbers, $separator)
    {
        if (!is_array($numbers))
            return self::format_number($numbers);
        $numbers_array = array();
        foreach ($numbers as $number) {
            $n = self::format_numbers($number);
            array_push($numbers_array, $n);
        }
        return implode($separator, $numbers_array);
    }

    public static function format_number($number)
    {
        if (strlen($number) == 10 && starts_with($number, '05'))
            return preg_replace('/^0/', '966', $number);
        elseif (starts_with($number, '00'))
            return preg_replace('/^00/', '', $number);
        elseif (starts_with($number, '+'))
            return preg_replace('/^+/', '', $number);
        return $number;
    }

    public static function count_messages($text)
    {
        $length = mb_strlen($text);
        if ($length <= 70)
            return 1;
        else
            return ceil($length / 67);
    }

}
