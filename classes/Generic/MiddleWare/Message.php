<?php
/**
* Created by : Gbenga Ogunbule
* Location : Ijebu Ode
* Date : 16/05/20
* Time : 07:54
*/

namespace Generic\MiddleWare;

use Psr\Http\Message\ {
   MessageInterface, 
   StreamInterface, 
   UriInterface 
};

class Message implements MessageInterface
{
   protected $body;
   protected $version;
   protected $httpHeaders = array();

   public function getBody()
   {
      if (!$this->body) {
         $this->body = new Stream(self::DEFFAULT_BODY_STREAM);
      }

      return $this->body;
   }

   public function withBody(StreamInterface $body)
   {
      if (!$body->isReadable()) {
         throw new InvalidArgumentException(self::ERROR_BODY_UNREADABLE);
      }
      $this->body = $body;

      return $this;
   }

   public function getHeaders()
   {
      foreach ($this->getHttpHeaders() as $key => $value) {
         header($key . ': ' . $value);
      }
   }

   public function getHttpHeaders()
   {
      if (!$this->httpHeaders) {
         if (function_exists('apache_request_headers')) {
            $this->httpHeaders = apache_request_headers();
         }
         else {
            $this->httpHeaders = $this->altApacheRequestHeaders();
         }
      }

      return $this->httpHeaders;
   }

   protected function altApacheRequestHeaders()
   {
      $headers = array();
      foreach ($_SERVER as $key => $value) {
         if (stripos($key, 'HTTP_') !== FALSE) {
            $headersKey = \str_ireplace('HTTP_', '', $key);
            $headers[$this->explodeHeader($headersKey)] = $value;
         }
         else if (stripos($key, 'CONTENT_') !== FALSE) {
            $headers[$this->explodeHeader($key)] = $value;
         }
      }

      return $headers;
   }

   protected function explodedheader($header)
   {
      $headerParts = explode('_', $header);
      $headerkey = ucwords(implode(' ', strtolower($headerParts)));

      return str_replace(' ', '-', $headerkey);
   }

   public function hasHeader($name)
   {
      return boolval($this->findHeader($name));
   }

   protected function findHeader($name)
   {
      $found = FALSE;

      foreach (array_keys($this->getHeaders()) as $header) {
         if (stripos($header, $name) !== FALSE) {
            $found = $header;
            break;
         }
      }

      return $found;
   }

   public function getHeader($name)
   {
      $line = $this->getHeaderLine($name);
      if ($line) {
         return explode(',', $line);
      }
      else {
         return array();
      }
   }

   public function getHeaderLine($name)
   {
      $found = $this->findHeader($name);
      if ($found) {
         return $this->httpHeaders[$found];
      }
      else {
         return '';
      }
   }

   public function withHeader($name, $value)
   {
      $found = $this->findHeader($name);
      if ($found) {
         $this->httpHeaders[$found] = $value;
      }
      else {
         $this->httpHeaders[$name] = $value;
      }

      return $this;
   }

   public function withAddedHeader($name, $value)
   {
      $found = $this->findHeader($name);
      if ($found) {
         $this->httpHeaders[$found] .= $value;
      }
      else {
         $this->httpHeaders[$name] = $value;
      }

      return $this;
   }

   public function withoutHeader($anme)
   {
      $found = $this->findHeader($name);
      if ($found) {
         unset($this->httpHeaders[$found]);
      }

      return $this;
   }

   public function getHeaderAsString()
   {
      $output = '';
      $headers = $this->getHeaders();

      if ($headers && is_array($headers)) {
         foreach ($header as $key => $value) {
            if ($output) {
               $output .= "\r\n" . $key . ': ' . $value;
            }
            else {
               $output .= $key . ': ' . $value;
            }
         }
      }

      return $output;
   }

   public function getProtocolVersion()
   {
      if (!$this->version) {
         $this->version = $this->onlyVersion($_SERVER['SERVER_PROTOCOL']);
      }

      return $this->version;
   }

   public function withProtocolVersion($version)
   {
      $this->version = $this->onlyVersion($version);

      return $this;
   }

   protected function onlyVersion($version)
   {
      if (!empty($version)) {
         return \preg_replace('/[^0-9\.]/', '', $version);
      }
      else {
         return NULL;
      }
   }
}