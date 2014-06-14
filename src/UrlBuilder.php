<?php
/**
 * @author Petr Grishin <petr.grishin@grishini.ru>
 */

namespace PetrGrishin\Url;


use CUrlManager;
use PetrGrishin\Url\Exception\UrlBuilderException;

class UrlBuilder {
    const PARAMETER_NAME_HASH = '#';

    /** @var CUrlManager */
    private $urlManager;
    /** @var string */
    private $route;
    /** @var array */
    private $params = array();
    /** @var array */
    private $required = array();

    public static function className() {
        return get_called_class();
    }

    /**
     * @param CUrlManager $urlManager
     */
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

    /**
     * @param string $name
     * @return mixed
     * @throws Exception\UrlBuilderException
     */
    public function getParam($name) {
        if (!array_key_exists($name, $this->params)) {
            throw new Exception\UrlBuilderException(sprintf('This param `%s` not exists'));
        }
        return $this->params[$name];
    }

    /**
     * @param string $name
     * @param mixed $value
     * @return $this
     */
    public function setParam($name, $value) {
        $this->params[$name] = $value;
        return $this;
    }

    /**
     * @return string
     * @throws Exception\UrlBuilderException
     */
    public function getHash() {
        return $this->getParam(self::PARAMETER_NAME_HASH);
    }

    /**
     * @param string $value
     * @return $this
     */
    public function setHash($value) {
        $this->setParam(self::PARAMETER_NAME_HASH, $value);
        return $this;
    }

    /**
     * @return array
     */
    public function getRequired() {
        return $this->required;
    }

    /**
     * @param array $required
     * @return $this
     */
    public function setRequired($required) {
        $this->required = $required;
        return $this;
    }

    /**
     * @throws Exception\UrlBuilderException
     * @return string
     */
    public function getUrl() {
        if ($this->hasRequiredParams()) {
            throw new UrlBuilderException(sprintf('Required params `%s` not exists', implode(', ', $this->requiredParams())));
        }
        return $this->getUrlManager()->createUrl($this->route, $this->params);
    }

    /**
     * @return array
     */
    public function toArray() {
        return array(
            'route' => $this->route,
            'params' => $this->params,
            'required' => $this->required,
        );
    }

    /**
     * @return UrlBuilder
     */
    public function copy() {
        return clone $this;
    }

    protected function hasRequiredParams() {
        return (boolean)$this->requiredParams();
    }

    protected function requiredParams() {
        return array_diff($this->required, array_keys(array_filter($this->params)));
    }
}
 