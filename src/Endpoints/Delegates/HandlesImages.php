<?php

namespace OpenSoutheners\Docker\Endpoints\Delegates;

use OpenSoutheners\Docker\Endpoints\Images;

/**
 * @mixin \OpenSoutheners\Docker\Client
 */
trait HandlesImages
{
    protected Images $images;

    public function getImages()
    {
        return $this->images->list();
    }

    public function buildImage()
    {
        return $this->images->build();
    }

    public function pruneImageBuildCache()
    {
        return $this->images->pruneBuildCache();
    }

    public function createImage()
    {
        return $this->images->create();
    }

    public function getImage(string $name)
    {
        return $this->images->inspect($name);
    }

    public function getImageLayers($name)
    {
        return $this->images->history($name);
    }

    public function pushImage(string $name)
    {
        return $this->images->push($name);
    }

    public function tagImage(string $name)
    {
        return $this->images->tag($name);
    }

    public function removeImage(string $name)
    {
        return $this->images->remove($name);
    }

    public function searchImages()
    {
        return $this->images->search();
    }

    public function pruneUnusedImages()
    {
        return $this->images->prune();
    }

    public function createImageFromContainer()
    {
        return $this->images->commit();
    }

    public function exportImage(string $name)
    {
        return $this->images->export($name);
    }

    public function exportImages()
    {
        return $this->images->exportMany();
    }

    public function importImages()
    {
        return $this->images->import();
    }
}
