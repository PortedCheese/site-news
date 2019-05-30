<?php

namespace PortedCheese\SiteNews\Filters;

use Intervention\Image\Facades\Image;
use Intervention\Image\Filters\FilterInterface;
use Intervention\Image\Image as File;

class NewsShowMain implements FilterInterface {

    public function applyFilter(File $image)
    {
        return $image
            ->widen(350);
    }
}