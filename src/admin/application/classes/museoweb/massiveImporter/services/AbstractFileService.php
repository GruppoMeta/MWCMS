<?php
abstract class museoweb_massiveImporter_services_AbstractFileService implements museoweb_massiveImporter_services_interfaces_FileServiceInterface, Iterator
{
    protected $data;
    protected $pos;

    public function &current()
    {
        return $this->data;
    }

    public function key()
    {
        return $this->pos;
    }

    public function next()
    {
        $this->fetch();
    }

    public function rewind()
    {
        $this->pos = 0;
        $this->fetch();
    }

    public function valid()
    {
        return $this->data != null;
    }

    abstract protected function fetch();
}