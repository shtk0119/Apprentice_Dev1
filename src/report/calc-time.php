<?php
namespace report;

function getDailyTotaltime($dailyReports)
{
    $totalTime = 0;
    foreach ($dailyReports as $key => $dailyReport) {
        $totalTime += strtotime($dailyReport["time"]);
    }
    $result = date('H:i:s', $totalTime);
    return $result;
}
