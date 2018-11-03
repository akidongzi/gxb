<?php

namespace App\Console\Commands;

use App\Models\Region;
use Illuminate\Console\Command;

class LoadRegionXml extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'region:load-xml {xml : LocList.xml文件路径}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = '从QQ安装目录2052中的LocList.xml解析国家地区数据到数据库';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    protected function saveRegionData($data, $pid = 0, $rootId = 0)
    {
        $region = null;
        if (! empty($data['name'])) {
            $region = new Region();
            $region->name = trim(str_replace([' ', '　', "\t"], '', $data['name']));
            $region->code = $data['code'];
            $region->type = $data['type'];
            $region->root_id = $rootId;
            $region->pid = $pid;
            $region->save();

            if ($pid == 0) {
                $rootId = $region->id;
            }

            $this->info('region数据保存成功：' . $region->name . '...');
        }

        if (! empty($data['children'])) {
            foreach ($data['children'] as $item) {
                $this->saveRegionData($item, $region ? $region->id : 0, $rootId);
            }
        }
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $xml = simplexml_load_file($this->argument('xml'));
        $data = [];

        $dics = ['北京', '上海', '天津', '重庆'];
        $levels = [null, 'country', 'state', 'city', 'region'];

        foreach ($xml->CountryRegion as $country) {
            $level = 1;
            $attrs = $country->attributes();
            $countryData = null;

            $countryData = [
                'name' => (string) $attrs->Name,
                'code' => (string) $attrs->Code,
                'type' => $level,
                'children' => [],
            ];

            $level ++;
            foreach ($country->State as $state) {
                $stateAttrs = $state->attributes();

                $stateData = null;
                if ($stateAttrs->count() > 0) {

                    $sName = (string) $stateAttrs->Name;
                    $stateData = [
                        'name' => $sName,
                        'code' => (string) $stateAttrs->Code,
                        'type' => $level,
                        'children' => [],
                    ];
                }

                $level ++;
                foreach ($state->City as $city) {
                    $cityAttrs = $city->attributes();

                    $cityData = null;
                    if ($cityAttrs->count() > 0) {
                        $cityData = [
                            'name' => (string) $cityAttrs->Name,
                            'code' => (string) $cityAttrs->Code,
                            'type' => $level,
                            'children' => [],
                        ];
                    }

                    $level ++;
                    foreach ($city->Region as $region) {
                        $regionAttrs = $region->attributes();
                        $regionData = [
                            'name' => (string) $regionAttrs->Name,
                            'code' => (string) $regionAttrs->Code,
                            'type' => $level,
                        ];

                        if (! empty($cityData)) {
                            $cityData['children'][] = $regionData;
                        } else {
                            if (! empty($stateData)){
                                $stateData['children'][] = $regionData;
                            } else {
                                $countryData['children'] = $regionData;
                            }
                        }
                    }
                    $level --;

                    if (! empty($stateData)) {
                        $stateData['children'][] = $cityData;
                    } else {
                        $countryData['children'][] = $cityData;
                    }
                }
                $level --;

                $countryData['children'][] = $stateData;
            }

            $data['children'][] = $countryData;
        }

        $this->saveRegionData($data);
    }
}
