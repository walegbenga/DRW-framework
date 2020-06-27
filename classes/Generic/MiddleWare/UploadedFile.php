<?php
declare(strict_types=1);
/**
* Created by : Gbenga Ogunbule
* Location : Ijebu Ode
* Date : 16/05/20
* Time : 07:34
*/

namespace Generic\MiddleWare;

use Exception;
use RuntimeException;
use InvalidArgumentException;
use Psr\Http\Message\UploadedFileInterface;

class UploadedFile implements UploadedFileInterface
{
   protected $field; // original name of file upload field
   protected $info; // $_FILES[$field]
   protected $stream;
   protected $randomize;
   protected $movedName = '';

   public function __construct($field, array $info, $randomize = FALSE)
   {
      $this->info = $info;
      $this->field = $field;
      $this->randomize = $randomize;
   }

   public function getStream()
   {
      if (!$this->stream) {
         if ($this->movedName) {
            $this->stream = new Stream($this->movedName);
         }
         else {
            $this->stream = new Stream($info['tmp_name']);
         }
      }

      return $this->stream;
   }

   public function moveTo($targetPath)
   {
      if (@$this->moved) {
         throw new Exception(Constants::ERROR_MOVE_DONE);
      }
      if (!file_exists($targetPath)) {
         throw new InvalidArgumentException(Constants::ERROR_BAD_DIR);
      }

      $tempFile = $this->info['tmp_name'] ?? FALSE;
      if (!$tempFile || !file_exists($tempFile)) {
         throw new Exception(Constants::ERROR_BAD_FILE);
      }
      if (!is_uploaded_file($tempFile)) {
         throw new Exception(Constants::ERROR_FILE_NOT);
      }

      if ($this->randomize) {
         $final = bin2hex(random_bytes(8)) . '.txt';
      }
      else {
         $final = $this->info['name'];
      }
      $final = $targetPath . '/' . $final;
      $final = str_replace('//', '/', $final);

      if (!\move_uploaded_file($tempFile, $final)) {
         throw new RuntimeException(Constants::ERROR_MOVE_UNABLE);
      }

      $this->movedName = $final;

      return TRUE;
   }

   public function getMovedName()
   {
      return $this->movedName ?? NULL;
   }

   public function getSize()
   {
      return $this->info['size'] ?? NULL;
   }

   public function getError()
   {
      if (!$this->moved) {
         return UPLOAD_ERR_OK;
      }

      return $this->info['error'];
   }

   public function getClientFilename()
   {
      return $this->info['name'] ?? NULL; 
   }

   public function getClientMediaType()
   {
      return $this->info['type'] ?? NULL; 
   }
}