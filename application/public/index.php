<?php

/*
 |-----------------------------------------------------------------------------
 | Register the auto loader
 |-----------------------------------------------------------------------------
 */
require __DIR__ . '/../app/Core/AutoLoading/autoLoading.php';

/*
 |-----------------------------------------------------------------------------
 | Register helpers
 |-----------------------------------------------------------------------------
 */
require __DIR__ . '/../app/Core/Helpers/helpers.php';

use Action\Core\Cache\CacheItem;
use Action\Core\Cache\CacheItemPool;

$pool = new CacheItemPool();
