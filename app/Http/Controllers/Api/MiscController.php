<?php
/**
 * Created by PhpStorm.
 * User: lindowx
 * Date: 2018/10/30
 * Time: 14:10
 */
namespace App\Http\Controllers\Api;

use App\Exceptions\ApiException as AE;
use App\Http\Controllers\Controller;
use App\Models\Region;
use Illuminate\Http\Request;

class MiscController extends Controller
{
    /**
     * @param Request $request
     */
    public function countryCityCascade(Request $request)
    {
        $resp = [
            'status'    => 1,
            'data'      => null,
        ];

        try {
            if (! empty($request->get('country_id'))) {
                $country = Region::find($request->get('country_id'));
                if (empty($country)) {
                    throw AE::e(AE::ERR_BAD_REQUEST, '错误的国家id');
                }

                $resp['data']['countries'][] = [
                    'id'        => $country->id,
                    'display'   => $country->name,
                ];

                $cities = Region::where('root_id', $country->id)
                    ->where('type', 3)
                    ->get();

                foreach ($cities as $city) {
                    $resp['data']['cities'][] = [
                        'id'        => $city->id,
                        'display'   => $city->name,
                    ];
                }

            } else {
                $allCountries = Region::where('type', 1)
                    ->get();

                foreach ($allCountries as $country) {
                    $resp['data']['countries'][] = [
                        'id'        => $country->id,
                        'display'   => $country->name,
                    ];
                }
                unset($allCountries);
            }

        } catch (\Exception $e) {
            $resp['status'] = 0;
            $resp['errno'] = $e->getCode();

            if (env('API_DEBUG') == true) {
                $resp['debug'] = $e->getMessage();
            }
        }

        return $resp;
    }
}