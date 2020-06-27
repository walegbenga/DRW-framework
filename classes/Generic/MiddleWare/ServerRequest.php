<?php
/**
* Created by : Gbenga Ogunbule
* Location : Ijebu Ode
* Date : 16/05/20
* Time : 08:19
*/

namespace Generic\Middleware;

use Psr\Http\Message\ { 
   ServerRequestInterface,
   UploadedFileInterface 
};

class ServerRequest extends Request implements ServerRequestInterface
{
   protected $serverParams;
   protected $cookies;
   protected $queryParams;
   protected $contentType;
   protected $parseBody;
   protected $attributes;
   protected $method;
   protected $uploadedFileInfo;
   protected $uploadedFileObjs;

   public function initialize()
   {
      $this->getServerParams();
      $this->getCookieParams();
      $this->getQueryParams();
      $this->getuploadedFiles();
      $this->getRequestMethod();
      $this->getContentType();
      $this->getParsedBody();

      return $this->withRequestTarget($this->getServerParams()['REQUEST_URI']);
   }

   public function getServerParams()
   {
      if (!$this->serverParams) {
         $this->serverParams = $_SERVER;
      }

      return $this->serverParams;
   }

   public function getCookieParams()
   {
      if (!$this->cookies) {
         $this->cookies = $_COOKIE;
      }

      return $this->cookies;
   }

   public function withCookieParams(array $cookies)
   {
      array_merge($this->getCookieParams(), $cookeis);

      return $this;
   }

   public function getQueryParams()
   {
      if (!$this->queryParams) {
         $this->queryParams = $_GET;
      }

      return $this->queryParams;
   }

   public function withQueryParams(array $query)
   {
      array_merge($this->getQueryParams(), $query);

      return $this;
   }

   public function getUploadedFileInfo()
   {
      if (!$this->uploadedFileInfo) {
         $this->uploadedFileInfo = $_FILES ?? array();
      }

      return $this->uploadedFileInfo;
   }

   public function getUploadedFiles()
   {
      if (!$this->uploadedFileObjs) {
         foreach ($this->getUploadedFileInfo() as $field => $value) {
            $this->uploadedFileObjs[$field] = new UploadedFile($field, $value);
         }
      }

      return $this->uploadedFileObjs;
   }

   public function withUploadedFiles(array $uploadedFiles)
   {
      if (!count($uploadedFiles)) {
         throw new InvalidArgumentException(Constant::ERR_NO_UPLOADED_FILES);
      }

      foreach ($uploadedFiles as $fileObj) {
         if (!$fileObj instanceof UploadedFileInterface) {
            throw new InvalidArgumentException(Constant::ERROR_INVALID_UPLOADED);
         }
      }

      $this->uploadedFileObj = $uploadedFiles;
   }

   public function getRequestMethod()
   {
      $method = $this->getServerParams()['REQUEST_METHOD'] ?? $this->method = strtolower($method);

      return $this->method;
   }

   public function getContentType()
   {
      if (!$this->contentType) {
         $this->contentType = $this->getServerParams()['CONTENT_TYPE'] ?? '';
         $this->contentType = strtolower($this->contentType);
      }

      return $this->contentType;
   }

   public function getParsedBody()
   {
      if (!$this->parseBody) {
         if (
               ($this->getContentType() == Constants::CONTENT_TYPE_FORM_ENCODED
                  || $this->getContentType() == Constants::CONTENT_TYPE_MULTI_FORM)
               && $this->getRequestMethod() == Constants::METHOD_POST
         ) {
            $this->parsebody = $_POST;
         }
         else if (
            $this->getContentType() == Constants::CONTENT_TYPE_JSON
            || $this->getContentType() == Constants::CONTENT_TYPE_HAL_JSON
         ) {
            ini_set("allow_url_fopen", true);
            $this->parseBody = json_decode(file_get_contents('php://input'));
         }
         else if (!empty($_REQUEST)) {
            $this->parseBody = $_REQUEST;
         }
         else {
            ini_set("allow_url_fopen", true);
            $this->parseBody = \file_get_contents('php://input');
         }
      }

      return $this->parseBody;
   }

   public function withParsedBody($data)
   {
      $this->parseBody = $data;

      return $this;
   }

   public function getAttributes()
   {
      return $this->attributes;
   }

   public function getAttribute($name, $default = NULL)
   {
      return $this->attributes[$name] ?? $default;
   }

   public function withAttribute($name, $value)
   {
      $this->attributes[$name] = $value;

      return $this;
   }

   public function withoutAttribute($name)
   {
      if (isset($this->attributes[$name])) {
         unset($this->attributes[$anme]);
      }

      return $this;
   }
}