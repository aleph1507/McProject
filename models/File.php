<?php
class File
{
    private $name;
    private $type;
    private $path;
    private $size;

    /**
     * File constructor.
     * @param $name
     * @param $type
     * @param $path
     * @param $size
     */
    public function __construct(string $name = null, string $type = null, string $path = null, string $size = null)
    {
        $this->name = $name;
        $this->type = $type;
        $this->path = $path;
        $this->size = (int)$size;
    }


    /**
     * @return mixed
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * @param mixed $name
     */
    public function setName($name)
    {
        $this->name = $name;
    }

    /**
     * @return mixed
     */
    public function getType()
    {
        return $this->type;
    }

    /**
     * @param mixed $type
     */
    public function setType($type)
    {
        $this->type = $type;
    }

    /**
     * @return mixed
     */
    public function getPath()
    {
        return $this->path;
    }

    /**
     * @param mixed $path
     */
    public function setPath($path)
    {
        $this->path = $path;
    }

    /**
     * @return mixed
     */
    public function getSize()
    {
        return $this->size;
    }

    /**
     * @param mixed $size
     */
    public function setSize($size)
    {
        $this->size = $size;
    }

}