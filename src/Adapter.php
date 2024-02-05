<?php
namespace Xiaohuilam\Flysystem\MultipleDisks;

use League\Flysystem\FilesystemAdapter;
use League\Flysystem\Config;
use League\Flysystem\FileAttributes;
use Throwable;

class Adapter implements FilesystemAdapter
{
    protected $disks;
    protected $config;

    public function __construct($disks, $config)
    {
        $this->disks = $disks;
        $this->config = $config;
    }

    public function fileExists(string $path): bool
    {
        $res = $this->__call(__FUNCTION__, func_get_args());
        return $res[0];
    }

    public function directoryExists(string $path): bool
    {
        $res = $this->__call(__FUNCTION__, func_get_args());
        return $res[0];
    }

    public function write(string $path, string $contents, Config $config): void
    {
        $this->__call(__FUNCTION__, func_get_args());
    }

    public function writeStream(string $path, $resource, Config $config): void
    {
        $this->__call(__FUNCTION__, [$path, $resource, $config->toArray()]);
    }

    public function read(string $path): string
    {
        $res =  $this->__call(__FUNCTION__, func_get_args());
        return $res[0];
    }

    public function readStream(string $path)
    {
        $res = $this->__call(__FUNCTION__, func_get_args());
        return $res[0];
    }

    public function delete(string $path): void
    {
        $this->__call(__FUNCTION__, func_get_args());
    }

    public function deleteDirectory(string $path): void
    {
        $this->__call(__FUNCTION__, func_get_args());
    }

    public function createDirectory(string $path, Config $config): void
    {
        $this->__call(__FUNCTION__, func_get_args());
    }

    public function setVisibility(string $path, string $visibility): void
    {
        $this->__call(__FUNCTION__, func_get_args());
    }

    public function visibility(string $path): FileAttributes
    {
        $res = $this->__call(__FUNCTION__, func_get_args());
        return $res[0];
    }

    public function mimeType(string $path): FileAttributes
    {
        $res = $this->__call(__FUNCTION__, func_get_args());
        return $res[0];
    }

    public function lastModified(string $path): FileAttributes
    {
        $res = $this->__call(__FUNCTION__, func_get_args());
        return $res[0];
    }

    public function fileSize(string $path): FileAttributes
    {
        $res = $this->__call(__FUNCTION__, func_get_args());
        return $res[0];
    }

    public function listContents(string $directory = '', bool $deep = false): iterable
    {
        $res = $this->__call(__FUNCTION__, func_get_args());
        return $res[0];
    }

    public function move(string $source, string $destination, Config $config): void
    {
        $this->__call(__FUNCTION__, func_get_args());
    }

    public function copy(string $source, string $destination, Config $config): void
    {
        $this->__call(__FUNCTION__, func_get_args());
    }

    public function getUrl(string $path): string
    {
        foreach ($this->disks as $disk) {
            if (method_exists($disk, __FUNCTION__)) {
                return $disk->{__FUNCTION__}($path);
            }
        }
        return $path;
    }

    public function __call($name, $arguments)
    {
        $res = [];
        $errors = [];
        $errorDisks = [];
        foreach ($this->disks as $disk) {
            try {
                $res[] = call_user_func_array([$disk, $name], $arguments);
            } catch (Throwable $e) {
                throw $e;
                $errors[] = $e;
                $errorDisks[] = $disk;
            }
        }

        if (!count($errors)) {
            return $res;
        } else {
            throw new MultipleDisksException($errors, $errorDisks);
        }
    }
}
