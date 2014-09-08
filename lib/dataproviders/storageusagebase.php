<?php
/**
 * Copyright (c) 2014 - Arno van Rossum <arno@van-rossum.com>
 *
 * Permission is hereby granted, free of charge, to any person obtaining a copy
 * of this software and associated documentation files (the "Software"), to deal
 * in the Software without restriction, including without limitation the rights
 * to use, copy, modify, merge, publish, distribute, sublicense, and/or sell
 * copies of the Software, and to permit persons to whom the Software is
 * furnished to do so, subject to the following conditions:
 *
 * The above copyright notice and this permission notice shall be included in
 * all copies or substantial portions of the Software.
 *
 * THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND, EXPRESS OR
 * IMPLIED, INCLUDING BUT NOT LIMITED TO THE WARRANTIES OF MERCHANTABILITY,
 * FITNESS FOR A PARTICULAR PURPOSE AND NONINFRINGEMENT. IN NO EVENT SHALL THE
 * AUTHORS OR COPYRIGHT HOLDERS BE LIABLE FOR ANY CLAIM, DAMAGES OR OTHER
 * LIABILITY, WHETHER IN AN ACTION OF CONTRACT, TORT OR OTHERWISE, ARISING FROM,
 * OUT OF OR IN CONNECTION WITH THE SOFTWARE OR THE USE OR OTHER DEALINGS IN
 * THE SOFTWARE.
 */

namespace OCA\ocUsageCharts\DataProviders;

use OC\AppFramework\DependencyInjection\DIContainer;
use OCA\ocUsageCharts\Entity\ChartConfig;
use OCA\ocUsageCharts\Entity\StorageUsage;
use OCA\ocUsageCharts\Entity\StorageUsageRepository;

abstract class StorageUsageBase implements DataProviderInterface
{
    /**
     * @var ChartConfig
     */
    protected $chartConfig;

    /**
     * @var StorageUsageRepository
     */
    protected $repository;

    /**
     * @param DIContainer $container
     * @param ChartConfig $chartConfig
     */
    public function __construct(DIContainer $container, ChartConfig $chartConfig)
    {
        $this->chartConfig = $chartConfig;
        $this->repository = $container->query('StorageUsageRepository');
    }

    /**
     * Return a CURRENT storage usage for a user
     *
     * @return StorageUsage
     */
    public function getChartUsageForUpdate()
    {
        $userName = $this->chartConfig->getUsername();
        $created = new \DateTime();
        $created->setTime(0,0,0);
        $results = $this->repository->findAfterCreated($userName, $created);

        // The cron has already ran today, therefor ignoring a current update, only update once a day.
        if ( count($results) == 0 )
        {
            return new StorageUsage(new \Datetime(), $this->getStorageUsageFromCacheByUserName($userName), $userName);
        }
    }

    /**
     * Retrieve storage usage from cache by username
     *
     * This method exists, because after vigorous trying, owncloud does not supply a proper way
     * to check somebody's used size
     * @param string $userName
     * @return integer
     */
    protected function getStorageUsageFromCacheByUserName($userName)
    {
        $data = new \OC\Files\Storage\Home(array('user' => \OC_User::getManager()->get($userName)));
        return $data->getCache('files')->calculateFolderSize('files');
    }

    /**
     * Check if user is admin
     * small wrapper for owncloud methodology
     * @return boolean
     */
    protected function isAdminUser()
    {
        return \OC_User::isAdminUser(\OC_User::getUser());
    }

    /**
     * @param StorageUsage $usage
     * @return boolean
     */
    public function save($usage)
    {
        return $this->repository->save($usage);
    }
}