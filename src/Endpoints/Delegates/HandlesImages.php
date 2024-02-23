<?php

namespace OpenSoutheners\Docker\Endpoints\Delegates;

use OpenSoutheners\Docker\Endpoints\Images;

/**
 * @mixin \OpenSoutheners\Docker\Client
 */
trait HandlesImages
{
    protected Images $images;

    public function getImages(): mixed
    {
        return $this->images->list();
    }

    public function buildImage(): mixed
    {
        return $this->images->build();
    }

    public function pruneImageBuildCache(): mixed
    {
        return $this->images->pruneBuildCache();
    }

    public function createImage(): mixed
    {
        return $this->images->create();
    }

    public function getImage(string $name): mixed
    {
        return $this->images->inspect($name);
    }

    public function getImageLayers(string $name): mixed
    {
        return $this->images->history($name);
    }

    public function pushImage(string $name): mixed
    {
        return $this->images->push($name);
    }

    public function tagImage(string $name): mixed
    {
        return $this->images->tag($name);
    }

    public function removeImage(string $name): mixed
    {
        return $this->images->remove($name);
    }

    public function searchImages(): mixed
    {
        return $this->images->search();
    }

    public function pruneUnusedImages(): mixed
    {
        return $this->images->prune();
    }

    public function createImageFromContainer(): mixed
    {
        return $this->images->commit();
    }

    public function exportImage(string $name): mixed
    {
        return $this->images->export($name);
    }

    public function exportImages(): mixed
    {
        return $this->images->exportMany();
    }

    public function importImages(): mixed
    {
        return $this->images->import();
    }
}
