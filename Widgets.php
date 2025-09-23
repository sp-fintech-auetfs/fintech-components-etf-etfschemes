<?php

namespace Apps\Fintech\Components\Etf\Schemes;

use Apps\Fintech\Packages\Etf\Schemes\EtfSchemes;
use Carbon\Carbon;
use System\Base\Providers\ModulesServiceProvider\Modules\Components\ComponentsWidgets;

class Widgets extends ComponentsWidgets
{
    public function watchlist($widget, $dashboardWidget)
    {
        $schemePackage = new EtfSchemes;

        $watchlists = $schemePackage->getWatchlistByAccountId();

        $watchlistsSchemes = [];

        if ($watchlists && count($watchlists['schemes']) > 0) {
            $schemePackage->switchModel();

            foreach ($watchlists['schemes'] as $schemeId) {
                $schemeArr = $schemePackage->getSchemeById((int) $schemeId, false, false, false, false);

                if ($schemeArr) {
                    $watchlistsSchemes['schemes'][$schemeArr['id']] = [];
                    $watchlistsSchemes['schemes'][$schemeArr['id']]['symbol'] = $schemeArr['symbol'];
                    $watchlistsSchemes['schemes'][$schemeArr['id']]['name'] = $schemeArr['name'];
                    $watchlistsSchemes['schemes'][$schemeArr['id']]['latest_nav'] = round($schemeArr['latest_nav'], 2);
                    $watchlistsSchemes['schemes'][$schemeArr['id']]['day_cagr'] = $schemeArr['day_cagr'];
                }
            }
        }

        $widget['data']['settings']['watchlist'] = $watchlistsSchemes;

        return $this->getWidgetContent($widget, $dashboardWidget);
    }
}