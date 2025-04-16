<?php

namespace Modules\AdminRoleAuthModule\Repositories;

use Modules\AdminRoleAuthModule\RepositoryInterface\CurrencyRepositoryInterface;
use Modules\AdminRoleAuthModule\Models\Currency;

class DBCurrenciesRepository implements CurrencyRepositoryInterface
{
    public function getAll()
    {
        return Currency::withTranslation()
            ->get();
    }

    public function create(array $request)
    {
        $locale = getDefaultLanguageCode();
        if ($request['default'] == 1) 
            Currency::where('default', 1)->update(['default' => 0]);
        $data = [
            'default' => (int) $request['default'],
            'code'    => $request['code'],
            'symbol'  => $request['symbol'],
            'color'   => $request['color'],
            $locale => [
                'name' => $request['name']
            ]
        ];
        return Currency::create($data);
    }

    public function findById($id, $locale = null)
    {
        return Currency::withTranslation($locale)->findOrFail($id);
    }

    public function update(int $id, array $request)
    {
        $data = $this->findById($id, $request['locale']);
        if ($request['default'] == 1) 
            Currency::where('id', '!=', $id)->update(['default' => 0]);
        $data->translateOrNew($request['locale'])->name = $request['name'];
        $data->code    = $request['code'];
        $data->symbol  = $request['symbol'];
        $data->color   = $request['color'];
        $data->default = (int) $request['default'];
        return $data->save();
    }

    public function delete(int $id)
    {
        $data = $this->findById($id);
        if ($data->default)
            return false;
        return $data->delete();
    }

    public function active(int $id, string $value)
    {
        $data = $this->findById($id);
        if (!$data)
            return response()->json( array('type' => 'error', 'text' => __('Something went wrong during the process.')) );
        if ($data->default)
            return response()->json( array('type' => 'error', 'text' => __('You cannot deactivate the default currency.')) );
        $data->active = ($value == 'true') ? 1 : 0;
        $data->save();
        if ($value == 'true') 
            return response()->json( array('type' => 'success', 'text' => __('Record activated successfully.')) );
        return response()->json( array('type' => 'success', 'text' => __('Record deactivated successfully.')) );
    }

    public function getActiveRecords()
    {
        return Currency::withTranslation()
            ->where('active', 1)
            ->get();
    }

    public function getDefaultCurrency()
    {
        return Currency::withTranslation()
            ->where('default', 1)
            ->first();
    }

}
