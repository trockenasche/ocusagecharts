<?php
$userSelected = 'gb'; // @TODO this should go from the appconfigservice
$selected = ' selected="selected"';

echo '
<div class="section" id="ocusagecharts-personal">
	<h2>';
	p($l->t('DefaultChartSize'));
    echo '</h2>
<div><div id="ocusagecharts-msg"></div>
';
foreach($_['charts'] as $chart)
{
    $config = $chart->getConfig();

    $userSelected = 'gb';
    $metaData = json_decode($config->getMetaData());
    if ( empty($metaData) )
    {
        // No metadata, no choice in gb or kb
        break;
    }
    $userSelected = $metaData->size;
    p($l->t($config->getChartType()));


    echo '
    <select name="ocusagecharts-charts-' . $config->getId() . '">
        <option name="kb"' . ($userSelected == 'kb' ? $selected: '' ) . ' value="kb">' . $l->t('Kilobytes') . '</option>
        <option name="mb"' . ($userSelected == 'mb' ? $selected: '' ) . ' value="mb">' . $l->t('Megabytes') . '</option>
        <option name="gb"' . ($userSelected == 'gb' ? $selected: '' ) . ' value="gb">' . $l->t('Gigabytes') . '</option>
        <option name="tb"' . ($userSelected == 'tb' ? $selected: '' ) . ' value="tb">' . $l->t('Terabytes') . '</option>
    </select><br />';
}

echo '
</div>
</div>
';
