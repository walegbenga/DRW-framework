<?php
/**
* Created by : Gbenga Ogunbule
* Location : Ijebu Ode
* Date : 16/05/20
* Time : 08:08
*/

namespace Generic\MiddleWare;

use InvalidArgumentException;
use Psr\Http\Message\ { 
   RequestInterface, 
   StreamInterface, 
   UriInterface 
};

class Request extends Message implements RequestInterface
{
   protected $uri;
   protected $method;
   protected $uriObj;

   public function __construct(
      $uri = NUll,
      $method = NULL,
      StreamInterface $body = NULL,
      $headers = NULL,
      $version = NULL
   ) {
      $this->uri = $uri;
      $this->body = $body;
      $this->method = $this->checkMethod($method);
      $this->httpHeaders = $headers;
      $this->version = $this->onlyVersion($version);
   }

   public function getRequestTarget()
   {
      return $this->uri ?? Constants::DEFAULT_REQUEST_TARGET;
   }

   public function withRequestTarget($requestTarget)
   {
      $this->uri = $requestTarget;
      $this->getUri();

      return $this;
   }

   public function getMethod()
   {
      return $this->method;
   }

   public function withMethod($method)
   {
      $this->method = $this->checkMethod($method);

      return $this;
   }

   protected function checkMethod($method)
   {
      if (!$method === NULL) {
         if (!in_array(strtolower($method), Constants::HTTP_METHODS)) {
            throw new InvalidArgumentException(Constants::ERROR_HTTP_METHOD);
         }
      }

      return $method;
   }

   public function getUri()
   {
      if (!$this->uriObj) {
         $this->uriObj = new Uri($this->uri);
      }

      return $this->uriObj;
   }

   public function withUri(
      UriInterface $uri,
      $preserveHost = false)
   {
      if ($preserveHost) {
         $found = $this->findHeader(Constants::HEADER_HOST);
         if (!$found && $uri->getHost()) {
            $this->httpHeaders[Constants::HEADER_HOST] = $uri->getHost();
         }
      }
      else if ($uri->getHost()) {
         $this->httpHeaders[Constants::HEADER_HOST] = $uri->getHost();
      }

      $this->uri = $uri->__toString();

      return $this;
   }
}
