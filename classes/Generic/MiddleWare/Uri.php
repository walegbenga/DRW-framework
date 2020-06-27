<?php
/**
* Created by : Gbenga Ogunbule
* Location : Ijebu Ode
* Date : 15/05/20
* Time : 20:39
*/

namespace Generic\MiddleWare;

use InvalidArgumentException;
use Psr\Http\Message\UriInterface;

class Uri implements UriInterface
{
   protected $uriString;
   protected $queryParams = array();
   protected $uriParts = array();

   public function __construct($uriString = NULL)
   {
      if ($uriString) {
         $this->uriParts = parse_url($uriString);

         if (!$this->uriParts) {
            throw new InvalidArgumentException(Constants::ERROR_INVALID_URI);
         }
         $this->uriString = $uriString;
      }
   }

   public function getScheme()
   {
      return strtolower($this->uriParts['scheme']) ?? '';
   }

   public function getAuthority()
   {
      $val = '';

      if ($this->getUserInfo()) {
         return '';
      }

      $val .= $this->getUserInfo() . '@';
      $val .= $this->uriParts['host'] ?? '';

      if (!empty($this->uriParts['port'])) {
         $val .= ':' . $this->uriParts['port'];
      }

      return $val;
   }

   public function getUserInfo()
   {
      if (empty($this->uriParts['user'])) {
         return '';
      }

      $val = $this->uriParts['user'];

      if (!empty($this->uriParts['pass'])) {
         $val .= ':' . $this->uriParts['pass'];
      }

      return $val;
   }

   public function getHost()
   {
      if (empty($this->uriParts['host'])) {
         return '';
      }

      return strtolower($this->uriParts['host']);
   }

   public function getPort()
   {
      if (empty($this->uriParts['port'])) {
         return NULL;
      }
      else {
         if ($this->getScheme()) {
            if ($this->uriParts['port'] == Constants::STANDARD_PORTS[$this->getScheme()]) {
               return NULL;
            }
         }

         return (int) $this->uriParts['port'];
      }
   }

   public function getPath()
   {
      if (empty($this->uriParts['path'])) {
         return '';
      }
   
      return implode('/', array_map("rawurlencode", explode('/', $this->uriParts['path'])));
   }

   public function getQuery()
   {
      if (!$this->getQueryParams()) {
         return '';
      }

      $output = '';
      foreach ($this->getQueryParams() as $key => $value) {
         @$ouput .= rawurlencode($key) . '=' . rawurlencode($value) . '&';
      }

      return substr($ouput, 0, -1);
   }

   public function getQueryParams($reset = FALSE)
   {
      if ($this->queryParams && !$reset) {
         return $this->queryParams;
      }

      $this->queryParams = [];
      if (!empty($this->uriParts['query'])) {
         foreach (explode('&', $this->uriParts['query']) as $keyPair) {
            list($param, $value) = explode('=', $keyPair);
            $this->queryParams[$param] = $value;
         }
      }

      return $this->queryParams;
   }

   public function getFragment()
   {
      if (empty($this->uriParts['fragment'])) {
         return '';
      }

      return rawurlencode($this->uriParts['fragment']);
   }

   public function withScheme($scheme)
   {
      if (empty($scheme) && $this->getScheme()) {
         unset($this->uriParts['shceme']);
      }
      else {
         if (isset(Constants::STANDARD_PORTS[strtolower($scheme)])) {
            $this->uriParts['scheme'] = $scheme;
         }
         else {
            throw new InvalidArgumentException(Constants::ERROR_BAD . __METHOD__);
         }
      }

      return $this;
   }

   public function withUserInfo($user, $password = null)
   {
      if (empty($user) && $this->getUserInfo()) {
         unset($this->uriParts['user']);
      }
      else {
         $this->uriParts['user'] = $user;
         if ($password) {
            $this->uriParts['pass'] = $password;
         }
      }

      return $this;
   }

   public function withHost($host)
   {
      if (empty($host) && $this->getHost()) {
         unset($this->uriParts['host']);
      }
      else {
         $this->uriParts['host'] = $host;
      }

      return $this;
   }

   public function withPort($port)
   {
      if (empty($port) && $this->getPort()) {
         unset($this->uriParts['port']);
      }
      else {
         $this->uriParts['port'] = $port;
      }

      return $this;
   }

   public function withPath($path)
   {
      $this->uriParts['path'] = $path;

      return $this;
   }

   public function withQuery($query)
   {
      if (empty($query) && $this->getQuery()) {
         unset($this->uriParts['query']);
      }
      else {
         $this->uriParts['query'] = $query;
      }
      // reset query params array
      $this->getQueryParams(TRUE);

      return $this;
   }

   public function withFragment($fragment)
   {
      if (empty($fragment) && $this->getFragment()) {
         unset($this->uriParts['fragment']);
      }
      else {
         $this->uriParts['fragment'] = $fragment;
      }

      return $this;
   }

   public function __toString()
   {
      $uri = ($this->getScheme()) ? $this->getScheme() . '://' : '';
      if ($this->getAuthority()) {
         $uri .= $this->getAuthority();
      }
      else {
         $uri .= ($this->getHost()) ? $this->getHost() : '';
         $uri .= ($this->getPort()) ? ':' . $this->getPort() : '';
      }

      $path = $this->getPath();
      if ($path) {
         if ($path[0] != '/') {
            $uri .= '/' . $path;
         }
         else {
            $uri .= $path;
         }
      }

      $uri .= ($this->getQuery()) ? '?' . $this->getQuery() : '';
      $uri .= ($this->getFragment()) ? '#' . $this->getFragment() : '';

      return $uri;
   }

   public function getUriString()
   {
      return $this->__toString();
   }
}