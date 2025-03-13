<?php
class MobileDetect {
    private static function getUserAgent() {
        return isset($_SERVER['HTTP_USER_AGENT']) ? $_SERVER['HTTP_USER_AGENT'] : '';
    }

    public static function isMobile() {
        $userAgent = self::getUserAgent();
        $mobileKeywords = array(
            'Mobile', 'Android', 'iPhone', 'iPad', 'Windows Phone',
            'webOS', 'BlackBerry', 'iPod', 'Opera Mini', 'IEMobile'
        );

        foreach ($mobileKeywords as $keyword) {
            if (stripos($userAgent, $keyword) !== false) {
                return true;
            }
        }

        return false;
    }

    public static function isAndroid() {
        return stripos(self::getUserAgent(), 'Android') !== false;
    }

    public static function isIOS() {
        $userAgent = self::getUserAgent();
        return (stripos($userAgent, 'iPhone') !== false ||
                stripos($userAgent, 'iPad') !== false ||
                stripos($userAgent, 'iPod') !== false);
    }
}