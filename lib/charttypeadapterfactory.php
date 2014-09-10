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

namespace OCA\ocUsageCharts;

use OCA\ocUsageCharts\Adapters\c3js\StorageUsageCurrentAdapter;
use OCA\ocUsageCharts\Adapters\c3js\StorageUsageLastMonthAdapter;
use OCA\ocUsageCharts\Adapters\c3js\StorageUsagePerMonthAdapter;
use OCA\ocUsageCharts\Adapters\ChartTypeAdapterInterface;
use OCA\ocUsageCharts\Entity\ChartConfig;
use OCA\ocUsageCharts\Exception\ChartTypeAdapterException;

/**
 * @author Arno van Rossum <arno@van-rossum.com>
 */
class ChartTypeAdapterFactory
{
    /**
     * @TODO, This could be nicer, i should figure out how....
     *
     * @param ChartConfig $config
     * @return ChartTypeAdapterInterface
     * @throws Exception\ChartTypeAdapterException
     */
    public function getChartTypeAdapterByConfig(ChartConfig $config)
    {
        $method = 'get' . $config->getChartType() . 'Adapter';

        if ( !method_exists($this, $method) )
        {
            throw new ChartTypeAdapterException("DataProvider for " . $config->getChartType() . ' does not exist.');
        }

        return $this->$method($config->getChartProvider(), $config);
    }

    /**
     * @param string $provider
     * @param ChartConfig $config
     * @return StorageUsageCurrentAdapter
     */
    public function getStorageUsageCurrentAdapter($provider, ChartConfig $config)
    {
        switch($provider)
        {
            case 'c3js':
            default:
                $adapter = new StorageUsageCurrentAdapter($config);
        }
        return $adapter;
    }

    /**
     * @param string $provider
     * @param ChartConfig $config
     * @return StorageUsageLastMonthAdapter
     */
    public function getStorageUsageLastMonthAdapter($provider, ChartConfig $config)
    {
        switch($provider)
        {
            case 'c3js':
            default:
                $adapter = new StorageUsageLastMonthAdapter($config);
        }
        return $adapter;
    }

    /**
     * @param string $provider
     * @param ChartConfig $config
     * @return StorageUsagePerMonthAdapter
     */
    public function getStorageUsagePerMonthAdapter($provider, ChartConfig $config)
    {
        switch($provider)
        {
            case 'c3js':
            default:
                $adapter = new StorageUsagePerMonthAdapter($config);
        }
        return $adapter;
    }
}