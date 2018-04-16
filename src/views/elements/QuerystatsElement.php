<?php
/**
 * SeekQuarry/Yioop --
 * Open Source Pure PHP Search Engine, Crawler, and Indexer
 *
 * Copyright (C) 2009 - 2017  Chris Pollett chris@pollett.org
 *
 * LICENSE:
 *
 * This program is free software: you can redistribute it and/or modify
 * it under the terms of the GNU General Public License as published by
 * the Free Software Foundation, either version 3 of the License, or
 * (at your option) any later version.
 *
 * This program is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 * GNU General Public License for more details.
 *
 * You should have received a copy of the GNU General Public License
 * along with this program.  If not, see <http://www.gnu.org/licenses/>.
 *
 * END LICENSE
 *
 * @author Chris Pollett chris@pollett.org
 * @license http://www.gnu.org/licenses/ GPL3
 * @link http://www.seekquarry.com/
 * @copyright 2009 - 2017
 * @filesource
 */
namespace seekquarry\yioop\views\elements;

use seekquarry\yioop as B;
use seekquarry\yioop\configs as C;
use seekquarry\yioop\library\CrawlConstants;

/**
 * Element responsible for displaying statistics about recent queries that
 * have been run against the search engine
 *
 * @author Chris Pollett
 */
class QuerystatsElement extends Element
{
    /**
     * Draws statistics about what queries have been recently run against the
     * search engine
     *
     * @param array $data keys are generally the different setting that can
     *     be set in the crawl.ini file
     */
    public function render($data)
    {
        $admin_url = htmlentities(B\controllerUrl('admin', true));
        ?>
        <div class="current-activity">
        <div class="<?= $data['leftorright'] ?>">
        <a href="<?=$admin_url ?>a=manageCrawls&amp;<?=
            C\CSRF_TOKEN."=".$data[C\CSRF_TOKEN] ?>"  ><?=
            tl('querystats_element_back_to_manage') ?></a>
        </div>
        <h2><?=tl('querystats_element_query_statistics') ?></h2>
        <form>
        <div>
        <b><label for='query-filter'><?=
        tl('querystats_element_filter')?></label></b>
        <input type="text" class="narrow-field" name='filter'
            id='query-filter' value="<?=$data['FILTER']?>" />
        <input type="hidden" name='<?=C\CSRF_TOKEN?>'
            value='<?=$data[C\CSRF_TOKEN]?>' />
        <input type="hidden" name='a' value='query' />
        <input type="hidden" name='c' value='statistics' />
        <button type='submit' name='filter_go'
            class="button-box"><?=tl('querystats_element_go') ?></button>
        </div></form>
        <?php
        $time_periods = [
           C\ONE_HOUR => tl('querystats_element_last_hour'),
           C\ONE_DAY => tl('querystats_element_last_day'),
           C\ONE_MONTH => tl('querystats_element_last_month'),
           C\ONE_YEAR => tl('querystats_element_last_year'),
           C\FOREVER => tl('querystats_element_all_time'),
        ];
        foreach ($time_periods as  $time_period => $period_heading) {
            if (!empty($data['STATISTICS'][
                $time_period])) {
                ?><h4><?=$period_heading ?>:</h4><?php
                foreach ($data['STATISTICS'][
                    $time_period] as $item_name => $item_data) {
                    e("<p>".urldecode($item_name).": ".
                        $item_data[0]['NUM_VIEWS']. "</p>");
                }
            } else {
                e("<p><b>$period_heading</b>: ".
                    tl('querystats_element_no_activity').
                    "</p>");
            }
        }
        ?>
        </div>
    <?php
    }
}