<?php
/**
 * @author Petr Grishin <petr.grishin@grishini.ru>
 */

namespace PetrGrishin\Url;


use CUrlManager;

class UrlBuilder {
    const PARAMETER_NAME_HASH = '#';

    /** @var CUrlManager */
    private $urlManager;
    /** @var string */
    private $route;
    /** @var array */
    private $params = array();

    public static function className() {
        return get_called_class();
    }

    public function __construct(CUrlManager $urlManager) {
        $this->urlManager = $urlManager;
    }

    /**
     * @return CUrlManager
     */
    public function getUrlManager() {
        return $this->urlManager;
    }

    /**
     * @return string
     */
    public function getRoute() {
        return $this->route;
    }

    /**
     * @param string $route
     * @return $this
     */
    public function setRoute($route) {
        $this->route = $route;
        return $this;
    }

    /**
     * @return array
     */
    public function getParams() {
        return $this->params;
    }

    /**
     * @param array $params
     * @return $this
     */
    public function setParams($params) {
        $this->params = $params;
        return $this;
    }

    public function getParam($name) {
        if (!array_key_exists($name, $this->params)) {
            throw new Exception\UrlBuilderException(sprintf('This param `%s` not exists'));
        }
        return $this->params[$name];
    }

    public function setParam($name, $value) {
        $this->params[$name] = $value;
        return $this;
    }

    public function getHash() {
        return $this->getParam(self::PARAMETER_NAME_HASH);
    }

    public function setHash($value) {
        $this->setParam(self::PARAMETER_NAME_HASH, $value);
        return $this;
    }

    /**
     * @return string
     */
    public function getUrl() {
        return $this->getUrlManager()->createUrl($this->route, $this->params);
    }

    /**
     * @return array
     */
    public function toArray() {
        return array(
            'route' => $this->route,
            'params' => $this->params,
        );
    }
}
 