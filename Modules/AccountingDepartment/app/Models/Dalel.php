<?php
namespace Modules\AccountingDepartment\Models;



use Illuminate\Database\Eloquent\Model;

class Dalel extends Model
{
    protected $table = 'dalel';

    public function buildTree($where)
    {
        return $this->where($where)->orderBy('code', 'ASC')->get();
    }

    public function checkValidate($where)
    {
        return $this->where($where)->first();
    }

    public function lastSubCode($where)
    {
        return $this->where($where)->max('code') ?? 0;
    }

    public function deleteTreeNodes($id)
    {
        $accounts = $this->buildTree(['parent' => $id]);
        if ($accounts->isNotEmpty()) {
            foreach ($accounts as $row) {
                $this->deleteTreeNodes($row->id);
                $this->deleteAccount($row->id);
            }
        }
        $this->deleteAccount($id);
    }

    public function deleteAccount($id)
    {
        return $this->where('id', $id)->delete();
    }

    public function getAccount($id)
    {
        $query = $this->select('dalel.*', 'branch.id AS branch', 'parent.name as parent_name')
            ->leftJoin('dalel as branch', 'branch.parent', '=', 'dalel.id')
            ->leftJoin('dalel as parent', 'parent.id', '=', 'dalel.parent')
            ->where('dalel.id', $id)
            ->first();
        $query->marakez = $this->get_marakez($query->code);
        return $query;
    }

    public function insert()
    {
        $data = request()->only(['name', 'ttype', 'parent_code', 'code', 'parent', 'level', 'hesab_no3', 'hesab_tabe3a', 'hesab_report']);

        if ($data['hesab_no3'] == 1) {
            $data['markz_tklfa'] = 2;
        } elseif ($data['hesab_no3'] == 2) {
            $data['markz_tklfa'] = request('markz_tklfa');
            if ($data['markz_tklfa'] == 1) {
                $maraz_taklefa = request('markz_tklfa_fk');
                foreach ($maraz_taklefa as $item) {
                    $this->add_hesab_markz_tklfa($item);
                }
            }
        }

        return $this->create($data);
    }

    public function update(array $attributes = [], array $options = [])
    {
        $data = request()->only(['name', 'ttype', 'parent_code', 'code', 'parent', 'level', 'hesab_no3', 'hesab_tabe3a', 'hesab_report']);
        return $this->where('id', $this->id)->update($data);

    }

    public function getBanks()
    {
        return $this->select('bank_id', 'code_account_id', 'bank.title AS bank_title')
            ->leftJoin('banks_settings as bank', 'bank.id', '=', 'finance_sheek_setting.bank_id')
            ->get();
    }

    public function tree()
    {
        // Implementation for building the tree structure
    }

    public function build_child($parent)
    {
        // Implementation for building child accounts recursively
    }

    public function tree_dates($date_from, $date_to)
    {
        // Implementation for retrieving accounts based on date range
    }

    public function select_markez_subs()
    {
        // Implementation for selecting financial centers
    }

    public function select_markez()
    {
        // Implementation for selecting financial centers
    }

    public function get_marakez($code)
    {
        // Implementation for retrieving related financial centers
    }

    public function delete_hesab_markz_tklfa($code)
    {
        // Implementation for deleting financial center records
    }

    public function add_hesab_markz_tklfa($maraz_taklefa)
    {
        // Implementation for adding financial center records
    }

    public function getUserName($user_id)
    {
        // Implementation for retrieving user names based on roles
    }

    public function max_level_tree()
    {
        return $this->max('level');
    }

    public function search_buildTree($where)
    {
        // Implementation for searching and building the tree
    }
}

/* End of file Dalel.php */
/* Location: ./app/Models/Dalel.php */