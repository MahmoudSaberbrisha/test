<?php

namespace App\Repositories\FinancialManagement;
use App\RepositoryInterface\ExpenseRepositoryInterface;
use App\Models\Expense;
use App\Traits\ImageTrait;

class DBExpensesRepository implements ExpenseRepositoryInterface
{
    use ImageTrait;

    public function getAll()
    {
        return Expense::with([
                'expenses_type' => function ($query) {
                    $query->withTranslation();
                },
                'currency' => function ($query) {
                    $query->withTranslation();
                },
                'branch' => function ($query) {
                    $query->withTranslation();
                },
            ])
            ->get();
    }

    public function create(array $data)
    {
        if (isset($request['image'])) 
            $data['image'] = $this->verifyAndUpload($data, 'image', 'expenses');
        return Expense::create($data);
    }

    public function findById($id, $locale = null)
    {
        return Expense::with([
                'expenses_type' => function ($query) {
                    $query->withTranslation();
                },
                'currency' => function ($query) {
                    $query->withTranslation();
                },
                'branch' => function ($query) {
                    $query->withTranslation();
                },
            ])->findOrFail($id);
    }

    public function update(int $id, array $data)
    {
        $expense = $this->findById($id);
        if(isset($data['image'])) {
            if ($expense->getRawOriginal('image') != null)
                $this->deleteFile('expenses/'.$expense->getRawOriginal('image'));
            $data['image'] = $this->verifyAndUpload($data, 'image', 'expenses');
        }
        return $expense->update($data);
    }

    public function delete(int $id)
    {
        $data = $this->findById($id);
        return $data->delete();
    }

}
