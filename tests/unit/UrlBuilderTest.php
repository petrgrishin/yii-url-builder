<?php
use PetrGrishin\Url\UrlBuilder;

/**
 * @author Petr Grishin <petr.grishin@grishini.ru>
 */

class UrlBuilderTest extends PHPUnit_Framework_TestCase {

    public function test() {
        $url = $this->createUrlBuilder('site/index')->getUrl();
        $this->assertEquals('site/index', $url);
    }

    public function createUrlBuilder($route, $params = array()) {
        $urlBuilder = new UrlBuilder($this->getUrlManager());
        $urlBuilder
            ->setRoute($route)
            ->setParams($params);

        return $urlBuilder;
    }

    public function getUrlManager() {
        return $this->getApp()->getUrlManager();
    }

    /**
     * @return CWebApplication
     */
    public function getApp() {
        return \Yii::app();
    }
}
 