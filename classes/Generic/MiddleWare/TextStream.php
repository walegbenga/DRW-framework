<?php
declare(strict_types=1);
/**
* Created by : Gbenga Ogunbule
* Location : Ijebu Ode
* Date : 16/05/20
* Time : 07:23
*/

namespace Generic\MiddleWare;

use Throwable;
use RuntimeException;
use SplFileInfo;
use Psr\Http\Message\StreamInterface;

class TextStream implements StreamInterface
{
   protected $stream;
   protected $pos = 0;

   public function __construct(string $input)
   {
      $this->stream = $input;
   }

   public function getStream()
   {
      return $this->stream;
   }

   public function getInfo()
   {
      return NULL;
   }

   public function getContents()
   {
      return $this->stream;
   }

   public function __toString()
   {
      return $this->getContents();
   }

   public function close()
   {
      // do nothing
   }

   public function detach()
   {
      return $this->close();
   }

   public function getSize()
   {
      return strlen($this->stream);
   }

   public function tell()
   {
      return $this->pos;
   }

   public function eof()
   {
      return ($this->pos == strlen($this->stream));
   }

   public function isSeekable()
   {
      return TRUE;
   }

   public function seek($offset, $whence = NULL)
   {
      if ($offset < $this->getSize()) {
         $this->pos = $offset;
      }
      else {
         throw new RuntimeException(Constants::ERROR_BAD . __METHOD__);
      }
   }

   public function rewind()
   {
      $this->pos = 0;
   }

   public function isWritable()
   {
      return TRUE;
   }

   public function write($string)
   {
      $temp = substr($this->stream, 0, $this->pos);
      $this->stream = $temp . $string;
      $this->pos = strlen($this->stream);
   }

   public function isReadable()
   {
      return TRUE;
   }

   public function read($length)
   {
      return \substr($this->stream, $this->pos, $length);
   }

   public function getMetadata($key = NULL)
   {
      return NULL;
   }
}
