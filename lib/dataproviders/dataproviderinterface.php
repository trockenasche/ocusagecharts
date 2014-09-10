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

/**
 * @author Arno van Rossum <arno@van-rossum.com>
 */
interface DataProviderInterface
{
    /**
     * @param DIContainer $container
     * @param ChartConfig $chartConfig
     *
     * @return void
     */
    public function __construct(DIContainer $container, ChartConfig $chartConfig);

    /**
     * Return a CURRENT usage for a USER,
     * this is used to update the data with
     *
     * @return mixed
     */
    public function getChartUsageForUpdate();

    /**
     * Return the chart data you want to return based on the ChartConfig
     *
     * @return mixed
     */
    public function getChartUsage();

    /**
     * This method should store the data given from getChartUsageForUpdate
     *
     * @param $usage
     * @return boolean
     */
    public function save($usage);
}
