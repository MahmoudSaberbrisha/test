<?php

namespace App\Livewire\FinancialManagement;

use Livewire\Component;
use App\Models\Account;

class TrialBalance extends Component
{
    public $search = '';
    public $sortField = 'name';
    public $sortDirection = 'asc';

    public function sortBy($field)
    {
        if ($this->sortField === $field) {
            $this->sortDirection = $this->sortDirection === 'asc' ? 'desc' : 'asc';
        } else {
            $this->sortField = $field;
            $this->sortDirection = 'asc';
        }
    }

    public function render()
    {
        $locale = app()->getLocale();

        $accounts = Account::query()
            ->whereHas('translations', function ($query) use ($locale) {
                $query->where('locale', $locale)
                      ->where('name', 'like', '%' . $this->search . '%');
            })
            ->with(['translations' => function ($query) use ($locale) {
                $query->where('locale', $locale);
            }, 'entries'])
            ->get()
            ->map(function ($account) {
                $totalDebit = $account->entries->sum('debit');
                $totalCredit = $account->entries->sum('credit');
                $account->balance = $totalDebit - $totalCredit;
                return $account;
            })
            ->sortBy(function ($account) {
                return strtolower($account->translate(app()->getLocale())->{$this->sortField});
            }, SORT_REGULAR, $this->sortDirection === 'desc');

        return view('livewire.financial-management.trial-balance', [
            'accounts' => $accounts,
        ]);
    }
}