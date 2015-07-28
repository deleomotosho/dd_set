<?php


namespace DirectDigital\Services;


use DirectDigital\Ad;
use DirectDigital\Lead;
use DirectDigital\Order;
use DB;

class BaseAnalyzer
{

    /**
     * @var Order
     */
    protected $order;

    /**
     * @var Ad
     */
    protected $ad;

    /**
     * @var Lead
     */
    protected $lead;


    /**
     * @param Order $order
     * @param Lead $lead
     * @param Ad $ad
     */
    public function __construct(Order $order, Lead $lead, Ad $ad)
    {
        $this->ad = $ad;
        $this->lead = $lead;
        $this->order = $order;
    }


    /**
     * Imports CSV
     *
     * @param $path
     * @param $table
     * @param $columns
     *
     * @return bool
     */
    public function importFile($path, $table, array $columns)
    {
        $columns = '`' . implode("`,`", $columns) . '`';

        $query = sprintf("LOAD DATA INFILE '%s' INTO TABLE %s FIELDS TERMINATED BY ','
        OPTIONALLY ENCLOSED BY '\"' ESCAPED BY '\"' LINES TERMINATED BY '\\n' IGNORE 0 LINES (%s)", addslashes($path), $table, $columns);

        if (!\DB::connection()->getpdo()->exec($query)) {

            return false;
        };

        return true;
    }

    public function resetAll()
    {
        $tables = ['ads', 'orders', 'leads'];

        foreach ($tables as $name) {
            if ($name == 'migrations') {
                continue;
            }

            \DB::table($name)->delete();

        }
    }

   public function getAnalysis()
   {
       $query = <<<Q
    SELECT
	@id := a.id `id`,
	SUM(DISTINCT a.views) `totalViews`,
	COUNT(l.adId),
	ROUND(
		SUM(DISTINCT a.views) / COUNT(l.adId),
		2
	) `ctr`,
	COUNT(DISTINCT o.leadId) / SUM(DISTINCT a.views) AS `cvRate`,
	SUM(
		o.unitPrice * o.quantity + o.shippingCost
	) `totalRevenue`,
	FLOOR(
		DATEDIFF(
			NOW(),
			FROM_UNIXTIME(
				AVG(
					UNIX_TIMESTAMP(l.birthDate)
				)
			)
		) / 365
	) `averageAge`,
	(
		SELECT
			l.state
		FROM
			orders o
		INNER JOIN leads l ON l.id = o.leadId
		WHERE
			l.adId = @id
		GROUP BY
			l.state
		ORDER BY
			COUNT(l.state) DESC
		LIMIT 1
	) `bestState`,
	(
		SELECT
			l.state
		FROM
			orders o
		INNER JOIN leads l ON l.id = o.leadId
		WHERE
			l.adId = @id
		GROUP BY
			l.state
		ORDER BY
			COUNT(l.state) ASC
		LIMIT 1
	) `worstState`
FROM
	ads a
INNER JOIN leads l ON l.adId = a.id
LEFT JOIN orders o ON o.leadId = l.id --
GROUP BY
	a.id
ORDER BY
	`ctr` DESC
Q;
       return  \DB::select(DB::raw($query));

   }
}


